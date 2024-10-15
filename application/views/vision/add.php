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
      width: 480px;
      
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
        <section class="content">
            <form id="vision_modal_form" method="post"> <!-- Use method="post" -->
                <input type="hidden" name="data_id" id="patient_id" value="<?php echo isset($form_data['data_id'])?$form_data['data_id']:''; ?>">
                <input type="hidden" name="booking_id" id="booking_id" value="<?php echo isset($form_data['booking_id'])?$form_data['booking_id']:''; ?>">

                <div class="form-group">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <label for="patient_name" class="font-weight-bold mb-0">Name of the patient: <span class="star">*</span></label>
                        </div>
                        <div class="col-md-6">
                            <?php 
                            // Display the patient name if available, otherwise show the default $patient_name
                            $patient_name_to_display = isset($form_data['patient_name']) ? $form_data['patient_name'] : $patient_name;
                            //echo htmlspecialchars($patient_name_to_display); // Safely display the name
                            ?>

                            <input type="text" name="patient_name" class="form-control input-height" id="patient_name" placeholder="Enter patient's name" maxlength="255" value="<?php echo $patient_name_to_display; ?>" required>
                            
                            <?php if (!empty($form_error)) echo form_error('patient_name'); ?>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <label for="procedure_purpose" class="font-weight-bold mb-0">Purpose of the Procedure: <span class="star">*</span></label>
                        </div>
                        <div class="col-md-6">
                            <textarea id="procedure_purpose" name="procedure_purpose" class="form-control input-height" rows="3" placeholder="Enter the purpose of the procedure here" required><?php echo isset($form_data['procedure_purpose']) ? htmlspecialchars($form_data['procedure_purpose']) : ''; ?></textarea>
                            <?php if (!empty($form_error)) echo form_error('procedure_purpose'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <label for="sideEffects" class="font-weight-bold mb-0">Side Effects <span class="star">*</span></label>
                        </div>
                        <div class="col-md-6">
                            <select name="side_effects" id="sideEffects" class="m_input_default select-height" required>
                                <option value="" disabled <?php echo empty($form_data['side_effects']) ? 'selected' : ''; ?>>Select a side effect</option>
                                <?php if (!empty($side_effects)): ?>
                                    <?php foreach ($side_effects as $side_effect): ?>
                                        <option value="<?php echo $side_effect->id; ?>" <?php echo (isset($form_data['side_effects']) && $form_data['side_effects'] == $side_effect->id) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($side_effect->side_effect_name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option disabled>No side effects found.</option>
                                <?php endif; ?>
                            </select>
                            <?php if (!empty($form_error)) echo form_error('side_effects'); ?>
                        </div>
                    </div>
                </div>

                <p class="mt-3">I have been informed about the procedure, benefits, and risks, and hereby consent to proceed with the investigation.</p>

                <div class="form-signatures">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="font-weight-bold">Signature / LTI of patient</p>
                            <div class="border-top pt-2" style="width: 200px;">
                                <span><?php echo isset($form_data['optometrist_signature']) ? htmlspecialchars($form_data['optometrist_signature']) : 'Not Provided'; ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="font-weight-bold">Signature / LTI of relative</p>
                            <div class="border-top pt-2" style="width: 200px;">
                                <span><?php echo isset($form_data['anaesthetist_signature']) ? htmlspecialchars($form_data['anaesthetist_signature']) : 'Not Provided'; ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section mt-5">
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
                                                <input type="radio" name="<?php echo $name; ?>" value="yes" <?php echo (isset($form_data[$name]) && $form_data[$name] == 'yes') ? 'checked' : ''; ?> required> Yes
                                            </label>
                                            <label>
                                                <input type="radio" name="<?php echo $name; ?>" value="no" <?php echo (isset($form_data[$name]) && $form_data[$name] == 'no') ? 'checked' : ''; ?> required> No
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>

                    <div class="form-group">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <label class="font-weight-bold mb-0">FFA not done due to:</label>
                            </div>
                            <div class="col-md-6">
                                <textarea rows="2" class="form-control input-height" name="reason_ffa_not_done" placeholder="Enter the reason FFA was not done" required><?php echo isset($form_data['reason_ffa_not_done']) ? htmlspecialchars($form_data['reason_ffa_not_done']) : ''; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-signatures mt-5">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <p class="font-weight-bold">Optometrist's Signature</p>
                            <div class="border-top pt-2" style="width: 200px;">______________________</div>
                            <p class="mt-2">Date: ___________________</p>
                        </div>
                        <div class="col-md-4">
                            <p class="font-weight-bold">Anaesthetist's Signature</p>
                            <div class="border-top pt-2" style="width: 200px;">______________________</div>
                            <p class="mt-2">Date: ___________________</p>
                        </div>
                        <div class="col-md-4">
                            <p class="font-weight-bold">Doctor's Signature</p>
                            <div class="border-top pt-2" style="width: 200px;">______________________</div>
                            <p class="mt-2">Date: ___________________</p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="grp">
                        <label></label>
                        <div class="box-right">
                            <button class="btn-update" id="form_submit">
                            <i class="fa fa-save"></i> Save</button>
                            <a href="<?php echo base_url('vision'); ?>" class="btn-update"
                            style="text-decoration:none!important;color:#FFF;padding:8px 2em;"><i class="fa fa-sign-out"></i>
                            Exit</a>
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
document.getElementById('vision_modal_form').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the default form submission

    var formData = new FormData(this); // Gather form data
    // formData.forEach(function(value, key) {
    //     console.log(key + ': ' + value);
    // });
   

    fetch('<?php echo base_url('vision/add'); ?>', { // Update with the correct URL
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        // Handle success or error response
        if (data.success) {
            // alert('Form submitted successfully!');
            // Redirect to the vision list page
            window.location.href = '<?php echo base_url('vision'); ?>'; // Adjust this URL as necessary
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





<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
