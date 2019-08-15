<?php
include_once("../config/config.php");	// connecting to the database
include_once("../function/function.php");	// function
if(isset($_POST['id'])){
	check_all_var();
	$q = row('forcast',$_POST['id']);
	$details[] = array(
		'image'=> $q->image,
		'title'=>$q->title,
		'location'=>$q->location,
		'rupees'=>$q->rupees,
		'content' => htmlspecialchars_decode($q->content)
		);
	echo json_encode($details);	
}
?>