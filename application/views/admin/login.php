<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <title>Login</title>
    <link href="<?=base_url()?>assets/admin/css/bootstrap.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/admin/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/admin/css/style.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/admin/css/style-responsive.css" rel="stylesheet">
  </head>
  <body style="background: #fff;">
	  <div id="login-page">
	  	<div class="container">
			<div class="col-lg-12 clearfix" style="margin-top:150px; text-align:center;">
				<img src="<?=base_url()?>assets/images/logo_new.jpg" style="margin-bottom: 6%;">
			</div>
			<div class="clearfix"></div>
	      	<?php echo form_open('index.php/login/form_submit', array('class' => 'form-login')); ?>
	        <h2 class="form-login-heading" style="margin-top:-7%">sign in now</h2>
	        <div class="login-wrap">
	        	<p><?=@$message?></p>
	            <input name="identity" type="text" class="form-control" placeholder="User ID" autofocus>
	            <br>
	            <input name="password" type="password" class="form-control" placeholder="Password">
	            <label class="checkbox">
	                <span class="pull-right">
	                    <a data-toggle="modal" href="login.html#myModal"> Forgot Password?</a>
	                </span>
	            </label>
	            <button class="btn btn-theme btn-block" href="index.html" type="submit"><i class="fa fa-lock"></i> SIGN IN</button>
		        <?=form_close();?>
	        </div>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                  	<?php echo form_open("auth/forgot_password");?>
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Forgot Password ?</h4>
                      </div>
                      <div class="modal-body">
                          <p>Enter your e-mail address below to reset your password.</p>
                          <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                      </div>
                      <div class="modal-footer">
                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                          <button class="btn btn-theme" type="button">Submit</button>
                      </div>
					  <?=form_close();?>
                  </div>
              </div>
            </div>
	  	</div>
	  </div>
    <script src="<?=base_url()?>assets/admin/js/jquery.js"></script>
    <script src="<?=base_url()?>assets/admin/js/bootstrap.min.js"></script>
  </body>
</html>
