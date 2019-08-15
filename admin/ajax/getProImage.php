<?php

include_once("../config/config.php");	// connecting to the database

include_once("../function/function.php");	// function

if(isset($_POST['id'])){

	check_all_var();

	$q = row('product_img',$_POST['id']);

	$details[] = array(

		'img' => htmlspecialchars_decode($q->image)
		);

	echo json_encode($details);	

}

?>