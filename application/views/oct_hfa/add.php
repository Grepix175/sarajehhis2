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
        .comment label{
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
                        <input type="text" name="patient_name" value="<?php echo isset($booking_data['patient_name']) ? $booking_data['patient_name'] : 'N/A'; ?>" readonly="">
                    </div>
                </div>
                <div class="row m-b-5">
                    <div class="col-xs-4"><strong>Patient Reg. No</strong></div>
                    <div class="col-xs-8">
                        <input type="text" name="patient_code" value="<?php echo isset($booking_data['patient_code']) ? $booking_data['patient_code'] : 'N/A'; ?>" readonly="">
                    </div>
                </div>
                <div class="row m-b-5">
                    <div class="col-xs-4"><strong>OPD No</strong></div>
                    <div class="col-xs-8">
                        <input type="text" name="booking_code" value="<?php echo isset($booking_data['booking_code']) ? $booking_data['booking_code'] : 'N/A'; ?>" readonly="">
                    </div>
                    
                </div>
                <div class="row m-b-5">
                        <div class="col-xs-4"><strong>Token No</strong></div>
                        <div class="col-xs-8">
                            <input type="text" name="token_no" value="<?php echo isset($booking_data['token_no']) ? $booking_data['token_no'] : 'N/A'; ?>" readonly="">
                        </div>
                    </div>
            </div>
            <div class="col-xs-5">
                <div class="row m-b-5">
                    <div class="col-xs-4"><strong>Mobile no.</strong></div>
                    <div class="col-xs-8">
                        <input type="text" name="mobile_no" value="<?php echo isset($booking_data['mobile_no']) ? $booking_data['mobile_no'] : 'N/A'; ?>" readonly="">
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
                        <input type="text" name="gender" value="<?php echo ($booking_data['gender'] == '0') ? 'Female' : 'Male'; ?>" readonly="">
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
        
       <?php //echo "<pre>";print_r($chief_complaints);die; ?>
            

        <section>
        <h4>Chief Complaints</h4> 
        <div class="btn-group">
        <label class="btn-custom" style="text-transform:unset!important;"><input type="checkbox" <?php if($chief_complaints['bdv_m']==1){echo 'checked';}?> name="bdv_m" value="1" id="bdv_m"> Blurring/Diminution of vision</label>  
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['redness_m']==1){echo 'checked';}?> name="redness_m" value="1" id="redness_m"> Redness</label>  
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['`pain_m`']==1){echo 'checked';}?> name="pain_m" value="1" id="pain_m"> Pain</label>
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['injury_m']==1){echo 'checked';}?> name="injury_m" value="1" id="injury_m"> Injury</label>
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['water_m']==1){echo 'checked';}?> name="water_m" value="1" id="water_m"> Watering</label>
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['discharge_m']==1){echo 'checked';}?> name="discharge_m" value="1" id="discharge_m"> Discharge</label>
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['dryness_m']==1){echo 'checked';}?> name="dryness_m" value="1" id="dryness_m"> Dryness</label>
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['itch_m']==1){echo 'checked';}?> name="itch_m" value="1" id="itch_m"> Itching</label>
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['fbd_m']==1){echo 'checked';}?> name="fbd_m" value="1" id="fbd_m"> FB Sensation</label>
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['devs_m']==1){echo 'checked';}?> name="devs_m" value="1" id="devs_m"> Deviation/Squint</label>
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['heads_m']==1){echo 'checked';}?> name="heads_m" value="1" id="heads_m"> Headache/Strain</label>
        <label class="btn-custom" style="text-transform:unset!important;"><input type="checkbox" <?php if($chief_complaints['canss_m']==1){echo 'checked';}?> name="canss_m" value="1" id="canss_m"> Change in Size/Shape</label>
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['ovs_m']==1){echo 'checked';}?> name="ovs_m" value="1" id="ovs_m"> Other Visual Symptoms</label>
        <label class="btn-custom" style="text-transform:unset!important;"><input type="checkbox" <?php if($chief_complaints['sdv_m']==1){echo 'checked';}?> name="sdv_m" value="1" id="sdv_m"> Shadow/Defect in vision</label>
        <label class="btn-custom" style="text-transform:unset!important;"><input type="checkbox" <?php if($chief_complaints['doe_m']==1){echo 'checked';}?> name="doe_m" value="1" id="doe_m"> Discoloration of Eye</label>
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['swel_m']==1){echo 'checked';}?> name="swel_m" value="1" id="swel_m"> Swelling</label>
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['burns_m']==1){echo 'checked';}?> name="burns_m" value="1" id="burns_m"> Burning Sensation</label>
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['ptosis_sx']==1){echo 'checked';}?> name="ptosis_sx" value="1" id="ptosis_sx"> Ptosis Sx</label>
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['lid_sx']==1){echo 'checked';}?> name="lid_sx" value="1" id="lid_sx"> Lid Sx</label>
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['corneal_sx']==1){echo 'checked';}?> name="corneal_sx" value="1" id="corneal_sx"> Corneal Sx</label>
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['cataract_sx']==1){echo 'checked';}?> name="cataract_sx" value="1" id="cataract_sx"> Cataract Sx</label>
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['squint_sx']==1){echo 'checked';}?> name="squint_sx" value="1" id="squint_sx"> Squint Sx</label>
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['pterygium_sx']==1){echo 'checked';}?> name="pterygium_sx" value="1" id="pterygium_sx"> Pterygium Sx</label>
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['dcr']==1){echo 'checked';}?> name="dcr" value="1" id="dcr_sx"> DCR</label>
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['dct_sx']==1){echo 'checked';}?> name="dct_sx" value="1" id="dct_sx"> DCT Sx</label>
        <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['patching_therapy']==1){echo 'checked';}?> name="patching_therapy" value="1" id="patching_therapy">Patching Therapy</label>
        </div>     

        <div class="panel">
            <div class="panel-body">
            <section class="my_float_div">
                <div class="row">
                <div class="col-md-2  m-b-5">
                    <label>Name</label>
                </div>
                <div class="col-md-1  m-b-5">
                    <label>Side</label>
                </div>
                <div class="col-md-1  m-b-5">
                    <label>Duration</label>
                </div>
                <div class="col-md-3  m-b-5">
                    <label>Duration Unit</label>
                </div>
                <div class="col-md-3  m-b-5">
                    <label>Comments</label>
                </div>
                <div class="col-md-2  m-b-5">
                    <label>Options</label>
                </div>
                </div>
            </section>
            

            <section class="my_float_div" id="append_redness">
                <div class="row" id="pains">
                        <div class="col-md-2  m-b-5">
                            <label>Pain</label>
                        </div>
                        <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_pains_side">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_pains_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                            <option <?php if($chief_complaints['history_chief_pains_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                            <option <?php if($chief_complaints['history_chief_pains_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                            </select>  
                        </div>
                        <div class="col-md-1 m-b-5">
                            <select class="form-control" name="history_chief_pains_dur">
                            <option value="">Please Select</option>
                            <?php for($i=1; $i<=40;$i++) { ?>
                                <option <?php if($chief_complaints['history_chief_pains_dur']==$i){ echo 'selected';} ?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php } ?>
                            
                            </select>
                        </div>
                        <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_pains_unit">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_pains_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                            <option <?php if($chief_complaints['history_chief_pains_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                            <option <?php if($chief_complaints['history_chief_pains_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                            <option <?php if($chief_complaints['history_chief_pains_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                            </select>
                        </div>
                        <div class="col-md-3  m-b-5">
                            <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_pains_comm'];?>" name="history_chief_pains_comm" style="width: 100%;">
                        </div></div>

                <div class="row" id="blurr">
                        <div class="col-md-2  m-b-5">
                        <label style="text-transform:unset !important">Blurring Diminution of Vision</label>
                        </div>
                            <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_blurr_side">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_blurr_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                            <option <?php if($chief_complaints['history_chief_blurr_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                            <option <?php if($chief_complaints['history_chief_blurr_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                        </select>  
                        </div>
                        <div class="col-md-1 m-b-5">
                        <select class="form-control" name="history_chief_blurr_dur">
                            <option value="">Please Select</option>
                            <?php for($i=1; $i<=40;$i++) { ?>
                                <option <?php if($chief_complaints['history_chief_blurr_dur']==$i){ echo 'selected';} ?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php } ?>
                            
                        </select>
                        </div>
                        <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_blurr_unit">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_blurr_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                            <option <?php if($chief_complaints['history_chief_blurr_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                            <option <?php if($chief_complaints['history_chief_blurr_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                            <option <?php if($chief_complaints['history_chief_blurr_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                        </select>
                        </div>
                        <div class="col-md-3  m-b-5">
                        <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_blurr_comm']; ?>" name="history_chief_blurr_comm" style="width: 100%;">
                        </div>
                        <div class="col-md-4  m-b-5">
                        <div class="btn-group">
                            <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['history_chief_blurr_dist']==1){ echo 'checked';} ?> name="history_chief_blurr_dist" id="history_chief_blurr_dist" value="1" >Distant</label>
                            <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['history_chief_blurr_near']==1){ echo 'checked';} ?> name="history_chief_blurr_near" id="history_chief_blurr_near" value="1" >Near</label>
                            <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['history_chief_blurr_pain']==1){ echo 'checked';} ?> name="history_chief_blurr_pain" id="history_chief_blurr_pain" value="1" >Pain</label>
                            <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['history_chief_blurr_ug']==1){ echo 'checked';} ?> name="history_chief_blurr_ug" id="history_chief_blurr_ug" value="1" >Using Glasses</label>
                        </div>
                        </div></div>
                    
                <div class="row" id="rednes">
                        <div class="col-md-2  m-b-5">
                        <label>Redness </label>
                        </div>
                            <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_rednes_side">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_rednes_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                            <option <?php if($chief_complaints['history_chief_rednes_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                            <option <?php if($chief_complaints['history_chief_rednes_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                        </select>  
                        </div>
                        <div class="col-md-1 m-b-5">
                        <select class="form-control" name="history_chief_rednes_dur">
                            <option value="">Please Select</option>
                            <?php for($i=1; $i<=40;$i++) { ?>
                                <option <?php if($chief_complaints['history_chief_rednes_dur']==$i){ echo 'selected';}?>  value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php } ?>
                            
                        </select>
                        </div>
                        <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_rednes_unit">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_rednes_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                            <option <?php if($chief_complaints['history_chief_rednes_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                            <option <?php if($chief_complaints['history_chief_rednes_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                            <option <?php if($chief_complaints['history_chief_rednes_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                        </select>
                        </div>
                        <div class="col-md-3  m-b-5">
                        <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_rednes_comm']; ?>" name="history_chief_rednes_comm" style="width: 100%;">
                        </div></div>

                <div class="row" id="injuries">
                        <div class="col-md-2  m-b-5">
                        <label>Injury  </label>
                        </div>
                        <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_injuries_side">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_injuries_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                            <option <?php if($chief_complaints['history_chief_injuries_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                            <option <?php if($chief_complaints['history_chief_injuries_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                        </select>  
                        </div>
                        <div class="col-md-1 m-b-5">
                        <select class="form-control" name="history_chief_injuries_dur">
                            <option value="">Please Select</option>
                            <?php for($i=1; $i<=40;$i++) { ?>
                                <option <?php if($chief_complaints['history_chief_injuries_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php } ?>
                            
                        </select>
                        </div>
                        <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_injuries_unit">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_injuries_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                            <option <?php if($chief_complaints['history_chief_injuries_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                            <option <?php if($chief_complaints['history_chief_injuries_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                            <option <?php if($chief_complaints['history_chief_injuries_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                        </select>
                        </div>
                        <div class="col-md-3  m-b-5">
                        <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_injuries_comm'];?>" name="history_chief_injuries_comm" style="width: 100%;">
                        </div></div>

                <div class="row" id="waterings">
                        <div class="col-md-2  m-b-5">
                        <label>Watering </label>
                        </div>
                        <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_waterings_side">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_waterings_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                            <option <?php if($chief_complaints['history_chief_waterings_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                            <option <?php if($chief_complaints['history_chief_waterings_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                        </select>  
                        </div>
                        <div class="col-md-1 m-b-5">
                        <select class="form-control" name="history_chief_waterings_dur">
                            <option value="">Please Select</option>
                            <?php for($i=1; $i<=40;$i++) { ?>
                                <option <?php if($chief_complaints['history_chief_waterings_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php } ?>
                            
                        </select>
                        </div>
                        <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_waterings_unit">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_waterings_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                            <option <?php if($chief_complaints['history_chief_waterings_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                            <option <?php if($chief_complaints['history_chief_waterings_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                            <option <?php if($chief_complaints['history_chief_waterings_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                        </select>
                        </div>
                        <div class="col-md-3  m-b-5">
                        <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_waterings_comm'];?>" name="history_chief_waterings_comm" style="width: 100%;">
                        </div></div>

                <div class="row" id="discharges">
                        <div class="col-md-2  m-b-5">
                        <label>Discharge </label>
                        </div>
                            <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_discharges_side">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_discharges_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                            <option <?php if($chief_complaints['history_chief_discharges_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                            <option <?php if($chief_complaints['history_chief_discharges_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                        </select>  
                        </div>
                        <div class="col-md-1 m-b-5">
                        <select class="form-control" name="history_chief_discharges_dur">
                            <option value="">Please Select</option>
                            <?php for($i=1; $i<=40;$i++) { ?>
                                <option <?php if($chief_complaints['history_chief_discharges_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php } ?>
                            
                        </select>
                        </div>
                        <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_discharges_unit">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_discharges_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                            <option <?php if($chief_complaints['history_chief_discharges_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                            <option <?php if($chief_complaints['history_chief_discharges_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                            <option <?php if($chief_complaints['history_chief_discharges_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                        </select>
                        </div>
                        <div class="col-md-3  m-b-5">
                        <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_discharges_comm'];?>" name="history_chief_discharges_comm" style="width: 100%;">
                        </div></div>

                <div class="row" id="dryness">
                        <div class="col-md-2  m-b-5">
                        <label>Dryness </label>
                        </div>
                        <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_dryness_side">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_dryness_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                            <option <?php if($chief_complaints['history_chief_dryness_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                            <option <?php if($chief_complaints['history_chief_dryness_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                        </select>  
                        </div>
                        <div class="col-md-1 m-b-5">
                        <select class="form-control" name="history_chief_dryness_dur">
                            <option value="">Please Select</option>
                            <?php for($i=1; $i<=40;$i++) { ?>
                                <option <?php if($chief_complaints['history_chief_dryness_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php } ?>
                            
                        </select>
                        </div>
                        <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_dryness_unit">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_dryness_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                            <option <?php if($chief_complaints['history_chief_dryness_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                            <option <?php if($chief_complaints['history_chief_dryness_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                            <option <?php if($chief_complaints['history_chief_dryness_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                        </select>
                        </div>
                        <div class="col-md-3  m-b-5">
                        <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_dryness_comm']; ?>" name="history_chief_dryness_comm" style="width: 100%;">
                        </div></div>

                <div class="row" id="itchings">
                        <div class="col-md-2  m-b-5">
                        <label>Itching  </label>
                        </div>
                        <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_itchings_side">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_itchings_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                            <option <?php if($chief_complaints['history_chief_itchings_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                            <option <?php if($chief_complaints['history_chief_itchings_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                        </select>  
                        </div>
                        <div class="col-md-1 m-b-5">
                        <select class="form-control" name="history_chief_itchings_dur">
                            <option value="">Please Select</option>
                            <?php for($i=1; $i<=40;$i++) { ?>
                                <option <?php if($chief_complaints['history_chief_itchings_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php } ?>
                            
                        </select>
                        </div>
                        <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_itchings_unit">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_itchings_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                            <option <?php if($chief_complaints['history_chief_itchings_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                            <option <?php if($chief_complaints['history_chief_itchings_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                            <option <?php if($chief_complaints['history_chief_itchings_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                        </select>
                        </div>
                        <div class="col-md-3  m-b-5">
                        <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_itchings_comm']; ?>" name="history_chief_itchings_comm" style="width: 100%;">
                        </div></div>

                <div class="row" id="fbsensation">
                        <div class="col-md-2  m-b-5">
                        <label>FB Sensation </label>
                        </div>
                            <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_fbsensation_side">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_fbsensation_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                            <option <?php if($chief_complaints['history_chief_fbsensation_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                            <option <?php if($chief_complaints['history_chief_fbsensation_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                        </select>  
                        </div>
                        <div class="col-md-1 m-b-5">
                        <select class="form-control" name="history_chief_fbsensation_dur">
                            <option value="">Please Select</option>
                            <?php for($i=1; $i<=40;$i++) { ?>
                                <option <?php if($chief_complaints['history_chief_fbsensation_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php } ?>
                            
                        </select>
                        </div>
                        <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_fbsensation_unit">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_fbsensation_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                            <option <?php if($chief_complaints['history_chief_fbsensation_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                            <option <?php if($chief_complaints['history_chief_fbsensation_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                            <option <?php if($chief_complaints['history_chief_fbsensation_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                        </select>
                        </div>
                        <div class="col-md-3  m-b-5">
                        <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_fbsensation_comm']; ?>" name="history_chief_fbsensation_comm" style="width: 100%;">
                        </div></div>

                <div class="row" id="dev_squint">
                        <div class="col-md-2  m-b-5">
                        <label>Deviation Squint </label>
                        </div>
                            <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_dev_squint_side">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_dev_squint_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                            <option <?php if($chief_complaints['history_chief_dev_squint_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                            <option <?php if($chief_complaints['history_chief_dev_squint_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                        </select>  
                        </div>
                        <div class="col-md-1 m-b-5">
                        <select class="form-control" name="history_chief_dev_squint_dur">
                            <option value="">Please Select</option>
                            <?php for($i=1; $i<=40;$i++) { ?>
                                <option <?php if($chief_complaints['history_chief_dev_squint_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php } ?>
                            
                        </select>
                        </div>
                        <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_dev_squint_unit">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_dev_squint_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                            <option <?php if($chief_complaints['history_chief_dev_squint_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                            <option  <?php if($chief_complaints['history_chief_dev_squint_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                            <option  <?php if($chief_complaints['history_chief_dev_squint_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                        </select>
                        </div>
                        <div class="col-md-3  m-b-5">
                        <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_dev_squint_comm']; ?>" name="history_chief_dev_squint_comm" style="width: 100%;">
                        </div>
                        <div class="col-md-4  m-b-5">
                        <div class="btn-group">

                            <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['history_chief_dev_diplopia']==1){ echo 'checked';} ?> name="history_chief_dev_diplopia" id="history_chief_dev_diplopia" value="1" >Diplopia</label>

                            <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['history_chief_dev_truma']==1){ echo 'checked';} ?> name="history_chief_dev_truma" id="history_chief_dev_truma" value="1" >Trauma</label>

                            <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['history_chief_dev_ps']==1){ echo 'checked';} ?> name="history_chief_dev_ps" id="history_chief_dev_ps" value="1" >Past Surgery</label>
                        </div>
                        </div></div>

                <div class="row" id="head_strain">
                        <div class="col-md-2  m-b-5">
                        <label>Headache Strain </label>
                        </div>
                            <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_head_strain_side">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_head_strain_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                            <option <?php if($chief_complaints['history_chief_head_strain_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                            <option <?php if($chief_complaints['history_chief_head_strain_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                        </select>  
                        </div>
                        <div class="col-md-1 m-b-5">
                        <select class="form-control" name="history_chief_head_strain_dur">
                            <option value="">Please Select</option>
                            <?php for($i=1; $i<=40;$i++) { ?>
                                <option <?php if($chief_complaints['history_chief_head_strain_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php } ?>
                            
                        </select>
                        </div>
                        <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_head_strain_unit">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_head_strain_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                            <option <?php if($chief_complaints['history_chief_head_strain_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                            <option <?php if($chief_complaints['history_chief_head_strain_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                            <option <?php if($chief_complaints['history_chief_head_strain_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                        </select>
                        </div>
                        <div class="col-md-3  m-b-5">
                        <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_head_strain_comm']; ?>" name="history_chief_head_strain_comm" style="width: 100%;">
                        </div></div>

                <div class="row" id="size_shape">
                        <div class="col-md-2  m-b-5">
                        <label>Change In Size Shape </label>
                        </div>
                            <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_size_shape_side">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_size_shape_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                            <option <?php if($chief_complaints['history_chief_size_shape_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                            <option <?php if($chief_complaints['history_chief_size_shape_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                        </select>  
                        </div>
                        <div class="col-md-1 m-b-5">
                        <select class="form-control" name="history_chief_size_shape_dur">
                            <option value="">Please Select</option>
                            <?php for($i=1; $i<=40;$i++) { ?>
                                <option <?php if($chief_complaints['history_chief_size_shape_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php } ?>
                            
                        </select>
                        </div>
                        <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_size_shape_unit">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_size_shape_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                            <option <?php if($chief_complaints['history_chief_size_shape_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                            <option <?php if($chief_complaints['history_chief_size_shape_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                            <option <?php if($chief_complaints['history_chief_size_shape_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                        </select>
                        </div>
                        <div class="col-md-3  m-b-5">
                        <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_size_shape_comm']; ?>" name="history_chief_size_shape_comm" style="width: 100%;">
                        </div></div>

                <div class="row" id="ovs">
                        <div class="col-md-2  m-b-5">
                        <label>Other Visual Symptoms </label>
                        </div>
                            <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_ovs_side">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_ovs_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                            <option <?php if($chief_complaints['history_chief_ovs_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                            <option <?php if($chief_complaints['history_chief_ovs_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                        </select>  
                        </div>
                        <div class="col-md-1 m-b-5">
                        <select class="form-control" name="history_chief_ovs_dur">
                            <option value="">Please Select</option>
                            <?php for($i=1; $i<=40;$i++) { ?>
                                <option <?php if($chief_complaints['history_chief_ovs_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php } ?>
                            
                        </select>
                        </div>
                        <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_ovs_unit">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_ovs_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                            <option <?php if($chief_complaints['history_chief_ovs_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                            <option <?php if($chief_complaints['history_chief_ovs_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                            <option <?php if($chief_complaints['history_chief_ovs_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                        </select>
                        </div>
                        <div class="col-md-3  m-b-5">
                        <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_ovs_comm']; ?>" name="history_chief_ovs_comm" style="width: 100%;">
                        </div>
                        <div class="col-md-4  m-b-5">
                        <div class="btn-group">
                            <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['history_chief_ovs_glare']==1){ echo 'checked';}?> name="history_chief_ovs_glare" value="1" id="history_chief_ovs_glare">Glare</label>
                            <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['history_chief_ovs_floaters']==1){ echo 'checked';}?> name="history_chief_ovs_floaters" value="1" id="history_chief_ovs_floaters">Floaters</label>
                            <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['history_chief_ovs_photophobia']==1){ echo 'checked';}?> name="history_chief_ovs_photophobia" value="1" id="history_chief_ovs_photophobia">Photophobia</label>
                            <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['history_chief_ovs_color_halos']==1){ echo 'checked';}?> name="history_chief_ovs_color_halos" value="1" id="history_chief_ovs_color_halos">Colored Halos</label>
                            <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['history_chief_ovs_metamorphopsia']==1){ echo 'checked';}?> name="history_chief_ovs_metamorphopsia" value="1" id="history_chief_ovs_metamorphopsia">Metamorphopsia</label>
                            <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['history_chief_ovs_chromatopsia']==1){ echo 'checked';}?> name="history_chief_ovs_chromatopsia" value="1" id="history_chief_ovs_chromatopsia">Chromatopsia</label>
                            <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['history_chief_ovs_dnv']==1){ echo 'checked';}?> name="history_chief_ovs_dnv" value="1" id="history_chief_ovs_dnv">Diminished Night Vision</label>
                            <label class="btn-custom"><input type="checkbox" <?php if($chief_complaints['history_chief_ovs_ddv']==1){ echo 'checked';}?> name="history_chief_ovs_ddv" value="1" id="history_chief_ovs_ddv">Diminished Day Vision</label>

                        </div>
                        </div> </div>

                <div class="row" id="sdiv">
                        <div class="col-md-2  m-b-5">
                        <label>Shadow Defect In Vision </label>
                        </div>
                            <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_sdiv_side">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_sdiv_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                            <option <?php if($chief_complaints['history_chief_sdiv_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                            <option <?php if($chief_complaints['history_chief_sdiv_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                        </select>  
                        </div>
                        <div class="col-md-1 m-b-5">
                        <select class="form-control" name="history_chief_sdiv_dur">
                            <option value="">Please Select</option>
                            <?php for($i=1; $i<=40;$i++) { ?>
                                <option <?php if($chief_complaints['history_chief_sdiv_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php } ?>
                            
                        </select>
                        </div>
                        <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_sdiv_unit">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_sdiv_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                            <option <?php if($chief_complaints['history_chief_sdiv_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                            <option <?php if($chief_complaints['history_chief_sdiv_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                            <option <?php if($chief_complaints['history_chief_sdiv_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                        </select>
                        </div>
                        <div class="col-md-3  m-b-5">
                        <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_sdiv_comm']; ?>" name="history_chief_sdiv_comm" style="width: 100%;">
                        </div></div>

                <div class="row" id="doe">
                        <div class="col-md-2  m-b-5">
                        <label>Discoloration Of Eye </label>
                        </div>
                            <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_doe_side">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_doe_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                            <option <?php if($chief_complaints['history_chief_doe_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                            <option <?php if($chief_complaints['history_chief_doe_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                        </select>  
                        </div>
                        <div class="col-md-1 m-b-5">
                        <select class="form-control" name="history_chief_doe_dur">
                            <option value="">Please Select</option>
                            <?php for($i=1; $i<=40;$i++) { ?>
                                <option <?php if($chief_complaints['history_chief_doe_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php } ?>
                            
                        </select>
                        </div>
                        <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_doe_unit">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_doe_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                            <option <?php if($chief_complaints['history_chief_doe_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                            <option <?php if($chief_complaints['history_chief_doe_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                            <option <?php if($chief_complaints['history_chief_doe_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                        </select>
                        </div>
                        <div class="col-md-3  m-b-5">
                        <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_doe_comm']; ?>" name="history_chief_doe_comm" style="width: 100%;">
                        </div>          </div>

                <div class="row" id="swell">
                        <div class="col-md-2  m-b-5">
                        <label>Swelling  </label>
                        </div>
                            <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_swell_side">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_swell_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                            <option <?php if($chief_complaints['history_chief_swell_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                            <option <?php if($chief_complaints['history_chief_swell_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                        </select>  
                        </div>
                        <div class="col-md-1 m-b-5">
                        <select class="form-control" name="history_chief_swell_dur">
                            <option value="">Please Select</option>
                            <?php for($i=1; $i<=40;$i++) { ?>
                                <option <?php if($chief_complaints['history_chief_swell_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php } ?>
                            
                        </select>
                        </div>
                        <div class="col-md-1  m-b-5">
                        <select class="form-control" name="history_chief_swell_unit">
                            <option value="">Please Select</option>
                            <option <?php if($chief_complaints['history_chief_swell_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                            <option <?php if($chief_complaints['history_chief_swell_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                            <option <?php if($chief_complaints['history_chief_swell_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                            <option <?php if($chief_complaints['history_chief_swell_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                        </select>
                        </div>
                        <div class="col-md-3  m-b-5">
                        <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_swell_comm']; ?>" name="history_chief_swell_comm" style="width: 100%;">
                        </div></div>

                        <div class="row" id="sen_burn">
                            <div class="col-md-2  m-b-5">
                                <label>Sensation Burning</label>
                            </div>
                            <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_sen_burn_side">
                                <option value="">Please Select</option>
                                <option <?php if($chief_complaints['history_chief_sen_burn_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                                <option <?php if($chief_complaints['history_chief_sen_burn_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                                <option <?php if($chief_complaints['history_chief_sen_burn_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                            </select>  
                            </div>
                            <div class="col-md-1 m-b-5">
                            <select class="form-control" name="history_chief_sen_burn_dur">
                                <option value="">Please Select</option>
                                <?php for($i=1; $i<=40;$i++) { ?>
                                    <option <?php if($chief_complaints['history_chief_sen_burn_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php } ?>
                                
                            </select>
                            </div>
                            <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_sen_burn_unit">
                                <option value="">Please Select</option>
                                <option <?php if($chief_complaints['history_chief_sen_burn_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                                <option <?php if($chief_complaints['history_chief_sen_burn_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                                <option <?php if($chief_complaints['history_chief_sen_burn_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                                <option <?php if($chief_complaints['history_chief_sen_burn_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                            </select>
                            </div>
                            <div class="col-md-3  m-b-5">
                            <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_sen_burn_comm']; ?>" name="history_chief_sen_burn_comm" style="width: 100%;">
                            </div>
                        </div>
                        <div class="row" id="sx_ptosis">
                            <div class="col-md-2  m-b-5">
                                <label>Ptosis Sx</label>
                            </div>
                            <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_ptosis_side">
                                <option value="">Please Select</option>
                                <option <?php if($chief_complaints['history_chief_ptosis_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                                <option <?php if($chief_complaints['history_chief_ptosis_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                                <option <?php if($chief_complaints['history_chief_ptosis_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                            </select>  
                            </div>
                            <div class="col-md-1 m-b-5">
                            <select class="form-control" name="history_chief_ptosis_dur">
                                <option value="">Please Select</option>
                                <?php for($i=1; $i<=40;$i++) { ?>
                                    <option <?php if($chief_complaints['history_chief_ptosis_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php } ?>
                                
                            </select>
                            </div>
                            <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_ptosis_unit">
                                <option value="">Please Select</option>
                                <option <?php if($chief_complaints['history_chief_ptosis_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                                <option <?php if($chief_complaints['history_chief_ptosis_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                                <option <?php if($chief_complaints['history_chief_ptosis_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                                <option <?php if($chief_complaints['history_chief_ptosis_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                            </select>
                            </div>
                            <div class="col-md-3  m-b-5">
                            <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_ptosis_comm']; ?>" name="history_chief_ptosis_comm" style="width: 100%;">
                            </div>
                        </div>
                        <div class="row" id="sx_lid">
                            <div class="col-md-2  m-b-5">
                                <label>Lid Sx</label>
                            </div>
                            <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_lid_sx_side">
                                <option value="">Please Select</option>
                                <option <?php if($chief_complaints['history_chief_lid_sx_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                                <option <?php if($chief_complaints['history_chief_lid_sx_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                                <option <?php if($chief_complaints['history_chief_lid_sx_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                            </select>  
                            </div>
                            <div class="col-md-1 m-b-5">
                            <select class="form-control" name="history_chief_lid_sx_dur">
                                <option value="">Please Select</option>
                                <?php for($i=1; $i<=40;$i++) { ?>
                                    <option <?php if($chief_complaints['history_chief_lid_sx_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php } ?>
                                
                            </select>
                            </div>
                            <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_lid_sx_unit">
                                <option value="">Please Select</option>
                                <option <?php if($chief_complaints['history_chief_lid_sx_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                                <option <?php if($chief_complaints['history_chief_lid_sx_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                                <option <?php if($chief_complaints['history_chief_lid_sx_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                                <option <?php if($chief_complaints['history_chieflid_sx_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                            </select>
                            </div>
                            <div class="col-md-3  m-b-5">
                            <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_lid_sx_comm']; ?>" name="history_chieflid_sx_comm" style="width: 100%;">
                            </div>
                        </div>
                        <div class="row" id="sx_corneal">
                            <div class="col-md-2  m-b-5">
                                <label>Corneal Sx</label>
                            </div>
                            <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_corneal_sx_side">
                                <option value="">Please Select</option>
                                <option <?php if($chief_complaints['history_chief_corneal_sx_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                                <option <?php if($chief_complaints['history_chief_corneal_sx_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                                <option <?php if($chief_complaints['history_chief_corneal_sx_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                            </select>  
                            </div>
                            <div class="col-md-1 m-b-5">
                            <select class="form-control" name="history_chief_corneal_sx_dur">
                                <option value="">Please Select</option>
                                <?php for($i=1; $i<=40;$i++) { ?>
                                    <option <?php if($chief_complaints['history_chief_corneal_sx_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php } ?>
                                
                            </select>
                            </div>
                            <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_sen_cornel_sx_unit">
                                <option value="">Please Select</option>
                                <option <?php if($chief_complaints['history_chief_sen_corneal_sx_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                                <option <?php if($chief_complaints['history_chief_sen_corneal_sx_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                                <option <?php if($chief_complaints['history_chief_sen_corneal_sx_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                                <option <?php if($chief_complaints['history_chief_sen_corneal_sx_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                            </select>
                            </div>
                            <div class="col-md-3  m-b-5">
                            <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_corneal_sx_comm']; ?>" name="history_chief_corneal_sx_comm" style="width: 100%;">
                            </div>
                        </div>
                        
                        <div class="row" id="sx_cataract">
                            <div class="col-md-2  m-b-5">
                                <label>Cataract Sx</label>
                            </div>
                            <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_cataract_sx_side">
                                <option value="">Please Select</option>
                                <option <?php if($chief_complaints['history_chief_cataract_sx_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                                <option <?php if($chief_complaints['history_chief_cataract_sx_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                                <option <?php if($chief_complaints['history_chief_cataract_sx_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                            </select>  
                            </div>
                            <div class="col-md-1 m-b-5">
                            <select class="form-control" name="history_chief_cataract_sx_dur">
                                <option value="">Please Select</option>
                                <?php for($i=1; $i<=40;$i++) { ?>
                                    <option <?php if($chief_complaints['history_chief_cataract_sx_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php } ?>
                                
                            </select>
                            </div>
                            <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_cataract_sx_unit">
                                <option value="">Please Select</option>
                                <option <?php if($chief_complaints['history_chief_cataract_sx_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                                <option <?php if($chief_complaints['history_chief_cataract_sx_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                                <option <?php if($chief_complaints['history_chief_cataract_sx_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                                <option <?php if($chief_complaints['history_chief_cataract_sx_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                            </select>
                            </div>
                            <div class="col-md-3  m-b-5">
                            <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_cataract_sx_comm']; ?>" name="history_chief_cataract_sx_comm" style="width: 100%;">
                            </div>
                        </div>
                        <div class="row" id="sx_squint">
                            <div class="col-md-2  m-b-5">
                                <label>Squnit Sx</label>
                            </div>
                            <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_squint_sx_side">
                                <option value="">Please Select</option>
                                <option <?php if($chief_complaints['history_chief_squint_sx_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                                <option <?php if($chief_complaints['history_chief_squint_sx_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                                <option <?php if($chief_complaints['history_chief_squint_sx_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                            </select>  
                            </div>
                            <div class="col-md-1 m-b-5">
                            <select class="form-control" name="history_chief_squint_sx_dur">
                                <option value="">Please Select</option>
                                <?php for($i=1; $i<=40;$i++) { ?>
                                    <option <?php if($chief_complaints['history_chief_squint_sx_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php } ?>
                                
                            </select>
                            </div>
                            <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_squint_sx_unit">
                                <option value="">Please Select</option>
                                <option <?php if($chief_complaints['history_chief_squint_sx_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                                <option <?php if($chief_complaints['history_chief_squint_sx_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                                <option <?php if($chief_complaints['history_chief_squint_sx_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                                <option <?php if($chief_complaints['history_chief_squint_sx_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                            </select>
                            </div>
                            <div class="col-md-3  m-b-5">
                            <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_squint_sx_comm']; ?>" name="history_chief_squint_sx_comm" style="width: 100%;">
                            </div>
                        </div>
                        <div class="row" id="sx_pterygium">
                            <div class="col-md-2  m-b-5">
                                <label>Pterygium Sx</label>
                            </div>
                            <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_pterygium_sx_side">
                                <option value="">Please Select</option>
                                <option <?php if($chief_complaints['history_chief_pterygium_sx_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                                <option <?php if($chief_complaints['history_chief_pterygium_sx_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                                <option <?php if($chief_complaints['history_chief_pterygium_sx_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                            </select>  
                            </div>
                            <div class="col-md-1 m-b-5">
                            <select class="form-control" name="history_chief_squint_sx_dur">
                                <option value="">Please Select</option>
                                <?php for($i=1; $i<=40;$i++) { ?>
                                    <option <?php if($chief_complaints['history_chief_pterygium_sx_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php } ?>
                                
                            </select>
                            </div>
                            <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_pterygium_sx_unit">
                                <option value="">Please Select</option>
                                <option <?php if($chief_complaints['history_chief_pterygium_sx_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                                <option <?php if($chief_complaints['history_chief_pterygium_sx_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                                <option <?php if($chief_complaints['history_chief_pterygium_sx_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                                <option <?php if($chief_complaints['history_chief_pterygium_sx_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                            </select>
                            </div>
                            <div class="col-md-3  m-b-5">
                            <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_pterygium_sx_comm']; ?>" name="history_chief_pterygium_sx_comm" style="width: 100%;">
                            </div>
                        </div>
                        <div class="row" id="sx_dcr">
                            <div class="col-md-2  m-b-5">
                                <label>DCR</label>
                            </div>
                            <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_dcr_sx_side">
                                <option value="">Please Select</option>
                                <option <?php if($chief_complaints['history_chief_dcr_sx_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                                <option <?php if($chief_complaints['history_chief_dcr_sx_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                                <option <?php if($chief_complaints['history_chief_dcr_sx_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                            </select>  
                            </div>
                            <div class="col-md-1 m-b-5">
                            <select class="form-control" name="history_chief_dcr_sx_dur">
                                <option value="">Please Select</option>
                                <?php for($i=1; $i<=40;$i++) { ?>
                                    <option <?php if($chief_complaints['history_chief_dcr_sx_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php } ?>
                                
                            </select>
                            </div>
                            <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_dcr_sx_unit">
                                <option value="">Please Select</option>
                                <option <?php if($chief_complaints['history_chief_dcr_sx_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                                <option <?php if($chief_complaints['history_chief_dcr_sx_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                                <option <?php if($chief_complaints['history_chief_dcr_sx_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                                <option <?php if($chief_complaints['history_chief_dcr_sx_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                            </select>
                            </div>
                            <div class="col-md-3  m-b-5">
                            <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_dcr_sx_comm']; ?>" name="history_chief_dcr_sx_comm" style="width: 100%;">
                            </div>
                        </div>
                        <div class="row" id="sx_dct">
                            <div class="col-md-2  m-b-5">
                                <label>DCT Sx</label>
                            </div>
                            <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_dct_sx_side">
                                <option value="">Please Select</option>
                                <option <?php if($chief_complaints['history_chief_dct_sx_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                                <option <?php if($chief_complaints['history_chief_dct_sx_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                                <option <?php if($chief_complaints['history_chief_dct_sx_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                            </select>  
                            </div>
                            <div class="col-md-1 m-b-5">
                            <select class="form-control" name="history_chief_dct_sx_dur">
                                <option value="">Please Select</option>
                                <?php for($i=1; $i<=40;$i++) { ?>
                                    <option <?php if($chief_complaints['history_chief_dct_sx_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php } ?>
                                
                            </select>
                            </div>
                            <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_dcy_sx_unit">
                                <option value="">Please Select</option>
                                <option <?php if($chief_complaints['history_chief_dct_sx_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                                <option <?php if($chief_complaints['history_chief_dct_sx_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                                <option <?php if($chief_complaints['history_chief_dct_sx_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                                <option <?php if($chief_complaints['history_chief_dct_sx_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                            </select>
                            </div>
                            <div class="col-md-3  m-b-5">
                            <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_dct_sx_comm']; ?>" name="history_chief_dct_sx_comm" style="width: 100%;">
                            </div>
                        </div>
                        <div class="row" id="sx_patching_therapy">
                            <div class="col-md-2  m-b-5">
                                <label>Patching Therapy</label>
                            </div>
                            <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_patching_therapy_sx_side">
                                <option value="">Please Select</option>
                                <option <?php if($chief_complaints['history_chief_patching_therapy_sx_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                                <option <?php if($chief_complaints['history_chief_patching_therapy_sx_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                                <option <?php if($chief_complaints['history_chief_patching_therapy_sx_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                            </select>  
                            </div>
                            <div class="col-md-1 m-b-5">
                            <select class="form-control" name="history_chief_patching_therapy_sx_dur">
                                <option value="">Please Select</option>
                                <?php for($i=1; $i<=40;$i++) { ?>
                                    <option <?php if($chief_complaints['history_chief_patching_therapy_sx_dur']==$i){ echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php } ?>
                                
                            </select>
                            </div>
                            <div class="col-md-1  m-b-5">
                            <select class="form-control" name="history_chief_dcy_sx_unit">
                                <option value="">Please Select</option>
                                <option <?php if($chief_complaints['history_chief_patching_therapy_sx_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                                <option <?php if($chief_complaints['history_chief_patching_therapy_sx_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                                <option <?php if($chief_complaints['history_chief_patching_therapy_sx_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                                <option <?php if($chief_complaints['history_chief_patching_therapy_sx_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                            </select>
                            </div>
                            <div class="col-md-3  m-b-5">
                            <input type="text" placeholder="Comment..." value="<?php echo $chief_complaints['history_chief_patching_therapy_sx_comm']; ?>" name="history_chief_patching_therapy_sx_comm" style="width: 100%;">
                            </div>
                        </div>
            </section>


            <section>
                <div class="row">
                <div class="col-md-2">
                    Comments
                </div>
                <div class="col-md-10">
                    <textarea class="form-control w-100" name="history_chief_comm"><?php echo $chief_complaints['history_chief_comm'];?></textarea>
                </div>
                </div>
            </section>

            
            </div>
            
            <h4>Birth History:</h4>
            <section style="padding-left:15px;">
                <div class="grp" style="">
                    <label>Past Ocular History: </label>
                    <div class="box-right">
                        <input type="text" name="ocular_history" class="txt_firstCap input-height"
                            id="ocular_history" value="<?php echo isset($form_data['ocular_history']) ? htmlspecialchars($form_data['ocular_history']) : ''; ?>" style="width: 374px;" />
                        <?php echo form_error('ocular_history'); ?>
                    </div>
                </div>
                <div class="grp" style="">
                    <label>Past Medical History: </label>
                    <div class="box-right">
                        <input type="text" name="medical_history" class="txt_firstCap input-height"
                            id="medical_history" value="<?php echo isset($form_data['medical_history']) ? htmlspecialchars($form_data['medical_history']) : ''; ?>" style="width: 374px;" />
                        <?php echo form_error('medical_history'); ?>
                    </div>
                </div>


                <div class="grp" style="">
                    <label>No of child </label>
                    <div class="box-right">
                        
                        <input type="text" name="no_of_child" class="txt_firstCap input-height"
                            id="no_of_child" value="<?php echo isset($form_data['no_of_child']) ? htmlspecialchars($form_data['no_of_child']) : ''; ?>" style="width: 374px;" />
                        <?php echo form_error('time'); ?>
                    </div>
                </div>

                <div class="grp" style="">
                    <!-- <div class="grp" style=""> -->
                        <label for="sideEffects" class="font-weight-bold mb-0">Full Term</label>
                    <!-- </div> -->
                    
                    <div class="box-right">
                        <select name="delivery_type" id="delivery_type" class="m_input_default select-height">
                            <option value="">Select Delivery Type</option>
                            <option value="full_term" <?php echo isset($form_data['delivery_type']) && $form_data['delivery_type'] == 'full_term' ? 'selected="selected"' : ''; ?>>Full Term</option>
                            <option value="preterm" <?php echo isset($form_data['delivery_type']) && $form_data['delivery_type'] == 'preterm' ? 'selected="selected"' : ''; ?>>Preterm</option>
                            <option value="premature" <?php echo isset($form_data['delivery_type']) && $form_data['delivery_type'] == 'premature' ? 'selected="selected"' : ''; ?>>Premature</option>
                            <option value="normal" <?php echo isset($form_data['delivery_type']) && $form_data['delivery_type'] == 'normal' ? 'selected="selected"' : ''; ?>>Normal</option>
                            <option value="cesarian" <?php echo isset($form_data['delivery_type']) && $form_data['delivery_type'] == 'cesarian' ? 'selected="selected"' : ''; ?>>Cesarian Delivery</option>
                        </select>
                        <?php 
                        // Show form validation error if there is one
                        if (!empty($form_error)) {
                            echo form_error('delivery_type');
                        }
                        ?>
                    </div>

                </div>

                <div class="grp">
                    <label>Birth Weight (Kg): </label>
                    <div class="box-right">
                        <input type="text" name="birth_weight" class="txt_firstCap input-height"
                            id="birth_weight" value="<?php echo isset($form_data['birth_weight']) ? htmlspecialchars($form_data['birth_weight']) : ''; ?>" style="width: 374px;" />
                        <?php echo form_error('birth_weight'); ?>
                    </div>
                </div>
            
                <div class="grp">
                    <label>Recent Weight (Kg): </label>
                    <div class="box-right">
                        <input type="text" name="recent_weight" class="txt_firstCap input-height"
                            id="recent_weight" value="<?php echo isset($form_data['recent_weight']) ? htmlspecialchars($form_data['recent_weight']) : ''; ?>" style="width: 374px;" />
                        <?php echo form_error('recent_weight'); ?>
                    </div>
                </div>
            
                <div class="grp">
                    <label>H/O of Birth Asphyxia: </label>
                    <div class="box-right">
                        <input type="text" name="birth_asphyxia" class="txt_firstCap input-height"
                            id="birth_asphyxia" value="<?php echo isset($form_data['birth_asphyxia']) ? htmlspecialchars($form_data['birth_asphyxia']) : ''; ?>" style="width: 374px;" />
                        <?php echo form_error('birth_asphyxia'); ?>
                    </div>
                </div>
            
                <div class="grp">
                    <label>Cried after Birth: </label>
                    <div class="box-right">
                        <select name="cried_after_birth" id="cried_after_birth" class="m_input_default select-height">
                            <option value="">Select Yes/No</option>
                            <option value="yes" <?php echo isset($form_data['cried_after_birth']) && $form_data['cried_after_birth'] == 'yes' ? 'selected="selected"' : ''; ?>>Yes</option>
                            <option value="no" <?php echo isset($form_data['cried_after_birth']) && $form_data['cried_after_birth'] == 'no' ? 'selected="selected"' : ''; ?>>No</option>
                        </select>
                        <?php echo form_error('cried_after_birth'); ?>
                    </div>
                </div>
            
                <div class="grp">
                    <label>H/O: Pre/Peri/Postnatal Infection: </label>
                    <div class="box-right">
                        <select name="infection_history" id="infection_history" class="m_input_default select-height">
                            <option value="">Select Infection History</option>
                            <option value="pre" <?php echo isset($form_data['infection_history']) && $form_data['infection_history'] == 'pre' ? 'selected="selected"' : ''; ?>>Pre</option>
                            <option value="peri" <?php echo isset($form_data['infection_history']) && $form_data['infection_history'] == 'peri' ? 'selected="selected"' : ''; ?>>Peri</option>
                            <option value="post" <?php echo isset($form_data['infection_history']) && $form_data['infection_history'] == 'post' ? 'selected="selected"' : ''; ?>>Postnatal</option>
                        </select>
                        <?php echo form_error('infection_history'); ?>
                    </div>
                </div>
            
                <div class="grp">
                    <label>Milestone: </label>
                    <div class="box-right">
                        <select name="milestone" id="milestone" class="m_input_default select-height">
                            <option value="">Select Milestone</option>
                            <option value="normal" <?php echo isset($form_data['milestone']) && $form_data['milestone'] == 'normal' ? 'selected="selected"' : ''; ?>>Normal</option>
                            <option value="delayed" <?php echo isset($form_data['milestone']) && $form_data['milestone'] == 'delayed' ? 'selected="selected"' : ''; ?>>Delayed</option>
                            <option value="developmental_delayed" <?php echo isset($form_data['milestone']) && $form_data['milestone'] == 'developmental_delayed' ? 'selected="selected"' : ''; ?>>Developmental Delayed</option>
                        </select>
                        <?php echo form_error('milestone'); ?>
                    </div>
                </div>
            
                <div class="grp">
                    <label>H/O: Convulsion/Fits/Seizure: </label>
                    <div class="box-right">
                        <select name="convulsion_history" id="convulsion_history" class="m_input_default select-height">
                            <option value="">Select Convulsion History</option>
                            <option value="yes" <?php echo isset($form_data['convulsion_history']) && $form_data['convulsion_history'] == 'yes' ? 'selected="selected"' : ''; ?>>Yes</option>
                            <option value="no" <?php echo isset($form_data['convulsion_history']) && $form_data['convulsion_history'] == 'no' ? 'selected="selected"' : ''; ?>>No</option>
                        </select>
                        <?php echo form_error('convulsion_history'); ?>
                    </div>
                </div>
            
                <div class="grp">
                    <label>H/O of Consanguinity: </label>
                    <div class="box-right">
                        <input type="text" name="consanguinity_history" class="txt_firstCap input-height"
                            id="consanguinity_history" value="<?php echo isset($form_data['consanguinity_history']) ? htmlspecialchars($form_data['consanguinity_history']) : ''; ?>" style="width: 374px;" />
                        <?php echo form_error('consanguinity_history'); ?>
                    </div>
                </div>
            </section>

            <h4>Squint History</h4>
            <section>
                <?php //echo "<pre>";print_r($squint_history);die; ?>
                <div class="btn-group">
                <label class="btn-custom"><input type="checkbox" <?php if($squint_history['inward']==1){echo 'checked';}?> name="inward" value="1" id="inward"> Inward Deviation</label>  
                <label class="btn-custom"><input type="checkbox" <?php if($squint_history['outward']==1){echo 'checked';}?> name="outward" value="1" id="outward"> Outward Deviation</label>
                <label class="btn-custom"><input type="checkbox" <?php if($squint_history['upward']==1){echo 'checked';}?> name="upward" value="1" id="upward"> Upward/Downward</label>
                <label class="btn-custom"><input type="checkbox" <?php if($squint_history['prev_squint']==1){echo 'checked';}?> name="prev_squint" value="1" id="prev_squint"> Prev.H/O Squint/Other Surgery</label>
                <label class="btn-custom"><input type="checkbox" <?php if($squint_history['double_vision']==1){echo 'checked';}?> name="double_vision" value="1" id="double_vision"> H/O Double Vision</label>
                <label class="btn-custom"><input type="checkbox" <?php if($squint_history['constant']==1){echo 'checked';}?> name="constant" value="1" id="constant"> Constant/Occassional/Intermittently</label>
                <label class="btn-custom"><input type="checkbox" <?php if($squint_history['antisupression']==1){echo 'checked';}?> name="antisupression" value="1" id="antisupression"> H/O Waering Glasses/Patching Therapy/Antisupression</label>
                </div>     

                <div class="panel">
                    <div class="panel-body">
                    <section class="my_float_div">
                        <div class="row">
                        <div class="col-md-2  m-b-5">
                            <label>Name</label>
                        </div>
                        <div class="col-md-2  m-b-5">
                            <label>Side</label>
                        </div>
                        <div class="col-md-2  m-b-5">
                            <label>Duration</label>
                        </div>
                        <div class="col-md-3  m-b-5">
                            <label>Duration Unit</label>
                        </div>
                        <div class="col-md-3  m-b-5" >
                            <label>Comments</label>
                        </div>
                        <!-- <div class="col-md-2  m-b-5">
                            <label>Options</label>
                        </div> -->
                        </div>
                    </section>

                    <section class="my_float_div" id="append_redness">
                        <div class="row" id="inward1">
                            <div class="col-md-2  m-b-5">
                                <label>Inward Deviation</label>
                            </div>
                            <div class="col-md-2  m-b-5">
                                <select class="form-control" name="history_chief_inward_side">
                                <option value="">Please Select</option>
                                <option <?php if($squint_history['history_chief_inward_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                                <option <?php if($squint_history['history_chief_inward_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                                <option <?php if($squint_history['history_chief_inward_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                                </select>  
                            </div>
                            <div class="col-md-2 m-b-5">
                                <select class="form-control" name="history_chief_inward_dur">
                                <option value="">Please Select</option>
                                <?php for($i=1; $i<=40;$i++) { ?>
                                    <option <?php if($squint_history['history_chief_inward_dur']==$i){ echo 'selected';} ?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php } ?>
                                
                                </select>
                            </div>
                            <div class="col-md-3  m-b-5">
                                <select class="form-control" name="history_chief_inward_unit">
                                <option value="">Please Select</option>
                                <option <?php if($squint_history['history_chief_inward_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                                <option <?php if($squint_history['history_chief_inward_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                                <option <?php if($squint_history['history_chief_inward_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                                <option <?php if($squint_history['history_chief_inward_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                                </select>
                            </div>
                            <div class="col-md-3  m-b-5" style="width:9px !important;">
                                <input type="text" placeholder="Comment..." value="<?php echo $squint_history['history_chief_inward_comm'];?>" name="history_chief_inward_comm" style="width: 263px;margin-left:3px;">
                            </div>
                        </div>
                        <div class="row" id="outward1">
                            <div class="col-md-2  m-b-5">
                                <label>Outward Deviation</label>
                            </div>
                            <div class="col-md-2  m-b-5">
                                <select class="form-control" name="history_chief_outward_side">
                                <option value="">Please Select</option>
                                <option <?php if($squint_history['history_chief_outward_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                                <option <?php if($squint_history['history_chief_outward_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                                <option <?php if($squint_history['history_chief_outward_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                                </select>  
                            </div>
                            <div class="col-md-2 m-b-5">
                                <select class="form-control" name="history_chief_outward_dur">
                                <option value="">Please Select</option>
                                <?php for($i=1; $i<=40;$i++) { ?>
                                    <option <?php if($squint_history['history_chief_outward_dur']==$i){ echo 'selected';} ?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php } ?>
                                
                                </select>
                            </div>
                            <div class="col-md-3  m-b-5">
                                <select class="form-control" name="history_chief_outward_unit">
                                <option value="">Please Select</option>
                                <option <?php if($squint_history['history_chief_outward_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                                <option <?php if($squint_history['history_chief_outward_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                                <option <?php if($squint_history['history_chief_outward_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                                <option <?php if($squint_history['history_chief_outward_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                                </select>
                            </div>
                            <div class="col-md-3  m-b-5" style="width:9px !important;">
                                <input type="text" placeholder="Comment..." value="<?php echo $squint_history['history_chief_outward_comm'];?>" name="history_chief_outward_comm" style="width: 263px;margin-left:3px;">
                            </div>
                        </div>
                        <div class="row" id="upward1">
                            <div class="col-md-2  m-b-5">
                                <label>Upward/Downward</label>
                            </div>
                            <div class="col-md-2  m-b-5">
                                <select class="form-control" name="history_chief_upward_side">
                                <option value="">Please Select</option>
                                <option <?php if($squint_history['history_chief_upward_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                                <option <?php if($squint_history['history_chief_upward_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                                <option <?php if($squint_history['history_chief_upward_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                                </select>  
                            </div>
                            <div class="col-md-2 m-b-5">
                                <select class="form-control" name="history_chief_upward_dur">
                                <option value="">Please Select</option>
                                <?php for($i=1; $i<=40;$i++) { ?>
                                    <option <?php if($squint_history['history_chief_upward_dur']==$i){ echo 'selected';} ?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php } ?>
                                
                                </select>
                            </div>
                            <div class="col-md-3  m-b-5">
                                <select class="form-control" name="history_chief_upward_unit">
                                <option value="">Please Select</option>
                                <option <?php if($squint_history['history_chief_upward_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                                <option <?php if($squint_history['history_chief_upward_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                                <option <?php if($squint_history['history_chief_upward_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                                <option <?php if($squint_history['history_chief_upward_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                                </select>
                            </div>
                            <div class="col-md-3  m-b-5" style="width:9px !important;">
                                <input type="text" placeholder="Comment..." value="<?php echo $squint_history['history_chief_upward_comm'];?>" name="history_chief_upward_comm" style="width: 263px;margin-left:3px;">
                            </div>
                        </div>
                        <div class="row" id="prev_squint1">
                            <div class="col-md-2  m-b-5">
                                <label>Prev.H/O Squint/Other Surgery</label>
                            </div>
                            <div class="col-md-2  m-b-5">
                                <select class="form-control" name="history_chief_prev_squint_side">
                                <option value="">Please Select</option>
                                <option <?php if($squint_history['history_chief_prev_squint_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                                <option <?php if($squint_history['history_chief_prev_squint_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                                <option <?php if($squint_history['history_chief_prev_squint_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                                </select>  
                            </div>
                            <div class="col-md-2 m-b-5">
                                <select class="form-control" name="history_chief_prev_squint_dur">
                                <option value="">Please Select</option>
                                <?php for($i=1; $i<=40;$i++) { ?>
                                    <option <?php if($squint_history['history_chief_prev_squint_dur']==$i){ echo 'selected';} ?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php } ?>
                                
                                </select>
                            </div>
                            <div class="col-md-3  m-b-5">
                                <select class="form-control" name="history_chief_prev_squint_unit">
                                <option value="">Please Select</option>
                                <option <?php if($squint_history['history_chief_prev_squint_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                                <option <?php if($squint_history['history_chief_prev_squint_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                                <option <?php if($squint_history['history_chief_prev_squint_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                                <option <?php if($squint_history['history_chief_prev_squint_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                                </select>
                            </div>
                            <div class="col-md-3  m-b-5" style="width:9px !important;">
                                <input type="text" placeholder="Comment..." value="<?php echo $squint_history['history_chief_prev_squint_comm'];?>" name="history_chief_prev_squint_comm" style="width: 263px;margin-left:3px;">
                            </div>
                        </div>
                        <div class="row" id="double_vision1">
                            <div class="col-md-2  m-b-5">
                                <label>H/O Double Vision</label>
                            </div>
                            <div class="col-md-2  m-b-5">
                                <select class="form-control" name="history_chief_double_vision_side">
                                <option value="">Please Select</option>
                                <option <?php if($squint_history['history_chief_double_vision_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                                <option <?php if($squint_history['history_chief_double_vision_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                                <option <?php if($squint_history['history_chief_double_vision_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                                </select>  
                            </div>
                            <div class="col-md-2 m-b-5">
                                <select class="form-control" name="history_chief_double_vision_dur">
                                <option value="">Please Select</option>
                                <?php for($i=1; $i<=40;$i++) { ?>
                                    <option <?php if($squint_history['history_chief_double_vision_dur']==$i){ echo 'selected';} ?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php } ?>
                                
                                </select>
                            </div>
                            <div class="col-md-3  m-b-5">
                                <select class="form-control" name="history_chief_double_vision_unit">
                                <option value="">Please Select</option>
                                <option <?php if($squint_history['history_chief_double_vision_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                                <option <?php if($squint_history['history_chief_double_vision_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                                <option <?php if($squint_history['history_chief_double_vision_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                                <option <?php if($squint_history['history_chief_double_vision_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                                </select>
                            </div>
                            <div class="col-md-3  m-b-5" style="width:9px !important;">
                                <input type="text" placeholder="Comment..." value="<?php echo $squint_history['history_chief_double_vision_comm'];?>" name="history_chief_double_vision_comm" style="width: 263px;margin-left:3px;">
                            </div>
                        </div>
                        <div class="row" id="constant1">
                            <div class="col-md-2  m-b-5">
                                <label>Constant/Occassional/Intermittently</label>
                            </div>
                            <div class="col-md-2  m-b-5">
                                <select class="form-control" name="history_chief_constant_side">
                                <option value="">Please Select</option>
                                <option <?php if($squint_history['history_chief_constant_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                                <option <?php if($squint_history['history_chief_constant_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                                <option <?php if($squint_history['history_chief_constant_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                                </select>  
                            </div>
                            <div class="col-md-2 m-b-5">
                                <select class="form-control" name="history_chief_constant_dur">
                                <option value="">Please Select</option>
                                <?php for($i=1; $i<=40;$i++) { ?>
                                    <option <?php if($squint_history['history_chief_constant_dur']==$i){ echo 'selected';} ?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php } ?>
                                
                                </select>
                            </div>
                            <div class="col-md-3  m-b-5">
                                <select class="form-control" name="history_chief_constant_unit">
                                <option value="">Please Select</option>
                                <option <?php if($squint_history['history_chief_constant_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                                <option <?php if($squint_history['history_chief_constant_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                                <option <?php if($squint_history['history_chief_constant_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                                <option <?php if($squint_history['history_chief_constant_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                                </select>
                            </div>
                            <div class="col-md-3  m-b-5" style="width:9px !important;">
                                <input type="text" placeholder="Comment..." value="<?php echo $squint_history['history_chief_constant_comm'];?>" name="history_chief_constant_comm" style="width: 263px;margin-left:3px;">
                            </div>
                        </div>
                        <div class="row" id="antisupression1">
                            <div class="col-md-2  m-b-5">
                                <label>H/O Waering Glasses/Patching Therapy/Antisupression</label>
                            </div>
                            <div class="col-md-2  m-b-5">
                                <select class="form-control" name="history_chief_antisupression_side">
                                <option value="">Please Select</option>
                                <option <?php if($squint_history['history_chief_antisupression_side']=='Left'){ echo 'selected';}?> value="Left">L</option>
                                <option <?php if($squint_history['history_chief_antisupression_side']=='Right'){ echo 'selected';}?> value="Right">R</option>
                                <option <?php if($squint_history['history_chief_antisupression_side']=='Both'){ echo 'selected';}?> value="Both">B/E</option>
                                </select>  
                            </div>
                            <div class="col-md-2 m-b-5">
                                <select class="form-control" name="history_chief_antisupression_dur">
                                <option value="">Please Select</option>
                                <?php for($i=1; $i<=40;$i++) { ?>
                                    <option <?php if($squint_history['history_chief_antisupression_dur']==$i){ echo 'selected';} ?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php } ?>
                                
                                </select>
                            </div>
                            <div class="col-md-3  m-b-5">
                                <select class="form-control" name="history_chief_antisupression_unit">
                                <option value="">Please Select</option>
                                <option <?php if($squint_history['history_chief_antisupression_unit']=='Days'){ echo 'selected';}?> value="Days">Days</option>
                                <option <?php if($squint_history['history_chief_antisupression_unit']=='Weeks'){ echo 'selected';}?> value="Weeks">Weeks</option>
                                <option <?php if($squint_history['history_chief_antisupression_unit']=='Months'){ echo 'selected';}?> value="Months">Months</option>
                                <option <?php if($squint_history['history_chief_antisupression_unit']=='Years'){ echo 'selected';}?> value="Years">Years</option>
                                </select>
                            </div>
                            <div class="col-md-3  m-b-5" style="width:9px !important;">
                                <input type="text" placeholder="Comment..." value="<?php echo $squint_history['history_chief_antisupression_comm'];?>" name="history_chief_antisupression_comm" style="width: 263px;margin-left:3px;">
                            </div>
                        </div>

                    </section>


                <section>
                    <div class="row">
                    <div class="col-md-2">
                        Comments
                    </div>
                    <div class="col-md-10">
                        <textarea class="form-control w-100" name="squint_comm"><?php echo $squint_history['squint_comm'];?></textarea>
                    </div>
                    </div>
                </section>

            
                </div>
                <section style="padding-left:15px;">  
                    <div class="grp">
                        <label>Remarks: </label>
                        <div class="box-right">
                            <input type="text" name="remarks" class="txt_firstCap input-height"
                                id="remarks" value="<?php echo isset($form_data['remarks']) ? htmlspecialchars($form_data['remarks']) : ''; ?>" style="width: 374px;" />
                            <?php echo form_error('remarks'); ?>
                        </div>
                    </div>
                </section>

         </div>
        </section>  

        


        <section>
            <h4>
        <script>
        $(document).ready(function(){

        var presid='<?php echo $pres_id;?>';
        if(presid !='')
        {
            $('#history_vital_temp').change(function() {
            $('#history_vital_temp_update').val('red');
            });
            $('#history_vital_pulse').change(function() {
            $('#history_vital_pulse_update').val('red');
            });
            $('#history_vital_bp').change(function() {
            $('#history_vital_bp_update').val('red');
            }); 
        }

        $('#inward1,#outward1,#upward1,#prev_squint1,#double_vision1,#constant1,#antisupression1,#pains, #blurr, #rednes, #injuries, #waterings, #discharges,#dryness, #itchings, #fbsensation, #dev_squint, #head_strain, #size_shape, #ovs, #sdiv, #doe, #swell, #sen_burn, #glau, #renti_d, #glas, #eye_d, #eye_s, #uvei, #renti_l,#contact_lens_l,#vision_therapy_l,#low_vision_l,#aid_m, #diab, #hyper, #smokt, #alcoh, #cardd, #steri, #drug, #hiva, #cantu, #tuberc, #asthm, #cncds, #hypo, #hyperth, #heptc, #rend, #acid, #onins, #oasbth, #consan, #thyrd, #chewt,#chronic_kidney_disease,#can,#rheumatoid_artheritis,#benign_ruostatic_hyperplasia,#drug_medication_history,#bph,#thyroid, #antimi_agen, #antif_agen, #ant_agen, #nsaids, #eye_drops, #ampici, #amoxi, #ceftr, #ciprof, #clarith, #cotri, #ethamb, #isoni, #metron, #penic, #rifam, #strept, #ketoco, #flucon, #itrac,  #acyclo, #efavir, #enfuv, #nelfin, #nevira, #zidov, #aspirin, #paracet, #ibupro, #diclo, #aceclo, #napro, #alcohol, #latex, #betad, #adhes, #tegad, #transp,  #seaf, #corn, #egg, #milk_p, #pean, #shell, #soy, #lact, #mush, #tropicp, #tropica, #timol, #homide, #brimon, #latan, #travo, #tobra, #moxif, #homat, #piloca, #cyclop, #atropi, #phenyl, #tropicac, #paracain, #ciplox, #sx_ptosis, #sx_lid, #sx_corneal, #sx_cataract, #sx_squint,#sx_pterygium, #sx_dcr,#sx_dct,#sx_patching_therapy,#consanguinity,#glaucoma,#diabetes,#squint,#retinitis_pigmentosa,#congenital_catarac').css('display','none');
        //
            $("#inward").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#inward1").toggle();
            });
            //
            $("#outward").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#outward1").toggle();
            });
            //
            $("#upward").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#upward1").toggle();
            });
            //
            $("#prev_squint").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#prev_squint1").toggle();
            });
            //
            $("#double_vision").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#double_vision1").toggle();
            });
            //
            $("#constant").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#constant1").toggle();
            });
            //
            $("#antisupression").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#antisupression1").toggle();
            });
            //
            $("#pain_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#pains").toggle();
            });
            //
            $("#bdv_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#blurr").toggle();
            });
            //
            $("#redness_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#rednes").toggle();
            });
            //
            $("#injury_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#injuries").toggle();
            });
            //
            $("#water_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#waterings").toggle();
            });
            //
            $("#discharge_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#discharges").toggle();
            });
            //
            $("#dryness_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#dryness").toggle();
            });
            //
            $("#itch_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#itchings").toggle();
            });
            //
            $("#fbd_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#fbsensation").toggle();
            });
            //
            $("#devs_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#dev_squint").toggle();
            });
            //
            $("#heads_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#head_strain").toggle();
            });
            //
            $("#canss_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#size_shape").toggle();
            });
            //
            $("#ovs_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#ovs").toggle();
            });
            //
            $("#sdv_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#sdiv").toggle();
            });
            //
            $("#doe_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#doe").toggle();
            });
            //
            $("#swel_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#swell").toggle();
            });
            //
            $("#burns_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#sen_burn").toggle();
            });
            $("#ptosis_sx").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#sx_ptosis").toggle();
            });
            $("#lid_sx").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#sx_lid").toggle();
            });
            $("#corneal_sx").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#sx_corneal").toggle();
            });
            $("#cataract_sx").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#sx_cataract").toggle();
            });
            $("#squint_sx").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#sx_squint").toggle();
            });
            $("#pterygium_sx").click(function(){
                
            $(this).parent().toggleClass('bg-theme');
            $("#sx_pterygium").toggle();
            });
            $("#dcr_sx").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#sx_dcr").toggle();
            });
            $("#dct_sx").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#sx_dct").toggle();
            });
            $("#patching_therapy").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#sx_patching_therapy").toggle();
            });
            //
            $("#gla_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#glau").toggle();
            });
            //
            $("#reti_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#renti_d").toggle();
            });
            //
            $("#glass_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#glas").toggle();
            });
            //
            $("#eyedi_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#eye_d").toggle();
            });
            //
            $("#eyesu_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#eye_s").toggle();
            });
            //
            $("#uve_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#uvei").toggle();
            });
            //
            $("#retil_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#renti_l").toggle();
            });
            $("#contact_lens_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#contact_lens_l").toggle();
            });
            $("#vision_therapy_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#vision_therapy_l").toggle();
            });
            $("#low_vision_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#low_vision_l").toggle();
            });
            $("#aid_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#aid_l").toggle();
            });
            //
            $("#dia_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#diab").toggle();
            });
            //
            $("#hyper_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#hyper").toggle();
            });
            //
            $("#alcoh_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#alcoh").toggle();
            });
            //
            $("#smok_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#smokt").toggle();
            });
            //
            $("#card_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#cardd").toggle();
            });
            //
            $("#steri_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#steri").toggle();
            });

            //
            $("#drug_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#drug").toggle();
            });//
            $("#hiva_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#hiva").toggle();
            });
            
            //
            $("#cant_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#cantu").toggle();
            });
            //
            $("#tuber_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#tuberc").toggle();
            });
            //
            $("#asth_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#asthm").toggle();
            });
            //
            $("#cnsds_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#cncds").toggle();
            });
            //
            $("#hypo_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#hypo").toggle();
            });
            //
            $("#hyperth_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#hyperth").toggle();
            });
            //
            $("#hepac_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#heptc").toggle();
            });
            //
            $("#renald_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#rend").toggle();
            });
            //
            $("#acid_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#acid").toggle();
            });
            //
            $("#oins_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#onins").toggle();
            });
            //
            $("#oasp_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#oasbth").toggle();
            });
            //
            $("#acon_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#consan").toggle();
            });
            //
            $("#thd_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#thyrd").toggle();
            });
            //
            $("#chewt_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#chewt").toggle();
            });
            $("#chronic_kidney_disease_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#chronic_kidney_disease").toggle();
            });
            $("#can_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#can").toggle();
            });
            $("#rheumatoid_artheritis_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#rheumatoid_artheritis").toggle();
            });
            $("#benign_ruostatic_hyperplasia_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#benign_ruostatic_hyperplasia").toggle();
            });
            $("#drug_medication_history_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#drug_medication_history").toggle();
            });
            $("#bph_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#bph").toggle();
            });
            $("#thyroid_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#thyroid").toggle();
            });

            //
            $("#antimi_agen_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#antimi_agen").toggle();
            });
            //
            $("#antif_agen_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#antif_agen").toggle();
            });
            //
            $("#ant_agen_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#ant_agen").toggle();
            });
            //
            $("#nsaids_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#nsaids").toggle();
            });
            //
            $("#eye_drops_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#eye_drops").toggle();
            });
            //
            $("#ampic_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#ampici").toggle();
            });
            //
            $("#amox_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#amoxi").toggle();
            });
            //
            $("#ceftr_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#ceftr").toggle();
            });
            //
            $("#cipro_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#ciprof").toggle();
            });
            //
            $("#clari_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#clarith").toggle();
            });
            //
            $("#cotri_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#cotri").toggle();
            }); //
            $("#etham_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#ethamb").toggle();
            });
            //
            $("#ison_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#isoni").toggle();
            });
            //
            $("#metro_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#metron").toggle();
            });
            //
            $("#penic_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#penic").toggle();
            });
            //
            $("#rifa_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#rifam").toggle();
            });
            //
            $("#ketoc_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#ketoco").toggle();
            });  
            //
        $("#fluco_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#flucon").toggle();
            });
        //
        $("#itrac_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#itrac").toggle();
            });
            //
            $("#acyclo_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#acyclo").toggle();
            });  
            //
        $("#efavir_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#efavir").toggle();
            });
        //
        $("#enfuv_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#enfuv").toggle();
            });
            //
            $("#nelfin_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#nelfin").toggle();
            });  
            //
        $("#nevira_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#nevira").toggle();
            });
        //
        $("#zidov_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#zidov").toggle();
            });

            //
            $("#aspirin_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#aspirin").toggle();
            });  
            //
        $("#paracet_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#paracet").toggle();
            });
        //
        $("#ibupro_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#ibupro").toggle();
            });
            //
            $("#diclo_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#diclo").toggle();
            });  
            //
        $("#aceclo_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#aceclo").toggle();
            });
        //
        $("#napro_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#napro").toggle();
            });

            //
            $("#strep_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#strept").toggle();
            });
            //
            $("#tropip_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#tropicp").toggle();
            });
            //
            $("#tropi_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#tropica").toggle();
            });
            //
            $("#timolol_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#timol").toggle();
            });
            //
            $("#homide_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#homide").toggle();
            });
            //
            $("#brimo_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#brimon").toggle();
            });
            //
            $("#latan_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#latan").toggle();
            });
            //
            $("#travo_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#travo").toggle();
            });
            //
            $("#tobra_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#tobra").toggle();
            });
            //
            $("#moxif_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#moxif").toggle();
            });
            //
            $("#homat_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#homat").toggle();
            });
            //
            $("#piloc_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#piloca").toggle();
            });
            //
            $("#cyclop_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#cyclop").toggle();
            });
            //
            $("#atrop_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#atropi").toggle();
            });
            //
            $("#phenyl_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#phenyl").toggle();
            });
            //
            $("#tropic_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#tropicac").toggle();
            });
            //
            $("#parac_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#paracain").toggle();
            });
            //
            $("#ciplox_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#ciplox").toggle();
            });

            //
            $("#alco_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#alcohol").toggle();
            });
            //
            $("#latex_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#latex").toggle();
            });
            //
            $("#betad_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#betad").toggle();
            });
            //
            $("#adhes_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#adhes").toggle();
            });
            //
            $("#tegad_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#tegad").toggle();
            });
            //
            $("#trans_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#transp").toggle();
            });

            //
            $("#seaf_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#seaf").toggle();
            });
            //
            $("#corn_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#corn").toggle();
            });
            //
            $("#egg_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#egg").toggle();
            });
            //
            $("#milk_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#milk_p").toggle();
            });
            //
            $("#pean_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#pean").toggle();
            });
            //
            $("#shell_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#shell").toggle();
            });
            //
            $("#soy_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#soy").toggle();
            });
            //
            $("#lact_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#lact").toggle();
            });
            //
            $("#mush_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#mush").toggle();
            });
            //
            $("#history_chief_ovs_glare").click(function(){
            $(this).parent().toggleClass('bg-theme');
            });
            //
            $("#history_chief_ovs_floaters").click(function(){
            $(this).parent().toggleClass('bg-theme');
            });
            //
            $("#history_chief_ovs_photophobia").click(function(){
            $(this).parent().toggleClass('bg-theme');
            });
            //
            $("#history_chief_ovs_color_halos").click(function(){
            $(this).parent().toggleClass('bg-theme');

            });
            
            //
            $("#history_chief_ovs_metamorphopsia").click(function(){
            $(this).parent().toggleClass('bg-theme');
            });
            //
            $("#history_chief_ovs_chromatopsia").click(function(){
            $(this).parent().toggleClass('bg-theme');
            });
            //
            $("#history_chief_ovs_dnv").click(function(){
            $(this).parent().toggleClass('bg-theme');
            });
            //
            $("#history_chief_ovs_ddv").click(function(){
            $(this).parent().toggleClass('bg-theme');

            });
            //
            $("#history_chief_blurr_dist").click(function(){
            $(this).parent().toggleClass('bg-theme');

            });
            //
            $("#history_chief_blurr_near").click(function(){
            $(this).parent().toggleClass('bg-theme');
            });
            //
            $("#history_chief_blurr_pain").click(function(){
            $(this).parent().toggleClass('bg-theme');
            });
            //
            $("#history_chief_blurr_ug").click(function(){
            $(this).parent().toggleClass('bg-theme');
            });
            //
            $("#history_chief_dev_diplopia").click(function(){
            $(this).parent().toggleClass('bg-theme');
            });
            //
            $("#history_chief_dev_truma").click(function(){
            $(this).parent().toggleClass('bg-theme');
            });
            //
            $("#history_chief_dev_ps").click(function(){
            $(this).parent().toggleClass('bg-theme');
            });
            $("#consanguinity_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#consanguinity").toggle();
            });
            //
            $("#glaucoma_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#glaucoma").toggle();
            });
            //
            $("#diabetes_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#diabetes").toggle();
            });
            //
            $("#squint_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#squint").toggle();
            });
            //
            $("#retinitis_pigmentosa_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#retinitis_pigmentosa").toggle();
            });
            //
            //
            $("#congenital_cataract_m").click(function(){
            $(this).parent().toggleClass('bg-theme');
            $("#congenital_catarac").toggle();
            });
            //
            $('.ht_btn').click(function(){
            $('.ht_btn').removeClass('btn-save');
            $(this).addClass('btn-save');
            });
        });

        $(document).ready(function(){
        var inward = '<?php echo $squint_history['inward'];?>';
        var outward = '<?php echo $squint_history['outward'];?>';
        var upward = '<?php echo $squint_history['upward'];?>';
        var prev_squint = '<?php echo $squint_history['prev_squint'];?>';
        var double_vision = '<?php echo $squint_history['double_vision'];?>';
        var constant = '<?php echo $squint_history['constant'];?>';
        var antisupression = '<?php echo $squint_history['antisupression'];?>';
        var pain_m = '<?php echo $chief_complaints['pain_m'];?>';
        var bdv_m = '<?php echo $chief_complaints['bdv_m'];?>';
        var redness_m='<?php echo $chief_complaints['redness_m'];?>';
        var injury_m ='<?php echo $chief_complaints['injury_m'];?>';
        var water_m ='<?php echo $chief_complaints['water_m'];?>';
        var discharge_m ='<?php echo $chief_complaints['discharge_m'];?>';
        var dryness_m ='<?php echo $chief_complaints['dryness_m'];?>';
        var itch_m ='<?php echo $chief_complaints['itch_m'];?>'; 
        var fbd_m = '<?php echo $chief_complaints['fbd_m'];?>'; 
        var devs_m ='<?php echo $chief_complaints['devs_m'];?>'; 
        var heads_m ='<?php echo $chief_complaints['heads_m'];?>'; 
        var canss_m ='<?php echo $chief_complaints['canss_m'];?>'; 
        var ovs_m ='<?php echo $chief_complaints['ovs_m'];?>'; 
        var sdv_m ='<?php echo $chief_complaints['sdv_m'];?>';
        var doe_m ='<?php echo $chief_complaints['doe_m'];?>';
        var swel_m ='<?php echo $chief_complaints['swel_m'];?>'; 
        var burns_m ='<?php echo $chief_complaints['burns_m'];?>'; 
        var ptosis_sx ='<?php echo $chief_complaints['ptosis_sx'];?>'; 
        var lid_sx ='<?php echo $chief_complaints['lid_sx'];?>'; 
        var corneal_sx ='<?php echo $chief_complaints['corneal_sx'];?>'; 
        var cataract_sx ='<?php echo $chief_complaints['cataract_sx'];?>'; 
        var squint_sx ='<?php echo $chief_complaints['squint_sx'];?>'; 
        var pterygium_sx ='<?php echo $chief_complaints['pterygium_sx'];?>'; 
        console.log(pterygium_sx,'==========');
        var dcr_sx ='<?php echo $chief_complaints['dcr'];?>'; 
        var dct_sx ='<?php echo $chief_complaints['dct_sx'];?>'; 
        var patching_therapy ='<?php echo $chief_complaints['patching_therapy'];?>'; 
        var history_chief_blurr_dist ='<?php echo $chief_complaints['history_chief_blurr_dist'];?>';
        var history_chief_blurr_near ='<?php echo $chief_complaints['history_chief_blurr_near'];?>';
        var history_chief_blurr_pain ='<?php echo $chief_complaints['history_chief_blurr_pain'];?>';
        var history_chief_blurr_ug ='<?php echo $chief_complaints['history_chief_blurr_ug'];?>';
        var history_chief_dev_diplopia ='<?php echo $chief_complaints['history_chief_dev_diplopia'];?>';
        var history_chief_dev_truma ='<?php echo $chief_complaints['history_chief_dev_truma'];?>'; 
        var history_chief_dev_ps ='<?php echo $chief_complaints['history_chief_dev_ps'];?>';
        var history_chief_ovs_glare ='<?php echo $chief_complaints['history_chief_ovs_glare'];?>'; 
        var history_chief_ovs_floaters ='<?php echo $chief_complaints['history_chief_ovs_floaters'];?>';
        var history_chief_ovs_photophobia ='<?php echo $chief_complaints['history_chief_ovs_photophobia'];?>';
        var history_chief_ovs_color_halos ='<?php echo $chief_complaints['history_chief_ovs_color_halos'];?>';
        var history_chief_ovs_metamorphopsia='<?php echo $chief_complaints['history_chief_ovs_metamorphopsia'];?>';
        var history_chief_ovs_chromatopsia ='<?php echo $chief_complaints['history_chief_ovs_chromatopsia'];?>';
        var history_chief_ovs_dnv ='<?php echo $chief_complaints['history_chief_ovs_dnv'];?>';
        var history_chief_ovs_ddv ='<?php echo $chief_complaints['history_chief_ovs_ddv'];?>';
        var gla_m = '<?php echo $ophthalmic['gla_m'];?>';
        var reti_m = '<?php echo $ophthalmic['reti_m'];?>';
        var glass_m = '<?php echo $ophthalmic['glass_m'];?>';
        var eyedi_m = '<?php echo $ophthalmic['eyedi_m'];?>';
        var eyesu_m = '<?php echo $ophthalmic['eyesu_m'];?>';
        var uve_m = '<?php echo $ophthalmic['uve_m'];?>';
        var retil_m = '<?php echo $ophthalmic['retil_m'];?>';
        var contact_lens_m = '<?php echo $ophthalmic['contact_lens_m'];?>';
        var vision_therapy_m = '<?php echo $ophthalmic['vision_therapy_m'];?>';
        var low_vision_m = '<?php echo $ophthalmic['low_vision_m'];?>';
        var aid_m = '<?php echo $ophthalmic['aid_m'];?>';
        var dia_m ='<?php echo $systemic['dia_m'];?>';
        var hyper_m ='<?php echo $systemic['hyper_m'];?>';
        var alcoh_m ='<?php echo $systemic['alcoh_m'];?>';
        var smok_m ='<?php echo $systemic['smok_m'];?>';
        var card_m ='<?php echo $systemic['card_m'];?>';
        var steri_m ='<?php echo $systemic['steri_m'];?>';
        var drug_m ='<?php echo $systemic['drug_m'];?>';
        var hiva_m ='<?php echo $systemic['hiva_m'];?>';
        var cant_m ='<?php echo $systemic['cant_m'];?>';
        var tuber_m ='<?php echo $systemic['tuber_m'];?>';
        var asth_m ='<?php echo $systemic['asth_m'];?>';
        var cnsds_m ='<?php echo $systemic['cnsds_m'];?>';
        var hypo_m ='<?php echo $systemic['hypo_m'];?>';
        var hyperth_m ='<?php echo $systemic['hyperth_m'];?>';
        var hepac_m ='<?php echo $systemic['hepac_m'];?>';
        var renald_m ='<?php echo $systemic['renald_m'];?>';
        var acid_m ='<?php echo $systemic['acid_m'];?>';
        var oins_m ='<?php echo $systemic['oins_m'];?>';
        var oasp_m ='<?php echo $systemic['oasp_m'];?>';
        var acon_m ='<?php echo $systemic['acon_m'];?>';
        var thd_m ='<?php echo $systemic['thd_m'];?>';
        var chewt_m ='<?php echo $systemic['chewt_m'];?>';
        var chronic_kidney_disease_m ='<?php echo $systemic['chronic_kidney_disease_m'];?>';
        var can_m ='<?php echo $systemic['can_m'];?>';
        var rheumatoid_artheritis_m ='<?php echo $systemic['rheumatoid_artheritis_m'];?>';
        var benign_ruostatic_hyperplasia_m ='<?php echo $systemic['benign_ruostatic_hyperplasia_m'];?>';
        var drug_medication_history_m ='<?php echo $systemic['drug_medication_history_m'];?>';
        var bph_m ='<?php echo $systemic['bph_m'];?>';
        var thyroid_m ='<?php echo $systemic['thyroid_m'];?>';
        var antimi_agen_m ='<?php echo $drug_allergies['antimi_agen_m'];?>';
        var antif_agen_m ='<?php echo $drug_allergies['antif_agen_m'];?>';
        var ant_agen_m ='<?php echo $drug_allergies['ant_agen_m'];?>';
        var nsaids_m ='<?php echo $drug_allergies['nsaids_m'];?>';
        var eye_drops_m ='<?php echo $drug_allergies['eye_drops_m'];?>';
        var ampic_m ='<?php echo $drug_allergies['ampic_m'];?>';
        var amox_m ='<?php echo $drug_allergies['amox_m'];?>'; 
        var ceftr_m ='<?php echo $drug_allergies['ceftr_m'];?>';
        var cipro_m ='<?php echo $drug_allergies['cipro_m'];?>';
        var clari_m ='<?php echo $drug_allergies['clari_m'];?>';
        var cotri_m ='<?php echo $drug_allergies['cotri_m'];?>';
        var etham_m ='<?php echo $drug_allergies['etham_m'];?>';
        var ison_m ='<?php echo $drug_allergies['ison_m'];?>'; 
        var metro_m ='<?php echo $drug_allergies['metro_m'];?>';
        var penic_m ='<?php echo $drug_allergies['penic_m'];?>';
        var rifa_m ='<?php echo $drug_allergies['rifa_m'];?>'; 
        var strep_m ='<?php echo $drug_allergies['strep_m'];?>';
        var ketoc_m ='<?php echo $drug_allergies['ketoc_m'];?>'; 
        var fluco_m ='<?php echo $drug_allergies['fluco_m'];?>'; 
        var itrac_m ='<?php echo $drug_allergies['itrac_m'];?>'; 
        var acyclo_m ='<?php echo $drug_allergies['acyclo_m']; ?>';
        var efavir_m ='<?php echo $drug_allergies['efavir_m'];?>'; 
        var enfuv_m ='<?php echo $drug_allergies['enfuv_m'];?>'; 
        var nelfin_m ='<?php echo $drug_allergies['nelfin_m'];?>'; 
        var nevira_m ='<?php echo $drug_allergies['nevira_m'];?>'; 
        var zidov_m ='<?php echo $drug_allergies['zidov_m'];?>'; 
        var aspirin_m ='<?php echo $drug_allergies['aspirin_m'];?>';
        var paracet_m ='<?php echo $drug_allergies['paracet_m'];?>';
        var ibupro_m ='<?php echo $drug_allergies['ibupro_m'];?>'; 
        var diclo_m ='<?php echo $drug_allergies['diclo_m'];?>'; 
        var aceclo_m ='<?php echo $drug_allergies['aceclo_m'];?>'; 
        var napro_m ='<?php echo $drug_allergies['napro_m'];?>'; 
        var tropip_m ='<?php echo $drug_allergies['tropip_m'];?>'; 
        var tropi_m ='<?php echo $drug_allergies['tropi_m'];?>'; 
        var timolol_m ='<?php echo $drug_allergies['timolol_m'];?>';
        var homide_m ='<?php echo $drug_allergies['homide_m'];?>'; 
        var brimo_m ='<?php echo $drug_allergies['brimo_m'];?>'; 
        var latan_m ='<?php echo $drug_allergies['latan_m'];?>'; 
        var travo_m ='<?php echo $drug_allergies['travo_m'];?>'; 
        var tobra_m ='<?php echo $drug_allergies['tobra_m'];?>'; 
        var moxif_m ='<?php echo $drug_allergies['moxif_m'];?>'; 
        var homat_m ='<?php echo $drug_allergies['homat_m'];?>'; 
        var piloc_m ='<?php echo $drug_allergies['piloc_m'];?>'; 
        var cyclop_m ='<?php echo $drug_allergies['cyclop_m'];?>'; 
        var atrop_m ='<?php echo $drug_allergies['atrop_m'];?>'; 
        var phenyl_m ='<?php echo $drug_allergies['phenyl_m'];?>'; 
        var tropic_m ='<?php echo $drug_allergies['tropic_m'];?>'; 
        var parac_m ='<?php echo $drug_allergies['parac_m'];?>'; 
        var ciplox_m ='<?php echo $drug_allergies['ciplox_m'];?>'; 
        var alco_m ='<?php echo $contact_allergies['alco_m'];?>';
        var latex_m ='<?php echo $contact_allergies['latex_m'];?>';
        var betad_m ='<?php echo $contact_allergies['betad_m'];?>';
        var adhes_m ='<?php echo $contact_allergies['adhes_m'];?>';
        var tegad_m ='<?php echo $contact_allergies['tegad_m'];?>';
        var trans_m ='<?php echo $contact_allergies['trans_m'];?>';
        var seaf_m='<?php echo $food_allergies['seaf_m']; ?>';
        var corn_m='<?php echo $food_allergies['corn_m']; ?>';
        var egg_m='<?php echo $food_allergies['egg_m']; ?>'; 
        var milk_m='<?php echo $food_allergies['milk_m']; ?>';
        var pean_m='<?php echo $food_allergies['pean_m']; ?>';
        var shell_m='<?php echo $food_allergies['shell_m'];?>';
        var soy_m='<?php echo $food_allergies['soy_m']; ?>'; 
        var lact_m='<?php echo $food_allergies['lact_m']; ?>';
        var mush_m='<?php echo $food_allergies['mush_m']; ?>';
        var consanguinity_m='<?php echo $family_history['consanguinity_m']; ?>';
        var glaucoma_m='<?php echo $family_history['glaucoma_m']; ?>';
        var diabetes_m='<?php echo $family_history['diabetes_m'];?>';
        var squint_m='<?php echo $family_history['squint_m']; ?>'; 
        var retinitis_pigmentosa_m='<?php echo $family_history['retinitis_pigmentosa_m']; ?>';
        var congenital_cataract_m='<?php echo $family_history['congenital_cataract_m']; ?>';
        var special_status='<?php echo $history_radios_data['special_status']; ?>';
        var general_checkup='<?php echo $history_radios_data['general_checkup']; ?>';

            if (inward == 1) {
                $('#inward').parent().toggleClass('bg-theme');
                $("#inward1").toggle();
            }

            if (outward == 1) {
                $('#outward').parent().toggleClass('bg-theme');
                $("#outward1").toggle();
            }

            if (upward == 1) {
                $('#upward').parent().toggleClass('bg-theme');
                $("#upward1").toggle();
            }

            if (prev_squint == 1) {
                $('#prev_squint').parent().toggleClass('bg-theme');
                $("#prev_squint1").toggle();
            }

            if (double_vision == 1) {
                $('#double_vision').parent().toggleClass('bg-theme');
                $("#double_vision1").toggle();
            }

            if (constant == 1) {
                $('#constant').parent().toggleClass('bg-theme');
                $("#constant1").toggle();
            }

            if (antisupression == 1) {
                $('#antisupression').parent().toggleClass('bg-theme');
                $("#antisupression1").toggle();
            }
            //
            if(pain_m==1){
            $('#pain_m').parent().toggleClass('bg-theme');
            $("#pains").toggle();
            }
            //
            if(bdv_m==1){
            $('#bdv_m').parent().toggleClass('bg-theme');
            $("#blurr").toggle();
            }
            //
            if(redness_m==1){
            $('#redness_m').parent().toggleClass('bg-theme');
            $("#rednes").toggle();
            }
            //
            if(injury_m==1){
            $('#injury_m').parent().toggleClass('bg-theme');
            $("#injuries").toggle();
            }
            //
            if(water_m==1){
            $('#water_m').parent().toggleClass('bg-theme');
            $("#waterings").toggle();
            }
            //
            if(discharge_m==1){
            $('#discharge_m').parent().toggleClass('bg-theme');
            $("#discharges").toggle();
            }
            //
            if(dryness_m==1){
            $('#dryness_m').parent().toggleClass('bg-theme');
            $("#dryness").toggle();
            }
            //
            if(itch_m==1){
            $('#itch_m').parent().toggleClass('bg-theme');
            $("#itchings").toggle();
            }
            //
            if(fbd_m==1){
            $('#fbd_m').parent().toggleClass('bg-theme');
            $("#fbsensation").toggle();
            }
            //
            if(devs_m==1){
            $('#devs_m').parent().toggleClass('bg-theme');
            $("#dev_squint").toggle();
            }
            //
            if(heads_m==1){
            $('#heads_m').parent().toggleClass('bg-theme');
            $("#head_strain").toggle();
            }
            //
            if(canss_m==1){
            $('#canss_m').parent().toggleClass('bg-theme');
            $("#size_shape").toggle();
            }
            //
            if(ovs_m==1){
            $('#ovs_m').parent().toggleClass('bg-theme');
            $("#ovs").toggle();
            }
            //
            if(sdv_m==1){
            $('#sdv_m').parent().toggleClass('bg-theme');
            $("#sdiv").toggle();
            }
            //
            if(doe_m==1){
            $('#doe_m').parent().toggleClass('bg-theme');
            $("#doe").toggle();
            }
            //
            if(swel_m==1){
            $('#swel_m').parent().toggleClass('bg-theme');
            $("#swell").toggle();
            }
            //
            if(burns_m==1){
            $('#burns_m').parent().toggleClass('bg-theme');
            $("#sen_burn").toggle();
            }
            if(ptosis_sx==1){
            $('#ptosis_sx').parent().toggleClass('bg-theme');
            $("#sx_ptosis").toggle();
            }
            if(lid_sx==1){
            $('#lid_sx').parent().toggleClass('bg-theme');
            $("#sx_lid").toggle();
            }
            if(corneal_sx==1){
            $('#corneal_sx').parent().toggleClass('bg-theme');
            $("#sx_corneal").toggle();
            }
            if(cataract_sx==1){
            $('#cataract_sx').parent().toggleClass('bg-theme');
            $("#sx_cataract").toggle();
            }
            if(squint_sx==1){
            $('#squint_sx').parent().toggleClass('bg-theme');
            $("#sx_squint").toggle();
            }
            if(pterygium_sx==1){
            $('#spterygium_sx').parent().toggleClass('bg-theme');
            $("#sx_pterygium").toggle();
            }
            if(dcr_sx==1){
            $('#dcr_sx').parent().toggleClass('bg-theme');
            $("#sx_dcr").toggle();
            }
            if(dct_sx==1){
            $('#dct_sx').parent().toggleClass('bg-theme');
            $("#sx_dct").toggle();
            }
            if(patching_therapy==1){
            $('#patching_therapy_sx').parent().toggleClass('bg-theme');
            $("#sx_patching_therapy").toggle();
            }
            //
            if(gla_m==1){
            $('#gla_m').parent().toggleClass('bg-theme');
            $("#glau").toggle();
            }
            //
            if(reti_m==1){
            $('#reti_m').parent().toggleClass('bg-theme');
            $("#renti_d").toggle();
            }
            //
            if(glass_m==1){
            $('#glass_m').parent().toggleClass('bg-theme');
            $("#glas").toggle();
            }
            //
            if(eyedi_m==1){
            $('#eyedi_m').parent().toggleClass('bg-theme');
            $("#eye_d").toggle();
            }
            //
            if(eyesu_m==1){
            $('#eyesu_m').parent().toggleClass('bg-theme');
            $("#eye_s").toggle();
            }
            //
            if(uve_m==1){
            $('#uve_m').parent().toggleClass('bg-theme');
            $("#uvei").toggle();
            }
            //
            if(retil_m==1){
            $('#retil_m').parent().toggleClass('bg-theme');
            $("#renti_l").toggle();
            }
            if(contact_lens_m==1){
            $('#contact_lens_m').parent().toggleClass('bg-theme');
            $("#contact_lens_l").toggle();
            }
            if(vision_therapy_m==1){
            $('#vision_therapy_m').parent().toggleClass('bg-theme');
            $("#vision_therapy_l").toggle();
            }
            if(low_vision_m==1){
            $('#low_vision_m').parent().toggleClass('bg-theme');
            $("#low_vision_m_l").toggle();
            }
            if(aid_m==1){
            $('#aid_m').parent().toggleClass('bg-theme');
            $("#aid_l").toggle();
            }
            //
            if(dia_m==1){
            $('#dia_m').parent().toggleClass('bg-theme');
            $("#diab").toggle();
            }
            //
            if(hyper_m==1){
            $('#hyper_m').parent().toggleClass('bg-theme');
            $("#hyper").toggle();
            }
            //
            if(alcoh_m==1){
            $('#alcoh_m').parent().toggleClass('bg-theme');
            $("#alcoh").toggle();
            }
            //
            if(smok_m==1){
            $('#smok_m').parent().toggleClass('bg-theme');
            $("#smokt").toggle();
            }
            //
            if(card_m==1){
            $('#card_m').parent().toggleClass('bg-theme');
            $("#cardd").toggle();
            }
            //
            if(steri_m==1){
            $('#steri_m').parent().toggleClass('bg-theme');
            $("#steri").toggle();
            }
            
            //
            if(consanguinity_m==1){
            $('#consanguinity_m').parent().toggleClass('bg-theme');
            $("#consanguinity").toggle();
            }
            //
            if(glaucoma_m==1){
            $('#glaucoma_m').parent().toggleClass('bg-theme');
            $("#glaucoma").toggle();
            }
            //
            if(diabetes_m==1){
            $('#diabetes_m').parent().toggleClass('bg-theme');
            $("#diabetes").toggle();
            }
            //
            if(squint_m==1){
            $('#squint_m').parent().toggleClass('bg-theme');
            $("#squint").toggle();
            }
            //
            if(retinitis_pigmentosa_m==1){
            $('#retinitis_pigmentosa_m').parent().toggleClass('bg-theme');
            $("#retinitis_pigmentosa").toggle();
            }
            //
            if(congenital_cataract_m==1){
            $('#congenital_cataract_m').parent().toggleClass('bg-theme');
            $("#congenital_cataract").toggle();
            }

            //
            if(drug_m==1){
            $('#drug_m').parent().toggleClass('bg-theme');
            $("#drug").toggle();
            }//
            if(hiva_m==1){
            $('#hiva_m').parent().toggleClass('bg-theme');
            $("#hiva").toggle();
            }
            
            //
            if(cant_m==1){
            $('#cant_m').parent().toggleClass('bg-theme');
            $("#cantu").toggle();
            }
            //
            if(tuber_m==1){
            $('#tuber_m').parent().toggleClass('bg-theme');
            $("#tuberc").toggle();
            }
            //
            if(asth_m==1){
            $('#asth_m').parent().toggleClass('bg-theme');
            $("#asthm").toggle();
            }
            //
            if(cnsds_m==1){
            $('#cnsds_m').parent().toggleClass('bg-theme');
            $("#cncds").toggle();
            }
            //
            if(hypo_m==1){
            $('#hypo_m').parent().toggleClass('bg-theme');
            $("#hypo").toggle();
            }
            //
            if(hyperth_m==1){
            $('#hyperth_m').parent().toggleClass('bg-theme');
            $("#hyperth").toggle();
            }
            //
            if(hepac_m==1){
            $('#hepac_m').parent().toggleClass('bg-theme');
            $("#heptc").toggle();
            }
            //
            if(renald_m==1){
            $('#renald_m').parent().toggleClass('bg-theme');
            $("#rend").toggle();
            }
            //
            if(acid_m==1){
            $('#acid_m').parent().toggleClass('bg-theme');
            $("#acid").toggle();
            }
            //
            if(oins_m==1){
            $('#oins_m').parent().toggleClass('bg-theme');
            $("#onins").toggle();
            }
            //
            if(oasp_m==1){
            $('#oasp_m').parent().toggleClass('bg-theme');
            $("#oasbth").toggle();
            }
            //
            if(acon_m==1){
            $('#acon_m').parent().toggleClass('bg-theme');
            $("#consan").toggle();
            }
            //
            if(thd_m==1){
            $('#thd_m').parent().toggleClass('bg-theme');
            $("#thyrd").toggle();
            }
            //
            if(chewt_m==1){
            $('#chewt_m').parent().toggleClass('bg-theme');
            $("#chewt").toggle();
            }
            if(chronic_kidney_disease_m ==1){
            $('#chronic_kidney_disease_m').parent().toggleClass('bg-theme');
            $("#chronic_kidney_disease").toggle();
            }
            if(can_m ==1){
            $('#can_m').parent().toggleClass('bg-theme');
            $("#can").toggle();
            }
            if(rheumatoid_artheritis_m ==1){
            $('#rheumatoid_artheritis_m').parent().toggleClass('bg-theme');
            $("#rheumatoid_artheritis").toggle();
            }
            if(benign_ruostatic_hyperplasia_m ==1){
            $('#benign_ruostatic_hyperplasia_m').parent().toggleClass('bg-theme');
            $("#benign_ruostatic_hyperplasia").toggle();
            }
            if(drug_medication_history_m ==1){
            $('#drug_medication_history_m').parent().toggleClass('bg-theme');
            $("#drug_medication_history").toggle();
            }
            if(bph_m ==1){
            $('#bph_m').parent().toggleClass('bg-theme');
            $("#bph").toggle();
            }
            if(thyroid_m ==1){
            $('#thyroid_m').parent().toggleClass('bg-theme');
            $("#thyroid").toggle();
            }

            //
            if(antimi_agen_m==1){
            $('#antimi_agen_m').parent().toggleClass('bg-theme');
            $("#antimi_agen").toggle();
            }
            //
            if(antif_agen_m==1){
            $('#antif_agen_m').parent().toggleClass('bg-theme');
            $("#antif_agen").toggle();
            }
            //
            if(ant_agen_m==1){
            $('#ant_agen_m').parent().toggleClass('bg-theme');
            $("#ant_agen").toggle();
            }
            //
            if(nsaids_m==1){
            $('#nsaids_m').parent().toggleClass('bg-theme');
            $("#nsaids").toggle();
            }
            //
            if(eye_drops_m==1){
            $('#eye_drops_m').parent().toggleClass('bg-theme');
            $("#eye_drops").toggle();
            }
            //
            if(ampic_m==1){
            $('#ampic_m').parent().toggleClass('bg-theme');
            $("#ampici").toggle();
            }
            //
            if(amox_m==1){
            $('#amox_m').parent().toggleClass('bg-theme');
            $("#amoxi").toggle();
            }
            //
            if(ceftr_m==1){
            $('#ceftr_m').parent().toggleClass('bg-theme');
            $("#ceftr").toggle();
            }
            //
            if(cipro_m==1){
            $('#cipro_m').parent().toggleClass('bg-theme');
            $("#ciprof").toggle();
            }
            //
            if(clari_m==1){
            $('#clari_m').parent().toggleClass('bg-theme');
            $("#clarith").toggle();
            }
            //
            if(cotri_m==1){
            $('#cotri_m').parent().toggleClass('bg-theme');
            $("#cotri").toggle();
            } //
            if(etham_m==1){
            $('#etham_m').parent().toggleClass('bg-theme');
            $('#ethamb').toggle();
            }
            //
            if(ison_m==1){
            $('#ison_m').parent().toggleClass('bg-theme');
            $("#isoni").toggle();
            }
            //
            if(metro_m==1){
            $('#metro_m').parent().toggleClass('bg-theme');
            $("#metron").toggle();
            }
            //
            if(penic_m==1){
            $('#penic_m').parent().toggleClass('bg-theme');
            $("#penic").toggle();
            }
            //
            if(rifa_m==1){
            $('#rifa_m').parent().toggleClass('bg-theme');
            $("#rifam").toggle();
            }
            //
            if(strep_m==1){
            $('#strep_m').parent().toggleClass('bg-theme');
            $("#strept").toggle();
            }  
            //
        if(ketoc_m==1){
            $('#ketoc_m').parent().toggleClass('bg-theme');
            $("#ketoco").toggle();
            }
        //
        if(fluco_m==1){
            $('#fluco_m').parent().toggleClass('bg-theme');
            $("#flucon").toggle();
            }
            //
            if(itrac_m==1){
            $('#itrac_m').parent().toggleClass('bg-theme');
            $("#itrac").toggle();
            }  
            //
        if(acyclo_m==1){
            $('#acyclo_m').parent().toggleClass('bg-theme');
            $("#acyclo").toggle();
            }
        //
        if(efavir_m==1){
            $('#efavir_m').parent().toggleClass('bg-theme');
            $("#efavir").toggle();
            }
            //
            if(enfuv_m==1){
            $('#enfuv_m').parent().toggleClass('bg-theme');
            $("#enfuv").toggle();
            }  
            //
        if(nelfin_m==1){
            $('#nelfin_m').parent().toggleClass('bg-theme');
            $("#nelfin").toggle();
            }
        //
        if(nevira_m==1){
            $('#nevira_m').parent().toggleClass('bg-theme');
            $("#nevira").toggle();
            }

            //
            if(zidov_m==1){
            $('#zidov_m').parent().toggleClass('bg-theme');
            $("#zidov").toggle();
            }  
            //
        if(aspirin_m==1){
            $('#aspirin_m').parent().toggleClass('bg-theme');
            $("#aspirin").toggle();
            }
        //
        if(paracet_m==1){
            $('#paracet_m').parent().toggleClass('bg-theme');
            $("#paracet").toggle();
            }
            //
            if(ibupro_m==1){
            $('#ibupro_m').parent().toggleClass('bg-theme');
            $("#ibupro").toggle();
            }  
            //
        if(diclo_m==1){
            $('#diclo_m').parent().toggleClass('bg-theme');
            $("#diclo").toggle();
            }
        //
        if(aceclo_m==1){
            $('#aceclo_m').parent().toggleClass('bg-theme');
            $("#aceclo").toggle();
            }

            //
            if(napro_m==1){
            $('#napro_m').parent().toggleClass('bg-theme');
            $("#napro").toggle();
            }
            //
            if(tropip_m==1){
            $('#tropip_m').parent().toggleClass('bg-theme');
            $("#tropicp").toggle();
            }
            //
            if(tropi_m==1){
            $('#tropi_m').parent().toggleClass('bg-theme');
            $("#tropica").toggle();
            }
            //
            if(timolol_m==1){
            $('#timolol_m').parent().toggleClass('bg-theme');
            $("#timol").toggle();
            }
            //
            if(homide_m==1){
            $('#homide_m').parent().toggleClass('bg-theme');
            $("#homide").toggle();
            }
            //
            if(brimo_m==1){
            $('#brimo_m').parent().toggleClass('bg-theme');
            $("#brimon").toggle();
            }
            //
            if(latan_m==1){
            $('#latan_m').parent().toggleClass('bg-theme');
            $("#latan").toggle();
            }
            //
            if(travo_m==1){
            $('#travo_m').parent().toggleClass('bg-theme');
            $("#travo").toggle();
            }
            //
            if(tobra_m==1){
            $('#tobra_m').parent().toggleClass('bg-theme');
            $("#tobra").toggle();
            }
            //
            if(moxif_m==1){
            $('#moxif_m').parent().toggleClass('bg-theme');
            $("#moxif").toggle();
            }
            //
            if(homat_m==1){
            $('#homat_m').parent().toggleClass('bg-theme');
            $("#homat").toggle();
            }
            //
            if(piloc_m==1){
            $('#piloc_m').parent().toggleClass('bg-theme');
            $("#piloca").toggle();
            }
            //
            if(cyclop_m==1){
            $('#cyclop_m').parent().toggleClass('bg-theme');
            $("#cyclop").toggle();
            }
            //
            if(atrop_m==1){
            $('#atrop_m').parent().toggleClass('bg-theme');
            $("#atropi").toggle();
            }
            //
            if(phenyl_m==1){
            $('#phenyl_m').parent().toggleClass('bg-theme');
            $("#phenyl").toggle();
            }
            //
            if(tropic_m==1){
            $('#tropic_m').parent().toggleClass('bg-theme');
            $("#tropicac").toggle();
            }
            //
            if(parac_m==1){
            $('#parac_m').parent().toggleClass('bg-theme');
            $("#paracain").toggle();
            }
            //
            if(ciplox_m==1){
            $('#ciplox_m').parent().toggleClass('bg-theme');
            $("#ciplox").toggle();
            }

            //
            if(alco_m==1){
            $('#alco_m').parent().toggleClass('bg-theme');
            $("#alcohol").toggle();
            }
            //
            if(latex_m==1){
            $('#latex_m').parent().toggleClass('bg-theme');
            $("#latex").toggle();
            }
            //
            if(betad_m==1){
            $('#betad_m').parent().toggleClass('bg-theme');
            $("#betad").toggle();
            }
            //
            if(adhes_m==1){
            $('#adhes_m').parent().toggleClass('bg-theme');
            $("#adhes").toggle();
            }
            //
            if(tegad_m==1){
            $('#tegad_m').parent().toggleClass('bg-theme');
            $("#tegad").toggle();
            }
            //
            if(trans_m==1){
            $('#trans_m').parent().toggleClass('bg-theme');
            $("#transp").toggle();
            }

            //
            if(seaf_m==1){
            $('#seaf_m').parent().toggleClass('bg-theme');
            $("#seaf").toggle();
            }
            //
            if(corn_m==1){
            $('#corn_m').parent().toggleClass('bg-theme');
            $("#corn").toggle();
            }
            //
            if(egg_m==1){
            $('#egg_m').parent().toggleClass('bg-theme');
            $("#egg").toggle();
            }
            //
            if(milk_m==1){
            $('#milk_m').parent().toggleClass('bg-theme');
            $("#milk_p").toggle();
            }
            //
            if(pean_m==1){
            $('#pean_m').parent().toggleClass('bg-theme');
            $("#pean").toggle();
            }
            //
            if(shell_m==1){
            $('#shell_m').parent().toggleClass('bg-theme');
            $("#shell").toggle();
            }
            //
            if(soy_m==1){
            $('#soy_m').parent().toggleClass('bg-theme');
            $("#soy").toggle();
            }
            //
            if(lact_m==1){
            $('#lact_m').parent().toggleClass('bg-theme');
            $("#lact").toggle();
            }
            //
            if(mush_m==1){
            $('#mush_m').parent().toggleClass('bg-theme');
            $("#mush").toggle();
            }
            //
            if(history_chief_ovs_glare==1){
            $('#history_chief_ovs_glare').parent().toggleClass('bg-theme');
            }
            //
            if(history_chief_ovs_floaters==1){
            $('#history_chief_ovs_floaters').parent().toggleClass('bg-theme');
            }
            //
            if(history_chief_ovs_photophobia==1){
            $('#history_chief_ovs_photophobia').parent().toggleClass('bg-theme');
            }
            //
            if(history_chief_ovs_color_halos==1){
            $('#history_chief_ovs_color_halos').parent().toggleClass('bg-theme');   
            }
            //
            if(history_chief_ovs_metamorphopsia==1){
            $('#history_chief_ovs_metamorphopsia').parent().toggleClass('bg-theme');
            }
            //
            if(history_chief_ovs_chromatopsia==1){
            $('#history_chief_ovs_chromatopsia').parent().toggleClass('bg-theme');
            }
            //
            if(history_chief_ovs_dnv==1){
            $('#history_chief_ovs_dnv').parent().toggleClass('bg-theme');
            }
            //
            if(history_chief_ovs_ddv==1){
            $('#history_chief_ovs_ddv').parent().toggleClass('bg-theme');    
            }
            //
            if(history_chief_blurr_dist==1){
            $('#history_chief_blurr_dist').parent().toggleClass('bg-theme');
            }

            //
            if(history_chief_blurr_near==1){
            $('#history_chief_blurr_near').parent().toggleClass('bg-theme');
            }
            //
            if(history_chief_blurr_pain==1){
            $('#history_chief_blurr_pain').parent().toggleClass('bg-theme');
            }
            //
            if(history_chief_blurr_ug==1){
            $('#history_chief_blurr_ug').parent().toggleClass('bg-theme');
            }
            //
            if(history_chief_dev_diplopia==1){
            $('#history_chief_dev_diplopia').parent().toggleClass('bg-theme');
            }
            //
            if(history_chief_dev_truma==1){
            $('#history_chief_dev_truma').parent().toggleClass('bg-theme');
            }
            //
            if(history_chief_dev_ps==1){
            $('#history_chief_dev_ps').parent().toggleClass('bg-theme');
            }
            //
            if(general_checkup==1){
            $('#general_checkup').parent().addClass('btn-save');
            $('#clear_checkuptype').show();
            }
            else if(general_checkup==2)
            {
            $('#routine_checkup').parent().addClass('btn-save');
            $('#clear_checkuptype').show();
            }
            else if(general_checkup==3)
            {
            $('#postop_checkup').parent().addClass('btn-save');
            $('#clear_checkuptype').show();
            }
            if(special_status==1)
            {
            $('#special_status_brestf').parent().addClass('btn-save');
            $('#clear_special_status').show();
            }
            else if(special_status==2)
            {
            $('#special_status_preg').parent().addClass('btn-save');    
            $('#clear_special_status').show();  
            }
        });



        function myFunction() 
        {
            var weight= $('#weight').val();
            var height= $('#height').val();   
            var newheight= height/100;
            if(weight!='' && newheight!='')
            {
            var bmi=parseFloat(weight/(newheight*newheight)).toFixed(2);
            }
            else
            {
            var bmi='';
            }
            $('#bmi_calculate').val(bmi);

        }

        $('.checkups').click(function(){
            $('#clear_checkuptype').show();
        });

        function clear_checkups()
        {
            $('.checkups').prop('checked', false);
            $('.checkups').parent().removeClass('btn-save');
            $('#clear_checkuptype').hide();
        }

        $('.special_status').click(function(){
            $('#clear_special_status').show();
        });
        function clear_special_status()
        {
            $('.special_status').prop('checked', false);
            $('.special_status').parent().removeClass('btn-save');
            $('#clear_special_status').hide();
        }

        function glaucoma()
        {
            $('#history_ophthalmic_glau_r_dur').val($('#history_ophthalmic_glau_l_dur').val());
            $('#history_ophthalmic_glau_r_unit').val($('#history_ophthalmic_glau_l_unit').val());
        }
        function retinal_detachment()
        {
            $('#history_ophthalmic_renti_d_r_dur').val($('#history_ophthalmic_renti_d_l_dur').val());
            $('#history_ophthalmic_renti_d_r_unit').val($('#history_ophthalmic_renti_d_l_unit').val());
        }
        function glassess()
        {
            $('#history_ophthalmic_glas_r_dur').val($('#history_ophthalmic_glas_l_dur').val());
            $('#history_ophthalmic_glas_r_unit').val($('#history_ophthalmic_glas_l_unit').val());
        }
        function eye_disease()
        {
            $('#history_ophthalmic_eye_d_r_dur').val($('#history_ophthalmic_eye_d_l_dur').val());
            $('#history_ophthalmic_eye_d_r_unit').val($('#history_ophthalmic_eye_d_l_unit').val());
        }

        function eye_surgery()
        {
            $('#history_ophthalmic_eye_s_r_dur').val($('#history_ophthalmic_eye_s_l_dur').val());
            $('#history_ophthalmic_eye_s_r_unit').val($('#history_ophthalmic_eye_s_l_unit').val());
        }
        function uveitis()
        {
            $('#history_ophthalmic_uvei_r_dur').val($('#history_ophthalmic_uvei_l_dur').val());
            $('#history_ophthalmic_uvei_r_unit').val($('#history_ophthalmic_uvei_l_unit').val());
        }
        function retinal_laser()
        {
            $('#history_ophthalmic_renti_l_r_dur').val($('#history_ophthalmic_renti_l_l_dur').val());
            $('#history_ophthalmic_renti_l_r_unit').val($('#history_ophthalmic_renti_l_l_unit').val());
        }
        function contact_lens()
        {
            $('#history_ophthalmic_contact_lens_l_r_dur').val($('#history_ophthalmic_contact_lens_l_l_dur').val());
            $('#history_ophthalmic_contact_lens_l_r_unit').val($('#history_ophthalmic_contact_lens_l_l_unit').val());
        }
        function vision_therapy()
        {
            $('#history_ophthalmic_vision_therapy_l_r_dur').val($('#history_ophthalmic_vision_therapy_l_l_dur').val());
            $('#history_ophthalmic_vision_therapy_l_r_unit').val($('#history_ophthalmic_vision_therapy_l_l_unit').val());
        }
        function low_vision()
        {
            $('#history_ophthalmic_low_vision_l_r_dur').val($('#history_ophthalmic_vision_therapy_l_l_dur').val());
            $('#history_ophthalmic_low_vision_l_r_unit').val($('#history_ophthalmic_low_vision_l_l_unit').val());
        }
        function aid()
        {
            $('#history_ophthalmic_aid_l_r_dur').val($('#history_ophthalmic_aid_l_l_dur').val());
            $('#history_ophthalmic_aid_l_r_unit').val($('#history_ophthalmic_aid_l_l_unit').val());
        }
        </script>













           
       

            <div class="grp">
                <label></label>
                <div class="box-right">
                    <button class="btn-update" id="form_submit">
                        <i class="fa fa-save"></i> Save</button>
                    <a href="<?php echo base_url('oct_hfa'); ?>" class="btn-update"
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
            var url = isEditMode ? '<?php echo base_url('oct_hfa/edit/'); ?>' + id : '<?php echo base_url('oct_hfa/add'); ?>';
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
                    window.location.href = '<?php echo base_url('oct_hfa'); ?>'; // Adjust this URL as necessary
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