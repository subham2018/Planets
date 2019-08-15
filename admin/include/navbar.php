<div class="topbar">
    <div class="logo"><a href="index.php"><img src="<?=UPLOAD_IMG_PATH.$site->logo?>" alt="..."></a></div>
    <button class="toggle-btn"><i class="fa fa-bars fa-fw"></i></button>
    <ul class="right-menu">
        
        <!-- <li><a href="#"><img src="assets/image/usr.png" alt="..."><?=$user->name?> <i class="fa fa-angle-down fa-fw"></i></a></li> -->
        <li><a href="logout.php"><i class="fa fa-power-off fa-lg fa-fw"></i> Logout</a></li>
    </ul>
</div>
<div class="main">
    <!--sidebar start-->
    <div class="sidebar">
        <div class="user-details">
            <p class="name clearfix">
                <span>Welcome</span>
                <span><?=$user->name?></span>
                    <br>
                        <small><a href="password.php" style="color:white">Change Password</a></small>
                    

            </p>
        </div>
        <span class="menu-divider">Menu Navigation</span>
        <ul class="menu-item">
            <li><a href="index.php"><i class="fa fa-dashboard fa-fw"></i><span>Dashboard</span></a></li> 

                <li class="has-sub">
                    <a href="#"><i class="fa fa-gears fa-fw"></i> <span>Home Settings</span></a>
                    <ul>
                        <li><a href="banner.php"><span>Manage Banners</span></a></li>
                        <li><a href="dsc.php"><span>Announcement</span></a></li>
                          
                        <li><a href="content.php"><span>Manage Home Contents</span></a></li>
                        <li><a href="testimonial.php"><span>Testimonial</span></a></li>

                    </ul>
                </li>

            <li class="has-sub">
                <a href="#"><i class="fa fa-info fa-fw"></i> <span>About Us</span></a>
                <ul>                     
                    <li><a href="about.php"><span>About Main Page</span></a></li>                    
                    
                </ul>
            </li>   

              <li class="has-sub">
                <a href="#"><i class="fa fa-question fa-fw"></i> <span>Enquiry</span></a>
                <ul>                     
                    <li><a href="membership-query.php"><span>Membership Enquiry</span></a></li> 
                    
                </ul>
            </li>   


            <li><a href="gallery_image.php"><i class="fa fa-image fa-fw"></i><span>Photo Gallery</span></a></li>
            <li><a href="notice.php"><i class="fa fa-image fa-fw"></i><span>Notice Board</span></a></li>
             <li><a href="forcast.php"><i class="fa fa-image fa-fw"></i><span>Project Forcast</span></a></li>
            
            <li><a href="news.php"><i class="fa fa-file-text-o fa-fw"></i><span>Manage News & Events</span></a></li>
            
           
            <li><a href="site-settings.php"><i class="fa fa-cogs fa-fw"></i> <span>Site Settings</span></a></li>
        </ul>
    </div>
    <!--sidebar end-->