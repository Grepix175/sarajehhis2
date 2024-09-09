<div class="modal-dialog">
<div class="overlay-loader" id="overlay-loader">
        <img src="<?php echo ROOT_IMAGES_PATH; ?>loader.gif" class="aj-loader">
    </div>
  <div class="modal-content"> 
  <form id="interpretation_form"  class="form-inline">
  <input type="hidden" name="data_id" id="data_id" value="<?php echo $form_data['data_id']; ?>" /> 
  <input type="hidden" name="profile_id" id="profile_id" value="<?php echo $form_data['profile_id']; ?>" /> 
      <div class="modal-header">
          <button type="button" class="close"  data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4><?php echo $page_title; ?></h4> 
      </div> 
      <div class="modal-body">   
          <div class="row">
            <div class="col-md-12 m-b1">
              <div class="row"> 
                <div class="col-md-12">
                    <textarea name="profile_interpretation" class="profile_interpretation" id="interpretation_data">
                      <?php echo $form_data['profile_interpretation']; ?>
                    </textarea>
                    
                    <?php if(!empty($form_error)){ echo form_error('profile_interpretation'); } ?>
                </div>
              </div> <!-- innerrow -->
            </div> <!-- 12 -->
          </div> <!-- row -->   
      </div> <!-- modal-body --> 

      <div class="modal-footer"> 
         <input type="submit"  class="btn-update" name="submit" value="Save" />
         <button type="button" class="btn-cancel" data-dismiss="modal">Close</button>
      </div>
</form>     

<script>  
  CKEDITOR.replace( 'profile_interpretation' );
 
$("#interpretation_form").on("submit", function(event) { 
  event.preventDefault(); 

for (instance in CKEDITOR.instances)
CKEDITOR.instances[instance].updateElement();

  $('#overlay-loader').show();
  var ids = $('#type_id').val();
  if(ids!="" && !isNaN(ids))
  { 
    var path = 'add_profile_interpretation/'+ids;
    var msg = 'Interpretation successfully updated.';
  }
  else
  {
    var path = 'add_profile_interpretation/';
    var msg = 'Interpretation successfully created.';
  } 
  //alert('ddd');return false;
  $.ajax({
    url: "<?php echo base_url('test/'); ?>"+path,
    type: "post",
    data: $(this).serialize(),
    success: function(result) {
      if(result==1)
      {
        $('#load_add_test_modal_popup').modal('hide');
        flash_session_msg(msg);  
      } 
      else
      {
        $("#load_add_test_modal_popup").html(result);
      }       
      $('#overlay-loader').hide();
    }
  });
}); 
  


</script>  
<!-- Delete confirmation box -->  
<!-- Delete confirmation end --> 
        </div><!-- /.modal-content -->
    
</div><!-- /.modal-dialog -->