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
<link href = "<?php echo ROOT_CSS_PATH; ?>jquery-ui.css"
  rel = "stylesheet">
<!-- js -->
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>jquery.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>validation.js"></script>
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap.min.js"></script> 

<!-- datatable js -->
<script src="<?php echo ROOT_JS_PATH; ?>jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT_JS_PATH; ?>dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datepicker.css">
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap-datepicker.js"></script> 
   
<script type="text/javascript">
$(document).ready(function(){
var $modal = $('#load_add_modal_popup');
$('#medicine_entry_add_modal').on('click', function(){
$modal.load('<?php echo base_url().'garbage_stock_item/add/' ?>',
{
  //'id1': '1',
  //'id2': '2'
  },
function(){
$modal.modal('show');
});

});

});

function edit_stock_purchase(id)
{
   window.location.href= '<?php echo base_url().'garbage_stock_item/edit/' ?>'+id;

  
}

function view_medicine_entry(id)
{
  var $modal = $('#load_add_modal_popup');
  $modal.load('<?php echo base_url().'garbage_stock_item/view/' ?>'+id,
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
                      url: "<?php echo base_url('garbage_stock_item/deleteall');?>",
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
  <?php if(in_array('983',$users_data['permission']['action'])) {
  ?>
  <form id="new_search_form">
  <table class="ptl_tbl">
     
      <tr>
        <td><label>From Date</label> <input type="text" name="start_date" id="start_date_p" class="datepicker"  onkeyup="return form_submit();" value="<?php echo $form_data['start_date'] ?>"></td>
        <td><label>To Date</label> <input type="text" name="end_date" id="end_date_p" class="datepicker"  onkeyup="return form_submit();" value="<?php echo $form_data['end_date'] ?>" ></td>
        <td><!-- <a href="javascript:void(0)" class="btn-a-search" id="adv_search_purchase"><i class="fa fa-cubes" aria-hidden="true"></i> Advance Search</a> --> <a class="btn-custom" id="reset_date" onclick="reset_search();">Reset</a></td>
      </tr>
      </table>

  


 </form>
 <?php }?>
    	 
    <form>
       <?php if(in_array('983',$users_data['permission']['action'])) {
       ?>
       <!-- bootstrap data table -->
        <table id="table" class="table table-striped table-bordered table-responsive medicine_entry_list" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th align="center" width="40"> <input type="checkbox" name="selectall" class="" id="selectAll_garbage" value=""> </th> 
                    <th> Garbage No. </th> 
                    <th> Remarks</th> 
                    <th> Total Amount </th> 
                    <th> Garbage Date </th> 
                 
                   <th> Action </th>
                </tr>
            </thead>  
        </table>
        <?php } ?>
          
    </form>


    

     
   </div> <!-- close -->





  	<div class="userlist-right">
  		<div class="btns">
               <?php if(in_array('982',$users_data['permission']['action'])) {
               ?>
  			     <button class="btn-update" onclick="window.location.href='<?php echo base_url('garbage_stock_item/add');?>'">
  				    <i class="fa fa-plus"></i> New
  			     </button>
             <?php }?>
              <?php if(in_array('983',$users_data['permission']['action'])) {
               ?>
              <a href="<?php echo base_url('garbage_stock_item/garbage_stock_item_excel'); ?>" class="btn-anchor m-b-2">
              <i class="fa fa-file-excel-o"></i> Excel
              </a>

              <a href="<?php echo base_url('garbage_stock_item/garbage_stock_item_csv'); ?>" class="btn-anchor m-b-2">
              <i class="fa fa-file-word-o"></i> CSV
              </a>

              <a href="<?php echo base_url('garbage_stock_item/pdf_garbage_stock_item'); ?>" class="btn-anchor m-b-2">
              <i class="fa fa-file-pdf-o"></i> PDF
              </a>
            <a href="javascript:void(0)" class="btn-anchor m-b-2"  onClick="return print_window_page('<?php echo base_url("garbage_stock_item/print_garbage_stock_item"); ?>');"> <i class="fa fa-print"></i> Print</a>

               <?php } ?>
               <?php if(in_array('979',$users_data['permission']['action'])) {
               ?>
  			     <button class="btn-update" id="deleteAll" onclick="return checkboxValues();">
  				    <i class="fa fa-trash"></i> Delete
  			     </button>
               <?php } ?>
               <?php if(in_array('983',$users_data['permission']['action'])) {
               ?>

                    <button class="btn-update" onclick="reload_table()">
                         <i class="fa fa-refresh"></i> Reload
                    </button>
               <?php } ?>
               <?php if(in_array('978',$users_data['permission']['action'])) {
               ?>
  			     <button class="btn-exit" onclick="window.location.href='<?php echo base_url('garbage_stock_item/archive'); ?>'">
  				    <i class="fa fa-archive"></i> Archive
  			     </button>
               <?php } ?>
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
$(document).ready(function(){
   $('#selectAll_garbage').on('click', function () { 
                                 
         if ($("#selectAll_garbage").hasClass('allChecked')) {
             $('.checklist').prop('checked', false);
         } else {
             $('.checklist').prop('checked', true);
         }
         $(this).toggleClass('allChecked');
    });
});
 function delete_stock_purchase(id)
 {    
    $('#confirm').modal({
      backdrop: 'static',
      keyboard: false
    })
    .one('click', '#delete', function(e)
    { 
        $.ajax({
                 url: "<?php echo base_url('garbage_stock_item/delete/'); ?>"+id, 
                 success: function(result)
                 {
                    flash_session_msg(result);
                    reload_table(); 
                 }
              });
    });     
 }
 
$(document).ready(function() {
   $('#load_add_modal_popup').on('shown.bs.modal', function(e) {
      $('.inputFocus').focus();
   })
}); 
</script> 
<!-- Confirmation Box -->

    <div id="confirm" class="modal fade dlt-modal">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-theme"><h4>Are You Sure?</h4></div>
          <div class="modal-body" style="font-size:8px;">*Data that have been in Archive more than 60 days will be automatically deleted.</div> 
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn-update" id="delete">Confirm</button>
            <button type="button" data-dismiss="modal" class="btn-cancel">Cancel</button>
          </div>
        </div>
      </div>  
    </div> <!-- modal -->

<!-- Confirmation Box end -->
<script>

</script>
<div id="load_add_modal_popup" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false"></div>
</div>
<script>
var $modal = $('#load_add_modal_popup');
  $('#adv_search_medicine').on('click', function(){
  // alert();
$modal.load('<?php echo base_url().'garbage_stock_item/advance_search/' ?>',
{ 
},
function(){
$modal.modal('show');
});

});

$('#start_date_p').datepicker({
    format: 'dd-mm-yyyy', 
    autoclose: true, 
    //endDate : new Date(), 
  }).on("change", function(selectedDate) 
  { 
      var start_data = $('#start_date_p').val();
      $('#end_date_p').datepicker('setStartDate', start_data); 
      form_submit();
  });

  $('#end_date_p').datepicker({
    format: 'dd-mm-yyyy',     
    autoclose: true,  
  }).on("change", function(selectedDate) 
  {   
     form_submit();
  });
  
function form_submit(vals)
{ 
  var start_date = $('#start_date_p').val();
  var end_date = $('#end_date_p').val();
  
 $.ajax({
         url: "<?php echo base_url('garbage_stock_item/advance_search/'); ?>", 
         type: 'POST',
         data: {start_date: start_date, end_date : end_date} ,
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
if(in_array('983',$users_data['permission']['action'])) 
{
?>
$(document).ready(function() { 
   table = $('#table').DataTable({  
        "processing": true, 
        "serverSide": true, 
        "order": [], 
        "pageLength": '20',
        "ajax": {
            "url": "<?php echo base_url('garbage_stock_item/ajax_list')?>",
            "type": "POST",
        }, 
        "columnDefs": [
        { 
            "targets": [ 0 , -1 ], //last column
            "orderable": false, //set not orderable

        },
        ],

    });

    // form_submit();
}); 

<?php }?>
function reset_search()
  { 
    $('#start_date_p').val('');
    $('#end_date_p').val('');
    $.ajax({url: "<?php echo base_url(); ?>garbage_stock_item/reset_search/", 
      success: function(result)
      { 
        reload_table();
      } 
    }); 
  }

/*function form_submit()
{
  $('#new_search_form').delay(200).submit();
}*/
<?php
 $flash_success = $this->session->flashdata('success');
 if(isset($flash_success) && !empty($flash_success))
 {
   echo 'flash_session_msg("'.$flash_success.'");';
 }
 ?>
</script>

<script type="text/javascript">

$('document').ready(function(){
 <?php
 $garbagess_id = $this->session->userdata('garbagess_id');
  if(isset($_GET['status']) && isset($garbagess_id) && $_GET['status']=='print'){ ?>
  $('#confirm_print').modal({
      backdrop: 'static',
      keyboard: false
        })
  
  .one('click', '#cancel', function(e)
    { 
      
    }); 
       
  <?php }
  ?>
 });

</script>
<!-- container-fluid -->
</body>
</html>

<div id="confirm_print" class="modal fade dlt-modal">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-theme"><h4>Are You Sure?</h4></div>
      <!-- <div class="modal-body"></div> -->
      <div class="modal-footer">
          <a  data-dismiss="modal" class="btn-anchor"  onClick="return print_window_page('<?php echo base_url("garbage_stock_item/print_garbage_item/"); ?>');">Print</a>
                   
       <button type="button" data-dismiss="modal" class="btn-cancel" id="cancel">Close</button>
      </div>
    </div>
  </div>  
</div>