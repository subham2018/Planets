<?php 
include 'admin/config/config.php';
include 'admin/function/function.php';	// function
error_reporting(0);
$site =site_info();
$now = date('Y-m-d H:i:s');
$siteurl=$site->base;

define("UPLOAD_DOC_PATH", "admin/upload/doc/");
define("UPLOAD_IMG_PATH", "admin/upload/original/");
define("UPLOAD_TMB_IMG_PATH", "admin/upload/thumbnail/t_");
?>