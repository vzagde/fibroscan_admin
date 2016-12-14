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
                <h3>Users</h3>
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
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add user <small>Any type of user is added by here</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                      
                      <div class="form-group">
                        <label for="username" class="control-label col-md-3 col-sm-3 col-xs-12">
                          User Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="username" class="form-control col-md-7 col-xs-12" type="text" name="user-name">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">
                          User Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="email" class="form-control col-md-7 col-xs-12" type="email" name="email">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fname">
                          First Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="fname" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lname">
                          Last Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="lname" name="lname" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">
                          Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" id="password" name="password" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="repassword">
                          Re-Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" id="repassword" name="repassword" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="phoneno" class="control-label col-md-3 col-sm-3 col-xs-12">
                          Phone no. <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="phoneno" class="form-control col-md-7 col-xs-12" type="phone" name="phoneno">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Group</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="select2_group form-control" tabindex="-1">
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Senior</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="select2_senior form-control" tabindex="-1">
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select City</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="select2_city form-control" tabindex="-1">
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Area</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="select2_area form-control" tabindex="-1">
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Profile pic</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" id="profile_image">
                        </div>
                      </div>
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="reset" class="btn btn-primary">Cancel</button>
                          <button id="sbmtbtn" type="button" class="btn btn-success">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
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
    <script type="text/javascript">
      var city = <?=json_encode($city)?>;
      var area = <?=json_encode($area)?>;
      var groups = <?=json_encode($groups)?>;
      var senior = <?=json_encode($senior)?>;
      
      groups.unshift({id: '', name: ''});
      for (var i = 0; i < groups.length; i++) {
        groups[i].text = groups[i].name;
      }

      senior.unshift({id: '', name: '', first_name: '', last_name: ''});
      for (var i = 0; i < senior.length; i++) {
        senior[i].text = senior[i].first_name + ' ' + senior[i].last_name;
      }

      city.unshift({id: '', name: ''});
      for (var i = 0; i < city.length; i++) {
        city[i].text = city[i].name;
      }

      area.unshift({id: '', name: '', city_id: ''});
      for (var i = 0; i < area.length; i++) {
        area[i].text = area[i].name;
      }
      $(document).ready(function() {

        $(".select2_group").select2({
          placeholder: "Select a group",
          allowClear: true,
          data: groups
        });

        $(".select2_senior").select2({
          placeholder: "Select a senior",
          allowClear: true,
          data: senior
        });

        $(".select2_city").select2({
          placeholder: "Select a city",
          allowClear: true,
          data: city
        });

        $(".select2_area").select2({
          placeholder: "Select a area",
          allowClear: true,
          data: area
        });

        $(".select2_city").on("change", function(e) {
          var theSelection = $(this).select2('val');
          console.log(theSelection);
          if (theSelection!='') {
            var new_area = [];
            for (var i = 0; i < area.length; i++) {
              if (theSelection==area[i].city_id) {
                new_area.push(area[i]);
              }
            }
            $(".select2_area").select2("destroy");
            $(".select2_area").html("<option><option>");
            $(".select2_area").select2({
              placeholder: "Select a area",
              allowClear: true,
              data: new_area
            });
          }
        });

        $('#sbmtbtn').click(function(event) {
          event.preventDefault();
          $('#sbmtbtn').prop('disabled', true);

          var email_regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
          var phone_regex = /^\d{10}$/;

          var _username = $('#username').val();
          var _email = $('#email').val();
          var _fname = $('#fname').val();
          var _lname = $('#lname').val();
          var _password = $('#password').val();
          var _repassword = $('#repassword').val();
          var _phoneno = $('#phoneno').val();
          var _group = $('.select2_group').select2('val');
          var _senior = $('.select2_senior').select2('val');
          var _city = $('.select2_city').select2('val');
          var _area = $('.select2_area').select2('val');
          var _profile_image = $('#profile_image').val();
          // console.log('data: '+_username + _email + _fname + _lname + _password + _repassword + _phoneno);
          // console.log('select2: '+ _group + 'g' + _senior + 's' + _city + 'c' + _area + 'a');

          if ( (_username=='' || _email=='' || _fname=='' || _lname=='' || _password=='' || _repassword=='' || _phoneno=='' || _group=='' || _senior=='' || _city=='' || _area=='') || (_password!=_repassword) || _profile_image=='') {
            alert('please fill all feilds.');
            $('#sbmtbtn').prop('disabled', false);
            return false;
          } else if (!_email.match(email_regex) || !_phoneno.match(phone_regex)) {
            alert('please fill valid data.');
            $('#sbmtbtn').prop('disabled', false);
            return false;
          }

          data = new FormData();
          data.append('profile_image', $('#profile_image')[0].files[0]);
          data.append('username', _username);
          data.append('email', _email);
          data.append('fname', _fname);
          data.append('lname', _lname);
          data.append('password', _password);
          data.append('repassword', _repassword);
          data.append('phoneno', _phoneno);
          data.append('group', _group);
          data.append('senior', _senior);
          data.append('city', _city);
          data.append('area', _area);

          $.ajax({
            url: '<?=base_url()?>admin/create_user',
            type: 'POST',
            dataType: 'json',
            enctype: 'multipart/form-data',
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            data: data,
            // {
            //   username: _username,
            //   email: _email,
            //   fname: _fname,
            //   lname: _lname,
            //   password: _password,
            //   repassword: _repassword,
            //   phoneno: _phoneno,
            //   group: _group,
            //   senior: _senior,
            //   city: _city,
            //   area: _area,
            //   profile_image: data,
            // },
          })
          .done(function(res) {
            console.log("success: "+res);
            if (res.status=='success') {
              alert('user created sucessfuly');
              $('#username').val('');
              $('#email').val('');
              $('#fname').val('');
              $('#lname').val('');
              $('#password').val('');
              $('#repassword').val('');
              $('#phoneno').val('');
              $('.select2_group').select2(null).trigger("change");
              $('.select2_senior').select2(null).trigger("change");
              $('.select2_city').select2(null).trigger("change");
              $('.select2_area').select2(null).trigger("change");
            }
          })
          .fail(function(err) {
            console.log("error");
          })
          .always(function() {
            console.log("complete");
          });
          

          $('#sbmtbtn').prop('disabled', false);
        });
      });
    </script>
  </body>
</html>
