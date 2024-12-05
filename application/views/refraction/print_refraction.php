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
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            border: 1px solid #000;
            padding: 20px;
            width: 800px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
        }

        .header div {
            width: 80%;
        }

        .header .name-section,
        .header .date-section {
            display: flex;
            justify-content: space-between;
        }

        .name-section input,
        .date-section input {
            /* width: 60%; */
            padding: 5px;
            border: none;
            border-bottom: 1px solid #000;
        }

        .rx-symbol {
            font-size: 36px;
            font-weight: bold;
            color: blue;
        }

        .section-title {
            margin-top: 20px;
            font-size: 18px;
        }

        .prescription-grid {
            margin-top: 10px;
            border-collapse: collapse;
            width: 100%;
        }

        .prescription-grid th,
        .prescription-grid td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .signature-section div {
            width: 45%;
            text-align: center;
        }

        .signature-section input {
            border: none;
            border-bottom: 1px solid #000;
            width: 100%;
            padding: 5px;
        }

        .note {
            margin-top: 20px;
            font-size: 14px;
            text-align: center;
        }

        .header {
            background: none;
        }

        .date-section,
        .name-age-section {
            margin-bottom: 10px;
        }

        .name-age-section {
            display: flex;
            /* justify-content: space-between; */
        }

        .name-section,
        .age-section {
            display: flex;
            align-items: center;
        }

        input {
            margin-left: 10px;
        }

        #name {
            width: 100%;
        }

        .dials {
            display: flex;
            justify-content: space-between;
            width: 55%;
        }

        .dial {
            text-align: center;
            font-size: 36px;
            font-weight: bold;
            color: #000080;
            width: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dial div {
            font-size: 36px;
            color: #000080;
        }
    </style>
     <style>
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

        /* table {s */
        td {
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
            width: 300px !important;
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
            width: 100%;
            /* Ensures full width usage */
            border-collapse: collapse;
            /* Remove spaces between inner table cells */
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
    <?php
    // echo "<pre>";
// print_r($form_data);
// die;
    ?>

<body>
    
    <div class="container-fluid">
        <!-- <p style="text-align: center; font-size: 7px;"><strong>Sara Eye HOSPITALS</strong></p> -->
        <!-- <div class="header">
            <div class="image" align="left" style="border-right: 0;padding: 0;">
                <img src="https://cdn.hexahealth.com/Image/996a9a6d-24fc-48f0-9464-93d36f0f8cfd.jpg" alt="Hospital Image" width="280px">
            </div>
            <div class="info" align="right" style="border-right:0; border-left: 0;width: 850px;">
                <h2>JAMSHEDPUR EYE HOSPITAL</h2>
                <h3>Sakchi, Jamshedpur- 831001, Jharkhand, India</h3>
                <p>Phone (0657) 2432203, 2422933; Email : jamshedpureyehospital@gmail.com</p>
            </div>
        </div> -->
        <div class="header-print">
            <img width="280px" src="https://cdn.hexahealth.com/Image/996a9a6d-24fc-48f0-9464-93d36f0f8cfd.jpg">
            <div class="hospital-info">
                <h1>JAMSHEDPUR EYE HOSPITAL</h1>
                <p>Sakchi, Jamshedpur- 831001, Jharkhand, India</p>
                <p>Phone: (0657) 2432203, 2422933; Email: jamshedpureyehospital@gmail.com</p>
            </div>
        </div>
        
        <!-- Header section for Name, Date, Age -->
        <div class="row">
            <div class="col-md-6">
                <div class="date-section">
                    <label for="date">Date:</label>
                    <span
                        style="width: 100%; padding: 10px;"><?php echo date('d-m-Y H:i', strtotime($form_data['date'])); ?></span>
                </div>
                <div class="name-age-section">
                    <div class="name-section" style="width: 37%;">
                        <label for="age">Name:</label>
                        <span style="padding: 10px;"> <?php echo $form_data['patient_name']; ?></span>
                    </div>
                    <div class="name-section">
                        <label for="age">Age:</label>
                        <span style="padding: 10px;"> <?php echo $form_data['age']; ?></span>
                    </div>
                    <!-- <div class="name-section">
                        <label for="age">Token No:</label>
                        <span style="padding: 10px;"> <?php echo $form_data['token_no']; ?></span>
                    </div> -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="dials">

                    <div class="dial">
                        <div>R</div>
                    </div>

                    <div class="dial">
                        <div>L</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prescription Symbol -->
        <div class="row">
            <div class="col-md-6">
                <!-- Prescription Notes / Rejection -->
                <!-- <div class="section-title" style="display: flex; justify-content: space-between;">
                    <span>Rejection</span>
                </div> -->
                <!-- <textarea rows="4" style="width: 100%; border: 1px solid #000; padding: 10px;"></textarea> -->
                <div class="rx-symbol">℞</div>

                <!-- Prescription Details -->
                <!-- <div class="section-title" style="display: flex; justify-content: space-between;">
                    <span>Prescription Details:</span>
                </div> -->

            </div>
            <div class="col-md-6">
                <!-- Left Eye (ARx) - Auto Refraction -->
                <!-- <div class="col-md-4">
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
                                    <span
                                        class="auto_ref"><?= isset($form_data['refraction_ar_l_dv_sph']) ? htmlspecialchars($form_data['refraction_ar_l_dv_sph']) : '' ?></span>
                                </td>
                                <td>
                                    <span
                                        class="auto_ref"><?= isset($form_data['refraction_ar_l_dv_cyl']) ? htmlspecialchars($form_data['refraction_ar_l_dv_cyl']) : '' ?></span>
                                </td>
                                <td>
                                    <span
                                        class="auto_ref"><?= isset($form_data['refraction_ar_l_dv_axis']) ? htmlspecialchars($form_data['refraction_ar_l_dv_axis']) : '' ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left;">NV</td>
                                <td>
                                    <span
                                        class="auto_ref"><?= isset($form_data['refraction_ar_l_nv_sph']) ? htmlspecialchars($form_data['refraction_ar_l_nv_sph']) : '' ?></span>
                                </td>
                                <td>
                                    <span
                                        class="auto_ref"><?= isset($form_data['refraction_ar_l_nv_cyl']) ? htmlspecialchars($form_data['refraction_ar_l_nv_cyl']) : '' ?></span>
                                </td>
                                <td>
                                    <span
                                        class="auto_ref"><?= isset($form_data['refraction_ar_l_nv_axis']) ? htmlspecialchars($form_data['refraction_ar_l_nv_axis']) : '' ?></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> -->

                <!-- Right Eye (ARx) - Auto Refraction -->
                <!-- <div class="col-md-4">
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
                                    <span
                                        class="auto_ref"><?= isset($form_data['refraction_ar_r_dv_sph']) ? htmlspecialchars($form_data['refraction_ar_r_dv_sph']) : '' ?></span>
                                </td>
                                <td>
                                    <span
                                        class="auto_ref"><?= isset($form_data['refraction_ar_r_dv_cyl']) ? htmlspecialchars($form_data['refraction_ar_r_dv_cyl']) : '' ?></span>
                                </td>
                                <td>
                                    <span
                                        class="auto_ref"><?= isset($form_data['refraction_ar_r_dv_axis']) ? htmlspecialchars($form_data['refraction_ar_r_dv_axis']) : '' ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left;">NV</td>
                                <td>
                                    <span
                                        class="auto_ref"><?= isset($form_data['refraction_ar_r_nv_sph']) ? htmlspecialchars($form_data['refraction_ar_r_nv_sph']) : '' ?></span>
                                </td>
                                <td>
                                    <span
                                        class="auto_ref"><?= isset($form_data['refraction_ar_r_nv_cyl']) ? htmlspecialchars($form_data['refraction_ar_r_nv_cyl']) : '' ?></span>
                                </td>
                                <td>
                                    <span
                                        class="auto_ref"><?= isset($form_data['refraction_ar_r_nv_axis']) ? htmlspecialchars($form_data['refraction_ar_r_nv_axis']) : '' ?></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> -->
                <!-- <div class="section-title">Prescription Details:</div> -->
                <table class="prescription-grid">
                    <thead>
                        <tr>
                            <th></th>
                            <th>SPH</th>
                            <th>CYL</th>
                            <th>AXIS</th>
                            <th>SPH</th>
                            <th>CYL</th>
                            <th>AXIS</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>DV</td>
                            <td><?= isset($form_data['refraction_ar_l_dv_sph']) ? htmlspecialchars($form_data['refraction_ar_l_dv_sph']) : '' ?>
                            </td>
                            <td><?= isset($form_data['refraction_ar_l_dv_cyl']) ? htmlspecialchars($form_data['refraction_ar_l_dv_cyl']) : '' ?>
                            </td>
                            <td><?= isset($form_data['refraction_ar_l_dv_axis']) ? htmlspecialchars($form_data['refraction_ar_l_dv_axis']) : '' ?>
                            </td>
                            <td><?= isset($form_data['refraction_ar_r_dv_sph']) ? htmlspecialchars($form_data['refraction_ar_r_dv_sph']) : '' ?>
                            </td>
                            <td><?= isset($form_data['refraction_ar_r_dv_cyl']) ? htmlspecialchars($form_data['refraction_ar_r_dv_cyl']) : '' ?>
                            </td>
                            <td><?= isset($form_data['refraction_ar_r_dv_axis']) ? htmlspecialchars($form_data['refraction_ar_r_dv_axis']) : '' ?>
                            </td>
                        </tr>
                        <tr>
                            <td>NV</td>
                            <td><?= isset($form_data['refraction_ar_l_nv_sph']) ? htmlspecialchars($form_data['refraction_ar_l_nv_sph']) : '' ?>
                            </td>
                            <td><?= isset($form_data['refraction_ar_l_nv_cyl']) ? htmlspecialchars($form_data['refraction_ar_l_nv_cyl']) : '' ?>
                            </td>
                            <td><?= isset($form_data['refraction_ar_l_nv_axis']) ? htmlspecialchars($form_data['refraction_ar_l_nv_axis']) : '' ?>
                            </td>
                            <td><?= isset($form_data['refraction_ar_r_nv_sph']) ? htmlspecialchars($form_data['refraction_ar_r_nv_sph']) : '' ?>
                            </td>
                            <td><?= isset($form_data['refraction_ar_r_nv_cyl']) ? htmlspecialchars($form_data['refraction_ar_r_nv_cyl']) : '' ?>
                            </td>
                            <td><?= isset($form_data['refraction_ar_r_nv_axis']) ? htmlspecialchars($form_data['refraction_ar_r_nv_axis']) : '' ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>
        <div style="width:60%;">
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
        <div class="row">
            <div class="col-md-6">
                <div class="footer-note" style="margin-top: 20px;">
                    <b>On future visit, please bring this prescription.</b>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Signature Section -->
                <div class="signature-section" style="display: flex; justify-content: space-between;">
                    <div>
                        <label for="optometrist">Signature of Optometrist:</label>
                        <br />
                        <!-- <input type="text" id="optometrist"> -->
                        <span class="border-top pt-2 mx-auto" style="display: inline-block; width: 200px; border-top:1px solid black; margin-top: 24px;"><strong><?php echo $form_data['optometrist_signature_name'];?></strong></span>
                    </div>
                    <div>
                        <label for="doctor">Signature of Doctor:</label>
                        <br />
                        <span class="border-top pt-2 mx-auto" style="display: inline-block; width: 200px; border-top:1px solid black; margin-top: 24px;"><strong><?php echo $form_data['doctor_signature_name'];?></strong></span>
                        <!-- <input type="text" id="doctor"> -->
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

</html>