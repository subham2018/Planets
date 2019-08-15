<?php
include_once("../config/config.php");	// connecting to the database
include_once("../function/function.php");	// function
if(isset($_POST['id'])){
	check_all_var();
	$q = row('product',$_POST['id']);
	$details[] = array(
		'title' => $q->title,
		'image'=> $q->image,
		'dsc'=> $q->dsc,
        'catid'=> $q->catid,
		'dsc'=> htmlspecialchars_decode($q->dsc),
		'specification'=> htmlspecialchars_decode($q->specification),
		'status'=> $q->status
		);
	echo json_encode($details);	
}
?>