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
            width: 70%;
            /* Input width (70% of the 50% container) */
        }

        .comment label {
            width: 100% !important;
        }


        .grp {
            width: 50%;
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            /* padding-left: 15px; */
        }

        .grp label {
            width: 20%;
            /* Adjust this value according to your preference */
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
            padding-left: 12px !important;
        }

        #patient_form #mobile_no {
            width: 246px;
        }

        #patient_form .pat-col>.grp-full>.grp>.box-right>input[type="text"] {
            width: 233px;
            padding-left: 12px !important;

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

        .grp-full {
            float: left;
            width: 100%;
            margin-bottom: 5px;
        }

        .form-signatures .table>tbody>tr>td {
            border-top: none !important;
            /* Remove top border */
        }

        /* input[type=text], .form-control{width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;} */
        input[type=text].w-40px {
            width: 40px !important;
        }

        .row hr {
            margin: 3px 0 10px;
        }

        .row input[type=range] {
            margin-top: 10px;
        }

        table.table thead {
            background: #d9edf7 !important;
            color: black !important;
        }

        table.table thead>tr>th,
        table.table-bordered,
        table.table-bordered td {
            border-color: #aad4e8 !important;
            font-size: 12px;
        }

        .row .well {
            min-height: auto;
            margin-bottom: 0px;
        }

        .row textarea.form-control {
            height: 75px;
            width: 100%;
        }

        .input-group-addon {
            border-radius: 0px;
            border-color: #aaa;
        }

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
            width: 100%;
            /* Ensures full width usage */
            border-collapse: collapse;
            /* Remove spaces between inner table cells */
        }

        .info-label {
            font-weight: bold;
            white-space: nowrap;
            padding-right: 5px;
            /* Space between label and content */
        }

        .info-content {
            padding-left: 5px;
        }

        table {
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
        <!-- <div class="panel-body" style="padding:20px;float:left;"> -->
        <div class="userlist">


            <form id="oct_hfa_form" method="post" action="<?php echo current_url(); ?>">

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
                                <input type="text" name="patient_name"
                                    value="<?php echo isset($booking_data['patient_name']) ? $booking_data['patient_name'] : 'N/A'; ?>"
                                    readonly="" style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                            </div>
                        </div>
                        <div class="row m-b-5">
                            <div class="col-xs-4"><strong>Patient Reg. No</strong></div>
                            <div class="col-xs-8">
                                <input type="text" name="patient_code"
                                    value="<?php echo isset($booking_data['patient_code']) ? $booking_data['patient_code'] : 'N/A'; ?>"
                                    readonly="" style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                            </div>
                        </div>
                        <div class="row m-b-5">
                            <div class="col-xs-4"><strong>OPD No</strong></div>
                            <div class="col-xs-8">
                                <input type="text" name="booking_code"
                                    value="<?php echo isset($booking_data['booking_code']) ? $booking_data['booking_code'] : 'N/A'; ?>"
                                    readonly="" style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                            </div>

                        </div>
                        <div class="row m-b-5">
                            <div class="col-xs-4"><strong>Token No</strong></div>
                            <div class="col-xs-8">
                                <input type="text" name="token_no"
                                    value="<?php echo isset($booking_data['token_no']) ? $booking_data['token_no'] : 'N/A'; ?>"
                                    readonly="" style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-5">
                        <div class="row m-b-5">
                            <div class="col-xs-4"><strong>Mobile no.</strong></div>
                            <div class="col-xs-8">
                                <input type="text" name="mobile_no"
                                    value="<?php echo isset($booking_data['mobile_no']) ? $booking_data['mobile_no'] : 'N/A'; ?>"
                                    readonly="" style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                            </div>
                        </div>
                        <div class="row m-b-5">
                            <div class="col-xs-4"><strong>Age</strong></div>
                            <div class="col-xs-8">
                                <input type="text" name="mobile_no" value="<?php echo isset($age) ? $age : 'N/A'; ?>"
                                    readonly="" style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                            </div>
                        </div>
                        <div class="row m-b-5">
                            <div class="col-xs-4"><strong>Gender</strong></div>
                            <div class="col-xs-8">
                                <input type="text" name="gender"
                                    value="<?php echo ($booking_data['gender'] == '0') ? 'Female' : 'Male'; ?>"
                                    readonly="" style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $form_data['contact_lens_trial_table'] = json_decode($form_data['contact_lens_trial_table'], true);
                $form_data['final_order_table'] = json_decode($form_data['final_order_table'], true);

                // echo"<pre>";print_r();die; ?>
                <input type="hidden" id="id" name="id"
                    value="<?php echo isset($form_data['id']) ? $form_data['id'] : ''; ?>">
                <input type="hidden" id="booking_id" name="booking_id"
                    value="<?php echo isset($form_data['booking_id']) ? $form_data['booking_id'] : ''; ?>">
                <input type="hidden" id="branch_id" name="branch_id"
                    value="<?php echo isset($form_data['branch_id']) ? $form_data['branch_id'] : ''; ?>">
                <!-- <input type="hidden" id="booking_code" name="booking_code" value="<?php echo isset($form_data['booking_code']) ? $form_data['booking_code'] : ''; ?>"> -->
                <input type="hidden" id="pres_id" name="pres_id" value="<?php echo isset($id) ? $id : '28'; ?>">
                <input type="hidden" id="patient_id" name="patient_id"
                    value="<?php echo isset($form_data['patient_id']) ? $form_data['patient_id'] : ''; ?>">
                <input type="hidden" id="editable" name="editable"
                    value="<?php echo isset($form_data['editable']) ? $form_data['editable'] : ''; ?>">

                <?php //echo "<pre>";print_r($chief_complaints);die; ?>


                <div class="row">
                    <div class="col-md-11">
                        <section class="panel panel-default">

                            <div class="panel-body">
                                <div class="row">
                                    <div class="grp">

                                        <div class="col-xs-2"><strong>Referred by</strong></div>
                                        <div class="col-xs-10 box-right" style="margin-left: 85px;">
                                            <select name="referred_by" id="refered_id"
                                                class="m_input_default select-height"
                                                >
                                                <option value="">Select Doctor</option>
                                                <?php
                                                if (!empty($referal_doctor_list)) {
                                                    foreach ($referal_doctor_list as $referal_doctor) {
                                                        ?>
                                                        <option <?php if ($form_data['referred_by'] == $referal_doctor->id) {
                                                            echo 'selected="selected"';
                                                        } ?>
                                                            value="<?php echo $referal_doctor->id; ?>">
                                                            <?php echo $referal_doctor->doctor_name; ?>
                                                        </option>

                                                        <?php
                                                    }
                                                }
                                                ?>

                                                <option value="0" <?php if (!empty($form_data['ref_by_other'])) {
                                                    if ($form_data['referred_by'] == '0') {
                                                        echo "selected";
                                                    }
                                                } ?>>
                                                    Others </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <h4><strong>History: </strong></h4>
                                <section style="padding-left:15px;">
                                    <div class="grp">
                                        <label>Main Complaints </label>
                                        <div class="box-right" style="margin-left: 45px;">
                                            <input type="text" name="main_complaints" class="txt_firstCap input-height"
                                                id="main_complaints"
                                                value="<?php echo isset($form_data['main_complaints']) ? htmlspecialchars($form_data['main_complaints']) : ''; ?>"
                                                style="width: 374px;" />
                                            <?php echo form_error('main_complaints'); ?>
                                        </div>
                                    </div>
                                    <div class="grp">
                                        <label>Hours of near work/computer use & related details: </label>
                                        <div class="box-right" style="margin-left: 45px;">
                                            <input type="text" name="hours_of_work_computer" class="txt_firstCap input-height"
                                                id="hours_of_work_computer"
                                                value="<?php echo isset($form_data['hours_of_work_computer']) ? htmlspecialchars($form_data['hours_of_work_computer']) : ''; ?>"
                                                style="width: 374px;" />
                                            <?php echo form_error('hours_of_work_computer'); ?>
                                        </div>
                                    </div>


                                    <div class="grp">
                                        <label>Associated Symptoms:</label>
                                        <div class="box-right" style="margin-left: 45px;">

                                            <input type="text" name="associated_symptoms" class="txt_firstCap input-height"
                                                id="associated_symptoms"
                                                value="<?php echo isset($form_data['associated_symptoms']) ? htmlspecialchars($form_data['associated_symptoms']) : ''; ?>"
                                                style="width: 374px;" />
                                            <?php echo form_error('time'); ?>
                                        </div>
                                    </div>
                                    <div class="grp">
                                        <label>Previous History of Orthoptics Treatment & related Details(Compliance
                                            etc.):</label>
                                        <div class="box-right" style="margin-left: 45px;">

                                            <input type="text" name="previ_his_of_ortho" class="txt_firstCap input-height"
                                                id="previ_his_of_ortho"
                                                value="<?php echo isset($form_data['previ_his_of_ortho']) ? htmlspecialchars($form_data['previ_his_of_ortho']) : ''; ?>"
                                                style="width: 374px;" />
                                            <?php echo form_error('previ_his_of_ortho'); ?>
                                        </div>
                                    </div>
                                    <div class="grp">
                                        <label>General Health & Medication Details:</label>
                                        <div class="box-right" style="margin-left: 45px;">

                                            <input type="text" name="gene_heal_medi_deta" class="txt_firstCap input-height"
                                                id="gene_heal_medi_deta"
                                                value="<?php echo isset($form_data['gene_heal_medi_deta']) ? htmlspecialchars($form_data['gene_heal_medi_deta']) : ''; ?>"
                                                style="width: 374px;" />
                                            <?php echo form_error('time'); ?>
                                        </div>
                                    </div>
                                </section>
                                <div class="row">
                                    <!-- UnVn Row -->
                                    <div class="col-md-6">
                                        <table class="table table-bordered">
                                            <thead class="bg-info">
                                                <tr>
                                                    <th width="25%">Refraction</th>
                                                    <th width="25%">OD</th>
                                                    <th width="25%">OS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Visual Acuity</td>
                                                    <td><input type="text" value="<?php echo $refraction_tbl['visual_acuity_od']; ?>"
                                                            name="visual_acuity_od" id="visual_acuity_od"></td>
                                                    <td><input type="text" value="<?php echo $refraction_tbl['visual_acuity_os']; ?>"
                                                            name="visual_acuity_os" id="visual_acuity_os"></td>
                                                </tr>
                                                <tr>
                                                    <td>Duchrome</td>
                                                    <td><input type="text" value="<?php echo $refraction_tbl['duchrome_od']; ?>"
                                                            name="duchrome_od" id="duchrome_od"></td>
                                                    <td><input type="text" value="<?php echo $refraction_tbl['duchrome_os']; ?>"
                                                            name="duchrome_os" id="duchrome_os"></td>
                                                </tr>
                                                <tr>
                                                    <td>PGP</td>
                                                    <td><input type="text" value="<?php echo $refraction_tbl['pgp_od']; ?>"
                                                            name="pgp_od" id="pgp_od"></td>
                                                    <td><input type="text" value="<?php echo $refraction_tbl['pgp_os']; ?>"
                                                            name="pgp_os" id="pgp_os"></td>
                                                </tr>
                                                <tr>
                                                    <td>Static Retinoscopy</td>
                                                    <td><input type="text" value="<?php echo $refraction_tbl['static_retinoscopy_od']; ?>"
                                                            name="static_retinoscopy_od" id="static_retinoscopy_od"></td>
                                                    <td><input type="text" value="<?php echo $refraction_tbl['static_retinoscopy_os']; ?>"
                                                            name="static_retinoscopy_os" id="static_retinoscopy_os"></td>
                                                </tr>
                                                <tr>
                                                    <td>Acceptance(PMT)</td>
                                                    <td><input type="text" value="<?php echo $refraction_tbl['acceptance_od']; ?>"
                                                            name="acceptance_od" id="acceptance_od"></td>
                                                    <td><input type="text" value="<?php echo $refraction_tbl['acceptance_os']; ?>"
                                                            name="acceptance_os" id="acceptance_os"></td>
                                                </tr>
                                                <tr>
                                                    <td>JCC Refining</td>
                                                    <td><input type="text" value="<?php echo $refraction_tbl['jcc_refining_od']; ?>"
                                                            name="jcc_refining_od" id="jcc_refining_od"></td>
                                                    <td><input type="text" value="<?php echo $refraction_tbl['jcc_refining_os']; ?>"
                                                            name="jcc_refining_os" id="jcc_refining_os"></td>
                                                </tr>
                                                <tr>
                                                    <td>Add</td>
                                                    <td><input type="text" value="<?php echo $refraction_tbl['add_od']; ?>"
                                                            name="add_od" id="add_od"></td>
                                                    <td><input type="text" value="<?php echo $refraction_tbl['add_os']; ?>"
                                                            name="add_os" id="add_os"></td>
                                                </tr>
                                                <tr>
                                                    <td>After Binocular Balancing(Final Rx)</td>
                                                    <td><input type="text" value="<?php echo $refraction_tbl['after_binocular_balancing_od']; ?>"
                                                            name="after_binocular_balancing_od" id="after_binocular_balancing_od"></td>
                                                    <td><input type="text" value="<?php echo $refraction_tbl['after_binocular_balancing_os']; ?>"
                                                            name="after_binocular_balancing_os" id="after_binocular_balancing_os"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="grp">
                                    <label>Additional testing: </label>
                                    <div class="box-right" style="margin-left: 55px;">
                                        <input type="text" name="addi_test" class="txt_firstCap input-height"
                                            id="addi_test"
                                            value="<?php echo isset($form_data['addi_test']) ? htmlspecialchars($form_data['addi_test']) : ''; ?>"
                                            style="width: 374px;" />
                                        <?php echo form_error('addi_test'); ?>
                                    </div>
                                </div>
                                <div class="grp">
                                    <label>Details regarding Adaption: </label>
                                    <div class="box-right" style="margin-left: 55px;">
                                        <input type="text" name="deta_rega_adap" class="txt_firstCap input-height"
                                            id="deta_rega_adap"
                                            value="<?php echo isset($form_data['deta_rega_adap']) ? htmlspecialchars($form_data['deta_rega_adap']) : ''; ?>"
                                            style="width: 374px;" />
                                        <?php echo form_error('deta_rega_adap'); ?>
                                    </div>
                                </div>

                                <h4><strong>Binocular Vision assessment: </strong></h4>
                                <section style="padding-left:15px;">
                                    <div class="grp">
                                        <label>Sensory Evaluation: </label>
                                        <div class="box-right" style="margin-left: 45px;">
                                            <input type="text" name="senso_evalu" class="txt_firstCap input-height"
                                                id="senso_evalu"
                                                value="<?php echo isset($form_data['senso_evalu']) ? htmlspecialchars($form_data['senso_evalu']) : ''; ?>"
                                                style="width: 374px;" />
                                            <?php echo form_error('senso_evalu'); ?>
                                        </div>
                                    </div>
                                    <div class="grp">
                                        <label>Stereopsis(Near) with Randot Stereo: </label>
                                        <div class="box-right" style="margin-left: 45px;">
                                            <input type="text" name="stere_with_rando_stere" class="txt_firstCap input-height"
                                                id="stere_with_rando_stere"
                                                value="<?php echo isset($form_data['stere_with_rando_stere']) ? htmlspecialchars($form_data['stere_with_rando_stere']) : ''; ?>"
                                                style="width: 374px;" />
                                            <?php echo form_error('stere_with_rando_stere'); ?>
                                        </div>
                                    </div>
                                    <div class="grp">
                                        <label>Motor Evaluation:</label>
                                        <div class="box-right" style="margin-left: 45px;">

                                            <input type="text" name="motor_evaluation" class="txt_firstCap input-height"
                                                id="motor_evaluation"
                                                value="<?php echo isset($form_data['motor_evaluation']) ? htmlspecialchars($form_data['motor_evaluation']) : ''; ?>"
                                                style="width: 374px;" />
                                            <?php echo form_error('motor_evaluation'); ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- UnVn Row -->
                                        <div class="col-md-6">
                                            <table class="table table-bordered">
                                                <thead class="bg-info">
                                                    <tr>
                                                        <th width="25%"></th>
                                                        <th width="25%">OD</th>
                                                        <th width="25%">OS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>EOM</td>
                                                        <td><input type="text" value="<?php echo $eom_tbl['eom_od']; ?>"
                                                                name="eom_od" id="eom_od"></td>
                                                        <td><input type="text" value="<?php echo $eom_tbl['eom_os']; ?>"
                                                                name="eom_os" id="eom_os"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-bordered">
                                            <thead class="bg-info">
                                                <tr>
                                                    <th width="25%"></th>
                                                    <th width="25%">D</th>
                                                    <th width="25%">N</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>WFDT</td>
                                                    <td><input type="text" value="<?php echo $wfdt_tbl['wfdt_d']; ?>"
                                                            name="wfdt_d" id="wfdt_d"></td>
                                                    <td><input type="text" value="<?php echo $wfdt_tbl['wfdt_n']; ?>"
                                                            name="wfdt_n" id="wfdt_n"></td>
                                                </tr>
                                                <tr>
                                                    <td>Cover Test</td>
                                                    <td><input type="text" value="<?php echo $wfdt_tbl['cover_test_d']; ?>"
                                                            name="cover_test_d" id="cover_test_d"></td>
                                                    <td><input type="text" value="<?php echo $wfdt_tbl['cover_test_n']; ?>"
                                                            name="cover_test_n" id="cover_test_n"></td>
                                                </tr>
                                                <tr>
                                                    <td>Maddox Rod: Horizontal</td>
                                                    <td><input type="text" value="<?php echo $wfdt_tbl['maddox_rod_horizontal_d']; ?>"
                                                            name="maddox_rod_horizontal_d" id="maddox_rod_horizontal_d"></td>
                                                    <td><input type="text" value="<?php echo $wfdt_tbl['maddox_rod_horizontal_n']; ?>"
                                                            name="maddox_rod_horizontal_n" id="maddox_rod_horizontal_n"></td>
                                                </tr>
                                                <tr>
                                                    <td>Maddox Rod: Vertical</td>
                                                    <td><input type="text" value="<?php echo $wfdt_tbl['maddox_rod_vertical_d']; ?>"
                                                            name="maddox_rod_vertical_d" id="maddox_rod_vertical_d"></td>
                                                    <td><input type="text" value="<?php echo $wfdt_tbl['maddox_rod_vertical_n']; ?>"
                                                            name="maddox_rod_vertical_n" id="maddox_rod_vertical_n"></td>
                                                </tr>
                                                <tr>
                                                    <td>PBCT</td>
                                                    <td><input type="text" value="<?php echo $wfdt_tbl['pbct_d']; ?>"
                                                            name="pbct_d" id="pbct_d"></td>
                                                    <td><input type="text" value="<?php echo $wfdt_tbl['pbct_n']; ?>"
                                                            name="pbct_n" id="pbct_n"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                    
                                </section>
                                <section style="padding-left:15px;">
                                    <div class="grp">
                                        <label>Distance IPD: </label>
                                        <div class="box-right" style="margin-left: 45px;">
                                            <input type="text" name="distance_ipd" class="txt_firstCap input-height"
                                                id="distance_ipd"
                                                value="<?php echo isset($form_data['distance_ipd']) ? htmlspecialchars($form_data['distance_ipd']) : ''; ?>"
                                                style="width: 374px;" />
                                            <?php echo form_error('distance_ipd'); ?>
                                        </div>
                                    </div>
                                    <div class="grp">
                                        <label>AC/A Ratio: </label>
                                        <div class="box-right" style="margin-left: 45px;">
                                            <input type="text" name="ac_a_ratio" class="txt_firstCap input-height"
                                                id="ac_a_ratio"
                                                value="<?php echo isset($form_data['ac_a_ratio']) ? htmlspecialchars($form_data['ac_a_ratio']) : ''; ?>"
                                                style="width: 374px;" />
                                            <?php echo form_error('ac_a_ratio'); ?>
                                        </div>
                                    </div>
                                    <div class="grp">
                                        <label>Heterophoria Method:</label>
                                        <div class="box-right" style="margin-left: 45px;">

                                            <input type="text" name="heterophoria_method" class="txt_firstCap input-height"
                                                id="heterophoria_method"
                                                value="<?php echo isset($form_data['heterophoria_method']) ? htmlspecialchars($form_data['heterophoria_method']) : ''; ?>"
                                                style="width: 374px;" />
                                            <?php echo form_error('heterophoria_method'); ?>
                                        </div>
                                    </div>
                                    
                                </section>

                            </div>
                        </section>
                    </div>
                    <div class="col-md-1">
                        <div class="fixed">
                            <div class="btns">
                                <button class="btn-update" id="form_submit">
                                    <i class="fa fa-save"></i> Save</button>
                                <a href="<?php echo base_url('ortho_ptics'); ?>" class="btn-update"
                                    style="text-decoration:none!important;color:#FFF;padding:8px 2em;"><i
                                        class="fa fa-sign-out"></i>
                                    Exit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div id="load_add_type_modal_popup" class="modal fade" role="dialog" data-backdrop="static"
            data-keyboard="false"></div>


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
    $(document).ready(function () {
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
        $('.prosthetic_contra_sens_l').click(function () {
            let selectedValueL = $(this).val();
            $('.cons_clr_l').show();
            $('.prosthetic_contra_sens_l').parent().removeClass('active');
            $(this).parent().addClass('active');
        });

        // Event listener for right radio buttons
        $('.prosthetic_contra_sens_r').click(function () {
            let selectedValueR = $(this).val();
            $('.cons_clr_r').show();
            $('.prosthetic_contra_sens_r').parent().removeClass('active');
            $(this).parent().addClass('active');
        });
    });



    function prosthetic_contra_sens_ltr() {
        // alert();
        var radiosl = $('input[name=prosthetic_contra_sens_l]');
        var radiosr = $('input[name=prosthetic_contra_sens_r]');
        var vals = $('input[name=prosthetic_contra_sens_l]:checked').val();
        if (radiosl.is(':checked') === true) {
            $('.prosthetic_contra_sens_r').parent().removeClass('active');
            radiosr.filter('[value="' + vals + '"]').prop('checked', true).parent().addClass('active');
        }
    }

    function prosthetic_contra_sens_rtl() {
        var radiosr = $('input[name=prosthetic_contra_sens_r]');
        var radiosl = $('input[name=prosthetic_contra_sens_l]');
        var vals = $('input[name=prosthetic_contra_sens_r]:checked').val();
        if (radiosr.is(':checked') === true) {
            $('.prosthetic_contra_sens_l').parent().removeClass('active');
            radiosl.filter('[value="' + vals + '"]').prop('checked', true).parent().addClass('active');
        }
    }
    function open_modals_2(modal_tab) {
        // alert('ok');
        var $modal = $('#load_add_type_modal_popup');
        $modal.load('<?php echo base_url() . 'prosthetic/fill_eye_data_auto_prosthetic/' ?>' + modal_tab,
            {
            },
            function () {
                $modal.modal('show');
            });
    }

    document.getElementById('oct_hfa_form').addEventListener('submit', function (event) {
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
        var url = isEditMode ? '<?php echo base_url('ortho_ptics/edit/'); ?>' + id : '<?php echo base_url('ortho_ptics/add'); ?>';
        // console.log(isEditMode)
        fetch(url, {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                console.log(data, '=====')
                // Handle success or error response
                if (data.success) {
                    // alert('Form submitted successfully!');
                    // Redirect to the vision list page
                    // flash_session_msg(data.message);
                    window.location.href = '<?php echo base_url('ortho_ptics'); ?>'; // Adjust this URL as necessary
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