<?php include_once 'include/head.php';?>
<!doctype html>
<html>
<head>
<?php include_once 'include/header.php';?>
<title><?=$site->site_title?> Admin Panel</title>
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>
<?php include_once 'include/navbar.php';?>	
        <div class="content">
        	<div class="overlay"></div><!--for mobile view sidebar closing-->
        	<!--title and breadcrumb-->
            <div class="top">
            	<p class="page-title"><i class="fa fa-cogs fa-fw"></i> Site Settings</p>
                <ol class="breadcrumb">
                    <li><a href="index.php">Dashboard</a></li>
                    <li class="active">Site Settings</li>
                </ol>
            </div>
            <!--main content start-->
            <div class="main-body">
            
            
            	<?php
				if(isset($_POST['submit'])){
					check_all_var(); //prevent mysql injection
					//generate query from post
					$query='';
					foreach($_POST as $key=>$value) if($key != 'submit')$query .="`$key`='$value',";
					$query = substr($query, 0, -1);//omit last comma
					
					if(mysqli_query($link,"UPDATE ".$prefix."setting SET ".$query." WHERE id=1")){ //insert all text info
						//check and insert favicon
						if(!empty($_FILES['favicon']['tmp_name']) && is_uploaded_file( $_FILES['favicon']['tmp_name'] )){
							//conver file name to md5 and prepend timestamp
							$fbasename=time().'_'.md5($_FILES["favicon"]["name"]).'.'.pathinfo($_FILES["favicon"]["name"],PATHINFO_EXTENSION);
							$target_file = UPLOAD_IMG_PATH . $fbasename;
							$image_temp = $_FILES['favicon']['tmp_name'];
							$image_size_info    = getimagesize($image_temp);
							if($image_size_info){
								$image_width        = $image_size_info[0];
								$image_height       = $image_size_info[1];
								$image_type         = $image_size_info['mime'];
							}else{
							   exit;
							}
							//check if image is in png format or not
							switch($image_type){
								case 'image/png': $image_res = imagecreatefrompng($image_temp); break;
								default: $image_res = false;
							}
							//corp and resize to 20x20 and save
							if($image_res != false && crop_image_square($image_res, $target_file, $image_type, 20, $image_width, $image_height, 50)) {
								@unlink(UPLOAD_IMG_PATH . $site->favicon);
								mysqli_query($link,"UPDATE ".$prefix."setting SET `favicon`='$fbasename' WHERE id=1");
								$error=0;
							}
							else $error=1;
							
						}
						//check and insert logo
						if(!empty($_FILES['logo']['tmp_name']) && is_uploaded_file( $_FILES['logo']['tmp_name'] )){
							
							//conver file name to md5 and prepend timestamp
							$fbasename=time().'_'.md5($_FILES["logo"]["name"]).'.'.pathinfo($_FILES["logo"]["name"],PATHINFO_EXTENSION);
							$target_file = UPLOAD_IMG_PATH . $fbasename;
							$image_temp = $_FILES['logo']['tmp_name'];
							$image_size_info    = getimagesize($image_temp);
							if($image_size_info){
								$image_width        = $image_size_info[0];
								$image_height       = $image_size_info[1];
								$image_type         = $image_size_info['mime']; 
							}else{
							   exit;
							}
							//check if image is in png format or not
							switch($image_type){
								case 'image/png': $image_res = imagecreatefrompng($image_temp);break;
								default: $image_res = false;
							}
							//resize to max height 60px and save
							if($image_res != false && resize_image($image_res, $target_file, $image_type, 300, $image_width, $image_height, 80, true, false)){
								@unlink(UPLOAD_IMG_PATH . $site->logo);
								mysqli_query($link,"UPDATE ".$prefix."setting SET `logo`='$fbasename' WHERE id=1");
								$error=isset($error) && $error == 1? 1:0;
							}
							else $error=1;	
						}
						//check and insert footer logo
                        if(!empty($_FILES['flogo']['tmp_name']) && is_uploaded_file( $_FILES['flogo']['tmp_name'] )){
                            //conver file name to md5 and prepend timestamp
                            $fbasename=time().'_'.md5($_FILES["flogo"]["name"]).'.'.pathinfo($_FILES["flogo"]["name"],PATHINFO_EXTENSION);
                            $target_file = UPLOAD_IMG_PATH . $fbasename;
                            $image_temp = $_FILES['flogo']['tmp_name'];
                            $image_size_info    = getimagesize($image_temp);
                            if($image_size_info){
                                $image_width        = $image_size_info[0];
                                $image_height       = $image_size_info[1];
                                $image_type         = $image_size_info['mime'];
                            }else{
                               exit;
                            }
                            //check if image is in png format or not
                            switch($image_type){
                                case 'image/jpeg': case 'image/pjpeg': $image_res = imagecreatefromjpeg($image_temp); break;
                                default: $image_res = false;
                            }
                            //resize to max height 60px and save
                            if($image_res != false && resize_image($image_res, $target_file, $image_type, 1366, $image_width, $image_height, 80, false, true)){
                                @unlink(UPLOAD_IMG_PATH . $site->flogo);
                                mysqli_query($link,"UPDATE ".$prefix."setting SET `flogo`='$fbasename' WHERE id=1");
                                $error=isset($error) && $error == 1? 1:0;
                            }
                            else $error=1;  
                        }

						//check if error occure in any step
						if(isset($error) && $error == 0)
							echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Image and Details updated successfully.</p>';
						elseif(isset($error) && $error == 1)
							echo '<p class="alert alert-warning<i class="fa fa-check fa-fw"></i> Details updated successfully. But there is an error while uploading image!</p>';
						else echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Details updated successfully.</p>';
					}
					else echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! Something went wrong.'.mysqli_error().'</p>';
					$site = site_info();
				}
				?>
            	<div class="panel panel-default">
                	<div class="panel-heading">
                    	<div class="panel-title"><i class="fa fa-pencil fa-fw"></i> Edit Site Settings</div>
                    </div>
                    <div class="panel-body">
                    	<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        	<p class="label-hr">Basic Details</p>
                        	<div class="form-group">
                            	<label class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-10">
	                                <input type="text" class="form-control" name="site_title" value="<?=$site->site_title?>" placeholder="Enter site title">
                                </div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-2 control-label">Meta-Description</label>
                                <div class="col-sm-10">
	                                <input type="text" class="form-control" name="meta_description" value="<?=$site->meta_description?>" placeholder="Enter site meta-description">
                                </div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-2 control-label">Meta-Keywords</label>
                                <div class="col-sm-10">
	                                <input type="text" class="form-control" name="meta_keyword" value="<?=$site->meta_keyword?>" placeholder="Enter site meta-keywords (Separate by comma ',')">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Site Owner</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="site_owner_name" value="<?=$site->site_owner_name?>" placeholder="Enter site owner name">
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Footer Info Text</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="footer" value="<?=$site->footer?>" placeholder="Enter Footer Info Text">
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Embedded Map</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="map" value="<?=$site->map?>" placeholder="Enter Footer Info Text">
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Embedded Map</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="map1" value="<?=$site->map?>" placeholder="Enter Footer Info Text">
                                </div>
                            </div>                          
                            <p class="label-hr">Contact Details</p>
                            <div class="form-group">
                            	<label class="col-sm-2 control-label">Site Owner Email</label>
                                <div class="col-sm-10">
	                                <input type="email" class="form-control" name="site_owner_email" value="<?=$site->site_owner_email?>" placeholder="Enter site owner email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Phone Number</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="contact" value="<?=$site->contact?>" placeholder="Enter phone number">
                                </div>
                            </div>  
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Fax Number</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="fax" value="<?=$site->fax?>" placeholder="Enter fax number">
                                </div>
                            </div>                            
                            <div class="form-group">
                            	<label class="col-sm-2 control-label">Reg. Address</label>
                                <div class="col-sm-10">
	                                <input type="text" class="form-control" name="reg_address" value="<?=$site->reg_address?>" placeholder="Enter registered address">
                                </div>
                            </div>
                           <!-- <div class="form-group">
                            	<label class="col-sm-2 control-label">Map Embed Source</label>
                                <div class="col-sm-10">
	                                <input type="text" class="form-control" name="map" value="<?=$site->map?>" placeholder="Enter source from google map embed iframe code">
                                </div>
                            </div> -->
                            <p class="label-hr">Social Details</p>
                            <div class="form-group">
                            	<label class="col-sm-2 control-label">Facebook Link</label>
                                <div class="col-sm-10">
	                                <input type="text" class="form-control" name="facebook" value="<?=$site->facebook?>" placeholder="Enter facebook page link">
                                </div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-2 control-label">Twitter Link</label>
                                <div class="col-sm-10">
	                                <input type="text" class="form-control" name="twitter" value="<?=$site->twitter?>" placeholder="Enter twitter page link">
                                </div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-2 control-label">Google Plus Link</label>
                                <div class="col-sm-10">
	                                <input type="text" class="form-control" name="gplus" value="<?=$site->gplus?>" placeholder="Enter google plus page link">
                                </div>
                            </div>
                            <!-- <div class="form-group">
                            	<label class="col-sm-2 control-label">LinkdIn Link</label>
                                <div class="col-sm-10">
	                                <input type="text" class="form-control" name="linkedin" value="<?=$site->linkedin?>" placeholder="Enter linkedin page link">
                                </div>
                            </div> -->
                            <div class="form-group">
                            	<label class="col-sm-2 control-label">Instagram Link</label>
                                <div class="col-sm-10">
	                                <input type="text" class="form-control" name="instagram" value="<?=$site->instagram?>" placeholder="Enter instagram page link">
                                </div>
                            </div>
                            <p class="label-hr">Logo and Favicon</p>
                            <div class="form-group">
                            	<label class="col-sm-2 control-label">Favicon</label>
                                <div class="col-sm-10">
                                	<div class="input-group">
                                    	<span class="input-group-addon"><img src="<?=UPLOAD_IMG_PATH . $site->favicon?>" height="18px"></span>
	                                	<input type="text" class="form-control" readonly placeholder="Choose PNG file">
                                        <input type="file" name="favicon" onChange="updateName(this)" accept="image/x-png" class="hidden">
                                        <span class="input-group-btn"><button data-file-input='favicon' type="button" class="btn btn-primary">Browse</button></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-2 control-label">Logo</label>
                                <div class="col-sm-10">
                                	<div class="input-group">
                                    	<span class="input-group-addon"><img src="<?=UPLOAD_IMG_PATH . $site->logo?>" height="18px"></span>
	                                	<input type="text" class="form-control" readonly placeholder="Choose PNG file">
                                        <input type="file" name="logo" onChange="updateName(this)" accept="image/x-png" class="hidden">
                                        <span class="input-group-btn"><button data-file-input='logo' type="button" class="btn btn-primary">Browse</button></span>
                                    </div>
                                </div>
                            </div>
                           <!-- <div class="form-group">
                            	<label class="col-sm-2 control-label">Inner Page Top Image</label>
                                <div class="col-sm-10">
                                	<div class="input-group">
                                    	<span class="input-group-addon"><img src="<?=UPLOAD_IMG_PATH . $site->flogo?>" height="18px"></span>
	                                	<input type="text" class="form-control" readonly placeholder="Choose JPEG file">
                                        <input type="file" name="flogo" onChange="updateName(this)" accept=".jpeg,.jpg" class="hidden">
                                        <span class="input-group-btn"><button data-file-input='flogo' type="button" class="btn btn-primary">Browse</button></span>

                                    </div>
                                    <small><i class="fa fa-info-circle fa-fw"></i> Image width must be 1366px or higher.</small>
                                </div>
                            </div> -->
                             
                            <hr>
                            <input type="submit" name="submit" class="btn btn-success pull-right" value="Update">
                        </form>
                    </div>
                    
                </div>
                
                
                
            </div>
            <!--main content end-->
        </div>
<?php include_once 'include/footer.php';?>
<script src="assets/plugins/ckeditor/ckeditor.js"></script>
<script src="assets/js/common.js"></script>
<script type="text/javascript">
CKEDITOR.replace( 'cont' );
</script>
</body>
</html>