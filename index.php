<?php 
# 加载用户缓存文件和用户权限缓存文件
include_once($_SERVER['DOCUMENT_ROOT'].'\get_user_priv\user.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'\get_user_priv\user_priv.inc.php');

# 由于需要登录后才有 SESSION 值，此处由于是测试用的代码，就模拟登录后的效果，即先给 SESSION['id'] = 1。
session_start();
if(!isset($_SESSION['id']))
{
	$_SESSION['id'] = 1;
}
	
/**
 * @purpose	:	获取用户权限字符串
 * @time	:	2017/12/15
 * @author	:	kangaroo
 * @param	:	int		$user_id	用户登录名
 *				string	$user_name	用户真实姓名
 *				int 	$user_priv	用户权限id
 *				int		$extension	分机号
 * @return		string	$priv_str	以','分割的权限字符串
*/
function getUserPriv($id="",$user_name="",$user_priv="",$extension="")
{
	# 获取用户和用户缓存
	global $cache_user;
	global $cache_priv;
	
	# 如果没有传入任何参数，获取当前用户的 id
	if(empty($id) && empty($user_name) && empty($user_priv) && empty($extension)){
		# 获取当前用户
		$user = getLocalUser();
		$id = $user['id'];
	}

	# 获取用户权限，如果存在缓存文件，则从缓存文件中读取，否则从数据库中读取。
	$priv_str = ''; // 用户权限
	if(empty($cache_user) && !empty($cache_priv)){
		$priv_id = '';	// 权限id
		foreach($cache_user as $val){
			if(!empty($id) && $val['id'] == $id){
				$priv_id = $val['user_priv'];
			}elseif(!empty($user_name) && $val['user_name'] == $user_name){
				$priv_id = $val['user_priv'];
			}elseif(!empty($user_priv) && $val['user_priv'] == $user_priv){
				$priv_id = $val['user_priv'];
			}elseif(!empty($extension) && $val['extension'] == $extension){
				$priv_id = $val['user_priv'];
			}
		}
		
		if(!empty($priv_id)){
			$priv_str = $cache_priv[$priv_id]['priv_str'];
		}
		
	}else{
		$dsn = 'mysql:host=localhost;dbname=learn_db';
		$db_user = 'root';
		$db_pwd = '';
		$pdo = new PDO($dsn,$db_user,$db_pwd);
		
		if( !empty( $id ) ){//如果为空则默认为当前用户
			$sql = "SELECT priv_str FROM org_user_priv up,org_user u WHERE u.user_priv = up.priv_id  and  u.id='".$id."'";
		}
		elseif( !empty( $user_name ) ){
			$sql = "SELECT priv_str FROM org_user_priv up,org_user u WHERE u.user_priv = up.priv_id  and  u.user_name='".$user_name."'";
		}
		elseif( !empty( $user_priv ) ){
			$sql = "SELECT priv_str FROM org_user_priv WHERE priv_id='".$user_priv."'";
		}
		elseif( !empty( $extension ) ){
			$sql = "SELECT priv_str FROM org_user_priv up,org_user u WHERE u.user_priv = up.priv_id  and  u.extension='".$extension."'";
		}
		$re = $pdo->query( $sql );
		foreach($re as $row){
			$priv_str = $row['priv_str'];
		}
		
	}
	return $priv_str;
}

/**
 * @purpose	:	获取当前用户
 * @time	:	2017/12/15
 * @author	:	kangaroo
 * @param	:	(无)
 * @return	:	$val/$user 用户信息	
*/
function getLocalUser()
{	
	global $cache_user;
	$dsn = 'mysql:host=localhost;dbname=learn_db';
	$db_user = 'root';
	$db_pwd = '';
	$pdo = new PDO($dsn,$db_user,$db_pwd);
		
	# 当前用户登录的id
	$id = $_SESSION['id'];
	
	# 有缓存使用缓存，没有缓存从数据库中获取
	if(isset($cache_user)){
		foreach($cache_user as $val){
			if($val['id'] == $id){
				return $val;
			}else{
				continue;
			}
		}
		
	}else{
		$sql = "SELECT u.*, d.dept_name, p.priv_name FROM org_user u LEFT JOIN org_department d ON u.dept_id=d.dept_id LEFT JOIN org_user_priv p ON u.user_priv=p.priv_id WHERE u.id=$id";
		$re = $pdo->query($sql);
		foreach($re as $row){
			$user = $row;
		}
		return $user;
	}
}

function index(){
	$user_priv = getUserPriv();
	echo $user_priv;
}

index();