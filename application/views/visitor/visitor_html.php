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

    td,
    th {
      padding-left: 3px;
      font: 13px Arial;
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
      <th style="text-align: left;"><?php echo $data = get_setting_value('PATIENT_REG_NO'); ?></th>
      <th style="text-align: left;">Visitor Type</th>
      <th style="text-align: left;">From</th>
      <th style="text-align: left;">Visitor Name</th>
      <th style="text-align: left;">Mobile No.</th>
      <th style="text-align: left;">Purpose</th>
      <th style="text-align: left;">Employee</th>
      <th style="text-align: left;">Created Date</th>
    </tr>
    <?php
    if (!empty($data_list)) {
      echo "<pre>";
      print_r($data_list);
      die;
      $i = 1;
      foreach ($data_list as $visitor) {
        // $genders = array('0'=>'Female','1'=>'Male','2'=>'Other');
        // $gender = $genders[$visitor->gender];
        // $age_y = $visitor->age_y;
        // $age_m = $visitor->age_m;
        // $age_d = $visitor->age_d;
        // $age = "";
        // if($age_y>0)
        // {
        // $year = 'Years';
        // if($age_y==1)
        // {
        //   $year = 'Year';
        // }
        // $age .= $age_y." ".$year;
        // }
        // if($age_m>0)
        // {
        // $month = 'Months';
        // if($age_m==1)
        // {
        //   $month = 'Month';
        // }
        // $age .= ", ".$age_m." ".$month;
        // }
        // if($age_d>0)
        // {
        // $day = 'Days';
        // if($age_d==1)
        // {
        //   $day = 'Day';
        // }
        // $age .= ", ".$age_d." ".$day;
        // }
        // $patient_age =  $age;
        ?>
        <tr>
          <td><?php echo $visitor->visitor_type_name; ?></td>
          <td><?php echo $visitor->from; ?></td>
          <td><?php echo $visitor->visitor_name; ?></td>
          <td><?php echo $visitor->mobile_no; ?></td>
          <td><?php echo $visitor->purpose; ?></td>
          <td><?php echo $visitor->employee_name; ?></td>

          <td><?php echo date('d-m-Y h:i A', strtotime($visitor->created_date)); ?></td>


        </tr>
        <?php
        $i++;
      }
    }
    ?>
  </table>
</body>

</html>