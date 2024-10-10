<div class="modal-dialog ">
    <div class="overlay-loader" id="overlay-loader">
        <img src="<?php echo ROOT_IMAGES_PATH; ?>loader.gif" class="aj-loader">
    </div>
    <div class="modal-content"> 
        <form id="brand_modal_form" class="form-inline">
            <input type="hidden" name="data_id" id="brand_id" value="<?php echo $form_data['data_id']; ?>" /> 
            <div class="modal-header">
                <button type="button" class="close" data-number="3" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4><?php echo $page_title; ?></h4> 
            </div>
            <div class="modal-body">   
                <div class="row">
                    <div class="col-md-12 m-b1">
                        <div class="row">
                            <div class="col-md-5">
                                <label>Brand Name<span class="star">*</span></label> 
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="brand_name" value="<?php echo $form_data['brand_name']; ?>" class="inputFocus">
                                
                                <?php if(!empty($form_error)){ echo form_error('brand_name'); } ?>
                            </div>
                        </div> <!-- innerrow -->
                    </div> <!-- 12 -->
                </div> <!-- row -->  
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5">
                                <label>Status<span class="star">*</span></label>
                            </div>
                            <div class="col-md-7">
                                <input type="radio" class="" name="brand_status" <?php if($form_data['brand_status']=='active'){ echo 'checked="checked"'; } ?> id="brand_status" value="1" /> Active  
                                <input type="radio" class="" name="brand_status" <?php if($form_data['brand_status']!=='active'){ echo 'checked="checked"'; } ?> id="login_status" value="0" /> Inactive   
                            </div>
                        </div> <!-- innerrow -->
                    </div> <!-- 12 -->
                </div> <!-- row -->  
            </div> <!-- modal-body --> 
 <!-- modal-body --> 

            <div class="modal-footer"> 
                <input type="submit" class="btn-update" name="submit" value="Save" />
                <button type="button" class="btn-cancel" data-number="3">Close</button>
            </div>
        </form>     

        <script>  
        $("#brand_modal_form").on("submit", function(event) { 
            event.preventDefault(); 
            $('#overlay-loader').show();
            var ids = $('#brand_id').val();
            var path = ids != "" && !isNaN(ids) ? 'edit/' + ids : 'add/';
            var msg = ids != "" && !isNaN(ids) ? 'Brand successfully updated.' : 'Brand successfully created.';

            $.ajax({
                url: "<?php echo base_url('ipd_brands/'); ?>" + path,
                type: "post",
                data: $(this).serialize(),
                success: function(result) {
                    if (result == 1) {
                        // alert(result);
                        reload_table();
                        $('#load_add_brand_popup').modal('hide');
                    } else {
                        $("#load_add_brand_popup").html(result);
                    }       
                    $('#overlay-loader').hide();
                }
            });
        });

        $("button[data-number=3]").click(function() {
            $('#load_add_brand_popup').modal('hide');
        });
        </script>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<div id="load_add_brand_popup" class="modal fade modal-top45" role="dialog" data-backdrop="static" data-keyboard="false"></div>
