<?php

// site details


function site_info() {
	
	global $prefix,$link;
	
	$select = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `".$prefix."setting` WHERE id='1'"));
	return $select;
}
// site details
function home_info() {
	
	global $prefix,$link;
	
	$select = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `".$prefix."home_setting` WHERE id='1'"));
	return $select;
}


function row($table,$id) {
	
	global $prefix,$link;
	
	$select = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `".$prefix.$table."` WHERE id='".$id."'"));
	return $select;
}
function rowCondition($table,$field,$value) {
	
	global $prefix,$link;
	
	$select = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `".$prefix.$table."` WHERE `".$field."`='".$value."'"));
	return $select;
}


function variable_check($data)
{
	global $prefix,$link;

  $data = is_array($data)?array_map("trim", $data):trim($data);
  $data = is_array($data)?array_map("stripslashes", $data):stripslashes($data);
  $data = is_array($data)?array_map("htmlspecialchars", $data):htmlspecialchars($data);
  // $data = is_array($data)?array_map("mysqli_real_escape_string", $link, $data):mysqli_real_escape_string($link, $data);
  return $data;
}

function variable_check_low($data)
{
	global $prefix,$link;

  $data = is_array($data)?array_map("stripslashes", $data):stripslashes($data);
  $data = is_array($data)?array_map("htmlspecialchars", $data):htmlspecialchars($data);
  $data = is_array($data)?array_map("mysqli_real_escape_string", $link,$data):mysqli_real_escape_string($link, $data);
  return $data;
}

function check_all_var_low() {
	
	foreach($_POST as $key=>$value)
		{
			$_POST[$key]=variable_check_low($value);
						  
		}
}

function un_set() {
	// unset variables
	foreach($_POST as $key=>$value)
		{
		  unset($_POST[$key]);
			  
		}
}

function check_all_var() {
	
	foreach($_POST as $key=>$value)
		{
			$_POST[$key]=variable_check($value);
						  
		}
}


// delete rows
function del($id,$table) {
	
	global $prefix,$link;
	
	$sql = mysqli_query($link,"DELETE FROM `".$prefix.$table."` WHERE id='".$id."'");
	return $sql;
	
}

// delete rows with condition
function del_condition($value,$table,$field) {
	
	global $prefix,$link;
	
	$sql = mysqli_query($link,"DELETE FROM `".$prefix.$table."` WHERE `".$field."`='".$value."'");
	return $sql;
	
}

function count_rows($table, $field, $value) {
	
	global $prefix,$link;
	
	$select = mysqli_query($link,"SELECT * FROM `".$prefix.$table."` WHERE ".$field."='".$value."'");
	return mysqli_num_rows($select);
	
}

function anything($table,$field,$id) {
	
	global $prefix,$link;
	
	$select = mysqli_query($link,"SELECT * FROM `".$prefix.$table."` WHERE id='".$id."'");
	
	$row = mysqli_fetch_object($select);
	
	return $row->$field;
	
	
}
function setData($table,$field,$data,$wfield,$wdata,$query=''){
	
	global $prefix,$link;
	
	if($query == '' && count_rows($table, $wfield, $wdata)> 0){
		if(mysqli_query($link,"UPDATE `".$prefix.$table."` SET `".$field."`='".$data."' WHERE `".$wfield."`='".$wdata."'"))
			return true;
		else return false;
	}
	else{
		if(mysqli_query($link,"INSERT INTO `".$prefix.$table."` SET ".$query))
			return true;
		else return false;
	}
}

function crop_image_square($source, $destination, $image_type, $square_size, $image_width, $image_height, $quality){
    if($image_width <= 0 || $image_height <= 0){return false;}
    if( $image_width > $image_height )
    {
        $y_offset = 0;
        $x_offset = ($image_width - $image_height) / 2;
        $s_size     = $image_width - ($x_offset * 2);
    }else{
        $x_offset = 0;
        $y_offset = ($image_height - $image_width) / 2;
        $s_size = $image_height - ($y_offset * 2);
    }
    $new_canvas = imagecreatetruecolor( $square_size, $square_size);
	imagealphablending( $new_canvas, false );
	imagesavealpha( $new_canvas, true );
    if(imagecopyresampled($new_canvas, $source, 0, 0, $x_offset, $y_offset, $square_size, $square_size, $s_size, $s_size)){
        if(save_image($new_canvas, $destination, $image_type, $quality)) return true;
		else return false;
    }
}
function resize_image($source, $destination, $image_type, $minSize, $image_width, $image_height, $quality, $height_static, $width_static){
	if($height_static && $width_static) return false;
	else{
		if($minSize==0) {
			$minSize=$image_width;
			$height_static=false;
			$width_static=false;
		}
		$ratioW = $minSize / $image_width; 
		$ratioH = $minSize / $image_height;
		if($height_static) {$ratio = $ratioH;}
		elseif($width_static) {$ratio = $ratioW;}
		elseif($ratioW < $ratioH) {$ratio = $ratioW;}else{$ratio = $ratioH;}
		$newWidth = $image_width*$ratio;
		$newHeight = $image_height*$ratio;
		$dst_img = imagecreatetruecolor($newWidth,$newHeight);
		imagealphablending( $dst_img, false );
		imagesavealpha( $dst_img, true );

		if(imagecopyresampled($dst_img, $source, 0, 0, 0, 0, $newWidth, $newHeight, $image_width, $image_height)){
			if(save_image($dst_img, $destination, $image_type, $quality)) return true;
			else return false;
		}
	}
}
function save_image($source, $destination, $image_type, $quality){
    switch(strtolower($image_type)){
        case 'image/jpeg': case 'image/pjpeg': 
            imagejpeg($source, $destination, $quality); return true;
            break;
		case 'image/png': 
			$q=floor($quality / 10) - 1;
            imagepng($source, $destination, $q); return true;
            break;
		case 'image/gif': 
            imagegif($source, $destination, $quality); return true;
            break;
        default: return false;
    }
}
function getAmount($table, $field_name){
	global $prefix,$link;
	
	$select1 = mysqli_query($link,"SELECT `".$field_name."` FROM `".$prefix.$table."`");
	$i=0;
	while($row1 = mysqli_fetch_object($select1))
	{
	   $i +=$row1->$field_name;
		
	
	}
	
	echo $i;
}
function getProductsales(){
	global $prefix,$link;
	
	$select = mysqli_query($link,"SELECT `qty` FROM `".$prefix."product_order` WHERE `paid`='0'");
	$i=0;
	while ($row = mysqli_fetch_object($select))
	{
	   $i +=$row->qty;
		
	
	}
	
	echo $i;
}

?>

