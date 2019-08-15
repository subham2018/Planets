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
                <p class="page-title"><i class="fa fa-image fa-fw"></i> Photo Gallery Images</p>
                <ol class="breadcrumb">
                    <li><a href="index.php">Dashboard</a></li>
                    <li class="active"> Photo Gallery Images</li>
                </ol>
            </div>
            <!--main content start-->
            <div class="main-body">
                <?php
                    if(isset($_POST['submit'])){
                    check_all_var(); //prevent mysql injection              
                    //check and insert banner
                    if(!empty($_FILES['image']['tmp_name']) && is_uploaded_file( $_FILES['image']['tmp_name'] )){
                        //convert file name to md5 and prepend timestamp
                        $fbasename=time().'_'.md5($_FILES["image"]["name"]).'.'.pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
                        $target_file = UPLOAD_IMG_PATH . $fbasename;
                        $target_tmb_file = UPLOAD_TMB_IMG_PATH . $fbasename;


                        $image_temp = $_FILES['image']['tmp_name'];
                        $image_size_info    = getimagesize($image_temp);
                        if($image_size_info){
                            $image_width        = $image_size_info[0];
                            $image_height       = $image_size_info[1];
                            $image_type         = $image_size_info['mime'];
                        }else{
                           exit;
                        }
                        //check if image is in jpg format or not
                        switch($image_type){
                            case 'image/jpeg': case 'image/pjpeg':  $image_res = imagecreatefromjpeg($image_temp); break;
                            //case 'image/png':  $image_res = imagecreatefrompng($image_temp); break;
                            default: $image_res = false;
                        }
                        //optimize and save
                        if($image_res != false && resize_image($image_res, $target_file, $image_type, 1336, $image_width, $image_height,  $_POST['qa'], false, true)){
                            crop_image_square($image_res, $target_tmb_file, $image_type, 320, $image_width, $image_height,  $_POST['qa']);
                                                       
                         $query='';
                        foreach($_POST as $key=>$value) if($key != 'submit')if($key != 'qa')$query .="`$key`='$value',";
                        $query .= "`image`='$fbasename'"; 
                            
                        mysqli_query($link,"INSERT INTO ".$prefix."gallery SET ".$query);
                            echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Gallery Image Added  successfully.</p>';
                        }
                        else {
                            unlink($target_file);
                            echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while uploading image!</p>'; 
                        }
                    }
                }

                //Project edit
                if(isset($_POST['usubmit'])){
                    check_all_var(); //prevent mysql injection              
                    //check and update Technology
                    if(!empty($_FILES['image']['tmp_name']) && is_uploaded_file( $_FILES['image']['tmp_name'] )){
                        //conver file name to md5 and prepend timestamp
                        $fbasename=time().'_'.md5($_FILES["image"]["name"]).'.'.pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
                        $target_file = UPLOAD_IMG_PATH . $fbasename;
                         $target_tmb_file = UPLOAD_TMB_IMG_PATH . $fbasename;

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
                            case 'image/jpeg': case 'image/pjpeg':  $image_res = imagecreatefromjpeg($image_temp); break;
                            default: $image_res = false;
                        }
                        //optimize and save
                        if($image_res != false && resize_image($image_res, $target_file, $image_type, 1336, $image_width, $image_height,  $_POST['qa'], false, true)){
                            crop_image_square($image_res, $target_tmb_file, $image_type, 320, $image_width, $image_height,  $_POST['qa']);
                           
                            @unlink(UPLOAD_IMG_PATH . anything('gallery','image',$_POST['bid']));
                            @unlink(UPLOAD_TMB_IMG_PATH . anything('gallery','image',$_POST['bid']));


                            mysqli_query($link,"UPDATE ".$prefix."gallery SET `image`='$fbasename' WHERE `id`=".$_POST['bid']);
                        }
                        else {
                            $error='1';
                            unlink($target_file);
                        }
                    }
                    
                    $query='';
                    foreach($_POST as $key=>$value) if($key != 'usubmit')if($key != "bid")if($key != 'qa')$query .="`$key`='$value',";
                    $query = substr($query, 0, -1);//omit last comma

                    if(!isset($error)&& mysqli_query($link,"UPDATE ".$prefix."gallery SET ".$query." WHERE id=".$_POST['bid'])){//insert all text info
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Gallery Image Updated successfully.</p>';
                    }
                    // else { 
                    //     echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while updating details!</p>';   
                    // }
                }
                
                
                    //delete Projects

                    if(isset($_GET['del'])){
                    
                     $img=anything('gallery','image',$_GET['del']);
                    if(mysqli_query($link,"DELETE FROM ".$prefix."gallery WHERE id=".variable_check($_GET['del']))){ //delete info
                        @unlink(UPLOAD_IMG_PATH . $img);
                         @unlink(UPLOAD_TMB_IMG_PATH . $img);  
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Photo Gallery Images Image Deleted successfully.</p>';
                    }
                    else echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while deleting!</p>';
                }
                ?>

                <!--add new-->
                <div class="panel panel-default" id="addnew" style="display:none;">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="fa fa-plus fa-fw"></i> Add New</div>
                    </div>
                    <div class="panel-body">
                        <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                                             
                             
                             <div class="form-group">
                                <label class="col-sm-2 control-label">Image<font color="red">*</font></label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input type="text" class="form-control" readonly placeholder="Choose JPEG file">
                                       
                                        <span class="input-group-btn"><button data-file-input='image' type="button" class="btn btn-primary">Browse</button></span>
                                         <input type="file" name="image" onChange="updateName(this)" accept=".jpg,.jpeg" style="height:1px;width:1px;" required>
                                    </div>
                                    <small><i class="fa fa-info-circle fa-fw"></i>Try to upload Higher Resolution JPEG image</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Quality</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="qa">
                                        <?php
                                        $i=0;
                                        while($i<=100){
                                        ?>
                                        <option value="<?=$i?>" <?=$i==100? 'selected' :''?>><?=$i?> <?=$i==100?'(Original)':''?><?=$i==70?'(Good)':''?><?=$i==50?'(Average)':''?><?=$i==20?'(Low)':''?></option>
                                        <?php
                                            $i=$i+1;
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <input type="reset" class="btn btn-danger pull-right" value="Cancel" onClick="$('#addnew').hide('slow')">
                            <input type="submit" name="submit" class="btn btn-success pull-right" value="Save">
                        </form>
                    </div>
                </div>
                <!--list-->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="fa fa-list fa-fw"></i> Gallery List <button onClick="$('#addnew').show('slow')" class="btn btn-sm btn-primary pull-right">Add New</button></div>
                    </div>
                    <div class="panel-body">
                        <table id="gallery_list" class="table table-hover table-bordered table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $select=mysqli_query($link,"SELECT * FROM ".$prefix."gallery");
                                while($row=mysqli_fetch_object($select)){
                                ?>
                                <tr>
                                    
                                    <td><img src="<?=UPLOAD_TMB_IMG_PATH . $row->image?>" alt="..." height="30"></td>                                   
                                   
                                    <td>
                                        <button class="btn btn-default btn-sm" onClick="getGallery(<?=$row->id?>)"><i class="fa fa-eye fa-fw"></i>/<i class="fa fa-pencil fa-fw"></i></button>
                                        <a class="btn btn-danger btn-sm" href="?del=<?=$row->id?>"><i class="fa fa-trash fa-fw"></i></a>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal fade" role="dialog">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">View / Edit Gallery</h4>
                        </div>
                        <div class="modal-body clearfix">
                           <div class="row">
                                <div class="col-sm-4 text-center">
                                    <p><b>Existing Image:</b></p>
                                    <img id="eximg" src="" alt="" width="100%">
                                </div>
                                <div class="col-sm-8">
                                    <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                                    <input type="hidden" id="bid" name="bid" required>
                                   
                                    <div class="form-group">
                                    <label class="col-sm-2 control-label">Image</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <input type="text" class="form-control" readonly placeholder="Choose JPEG file">
                                            
                                            <span class="input-group-btn"><button data-file-input='image' type="button" class="btn btn-primary">Browse</button></span>
                                            <input type="file" name="image" onChange="updateName(this)" accept=".jpg,.jpeg" style="height:1px;width:1px;">
                                        </div>
                                        <small><i class="fa fa-info-circle fa-fw"></i>Try to upload Higher Resolution JPEG image</small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Quality</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="qa">
                                            <?php
                                            $i=0;
                                            while($i<=100){
                                            ?>
                                            <option value="<?=$i?>" <?=$i==100? 'selected' :''?>><?=$i?> <?=$i==100?'(Original)':''?><?=$i==70?'(Good)':''?><?=$i==50?'(Average)':''?><?=$i==20?'(Low)':''?></option>
                                            <?php
                                                $i=$i+1;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <input type="submit" name="usubmit" class="btn btn-success pull-right" value="Save">
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                
                
            </div>
            <!--main content end-->
        </div>
<?php include_once 'include/footer.php';?>
<script src="assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/js/common.js"></script>
<script type="text/javascript">
$('#gallery_list').DataTable( {
    "columnDefs": [
    {"searchable": false,"orderable": false,"targets": 1}],
    "order": [[ 0, 'asc' ]]
});
function getGallery(id){
    $.ajax({
        type: 'post',
        url:'ajax/getGallery.php',
        data:{'id':id},
        success:function(data){
            data = JSON.parse(data);
            $('#bid').val(id);          
            $('#eximg').attr('src',"<?=UPLOAD_IMG_PATH?>" + data[0]['image']);
            $('.modal').modal('show');
        }
    })
}
</script>
<?php if(isset($_GET['del'])){?>
<div id="url_replace">
    <script type="text/javascript">
        $(document).ready(function(e) {
            window.history.replaceState(null, null, '<?=$page?>');
            $('#url_replace').remove();
        });
    </script>
</div>
<?php }?>
</body>
</html>    
