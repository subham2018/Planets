<?php
include_once("../config/config.php");	// connecting to the database
include_once("../function/function.php");	// function
if(isset($_POST['id'])){
	check_all_var();
	$q = row('category',$_POST['id']);
	$details[] = array(
		'title' => htmlspecialchars_decode($q->title),
		'dsc'=> $q->dsc,
		'image' => $q->image
		'catid'=> $q->catid,
		
		);
	echo json_encode($details);	
}
?>