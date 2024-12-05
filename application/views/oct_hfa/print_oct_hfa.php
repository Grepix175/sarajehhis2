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
            padding: ;
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



            <?php //echo"<pre>";print_r($data_list[0]);die; ?>
            


            <div class="panel-body" style="padding:0px;">
                <h4 style="float:left;width:100%;text-align:center;margin:2px 2px;position:relative;">
                    <!-- <span style="position:absolute;height:2px;width:40%;background:#eee;"></span> -->
                    OCT/HFA
                </h4>
                <?php
                $chief_complaints = json_decode($data_list[0]->chief_complaints); // Adjust this method according to your model
                $chief_complaints = (array) $chief_complaints;
                // echo "<pre>";print_r($data['chief_complaints']);die;
                $squint_history = json_decode($data_list[0]->squint_history);
                $squint_history = (array) $squint_history;
                // echo "<pre>";print_r($squint_history);die;
                ?>
                <div class="row" style="font-size: 10px; font-weight: normal;">
                    <table style="width: 100%; border-collapse: collapse;padding-left:15px;">
                        <tr>
                            <!-- Step-1 History -->
                            <td style="text-align: left; padding: 15px 15px 0 15px;width:20%;">
                                Step-1 History
                            </td>

                            <!-- Step-2 Refraction -->
                            <td style="text-align: left; padding: 15px 0 0 15px;">
                                Step-2 Refraction
                            </td>

                            <!-- Step-3 Examination -->
                            <td style="text-align: left; padding: 15px 15px 0 0;">
                                Step-3 Examination
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="row" style="font-size: 10px; font-weight: normal;">
                    <table style="width: 100%; border-collapse: collapse; padding-left: 15px;">
                        <tr>
                            <!-- Step-1 History -->
                            <td style="text-align: left; padding: 15px; width: 25%;">
                                <strong>Visit:</strong>
                            </td>
                            <td style="text-align: left; padding: 15px; width: 8%;">
                                <strong>...</strong>
                            </td>

                            <!-- Step-2 Refraction -->
                            <td style="text-align: left; padding: 15px;">
                                <strong>General checkup</strong>
                            </td>

                            <!-- Step-3 Examination -->
                            <td style="text-align: left; padding: 15px;">
                                <strong>Routine checkup</strong>
                            </td>

                            <!-- Step-1 History -->
                            <td style="text-align: left; padding: 15px;">
                                <strong>PostOP CHECK Up</strong>
                            </td>

                            <!-- Step-2 Refraction -->
                            <td style="text-align: left; padding: 15px;">
                                <strong>2nd Opinion Referred</strong>
                            </td>

                            <!-- Step-3 Examination -->
                            <td style="text-align: left; padding: 15px;">
                                <!-- Empty cell if needed -->
                            </td>
                        </tr>
                    </table>
                </div>
                <ul style="list-style:none;margin:5px 0 15px;padding:0px;font-size:11px;">
                    <strong>Chied compalaints:</strong>

                    <?php
                    if ($chief_complaints['bdv_m'] == 1) { ?>
                        <li style=""> Blurring/Diminution of vision in <strong style="font-size:10px;">
                                <?php if (!empty($chief_complaints['history_chief_blurr_side'])) {
                                    echo $chief_complaints['history_chief_blurr_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size:10px;">
                                <?php if (!empty($chief_complaints['history_chief_blurr_dur'])) {
                                    echo 'since ' . $chief_complaints['history_chief_blurr_dur'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_blurr_unit'])) {
                                    echo $chief_complaints['history_chief_blurr_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_blurr_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_blurr_comm'];
                                }
                                if ($chief_complaints['history_chief_blurr_dist'] == 1) {
                                    echo ' - Distant, ';
                                }
                                if ($chief_complaints['history_chief_blurr_near'] == 1) {
                                    echo ' Near,';
                                }
                                if ($chief_complaints['history_chief_blurr_pain'] == 1) {
                                    echo ' Pain and ';
                                }
                                if ($chief_complaints['history_chief_blurr_ug'] == 1) {
                                    echo ' Using Glasses, ';
                                } ?>
                        </li>
                    <?php }
                    if ($chief_complaints['pain_m'] == 1) { ?></strong>
                        <li style=""> Pain in <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_pains_side'])) {
                                    echo $chief_complaints['history_chief_pains_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_pains_dur'])) {
                                    echo 'since ' . $chief_complaints['history_chief_pains_dur'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_pains_unit'])) {
                                    echo $chief_complaints['history_chief_pains_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_pains_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_pains_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['redness_m'] == 1) { ?>
                        <li style=""> Redness in <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_rednes_side'])) {
                                    echo $chief_complaints['history_chief_rednes_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_rednes_dur'])) {
                                    echo 'since ' . $chief_complaints['history_chief_rednes_dur'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_rednes_unit'])) {
                                    echo $chief_complaints['history_chief_rednes_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_rednes_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_rednes_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['injury_m'] == 1) { ?>
                        <li style=""> Injury in <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_injuries_side'])) {
                                    echo $chief_complaints['history_chief_injuries_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_injuries_dur'])) {
                                    echo 'since ' . $chief_complaints['history_chief_injuries_dur'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_injuries_unit'])) {
                                    echo $chief_complaints['history_chief_injuries_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_injuries_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_injuries_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['water_m'] == 1) { ?>
                        <li style=""> Watering in <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_waterings_side'])) {
                                    echo $chief_complaints['history_chief_waterings_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_waterings_dur'])) {
                                    echo 'since ' . $chief_complaints['history_chief_waterings_dur'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_waterings_unit'])) {
                                    echo $chief_complaints['history_chief_waterings_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_waterings_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_waterings_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['discharge_m'] == 1) { ?>
                        <li style=""> Discharge in <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_discharges_side'])) {
                                    echo $chief_complaints['history_chief_discharges_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_discharges_dur'])) {
                                    echo 'since ' . $chief_complaints['history_chief_discharges_dur'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_discharges_unit'])) {
                                    echo $chief_complaints['history_chief_discharges_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_discharges_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_discharges_comm'] . ', ';
                                } ?>

                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['dryness_m'] == 1) { ?>
                        <li style=""> Dryness in <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_dryness_side'])) {
                                    echo $chief_complaints['history_chief_dryness_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_dryness_dur'])) {
                                    echo 'since ' . $chief_complaints['history_chief_dryness_dur'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_dryness_unit'])) {
                                    echo $chief_complaints['history_chief_dryness_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_dryness_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_dryness_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['itch_m'] == 1) { ?>
                        <li style=""> Itching in <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_itchings_side'])) {
                                    echo $chief_complaints['history_chief_itchings_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_itchings_dur'])) {
                                    echo 'since ' . $chief_complaints['history_chief_itchings_dur'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_itchings_unit'])) {
                                    echo $chief_complaints['history_chief_itchings_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_itchings_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_itchings_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['fbd_m'] == 1) { ?>
                        <li style=""> Fbsensation in <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_fbsensation_side'])) {
                                    echo $chief_complaints['history_chief_fbsensation_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_fbsensation_dur'])) {
                                    echo 'since ' . $chief_complaints['history_chief_fbsensation_dur'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_fbsensation_unit'])) {
                                    echo $chief_complaints['history_chief_fbsensation_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_fbsensation_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_fbsensation_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['devs_m'] == 1) { ?>
                        <li style=""> Deviation Squint in <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_dev_squint_side'])) {
                                    echo $chief_complaints['history_chief_dev_squint_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_dev_squint_dur'])) {
                                    echo 'since ' . $chief_complaints['history_chief_dev_squint_dur'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_dev_squint_unit'])) {
                                    echo $chief_complaints['history_chief_dev_squint_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_dev_squint_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_dev_squint_comm'];
                                }
                                if ($chief_complaints['history_chief_dev_diplopia'] != '') {
                                    echo ' - ' . $chief_complaints['history_chief_dev_diplopia'];
                                }
                                if ($chief_complaints['history_chief_dev_truma'] != '') {
                                    echo ', ' . $chief_complaints['history_chief_dev_diplopia'];
                                }
                                if ($chief_complaints['history_chief_dev_ps'] != '') {
                                    echo ', ' . $chief_complaints['history_chief_dev_ps'];
                                } ?></strong>
                        </li>
                    <?php }
                    if ($chief_complaints['heads_m'] == 1) { ?>
                        <li style=""> Headache Strain in <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_head_strain_side'])) {
                                    echo $chief_complaints['history_chief_head_strain_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_head_strain_dur'])) {
                                    echo 'since ' . $chief_complaints['history_chief_head_strain_dur'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_head_strain_unit'])) {
                                    echo $chief_complaints['history_chief_head_strain_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_head_strain_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_head_strain_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['canss_m'] == 1) { ?>
                        <li style=""> Change In Size Shape in <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_size_shape_side'])) {
                                    echo $chief_complaints['history_chief_size_shape_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_size_shape_dur'])) {
                                    echo 'since ' . $chief_complaints['history_chief_size_shape_dur'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_size_shape_unit'])) {
                                    echo $chief_complaints['history_chief_size_shape_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_size_shape_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_size_shape_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['ovs_m'] == 1) { ?>
                        <li style=""> Other Visual Symptoms in <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_ovs_side'])) {
                                    echo $chief_complaints['history_chief_ovs_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_ovs_dur'])) {
                                    echo 'since ' . $chief_complaints['history_chief_ovs_dur'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_ovs_unit'])) {
                                    echo $chief_complaints['history_chief_ovs_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_ovs_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_ovs_comm'];
                                }
                                if ($chief_complaints['history_chief_ovs_glare'] == 1) {
                                    echo ' - Glare,';
                                }
                                if ($chief_complaints['history_chief_ovs_floaters'] == 1) {
                                    echo ' Floaters,';
                                }
                                if ($chief_complaints['history_chief_ovs_photophobia'] == 1) {
                                    echo ' Photophobia,';
                                }
                                if ($chief_complaints['history_chief_ovs_color_halos'] == 1) {
                                    echo ' Colored Halos,';
                                }
                                if ($chief_complaints['history_chief_ovs_metamorphopsia'] == 1) {
                                    echo ' Metamorphopsia, ';
                                }
                                if ($chief_complaints['history_chief_ovs_chromatopsia'] == 1) {
                                    echo ' Chromatopsia,';
                                }
                                if ($chief_complaints['history_chief_ovs_dnv'] == 1) {
                                    echo ' Diminished Night Vision and ';
                                }
                                if ($chief_complaints['history_chief_ovs_ddv'] == 1) {
                                    echo ' Diminished Day Vision';
                                } ?></strong>
                        </li>
                    <?php }
                    if ($chief_complaints['sdv_m'] == 1) { ?>
                        <li style=""> Shadow Defect In Vision in <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_sdiv_side'])) {
                                    echo $chief_complaints['history_chief_sdiv_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_sdiv_dur'])) {
                                    echo 'since ' . $chief_complaints['history_chief_sdiv_dur'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_sdiv_unit'])) {
                                    echo $chief_complaints['history_chief_sdiv_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_sdiv_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_sdiv_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['doe_m'] == 1) { ?>
                        <li style=""> Discoloration Of Eye in <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_doe_side'])) {
                                    echo $chief_complaints['history_chief_doe_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_doe_dur'])) {
                                    echo 'since ' . $chief_complaints['history_chief_doe_dur'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_doe_unit'])) {
                                    echo $chief_complaints['history_chief_doe_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_doe_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_doe_comm'] . ', ';
                                } ?>

                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['swel_m'] == 1) { ?>
                        <li style=""> Swelling in <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_swell_side'])) {
                                    echo $chief_complaints['history_chief_swell_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_swell_dur'])) {
                                    echo 'since ' . $chief_complaints['history_chief_swell_dur'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_swell_unit'])) {
                                    echo $chief_complaints['history_chief_swell_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_swell_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_swell_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['burns_m'] == 1) { ?>
                        <li style=""> Sensation Burning in <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_sen_burn_side'])) {
                                    echo $chief_complaints['history_chief_sen_burn_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_sen_burn_dur'])) {
                                    echo 'since ' . $chief_complaints['history_chief_sen_burn_dur'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_sen_burn_unit'])) {
                                    echo $chief_complaints['history_chief_sen_burn_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_sen_burn_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_sen_burn_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['ptosis_sx'] == 1) { ?>
                        <li style=""> Ptosis Sx <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_ptosis_side'])) {
                                    echo $chief_complaints['history_chief_ptosis_side'];
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_ptosis_dur'])) {
                                    echo 'since ' . $chief_complaints['history_chief_ptosis_dur'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_ptosis_unit'])) {
                                    echo $chief_complaints['history_chief_ptosis_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_ptosis_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_ptosis_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['lid_sx'] == 1) { ?>
                        <li style=""> Lid Sx <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_lid_sx_side'])) {
                                    echo $chief_complaints['history_chief_lid_sx_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_lid_sx_dur'])) {
                                    echo 'since ' . $chief_complaints['history_chief_lid_sx_dur'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_lid_sx_unit'])) {
                                    echo $chief_complaints['history_chief_lid_sx_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_lid_sx_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_lid_sx_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['corneal_sx'] == 1) { ?>
                        <li style=""> Corneal Sx <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_corneal_sx_side'])) {
                                    echo $chief_complaints['history_chief_corneal_sx_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_corneal_sx_dur'])) {
                                    echo 'since ' . $chief_complaints['history_chief_corneal_sx_dur'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_corneal_sx_unit'])) {
                                    echo $chief_complaints['history_chief_corneal_sx_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_corneal_sx_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_corneal_sx_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['cataract_sx'] == 1) { ?>
                        <li style=""> Cataract Sx <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_cataract_sx_side'])) {
                                    echo $chief_complaints['history_chief_cataract_sx_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_cataract_sx_due'])) {
                                    echo 'since ' . $chief_complaints['history_chief_cataract_sx_due'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_cataract_sx_unit'])) {
                                    echo $chief_complaints['history_chief_cataract_sx_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_cataract_sx_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_cataract_sx_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['squint_sx'] == 1) { ?>
                        <li style=""> Squint Sx <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_squint_sx_side'])) {
                                    echo $chief_complaints['history_chief_squint_sx_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_squint_sx_due'])) {
                                    echo 'since ' . $chief_complaints['history_chief_squint_sx_due'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_squint_sx_unit'])) {
                                    echo $chief_complaints['history_chief_squint_sx_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_squint_sx_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_squint_sx_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['pterygium_sx'] == 1) { ?>
                        <li style=""> Pterygium Sx <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_pterygium_sx_side'])) {
                                    echo $chief_complaints['history_chief_pterygium_sx_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_pterygium_sx_due'])) {
                                    echo 'since ' . $chief_complaints['history_chief_pterygium_sx_due'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_pterygium_sx_unit'])) {
                                    echo $chief_complaints['history_chief_pterygium_sx_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_pterygium_sx_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_pterygium_sx_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['dcr'] == 1) { ?>
                        <li style=""> DCR <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_dcr_sx_side'])) {
                                    echo $chief_complaints['history_chief_dcr_sx_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_dcr_sx_due'])) {
                                    echo 'since ' . $chief_complaints['history_chief_dcr_sx_due'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_dcr_sx_unit'])) {
                                    echo $chief_complaints['history_chief_dcr_sx_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_dcr_sx_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_dcr_sx_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['dct_sx'] == 1) { ?>
                        <li style=""> DCT Sx <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_dct_sx_side'])) {
                                    echo $chief_complaints['history_chief_dct_sx_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_dct_sx_due'])) {
                                    echo 'since ' . $chief_complaints['history_chief_dct_sx_due'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_dct_sx_unit'])) {
                                    echo $chief_complaints['history_chief_dct_sx_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_dct_sx_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_dct_sx_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['patching_therapy'] == 1) { ?>
                        <li style=""> Patching Therapy <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_patching_therapy_side'])) {
                                    echo $chief_complaints['history_chief_patching_therapy_side'] . ' Eye ';
                                } ?></strong>
                            <strong style="font-size: 10px;">
                                <?php if (!empty($chief_complaints['history_chief_patching_therapy_due'])) {
                                    echo 'since ' . $chief_complaints['history_chief_patching_therapy_due'] . ' ';
                                }
                                if (!empty($chief_complaints['history_chief_patching_therapy_unit'])) {
                                    echo $chief_complaints['history_chief_patching_therapy_unit'];
                                }
                                if (!empty($chief_complaints['history_chief_patching_therapy_comm'])) {
                                    echo ' - ' . $chief_complaints['history_chief_patching_therapy_comm'] . ', ';
                                } ?>
                            </strong>
                        </li>
                    <?php }
                    if ($chief_complaints['history_chief_comm'] != '') { ?>
                        <li style="margin-top:8px;"> <strong style="font-size: 10px;">
                                <?php echo '- ' . $chief_complaints['history_chief_comm']; ?></strong> </li>
                    <?php } ?>
                </ul>

                <div class="row" style="margin:5px 0 15px;">
                    <div class="col">
                        <strong>Past Ocular History:</strong>
                        <span style="font-size: 10px;">
                            <?php if (!empty($data_list[0]->ocular_history)) {
                                echo htmlspecialchars($data_list[0]->ocular_history);
                            } else {
                                echo "N/A"; // or any fallback text
                            } ?>
                        </span>
                    </div>
                </div>

                <div class="row" style="margin:0 0 15px;">
                    <div class="col">
                        <strong>Past Medical History:</strong>
                        <span style="font-size: 10px;">
                            <?php if (!empty($data_list[0]->medical_history)) {
                                echo htmlspecialchars($data_list[0]->medical_history);
                            } else {
                                echo "N/A"; // or any fallback text
                            } ?>
                        </span>
                    </div>
                </div>


                <div class="row" style="padding: 0 15px">
                    <div style="width: 33%; float: left;">
                        <strong>Birth History:</strong>

                        <div style="font-size: 10px; font-weight: normal;">
                            <label for="no_of_child">No of child: </label>
                            <?php if (!empty($data_list[0]->no_of_child)) {
                                echo "<strong>" . htmlspecialchars($data_list[0]->no_of_child) . "</strong>";
                            } else {
                                echo "<strong>N/A</strong>"; // or any fallback text
                            } ?>
                        </div>

                        <div style="font-size: 10px;">
                            <label for="delivery_type">Full term: </label>
                            <?php if (!empty($data_list[0]->delivery_type)) {
                                echo "<strong>" . htmlspecialchars($data_list[0]->delivery_type) . "</strong>";
                            } else {
                                echo "<strong>N/A</strong>"; // or any fallback text
                            } ?>
                        </div>

                        <div style="font-size: 10px;">
                            <label for="birth_weight">Birth Weight (Kg): </label>
                            <?php if (!empty($data_list[0]->birth_weight)) {
                                echo "<strong>" . htmlspecialchars($data_list[0]->birth_weight) . "</strong>";
                            } else {
                                echo "<strong>N/A</strong>"; // or any fallback text
                            } ?>
                        </div>

                        <div style="font-size: 10px;">
                            <label for="recent_weight">Recent Weight (Kg): </label>
                            <?php if (!empty($data_list[0]->recent_weight)) {
                                echo "<strong>" . htmlspecialchars($data_list[0]->recent_weight) . "</strong>";
                            } else {
                                echo "<strong>N/A</strong>"; // or any fallback text
                            } ?>
                        </div>

                        <div style="font-size: 10px;">
                            <label for="birth_asphyxia">H/O of Birth Asphyxia: </label>
                            <?php if (!empty($data_list[0]->birth_asphyxia)) {
                                echo "<strong>" . htmlspecialchars($data_list[0]->birth_asphyxia) . "</strong>";
                            } else {
                                echo "<strong>N/A</strong>"; // or any fallback text
                            } ?>
                        </div>

                        <div style="font-size: 10px;">
                            <label for="cried_after_birth">Cried after Birth: </label>
                            <?php if (!empty($data_list[0]->cried_after_birth)) {
                                echo "<strong>" . htmlspecialchars($data_list[0]->cried_after_birth) . "</strong>";
                            } else {
                                echo "<strong>N/A</strong>"; // or any fallback text
                            } ?>
                        </div>

                        <div style="font-size: 10px;">
                            <label for="infection_history">H/O: Pre/Peri/Postnatal Infection: </label>
                            <?php if (!empty($data_list[0]->infection_history)) {
                                echo "<strong>" . htmlspecialchars($data_list[0]->infection_history) . "</strong>";
                            } else {
                                echo "<strong>N/A</strong>"; // or any fallback text
                            } ?>
                        </div>

                        <div style="font-size: 10px;">
                            <label for="milestone">Milestone: </label>
                            <?php if (!empty($data_list[0]->milestone)) {
                                echo "<strong>" . htmlspecialchars($data_list[0]->milestone) . "</strong>";
                            } else {
                                echo "<strong>N/A</strong>"; // or any fallback text
                            } ?>
                        </div>

                        <div style="font-size: 10px;">
                            <label for="convulsion_history">H/O Convulsion/Fits/Seizure: </label>
                            <?php if (!empty($data_list[0]->convulsion_history)) {
                                echo "<strong>" . htmlspecialchars($data_list[0]->convulsion_history) . "</strong>";
                            } else {
                                echo "<strong>N/A</strong>"; // or any fallback text
                            } ?>
                        </div>

                        <div style="font-size: 10px;">
                            <label for="consanguinity_history">H/O of Consanguinity: </label>
                            <?php if (!empty($data_list[0]->consanguinity_history)) {
                                echo "<strong>" . htmlspecialchars($data_list[0]->consanguinity_history) . "</strong>";
                            } else {
                                echo "<strong>N/A</strong>"; // or any fallback text
                            } ?>
                        </div>
                        <div class="col-md-3" style="text-align:right; ">
                            <div style="font-size: 10px; font-weight: normal;">
                                <strong>Remarks:</strong>
                                <?php echo !empty($data_list[0]->remarks) ? "<strong>" . htmlspecialchars($data_list[0]->remarks) . "</strong>" : "<strong>N/A</strong>"; ?>
                            </div>
                        </div>
                    </div>

                    <!-- New Column for Squint History -->
                    <div style="width: 50%; float: left;">
                        <!-- <strong>Squint History:</strong>222 -->
                        <table id="newtab" style="width: 100%; font-size: 10px; text-align: left;">
                            <thead>
                                <tr>
                                    <th style="width:50%;">Squint History</th>
                                    <th>Side</th>
                                    <th>Duration</th>
                                    <th>Duration Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($squint_history['inward'] == 1) { ?>
                                    <tr>
                                        <td style="text-align:left;">Inward Deviation</td>
                                        <td style="text-align:left;">
                                            <?php echo !empty($squint_history['history_chief_inward_side']) ? $squint_history['history_chief_inward_side'] . ' Eye' : 'N/A'; ?>
                                        </td>
                                        <td style="text-align:left;">
                                            <?php echo !empty($squint_history['history_chief_inward_dur']) ? $squint_history['history_chief_inward_dur'] : 'N/A'; ?>
                                        </td>
                                        <td style="text-align:left;">
                                            <?php echo !empty($squint_history['history_chief_inward_unit']) ? $squint_history['history_chief_inward_unit'] : 'N/A'; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($squint_history['outward'] == 1) { ?>
                                    <tr>
                                        <td style="text-align:left;">Outward Deviation</td>
                                        <td style="text-align:left;">
                                            <?php echo !empty($squint_history['history_chief_outward_side']) ? $squint_history['history_chief_outward_side'] . ' Eye' : 'N/A'; ?>
                                        </td>
                                        <td style="text-align:left;">
                                            <?php echo !empty($squint_history['history_chief_outward_dur']) ? $squint_history['history_chief_outward_dur'] : 'N/A'; ?>
                                        </td>
                                        <td style="text-align:left;">
                                            <?php echo !empty($squint_history['history_chief_outward_unit']) ? $squint_history['history_chief_outward_unit'] : 'N/A'; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($squint_history['upward'] == 1) { ?>
                                    <tr>
                                        <td style="text-align:left;">Upward/Downward Deviation</td>
                                        <td style="text-align:left;">
                                            <?php echo !empty($squint_history['history_chief_upward_side']) ? $squint_history['history_chief_upward_side'] . ' Eye' : 'N/A'; ?>
                                        </td>
                                        <td style="text-align:left;">
                                            <?php echo !empty($squint_history['history_chief_upward_dur']) ? $squint_history['history_chief_upward_dur'] : 'N/A'; ?>
                                        </td>
                                        <td style="text-align:left;">
                                            <?php echo !empty($squint_history['history_chief_upward_unit']) ? $squint_history['history_chief_upward_unit'] : 'N/A'; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($squint_history['prev_squint'] == 1) { ?>
                                    <tr>
                                        <td style="text-align:left;">Previous H/O Squint/Other Surgery</td>
                                        <td><?php echo !empty($squint_history['history_chief_prev_squint_side']) ? $squint_history['history_chief_prev_squint_side'] . ' Eye' : 'N/A'; ?>
                                        </td>
                                        <td><?php echo !empty($squint_history['history_chief_prev_squint_dur']) ? $squint_history['history_chief_prev_squint_dur'] : 'N/A'; ?>
                                        </td>
                                        <td><?php echo !empty($squint_history['history_chief_prev_squint_unit']) ? $squint_history['history_chief_prev_squint_unit'] : 'N/A'; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($squint_history['double_vision'] == 1) { ?>
                                    <tr>
                                        <td style="text-align:left;">H/O Double Vision</td>
                                        <td><?php echo !empty($squint_history['history_chief_double_vision_side']) ? $squint_history['history_chief_double_vision_side'] . ' Eye' : 'N/A'; ?>
                                        </td>
                                        <td><?php echo !empty($squint_history['history_chief_double_vision_dur']) ? $squint_history['history_chief_double_vision_dur'] : 'N/A'; ?>
                                        </td>
                                        <td><?php echo !empty($squint_history['history_chief_double_vision_unit']) ? $squint_history['history_chief_double_vision_unit'] : 'N/A'; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($squint_history['constant'] == 1) { ?>
                                    <tr>
                                        <td style="text-align:left;">Constant/Occasional/Intermittent</td>
                                        <td><?php echo !empty($squint_history['history_chief_constant_side']) ? $squint_history['history_chief_constant_side'] . ' Eye' : 'N/A'; ?>
                                        </td>
                                        <td><?php echo !empty($squint_history['history_chief_constant_dur']) ? $squint_history['history_chief_constant_dur'] : 'N/A'; ?>
                                        </td>
                                        <td><?php echo !empty($squint_history['history_chief_constant_unit']) ? $squint_history['history_chief_constant_unit'] : 'N/A'; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($squint_history['antisupression'] == 1) { ?>
                                    <tr>
                                        <td style="text-align:left;">H/O Wearing Glasses/Patching Therapy/Antisupression
                                        </td>
                                        <td><?php echo !empty($squint_history['history_chief_antisupression_side']) ? $squint_history['history_chief_antisupression_side'] . ' Eye' : 'N/A'; ?>
                                        </td>
                                        <td><?php echo !empty($squint_history['history_chief_antisupression_dur']) ? $squint_history['history_chief_antisupression_dur'] : 'N/A'; ?>
                                        </td>
                                        <td><?php echo !empty($squint_history['history_chief_antisupression_unit']) ? $squint_history['history_chief_antisupression_unit'] : 'N/A'; ?>
                                        </td>
                                    </tr>
                                <?php }
                                if ($chief_complaints['squint_comm'] != '') { ?>
                                    <li style="margin-top:8px;"> <strong style="font-size: 10px;">
                                            <?php echo '- ' . $chief_complaints['squint_comm']; ?></strong> </li>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row" style="padding: 0 15px">

                    </div>








                    <div class="footer"
                        style="position: fixed; bottom: 0; left: 0; right: 0; background-color: #f8f9fa; text-align: center; padding: 10px; box-shadow: 0 -2px 5px rgba(0,0,0,0.1);">
                        <hr />
                        <p style="margin: 0;">Powered by Sara Software</p>
                    </div>

                </div>
                <div id="load_add_type_modal_popup" class="modal fade" role="dialog" data-backdrop="static"
                    data-keyboard="false"></div>



</body>



</html>