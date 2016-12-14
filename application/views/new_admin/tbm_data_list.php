<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once( 'includes/head.php'); ?>
    <!-- Select2 -->
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

      .dataTables_wrapper .dataTables_paginate .paginate_button:hover{
          color: white !important;
          border: 1px solid #111;
          background-color: none !important;
          background: none !important;
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
            <div class="clearfix" ></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="push_data1"></div>
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
    <script src="<?=base_url()?>assets/new_admin/vendors/select2/dist/js/select2.full.min.js"></script>
    <script src="<?=base_url()?>assets/new_admin/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>

    <script type="text/javascript" language="javascript" src="<?=base_url()?>assets/js/datatables/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="<?=base_url()?>assets/js/datatables/resources/syntax/shCore.js"></script>
    <script type="text/javascript" language="javascript" src="<?=base_url()?>assets/js/datatables/resources/demo.js"></script>
    <script type="text/javascript" language="javascript" src="<?=base_url()?>assets/js/datatables/dataTables.tableTools.js"></script>

<script type="text/javascript">
      var html = '';
      var user_id = "<?php echo @$user_id; ?>";
      $.ajax({
        url: '<?=base_url()?>' + 'admin/get_tbmlist_data',
        type: 'post',
        data: {user_id: user_id,},
        success: function(data){
          var obj = JSON.parse(data);
          var html = '<div class="x_content">'+
            '<table class="table table-striped" style="border: 1px solid #111">'+
              '<thead>'+
                '<tr>'+
                  '<th>#</th>'+
                  '<th>ID</th>'+
                  '<th>Name</th>'+
                  '<th>Email</th>'+
                  '<th>Area</th>'+
                  '<th>City</th>'+
                '</tr>'+
              '</thead>'+
              '<tbody>';
            var i = 1;
            $.each(obj, function(index, value){
              console.log(value);
              html += '<tr>'+'<th scope="row">'+i+'</th>'+'<td>'+value.id+'</td>'+'<td>'+value.first_name+''+value.last_name+'</td>'+'<td>'+value.email+'</td>'+'<td>'+value.area+'</td>'+'<td>'+value.city+'</td>'+'</tr>';
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
