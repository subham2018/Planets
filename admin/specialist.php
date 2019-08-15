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
            	<p class="page-title"><i class="fa fa-image fa-fw"></i> Specialist</p>
                <ol class="breadcrumb">
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="#">Home</a></li>                    
                    <li class="active">Specialist</li>
                </ol>
            </div>
            <!--main content start-->
            <div class="main-body">
            	<?php
                //specialist background
                if(isset($_POST['submit'])){
                    //check and insert specialist back
                    if(!empty($_FILES['side_img']['tmp_name']) && is_uploaded_file( $_FILES['side_img']['tmp_name'] )){
                        //conver file name to md5 and prepend timestamp
                        $fbasename=time().'_'.md5($_FILES["side_img"]["name"]).'.'.pathinfo($_FILES["side_img"]["name"],PATHINFO_EXTENSION);
                        $target_file = UPLOAD_IMG_PATH . $fbasename;
                        $image_temp = $_FILES['side_img']['tmp_name'];
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
                            case 'image/png':  $image_res = imagecreatefrompng($image_temp); break;
                            default: $image_res = false;
                        }
                        //optimize and save
                        if($image_res != false && resize_image($image_res, $target_file, $image_type, 768, $image_width, $image_height,  $_POST['qa'], true, false)){
                            //generate query from post
                            $query='';
                            foreach($_POST as $key=>$value) if($key != "submit")if($key != "qa") $query .="`$key`='$value',";
                            $query .= "`side_img`='".$fbasename."'";
                            
                            mysql_query("INSERT INTO ".$prefix."specialist SET ".$query);
                            echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Specialist successfully added.</p>';
                        }
                        else {
                            unlink($target_file);
                            echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while inserting specialist information record!</p>'; 
                        }
                    }
                }

                //specialist edit
                if(isset($_POST['usubmit'])){
                    check_all_var(); //prevent mysql injection 
                    //check and insert specialist back
                    if(!empty($_FILES['side_img']['tmp_name']) && is_uploaded_file( $_FILES['side_img']['tmp_name'] )){
                        //conver file name to md5 and prepend timestamp
                        $fbasename=time().'_'.md5($_FILES["side_img"]["name"]).'.'.pathinfo($_FILES["side_img"]["name"],PATHINFO_EXTENSION);
                        $target_file = UPLOAD_IMG_PATH . $fbasename;
                        $image_temp = $_FILES['side_img']['tmp_name'];
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
                            case 'image/png':  $image_res = imagecreatefrompng($image_temp); break;
                            default: $image_res = false;
                        }
                        //optimize and save
                        if($image_res != false && resize_image($image_res, $target_file, $image_type, 768, $image_width, $image_height,  $_POST['qa'], true, false)){
                            //generate query from post
                            unlink(UPLOAD_IMG_PATH . anything('specialist','side_img',$_POST['bid']));
                            mysql_query("UPDATE ".$prefix."specialist SET `side_img`='".$fbasename."' WHERE `id`=".$_POST['bid']);
                        }
                        else {
                            unlink($target_file);
                            $error='1';
                        }
                    }             
                    //generate query from post
                    $query='';
                    foreach($_POST as $key=>$value) if($key != "usubmit") if($key != "qa") if($key != "bid") $query .="`$key`='$value',";
                    $query = substr($query, 0, -1);//omit last comma

                    if(!isset($error) && mysql_query("UPDATE ".$prefix."specialist SET ".$query." WHERE id=".$_POST['bid'])) //insert all text info
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Specialist information successfully updated.</p>';
                    else { 
                        
                        echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while updating specialist information record!</p>';   
                    }
                }

				if(isset($_GET['del'])){
                    //delete specialist
                    $img = anything('specialist','side_img',$_GET['del']);
					if(mysql_query("DELETE FROM ".$prefix."specialist WHERE id=".variable_check($_GET['del']))) {//delete info
                        @unlink(UPLOAD_IMG_PATH . $img);
						echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Specialist successfully deleted.</p>';
                    }
					else echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while deleting specialist information record!</p>';
				}
				?>

            	<!--add new-->
                <div class="panel panel-default" id="addnew" style="display:none;">
                	<div class="panel-heading">
                    	<div class="panel-title"><i class="fa fa-plus fa-fw"></i> Add Specialist</div>
                    </div>
                    <div class="panel-body">
                        

                        <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Title*</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"  maxlength="255" name="title" placeholder="Enter specialist title" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Content*</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"  maxlength="" name="content" placeholder="Enter specialist Content" required>
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label class="col-sm-2 control-label">Button Name*</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"  maxlength="255" name="btn_name" placeholder="Enter specialist button name" required>
                                </div>
                            </div> -->

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Image*</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input type="text" class="form-control" readonly placeholder="Choose JPEG file">
                                        <input type="file" name="side_img" onChange="updateName(this)" accept=".jpg,.jpeg" required class="hidden">
                                        <span class="input-group-btn"><button data-file-input='side_img' type="button" class="btn btn-primary">Browse</button></span>
                                    </div>
                                    <small><i class="fa fa-info-circle fa-fw"></i> Please upload good resolution image.</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Image Quality*</label>
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
                    	<div class="panel-title"><i class="fa fa-list fa-fw"></i> Specialist List <button onClick="$('#addnew').show('slow')" class="btn btn-sm btn-primary pull-right">Add Record</button></div>
                    </div>
                    <div class="panel-body">
                    	<table id="specialist_list" class="table table-hover table-bordered table-condensed" cellspacing="0" width="100%">
                        	<thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
							<tbody>
                            	<?php
								$select=mysql_query("SELECT * FROM ".$prefix."specialist");
								while($row=mysql_fetch_object($select)){
								?>
                                <tr>
                                	<td><?=$row->title?></td>
                                    <td><img src="<?=UPLOAD_IMG_PATH.anything('specialist','side_img',$row->id)?>" height="20px"></td>
                                    <td>
                                        <button class="btn btn-default btn-sm" onClick="getSpecialist(<?=$row->id?>)"><i class="fa fa-eye fa-fw"></i>/<i class="fa fa-pencil fa-fw"></i></button>
                                        <a class="btn btn-danger btn-sm" href="specialist.php?del=<?=$row->id?>"><i class="fa fa-trash fa-fw"></i></a>
                                    </td>
								</tr>
                                <?php }?>
                            </tbody>
						</table>
                    </div>
                </div>
                
                <div class="modal fade"  role="dialog">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">View / Edit Specialist</h4>
                        </div>
                        <div class="modal-body clearfix">
                            <a href="#uimg" aria-controls="uimg" role="tab" data-toggle="tab"></a>
                            <a href="#imgo" aria-controls="imgo" role="tab" data-toggle="tab"></a>
                            <div class="row">
                                <div class="col-sm-4 text-center">
                                    <p><b>Existing Image:</b></p>
                                    <img id="eximg" src="" alt="" width="100%">
                                </div>
                                <div class="col-sm-8">
                                     <form action="" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="bid" id="bid">
                                        <div class="form-group">
                                            <label>Title*</label>
                                            <div>
                                                <input type="text" class="form-control"  maxlength="255" id="title" name="title" placeholder="Enter specialist title" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label >Content</label>
                                            <div >
                                                <input type="text" class="form-control"  id="content" name="content" placeholder="Enter specialist Content" required>
                                            </div>
                                        </div>
                                     <!--   <div class="form-group">
                                            <label>Button Name*</label>
                                            <div>
                                                <input type="text" class="form-control"  maxlength="255" name="btn_name" id="btn_name" placeholder="Enter specialist button name" required>
                                            </div>
                                        </div> -->
                                        <div class="form-group">
                                            <label>Image*</label>
                                            <div >
                                                <div class="input-group">
                                                    <input type="text" class="form-control" readonly placeholder="Choose JPEG file">
                                                    <input type="file" name="side_img" onChange="updateName(this)" accept=".jpg,.jpeg"  class="hidden">
                                                    <span class="input-group-btn"><button data-file-input='side_img' type="button" class="btn btn-primary">Browse</button></span>
                                                </div>
                                                <small><i class="fa fa-info-circle fa-fw"></i> Please upload good resolution image.</small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Image Quality*</label>
                                            <div >
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
                                        <!-- <input type="reset" class="btn btn-danger pull-right" value="Cancel" onClick="$('#addnew').hide('slow')"> -->
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
<script src="assets/js/jscolor.min.js"></script>
<script type="text/javascript">
$('#specialist_list').DataTable( {
	"columnDefs": [
	{"searchable": false,"orderable": false,"targets": 2}],
	"order": [[ 0, 'asc' ]]
});
function getSpecialist(id){
    $.ajax({
        type: 'post',
        url:'ajax/getSpecialist.php',
        data:{'id':id},
        success:function(data){
            data = JSON.parse(data);
            $('#bid').val(id);
            $('#title').val(data[0]['title']);
            $('#content').val(data[0]['content']);  
            $('#eximg').attr('src',"<?=UPLOAD_IMG_PATH?>" + data[0]['side_img']);
            
            $('.modal').modal('show');
        }
    })
}
</script>

</body>
</html>