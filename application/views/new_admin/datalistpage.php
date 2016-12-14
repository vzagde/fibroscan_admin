<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once( 'includes/head.php'); ?>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/js/datatables/media/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/js/datatables/resources/syntax/shCore.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/js/datatables/dataTables.tableTools.css">

    <style>
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
      div.dataTables_wrapper {
          margin-bottom: 3em;
      }

      /*.pagination>.active>a{
        padding: 0 !important;
        color: #111;
        background: none !important;
        border: none;
      }*/

      .dataTables_wrapper .dataTables_paginate .paginate_button:hover{
          color: white !important;
          border: 1px solid #111;
          background-color: none !important;
          background: none !important;
          /*background: none !important;
          background: none !important;
          background: none !important;
          background: none !important;
          background: none !important;*/
      }
    </style>
  </head>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <?php include_once( 'includes/sidebar.php'); ?>
        <?php include_once('includes/topbar.php'); ?>
        <div class="right_col" role="main">
          <div class="row">
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
            <div class="col-md-12 col-sm-12 col-xs-12" style="background: #fff">
              <div class="dashboard_graph">
                <h3>Defaulter List of Technician</h3>
                <div class="col-md-6" id="push_data1" style="background: #ededed; padding: 1%;"></div>
                <!-- <h3>Defaulter List of Technician</h3>
                <div class="col-md-6" id="push_data2"></div>
                <h3>Defaulter List of Technician</h3>
                <div class="col-md-6" id="push_data3"></div> -->
              </div>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div class="pull-right">
        Abbott - App Admin Template by <a href="http://kreaserv.com">Kreaserv</a>
      </div>
      <div class="clearfix"></div>
    </footer>
    <?php include_once( 'includes/footer.php'); ?>
    <script src="https://maps.googleapis.com/maps/api/js?v=3&sensor=false" type="text/javascript"></script>
    <script src="https://code.highcharts.com/maps/highmaps.js"></script>
    <script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/mapdata/countries/in/custom/in-all-andaman-and-nicobar.js"></script>

    <script type="text/javascript" language="javascript" src="<?=base_url()?>assets/js/datatables/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="<?=base_url()?>assets/js/datatables/resources/syntax/shCore.js"></script>
    <script type="text/javascript" language="javascript" src="<?=base_url()?>assets/js/datatables/resources/demo.js"></script>
    <script type="text/javascript" language="javascript" src="<?=base_url()?>assets/js/datatables/dataTables.tableTools.js"></script>

    <script type="text/javascript">
      var base_url = "https://stg.adityabirlamoneyuniverse.com/equity-account";
      var html = '';
      function onBlurLoadGraph(){
        $.ajax({
          url: '<?=base_url()?>'+'admin/get_filterdata_datalist',
          type: 'POST',
          data: {
            start_date : $('#startdate').val(), 
            end_date : $('#enddate').val(), 
            location : $('#location').val(), 
            city : $('#city').val(), 
          },
          success: function(data){
            console.log(data);
            var obj = JSON.parse(data);
            console.log(obj);
            var html = '<div class="x_content">'+
              '<table class="table table-striped" style="border: 1px solid #111">'+
                '<thead>'+
                  '<tr>'+
                    '<th>#</th>'+
                    '<th>Count</th>'+
                    '<th>Name</th>'+
                  '</tr>'+
                '</thead>'+
                '<tbody>';
              var i = 1;
              $.each(obj.data1, function(index, value){
                console.log(value);
                html += '<tr>'+'<th scope="row">'+i+'</th>'+'<td>'+value.count+'</td>'+'<td>'+value.first_name+'</td>'+'</tr>';
                i+=1;
              })
              html += '</tbody>';
              $('#push_data1').html(html);
              var table = $('table').dataTable({
                "dom": 'T<"clear">lfrtip',
                "tableTools": {
                    "sSwfPath": "<?=base_url()?>"+"/assets/js/datatables/copy_csv_xls_pdf.swf"
              }
            })
          }
        })
      }

      $.ajax({
        url: '<?=base_url()?>' + 'admin/get_datalist_data',
        success: function(data){
          // console.log(data);
          var obj = JSON.parse(data);
          console.log(obj);
          var html = '<div class="x_content">'+
            '<table class="table table-striped" style="border: 1px solid #111">'+
              '<thead>'+
                '<tr>'+
                  '<th>#</th>'+
                  '<th>Count</th>'+
                  '<th>Name</th>'+
                '</tr>'+
              '</thead>'+
              '<tbody>';
            var i = 1;
            $.each(obj.data1, function(index, value){
              console.log(value);
              html += '<tr>'+'<th scope="row">'+i+'</th>'+'<td>'+value.count+'</td>'+'<td>'+value.first_name+'</td>'+'</tr>';
              i+=1;
            })
            html += '</tbody>';
            $('#push_data1').html(html);
            var table = $('table').dataTable({
              "dom": 'T<"clear">lfrtip',
              "tableTools": {
                  "sSwfPath": "<?=base_url()?>"+"/assets/js/datatables/copy_csv_xls_pdf.swf"
            }
          })
        }
      })
    </script>
  </body>
</html>