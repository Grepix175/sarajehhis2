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

        input[type=text], .form-control{width:100% !important;height:25px;background:#f8f8f8;font-size:13px;padding:2px;}
        input[type=text].w-40px{width:40px !important;}
        .row hr {margin:3px 0 10px;}
        .row input[type=range]{margin-top:10px;}
        table.table thead {background:#d9edf7 !important;color:black !important;}
        table.table thead >tr> th, table.table-bordered, table.table-bordered td {border-color:#aad4e8 !important;font-size:12px;}
        .row .well {min-height:auto;margin-bottom:0px;}
        .row textarea.form-control {height:75px;width:100%;}
        .input-group-addon {border-radius:0px;border-color:#aaa;} 
    </style>

        

    <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datetimepicker.css">
    <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap-datetimepicker.js"></script>
    <!-- <body onLoad="set_tpa(<?php echo $form_data['insurance_type']; ?>); set_married(<?php echo $form_data['marital_status']; ?>);">  -->

<body>
<div class="container-fluid">
   
    <?php //echo "<pre>";print_r($form_data);die; ?>
    <p style="text-align:center;padding:10px;">Refraction List</p>
    <div class="panel-body" style="padding:20px; float:left;">
        <form id="refraction_form" method="post" action="<?php echo current_url(); ?>">
        <input type="hidden" id="booking_id" name="booking_id" value="<?php echo isset($form_data['booking_id']) ? $form_data['booking_id'] : ''; ?>">
        <input type="hidden" id="branch_id" name="branch_id" value="<?php echo isset($form_data['branch_id']) ? $form_data['branch_id'] : ''; ?>">
        <input type="hidden" id="booking_code" name="booking_code" value="<?php echo isset($form_data['booking_code']) ? $form_data['booking_code'] : ''; ?>">
        <input type="hidden" id="pres_id" name="pres_id" value="<?php echo isset($id) ? $id : ''; ?>">
        <input type="hidden" id="patient_id" name="patient_id" value="<?php echo isset($form_data['patient_id']) ? $form_data['patient_id'] : ''; ?>">
        <section class="panel panel-default" style="width:100%;">
        <div class="row">
            <div class="col-md-12 text-right btn_edit" style="display: none;">
                <a href="javascript:void(0)" class="btn_fill" onclick="$('.auto_ref').toggle();">Edit</a>
                <hr>
            </div>
            <div class="col-md-2">
                <div class="label_name">AUTO REFRACTION (ARx) <i onclick="refraction_ar_ltr();" title="Copy Left to Right" class="fa fa-arrow-right"></i></div>
                <!-- <button type="button" class="btn_fill auto_ref d-none" title="Fill AUTO REFRACTION" onclick="return open_modals_2('refraction_ar');" style="display: inline-block;">Fill <i class="fa fa-arrow-right"></i></button> -->
            </div>
            <div class="col-md-4">
                <table class="table table-bordered">
                    <thead class="bg-info">
                        <tr>
                            <th width="25%"></th>
                            <th width="25%">Sph</th>
                            <th width="25%">Cyl</th>
                            <th width="25%">Axis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align:left;">DV</td>
                            <td>
                                <span class="auto_ref"><?= isset($form_data['refraction_ar_l_dv_sph']) ? htmlspecialchars($form_data['refraction_ar_l_dv_sph']) : '' ?></span>
                            </td>
                            <td>
                                <span class="auto_ref"><?= isset($form_data['refraction_ar_l_dv_cyl']) ? htmlspecialchars($form_data['refraction_ar_l_dv_cyl']) : '' ?></span>
                            </td>
                            <td>
                                <span class="auto_ref"><?= isset($form_data['refraction_ar_l_dv_axis']) ? htmlspecialchars($form_data['refraction_ar_l_dv_axis']) : '' ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:left;">NV</td>
                            <td>
                                <span class="auto_ref"><?= isset($form_data['refraction_ar_l_nv_sph']) ? htmlspecialchars($form_data['refraction_ar_l_nv_sph']) : '' ?></span>
                            </td>
                            <td>
                                <span class="auto_ref"><?= isset($form_data['refraction_ar_l_nv_cyl']) ? htmlspecialchars($form_data['refraction_ar_l_nv_cyl']) : '' ?></span>
                            </td>
                            <td>
                                <span class="auto_ref"><?= isset($form_data['refraction_ar_l_nv_axis']) ? htmlspecialchars($form_data['refraction_ar_l_nv_axis']) : '' ?></span>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>

            </div>
            <div class="col-md-2">
                <div class="label_name">AUTO REFRACTION (ARx) <i onclick="refraction_ar_rtl();" title="Copy Right to Left" class="fa fa-arrow-left"></i></div>
            </div>
            <div class="col-md-4">
                <table class="table table-bordered">
                    <thead class="bg-info">
                        <tr>
                            <th width="25%"></th>
                            <th width="25%">Sph</th>
                            <th width="25%">Cyl</th>
                            <th width="25%">Axis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align:left;">DV</td>
                            <td>
                                <span class="auto_ref"><?= isset($form_data['refraction_ar_r_dv_sph']) ? htmlspecialchars($form_data['refraction_ar_r_dv_sph']) : '' ?></span>
                            </td>
                            <td>
                                <span class="auto_ref"><?= isset($form_data['refraction_ar_r_dv_cyl']) ? htmlspecialchars($form_data['refraction_ar_r_dv_cyl']) : '' ?></span>
                            </td>
                            <td>
                                <span class="auto_ref"><?= isset($form_data['refraction_ar_r_dv_axis']) ? htmlspecialchars($form_data['refraction_ar_r_dv_axis']) : '' ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:left;">NV</td>
                            <td>
                                <span class="auto_ref"><?= isset($form_data['refraction_ar_r_nv_sph']) ? htmlspecialchars($form_data['refraction_ar_r_nv_sph']) : '' ?></span>
                            </td>
                            <td>
                                <span class="auto_ref"><?= isset($form_data['refraction_ar_r_nv_cyl']) ? htmlspecialchars($form_data['refraction_ar_r_nv_cyl']) : '' ?></span>
                            </td>
                            <td>
                                <span class="auto_ref"><?= isset($form_data['refraction_ar_r_nv_axis']) ? htmlspecialchars($form_data['refraction_ar_r_nv_axis']) : '' ?></span>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>

        


        
        
        </section>

            <div style="width:60%;">    
                <!-- L - Lens Type -->
                <div class="grp-full">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <label for="lens" class="font-weight-bold mb-0">Lens:</label>
                        </div>
                        <div class="col-md-6">
                            <span>
                                <?= isset($form_data['lens']) ? htmlspecialchars($form_data['lens']) : 'Select Lens Type' ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- L - Comments -->
                <div class="grp-full" style="margin-bottom:40px;">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <label for="comment" class="font-weight-bold mb-0">Comments:</label>
                        </div>
                        <div class="col-md-6">
                            <span>
                                <?= isset($form_data['comment']) ? htmlspecialchars($form_data['comment']) : '' ?>
                            </span>
                        </div>
                    </div>
                </div>

                </div>

                <div class="form-signatures mt-4">
                    <table class="table table-borderless mb-4">
                        <tbody>
                            <tr>
                                <td class="small text-center mt-5" style="width:50%;">
                                    <div class="pt-5"> 
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <span class="font-weight-bold">Signature of Optometrist:</span><br>
                                    <div class="border-top pt-2" style="display: inline-block; width: 200px;border-top:1px solid black;margin-top: 24px;">
                                        <span></span>
                                    </div>
                                </td>
                                <td class="small text-center mt-5">
                                    <div class="pt-5"> 
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <span class="font-weight-bold">Signature of Doctor:</span><br>
                                    <div class="border-top pt-2" style="display: inline-block; width: 200px; border-top:1px solid black;margin-top: 24px;">
                                        <span></span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                
            </div> 


           
        </form>
    </div>
    <div id="load_add_type_modal_popup" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false"></div>


</body>
<script>
    function open_modals_2(modal_tab) {
        // alert('ok');
        var $modal = $('#load_add_type_modal_popup');
        $modal.load('<?php echo base_url().'refraction/fill_eye_data_auto_refraction/' ?>'+modal_tab,
        {
        },
        function(){
        $modal.modal('show');
        });
  	}

      document.getElementById('refraction_form').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission

            var formData = new FormData(this); // Gather form data

            fetch('<?php echo base_url('refraction/add'); ?>', { // Update with the correct URL
                method: 'POST',
                body: formData,
            })
            
            .then(response => response.json())
            .then(data => {
                console.log(data,'=====');
                // Handle success or error response
                if (data.success) {
                    window.location.href = '<?php echo base_url('refraction'); ?>'; // Adjust this URL as necessary
                } else {
                    // If no data found, select the "Select Lens Type"
                    const lensTypeSelect = document.getElementById('lens_type'); // Ensure the correct ID for your select input
                    lensTypeSelect.value = ""; // Or set it to the value that corresponds to "Select Lens Type"
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
    // $this->load->view('include/footer');
    ?>
</html>