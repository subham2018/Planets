<?php include_once 'include/head.php';?>
<!doctype html>
<html>
<head>
<?php include_once 'include/header.php';?>
<title><?=$site->site_title?> Admin Panel</title>
<link rel="stylesheet" type="text/css" href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>
<?php include_once 'include/navbar.php';?>  
        <div class="content">
            <div class="overlay"></div><!--for mobile view sidebar closing-->
            <!--title and breadcrumb-->
            <div class="top">
                <p class="page-title"><i class="fa fa-image fa-fw"></i>Background Image Gallery</p>
                <ol class="breadcrumb">
                    <li><a href="index.php">Dashboard</a></li>
                    <li class="">Background Image Gallery</li>
                </ol>
            </div>
            <!--main content start-->
            <div class="main-body">
                <?php                   

                //Project edit
                if(isset($_POST['usubmit'])){
                    check_all_var(); //prevent mysql injection              
                    //check and update Technology
                    if(!empty($_FILES['about_us']['tmp_name']) && is_uploaded_file( $_FILES['about_us']['tmp_name'] )){
                        //conver file name to md5 and prepend timestamp
                        $fbasename=time().'_'.md5($_FILES["about_us"]["name"]).'.'.pathinfo($_FILES["about_us"]["name"],PATHINFO_EXTENSION);
                        $target_file = UPLOAD_IMG_PATH . $fbasename;
                         $target_tmb_file = UPLOAD_TMB_IMG_PATH . $fbasename;

                        $image_temp = $_FILES['about_us']['tmp_name'];
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
                            case 'image/jpeg': case 'image/pjpeg':  $image_res = imagecreatefromjpeg($image_temp); break;
                            default: $image_res = false;
                        }
                        //optimize and save
                        if($image_res != false && resize_image($image_res, $target_file, $image_type, 1336, $image_width, $image_height, 80, false, true)){
                            crop_image_square($image_res, $target_tmb_file, $image_type, 320, $image_width, $image_height,  80);
                           
                            // @unlink(UPLOAD_IMG_PATH . anything('gallery','about_us',$_POST['bid']));
                            // @unlink(UPLOAD_TMB_IMG_PATH . anything('gallery','about_us',$_POST['bid']));


                            mysql_query("UPDATE ".$prefix."bg_image SET `about_us`='$fbasename'");
                        }
                        else {
                            $error='1';
                            unlink($target_file);
                        }
                    }

                    if(!empty($_FILES['products']['tmp_name']) && is_uploaded_file( $_FILES['products']['tmp_name'] )){
                        //conver file name to md5 and prepend timestamp
                        $fbasename=time().'_'.md5($_FILES["products"]["name"]).'.'.pathinfo($_FILES["products"]["name"],PATHINFO_EXTENSION);
                        $target_file = UPLOAD_IMG_PATH . $fbasename;
                         $target_tmb_file = UPLOAD_TMB_IMG_PATH . $fbasename;

                        $image_temp = $_FILES['products']['tmp_name'];
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
                            case 'image/jpeg': case 'image/pjpeg':  $image_res = imagecreatefromjpeg($image_temp); break;
                            default: $image_res = false;
                        }
                        //optimize and save
                        if($image_res != false && resize_image($image_res, $target_file, $image_type, 1336, $image_width, $image_height, 80, false, true)){
                            crop_image_square($image_res, $target_tmb_file, $image_type, 320, $image_width, $image_height,  80);
                           
                            // @unlink(UPLOAD_IMG_PATH . anything('gallery','about_us',$_POST['bid']));
                            // @unlink(UPLOAD_TMB_IMG_PATH . anything('gallery','about_us',$_POST['bid']));


                            mysql_query("UPDATE ".$prefix."bg_image SET `products`='$fbasename'");
                        }
                        else {
                            $error='1';
                            unlink($target_file);
                        }
                    }

                    if(!empty($_FILES['quote']['tmp_name']) && is_uploaded_file( $_FILES['quote']['tmp_name'] )){
                        //conver file name to md5 and prepend timestamp
                        $fbasename=time().'_'.md5($_FILES["quote"]["name"]).'.'.pathinfo($_FILES["quote"]["name"],PATHINFO_EXTENSION);
                        $target_file = UPLOAD_IMG_PATH . $fbasename;
                         $target_tmb_file = UPLOAD_TMB_IMG_PATH . $fbasename;

                        $image_temp = $_FILES['quote']['tmp_name'];
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
                            case 'image/jpeg': case 'image/pjpeg':  $image_res = imagecreatefromjpeg($image_temp); break;
                            default: $image_res = false;
                        }
                        //optimize and save
                        if($image_res != false && resize_image($image_res, $target_file, $image_type, 1336, $image_width, $image_height, 80, false, true)){
                            crop_image_square($image_res, $target_tmb_file, $image_type, 320, $image_width, $image_height,  80);
                           
                            // @unlink(UPLOAD_IMG_PATH . anything('gallery','about_us',$_POST['bid']));
                            // @unlink(UPLOAD_TMB_IMG_PATH . anything('gallery','about_us',$_POST['bid']));


                            mysql_query("UPDATE ".$prefix."bg_image SET `quote`='$fbasename'");
                        }
                        else {
                            $error='1';
                            unlink($target_file);
                        }
                    }

                    if(!empty($_FILES['blog']['tmp_name']) && is_uploaded_file( $_FILES['blog']['tmp_name'] )){
                        //conver file name to md5 and prepend timestamp
                        $fbasename=time().'_'.md5($_FILES["blog"]["name"]).'.'.pathinfo($_FILES["blog"]["name"],PATHINFO_EXTENSION);
                        $target_file = UPLOAD_IMG_PATH . $fbasename;
                         $target_tmb_file = UPLOAD_TMB_IMG_PATH . $fbasename;

                        $image_temp = $_FILES['blog']['tmp_name'];
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
                            case 'image/jpeg': case 'image/pjpeg':  $image_res = imagecreatefromjpeg($image_temp); break;
                            default: $image_res = false;
                        }
                        //optimize and save
                        if($image_res != false && resize_image($image_res, $target_file, $image_type, 1336, $image_width, $image_height, 80, false, true)){
                            crop_image_square($image_res, $target_tmb_file, $image_type, 320, $image_width, $image_height,  80);
                           
                            // @unlink(UPLOAD_IMG_PATH . anything('gallery','about_us',$_POST['bid']));
                            // @unlink(UPLOAD_TMB_IMG_PATH . anything('gallery','about_us',$_POST['bid']));


                            mysql_query("UPDATE ".$prefix."bg_image SET `blog`='$fbasename'");
                        }
                        else {
                            $error='1';
                            unlink($target_file);
                        }
                    }

                    if(!empty($_FILES['contact']['tmp_name']) && is_uploaded_file( $_FILES['contact']['tmp_name'] )){
                        //conver file name to md5 and prepend timestamp
                        $fbasename=time().'_'.md5($_FILES["contact"]["name"]).'.'.pathinfo($_FILES["contact"]["name"],PATHINFO_EXTENSION);
                        $target_file = UPLOAD_IMG_PATH . $fbasename;
                         $target_tmb_file = UPLOAD_TMB_IMG_PATH . $fbasename;

                        $image_temp = $_FILES['contact']['tmp_name'];
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
                            case 'image/jpeg': case 'image/pjpeg':  $image_res = imagecreatefromjpeg($image_temp); break;
                            default: $image_res = false;
                        }
                        //optimize and save
                        if($image_res != false && resize_image($image_res, $target_file, $image_type, 1336, $image_width, $image_height, 80, false, true)){
                            crop_image_square($image_res, $target_tmb_file, $image_type, 320, $image_width, $image_height,  80);
                           
                            // @unlink(UPLOAD_IMG_PATH . anything('gallery','about_us',$_POST['bid']));
                            // @unlink(UPLOAD_TMB_IMG_PATH . anything('gallery','about_us',$_POST['bid']));


                            mysql_query("UPDATE ".$prefix."bg_image SET `contact`='$fbasename'");
                        }
                        else {
                            $error='1';
                            unlink($target_file);
                        }
                    }

                    if(!empty($_FILES['gallery']['tmp_name']) && is_uploaded_file( $_FILES['gallery']['tmp_name'] )){
                        //conver file name to md5 and prepend timestamp
                        $fbasename=time().'_'.md5($_FILES["gallery"]["name"]).'.'.pathinfo($_FILES["gallery"]["name"],PATHINFO_EXTENSION);
                        $target_file = UPLOAD_IMG_PATH . $fbasename;
                         $target_tmb_file = UPLOAD_TMB_IMG_PATH . $fbasename;

                        $image_temp = $_FILES['gallery']['tmp_name'];
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
                            case 'image/jpeg': case 'image/pjpeg':  $image_res = imagecreatefromjpeg($image_temp); break;
                            default: $image_res = false;
                        }
                        //optimize and save
                        if($image_res != false && resize_image($image_res, $target_file, $image_type, 1336, $image_width, $image_height, 80, false, true)){
                            crop_image_square($image_res, $target_tmb_file, $image_type, 320, $image_width, $image_height,  80);
                           
                            // @unlink(UPLOAD_IMG_PATH . anything('gallery','about_us',$_POST['bid']));
                            // @unlink(UPLOAD_TMB_IMG_PATH . anything('gallery','about_us',$_POST['bid']));


                            mysql_query("UPDATE ".$prefix."bg_image SET `gallery`='$fbasename'");
                        }
                        else {
                            $error='1';
                            unlink($target_file);
                        }
                    }


                    
                    // $query='';
                    // foreach($_POST as $key=>$value) if($key != 'usubmit')if($key != "bid")if($key != 'qa')$query .="`$key`='$value',";
                    // $query = substr($query, 0, -1);//omit last comma

                    // if(!isset($error)&& mysql_query("UPDATE ".$prefix."gallery SET ".$query." WHERE id=".$_POST['bid'])){//insert all text info
                    if(!isset($error)){
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i>All TThe Background Gallery Image Updated successfully.</p>';
                    }
                    
                    else { 
                        echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while updating details!</p>';   
                    }
                }             
                ?>

                <!--add new-->
                <div class="panel panel-default" id="" style="">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="fa fa-plus fa-fw"></i>Background Images</div>
                    </div>
                    <div class="panel-body">
                        <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">About<font color="red">*</font></label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" readonly placeholder="Choose JPEG file">
                                       
                                        <span class="input-group-btn"><button data-file-input='about_us' type="button" class="btn btn-primary">Browse</button></span>
                                         <input type="file" name="about_us" onChange="updateName(this)" accept=".jpg,.jpeg" style="height:1px;width:1px;" >
                                    </div>
                                    <small><i class="fa fa-info-circle fa-fw"></i>Try to upload Higher Resolution JPEG image</small>
                                </div>
                                <div class="col-sm-4 text-center">
                                    <p><b>Existing Image:</b></p>
                                    <img id="eximg" src="<?=UPLOAD_TMB_IMG_PATH .anything('bg_image','about_us',1)?>" alt="" width="30%">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Products<font color="red">*</font></label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" readonly placeholder="Choose JPEG file">
                                       
                                        <span class="input-group-btn"><button data-file-input='products' type="button" class="btn btn-primary">Browse</button></span>
                                         <input type="file" name="products" onChange="updateName(this)" accept=".jpg,.jpeg" style="height:1px;width:1px;" >
                                    </div>
                                    <small><i class="fa fa-info-circle fa-fw"></i>Try to upload Higher Resolution JPEG image</small>
                                </div>
                                <div class="col-sm-4 text-center">
                                    <p><b>Existing Image:</b></p>
                                    <img id="eximg" src="<?=UPLOAD_TMB_IMG_PATH .anything('bg_image','products',1)?>" alt="" width="35%">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Get a quote<font color="red">*</font></label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" readonly placeholder="Choose JPEG file">
                                       
                                        <span class="input-group-btn"><button data-file-input='quote' type="button" class="btn btn-primary">Browse</button></span>
                                         <input type="file" name="quote" onChange="updateName(this)" accept=".jpg,.jpeg" style="height:1px;width:1px;" >
                                    </div>
                                    <small><i class="fa fa-info-circle fa-fw"></i>Try to upload Higher Resolution JPEG image</small>
                                </div>
                                <div class="col-sm-4 text-center">
                                    <p><b>Existing Image:</b></p>
                                    <img id="eximg" src="<?=UPLOAD_TMB_IMG_PATH .anything('bg_image','quote',1)?>" alt="" width="35%">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Blog<font color="red">*</font></label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" readonly placeholder="Choose JPEG file">
                                       
                                        <span class="input-group-btn"><button data-file-input='blog' type="button" class="btn btn-primary">Browse</button></span>
                                         <input type="file" name="blog" onChange="updateName(this)" accept=".jpg,.jpeg" style="height:1px;width:1px;" >
                                    </div>
                                    <small><i class="fa fa-info-circle fa-fw"></i>Try to upload Higher Resolution JPEG image</small>
                                </div>
                                <div class="col-sm-4 text-center">
                                    <p><b>Existing Image:</b></p>
                                    <img id="eximg" src="<?=UPLOAD_TMB_IMG_PATH .anything('bg_image','blog',1)?>" alt="" width="35%">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Contact<font color="red">*</font></label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" readonly placeholder="Choose JPEG file">
                                       
                                        <span class="input-group-btn"><button data-file-input='contact' type="button" class="btn btn-primary">Browse</button></span>
                                         <input type="file" name="contact" onChange="updateName(this)" accept=".jpg,.jpeg" style="height:1px;width:1px;" >
                                    </div>
                                    <small><i class="fa fa-info-circle fa-fw"></i>Try to upload Higher Resolution JPEG image</small>
                                </div>
                                <div class="col-sm-4 text-center">
                                    <p><b>Existing Image:</b></p>
                                    <img id="eximg" src="<?=UPLOAD_TMB_IMG_PATH .anything('bg_image','contact',1)?>" alt="" width="35%">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Gallery<font color="red">*</font></label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" readonly placeholder="Choose JPEG file">
                                       
                                        <span class="input-group-btn"><button data-file-input='gallery' type="button" class="btn btn-primary">Browse</button></span>
                                         <input type="file" name="gallery" onChange="updateName(this)" accept=".jpg,.jpeg" style="height:1px;width:1px;" >
                                    </div>
                                    <small><i class="fa fa-info-circle fa-fw"></i>Try to upload Higher Resolution JPEG image</small>
                                </div>
                                <div class="col-sm-4 text-center">
                                    <p><b>Existing Image:</b></p>
                                    <img id="eximg" src="<?=UPLOAD_TMB_IMG_PATH .anything('bg_image','gallery',1)?>" alt="" width="35%">
                                </div>
                            </div>
                            
                            <hr>                            
                            <input type="submit" name="usubmit" class="btn btn-success pull-right" value="Save">
                        </form>
                    </div>
                </div>              
                <div class="form-group">
                    <label class="col-sm-2 control-label">GST No(if any)</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="cont" rows="5" name="dsc<?=$lang?>" placeholder="Enter gst no">
                    </div>
                </div>
                
            </div>
            <!--main content end-->
        </div>
<?php include_once 'include/footer.php';?>
<script src="assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/js/common.js"></script>


</body>
</html>    
