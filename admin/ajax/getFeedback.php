<?php
include_once("../config/config.php");	// connecting to the database
include_once("../function/function.php");	// function
if(isset($_POST['id'])){
	check_all_var();
	$q = row('testimonial',$_POST['id']);
	$details[] = array(
		'name' => htmlspecialchars_decode($q->name),
		'msg'=> $q->msg,
		'image' => $q->image
		
		);
	echo json_encode($details);	
}
?>