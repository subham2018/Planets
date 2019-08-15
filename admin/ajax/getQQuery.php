<?php
include_once("../config/config.php");	// connecting to the database
include_once("../function/function.php");	// function
if(isset($_POST['id'])){
	check_all_var();
	$q = mysql_fetch_assoc(mysql_query("SELECT * FROM `".$prefix."quote_query` WHERE `id`='".$_POST['id']."'"));

	$data='';
	$nocol = array('id','fabric_other','gusset_in','length_in','status');
	foreach ($q as $key => $value) {
		if($key=="fabric" && $value=='Non-Woven')
			$data .= '<div class="col-sm-6"><div class="form-group"><label class="text-uppercase">'.str_replace('_',' ',$key).':</label> <div class="form-control">'.$value.' ('.$q['fabric_other'].')</div></div></div>';
		elseif($key=="height" || $key=="width" || $key=="gusset")
			$data .= '<div class="col-sm-6"><div class="form-group"><label class="text-uppercase">'.str_replace('_',' ',$key).':</label> <div class="form-control">'.$value.$q['gusset_in'].'</div></div></div>';
		elseif($key=="length")
			$data .= '<div class="col-sm-6"><div class="form-group"><label class="text-uppercase">'.str_replace('_',' ',$key).':</label> <div class="form-control">'.$value.$q['length_in'].'</div></div></div>';
		elseif($key=="datetime")
			$data .= '<div class="col-sm-6"><div class="form-group"><label class="text-uppercase">'.str_replace('_',' ',$key).':</label> <div class="form-control">'.date('M d, Y h:i a',strtotime($value)).'</div></div></div>';
		elseif(!in_array($key, $nocol)) $data .= '<div class="col-sm-6"><div class="form-group"><label class="text-uppercase">'.str_replace('_',' ',$key).':</label> <div class="form-control">'.$value.'</div></div></div>';
	}
	
	echo $data;	
}
?>