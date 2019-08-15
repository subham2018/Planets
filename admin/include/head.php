<?php


// display errors
ini_set('display_errors',1);
ini_set('display_startup_errors',1);


ob_start();
@session_start();


include_once(__DIR__ ."/../config/config.php");	// connecting to the database
include_once(__DIR__ ."/../function/function.php");	// function

$site =site_info();
$now = date('Y-m-d H:i:s');
$siteurl=$site->base;

define("UPLOAD_DOC_PATH", "upload/doc/");
define("UPLOAD_IMG_PATH", "upload/original/");
define("UPLOAD_TMB_IMG_PATH", "upload/thumbnail/t_");


if(isset($_SESSION['admin_id'])) {
	
	$user_id = $_SESSION['admin_id'];
	$login_string = $_SESSION['login_string'];
	$user_browser = $_SERVER['HTTP_USER_AGENT'];
	
	$user =row('admin',$user_id);
	$login_check = hash('sha512', $user->password . $user_browser);
	
	if ($login_check == $login_string) {
		$userid = $user->id;
		if(basename($_SERVER['PHP_SELF'])=="login.php") header("location: index.php");
	}
	else header("location: logout.php");
}
else if((basename($_SERVER['PHP_SELF'])!="login.php") && (basename($_SERVER['PHP_SELF'])!="forgot.php") && (basename($_SERVER['PHP_SELF'])!="reset.php")) header("location: login.php");

?>