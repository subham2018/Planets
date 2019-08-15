<?php include_once 'include/head.php';?>
<!doctype html>
<html>
<head>
<?php include_once 'include/header.php';?>
<title><?=$site->site_title?>Admin Panel</title>
<link rel="stylesheet" type="text/css" href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>
<?php include_once 'include/navbar.php';?>  
        <div class="content">
            <div class="overlay"></div><!--for mobile view sidebar closing-->
            <!--title and breadcrumb-->
            <div class="top">
                <p class="page-title"><i class="fa fa-cubes"></i> Product</p>
                <ol class="breadcrumb">
                   <li><a href="index.php">Admin panel</a></li>
                    
                     <li class="active">Product</li>
                </ol>
            </div>

            <div class="main-body">
                        <?php
                //Category save
                if(isset($_POST['submit'])){
                    check_all_var(); //prevent mysql injection              
                    //check and insert Technology top
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
                            case 'image/jpeg':  $image_res = imagecreatefromjpeg($image_temp); break;
                            default: $image_res = false;
                        }
                        //optimize and save
                        if($image_res != false && resize_image($image_res, $target_file, $image_type, 1024, $image_width, $image_height,  $_POST['qa'], false, true)){
                            $query='';
                            foreach($_POST as $key=>$value) if($key != 'submit')if($key != 'qa')$query .="`$key`='$value',";
                            $query .= "`image`='$fbasename'"; 
                            mysql_query("INSERT INTO ".$prefix."product SET ".$query);
                            echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Product Added successfully.</p>';
                            echo mysql_error();
                        }
                        else {
                            unlink($target_file);
                            echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while uploading image!</p>'; 
                        }
                    }
                }
                if(isset($_POST['usubmit'])){
                   check_all_var(); //prevent mysql injection              
                    //check and insert Technology top
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
                            case 'image/jpeg':  $image_res = imagecreatefromjpeg($image_temp); break;
                            default: $image_res = false;
                        }
                        //optimize and save
                        if($image_res != false && resize_image($image_res, $target_file, $image_type, 1024, $image_width, $image_height,  $_POST['qa'], false, true)){
                            unlink(UPLOAD_IMG_PATH . anything('product','image',$_POST['bid']));
                            mysql_query("UPDATE ".$prefix."product SET `image`='$fbasename' WHERE `id`=".$_POST['bid']);
                        }
                        else {
                            $error='1';
                            unlink($target_file);
                        }
                    }
                    //insert to database textual data
                    $query='';
                    foreach($_POST as $key=>$value) if($key != 'usubmit')if($key != "bid")if($key != 'qa')$query .="`$key`='$value',";
                    $query = substr($query, 0, -1);//omit last comma

                    if(!isset($error) && mysql_query("UPDATE ".$prefix."product SET ".$query." WHERE id=".$_POST['bid'])) //insert all text info
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Product Updated successfully.</p>';
                    else { 
                        echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while updating details!</p>';
                        echo mysql_error();
                }
            }

                if(isset($_GET['del'])){
                    $img = anything('product','image',$_GET['del']);
                    //delete Blog Category Page
                    if(mysql_query("DELETE FROM ".$prefix."product WHERE id=".variable_check($_GET['del']))){ //delete info
                        @unlink(UPLOAD_IMG_PATH . $img);
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Product successfully deleted.</p>';
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
                                <label class="col-sm-2 control-label">Product Category*</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="catid">
                                         <option value="0">No Category</option>
                                        <?php
                             $productselect=mysql_query("SELECT * FROM ".$prefix."procat");
                                        while($rowselect=mysql_fetch_object($productselect)){
                                        ?>
                                        <option value="<?=$rowselect->id?>"><?=$rowselect->title?></option>
                                        <?php
                                           
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" maxlength="256" placeholder="Enter product title" required>
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="col-sm-2 control-label">Desciption</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="editor_hea" name="dsc" required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Specification</label>
                                <div class="col-sm-10">
                        <textarea class="form-control" id="editor_ha" name="specification" required></textarea>
                                </div>
                            </div>

                           <div class="form-group">
                                <label class="col-sm-2 control-label">Image*</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input type="text" class="form-control" readonly placeholder="Choose JPEG file">
                                        <input type="file" name="image" onChange="updateName(this)" accept=".jpg,.jpeg" required class="hidden">
                                        <span class="input-group-btn"><button data-file-input='image' type="button" class="btn btn-primary">Browse</button></span>
                                    </div>
                                    <small><i class="fa fa-info-circle fa-fw"></i> Please upload good resolution image.</small>
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
                            <!-- <div class="form-group">
                                <label class="col-sm-2 control-label">Price</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-inr fa-fw"></i></span>
                                        <input type="number" class="form-control" name="price" min="0" step="1" placeholder="Enter product price" required>
                                    </div>
                                </div>
                            </div> -->
                           
                             
                            <hr>
                            <input type="reset" class="btn btn-danger pull-right" value="Cancel" onClick="$('#addnew').hide('slow')">
                            <input type="submit" name="submit" class="btn btn-success pull-right" value="Save">
                        </form>
                    </div>
                </div>
                 <!--list-->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="fa fa-list fa-fw"></i> Product List <button onClick="$('#addnew').show('slow')" class="btn btn-sm btn-primary pull-right">Add New</button></div>
                    </div>
                    <div class="panel-body">
                        <table id="Service_list" class="table table-hover table-bordered table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Title</th>                                   
                                    <th>Image</th>  
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $select=mysql_query("SELECT * FROM ".$prefix."product");
                                while($row=mysql_fetch_object($select)){
                                ?>
                                <tr>
                                    <td><?=$row->title?></td>                                     
                                    <td><img src="<?=UPLOAD_IMG_PATH.anything('product','image',$row->id)?>" height="20px"></td> 
                                   
                                   <td><?=$row->status=='0'?'Inactive':''?><?=$row->status=='1'?'Active':''?></td>
                                    <td>

                                        <button class="btn btn-default btn-sm" onClick="getCategory(<?=$row->id?>)"><i class="fa fa-eye fa-fw"></i>/<i class="fa fa-pencil fa-fw"></i></button>                                        
                                       
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
                            <h4 class="modal-title">View / Edit Product</h4>
                        </div>
                        <div class="modal-body clearfix">
                           <div class="col-sm-4 text-center">
                                    <p><b>Existing Image:</b></p>
                                    <img id="eximg" src="" alt="" width="100%">
                                </div>
                                <div class="col-sm-8">
                            <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                                <input type="hidden" id="bid" name="bid" required>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="title" name="title" maxlength="256" placeholder="Enter product title" required>
                                    </div>
                                </div>
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
                              
                               <!--  <div class="form-group">
                                    <label class="col-sm-2 control-label">Price</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-inr fa-fw"></i></span>
                                            <input type="number" class="form-control" id="price" name="price" min="0" step="1" placeholder="Enter product price" required>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Desciption</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="editor_he" name="dsc" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Specification</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="editor_h" name="specification" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Status</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select2" id="status" name="status" required>
                                            <option value="0">Inactive</option>
                                            <option value="1">Active</option>
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
<script src="assets/plugins/ckeditor/ckeditor.js"></script>
<script src="assets/js/common.js"></script>
<script type="text/javascript">
CKEDITOR.replace( 'editor_h' );

CKEDITOR.replace( 'editor_he' );


CKEDITOR.replace( 'editor_ha' );

CKEDITOR.replace( 'editor_hea' );

$('#Service_list').DataTable( {
    "columnDefs": [
    {"searchable": false,"orderable": false,"targets": 2} ],
    "order": [[ 0, 'asc' ]]
});
function getCategory(id){
    $.ajax({
        type: 'post',
        url:'ajax/getProduct.php',
        data:{'id':id},
        success:function(data){
            data = JSON.parse(data);
            $('#bid').val(id);
            $('#catid').val(data[0]['catid']);
            $('#title').val(data[0]['title']);      
            $('#status').val(data[0]['status']);  
            $('#eximg').attr('src',"<?=UPLOAD_IMG_PATH?>" + data[0]['image']);
            CKEDITOR.instances['editor_he'].setData(data[0]['dsc']);
            CKEDITOR.instances['editor_h'].setData(data[0]['specification']);
            
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
