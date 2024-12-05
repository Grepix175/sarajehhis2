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
            margin-bottom: 1rem;
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
            padding: 8px;
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
    <!-- <body onLoad="set_tpa(<?php echo $form_data['insurance_type']; ?>); set_married(<?php echo $form_data['marital_status']; ?>);">  -->

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

        <?php //echo "<pre>";print_r($form_data);die; ?>
        <div class="panel-body">
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
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <?php //echo"<pre>";print_r($data_list[0]);die; ?>
            <input type="hidden" id="id" name="id"
                value="<?php echo isset($form_data['id']) ? $form_data['id'] : ''; ?>">
            <input type="hidden" id="booking_id" name="booking_id"
                value="<?php echo isset($form_data['booking_id']) ? $form_data['booking_id'] : ''; ?>">
            <input type="hidden" id="branch_id" name="branch_id"
                value="<?php echo isset($form_data['branch_id']) ? $form_data['branch_id'] : ''; ?>">
            <input type="hidden" id="booking_code" name="booking_code"
                value="<?php echo isset($form_data['booking_code']) ? $form_data['booking_code'] : ''; ?>">
            <input type="hidden" id="pres_id" name="pres_id" value="<?php echo isset($id) ? $id : ''; ?>">
            <input type="hidden" id="patient_id" name="patient_id"
                value="<?php echo isset($form_data['patient_id']) ? $form_data['patient_id'] : ''; ?>">
            <section class="panel panel-default" style="border:none;">
                <?PHP //echo "<pre>";print_r($data);die; ?>
                <?php
                // Assuming $data_list[0]->color_vision contains JSON data
                $color_vision_data = isset($data_list[0]->color_vision) ? json_decode($data_list[0]->color_vision, true) : [];

                // Extract values from the decoded data
                $low_vision_col_vis_l = isset($color_vision_data['low_vision_col_vis_l']) ? $color_vision_data['low_vision_col_vis_l'] : '';
                $low_vision_col_vis_r = isset($color_vision_data['low_vision_col_vis_r']) ? $color_vision_data['low_vision_col_vis_r'] : '';
                ?>
                <div class="panel-body" style="padding:0;border:0;">
                    <table class="table table-borderless" style="margin-bottom:0;">
                        <tr>
                            <td style="width: 26%;">
                                <div class="text-center">
                                    <div class="label_name">COLOR VISION
                                        <i onclick="low_vision_col_vis_ltr();" title="Copy Left to Right"
                                            class="fa fa-arrow-right"></i>
                                    </div>
                                </div>
                            </td>
                            <td style="width: 20%;">
                                <input type="text" name="low_vision_col_vis_l" id="low_vision_col_vis_l"
                                    class="form-control" value="<?php echo htmlspecialchars($low_vision_col_vis_l); ?>"
                                    readonly />
                            </td>
                            <td style="width: 25%;">
                                <div class="text-center">
                                    <div class="label_name">COLOR VISION
                                        <i onclick="low_vision_col_vis_rtl();" title="Copy Right to Left"
                                            class="fa fa-arrow-left pointer"></i>
                                    </div>
                                </div>
                            </td>
                            <td style="width: 20%;">
                                <input type="text" name="low_vision_col_vis_r" id="low_vision_col_vis_r"
                                    class="form-control" value="<?php echo htmlspecialchars($low_vision_col_vis_r); ?>"
                                    readonly />
                            </td>
                        </tr>
                    </table>
                </div>




            </section>


            <?php
            // Assuming $data_list[0]->contrast_sensitivity contains JSON data
            $contrast_sensitivity_data = isset($data_list[0]->contrast_sensivity) ? json_decode($data_list[0]->contrast_sensivity, true) : [];

            // Extract values from the decoded data
            $low_vision_contra_sens_l = isset($contrast_sensitivity_data['low_vision_contra_sens_l']) ? $contrast_sensitivity_data['low_vision_contra_sens_l'] : '';
            $low_vision_contra_sens_r = isset($contrast_sensitivity_data['low_vision_contra_sens_r']) ? $contrast_sensitivity_data['low_vision_contra_sens_r'] : '';
            ?>

            <section class="panel panel-default" style="border:none;">
                <div class="panel-body" style="padding: 0; border: 0;">
                    <table class="table table-borderless" style="margin-bottom: 0;">
                        <tr>
                            <td colspan="4" class="text-right btn_edit" style="display: none;">
                                <a href="javascript:void(0)" class="btn_fill" onclick="$('.con_sen').toggle();">Edit</a>
                                <hr>
                            </td>
                        </tr>
                        <?php
                        // Array of contrast sensitivity values
                        $contrast_values = [
                            '2.25',
                            '2.10',
                            '1.95',
                            '1.80',
                            '1.65',
                            '1.50',
                            '1.35',
                            '1.20',
                            '1.05',
                            '0.90',
                            '0.75',
                            '0.60',
                            '0.45',
                            '0.30',
                            '0.15',
                            '0.00'
                        ];
                        ?>

                        <!-- Left Side Contrast Sensitivity -->
                        <tr>
                            <td style="width: 26%;">
                                <div class="text-center">
                                    <div class="label_name">LEFT CONTRAST SENSITIVITY
                                        <i onclick="low_vision_contra_sens_ltr();" title="Copy Left to Right"
                                            class="fa fa-arrow-right"></i>
                                    </div>
                                </div>
                            </td>
                            <td style="width: 20%;">
                                <input type="text" name="low_vision_contra_sens_l" id="low_vision_contra_sens_l"
                                    class="form-control" value="<?= htmlspecialchars($low_vision_contra_sens_l); ?>"
                                    readonly />
                            </td>

                            <!-- Right Side Contrast Sensitivity -->
                            <td style="width: 25%;">
                                <div class="text-center">
                                    <div class="label_name">RIGHT CONTRAST SENSITIVITY
                                        <i onclick="low_vision_contra_sens_rtl();" title="Copy Right to Left"
                                            class="fa fa-arrow-left"></i>
                                    </div>
                                </div>
                            </td>
                            <td style="width: 20%;">
                                <input type="text" name="low_vision_contra_sens_r" id="low_vision_contra_sens_r"
                                    class="form-control" value="<?= htmlspecialchars($low_vision_contra_sens_r); ?>"
                                    readonly />
                            </td>
                        </tr>
                    </table>
                </div>

            </section>

            <div class="grp-full">
                <!-- Patient Name -->
                <!-- <div class="grp" style="width: 100%;">
                <div class="box-right">
                    <span>
                        <strong>
                            Patient Name: 
                        </strong>
                        <?php echo isset($data_list[0]->patient_name) ? htmlspecialchars($data_list[0]->patient_name) : ''; ?>
                    </span>
                    
                </div>
            </div> -->

                <!-- AMSLER GRID -->
                <div class="grp" style="width: 100%;">
                    <div class="box-right">
                        <span>
                            <strong>
                                AMSLER GRID:
                            </strong>
                            <?php echo isset($data_list[0]->amsler_grid) ? htmlspecialchars($data_list[0]->amsler_grid) : ''; ?>
                        </span>
                    </div>
                </div>

                <!-- LVA TRIAL -->
                <div class="grp" style="width: 100%;">
                    <div class="box-right">
                        <span>
                            <strong>
                                LVA TRIAL:
                            </strong>
                            <?php echo isset($data_list[0]->lva_trial) ? htmlspecialchars($data_list[0]->lva_trial) : ''; ?>
                        </span>
                    </div>
                </div>

                <!-- DISTANCE LVA -->
                <div class="grp" style="width: 100%;">
                    <div class="box-right">
                        <span>
                            <strong>
                                DISTANCE LVA:
                            </strong>
                            <?php echo isset($data_list[0]->distance_lva) ? htmlspecialchars($data_list[0]->distance_lva) : ''; ?>
                        </span>
                    </div>
                </div>

                <!-- NEAR LVA -->
                <div class="grp" style="width: 100%;">
                    <div class="box-right">
                        <span>
                            <strong>
                                NEAR LVA:
                            </strong>
                            <?php echo isset($data_list[0]->near_lva) ? htmlspecialchars($data_list[0]->near_lva) : ''; ?>
                        </span>

                    </div>
                </div>

                <!-- NON OPTICAL DEVICE -->
                <div class="grp" style="width: 100%;">
                    <div class="box-right">
                        <span>
                            <strong>
                                NON OPTICAL DEVICE:
                            </strong>
                            <?php echo isset($data_list[0]->non_optical_device) ? htmlspecialchars($data_list[0]->non_optical_device) : ''; ?>
                        </span>

                    </div>
                </div>

                <!-- FINAL ADVICE -->
                <div class="grp" style="width: 100%;">
                    <div class="box-right">
                        <span>
                            <strong>
                                FINAL ADVICE:
                            </strong>
                            <?php echo isset($data_list[0]->final_advice) ? htmlspecialchars($data_list[0]->final_advice) : ''; ?>
                        </span>

                    </div>
                </div>

                <!-- REFERRED FOR (IF NEEDED) -->
                <div class="grp" style="width: 100%;">
                    <div class="box-right">
                        <span>
                            <strong>
                                REFERRED FOR:
                            </strong>
                            <?php echo isset($data_list[0]->referred_for) ? htmlspecialchars($data_list[0]->referred_for) : ''; ?>
                        </span>

                    </div>
                </div>

                <!-- FOLLOW UP / COMPLIANCE -->
                <div class="grp" style="width: 100%;">
                    <div class="box-right">
                        <span>
                            <strong>
                                FOLLOW UP:
                            </strong>
                            <?php echo isset($data_list[0]->follow_up) ? htmlspecialchars($data_list[0]->follow_up) : ''; ?>
                        </span>

                    </div>
                </div>
            </div>

            <div class="form-signatures mt-4">
                <table class="table table-borderless mb-4 w-100">
                    <tbody>
                        <tr>
                            <!-- Optometrist Signature -->
                            <td class="small text-center mt-5" style="width: 50%;">
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

                            <!-- Doctor Signature -->
                            <td class="small text-center mt-5" style="width: 50%;">
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
                        </tr>
                    </tbody>
                </table>
            </div>



            <!-- <div class="footer" style="position: fixed; bottom: 0; left: 0; right: 0; background-color: #f8f9fa; text-align: center; padding: 10px; box-shadow: 0 -2px 5px rgba(0,0,0,0.1);">
        <hr />
        <p style="margin: 0;">Powered by Sara Software</p> -->
            <!-- </div> -->

        </div>
    </div>

</body>



</html>