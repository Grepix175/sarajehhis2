<html>
<?php error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING); ?>

<head>
    <title>Contact Lens</title>
    <?php
    if ($print_status == 1) {
        ?>
        <script type="text/javascript">
            window.print();
            window.onfocus = function () { window.close(); }
        </script>
        <?php
    }
    ?>
    <style>
        body {
            font-size: 7px;
            /* Reduced font size */
        }

        table {
            margin-top: 5px;
        }

        td {
            padding-left: 3px;
        }

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

        .patient-info-table {
            width: 100%;
            border: 1px solid #000;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }

        .patient-info-table td {
            padding: 5px;
            vertical-align: top;
        }

        .info-label {
            font-weight: bold;
            white-space: nowrap;
            padding-right: 5px;
            /* Space between label and content */
        }

        .info-content {
            padding-left: 5px;
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
</head>

<body>
<div class="container-fluid">
    <div class="header-print">
        <img width="280px" src="https://cdn.hexahealth.com/Image/996a9a6d-24fc-48f0-9464-93d36f0f8cfd.jpg">
        <div class="hospital-info">
            <h1>JAMSHEDPUR EYE HOSPITAL</h1>
            <p>Sakchi, Jamshedpur- 831001, Jharkhand, India</p>
            <p>Phone: (0657) 2432203, 2422933; Email: jamshedpureyehospital@gmail.com</p>
        </div>
    </div>

    <?php
    // Loop through the contact lens data
    $age_y = $data_list[0]['age_y'];
    $age_m = $data_list[0]['age_m'];
    $age_d = $data_list[0]['age_d'];

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
                        <td class="info-content">: <?php echo $data_list[0]['patient_name']; ?></td>
                    </tr>
                    <tr>
                        <td class="info-label">Patient Reg. No</td>
                        <td class="info-content">: <?php echo $data_list[0]['patient_code']; ?></td>
                    </tr>
                    <tr>
                        <td class="info-label">OPD No</td>
                        <td class="info-content">: <?php echo $data_list[0]['booking_code']; ?></td>
                    </tr>
                    <tr>
                        <td class="info-label">Token No</td>
                        <td class="info-content">: <?php echo $data_list[0]['token_no']; ?></td>
                    </tr>
                </table>
            </td>
            <td class="right-column">
                <table>
                    <tr>
                        <td class="info-label">Mobile no.</td>
                        <td class="info-content">: <?php echo $data_list[0]['mobile_no']; ?></td>
                    </tr>
                    <tr>
                        <td class="info-label">Age</td>
                        <td class="info-content">: <?php echo $age; ?></td>
                    </tr>
                    <tr>
                        <td class="info-label">Gender</td>
                        <td class="info-content">: <?php echo ($data_list[0]['gender'] == '0') ? 'Female' : 'Male'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">Date/Time</td>
                        <td class="info-content">: <?php echo date('d-m-Y h:i A', strtotime($created_date)); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table width="100%" cellpadding="5" cellspacing="0"
        style="font:10px Arial; margin-bottom: 10px;  margin-top: 20px;  text-align: center;">
        <tr>
            <td><strong>Internal Communications</strong></td>
        </tr>
    </table>
    <h3 style="font-size: 12px;"><strong>With Intermidiate effect below mentioned device is chargeable to patient for
            Contact Lens</strong></h3>
    <table width="100%" cellpadding="0" cellspacing="0" border="1px">
        <tr>
            <th>Sr. No</th>
            <th> Hospital Code </th>
            <th> Item Description </th>
            <th> Menufacturer </th>
            <th> Qty </th>
            <th> Unit </th>
            <th> Hospital Rate </th>
            <th> Created Date </th>
        </tr>
        <?php
        if (!empty($data_list)) {
            $i = 1;
            foreach ($data_list[0]['contact_lens'] as $contact_lens) {

                ?>
                <tr>
                    <td><?php echo $i; ?>.</td>
                    <td><?php echo $contact_lens['hospital_code']; ?></td>
                    <td><?php echo $contact_lens['item_description']; ?></td>
                    <td><?php echo $contact_lens['menufacturer']; ?></td>
                    <td><?php echo $contact_lens['qty']; ?></td>
                    <td><?php echo $contact_lens['unit']; ?></td>
                    <td><?php echo $contact_lens['hospital_rate']; ?></td>
                    <td><?php echo date('d-M-Y h:i A', strtotime($contact_lens['created_date'])); ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </table>
    <div style="margin-top: 40px; margin-bottom: 20px;">
        <div style="margin-bottom: 24px; display: flex; justify-content: space-between;">
            <div style="text-align: left; width: 48%;">
                <p style="font-weight: bold; font-size: 10px; margin-top: 10px;">Signature of Optometrist</p>
                <strong
                    style="display: inline-block; font-size: 15px; text-align: center; width: 200px; border-top:1px solid black; margin-top: 24px;"><?php echo $data_list[0]['optometrist_signature_name']; ?></strong>
                <!-- Increased font size -->
                <!-- <div style="border-top: 1px solid #000; padding-top: 8px; width: 50%; margin-top: 30px;">
                </div> -->
            </div>
            <div style="text-align: right; width: 48%;">
                <p style="font-weight: bold; font-size: 10px; margin-top: 10px;">Signature of Doctor</p>
                <strong
                    style="display: inline-block; font-size: 15px; text-align: center; width: 200px; border-top:1px solid black; margin-top: 24px;"><?php echo $data_list[0]['doctor_signature_name']; ?></strong>
                <!-- Increased font size -->

            </div>
        </div>
    </div>

    <div class="footer">
        <hr />
        <p>Powered by Sara Software</p>
    </div>
</div>
</body>

</html>