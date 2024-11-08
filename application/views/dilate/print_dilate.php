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
        .footer {
            position: absolute; /* Fixed position at the bottom */
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 11px; /* Smaller font size for footer text */
        }

        .footer hr {
            border: none;
            border-top: 1px solid #000; /* Line style */
            margin: 0; /* Remove margins */
        }
        /* table {s */
        td{
            width: auto !important;
            text-align: unset !important;
        }

        .itemTable th,
        .itemTable td {
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
        
    </style>
    <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datetimepicker.css">
    <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap-datetimepicker.js"></script>
    <!-- <body onLoad="set_tpa(<?php echo $form_data['insurance_type']; ?>); set_married(<?php echo $form_data['marital_status']; ?>);">  -->

<body>
    
<div class="panel-body"   style="padding:20px;">
    <p style="text-align: center; font-size: 7px;"><strong>Sara Eye HOSPITALS</strong></p>


        <?php
        // Loop through the contact lens data
        $age_y = $booking_data['age_y']??'';
        $age_m = $booking_data['age_m']??'';
        $age_d = $booking_data['age_d']??'';

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
                            <td class="info-content">: <?php echo $booking_data['patient_name']??''; ?></td>
                        </tr>
                        <tr>
                            <td class="info-label">Patient Reg. No</td>
                            <td class="info-content">: <?php echo $booking_data['patient_code']??''; ?></td>
                        </tr>
                        <tr>
                            <td class="info-label">Token No</td>
                            <td class="info-content">: <?php echo $booking_data['token_no']??''; ?></td>
                        </tr>
                        <tr>
                            <td class="info-label">OPD No</td>
                            <td class="info-content">: <?php echo $form_data['booking_id']??''; ?></td>
                        </tr>
                    </table>
                </td>
                <td class="right-column">
                    <table>
                        <tr>
                            <td class="info-label">Mobile no.</td>
                            <td class="info-content">: <?php echo $booking_data['mobile_no']??''; ?></td>
                        </tr>
                        <tr>
                            <td class="info-label">Age</td>
                            <td class="info-content">: <?php echo $age??''; ?></td>
                        </tr>
                        <tr>
                            <td class="info-label">Gender</td>
                            <td class="info-content">: <?php echo ($booking_data['gender'] == '0') ? 'Female' : 'Male'; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
                    
                        <h3>Dilate</h3>

                        



                    <!-- <h5>With Intermidiate effect below mentioned device is chargeable to patient for Contact Lens</h5> -->
                    <div class="pat-col">
                        <table width="100%" cellpadding="0" cellspacing="0" border="1px">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Drop Name</th>
                                    <th>Salt</th>
                                    <th>Percentage</th>
                                    <th>Dilate start time</th>
                                    <th>Dilate Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($form_data['items'])): ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($form_data['items'] as $item): ?>
                                        <tr>
                                            <td><?php echo $i; ?>.</td>

                                            <!-- Drop Name (Medicine Name) -->
                                            <td>
                                                <?php 
                                                // Find and display medicine name from the list
                                                $medicine_name = '';
                                                foreach ($medicines as $medicine) {
                                                    if ($medicine['id'] == $item['drop_name']) {
                                                        $medicine_name = $medicine['medicine_name'];
                                                        break;
                                                    }
                                                }
                                                echo $medicine_name;
                                                ?>
                                            </td>

                                            <!-- Salt -->
                                            <td><?php echo $item['salt']; ?></td>

                                            <!-- Percentage -->
                                            <td><?php echo $item['percentage']; ?>%</td>

                                            <td><?php echo $booking_data['dilate_start_time']; ?></td>
                                            
                                            <td><?php echo $booking_data['dilate_time']; ?></td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td>1.</td>
                                        <td>No Data Available</td>
                                        <td>No Data Available</td>
                                        <td>No Data Available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>

                        
                        
                    </div>
                </div>
                <div class="grp" style="width: 100%; text-align: left; margin-top: 10px;padding:20px;">
                    <div class="box-right">
                        <span>
                            <strong>
                                Remarks:
                            </strong>
                            <?php echo isset($form_data['remarks']) ? htmlspecialchars($form_data['remarks']) : 'No remarks available.'; ?>
                        </span>
                    </div>
                </div>

            </form>
            
        </section>
    </div>
    
    </div>
    <div class="footer">
        <hr />
        <p>Powered by Sara Software</p>
    </div>
</body>



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