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
                    	
                    	<div class="panel panel-default">
                          <div class="panel-body">
                          	<?php
                                if(isset($_POST['forgot'])){
                                    
                                    if(mysql_num_rows(mysql_query("SELECT `id` FROM ".$prefix."admin WHERE `email`='".$_POST['email']."'")) == 1){
                                        $hh = md5(time().date('Y,m,f'));
                                        mysql_query("UPDATE ".$prefix."host SET `fhash`='$hh' WHERE `email`='".$_POST['email']."'");
                                        
                                        $to1=$_POST['email'];
                                        $subject1='Password Reset Request';
                                        $message1='<html><body><p><strong>Password Reset Request</strong></p>';
                                        $message1 .= '<br><br><p>Click on the following link to reset password. If you did not request a new password then ignore this.</p>';
                                        $message1 .= '<p><a href="'.$site->base.'/reset.php?ch='.$hh.'">Reset Password</a></p>';
                                        $message1 .= '<br><br><h6 style="color:#888888">This is a system generated email, do not reply to this email id.</h6>';
                                        $message1 .= '</body></html>';
                                        $headers1 = 'From: venerate exports <noreply@venerateexports.com>' . "\r\n";
                                        $headers1 .= "MIME-Version: 1.0" . "\r\n";
                                        $headers1 .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                        if(mail($to1,$subject1,$message1,$headers1)){
                                            $error=0;
                                            echo '<div class="alert alert-success" role="alert">
                                                      <strong>Thank you!</strong>Check your email address in order to continue the reset procedure.
                                                  </div>';
                                        }
                                            
                                        else echo '<p class="lead text-danger"><i class="fa fa-warning fa-fw"></i> Sorry! Unable to send email. Try again.</p>';
                                        
                                    }else echo '<p class="lead text-danger"><i class="fa fa-warning fa-fw"></i> You are not registered.</p>';
                                }
                                if(isset($error) == false){
                               ?>
                                <form action="" method="post">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="email" placeholder="Enter your email" required>
                                            <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                                        </div>
                                    </div>
                                   
                                    <div class="form-group">
                                        <input class="btn btn-primary btn-block" type="submit" value="Send Email" name="forgot">
                                    </div>
                                    
                                    
                                </form>
                                <?php }?>
                            
                          </div>
                        </div>
                        
                        <h6>&copy; <?=date('Y')?> &middot; <?=$site->site_title?>. All Rights Reserved.</h6>
                    </div>
                </div>
            </div>
        </div>
    <?php include_once 'include/footer.php';?>
    </body>
</html>