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
                <p class="page-title"><i class="fa fa-info-circle fa-fw"></i> History and Profile</p>
                <ol class="breadcrumb">
                    <li><a href="index.php">Dashboard</a></li>
                    <li>About</li>
                    <li class="active">History and Profile</li>
                </ol>
            </div>
            <!--main content start-->
            <div class="main-body">
                 <?php
                    if(isset($_POST['usubmit'])){
                        check_all_var(); //prevent mysql injection              
                       
                        
                        $query='';
                        foreach($_POST as $key=>$value) if($key != 'usubmit')if($key != "bid")if($key != 'qa')$query .="`$key`='$value',";
                        $query = substr($query, 0, -1);//omit last comma

                        if(mysql_query("UPDATE ".$prefix."history SET ".$query)) //insert all text info
                            echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> History and Prifile information updated successfully.</p>';
                        else { 
                            echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There is an error while updating details!</p>';   
                        }
                    }
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="fa fa-pencil fa-fw"></i> Edit History and Profile</div>
                    </div>
                    <div class="panel-body">

                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10">
                                    <TEXTAREA type="text" class="form-control" name="description" id="description" maxlength="255" placeholder="Enter short description " required><?=anything('history','description',1)?></TEXTAREA>
                                </div>
                            </div>                                    
                            <hr>
                            <input type="submit" name="usubmit" class="btn btn-success pull-right" value="Update">
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
