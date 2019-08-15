<?php
include_once("../config/config.php");	// connecting to the database
include_once("../function/function.php");	// function
if(isset($_POST['id'])){
	check_all_var();
	$q = row('clients',$_POST['id']);
	$details[] = array(
		'name'=>$q->name
		
		);
	echo json_encode($details);	
}
?>