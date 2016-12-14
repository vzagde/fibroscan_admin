<?php 
$this->load->library('session');
$dt = $this->session->all_userdata();
?>
<div id="sidebar"  class="nav-collapse " style="z-index:999">
  <ul class="sidebar-menu" id="nav-accordion">
    <p class="centered">
      <a>
        <img src="<?=base_url()?>assets/images/logo.jpg" style="color: #fff !important;background-color: white;width:100px;hight:90px;margin: 5%"> 
        <h1 class="centered">Abbott Admin</h1>
      </a>
    </p>
    <li class="mt">
      <a href="<?=base_url()?>index.php/admin" class="active" id="menu_dashboard">
        <i class="fa fa-dashboard"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <?php
    switch ($group->name) {
      case 'admin':
    ?>
        <li>
          <a href="<?=base_url()?>index.php/admin/">
            <i class="fa fa-book"></i>
            <span>Admin</span>
          </a>
        </li>
    <?php
        break;
      case 'BM':
    ?>
        <li>
          <a href="<?=base_url()?>index.php/admin/">
            <i class="fa fa-book"></i>
            <span>BM</span>
          </a>
        </li>
    <?php
        break;
      case 'HO':
    ?>
        <li>
          <a href="<?=base_url()?>index.php/admin/">
            <i class="fa fa-book"></i>
            <span>HO</span>
          </a>
        </li>
    <?php
        break;

      default:
        # code...
        break;
    }
    ?>
  </ul>
</div>
<script>
  $('.sidebar-menu li a').removeClass('active');
  $('#menu_<?=strtolower($this->uri->segment(2, 0))?>').addClass('active');
</script>
