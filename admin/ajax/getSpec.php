<?php
include_once("../config/config.php");	// connecting to the database
include_once("../function/function.php");	// function
if(isset($_POST['id'])){
	check_all_var();
	$q = row('product_spec',$_POST['id']);
	$details[] = array(
		
		'product_id' => htmlspecialchars_decode($q->product_id),
		'spectitle' => htmlspecialchars_decode($q->spectitle),
		'specvalue' => htmlspecialchars_decode($q->specvalue)
		
		);
	echo json_encode($details);	
}
?>