<html><head>
<title>Item Manage Report</title>
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
*{margin:0;padding:0;box-sizing:border-box;}
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
<table width="100%" cellpadding="0" cellspacing="0" border="1px" style="font:13px Arial;">
 <tr>
    <th>Sr.No.</th>
    <th>Item Code</th>
    <th>Item Name</th>
    <th>MRP </th>
    <th>Price</th>
    <th>Category</th>
    <th>Quantity</th>
    <th>Min.Alert</th>
    <th>Rack No.</th>
    <th>Created Date</th>
 </tr>
 <?php
   if(!empty($data_list))
   {
    $qty='';
   	 //echo "<pre>";print_r($data_list); die;
   	 $i=1;
   	 foreach($data_list as $data)
   	 {
       $qty_data = get_item_quantity($data->id,$data->category_id);
        if($qty_data['total_qty']>=0)
        {
          $qty = $qty_data['total_qty'];
        }
        else
        {
          $qty='0';
        }
   	   ?>
   	    <tr>
            <td><?php echo $i; ?>.</td>
   	        <td><?php echo $data->item_code; ?></td>
      		<td><?php echo $data->item; ?></td>
            <td><?php echo $data->mrp; ?></td>
      		<td><?php echo $data->price; ?></td>
      		<td><?php echo $data->category; ?></td>
            <td align="right" style="padding-right:5px;">
              <?php 
                if($data->stock_qty>0){
                  echo $data->stock_qty; 
                } else {
                  echo '0';
                }
              ?>
            </td>
            <td><?php echo $data->min_alert; ?></td>
      		  <td><?php echo $data->rack_no; ?></td>
            <td><?php echo date('d-M-Y',strtotime($data->created_date)); ?></td>
            
    
      </tr>
   	   <?php
   	   $i++;	
   	 }	
   }
 ?> 
</table>
</body></html>