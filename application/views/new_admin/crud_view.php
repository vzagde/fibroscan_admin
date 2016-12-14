<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once( 'includes/head.php'); ?>
    <?php 
    foreach($css_files as $file): ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
     
    <?php endforeach; ?>
    
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <?php include_once( 'includes/sidebar.php'); ?>
        <?php include_once('includes/topbar.php'); ?>
        
        <div class="right_col" role="main" style="min-height: 3788px;">
          <?php echo $output; ?>
        </div>

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Abbott - App Admin Template by <a href="http://kreaserv.com">Kreaserv</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
    <?php include_once( 'includes/footer.php'); ?>
    <?php foreach($js_files as $file): ?>
     
        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
    <script id="base" data-base_url="<?=base_url()?>" src="<?=base_url()?>assets/new_admin/js/custom_script.js"></script>
  </body>
</html>
