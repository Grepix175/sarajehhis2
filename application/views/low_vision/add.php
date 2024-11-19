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
            padding-left: 3px;
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
        

    <form id="low_vision_form" method="post" action="<?php echo current_url(); ?>">

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
                        <input type="text" name="patient_name" value="<?php echo isset($booking_data['patient_name']) ? $booking_data['patient_name'] : 'N/A'; ?>" readonly="" style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                    </div>
                </div>
                <div class="row m-b-5">
                    <div class="col-xs-4"><strong>Patient Reg. No</strong></div>
                    <div class="col-xs-8">
                        <input type="text" name="patient_code" value="<?php echo isset($booking_data['patient_code']) ? $booking_data['patient_code'] : 'N/A'; ?>" readonly="" style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                    </div>
                </div>
                <div class="row m-b-5">
                    <div class="col-xs-4"><strong>OPD No</strong></div>
                    <div class="col-xs-8">
                        <input type="text" name="booking_code" value="<?php echo isset($booking_data['booking_code']) ? $booking_data['booking_code'] : 'N/A'; ?>" readonly="" style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                    </div>
                    
                </div>
                <div class="row m-b-5">
                        <div class="col-xs-4"><strong>Token No</strong></div>
                        <div class="col-xs-8">
                            <input type="text" name="token_no" value="<?php echo isset($booking_data['token_no']) ? $booking_data['token_no'] : 'N/A'; ?>" readonly="" style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                        </div>
                    </div>
            </div>
            <div class="col-xs-5">
                <div class="row m-b-5">
                    <div class="col-xs-4"><strong>Mobile no.</strong></div>
                    <div class="col-xs-8">
                        <input type="text" name="mobile_no" value="<?php echo isset($booking_data['mobile_no']) ? $booking_data['mobile_no'] : 'N/A'; ?>" readonly="" style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
                    </div>
                </div>
                <div class="row m-b-5">
                    <div class="col-xs-4"><strong>Age</strong></div>
                    <div class="col-xs-8">
                        <input type="text" name="mobile_no" value="<?php echo isset($age) ? $age : 'N/A'; ?>" readonly="" style="width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;">
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
        <?php //echo"<pre>";print_r($form_data);die; ?>
        <input type="hidden" id="id" name="id" value="<?php echo isset($form_data['id']) ? $form_data['id'] : ''; ?>">
        <input type="hidden" id="booking_id" name="booking_id" value="<?php echo isset($form_data['booking_id']) ? $form_data['booking_id'] : ''; ?>">
        <input type="hidden" id="branch_id" name="branch_id" value="<?php echo isset($form_data['branch_id']) ? $form_data['branch_id'] : ''; ?>">
        <!-- <input type="hidden" id="booking_code" name="booking_code" value="<?php echo isset($form_data['booking_code']) ? $form_data['booking_code'] : ''; ?>"> -->
        <input type="hidden" id="pres_id" name="pres_id" value="<?php echo isset($id) ? $id : ''; ?>">
        <input type="hidden" id="patient_id" name="patient_id" value="<?php echo isset($form_data['patient_id']) ? $form_data['patient_id'] : ''; ?>">
        <input type="hidden" id="editable" name="editable" value="<?php echo isset($form_data['editable']) ? $form_data['editable'] : ''; ?>">
        <section class="panel panel-default">
            <?PHP //echo "<pre>";print_r($data);die; ?>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="label_name">COLOR VISION <i onclick="low_vision_col_vis_ltr();" title="Copy Left to Right" class="fa fa-arrow-right"></i></div>
                    </div>
                    <div class="col-md-4">							
                        <textarea name="low_vision_col_vis_l" id="low_vision_col_vis_l" style="height: 60px" class="form-control"><?php echo isset($form_data['low_vision_col_vis_l']) ? htmlspecialchars($form_data['low_vision_col_vis_l']) : ''; ?></textarea>						
                    </div>
                    <div class="col-md-2">
                        <div class="label_name">COLOR VISION <i onclick="low_vision_col_vis_rtl();" title="Copy Right to Left" class="fa fa-arrow-left pointer"></i></div>
                    </div>
                    <div class="col-md-4">							
                        <textarea name="low_vision_col_vis_r" id="low_vision_col_vis_r" style="height: 60px" class="form-control"><?php echo isset($form_data['low_vision_col_vis_r']) ? htmlspecialchars($form_data['low_vision_col_vis_r']) : ''; ?></textarea>
                    </div>	
                </div>
            </div>
        </section>


        <section class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 text-right btn_edit" style="display: none;">
                        <a href="javascript:void(0)" class="btn_fill" onclick="$('.con_sen').toggle();">Edit</a>
                        <hr>
                    </div>
                    <?php
                        // Array of contrast sensitivity values
                        $contrast_values = [
                            '2.25', '2.10', '1.95', '1.80', '1.65', '1.50', 
                            '1.35', '1.20', '1.05', '0.90', '0.75', '0.60', 
                            '0.45', '0.30', '0.15', '0.00'
                        ];
                        ?>

                        <div class="col-md-2">
                            <div class="label_name">CONTRAST SENSITIVITY 
                                <i onclick="low_vision_contra_sens_ltr()" title="Copy Left to Right" class="fa fa-arrow-right"></i>
                            </div>
                            <small class="mini_outline_btn d-none cons_clr_l" 
                                onclick="$('.low_vision_contra_sens_l').prop('checked', false); 
                                        $('.low_vision_contra_sens_l').parent().removeClass('active'); $(this).hide();">
                                clear
                            </small>
                        </div>

                        <div class="col-md-4">
                            <div class="btn-group">
                                <!-- Hidden input to retain previous value if no new value is selected -->
                                <input type="hidden" name="low_vision_contra_sens_l" value="<?= $form_data['low_vision_contra_sens_l'] ?>">
                                
                                <?php foreach ($contrast_values as $value): ?>
                                    <label class="btn_radio_small d-none con_sen <?= $form_data['low_vision_contra_sens_l'] == $value ? 'active' : '' ?>" style="display: inline-block;">
                                        <input type="radio" name="low_vision_contra_sens_l" class="low_vision_contra_sens_l" value="<?= $value ?>" <?= $form_data['low_vision_contra_sens_l'] == $value ? 'checked' : '' ?>> <?= $value ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>


                        <div class="col-md-2">
                            <div class="label_name">CONTRAST SENSITIVITY 
                                <i onclick="low_vision_contra_sens_rtl();" title="Copy Right to Left" class="fa fa-arrow-left"></i>
                            </div>
                            <small class="mini_outline_btn d-none cons_clr_r" 
                                onclick="$('.low_vision_contra_sens_r').prop('checked', false); 
                                        $('.low_vision_contra_sens_r').parent().removeClass('active'); $(this).hide();">
                                clear
                            </small>
                        </div>

                        <div class="col-md-4">
                            <div class="btn-group">
                                <!-- Hidden input to retain previous value if no new value is selected -->
                                <input type="hidden" name="low_vision_contra_sens_r" value="<?= $form_data['low_vision_contra_sens_r'] ?>">
                                
                                <?php foreach ($contrast_values as $value): ?>
                                    <label class="btn_radio_small d-none con_sen <?= $form_data['low_vision_contra_sens_r'] == $value ? 'active' : '' ?>" style="display: inline-block;">
                                        <input type="radio" name="low_vision_contra_sens_r" class="low_vision_contra_sens_r" value="<?= $value ?>" <?= $form_data['low_vision_contra_sens_r'] == $value ? 'checked' : '' ?>> <?= $value ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>


                </div>
            </div>
        </section>


        <div class="grp-full">
            <!-- Patient Name -->
            <!-- <div class="grp" style="width: 115%;">
                <label>Patient Name  </label>
                <div class="box-right" style="padding-left: 2.5rem;">
                    <input type="text" name="patient_name" class="alpha_space_name txt_firstCap input-height"
                        id="patient_name" value="<?php echo isset($booking_data['patient_name']) ? htmlspecialchars($booking_data['patient_name']) : ''; ?>" autofocus
                        style="width: 374px;"  readonly/>
                    <?php
                    if (!empty($form_error)):
                        echo form_error('patient_name');
                        echo form_error('simulation_id');
                    endif;
                    ?>
                </div>
            </div> -->

            <!-- AMSLER GRID -->
            <div class="grp" style="width: 115%;">
                <label>AMSLER GRID  </label>
                <div class="box-right" style="padding-left: 2.5rem;">
                    <input type="text" name="amsler_grid" class="txt_firstCap input-height"
                        id="amsler_grid" value="<?php echo isset($form_data['amsler_grid']) ? htmlspecialchars($form_data['amsler_grid']) : ''; ?>" style="width: 374px;" />
                    <?php echo form_error('amsler_grid'); ?>
                </div>
            </div>

            <!-- LVA TRIAL -->
            <div class="grp" style="width: 115%;">
                <label>LVA TRIAL  </label>
                <div class="box-right" style="padding-left: 2.5rem;">
                    <input type="text" name="lva_trial" class="txt_firstCap input-height"
                        id="lva_trial" value="<?php echo isset($form_data['lva_trial']) ? htmlspecialchars($form_data['lva_trial']) : ''; ?>" style="width: 374px;" />
                    <?php echo form_error('lva_trial'); ?>
                </div>
            </div>

            <!-- DISTANCE LVA -->
            <div class="grp" style="width: 115%;">
                <label>DISTANCE LVA  </label>
                <div class="box-right" style="padding-left: 2.5rem;">
                    <input type="text" name="distance_lva" class="txt_firstCap input-height"
                        id="distance_lva" value="<?php echo isset($form_data['distance_lva']) ? htmlspecialchars($form_data['distance_lva']) : ''; ?>" style="width: 374px;" />
                    <?php echo form_error('distance_lva'); ?>
                </div>
            </div>

            <!-- NEAR LVA -->
            <div class="grp" style="width: 115%;">
                <label>NEAR LVA  </label>
                <div class="box-right" style="padding-left: 2.5rem;">
                    <input type="text" name="near_lva" class="txt_firstCap input-height"
                        id="near_lva" value="<?php echo isset($form_data['near_lva']) ? htmlspecialchars($form_data['near_lva']) : ''; ?>" style="width: 374px;" />
                    <?php echo form_error('near_lva'); ?>
                </div>
            </div>

            <!-- NON OPTICAL DEVICE -->
            <div class="grp" style="width: 115%;">
                <label>NON OPTICAL DEVICE  </label>
                <div class="box-right" style="padding-left: 2.5rem;">
                    <input type="text" name="non_optical_device" class="txt_firstCap input-height"
                        id="non_optical_device" value="<?php echo isset($form_data['non_optical_device']) ? htmlspecialchars($form_data['non_optical_device']) : ''; ?>" style="width: 374px;" />
                    <?php echo form_error('non_optical_device'); ?>
                </div>
            </div>

            <!-- FINAL ADVICE -->
            <div class="grp" style="width: 115%;">
                <label>FINAL ADVICE  </label>
                <div class="box-right" style="padding-left: 2.5rem;">
                    <input type="text" name="final_advice" class="txt_firstCap input-height"
                        id="final_advice" value="<?php echo isset($form_data['final_advice']) ? htmlspecialchars($form_data['final_advice']) : ''; ?>" style="width: 374px;" />
                    <?php echo form_error('final_advice'); ?>
                </div>
            </div>

            <!-- REFERRED FOR(IF NEEDED) -->
            <div class="grp" style="width: 115%;">
                <label>REFERRED FOR(IF NEEDED)  </label>
                <div class="box-right" style="padding-left: 2.5rem;">
                    <input type="text" name="referred_for" class="txt_firstCap input-height"
                        id="referred_for" value="<?php echo isset($form_data['referred_for']) ? htmlspecialchars($form_data['referred_for']) : ''; ?>" style="width: 374px;" />
                    <?php echo form_error('referred_for'); ?>
                </div>
            </div>

            <!-- FOLLOW UP/COMPLIANCE -->
            <div class="grp" style="width: 115%;">
                <label>FOLLOW UP/COMPLIANCE  </label>
                <div class="box-right" style="padding-left: 2.5rem;">
                    <input type="text" name="follow_up" class="txt_firstCap input-height"
                        id="follow_up" value="<?php echo isset($form_data['follow_up']) ? htmlspecialchars($form_data['follow_up']) : ''; ?>" style="width: 374px;" />
                    <?php echo form_error('follow_up'); ?>
                </div>
            </div>

            <div class="form-signatures mt-4">
                <table class="table table-borderless mb-4 w-100">
                    <tbody>
                        <tr>
                            <!-- Optometrist Dropdown -->
                            <td class="small text-center mt-5" style="width: 50%;">
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

                            <!-- Doctor Dropdown -->
                            <td class="small text-center mt-5" style="width: 50%;">
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
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>


            <div class="grp">
                <label></label>
                <div class="box-right">
                    <button class="btn-update" id="form_submit">
                        <i class="fa fa-save"></i> Save</button>
                    <a href="<?php echo base_url('low_vision'); ?>" class="btn-update"
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
        $('.low_vision_contra_sens_l').prop('checked', false).parent().removeClass('active');
        $('.cons_clr_l').hide();
    }

    function clearRight() {
        $('.low_vision_contra_sens_r').prop('checked', false).parent().removeClass('active');
        $('.cons_clr_r').hide();
    }
    $(document).ready(function() {
    // Example of how you might receive $form_data from your server-side code
    var form_data = {
        low_vision_contra_sens_l: 'value1', // replace with actual value
        low_vision_contra_sens_r: 'value2'  // replace with actual value
    };

    // Check if there is a selected value for left contrast sensitivity
    if (form_data.low_vision_contra_sens_l) {
        $('.cons_clr_l').show();
        // You might want to set the radio button as checked and active
        $('.low_vision_contra_sens_l[value="' + form_data.low_vision_contra_sens_l + '"]').prop('checked', true).parent().addClass('active');
    } else {
        $('.cons_clr_l').hide(); // Hide if there is no selection
    }

    // Check if there is a selected value for right contrast sensitivity
    if (form_data.low_vision_contra_sens_r) {
        $('.cons_clr_r').show();
        $('.low_vision_contra_sens_r[value="' + form_data.low_vision_contra_sens_r + '"]').prop('checked', true).parent().addClass('active');
    } else {
        $('.cons_clr_r').hide(); // Hide if there is no selection
    }

    // Event listener for left radio buttons
    $('.low_vision_contra_sens_l').click(function() {
        let selectedValueL = $(this).val();
        $('.cons_clr_l').show();
        $('.low_vision_contra_sens_l').parent().removeClass('active');
        $(this).parent().addClass('active');
    });

    // Event listener for right radio buttons
    $('.low_vision_contra_sens_r').click(function() {
        let selectedValueR = $(this).val();
        $('.cons_clr_r').show();
            $('.low_vision_contra_sens_r').parent().removeClass('active');
            $(this).parent().addClass('active');
        });
    });



    function low_vision_contra_sens_ltr()
  	{
        // alert();
  		  var radiosl = $('input[name=low_vision_contra_sens_l]');
  		  var radiosr = $('input[name=low_vision_contra_sens_r]');
  		  var vals=$('input[name=low_vision_contra_sens_l]:checked').val();
  		  if(radiosl.is(':checked') === true) 
  		  {
  		  	$('.low_vision_contra_sens_r').parent().removeClass('active');
		      radiosr.filter('[value="'+vals+'"]').prop('checked', true).parent().addClass('active');
		  }
  	}
    
  	function low_vision_contra_sens_rtl()
  	{
  		  var radiosr = $('input[name=low_vision_contra_sens_r]');
  		  var radiosl = $('input[name=low_vision_contra_sens_l]');
  		  var vals=$('input[name=low_vision_contra_sens_r]:checked').val();
  		  if(radiosr.is(':checked') === true) 
  		  {
  		  	$('.low_vision_contra_sens_l').parent().removeClass('active');
		      radiosl.filter('[value="'+vals+'"]').prop('checked', true).parent().addClass('active');
		  }
  	}  	
    function open_modals_2(modal_tab) {
        // alert('ok');
        var $modal = $('#load_add_type_modal_popup');
        $modal.load('<?php echo base_url().'low_vision/fill_eye_data_auto_low_vision/' ?>'+modal_tab,
        {
        },
        function(){
        $modal.modal('show');
        });
  	}

      document.getElementById('low_vision_form').addEventListener('submit', function (event) {
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
            var url = isEditMode ? '<?php echo base_url('low_vision/edit/'); ?>' + id : '<?php echo base_url('low_vision/add'); ?>';
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
                    window.location.href = '<?php echo base_url('low_vision'); ?>'; // Adjust this URL as necessary
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