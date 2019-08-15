<?php include_once 'include/head.php';
if(!isset($_GET['id'])) header('location: manageproduct.php');
else{
    $aid = variable_check($_GET['id']);
    if(mysql_num_rows(mysql_query("SELECT * from ".$prefix."product WHERE `id`='".$aid."'")) == 0) header('location: manageproduct.php');
}
?>
<!doctype html>
<html>
<head>
<?php include_once 'include/header.php';?>
<title><?=$site->site_title?> Admin Panel</title>
<link rel="stylesheet" type="text/css" href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/plugins/select2-master/dist/css/select2.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>

<body>
<?php include_once 'include/navbar.php';?>	
        <div class="content">
        	<div class="overlay"></div><!--for mobile view sidebar closing-->
        	<!--title and breadcrumb-->
            <div class="top">
            	<p class="page-title"><i class="fa fa-image fa-fw"></i> Product Images</p>
                <ol class="breadcrumb">
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="product.php">Product</a></li>
                    <li class="active">Product Images</li>
                </ol>
            </div>
            <!--main content start-->
            <div class="main-body">
                <?php
                //Projects Save
                if(isset($_POST['submit'])){
                    check_all_var(); //prevent mysql injection              
                    //check and insert banner
                    if(!empty($_FILES['image1']['tmp_name']) && is_uploaded_file( $_FILES['image1']['tmp_name'] )){
                        //convert file name to md5 and prepend timestamp
                        $fbasename=time().'_'.md5($_FILES["image1"]["name"]).'.'.pathinfo($_FILES["image1"]["name"],PATHINFO_EXTENSION);
                        $target_file = UPLOAD_IMG_PATH . $fbasename;
                        $target_tmb_file = UPLOAD_TMB_IMG_PATH . $fbasename;
                        $target_file_s = UPLOAD_IMG_PATH . 's_' .$fbasename;
                        

                        $image_temp = $_FILES['image1']['tmp_name'];
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
                            case 'image/png':  $image_res = imagecreatefrompng($image_temp); break;
                            case 'image/jpeg': case 'image/pjpeg':  $image_res = imagecreatefromjpeg($image_temp); break;
                            default: $image_res = false;
                        }
                        //optimize and save
                        if($image_res != false && resize_image($image_res, $target_file_s, $image_type, 700, $image_width, $image_height,  $_POST['qa'], false, true)){
                            save_image($image_res, $target_file, $image_type, $_POST['qa']);

                            crop_image_square($image_res, $target_tmb_file, $image_type, 400, $image_width, $image_height,  $_POST['qa']);
                            $query='';
                            foreach($_POST as $key=>$value) if($key != 'submit')if($key != 'qa')$query .="`$key`='$value',";
                            $query .= "`image1`='$fbasename'"; 
                            
                            mysql_query("INSERT INTO ".$prefix."product SET ".$query);
                            echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Product Image Added successfully.</p>';
                            echo mysql_error();
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
                        $target_file_s = UPLOAD_IMG_PATH . 's_' .$fbasename;
                       

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
                            case 'image/png':  $image_res = imagecreatefrompng($image_temp);  break;
                            case 'image/jpeg': case 'image/pjpeg':  $image_res = imagecreatefromjpeg($image_temp); break;
                            default: $image_res = false;
                        }
                        //optimize and save
                        if($image_res != false && resize_image($image_res, $target_file_s, $image_type, 1000, $image_width, $image_height,  $_POST['qa'], true, false)){
                            save_image($image_res, $target_file, $image_type, $_POST['qa']);
                            crop_image_square($image_res, $target_tmb_file, $image_type, 400, $image_width, $image_height,  $_POST['qa']);

                            @unlink(UPLOAD_IMG_PATH . anything('product_img','image',$_POST['pid']));
                            @unlink(UPLOAD_TMB_IMG_PATH . anything('product_img','image',$_POST['pid']));
                            @unlink(UPLOAD_IMG_PATH .'s_'. anything('product_img','image',$_POST['pid']));
                            
                            if(mysql_query("UPDATE ".$prefix."product_img  SET `image`='$fbasename' WHERE `id`='".$_POST['pid']."'"))
                                echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Product Image Updated successfully.</p>';
                            else echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while updating details!</p>';

                        }
                        else {
                            unlink($target_file);
                            echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while updating details!</p>';
                        }
                    }
                    
                    
                }

                if(isset($_GET['del'])){
                    //delete Projects
                     $img=anything('product_img','image',$_GET['del']);
                    if(mysql_query("DELETE FROM ".$prefix."product_img WHERE id=".variable_check($_GET['del']))){ //delete info
                        @unlink(UPLOAD_IMG_PATH . $img);
                        @unlink(UPLOAD_TMB_IMG_PATH . $img);
                        @unlink(UPLOAD_IMG_PATH .'s_'. $img);
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Product Image Deleted successfully.</p>';

                    }
                    else echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while deleting!</p>';
                }
                ?>
                <div class="well well-sm"><p style="margin:0"><strong>Product Title:</strong> <?=anything('product','title',$aid)?></p></div>
                <!--add new-->
                <div class="panel panel-default" id="addnew" style="display:none;">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="fa fa-plus fa-fw"></i> Add New Image</div>
                    </div>
                    <div class="panel-body">
                        <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <!-- <input type="hidden" name="pro_id" value="<?=$aid?>" required> -->
                            
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Image</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input type="text" class="form-control" readonly placeholder="Choose JPEG/PNG file">
                                        <input type="file" name="image1" onChange="updateName(this)" accept=".png,.jpeg,.jpg" class="hidden" required>
                                        <span class="input-group-btn"><button data-file-input='image' type="button" class="btn btn-primary">Browse</button></span>
                                    </div>
                                    <small><i class="fa fa-info-circle fa-fw"></i>Try to upload JPEG/PNG image</small>
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
                                        <option value="<?=$i?>" <?=$i==70? 'selected' :''?>><?=$i?> <?=$i==100?'(Original)':''?><?=$i==70?'(Good)':''?><?=$i==50?'(Average)':''?><?=$i==20?'(Low)':''?></option>
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
                        <div class="panel-title"><i class="fa fa-list fa-fw"></i> Image List <button onClick="$('#addnew').show('slow')" class="btn btn-sm btn-primary pull-right">Add Image</button></div>
                    </div>
                    <div class="panel-body">
                        <table id="Projects_list" class="table table-hover table-bordered table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $select=mysql_query("SELECT * FROM ".$prefix."product_img WHERE `pro_id`='".$aid."'");
                                while($row=mysql_fetch_object($select)){
                                ?>
                                <tr>
                                    <td><img src="<?=UPLOAD_IMG_PATH.$row->image?>" height="20px"></td>
                                    <td>
                                        <button class="btn btn-default btn-sm" onClick="getImage(<?=$row->id?>)"><i class="fa fa-eye fa-fw"></i>/<i class="fa fa-pencil fa-fw"></i></button>
                                        <a class="btn btn-danger btn-sm" href="product_image.php?id=<?=$aid?>&del=<?=$row->id?>"><i class="fa fa-trash fa-fw"></i></a>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="modal fade" tabindex="-1" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">View / Edit Image</h4>
                        </div>
                        <div class="modal-body clearfix">
                            <div class="row">
                                <div class="col-sm-3 text-center">
                                    <p><b>Existing Image:</b></p>
                                    <img id="eximg" src="" alt="" width="100%">
                                </div>
                                <div class="col-sm-9">
                                    <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                                        <input type="hidden" id="pid" name="pid" required>
                                        
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Image</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" readonly placeholder="Choose JPEG/PNG file">
                                                    <input type="file" name="image" onChange="updateName(this)" accept=".png,.jpeg,.jpg" class="hidden" >
                                                    <span class="input-group-btn"><button data-file-input='image' type="button" class="btn btn-primary">Browse</button></span>
                                                </div>
                                                <small><i class="fa fa-info-circle fa-fw"></i>Try to upload JPEG/PNG image</small>
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
                                                    <option value="<?=$i?>" <?=$i==70? 'selected' :''?>><?=$i?> <?=$i==100?'(Original)':''?><?=$i==70?'(Good)':''?><?=$i==50?'(Average)':''?><?=$i==20?'(Low)':''?></option>
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
                            </div>
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

$('#Projects_list').DataTable( {
    "columnDefs": [
    {"searchable": false,"orderable": false,"targets": 1} ],
    "order": [[ 0, 'asc' ]]
});
function getImage(id){
    $.ajax({
        type: 'post',
        url:'ajax/getProImage.php',
        data:{'id':id},
        success:function(data){
            data = JSON.parse(data);
            $('#pid').val(id);
            $('#eximg').attr('src',"<?=UPLOAD_IMG_PATH?>" + data[0]['img']);
            $('.modal').modal('show');
        }
    })
}
</script>

</body>
</html>