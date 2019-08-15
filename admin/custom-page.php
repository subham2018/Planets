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
            	<p class="page-title"><i class="fa fa-file-text-o fa-fw"></i> Policy Information</p>
                <ol class="breadcrumb">
					<li><a href="index.php">Dashboard</a></li>
                    <li class="active">Policy Information</li>
                </ol>
            </div>
            <!--main content start-->
            <div class="main-body">
            	<?php
                //Custom Page Save
                if(isset($_POST['submit'])){
                    check_all_var(); //prevent mysql injection              

                    if(mysql_query("INSERT INTO ".$prefix."page SET `title`='".$_POST['title']."',`content`='".$_POST['content']."',`status`='".$_POST['status']."'")) //insert all text info
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Custom page information successfully added.</p>';
                    else { 
                        echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while uploading image!</p>';   
                    }
                }

                //Custom Page edit
                if(isset($_POST['usubmit'])){
                    check_all_var(); //prevent mysql injection      
                    
                    $query='';
                    foreach($_POST as $key=>$value) if($key != 'usubmit')if($key != "pid")if($key != 'qa')$query .="`$key`='$value',";
                    $query = substr($query, 0, -1);//omit last comma

                    if(!isset($error) && mysql_query("UPDATE ".$prefix."page SET ".$query." WHERE id=".$_POST['pid'])) //insert all text info
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Custom page information successfully updated.</p>';
                    else { 
                        echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while updating details!</p>';   
                    }
                }
				?>
                
            	<!--add new-->
                <div class="panel panel-default" id="addnew" style="display:none;">
                	<div class="panel-heading">
                    	<div class="panel-title"><i class="fa fa-plus fa-fw"></i> Add Policy Information</div>
                    </div>
                    <div class="panel-body">
                    	<form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                        	<div class="form-group">
                            	<label class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-10">
	                                <input type="text" class="form-control" name="title" placeholder="Enter Custom Page Title" required>
                                </div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-2 control-label">Content</label>
                                <div class="col-sm-10">
	                                <textarea class="form-control" id="cont" rows="5" name="content" placeholder="Enter Content" required></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Status</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="status">
                                        <option selected value="1">Active</option>
                                        <option value="0">Deactive</option>
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
                    	<div class="panel-title"><i class="fa fa-list fa-fw"></i>Policy Information List <button onClick="$('#addnew').show('slow')" class="btn btn-sm btn-primary pull-right">Add Record</button></div>
                    </div>
                    <div class="panel-body">
                    	<table id="Page_list" class="table table-hover table-bordered table-condensed" cellspacing="0" width="100%">
                        	<thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Frontend Link</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
							<tbody>
                            	<?php
								$select=mysql_query("SELECT * FROM ".$prefix."page");
								while($row=mysql_fetch_object($select)){
								?>
                                <tr>
                                	<td><?=$row->title?></td>
                                    <td><a href="<?=$siteurl?>/inner.php?id=<?=$row->id?>" target="_blank"><?=$siteurl?>/inner.php?id=<?=$row->id?></a></td>
                                    <td><i class="fa fa-<?=$row->status==0? 'close':'check'?> fa-fw"></i></td>
                                    <td>
                                        <button class="btn btn-default btn-sm" onClick="getCustomPage(<?=$row->id?>)"><i class="fa fa-eye fa-fw"></i>/<i class="fa fa-pencil fa-fw"></i></button>
                                        <?php if($row->id > 10){?>
                                        <a class="btn btn-danger btn-sm" href="custom-page.php?del=<?=$row->id?>"><i class="fa fa-trash fa-fw"></i></a>
                                        <?php }?>
                                    </td>
								</tr>
                                <?php }?>
                            </tbody>
						</table>
                    </div>
                </div>
                
                <div class="modal fade" tabindex="-1" role="dialog">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">View / Edit Policy Information</h4>
                        </div>
                        <div class="modal-body clearfix">
                            
                            <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                                <input type="hidden" id="pid" name="pid" required>
                                <div class="row">
                                    
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Custom Page Title" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Status</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="status" id="status">
                                                    <option value="1">Active</option>
                                                    <option value="0">Deactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Content</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" rows="5" id="content" name="content" placeholder="Enter Content" required></textarea>
                                            </div>
                                        </div>
                                        <hr>
                                        <input type="submit" name="usubmit" class="btn btn-success pull-right" value="Save">
                                    </div>
                                </div>
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
CKEDITOR.replace( 'cont' );
CKEDITOR.replace( 'content' );
$('#Page_list').DataTable( {
	"columnDefs": [
	{"searchable": false,"orderable": false,"targets": 3} ],
	"order": [[ 0, 'asc' ]]
});
function getCustomPage(id){
    $.ajax({
        type: 'post',
        url:'ajax/getCustomPage.php',
        data:{'id':id},
        success:function(data){
            data = JSON.parse(data);
            $('#pid').val(id);
            $('#title').val(data[0]['title']);
            CKEDITOR.instances['content'].setData(data[0]['content']);
            
            $('#status').val(data[0]['status']);
            $('.modal').modal('show');
        }
    })
}
</script>
</body>
</html>