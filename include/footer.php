<footer class="site-footer">
			<div class="top-footer">
				<div class="container">
					<div class="row">
						<div class="col-md-3 col-sm-4 col-xs-12 contact-info footer-widget">
							<h4 class="footer-widget-title">Contact Info</h4>
							
							<ul>
								<li><span>Phone:</span><a href="tel:<?=$site->contact?>"><?=$site->contact?></a></li>
								<li><span>Email:</span><a href="mailto:<?=$site->site_owner_email?>"><?=$site->site_owner_email?></a></li>
							</ul>
						</div> <!-- /.col-md-3 -->
						<div class="col-md-5 col-sm-8 col-xs-12 footer-widget">
							<h4 class="footer-widget-title">Stay in touch with us</h4>
							<a href="<?=$site->facebook?>"><img src="images/facebook.png" width="30px;" title="Connect with Facebook"></a>
						</div> <!-- /.col-md-5 -->
						<div class="col-md-4 col-sm-12 col-xs-12 footer-widget">
							<h4 class="footer-widget-title">More about US</h4>
							<p><?=htmlspecialchars_decode(anything('vission','description',1));?></p>
						</div> <!-- /.col-md-4 -->
					</div> <!-- /.row -->
				</div> <!-- /.container -->
			</div> <!-- /.top-footer -->
			<div class="main-footer">
				<div class="container">
					<div class="row">
						<div class="col-md-3 col-sm-6 footer-widget">
							<h4 class="footer-widget-title">Text Widget</h4>
							<p>Curabitur a orci et nulla gravida laoreet. Pellentesque dictum ipsum nec placerat dignissim. Vivamus porta pellentesque libeadro, sit amet non.</p>
						</div> <!-- /.col-md-3 -->
						<div class="col-md-3 col-sm-6 footer-widget">
							<h4 class="footer-widget-title">Popular Posts</h4>
							<ul>
								<li><a href="blog-single.html">The Importance of an MOU</a></li>
								<li><a href="blog-single.html">Detecting and learning from failure</a></li>
								<li><a href="blog-single.html">Limited Support on Memorial Day</a></li>
								<li><a href="blog-single.html">Fundraising Reading Round-Up</a></li>
								<li><a href="blog-single.html">Ugly Design or Beautiful Design?</a></li>
							</ul>
						</div> <!-- /.col-md-3 -->
						<div class="col-md-2 col-sm-6 footer-widget">
							<h4 class="footer-widget-title">Useful Links</h4>
							<ul>
								<li><a href="staff-sidebar.html">Meet the Team</a></li>
								<li><a href="blog-grid.html">Read Our Blog</a></li>
								<li><a href="#">Partnerships</a></li>
								<li><a href="#">Developer Tools</a></li>
							</ul>
						</div> <!-- /.col-md-2 -->
						<div class="col-md-4 col-sm-6 footer-widget">
							<h4 class="footer-widget-title">Our Gallery</h4>
							<div class="footer-gallery">

								<?php
                                $selec=mysqli_query($link,"SELECT * FROM ".$prefix."gallery LIMIT 3");
                                while($ro=mysqli_fetch_object($selec)){
                                ?>
								<div class="gallery-thumb">
									<a href="<?=UPLOAD_IMG_PATH.$ro->image?>" class="fancybox" data-fancybox-group="group1">
										<img src="<?=UPLOAD_IMG_PATH.$ro->image?>" alt="">
									</a>
								</div> <!-- /.gallery-thumb -->
								
								<?php } ?>
								
							</div> <!-- /.footer-gallery -->
						</div> <!-- /.col-md-4 -->
					</div> <!-- /.row -->
					<div class="copyright">
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<p class="small-text">Copyright Reserved <?=date('Y');?> &copy;. The Plannets Association</p>
							</div> <!-- /.col-md-6 -->
							<div class="col-md-6 col-sm-6">
								<div class="credits">
									<p class="small-text">Designed and Developed with <i class="fa fa-heart"></i> by <a href="http://soinit-ts.com">Soinit Technology Solutions Pvt. Ltd.</a></p>
								</div>
							</div> <!-- /.col-md-6 -->
						</div> <!-- /.row -->
					</div> <!-- /.copyright -->
				</div> <!-- /.container -->
			</div> <!-- /.main-footer -->
		</footer> <!-- /.site-footer -->
		<a href="#top" id="top-link" class="fa fa-angle-up"></a>
	
        <!-- JavaScripts -->
        <script src="js/bootstrap.min.js"></script>
        <script src="js/min/plugins.min.js"></script>
        <script src="js/min/custom.min.js"></script>
	