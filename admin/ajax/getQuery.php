<?php
include_once("../config/config.php");	// connecting to the database
include_once("../function/function.php");	// function
if(isset($_POST['id'])){
	check_all_var();
	$q = row('contact',$_POST['id']);
	$details[] = array(
		'name' => htmlspecialchars_decode($q->name),
		'email' => htmlspecialchars_decode($q->email),
		'phone' => htmlspecialchars_decode($q->phone),
		'content' => htmlspecialchars_decode($q->content)
		);
	echo json_encode($details);	
}
?>