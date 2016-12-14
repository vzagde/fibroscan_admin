<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once( 'includes/head.php'); ?>
    <style >
#canvas_dahs, #doctor_engaged, #patients_scanned {
    height: 500px; 
    min-width: 310px; 
    max-width: 800px; 
    margin: 0 auto; 
}
.loading {
    margin-top: 10em;
    text-align: center;
    color: gray;
}

    </style>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <?php include_once( 'includes/sidebar.php'); ?>
        <?php include_once('includes/topbar.php'); ?>
        <div class="right_col" role="main">
          <div class="row tile_count" style="background: #fff">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Top performing FAM</span>
              <div class="count green"><?=@$top_fam->name?></div>
              <span class="count_bottom"><i class="green"> from </i><?=@$top_fam->area_name?> </span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Top performing TBM</span>
              <div class="count green"><?=@$top_tbm->name?></div>
              <span class="count_bottom"><i class="green"> from </i><?=@$top_tbm->area_name?> </span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Patient scanned</span>
              <div class="count green"><?=@$num_of_patient?></div>
              <span class="count_bottom"><i class="green">from</i><?=@$total_num_camps?> Camps</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Camps Planned</span>
              <div class="count green"><?=@$total_num_planned_camps?></div>
              <span class="count_bottom"><i class="green"> For</i> This Month </span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Camps Executed</span>
              <div class="count green"><?=@$total_num_camps?></div>
              <span class="count_bottom"><i class="green"> From </i> <?=@$total_num_planned_camps?> Camps</span>
            </div>
            <!-- <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Collections</span>
              <div class="count">2,315</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Connections</span>
              <div class="count">7,325</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div> -->
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">
                <div class="row x_title">
                  <div class="col-md-6">
                    <h3>State wise camp executed <small></small></h3>
                  </div>
                  <!-- <div class="col-md-6">
                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                      <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                      <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
                  </div> -->
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-6 col-sm-9 col-xs-12">
                      <div id="placeholder33" style="height: 260px; display: none" class="demo-placeholder"></div>
                      <div style="width: 100%;">
                        <div id="canvas_dahs" class="demo-placeholder" ></div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-9 col-xs-12">
                      <div id="placeholder33" style="height: 260px; display: none" class="demo-placeholder"></div>
                      <div style="width: 100%;">
                        <div id="doctor_engaged" class="demo-placeholder" ></div>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="row">
                  <div class="col-md-12" style="padding: 2% 0;">
                    <div class="col-md-6 col-sm-9 col-xs-12" style="padding: 2%;">
                      <div id="placeholder33" style="height: 260px; display: none" class="demo-placeholder"></div>
                      <div style="width: 100%;">
                        <div id="" class="demo-placeholder" >
                          <div class="x_panel">
                          <div class="x_title">
                            <h2>Top TBMs <small></small></h2>
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Count</th>
                                  <th>Name</th>
                                  <th>From</th>
                                  <th>Appreciate</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php for ($i=0; $i<count($top_tbms); $i++) { ?>
                                <tr>
                                  <th scope="row"><?=@$i+1?></th>
                                  <td><?=@$top_tbms[$i]->count?></td>
                                  <td><?=@$top_tbms[$i]->name?></td>
                                  <td><?=@$top_tbms[$i]->area_name?></td>
                                  <td><i class="fa fa-thumbs-up" data-id="<?=@$top_tbms[$i]->id?>" aria-hidden="true"></i></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                  <th scope="row">2</th>
                                  <td>0</td>
                                  <td>TBM Rank 2</td>
                                  <td>Location</td>
                                  <td><i class="fa fa-thumbs-up" aria-hidden="true"></i></td>
                                </tr>
                                <tr>
                                  <th scope="row">3</th>
                                  <td>0</td>
                                  <td>TBM Rank 3</td>
                                  <td>Location</td>
                                  <td><i class="fa fa-thumbs-up" aria-hidden="true"></i></td>
                                </tr>
                                <tr>
                                  <th scope="row">4</th>
                                  <td>0</td>
                                  <td>TBM Rank 4</td>
                                  <td>Location</td>
                                  <td><i class="fa fa-thumbs-up" aria-hidden="true"></i></td>
                                </tr>
                                <tr>
                                  <th scope="row">5</th>
                                  <td>0</td>
                                  <td>TBM Rank 5</td>
                                  <td>Location</td>
                                  <td><i class="fa fa-thumbs-up" aria-hidden="true"></i></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-9 col-xs-12" style="padding: 2%;">
                      <div id="placeholder33" style="height: 260px; display: none" class="demo-placeholder"></div>
                      <div style="width: 100%;">
                        <div id="" class="demo-placeholder" >
                          <div class="x_panel">
                          <div class="x_title">
                            <h2>Top FAMs <small></small></h2>
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Count</th>
                                  <th>Name</th>
                                  <th>From</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php for ($i=0; $i<count($top_fams); $i++) { ?>
                                <tr>
                                  <th scope="row"><?=@$i+1?></th>
                                  <td><?=@$top_fams[$i]->count?></td>
                                  <td><?=@$top_fams[$i]->name?></td>
                                  <td><?=@$top_fams[$i]->area_name?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                  <th scope="row">2</th>
                                  <td>0</td>
                                  <td>FAM Rank 2</td>
                                  <td>Location</td>
                                </tr>
                                <tr>
                                  <th scope="row">3</th>
                                  <td>0</td>
                                  <td>FAM Rank 3</td>
                                  <td>Location</td>
                                </tr>
                                <tr>
                                  <th scope="row">4</th>
                                  <td>0</td>
                                  <td>FAM Rank 4</td>
                                  <td>Location</td>
                                </tr>
                                <tr>
                                  <th scope="row">5</th>
                                  <td>0</td>
                                  <td>FAM Rank 5</td>
                                  <td>Location</td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12" style="padding: 2% 0;">
                    <div class="col-md-6 col-sm-9 col-xs-12" style="padding: 2%;">
                      <div id="placeholder33" style="height: 260px; display: none" class="demo-placeholder"></div>
                      <div style="width: 100%;">
                        <div id="" class="demo-placeholder" >
                          <div class="x_panel">
                          <div class="x_title">
                            <h2>Top TECHNICIANs <small></small></h2>
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Count</th>
                                  <th>Name</th>
                                  <th>From</th>
                                  <th>Appreciate</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php for ($i=0; $i<count($top_technician); $i++) { ?>
                                <tr>
                                  <th scope="row"><?=@$i+1?></th>
                                  <td><?=@$top_technician[$i]->count?></td>
                                  <td><?=@$top_technician[$i]->name?></td>
                                  <td><?=@$top_technician[$i]->area_name?></td>
                                  <td><i class="fa fa-thumbs-up" data-id="<?=@$top_technician[$i]->id?>" aria-hidden="true"></i></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                  <th scope="row">3</th>
                                  <td>0</td>
                                  <td>Technician Rank 3</td>
                                  <td>Location</td>
                                  <td><i class="fa fa-thumbs-up" aria-hidden="true"></i></td>
                                </tr>
                                <tr>
                                  <th scope="row">4</th>
                                  <td>0</td>
                                  <td>Technician Rank 4</td>
                                  <td>Location</td>
                                  <td><i class="fa fa-thumbs-up" aria-hidden="true"></i></td>
                                </tr>
                                <tr>
                                  <th scope="row">5</th>
                                  <td>0</td>
                                  <td>Technician Rank 5</td>
                                  <td>Location</td>
                                  <td><i class="fa fa-thumbs-up" aria-hidden="true"></i></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        </div>
                      </div>
                      <div id="placeholder33" style="height: 260px; display: none" class="demo-placeholder"></div>
                      <div style="width: 100%;">
                        <div id="" class="demo-placeholder" >
                          <div class="x_panel">
                          <div class="x_title">
                            <h2>Defaulter List for Technician<small></small></h2>
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Count</th>
                                  <th>Name</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php for ($i=0; $i<count($defaulter_list); $i++) { ?>
                                <tr>
                                  <th scope="row"><?=@$i+1?></th>
                                  <td><?=@$defaulter_list[$i]->count?></td>
                                  <td><?=@$defaulter_list[$i]->first_name?></td>
                                </tr>
                                <?php } ?>
                                <!-- <tr>
                                  <th scope="row">3</th>
                                  <td>0</td>
                                  <td>Technician Rank 3</td>
                                </tr>
                                <tr>
                                  <th scope="row">4</th>
                                  <td>0</td>
                                  <td>Technician Rank 4</td>
                                </tr>
                                <tr>
                                  <th scope="row">5</th>
                                  <td>0</td>
                                  <td>Technician Rank 5</td>
                                </tr> -->
                              </tbody>
                            </table>
                          </div>
                        </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-9 col-xs-12" style="padding: 2%;">
                      <div id="placeholder33" style="height: 260px; display: none" class="demo-placeholder"></div>
                      <div style="width: 100%;">
                        <div id="patients_scanned" class="demo-placeholder" ></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12" style="padding: 2% 0;">
                    <div class="col-md-6 col-sm-9 col-xs-12" style="padding: 2%;">
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
                  <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-6">
                      <div id="chart2"></div>
                    </div>
                    <div class="col-md-6">
                      <div id="chart3"></div>
                    </div>
                  </div>
                </div>

                <!-- commented on 29 Aug 2016 by V -->

                <!-- <div class="col-md-6 col-sm-9 col-xs-12">
                  <div id="placeholder33" style="height: 260px; display: none" class="demo-placeholder"></div>
                  <div style="width: 100%;">
                    <div id="" class="demo-placeholder" ></div>
                  </div>
                </div> -->



                <!-- <div class="col-md-3 col-sm-3 col-xs-12 bg-white">
                  <div class="x_title">
                    <h2>Top Campaign Performance</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-6">
                    <div>
                      <p>Facebook Campaign</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 76%;">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="80"></div>
                        </div>
                      </div>
                    </div>
                    <div>
                      <p>Twitter Campaign</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 76%;">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="60"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-6">
                    <div>
                      <p>Conventional Media</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 76%;">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="40"></div>
                        </div>
                      </div>
                    </div>
                    <div>
                      <p>Bill boards</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 76%;">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                        </div>
                      </div>
                    </div> 
                  </div>
                </div> -->
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div style="width: 100%;">
                  <div id="google-map" class="demo-placeholder" ></div>
                </div>
              </div>
            </div>

          </div>
          <br />

          <!-- <div class="row">


            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="x_panel tile fixed_height_320">
                <div class="x_title">
                  <h2>App Versions</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <h4>App Usage across versions</h4>
                  <div class="widget_summary">
                    <div class="w_left w_25">
                      <span>0.1.5.2</span>
                    </div>
                    <div class="w_center w_55">
                      <div class="progress">
                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 66%;">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </div>
                    <div class="w_right w_20">
                      <span>123k</span>
                    </div>
                    <div class="clearfix"></div>
                  </div>

                  <div class="widget_summary">
                    <div class="w_left w_25">
                      <span>0.1.5.3</span>
                    </div>
                    <div class="w_center w_55">
                      <div class="progress">
                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 45%;">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </div>
                    <div class="w_right w_20">
                      <span>53k</span>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="widget_summary">
                    <div class="w_left w_25">
                      <span>0.1.5.4</span>
                    </div>
                    <div class="w_center w_55">
                      <div class="progress">
                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </div>
                    <div class="w_right w_20">
                      <span>23k</span>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="widget_summary">
                    <div class="w_left w_25">
                      <span>0.1.5.5</span>
                    </div>
                    <div class="w_center w_55">
                      <div class="progress">
                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 5%;">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </div>
                    <div class="w_right w_20">
                      <span>3k</span>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="widget_summary">
                    <div class="w_left w_25">
                      <span>0.1.5.6</span>
                    </div>
                    <div class="w_center w_55">
                      <div class="progress">
                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 2%;">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </div>
                    <div class="w_right w_20">
                      <span>1k</span>
                    </div>
                    <div class="clearfix"></div>
                  </div>

                </div>
              </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="x_panel tile fixed_height_320 overflow_hidden">
                <div class="x_title">
                  <h2>Device Usage</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <table class="" style="width:100%">
                    <tr>
                      <th style="width:37%;">
                        <p>Top 5</p>
                      </th>
                      <th>
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                          <p class="">Device</p>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                          <p class="">Progress</p>
                        </div>
                      </th>
                    </tr>
                    <tr>
                      <td>
                        <canvas id="canvas1" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                      </td>
                      <td>
                        <table class="tile_info">
                          <tr>
                            <td>
                              <p><i class="fa fa-square blue"></i>IOS </p>
                            </td>
                            <td>30%</td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square green"></i>Android </p>
                            </td>
                            <td>10%</td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square purple"></i>Blackberry </p>
                            </td>
                            <td>20%</td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square aero"></i>Symbian </p>
                            </td>
                            <td>15%</td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square red"></i>Others </p>
                            </td>
                            <td>30%</td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>


            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="x_panel tile fixed_height_320">
                <div class="x_title">
                  <h2>Quick Settings</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="dashboard-widget-content">
                    <ul class="quick-list">
                      <li><i class="fa fa-calendar-o"></i><a href="#">Settings</a>
                      </li>
                      <li><i class="fa fa-bars"></i><a href="#">Subscription</a>
                      </li>
                      <li><i class="fa fa-bar-chart"></i><a href="#">Auto Renewal</a> </li>
                      <li><i class="fa fa-line-chart"></i><a href="#">Achievements</a>
                      </li>
                      <li><i class="fa fa-bar-chart"></i><a href="#">Auto Renewal</a> </li>
                      <li><i class="fa fa-line-chart"></i><a href="#">Achievements</a>
                      </li>
                      <li><i class="fa fa-area-chart"></i><a href="#">Logout</a>
                      </li>
                    </ul>

                    <div class="sidebar-widget">
                      <h4>Profile Completion</h4>
                      <canvas width="150" height="80" id="foo" class="" style="width: 160px; height: 100px;"></canvas>
                      <div class="goal-wrapper">
                        <span class="gauge-value pull-left">$</span>
                        <span id="gauge-text" class="gauge-value pull-left">3,200</span>
                        <span id="goal-text" class="goal-value pull-right">$5,000</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div> -->


          <!-- <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Recent Activities <small>Sessions</small></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="dashboard-widget-content">

                    <ul class="list-unstyled timeline widget">
                      <li>
                        <div class="block">
                          <div class="block_content">
                            <h2 class="title">
                                              <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                          </h2>
                            <div class="byline">
                              <span>13 hours ago</span> by <a>Jane Smith</a>
                            </div>
                            <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                            </p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="block">
                          <div class="block_content">
                            <h2 class="title">
                                              <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                          </h2>
                            <div class="byline">
                              <span>13 hours ago</span> by <a>Jane Smith</a>
                            </div>
                            <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                            </p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="block">
                          <div class="block_content">
                            <h2 class="title">
                                              <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                          </h2>
                            <div class="byline">
                              <span>13 hours ago</span> by <a>Jane Smith</a>
                            </div>
                            <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                            </p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="block">
                          <div class="block_content">
                            <h2 class="title">
                                              <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                          </h2>
                            <div class="byline">
                              <span>13 hours ago</span> by <a>Jane Smith</a>
                            </div>
                            <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                            </p>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-md-8 col-sm-8 col-xs-12">



              <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Visitors location <small>geo-presentation</small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="dashboard-widget-content">
                        <div class="col-md-4 hidden-small">
                          <h2 class="line_30">125.7k Views from 60 countries</h2>

                          <table class="countries_list">
                            <tbody>
                              <tr>
                                <td>United States</td>
                                <td class="fs15 fw700 text-right">33%</td>
                              </tr>
                              <tr>
                                <td>France</td>
                                <td class="fs15 fw700 text-right">27%</td>
                              </tr>
                              <tr>
                                <td>Germany</td>
                                <td class="fs15 fw700 text-right">16%</td>
                              </tr>
                              <tr>
                                <td>Spain</td>
                                <td class="fs15 fw700 text-right">11%</td>
                              </tr>
                              <tr>
                                <td>Britain</td>
                                <td class="fs15 fw700 text-right">10%</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div id="world-map-gdp" class="col-md-8 col-sm-12 col-xs-12" style="height:230px;"></div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="row">


                Start to do list 
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>To Do List <small>Sample tasks</small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                      <div class="">
                        <ul class="to_do">
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Schedule meeting with new client </p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Create email address for new intern</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Have IT fix the network printer</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Copy backups to offsite location</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Food truck fixie locavors mcsweeney</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Food truck fixie locavors mcsweeney</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Create email address for new intern</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Have IT fix the network printer</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Copy backups to offsite location</p>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                End to do list
                
                start of weather widget
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Daily active users <small>Sessions</small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="temperature"><b>Monday</b>, 07:30 AM
                            <span>F</span>
                            <span><b>C</b></span>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="weather-icon">
                            <canvas height="84" width="84" id="partly-cloudy-day"></canvas>
                          </div>
                        </div>
                        <div class="col-sm-8">
                          <div class="weather-text">
                            <h2>Texas <br><i>Partly Cloudy Day</i></h2>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="weather-text pull-right">
                          <h3 class="degrees">23</h3>
                        </div>
                      </div>

                      <div class="clearfix"></div>

                      <div class="row weather-days">
                        <div class="col-sm-2">
                          <div class="daily-weather">
                            <h2 class="day">Mon</h2>
                            <h3 class="degrees">25</h3>
                            <canvas id="clear-day" width="32" height="32"></canvas>
                            <h5>15 <i>km/h</i></h5>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="daily-weather">
                            <h2 class="day">Tue</h2>
                            <h3 class="degrees">25</h3>
                            <canvas height="32" width="32" id="rain"></canvas>
                            <h5>12 <i>km/h</i></h5>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="daily-weather">
                            <h2 class="day">Wed</h2>
                            <h3 class="degrees">27</h3>
                            <canvas height="32" width="32" id="snow"></canvas>
                            <h5>14 <i>km/h</i></h5>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="daily-weather">
                            <h2 class="day">Thu</h2>
                            <h3 class="degrees">28</h3>
                            <canvas height="32" width="32" id="sleet"></canvas>
                            <h5>15 <i>km/h</i></h5>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="daily-weather">
                            <h2 class="day">Fri</h2>
                            <h3 class="degrees">28</h3>
                            <canvas height="32" width="32" id="wind"></canvas>
                            <h5>11 <i>km/h</i></h5>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="daily-weather">
                            <h2 class="day">Sat</h2>
                            <h3 class="degrees">26</h3>
                            <canvas height="32" width="32" id="cloudy"></canvas>
                            <h5>10 <i>km/h</i></h5>
                          </div>
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                  </div>

                </div>
                end of weather widget
              </div>
            </div>
          </div> -->
        </div>
        <!-- /page content -->

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

<!-- Flot -->
<script src="https://maps.googleapis.com/maps/api/js?v=3&sensor=false" type="text/javascript"></script>
<script>
  $(document).ready(function() {
    // var data1 = [
    //   [gd(2012, 1, 1), 17],
    //   [gd(2012, 1, 2), 74],
    //   [gd(2012, 1, 3), 6],
    //   [gd(2012, 1, 4), 39],
    //   [gd(2012, 1, 5), 20],
    //   [gd(2012, 1, 6), 85],
    //   [gd(2012, 1, 7), 7]
    // ];

    // var data2 = [
    //   [gd(2012, 1, 1), 82],
    //   [gd(2012, 1, 2), 23],
    //   [gd(2012, 1, 3), 66],
    //   [gd(2012, 1, 4), 9],
    //   [gd(2012, 1, 5), 119],
    //   [gd(2012, 1, 6), 6],
    //   [gd(2012, 1, 7), 9]
    // ];
  //   $("#canvas_dahs").length && $.plot($("#canvas_dahs"), [
  //     data1, data2
  //   ], {
  //     series: {
  //       lines: {
  //         show: false,
  //         fill: true
  //       },
  //       splines: {
  //         show: true,
  //         tension: 0.4,
  //         lineWidth: 1,
  //         fill: 0.4
  //       },
  //       points: {
  //         radius: 0,
  //         show: true
  //       },
  //       shadowSize: 2
  //     },
  //     grid: {
  //       verticalLines: true,
  //       hoverable: true,
  //       clickable: true,
  //       tickColor: "#d5d5d5",
  //       borderWidth: 1,
  //       color: '#fff'
  //     },
  //     colors: ["rgba(38, 185, 154, 0.38)", "rgba(3, 88, 106, 0.38)"],
  //     xaxis: {
  //       tickColor: "rgba(51, 51, 51, 0.06)",
  //       mode: "time",
  //       tickSize: [1, "day"],
  //       //tickLength: 10,
  //       axisLabel: "Date",
  //       axisLabelUseCanvas: true,
  //       axisLabelFontSizePixels: 12,
  //       axisLabelFontFamily: 'Verdana, Arial',
  //       axisLabelPadding: 10
  //     },
  //     yaxis: {
  //       ticks: 8,
  //       tickColor: "rgba(51, 51, 51, 0.06)",
  //     },
  //     tooltip: false
  //   });

    // function gd(year, month, day) {
    //   return new Date(year, month - 1, day).getTime();
    // }
  });
</script>
<!-- /Flot -->

<!-- JQVMap -->
<script>
  // $(document).ready(function(){
  //   $('#world-map-gdp').vectorMap({
  //       map: 'world_en',
  //       backgroundColor: null,
  //       color: '#ffffff',
  //       hoverOpacity: 0.7,
  //       selectedColor: '#666666',
  //       enableZoom: true,
  //       showTooltip: true,
  //       values: sample_data,
  //       scaleColors: ['#E6F2F0', '#149B7E'],
  //       normalizeFunction: 'polynomial'
  //   });
  // });
</script>
<!-- /JQVMap -->

<!-- Skycons -->
<script>
  function initialize(id){
      var lat = '20.591586';
      var lon = '78.961358';
      var zm = 15;
      var zoomd = 15;
      map = new google.maps.Map(document.getElementById('google-map'), {
          zoom: zoomd,
          center: new google.maps.LatLng(lat, lon),
          mapTypeControlOptions: {
                mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
              },
              mapTypeId: MY_MAPTYPE_ID
      });
      var styles = [
          {
          featureType: 'all',
          elementType: 'all',
            stylers: [
              { hue: '#0800ff' },
              { invert_lightness: 'true' },
              { saturation: -100 }
            ]
          },
          {
          featureType: 'all',
          elementType: 'labels.icon',
            stylers: [
              { visibility: 'off' }
            ]
          },
          {
          featureType: 'all',
          elementType: 'labels.text',
            stylers: [
              { visibility: 'off' }
            ]
          },
          {
          featureType: 'road.arterial',
          elementType: 'labels',
            stylers: [
              { visibility: 'on' }
            ]
          },
      ];
      var styledMapOptions = {
          name: 'Mumbai Parties'
      };
      var customMapType = new google.maps.StyledMapType(styles, styledMapOptions);
      map.mapTypes.set(MY_MAPTYPE_ID, customMapType);
      $.ajax({
          url:'http://mumbaiparties.com/index.php/api/get_entities_list/',
          type: 'post',
          crossDomain:true,
          data: {
              id : "1"
          },
          success: function(data){
              console.log(data);
              $.each(data, function(index, value){
                  var v = value.latitude;
                  var s = value.longitude;
                  var bar = value.entity_name;
                  console.log(v+' '+s);
                  var eventtype = $('#filter_id').val();
                  
                  //google.maps.Marker
                  var marker1 = new google.maps.Marker({
                      position: new google.maps.LatLng(v, s),
                      map: map,
                      // icon: 'img/party-meter.gif',
                      icon: value.marker,
                      labelContent: bar,
                      labelAnchor: new google.maps.Point(-10, 20),
                      labelClass: value.css,
                      labelInBackground: false
                  });
                  
                  var marker = new MarkerWithLabel({
                      position: new google.maps.LatLng(v, s),
                      map: map,
                      // icon: 'img/party-meter.gif',
                      icon: value.marker,
                      labelContent: bar,
                      labelAnchor: new google.maps.Point(-10, 20),
                      labelClass: value.css,
                      labelInBackground: false
                  });
                  
                  google.maps.event.addListener(marker, 'click', function(marker, i) {
                      geteventsbyentity(value.id);
                  });
                  
                  google.maps.event.addListener(marker1, 'click', function(marker, i) {
                      geteventsbyentity(value.id);
                  });
              });
          }
      })
      $('.loader').fadeOut();
        }
  // $(document).ready(function() {
  //   var icons = new Skycons({
  //       "color": "#73879C"
  //     }),
  //     list = [
  //       "clear-day", "clear-night", "partly-cloudy-day",
  //       "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
  //       "fog"
  //     ],
  //     i;

  //   for (i = list.length; i--;)
  //     icons.set(list[i], list[i]);

  //   icons.play();
  // });
</script>
<!-- /Skycons -->

<!-- Doughnut Chart -->
<script>
  // $(document).ready(function(){
  //   var options = {
  //     legend: false,
  //     responsive: false
  //   };

  //   new Chart(document.getElementById("canvas1"), {
  //     type: 'doughnut',
  //     tooltipFillColor: "rgba(51, 51, 51, 0.55)",
  //     data: {
  //       labels: [
  //         "Symbian",
  //         "Blackberry",
  //         "Other",
  //         "Android",
  //         "IOS"
  //       ],
  //       datasets: [{
  //         data: [15, 20, 30, 10, 30],
  //         backgroundColor: [
  //           "#BDC3C7",
  //           "#9B59B6",
  //           "#E74C3C",
  //           "#26B99A",
  //           "#3498DB"
  //         ],
  //         hoverBackgroundColor: [
  //           "#CFD4D8",
  //           "#B370CF",
  //           "#E95E4F",
  //           "#36CAAB",
  //           "#49A9EA"
  //         ]
  //       }]
  //     },
  //     options: options
  //   });
  // });
</script>
<!-- /Doughnut Chart -->

<!-- bootstrap-daterangepicker -->
<script>
  // $(document).ready(function() {

  //   var cb = function(start, end, label) {
  //     console.log(start.toISOString(), end.toISOString(), label);
  //     $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  //   };

  //   var optionSet1 = {
  //     startDate: moment().subtract(29, 'days'),
  //     endDate: moment(),
  //     minDate: '01/01/2012',
  //     maxDate: '12/31/2015',
  //     dateLimit: {
  //       days: 60
  //     },
  //     showDropdowns: true,
  //     showWeekNumbers: true,
  //     timePicker: false,
  //     timePickerIncrement: 1,
  //     timePicker12Hour: true,
  //     ranges: {
  //       'Today': [moment(), moment()],
  //       'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
  //       'Last 7 Days': [moment().subtract(6, 'days'), moment()],
  //       'Last 30 Days': [moment().subtract(29, 'days'), moment()],
  //       'This Month': [moment().startOf('month'), moment().endOf('month')],
  //       'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
  //     },
  //     opens: 'left',
  //     buttonClasses: ['btn btn-default'],
  //     applyClass: 'btn-small btn-primary',
  //     cancelClass: 'btn-small',
  //     format: 'MM/DD/YYYY',
  //     separator: ' to ',
  //     locale: {
  //       applyLabel: 'Submit',
  //       cancelLabel: 'Clear',
  //       fromLabel: 'From',
  //       toLabel: 'To',
  //       customRangeLabel: 'Custom',
  //       daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
  //       monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
  //       firstDay: 1
  //     }
  //   };
  //   $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
  //   $('#reportrange').daterangepicker(optionSet1, cb);
  //   $('#reportrange').on('show.daterangepicker', function() {
  //     console.log("show event fired");
  //   });
  //   $('#reportrange').on('hide.daterangepicker', function() {
  //     console.log("hide event fired");
  //   });
  //   $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
  //     console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
  //   });
  //   $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
  //     console.log("cancel event fired");
  //   });
  //   $('#options1').click(function() {
  //     $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
  //   });
  //   $('#options2').click(function() {
  //     $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
  //   });
  //   $('#destroy').click(function() {
  //     $('#reportrange').data('daterangepicker').remove();
  //   });
  // });
</script>
<!-- /bootstrap-daterangepicker -->

<!-- gauge.js -->
<script>
  // var opts = {
  //     lines: 12,
  //     angle: 0,
  //     lineWidth: 0.4,
  //     pointer: {
  //         length: 0.75,
  //         strokeWidth: 0.042,
  //         color: '#1D212A'
  //     },
  //     limitMax: 'false',
  //     colorStart: '#1ABC9C',
  //     colorStop: '#1ABC9C',
  //     strokeColor: '#F0F3F3',
  //     generateGradient: true
  // };
  // var target = document.getElementById('foo'),
  //     gauge = new Gauge(target).setOptions(opts);

  // gauge.maxValue = 6000;
  // gauge.animationSpeed = 32;
  // gauge.set(3200);
  // gauge.setTextField(document.getElementById("gauge-text"));
</script>
<!-- /gauge.js -->

<!-- high charts -->
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/mapdata/countries/in/custom/in-all-andaman-and-nicobar.js"></script>

<!-- high charts -->
<script>
$(function () {
    load_chart1();
    load_chart2();
    // load_chart2();
    // Prepare demo data
    var data = [
        {
            "hc-key": "in-5390",
            "value": 0
        },
        {
            "hc-key": "in-py",
            "value": 1
        },
        {
            "hc-key": "in-ld",
            "value": 2
        },
        {
            "hc-key": "in-an",
            "value": 3
        },
        {
            "hc-key": "in-wb",
            "value": 4
        },
        {
            "hc-key": "in-or",
            "value": 5
        },
        {
            "hc-key": "in-br",
            "value": 6
        },
        {
            "hc-key": "in-sk",
            "value": 7
        },
        {
            "hc-key": "in-ct",
            "value": 8
        },
        {
            "hc-key": "in-tn",
            "value": 9
        },
        {
            "hc-key": "in-mp",
            "value": 10
        },
        {
            "hc-key": "in-2984",
            "value": 11
        },
        {
            "hc-key": "in-ga",
            "value": 12
        },
        {
            "hc-key": "in-nl",
            "value": 13
        },
        {
            "hc-key": "in-mn",
            "value": 14
        },
        {
            "hc-key": "in-ar",
            "value": 15
        },
        {
            "hc-key": "in-mz",
            "value": 16
        },
        {
            "hc-key": "in-tr",
            "value": 17
        },
        {
            "hc-key": "in-3464",
            "value": 18
        },
        {
            "hc-key": "in-dl",
            "value": 19
        },
        {
            "hc-key": "in-hr",
            "value": 20
        },
        {
            "hc-key": "in-ch",
            "value": 21
        },
        {
            "hc-key": "in-hp",
            "value": 22
        },
        {
            "hc-key": "in-jk",
            "value": 23
        },
        {
            "hc-key": "in-kl",
            "value": 24
        },
        {
            "hc-key": "in-ka",
            "value": 25
        },
        {
            "hc-key": "in-dn",
            "value": 26
        },
        {
            "hc-key": "in-mh",
            "value": 27
        },
        {
            "hc-key": "in-as",
            "value": 28
        },
        {
            "hc-key": "in-ap",
            "value": 29
        },
        {
            "hc-key": "in-ml",
            "value": 30
        },
        {
            "hc-key": "in-pb",
            "value": 31
        },
        {
            "hc-key": "in-rj",
            "value": 32
        },
        {
            "hc-key": "in-up",
            "value": 33
        },
        {
            "hc-key": "in-ut",
            "value": 34
        },
        {
            "hc-key": "in-jh",
            "value": 35
        }
    ];

    // Initiate the chart
    $('#canvas_dahs').highcharts('Map', {

        title : {
            text : 'Total No. of Camps'
        },

        subtitle : {
            text : ''
        },

        mapNavigation: {
            enabled: true,
            buttonOptions: {
                verticalAlign: 'bottom'
            }
        },

        colorAxis: {
            min: 0
        },

        series : [{
            data : data,
            mapData: Highcharts.maps['countries/in/custom/in-all-andaman-and-nicobar'],
            joinBy: 'hc-key',
            name: 'Random data',
            states: {
                hover: {
                    color: '#BADA55'
                }
            },
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }]
    });

    // Initiate the chart
    $('#doctor_engaged').highcharts('Map', {

        title : {
            text : 'Doctors Engaged'
        },

        subtitle : {
            text : ''
        },

        mapNavigation: {
            enabled: true,
            buttonOptions: {
                verticalAlign: 'bottom'
            }
        },

        color: {
            linearGradient: { x1: 0, x2: 0, y1: 0, y2: 1 },
            stops: [
                [0, '#000000'],
                [1, '#151515']
            ]
        },

        colorAxis: {
            min: 0
        },

        series : [{
            data : data,
            mapData: Highcharts.maps['countries/in/custom/in-all-andaman-and-nicobar'],
            joinBy: 'hc-key',
            name: 'Random data',
            states: {
                hover: {
                    color: '#BADA55'
                }
            },
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }]
    });

    $('#patients_scanned').highcharts('Map', {
        title : {
            text : 'Total No. of Patients Scanned'
        },
        subtitle : {
            text : ''
        },
        mapNavigation: {
            enabled: true,
            buttonOptions: {
                verticalAlign: 'bottom'
            }
        },
        colorAxis: {
            min: 0
        },

        series : [{
            data : data,
            mapData: Highcharts.maps['countries/in/custom/in-all-andaman-and-nicobar'],
            joinBy: 'hc-key',
            name: 'Random data',
            states: {
                hover: {
                    color: '#BADA55'
                }
            },
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }]
    });
});
  
  function load_chart1(){
    var cat = [];
    var data = [];
    $.ajax({
      url : '<?=base_url()?>'+'admin/getcamp_clinic_count',
      type : 'post',
      success : function(res){
        var obj = JSON.parse(res);
        var html = '';
        $.each(obj.data, function(index, value){
          data.push(Number(value.count));
          cat.push(value.camp_type);
        })
        console.log(data);
        $('#chart2').highcharts({
            chart: {
                type: 'column',
                options3d: {
                    enabled: true,
                    alpha: 10,
                    beta: 25,
                    depth: 70
                }
            },
            title: {
                text: 'No. of Camp - Clinic'
            },
            subtitle: {
                text: ''
            },
            plotOptions: {
                column: {
                    depth: 25
                }
            },
            xAxis: {
                categories: cat
            },
            yAxis: {
                title: {
                    text: null
                }
            },
            series: [{
                name: 'Camp - Clinic',
                data: data
            }]
        });
      }
    })
  }

  function load_chart2(){
    var cat = [];
    var data = [];
    $.ajax({
      url : '<?=base_url()?>'+'admin/getcamp_clinic_count',
      type : 'post',
      success : function(res){
        var obj = JSON.parse(res);
        var html = '';
        $.each(obj.data, function(index, value){
          data.push(Number(value.count));
          cat.push(value.camp_type);
        })
        console.log(data);
        $('#chart3').highcharts({
            chart: {
                type: 'column',
                options3d: {
                    enabled: true,
                    alpha: 10,
                    beta: 25,
                    depth: 70
                }
            },
            title: {
                text: 'No. of Government / Non Government'
            },
            subtitle: {
                text: ''
            },
            plotOptions: {
                column: {
                    depth: 25
                }
            },
            xAxis: {
                categories: cat
            },
            yAxis: {
                title: {
                    text: null
                }
            },
            series: [{
                name: 'Camp - Clinic',
                data: data
            }]
        });
      }
    })
  }

</script>
<!-- /high charts -->
  </body>
</html>
