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


<link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datepicker.css">
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap-datepicker.js"></script>

<!-- datatable js -->
<script src="<?php echo ROOT_JS_PATH; ?>jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT_JS_PATH; ?>dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>validation.js"></script> 
<script type="text/javascript">
var save_method; 
var table;
<?php
if(in_array('1249',$users_data['permission']['action'])) 
{
?>
$(document).ready(function() { 
    table = $('#table').DataTable({  
        "processing": true, 
        "serverSide": true, 
        "order": [], 
        "pageLength": '20',
        "ajax": {
            "url": "<?php echo base_url('test_home_collection/ajax_list')?>",
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

<?php
}
?>

function edit_record(id)
{
  var $modal = $('#load_add_record_modal_popup');
  $modal.load('<?php echo base_url().'test_home_collection/edit/' ?>'+id,
  {
    //'id1': '1',
    //'id2': '2'
    },
  function(){
  $modal.modal('show');
  });
}

function view_employee(id)
{
  var $modal = $('#load_add_record_modal_popup');
  $modal.load('<?php echo base_url().'employee/view/' ?>'+id,
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
           <?php
           if(in_array('1249',$users_data['permission']['action'])) 
           {
           ?>
           <!-- bootstrap data table -->
            <table id="table" class="table table-striped table-bordered employee_list" cellspacing="0" width="100%">
                <thead class="bg-theme">
                    <tr>

                        <th> Status </th>
                        <th> Charge </th> 
                        <th> Created Date </th> 
                        <th> Action </th>
                    </tr>
                </thead>  
            </table>
           <?php
           }
           ?>

        </form>


   </div> <!-- close -->





  	<div class="userlist-right">
  		<div class="btns">
      <?php
     
       if(in_array('1249',$users_data['permission']['action'])) 
       {
        ?>
        <button class="btn-update" onclick="reload_table()">
          <i class="fa fa-refresh"></i> Reload
        </button>
        <?php
       }
      ?> 
  			
        
  			
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

 function delete_emp(emp_id)
 {    
    $('#confirm').modal({
      backdrop: 'static',
      keyboard: false
    })
    .one('click', '#delete', function(e)
    { 
        $.ajax({
                 url: "<?php echo base_url('employee/delete/'); ?>"+emp_id, 
                 success: function(result)
                 {
                    flash_session_msg(result);
                    reload_table(); 
                 }
              });
    });     
 }
$(document).ready(function() {
   $('#load_add_record_modal_popup').on('shown.bs.modal', function(e) {
      $('.inputFocus').focus();
   })
});
/*$(document).ready(function() {
   $('#load_add_emp_type_modal_popup').on('shown.bs.modal', function(e) {
      $('.inputFocus').focus();
   })
});  */
</script> 
<!-- Confirmation Box -->
  <div id="confirm" class="modal fade dlt-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h4>Are you sure?</h4>
        </div>
        <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn-update" id="delete">Confirm</button>
          <button type="button" data-dismiss="modal" class="btn-cancel">Close</button>
        </div>
      </div>
    </div>  
  </div>
<!-- Confirmation Box end -->
<div id="load_add_record_modal_popup" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false"></div>
</div><!-- container-fluid -->
</body>
</html>