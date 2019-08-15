<?php

// database

if($_SERVER['HTTP_HOST'] == "localhost")
{
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "";
	$dbname = "tpa";


}
else
{
	$dbhost = 'localhost'; 
	$dbuser = 'wwwsoini_billing'; 
	$dbpass = '@WE#$RT%'; 
	$dbname = 'wwwsoini_firecheckindiasite';
	
}


$link = @mysqli_connect($dbhost, $dbuser, $dbpass) or die("Could not connect to the host because " . mysqli_error()); 
$db = @mysqli_select_db($link,$dbname) or die("Could not select the database because " . mysqli_error()); 


$page = basename($_SERVER['PHP_SELF']);
$prefix = "soinit_";

date_default_timezone_set('Asia/Kolkata');

?>
