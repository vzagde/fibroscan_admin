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
                    <h3>Patients Graphs</h3>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 form-group top_search">
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group top_search">
                        <label>Start Date</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            <input type="date" class="form-control" placeholder="Start Date" aria-describedby="basic-addon1" id="startdate" onblur="onBlurLoadGraph()">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group top_search">
                        <label>End Date</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            <input type="date" class="form-control" placeholder="Start Date" aria-describedby="basic-addon1" id="enddate" onblur="onBlurLoadGraph()">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group top_search">
                        <label>Select City</label>
                        <select class="form-control" id="city" onchange="onBlurLoadGraph()">
                            <option value="0">Select City</option>
                            <?php foreach ($city as $value) { ?>
                            <option value="<?=@$value['id']?>"><?=@$value['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group top_search">
                        <label>Select Location</label>
                        <select class="form-control" id="location" onchange="onBlurLoadGraph()">
                            <option value="0">Select Location</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-4 col-sm-12 col-xs-12">
                <div id="container2"></div>
              </div>
              <div class="col-md-4 col-sm-12 col-xs-12">
                <div id="container1"></div>
              </div>
              <div class="col-md-4 col-sm-12 col-xs-12">
                <div id="container4"></div>
              </div>
            </div>
            <br>
            <br>
            <br>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="container5"></div>
              </div>
              <!-- <div class="col-md-6 col-sm-12 col-xs-12">
                <div id="container3"></div>
              </div> -->
            </div>
            <br>
            <br>
            <br>
            <div class="row">
            </div>
          </div>
        </div>
        <footer>
          <div class="pull-right">
            Abbott - App Admin Template by <a href="http://kreaserv.com">Kreaserv</a>
          </div>
          <div class="clearfix"></div>
        </footer>
      </div>
    </div>
    <?php include_once( 'includes/footer.php'); ?>
    <script src="<?=base_url()?>assets/new_admin/vendors/select2/dist/js/select2.full.min.js"></script>
    <script src="<?=base_url()?>assets/new_admin/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script type="text/javascript">
    $(function() {
        onBlurLoadGraph();
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
                if (res.status=='success') {
                    $('#location').html('<option value="">location</option>');
                    res.data.map(function(val, index) {
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
            // var location = $('#location').val();
            // var year = $('#year').val();
            // var month = $('#month').val();
            // if (location=='' || month=='' || year=='') {
            //     alert('please, fill all data');
            //     return false;
            // }
            // get_chart_data(location, year, month);
        });
    });

    function onBlurLoadGraph(){
        var start_date = $('#startdate').val();
        var end_date = $('#enddate').val();
        var location = $('#location').val();
        var city = $('#city').val();
        // return false;
        get_values(start_date, end_date, location, city);
    }

    function get_values(start_date, end_date, location, city){
        $.ajax({
            url: '<?=base_url()?>' + 'admin/get_patients_age',
            type: 'POST',
            dataType: 'json',
            data: {
                location: location,
                city: city,
                start_date: start_date,
                end_date: end_date,
            },
        })
        .done(function(res) {
            draw_chart(res.data);
            draw_chart1(res.data1);
            // draw_chart2(res.data2);
            draw_chart3(res.data3);
            draw_chart4(res.data4);
        })
        .fail(function(err) {
            console.log("error: " + j2s(err));
        })
        .always(function() {
            console.log("complete");
        });
    }

    function draw_chart(result) {
        var array = "";
        var arr = [];
        for (var i = 0; i < result.length; i++) {
            array = {name: result[i]['name'], y: Number(result[i]['count']), drilldown: result[i]['name']};
            arr.push(array);
        }
        $('#container1').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Patients data per AGE'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total number of Patients'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
            },

            series: [{
                name: 'Age',
                colorByPoint: true,
                data: arr,
            }],
        });
    }

    function draw_chart1(result) {
        var array = "";
        var arr = [];
        for (var i = 0; i < result.length; i++) {
            array = {name: result[i]['name'], y: Number(result[i]['count']), drilldown: result[i]['name']};
            arr.push(array);
        }
        $('#container2').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Patients data per GENDER'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total number of Patients'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
            },

            series: [{
                name: 'Gender',
                colorByPoint: true,
                data: arr,
            }],
        });
    }

    function draw_chart2(result) {
        var array = "";
        var arr = [];
        for (var i = 0; i < result.length; i++) {
            array = {name: result[i]['name'], y: Number(result[i]['count']), drilldown: result[i]['name']};
            arr.push(array);
        }
        
        $('#container3').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Patients data per Disease'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: ''
            },
            yAxis: {
                title: {
                    text: 'Total number of Patients'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
            },

            series: [{
                name: 'Disease',
                colorByPoint: true,
                data: arr,
            }],
        });
    }

    function draw_chart3(result) {
        var array = "";
        var arr = [];
        for (var i = 0; i < result.length; i++) {
            if (result[i]['name']) {
                if (result[i]['name'].indexOf("Other") !== -1) {
                    array = {name: 'Others', y: Number(result[i]['count']), drilldown: 'Others'};
                    arr.push(array);
                } else {
                    array = {name: 'Disease', y: Number(result[i]['count']), drilldown: 'Disease'};
                    arr.push(array);
                }
            }
        }
        
        $('#container4').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Patients data Results'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: ''
            },
            yAxis: {
                title: {
                    text: 'Total number of Patients'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
            },

            series: [{
                name: 'Results',
                colorByPoint: true,
                data: arr,
            }],
        });
    }

    function draw_chart4(result) {
        var array = "";
        var arr = [];
        var mnth = [];
        var mnthname = '';

        if (_.size(result) > 0) {
            $.each(result, function(index, value){
                var countvalue = [];
                for (var i = 1; i <= 12; i++) {
                    var varvalue = '';
                    if (value[i]['count'].length > 0) {
                        mnthname = value[i]['count'][0]['month'];
                        if (!(mnthname in mnth)) {
                            mnth.push(mnthname);
                        }
                        varvalue = Number(value[i]['count'][0]['count']);
                    } else {
                        varvalue = 0;
                    }
                    countvalue.push(varvalue);
                }
                array = {name: index,data: countvalue};
                arr.push(array);
            })
            mnth = getMonths(mnth.sort());
            // console.log(mnth.sort());
        }

        $('#container5').highcharts({
            title: {
                text: 'Monthly Patients detected with Disease',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Number Of Patients'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: ''
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: arr,
        });
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

    function getMonths(data){
        returndata = [];
        for (var i = 0; i < data.length; i++) {
            console.log(data[i]);
            if (data[i] == 1) {
                if (returndata.indexOf('Jan') == -1) {
                    returndata.push('Jan');
                }
            } else if (data[i] == 2) {
                if (returndata.indexOf('Feb') == -1) {
                    returndata.push('Feb');
                }
            } else if (data[i] == 3) {
                if (returndata.indexOf('Mar') == -1) {
                    returndata.push('Mar');
                }
            } else if (data[i] == 4) {
                if (returndata.indexOf('Apr') == -1) {
                    returndata.push('Apr');
                }
            } else if (data[i] == 5) {
                if (returndata.indexOf('May') == -1) {
                    returndata.push('May');
                }
            } else if (data[i] == 6) {
                if (returndata.indexOf('Jun') == -1) {
                    returndata.push('Jun');
                }
            } else if (data[i] == 7) {
                if (returndata.indexOf('Jul') == -1) {
                    returndata.push('Jul');
                }
            } else if (data[i] == 8) {
                if (returndata.indexOf('Aug') == -1) {
                    returndata.push('Aug');
                }
            } else if (data[i] == 9) {
                if (returndata.indexOf('Sep') == -1) {
                    returndata.push('Sep');
                }
            } else if (data[i] == 10) {
                if (returndata.indexOf('Oct') == -1) {
                    returndata.push('Oct');
                }
            } else if (data[i] == 11) {
                if (returndata.indexOf('Nov') == -1) {
                    returndata.push('Nov');
                }
            } else if (data[i] == 12) {
                if (returndata.indexOf('Dec') == -1) {
                    returndata.push('Dec');
                }
            }
        }
        return returndata;
    }
    </script>
</body>
</html>