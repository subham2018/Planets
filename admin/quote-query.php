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
            	<p class="page-title"><i class="fa fa-question-circle fa-fw"></i> Quote Enquiry</p>
                <ol class="breadcrumb">
					<li><a href="index.php">Dashboard</a></li>
                    <li class="active">Quote Enquiry</li>
                </ol>
            </div>
            <!--main content start-->
            <div class="main-body">
            	<?php

				if(isset($_GET['del'])){
                    //delete Training Reg
					if(mysql_query("DELETE FROM ".$prefix."quote_query WHERE id=".variable_check($_GET['del']))) //delete info
						echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Quote Information Succesfully Deleted.</p>';
					else echo '<p class="alert alert-danger"><i class="fa fa-warning fa-fw"></i> Sorry! There Is An Error While Deleting Contact Information!</p>';
				}
				?>
                
                <!--list-->
            	<div class="panel panel-default">
                	<div class="panel-heading">
                    	<div class="panel-title"><i class="fa fa-list fa-fw"></i> Enquiry List</div>
                    </div>
                    <div class="panel-body">
                    	<table id="query_list" class="table table-hover table-bordered table-condensed" cellspacing="0" width="100%">
                        	<thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
							<tbody>
                            	<?php
								$select=mysql_query("SELECT * FROM ".$prefix."quote_query");
								while($row=mysql_fetch_object($select)){
                                   
								?>
                                <tr>
                                	<td><?=$row->name?></td>
                                    <td><?=$row->email?></td>
                                    <td><?=$row->phone?></td>
                                    <td><?=$row->message?></td>
                                    <td>
                                       
                                        <a class="btn btn-danger btn-sm" href="?del=<?=$row->id?>"><i class="fa fa-trash fa-fw"></i></a>
                                    </td>
								</tr>
                                <?php }?>
                            </tbody>
						</table>
                    </div>
                </div>
                
              
            </div>
            <!--main content end-->
        </div>
<?php include_once 'include/footer.php';?>
<script src="assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/js/common.js"></script>
<script type="text/javascript">
$('#query_list').DataTable( {
	"columnDefs": [
	{"searchable": true,"orderable": true,"targets": 4} ],
	"order": [[ 0, 'asc' ]]
});

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