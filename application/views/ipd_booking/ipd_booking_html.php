<html><head>
<title>IPD Booking</title>
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
  padding-left:3px;
}
</style>
</head><body>
<table width="100%" cellpadding="0" cellspacing="0" border="1px" style="font:8px Arial;">
 <tr>
     <th>Id</th>
    <th>Token No.</th>
    <th>IPD No.</th> 
    <th><?php echo $data= get_setting_value('PATIENT_REG_NO');?></th>  
    <th>Patient Name </th> 
    <th>Category</th>
    <th>Village/Town</th>
    <th>Gender</th>
    <th>Age</th>
    <th>Mobile No.</th> 
    <th>Admission Date</th>
    <th>Surgeon Name</th>
    <th>Operation Name</th>
    <th>Package Name</th>
    <th>Eye Details</th>
    <th>Surgery Type</th>
    <th>Operation Room Type</th>
    <th>Advance Amount</th>
    
 </tr>
 <?php
   if(!empty($data_list))
   {
   	//  echo "<pre>";print_r($data_list);
   	 $i=1;
   	 foreach($data_list as $reports)
   	 {
   	  
   	        $age_y = $reports->age_y;
                $age_m = $reports->age_m;
                $age_d = $reports->age_d;
                //$age_h = $ipd_booking->age_h;
                $age = "";
                if($age_y>0)
                {
                $year = 'Years';
                if($age_y==1)
                {
                  $year = 'Year';
                }
                $age .= $age_y." ".$year;
                }
                if($age_m>0)
                {
                $month = 'Months';
                if($age_m==1)
                {
                  $month = 'Month';
                }
                $age .= ", ".$age_m." ".$month;
                }
                if($age_d>0)
                {
                $day = 'Days';
                if($age_d==1)
                {
                  $day = 'Day';
                }
                $age .= ", ".$age_d." ".$day;
                }
                /*if($age_h>0)
                {
                $hours = 'Hours';
                
                $age .= " ".$age_h." ".$hours;
                } */
            ///////////////////////////////////////
           
            
            $genders = array('0'=>'Female','1'=>'Male','2'=>'Others');
        
            $age_gender = $genders[$reports->gender].'/'.$age;
   	     if($reports->discharge_date =='0000-00-00 00:00:00')
                {
                	$createdate ='';	
                }
                else
                {
                	$createdate = date('d-M-Y h:i A',strtotime($reports->discharge_date));
                }
   	   ?>
   	    <tr>
   	        <td><?php echo $i; ?>.</td>
      		 	<td><?php echo $reports->token; ?></td>
      		 	<td><?php echo $reports->ipd_no; ?></td>
      		 	<td><?php echo $reports->patient_code; ?></td>
      		 	<td><?php echo $reports->patient_name; ?></td>
      		 	<td><?php echo $reports->patient_category_name; ?></td>
                <td><?php echo $reports->address; ?></td>
                <td><?php echo $genders[$reports->gender]; ?></td>
                <td><?php echo $age; ?></td>
      		 	<td><?php echo $reports->mobile_no; ?></td>
      		 	<td><?php echo date('d-M-Y',strtotime($reports->admission_date)); ?></td>
      		 	<!--<td><?php echo $reports->insurance_type; ?></td>-->
      		 	<td><?php echo $reports->surgeon_name; ?></td>
            <td><?php echo $reports->operation_name; ?></td>
            <td><?php echo $reports->package_name; ?></td>
            <td><?php echo $reports->eye_details; ?></td>
            <td><?php echo $reports->surgery_type; ?></td>
            <td><?php echo $reports->room_type; ?></td>
            <td><?php echo $reports->advance_payment; ?></td>
      	
		 </tr>
   	   <?php
   	   $i++;	
   	 }	
   }
 ?> 
</table>
</body></html>