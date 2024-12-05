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

            <!-- Single Row for Date, Time, and Work-up Done By -->
            <div style="display: flex; justify-content: space-between; width: 100%; padding: 8px;">
                <!-- Date Section -->
                <div style="flex: 1; padding: 8px; text-align: left;">
                    <strong>Date:</strong>
                    <span>
                        <?php
                        if (isset($data_list[0]->created_date) && !empty($data_list[0]->created_date)) {
                            echo htmlspecialchars(date('d-m-Y', strtotime($data_list[0]->created_date)));
                        } else {
                            echo date('Y-m-d');
                        }
                        ?>
                    </span>
                </div>

                <!-- Time Section -->
                <div style="flex: 1; padding: 8px; text-align: left;">
                    <strong>Time:</strong>
                    <span>
                        <?php
                        if (isset($data_list[0]->created_date) && !empty($data_list[0]->created_date)) {
                            echo htmlspecialchars(date('H:i:s', strtotime($data_list[0]->created_date)));
                        } else {
                            echo date('H:i:s');
                        }
                        ?>
                    </span>
                </div>

                <!-- Work-up Done By Section -->
                <div style="flex: 1; padding: 8px; text-align: left;">
                    <strong>Work-up Done By:</strong>
                    <span>
                        <?php
                        if (!empty($doctor)) {
                            foreach ($doctor as $doctorObj) {
                                if (isset($data_list[0]->workup_by) && $doctorObj->id == $data_list[0]->workup_by) {
                                    echo htmlspecialchars($doctorObj->doctor_name);
                                    break;
                                }
                            }
                        } else {
                            echo 'No doctor found.';
                        }
                        ?>
                    </span>
                </div>
            </div>

            <table style="width:100%;">

                <!-- Full-Width Row for CONTACT LENS CLINIC / PROSTHETIC WORK SHEET -->
                <tr>
                    <td colspan="6"
                        style="padding: 16px; text-align:center; border: 2px solid #000; background-color: #f4f4f4;">
                        <strong>CONTACT LENS CLINIC / PROSTHETIC WORK SHEET</strong>
                    </td>
                </tr>
            </table>       


            <div class="panel-body" style="padding:0px;">
                <?php //echo "<pre>";print_r($data_list);die; ?>


                <!-- Date Section -->
                <table id="tabledata" style="width: 100%; border-collapse: collapse;">


                    <!-- Indication Row -->
                    <tr>
                        <td style="text-align:left; "><strong>Indication:</strong></td>
                        <td style="text-align:left; ">
                            <?php echo isset($data_list[0]->indication) ? htmlspecialchars($data_list[0]->indication) : ''; ?>
                        </td>
                    </tr>

                    <!-- Anterior Segment Evaluation Row -->
                    <tr>
                        <td style=" text-align:left;"><strong>Anterior Segment Evaluation:</strong></td>
                        <td style=" ">
                            <?php echo isset($data_list[0]->anterior_segment_evaluation) ? htmlspecialchars($data_list[0]->anterior_segment_evaluation) : ''; ?>
                        </td>
                    </tr>
                </table>



                <div class="grp" style="">
                   
                    <div class="box-right">
                        <table class="table table-bordered"
                            style="width:100%; font-size:12px; border-collapse:collapse;">
                            <thead class="bg-info">
                                <tr>
                                    <th width="25%" style="padding:0px;"> </th>
                                    <th width="25%" style="padding:0px;">OD</th>
                                    <th width="25%" style="padding:0px;">OS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align:left; padding:0px;">SPECTACLE POWER</td>
                                    <td style="padding:0px;">
                                        <?php echo isset($data_list[0]->spectacle_power_od) ? htmlspecialchars($data_list[0]->spectacle_power_od) : ''; ?>
                                    </td>
                                    <td style="padding:0px;">
                                        <?php echo isset($data_list[0]->spectacle_power_os) ? htmlspecialchars($data_list[0]->spectacle_power_os) : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; padding:0px;">KERATOMETRY</td>
                                    <td style="padding:0px;">
                                        <?php echo isset($data_list[0]->keratometry_od) ? htmlspecialchars($data_list[0]->keratometry_od) : ''; ?>
                                    </td>
                                    <td style="padding:0px;">
                                        <?php echo isset($data_list[0]->keratometry_os) ? htmlspecialchars($data_list[0]->keratometry_os) : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; padding:0px;">HVID</td>
                                    <td style="padding:0px;">
                                        <?php echo isset($data_list[0]->hvid_od) ? htmlspecialchars($data_list[0]->hvid_od) : ''; ?>
                                    </td>
                                    <td style="padding:0px;">
                                        <?php echo isset($data_list[0]->hvid_os) ? htmlspecialchars($data_list[0]->hvid_os) : ''; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                </div>

                <?php //echo "<pre>";print_r($data_list);die; ?>
                <div class="row" style="display: flex; align-items: center;">
                    <!-- Label Section (Name First) -->
                    <div class="col-md-12" style="padding-right: 10px;padding-left:15px; text-align: left;">
                        <label><strong>Contact Lens Trial:</strong></label>
                    </div>
                </div>

                <div class="row">
                    <!-- Table Section -->
                    <div class="col-md-12">
                        <table class="table table-bordered"
                            style="font-size:12px; border-collapse:collapse; width:100%;">
                            <thead>
                                <tr>
                                    <th style="padding:0px;"></th>
                                    <th style="padding:0px;">B.C (MM)</th>
                                    <th style="padding:0px;">DIA (MM)</th>
                                    <th style="padding:0px;">Power</th>
                                    <th style="padding:0px;">VN</th>
                                    <th style="padding:0px;">Remarks</th>
                                    <th style="padding:0px;">RX On Top</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Decode the JSON string into an object
                                $contactLensTrial = json_decode($data_list[0]->contact_lens_trial_table);
                                ?>
                                <tr>
                                    <td style="padding:0px;">OD OS</td>
                                    <td style="padding:0px;">
                                        <?php echo isset($contactLensTrial->bc_od) ? htmlspecialchars($contactLensTrial->bc_od) : ''; ?>
                                    </td>
                                    <td style="padding:0px;">
                                        <?php echo isset($contactLensTrial->dia_od) ? htmlspecialchars($contactLensTrial->dia_od) : ''; ?>
                                    </td>
                                    <td style="padding:0px;">
                                        <?php echo isset($contactLensTrial->power_od) ? htmlspecialchars($contactLensTrial->power_od) : ''; ?>
                                    </td>
                                    <td style="padding:0px;">
                                        <?php echo isset($contactLensTrial->vn_od) ? htmlspecialchars($contactLensTrial->vn_od) : ''; ?>
                                    </td>
                                    <td style="padding:0px;">
                                        <?php echo isset($contactLensTrial->remarks_od) ? htmlspecialchars($contactLensTrial->remarks_od) : ''; ?>
                                    </td>
                                    <td style="padding:0px;">
                                        <?php echo isset($contactLensTrial->rx_od) ? htmlspecialchars($contactLensTrial->rx_od) : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0px;">OD OS</td>
                                    <td style="padding:0px;">
                                        <?php echo isset($contactLensTrial->bc_os) ? htmlspecialchars($contactLensTrial->bc_os) : ''; ?>
                                    </td>
                                    <td style="padding:0px;">
                                        <?php echo isset($contactLensTrial->dia_os) ? htmlspecialchars($contactLensTrial->dia_os) : ''; ?>
                                    </td>
                                    <td style="padding:0px;">
                                        <?php echo isset($contactLensTrial->power_os) ? htmlspecialchars($contactLensTrial->power_os) : ''; ?>
                                    </td>
                                    <td style="padding:0px;">
                                        <?php echo isset($contactLensTrial->vn_os) ? htmlspecialchars($contactLensTrial->vn_os) : ''; ?>
                                    </td>
                                    <td style="padding:0px;">
                                        <?php echo isset($contactLensTrial->remarks_os) ? htmlspecialchars($contactLensTrial->remarks_os) : ''; ?>
                                    </td>
                                    <td style="padding:0px;">
                                        <?php echo isset($contactLensTrial->rx_os) ? htmlspecialchars($contactLensTrial->rx_os) : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0px;">OD OS</td>
                                    <td style="padding:0px;">
                                        <?php echo isset($contactLensTrial->bc_os2) ? htmlspecialchars($contactLensTrial->bc_os2) : ''; ?>
                                    </td>
                                    <td style="padding:0px;">
                                        <?php echo isset($contactLensTrial->dia_os2) ? htmlspecialchars($contactLensTrial->dia_os2) : ''; ?>
                                    </td>
                                    <td style="padding:0px;">
                                        <?php echo isset($contactLensTrial->power_os2) ? htmlspecialchars($contactLensTrial->power_os2) : ''; ?>
                                    </td>
                                    <td style="padding:0px;">
                                        <?php echo isset($contactLensTrial->vn_os2) ? htmlspecialchars($contactLensTrial->vn_os2) : ''; ?>
                                    </td>
                                    <td style="padding:0px;">
                                        <?php echo isset($contactLensTrial->remarks_o2) ? htmlspecialchars($contactLensTrial->remarks_o2) : ''; ?>
                                    </td>
                                    <td style="padding:0px;">
                                        <?php echo isset($contactLensTrial->rx_os2) ? htmlspecialchars($contactLensTrial->rx_os2) : ''; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>



                <div class="row" style="display: flex; align-items: center;padding-left:15px;">
                    <!-- Trial Given Label and Value Section -->
                    <div class="col-md-4">
                        <label for="trial_given">Trial Given:</label>
                    </div>
                    <div class="col-md-8">
                        <span><?php echo isset($data_list[0]->trial_given) ? htmlspecialchars($data_list[0]->trial_given) : ''; ?></span>
                    </div>
                </div>





                <div class="row" style="padding-left: 3px;">
                    <!-- Label Section (Name First) -->
                    <div class="col-md-12" style="text-align: left;">
                        <label><strong>Final Order:</strong></label>
                    </div>
                </div>

                <div class="row">
                    <!-- Table Section -->
                    <div class="col-md-12">
                        <table class="table table-bordered"
                            style="font-size: 12px; border-collapse: collapse; width: 100%;">
                            <thead>
                                <tr>
                                    <th style="padding: 0px;"></th>
                                    <th style="padding: 0px;">B.C (MM)</th>
                                    <th style="padding: 0px;">DIA (MM)</th>
                                    <th style="padding: 0px;">Power</th>
                                    <th style="padding: 0px;">Tint</th>
                                    <th style="padding: 0px;">Material</th>
                                    <th style="padding: 0px;">Company</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Decode the final_order_table JSON string into an object
                                $finalOrderTable = json_decode($data_list[0]->final_order_table);
                                ?>
                                <tr>
                                    <td style="padding: 0px;">OD</td>
                                    <td style="padding: 0px;">
                                        <?php echo isset($finalOrderTable->bc_od) ? htmlspecialchars($finalOrderTable->bc_od) : ''; ?>
                                    </td>
                                    <td style="padding: 0px;">
                                        <?php echo isset($finalOrderTable->dia_od) ? htmlspecialchars($finalOrderTable->dia_od) : ''; ?>
                                    </td>
                                    <td style="padding: 0px;">
                                        <?php echo isset($finalOrderTable->power_od) ? htmlspecialchars($finalOrderTable->power_od) : ''; ?>
                                    </td>
                                    <td style="padding: 0px;">
                                        <?php echo isset($finalOrderTable->tint_od) ? htmlspecialchars($finalOrderTable->tint_od) : ''; ?>
                                    </td>
                                    <td style="padding: 0px;">
                                        <?php echo isset($finalOrderTable->material_od) ? htmlspecialchars($finalOrderTable->material_od) : ''; ?>
                                    </td>
                                    <td style="padding: 0px;">
                                        <?php echo isset($finalOrderTable->company_od) ? htmlspecialchars($finalOrderTable->company_od) : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0px;">OS</td>
                                    <td style="padding: 0px;">
                                        <?php echo isset($finalOrderTable->bc_os) ? htmlspecialchars($finalOrderTable->bc_os) : ''; ?>
                                    </td>
                                    <td style="padding: 0px;">
                                        <?php echo isset($finalOrderTable->dia_os) ? htmlspecialchars($finalOrderTable->dia_os) : ''; ?>
                                    </td>
                                    <td style="padding: 0px;">
                                        <?php echo isset($finalOrderTable->power_os) ? htmlspecialchars($finalOrderTable->power_os) : ''; ?>
                                    </td>
                                    <td style="padding: 0px;">
                                        <?php echo isset($finalOrderTable->tint_os) ? htmlspecialchars($finalOrderTable->tint_os) : ''; ?>
                                    </td>
                                    <td style="padding: 0px;">
                                        <?php echo isset($finalOrderTable->material_os) ? htmlspecialchars($finalOrderTable->material_os) : ''; ?>
                                    </td>
                                    <td style="padding: 0px;">
                                        <?php echo isset($finalOrderTable->company_os) ? htmlspecialchars($finalOrderTable->company_os) : ''; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="form-group col-md-12" style="padding:0px;padding-top:5px;">
                    <label for="instruction_given">Instruction Given/Lens Dispensed on:</label>
                    <span>
                        <?php
                        if (isset($data_list[0]->instruction_given_lens_dispensed_on) && !empty($data_list[0]->instruction_given_lens_dispensed_on)) {
                            // Convert the date to the desired format (dd/mm/yyyy)
                            echo date('d/m/Y', strtotime($data_list[0]->instruction_given_lens_dispensed_on));
                        } else {
                            // Show the placeholder if no date is provided
                            echo '__/__/__';
                        }
                        ?>
                    </span>
                </div>

                <div class="form-group col-md-12" style="padding:0px;padding-top:5px;">
                    <h4>Informed Consent for Contact Lens Trial</h4>
                    <p>
                        I, <strong><?php echo $booking_data['patient_name']; ?></strong>, underwent contact lens trial &
                        understood
                        the process of contact lens handling (insertion, removal & care regimen).
                        I am responsible for delivered contact lens now.
                    </p>
                </div>

                <div class="form-signatures mt-4" style="padding-top:5px;">
                    <table class="table table-borderless mb-4 w-100">
                        <tbody>
                            <tr>

                                <!-- Doctor Signature -->
                                <td class="small text-center mt-5" style="width: 33%;">
                                    <div class="text-center">
                                        <span class="font-weight-bold">Signature of Doctor:</span><br>
                                        <div class="border-top pt-2 mx-auto"
                                            style="display: inline-block; width: 200px; border-top:1px solid black; margin-top: 24px;">
                                            <span>
                                                <?php
                                                // Get the doctor signature id from data_list
                                                $doctorSignatureId = $data_list[0]->doctor_signature ?? null;
                                                // Find the doctor name based on the signature id
                                                $doctorName = 'Not Selected';
                                                if ($doctorSignatureId) {
                                                    foreach ($doctor as $doc) {
                                                        if ($doc->id == $doctorSignatureId) {
                                                            $doctorName = $doc->doctor_name;
                                                            break;
                                                        }
                                                    }
                                                }
                                                echo $doctorName;
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Optometrist Signature -->
                                <td class="small text-center mt-5" style="width: 33%;">
                                    <div class="text-center">
                                        <span class="font-weight-bold">Signature of Optometrist:</span><br>
                                        <div class="border-top pt-2 mx-auto"
                                            style="display: inline-block; width: 200px; border-top:1px solid black; margin-top: 24px;">
                                            <span>
                                                <?php
                                                // Get the optometrist signature id from data_list
                                                $optometristSignatureId = $data_list[0]->optometrist_signature ?? null;
                                                // Find the optometrist name based on the signature id
                                                $optometristName = 'Not Selected';
                                                if ($optometristSignatureId) {
                                                    foreach ($doctor as $optometrist) {
                                                        if ($optometrist->id == $optometristSignatureId) {
                                                            $optometristName = $optometrist->doctor_name;
                                                            break;
                                                        }
                                                    }
                                                }
                                                echo $optometristName;
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <td class="small text-center mt-5" style="width: 33%;">
                                    <div class="text-center">
                                        <span class="font-weight-bold">Signature of Patient:</span><br>
                                        <div class="border-top pt-2 mx-auto"
                                            style="display: inline-block; width: 200px; border-top:1px solid black; margin-top: 24px;">
                                            <span>
                                                <?php
                                                // Get the optometrist signature id from data_list
                                                $optometristSignatureId = $data_list[0]->optometrist_signature ?? null;
                                                // Find the optometrist name based on the signature id
                                                $optometristName = 'Not Selected';
                                                if ($optometristSignatureId) {
                                                    foreach ($doctor as $optometrist) {
                                                        if ($optometrist->id == $optometristSignatureId) {
                                                            $optometristName = $optometrist->doctor_name;
                                                            break;
                                                        }
                                                    }
                                                }
                                                echo $booking_data['patient_name'];
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- <div class="form-group col-md-12">
                <label for="consent_form">Consent Form:</label>
                <input type="file" class="form-control" id="consent_form" name="consent_form">
            </div> -->
            </div>



            <div class="footer"
                style="position: fixed; bottom: 0; left: 0; right: 0; background-color: #f8f9fa; text-align: center; padding: 10px; box-shadow: 0 -2px 5px rgba(0,0,0,0.1);">
                <hr />
                <p style="margin: 0;">Powered by Sara Software</p>
            </div>

        </div>
    </div>
</body>

</html>