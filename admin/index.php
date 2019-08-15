<?php include_once 'include/head.php';?>
<!doctype html>
<html>
<head>
<?php include_once 'include/header.php';?>
<title><?=$site->site_title?></title>
<link rel="stylesheet" type="text/css" href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css">
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
                    <li><a href="#">Admin panel</a></li>
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
                                                      <a class="btn btn-info circle"><i class="fa fa-cube"></i></a>
                                                </div>
                                                <div class="col-xs-6">
                                                      <p><?=count_rows('product','1','1')?></p>
                                                      <small>Total Product</small>
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
                                                      <a href="news.php" class="btn btn-danger circle" ><i class="fa fa-question"></i></a>
                                                </div>
                                                <div class="col-xs-6">
                                                      <p><?=count_rows('news','1','1')?></p>
                                                      <small class="text-muted">Total News & Events</small>
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
                                                      <a href="quote-query.php" class="btn btn-warning circle" ><i class="fa fa-tty"></i></a>
                                                </div>
                                                <div class="col-xs-6">
                                                      <p><?=count_rows('contact','1','1')?></p>
                                                      <small class="text-muted">Total Contact Query</small>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>
                        

                  <div class="panel panel-default">
                        <div class="panel-body">      
                              <h4 style="margin-top:8px; margin-bottom:0"><i class="fa fa-link fa-fw"></i> QUICK <strong>LINKS</strong></h4>
                              <hr>
                              <div class="row">
                                    <div class="col-sm-3 text-center">
                                          <a class="btn btn-default box" href="product.php" target="_blank"><i class="fa fa-cube fa-fw"></i> <span>Manage Products</span></a>
                                    </div>
                                    <div class="col-sm-3 text-center">
                                          <a class="btn btn-default box" href="news.php" target="_blank"><i class="fa fa-tags fa-fw"></i> <span> Manage News</span></a>
                                    </div>
                                    <div class="col-sm-3 text-center">
                                          <a class="btn btn-default box" href="gallery_image.php" target="_blank"><i class="fa fa-image fa-fw"></i> <span> Manage Work Environment</span></a>
                                    </div>
                                    <div class="col-sm-3 text-center">
                                          <a class="btn btn-default box" href="blog.php" target="_blank"><i class="fa fa-file-text-o fa-fw"></i> <span> Manage Articles</span></a>
                                    </div>
                              </div>
                        </div>
                  </div>
               
            </div>
            <!--main content end-->
        </div>
<?php include_once 'include/footer.php';?>
<script src="assets/plugins/malihu-custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="assets/js/common.js"></script>
<script src="assets/js/jscolor.min.js"></script>
</body>
</html>