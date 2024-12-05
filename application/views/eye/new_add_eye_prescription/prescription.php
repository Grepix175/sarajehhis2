<?php
$users_data = $this->session->userdata('auth_users');

?>
<!DOCTYPE html>
<html>

<head>
  <title><?php echo $page_title; ?></title>
  <meta name="viewport" content="width=1024">
  <!-- bootstrap -->
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>dataTables.bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datatable.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>font-awesome.min.css">

  <!-- links -->
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>my_layout.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>menu_style.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>menu_for_all.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>withoutresponsive.css">

  <!-- js -->
  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>moment-with-locales.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datepicker.css">
  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap-datepicker.js"></script>

  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datetimepicker.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      /* Font style for the body */
      background-color: #f4f4f4;
      /* Background color */
      margin: 0;
      /* Remove default margin */
      /* padding: 20px; */
      /* Padding around the page */
    }

    .questionnaire {
      width: 100%;
      /* Full width */
      max-width: 600px;
      /* Max width for the questionnaire */
      /*margin: auto;*/
      margin-top: 10px;
    }

    input[type="text"],
    input[type="number"] {
      width: 100%;
      padding: 6px;
      box-sizing: border-box;
      outline: none;
    }

    .question-item {
      display: flex;
      /* Use flexbox for layout */
      justify-content: space-between;
      /* Space between question text and radio buttons */
      align-items: center;
      /* Center vertically */
      background: #fff;
      /* Background color */
      padding: 10px;
      /* Padding around the item */
      border-radius: 5px;
      /* Rounded corners */
      margin-bottom: 10px;
      /* Space between items */
      box-shadow: none;
      /* Remove any shadow */
    }

    .question-text {
      flex: 1;
      /* Take remaining space */
      color: #333;
      /* Text color */
    }

    .radio-buttons {
      display: flex;
      /* Align buttons in a row */
      justify-content: flex-end;
      /* Align buttons to the right */
    }

    .btn-defaults {
      padding: 10px 15px;
      /* Padding for button appearance */
      cursor: pointer !important;
      /* Pointer cursor on hover */
      color: #333;
      /* Text color */
      margin-left: 5px;
      /* Space between buttons */
    }

    /* Change background color when selected */
    input[type="radio"]:checked+.btn-defaults {
      background-color: #007bff;
      /* Blue background when selected */
      color: white;
      /* White text when selected */
      border-color: #007bff;
      /* Matching border color when selected */
    }

    label.btn input[type=radio] {
      position: absolute;
      left: 0;
      top: 9px !important;
    }
  </style>
  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap-datetimepicker.js"></script>
  <!-- datatable js -->
  <!--<script src="<?php echo ROOT_JS_PATH; ?>jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT_JS_PATH; ?>dataTables.bootstrap.min.js"></script>-->

  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>validation.js"></script>

  <script>
    $(window).load(function () {
      $('.overlay-loader').delay('slow').hide();
    });
  </script>

</head>

<body>
  <div class="overlay-loader" style="display:block;">
    <img src="<?php echo base_url('assets/images/loader.gif'); ?>" alt="">
  </div>

  <div class="container-fluid">
    <?php
    $this->load->view('include/header');
    $this->load->view('include/inner_header');
    ?>
    <!-- ============================= Main content start here ===================================== -->
    <section class="userlist">
      <form id="prescription_form" name="prescription_form" action="<?php echo current_url(); ?>" method="post"
        enctype="multipart/form-data">
        <input type="hidden" name="branch_id" value="<?php echo $branch_id; ?>">
        <input type="hidden" name="flag" value="<?php echo $flag ?? ''; ?>">
        <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
        <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>">
        <input type="hidden" name="booking_code" value="<?php echo $booking_code; ?>">
        <input type="hidden" name="simulation_id" value="<?php echo $datas['simulation_id']; ?>">
        <input type="hidden" name="refered_id" value="<?php echo $datas['referral_doctor']; ?>">
        <input type="hidden" name="prescrption_id" value="<?php if (!empty($pres_id)) {
          echo $pres_id;
        } ?>">
        <input type="hidden" name="sale_id" value="<?php echo $sale_id; ?>">
        <?php

        if (empty($flag)) {

          ?>
          <!-- <div class="row">
            <div class="col-md-2">
              <label class="col-md-12 col-sm-12" for="printsummary-labels"><strong>Print only:</strong></label>
            </div>
            <div class="col-md-10 col-sm-10">
              <div class="ckbox ckbox-default col-md-3 col-sm-3">
                <?php
                // if ($form_data['history_flag'] == 1) {
                //   echo 'checked';
                // } 
                ?>
                <input type="checkbox" name="print_history_flag" id="checkboxhistory" value="1" checked>
                <label for="checkboxhistory">History</label>
              </div>

              <div class="ckbox ckbox-default col-md-3 col-sm-3">
                <?php
                // if ($form_data['contactlens_flag'] == 1) {
                //   echo 'checked';
                // } 
                ?>
                <input type="checkbox" name="print_contactlens_flag" id="checkboxcontactlens" value="1" checked>
                <label for="checkboxcontactlens">Contact Lens</label>
              </div>
              <div class="ckbox ckbox-default col-md-3 col-sm-3">
                <?php
                //  if ($form_data['glassesprescriptions_flag'] == 1) {
                //   echo 'checked';
                // } 
                ?>
                <input type="checkbox" name="print_glassesprescriptions_flag" id="checkboxglasses" value="1" checked>
                <label for="checkboxglasses">Glasses</label>
              </div>

              <div class="ckbox ckbox-default col-md-3 col-sm-3">
                <?php
                // if ($form_data['intermediate_glasses_prescriptions_flag'] == 1) {
                //   echo 'checked';
                // } 
                ?>
                <input type="checkbox" name="print_intermediate_glasses_prescriptions_flag" id="checkboxinterglasses"
                  value="1" checked>
                <label for="checkboxinterglasses">Intermediate Glasses</label>
              </div>

              <div class="ckbox ckbox-default col-md-3 col-sm-3">
                <?php
                // if ($form_data['examination_flag'] == 1) {
                //   echo 'checked';
                // } 
                ?>
                <input type="checkbox" name="print_examination_flag" id="checkboxexamination" value="1" checked>
                <label for="checkboxexamination">Examination</label>
              </div>

              <div class="ckbox ckbox-default col-md-3 col-sm-3">
                <?php
                // if ($form_data['drawing_flag'] == 1) {
                //   echo 'checked';
                // }  
                ?>
                <input type="checkbox" name="print_drawing_flag" id="checkboxdrawing" value="1" checked>
                <label for="checkboxdrawing">Hess Chart</label>
              </div>

              <div class="ckbox ckbox-default col-md-3 col-sm-3">
                <?php
                // if ($form_data['diagnosis_flag'] == 1) {
                //   echo 'checked';
                // } 
                ?>
                <input type="checkbox" name="print_diagnosis_flag" id="checkboxdiagnosis" value="1" checked>
                <label for="checkboxdiagnosis">Diagnosis</label>
              </div>

              <div class="ckbox ckbox-default col-md-3 col-sm-3">
                <?php
                // if ($form_data['investigations_flag'] == 1) {
                //   echo 'checked';
                // } 
                ?>
                <input type="checkbox" name="print_investigations_flag" id="checkboxinvestigations" value="1" checked>
                <label for="checkboxinvestigations">Investigations</label>
              </div>

              <div class="ckbox ckbox-default col-md-3 col-sm-3">
                <?php
                // if ($form_data['advice_flag'] == 1) {
                //   echo 'checked';
                // } 
                ?>
                <input type="checkbox" name="print_advice_flag" id="checkboxadvice" value="1" checked>
                <label for="checkboxadvice">Advice</label>
              </div>

              <div class="ckbox ckbox-default col-md-3 col-sm-3">
                <?php
                // if ($form_data['biometry_flag'] == 1) {
                //   echo 'checked';
                // } 
                ?>
                <input type="checkbox" name="print_biometry_flag" id="checkboxadvice" value="1" checked>
                <label for="checkboxadvice">Biometry</label>
              </div>
              <div>
              </div>
            </div>
          </div> -->
          <?php
          // echo "<pre>";
          // print_r($booking_id);
          // print_r($patient_id);
          // die;
          ?>
          <?php
          // Assuming $pat_status is the string
          $pat_status = $booking_data['pat_status'] ?? '';

          // Step 1: Convert the string to an array by splitting by commas
          $pat_status_array = explode(',', $pat_status);

          // Step 2: Trim the whitespace from each item in the array
          $pat_status_array = array_map('trim', $pat_status_array);

          // Step 3: Remove duplicate values from the array
          $pat_status_array = array_unique($pat_status_array);


          $button_actions = [
            'refraction_above_8_years' => 'Refraction above 8 years',
            'vision' => 'Vision',
            'contact_lens' => 'Contact Lens',
            'low_vision' => 'Low vision',
            'hess_chart' => 'Hess Chart',
            'refraction_below_8_years' => 'Refraction below 8 years',
            'dilate' => 'Dilate',
            'prosthetic' => 'Prosthetic',
            'oct_hfa' => 'OCT-HFA',
            'ortho_paedic' => 'Ortho Paedic'
          ];
          ?>
          <div class="row">
            <div class="col-md-2">
              <label class="col-md-12 col-sm-12" for="printsummary-labels"><strong>Print Preview: </strong></label>
            </div>
            <div class="col-md-10 col-sm-10">
              <div class="col-md-10 col-sm-10">
                <!-- <div class="button-group">
                  <a href="javascript:void(0)" class="btn btn-custom"
                    onclick="return print_window_page('<?php echo base_url('refraction/print_refraction/' . $booking_id . '/' . $booking_data['ref_abv_id']); ?>');">
                    <i class="fa fa-print"></i> Refraction above 8 years preview
                  </a>
                  <a href="javascript:void(0)" class="btn btn-custom"
                    onclick="return print_window_page('<?php echo base_url('vision/print_vision/' . $booking_data['vision_id']); ?>');">
                    <i class="fa fa-print"></i> Vision Preview
                  </a>
                  <a href="javascript:void(0)" class="btn btn-custom"
                    onclick="return print_window_page('<?php echo base_url('contact_lens/print_contact_lens/' . $booking_data['contact_lens_id'] . '/' . $booking_id . '/' . $booking_data['patient_id']); ?>' );">
                    <i class="fa fa-print"></i> Contact Lens Preview
                  </a>
                  <a href="javascript:void(0)" class="btn btn-custom"
                    onclick="return print_window_page('<?php echo base_url('low_vision/print_low_vision/' . $booking_id . '/' . $booking_data['low_visi_id']); ?>');">
                    <i class="fa fa-print"></i> Low Vision Preview
                  </a>
                  <a href="javascript:void(0)" class="btn btn-custom"
                    onclick="return print_window_page('<?php echo base_url('eye/add_eye_prescription/view_prescription/' . $booking_data['std_eye_presc_id'] . '/' . $booking_id); ?>?flag=hess_chart&type=help_desk');">
                    <i class="fa fa-print"></i> Hess Chart Preview
                  </a>
                  <a href="javascript:void(0)" class="btn btn-custom"
                    onclick="return print_window_page('<?php echo base_url('eye/add_eye_prescription/view_prescription/' . $booking_data['std_eye_presc_id'] . '/' . $booking_id); ?>?flag=refraction_below_8_years&type=help_desk');">
                    <i class="fa fa-print"></i> Refraction below 8 years Preview
                  </a>
                  <a href="javascript:void(0)" class="btn btn-custom"
                    onclick="return print_window_page('<?php echo base_url('dilate/print_dilate/' . $booking_data['patient_id']); ?>');">
                    <i class="fa fa-print"></i> Dilate Preview
                  </a>
                  <a href="javascript:void(0)" class="btn btn-custom"
                    onclick="return print_window_page('<?php echo base_url('prosthetic/print_prosthetic/' . $booking_id . '/' . $booking_data['patient_id']); ?>');">
                    <i class="fa fa-print"></i> Prosthetic Preview
                  </a>
                  <a href="javascript:void(0)" class="btn btn-custom"
                    onclick="return print_window_page('<?php echo base_url('oct_hfa/print_oct_hfa/' . $booking_id . '/' . $booking_data['patient_id']); ?>');">
                    <i class="fa fa-print"></i> OCT HFA Preview
                  </a>
                  <a href="javascript:void(0)" class="btn btn-custom"
                    onclick="return print_window_page('<?php echo base_url('ortho_ptics/print_oct_hfa/' . $booking_id . '/' . $booking_data['patient_id']); ?>');">
                    <i class="fa fa-print"></i> Ortho Paedic Preview
                  </a> 

                </div> -->
                <?php
                // echo "<pre>";
                // print_r($button_actions);
                // die('sagar');
                ?>
                <div class="button-group">
                  <?php foreach ($button_actions as $key => $action): ?>
                    <a href="javascript:void(0)" class="btn btn-custom" onclick="return print_window_page('<?php
                    // Set URL based on the action
                    switch ($key) {
                      case 'refraction_above_8_years':
                        echo base_url('refraction/print_refraction/' . $booking_id . '/' . $booking_data['ref_abv_id']);
                        break;
                      case 'vision':
                        echo base_url('vision/print_vision/' . $booking_data['vision_id']);
                        break;
                      case 'contact_lens':
                        echo base_url('contact_lens/print_contact_lens/' . $booking_data['contact_lens_id'] . '/' . $booking_id . '/' . $booking_data['patient_id']);
                        break;
                      case 'low_vision':
                        echo base_url('low_vision/print_low_vision/' . $booking_id . '/' . $booking_data['low_visi_id']);
                        break;
                      case 'hess_chart':
                        echo base_url('eye/add_eye_prescription/view_prescription/' . $booking_data['std_eye_presc_id'] . '/' . $booking_id) . '?flag=hess_chart&type=help_desk';
                        break;
                      case 'refraction_below_8_years':
                        echo base_url('eye/add_eye_prescription/view_prescription/' . $booking_data['std_eye_presc_id'] . '/' . $booking_id) . '?flag=refraction_below_8_years&type=help_desk';
                        break;
                      case 'dilate':
                        echo base_url('dilate/print_dilate/' . $booking_data['patient_id']);
                        break;
                      case 'prosthetic':
                        echo base_url('prosthetic/print_prosthetic/' . $booking_id . '/' . $booking_data['patient_id']);
                        break;
                      case 'oct_hfa':
                        echo base_url('oct_hfa/print_oct_hfa/' . $booking_id . '/' . $booking_data['patient_id']);
                        break;
                      case 'ortho_paedic':
                        echo base_url('ortho_ptics/print_oct_hfa/' . $booking_id . '/' . $booking_data['patient_id']);
                        break;
                    }
                    ?>');" <?php echo in_array($action, $pat_status_array) ? '' : 'disabled'; ?>>
                      <i class="fa fa-print"></i> <?php echo $action; ?> Preview
                    </a>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
          <?php
        } else if ($flag == 'eye_history') {
          ?>
            <input type="checkbox" name="print_history_flag" <?php if ($form_data['history_flag'] == 1) {
              echo 'checked';
            } ?>
              id="checkboxhistory" value="1" hidden>

          <?php
        } else if ($flag == 'hess_chart') {

          ?>


              <input type="checkbox" name="print_drawing_flag" checked id="checkboxdrawing" value="1" style="display: none;">
              <label for="checkboxdrawing" style="display: none;">Hess Chart</label>

          <?php

        } else {
          ?>
              <!-- <input type="checkbox" name="print_history_flag" <?php if ($form_data['history_flag'] == 1) {
                echo 'checked';
              } ?>
            id="checkboxhistory" value="1" hidden> -->

          <?php
        }
        ?>
        <?php
        // echo "<pre>";
        //   print_r($data['form_data']);
        //   // print_r($booking_id);
        //   die; 
        ?>

        <?php
        // Loop through the contact lens data
        $age_y = $booking_data['age_y'];
        $age_m = $booking_data['age_m'];
        $age_d = $booking_data['age_d'];

        $age = "";
        if ($age_y > 0) {
          $year = 'Years';
          if ($age_y == 1) {
            $year = 'Year';
          }
          $age .= $age_y . " " . $year;
        }
        if ($age_m > 0) {
          $month = 'Months';
          if ($age_m == 1) {
            $month = 'Month';
          }
          $age .= ", " . $age_m . " " . $month;
        }
        if ($age_d > 0) {
          $day = 'Days';
          if ($age_d == 1) {
            $day = 'Day';
          }
          $age .= ", " . $age_d . " " . $day;
        }
        ?>
        <div class="row mt-3" style="margin-bottom:10px;">
          <div class="col-xs-5">
            <div class="row m-b-5">
              <div class="col-xs-4"><strong>Patient</strong></div>
              <div class="col-xs-8">
                <input type="text" name="patient_name"
                  value="<?php echo isset($booking_data['patient_name']) ? $booking_data['patient_name'] : 'N/A'; ?>"
                  readonly="">
              </div>
            </div>
            <div class="row m-b-5">
              <div class="col-xs-4"><strong>Patient Reg. No</strong></div>
              <div class="col-xs-8">
                <input type="text" name="patient_code"
                  value="<?php echo isset($booking_data['patient_code']) ? $booking_data['patient_code'] : 'N/A'; ?>"
                  readonly="">
              </div>
            </div>
            <div class="row m-b-5">
              <div class="col-xs-4"><strong>OPD No</strong></div>
              <div class="col-xs-8">
                <input type="text" name="booking_code"
                  value="<?php echo isset($booking_data['booking_code']) ? $booking_data['booking_code'] : 'N/A'; ?>"
                  readonly="">
              </div>

            </div>
            <div class="row m-b-5">
              <div class="col-xs-4"><strong>Token No</strong></div>
              <div class="col-xs-8">
                <input type="text" name="token_no"
                  value="<?php echo isset($booking_data['token_no']) ? $booking_data['token_no'] : 'N/A'; ?>"
                  readonly="">
              </div>
            </div>
          </div>
          <div class="col-xs-5">
            <div class="row m-b-5">
              <div class="col-xs-4"><strong>Mobile no.</strong></div>
              <div class="col-xs-8">
                <input type="text" name="mobile_no"
                  value="<?php echo isset($booking_data['mobile_no']) ? $booking_data['mobile_no'] : 'N/A'; ?>"
                  readonly="">
              </div>
            </div>
            <div class="row m-b-5">
              <div class="col-xs-4"><strong>Age</strong></div>
              <div class="col-xs-8">
                <input type="text" name="mobile_no" value="<?php echo isset($age) ? $age : 'N/A'; ?>" readonly="">
              </div>
            </div>
            <div class="row m-b-5">
              <div class="col-xs-4"><strong>Gender</strong></div>
              <div class="col-xs-8">
                <input type="text" name="gender"
                  value="<?php echo ($booking_data['gender'] == '0') ? 'Female' : 'Male'; ?>" readonly="">
              </div>
            </div>
          </div>
        </div>



        <!-- <div class="col-md-2">
          <label class="col-md-12 col-sm-12" for="printsummary-labels"><strong>Token No: </strong>
            <?php //echo $token_no; 
            ?>
          </label>
        </div> -->
        <hr>


        <?php
        if ($flag == 'hess_chart') {
          $classtab8 = $class9 = '';
          if (in_array('2429', $users_data['permission']['action'])) {
            $class9 = 'class="active"';
            $classtab8 = 'fade in active';
          }
        } else if ($flag == 'eye_history') {
          $classtab1 = $class1 = '';
          if (in_array('2429', $users_data['permission']['action'])) {
            $class1 = 'class="active"';
            $classtab1 = 'fade in active';
          }
        } else if ($flag == 'refraction_below_8_years') {
          $classtab2 = $class2 = '';
          if (in_array('2429', $users_data['permission']['action'])) {
            $class2 = 'class="active"';
            $classtab2 = 'fade in active';
          }
        } else {
          $class1 = $class2 = $class3 = $class4 = $class5 = $class6 = $class7 = '';
          $classtab1 = $classtab2 = $classtab3 = $classtab4 = $classtab8 = $classtab5 = $classtab6 = $classtab7 = $class8 = '';

          if (in_array('2416', $users_data['permission']['action'])) {
            $class1 = 'class="active"';
            $classtab1 = 'fade in active';
          } else if (in_array('2417', $users_data['permission']['action'])) {
            $class2 = 'class="active"';
            $classtab2 = 'fade in active';
          } else if (in_array('2418', $users_data['permission']['action'])) {
            $class3 = 'class="active"';
            $classtab3 = 'fade in active';
          } else if (in_array('2429', $users_data['permission']['action'])) {
            $class8 = 'class="active"';
            $classtab8 = 'fade in active';
          } else if (in_array('2419', $users_data['permission']['action'])) {
            $class4 = 'class="active"';
            $classtab4 = 'fade in active';
          } else if (in_array('2420', $users_data['permission']['action'])) {
            $class5 = 'class="active"';
            $classtab5 = 'fade in active';
          } else if (in_array('2421', $users_data['permission']['action'])) {
            $class6 = 'class="active"';
            $classtab6 = 'fade in active';
          } else if (in_array('2422', $users_data['permission']['action'])) {
            $class7 = 'class="active"';
            $classtab7 = 'fade in active';
          }
        } ?>



        <div class="row">
          <div class="col-md-11">
            <!-- main Tabs -->
            <div class="row">
              <div class="col-xs-10">
                <ul class="nav nav-tabs">
                  <?php if ($flag === 'eye_history') { ?>
                    <?php if (in_array('2416', $users_data['permission']['action'])) { ?>
                      <li <?php echo $class1; ?>><a data-toggle="tab" href="#history">History</a></li>
                    <?php } ?>
                  <?php } elseif ($flag === 'hess_chart') { ?> <!-- Additional elseif condition -->
                    <?php if (in_array('2429', $users_data['permission']['action'])) { ?>
                      <li <?php echo $class9; ?>><a data-toggle="tab" href="#Drawing">Hess Chart</a></li>
                    <?php } ?>
                  <?php } elseif ($flag === 'refraction_below_8_years') { ?> <!-- Additional elseif condition -->
                    <?php if (in_array('2417', $users_data['permission']['action'])) { ?>
                      <li <?php echo $class2; ?>><a data-toggle="tab" href="#refraction">Refraction</a></li>
                    <?php } ?>

                  <?php } else { ?>
                    <?php if (in_array('2416', $users_data['permission']['action'])) { ?>
                      <li <?php echo $class1; ?>><a data-toggle="tab" href="#history">History</a></li>
                    <?php } ?>
                    <?php if (in_array('2417', $users_data['permission']['action'])) { ?>
                      <li <?php echo $class2; ?>><a data-toggle="tab" href="#refraction">Refraction</a></li>
                    <?php } ?>

                    <?php if (in_array('2418', $users_data['permission']['action'])) { ?>
                      <li <?php echo $class3; ?>><a data-toggle="tab" href="#Examination">Examination</a></li>
                    <?php } ?>

                    <?php if (in_array('2429', $users_data['permission']['action'])) { ?>
                      <li <?php echo $class9; ?>><a data-toggle="tab" href="#Drawing">Hess Chart</a></li>
                    <?php } ?>

                    <?php if (in_array('2419', $users_data['permission']['action'])) { ?>
                      <li <?php echo $class4; ?>><a data-toggle="tab" href="#investigation">Investigation</a></li>
                    <?php } ?>

                    <?php if (in_array('2420', $users_data['permission']['action'])) { ?>
                      <li <?php echo $class5; ?>><a data-toggle="tab" href="#Diagnosis">Diagnosis</a></li>
                    <?php } ?>

                    <?php if (in_array('2421', $users_data['permission']['action'])) { ?>
                      <li <?php echo $class6; ?>><a data-toggle="tab" href="#planmanagement">Plan of Management</a></li>
                    <?php } ?>

                    <?php if (in_array('2422', $users_data['permission']['action'])) { ?>
                      <li <?php echo $class8; ?>><a data-toggle="tab" href="#upload_files">Upload Files</a></li>
                      <li <?php echo $class7; ?>><a data-toggle="tab" href="#advice">Advice</a></li>
                    <?php } ?>

                    <?php if (in_array('2422', $users_data['permission']['action'])) { ?>
                      <li <?php echo $class7; ?>><a data-toggle="tab" href="#biometry">Biometry</a></li>
                    <?php } ?>
                  <?php } ?>

                </ul>

              </div>
              <div class="col-xs-2 text-right">
                <?php
                if (empty($flag)) {
                  ?>
                  <div class="input-group bg-warning" style="width:100px;float:right;border:1px solid #aaa;">
                    <span class="input-group-addon alert alert-warning" style="border:0" id="demo">Undilated</span>
                    <div id="d_start"><input type="button" class="btn-success btn btn-sm"
                        onclick="dilate_strt('<?php echo $booking_id; ?>');" value="Start"></div>
                  </div>
                  <?php
                }
                ?>

                <script type="text/javascript">
                  var dltddate = '<?php echo $datas['dilate_time']; ?>';
                  var dilate_status = '<?php echo $datas['dilate_status']; ?>';

                  var dltddate2 = new Date('<?php echo $datas['dilate_start_time']; ?>').getTime();
                  if (dltddate != '0000-00-00 00:00:00' && dltddate != '') {
                    var countDownDate = new Date("<?php echo $datas['dilate_time']; ?>").getTime();
                    var diff = countDownDate - dltddate2;
                    var x = setInterval(function () {
                      var now = new Date().getTime();
                      var distance = now - dltddate2;
                      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                      document.getElementById("demo").innerHTML = 'Dilate Time ' + minutes + "m " + seconds + "s";
                      if (distance >= diff && dilate_status !== '2') {
                        $.ajax({ //dilated_stop
                          url: "<?php echo base_url(); ?>opd/dilated_stop",
                          type: "POST",
                          data: {
                            booked_id: '<?php echo $booking_id; ?>'
                          },
                          success: function (result) {
                            setTimeout(function () { }, 1300);
                          }
                        });
                        clearInterval(x);
                        document.getElementById("demo").innerHTML = "Dilated";
                        $('#d_start').html('');
                      } else {
                        $('#d_start').html('<input type="button" class="btn btn-danger btn-sm" onclick="dilate_stop(<?php echo $booking_id; ?>);" value="Stop">');
                      }
                    }, 1000);
                  }
                </script>

                <!-- cyclo --->
                <br>
                <?php
                if (empty($flag)) {
                  ?>
                <div class="input-group bg-warning" style="width:100px;float:right;border:1px solid #aaa;">
                  <span class="input-group-addon alert alert-warning" style="border:0" id="cyclodemo">CYCLO</span>
                  <div id="c_start"><input type="button" class="btn-success btn btn-sm"
                      onclick="cyclo_start('<?php echo $booking_id; ?>');" value="Start"></div>
                </div>
                <?php
                }
                ?>

                <script type="text/javascript">
                  var cyclodate = '<?php echo $datas['cyclo_time']; ?>';

                  var cyclodate2 = new Date('<?php echo $datas['cyclo_start_time']; ?>').getTime();
                  if (cyclodate != '0000-00-00 00:00:00' && cyclodate != '') {
                    var countDownDate = new Date("<?php echo $datas['cyclo_time']; ?>").getTime();
                    var diff = countDownDate - cyclodate2;
                    var x = setInterval(function () {
                      var now = new Date().getTime();
                      var distance = now - cyclodate2;
                      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                      document.getElementById("cyclodemo").innerHTML = 'Cyclo Time ' + minutes + "m " + seconds + "s";
                      if (distance > diff) {
                        $.ajax({
                          url: "<?php echo base_url(); ?>opd/cyclo_stop",
                          type: "POST",
                          data: {
                            booked_id: '<?php echo $booking_id; ?>'
                          },
                          success: function (result) {
                            setTimeout(function () { }, 1300);
                          }
                        });
                        clearInterval(x);
                        document.getElementById("cyclodemo").innerHTML = "Cyclo";
                        $('#c_start').html('');
                      } else {
                        $('#c_start').html('<input type="button" class="btn btn-danger btn-sm" onclick="cyclo_stop(<?php echo $booking_id; ?>);" value="Stop">');
                      }
                    }, 1000);
                  }
                </script>
              </div>

              <!--end of cyclo -->

            </div>
            <!-- main tab-content -->
            <div class="tab-content" style="padding:10px;">
              <!-- 1 tab -->
              <div id="history" class="tab-pane <?php echo $classtab1; ?>">
                <?php $this->load->view('eye/new_add_eye_prescription/pages/history'); ?>
              </div>
              <div id="refraction" class="tab-pane <?php echo $classtab2; ?>">
                <?php $this->load->view('eye/new_add_eye_prescription/pages/refraction'); ?>
              </div>
              <div id="Examination" class="tab-pane <?php echo $classtab3; ?>">
                <?php $this->load->view('eye/new_add_eye_prescription/pages/examination'); ?>
              </div>
              <div id="Drawing" class="tab-pane <?php echo $classtab8; ?>">
                <?php //$this->load->view('eye/new_add_eye_prescription/pages/drawing'); 
                ?>
                <div class="row" style="padding-left:15px;"><a class="btn-save" href="#" id="form_submit"
                    onclick="print_window_page('<?php echo base_url('eye/add_eye_prescription/drawing_prescription/' . $booking_id . '/' . $pres_id); ?>');">Add
                    Drawing</a></div>
                <table class="table table-bordered text-center" id="set_drawing"
                  style="width:500px; margin-left:100px;">
                  <thead>
                    <tr>
                      <th class="text-center" width="200px;">Image</th>
                      <th class="text-center" width="200px;">Remark</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>

              <div id="investigation" class="tab-pane <?php echo $classtab4; ?>">
                <?php $this->load->view('eye/new_add_eye_prescription/pages/investigation'); ?>
              </div>
              <div id="Diagnosis" class="tab-pane <?php echo $classtab5; ?>">
                <?php $this->load->view('eye/new_add_eye_prescription/pages/diagnosis'); ?>
              </div>
              <div id="planmanagement" class="tab-pane <?php echo $classtab6; ?>">
                <?php $this->load->view('eye/new_add_eye_prescription/pages/planmanagement'); ?>
              </div>
              <div id="upload_files" class="tab-pane < ?php echo $classtab6;?>">
                <?php $this->load->view('eye/new_add_eye_prescription/pages/upload_files'); ?>
              </div>
              <div id="advice" class="tab-pane <?php echo $classtab7; ?>">
                <?php $this->load->view('eye/new_add_eye_prescription/pages/advice'); ?>
              </div>

              <div id="biometry" class="tab-pane <?php echo $classtab7; ?>">
                <?php $this->load->view('eye/new_add_eye_prescription/pages/biometry'); ?>
              </div>
            </div>
          </div>
          <div class="col-md-1">
            <div class="fixed">
              <div class="btns">
                <button class="btn-save" type="submit" id="form_submit">Save</button>
                <button type="button" onclick="window.location.href='<?php if (!empty($pres_id)) {
                  echo base_url() . 'help_desk';
                } else {
                  echo base_url() . 'opd';
                } ?>'" class="btn-update">Exit</button>
              </div>
            </div>
          </div>
        </div>
        <?php // echo "dddss";die; 
        ?>
      </form>
    </section> <!-- section close -->

    <?php
    $this->load->view('include/footer');
    ?>

  </div><!-- container-fluid -->
  <script type="text/javascript">
    function print_window_page(url) {
      var drawingWindow = window.open(url, 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
      drawingWindow.addEventListener('beforeunload', function () {
        set_drawing_data();
      }, true);


    }

    function set_drawing_data() {
      $.ajax({
        url: '<?php echo base_url('eye/add_eye_prescription/drawing_data'); ?>',
        success: function (result) {
          $('#set_drawing tbody').html(result);
        }
      });
    }

    function delete_drawing(keys) {
      $.ajax({
        url: '<?php echo base_url('eye/add_eye_prescription/delete_drawing/'); ?>' + keys,
        success: function (result) {
          set_drawing_data();
        }
      });
    }

    set_drawing_data();

    $('.datepicker_m').datepicker({
      format: 'dd-mm-yyyy',
      startDate: new Date(),
      autoclose: true,
    });
    $('.datepicker3').datetimepicker({
      format: 'LT',
    });


    <?php if (!empty($pres_id)) {
      echo $pres_id;
    } ?>

    function dilate_strt(id) {
      $.ajax({
        url: "<?php echo base_url(); ?>opd/dilated_start",
        type: "POST",
        data: {
          booked_id: id
        },
        success: function (result) {
          flash_session_msg(result);
          location.reload();
        }
      });
    }

    function dilate_stop(id) {
      $.ajax({
        url: "<?php echo base_url(); ?>opd/dilate_m_stop",
        type: "POST",
        data: {
          booked_id: id
        },
        success: function (result) {
          flash_session_msg(result);
          location.reload();
        }
      });
    }

    function cyclo_start(id) {
      $.ajax({
        url: "<?php echo base_url(); ?>opd/cyclo_start",
        type: "POST",
        data: {
          booked_id: id
        },
        success: function (result) {
          flash_session_msg(result);
          location.reload();
        }
      });
    }

    function cyclo_stop(id) {
      $.ajax({
        url: "<?php echo base_url(); ?>opd/cyclo_m_stop",
        type: "POST",
        data: {
          booked_id: id
        },
        success: function (result) {
          flash_session_msg(result);
          location.reload();
        }
      });
    }
  </script>

</body>

</html>