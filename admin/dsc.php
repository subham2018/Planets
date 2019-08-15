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
                <p class="page-title"><i class="fa fa-info-circle fa-fw"></i> Announcement Page</p>
                <ol class="breadcrumb">
                    <li><a href="index.php">Dashboard</a></li>
                    <li>Announcement Page</li>
                    <li class="active">Announcement Page</li>
                </ol>
            </div>
            <!--main content start-->
            <div class="main-body">
                 <?php
                
                 //Vission edit
                if(isset($_POST['submit'])){
                    check_all_var(); //prevent mysql injection  
                    if(!empty($_FILES['image']['tmp_name']) && is_uploaded_file( $_FILES['image']['tmp_name'] )){
                        //conver file name to md5 and prepend timestamp
                        $fbasename=time().'_'.md5($_FILES["image"]["name"]).'.'.pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
                        $target_file = UPLOAD_IMG_PATH . $fbasename;
                        $image_temp = $_FILES['image']['tmp_name'];
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
                            case 'image/png':  $image_res = imagecreatefrompng($image_temp); break;
                            case 'image/jpeg': case 'image/pjpeg':  $image_res = imagecreatefromjpeg($image_temp); break;
                            default: $image_res = false;
                        }
                        //optimize and save
                        if($image_res != false && resize_image($image_res, $target_file, $image_type, 700, $image_width, $image_height,  $_POST['qa'],true,false)){
                            //unlink(UPLOAD_IMG_PATH . anything('vission','image',1));
                            mysqli_query($link,"UPDATE ".$prefix."dsc SET `image`='$fbasename' ");
                        }
                        else {
                            $error='1';
                            unlink($target_file);
                        }
                    }    
                    
                    $query='';
                    foreach($_POST as $key=>$value) if($key != 'submit')if($key != "id")if($key != 'qa')$query .="`$key`='$value',";
                    $query = substr($query, 0, -1);//omit last comma

                    if( mysqli_query($link,"UPDATE ".$prefix."dsc SET ".$query)) //insert all text info
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Announcement Page Updated successfully.</p>';
                    else { 
                        echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error!</p>';   
                    }
                }
                $vission=row('dsc',"1");
                
                ?>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="fa fa-pencil fa-fw"></i> Edit About Main Page </div>
                    </div>
                    <div class="panel-body">
                    <div class="row">
                         
                        <div class="col-sm-12">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10">
                <TEXTAREA type="text" class="form-control" name="description" id="description"  placeholder="Enter short description " required><?=htmlspecialchars_decode($vission->description)?></TEXTAREA>
                                </div>
                            </div>
                            <hr>
                            <input type="submit" name="submit" class="btn btn-success pull-right" value="Update">
                        </form>
                        </div>
                    </div>
                    </div>
                </div>


            </div>

        </div>
<?php include_once 'include/footer.php';?>
<script src="assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/js/common.js"></script>
<script src="assets/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
CKEDITOR.replace( 'description');

</script>
</body>
</html> 
