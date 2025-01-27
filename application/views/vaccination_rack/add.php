<div class="modal-dialog emp-add-add">
<div class="overlay-loader" id="overlay-loader">
        <img src="<?php echo ROOT_IMAGES_PATH; ?>loader.gif" class="aj-loader">
    </div>
  <div class="modal-content"> 
  <form  id="vaccination_rack" class="form-inline">
  <input type="hidden" name="data_id" id="type_id" value="<?php echo $form_data['data_id']; ?>" /> 
      <div class="modal-header">
          <button type="button" class="close"  data-number="1" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4><?php echo $page_title; ?></h4> 
      </div>
      
      <div class="modal-body">   
          <div class="row">
            <div class="col-md-12 m-b1">
              <div class="row">
                <div class="col-md-5">
                    <label>Rack No.</label>
                </div>
                <div class="col-md-7">
                    <input type="text" name="rack_no" class="alpha_numeric_space inputFocus" value="<?php echo $form_data['rack_no']; ?>">
                    
                    <?php if(!empty($form_error)){ echo form_error('rack_no'); } ?>
                </div>
              </div> <!-- innerrow -->
            </div> <!-- 12 -->
          </div> <!-- row -->  
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-5">
                    <label>Status</label>
                </div>
                <div class="col-md-7">
                     <input type="radio"  class="" name="status" <?php if($form_data['status']==1){ echo 'checked="checked"'; } ?> id="status" value="1" /> Active  
                     <input type="radio"  class="" name="status" <?php if($form_data['status']==0){ echo 'checked="checked"'; } ?> id="login_status" value="0" /> Inactive   
                 </div>
              </div> <!-- innerrow -->
            </div> <!-- 12 -->
          </div> <!-- row -->  
      </div> <!-- modal-body --> 

      <div class="modal-footer"> 
         <input type="submit"  class="btn-update" name="submit" value="Save" />
         <button type="button" class="btn-cancel" data-number="1">Close</button>
      </div>
</form>     

<script>  

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    } else {
        return true;
    }      
}
 
$("#vaccination_rack").on("submit", function(event) { 
  event.preventDefault(); 
  $('#overlay-loader').show();
  var ids = $('#type_id').val();
  if(ids!="" && !isNaN(ids))
  { 
    var path = 'edit/'+ids;
    var msg = 'Vaccination Rack number successfully updated.';
  }
  else
  {
    var path = 'add/';
    var msg = 'Vaccination Rack number successfully created.';
  } 
  //alert('ddd');return false;
  $.ajax({
    url: "<?php echo base_url('vaccination_rack/'); ?>"+path,
    type: "post",
    data: $(this).serialize(),
    success: function(result) {
      if(result==1)
      {
        $('#load_add_vaccination_rack_modal_popup').modal('hide');
        flash_session_msg(msg);
        get_rack();
        reload_table();
      } 
      else
      {
        $("#load_add_vaccination_rack_modal_popup").html(result);
      }       
      $('#overlay-loader').hide();
    }
  });
}); 

$("button[data-number=1]").click(function(){
    $('#load_add_vaccination_rack_modal_popup').modal('hide');
});

function get_rack()
{
   $.ajax({url: "<?php echo base_url(); ?>vaccination_rack/vaccination_rack_dropdown/", 
    success: function(result)
    {
      $('#rack_no').html(result); 
    } 
  });
}
</script>   
        </div> 
    
</div> 