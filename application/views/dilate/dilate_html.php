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

    <!--<th> Token No </th>-->
    <th> Patient Reg No. </th>
    <th> OPD No. </th>
    <th> Drop Name </th>
    <th> Patient Name </th>
    <!-- <th> Gender </th> -->
    <!-- <th> Patient Category </th> -->
    <th> Salt </th>
    <!-- <th> Age </th> -->
    <!-- <th> Consultant </th> -->
    <!-- <th> Lens </th> -->
    <!-- <th> Comment </th> -->
    <th> Patient Status </th>
    <th> Created Date </th>

 </tr>
 <?php
//  
   if(!empty($grouped_data))
   {
   	 
   	 $i=1;
   	 foreach($grouped_data as $dilate)
   	 {
         
        //echo "<pre>";print_r($dilate);die;
            
   	   ?>
   	    <tr>
          <!--<td><?php //echo $dilate[token_no; ?></td>-->
          <td><?php echo $dilate['patient_id']; ?></td>
   	      <td><?php echo $dilate['booking_id']; ?></td>
          <td><?php echo $dilate['medicine_names']; ?></td>
          <td><?php echo $dilate['patient_name']; ?></td>
          <td><?php echo $dilate['salts']; ?></td>
          <td><?php echo ($dilate['status'] == 1) ? 'Active' : 'Inactive'; ?></td>
          <td><?php echo date('d-M-Y', strtotime($dilate['created_date'])); ?></td>
          </tr>
   	   <?php
   	   $i++;	
   	 }	
   }
 ?> 
</table>
</body></html>