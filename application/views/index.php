<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en-US"> <!--<![endif]-->
<head>

<!-- DEFAULT META TAGS -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Owlworx | Home </title>
<!-- DEFAULT META TAGS -->

<!-- FONTS -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,800,600|Raleway:300,600,900' rel='stylesheet' type='text/css'>
<!-- FONTS -->

<!-- CSS -->
<link rel='stylesheet' id='default-style-css'  href='<?= base_url();?>assets/css/style.css' type='text/css' media='all' />
<link rel='stylesheet' id='flexslider-style-css'  href='<?= base_url();?>assets/css/flexslider.css' type='text/css' media='all' />
<link rel='stylesheet' id='easy-opener-style-css'  href='<?= base_url();?>assets/css/easy-opener.css' type='text/css' media='all' />
<link rel='stylesheet' id='jplayer-style-css'  href='<?= base_url();?>assets/jplayer/jplayer.css' type='text/css' media='all' />
<link rel='stylesheet' id='isotope-style-css'  href='<?= base_url();?>assets/css/isotope.css' type='text/css' media='all' />
<link rel="stylesheet" id='rsplugin-style-css' href="<?= base_url();?>assets/css/settings.css" type="text/css" media="all" />
<link rel="stylesheet" id='fontawesome-style-css' href="<?= base_url();?>assets/css/font-awesome.min.css" type="text/css" media="all" />
<link rel='stylesheet' id='retina-style-css'  href='<?= base_url();?>assets/css/retina.css' type='text/css' media='all' />
<!-- <link rel='stylesheet' id='dark-style-css'  href='files/css/dark.css' type='text/css' media='all' /> -->
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

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-28405119-3', 'owlworx.in');
  ga('send', 'pageview');
</script>

<!-- PAGELOADER -->
<div id="page-loader">
	<div class="page-loader-inner">
 <div class="loader-logo"><img src="<?= base_url();?>assets/uploads/logo-preloader.png" alt="Logo"/></div>
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
				<a id="defaut-logo" class="logotype" href="<?= base_url();?>l"><img src="<?= base_url();?>assets/uploads/xone-logo.png" alt="Logo"></a>
			</div>    
            
			<div class="menu right-float clearfix">
           	<nav id="main-nav">
            		<ul>
                  	<li class="current-menu-item"><a href="#parallax-video" class="scroll-to">Home</a></li>
                    <li><a href="#portfolio" class="scroll-to">Portfolio</a></li>
                  	<li><a href="#about" class="scroll-to">About</a></li>
                  	<li><a href="#service" class="scroll-to">Service</a></li>
                  	<li><a href="#team" class="scroll-to">Team</a></li>
                  	
                  	<!-- <li><a href="https://vimeo.com/album/2887864" target="_blank" > Testimonial</a>
                    		
                    	</li> -->

                    <li><a href="#contact" class="scroll-to">Contact</a></li>
					</ul>
				</nav>              
			</div>
                    
		</div> <!-- END .header-inner -->
	</header> <!-- END header -->
	<!-- HEADER -->    
    
	<!-- PAGEBODY -->
	<div class="page-body">
    
  <!-- PARALLAX VIDEO SECTION -->             
  <div id="parallax-video" class="horizontalsection text-light videobg-section"
   data-videofile="<?= base_url();?>assets/uploads/coffee" 
   data-videowidth="1280"
   data-videoheight="720"
   data-videoposter="<?= base_url();?>assets/uploads/slider-bg1.jpg"
   data-videoparallax="true"
   data-videooverlaycolor="#000000"
   data-videooverlayopacity="0.6">
          
    <div class="horizontalinner1 wrapper">
        <div class="section-title sr-animation">
        <?php foreach($slider as $value_slider): ?>
            <h2><?php echo $value_slider->title; ?></h2>
            <div class="seperator size-small"><span></span></div>
            <h4 class="subtitle"><?php echo $value_slider->description; ?></h4>
        <?php endforeach; ?>
          </div>
          <h6 class="align-center sr-animation sr-animation-frombottom"><strong></strong></h6>
          <p class="align-center sr-animation sr-animation-frombottom" data-delay="200">            
          </p>
     </div>   
  </div> <!-- END #parallax-video -->
            <!-- PARALLAX VIDEO SECTION -->


		<!-- PORTFOLIO --> 
     	<section id="portfolio" class="no-padding">
            <div class="section-inner">
                
            <!-- AJAX AREA -->    
            <div id="ajax-portfolio" class="ajax-section">
				       <div id="ajax-loader"><div class="loader-icon"><span class="spinner"></span><span></span></div></div>
					        <div class="ajax-content clearfix"> 
                    	<!-- THE LOADED CONTENT WILL BE ADDED HERE -->
                	</div>
				       <div class="close-project"><a href="<?php base_url(); ?>">Close</a></div>
            </div>    
            <!-- AJAX AREA -->    
           
           <div id="portfolio-grid" class="masonry portfolio-entries clearfix" data-maxitemwidth="600">
                <?php 
                //.'/'.$value_portfolio->background.'/'.$value_portfolio->idea.'/'.$value_portfolio->solution
                //print_r($back_ideo_sol);//exit; 
               // echo '<br />';
                //print_r($portfolio); 
                foreach($portfolio as $value_portfolio): ?>
                <div class="portfolio-masonry-entry masonry-item branding">
                    <div class="entry-thumb portfolio-thumb">
                        <div class="imgoverlay text-light">
                            <a href="<?=base_url().'home/sub_product/'.$value_portfolio->id; ?>" class="load-content">
                                <img src="<?php echo base_url().'assets/uploads/portfolio/'.$value_portfolio->image; ?>" alt="SEO IMAGE NAME" />
                            		<div class="overlay"><span class="overlaycolor"></span><div class="overlayinfo">
              									<h5 class="portfolio-name"><strong><?php echo $value_portfolio->title; ?></strong></h5>
              									<h6><?php echo $value_portfolio->sub_title; ?></h6></div></div>
                            </a>
                        </div>
                   </div>
                </div> 

              <?php endforeach; ?>
 <!-- END .portfolio-masonry-entry -->
                
         	</div> <!-- END #portfolio-grid -->
                          
          	</div> <!-- END .section-inner-->
     	</section> <!-- END SECTION #portfolio-->
		<!-- PORTFOLIO -->    
        
       <!-- ABOUT --> 
      	<section id="about">
            <div class="section-inner">
            
            <div class="wrapper">
                
             	<div class="section-title">
                	<h2>About</h2>
              		<div class="seperator size-small"><span></span></div>
              		<h4 class="subtitle">Driven by truth, simplicity & boldness.</h4>
              	</div>
                
            	<div class="column-section clearfix">
                	<?php foreach ($about as $key_about => $value_about): //echo $value_about->name; ?>
                  <div class="column one-third sr-animation sr-animation-zoomin" data-delay="200">
                  	<div class="align-center"><i class="fa fa-check-circle-o fa-3x xone custom-padbot"></i></div>
                    	<h4><strong><?php echo $value_about->name ;?></strong></h4>
                    	<p>
                        <?php echo $value_about->description ;?>
                  	</p>
                  </div>
                  <?php endforeach; ?>
				     </div> 

        <!-- END .column-section -->
                
			</div> <!-- END .wrapper> -->
            
			<div class="spacer spacer-big"></div>
           
           <!-- PASSIONATE -->
              <div id="passionate1" class="horizontalsection text-light parallax-section">
          <div class="horizontalinner wrapper align-center">
                    <h2>We are passionate about design</h2>
                      <div class="spacer spacer-small"></div>
                      <p><a href="#portfolio" class="scroll-to sr-button sr-button4 medium-button">See our Work</a></p>
                </div>
              </div>
        <!-- PASSIONATE -->
                                
			</div> <!-- END .section-inner-->
		</section>
       	<!-- ABOUT -->
		
	   
		<!-- SERVICE -->	    
     	<section id="service">
        	<div class="section-inner">
              	<div class="wrapper"> 
				
				        <div class="section-title">
                	<h2>Services</h2>
              		<div class="seperator size-small"><span></span></div>
              		<h4 class="subtitle"> Comprehensive branding, identity and packaging services <br>for brands at all stages of evolution.</h4>
              	</div>
				   
             	<div class="column-section clearfix">
                	<?php foreach($service as $key=>$value_services): 
                  if($key==1 || $key==2 || $key==3){   ?>
                  <div class="column one-third iconbox clearfix sr-animation sr-animation-frombottom" data-delay="0">
                  	<!-- <i class="fa fa-laptop fa-2x fa-fw"></i> -->
                    	<div class="iconbox-content">
                      	<h5><strong><?php echo $value_services->name; ?></strong></h5>
                         <p>
                        <?php echo $value_services->description; ?>
                        	</p>
                    	</div>
                  </div>
                <?php } endforeach; ?>



            	</div>
                 <div class="column-section clearfix">
                  <?php foreach($service as $key=>$value_services): 
                  if($key==4 || $key==5 || $key==6){   ?>
                  <div class="column one-third iconbox clearfix sr-animation sr-animation-frombottom" data-delay="0">
                    <!-- <i class="fa fa-laptop fa-2x fa-fw"></i> -->
                      <div class="iconbox-content">
                        <h5><strong><?php echo $value_services->name; ?></strong></h5>
                         <p>
                        <?php echo $value_services->description; ?>
                          </p>
                      </div>
                  </div>
                <?php } endforeach; ?>
              </div>  


                <div class="column-section clearfix">
                  <?php foreach($service as $key=>$value_services): 
                  if($key==7 || $key==8 || $key==9){   ?>
                  <div class="column one-third iconbox clearfix sr-animation sr-animation-frombottom" data-delay="0">
                    <!-- <i class="fa fa-laptop fa-2x fa-fw"></i> -->
                      <div class="iconbox-content">
                        <h5><strong><?php echo $value_services->name; ?></strong></h5>
                         <p>
                        <?php echo $value_services->description; ?>
                          </p>
                      </div>
                  </div>
                <?php } endforeach; ?>
              </div>  


                 <div class="column-section clearfix">
                  <?php foreach($service as $key=>$value_services): 
                  if($key==10 || $key==11 || $key==12){   ?>
                  <div class="column one-third iconbox clearfix sr-animation sr-animation-frombottom" data-delay="0">
                    <!-- <i class="fa fa-laptop fa-2x fa-fw"></i> -->
                      <div class="iconbox-content">
                        <h5><strong><?php echo $value_services->name; ?></strong></h5>
                         <p>
                        <?php echo $value_services->description; ?>
                          </p>
                      </div>
                  </div>
                <?php } endforeach; ?>



              </div>  
           
          <div class="spacer spacer-big"></div>
            
				<!-- FACTS -->
        </div>
				<div id="facts" class="horizontalsection text-light parallax-section">
					<div class="horizontalinner wrapper">
						<h3 class="align-center">When the owls are wide awake...</h3>	
						<div class="spacer spacer-small"></div>
						<div class="column-section clearfix align-center ">
                            
                      <?php foreach($counter as $count_value): ?>
                            <div class="column one-fourth">
                            <i class="<?php echo 'fa '.$count_value->icon.' fa-3x fw';?> "></i>
                                <div class="counter">
                                    <div class="counter-value" data-from="0" data-to="<?php echo $count_value->count; ?>" data-speed="60">0</div>
                                    <h6 class="counter-name"><strong><?php echo $count_value->name; ?></strong></h6>
                                 </div>
                            </div>
                        <?php endforeach; ?>
                        </div> <!-- END .column-section --> 
						
                    </div>  
                </div> <!-- END #facts-->
				<!-- FACTS -->
                   
			 <!-- END .section-inner-->
		</section> <!-- END SECTION #service-->
		<!-- SERVICE -->
		       
	   	<!-- TEAM --> 
		<section id="team">
            <div class="section-inner">
              	<div class="wrapper">  
                        
            	<div class="section-title">
                	<h2>Meet the Team</h2>
              		<div class="seperator size-small"><span></span></div>
              		<h4 class="subtitle">Insights, ideas and passion to breathe life into your brands. </h4>
              	</div>
                
            	<div class="column-section clearfix">
                	
              <?php 
              foreach($team as $value_team) : ?>
                  <div class="column one-third align-center">
                  	<div class="team-pic">
                    		<div class="imgoverlay text-light">
              								<img src="<?php echo base_url().'assets/uploads/team/'.$value_team->image; ?>" alt="IMAGE">
              								<div class="overlay"><span class="overlaycolor"></span><div class="overlayinfo">
              								<ul class="socialmedia-widget text-light">
                              <?php if($value_team->facebook!=''){ ?>
              									<li class="facebook"><a target='_blank'  href="<?php echo $value_team->facebook;?>">Facebook</a></li>
                                <?php }
                                if($value_team->twitter!=''){ ?>
              									<li class="xing"><a target='_blank' href="<?php echo $value_team->twitter;?>">Tweet</a></li>
              								<?php }
                               if($value_team->linkedin!=''){ ?>	
                                <li class="linkedin"><a target='_blank' href="<?php echo $value_team->linkedin;?>">Linked in</a></li>
                                <?php } ?>
                                </ul>
                         		</div>
                            </div>
                         </div>
                      </div>
                    	<h4 class="team-name"><strong><?php echo $value_team->name; ?></strong></h4>
                    	<h6 class="team-role"><?php echo  $value_team->designation; ?></h6>
                    	<div class="seperator size-mini height-small"><span></span></div> 
                    	<!-- <p class="team-info">
                     	Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore.  
                  	</p> -->
                  </div>
                <?php endforeach; ?>

              
           	</div> <!-- END .column-section -->

            	</div> <!-- END .wrapper -->
                
            	<div class="spacer spacer-big"></div>
            	
				<!-- PASSIONATE -->
            	<div id="passionate" class="horizontalsection text-light parallax-section">
					<div class="horizontalinner wrapper align-center">
                  	<h2>Collaborate</h2>
                    	<div class="spacer spacer-small"></div>
                      <p>Working at Owlworx means being a part of a team that is multicultural, diverse and obsessed with simplicity. If you are passionate, creative and sensitive, you will enjoy being a part of our team. Previous experience is desirable but not always necessary. Having loads of ideas and an uncomplicated mind is usually enough to get us talking.<br>We happily welcome long term (minimum 12 weeks) interns as well.<br>Write to <a href="mailto:anirudha@owlworx.in">anirudha@owlworx.in</a><br>Now is a good time.
                      </p>
                    	<!-- <p><a href="#portfolio" class="scroll-to sr-button sr-button4 medium-button">See our Works</a></p> -->
            		</div>
            	</div>
				<!-- PASSIONATE -->
                 	
         	</div> <!-- END .section-inner-->
    	</section>
		<!-- TEAM -->
		
		<!-- CONTACT --> 
       <section id="contact">
            <div class="section-inner wrapper">
                        
            	<div class="section-title">
                	<h2>Contact us</h2>
              		<div class="seperator size-small"><span></span></div>
              		<h4 class="subtitle">We're passionate about brands.<br>We'd love to work on yours.</h4>
              	</div>
             	
            	<div class="column-section clearfix">
                	<div class="column one-half"> 
                 		<form id="contact-form" class="checkform" action="#" target="contact-send.php" method="post" >
                      	
                        	<div class="form-row clearfix">
                            	<label for="name" class="req">Name *</label>
                            	<div class="form-value"><input type="text" name="name" class="name" id="name" value="" /></div>
                        	</div>
                            
                        	<div class="form-row clearfix">
                            	<label for="email" class="req">Email *</label>
                            	<div class="form-value"><input type="text" name="email" class="email" id="email" value="" /></div>
                        	</div>
                            
                        	<div class="form-row clearfix textbox">
                            	<label for="message" class="req">Message *</label>
                            	<div class="form-value"><textarea name="message" class="message" id="message" rows="15" cols="50"></textarea></div>
                        	</div>
							
							<div id="form-note">
								<div class="alert alert-error">
									<h6><strong>Error</strong>: Please check your entries!</h6>
								</div>
							</div>
                            
                        	<div class="form-row form-submit">
                            	<input type="submit" name="submit_form" class="submit" value="Send" />
                        	</div>
                    
                        	<input type="hidden" name="subject" value="Contact Subject Xone html" />
                        	<input type="hidden" name="fields" value="name,email,message," />
                        	<input type="hidden" name="sendto" value="vzagde110@gmail.com" />  
                        
                   	</form> 
				  
                	</div>
                    
                	<div class="column one-half last-col"> 
                  	<h5>Drop in for a second</h5>
                    <p>
                		The owls are always happy to help you find exciting solutions to your branding and packaging needs.
                   		</p> 
						     <?php foreach($com_address as $value_address): ?>
                 <div class="spacer spacer-small"></div>
                    	<h5><strong><?php echo $value_address->name; ?></strong></h5>
                    	<p>
                      <?php echo $value_address->address; ?>
                    	</p> 
                    	<p>
                     <?php echo $value_address->mobile; ?><br>
                      <a href="mailto:<?php echo $value_address->email; ?>"><?php echo $value_address->email; ?>  </a>
                    	</p>   
                	</div>
            	</div> 
            <?php endforeach; ?>
              <!-- END .column-section --> 
				
				<div class="spacer spacer-big"></div>
			
			</div> <!-- END .section-inner-->
     	</section>
		<!-- CONTACT -->
        
      	<!-- FOOTER -->  
		<footer>
			<div class="footerinner wrapper align-center text-light">
				<a id="backtotop" href="#" class="sr-button sr-buttonicon small-iconbutton"><i class="fa fa-angle-up"></i></a>
				<p class="footer-logo"><img src="<?php base_url();?>assets/uploads/xone-logo-footer.png" alt="Footer Logo"></p>
             	<ul class="socialmedia-widget social-share">
 					<li class="facebook"><a href="https://www.facebook.com/Owlworx">Facebook</a></li>
  					            	</ul>
            	<p class="copyright">Copyright &copy; 2014 - Owlworx - Created by DesignNova</p>
         	</div>
    	</footer>
      	<!-- FOOTER -->         
        
 	</div> <!-- END .page-body -->
	<!-- PAGEBODY -->
    
</div> <!-- END #page-content -->
<!-- PAGE CONTENT -->


<!-- SCRIPTS -->
<!-- <script type='text/javascript' src='<?= base_url();?>assets/js/retina.js'></script>
 --><script type='text/javascript' src='<?= base_url();?>assets/js/jquery.easing.1.3.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/jquery.easing.compatibility.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/jquery.visible.min.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/jquery.easy-opener.min.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/jquery.flexslider.min.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/jquery.isotope.min.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/jquery.bgvideo.min.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/jquery.fitvids.min.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/jplayer/jquery.jplayer.min.js'></script>
<script type="text/javascript" src="<?= base_url();?>assets/js/jquery.themepunch.plugins.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>assets/js/jquery.themepunch.revolution.min.js"></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/jquery.parallax.min.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/jquery.counter.min.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/jquery.scroll.min.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/xone-header.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/xone-loader.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/xone-form.js'></script>
<script type='text/javascript' src='<?= base_url();?>assets/js/script.js'></script>
<!-- SCRIPTS -->

</body>
</html>