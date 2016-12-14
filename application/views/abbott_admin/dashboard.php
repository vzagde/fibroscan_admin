<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once( 'includes/head.php'); ?>
  </head>
  <body>
    <section id="container">
      <header class="header black-bg">
        <div class="sidebar-toggle-box">
          <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation">
          </div>
        </div>
        <!--logo start-->
        <a href="javascript:void(0);" class="logo">
        </a>
        <!--logo end-->
        <div class="nav notify-row" id="top_menu">
          <!--  notification start -->
          <ul class="nav top-menu">
          </ul>
          <!--  notification end -->
        </div>
        <div class="top-menu">
          <ul class="nav pull-right top-menu">
            <li class="top-menu-li"><a href="#">Hi <?= $user->username?>,</a></li>
            <li class="top-menu-li"><a href="#">[ <?= $group->name?> ]</a></li>
            <li>
              <a class="logout" href="<?=base_url()?>auth/logout">Logout</a>
            </li>
          </ul>
        </div>
      </header>
      <!--header end-->
      <!--sidebar start-->
      <aside>
        <?php include_once( 'includes/sidebar.php'); ?>
      </aside>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
        <section class="wrapper site-min-height">
          <h1 class="page-header">Dashboard</h1>
          <hr>
          <div class="row mt">
            <div class="col-lg-12">
              <!-- <div id="site_users_chart"></div> -->
              <div class="col-lg-12">
                <!-- <div id="reports_chart"></div> -->
              </div>
              </style>
          </div>
          </div>
      </section>
      <!-- /wrapper -->
    </section>
    <!-- /MAIN CONTENT -->
    <!--main content end-->
    </section>
  <?php include_once( 'includes/site_bottom_scripts.php'); ?>
  </body>
</html>
