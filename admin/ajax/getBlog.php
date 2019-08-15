<?php
include_once("../config/config.php");	// connecting to the database
include_once("../function/function.php");	// function
if(isset($_POST['id'])){
	check_all_var();
	$q = row('blog',$_POST['id']);
	$details[] = array(
		'title' => htmlspecialchars_decode($q->title),
		'content' => htmlspecialchars_decode($q->content),
		'tag' => htmlspecialchars_decode($q->tag),
		'act' => htmlspecialchars_decode($q->status),
		'ads' => htmlspecialchars_decode($q->shoads),
		'relatepost' => htmlspecialchars_decode($q->post),
		'cat_id'=>$q->cat_id,
		'image'=> $q->image
		
		);
	echo json_encode($details);	
}
?>