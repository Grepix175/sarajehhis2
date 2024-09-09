<?php
$users_data = $this->session->userdata('auth_users');

?>
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datepicker.css">
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap-datepicker.js"></script>
<div class="modal-dialog emp-add-add">
<div class="overlay-loader" id="overlay-loader">
        <img src="<?php echo ROOT_IMAGES_PATH; ?>loader.gif" class="aj-loader">
    </div>
  <div class="modal-content"> 
  <form  id="new_relation" class="form-inline">
 
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"  data-number="1" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4><?php echo $page_title; ?></h4> 
      </div>
      
     <div class="modal-body">   
          <div class="row">
               <div class="col-md-12">
                   
                    <div class="row m-b-5">
                         <div class="col-md-5">
                              <label><b>From Date:</b></label>
                         </div>
                         <div class="col-md-7">
                              <input type="text" id="from_g_date" name="from_g_date" class="collection_datepicker" value="<?php echo date('d-m-Y'); ?>">
                         </div>
                    </div>
                    <div class="row m-b-5">
                         <div class="col-md-5">      
                              <label><b>To Date:</b></label>
                         </div>
                         <div class="col-md-7">
                              <input type="text" name="to_g_date" id="to_g_date" class="collection_datepicker_to" value="<?php echo date('d-m-Y'); ?>">
                         </div>
                    </div>

                  
                    <div id="export_type">
                    <div class="row m-b-5">
                         <div class="col-md-5">      
                              <label><b>Export Type:</b></label>
                         </div>
                         <div class="col-md-7">
                             <select name="print_opt" id="print_opt" onchange="print_options_report(this.value)">
                              <option value="">Select Print Options</option>
                              <option value="1" selected="selected">Plain</option>
                              <!-- <option value="2">Excel</option>
                              <option value="3">Pdf</option> -->
                              </select>
                         </div>
                    </div>
                    </div>
                    
               </div> <!-- 12 -->
          </div> <!-- row -->  
         
      </div> <!-- modal-body --> 

        <div class="modal-footer">
            <div style="float:right;width:80%;display:inline-flex;">
                <!-- <button type="submit"  class="btn-update" id="reset_date" value="Reset" onClick="reset_date_search();">Reset</button> -->
                <button type="button" class="btn-update" name="submit" id="print_allot">Print</button>
                <?php //if(in_array('245',$users_data['permission']['action'])){ ?>
                <a href="" class="btn-anchor" style="display:none;" class="btn-update"  name="print_pdf" id="print_pdf">Print</a>
                <?php //} ?>
                <button type="button" class="btn-cancel" data-dismiss="modal"  data-number="1">Close</button>
            </div>
        </div>
</form>     

<script type="text/javascript">
$(document).ready(function(){
  var printOpt = $( "#print_opt option:selected" ).val();
  print_options_report(printOpt);
});

$('.collection_datepicker').datepicker({
    format: 'dd-mm-yyyy', 
    autoclose: true, 
    endDate : new Date(), 
  }).on("change", function(selectedDate) 
  { 
      var start_data = $('.collection_datepicker').val();
      $('.collection_datepicker_to').datepicker('setStartDate', start_data);
       
  });

  $('.collection_datepicker_to').datepicker({
    format: 'dd-mm-yyyy',     
    autoclose: true,  
  }).on("change", function(selectedDate) 
  {   
  });  


function print_options_report(print_option){
  //alert(print_option);
     $("#print_allot").removeAttr("onClick");
     document.getElementById("print_pdf").style.display = "none";
     document.getElementById("print_allot").style.display = "block";
     var start_date = $('#from_g_date').val();
     var end_date = $('#to_g_date').val(); 
      var section_type = $('#section_type').val();
      var branch_id= $('#branch_id').val();
     if(print_option!=''){
          if(print_option==1){
               $("#print_allot").attr("onClick","return inventory_report();");
          }else if(print_option==2){
                          $("#print_allot").removeAttr("onClick");
                          $("#print_allot").removeAttr("onClick");
                          $("#print_allot").attr("onClick","return print_window_page('<?php echo base_url('inventory_report/inventory_purchase_report_excel?') ?>start_date="+start_date+"&end_date="+end_date+"&section_type=3&branch_id="+branch_id+"');");
          }else if(print_option==3){ 
               $("#print_allot").removeAttr("onClick");
                $("#print_allot").attr("onClick","return print_window_page('<?php echo base_url('inventory_report/inventory_purchase_report_pdf?') ?>start_date="+start_date+"&end_date="+end_date+"&section_type=3&branch_id="+branch_id+"');");

               /*var start_date = $('#start_date_from').val();
               var end_date = $('#end_date_to').val(); 
               document.getElementById("print_allot").style.display = "none";
                document.getElementById("print_pdf").style.display = "block";
               $("#print_pdf").attr("href","< ?php echo base_url("reports/print_pdf?") ?>start_date="+start_date+"&end_date="+end_date+"");
*/
          }
          else{
                document.getElementById("print_pdf").style.display = "none";
                document.getElementById("print_allot").style.display = "block";
               $("#print_allot").removeAttr("onClick");
          }
     }
} 


function inventory_report()
{   
  var start_date = $('#from_g_date').val();
  var end_date = $('#to_g_date').val(); 
  var section_type = $('#section_type option:selected').val(); 
  var branch_id = $('#branch_id option:selected').val();
   window.open('<?php echo base_url('inventory_report/print_inventory_dialysis_reports?') ?>start_date='+start_date+'&end_date='+end_date+'&section_type=3&branch_id='+branch_id,'mywin','width=800,height=600');
}  


$(document).ready(function(){
 // export_type_select('all');
     $.post('<?php echo base_url('reports/get_allsub_branch_list/'); ?>',{},function(result){
          $("#child_branch").html(result);
     });
 });
 var count = 0;
 
 function reset_date_search(){
     $("#start_date").val('');
     $("#end_date").val('');
 }
 $("button[data-number=1]").click(function(){
    $('#load_inventory_allotment_modal_popup').modal('hide');
});
</script>
<!-- Delete confirmation box -->  
<!-- Delete confirmation end --> 
        </div><!-- /.modal-content -->
    
</div><!-- /.modal-dialog -->
<div id="load_gst_modal_popup" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false"></div>