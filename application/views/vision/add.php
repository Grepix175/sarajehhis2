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
            border-top: 1px solid #000;
            /* Adjust border color */
        }

        .row.mb-4 {
            margin-bottom: 0px;
            /* Space between the row and the next element */
        }
    </style>
   
    <!-- <body onLoad="set_tpa(<?php echo $form_data['insurance_type']; ?>); set_married(<?php echo $form_data['marital_status']; ?>);">  -->

<body>
    <div id="flash_msg" class="booked_session_flash" style="display: none;">
        <i class="fa fa-check-circle"></i>
        <span id="flash_msg_text"></span>
    </div>
    <div class="container-fluid">
        <?php
        $this->load->view('include/header');
        $this->load->view('include/inner_header');
        ?>
        <section class="content">
            <form id="vision_modal_form" method="post" action="<?php echo current_url(); ?>"
                enctype="multipart/form-data"> <!-- Use method="post" -->
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
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-xs-5">
                        <div class="row m-b-5">
                            <div class="col-xs-4"><strong>Patient</strong></div>
                            <div class="col-xs-8">
                                <input type="text" name="patient_name"
                                    value="<?php echo isset($booking_data['patient_name']) ? $booking_data['patient_name'] : 'N/A'; ?>"
                                    readonly=""
                                    style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                            </div>
                        </div>
                        <div class="row m-b-5">
                            <div class="col-xs-4"><strong>Patient Reg. No</strong></div>
                            <div class="col-xs-8">
                                <input type="text" name="patient_code"
                                    value="<?php echo isset($booking_data['patient_code']) ? $booking_data['patient_code'] : 'N/A'; ?>"
                                    readonly=""
                                    style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                            </div>
                        </div>
                        <div class="row m-b-5">
                            <div class="col-xs-4"><strong>OPD No</strong></div>
                            <div class="col-xs-8">
                                <input type="text" name="booking_code"
                                    value="<?php echo isset($booking_data['booking_code']) ? $booking_data['booking_code'] : 'N/A'; ?>"
                                    readonly=""
                                    style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                            </div>

                        </div>
                        <div class="row m-b-5">
                            <div class="col-xs-4"><strong>Token No</strong></div>
                            <div class="col-xs-8">
                                <input type="text" name="token_no"
                                    value="<?php echo isset($booking_data['token_no']) ? $booking_data['token_no'] : 'N/A'; ?>"
                                    readonly=""
                                    style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-5">
                        <div class="row m-b-5">
                            <div class="col-xs-4"><strong>Mobile no.</strong></div>
                            <div class="col-xs-8">
                                <input type="text" name="mobile_no"
                                    value="<?php echo isset($booking_data['mobile_no']) ? $booking_data['mobile_no'] : 'N/A'; ?>"
                                    readonly=""
                                    style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                            </div>
                        </div>
                        <div class="row m-b-5">
                            <div class="col-xs-4"><strong>Age</strong></div>
                            <div class="col-xs-8">
                                <input type="text" name="mobile_no" value="<?php echo isset($age) ? $age : 'N/A'; ?>"
                                    readonly=""
                                    style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                            </div>
                        </div>
                        <div class="row m-b-5">
                            <div class="col-xs-4"><strong>Gender</strong></div>
                            <div class="col-xs-8">
                                <input type="text" name="gender"
                                    value="<?php echo ($booking_data['gender'] == '0') ? 'Female' : 'Male'; ?>"
                                    readonly=""
                                    style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="data_id" id="data_id"
                    value="<?php echo isset($form_data['data_id']) ? $form_data['data_id'] : ''; ?>">
                <input type="hidden" name="patient_id" id="patient_id"
                    value="<?php echo isset($form_data['patient_id']) ? $form_data['patient_id'] : ''; ?>">
                <input type="hidden" name="booking_id" id="booking_id"
                    value="<?php echo isset($form_data['booking_id']) ? $form_data['booking_id'] : ''; ?>">
                <div class="content-inner">
                    <div class="pat-col">
                        <?php $data = get_setting_value('PATIENT_REG_NO');
                        if (!empty($data) && isset($data)) {
                            ?>
                            <!-- <div class="grp">
                                <label><?php echo "Reg No : " ?></label>
                                <div class="box-right"><?php echo $form_data['patient_code']; ?></div>
                                <input type="hidden" name="patient_code" id="patient_code"
                                    value="<?php echo $form_data['patient_code']; ?>" />
                            </div> -->
                        <?php } ?>
                        <!-- <div class="grp-full">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label for="patient_name" class="font-weight-bold mb-0">Name of the patient: <span
                                            class="star">*</span></label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    // Display the patient name if available, otherwise show the default $patient_name
                                    $patient_name_to_display = isset($form_data['patient_name']) ? $form_data['patient_name'] : $patient_name;
                                    //echo htmlspecialchars($patient_name_to_display); // Safely display the name
                                    ?>

                                    <input type="text" name="patient_name" class="form-control input-height"
                                        id="patient_name" placeholder="Enter patient's name" maxlength="255"
                                        value="<?php echo $patient_name_to_display; ?>" required>

                                    <?php if (!empty($form_error))
                                        echo form_error('patient_name'); ?>
                                </div>

                            </div>
                        </div> -->

                        <div class="grp-full">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label for="procedure_purpose" class="font-weight-bold mb-0">Purpose of the
                                        Procedure: <span class="star">*</span></label>
                                </div>
                                <div class="col-md-6">
                                    <textarea id="procedure_purpose" name="procedure_purpose"
                                        class="form-control input-height" rows="3"
                                        placeholder="Enter the purpose of the procedure here"
                                        required><?php echo isset($form_data['procedure_purpose']) ? htmlspecialchars($form_data['procedure_purpose']) : ''; ?></textarea>
                                    <?php if (!empty($form_error))
                                        echo form_error('procedure_purpose'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="grp-full">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label for="sideEffects" class="font-weight-bold mb-0">Side Effects <span
                                            class="star">*</span></label>
                                </div>

                                <div class="col-md-6">
                                    <!-- <select name="side_effects" id="side_effects" class="m_input_default select-height">
                                        <option value="" <?php echo empty($form_data['side_effects']) ? 'selected' : ''; ?>>Select a side effect</option>
                                        <?php if (!empty($side_effects)): ?>
                                            <?php foreach ($side_effects as $side_effect): ?>
                                                <option value="<?php echo $side_effect->id; ?>" <?php echo (isset($form_data['side_effects']) && $form_data['side_effects'] == $side_effect->id) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($side_effect->side_effect_name); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option disabled>No side effects found.</option>
                                        <?php endif; ?>
                                    </select> -->
                                    <select name="side_effects" id="side_effects" class="m_input_default">
                                        <option value="">Select Side Effects</option>
                                        <?php

                                        if (!empty($side_effects)) {
                                            foreach ($side_effects as $side_effect) {
                                                $selected_side_effect = "";
                                                if ($side_effect->id == $form_data['side_effects']) {
                                                    $selected_side_effect = 'selected="selected"';
                                                }
                                                echo '<option value="' . $side_effect->id . '" ' . $selected_side_effect . '>' . htmlspecialchars($side_effect->side_effect_name) . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php if (!empty($form_error))
                                        echo form_error('side_effects'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="grp-full" style="width: 155%; display: flex; justify-content: left;">
                            <div class="align-items-center" style="width: 147%;">
                                <p class="mt-3" style="text-align: justify; line-height: 1.6;">
                                    I have been informed about the procedure, benefits, and risks, and hereby consent to
                                    proceed with the investigation.
                                </p>
                            </div>
                        </div>

                        <div class="grp-full" style="width: 148% !important;">
                            <div class="row mb-4" style="justify-content: space-between;">
                                <div class="col-md-6" style="text-align: left;">
                                    <p class="font-weight-bold">Signature / LTI of patient</p>
                                    <div class="border-top pt-2"
                                        style="display: inline-block; width: 200px; margin-bottom: 0px;">
                                        <!-- <span><?php echo isset($form_data['optometrist_signature']) ? htmlspecialchars($form_data['optometrist_signature']) : ''; ?></span> -->
                                    </div>
                                </div>
                                <div class="col-md-6" style="text-align: right;">
                                    <p class="font-weight-bold">Signature / LTI of relative</p>
                                    <div class="border-top pt-2"
                                        style="display: inline-block; width: 200px; margin-bottom: 0px;">
                                        <!-- <span><?php echo isset($form_data['anaesthetist_signature']) ? htmlspecialchars($form_data['anaesthetist_signature']) : ''; ?></span> -->
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="grp-full" style="width: 156% !important;">
                            <h2 class="text-center"></h2>
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th>Check List Prior to FFA - for the evaluating Doctor and Assistant</th>
                                        <td>
                                            <!-- <div class="grp">
                                        <label><input type="radio" name="informed_consent" value="yes" <?php echo (isset($form_data['informed_consent']) && $form_data['informed_consent'] == 'yes') ? 'checked' : ''; ?> required> Yes</label>
                                        <label><input type="radio" name="informed_consent" value="no" <?php echo (isset($form_data['informed_consent']) && $form_data['informed_consent'] == 'no') ? 'checked' : ''; ?> required> No</label>
                                    </div> -->
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $questions = [
                                        'Informed Consent' => 'informed_consent',
                                        'Previous FFA' => 'previous_ffa',
                                        'History of Allergy' => 'history_allergy',
                                        'History of Asthma' => 'history_asthma',
                                        'History of Epilepsy (Flash photography)' => 'history_epilepsy',
                                        'Accompanied by Attendant' => 'accompanied_attendant',
                                        'S Creatinine' => 's_creatinine',
                                        'Blood Sugar' => 'blood_sugar',
                                        'Blood Pressure' => 'blood_pressure'
                                    ];

                                    foreach ($questions as $question => $name): ?>
                                        <tr>
                                            <th><?php echo $question; ?></th>
                                            <td>
                                                <div class="grp">
                                                    <label>
                                                        <input type="radio" name="<?php echo $name; ?>" value="yes" <?php echo (isset($form_data[$name]) && $form_data[$name] == 'yes') ? 'checked' : ''; ?>> Yes
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="<?php echo $name; ?>" value="no" <?php echo (isset($form_data[$name]) && $form_data[$name] == 'no') ? 'checked' : ''; ?>> No
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>

                            <div class="grp-full" style="width: 66%;">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <label>FFA not done due to:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <textarea rows="2" class="form-control input-height" name="reason_ffa_not_done"
                                            placeholder="Enter the reason FFA was not done"><?php echo isset($form_data['reason_ffa_not_done']) ? htmlspecialchars($form_data['reason_ffa_not_done']) : ''; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grp-full mt-5" style="width: 150%; margin-to:20px;">
                            <div class="row mb-4">
                                <div class="col-md-4 text-center">
                                    <p class="font-weight-bold">Optometrist's Signature</p>
                                    <!-- <div class="border-top pt-2" style="width: 200px; margin: 0 auto;">
                                    </div> -->
                                   
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
                                    <!-- <p class="mt-2" style="margin-top: 25px;">Date: <span
                                            style="border-bottom: 1px solid #000; width: 130px; display: inline-block;">
                                            <input type="text" name="optometrist_date"
                                                class="validity_date m_input_default"
                                                value="<?php echo $form_data['optometrist_date']; ?>" id="validity_date"
                                                readonly="true" style="width: 130px !important;" />
                                        </span>

                                    </p> -->
                                    <p class="mt-2" style="margin-top: 25px;">Date: 
                                        <span style="border-bottom: 1px solid #000; width: 130px; display: inline-block;">
                                            <input type="text" name="optometrist_date" class="validity_date m_input_default"
                                                value="<?php echo !empty($form_data['optometrist_date']) ? date('d-m-Y', strtotime($form_data['optometrist_date'])) : date('d-m-Y'); ?>" 
                                                id="validity_date_optometrist"
                                                readonly="true" style="width: 130px !important;" />
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <p class="font-weight-bold">Anaesthetist's Signature</p>
                                    <div class="border-top pt-2 mx-auto" style="display: inline-block; width: 200px; border-top:1px solid black; margin-top: 24px;">
                                        <select name="anaesthetist_signature" class="form-control mx-auto" style="width: 200px;">
                                            <option value="">Select Doctor</option>
                                            <?php foreach ($doctor as $anaesthetist) : ?>
                                                <option value="<?= $anaesthetist->id; ?>" 
                                                    <?= isset($form_data['anaesthetist_signature']) && $form_data['anaesthetist_signature'] == $anaesthetist->id ? 'selected' : ''; ?>>
                                                    <?= $anaesthetist->doctor_name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span></span>
                                    </div>
                                    <!-- <p class="mt-2" style="margin-top: 25px;">Date: <span
                                            style="border-bottom: 1px solid #000; width: 130px; display: inline-block;">
                                            <input type="text" name="anaesthetist_date"
                                                class="validity_date m_input_default"
                                                value="<?php echo $form_data['anaesthetist_date']; ?>"
                                                id="validity_date" readonly="true" style="width: 130px !important;" />
                                        </span>

                                    </p> -->
                                    <p class="mt-2" style="margin-top: 25px;">Date: 
                                        <span style="border-bottom: 1px solid #000; width: 130px; display: inline-block;">
                                            <input type="text" name="anaesthetist_date" class="validity_date m_input_default"
                                                value="<?php echo !empty($form_data['anaesthetist_date']) ? date('d-m-Y', strtotime($form_data['anaesthetist_date'])) : date('d-m-Y'); ?>" 
                                                id="validity_date_anaesthetist"
                                                readonly="true" style="width: 130px !important;" />
                                        </span>
                                    </p>

                                    
                                </div>
                                <div class="col-md-4 text-center">
                                    <p class="font-weight-bold">Doctor's Signature</p>
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
                                    <!-- <div class="border-top pt-2" style="width: 200px; margin: 0 auto;">
                                    </div> -->
                                    <p class="mt-2" style="margin-top: 25px;">Date: 
                                        <span style="border-bottom: 1px solid #000; width: 130px; display: inline-block;">
                                            <input type="text" name="doctor_date" class="validity_date m_input_default"
                                                value="<?php echo !empty($form_data['doctor_date']) ? date('d-m-Y', strtotime($form_data['doctor_date'])) : date('d-m-Y'); ?>" 
                                                id="validity_date_doctor"
                                                readonly="true" style="width: 130px !important;" />
                                        </span>
                                    </p>
                                    
                                </div>
                            </div>
                        </div>


                        <!-- <div class="modal-footer"> -->
                        <div class="grp">
                            <label></label>
                            <div class="box-right">
                                <button class="btn-update" id="form_submit">
                                    <i class="fa fa-save"></i> Save</button>
                                <a href="<?php echo base_url('vision'); ?>" class="btn-update"
                                    style="text-decoration:none!important;color:#FFF;padding:8px 2em;"><i
                                        class="fa fa-sign-out"></i>
                                    Exit</a>
                            </div>
                        </div>

                    </div>


                </div>

    </div>
    </form>
    </section>
    <?php
    $this->load->view('include/footer');
    ?>


    </div>

</body>

<script>
     $('.validity_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        startDate: new Date(),
    });
    document.getElementById('vision_modal_form').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = new FormData(this); // Gather form data
        // formData.forEach(function (value, key) {
        //     console.log(key + ': ' + value);
        // });

        // return;
        fetch('<?php echo base_url('vision/add'); ?>', { // Update with the correct URL
            method: 'POST',
            body: formData,
        })
            .then(response => {
                // Check if the response is okay (status 200-299)
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Parse the JSON response
            })
            .then(data => {
                // console.log(data)
                // return;
                // Handle success or error response
                if (data.success) {
                    // alert('Form submitted successfully!');
                    // Redirect to the vision list page
                    // flash_session_msg(data.message);
                    window.location.href = '<?php echo base_url('vision'); ?>'; // Adjust this URL as necessary
                }else if (data.faield) {
                    showAlert(
                        data.message,
                        "#ffc107", // Yellow color for a warning
                        "<?php echo base_url('vision'); ?>" // URL for redirection
                    );
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // alert('There was a problem with the submission.');
            });
    });
    function showAlert(message, color, redirectUrl) {
        // Create the alert box
        const alertBox = document.createElement("div");
        alertBox.style.position = "fixed";
        alertBox.style.top = "20px";
        alertBox.style.right = "20px";
        alertBox.style.padding = "15px";
        alertBox.style.borderRadius = "5px";
        alertBox.style.backgroundColor = color;
        alertBox.style.color = "white";
        alertBox.style.fontSize = "16px";
        alertBox.style.zIndex = "1000";
        alertBox.style.boxShadow = "0 2px 10px rgba(0, 0, 0, 0.1)";
        alertBox.innerHTML = `
        <p>${message}</p>
        <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
            <button id="yesButton" style="margin-right: 10px; padding: 5px 10px; border: none; border-radius: 3px; background-color: #28a745; color: white; cursor: pointer;">Yes</button>
        </div>
    `;

        // Append the alert box to the body
        document.body.appendChild(alertBox);

        // Add event listeners for buttons
        const yesButton = document.getElementById("yesButton");
        // const noButton = document.getElementById("noButton");

        yesButton.addEventListener("click", () => {
            window.location.href = redirectUrl;
        });
    }
    function flash_session_msg(val) {
        $('#flash_msg_text').html(val);
        $('#flash_session').slideDown('slow').delay(1500).slideUp('slow');
    }
    // $('.validity_date').datepicker({
    //     format: 'dd-mm-yyyy',
    //     autoclose: true,
    //     startDate: new Date(),
    // });
</script>





<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $("#side_effects").select2();
    $("#side_effects").select2({
        width: '435px' // Set your desired width
    });

   

</script>
</body>

</html>