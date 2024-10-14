<?php
$users_data = $this->session->userdata('auth_users');
$field_list = mandatory_section_field_list(2);
//echo "<pre>";print_r($users_data);die;
?>

<!DOCTYPE html>
<html>

<head>
  <title><?php echo $page_title . PAGE_TITLE; ?></title>
  <meta name="viewport" content="width=1024">


  <!-- bootstrap -->
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>font-awesome.min.css">

  <!-- links -->
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>my_layout.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>menu_style.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>menu_for_all.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>withoutresponsive.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>pwdwidget.css">
  <!-- js -->
  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>validation.js"></script>
  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>moment-with-locales.js"></script>
  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>validation.js"></script>
  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>pwdwidget.js"></script>
  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>webcam.js"></script>

  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>webcam.min.js"></script>

  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datepicker.css">
  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap-datepicker.js"></script>




  <style>
    #patient_form .pat-col>.grp {
      width: 80%;
    }

    #patient_form input[type="text"],
    #patient_form input[type="password"],
    #patient_form input[type="date"],
    #patient_form select,
    #patient_form .pat-col>.grp>.box-right {
      width: 300px;
    }

    #patient_form #mobile_no {
      width: 246px;
    }

    #patient_form .pat-col>.grp-full>.grp>.box-right>input[type="text"] {
      width: 233px;
    }

    #patient_form .pat-col>.grp-full>.grp>.box-right {
      width: 300px;
    }

    #patient_form .pat-col {
      width: 50%;
    }

    #patient_form .country_code {
      width: 50px !important;
    }

    #patient_form #simulation_id,
    #patient_form #relation_simulation_id {
      width: 11%;
    }

    #patient_form #age_y,
    #patient_form #age_m,
    #patient_form #age_d,
    #patient_form #age_h {
      width: 29px;
    }

    #patient_form #patient_category {
      width: 428px;
    }

    .input-height {
      height: 45px !important;
      padding: 8px;
      font-size: 14px;
      width: 500px !important;
    }

    .select-height {
      height: 45px !important;
      padding: 2px;
      font-size: 14px;
      width: 480px;
      
    }

    /* Target the main Select2 container */
    .select2-container .select2-selection--single {
      height: 40px !important;
      /* width: 380px !important; */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 40px !important;
      font-size: 14px;
      /* width: 380px !important; */
    }

    /* Adjust the dropdown arrow (caret) */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 40px !important;
      /* width: 380px !important; */
    }
    
  </style>
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datetimepicker.css">
  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap-datetimepicker.js"></script>
  <!-- <body onLoad="set_tpa(<?php echo $form_data['insurance_type']; ?>); set_married(<?php echo $form_data['marital_status']; ?>);">  -->

<body>
  <div class="container-fluid">
    <?php
    $this->load->view('include/header');
    $this->load->view('include/inner_header');
    ?>
    <!-- ============================= Main content start here ===================================== -->
    <!-- Patient Details page -->
    <section class="content">
      <form id="patient_form" name="ptaient_form" action="<?php echo current_url(); ?>" method="post"
        enctype="multipart/form-data">
        <input type="hidden" name="data_id" id="patient_id" value="<?php echo $form_data['data_id']; ?>">
        <div class="content-inner">

          <div class="pat-col">
            <div class="row">
              <div class="col-md-12">
                <!-- <div class="grp">
                  <span class="new_patient"><input type="radio" name="new_patient" <?php //if(empty($form_data['patient_id'])) { 
                  ?> checked <?php //} 
                   ?>> <label>Patient</label></span>
                  <span class="new_patient"><input type="radio" name="new_patient"
                      onClick="window.location='<?php echo base_url('patient'); ?>';" <?php if (!empty($form_data['patient_id'])) { ?> checked <?php } ?>> <label>Visitor</label></span>
                </div> -->
                <div class="grp">
                  <span class="new_patient">
                    <input type="radio" name="new_patient" id="patient_radio"
                      onClick="window.location='<?php echo base_url('patient/add'); ?>';">
                    <label>Patient</label>
                  </span>

                  <span class="new_patient">
                    <input type="radio" name="new_patient" id="visitor_radio"
                      onClick="window.location='<?php echo base_url('visitor/add'); ?>';">
                    <label>Visitor</label>
                  </span>
                </div>
              </div>
            </div>
            <div class="grp-full">
              <div class="grp">
                <label>Visitor Type <span class="star">*</span>
                </label>

                <div class="box-right">
                  <select name="visitor_type_id" id="visitor_type_id" class="m_input_default select-height">
                    <option value="">Select Visitor Type</option>
                    <?php
                    if (!empty($visitor_list)) {
                      foreach ($visitor_list as $visitor) {
                        $selected_visitor_type = "";
                        if ($visitor->id == $form_data['visitor_type_id']) {
                          $selected_visitor_type = 'selected="selected"';
                        }
                        echo '<option value="' . $visitor->id . '" ' . $selected_visitor_type . '>' . $visitor->visitor_type . '</option>';
                      }
                    }
                    ?>
                  </select>
                  <?php
                  if (!empty($form_error)) {
                    echo form_error('visitor_type_id');
                  }

                  ?>
                </div>
              </div>

              <?php //if(in_array('51',$users_data['permission']['action'])) {
              ?>
              <!-- <div class="grp-right">
                  <a title="Add Religion" class="btn-new" href="javascript:void(0)" onClick="patient_category_modal()"><i class="fa fa-plus"></i> New</a>
               </div> -->
              <?php //} 
              ?>
            </div>
            <?php //$data= get_setting_value('PATIENT_REG_NO'); 
            //if(!empty($data) && isset($data)) 
            //{
            ?>
            <!-- <div class="grp">
        <label><?php //echo $data; 
        ?></label>
        <div class="box-right"><?php //echo $form_data['patient_code']; 
        ?></div>
        <input type="hidden" name="patient_code" id="patient_code" value="<?php echo $form_data['patient_code']; ?>" />
      </div> -->
            <?php //} 
            ?>



            <div class="grp">
              <label>From <span class="star">*</span></label>
              <div class="box-right">
                <input type="text" name="from" id="form" class="from input-height" maxlength="255"
                  value="<?php echo $form_data['from']; ?>" />
                <?php
                if (!empty($form_error)) {
                  echo form_error('from');
                } ?>
              </div>
            </div>
            <div class="grp-full">
              <div class="grp" style="width: 115%;">
                <label>Visitor Name <span class="star">*</span> </label>
                <div class="box-right" style="width: 553px;padding-left: 2.5rem;">

                  <select name="simulation_id" id="simulation_id" class="pat-select1 select-height"
                    onChange="find_gender(this.value)">
                    <?php
                    if (!empty($simulation_list)) {
                      $seen_names = array();
                      foreach ($simulation_list as $simulation) {
                        if (empty($simulation->id) || empty($simulation->simulation)) {
                          continue;
                        }
                        if (in_array($simulation->simulation, $seen_names)) {
                          continue;
                        }
                        $seen_names[] = $simulation->simulation;
                        $selected_simulation = ($simulation->id == $form_data['simulation_id']) ? 'selected="selected"' : '';
                        ?>
                        <option value="<?php echo htmlspecialchars($simulation->id); ?>" <?php echo $selected_simulation; ?>>
                          <?php echo htmlspecialchars($simulation->simulation); ?>
                        </option>
                        <?php
                      }
                    }
                    ?>
                  </select>


                  <!-- Text input for patient name -->
                  <input type="text" name="visitor_name" class="alpha_space_name txt_firstCap input-height"
                    id="visitor_name" value="<?php echo htmlspecialchars($form_data['visitor_name']); ?>" autofocus
                    style="width: 435px !important;height: 45px !important;" />

                  <!-- Display form errors -->
                  <?php
                  // Display error messages if any
                  if (!empty($form_error)):
                    echo form_error('visitor_name');
                    echo form_error('simulation_id');
                  endif;
                  ?>
                </div>

              </div>
              <?php //if(in_array('65',$users_data['permission']['action'])) {
              ?>
              <!-- <div class="grp-right">
                    <a title="Add Simulation" href="javascript:void(0)" onClick="simulation_modal()" class="btn-new"><i class="fa fa-plus"></i> New</a>
               </div> -->
              <?php //} 
              ?>

            </div>





            <!-- <div class="grp">
        <label>Gender <span class="star">*</span></label>
        <div class="box-right" id="gender">
            <input type="radio" name="gender" value="1" <?php //if($form_data['gender']==1){ echo 'checked="checked"'; } 
            ?>> Male &nbsp;
            <input type="radio" name="gender" value="0" <?php //if($form_data['gender']==0){ echo 'checked="checked"'; } 
            ?>> Female
             <input type="radio" name="gender" value="2" <?php //if($form_data['gender']==2){ echo 'checked="checked"'; } 
             ?>> Others
            <?php
            //if(!empty($form_error)){ echo form_error('gender'); } 
            
            ?>
        </div>
      </div> -->



            <div class="grp" style="width: 115%;">
              <label>Mobile No.
                <?php if (!empty($field_list)) {
                  if ($field_list[0]['mandatory_field_id'] == 5 && $field_list[0]['mandatory_branch_id'] == $users_data['parent_id']) { ?>
                    <span class="star">*</span>
                    <?php
                  }
                }
                ?>
              </label>
              <div class="box-right" style="width: 553px;padding-left: 2.5rem;">
                <!-- <input type="text" maxlength="10" name="mobile_no" value="<?php echo $form_data['mobile_no']; ?>"    data-toggle="tooltip"  title="Allow only numeric." class="tooltip-text tool_tip numeric">  -->
                <input type="text" name="country_code" value="+91" readonly="" class="country_code input-height" placeholder="+91">
                <input type="text" name="mobile_no" id="mobile_no" maxlength="10" class="number numeric input-height"
                  placeholder="eg.9897221234" value="<?php echo $form_data['mobile_no']; ?>"
                  onkeyup="get_visitor_detail_by_mobile();" style="width: 446px !important;height: 45px !important;" />
                <?php if (!empty($field_list)) {
                  if ($field_list[0]['mandatory_field_id'] == '5' && $field_list[0]['mandatory_branch_id'] == $users_data['parent_id']) {
                    if (!empty($form_error)) {
                      echo form_error('mobile_no');
                    }
                  }
                }
                ?>

              </div>
            </div>

            <div class="grp">
              <label>Purpose <span class="star">*</span></label>
              <div class="box-right">
                <input type="text" name="purpose" id="purpose" class="purpose input-height" maxlength="255"
                  value="<?php echo $form_data['purpose']; ?>" />
                <?php
                if (!empty($form_error)) {
                  echo form_error('purpose');
                } ?>
              </div>
            </div>
            <div class="grp-full">
              <div class="grp">
                <label>Meeting with Whom <span class="star">*</span>
                </label>

                <div class="box-right">
                  <select name="emp_id" id="emp_id" class="m_input_default">
                    <option value="">Select employee</option>
                    <?php
                    if (!empty($employee_list)) {
                      foreach ($employee_list as $emp) {
                        $selected_employee = "";
                        if ($emp->id == $form_data['emp_id']) {
                          $selected_employee = 'selected="selected"';
                        }
                        echo '<option value="' . $emp->id . '" ' . $selected_employee . '>' . $emp->name . '</option>';
                      }
                    }
                    ?>
                  </select>
                  <?php
                  if (!empty($form_error)) {
                    echo form_error('emp_id');
                  }
                  ?>
                </div>

              </div>

              <?php //if(in_array('51',$users_data['permission']['action'])) {
              ?>
              <!-- <div class="grp-right">
                  <a title="Add Religion" class="btn-new" href="javascript:void(0)" onClick="patient_category_modal()"><i class="fa fa-plus"></i> New</a>
               </div> -->
              <?php //} 
              ?>
            </div>


            <!-- <div class="grp">
              <?php
              // if (isset($form_data['patient_code_auto'])  && !empty($form_data['patient_code_auto'])) {
              // $token = $form_data['patient_code_auto'];
              // } else {
              // $token = rand(100000, 999999);
              // }
              ?>
              <label>Token No</label>
              <div class="box-right">
                <div class=""><?php //echo $token; ?></div>
                <input type="hidden" name="patient_code_auto" id="patient_code_auto" value="<?php echo $token; ?>" />
              </div>



            </div> -->













            <div class="grp">
              <label></label>
              <div class="box-right">
                <button class="btn-update" id="form_submit">
                  <i class="fa fa-save"></i> Save</button>
                <a href="<?php echo base_url('visitor'); ?>" class="btn-update"
                  style="text-decoration:none!important;color:#FFF;padding:8px 2em;"><i class="fa fa-sign-out"></i>
                  Exit</a>
              </div>
            </div>





          </div>
          
          <div class="pat-col" style="gap: 1rem; padding: 5px; max-width: 200px; float:left; margin-left:100px; border: 1px groove #aaa; background: #f9f9f9;
    box-shadow: inset 0 0 3px #d3d3d3;">
            <div class="pat-col-right-box"
              style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem;">
              <!--Editing by Nitin Sharma 04/02/2024-->
              <strong>
                <center>Visitor Face/Pic Capture</center>
              </strong>
              <!--Editing by Nitin Sharma 04/02/2024-->
              <div class="photo">
                <?php
                $img_path = base_url('assets/images/photo.png');
                if (!empty($form_data['data_id']) && !empty($form_data['old_img'])) {
                  $img_path = ROOT_UPLOADS_PATH . 'visitor/' . $form_data['old_img'];
                }
                ?>
                <img id="pimg" src="<?php echo $img_path; ?>" class="img-responsive">
              </div>
              <!--Added By Nitin Sharma 04/02/2024-->
              <!-- <div class="photo fingerprint"  onclick="captureFP()">
                  <?php
                  $img_path = base_url('assets/images/finger_sacan.png');
                  if (!empty($form_data['data_id']) && !empty($form_data['fingerprint_photo'])) {
                    $img_path = $form_data['fingerprint_photo'];
                  }
                  ?>
                  <img id="FPImage1" src="<?php echo $img_path; ?>" class="img-responsive" >
                  <input type="hidden" id="capture_finger" name="capture_finger" value="" />
                  <input type="hidden" id="fingerprint_photo" name="fingerprint_photo" value="" />
                </div> -->
              <!--Added By Nitin Sharma 04/02/2024-->
            </div>
            <div class="pat-col-right-box2" style=" 
                                                  display: flex;
                                                  flex-direction: column;
                                                  align-items: center;
                                                  gap: 1rem
                                              ">
              <strong style="margin: 0;">Select Image</strong>
              <input type="hidden" name="old_img" value="<?php echo $form_data['old_img']; ?>" />
              <input type="hidden" id="capture_img" name="capture_img" value="" />
              <div style="float: left;width: 100%; font-weight: bold;text-align: center;">
                <a href="javascript:void(0);" onclick="return start_cam()"><img
                    src="<?php echo ROOT_IMAGES_PATH . 'camera.png'; ?>"></a>
              </div>
              <div style="float: left;width: 100%; font-weight: bold;text-align: center;">
                OR
              </div>
              <input type="file" id="img-input" style="margin:0;" accept="image/*" name="photo">
              <?php
              if (isset($photo_error) && !empty($photo_error)) {
                echo '<div class="text-danger">' . $photo_error . '</div>';
              }
              ?>
            </div>
            <?php
            if (!empty($form_data['data_id']) && $form_data['data_id'] > 0) {
            ?>
              <!-- <div class="pat-col-right-box2">
            <strong>Username</strong>
            <input type="text" id="username" class="alpha_numeric_space" readonly="" name="username" value="<?php echo $form_data['username']; ?>" />
          </div>
          <div class="pat-col-right-box2">
            <strong>Password</strong>
            <div class='pwdwidgetdiv' id='thepwddiv' style="float:left;"></div>
            <script  type="text/javascript" >
            $(document).ready(function(){
                 var pwdwidget = new PasswordWidget('thepwddiv','password');
                 pwdwidget.MakePWDWidget();
            });
            </script>
             <div class="brn_cover"> 
                   <div class="brn_1" id="brn_1">
                        <div class="brn_arrow"></div>
                        <div class="brn_txt">Password strength:</div>
                        <div id="mark_bar" class="brn_mark"></div>
                        <div class="brn_validation">
                             Password length should be 6-20 character only.
                        </div>
                   </div>
              </div>   -->
              <?php if (!empty($form_error)) {
                echo form_error('password');
              } ?>
          </div>
          <?php
            }
        ?>

        </div> <!-- // -->

  </div> <!-- content-inner -->
  </form>


  </section> <!-- content -->





  <!-- =================== footer ============================== -->
  <?php
  $this->load->view('include/footer');
  ?>
  <script>
    window.addEventListener('DOMContentLoaded', function () {
      // Get the current URL path
      var currentUrl = window.location.href;

      // PHP variable for 'data_id' from 'form_data' (converted into JS variable)
      var dataId = '<?php echo isset($form_data['data_id']) ? $form_data['data_id'] : ''; ?>';

      // Check if the URL contains 'visitor/add' or 'visitor/edit/[data_id]'
      if (currentUrl.includes('visitor/add')) {
        document.getElementById('visitor_radio').checked = true;  // Check the 'Visitor' radio button
      } else if (currentUrl.includes('visitor/edit/' + dataId)) {
        document.getElementById('visitor_radio').checked = true;  // Check the 'Visitor' radio button for editing
      } else {
        document.getElementById('patient_radio').checked = true;  // Default to 'Patient' radio button
      }
    });

  </script>
  <script>
    function get_visitor_detail_by_mobile() {
      var val = $('#mobile_no').val();
      if (val.length == 10) {

        $.ajax({
          url: "<?php echo site_url('opd/get_visitor_detail_no_mobile'); ?>/" + val,
          type: 'POST',
          async: false,
          success: function (datas) {
            var data = $.parseJSON(datas);
            if (data.st == 1) {
              // Add response in Modal body
              $('.modal-body').html(data.visitor_list);

              // Display Modal
              $('#patient_proceed').modal('show');
            }
          }
        });
        return false;
      }
    };

    $(document).ready(function () {

      $("#proceed").click(function () {

        if ($('input[name="patient_id"]:checked').length == 0) {

          alert("Please select a patient");
          return false;

        } else {
          var action_url = '<?php echo site_url('patient/add/'); ?>'
          var radioValue = $("input[name='patient_id']:checked").val();
          $.ajax({
            url: "<?php echo site_url('opd/get_visitor_detail_byid'); ?>/" + radioValue,
            type: 'POST',
            async: false,
            success: function (datas) {
              var data = $.parseJSON(datas);
              console.log(data)
              if (data.st == 1) {

                // $('#patient_id').val(data.patient_detail.id);
                // $("#registered").attr('checked', true);
                // $('#new').attr('checked', false);
                // $('#patient_code').val(data.patient_detail.patient_code);
                // $('#patient_code_auto').val(data.patient_detail.patient_code_auto);
                $('#visitor_name').val(data.visitor_detail.visitor_name);
                // $('#relation_name').val(data.patient_detail.relation_name);
                // $('#mobile_no').val(data.patient_detail.mobile_no);
                // $('#gender_' + data.patient_detail.gender).attr('checked', 'checked');
                // $('#age_y').val(data.patient_detail.age_y);
                // $('#age_m').val(data.patient_detail.age_m);
                // $('#age_d').val(data.patient_detail.age_d);
                // $('#age_h').val(data.patient_detail.age_h);
                // $('#opd_form').attr('action', action_url + data.patient_detail.id);

                // $("#simulation_id option[value=" + data.patient_detail.simulation_id + "]").attr('selected', 'selected');
                // $("#relation_simulation_id option[value=" + data.patient_detail.relation_simulation_id + "]").attr('selected', 'selected');
                // $("#relation_type_id option[value=" + data.patient_detail.relation_type + "]").attr('selected', 'selected');
                find_gender(data.visitor_detail.simulation_id);
              }
            }

          });

        }

      });

    });

    function getAsDate() {
      var day = parseInt($("#age_d").val());
      if (isNaN(day)) {
        var day = 0;
      }
      var month = parseInt($("#age_m").val() - 1);
      if (isNaN(month)) {
        var month = 0;
      }
      var year = parseInt($("#age_y").val());
      if (isNaN(year)) {
        var year = 0;
      }
      $.ajax({
        url: "<?php echo base_url(); ?>patient/getAge/",

        type: 'POST',
        data: {
          day: day,
          month: month,
          year: year
        },
        success: function (result) {
          $('#dob').val(result);
        }
      });
    }


    function set_married(val) {
      if (val == 0) {
        $('#anniversary').attr("disabled", true);
        $('#anniversary').val('');
      } else {
        $('#anniversary').attr("disabled", false);

      }
    }





    $(document).on("click", function (e) {
      if (!$(".password_id").is(e.target)) {
        //if your box isn't the target of click, hide it
        $(".brn_1").hide();
      }
    });

    $(document).ready(function () {
      $('[data-toggle="tooltip"]').tooltip({
        placement: 'right',
        trigger: 'focus'

      });
    });
  </script>
  <script type="text/javascript">
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
          $('#pimg').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#img-input").change(function () {
      readURL(this);
    });

    //function to find gender according to selected simulation
    function find_gender(id) {
      if (id !== '') {
        $.post('<?php echo base_url() . 'simulation/find_gender' ?>', {
          'simulation_id': id
        }, function (result) {
          if (result !== '') {
            $("#gender").html(result);
          }
        })
      }
    }
    //ends
    function simulation_modal() {
      var $modal = $('#load_add_simulation_modal_popup');
      $modal.load('<?php echo base_url() . 'simulation/add/' ?>', {
        //'id1': '1',
        //'id2': '2'
      },
        function () {
          $modal.modal('show');
        });
    }

    function start_cam() {
      var $modal = $('#load_start_cam_modal_popup');
      $modal.load('<?php echo base_url() . 'patient/start_cam/' ?>', {
        //'id1': '1',
        //'id2': '2'
      },
        function () {
          $modal.modal('show');
        });
    }

    function relation_modal() {
      var $modal = $('#load_add_relation_modal_popup');
      $modal.load('<?php echo base_url() . 'relation/add/' ?>', {
        //'id1': '1',
        //'id2': '2'
      },
        function () {
          $modal.modal('show');
        });
    }

    function religion_modal() {
      var $modal = $('#load_add_religion_modal_popup');
      $modal.load('<?php echo base_url() . 'religion/add/' ?>', {
        //'id1': '1',
        //'id2': '2'
      },
        function () {
          $modal.modal('show');
        });
    }

    function patient_category_modal() {
      var $modal = $('#load_add_patient_category_modal_popup');
      $modal.load('<?php echo base_url() . 'patient_category/add/' ?>', {
        //'id1': '1',
        //'id2': '2'
      },
        function () {
          $modal.modal('show');
        });
    }

    function insurance_type_modal() {
      var $modal = $('#load_add_insurance_type_modal_popup');
      $modal.load('<?php echo base_url() . 'insurance_type/add/' ?>', {
        //'id1': '1',
        //'id2': '2'
      },
        function () {
          $modal.modal('show');
        });
    }

    function insurance_company_modal() {
      var $modal = $('#load_add_insurance_company_modal_popup');
      $modal.load('<?php echo base_url() . 'insurance_company/add/' ?>', {
        //'id1': '1',
        //'id2': '2'
      },
        function () {
          $modal.modal('show');
        });
    }

    function get_state(country_id) {
      $.ajax({
        url: "<?php echo base_url(); ?>general/state_list/" + country_id,
        success: function (result) {
          $('#state_id').html(result);
        }
      });
      get_city();
    }

    function get_city(state_id) {
      $.ajax({
        url: "<?php echo base_url(); ?>general/city_list/" + state_id,
        success: function (result) {
          $('#city_id').html(result);
        }
      });
    }


    function isNumberKey(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode;
      if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
      } else {
        return true;
      }
    }

    $('#form_submit').on("click", function () {
      $(':input[id=form_submit]').prop('disabled', true);
      $('#patient_form').submit();

    })

    function set_tpa(val) {
      if (val == 0) {
        $('#insurance_type_id').attr("disabled", true);
        $('#insurance_type_id').val('');
        $('#ins_company_id').attr("disabled", true);
        $('#ins_company_id').val('');
        $('#polocy_no').attr("readonly", "readonly");
        $('#polocy_no').val('');

        $('#ins_authorization_no').attr("readonly", "readonly");
        $('#ins_authorization_no').val('');



        $('#tpa_id').attr("readonly", "readonly");
        $('#tpa_id').val('');
        $('#ins_amount').attr("readonly", "readonly");
        $('#ins_amount').val('');
      } else {
        $('#insurance_type_id').attr("disabled", false);
        $('#ins_company_id').attr("disabled", false);
        $('#polocy_no').removeAttr("readonly", "readonly");
        $('#ins_authorization_no').removeAttr("readonly", "readonly");
        $('#tpa_id').removeAttr("readonly", "readonly");
        $('#ins_amount').removeAttr("readonly", "readonly");
      }
    }

    $(document).ready(function () {
      $('#load_add_simulation_modal_popup').on('shown.bs.modal', function (e) {
        $(this).find('.inputFocus').focus();
      });
    });

    $(document).ready(function () {
      $('#load_add_religion_modal_popup').on('shown.bs.modal', function (e) {
        $(this).find('.inputFocus').focus();
      });
    });
    $(document).ready(function () {
      $('#load_add_patient_category_modal_popup').on('shown.bs.modal', function (e) {
        $(this).find('.inputFocus').focus();
      });
    });

    $(document).ready(function () {
      $('#load_add_relation_modal_popup').on('shown.bs.modal', function (e) {
        $(this).find('.inputFocus').focus();
      });
    });

    $(document).ready(function () {
      $('#load_add_modal_popup').on('shown.bs.modal', function (e) {
        $(this).find('.inputFocus').focus();
      });
    });


    $(".txt_firstCap").on('keyup', function () {

      var str = $('.txt_firstCap').val();
      var part_val = str.split(" ");
      for (var i = 0; i < part_val.length; i++) {
        var j = part_val[i].charAt(0).toUpperCase();
        part_val[i] = j + part_val[i].substr(1);
      }

      $('.txt_firstCap').val(part_val.join(" "));

    });

    $(document).ready(function () {
      $('.datepicker').datepicker({
        //format: 'dd-mm-yyyy',
        dateFormat: 'dd-mm-yy',
        endDate: new Date(),
        autoclose: true,
        startView: 2
      })


    });
  </script>
  <?php
  if (!empty($sim_id) && $form_data['data_id'] == '') {
    echo '<script>find_gender(' . $sim_id . ');</script>';
  }
  ?>
  <div id="load_add_simulation_modal_popup" class="modal fade" role="dialog" data-backdrop="static"
    data-keyboard="false"></div>
  <div id="load_add_religion_modal_popup" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  </div>
  <div id="load_add_patient_category_modal_popup" class="modal fade" role="dialog" data-backdrop="static"
    data-keyboard="false"></div>
  <div id="load_add_relation_modal_popup" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  </div>
  <div id="load_add_insurance_type_modal_popup" class="modal fade" role="dialog" data-backdrop="static"
    data-keyboard="false"></div>
  <div id="load_add_insurance_company_modal_popup" class="modal fade" role="dialog" data-backdrop="static"
    data-keyboard="false"></div>
  <div id="load_start_cam_modal_popup" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  </div>
  </div><!-- container-fluid -->
  <div id="patient_proceed" class="modal fade dlt-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-theme">
          <h4>Visitor Already Registered!. Do You Want to procced?</h4>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn-update" id="proceed">Continue</button>
          <button type="button" data-dismiss="modal" class="btn-cancel">Close</button>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
<script type="text/javascript">
  function father_husband_son() {
    $("#relation_name").css("display", "block");
  }

  function showAge(dob_birth) {

    var now = new Date(); //Todays Date   
    var birthday = dob_birth
    birthday = birthday.split("-");

    var dobMonth = birthday[1];
    var dobDay = birthday[0];
    var dobYear = birthday[2];

    var nowDay = now.getDate();
    var nowMonth = now.getMonth() + 1; //jan=0 so month+1
    var nowYear = now.getFullYear();

    var ageyear = nowYear - dobYear;
    var agemonth = nowMonth - dobMonth;
    var ageday = nowDay - dobDay;
    if (agemonth < 0) {
      ageyear--;
      agemonth = (12 + agemonth);
    }
    if (nowDay < dobDay) {
      agemonth--;
      ageday = 30 + ageday;
    }
    var val = ageyear + "-" + agemonth + "-" + ageday;
    $('#age_y').val(ageyear);
    $('#age_m').val(agemonth);
    $('#age_d').val(ageday);
  }

  $('.datepicker3').datetimepicker();
</script>
<!--Added By Nitin Sharma 04/02/2024-->
<script>
  function captureFP() {
    CallSGIFPGetData(SuccessFunc, ErrorFunc);
  }

  function SuccessFunc(result) {
    if (result.ErrorCode == 0) {
      if (result != null && result.BMPBase64.length > 0) {
        document.getElementById("FPImage1").src = "data:image/bmp;base64," + result.BMPBase64;
      }
      document.getElementById("capture_finger").value = result.TemplateBase64;
      document.getElementById("fingerprint_photo").value = "data:image/bmp;base64," + result.BMPBase64;
    } else {
      alert("Fingerprint Not Captured Properly. Error Code:  " + result.ErrorCode);
    }
  }

  function ErrorFunc(status) {
    alert("Check If Fingerprint Device Is Connected?");
  }

  function CallSGIFPGetData(successCall, failCall) {
    var uri = "https://localhost:8443/SGIFPCapture";

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        fpobject = JSON.parse(xmlhttp.responseText);
        successCall(fpobject);
      } else if (xmlhttp.status == 404) {
        failCall(xmlhttp.status);
      }
    };
    var params = "Timeout=" + "10000";
    params += "&Quality=" + "50";
    params += "&licstr=" + "";
    params += "&templateFormat=" + "ISO";
    params += "&imageWSQRate=" + "0.75";
    console.log;
    xmlhttp.open("POST", uri, true);
    xmlhttp.send(params);

    xmlhttp.onerror = function () {
      failCall(xmlhttp.statusText);
    };
  }
</script>
<!--Added By Nitin Sharma 04/02/2024-->
<!--new css-->
<link href="<?php echo ROOT_CSS_PATH; ?>jquery-ui.css" rel="stylesheet">
<script src="<?php echo ROOT_JS_PATH; ?>jquery-ui.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $("#visitor_type_id").select2();
  $("#emp_id").select2();
  $("#visitor_type_id").select2({
    width: '500px' // Set your desired width
});
  $("#emp_id").select2({
    width: '500px' // Set your desired width
});
</script>

<!--new css-->