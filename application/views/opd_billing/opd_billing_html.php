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

 </tr>
 <?php
   if(!empty($data_list))
   {
   	 
   	 $i=1;
   	 foreach($data_list as $opds)
   	 {
        $booking_date = date('d-m-Y h:i A', strtotime($opds->booking_date . ' ' . $opds->booking_time));
        $genders = array('0' => 'Female', '1' => 'Male', '2' => 'Others');
        $gender = $genders[$opds->gender];
        $referredBy = $opds->referred_by == 0 ? 'Doctor' : 'Hospital';
   	   ?>
   	    <tr>
   	      <td><?php echo $opds->patient_code; ?></td>
          <td><?php echo $opds->reciept_code; ?></td>
          <td><?php echo $opds->patient_name; ?></td>
          <td><?php echo $gender; ?></td>
          <td><?php echo $opds->mobile_no; ?></td>
          <td><?php echo $booking_date; ?></td>
          <td><?php echo $opds->token_no; ?></td>
          <td><?php echo $opds->address; ?></td>
          <td><?php echo $referredBy; ?></td>
          <td><?php echo $opds->payment_mode; ?></td>
          <td><?php echo $opds->total_amount; ?></td>
          <td><?php echo $opds->net_amount; ?></td>
          <td><?php echo $opds->paid_amount; ?></td>
     </tr>
   	   <?php
   	   $i++;	
   	 }	
   }
 ?> 
</table>
</body></html>