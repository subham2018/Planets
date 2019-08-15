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
                <p class="page-title"><i class="fa fa-cubes"></i> Notice Board</p>
                <ol class="breadcrumb">
                   <li><a href="index.php">Admin panel</a></li>
                    
                     <li class="active">Notice Board</li>
                </ol>
            </div>

            <div class="main-body">
                        <?php
                //Category save
                if(isset($_POST['submit'])){
                    check_all_var(); //prevent mysql injection              
                    //generate query from post
                    $query='';
                    foreach($_POST as $key=>$value) if($key != "submit") $query .="`$key`='$value',";
                    $query = substr($query, 0, -1);//omit last comma
                    
                    if(mysqli_query($link,"INSERT INTO ".$prefix."notice SET ".$query)) //insert all text info
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Notice Board Added successfully.</p>';
                    else { 
                        
                        echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while adding details!</p>';   
                    }
                }
                    
                
                if(isset($_POST['usubmit'])){
                    check_all_var(); //prevent mysql injection              
                    //generate query from post
                    $query='';
                    foreach($_POST as $key=>$value) if($key != "usubmit")if($key != "bid") $query .="`$key`='$value',";
                    $query = substr($query, 0, -1);//omit last comma
                    
                    if(mysqli_query($link,"UPDATE ".$prefix."notice SET ".$query."WHERE id='".$_POST['bid']."'")) //insert all text info
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i>Article Category Updated successfully.</p>';
                    else { 
                        
                        echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while adding details!</p>';   
                    }
                }

                if(isset($_GET['del'])){
                   
                    //delete Blog Category Page
                    if(mysqli_query($link,"DELETE FROM ".$prefix."notice WHERE id=".variable_check($_GET['del']))){ //delete info
                        
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Notice Board successfully deleted.</p>';
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
                                <label class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title"  placeholder="Enter Notice title" required>
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
                        <div class="panel-title"><i class="fa fa-list fa-fw"></i> Notice List <button onClick="$('#addnew').show('slow')" class="btn btn-sm btn-primary pull-right">Add New</button></div>
                    </div>
                    <div class="panel-body">
                        <table id="Service_list" class="table table-hover table-bordered table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Title</th>                                   
                                    
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $select=mysqli_query($link,"SELECT * FROM ".$prefix."notice");
                                while($row=mysqli_fetch_object($select)){
                                ?>
                                <tr>
                                    <td><?=$row->title?></td>                                     
                                    
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
                           
                                <div class="col-sm-8">
                            <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                                <input type="hidden" id="bid" name="bid" required>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="title" name="title"  placeholder="Enter product title" required>
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

$('#Service_list').DataTable( {
    "columnDefs": [
    {"searchable": false,"orderable": false,"targets": 2} ],
    "order": [[ 0, 'asc' ]]
});
function getCategory(id){
    $.ajax({
        type: 'post',
        url:'ajax/getProductcat.php',
        data:{'id':id},
        success:function(data){
            data = JSON.parse(data);
            $('#bid').val(id);
            $('#title').val(data[0]['title']);      
            
            
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
