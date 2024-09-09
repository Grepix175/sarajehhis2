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
  <input type="hidden" name="id" id="data_id" value="<?php echo $id; ?>">
  
      <div class="modal-header">
          <button type="button" class="close"  data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4><?php echo $page_title; ?></h4> 
      </div>
      
     <div class="modal-body">   
          <div class="row">
               <div class="col-md-12">
                   <div class="row m-b-5">
                         <div class="col-md-5">      
                              <label><b>Select No.:</b></label>
                         </div>
                         <div class="col-md-7">
                              <select name="print_opt_temp" id="print_opt_temp">
                                <option value="1" selected="selected">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                
                              </select>
                         </div>
                    </div>
                    
               </div> <!-- 12 -->
          </div> <!-- row -->  
         
      </div> <!-- modal-body --> 

        <div class="modal-footer">
            <div style="float:right;width:80%;display:inline-flex;">
                <button type="button" class="btn-update" name="submit" id="print" onclick="print_options_report()">Print</button>
                <button type="button" class="btn-cancel" data-dismiss="modal">Close</button>

            </div>
        </div>
</form>     

<script type="text/javascript">

function print_options_report()
{    
  //var print_option = $('#print_opt').val();
  var print_option = $("#print_opt_temp option:selected" ).val();
  var id = $('#data_id').val();
 
  print_window_page('<?php echo base_url('ipd_booking/print_label/') ?>'+id+'/'+print_option);
}  
</script>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
