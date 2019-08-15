<?php
include_once("../config/config.php");	// connecting to the database
include_once("../function/function.php");	// function
if(isset($_POST['id'])){
	check_all_var();
	$q = row('pro_query',$_POST['id']);
	$q->pro_id = explode(',',$q->pro_id);
	$p=array();
	foreach ($q->pro_id as $key => $value) {
		array_push($p,anything('product','name',$value));
	}
	$details[] = array(
		'name' => htmlspecialchars_decode($q->name),
		'email' => htmlspecialchars_decode($q->email),
		'phone' => htmlspecialchars_decode($q->phone),
		'qty' => htmlspecialchars_decode($q->qty),
		'date' => date('M d, Y h:i a',strtotime($q->datetime)),
		'pro' => implode(', ', $p),
		'content' => htmlspecialchars_decode($q->content)
		);
	echo json_encode($details);	
}
?>