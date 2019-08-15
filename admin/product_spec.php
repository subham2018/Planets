<?php include_once 'include/head.php';?>
<!doctype html>
<html>
<head>
<?php include_once 'include/header.php';?>
<title><?=$site->site_title?> Admin Panel</title>
<link rel="stylesheet" type="text/css" href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?=$siteurl?>/admin/assets/css/style.css">
<style type="text/css">
    .tab-pane{
        padding:10px;
        border:thin solid #ddd;
        border-top:none;
        overflow-y: auto;
        overflow-x: hidden;
    }
</style>
</head>

<body>
<?php include_once 'include/navbar.php';?>  
        <div class="content">
            <div class="overlay"></div><!--for mobile view sidebar closing-->
            <!--title and breadcrumb-->
            <div class="top">
                <p class="page-title"><i class="fa fa-qrcode fa-fw"></i> Specification</p>
                <ol class="breadcrumb">
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="product.php">Product</a></li>
                    <li class="active">Specification</li>
                </ol>
            </div>
            <!--main content start-->
            <div class="main-body">
                <?php
                //Projects Save
            if(isset($_POST['submit'])){
               check_all_var(); //prevent mysql injection              
                    //generate query from post
                    $query='';
                    foreach($_POST as $key=>$value) if($key != "submit") $query .="`$key`='$value',";
                    $query = substr($query, 0, -1);//omit last comma
                    
                    if(mysql_query("INSERT INTO ".$prefix."product_spec SET ".$query)) //insert all text info
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Specification successfully added.</p>';
                    else { 
                        
                        echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while inserting news product information record!</p>';   
                    }
                }
                if(isset($_POST['usubmit'])){
                    check_all_var(); //prevent mysql injection              
                    //generate query from post
                    $query='';
                    foreach($_POST as $key=>$value) if($key != "usubmit")if($key != "bid") $query .="`$key`='$value',";
                    $query = substr($query, 0, -1);//omit last comma
                    
                    if(mysql_query("UPDATE ".$prefix."product_spec SET ".$query."WHERE id='".$_POST['bid']."'")) //insert all text info
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i>Specification successfully updated.</p>';
                    else { 
                        
                        echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while updating news product information record!</p>';   
                    }
                }
                if(isset($_GET['del'])){
                    //delete Blog product Page
                    if(mysql_query("DELETE FROM ".$prefix."vendor_spec WHERE id=".variable_check($_GET['del']))){ //delete info
                        echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Specification successfully deleted.</p>';
                    }
                    else echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while deleting news product information record!</p>';
                }
             ?>
                
                <!--add new-->
                <div class="panel panel-default" id="addnew" style="display:none;">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="fa fa-plus fa-fw"></i> Add New </div>
                    </div>
                    <div class="panel-body">
                        <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                            
                            <input type="hidden" required name="product_id" value="<?=$_GET['id']?>">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Specification Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="spectitle" maxlength="256" placeholder="Enter specification title" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Specification Value</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="specvalue" maxlength="256" placeholder="Enter specification value" required>
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
                        <div class="panel-title"><i class="fa fa-list fa-fw"></i> Specification List <button onClick="$('#addnew').show('slow')" class="btn btn-sm btn-primary pull-right">Add Record</button></div>
                    </div>
                    <div class="panel-body">
                        <table id="Projects_list" class="table table-hover table-bordered table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Value</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $select=mysql_query("SELECT * FROM ".$prefix."product_spec WHERE `product_id`='".$_GET['id']."'");
                                while($row=mysql_fetch_object($select)){
                                ?>
                                <tr>
                                    <td><?=$row->spectitle?></td>
                                    <td><?=$row->specvalue?></td>
                                    <td>
                                        <button class="btn btn-default btn-sm" onClick="getSpec(<?=$row->id?>)"><i class="fa fa-eye fa-fw"></i>/<i class="fa fa-pencil fa-fw"></i></button>
                                       
                                       
                                        <a class="btn btn-danger btn-sm" href="spec.php?id=<?=$_GET['id']?>&del=<?=$row->id?>"><i class="fa fa-trash fa-fw"></i></a>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="modal fade" tabindex="-1" role="dialog">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">View / Edit Specification</h4>
                        </div>
                        <div class="modal-body clearfix">
                            <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                                <input type="hidden" id="pid" name="bid" >
                                        <input type="hidden" required name="product_id" value="<?=$_GET['id']?>">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Specification Title</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="spectitle" id="spectitle" maxlength="256" placeholder="Enter specification title" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Specification Value</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="specvalue" id="specvalue" maxlength="256" placeholder="Enter specification value" required>
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
<script src="<?=$siteurl?>/admin/assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?=$siteurl?>/admin/assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<!-- <script src="<?=$siteurl?>/admin/assets/plugins/ckeditor/ckeditor.js"></script> -->
<script src="<?=$siteurl?>/admin/assets/js/common.js"></script>
<script type="text/javascript">

$('#Projects_list').DataTable( {
    "columnDefs": [
    {"searchable": false,"orderable": false,"targets": 2} ],
    "order": [[ 0, 'asc' ]]
});
function getSpec(id){
    $.ajax({
        type: 'post',
        url:'ajax/getSpec.php',
        data:{'id':id},
        success:function(data){
            data = JSON.parse(data);
            $('#pid').val(id);
            $('#product_id').val(data[0]['product_id']);
            $('#spectitle').val(data[0]['spectitle']);
            $('#specvalue').val(data[0]['specvalue']);
            $('.modal').modal('show');
        }
    })
}
</script>
<?php if(isset($_GET['del'])){?>
<div id="url_replace">
    <script type="text/javascript">
        $(document).ready(function(e) {
            window.history.replaceState(null, null, '<?=$page.'?id='.$_GET['id']?>');
            $('#url_replace').remove();
        });
    </script>
</div>
<?php }?>
</body>
</html>