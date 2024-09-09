<!DOCTYPE html>
<html>
<head>
	<title><?php echo $page_title.PAGE_TITLE; ?></title>
	<?php  if($_GET['printer_id']==2){ ?> 	
		<style>
*{margin:0;padding:0;box-sizing:border-box;-webkit-box-sizing:border-box;}
	page {
	  background: white;
	  display: block;
	  margin: 1em auto;
	  margin-bottom: 0.5cm;
	  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
	}
	page[size="A4"] {  
	  width: 21cm; /* 21cm */
	  height: 14.85cm; /* 29.7cm  for A4/2 */ 
	  padding: 2em;
	  font-size:13px;
	}
@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
</style>
<?php }elseif($_GET['printer_id']==3)
{
	?>

	<style>
*{margin:0;padding:0;box-sizing:border-box;-webkit-box-sizing:border-box;}
	page {
	  background: white;
	  display: block;
	  margin: 1em auto;
	  margin-bottom: 0.5cm;
	  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
	}
	page[size="A4"] {  
	  width: 10.5cm;  /* 21cm for A4/4  */
	  min-height: 14.5cm; /* 29.7cm  for A4/4 */ 
	  padding: 1em;
	  font-size:12px;
	}
@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
</style>

	<?php
} else{ ?>
	<style type="text/css">*{margin:0;padding:0;box-sizing:border-box;-webkit-box-sizing:border-box;font-family:Arial;}
	page {
	  background: white;
	  display: block;
	  margin: 1em auto 0;
	  margin-bottom: 0.5cm;
	  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
	}
	page[size="A4"] {  
	  width: 21cm;
	  height: 27.7cm;  
	  padding: 3em;
	  font-size:13px;
	}
@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
	</style>

	<?php }


?>
</head>
<body style="background: rgb(204,204,204);font-family:Arial;color:#333;font-size:13px;">
 <page size="A4">
<h2 align="center">Commission Payment Details</h2>
<table width="100%" class="m-b-5">
<?php
$hospital = get_hospital_name($_GET['hospital_id']);
?>
  <tr>
  	 <td width="30%" align="left" class="text-left"><b>Hospital Name :</b> <?php echo $hospital; ?></td>
  	 <?php $users_data = $this->session->userdata('auth_users'); 
      if($users_data['users_role']!=3)
      { ?>
  	 <td width="30%" align="left" class="text-left"><b>Start Date :</b> <?php echo $_GET['start_date']; ?></td>
  	 <td width="30%" align="left" class="text-left"><b>End Date :</b> <?php echo $_GET['end_date']; ?></td>
  	 <?php } ?>
  	  <td width="10%" align="left" class="text-left print"><input type="button" name="button_print" value="Print"  id="print" onClick="return my_function();"/></td>
  </tr>
</table>

	<div style="display:block;border-top:2px solid black;">&nbsp;</div>
		<div style="float:left;width:100%;margin-top:20px;">

		<div style="float:left;width:100%;display:inline-flex;">
            <div style="width:33.33%;font-weight:bold;padding-bottom:10px;padding-left:5px;">Rec. Date</div>
            <div style="width:33.33%;font-weight:bold;padding-bottom:10px;"> Payment mode</div>
            
            <div style="width:33.33%;font-weight:bold;padding-bottom:10px;text-align:right;padding-right:1em;">Amount</div>
            
        </div>
	<?php
	 if(!empty($list))
	 {
	 // $pay_mode = array('0'=>'','1'=>'Cash', '3'=>'Cheque', '2'=>'Card', '4'=>'NEFT');		
	 	$total_amount=0;
	  foreach($list as $data)
	  {
	  ?>
	     <div style="float:left;width:100%;display:inline-flex;">
        <div style="width:33.33%;padding-bottom:10px;padding-left:5px;"><?php echo date('d-m-Y', strtotime($data->created_date)); ?></div>
        <div style="width:33.33%;padding-bottom:10px;"><?php echo $data->payment_mode; ?></div>
        <div style="width:33.33%;line-height:17px;text-align:right;padding-right:1em;"><?php echo number_format($data->debit,2); ?></div>
       </div>

	  <?php 
	  $total_amount = $total_amount+$data->debit;
	   } ?>

	    <div style="float:right;font-weight:bold;padding-right:0.5em;">
	   <div style="width:100%;border-top:1px solid #111;padding-right:0.25em;">
           <div style="float:left;font-weight:bold;padding-right:0.5em;">Total Amount:</div>
              <div style="float:right;font-weight:bold;padding-right:0.25em;"><?php echo number_format($total_amount,2); ?></div>
            </div>
       </div>
	 
	 <?php }
	 else
	 {
	   ?>
	     <div style="float:left;width:100%;display:inline-flex;">
        <div style="width:100%;padding-bottom:10px;padding-left:5px;">Record not found</div>
       </div>
	   <?php
	 }
	?> 
	</div>

</body>
</page>
	

</html>
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>jquery.min.js"></script>
 <script src = "<?php echo ROOT_JS_PATH; ?>jquery-ui.js"></script>
<script>
function my_function()
{
 $("#print").hide();
  window.print();
}
</script>