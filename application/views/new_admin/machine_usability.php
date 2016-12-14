<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once( 'includes/head.php'); ?>
    <!-- Select2 -->
    <link href="<?=base_url()?>assets/new_admin/vendors/select2/dist/css/select2.min.css" rel="stylesheet">

    <style>
        select {
            margin-left: 10px;
        }
    </style>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <?php include_once( 'includes/sidebar.php'); ?>
        <?php include_once('includes/topbar.php'); ?>

        <div class="right_col" role="main" style="min-height: 3788px;">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Machine Usability</h3>
              </div>

              <div class="title_right">
                <div class="col-md-12 col-sm-12 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <select class="form-control" name="year" id="year">
                                    <option value="">year</option>
                                    <?php while ($min_date <= $max_date) {
                                        if ($max_date == date('Y')) {
                                    ?>
                                    <option selected="" value="<?=$max_date?>"><?=$max_date?></option>
                                    <?php } else { ?>
                                    <option value="<?=$max_date?>"><?=$max_date?></option>
                                    <?php } $max_date--; } ?>
                                </select>
                            </div>

                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <select class="form-control" name="month" id="month">
                                    <option value="">month</option>
                                    <?php
                                    for ($i=1; $i <= 12; $i++) {
                                        if ($i==date('m')) { ?>
                                    <option value="<?=$i?>" selected=""><?=$i?></option>
                                    <?php
                                        } else { ?>
                                    <option value="<?=$i?>"><?=$i?></option>
                                    <?php
                                        } ?>
                                    <?php
                                    } ?>
                                </select>
                            </div>

                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <select class="form-control" name="city" id="city">
                                    <option value="">city</option>
                                    <?php for ($i=0; $i < count($cities); $i++) { ?>
                                    <option value="<?=$cities[$i]->id?>"><?=$cities[$i]->name?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <select class="form-control" name="location" id="location">
                                    <option value="2" selected="">Jama Masjid</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div id="chart1"></div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div id="chart2"></div>
              </div>
            </div>
            <br>
            <div class="row">
            </div>
          </div>
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
    <!-- Select2 -->
    <script src="<?=base_url()?>assets/new_admin/vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="<?=base_url()?>assets/new_admin/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>

    <!-- high chart -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <!-- /high chart -->
<script type="text/javascript">
$(function() {
  var d = new Date();
  var y = d.getFullYear();
  var m = d.getMonth() + 1;
  get_chart_data(2, y, m);

    $('#city').change(function(event) {
        var city = $('#city').val();

        if(city=='') {
            alert('please, check any city.');
            return false;
        }

        $.ajax({
            url: '<?=base_url()?>' + 'admin/getLocation',
            type: 'POST',
            dataType: 'json',
            data: {
                city: city
            },
        })
        .done(function(res) {
            console.log("success: "+j2s(res));
            if (res.status=='success') {
                $('#location').html('<option value="">location</option>');
                res.data.map(function(val, index) {
                    console.log('data: '+j2s(val));
                    console.log('data: '+j2s(index));
                    if (index==1)
                        $('#location').append('<option selected="" value="'+val.id+'">'+val.name+'</option>');
                    else
                        $('#location').append('<option value="'+val.id+'">'+val.name+'</option>');
                })
            }
        })
        .fail(function(err) {
            console.log("error: "+j2s(err));
        })
        .always(function() {
            console.log("complete");
        });

    });

    $('#location, #year, #month').change(function(event) {
        var location = $('#location').val();
        var year = $('#year').val();
        var month = $('#month').val();

        if (location=='' || month=='' || year=='') {
            alert('please, fill all data');
            return false;
        }

        get_chart_data(location, year, month);
    });
});

function get_chart_data(location, year, month) {
  $.ajax({
      url: '<?=base_url()?>' + 'admin/get_machine_usability',
      type: 'POST',
      dataType: 'json',
      data: {
        location: location,
        year: year,
        month: month
      },
    })
    .done(function(res) {
      console.log("success: " + j2s(res));
      if (res.status == 'success') {
        draw_chart(res.data);
      }
    })
    .fail(function(err) {
      console.log("error: " + j2s(err));
    })
    .always(function() {
      console.log("complete");
    });
}

function draw_chart(chartData) {
    var completed = 0;
    var planned = 0;
    var completedCheck = 0;
    var plannedCheck = 0;

    var machines = [];

    var data1 = [];
    var data2 = [];
    var i = 0;

    for (singleMachine in chartData) {
        completed = parseInt(chartData[singleMachine].completed);
        planned = parseInt(chartData[singleMachine].planned);

        completedCheck += completed;
        plannedCheck += planned;

        i += 1;
        if (i == size(chartData)) {
            data1.push({'name': singleMachine, 'y': completed, 'sliced': true, 'selected': true});
            data2.push({'name': singleMachine, 'y': planned, 'sliced': true, 'selected': true});
        } else {
            data1.push([ singleMachine, completed ]);
            data2.push([singleMachine, planned]);
        }
    }

    console.log('data1: '+j2s(data1));
    console.log('data2: '+j2s(data2));

    if (completedCheck==0) {
        $('#chart1').empty();
        $('#chart1').html("<h3>Total is zero</h3>");
    } else {
        $('#chart1').highcharts({
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                }
            },
            title: {
                text: 'Completed camp by machine'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    depth: 35,
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}'
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Machine Usability by Location',
                data: data1
            }]
        });
    }

    if (plannedCheck==0) {
        $('#chart2').empty();
        $('#chart2').html("<h3>Total is zero</h3>");
    } else {
        $('#chart2').highcharts({
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                }
            },
            title: {
                text: 'Planned camp by machine'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    depth: 35,
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}'
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Machine Usability by Location',
                data: data2
            }]
        });
    }
}

var size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
}

function j2s(json) {
  return JSON.stringify(json);
}
</script>
  </body>
</html>
