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
        table {
            width: 100%;
            border-collapse: collapse;
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
            border: none;
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
                                            <td>
                                                <select id="hospital_code_dropdown_<?php echo $index; ?>" name="items[<?php echo $index; ?>][hospital_code]"
                                                    class="hospital_code_dropdown" data-index="<?php echo $index; ?>">
                                                    <option value="">Select Hospital Code</option>
                                                    <?php foreach ($hospital_code_list as $code): ?>
                                                        <option value="<?php echo $code->id; ?>" <?php echo ($code->hospital_code == $item['hospital_code']) ? 'selected' : ''; ?>>
                                                            <?php echo $code->hospital_code; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td>
                                                
                                                <select id="item_description_dropdown_<?php echo $index; ?>" name="items[<?php echo $index; ?>][item_description]"
                                                    class="item_description_dropdown" data-index="<?php echo $index; ?>">
                                                    <option value="">Select Item Description</option>
                                                    <?php foreach ($item_desc_list as $desc): ?>
                                                        <option value="<?php echo $desc->id; ?>" <?php echo ($desc->item_desc == $item['item_description']) ? 'selected' : ''; ?>>
                                                            <?php echo $desc->item_desc; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td>
                                                
                                                <select id="manufacturer_dropdown_<?php echo $index; ?>" name="items[<?php echo $index; ?>][manufacturer]"
                                                    class="manufacturer_dropdown" data-index="<?php echo $index; ?>">
                                                    <option value="">Select Manufacturer</option>
                                                    <?php foreach ($manuf_company_list as $manufacturer): ?>
                                                        <option value="<?php echo $manufacturer->id; ?>" <?php echo ($manufacturer->company_name === $item['menufacturer']) ? 'selected' : ''; ?>>
                                                            <?php echo $manufacturer->company_name; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td><input type="number" name="items[<?php echo $index; ?>][qty]"
                                                    value="<?php echo $item['qty']; ?>" placeholder="Qty"></td>
                                            <td>
                                                <select id="unit_dropdown_<?php echo $index; ?>" name="items[<?php echo $index; ?>][unit]" class="unit_dropdown"
                                                    data-index="<?php echo $index; ?>">
                                                    <option value="">Select Unit</option>
                                                    <?php foreach ($unit_list as $unit): ?>
                                                        <option value="<?php echo $unit->id; ?>" <?php echo ($unit->medicine_unit == $item['unit']) ? 'selected' : ''; ?>>
                                                            <?php echo $unit->medicine_unit; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td><input type="text" name="items[<?php echo $index; ?>][hospital_rate]"
                                                    value="<?php echo $item['hospital_rate']; ?>" placeholder="Rate"></td>
                                            <td><button type="button" class="removeRowBtn">Remove</button></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td><input type="text" name="items[0][sl_no]" value="1" readonly></td>
                                        <td>
                                            <select id="hospital_code_dropdown_0" name="items[0][hospital_code]" class="hospital_code_dropdown"
                                                data-index="0">
                                                <option value="">Select Hospital Code</option>
                                                <?php foreach ($hospital_code_list as $code): ?>
                                                    <option value="<?php echo $code->id; ?>"><?php echo $code->hospital_code; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select id="item_description_dropdown_0" name="items[0][item_description]" class="item_description_dropdown"
                                                data-index="0">
                                                <option value="">Select Item Description</option>
                                                <?php foreach ($item_desc_list as $desc): ?>
                                                    <option value="<?php echo $desc->id; ?>"><?php echo $desc->item_desc; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select id="manufacturer_dropdown_0" name="items[0][manufacturer]" class="manufacturer_dropdown"
                                                data-index="0">
                                                <option value="">Select Manufacturer</option>
                                                <?php foreach ($manuf_company_list as $manufacturer): ?>
                                                    <option value="<?php echo $manufacturer->id; ?>">
                                                        <?php echo $manufacturer->company_name; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td><input type="number" name="items[0][qty]" placeholder="Qty"></td>
                                        <td>
                                            <select id="unit_dropdown_0" name="items[0][unit]" class="unit_dropdown" data-index="0">
                                                <option value="">Select Unit</option>
                                                <?php foreach ($unit_list as $unit): ?>
                                                    <option value="<?php echo $unit->id; ?>"><?php echo $unit->medicine_unit; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
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

        event.preventDefault();

        var formData = new FormData(this);
        var items = [];

        // Get all rows in the table body
        document.querySelectorAll('tbody tr').forEach((row, index) => {
        // Get both value and text (name) for each dropdown
        var hospital_code = row.querySelector(`select[name="items[${index}][hospital_code]"]`);
        var item_description = row.querySelector(`select[name="items[${index}][item_description]"]`);
        var manufacturer = row.querySelector(`select[name="items[${index}][manufacturer]"]`);
        var unit = row.querySelector(`select[name="items[${index}][unit]"]`);

        var item = {
            sl_no: row.querySelector(`input[name="items[${index}][sl_no]"]`)?.value ?? 0,
            hospital_code: hospital_code.value,
            hospital_code_name: hospital_code.options[hospital_code.selectedIndex].text, // Get selected text
            item_description: item_description.value,
            item_description_name: item_description.options[item_description.selectedIndex].text,
            manufacturer: manufacturer.value,
            manufacturer_name: manufacturer.options[manufacturer.selectedIndex].text,
            qty: row.querySelector(`input[name="items[${index}][qty]"]`).value,
            unit: unit.value,
            unit_name: unit.options[unit.selectedIndex].text,
            hospital_rate: row.querySelector(`input[name="items[${index}][hospital_rate]"]`).value
        };
        items.push(item); // Add each item object to items array
    });

    // console.log(items, '===========');
    //     return;
        // Now append items as a JSON string to formData
        formData.append('contact_lens_items', JSON.stringify(items));



        var booking_id = <?php echo json_encode($form_data['booking_id']); ?>;
        var patient_id = <?php echo json_encode($form_data['patient_id']); ?>;


        var url = '<?php echo base_url('contact_lens/add/'); ?>' + booking_id + '/' + patient_id;

        fetch(url, {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                // Handle success or error response
                if (data.success) {
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
        function initializeSelect2() {
            $('.hospital_code_dropdown, .item_description_dropdown, .manufacturer_dropdown, .unit_dropdown').select2({
            width: '100%'
        });
        }
                
                // $('select').select2();
        // Add new item row
        $('#addRowBtn').on('click', function () {
            let newIndex = $('tbody tr').length;
            let newRow = `
            <tr>
                <td><input type="text" name="items[${newIndex}][sl_no]" value="${newIndex + 1}" readonly></td>
                <td>
                    <select id="hospital_code_dropdown_${newIndex}" name="items[${newIndex}][hospital_code]" class="hospital_code_dropdown" data-index="${newIndex}">
                        <option value="">Select Hospital Code</option>
                        <?php foreach ($hospital_code_list as $code): ?>
                                        <option value="<?php echo $code->id; ?>"><?php echo $code->hospital_code; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select id="item_description_dropdown_${newIndex}" name="items[${newIndex}][item_description]" class="item_description_dropdown" data-index="${newIndex}">
                        <option value="">Select Item Description</option>
                        <?php foreach ($item_desc_list as $desc): ?>
                                        <option value="<?php echo $desc->id; ?>"><?php echo $desc->item_desc; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select id="manufacturer_dropdown_${newIndex}" name="items[${newIndex}][manufacturer]" class="manufacturer_dropdown" data-index="${newIndex}">
                        <option value="">Select Manufacturer</option>
                        <?php foreach ($manuf_company_list as $manufacturer): ?>
                                        <option value="<?php echo $manufacturer->id; ?>"><?php echo $manufacturer->company_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="number" name="items[${newIndex}][qty]" placeholder="Qty"></td>
                <td>
                    <select id="unit_dropdown_${newIndex}" name="items[${newIndex}][unit]" class="unit_dropdown" data-index="${newIndex}">
                        <option value="">Select Unit</option>
                        <?php foreach ($unit_list as $unit): ?>
                                        <option value="<?php echo $unit->id; ?>"><?php echo $unit->medicine_unit; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="text" name="items[${newIndex}][hospital_rate]" placeholder="Rate"></td>
                <td><button type="button" class="removeRowBtn">Remove</button></td>
            </tr>
        `;
            $('tbody').append(newRow);
            initializeSelect2();
        });

        // Remove item row
        $('#itemTable').on('click', '.removeRowBtn', function () {
            $(this).closest('tr').remove();
            updateSerialNumbers(); // Update serial numbers after removal
        });
        $(document).on('change', '.hospital_code_dropdown', function () {
            
            let index = $(this).data('index');
            let hospitalCode = $(this).val();
            if (hospitalCode) {
            $.ajax({
                url: '<?php echo base_url("contact_lens/get_item_details"); ?>',
                type: 'POST',
                data: { hospital_code: hospitalCode },
                success: function (response) {
                    // Assuming response is in JSON format
                    const data = JSON.parse(response); // Parse JSON response
                    if (data && data.data && data.data[0]) {

                        $(`select[name="items[${index}][item_description]"]`).val(data.data[0].item_desc_id).trigger('change');

                        // Set the manufacturer with Select2 and trigger the change event
                        $(`select[name="items[${index}][manufacturer]"]`).val(data.data[0].manuf_company).trigger('change');

                        // Set the unit with Select2 and trigger the change event
                        $(`select[name="items[${index}][unit]"]`).val(data.data[0].unit_id).trigger('change');

                        // Set other input fields
                        $(`input[name="items[${index}][qty]"]`).val(data.data[0].qty);
                        $(`input[name="items[${index}][hospital_rate]"]`).val(data.data[0].hospital_rate)
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: ", error);
                }
            });
        }
        });


    });
    $(document).on('change', '.hospital_code_dropdown', function () {
        
        let index = $(this).data('index');
        let hospitalCode = $(this).val();

        if (hospitalCode) {
            $.ajax({
                url: '<?php echo base_url("contact_lens/get_item_details"); ?>',
                type: 'POST',
                data: { hospital_code: hospitalCode },
                success: function (response) {
                    // Assuming response is in JSON format
                    const data = JSON.parse(response); // Parse JSON response
                    if (data && data.data && data.data[0]) {
                        console.log(data.data)
                        
                        $(`select[name="items[${index}][item_description]"]`).val(data.data[0].item_desc_id);
                        $(`select[name="items[${index}][manufacturer]"]`).val(data.data[0].manuf_company);
                        $(`select[name="items[${index}][unit]"]`).val(data.data[0].unit_id);
                        $(`input[name="items[${index}][qty]"]`).val(data.data[0].qty);
                        $(`input[name="items[${index}][hospital_rate]"]`).val(data.data[0].hospital_rate);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: ", error);
                }
            });
        }
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