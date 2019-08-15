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
                <p class="page-title"><i class="fa fa-image fa-fw"></i> Blog Manage</p>
                <ol class="breadcrumb">
                    
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Blog</a></li>
                    <li class="active">Blog Manage </li>
                </ol>
            </div>
     <!--main content start-->
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
                            mysql_query("INSERT INTO ".$prefix."blog SET ".$query);
                            echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Blog Manage Added successfully.</p>';
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
                            unlink(UPLOAD_IMG_PATH . anything('blog','image',$_POST['bid']));
                            mysql_query("UPDATE ".$prefix."blog SET `image`='$fbasename' WHERE `id`=".$_POST['bid']);
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

                    if(!isset($error) && mysql_query("UPDATE ".$prefix."blog SET ".$query." WHERE id=".$_POST['bid'])) //insert all text info
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Blog Manage Updated successfully.</p>';
                    else { 
                        echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while updating details!</p>';
                        echo mysql_error();
                }
            }

                if(isset($_GET['del'])){
                    $img = anything('blog','image',$_GET['del']);
                    //delete Blog Category Page
                    if(mysql_query("DELETE FROM ".$prefix."blog WHERE id=".variable_check($_GET['del']))){ //delete info
                        @unlink(UPLOAD_IMG_PATH . $img);
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Blog manage successfully deleted.</p>';
                    }
                    else echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while deleting!</p>';
                }
             ?>
     <!--add new-->
                <div class="panel panel-default" id="addnew" style="display:none;">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="fa fa-plus fa-fw"></i> Add Article</div>
                    </div>
                    <div class="panel-body">
                        <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" placeholder="Enter Name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Category</label>
                                <div class="col-sm-10">
                                   <select class="form-control" required name="cat_id">
                                        <option selected disabled value="">Select Category</option>
                                        <?php
                                        $select=mysql_query("SELECT * FROM ".$prefix."blog_cat");
                                        while($row=mysql_fetch_object($select)){
                                        ?>
                                        <option value="<?=$row->id?>"><?=$row->name?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                            <label class="col-md-2 control-label">Top Image (optional):</label>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="file" name="image" id="fileToUpload" accept=".jpg,.jpeg">
                                                    <font color="red"><b>Image will show up in social network while sharing this article and in the top of this article</b></font>
                                                </div>
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
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Content</label>
                                            <div class="col-sm-10">
                                            <textarea rows="5" class="form-control" id="content" name="content" placeholder="Enter description"></textarea>
                                        </div>
                                    </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Tags</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="tag" placeholder="Enter Name" required>
                                        <font color="red"><b>Tags need to be stepareted with comma (,)</b></font>
                                    </div>
                                </div>                               
                               
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Active</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="status" required>
                                            <option value="0" selected>No</option>
                                            <option value="1">Yes</option>
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
                        <div class="panel-title"><i class="fa fa-list fa-fw"></i>Article List <button onClick="$('#addnew').show('slow')" class="btn btn-sm btn-primary pull-right">Add New Manually</button></div>
                    </div>
                    <div class="panel-body">
                        <table id="blog" class="table table-hover table-bordered table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Content</th>
                                    <th>View</th>
                                    <th>Date</th>
                                    <th>Active</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $select=mysql_query("SELECT * FROM ".$prefix."blog");
                                while($row=mysql_fetch_object($select)){
                                ?>
                                <tr>
                                    <td><?=$row->title?></td>
                                    <td><?=anything('blog_cat','name',$row->cat_id)?></td>
                                    <td><?=strlen(strip_tags(html_entity_decode($row->content)))>100 ? trim(substr(strip_tags(html_entity_decode($row->content)),0,100)).'...':strip_tags(html_entity_decode($row->content))?></td>
                                    <td><?=$row->view?></td>
                                    <td><?=date("D, F d, Y",strtotime($row->datetime))?></td>
                                    <td><?=$row->status=='1'? 'Yes':'No'?></td>
                                    <td>
                                        <button class="btn btn-default btn-sm" onClick="getBlog(<?=$row->id?>)"><i class="fa fa-eye fa-fw"></i>/<i class="fa fa-pencil fa-fw"></i></button>
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
                            <h4 class="modal-title">View / Edit Article<h4>
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
                                    <label class="col-sm-2 control-label">Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" name="title" placeholder="Enter Name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                <label class="col-sm-2 control-label">Category</label>
                                <div class="col-sm-10">
                                   <select class="form-control" id="cat_id" required name="cat_id">
                                        <option selected disabled value="">Select Category</option>
                                        <?php
                                        $select=mysql_query("SELECT * FROM ".$prefix."blog_cat");
                                        while($row=mysql_fetch_object($select)){
                                        ?>
                                        <option value="<?=$row->id?>"><?=$row->name?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                </div>
                                <div class="form-group">
                                <label class="col-sm-2 control-label">Image</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input type="text" class="form-control" readonly placeholder="Choose JPEG file">
                                        <input type="file" name="image" onChange="updateName(this)" accept=".jpg,.jpeg,.png" class="hidden" >
                                        <span class="input-group-btn"><button data-file-input='image' type="button" class="btn btn-primary">Browse</button></span>
                                    </div>
                                    <small><i class="fa fa-info-circle fa-fw"></i>Try to upload Higher Resolution JPEG image</small>
                                    <br />
                                    <font color="red"><b>Image will show up in social network while sharing this article and in the top of this article</b></font>
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
                             <div class="form-group">
                                    <label class="col-sm-2 control-label">Content</label>
                                    <div class="col-sm-10">
                                    <textarea rows="5" class="form-control" id="content2" name="content" placeholder="Write Content here"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Tags</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="tag" name="tag" placeholder="Enter Name" required>
                                        <font color="red"><b>Tags need to be stepareted with comma (,)</b></font>
                                    </div>
                                </div>                               
                                 
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Active</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="act" name="status" required>
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
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
<script src="assets/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript">

$(document).ready(function(){
    $('#blog').DataTable( {
        "columnDefs": [
        {"searchable": false ,"orderable": false,"targets": 5} ],
        "order": [[ 0, 'asc' ]]
    });
    CKEDITOR.replace('content');
    CKEDITOR.replace('content2');
});
function getBlog(id){
    $.ajax({
        type: 'post',
        url:'ajax/getBlog.php',
        data:{'id':id},
        success:function(data){
            data = JSON.parse(data);
            $('#bid').val(id);
            $('#name').val(data[0]['title']);
            // $('#content2').val(data[0]['content']);
            CKEDITOR.instances['content2'].setData(data[0]['content']);
            $('#cat_id').val(data[0]['cat_id']);
            $('#eximg').attr('src',"<?=UPLOAD_IMG_PATH?>" + data[0]['image']);
            $('#tag').val(data[0]['tag']);
            $('#act').val(data[0]['act']);
            $('#act').val(data[0]['act']);
            $('#act1').val(data[0]['ads']);
            $('#act2').val(data[0]['relatepost']);
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
