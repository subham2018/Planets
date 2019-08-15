<?php
include_once("../config/config.php");	// connecting to the database
include_once("../function/function.php");	// function
if(isset($_POST['id'])){
	check_all_var();
	$q = row('about_us',$_POST['id']);
	$details[] = array(
		'title' => htmlspecialchars_decode($q->title),
		'content' => htmlspecialchars_decode($q->content),
		'status' => $q->status
		);
	echo json_encode($details);	
}
?>