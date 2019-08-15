<?php
include_once("../config/config.php");	// connecting to the database
include_once("../function/function.php");	// function
if(isset($_POST['id'])){
	check_all_var();
	$q = row('video',$_POST['id']);
	$details[] = array(
		'url'=> $q->url
		
		);
	echo json_encode($details);	
}
?>