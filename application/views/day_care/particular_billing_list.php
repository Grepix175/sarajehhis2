<?php
$users_data = $this->session->userdata('auth_users');
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

<!-- js -->
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>jquery.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap.min.js"></script> 

<!-- datatable js -->
<script src="<?php echo ROOT_JS_PATH; ?>jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT_JS_PATH; ?>dataTables.bootstrap.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datepicker.css">
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap-datepicker.js"></script>
<script type="text/javascript">
var save_method; 
var table;

$(document).ready(function() { 
    table = $('#table').DataTable({  
        "processing": true, 
        "serverSide": true, 
        "order": [], 
        "pageLength": '20',
        "ajax": {
            "url": "<?php echo base_url('day_care/ajax_particular_billing_list')?>",
            "type": "POST",
        }, 
        "columnDefs": [
        { 
            "targets": [ 0 , -1 ], //last column
            "orderable": false, //set not orderable

        },
        ],

    });
}); 



$(document).ready(function(){
var $modal = $('#load_add_modal_popup');
$('#doctor_add_modal').on('click', function(){
$modal.load('<?php echo base_url().'patient/add/' ?>',
{
  //'id1': '1',
  //'id2': '2'
  },
function(){
$modal.modal('show');
});

});
 

$('#adv_search').on('click', function(){
$modal.load('<?php echo base_url().'patient/advance_search/' ?>',
{ 
},
function(){
$modal.modal('show');
});

});

});

function edit_patient(id)
{
  var $modal = $('#load_add_modal_popup');
  $modal.load('<?php echo base_url().'patient/edit/' ?>'+id,
  {
    //'id1': '1',
    //'id2': '2'
    },
  function(){
  $modal.modal('show');
  });
}

function view_patient(id)
{
  var $modal = $('#load_add_modal_popup');
  $modal.load('<?php echo base_url().'patient/view/' ?>'+id,
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
                      url: "<?php echo base_url('day_care/deleteall');?>",
                      data: {row_id: allVals},
                      success: function(result) 
                      {
                            flash_session_msg(result);
                            reload_table();  
                      }
                  });
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
<!-- ============================= Main content start here ===================================== -->
<section class="userlist">
    <div class="userlist-box">
    
    <form>
       
       <!-- bootstrap data table -->
        <table id="table" class="table table-striped table-bordered opd_billing_list" cellspacing="0" width="100%">
            <thead class="bg-theme">
                <tr>
                    <th width="40" align="center"> <input type="checkbox" name="selectall" class="" id="selectAll" value=""> </th> 
                    <th> Billing ID </th> 
                    <th> Patient Name </th> 
                    <th> Billing Date </th> 
                    <th> Total Amount </th>  
                    <th> Paid Amount </th> 
                    <th> Discount </th> 
                    <th> Status </th>
                    <th> Action </th>
                </tr>
            </thead>  
        </table>


    </form>


   </div> <!-- close -->





  	<div class="userlist-right">
  		<div class="btns">
  			<button class="btn-update" onclick="window.location.href='<?php echo base_url('day_care/billing'); ?>'">
  				<i class="fa fa-plus"></i> New
  			</button>
  			
        <?php if(in_array('60',$users_data['permission']['action'])) {
          ?>
        <button class="btn-update" id="deleteAll" onclick="return checkboxValues();">
          <i class="fa fa-trash"></i> Delete
        </button>
          <?php } ?> 

        <button class="btn-update" onclick="reload_table()">
          <i class="fa fa-refresh"></i> Reload
        </button>
  			<button class="btn-exit" onclick="window.location.href='<?php echo base_url('day_care/billing_archive'); ?>'">
          <i class="fa fa-archive"></i> Archive
        </button>
        <button class="btn-exit" onclick="window.location.href='<?php echo base_url(); ?>'">
          <i class="fa fa-sign-out"></i> Exit
        </button>
  		</div>
  	</div> 
  	<!-- right -->
 
  <!-- cbranch-rslt close -->

  


  
</section> <!-- cbranch -->
<?php
$this->load->view('include/footer');
?>

<script>  
 <?php
 $flash_success = $this->session->flashdata('success');
 if(isset($flash_success) && !empty($flash_success))
 {
   echo 'flash_session_msg("'.$flash_success.'");';
 }
 ?>

  function confirm_billing(id)
  {
    var $modal = $('#load_add_modal_popup');
    $modal.load('<?php echo base_url().'day_care/confirm_billing/' ?>'+id,
    {
      //'id1': '1',
      //'id2': '2'
      },
    function(){
    $modal.modal('show');
    });
  }

 function delete_opd_billing(billing_id)
 {    
    $('#confirm').modal({
      backdrop: 'static',
      keyboard: false
    })
    .one('click', '#delete', function(e)
    { 
        $.ajax({
                 url: "<?php echo base_url('day_care/delete_billing/'); ?>"+billing_id, 
                 success: function(result)
                 {
                    flash_session_msg(result);
                    reload_table(); 
                 }
              });
    });     
 }
 
</script> 
<!-- Confirmation Box -->

    <div id="confirm" class="modal fade dlt-modal">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-theme"><h4>Are You Sure?</h4></div>
          <!-- <div class="modal-body"></div> -->
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn-update" id="delete">Confirm</button>
            <button type="button" data-dismiss="modal" class="btn-cancel">Close</button>
          </div>
        </div>
      </div>  
    </div> <!-- modal -->

<!-- Confirmation Box end -->
<div id="load_add_modal_popup" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false"></div>
</div><!-- container-fluid -->
</body>
</html>