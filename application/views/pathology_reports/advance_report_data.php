<?php
//$post = $this->input->post();
$segment = $this->uri->segment(3);
//echo "<pre>"; print_r($post);
 
if(empty($segment))
{
?>
<script type="text/javascript"> window.print();</script>
<?php
} 

if($post['report_type']==1)
{
?>
 
<table width="100%" cellpadding="4" cellspacing="0" border="0" align="center" style="width:21cm;float:left;font:13px arial;">
  <tr>
    <th colspan="2"><h2>Summarize Collection Report</h2></th>
  </tr>
  <tr>
    <td>From Date: <?php echo $post['start_date']; ?></td>
    <td width="150">To Date: <?php echo $post['end_date']; ?></td>
  </tr>
</table>



<table width="100%" cellpadding="4" cellspacing="0" border="1" align="center" style="width:21cm;float:left;font:13px arial;border-collapse:collapse;border:1px solid #999;">
 
  <tr>
    <th>Total Entity</th>
    <th>Total Amount</th>
    <th>Total Paid Amount</th>
    <th>Total Discount</th>
    <th>Total Balance</th>
  </tr>
<?php
if(!empty($sumrz_dept_list))
{
  foreach($sumrz_dept_list as $sumrz_dept)
  {
  ?>
  <tr>
    <td>Department(<?php echo $sumrz_dept['total_department']; ?>)</td>
    <td><?php echo $sumrz_dept['total_amount']; ?></td>
    <td><?php echo $sumrz_dept['total_collection']; ?></td>
    <td><?php echo $sumrz_dept['total_discount']; ?></td>
    <td><?php echo ($sumrz_dept['total_amount']-$sumrz_dept['total_discount'])-$sumrz_dept['total_collection']; ?></td>
  </tr>
  <?php 
  }
}

if(!empty($sumrz_test_list))
{
  foreach($sumrz_test_list as $sumrz_test)
  {
  ?>
  <tr>
    <td>Test</td>
    <td><?php echo $sumrz_test['total_amount']; ?></td>
    <td><?php echo $sumrz_test['total_collection']; ?></td>
    <td><?php echo $sumrz_test['total_discount']; ?></td>
    <td><?php echo number_format(($sumrz_test['total_amount']-$sumrz_test['total_discount'])-$sumrz_test['total_collection'],2); ?></td>
  </tr>
  <?php 
  }
}

if(!empty($sumrz_users_list))
{
  foreach($sumrz_users_list as $sumrz_users)
  {
  ?>
  <tr>
    <td>Users(<?php echo $sumrz_users['total_users']; ?>)</td>
    <td><?php echo $sumrz_users['total_amount']; ?></td>
    <td><?php echo $sumrz_users['total_collection']; ?></td>
    <td><?php echo $sumrz_users['total_discount']; ?></td>
    <td><?php echo number_format(($sumrz_users['total_amount']-$sumrz_users['total_discount'])-$sumrz_users['total_collection'],2); ?></td>
  </tr>
  <?php 
  }
}

if(!empty($sumrz_att_doc_list))
{
  foreach($sumrz_att_doc_list as $sumrz_att_doc)
  {
  ?>
  <tr>
    <td>Attendant Doctors(<?php echo $sumrz_att_doc['total_doctors']; ?>)</td>
    <td><?php echo $sumrz_att_doc['total_amount']; ?></td>
    <td><?php echo $sumrz_att_doc['total_collection']; ?></td>
    <td><?php echo $sumrz_att_doc['total_discount']; ?></td>
    <td><?php echo number_format(($sumrz_att_doc['total_amount']-$sumrz_att_doc['total_discount'])-$sumrz_att_doc['total_collection'],2); ?></td>
  </tr>
  <?php 
  }
}

if(!empty($sumrz_ref_doc_list))
{
  foreach($sumrz_ref_doc_list as $sumrz_ref_doc)
  {
  ?>
  <tr>
    <td>Referred Doctors(<?php echo $sumrz_ref_doc['total_doctors']; ?>)</td>
    <td><?php echo $sumrz_ref_doc['total_amount']; ?></td>
    <td><?php echo $sumrz_ref_doc['total_collection']; ?></td>
    <td><?php echo $sumrz_ref_doc['total_discount']; ?></td>
    <td><?php echo number_format(($sumrz_ref_doc['total_amount']-$sumrz_ref_doc['total_discount'])-$sumrz_ref_doc['total_collection'],2); ?></td>
  </tr>
  <?php 
  }
}

if(!empty($sumrz_patient_list))
{
  foreach($sumrz_patient_list as $sumrz_patient)
  {
  ?>
  <tr>
    <td>Patient(<?php echo $sumrz_patient['total_patient']; ?>)</td>
    <td><?php echo $sumrz_patient['total_amount']; ?></td>
    <td><?php echo $sumrz_patient['total_collection']; ?></td>
    <td><?php echo $sumrz_patient['total_discount']; ?></td>
    <td><?php echo number_format(($sumrz_patient['total_amount']-$sumrz_patient['total_discount'])-$sumrz_patient['total_collection'],2); ?></td>
  </tr>
  <?php 
  }
}



if(!empty($sumrz_pay_mode_list))
{
  foreach($sumrz_pay_mode_list as $sumrz_pay_mode)
  {
  ?>
  <tr>
    <td>Payment mode(<?php echo $sumrz_pay_mode['total_mode']; ?>)</td>
    <td><?php echo $sumrz_pay_mode['total_amount']; ?></td>
    <td><?php echo $sumrz_pay_mode['total_collection']; ?></td>
    <td><?php echo $sumrz_pay_mode['total_discount']; ?></td>
    <td><?php echo number_format(($sumrz_pay_mode['total_amount']-$sumrz_pay_mode['total_discount'])-$sumrz_pay_mode['total_collection'],2); ?></td>
  </tr>
  <?php 
  }
}

}
else if($post['report_type']==2)
{

//echo "<pre>"; print_r($dtl_test_list);die;  
?>

 
<table width="100%" cellpadding="4" cellspacing="0" border="0" align="center" style="width:21cm;float:left;font:13px arial;">
  <tr>
    <th colspan="2"><h2>Detailed Collection Report</h2></th>
  </tr>
  <tr>
    <th colspan="2"><h4><?php echo $report_wise; ?></h4></th>
  </tr>
  <tr>
    <td>From Date: <?php echo $post['start_date']; ?></td>
    <td width="150">To Date: <?php echo $post['end_date']; ?></td>
  </tr>
</table>


<table width="100%" cellpadding="4" cellspacing="0" border="1" align="center" style="width:21cm;float:left;;font:13px arial;border-collapse:collapse;border:1px solid #999;">
     
    
 <?php
   if(!empty($dtl_dept_list))
   {
   ?>
   <tr>
    <th>Department</th>
    <th>Total Amount</th>
    <th>Total Discount</th>
    <th>Total Received Amount</th>  
  </tr> 
   <?php   
      $total_amount = 0;
      $total_discount = 0;
      $total_paid_amount = 0;
     foreach ($dtl_dept_list as $dept_data) 
     { 
      if(!empty(trim($dept_data['department'])))
      {
      ?>
      <tr>  
        <td>
           <?php  
              echo $dept_data['department']; 
            ?>    
        </td>
        <td><?php echo number_format($dept_data['total_amount'],2); ?></td>
        <td><?php echo number_format($dept_data['total_discount'],2); ?></td> 
        <td><?php echo number_format($dept_data['total_paid_amount'],2); ?></td> 
      </tr>
     <?php
          $total_amount = $total_amount+$dept_data['total_amount'];
          $total_discount = $total_discount+$dept_data['total_discount'];
          $total_paid_amount = $total_paid_amount+$dept_data['total_paid_amount'];
      } 
     }
    ?>
      <th> Total </th>
        <th><?php echo number_format($total_amount,2); ?></th>
        <th><?php echo number_format($total_discount,2); ?></th> 
        <th><?php echo number_format($total_paid_amount,2); ?></th> 
    <?php  
   }

 if(!empty($dtl_user_list))
   {
    ?>
   <tr>
    <th>Booking Code</th>
    <th>Collection Date/Time</th>
    <th>Total Amount</th>
    <th>Total Paid Amount</th>
    <th>Total Discount</th>
    <th>Total Balance</th>
  </tr> 
   <?php
   $final_total_amount = 0;
   $final_paid_amount = 0;
   $final_discount = 0;
   $final_balance = 0;
     $i=1;
     $users = '';
     foreach ($dtl_user_list as $user_data) 
     {
      if($users!=$user_data['emp_name'])
      {
     ?>
      <tr>
        <td colspan="6">
        <strong>
        <?php 
          echo $user_data['emp_name']; 
          $users = $user_data['emp_name'];
        ?>
        </strong>
        </td>
      </tr>
      <?php
       }
      ?>
      <tr>
        <td><?php echo $user_data['lab_reg_no']; ?></td>
        <td><?php echo date('d-m-Y', strtotime($user_data['created_date'])); ?></td>
        <td><?php echo number_format($user_data['total_amount'],2); ?></td>
        <td> <?php echo number_format($user_data['total_paid_amount'],2); ?>    </td>
        <td><?php echo number_format($user_data['total_discount'],2); ?></td>
        <td><?php echo number_format(($user_data['total_amount']-$user_data['total_discount'])-$user_data['total_paid_amount'],2); ?></td>
      </tr>
     <?php
     $final_total_amount = $final_total_amount+$user_data['total_amount'];
     $final_paid_amount = $final_paid_amount+$user_data['total_paid_amount'];
     $final_discount = $final_discount+$user_data['total_discount'];
     $final_balance = $final_balance+(($user_data['total_amount']-$user_data['total_discount'])-$user_data['total_paid_amount']);
     $i++;  
     }
   ?>
     <tr>
        <th></th>
    <th>Total</th>
    <th><?php echo number_format($final_total_amount,2); ?></th>
    <th><?php echo number_format($final_paid_amount,2); ?></th>
    <th><?php echo number_format($final_discount,2); ?></th>
    <th><?php echo number_format($final_balance,2); ?></th>
  </tr>
   <?php
   }

   if(!empty($dtl_att_doc_list))
   {
    ?>
   <tr>
    <th>Booking Code</th>
    <th>Collection Date/Time</th>
    <th>Total Amount</th>
    <th>Total Paid Amount</th>
    <th>Total Discount</th>
    <th>Total Balance</th>
  </tr> 
   <?php
   $final_total_amount = 0;
   $final_paid_amount = 0;
   $final_discount = 0;
   $final_balance = 0;
     $i=1;
     $doctors = '';
     foreach ($dtl_att_doc_list as $att_doc_data) 
     {
      if($doctors!=$att_doc_data['doctor_name'])
      {
     ?>
      <tr>
        <td colspan="6">
        <strong>
        <?php 
          echo $att_doc_data['doctor_name']; 
          $doctors = $att_doc_data['doctor_name'];
        ?>
        </strong>
        </td>
      </tr>
      <?php
       }
      ?>
      <tr>
        <td><?php echo $att_doc_data['lab_reg_no']; ?></td>
        <td><?php echo date('d-m-Y', strtotime($att_doc_data['created_date'])); ?></td>
        <td><?php echo number_format($att_doc_data['total_amount'],2); ?></td>
        <td> <?php echo number_format($att_doc_data['total_paid_amount'],2); ?>    </td>
        <td><?php echo number_format($att_doc_data['total_discount'],2); ?></td>
        <td><?php echo number_format(($att_doc_data['total_amount']-$att_doc_data['total_discount'])-$att_doc_data['total_paid_amount'],2); ?></td>
      </tr>
     <?php
     $final_total_amount = $final_total_amount+$att_doc_data['total_amount'];
     $final_paid_amount = $final_paid_amount+$att_doc_data['total_paid_amount'];
     $final_discount = $final_discount+$att_doc_data['total_discount'];
     $final_balance = $final_balance+(($att_doc_data['total_amount']-$att_doc_data['total_discount'])-$att_doc_data['total_paid_amount']);
     $i++;  
     }
   ?>
     <tr>
        <th></th>
    <th>Total</th>
    <th><?php echo number_format($final_total_amount,2); ?></th>
    <th><?php echo number_format($final_paid_amount,2); ?></th>
    <th><?php echo number_format($final_discount,2); ?></th>
    <th><?php echo number_format($final_balance,2); ?></th>
  </tr>
   <?php
   }

   if(!empty($dtl_ref_doc_list))
   {
    ?>
   <tr>
    <th>Booking Code</th>
    <th>Collection Date/Time</th>
    <th>Total Amount</th>
    <th>Total Paid Amount</th>
    <th>Total Discount</th>
    <th>Total Balance</th>
  </tr> 
   <?php
   $final_total_amount = 0;
   $final_paid_amount = 0;
   $final_discount = 0;
   $final_balance = 0;
     $i=1;
     $doctors = '';
     foreach ($dtl_ref_doc_list as $ref_doc_data) 
     {
      if($doctors!=$ref_doc_data['doctor_name'])
      {
     ?>
      <tr>
        <td colspan="6">
        <strong>
        <?php 
          echo $ref_doc_data['doctor_name']; 
          $doctors = $ref_doc_data['doctor_name'];
        ?>
        </strong>
        </td>
      </tr>
      <?php
       }
      ?>
      <tr>
        <td><?php echo $ref_doc_data['lab_reg_no']; ?></td>
        <td><?php echo date('d-m-Y', strtotime($ref_doc_data['created_date'])); ?></td>
        <td><?php echo number_format($ref_doc_data['total_amount'],2); ?></td>
        <td> <?php echo number_format($ref_doc_data['total_paid_amount'],2); ?>    </td>
        <td><?php echo number_format($ref_doc_data['total_discount'],2); ?></td>
        <td><?php echo number_format(($ref_doc_data['total_amount']-$ref_doc_data['total_discount'])-$ref_doc_data['total_paid_amount'],2); ?></td>
      </tr>
     <?php
     $final_total_amount = $final_total_amount+$ref_doc_data['total_amount'];
     $final_paid_amount = $final_paid_amount+$ref_doc_data['total_paid_amount'];
     $final_discount = $final_discount+$ref_doc_data['total_discount'];
     $final_balance = $final_balance+(($ref_doc_data['total_amount']-$ref_doc_data['total_discount'])-$ref_doc_data['total_paid_amount']);
     $i++;  
     }
   ?>
     <tr>
        <th></th>
    <th>Total</th>
    <th><?php echo number_format($final_total_amount,2); ?></th>
    <th><?php echo number_format($final_paid_amount,2); ?></th>
    <th><?php echo number_format($final_discount,2); ?></th>
    <th><?php echo number_format($final_balance,2); ?></th>
  </tr>
   <?php
   } 

   if(!empty($dtl_pay_mode_list))
   {
    ?>
   <tr>
    <th>Booking Code</th>
    <th>Collection Date/Time</th>
    <th>Total Amount</th>
    <th>Total Paid Amount</th>
    <th>Total Discount</th>
    <th>Total Balance</th>
  </tr> 
   <?php
   $final_total_amount = 0;
   $final_paid_amount = 0;
   $final_discount = 0;
   $final_balance = 0;
     $i=1;
     $payment_mode = '';
     foreach ($dtl_pay_mode_list as $pay_mode_data) 
     {
      if($payment_mode!=$pay_mode_data['payment_mode'])
      {
     ?>
      <tr>
        <td colspan="6">
        <strong>
        <?php 
          echo $pay_mode_data['payment_mode']; 
          $payment_mode = $pay_mode_data['payment_mode'];
        ?>
        </strong>
        </td>
      </tr>
      <?php
       }
      ?>
      <tr>
        <td><?php echo $pay_mode_data['lab_reg_no']; ?></td>
        <td><?php echo date('d-m-Y', strtotime($pay_mode_data['created_date'])); ?></td>
        <td><?php echo number_format($pay_mode_data['total_amount'],2); ?></td>
        <td> <?php echo number_format($pay_mode_data['total_paid_amount'],2); ?>    </td>
        <td><?php echo number_format($pay_mode_data['total_discount'],2); ?></td>
        <td><?php echo number_format(($pay_mode_data['total_amount']-$pay_mode_data['total_discount'])-$pay_mode_data['total_paid_amount'],2); ?></td>
      </tr>
     <?php
     $final_total_amount = $final_total_amount+$pay_mode_data['total_amount'];
     $final_paid_amount = $final_paid_amount+$pay_mode_data['total_paid_amount'];
     $final_discount = $final_discount+$pay_mode_data['total_discount'];
     $final_balance = $final_balance+(($pay_mode_data['total_amount']-$pay_mode_data['total_discount'])-$pay_mode_data['total_paid_amount']);
     $i++;  
     }
   ?>
     <tr>
        <th></th>
    <th>Total</th>
    <th><?php echo number_format($final_total_amount,2); ?></th>
    <th><?php echo number_format($final_paid_amount,2); ?></th>
    <th><?php echo number_format($final_discount,2); ?></th>
    <th><?php echo number_format($final_balance,2); ?></th>
  </tr>
   <?php
   }  
if(!empty($dtl_test_list))
   {
   ?>
   <tr>
    <th>Test Name</th>
    <th>Quantity</th>
    <th>Total Amount</th> 
  </tr> 
   <?php  
   $total_amount = 0; 
   $i=1; 
     foreach ($dtl_test_list as $test_data) 
     {  
      ?>
      <tr>
        <td><?php echo $test_data['test_name']; ?></td>
        <th><?php echo $test_data['total_test']; ?></th>
        <td><?php echo number_format($test_data['total_amount'],2); ?></td>
      </tr>
     <?php
      // $total_amount = $total_amount+$test_data['total_amount'];
     $i++;  
     }
     
     //$total_amount = $total_entities[0]->total_amount+$total_entities[0]->total_discount;
     $total_amount = $total_entities[0]->total_amount;
   ?>
     <tr> 
    <td colspan="3">
      <table style="width:200px; text-align:left; font:13px arial;border-collapse:collapse;" align="right">
        <tr>
          <th> Total Amount:</th>
          <td><?php echo number_format($total_amount,2); ?></td>
        </tr>
        <tr>
          <th>Total Discount:</th>
          <td><?php echo number_format($total_entities[0]->total_discount,2); ?></td>
        </tr>
        <tr>
          <th>Net Amount:</th>
          <td><?php echo number_format($total_amount-$total_entities[0]->total_discount,2); ?></td>
        </tr>
        <tr>
          <th>Received Amount:</th>
          <td><?php echo number_format($total_entities[0]->total_paid_amount,2); ?></td>
        </tr>
        <tr>
          <th>Balance Amount:</th>
          <td><?php echo number_format(($total_amount-$total_entities[0]->total_discount)-$total_entities[0]->total_paid_amount,2); ?></td>
        </tr>
      </table>  
    </td> 
  </tr>
   <?php
   }     
 ?>
</table>  
<?php
}

else if($post['report_type']==3)
{
  ?>
   <table width="100%" cellpadding="4" cellspacing="0" border="0" align="center" style="width:21cm;float:left;font:13px arial;">
      <tr>
        <th colspan="2"><h2>Date Wise Collection Report</h2></th>
      </tr>
      <tr>
        <th colspan="2"><h4><?php echo $report_wise; ?></h4></th>
      </tr>
      <tr>
        <td>From Date: <?php echo $post['start_date']; ?></td>
        <td width="150">To Date: <?php echo $post['end_date']; ?></td>
      </tr>
    </table>
   <table width="100%" cellpadding="4" cellspacing="0" border="1" align="center" style="width:21cm;float:left;;font:13px arial;border-collapse:collapse;border:1px solid #999;"> 
    <tr> 
        <th>Date</th>
        <th>Total Amount</th>
        <th>Total Paid Amount</th>
        <th>Total Discount</th>
        <th>Total Balance</th>
    </tr>
    <?php
    if(!empty($date_wise_list))
    {
      $final_total_amount = '0.00';
      $final_paid_amount = '0.00';
      $final_discount = '0.00';
      $final_balance = '0.00';
      foreach($date_wise_list as $date_wise)
      {
    ?>
      <tr>
        <td><?php echo date('d-m-Y',strtotime($date_wise['created_date'])); ?></td>
        <td><?php echo number_format($date_wise['total_amount'],2); ?></td>
        <td> <?php echo number_format($date_wise['total_paid_amount'],2); ?>    </td>
        <td><?php echo number_format($date_wise['total_discount'],2); ?></td>
        <td><?php echo number_format(($date_wise['total_amount']-$date_wise['total_discount'])-$date_wise['total_paid_amount'],2); ?></td>
      </tr>
    <?php  
          $final_total_amount  = $final_total_amount+$date_wise['total_amount'];
          $final_paid_amount  = $final_paid_amount+$date_wise['total_paid_amount'];
          $final_discount  = $final_discount+$date_wise['total_discount'];
          $final_balance  = $final_balance+(($date_wise['total_amount']-$date_wise['total_discount'])-$date_wise['total_paid_amount']);
       }
    ?>
     <tr> 
    <th>Total</th>
    <th><?php echo number_format($final_total_amount,2); ?></th>
    <th><?php echo number_format($final_paid_amount,2); ?></th>
    <th><?php echo number_format($final_discount,2); ?></th>
    <th><?php echo number_format($final_balance,2); ?></th>
  </tr>
    <?php   
    }
    else
    {
     ?>
      <tr>
        <th colspan="5" style="color: red;">Data not available.</th> 
      </tr>
     <?php 
    }
    ?> 
  </table>
  <?php
}
?>  
</table>
 
