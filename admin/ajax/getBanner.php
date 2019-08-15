<?php
include_once("../config/config.php");	// connecting to the database
include_once("../function/function.php");	// function
if(isset($_POST['id'])){
	check_all_var();
	$q = row('banner',$_POST['id']);
	$details[] = array(
		'title' => htmlspecialchars_decode($q->title),
		
		'side_img' => $q->side_img,
		
		);
	echo json_encode($details);	
}
?>