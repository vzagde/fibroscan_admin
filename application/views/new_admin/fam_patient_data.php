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
                <h3>FAM Patient Data</h3>
              </div>

              <div class="title_right">
                <div class="form-group pull-right top_search">
                    <div class="row">
                        <div class="col-md-2 col-sm-12 col-xs-12">
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
                        <div class="col-md-2 col-sm-12 col-xs-12">
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

                        <div class="col-md-2 col-sm-12 col-xs-12">
                            <select class="form-control" name="city" id="city">
                                <option value="">city</option>
                                <?php for ($i=0; $i < count($cities); $i++) { ?>
                                <option value="<?=$cities[$i]->id?>"><?=$cities[$i]->name?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-12 col-xs-12">
                            <select class="form-control" name="location" id="location">
                                <option value="2" selected="">Jama Masjid</option>
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-12 col-xs-12">
                            <select class="form-control " name="user" id="user">
                                <option value="4" selected="">Dipesh Pithwa</option>
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-12 col-xs-12">
                            <button class="btn btn-success" id="sbmt-btn" style="font-size: 12px; margin-top: 3px; padding-bottom: 3px;">GET</button>
                        </div>
                    </div>
                </div>
              </div>
            </div>

            <div class="clearfix" ></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <table id="example" class="display" width="100%"></table>
              </div>
            </div>
          </div>
        </div>

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Abbott - App Admin by <a href="http://kreaserv.com">Kreaserv</a>
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

    <!-- datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

<script type="text/javascript">
$(function() {
    get_chart_data(2, 2016, 8, 4);

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

    $('#location').change(function(event) {
        var location = $('#location').val();

        if(location=='') {
            alert('please, check any city.');
            return false;
        }

        $.ajax({
            url: '<?=base_url()?>' + 'admin/get_user_by_location',
            type: 'POST',
            dataType: 'json',
            data: {
                location: location,
                user_type: 'fam',
            },
        })
        .done(function(res) {
            console.log("success: "+j2s(res));
            if (res.status=='success') {
                $('#user').html('<option value="">user</option>');
                res.data.map(function(val, index) {
                    console.log('data: '+j2s(val));
                    console.log('data: '+j2s(index));
                    $('#user').append('<option value="'+val.id+'">'+val.first_name+'</option>');
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
        var user = $('#user').val();

        if (location=='' || month=='' || year=='' || user=='') {
            alert('please, fill all data');
            return false;
        }

        get_chart_data(location, year, month, user);
    });
});

function get_chart_data(location, year, month, user) {
    console.log('data: '+location+' '+year+' '+month+' '+user);

    $.ajax({
      url: '<?=base_url()?>' + 'admin/get_fam_patient_data',
      type: 'POST',
      dataType: 'json',
      data: {
        location: location,
        year: year,
        month: month,
        user: user,
      },
    })
    .done(function(res) {
      console.log("success: " + j2s(res));
      if (res.status == 'success') {
          var d = eval(res.data);
          // console.log(d);
          var dataSet = d;
          if ( $.fn.dataTable.isDataTable('#example') ) {
              $('#example').DataTable( {
                  data: dataSet,
                  columns: [
                      { title: "id" },
                      { title: "camp details id" },
                      { title: "age" },
                      { title: "gender" },
                      { title: "indication" },
                      { title: "fibro scan value" },
                      { title: "date created" }
                  ],
                  dom: 'Bfrtip',
                  buttons: [
                      'copy', 'excel', 'pdf', 'print'
                  ]
              });
          }
          else {
              $('#example').DataTable( {
                  data: dataSet,
                  destroy: true,
                  columns: [
                      { title: "id" },
                      { title: "camp details id" },
                      { title: "age" },
                      { title: "gender" },
                      { title: "indication" },
                      { title: "fibro scan value" },
                      { title: "date created" }
                  ],
                  dom: 'Bfrtip',
                  buttons: [
                      'copy', 'excel', 'pdf', 'print'
                  ]
                });
          }
      }
    })
    .fail(function(err) {
      console.log("error: " + j2s(err));
    })
    .always(function() {
      console.log("complete");
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
</script>
  </body>
</html>
