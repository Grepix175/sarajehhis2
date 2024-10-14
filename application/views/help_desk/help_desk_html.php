<html><head>
<!--<title>Patient Report</title>-->
<?php
if($print_status==1)
{
?>
<script type="text/javascript">
window.print();
window.onfocus=function(){ window.close();}
</script>
<?php	
}
?>
<style>
body
{
	font-size: 10px;
}	
td
{
	padding-left:15px;
}
 .header-title {
        text-align: center;  /* Center the text */
        font-weight: bold;   /* Make the text bold */
        font-size: 18px;     /* Increase font size */
        padding: 10px;       /* Add padding inside the div */
        border: 2px solid black;  /* Add a solid border */
        margin-bottom: 20px; /* Add margin below for spacing */
        display: inline-block;
        width: 100%;
        box-sizing: border-box; /* Ensure padding does not affect width */
    }
</style>
</head><body>
    <div class="header-title"><?php echo $mainHeader; ?></div>
<table width="100%" cellpadding="0" cellspacing="0" border="1px">
 <tr>

      <th>Token No.</th>
      <th>OPD No.</th>
    <th>Patient Reg. No.</th>
      <th>Patient Name</th>
      <th>Mobile No.</th>
      <th>Age</th>
      <th>Patient Status</th>

 </tr>
 <?php
   if(!empty($data_list))
   {
   	 
   	 $i=1;
   	 foreach($data_list as $opds)
   	 {
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
        $pat_status = '';
        $patient_status = $this->opd->get_by_id_patient_details($opds->booking_id);

        if ($patient_status['completed'] == '1') {
          $pat_status = 'Completed';
        } else if ($patient_status['doctor'] == '1') {
          $pat_status = 'Doctor';
        } else if ($patient_status['optimetrist'] == '1') {
          $pat_status = 'Opt.Optom';
        } else if ($patient_status['reception'] == '1') {
          $pat_status = 'Reception';
        } else if ($patient_status['arrive'] == '1') {
          $pat_status = 'Arrived';
        } else {
          $pat_status = 'Not Arrived';
        }
   	   ?>
   	    <tr>
          <td><?php echo $opds->token_no; ?></td>
          <td><?php echo $opds->booking_code; ?></td>
   	      <td><?php echo $opds->patient_code; ?></td>
          <td><?php echo $opds->patient_name; ?></td>
          <td><?php echo $opds->mobile_no; ?></td>
          <td><?php echo $age; ?></td>
          <td><?php echo $pat_status; ?></td>
     </tr>
   	   <?php
   	   $i++;	
   	 }	
   }
 ?> 
</table>
</body></html>