<html>

<head>
    <!--<title>Patient Report</title>-->
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
            padding-left: 15px;
        }

        .header-title {
            text-align: center;
            /* Center the text */
            font-weight: bold;
            /* Make the text bold */
            font-size: 18px;
            /* Increase font size */
            padding: 10px;
            /* Add padding inside the div */
            border: 2px solid black;
            /* Add a solid border */
            margin-bottom: 20px;
            /* Add margin below for spacing */
            display: inline-block;
            width: 100%;
            box-sizing: border-box;
            /* Ensure padding does not affect width */
        }
    </style>
</head>

<body>
    <div class="header-title"><?php echo $mainHeader; ?></div>
    <table width="100%" cellpadding="0" cellspacing="0" border="1px">
        <tr>
            <th>Token No</th>
            <th>OPD No</th>
            <th>Patient Reg No.</th>
            <th>Patient Name</th>
            <th>Gender</th>
            <th>Mobile No</th>
            <th>Age</th>
            <th>Status</th>
            <th>Patient Status</th>
            <th>Doctore</th>
            <th>Room No</th>
            <th>Created Date</th>
        </tr>
        <?php
        if (!empty($data_list)) {
            foreach ($data_list as $ortho_paedic) {
                $age_y = $ortho_paedic->age_y;
                $age_m = $ortho_paedic->age_m;
                $age_d = $ortho_paedic->age_d;

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
                $gender = array('0' => 'Female', '1' => 'Male', '2' => 'Others');
                ?>
                <tr>
                    <td><?php echo $ortho_paedic->token_no; ?></td>
                    <td><?php echo $ortho_paedic->booking_code; ?></td>
                    <td><?php echo $ortho_paedic->patient_code; ?></td>
                    <td><?php echo $ortho_paedic->patient_name; ?></td>
                    <td><?php echo $gender[$ortho_paedic->gender]; ?></td>
                    <td><?php echo $ortho_paedic->mobile_no; ?></td>
                    <td><?php echo $age; ?></td>
                    <td><?php echo $ortho_paedic->status == 0 ? 'Pending' : 'Complete'; ?></td>
                    <td><?php
                    $statuses = explode(',', $ortho_paedic->pat_status);

                    // Trim any whitespace from the statuses and get the last one
                    $last_status = trim(end($statuses));
                    echo ($last_status); ?></td>
                    <td><?php echo $ortho_paedic->doctor_name; ?></td>
                    <td><?php echo $ortho_paedic->room_no; ?></td>
                    <td><?php echo date('d-M-Y', strtotime($ortho_paedic->created_date)); ?></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
</body>

</html>