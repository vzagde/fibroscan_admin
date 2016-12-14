<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once( 'includes/head.php'); ?>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <?php include_once( 'includes/sidebar.php'); ?>
        <?php include_once('includes/topbar.php'); ?>
        
        <div class="right_col" role="main" style="min-height: 3788px;">
            <!-- <?php echo $output; ?> -->
            <table border="2">
                <tr>
                    <th>user id</th>
                    <th>machine id</th>
                    <th>start time</th>
                    <th>end time</th>
                    <th>location</th>
                    <th>approved</th>
                    <th>date</th>
                    <th>cancel</th>
                    <th>cancel approved</th>
                    <th>camp type</th>
                    <th>completed</th>
                    <th>doctor id</th>
                    <th>doctor speciality id</th>
                    <th>expd no of registration</th>
                    <th>book a machine</th>
                    <th>available at camp</th>
                </tr>
                <?php foreach ($list as $key => $value) { ?>
                <tr>
                    <td><?=@$value->user_id?></td>
                    <td><?=@$value->machine_id?></td>
                    <td><?=@$value->start_time?></td>
                    <td><?=@$value->end_time?></td>
                    <td><?=@$value->location?></td>
                    <td><?=@$value->approved?></td>
                    <td><?=@$value->date?></td>
                    <td><?=@$value->cancel?></td>
                    <td><?=@$value->cancel_approved?></td>
                    <td><?=@$value->camp_type?></td>
                    <td><?=@$value->completed?></td>
                    <td><?=@$value->doctor_id?></td>
                    <td><?=@$value->doctor_speciality_id?></td>
                    <td><?=@$value->expd_no_of?></td>
                    <td><?=@$value->book_a_machine?></td>
                    <td><?=@$value->available_at_camp?></td>
                </tr>
                <?php } ?>
            </table>
        </div>

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Abbott - App Admin Dashboard by <a href="http://kreaserv.com">Kreaserv</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
    <?php include_once( 'includes/footer.php'); ?>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/heatmap.js"></script>
    <script src="https://code.highcharts.com/modules/treemap.js"></script>
  </body>
</html>
