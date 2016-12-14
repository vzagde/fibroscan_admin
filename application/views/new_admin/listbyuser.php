<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once( 'includes/head.php'); ?>
    <!-- Select2 -->
    <link href="<?=base_url()?>assets/new_admin/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://silviomoreto.github.io/bootstrap-select/dist/css/bootstrap-select.min.css">

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
                <h3><!-- Head Office Member List --></h3>
              </div>
              <div class="title_right">
              </div>
            </div>
            <div class="clearfix" ></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Select HO</label>
                    <select id="ho_dropdown" class="form-control" onChange="getListBM()">
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Select BM</label>
                    <select id="bm_dropdown" class="form-control" onChange="getListABM()">
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Select ABM</label>
                    <select id="abm_dropdown" class="form-control" onChange="getListFAM()">
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Select FAM</label>
                    <select id="fam_dropdown" class="form-control">
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <button class="btn btn-warning" onClick="get_data()">Go</button>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix" ></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="chart1"></div>
              </div>
            </div>
            <div class="clearfix" ></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="chart2"></div>
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
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>

    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
    <script type="text/javascript" src="https://silviomoreto.github.io/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <!-- /high chart -->

<script type="text/javascript">
    var usertype = 6;
    var userID = '';
    $(document).ready(function(){
        getListHo();
        get_data();
    })

    function get_data(){
      if ($('#fam_dropdown').val() && $('#fam_dropdown').val() != 0) {
        userID = $('#fam_dropdown').val();
        usertype = 'FAM';
      } else if ($('#abm_dropdown').val() && $('#abm_dropdown').val() != 0) {
        userID = $('#abm_dropdown').val();
        usertype = 'ABM';
      } else if ($('#bm_dropdown').val() && $('#bm_dropdown').val() != 0) {
        userID = $('#bm_dropdown').val();
        usertype = 'BM';
      } else if ($('#ho_dropdown').val() && $('#ho_dropdown').val() != 0) {
        userID = $('#ho_dropdown').val();
        usertype = 'HO';
      } else {
        userID = '';
        usertype = 'HO';
      }

      $.ajax({
        url : '<?=base_url()?>'+'admin/getDataForList',
        type : 'post',
        data : {
          usertype : usertype,
          userID : userID,
        },
        success : function (response) {
          console.log(response);
          var obj = JSON.parse(response);
          drawChart(obj.data);
          drawChart1(obj.data1);
        }
      })
    }

    function getListHo(){
      $.ajax({
        url : '<?=base_url()?>'+'admin/getListHo',
        type : 'post',
        success : function (response) {
          var obj = JSON.parse(response);
          console.log(obj);
          var html = "<option value='0'>Nothing Selected</option>";
          $.each(obj, function(index, value){
            html += "<option value='"+value.id+"'>"+value.first_name+" "+value.last_name+"</option>";
          })
          $("#ho_dropdown").html(html);
          var text = "<option value='0'>Nothing To Select</option>";
          $("#bm_dropdown").html(text);
          $("#abm_dropdown").html(text);
          $("#fam_dropdown").html(text);
        }
      })
    }

    function getListBM(){
      if ($('#ho_dropdown').val()) {
        $.ajax({
          url : '<?=base_url()?>'+'admin/getListBM',
          type : 'post',
          data : {
            userID : $('#ho_dropdown').val(),
          },
          success : function (response) {
            var obj = JSON.parse(response);
            console.log(obj);
            var html = "<option value='0'>Nothing Selected</option>";
            $.each(obj, function(index, value){
              html += "<option value='"+value.id+"'>"+value.first_name+" "+value.last_name+"</option>";
            })
            $("#bm_dropdown").html(html);

            var text = "<option value='0'>Nothing To Select</option>";
            $("#abm_dropdown").html(text);
            $("#fam_dropdown").html(text);
          }
        })
      }
    }

    function getListABM(){
      if ($('#bm_dropdown').val()) {
        $.ajax({
          url : '<?=base_url()?>'+'admin/getListABM',
          type : 'post',
          data : {
            userID : $('#bm_dropdown').val(),
          },
          success : function (response) {
            var obj = JSON.parse(response);
            console.log(obj);
            var html = "<option value='0'>Nothing Selected</option>";
            $.each(obj, function(index, value){
              html += "<option value='"+value.id+"'>"+value.first_name+" "+value.last_name+"</option>";
            })
            $("#abm_dropdown").html(html);

            var text = "<option value='0'>Nothing To Select</option>";
            $("#fam_dropdown").html(text);
          }
        })
      }
    }

    function getListFAM(){
      if ($('#abm_dropdown').val()) {
        $.ajax({
          url : '<?=base_url()?>'+'admin/getListFAM',
          type : 'post',
          data : {
            userID : $('#abm_dropdown').val(),
          },
          success : function (response) {
            var obj = JSON.parse(response);
            console.log(obj);
            var html = "<option value='0'>Nothing Selected</option>";
            $.each(obj, function(index, value){
              html += "<option value='"+value.id+"'>"+value.first_name+" "+value.last_name+"</option>";
            })
            $("#fam_dropdown").html(html);
          }
        })
      }
    }

    // function get_data(usertype, userID){
    //     $.ajax({
    //         url : '<?=base_url()?>'+"admin/getDataForList",
    //         type : 'post',
    //         data : {
    //             usertype : usertype,
    //             userID : userID,
    //         },
    //         success : function(response) {
    //             var obj = JSON.parse(response);
    //             var html = '<div class="x_content">'+
    //             '<table class="table table-striped" style="border: 1px solid #111">'+
    //               '<thead>'+
    //                 '<tr>'+
    //                   '<th>#</th>'+
    //                   '<th>Name</th>'+
    //                   '<th>Email</th>'+
    //                   '<th>Area</th>'+
    //                   '<th>City</th>'+
    //                   '<th>Action</th>'+
    //                 '</tr>'+
    //               '</thead>'+
    //               '<tbody>';
    //             if (obj.status == "success") {
    //                 if (obj.usertype == 2) {
    //                 }
    //                 $.each(obj.data, function(index, value){
    //                   html += '<tr>'+'<td>'+value.id+'</td>'+'<td>'+value.first_name+' '+value.last_name+'</td>'+'<td>'+value.email+'</td>'+'<td>'+value.area+'</td>'+'<td>'+value.city+'</td>'+'<td><a href="<?=base_url()?>admin/tbm_list_load/'+value.id+'"><button class="btn">View Internal</button><a></td>'+'</tr>';
    //                 })
    //             }
    //             html += '</tbody>';
    //             $('#chartBar').html(html);
    //             var table = $('table').dataTable({
    //               "dom": 'T<"clear">lfrtip',
    //               "tableTools": {
    //                   "sSwfPath": "<?=base_url()?>"+"/assets/js/datatables/copy_csv_xls_pdf.swf"
    //             }
    //             })
    //         }
    //     })
    // }

    function drawChart(inputdata){
      var count = [];
      var doc = [];
      $.each(inputdata, function(index, value){
        count.push(Number(value.COUNT));
        doc.push(value.name);
      })
      $('#chart1').highcharts({
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
              text: ''
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
              categories: doc
          },
          yAxis: {
              title: {
                  text: null
              }
          },
          series: [{
              name: 'Patients Per Doctor',
              data: count
          }]
      });
    }

    function drawChart1(inputdata){
      var count = [];
      var doc = [];
      $.each(inputdata, function(index, value){
        count.push(Number(value.COUNT));
        doc.push(value.name);
      })
      console.log(count);
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
              text: ''
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
              categories: doc
          },
          yAxis: {
              title: {
                  text: null
              }
          },
          series: [{
              name: 'Patients Per Disease',
              data: count
          }]
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