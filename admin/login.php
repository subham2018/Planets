<?php include_once 'include/head.php';?>
<!doctype html>
<html>
    <head>
		<?php include_once 'include/header.php';?>
        <title>Login | <?=$site->site_title?> Admin Panel</title>
        <link rel="stylesheet" type="text/css" href="assets/css/login.css">
    </head>

    <body>
        <div class="container">
        	<div class="login-cont">
            	<div class="row">
                	<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                    	
                    	<div class="panel panel-primary">
                          <div class="panel-body">
                          	<?php
							if(isset($_POST['aemail'],$_POST['apass'])){
								check_all_var();
								
								$sql="SELECT * FROM ".$prefix."admin WHERE email='".$_POST['aemail']."'";
		
								$result=mysqli_query($link,$sql);
								$c=mysqli_num_rows($result);
								$row=mysqli_fetch_object($result);
								
								if ($c == 1 && $row->status == '1' && $row->password==md5($_POST['apass']))
								{	
									$_SESSION['admin_id']=$row->id;
									$_SESSION['login_string']=hash('sha512', $row->password . $_SERVER['HTTP_USER_AGENT']);
									header("location: index.php");
								}
								elseif ($c == 1 && $row->status == '1' && $row->password!=md5($_POST['apass'])) echo '<p class="text-red"><i class="fa fa-warning fa-fw"></i> Email or Password mismatched!</p>';
								elseif($c == 1 && $row->status == '0') echo '<p class="text-red"><i class="fa fa-warning fa-fw"></i> Approval Pending!</p>';
								else echo '<p class="text-red"><i class="fa fa-warning fa-fw"></i> Email/Password Incorrect</p>';
							}

							?>
                            <img src="<?=UPLOAD_IMG_PATH.$site->logo?>">
                          	<form action="" method="post">
                            	<div class="form-group">
                                	<div class="input-group">
                                    	<input class="form-control" type="email" name="aemail" placeholder="Enter email" required>
                                        <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                	<div class="input-group">
                                    	<input class="form-control" type="password" name="apass" placeholder="Enter password" required>
                                        <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                	<input class="btn btn-primary btn-block" type="submit" value="Login">
                                </div>
                                <div class="form-group">
                                    <a href="forgot.php">Forgot Password?</a>
                                </div>
                            </form>
                          </div>
                        </div>
                        
                        <h6><font color="black">&copy; <?=date('Y')?> &middot; <?=$site->site_title?>. All Rights Reserved.</font></h6>
                    </div>
                </div>
            </div>
        </div>
    <?php include_once 'include/footer.php';?>
    </body>
</html>