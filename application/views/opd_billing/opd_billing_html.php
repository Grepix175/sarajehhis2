<html>

<head>
  <title>Patient Report</title>
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
</head>

<body>
  <table width="100%" cellpadding="0" cellspacing="0" border="1px" style="font:13px Arial;">
    <tr>
      <!--  <th>S.No.</th> -->
      <th>Patient Reg. No.</th>
      <th>Receipt No.</th>
      <th>Patient Name</th>
      <th>Gender</th>
      <th>Mobile No.</th>
      <th>Billing Date</th>
      <th>Token No</th>
      <th>Village/Town</th>
      <th>Referred By</th>
      <th>Mode of Payment</th>
      <th>Total Amount</th>
      <th>Net Amount</th>
      <th>Paid Amount</th>
      <th>Discount</th>

    </tr>
    <?php
    if (!empty($data_list)) {
      
      $i = 1;
      foreach ($data_list as $opds) {
        $attended_doctor_name = "";
        $attended_doctor_name = get_doctor_name($opds->attended_doctor);
        $specialization_id = get_specilization_name($opds->specialization_id);
        $booking_code = $opds->booking_code;
        $patient_name = $opds->patient_name;
        $confirm_date = date('d M Y', strtotime($opds->confirm_date));
        $booking_date = date('d-m-Y h:i A', strtotime($opds->booking_date . ' ' . $opds->booking_time));
        $genders = array('0' => 'Female', '1' => 'Male', '2' => 'Others');
        $gender = $genders[$opds->gender];
        $genders = array('0' => 'Female', '1' => 'Male');
        $referredBy = $row[] = $opds->referred_by == 0 ? 'Doctor' : 'Hospital';
        $gender = $genders[$opds->gender];
        $age_y = $opds->age_y;
        $age_m = $opds->age_m;
        $age_d = $opds->age_d;
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
        $patient_age = $age;
        $booking_date = date('d-m-Y', strtotime($opds->booking_date));
        ?>
        <tr>
          <!--   <td><?php //echo $i; ?>.</td> -->
          <td><?php echo $opds->patient_code; ?></td>
          <td><?php echo $opds->reciept_code; ?></td>
          <td><?php echo $opds->patient_name; ?></td>
          <td><?php echo $gender; ?></td>
          <td><?php echo $opds->mobile_no; ?></td>
          <td><?php echo $booking_date; ?></td>
          <td><?php echo $opds->token_no; ?></td>
          <td><?php echo $referredBy; ?></td>
          <td><?php echo $opds->payment_mode; ?></td>
          <td><?php echo $opds->total_amount; ?></td>
          <td><?php echo $opds->net_amount; ?></td>
          <td><?php echo $opds->paid_amount; ?></td>
          <td><?php echo $opds->discount; ?></td>
        </tr>
        <?php
        $i++;
      }
    }
    ?>
  </table>
</body>

</html>