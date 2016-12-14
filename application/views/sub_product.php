<!doctype html>
<html class="no-js" lang="en-US">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Owlworx | Sub Category</title>
<!-- DEFAULT META TAGS -->

<!-- FONTS -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,800,600|Raleway:300,600,900' rel='stylesheet' type='text/css'>
<!-- FONTS -->

<!-- CSS -->
<link rel='stylesheet' id='default-style-css'  href='<?= base_url();?>assets/css/style.css' type='text/css' media='all' />
<link rel='stylesheet' id='flexslider-style-css'  href='<?= base_url();?>assets/css/flexslider.css' type='text/css' media='all' />
<link rel="stylesheet" id='fontawesome-style-css' href="<?= base_url();?>assets/css/font-awesome.min.css" type="text/css" media="all" />
<link rel='stylesheet' id='retina-style-css'  href='<?= base_url();?>assets/css/retina.css' type='text/css' media='all' />
<link rel='stylesheet' id='mqueries-style-css'  href='<?= base_url();?>assets/css/mqueries.css' type='text/css' media='all' />
<!-- CSS -->

<!-- FAVICON -->
<link rel="shortcut icon" href="<?= base_url();?>assets/uploads/favicon.png"/>
<!-- FAVICON -->

<!-- JQUERY LIBRARY & MODERNIZR -->
<script src="<?= base_url();?>assets/js/jquery-1.9.1.min.js"></script>
<script src='<?= base_url();?>assets/js/jquery.modernizr.min.js'></script>
<!-- JQUERY LIBRARY & MODERNIZR -->

</head>

<body> 

<!-- PAGELOADER -->
<div id="page-loader">
	<div class="page-loader-inner">
    	<div class="loader-logo"><img src="<?= base_url();?>assets/uploads/xone-logo.png" alt="Logo"/></div>
		<div class="loader-icon"><span class="spinner"></span><span></span></div>
	</div>
</div>
<!-- PAGELOADER -->

<!-- PAGE CONTENT -->
<div id="page-content" class="fixed-header">

	<!-- HEADER -->
	<header id="header">        
		<div class="header-inner wrapper clearfix">
                            
			<div id="logo" class="left-float">
				<a id="defaut-logo" class="logotype" href="index.html"><img src="<?= base_url();?>assets/uploads/xone-logo.png" alt="Logo"></a>
			</div>    
            
			<div class="menu right-float clearfix">
           	<nav id="main-nav">
            		<ul>
                  	<li><a href="index.html" class="scroll-to">Home</a></li>
                  	<li><a href="index.html#about" class="scroll-to">About</a></li>
                  	<li><a href="index.html#service" class="scroll-to">Service</a></li>
                  	<li class="current-menu-item"><a href="#portfolio" class="scroll-to">Portfolio</a></li>
                  	<li><a href="index.html#team" class="scroll-to">Team</a></li>
                  	<li><a href="blog.html">Blog</a></li>
                  	<li><a href="elements.html">Elements</a>
                    		<ul class="sub-menu">
                        		<li><a href="elements.html">General</a></li>    
                        		<li><a href="portfolio-layout.html">Portfolio Layout</a></li>    
                        	</ul>
                    	</li>
                  	<li><a href="index.html#contact" class="scroll-to">Contact</a></li>
					</ul>
				</nav>
              	<nav id="menu-controls">
            		<ul>
                  	<li><a href="index.html" class="scroll-to"><span class="c-dot"></span><span class="c-name">Home</span></a></li>
                  	<li><a href="index.html#about" class="scroll-to"><span class="c-dot"></span><span class="c-name">About</span></a></li>
                  	<li><a href="index.html#service" class="scroll-to"><span class="c-dot"></span><span class="c-name">Service</span></a></li>
                  	<li class="current-menu-item"><a href="#portfolio" class="scroll-to"><span class="c-dot"></span><span class="c-name">Portfolio</span></a></li>
                  	<li><a href="index.html#team" class="scroll-to"><span class="c-dot"></span><span class="c-name">Team</span></a></li>
                  	<li><a href="blog.html"><span class="c-dot"></span><span class="c-name">Blog</span></a></li>
                  	<li><a href="elements.html"><span class="c-dot"></span><span class="c-name">Elements</span></a></li>
                  	<li><a href="index.html#contact" class="scroll-to"><span class="c-dot"></span><span class="c-name">Contact</span></a></li>
					</ul>
				</nav>  
			</div>
                    
		</div> <!-- END .header-inner -->
	</header> <!-- END header -->
	<!-- HEADER -->    
    
	<!-- PAGEBODY -->
	<div class="page-body">
    
       	<!-- PORTFOLIO SECTION -->
	    <section id="portfolio">
			<div id="portfolio-single" class="section-inner">
			
				<div class="wrapper">
				<div class="section-title project-title">
				<?php foreach ($back_ideo_sol as $key => $value_back_ideo_sol):
					?>
					<h2 class="project-name"><?php echo $value_back_ideo_sol->title;?></h2>
					<ul class="single-pagination portfolio-pagination clearfix" style="display:none;">
						<li class="next"><a href="portfolio-single-sidebar.html" class="load-content">next</a></li>
						<li class="prev"><a href="portfolio-single-sidebar.html" class="load-content">prev</a></li>
					</ul>
				</div>
					 
					<ul class="socialmedia-widget social-share">
					 <?php if($value_back_ideo_sol->facebook!=''){ ?>
						<li class="facebook"><a target='_blank' href="<?php echo $value_back_ideo_sol->facebook;?>">Facebook</a></li>
						<?php } ?> 

					<?php if($value_back_ideo_sol->facebook!=''){ ?>
						<li class="twitter"><a target='_blank' href="<?php echo $value_back_ideo_sol->twitter;?>">Tweet</a></li>
						<?php } ?> 

					<?php if($value_back_ideo_sol->facebook!=''){ ?>
						<li class="googleplus"><a target='_blank' href="<?php echo $value_back_ideo_sol->google;?>">Google Plus</a></li>
						<?php } ?> 

					<?php if($value_back_ideo_sol->facebook!=''){ ?>
						<li class="pinterest"><a target='_blank' href="<?php echo $value_back_ideo_sol->pinterest;?>">Pinterest</a></li>
						<?php } ?>						
					</ul>
					
					<div class="entry-media portfolio-media">
					<div class="flexslider portfolio-slider">
						<ul class="slides">
						<?php 
						/*print_r($back_ideo_sol);
						print_r($sub_portfolio); */ ?>
							<?php foreach ($sub_portfolio as $value_sub_porfolio): ?>
							<li><img src="<?= base_url();?>assets/uploads/sub_portfolio/<?php echo $value_sub_porfolio->image;?>" alt="SEO IMAGE NAME"/></li>
						<?php endforeach; ?>
						</ul>
					</div>  
					</div>
					
					<div class="entry-content portfolio-content">
						<div class="column-row clearfix" style="margin-top:5%">						 
						 	<div class="column one-third">
								<h5><strong><?php echo $value_back_ideo_sol->back_header; ?></strong></h5>
								<div class="seperator style-solid size-full seperator-light height-small"><span></span></div>
							<p><?php echo $value_back_ideo_sol->background; ?></p>
							</div>
						   <?php if ($value_back_ideo_sol->idea_header!=''){ ?>
						    <div class="column one-third">
								<h5><strong><?php echo $value_back_ideo_sol->idea_header; ?></strong></h5>
								<div class="seperator style-solid size-full seperator-light height-small"><span></span></div>
							<p><?php echo $value_back_ideo_sol->idea; ?></p>
							</div><?php } else { ?>

							<div class="column one-third">
								<h5><strong><?php echo $value_back_ideo_sol->insight_header; ?></strong></h5>
								<div class="seperator style-solid size-full seperator-light height-small"><span></span></div>
							<p><?php echo $value_back_ideo_sol->insight; ?></p>
							</div>	
                           
							<?php } ?>
						 <div class="column one-third last-col">
								<h5><strong><?php echo $value_back_ideo_sol->sol_header; ?></strong></h5>
								<div class="seperator style-solid size-full seperator-light height-small"><span></span></div>
							<p><?php echo $value_back_ideo_sol->solution; ?></p>
							</div> 

						</div>
					</div> <!-- END .entry-content -->
					
				</div> <!-- END .wrapper -->
				 
				<div class="spacer spacer-big"></div>
				
			</div> <!-- END #portfolio-single .section-inner -->
    	</section> <!-- END SECTION #portfolio-->
		<!-- PORTFOLIO SECTION -->
		<div class="close-project"><a href="index.html">Close</a></div>
        
      	<!-- FOOTER -->  
		<footer>
			<div class="footerinner wrapper align-center text-light">
				<a id="backtotop" href="#" class="sr-button sr-buttonicon small-iconbutton"><i class="fa fa-angle-up"></i></a>
				<p class="footer-logo"><img src="<?= base_url();?>assets/uploads/xone-logo-footer.png" alt="Footer Logo"></p>
             	<ul class="socialmedia-widget social-share">
 					<li class="facebook"><a href="<?php echo $value_back_ideo_sol->facebook; ?>">Facebook</a></li>
  					<li class="twitter"><a href="<?php echo $value_back_ideo_sol->twiiter; ?>">Twitter</a></li>
 					<li class="linkedin"><a href="<?php echo $value_back_ideo_sol->google; ?>">Google Plus</a></li>
 					<!-- <li class="dribbble"><a href="<?php echo $value_back_ideo_sol->solution; ?>">Dribble</a></li>
 					<li class="behance"><a href="<?php echo $value_back_ideo_sol->solution; ?>">Behance</a></li> -->
 					<li class="instagram"><a href="<?php echo $value_back_ideo_sol->pinterest; ?>">Pinterest</a></li>
            	</ul>
            <?php endforeach; ?> 	
            	<p class="copyright">Copyright &copy; 2014 - Xone - Created by SpabRice</p>
         	</div>
    	</footer>
      	<!-- FOOTER -->         
        
 	</div> <!-- END .page-body -->
	<!-- PAGEBODY -->
    
</div> <!-- END #page-content -->
<!-- PAGE CONTENT -->


<!-- SCRIPTS -->
<script type='text/javascript' src='<?= base_url();?>assets/js/retina.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/jquery.easing.1.3.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/jquery.easing.compatibility.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/jquery.visible.min.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/jquery.flexslider.min.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/jquery.fitvids.min.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/xone-header.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/script.js'></script>
<!-- SCRIPTS -->

</body>
</html>