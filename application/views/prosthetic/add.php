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
        .grp-full>.grp>.box-right>input[type="text"] {
            /* width: 233px; */
        }
        .box-right {
            width: 70%; /* Input width (70% of the 50% container) */
        }
        
        .grp {
            width: 50%;
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            /* padding-left: 15px; */
        }

        .grp label {
            width: 20%; /* Adjust this value according to your preference */
            font-weight: bold;
        }

        .box-right {
            flex-grow: 1;
        }

        .input-height {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .star {
            color: red;
        }
        #patient_form .pat-col>.grp {
            width: 80%;
        }

        #patient_form input[type="text"],
        #patient_form input[type="password"],
        #patient_form input[type="date"],
        #patient_form select,
        #patient_form .pat-col>.grp>.box-right {
            width: 300px;
            padding-left:12px !important;
        }

        #patient_form #mobile_no {
            width: 246px;
        }

        #patient_form .pat-col>.grp-full>.grp>.box-right>input[type="text"] {
            width: 233px;
            padding-left:12px !important;

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
            /* width: 480px; */
        }

        /* .input-height {
      height: 35px !important;
      padding: 8px;
      font-size: 14px;
        }

        .select-height {
        height: 35px !important;
        padding: 2px;
        font-size: 14px;

        } */

        .input-height {
            height: 45px !important;
            padding: 8px;
            font-size: 14px;
            width: 434px !important;
        }

        .select-height {
            height: 45px !important;
            font-size: 14px;
            width: 435px;
            border-radius: 4px;
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

        .grp-full .border-top {
            /* border-top: 1px solid #000; */
            /* Adjust border color */
        }

        .row.mb-4 {
            margin-bottom: 0px;
            /* Space between the row and the next element */
        }
        .grp-full{
            float: left;
            width: 100%;
            margin-bottom: 5px;
        }
        .form-signatures .table>tbody>tr>td {
            border-top: none !important; /* Remove top border */
        }

        /* input[type=text], .form-control{width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;} */
        input[type=text].w-40px{width:40px !important;}
        .row hr {margin:3px 0 10px;}
        .row input[type=range]{margin-top:10px;}
        table.table thead {background:#d9edf7 !important;color:black !important;}
        table.table thead >tr> th, table.table-bordered, table.table-bordered td {border-color:#aad4e8 !important;font-size:12px;}
        .row .well {min-height:auto;margin-bottom:0px;}
        .row textarea.form-control {height:75px;width:100%;}
        .input-group-addon {border-radius:0px;border-color:#aaa;} 
        .patient-info-table {
            width: 100%;
            border: 1px solid #000;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            margin-bottom: 10px;

        }

        .patient-info-table td {
            padding: 5px;
            vertical-align: top;
            text-align: left;
        }
        .left-column,
        .right-column {
            width: 50%;
        }

        /* Ensure all labels and contents in both columns align vertically */
        .left-column td,
        .right-column td {
            padding: 2px;
        }

        /* Ensure that the tables in both columns align to the top */
        .left-column table, 
        .right-column table {
            width: 100%; /* Ensures full width usage */
            border-collapse: collapse; /* Remove spaces between inner table cells */
        }
        .info-label {
            font-weight: bold;
            white-space: nowrap;
            padding-right: 5px; /* Space between label and content */
        }

        .info-content {
            padding-left: 5px;
        }
        table{
            margin-top: 5px;
        }
        td {
            padding-left: 8px;
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
    <?php //echo "<pre>";print_r($form_data);die; ?>
    <div class="panel-body"   style="padding:20px;float:left;">
        

    <form id="prosthetic_form" method="post" action="<?php echo current_url(); ?>">

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
        <div class="row">
            <div class="col-xs-5">
                <div class="row m-b-5">
                    <div class="col-xs-4"><strong>Patient</strong></div>
                    <div class="col-xs-8">
                        <input type="text" name="patient_name" value="<?php echo isset($booking_data['patient_name']) ? $booking_data['patient_name'] : ''; ?>" readonly="" style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                    </div>
                </div>
                <div class="row m-b-5">
                    <div class="col-xs-4"><strong>Patient Reg. No</strong></div>
                    <div class="col-xs-8">
                        <input type="text" name="patient_code" value="<?php echo isset($booking_data['patient_code']) ? $booking_data['patient_code'] : ''; ?>" readonly="" style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                    </div>
                </div>
                <div class="row m-b-5">
                    <div class="col-xs-4"><strong>OPD No</strong></div>
                    <div class="col-xs-8">
                        <input type="text" name="booking_code" value="<?php echo isset($booking_data['booking_code']) ? $booking_data['booking_code'] : ''; ?>" readonly="" style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                    </div>
                    
                </div>
                <div class="row m-b-5">
                        <div class="col-xs-4"><strong>Token No</strong></div>
                        <div class="col-xs-8">
                            <input type="text" name="token_no" value="<?php echo isset($booking_data['token_no']) ? $booking_data['token_no'] : ''; ?>" readonly="" style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                        </div>
                    </div>
            </div>
            <div class="col-xs-5">
                <div class="row m-b-5">
                    <div class="col-xs-4"><strong>Mobile no.</strong></div>
                    <div class="col-xs-8">
                        <input type="text" name="mobile_no" value="<?php echo isset($booking_data['mobile_no']) ? $booking_data['mobile_no'] : ''; ?>" readonly="" style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                    </div>
                </div>
                <div class="row m-b-5">
                    <div class="col-xs-4"><strong>Age</strong></div>
                    <div class="col-xs-8">
                        <input type="text" name="mobile_no" value="<?php echo isset($age) ? $age : ''; ?>" readonly="" style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                    </div>
                </div>
                <div class="row m-b-5">
                    <div class="col-xs-4"><strong>Gender</strong></div>
                    <div class="col-xs-8">
                        <input type="text" name="gender" value="<?php echo ($booking_data['gender'] == '0') ? 'Female' : 'Male'; ?>" readonly="" style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                    </div>
                </div>
            </div>
        </div>
        <?php 
        $form_data['contact_lens_trial_table'] = json_decode($form_data['contact_lens_trial_table'],true);
        $form_data['final_order_table'] = json_decode($form_data['final_order_table'],true);
        
        // echo"<pre>";print_r();die; ?>
        <input type="hidden" id="id" name="id" value="<?php echo isset($form_data['id']) ? $form_data['id'] : ''; ?>">
        <input type="hidden" id="booking_id" name="booking_id" value="<?php echo isset($form_data['booking_id']) ? $form_data['booking_id'] : ''; ?>">
        <input type="hidden" id="branch_id" name="branch_id" value="<?php echo isset($form_data['branch_id']) ? $form_data['branch_id'] : ''; ?>">
        <!-- <input type="hidden" id="booking_code" name="booking_code" value="<?php echo isset($form_data['booking_code']) ? $form_data['booking_code'] : ''; ?>"> -->
        <input type="hidden" id="pres_id" name="pres_id" value="<?php echo isset($id) ? $id : '28'; ?>">
        <input type="hidden" id="patient_id" name="patient_id" value="<?php echo isset($form_data['patient_id']) ? $form_data['patient_id'] : ''; ?>">
        <input type="hidden" id="editable" name="editable" value="<?php echo isset($form_data['editable']) ? $form_data['editable'] : ''; ?>">
        <section class="panel panel-default">
            <div class="panel-body">

                
                <div class="grp" style="">
                    <label>Date </label>
                    <div class="box-right">
                        <input type="text" disabled name="date" class="txt_firstCap input-height"
                            id="date" value="<?php echo isset($form_data['date']) ? htmlspecialchars($form_data['date']) : date('Y-m-d'); ?>" style="width: 374px;" />
                        <?php echo form_error('date'); ?>
                    </div>
                </div>
                <div class="grp" style="">
                    <label>Time </label>
                    <div class="box-right">
                        <input type="text" disabled name="time" class="txt_firstCap input-height"
                            id="time" value="<?php echo isset($form_data['time']) ? htmlspecialchars($form_data['time']) : date('H:i:s'); ?>" style="width: 374px;" />
                        <?php echo form_error('time'); ?>
                    </div>
                </div>


                <div class="grp" style="">
                    <!-- <div class="grp" style=""> -->
                        <label for="sideEffects" class="font-weight-bold mb-0">Work-up Done By </label>
                    <!-- </div> -->
                    
                    <div class="box-right" >
                        <select name="workup_by" id="workup_by" class="m_input_default select-height">
                            <option value="">Select Doctor</option>
                            <?php
                            // echo "<pre>";print_r($doctor);die;
                            // Loop through the side effects array and dynamically populate options
                            if (!empty($doctor)) {
                                foreach ($doctor as $doctorObj) {
                                    // Check if the current doctor is selected based on form data
                                    $selected_doctor = "";
                                    if (isset($form_data['workup_by']) && $doctorObj->id == $form_data['workup_by']) {
                                        $selected_doctor = 'selected="selected"';
                                    }
                                    // Display the option with doctor's name
                                    echo '<option value="' . $doctorObj->id . '" ' . $selected_doctor . '>' . htmlspecialchars($doctorObj->doctor_name) . '</option>';
                                }
                            } else {
                                echo '<option disabled>No doctor found.</option>';
                            }
                            
                            ?>
                        </select>
                        <?php 
                        // Show form validation error if there is one
                        if (!empty($form_error)) {
                            echo form_error('workup_by');
                        }
                        ?>
                    </div>
                </div>

                <div class="grp" style="">
                    <label>INDICATION </label>
                    <div class="box-right" >
                        <input type="text" name="indication" class="txt_firstCap input-height"
                            id="indication" value="<?php echo isset($form_data['indication']) ? htmlspecialchars($form_data['indication']) : ''; ?>" style="width: 374px;" />
                        <?php echo form_error('indication'); ?>
                    </div>
                </div>

                <div class="grp" style="">
                    <label>ANTERIOR SEGMENT EVALUATION </label>
                    <div class="box-right" >
                        <input type="text" name="anterior_segment_evaluation" class="txt_firstCap input-height"
                            id="ANTERIOR SEGMENT EVALUATION" value="<?php echo isset($form_data['anterior_segment_evaluation']) ? htmlspecialchars($form_data['anterior_segment_evaluation']) : ''; ?>" style="width: 374px;" />
                        <?php echo form_error('anterior_segment_evaluation'); ?>
                    </div>
                </div>

                <div class="grp" style="">
                <!-- <div class="col-md-2"> -->
                <!-- <div class="label_name">                <i onclick="refraction_ar_ltr_plated();" title="Copy Left to Right"></i></div> -->

                <!-- </div> -->
                <div class="box-right" >
                    <table class="table table-bordered">
                        <thead class="bg-info">
                            <tr>
                                <th width="25%"></th>
                                <th width="25%">OD</th>
                                <th width="25%">OS</th>
                                <!-- <th width="25%">Axis</th> -->
                            </tr>
                        </thead>
                        <tbody> 
                            <tr> 
                                <td style="text-align:left;">SPECTACLE POWER</td>
                                <td><input type="text" value="<?php echo isset($form_data['spectacle_power_od']) ? htmlspecialchars($form_data['spectacle_power_od']) : ''; ?>" name="spectacle_power_od" id="spectacle_power_od" class="w-50px auto_fer2"></td>
                                <td><input type="text" value="<?php echo isset($form_data['spectacle_power_os']) ? htmlspecialchars($form_data['spectacle_power_os']) : ''; ?>" name="spectacle_power_os" id="spectacle_power_os" class="w-50px auto_fer2"></td>
                            </tr>
                            <tr>
                                <td style="text-align:left;">KERATOMETRY</td>
                                <td><input type="text" value="<?php echo isset($form_data['keratometry_od']) ? htmlspecialchars($form_data['keratometry_od']) : ''; ?>" name="keratometry_od" id="keratometry_od" class="w-50px auto_fer2"></td>
                                <td><input type="text" value="<?php echo isset($form_data['keratometry_os']) ? htmlspecialchars($form_data['keratometry_os']) : ''; ?>" name="keratometry_os" id="keratometry_os" class="w-50px auto_fer2"></td>
                            </tr>
                            <tr>
                                <td style="text-align:left;">HVID</td>
                                <td><input type="text" value="<?php echo isset($form_data['hvid_od']) ? htmlspecialchars($form_data['hvid_od']) : ''; ?>" name="hvid_od" id="hvid_od" class="w-50px auto_fer2"></td>
                                <td><input type="text" value="<?php echo isset($form_data['hvid_os']) ? htmlspecialchars($form_data['hvid_os']) : ''; ?>" name="hvid_os" id="hvid_os" class="w-50px auto_fer2"></td>
                            </tr>

                        </tbody>
                    </table> 
                </div>
            </div>


                <div class="row">
                    <div class="col-md-12">
                        <label>Contact Lens Trial:</label>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>    
                                    <th>B.C (MM)</th>
                                    <th>DIA (MM)</th>
                                    <th>Power</th>
                                    <th>VN</th>
                                    <th>Remarks</th>
                                    <th>RX On Top</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>OD OS</td>
                                    <td><input type="text" class="form-control" name="contact_lens_trial_table[bc_od]"  value="<?= isset($form_data['contact_lens_trial_table']['bc_od']) ? $form_data['contact_lens_trial_table']['bc_od'] : ''; ?>"></td>
                                    <td><input type="text" class="form-control" name="contact_lens_trial_table[dia_od]"  value="<?= isset($form_data['contact_lens_trial_table']['dia_od']) ? $form_data['contact_lens_trial_table']['dia_od'] : ''; ?>"></td>
                                    <td><input type="text" class="form-control" name="contact_lens_trial_table[power_od]"  value="<?= isset($form_data['contact_lens_trial_table']['power_od']) ? $form_data['contact_lens_trial_table']['power_od'] : ''; ?>"></td>
                                    <td><input type="text" class="form-control" name="contact_lens_trial_table[vn_od]"  value="<?= isset($form_data['contact_lens_trial_table']['vn_od']) ? $form_data['contact_lens_trial_table']['vn_od'] : ''; ?>"></td>
                                    <td><input type="text" class="form-control" name="contact_lens_trial_table[remarks_od]"  value="<?= isset($form_data['contact_lens_trial_table']['remarks_od']) ? $form_data['contact_lens_trial_table']['remarks_od'] : ''; ?>"></td>
                                    <td><input type="text" class="form-control" name="contact_lens_trial_table[rx_od]"  value="<?= isset($form_data['contact_lens_trial_table']['rx_od']) ? $form_data['contact_lens_trial_table']['rx_od'] : ''; ?>"></td>
                                </tr>
                                <tr>
                                    <td>OD OS</td>
                                    <td><input type="text" class="form-control" name="contact_lens_trial_table[bc_os]"  value="<?= isset($form_data['contact_lens_trial_table']['bc_os']) ? $form_data['contact_lens_trial_table']['bc_os'] : ''; ?>"></td>
                                    <td><input type="text" class="form-control" name="contact_lens_trial_table[dia_os]"  value="<?= isset($form_data['contact_lens_trial_table']['dia_os']) ? $form_data['contact_lens_trial_table']['dia_os'] : ''; ?>"></td>
                                    <td><input type="text" class="form-control" name="contact_lens_trial_table[power_os]"  value="<?= isset($form_data['contact_lens_trial_table']['power_os']) ? $form_data['contact_lens_trial_table']['power_os'] : ''; ?>"></td>
                                    <td><input type="text" class="form-control" name="contact_lens_trial_table[vn_os]"  value="<?= isset($form_data['contact_lens_trial_table']['vn_os']) ? $form_data['contact_lens_trial_table']['vn_os'] : ''; ?>"></td>
                                    <td><input type="text" class="form-control" name="contact_lens_trial_table[remarks_os]"  value="<?= isset($form_data['contact_lens_trial_table']['remarks_os']) ? $form_data['contact_lens_trial_table']['remarks_os'] : ''; ?>"></td>
                                    <td><input type="text" class="form-control" name="contact_lens_trial_table[rx_os]"  value="<?= isset($form_data['contact_lens_trial_table']['rx_os']) ? $form_data['contact_lens_trial_table']['rx_os'] : ''; ?>"></td>
                                </tr>
                                <tr>
                                    <td>OD OS</td>
                                    <td><input type="text" class="form-control" name="contact_lens_trial_table[bc_os2]"  value="<?= isset($form_data['contact_lens_trial_table']['bc_os2']) ? $form_data['contact_lens_trial_table']['bc_os2'] : ''; ?>"></td>
                                    <td><input type="text" class="form-control" name="contact_lens_trial_table[dia_os2]"  value="<?= isset($form_data['contact_lens_trial_table']['dia_os2']) ? $form_data['contact_lens_trial_table']['dia_os2'] : ''; ?>"></td>
                                    <td><input type="text" class="form-control" name="contact_lens_trial_table[power_os2]"  value="<?= isset($form_data['contact_lens_trial_table']['power_os2']) ? $form_data['contact_lens_trial_table']['power_os2'] : ''; ?>"></td>
                                    <td><input type="text" class="form-control" name="contact_lens_trial_table[vn_os2]"  value="<?= isset($form_data['contact_lens_trial_table']['vn_os2']) ? $form_data['contact_lens_trial_table']['vn_os2'] : ''; ?>"></td>
                                    <td><input type="text" class="form-control" name="contact_lens_trial_table[remarks_o2]"  value="<?= isset($form_data['contact_lens_trial_table']['remarks_o2']) ? $form_data['contact_lens_trial_table']['remarks_o2'] : ''; ?>"></td>
                                    <td><input type="text" class="form-control" name="contact_lens_trial_table[rx_os2]"  value="<?= isset($form_data['contact_lens_trial_table']['rx_os2']) ? $form_data['contact_lens_trial_table']['rx_os2'] : ''; ?>"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="grp" style="padding:15px;">
                        <label for="trial_given">Trial Given</label>
                        <div class="box-right">
                            <select class="txt_firstCap input-height form-control" id="trial_given" name="trial_given" style="width: 374px;">
                                <option value="Yes" <?= isset($form_data['trial_given']) && $form_data['trial_given'] == 'Yes' ? 'selected' : ''; ?>>Yes</option>
                                <option value="No" <?= isset($form_data['trial_given']) && $form_data['trial_given'] == 'No' ? 'selected' : ''; ?>>No</option>
                            </select>
                            <?php echo form_error('trial_given'); ?>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label>Final Order:</label>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>B.C (MM)</th>
                                    <th>DIA (MM)</th>
                                    <th>Power</th>
                                    <th>Tint</th>
                                    <th>Material</th>
                                    <th>Company</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>OD</td>
                                    <td><input type="text" class="form-control" name="final_order_table[bc_od]" value="<?php echo isset($form_data['final_order_table']['bc_od']) ? $form_data['final_order_table']['bc_od'] : ''; ?>" placeholder="OD"></td>
                                    <td><input type="text" class="form-control" name="final_order_table[dia_od]" value="<?php echo isset($form_data['final_order_table']['dia_od']) ? $form_data['final_order_table']['dia_od'] : ''; ?>" placeholder="OD"></td>
                                    <td><input type="text" class="form-control" name="final_order_table[power_od]" value="<?php echo isset($form_data['final_order_table']['power_od']) ? $form_data['final_order_table']['power_od'] : ''; ?>" placeholder="OD"></td>
                                    <td><input type="text" class="form-control" name="final_order_table[tint_od]" value="<?php echo isset($form_data['final_order_table']['tint_od']) ? $form_data['final_order_table']['tint_od'] : ''; ?>" placeholder="OD"></td>
                                    <td><input type="text" class="form-control" name="final_order_table[material_od]" value="<?php echo isset($form_data['final_order_table']['material_od']) ? $form_data['final_order_table']['material_od'] : ''; ?>" placeholder="OD"></td>
                                    <td><input type="text" class="form-control" name="final_order_table[company_od]" value="<?php echo isset($form_data['final_order_table']['company_od']) ? $form_data['final_order_table']['company_od'] : ''; ?>" placeholder="OD"></td>
                                </tr>
                                <tr>
                                    <td>OS</td>
                                    <td><input type="text" class="form-control" name="final_order_table[bc_os]" value="<?php echo isset($form_data['final_order_table']['bc_os']) ? $form_data['final_order_table']['bc_os'] : ''; ?>" placeholder="OS"></td>
                                    <td><input type="text" class="form-control" name="final_order_table[dia_os]" value="<?php echo isset($form_data['final_order_table']['dia_os']) ? $form_data['final_order_table']['dia_os'] : ''; ?>" placeholder="OS"></td>
                                    <td><input type="text" class="form-control" name="final_order_table[power_os]" value="<?php echo isset($form_data['final_order_table']['power_os']) ? $form_data['final_order_table']['power_os'] : ''; ?>" placeholder="OS"></td>
                                    <td><input type="text" class="form-control" name="final_order_table[tint_os]" value="<?php echo isset($form_data['final_order_table']['tint_os']) ? $form_data['final_order_table']['tint_os'] : ''; ?>" placeholder="OS"></td>
                                    <td><input type="text" class="form-control" name="final_order_table[material_os]" value="<?php echo isset($form_data['final_order_table']['material_os']) ? $form_data['final_order_table']['material_os'] : ''; ?>" placeholder="OS"></td>
                                    <td><input type="text" class="form-control" name="final_order_table[company_os]" value="<?php echo isset($form_data['final_order_table']['company_os']) ? $form_data['final_order_table']['company_os'] : ''; ?>" placeholder="OS"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="instruction_given">Instruction Given/Lens Dispensed on:</label>
                        <input type="date" class="form-control" id="instruction_given" name="instruction_given_lens_dispensed_on" 
                        value="<?php echo isset($form_data['instruction_given_lens_dispensed_on']) ? $form_data['instruction_given_lens_dispensed_on'] : ''; ?>">

                        
                    </div>
                </div>

                <!-- <div class="form-group col-md-12">
                    <label for="consent_form">Consent Form:</label>
                    <input type="file" class="form-control" id="consent_form" name="consent_form">
                </div> -->
            </div>
            <div class="form-signatures mt-4">
                <table class="table table-borderless mb-4 w-100">
                    <tbody>
                        <tr>
                            <!-- Doctor Dropdown -->
                            <td class="small text-center mt-5" style="width: 33%;">
                                <div class="text-center">
                                    <span class="font-weight-bold">Signature of Doctor:</span><br>
                                    <div class="border-top pt-2 mx-auto" style="display: inline-block; width: 200px; border-top:1px solid black; margin-top: 24px;">
                                        <select name="doctor_signature" class="form-control mx-auto" style="width: 200px;">
                                            <option value="">Select Doctor</option>
                                            <?php foreach ($doctor as $doc) : ?>
                                                <option value="<?= $doc->id; ?>" 
                                                    <?= isset($form_data['doctor_signature']) && $form_data['doctor_signature'] == $doc->id ? 'selected' : ''; ?>>
                                                    <?= $doc->doctor_name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span></span>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Optometrist Dropdown -->
                            <td class="small text-center mt-5" style="width: 33%;">
                                <div class="text-center">
                                    <span class="font-weight-bold">Signature of Optometrist:</span><br>
                                    <div class="border-top pt-2 mx-auto" style="display: inline-block; width: 200px; border-top:1px solid black; margin-top: 24px;">
                                        <select name="optometrist_signature" class="form-control mx-auto" style="width: 200px;">
                                            <option value="">Select Optometrist</option>
                                            <?php foreach ($doctor as $optometrist) : ?>
                                                <option value="<?= $optometrist->id; ?>" 
                                                    <?= isset($form_data['optometrist_signature']) && $form_data['optometrist_signature'] == $optometrist->id ? 'selected' : ''; ?>>
                                                    <?= $optometrist->doctor_name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span></span>
                                    </div>
                                </div>
                            </td>

                            

                            <!-- Patient Name (Non-dropdown) -->
                            <td class="small text-center mt-5" style="width: 34%;">
                                <div class="text-center">
                                    <span class="font-weight-bold">Signature of Patient:</span><br>
                                    <div class="border-top pt-2 mx-auto" style="display: inline-block; width: 200px;border-top:1px solid black; margin-top: 24px;">
                                        <!-- Display current patient's name -->
                                        <input type="text" name="patient_signature" class="" style="width: 200px;" 
                                            value="<?= isset($booking_data['patient_name']) ? htmlspecialchars($booking_data['patient_name']) : 'Current Patient Name'; ?>" readonly />
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </section>
        
           
       

            <div class="grp">
                <label></label>
                <div class="box-right">
                    <button class="btn-update" id="form_submit">
                        <i class="fa fa-save"></i> Save</button>
                    <a href="<?php echo base_url('prosthetic'); ?>" class="btn-update"
                        style="text-decoration:none!important;color:#FFF;padding:8px 2em;"><i
                            class="fa fa-sign-out"></i>
                        Exit</a>
                </div>
            </div>
        </form>
    </div>
    <div id="load_add_type_modal_popup" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false"></div>


</body>
<script>
    function clearLeft() {
        $('.prosthetic_contra_sens_l').prop('checked', false).parent().removeClass('active');
        $('.cons_clr_l').hide();
    }

    function clearRight() {
        $('.prosthetic_contra_sens_r').prop('checked', false).parent().removeClass('active');
        $('.cons_clr_r').hide();
    }
    $(document).ready(function() {
    // Example of how you might receive $form_data from your server-side code
    var form_data = {
        prosthetic_contra_sens_l: 'value1', // replace with actual value
        prosthetic_contra_sens_r: 'value2'  // replace with actual value
    };

    // Check if there is a selected value for left contrast sensitivity
    if (form_data.prosthetic_contra_sens_l) {
        $('.cons_clr_l').show();
        // You might want to set the radio button as checked and active
        $('.prosthetic_contra_sens_l[value="' + form_data.prosthetic_contra_sens_l + '"]').prop('checked', true).parent().addClass('active');
    } else {
        $('.cons_clr_l').hide(); // Hide if there is no selection
    }

    // Check if there is a selected value for right contrast sensitivity
    if (form_data.prosthetic_contra_sens_r) {
        $('.cons_clr_r').show();
        $('.prosthetic_contra_sens_r[value="' + form_data.prosthetic_contra_sens_r + '"]').prop('checked', true).parent().addClass('active');
    } else {
        $('.cons_clr_r').hide(); // Hide if there is no selection
    }

    // Event listener for left radio buttons
    $('.prosthetic_contra_sens_l').click(function() {
        let selectedValueL = $(this).val();
        $('.cons_clr_l').show();
        $('.prosthetic_contra_sens_l').parent().removeClass('active');
        $(this).parent().addClass('active');
    });

    // Event listener for right radio buttons
    $('.prosthetic_contra_sens_r').click(function() {
        let selectedValueR = $(this).val();
        $('.cons_clr_r').show();
            $('.prosthetic_contra_sens_r').parent().removeClass('active');
            $(this).parent().addClass('active');
        });
    });



    function prosthetic_contra_sens_ltr()
  	{
        // alert();
  		  var radiosl = $('input[name=prosthetic_contra_sens_l]');
  		  var radiosr = $('input[name=prosthetic_contra_sens_r]');
  		  var vals=$('input[name=prosthetic_contra_sens_l]:checked').val();
  		  if(radiosl.is(':checked') === true) 
  		  {
  		  	$('.prosthetic_contra_sens_r').parent().removeClass('active');
		      radiosr.filter('[value="'+vals+'"]').prop('checked', true).parent().addClass('active');
		  }
  	}
    
  	function prosthetic_contra_sens_rtl()
  	{
  		  var radiosr = $('input[name=prosthetic_contra_sens_r]');
  		  var radiosl = $('input[name=prosthetic_contra_sens_l]');
  		  var vals=$('input[name=prosthetic_contra_sens_r]:checked').val();
  		  if(radiosr.is(':checked') === true) 
  		  {
  		  	$('.prosthetic_contra_sens_l').parent().removeClass('active');
		      radiosl.filter('[value="'+vals+'"]').prop('checked', true).parent().addClass('active');
		  }
  	}  	
    function open_modals_2(modal_tab) {
        // alert('ok');
        var $modal = $('#load_add_type_modal_popup');
        $modal.load('<?php echo base_url().'prosthetic/fill_eye_data_auto_prosthetic/' ?>'+modal_tab,
        {
        },
        function(){
        $modal.modal('show');
        });
  	}

      document.getElementById('prosthetic_form').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission

            var formData = new FormData(this); // Gather form data

            // Check if it's an edit operation by looking for a specific input
            var isEditMode = document.getElementById('editable') == null; // Adjust this to your specific condition
            // Initialize id variable
            // var id = '';

            // If in edit mode, get the id from a hidden input or other source
            // var recordIdElement = document.getElementById('id');
            // if (isEditMode && recordIdElement) {
            //     id = recordIdElement.value; // Only set id if the element exists
            // }

            // If in edit mode, get the id from a hidden input or other source
            var id = isEditMode ? document.getElementById('id').value : ''; // Make sure you have an input with ID 'record_id'

            // const BASE_URL = "<?php echo base_url(); ?>";
            // console.log(BASE_URL)
            // // let url = BASE_URL
            // let path = new URL(url).pathname;
            // let segments = path.split('/');
            // let addSegment = segments[2];


            // console.log('edit mode: ',addSegment)

            // Set the URL based on the mode
            var url = isEditMode ? '<?php echo base_url('prosthetic/edit/'); ?>' + id : '<?php echo base_url('prosthetic/add'); ?>';
            // console.log(isEditMode)
            fetch(url, {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                console.log(data,'=====')
                // Handle success or error response
                if (data.success) {
                    // alert('Form submitted successfully!');
                    // Redirect to the vision list page
                    // flash_session_msg(data.message);
                    window.location.href = '<?php echo base_url('prosthetic'); ?>'; // Adjust this URL as necessary
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // alert('There was a problem with the submission.');
            });
        });


</script>

<?php
    $this->load->view('include/footer');
    ?>
</html>