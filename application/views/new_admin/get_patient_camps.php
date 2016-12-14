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
          <div class="" id="charts">
            <div class="page-title">
              <div class="title_left">
                <h3>Patient Camp Disease Data</h3>
              </div>

              <div class="title_right">
                <div class="form-group pull-right top_search">
                    <div class="row">
                        <div class=" col-md-2 col-sm-12 col-xs-12 ">
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

                        <div class=" col-md-2 col-sm-12 col-xs-12 ">
                            <select class="form-control" name="month" id="month">
                                <option value="">month</option>
                                <?php for ($i=0; $i < 12; $i++) {
                                    if ($i==date('m')) { ?>
                                <option value="<?=$i?>" selected=""><?=$i?></option>
                                <?php } else { ?>
                                <option value="<?=$i?>"><?=$i?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>

                        <div class=" col-md-2 col-sm-12 col-xs-12 ">
                            <select class="form-control" name="city" id="city">
                                <option value="">city</option>
                                <?php for ($i=0; $i < count($cities); $i++) { ?>
                                <option value="<?=$cities[$i]->id?>"><?=$cities[$i]->name?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class=" col-md-2 col-sm-12 col-xs-12 ">
                            <select class="form-control" name="location" id="location">
                                <option value="2" selected="">Jama Masjid</option>
                            </select>
                        </div>

                        <!-- <div class=" col-md-2 col-sm-12 col-xs-12 ">
                            <select class="form-control" name="user" id="user">
                                <option value="4" selected="">Dipesh Pithwa</option>
                            </select>
                        </div> -->

                        <div class=" col-md-2 col-sm-12 col-xs-12 ">
                            <button class="btn btn-success " id="sbmt-btn" style="font-size: 10px;">GET</button>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="clearfix" ></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="chartBar"></div>
              </div>
            </div>
            <br>
            <div class="clearfix" ></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="chartBar1"></div>
              </div>
            </div>
            <br>
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
    <script src="https://code.highcharts.com/modules/exporting.js"></script>

    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
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

    $('#sbmt-btn').click(function(event) {
        var location = $('#location').val();
        var year = $('#year').val();
        var month = $('#month').val();
        // var user = $('#user').val();

        if (location=='' || month=='' || year=='') {
            alert('please, fill all data');
            return false;
        }

        get_chart_data(location, year, month);
        get_chart_data1(location, year, month);
    });
});

function get_chart_data(location, year, month) {
    console.log('data: '+location+' '+year+' '+month);
    $.ajax({
      url: '<?=base_url()?>' + 'admin/get_patient_camps_by_month',
      type: 'POST',
      dataType: 'json',
      data: {
        location: location,
        year: year,
        month: month,
      },
    })
    .done(function(res) {
      // console.log("success: " + j2s(res));
      if (res.status == 'success') {
        console.log(res.data);
        draw_chart(res.data);
        draw_chart1(res.data1);
      }
    })
    .fail(function(err) {
      console.log("error: " + j2s(err));
    })
    .always(function() {
      console.log("complete");
      // draw_chart(location);
    });
}

function draw_chart1(data){
    var obj = JSON.parse(data);
    console.log(obj);
    var categories = [];
    var series = [];
    for (var i = 1; i < 32; i++) {
        categories.push(i);
    };
    $.each(obj, function(index, value){
        var disease = [];
        var count = value.count.split(", ");
        for (var i = 0; i < count.length; i++) {
            disease.push(Number(count[i]));
        };
        console.log(disease);
        series.push({name: value.disease, data: disease});

    //     series_data = [];
    //     $.each(data, function(index, val) {
    //         for (var i = 1; i <= 31; i++) {
    //             if (Date('2016-08-'+i) != Date(val.date)) {
    //                 // series_data.push(0);
    //             } else if (val.indication != value.name) {
    //                 // series_data.push(0);
    //             } else {
    //                 series_data.push(Number(val.count));
    //             }
    //             categories.push(i);
    //         }
    //     })
    //     console.log("series_data"+series_data);
    //     series.push({name: value.name, data: [series_data]});
    //     // series.push({name: value.name, data: [series_data]});
    })

    console.log(series);

    $('#chartBar1').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Monthly Patients Detected as per Disease'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: categories,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: series
    });
}

function draw_chart(chartData) {
    // console.log('chartData: '+j2s(chartData));


    var categories = [];
    var tokyo = [];
    var newyork = [];
    var london = [];
    var berlin = [];
    var max = 0;

    for (date in chartData) {
        // console.log('date: '+chartData[date]);
        var size = sizeOfObject(chartData[date]);
        // console.log('size: '+size);
        if (size>max) max=size;
    }
    // console.log('max: '+max);
    var series = [];
    for (var i = 0; i < max; i++) {
        series.push({
            name: 'CAMP-'+i,
            data: []
        }); // max
    }
    // console.log('series: '+j2s(series));
    for (var i = 1; i < 32; i++) {
        categories.push(''+i);

        var num_patients = 0;
        // console.log('chartData[i]: '+j2s(chartData[i]));
        var n = 0;
        camp_size = sizeOfObject(chartData[i]);
        if (camp_size==0) {
            for (var j = 0; j < max; j++) {
                series[j].data.push(0);
            }
        }
        for (camp in chartData[i]) {
            // console.log('camp: '+chartData[i][camp]);
            series[n].data.push(parseFloat(chartData[i][camp]));
            if (camp_size==n+1) {
                for (var j = n+1; j < max; j++) {
                    // console.log('here');
                    series[j].data.push(0);
                }
            }

            n+=1;
        }

        // tokyo.push(parseFloat(Math.random() * (240.120 - 100.0200) + 100.0200));
        // newyork.push(parseFloat(Math.random() * (240.120 - 100.0200) + 100.0200));
        // london.push(parseFloat(Math.random() * (240.120 - 100.0200) + 100.0200));
        // berlin.push(parseFloat(Math.random() * (240.120 - 100.0200) + 100.0200));
    }
    // console.log('series: '+j2s(series));

    for (var i = 0; i < series.length; i++) {
        // console.log('ser len: '+series[i].data.length);
    }

    // console.log(j2s(categories));
    // console.log(j2s(tokyo));
    // console.log(j2s(newyork));
    // console.log(j2s(london));
    // console.log(j2s(berlin));
    //
    var seriese = [{
            name: 'CAMP-01',
            data: tokyo

        }, {
            name: 'CAMP-02',
            data: newyork

        }, {
            name: 'CAMP-03',
            data: london

        }, {
            name: 'CAMP-04',
            data: berlin

        }];

    $('#chartBar').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Patient Camp Disease'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: categories,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Number of pateints'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} patients</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: series
    });
}

function sizeOfObject(obj) {
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
