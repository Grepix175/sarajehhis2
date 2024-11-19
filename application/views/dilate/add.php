<?php
$users_data = $this->session->userdata('auth_users');
$field_list = mandatory_section_field_list(2);
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
        /* table {s */
        td{
            width: auto !important;
            /* text-align: unset !important; */
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            width: 20%;
        }

        th {
            /* background-color: #f0f0f0; */
        }

        input[type="text"],
        /* input[type="select"], */
        input[type="number"] {
            width: 100%;
            padding: 6px;
            box-sizing: border-box;
            outline: none;
        }

        td {
            padding: 6px;
        }

        button {
            margin-top: 10px;
        }

        .pat-col {
            float: left;
            width: 100% !important;
        }

        h5 {
            text-align: left;
        }

        h3 {
            text-align: center;
        }
        select {
            width: 300px!important;
        }
        span#select2-medicine_name_dropdown-container,
        span#select2-salt_dropdown-container {
            text-align: left;
            width: 300px;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datetimepicker.css">
    <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap-datetimepicker.js"></script>
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
            <form id="dilate_modal_form" method="post" action="<?php echo current_url(); ?>"
                enctype="multipart/form-data"> <!-- Use method="post" -->
                <input type="hidden" name="data_id" id="patient_id"
                    value="<?php echo isset($form_data['data_id']) ? $form_data['data_id'] : ''; ?>">
                <input type="hidden" name="booking_id" id="booking_id"
                    value="<?php echo isset($form_data['booking_id']) ? $form_data['booking_id'] : ''; ?>">
                <input type="hidden" name="patient_id" id="patient_id"
                    value="<?php echo isset($form_data['patient_id']) ? $form_data['patient_id'] : ''; ?>">
                <div class="content-inner">
                    <?php //echo "<pre>";print_r($form_data['booking_id']);print_r($booking_id);die; ?>
                    
                    <?php //echo "<pre>";print_r($booking_data);die('plp'); ?>
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
                    
                        <h3>Dilate</h3>

                        <div class=" text-right">
                        <?php
                            if (empty($flag)) {
                        ?>
                        <div class="input-group bg-warning" style="width:100px;float:right;border:1px solid #aaa;">
                            <span class="input-group-addon alert alert-warning" style="border:0" id="demo">Undilated</span>
                            <div id="d_start"><input type="button" class="btn-success btn btn-sm"
                                onclick="dilate_strt('<?php echo $booking_id; ?>');" value="Start"></div>
                        </div>
                        <?php
                        }
                        ?>

                    <script type="text/javascript">
                        var dltddate = '<?php echo $datas['dilate_time']; ?>';
                        var dilate_status = '<?php echo $datas['dilate_status']; ?>';
                        // console.log(dltddate)

                        var dltddate2 = new Date('<?php echo $datas['dilate_start_time']; ?>').getTime();

                        if (dltddate != '0000-00-00 00:00:00' && dltddate !== '') {
                            var countDownDate = new Date(dltddate).getTime();

                            var diff = countDownDate - dltddate2;

                            var x = setInterval(function () {
                                var now = new Date().getTime();
                                var distance = now - dltddate2;

                                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                // console.log(dilate_status)
                                // console.log(diff)

                                // Update the display with the current time difference
                                document.getElementById("demo").innerHTML = 'Dilate Time ' + minutes + "m " + seconds + "s";

                                // Check if the dilate time has elapsed
                                if (distance >= diff && dilate_status !== '2') {
                                    // alert('ok');

                                    $.ajax({ // Call to stop dilation
                                        url: "<?php echo base_url(); ?>dilated/dilated_stop",
                                        type: "POST",
                                        data: { booked_id: '<?php echo $booking_id; ?>' },
                                        success: function (result) {
                                            setTimeout(function () {
                                                // Additional actions after the stop (if any)
                                            }, 1300);
                                        },
                                        error: function (xhr, status, error) {
                                            console.error("AJAX request failed:", error);
                                        }
                                    });

                                    clearInterval(x);
                                    document.getElementById("demo").innerHTML = "Dilated";
                                    $('#d_start').html('');
                                } else {
                                    // Show stop button if not yet dilated
                                    $('#d_start').html('<input type="button" class="btn btn-danger btn-sm" onclick="dilate_stop(<?php echo $booking_id; ?>);" value="Stop">');
                                }
                            }, 1000);
                        } else {
                            console.warn("Dilate date is invalid. Cannot start timer.");
                        }
                    </script>




                    <!-- <h5>With Intermidiate effect below mentioned device is chargeable to patient for Contact Lens</h5> -->
                    <div class="pat-col">
                        <table id="itemTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Drop Name</th>
                                    <th>Salt</th>
                                    <th>Percentage</th>
                                    <!-- <th>Qty.</th>
                                    <th>Unit</th>
                                    <th>Hospital Rate</th> -->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($form_data['items'])): ?>
                                <?php foreach ($form_data['items'] as $index => $item): ?>
                                    <tr>
                                        <td><input type="text" name="items[<?php echo $index; ?>][sl_no]" value="<?php echo $index + 1; ?>" readonly></td>

                                        <!-- Medicine Name Dropdown -->
                                        <td style="width:100%;">
                                            <select id="medicine_name_dropdown_<?php echo $index; ?>" name="items[<?php echo $index; ?>][medicine_name]" class="medicine_name_dropdown" data-index="<?php echo $index; ?>">
                                                <option value="">Select Medicine Name</option>
                                                <?php foreach ($medicines as $medicine): ?>
                                                    <option value="<?php echo $medicine['id']; ?>" <?php echo ($medicine['id'] == $item['drop_name']) ? 'selected' : ''; ?>>
                                                        <?php echo $medicine['medicine_name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>

                                        <!-- Salt Dropdown -->
                                        <td>
                                            <select id="salt_dropdown_<?php echo $index; ?>" name="items[<?php echo $index; ?>][salt]" class="salt_dropdown" data-index="<?php echo $index; ?>">
                                                <option value="">Select Salt</option>
                                                <?php foreach ($medicines as $medicine): ?>
                                                    <option value="<?php echo $medicine['salt']; ?>" <?php echo ($medicine['salt'] == $item['salt']) ? 'selected' : ''; ?>>
                                                        <?php echo $medicine['salt']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>

                                        <td><input type="number" name="items[<?php echo $index; ?>][percentage]" value="<?php echo $item['percentage']; ?>" placeholder="Percentage"></td>
                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td><input type="text" name="items[0][sl_no]" value="1" readonly></td>

                                    <!-- Default Row with Medicine Name Dropdown -->
                                    <td>
                                        <select id="medicine_name_dropdown_0" name="items[0][medicine_name]" class="medicine_name_dropdown" data-index="0">
                                            <option value="">Select Medicine Name</option>
                                            <?php foreach ($medicines as $medicine): ?>
                                                <option value="<?php echo $medicine['id']; ?>" <?php echo (isset($form_data) && $form_data['drop_name'] == $medicine['id']) ? 'selected' : ''; ?>>
                                                    <?php echo $medicine['medicine_name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>

                                    <!-- Default Salt Dropdown -->
                                    <td>
                                        <select id="salt_dropdown_0" name="items[0][salt]" class="salt_dropdown" data-index="0">
                                            <option value="">Select Salt</option>
                                            <?php foreach ($medicines as $medicine): ?>
                                                <option value="<?php echo $medicine['salt']; ?>" <?php echo (isset($form_data) && $form_data['salt'] == $medicine['salt']) ? 'selected' : ''; ?>>
                                                    <?php echo $medicine['salt']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>

                                    <!-- Percentage Field -->
                                    <td>
                                        <input type="number" name="items[0][percentage]" value="<?php echo isset($form_data['percentage']) ? $form_data['percentage'] : ''; ?>" placeholder="Percentage">
                                    </td>

                                    <td><button type="button" class="removeRowBtn">Remove</button></td>
                                </tr>
                            <?php endif; ?>



                            </tbody>
                        </table>
                        
                        
                    </div>
                </div>
                <div class="row m-b-5" style="text-align:left;margin-top:10px;">
                    <div class="col-sm-2" style="margin: 30px 0;">
                        <label>Remarks</label>
                    </div>
                    <div class="col-sm-3" style="margin: 30px 0;">
                        <textarea type="text" class="m_input_default" name="remarks"><?php echo isset($form_data['remarks']) ? $form_data['remarks'] : ''; ?></textarea>
                    </div>
                </div>

            </form>
            <button type="button" class="btn-save" id="addRowBtn">Add Row</button>
            <button type="submit" class="btn-save">Submit</button>
                <a href="<?php echo base_url('dilate'); ?>" class="btn-anchor"><i
                    class="fa fa-sign-out"></i> Exit</a>
        </section>
    </div>
    <?php
    $this->load->view('include/footer');
    ?>
    </div>

</body>

<script>
    window.onload = function() {
        document.getElementById('d_start').focus(); // Use the correct ID for the input
    };
    document.getElementById('dilate_modal_form').addEventListener('submit', function (event) {
        event.preventDefault();

        event.preventDefault();

        var formData = new FormData(this);
        var items = [];

        // Get all rows in the table body
        document.querySelectorAll('tbody tr').forEach((row, index) => {
            // Get the values and text for the relevant dropdowns and inputs
            var medicine_name = row.querySelector(`select[name="items[${index}][medicine_name]"]`);
            var salt = row.querySelector(`select[name="items[${index}][salt]"]`);

            var item = {
                sl_no: row.querySelector(`input[name="items[${index}][sl_no]"]`)?.value ?? 0,
                medicine_name: medicine_name.value,
                medicine_name_text: medicine_name.options[medicine_name.selectedIndex].text, // Get selected text
                salt: salt.value,
                salt_text: salt.options[salt.selectedIndex].text,
                percentage: row.querySelector(`input[name="items[${index}][percentage]"]`).value
            };

            items.push(item); // Add each item object to items array
        });


        // console.log(items, '===========');
        //     return;
        // Now append items as a JSON string to formData
        formData.append('contact_lens_items', JSON.stringify(items));



        var booking_id = <?php echo json_encode($form_data['booking_id']); ?>;
        var patient_id = <?php echo json_encode($form_data['patient_id']); ?>;

        var url = '<?php echo base_url('dilate/add/'); ?>' + booking_id + '/' + patient_id;

            fetch(url, {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                // Handle success or error response
                if (data.success) {
                    flash_session_msg(data.message);
                    window.location.href = '<?php echo base_url('dilate'); ?>'; // Adjust this URL as necessary
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // alert('There was a problem with the submission.');
            });
    });

    function flash_session_msg(val) {
        $('#flash_msg_text').html(val);
        $('#flash_session').slideDown('slow').delay(1500).slideUp('slow');
    }
    $('.validity_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        startDate: new Date(),
    });
    function dilate_strt(id) {
        // alert(id)
      $.ajax({
        url: "<?php echo base_url(); ?>dilate/dilated_start",
        type: "POST",
        data: { booked_id: id },
        success: function (result) {
          flash_session_msg(result);
          location.reload();
        }
      });
    }
    function dilate_stop(id) {
        // alert(id)
      $.ajax({
        url: "<?php echo base_url(); ?>dilate/dilated_stop",
        type: "POST",
        data: { booked_id: id },
        success: function (result) {
          flash_session_msg(result);
          location.reload();
        }
      });
    }
</script>
<script>
    $(document).ready(function () {
        // Function to update row serial numbers
        function updateSerialNumbers() {
            $('#itemTable tbody tr').each(function (index) {
                $(this).find('input[name^="items["][name$="[sl_no]"]').val(index + 1);
            });
        }

        function initializeSelect2() {
            $('.medicine_name_dropdown, .salt_dropdown').select2({
                width: '100%'
            });
        }

        $('#addRowBtn').on('click', function () {
            let newIndex = $('tbody tr').length;
            let newRow = `
                <tr>
                    <td><input type="text" name="items[${newIndex}][sl_no]" value="${newIndex + 1}" readonly style="text-align: left;"></td>
                    <td>
                        <select id="medicine_name_dropdown" name="items[${newIndex}][medicine_name]" class="medicine_name_dropdown" data-index="${newIndex}" style="text-align: left;">
                            <option value="">Select Medicine Name</option>
                            <?php foreach ($medicines as $medicine): ?>
                                <option value="<?php echo $medicine['id']; ?>"><?php echo $medicine['medicine_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select id="salt_dropdown" name="items[${newIndex}][salt]" class="salt_dropdown" data-index="${newIndex}" style="text-align: left;">
                            <option value="">Select Salt</option>
                            <?php foreach ($medicines as $medicine): ?>
                                <option value="<?php echo $medicine['salt']; ?>"><?php echo $medicine['salt']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="number" name="items[${newIndex}][percentage]" placeholder="Percentage" style="text-align: left;"></td>
                    <td><button type="button" class="removeRowBtn">Remove</button></td>
                </tr>
            `;
            $('tbody').append(newRow);
            initializeSelect2(); // Reinitialize Select2 if necessary
        });



        // Remove item row
        $('#itemTable').on('click', '.removeRowBtn', function () {
            $(this).closest('tr').remove();
            updateSerialNumbers(); // Update serial numbers after removal
        });

        // Change event for medicine name dropdown
        $(document).on('change', '.medicine_name_dropdown', function () {
            let index = $(this).data('index'); // Get the index of the current dropdown
            let medicineName = $(this).val(); // Get the selected medicine name

            // Check if a medicine is selected
            if (medicineName) {
                $.ajax({
                    url: '<?php echo base_url("dilate/get_item_details_by_medicine"); ?>',
                    type: 'POST',
                    data: { medicine_name: medicineName },
                    success: function (response) {
                        try {
                            const data = JSON.parse(response); // Parse JSON response
                            if (data.success) { // Check if success is true
                                console.log('Data retrieved:', data.data); // Log data for debugging
                                // Set values in the respective fields
                                $(`select[name="items[${index}][salt]"]`).val(data.data.salt).trigger('change'); // Update item description
                                $(`input[name="items[${index}][qty]"]`).val(data.data.qty); // Update quantity
                            } else {
                                console.error(data.message || 'No data found');
                            }
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error: ", error);
                    }
                });
            }
        });




    });



</script>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
   $(document).ready(function () {
    // Initialize Select2 for all existing dropdowns
        $('.hospital_code_dropdown, .item_description_dropdown, .manufacturer_dropdown, .unit_dropdown').select2({
            width: '100%'
        });
    });
</script>
</body>

</html>