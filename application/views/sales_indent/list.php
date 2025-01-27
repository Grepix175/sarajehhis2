<?php
$users_data = $this->session->userdata('auth_users');
$user_role= $users_data['users_role'];
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $page_title.PAGE_TITLE; ?></title>
<meta name="viewport" content="width=1024">
<!-- bootstrap -->
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datatable.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>font-awesome.min.css">

<!-- links -->
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>my_layout.css">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>menu_style.css">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>menu_for_all.css">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>withoutresponsive.css">
<link href = "<?php echo ROOT_CSS_PATH; ?>jquery-ui.css"
    rel = "stylesheet">
<!-- js -->
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>jquery.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap.min.js"></script> 
<script src = "<?php echo ROOT_JS_PATH; ?>jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datepicker.css">
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap-datepicker.js"></script> 
<!-- datatable js -->
<script src="<?php echo ROOT_JS_PATH; ?>jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT_JS_PATH; ?>dataTables.bootstrap.min.js"></script>
<script type="text/javascript">

function edit_sales_indent(id)
{
  window.location.href='<?php echo base_url().'sales_indent/edit/';?>'+id
}

function view_medicine_entry(id)
{
  var $modal = $('#load_add_modal_popup');
  $modal.load('<?php echo base_url().'sales_indent/view/' ?>'+id,
  {
    //'id1': '1',
    //'id2': '2'
    },
  function(){
  $modal.modal('show');
   });
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}
function checkboxValues() 
{         
    $('#table').dataTable();
     var allVals = [];
     $(':checkbox').each(function() 
     {
       if($(this).prop('checked')==true)
       {
            allVals.push($(this).val());
       } 
     });
     allbranch_delete(allVals);
} 

function allbranch_delete(allVals)
 {    
   if(allVals!="")
   {
       $('#confirm').modal({
      backdrop: 'static',
      keyboard: false
        })
        .one('click', '#delete', function(e)
        { 
            $.ajax({
                      type: "POST",
                      url: "<?php echo base_url('sales_indent/deleteall');?>",
                      data: {row_id: allVals},
                      success: function(result) 
                      {
                            flash_session_msg(result);
                            reload_table();  
                      }
                  });
        });
   } 
    else{
        $('#confirm-select').modal({
            backdrop: 'static',
            keyboard: false
          });
     }           
 }
</script>




</head>

<body>


<div class="container-fluid">
 <?php
  $this->load->view('include/header');
  $this->load->view('include/inner_header');
 ?>
<section class="userlist">
    <div class="userlist-box">
    <?php if(isset($user_role) && $user_role==4 || $user_role==3)
    {
    }
    else
      {?>
<form id="new_search_form">

		
			<div class="row">
				<div class="col-md-4">
				
				
					<div class="row m-b-5">
						<div class="col-md-4">
							<label>From Date</label>
						</div>
						<div class="col-md-8">
							<input type="text" name="start_date" id="start_date_s" class="datepicker start_datepicker m_input_defa"  onkeyup="return form_submit();" value="<?php echo $form_data['start_date'];?>">
						</div>
					</div>
					

					<div class="row m-b-5">
						<div class="col-md-4">
							<label>To Date</label>
						</div>
						<div class="col-md-8">
							<input type="text" name="end_date" id="end_date_s" value="<?php echo $form_data['end_date'];?>" class="datepicker end_datepicker"  onkeyup="return form_submit();">
						</div>
					</div>
				</div>
				<div class="col-md-4">
				
					<div class="row m-b-5">
					
						<?php  
						  $users_data = $this->session->userdata('auth_users'); 

						  if (array_key_exists("permission",$users_data)){
						  $permission_section = $users_data['permission']['section'];
						  $permission_action = $users_data['permission']['action'];
						  }
						  else{
						  $permission_section = array();
						  $permission_action = array();
						  }
						  //print_r($permission_action);

						  $new_branch_data=array();
						  $users_data = $this->session->userdata('auth_users');
						  $sub_branch_details = $this->session->userdata('sub_branches_data');
						  $parent_branch_details = $this->session->userdata('parent_branches_data');


						  if(!empty($users_data['parent_id'])){
						  $new_branch_data['id']=$users_data['parent_id'];

						  $users_new_data[]=$new_branch_data;
						  $merg_branch= array_merge($users_new_data,$sub_branch_details);

						  $ids = array_column($merg_branch, 'id'); 
						  $branch_id = implode(',', $ids); 
						  $option= '<option value="'.$branch_id.'">All</option>';
						  }

						  ?>
						  <?php if(in_array('1',$permission_section)): ?> 
						<div class="col-md-4">
							<label>Select Branch</label>
						</div>
						<div class="col-md-8">
							<select name="branch_id" id="branch_id" onchange="return form_submit();">
								  <?php echo $option ;?>
								  <option  selected="selected" <?php if(isset($_POST['branch_id']) && $_POST['branch_id']==$users_data['parent_id']){ echo 'selected="selected"'; } ?> value="<?php echo $users_data['parent_id'];?>">Self</option>';
								  <?php 
								  if(!empty($sub_branch_details)){
								  $i=0;
								  foreach($sub_branch_details as $key=>$value){
								  ?>
								  <option value="<?php echo $sub_branch_details[$i]['id'];?>" <?php if(isset($_POST['branch_id'])&& $_POST['branch_id']==$sub_branch_details[$i]['id']){ echo 'selected="selected"'; } ?> ><?php echo $sub_branch_details[$i]['branch_name'];?> </option>
								  <?php 
								  $i = $i+1;
								  }

								  }
								  ?> 
							</select>
						
						</div>
						<?php endif;?>
					</div>
				
					<div class="row m-b-5">
						<div class="col-md-4">
							<label>Issue No.</label>
						</div>
						<div class="col-md-8">
							<input type="text" name="sale_no" class=""  id="sale_no" value="<?php echo $form_data['sale_no'];?>" onkeyup="return form_submit();" autofocus="">
						</div>
					</div>
			</div>  
				
				<div class="col-md-4">
					<div class="row m-b-5">
						<div class="col-md-12">
							<a class="btn-custom" id="reset_date" onclick="reset_search();"> Reset</a>
							<a href="javascript:void(0)" class="btn-a-search" id="adv_search_sale"><i class="fa fa-cubes" aria-hidden="true"></i> Advance Search</a> 
						</div>
						
					</div>
				</div>
			</div>
	 </form>
    <?php }?>
    	 
    <form>
       <?php if(in_array('399',$users_data['permission']['action'])) {
       ?>
       <!-- bootstrap data table -->
        <table id="table" class="table table-striped table-bordered sales_indent_list" cellspacing="0" width="100%">
            <thead class="bg-theme">
                <tr>
                    <th align="center" width="40"> <input type="checkbox" name="selectall" class="" id="selectAll" value=""> </th> 
                    <th> Issue No.</th> 
                    <th> Indent Name </th> 
                    <th> Issue Date </th> 
                    <th> Action </th>
                </tr>
            </thead>  
        </table>
        <?php } ?>
    </form>
   </div> <!-- close -->
	<div class="userlist-right">
  		<div class="btns">
               <?php if(in_array('400',$users_data['permission']['action'])) {
               ?>
  			     <button class="btn-update" onClick="window.location.href='<?php echo base_url('sales_indent/add'); ?>'">
  				    <i class="fa fa-plus"></i> New
  			     </button>
               <?php } ?>
               <?php if(in_array('402',$users_data['permission']['action'])) {
               ?>

                <a href="<?php echo base_url('sales_indent/medicine_sales_excel'); ?>" class="btn-anchor m-b-2">
                <i class="fa fa-file-excel-o"></i> Excel
                </a>

                <a href="<?php echo base_url('sales_indent/medicine_sales_csv'); ?>" class="btn-anchor m-b-2">
                <i class="fa fa-file-word-o"></i> CSV
                </a>

                <a href="<?php echo base_url('sales_indent/pdf_medicine_sales'); ?>" class="btn-anchor m-b-2">
                <i class="fa fa-file-pdf-o"></i> PDF
                </a>

                 <a href="javascript:void(0)" class="btn-anchor m-b-2"  onClick="return print_window_page('<?php echo base_url("sales_indent/print_medicine_sales"); ?>');"> <i class="fa fa-print"></i> Print</a>

  			     <button class="btn-update" id="deleteAll" onClick="return checkboxValues();">
  				    <i class="fa fa-trash"></i> Delete
  			     </button>
               <?php } ?>
               <?php if(in_array('399',$users_data['permission']['action'])) {
               ?>

                    <button class="btn-update" onClick="reload_table()">
                         <i class="fa fa-refresh"></i> Reload
                    </button>
               <?php } ?>
               <?php if(in_array('403',$users_data['permission']['action'])) {
               ?>
  			     <button class="btn-exit" onClick="window.location.href='<?php echo base_url('sales_indent/archive'); ?>'">
  				    <i class="fa fa-archive"></i> Archive
  			     </button>
               <?php } ?>
                
        <button class="btn-exit" onClick="window.location.href='<?php echo base_url(); ?>'">
          <i class="fa fa-sign-out"></i> Exit
        </button>
  		</div>
  	</div> 

</section> <!-- cbranch -->
<?php
$this->load->view('include/footer');
?>

<script>  


function reset_search()
  { 
    $('#start_date_s').val('');
    $('#end_date_s').val('');
    $('#paid_amount_from').val('');
    $('#paid_amount_to').val('');
    $('#balance_to').val('');
    $('#balance_from').val('');
    $('#purchase_no').val('');
    $('#refered_by').val('');
    $('#branch_id').val('');
    $('#refered_id').val('');
    $('#referral_hospital').val('');
     $('#referredby').attr('checked', false);
    $.ajax({url: "<?php echo base_url(); ?>sales_indent?>/reset_search/", 
      success: function(result)
      { 
        reload_table();
        $('#start_date_s').val('');
        $('#end_date_s').val('');
      } 
    }); 
  }
 function delete_sales_indent(id)
 {    
    $('#confirm').modal({
      backdrop: 'static',
      keyboard: false
    })
    .one('click', '#delete', function(e)
    { 
        $.ajax({
                 url: "<?php echo base_url('sales_indent/delete/'); ?>"+id, 
                 success: function(result)
                 {
                    flash_session_msg(result);
                    reload_table(); 
                 }
              });
    });     
 } 
</script> 
  <?php
 $flash_success = $this->session->flashdata('success');
 if(isset($flash_success) && !empty($flash_success))
 {
   echo '<script> flash_session_msg("'.$flash_success.'");</script> ';
   ?>
   <script>  
    //$('.dlt-modal').modal('show'); 
    </script> 
    <?php
 }
?>

<script>
$('documnet').ready(function(){
 <?php if(isset($_GET['status']) && $_GET['status']=='print'){?>
  $('#confirm_print').modal({
      backdrop: 'static',
      keyboard: false
        })
  
  .one('click', '#cancel', function(e)
    { 
        window.location.href='<?php echo base_url('sales_indent');?>'; 
    }) ;
   
       
  <?php }?>
 });


$(document).ready(function(){
  $('#load_add_modal_popup').on('shown.bs.modal', function(e) {
    $('.searchFocus').focus();
  });
});

</script>

<!-- Confirmation Box -->

<div id="confirm_print" class="modal fade dlt-modal">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-theme"><h4>Are You Sure?</h4></div>
          <!-- <div class="modal-body"></div> -->
          <div class="modal-footer">
     
            <a  type="button" data-dismiss="modal" class="btn-anchor"  onClick="return print_window_page('<?php echo base_url("sales_indent/print_sales_report"); ?>');">Print</a>

            <button type="button" data-dismiss="modal" class="btn-cancel" id="cancel">Close</button>
          </div>
        </div>
      </div>  
    </div> 

    <div id="confirm" class="modal fade dlt-modal">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-theme"><h4>Are You Sure?</h4></div>
          <div class="modal-body" style="font-size:8px;">*Data that have been in Archive more than 60 days will be automatically deleted.</div> 
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn-update" id="delete">Confirm</button>
            <button type="button" data-dismiss="modal" class="btn-cancel">Close</button>
          </div>
        </div>
      </div>  
    </div> <!-- modal -->
      <div id="confirm-select" class="modal fade dlt-modal">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-theme"><h4>Please select at-least one record.</h4></div>
          <!-- <div class="modal-body"></div> -->
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn-cancel">Close</button>
          </div>
        </div>
      </div>  
    </div> <!-- modal -->
 <!-- Confirmation Box end -->
<div id="load_add_modal_popup" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false"></div>
</div>
<script>
var $modal = $('#load_add_modal_popup');
  $('#adv_search_sale').on('click', function(){
$modal.load('<?php echo base_url().'sales_indent/advance_search/' ?>',
{ 
},
function(){
$modal.modal('show');
});

});

$('.start_datepicker').datepicker({
    format: 'dd-mm-yyyy', 
    autoclose: true, 
    endDate : new Date(), 
  }).on("change", function(selectedDate) 
  { 
      var start_data = $('.start_datepicker').val();
      $('.end_datepicker').datepicker('setStartDate', start_data); 
      form_submit();
  });

  $('.end_datepicker').datepicker({
    format: 'dd-mm-yyyy',     
    autoclose: true,  
  }).on("change", function(selectedDate) 
  {   
     form_submit();
  });
  function form_submit(vals)
{
    var start_date = $('#start_date_s').val();
    var end_date = $('#end_date_s').val();
    var branch_id = $('#branch_id').val();
    var sale_no = $('#sale_no').val();
    
 
  $.ajax({
       url: "<?php echo base_url(); ?>sales_indent/advance_search/",
       type: 'POST',
       data: { start_date: start_date, end_date : end_date,branch_id:branch_id,sale_no:sale_no} ,
         
    success: function(result) 
    {
      
      if(vals!="1")
      {
        reload_table(); 
      }
      
    }
  });

}

form_submit(1);
var save_method; 
var table;
<?php
if(in_array('399',$users_data['permission']['action'])) 
{
?>
$(document).ready(function() { 
    table = $('#table').DataTable({  
        "processing": true, 
        "serverSide": true, 
        "order": [], 
        "pageLength": '20',
        "ajax": {
            "url": "<?php echo base_url('sales_indent/ajax_list')?>",
            "type": "POST",
        }, 
        "columnDefs": [
        { 
            "targets": [ 0 , -1 ], //last column
            "orderable": false, //set not orderable

        },
         ],
        "drawCallback": function() 
        {
            $.ajax({
                      dataType: "json",
                      url: "<?php echo base_url('sales_indent/total_calc_return');?>",
                      success: function(result) 
                      {
                       
                      }
                  });
        },

    });
// form_submit();

}); 
<?php } ?>
</script>
</body>
</html>