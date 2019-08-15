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
                <p class="page-title"><i class="fa fa-image fa-fw"></i> Video Gallery</p>
                <ol class="breadcrumb">
                    <li><a href="index.php">Dashboard</a></li>
                    <li class="active"> Video Gallery</li>
                </ol>
            </div>
            <!--main content start-->
            <div class="main-body">
                <?php
                    if(isset($_POST['submit'])){
                    check_all_var(); //prevent mysql injection              
                    //check and insert banner
                      $query='';
                    foreach($_POST as $key=>$value) if($key != 'submit')$query .="`$key`='$value',";
                    $query = substr($query, 0, -1);//omit last comma

                    if(!isset($error)&& mysql_query("INSERT INTO ".$prefix."video SET ".$query)){//insert all text info
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Video Gallery Inserted successfully.</p>';
                    }
                   
                }

                //Project edit
                if(isset($_POST['usubmit'])){
                    check_all_var(); //prevent mysql injection              
                    //check and update Technology
                 
                    
                    $query='';
                    foreach($_POST as $key=>$value) if($key != 'usubmit')if($key != "bid")$query .="`$key`='$value',";
                    $query = substr($query, 0, -1);//omit last comma

                    if(!isset($error)&& mysql_query("UPDATE ".$prefix."video SET ".$query." WHERE id=".$_POST['bid'])){//insert all text info
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Video Gallery Updated successfully.</p>';
                    }
                    // else { 
                    //     echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while updating details!</p>';   
                    // }
                }
                
                
                    //delete Projects

                    if(isset($_GET['del'])){
                    
                    
                    if(mysql_query("DELETE FROM ".$prefix."video WHERE id=".variable_check($_GET['del']))){ //delete info
                      
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Video Gallery Deleted successfully.</p>';
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
                                    <label class="col-sm-2 control-label">URL</label>
                                    <div class="col-sm-10">
                                        <input type="url" class="form-control" name="url" maxlength="256" placeholder="Enter URL" required>
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
                        <div class="panel-title"><i class="fa fa-list fa-fw"></i> Video Gallery List <button onClick="$('#addnew').show('slow')" class="btn btn-sm btn-primary pull-right">Add New</button></div>
                    </div>
                    <div class="panel-body">
                        <table id="gallery_list" class="table table-hover table-bordered table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    
                                    <th>URL</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $select=mysql_query("SELECT * FROM ".$prefix."video");
                                while($row=mysql_fetch_object($select)){
                                ?>
                                <tr>
                                    
                                    <td><?=$row->url?></td>                                   
                                   
                                    <td>
                                        <button class="btn btn-default btn-sm" onClick="getGalleryv(<?=$row->id?>)"><i class="fa fa-eye fa-fw"></i>/<i class="fa fa-pencil fa-fw"></i></button>
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
                            <h4 class="modal-title">View / Edit Gallery Video</h4>
                        </div>
                        <div class="modal-body clearfix">
                            <form method="post" name="#">
                           <div class="row">
                                 <div class="form-group">
                                    <label class="col-sm-2 control-label">URL</label>
                                    <div class="col-sm-10">
                                        <input type="url" class="form-control" id="url" name="url" maxlength="256" placeholder="Enter URL" required>
                                         <input type="hidden" id="bid" name="bid">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                   
                                    <div class="col-sm-12">
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
<script src="assets/js/common.js"></script>
<script type="text/javascript">
$('#gallery_list').DataTable( {
    "columnDefs": [
    {"searchable": false,"orderable": false,"targets": 1}],
    "order": [[ 0, 'asc' ]]
});
function getGalleryv(id){
    $.ajax({
        type: 'post',
        url:'ajax/getGalleryv.php',
        data:{'id':id},
        success:function(data){
            data = JSON.parse(data);
            $('#bid').val(id);          
           $('#url').val(data[0]['url']);  
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
