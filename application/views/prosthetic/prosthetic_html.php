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
      <th>Created Date</th>

 </tr>
 <?php
   if(!empty($data_list))
   {
   	 $i=1;
   	 foreach($data_list as $prosthetic)
   	 {
         $age_y = $prosthetic->age_y;
        $age_m = $prosthetic->age_m;
        $age_d = $prosthetic->age_d;

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
          <td><?php echo $prosthetic->token; ?></td>
          <td><?php echo $prosthetic->booking_id; ?></td>
   	      <td><?php echo $prosthetic->patient_code; ?></td>
          <td><?php echo $prosthetic->patient_name; ?></td>
          <td><?php echo $prosthetic->mobile_no; ?></td>
          <td><?php echo $age; ?></td>
          <td><?php 
          $statuses = explode(',', $prosthetic->pat_status);
          
          // Trim any whitespace from the statuses and get the last one
          $last_status = trim(end($statuses));
          echo ($last_status); ?></td>
          <!-- <td><?php echo $prosthetic->created; ?></td> -->
          <td><?php echo date('d-m-Y h:i A', strtotime($prosthetic->created)); ?></td>
          </tr>
   	   <?php
   	   $i++;	
   	 }	
   }
 ?> 
</table>
</body></html>