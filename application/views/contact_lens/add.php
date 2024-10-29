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
            text-align: unset !important;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            /* background-color: #f0f0f0; */
        }

        input[type="text"],
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
            width: 89% !important;
        }

        h5 {
            text-align: left;
        }

        h3 {
            text-align: center;
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
            <form id="contact_lens_modal_form" method="post" action="<?php echo current_url(); ?>"
                enctype="multipart/form-data"> <!-- Use method="post" -->
                <input type="hidden" name="data_id" id="patient_id"
                    value="<?php echo isset($form_data['data_id']) ? $form_data['data_id'] : ''; ?>">
                <input type="hidden" name="booking_id" id="booking_id"
                    value="<?php echo isset($form_data['booking_id']) ? $form_data['booking_id'] : ''; ?>">
                <input type="hidden" name="patient_id" id="patient_id"
                    value="<?php echo isset($form_data['patient_id']) ? $form_data['patient_id'] : ''; ?>">
                <div class="content-inner">
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
                                            <input type="text" name="booking_code" value="<?php echo isset($booking_data['token_no']) ? $booking_data['token_no'] : 'N/A'; ?>" readonly="">
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
                    




                    <h3>Internal Communications</h3>
                    <h5>With Intermidiate effect below mentioned device is chargeable to patient for Contact Lens</h5>
                    <div class="pat-col">
                        <table id="itemTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>Hospital Code</th>
                                    <th>Item Description</th>
                                    <th>Manufacturer</th>
                                    <th>Qty.</th>
                                    <th>Unit</th>
                                    <th>Hospital Rate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($form_data['items'])): ?>
                                    <?php foreach ($form_data['items'] as $index => $item): ?>
                                        <tr>
                                            <td><input type="text" name="items[<?php echo $index; ?>][sl_no]"
                                                    value="<?php echo $index + 1; ?>" readonly></td>
                                            <td><input type="text" name="items[<?php echo $index; ?>][hospital_code]"
                                                    value="<?php echo $item['hospital_code']; ?>"
                                                    placeholder="Enter Hospital Code"></td>
                                            <td><input type="text" name="items[<?php echo $index; ?>][item_description]"
                                                    value="<?php echo $item['item_description']; ?>"
                                                    placeholder="Enter Item Description"></td>
                                            <td><input type="text" name="items[<?php echo $index; ?>][menufacturer]"
                                                    value="<?php echo $item['menufacturer']; ?>"
                                                    placeholder="Enter Manufacturer"></td>
                                            <td><input type="number" name="items[<?php echo $index; ?>][qty]"
                                                    value="<?php echo $item['qty']; ?>" placeholder="Qty"></td>
                                            <td><input type="text" name="items[<?php echo $index; ?>][unit]"
                                                    value="<?php echo $item['unit']; ?>" placeholder="Unit"></td>
                                            <td><input type="text" name="items[<?php echo $index; ?>][hospital_rate]"
                                                    value="<?php echo $item['hospital_rate']; ?>" placeholder="Rate"></td>
                                            <td><button type="button" class="removeRowBtn">Remove</button></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td><input type="text" name="items[0][sl_no]" value="1" readonly></td>
                                        <td><input type="text" name="items[0][hospital_code]"
                                                placeholder="Enter Hospital Code"></td>
                                        <td><input type="text" name="items[0][item_description]"
                                                placeholder="Enter Item Description"></td>
                                        <td><input type="text" name="items[0][menufacturer]"
                                                placeholder="Enter Manufacturer"></td>
                                        <td><input type="number" name="items[0][qty]" placeholder="Qty"></td>
                                        <td><input type="text" name="items[0][unit]" placeholder="Unit"></td>
                                        <td><input type="text" name="items[0][hospital_rate]" placeholder="Rate"></td>
                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="grp-full mt-5" style="margin-to:20px;">
                            <div class="row mb-4">
                                <div class="col-md-6 text-left">
                                    <p class="font-weight-bold">Signature</p>
                                    <div class="border-top pt-2" style="width: 50%;float: left;margin-top: 24px;">
                                    </div>
                                </div>
                                <div class="col-md-6 text-right">
                                    <p class="font-weight-bold">Signature</p>
                                    <div class="border-top pt-2" style="width: 50%;float: right;margin-top: 24px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-save" id="addRowBtn">Add Row</button>
                        <button type="submit" class="btn-save">Submit</button>
                        <a href="<?php echo base_url('contact_lens'); ?>" class="btn-anchor"><i
                                class="fa fa-sign-out"></i> Exit</a>
                    </div>
                </div>
            </form>
        </section>
    </div>
    <?php
    $this->load->view('include/footer');
    ?>
    </div>

</body>

<script>
    document.getElementById('contact_lens_modal_form').addEventListener('submit', function (event) {
        event.preventDefault();

        var formData = new FormData(this);
        var items = [];
        var itemsData = formData.getAll('items[0][sl_no]'); // Assuming items are always indexed like this
        var itemCount = itemsData.length; // Total number of items

        for (var i = 0; i < itemCount; i++) {
            var item = {
                sl_no: formData.get('items[' + i + '][sl_no]'),
                hospital_code: formData.get('items[' + i + '][hospital_code]'),
                item_description: formData.get('items[' + i + '][item_description]'),
                menufacturer: formData.get('items[' + i + '][menufacturer]'),
                qty: formData.get('items[' + i + '][qty]'),
                unit: formData.get('items[' + i + '][unit]'),
                hospital_rate: formData.get('items[' + i + '][hospital_rate]')
            };
            items.push(item); // Add item to the items array
        }

        // Now append items as a JSON string to formData
        formData.append('contact_lens_items', JSON.stringify(items));

        //  formData.forEach(function(value, key) {
        //     console.log(key + ': ' + value);
        // });

        var booking_id = <?php echo json_encode($form_data['booking_id']); ?>;
        var patient_id = <?php echo json_encode($form_data['patient_id']); ?>;


        var url = '<?php echo base_url('contact_lens/add/'); ?>' + booking_id + '/' + patient_id;

        fetch(url, {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                console.log(data, '=====')
                // Handle success or error response
                if (data.success) {
                    // alert('Form submitted successfully!');
                    // Redirect to the conatct_lens list page
                    flash_session_msg(data.message);
                    window.location.href = '<?php echo base_url('contact_lens'); ?>'; // Adjust this URL as necessary
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
</script>
<script>
    $(document).ready(function () {
        // Function to update row serial numbers
        function updateSerialNumbers() {
            $('#itemTable tbody tr').each(function (index) {
                $(this).find('input[name^="items["][name$="[sl_no]"]').val(index + 1);
            });
        }

        // Add new item row
        $('#addRowBtn').on('click', function () {
            var index = $('#itemTable tbody tr').length;
            var newRow = `
                <tr>
                    <td><input type="text" name="items[${index}][sl_no]" value="${index + 1}" readonly></td>
                    <td><input type="text" name="items[${index}][hospital_code]" placeholder="Enter Hospital Code"></td>
                    <td><input type="text" name="items[${index}][item_description]" placeholder="Enter Item Description"></td>
                    <td><input type="text" name="items[${index}][menufacturer]" placeholder="Enter Manufacturer"></td>
                    <td><input type="number" name="items[${index}][qty]" placeholder="Qty"></td>
                    <td><input type="text" name="items[${index}][unit]" placeholder="Unit"></td>
                    <td><input type="text" name="items[${index}][hospital_rate]" placeholder="Rate"></td>
                    <td><button type="button" class="removeRowBtn">Remove</button></td>
                </tr>`;
            $('#itemTable tbody').append(newRow);
        });

        // Remove item row
        $('#itemTable').on('click', '.removeRowBtn', function () {
            $(this).closest('tr').remove();
            updateSerialNumbers(); // Update serial numbers after removal
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
    $("#side_effects").select2();
    $("#side_effects").select2({
        width: '435px'
    });
</script>
</body>

</html>