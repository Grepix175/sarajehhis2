<html><head>
<title>Medicine Report</title>
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
<table width="100%" cellpadding="0" cellspacing="0" border="1px">
 <tr>
    <th>Sr.No.</th>
     <th>Hospital Code</th>
    <th>Item Desc</th>
    <th>Unit</th>
    <th>Manufacturer</th>
    <th>Qty.</th>
    <th>Hospital Rate</th>
    <th>Created Date</th>
    
  </tr>
 <?php
   if(!empty($data_list))
   {
   	 //echo "<pre>";print_r($data_list); die;
   	 $i=1;
   	 foreach($data_list as $data)
   	 {
   	   ?>
   	    <tr>
   	        <td><?php echo $i; ?>.</td>
            <td><?php echo $data->hospital_code; ?></td>
      		 	<td><?php echo $data->item_desc; ?></td>
            <td ><?php echo $data->medicine_unit; ?></td>
      		 	<td><?php echo $data->company_name; ?></td>
            <td><?php echo $data->qty; ?></td>
      		 	<td><?php echo $data->hospital_rate; ?></td>
      		 	<td><?php echo date('d-M-Y H:i A', strtotime($reports->created_date)); ?></td>
      		 
      </tr>
   	   <?php
   	   $i++;	
   	 }	
   }
 ?> 
</table>
</body></html>