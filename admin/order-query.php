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
            	<p class="page-title"><i class="fa fa-question-circle fa-fw"></i> Product Enquiry</p>
                <ol class="breadcrumb">
					<li><a href="index.php">Dashboard</a></li>
                    <li class="active">Product Enquiry</li>
                </ol>
            </div>
            <!--main content start-->
            <div class="main-body">
            	<?php

				if(isset($_GET['del'])){
                    //delete Training Reg
					if(mysql_query("DELETE FROM ".$prefix."pro_query WHERE id=".variable_check($_GET['del']))) //delete info
						echo '<p class="alert alert-success"><i class="fa fa-check fa-fw"></i> Contact Information Succesfully Deleted.</p>';
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
                                    <th>Enquiry Time</th>
                                    <th>Products Name</th>
                                    <th>Quantity</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Content</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
							<tbody>
                            	<?php
								$select=mysql_query("SELECT * FROM ".$prefix."pro_query");
								while($row=mysql_fetch_object($select)){
								?>
                                <tr>
                                    <td><?=date("F d, Y h:i:s A",strtotime($row->datetime))?></td>
                                	<td><?=$row->product_name?></td>
                                    <td><?=$row->qty?></td>
                                    <td><?=$row->name?></td>
                                    <td><?=$row->email?></td>
                                    <td><?=$row->phone?></td>
                                    <td><?=$row->content?></td>
                                    <td>
                                        <button class="btn btn-default btn-sm" onClick="getQuery(<?=$row->id?>)"><i class="fa fa-eye fa-fw"></i></button>
                                        <a class="btn btn-danger btn-sm" href="?del=<?=$row->id?>"><i class="fa fa-trash fa-fw"></i></a>
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
                            <h4 class="modal-title">View Information</h4>
                        </div>
                        <div class="modal-body clearfix">
                            <div class="form-group">
                                <label>Products:</label>
                                <div class="form-control" id="pro"></div>
                            </div>
                            <div class="form-group">
                                <label>Quantity:</label>
                                <div class="form-control" id="qty"></div>
                            </div>
                            <div class="form-group">
                                <label>Name:</label>
                                <div class="form-control" id="name"></div>
                            </div>
                            <div class="form-group">
                                <label>Email:</label>
                                <div class="form-control" id="email"></div>
                            </div>
                            <div class="form-group">
                                <label>Phone:</label>
                                <div class="form-control" id="phone"></div>
                            </div>
                            <div class="form-group">
                                <label>Message:</label>
                                <div class="form-control" id="content"></div>
                            </div>
                            <div class="form-group">
                                <label>Date & Time:</label>
                                <div class="form-control" id="date"></div>
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
$('#query_list').DataTable( {
	"columnDefs": [
	{"searchable": true,"orderable": true,"targets": 4} ],
	"order": [[ 0, 'asc' ]]
});
function getQuery(id){
    $.ajax({
        type: 'post',
        url:'ajax/getpQuery.php',
        data:{'id':id},
        success:function(data){
            data=JSON.parse(data);
            $('#name').text(data[0]['name']);
            $('#email').text(data[0]['email']);
            $('#phone').text(data[0]['phone']);
            $('#pro').text(data[0]['pro']);
            $('#qty').text(data[0]['qty']);
            $('#date').text(data[0]['date']);
			$('#content').text(data[0]['content']);
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