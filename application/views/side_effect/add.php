<div class="modal-dialog ">
    <div class="overlay-loader" id="overlay-loader">
        <img src="<?php echo ROOT_IMAGES_PATH; ?>loader.gif" class="aj-loader">
    </div>
    <div class="modal-content" style="width:50%; margin:auto;"> 
        <form id="side_effect_modal_form" class="form-inline">
            <input type="hidden" name="data_id" id="side_effect_id" value="<?php echo isset($form_data['data_id']) ? $form_data['data_id'] : ''; ?>" /> 
            <div class="modal-header">
                <button type="button" class="close" data-number="3" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4><?php echo isset($page_title) ? $page_title : ''; ?></h4> 
            </div>
            <div class="modal-body">   
                <div class="row">
                    <div class="col-md-12 m-b1">
                        <div class="row">
                            <div class="col-md-5">
                                <label>Side Effect Name<span class="star">*</span></label> 
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="side_effect_name" value="<?php echo isset($form_data['side_effect_name']) ? $form_data['side_effect_name'] : ''; ?>" class="inputFocus">
                                
                                <?php if(!empty($form_error)) { echo form_error('side_effect_name'); } ?>
                            </div>
                        </div> <!-- innerrow -->
                    </div> <!-- 12 -->
                </div> <!-- row -->  
                 
            </div> <!-- modal-body --> 

            <div class="modal-footer"> 
                <input type="submit" class="btn-update" name="submit" value="Save" />
                <button type="button" class="btn-cancel" data-number="3">Close</button>
            </div>
        </form>     

        <script>  
        $("#side_effect_modal_form").on("submit", function(event) { 
            event.preventDefault(); 
            $('#overlay-loader').show();
            var ids = $('#side_effect_id').val();
            var path = ids != "" && !isNaN(ids) ? 'edit/' + ids : 'add/';
            var msg = ids != "" && !isNaN(ids) ? 'Side Effect successfully updated.' : 'Side Effect successfully created.';

            $.ajax({
                url: "<?php echo base_url('side_effect/'); ?>" + path,
                type: "post",
                data: $(this).serialize(),
                success: function(result) {
                    if (result == 1) {
                        reload_table();
                        $('#load_add_side_effect_popup').modal('hide');
                    } else {
                        $("#load_add_side_effect_popup").html(result);
                    }       
                    $('#overlay-loader').hide();
                }
            });
        });

        $("button[data-number=3]").click(function() {
            $('#load_add_side_effect_popup').modal('hide');
        });
        </script>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<div id="load_add_side_effect_popup" class="modal fade modal-top45" role="dialog" data-backdrop="static" data-keyboard="false"></div>
