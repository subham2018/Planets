<?php include_once 'include/head.php';?>
<!doctype html>
<html>
<head>
<?php include_once 'include/header.php';?>
<title><?=$site->site_title?> Admin Panel</title>
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
<style type="text/css">
	.box{
		background-color: white;
		border-radius: 5px;
		box-shadow: 0px 0px 10px rgba(0,0,0,.1);
		padding: 15px 5px;
		margin-bottom: 15px;
		transition: .5s;
            text-decoration: none !important;
            display: block;
	}
	.box:hover{
		transform: scale(1.05);
	}

      .circle{
            border-radius: 50%;
            width: 50px;
            height:50px;
            padding-top: 7px;
            font-size: 25px;
            margin-top: 7px;
      }
      .widget p{font-size: 30px; margin-bottom: 0px;}
      .list-cont{max-height: 200px;}
      .list-items{
            padding: 10px 2px;
            border-bottom:thin solid #f4f4f4;
            font-size: 16px;
            display: block;
            color: #000;
            text-decoration: none !important;
            transition: .3s;
      }
      .list-items>.close{font-size: 14px;margin-top: 2px;}
      .list-items:hover{padding-left: 8px;}
      .list-items>span{width: calc(inherit - 2px);}
      .list-items>span>i{color: #ccc}
      .list-items:last-child{border:none;}

      .btn-purple{background-color: #9b59b6;border-color: #8e44ad; color:#fff !important;}
      .btn-purple:hover,.btn-purple:focus{background-color: #8e44ad;}

</style>
</head>

<body>
<?php include_once 'include/navbar.php';?>	
        <div class="content">
        	<div class="overlay"></div><!--for mobile view sidebar closing-->
        	<!--title and breadcrumb-->
            <div class="top">
            	<p class="page-title">Dashboard</p>
                <ol class="breadcrumb">
                    <li><a href="index.php">Admin Panel</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </div>
            <!--main content start-->
             <div class="main-body">
                  
                  <div class="row">
                        <div class="col-sm-4">
                              <div class="panel panel-default widget">
                                    <div class="panel-body">
                                          <div class="row">
                                                <div class="col-xs-3">
                                                      <a class="btn btn-info circle" href="analytics.php"><i class="fa fa-eye"></i></a>
                                                </div>
                                                <div class="col-xs-6">
                                                      <p><?=$site->view?></p>
                                                      <small>Total Page View</small>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>
                        <div class="col-sm-4">
                              <div class="panel panel-default widget">
                                    <div class="panel-body">
                                          <div class="row">
                                                <div class="col-xs-3">
                                                      <a class="btn btn-danger circle" href="manage_product.php"><i class="fa fa-pencil"></i></a>
                                                </div>
                                                <div class="col-xs-6">
                                                      <p>0</p>
                                                      <small class="text-muted">Total Review</small>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>
                        <div class="col-sm-4">
                              <div class="panel panel-default widget ">
                                    <div class="panel-body">
                                          <div class="row">
                                                <div class="col-xs-3">
                                                      <a class="btn btn-warning circle" href="user.php"><i class="fa fa-user"></i></a>
                                                </div>
                                                <div class="col-xs-6">
                                                      <p><?=mysql_num_rows(mysql_query("SELECT * FROM ".$prefix."user WHERE `status`='1'"))?></p>
                                                      <small class="text-muted">Total User</small>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>
                        <div class="col-sm-4">
                              <div class="panel panel-default widget">
                                    <div class="panel-body">
                                          <div class="row">
                                                <div class="col-xs-3">
                                                      <a class="btn btn-success circle" href="contact-query.php"><i class="fa fa-phone"></i></a>
                                                </div>
                                                <div class="col-xs-6">
                                                      <p><?=mysql_num_rows(mysql_query("SELECT * FROM ".$prefix."contact"))?></p>
                                                      <small class="text-muted">Total Contact Query</small>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>
                        <div class="col-sm-4">
                              <div class="panel panel-default widget">
                                    <div class="panel-body">
                                          <div class="row">
                                                <div class="col-xs-3">
                                                      <a class="btn btn-purple circle" href="offer-query.php"><i class="fa fa-bolt"></i></a>
                                                </div>
                                                <div class="col-xs-6">
                                                      <p>0</p>
                                                      <small class="text-muted">Total Offer Query</small>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>
                        <div class="col-sm-4">
                              <div class="panel panel-default widget">
                                    <div class="panel-body">
                                          <div class="row">
                                                <div class="col-xs-3">
                                                      <a class="btn btn-primary circle" href="job_app.php"><i class="fa fa-black-tie"></i></a>
                                                </div>
                                                <div class="col-xs-6">
                                                      <p>0</p>
                                                      <small class="text-muted">Total Job Application</small>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
<!-- 
                  <div class="row">
                        <div class="col-sm-4">
                              <div class="panel panel-default">
                                    <div class="panel-body">      
                                          <h4 style="margin-top:8px; margin-bottom:0"><i class="fa fa-cubes fa-fw"></i> MOST VIEWED <strong>PRODUCTS</strong></h4>
                                          <hr style="margin-bottom:0">
                                          <div class="list-cont">
                                                <?php $s=mysql_query("SELECT * FROM ".$prefix."product WHERE `status`='1' ORDER BY `view` DESC LIMIT 10");
                                                while($r=mysql_fetch_object($s)){
                                                ?>
                                                <a class="list-items" href="../product.php?id=<?=$r->id?>" target="_blank"><span><i class="fa fa-navicon fa-fw"></i> <?=$r->title?></span> <small class="close"><i class="fa fa-eye fa-fw"></i><?=$r->view?></small></a>
                                                <?php }?>
                                          </div>
                                    </div>
                              </div>
                        </div>
                        <div class="col-sm-4">
                              <div class="panel panel-default">
                                    <div class="panel-body">      
                                          <h4 style="margin-top:8px; margin-bottom:0"><i class="fa fa-sitemap fa-fw"></i> MOST VIEWED <strong>CATEGORIES</strong></h4>
                                          <hr style="margin-bottom:0">
                                          <div class="list-cont">
                                                <?php $s=mysql_query("SELECT SUM(`view`) as 'tcview',`cat_id` FROM ".$prefix."product WHERE `status`='1' GROUP BY `cat_id` ORDER BY `tcview` DESC LIMIT 10");
                                                while($r=mysql_fetch_object($s)){
                                                ?>
                                                <a class="list-items" href="../listing.php?cat[]=<?=$r->cat_id?>" target="_blank"><span><i class="fa fa-navicon fa-fw"></i> <?=anything('manage_category','name',$r->cat_id)?></span> <small class="close"><i class="fa fa-eye fa-fw"></i><?=$r->tcview?></small></a>
                                                <?php }?>
                                          </div>
                                    </div>
                              </div>
                        </div>
                        <div class="col-sm-4">
                              <div class="panel panel-default">
                                    <div class="panel-body">      
                                          <h4 style="margin-top:8px; margin-bottom:0"><i class="fa fa-star fa-fw"></i> MOST VIEWED <strong>BRANDS</strong></h4>
                                          <hr style="margin-bottom:0">
                                          <div class="list-cont">
                                                <?php $s=mysql_query("SELECT SUM(`view`) as 'tcview',`cat_id` FROM ".$prefix."product WHERE `status`='1' GROUP BY `cat_id` ORDER BY `tcview` DESC LIMIT 10");
                                                while($r=mysql_fetch_object($s)){
                                                ?>
                                                <a class="list-items" href="../listing.php?cat[]=<?=$r->cat_id?>" target="_blank"><span><i class="fa fa-navicon fa-fw"></i> <?=anything('manage_category','name',$r->cat_id)?></span> <small class="close"><i class="fa fa-eye fa-fw"></i><?=$r->tcview?></small></a>
                                                <?php }?>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
 -->
                  <div class="panel panel-default">
                        <div class="panel-body">      
                              <h4 style="margin-top:8px; margin-bottom:0"><i class="fa fa-link fa-fw"></i> QUICK <strong>LINKS</strong></h4>
                              <hr>
                              <div class="row">
                                    <div class="col-sm-3 text-center">
                                          <a class="btn btn-default box" href="user.php" target="_blank"><i class="fa fa-users fa-fw"></i> <span>Manage Users</span></a>
                                    </div>
                                    <div class="col-sm-3 text-center">
                                          <a class="btn btn-default box" href="manage_category.php" target="_blank"><i class="fa fa-sitemap fa-fw"></i> <span> Manage Categories</span></a>
                                    </div>
                                    <div class="col-sm-3 text-center">
                                          <a class="btn btn-default box" href="manage_product.php" target="_blank"><i class="fa fa-cubes fa-fw"></i> <span> Manage Products</span></a>
                                    </div>
                                    <div class="col-sm-3 text-center">
                                          <a class="btn btn-default box" href="manage_brand.php" target="_blank"><i class="fa fa-star fa-fw"></i> <span> Manage Brand</span></a>
                                    </div>
                              </div>
                        </div>
                  </div>
            	
                  <div class="panel panel-default">
                        <div class="panel-body">      
                              <h4 style="margin-top:8px; margin-bottom:0"><i class="fa fa-rss fa-fw"></i> MOST VIEWED <strong>ARTICLES</strong></h4>
                              <hr>
                        	<div class="row">
            	            	<?php 
            					$newsQuery = mysql_query("SELECT `title`,`id`,`image` FROM ".$prefix."blog_manage_article WHERE `status`='Y' ORDER BY `view` DESC LIMIT 4");
            					while($news=mysql_fetch_object($newsQuery)){
            					?>
                        		<div class="col-sm-3 text-center">
                        			<a class="box" target="_blank" href="<?=$site->base.'/articles.php?id='.$news->id?>">
                        				<div>
                  						<img src="<?=UPLOAD_IMG_PATH.$news->image?>" style="width: 100%;">
                                                      <br><br>
                  						<div style="overflow-wrap: break-word;">
                  							<p><?=$news->title?></p>
                  						</div>
                  					</div>
                        			</a>
                        		</div>
                        		<?php } ?>
                        	</div>
                        </div>
                  </div>
				
				
            	<!--<h1 class="text-center">Under Construction</h1>-->
            </div>
            <!--main content end-->
        </div>
<?php include_once 'include/footer.php';?>
<script src="assets/plugins/malihu-custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="assets/js/common.js"></script>
<script type="text/javascript">
      $(".list-cont").mCustomScrollbar({
            axis:"y",
            theme: "minimal-dark",
            scrollInertia: 100
      });
</script>

</body>
</html>