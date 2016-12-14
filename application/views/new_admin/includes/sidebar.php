<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="index.html" class="site_title">
        <span>Abbott.</span>
      </a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile">
      <div class="profile_pic">
        <img src="<?=base_url()?>assets/new_admin/images/img.jpg" alt="..." class="img-circle profile_img">
      </div>
      <div class="profile_info">
        <span>Welcome,</span>
        <h2><?= $user->username?></h2>
      </div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3><?= $group->name?></h3>
        <ul class="nav side-menu">
          <li>
            <a href="<?=base_url()?>admin">
              <i class="fa fa-home"></i> Dashboard
            </a>
          </li>

          <?php if($this->ion_auth->in_group(array("admin"))){ ?>
          <li>
            <a>
              <i class="fa fa-users"></i> Users
              <span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu">
              <li>
                <a href="<?=base_url()?>admin/all_users">
                  <i class="fa fa-users"></i>All user
                </a>
              </li>
              <li>
                <a href="<?=base_url()?>admin/add_user">
                  <i class="fa fa-edit"></i>Add user
                </a>
              </li>
            </ul>
          </li>
          <li>
            <a>
              <i class="fa fa-get-pocket"></i> Machine
              <span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu">
              <li>
                  <a href="<?=base_url()?>admin/camp_booking">
                      <i class="fa fa-get-pocket"></i> Machine Booking
                  </a>
              </li>
              <li>
                  <a href="<?=base_url()?>admin/machine_usability">
                      <i class="fa fa-bar-chart"></i> Machine Usability
                  </a>
              </li>
              <li>
                  <a href="<?=base_url()?>admin/machine_utilization">
                      <i class="fa fa-bar-chart"></i> Machine Utilization
                  </a>
              </li>
            </ul>
          </li>
          <li>
            <a>
              <i class="fa fa-area-chart"></i> FAM
              <span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu">
              <li>
                  <a href="<?=base_url()?>admin/fam_data">
                      <i class="fa fa-area-chart"></i> FAM Data
                  </a>
              </li>
              <li>
                  <a href="<?=base_url()?>admin/fam_list">
                      <i class="fa fa-line-chart"></i> FAM List
                  </a>
              </li>
            </ul>
          </li>
          <li>
              <a href="<?=base_url()?>admin/tbm_data">
                  <i class="fa fa-area-chart"></i> TBM Data
              </a>
          </li>
          <li>
            <a>
              <i class="fa fa-line-chart"></i> Patients
              <span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu">
              <li>
                  <a href="<?=base_url()?>admin/patients">
                      <i class="fa fa-line-chart"></i> Patients
                  </a>
              </li>
              <li>
                  <a href="<?=base_url()?>admin/patient_camps">
                      <i class="fa fa-h-square"></i> Patient Camp
                  </a>
              </li>
              <li>
                  <a href="<?=base_url()?>admin/getListByUser">
                      <i class="fa fa-line-chart"></i> Patients Data
                  </a>
              </li>
            </ul>
          </li>
          <li>
              <a href="<?=base_url()?>admin/list_data">
                  <i class="fa fa-edit"></i> Defaulter List
              </a>
          </li>
          <li>
              <a href="<?=base_url()?>admin/load_chart">
                  <i class="fa fa-line-chart"></i> BM Related Data
              </a>
          </li>
          <?php } ?>

        	<?php if($this->ion_auth->in_group(array("BM", "HO"))){ ?>
  				<li>
            <a href="<?=base_url()?>index.php/admin/slot_stats">
              <i class="fa fa-book"></i>
              <span>Slots Stats</span>
            </a>
          </li>
          <li>
            <a href="<?=base_url()?>index.php/admin/doctors_stats">
              <i class="fa fa-book"></i>
              <span>Doctor's Stats</span>
            </a>
          </li>
          <li>
            <a href="<?=base_url()?>index.php/admin/machine_used">
              <i class="fa fa-book"></i>
              <span>Machine Used</span>
            </a>
          </li>
          <li>
            <a href="<?=base_url()?>index.php/admin/doctors_speciality">
              <i class="fa fa-book"></i>
              <span>Speciality Stats</span>
            </a>
          </li>
          <li>
            <a href="<?=base_url()?>index.php/admin/activation_live">
              <i class="fa fa-book"></i>
              <span>Activation LIVE</span>
            </a>
          </li>
          <li>
            <a href="<?=base_url()?>index.php/admin/all_bookings">
              <i class="fa fa-book"></i>
              <span>All Bookings</span>
            </a>
          </li>
          <?php } ?>
          <?php if($this->ion_auth->in_group(array("ABM"))){ ?>
        		<li>
        			<a href="<?=base_url()?>index.php/admin/all_cancellation">
                <i class="fa fa-book"></i>
                <span>Approve / Disapprove</span>
              </a>
      		</li>
      		<?php } ?>
        </ul>
      </div>
    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
      <a data-toggle="tooltip" data-placement="top" title="Settings">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="FullScreen">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Lock">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
      </a>
      <a href="<?=base_url();?>admin/logout" data-toggle="tooltip" data-placement="top" title="Logout">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
      </a>
    </div>
    <!-- /menu footer buttons -->
  </div>
</div>
