<html>

<head>
    <title>Contact Lens List</title>
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
            font-size: 10px;
        }

        td {
            padding-left: 3px;
        }
    </style>
    <style>
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

        .patient-info-table th,
        .patient-info-table td {
            border: none;
        }

        .info-label {
            font-weight: bold;
            white-space: nowrap;
        }

        .info-content {
            padding-left: 5px;
        }

        .left-column,
        .right-column {
            width: 50%;
        }

        .left-column td,
        .right-column td {
            padding: 2px;
        }

        .right-column .info-label {
            text-align: right;
        }
    </style>
</head>

<body>
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
    <table class="patient-info-table">
        <tr>
            <td class="left-column">
                <table>
                    <tr>
                        <td class="info-label">Patient</td>
                        <td class="info-content">:<?php echo $data_list[0]['patient_name']; ?></td>
                    </tr>
                    <tr>
                        <td class="info-label">Patient Reg. No</td>
                        <td class="info-content">: <?php echo $data_list[0]['patient_code']; ?></td>
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
                        <td class="info-label">Gender:</td>
                        <td class="info-content">: <?php echo $data_list[0]['gender']; ?></td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
    <!-- Patient Details Section -->
    <!-- <table width="100%" cellpadding="5" cellspacing="0" border="1"
        style="font-family: Arial, sans-serif; font-size: 12px; border-collapse: collapse;">
        <tr>
            <td colspan="2"
                style="font-weight: bold; font-size: 14px; text-align: center; padding: 10px 0; font-family: Arial, sans-serif; border: 1px solid black;">
                Patient Details
            </td>
        </tr>
        <tr>
            <td style="text-align: center; border: 1px solid black;"><strong>Name:</strong>
                <?php echo $data_list[0]['patient_name']; ?></td>
            <td style="text-align: center; border: 1px solid black;"><strong>Patient Reg. No:</strong>
                <?php echo $data_list[0]['patient_code']; ?></td>
        </tr>
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
        <tr>
            <td style="text-align: center; border: 1px solid black;"><strong>Mobile No:</strong>
                <?php echo $data_list[0]['mobile_no']; ?></td>
            <td style="text-align: center; border: 1px solid black;"><strong>Age:</strong> <?php echo $age; ?></td>
        </tr>
        <tr>
            <td style="text-align: center; border: 1px solid black;"><strong>Gender:</strong>
                <?php echo $data_list[0]['gender']; ?></td>
        </tr>
    </table> -->


    <table width="100%" cellpadding="5" cellspacing="0"
        style="font:14px Arial; margin-bottom: 10px;  margin-top: 10px;  text-align: center;">
        <tr>
            <td><strong>Internal Communications</strong></td>
        </tr>
    </table>
    <h3><strong>With Intermidiate effect below mentioned device is chargeable to patient for Contact Lens</strong></h3>
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
            //  echo "<pre>";print_r($data_list);
            $i = 1;
            foreach ($data_list[0]['contact_lens'] as $contact_lens) {
                // echo "<pre>";
                // print_r($contact_lens);
                // die;
                if ($contact_lens->discharge_date == '0000-00-00 00:00:00') {
                    $createdate = '';
                } else {
                    $createdate = date('d-M-Y h:i A', strtotime($contact_lens->discharge_date));
                }
                ?>
                <tr>
                    <td><?php echo $i; ?>.</td>
                    <td><?php echo $contact_lens['hospital_code']; ?></td>
                    <td><?php echo $contact_lens['item_description']; ?></td>
                    <td><?php echo $contact_lens['menufacturer']; ?></td>
                    <td><?php echo $contact_lens['qty']; ?></td>
                    <td><?php echo $contact_lens['unit']; ?></td>
                    <td><?php echo $contact_lens['hospital_rate']; ?></td>
                    <td><?php echo date('d-M-Y h:i A', strtotime($contact_lens->created_date)); ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </table>
    <div style="margin-top:20px; margin-bottom: 20px;">
        <div style="margin-bottom: 24px; display: flex; justify-content: space-between;">
            <div style="text-align: left; width: 48%;">
                <p style="font-weight: bold;">Signature</p>
                <div style="border-top: 1px solid #000; padding-top: 8px; width: 50%; margin-top: 24px;">
                </div>
            </div>
            <div style="text-align: right; width: 48%;">
                <p style="font-weight: bold;">Signature</p>
                <div style="border-top: 1px solid #000; padding-top: 8px; width: 50%; margin-top: 24px; float: right;">
                </div>
            </div>
        </div>
    </div>
</body>

</html>