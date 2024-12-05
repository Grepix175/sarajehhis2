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

        .grp {
            width: 50%;
            display: flex;
            align-items: center;
            /* margin-bottom: 1rem; */
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
            /* width: 480px; */
        }

        .footer {
            position: absolute;
            /* Fixed position at the bottom */
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 11px;
            /* Smaller font size for footer text */
        }

        .footer hr {
            border: none;
            border-top: 1px solid #000;
            /* Line style */
            margin: 0;
            /* Remove margins */
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
            padding: 5px;
            font-size: 14px;
            width: 434px !important;
        }

        .select-height {
            height: 45px !important;
            padding: 2px;
            font-size: 14px;
            width: 435px;

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
            padding-left: 3px;
        }

        .body {
            width: 60%;
            margin: auto;
        }

        .tabledata td {
            text-align: left !important;
            /* Ensures all table cells have left-aligned text */
            padding: 8px;
            /* Add padding for better spacing */
            border-bottom: 1px solid #ddd;
            /* Adds a bottom border to all table cells */
        }

        label {
            font-weight: normal !important;
        }

        @media print {
            body {
                font-size: 10px;
                /* Reduce font size */
            }

            .table-bordered {
                font-size: 8px;
                /* Smaller table text */
            }

            .row,
            .col-md-4,
            .col-md-8 {
                padding: 0;
                /* Remove padding */
            }

            .table {
                width: 100%;
                /* Ensure the table fits on the page */
            }

            /* Adjust spacing for labels and content */
            label {
                font-size: 9px;
                margin-bottom: 2px;
            }

            /* Set table headers smaller */
            .table thead th {
                font-size: 8px;
            }

            /* Box styling adjustments */
            .box-right span {
                font-size: 9px;
            }

            /* Reduce spacing between elements */
            .row {
                margin-bottom: 5px;
                /* Reduce row spacing */
            }

            .form-group {
                margin-bottom: 5px;
                /* Reduce form-group spacing */
            }

            /* Adjust table cell padding for print */
            .table td,
            .table th {
                padding: 2px;
            }
        }

        /* Reduce table font size and cell padding */
        .box-right table {
            width: 100%;
            /* Ensures the table fits the box */
            font-size: 12px;
            /* Smaller font size */
            border-collapse: collapse;
            /* Ensures borders are clean and tight */
        }

        .box-right td,
        .box-right th {
            padding: ;
            /* Reduce padding for a more compact table */
            text-align: center;
            /* Keeps the text centered inside cells */
        }

        .box-right th {
            background-color: #17a2b8;
            /* Optional: Ensure header background color stays intact */
            color: white;
        }

        .box-right table,
        .box-right th,
        .box-right td {
            border: 1px solid #ddd;
            /* Ensure proper borders for cells */
        }

        /* Reduce table font size and cell padding */
        .row .table {
            font-size: 12px;
            /* Smaller font size */
            border-collapse: collapse;
            /* Ensures borders are clean and tight */
            width: 100%;
            /* Ensure the table fits within the column */
        }

        .row .table th,
        .row .table td {
            padding: 0px;
            /* Reduce padding for a more compact layout */
            text-align: center;
            /* Keeps the text aligned to the center */
        }

        .row .table th {
            background-color: #17a2b8;
            /* Optional: Set header background color */
            color: white;
            /* Ensure text color is white in the header */
        }

        .row .table,
        .row .table th,
        .row .table td {
            border: 1px solid #ddd;
            /* Define border style */
        }

        .newtab td {
            text-align: left !important;
        }

        /* Header Section */
        .header-print {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            border-bottom: 2px solid black;
        }

        .logo {
            width: 80px;
            height: auto;
        }

        .hospital-info {
            text-align: right;
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
        }

        .hospital-info h1 {
            font-size: 18px;
            margin: 0;
            font-weight: bold;
        }

        .hospital-info p {
            margin: 5px 0 0;
        }
    </style>



    <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datetimepicker.css">
    <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap-datetimepicker.js"></script>
    <!-- <body onLoad="set_tpa(<?php echo $data_list['insurance_type']; ?>); set_married(<?php echo $data_list['marital_status']; ?>);">  -->

<body>
    <div class="container-fluid">
        <div class="header-print">
            <img width="280px" src="https://cdn.hexahealth.com/Image/996a9a6d-24fc-48f0-9464-93d36f0f8cfd.jpg">
            <div class="hospital-info">
                <h1>JAMSHEDPUR EYE HOSPITAL</h1>
                <p>Sakchi, Jamshedpur- 831001, Jharkhand, India</p>
                <p>Phone: (0657) 2432203, 2422933; Email: jamshedpureyehospital@gmail.com</p>
            </div>
        </div>
        <?php //echo "<pre>";print_r($data_list);die; ?>
        <div class="panel-body" style="padding:0px;">
            <!-- <p style="text-align: center; font-size: 7px;"><strong>Sara Eye HOSPITALS</strong></p> -->
            <?php
            // Loop through the contact lens data
            $age_y = $booking_data['age_y'] ?? '';
            $age_m = $booking_data['age_m'] ?? '';
            $age_d = $booking_data['age_d'] ?? '';

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
            <table class="patient-info-table" style=" margin-top: 20px; ">
                <tr>
                    <td class="left-column">
                        <table>
                            <tr>
                                <td class="info-label">Patient</td>
                                <td class="info-content">: <?php echo $booking_data['patient_name'] ?? ''; ?></td>
                            </tr>
                            <tr>
                                <td class="info-label">Patient Reg. No</td>
                                <td class="info-content">: <?php echo $booking_data['patient_code'] ?? ''; ?></td>
                            </tr>
                            <tr>
                                <td class="info-label">OPD No</td>
                                <td class="info-content">: <?php echo $booking_data['booking_code'] ?? ''; ?></td>
                            </tr>
                            <tr>
                                <td class="info-label">Token No</td>
                                <td class="info-content">: <?php echo $booking_data['token_no'] ?? ''; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td class="right-column">
                        <table>
                            <tr>
                                <td class="info-label">Mobile no.</td>
                                <td class="info-content">: <?php echo $booking_data['mobile_no'] ?? ''; ?></td>
                            </tr>
                            <tr>
                                <td class="info-label">Age</td>
                                <td class="info-content">: <?php echo $age ?? ''; ?></td>
                            </tr>
                            <tr>
                                <td class="info-label">Gender</td>
                                <td class="info-content">:
                                    <?php echo ($booking_data['gender'] == '0') ? 'Female' : 'Male'; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="info-label">Date/Time</td>
                                <td class="info-content">:
                                <?php echo date('d-m-Y h:i A', strtotime($booking_data['created_date'])); ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <div class="panel-body" style="padding:0px;">
                <h4
                    style="float:left;width:100%;text-align:center;margin:2px 2px;position:relative; border:1px solid; padding:5px;">
                    <!-- <span style="position:absolute;height:2px;width:40%;background:#eee;"></span> -->
                    OrthoPtics Evaluation Performa
                </h4>
                <?php
                $chief_complaints = json_decode($data_list[0]->chief_complaints); // Adjust this method according to your model
                $chief_complaints = (array) $chief_complaints;
                $squint_history = json_decode($data_list[0]->squint_history);
                $squint_history = (array) $squint_history;
                // echo "<pre>";print_r($squint_history);die;
                ?>
                <div class="panel-body"
                    style="float:left;width:100%;margin:2px 2px;position:relative; border:1px solid; padding:5px;">
                    <div class="row" style="font-size: 15px; font-weight: normal;">
                        <div class="col-xs-2" style="margin-left: 15px;margin-top: 10px;"><strong>Referred by: </strong>
                            <?php echo $data_list['doctor_name']; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h4 style="margin-left: 0px;"><strong>History: </strong></h4>
                            <section>
                                <div class="" style="margin-left: 15px; margin-top:15px">
                                    <label><strong>Main Complaints: </strong>
                                        <?php echo $data_list['main_complaints'] ?></label>
                                </div>
                                <div class="" style="margin-left: 15px; margin-top:25px;">
                                    <label><strong>Hours of near work/computer use & related details:
                                        </strong> <?php echo $data_list['hours_of_work_computer']; ?></label>
                                </div>

                                <div class="" style="margin-left: 15px; margin-top:25px;">
                                    <label><strong>Associated Symptoms:</strong>
                                        <?php echo $data_list['associated_symptoms']; ?></label>

                                </div>
                                <div class="" style="margin-left: 15px; margin-top:25px;">
                                    <label><strong>Previous History of Orthoptics Treatment & related Details(Compliance
                                            etc.): </strong> <?php echo $data_list['previ_his_of_ortho']; ?></label>
                                </div>
                                <div class="" style="margin-left: 15px; margin-top:25px;">
                                    <label><strong>General Health & Medication Details: </strong>
                                        <?php echo $data_list['gene_heal_medi_deta']; ?></label>

                                </div>
                            </section>
                        </div>
                        <div class="col-md-6">
                            <h4 style="margin-left: 15px;"><strong>Refraction: </strong></h4>
                            <!-- UnVn Row -->
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
                                        <td><?php echo $refraction_tbl['visual_acuity_od']; ?></td>
                                        <td><?php echo $refraction_tbl['visual_acuity_os']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Duchrome</td>
                                        <td><?php echo $refraction_tbl['duchrome_od']; ?></td>
                                        <td><?php echo $refraction_tbl['duchrome_os']; ?>></td>
                                    </tr>
                                    <tr>
                                        <td>PGP</td>
                                        <td><?php echo $refraction_tbl['pgp_od']; ?></td>
                                        <td><?php echo $refraction_tbl['pgp_os']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Static Retinoscopy</td>
                                        <td><?php echo $refraction_tbl['static_retinoscopy_od']; ?></td>
                                        <td><?php echo $refraction_tbl['static_retinoscopy_os']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Acceptance(PMT)</td>
                                        <td><?php echo $refraction_tbl['acceptance_od']; ?></td>
                                        <td><?php echo $refraction_tbl['acceptance_os']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>JCC Refining</td>
                                        <td><?php echo $refraction_tbl['jcc_refining_od']; ?></td>
                                        <td><?php echo $refraction_tbl['jcc_refining_os']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Add</td>
                                        <td><?php echo $refraction_tbl['add_od']; ?></td>
                                        <td><?php echo $refraction_tbl['add_os']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>After Binocular Balancing(Final Rx)</td>
                                        <td><?php echo $refraction_tbl['after_binocular_balancing_od']; ?>
                                        </td>
                                        <td><?php echo $refraction_tbl['after_binocular_balancing_os']; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <section>
                                <div class="" style="margin-left: 15px; margin-top:15px">
                                    <label><strong>Additional testing: </strong>
                                        <?php echo $data_list['addi_test'] ?></label>
                                </div>
                            </section>
                            <section>
                                <div class="" style="margin-left: 15px; margin-top:15px">
                                    <label><strong>Details regarding Adaption: </strong>
                                        <?php echo $data_list['addi_test'] ?></label>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                    <h4><strong>Binocular Vision assessment: </strong></h4>
                    <div class="row">
                        <div class="col-md-4">
                            <section>
                                <div class="" style="margin-left: 15px; margin-top:15px">
                                    <label><strong>Sensory Evaluation: </strong>
                                        <?php echo $data_list['senso_evalu'] ?></label>
                                </div>
                            </section>
                            <section>
                                <div class="" style="margin-left: 15px; margin-top:15px">
                                    <label><strong>Stereopsis(Near) with Randot Stereo: </strong>
                                        <?php echo $data_list['stere_with_rando_stere'] ?></label>
                                </div>
                            </section>
                            <section>
                                <div class="" style="margin-left: 15px; margin-top:15px">
                                    <label><strong>Motor Evaluation: </strong>
                                        <?php echo $data_list['motor_evaluation'] ?></label>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-8">
                            <section style="float:left;width:48%;margin-right: 10px;">
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
                                            <td><?php echo $eom_tbl['eom_od']; ?></td>
                                            <td><?php echo $eom_tbl['eom_os']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </section>
                            <section style="float:left;width:48%;margin-right: 10px;">
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
                                            <td><?php echo $wfdt_tbl['wfdt_d']; ?>
                                            <td><?php echo $wfdt_tbl['wfdt_n']; ?>
                                        </tr>
                                        <tr>
                                            <td>Cover Test</td>
                                            <td><?php echo $wfdt_tbl['cover_test_d']; ?></td>
                                            <td><?php echo $wfdt_tbl['cover_test_n']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Maddox Rod: Horizontal</td>
                                            <td><?php echo $wfdt_tbl['maddox_rod_horizontal_d']; ?></td>
                                            <td><?php echo $wfdt_tbl['maddox_rod_horizontal_n']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Maddox Rod: Vertical</td>
                                            <td><?php echo $wfdt_tbl['maddox_rod_vertical_d']; ?></td>
                                            <td><?php echo $wfdt_tbl['maddox_rod_vertical_n']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>PBCT</td>
                                            <td><?php echo $wfdt_tbl['pbct_d']; ?>
                                            <td><?php echo $wfdt_tbl['pbct_n']; ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </section>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <section>
                                <div class="" style="margin-left: 15px; margin-top:15px">
                                    <label><strong>Distance IPD: </strong>
                                        <?php echo $data_list['distance_ipd'] ?></label>
                                </div>
                            </section>
                            <section>
                                <div class="" style="margin-left: 15px; margin-top:15px">
                                    <label><strong>AC/A Ratio: </strong>
                                        <?php echo $data_list['ac_a_ratio'] ?></label>
                                </div>
                            </section>
                            <section>
                                <div class="" style="margin-left: 15px; margin-top:15px">
                                    <label><strong>Heterophoria Method: </strong>
                                        <?php echo $data_list['heterophoria_method'] ?></label>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row" style="padding: 0 15px; margin-top:45px">
                <div class="footer"
                    style="position: fixed; bottom: 0; left: 0; right: 0; background-color: #f8f9fa; text-align: center; padding: 10px; box-shadow: 0 -2px 5px rgba(0,0,0,0.1);">
                    <hr />
                    <p style="margin: 0;">Powered by Sara Software</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>