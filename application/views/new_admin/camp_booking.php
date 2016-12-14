<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once( 'includes/head.php'); ?>
    <!-- Select2 -->
    <link href="<?=base_url()?>assets/new_admin/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
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
                <h3>Camp Utilization</h3>
              </div>

              <!-- <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div> -->
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="chart"></div>
              </div>
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
    <script src="https://code.highcharts.com/modules/heatmap.js"></script>
    <script src="https://code.highcharts.com/modules/treemap.js"></script>
    <!-- /high chart -->
<script type="text/javascript">
$(function() {
  var d = new Date();
  var y = d.getFullYear();
  var m = d.getMonth() + 1;
  get_chart_data(y, m);
});

function get_chart_data(year, month) {
  $.ajax({
      url: '<?=base_url()?>' + 'admin/get_camp_booking',
      type: 'POST',
      dataType: 'json',
      data: {
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
  var data = chartData,
    points = [],
    regionP,
    regionVal,
    regionI = 0,
    countryP,
    countryI,
    causeP,
    causeI,
    region,
    country,
    cause,
    causeName = {
      'completed': 'completed',
      'canceled': 'canceled',
      'total': 'total',
      'planned': 'planned'
    };

    data = {
            'Delhi': {
                'Jama Masjid': {
                    'completed': '75.5',
                    'canceled': '89.0',
                    'total': '501.2',
                    'planned': '50.2'
                },
                'Sansad Bhavan': {
                    'completed': '548.9',
                    'canceled': '64.0',
                    'total': '234.6',
                    'planned': '50.2'
                },
                'Rashtrapati Bhavan': {
                    'completed': '316.4',
                    'canceled': '102.0',
                    'total': '708.7',
                    'planned': '50.2'
                },
                'Connaught Place': {
                    'completed': '35.0',
                    'canceled': '487.2',
                    'total': '59.2',
                    'planned': '50.2'
                },
                'Lodhi Gardens': {
                    'completed': '91.9',
                    'canceled': '751.4',
                    'total': '117.3',
                    'planned': '50.2'
                },
                'Purana Quila': {
                    'completed': '142.2',
                    'canceled': '572.8',
                    'total': '186.9',
                    'planned': '50.2'
                },
                'Salimgarh Fort': {
                    'completed': '72.8',
                    'canceled': '123.3',
                    'total': '449.1',
                    'planned': '50.2'
                }
            },
            'Mumbai': {
                'Andheri Sports Complex': {
                    'completed': '16.8',
                    'canceled': '602.8',
                    'total': '44.3',
                    'planned': '50.2'
                },
                'Cross Maidan': {
                    'completed': '22.6',
                    'canceled': '494.5',
                    'total': '48.9',
                    'planned': '50.2'
                },
                'Shivaji Park': {
                    'completed': '31.2',
                    'canceled': '311.2',
                    'total': '20.8',
                    'planned': '50.2'
                }
            },
            'Bangalore': {
                'Lal Bagh': {
                    'completed': '756.8',
                    'canceled': '133.6',
                    'total': '729.0',
                    'planned': '50.2'
                },
                'Bangalore Palace': {
                    'completed': '648.6',
                    'canceled': '429.9',
                    'total': '89.0',
                    'planned': '50.2'
                },
                'Wonderla': {
                    'completed': '884.3',
                    'canceled': '119.5',
                    'total': '702.4',
                    'planned': '50.2'
                },
                'Nandi Hills ': {
                    'completed': '94.3',
                    'canceled': '34.5',
                    'total': '1102.4',
                    'planned': '50.2'
                }
            },
            'Ludhiana': {
                'Niran Kari Nagar': {
                    'completed': '344.8',
                    'canceled': '111.6',
                    'total': '444.0',
                    'planned': '50.2'
                },
                'Bangalore Palace': {
                    'completed': '648.6',
                    'canceled': '429.9',
                    'total': '89.0',
                    'planned': '50.2'
                },
                'Wonderla': {
                    'completed': '884.3',
                    'canceled': '119.5',
                    'total': '702.4',
                    'planned': '50.2'
                },
                'Nandi Hills ': {
                    'completed': '94.3',
                    'canceled': '34.5',
                    'total': '1102.4',
                    'planned': '50.2'
                }
            }
        };

        data = chartData;
        console.log('charData: '+j2s(chartData));
        // console.log('data: '+j2s(data));
        // data = chartData;

        // data = {
        //   "Delhi": {
        //     "Jama Masjid": {
        //       "completed": "75.5",
        //       "canceled": "89.0",
        //       "total": "501.2"
        //     }
        //   }
        // };
        console.log('charData: '+j2s(data));

        for (region in data) {
            if (data.hasOwnProperty(region)) {
                regionVal = 0;
                regionP = {
                    id: 'id_' + regionI,
                    name: region,
                    color: Highcharts.getOptions().colors[regionI]
                };
                countryI = 0;
                for (country in data[region]) {
                    if (data[region].hasOwnProperty(country)) {
                        countryP = {
                            id: regionP.id + '_' + countryI,
                            name: country,
                            parent: regionP.id
                        };
                        points.push(countryP);
                        causeI = 0;
                        for (cause in data[region][country]) {
                            if (data[region][country].hasOwnProperty(cause)) {
                                // console.log('cause: '+cause);
                                // console.log('causeName[cause]: '+causeName[cause]);
                                causeP = {
                                    id: countryP.id + '_' + causeI,
                                    name: causeName[cause],
                                    parent: countryP.id,
                                    value: Math.round(+data[region][country][cause])
                                };
                                regionVal += causeP.value;
                                points.push(causeP);
                                causeI = causeI + 1;
                            }
                        }
                        countryI = countryI + 1;
                    }
                }
                regionP.value = Math.round(regionVal / countryI);
                points.push(regionP);
                regionI = regionI + 1;
            }
        }
  // console.log('points: '+j2s(points));

  $('#chart').highcharts({
    series: [{
      type: 'treemap',
      layoutAlgorithm: 'squarified',
      allowDrillToNode: true,
      animationLimit: 1000,
      dataLabels: {
        enabled: false
      },
      levelIsConstant: false,
      levels: [{
        level: 1,
        dataLabels: {
          enabled: true
        },
        borderWidth: 3
      }],
      data: points
    }],
    subtitle: {
      text: ''
    },
    title: {
      text: 'Area wise camp bifurcation.'
    }
  });
}

function j2s(json) {
  return JSON.stringify(json);
}
</script>
  </body>
</html>
