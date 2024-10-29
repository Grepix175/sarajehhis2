<?php
$users_data = $this->session->userdata('auth_users');
$field_list = mandatory_section_field_list(5);
//print_r($form_data);
?>
<div class="modal-dialog">
  <div class="overlay-loader" id="overlay-loader">
    <img src="<?php echo ROOT_IMAGES_PATH; ?>loader.gif" class="aj-loader">
  </div>
  <div class="modal-content">
    <form id="emp_type" class="form-inline">
      <input type="hidden" name="data_id" id="type_id" value="<?php echo $form_data['data_id']; ?>" />

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">×</span></button>
        <h4><?php echo $page_title; ?></h4>
      </div>
      <div class="modal-body">
        <!-- // second row -->
        <div class="row">
          <div class="col-md-6">
            <!-- / -->
            <div class="row m-b-5">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-4">
                    <label>Hospital Code<span class="star">*</span></label>
                  </div> <!-- 4 -->
                  <div class="col-md-8">
                    <select name="hos_code_id" class="m_select_btn" id="hos_code_id" tabindex="3">
                      <option value=""> Select Unit </option>
                      <?php
                      if (!empty($hospital_code_list)) {
                        foreach ($hospital_code_list as $hos_code) {
                          ?>
                          <option value="<?php echo $hos_code->id; ?>" <?php if ($hos_code->id == $form_data['hos_code_id']) {
                               echo 'selected="selected"';
                             } ?>>
                            <?php echo $hos_code->hospital_code; ?>
                          </option>
                          <?php
                        }
                      }
                      ?>
                    </select>

                    <?php if (in_array('44', $users_data['permission']['action'])) {
                      ?>
                      <!-- <a href="javascript:void(0)" onclick=" return add_unit();" class="btn-new">
                        <i class="fa fa-plus"></i> New
                      </a> -->
                    <?php } ?>

                    <?php if (!empty($form_error)) {
                      echo form_error('hos_code_id');
                    } ?>
                  </div> <!-- 8 -->
                </div> <!-- innerRow -->
              </div> <!-- 12 -->
            </div> <!-- row -->
            <!-- / -->
          </div>

          <div class="col-md-6">
            <!-- / -->
            <div class="row m-b-5">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-4">
                    <label>Unit 1 <span class="star">*</span></label>
                  </div> <!-- 4 -->
                  <div class="col-md-8">
                    <select name="unit_id" class="m_select_btn" id="unit_id" tabindex="2">
                      <option value=""> Select Unit </option>
                      <?php
                      if (!empty($unit_list)) {
                        foreach ($unit_list as $unit) {
                          ?>
                          <option value="<?php echo $unit->id; ?>" <?php if ($unit->id == $form_data['unit_id']) {
                               echo 'selected="selected"';
                             } ?>><?php echo $unit->medicine_unit; ?></option>
                          <?php
                        }
                      }
                      ?>
                    </select>

                    <?php if (in_array('44', $users_data['permission']['action'])) {
                      ?>
                      <!-- <a href="javascript:void(0)" onclick=" return add_unit();" class="btn-new">
                        <i class="fa fa-plus"></i> New
                      </a> -->
                    <?php } ?>
                    <?php if (!empty($form_error)) {
                      echo form_error('unit_id');
                    } ?>
                  </div> <!-- 8 -->
                </div> <!-- innerRow -->
              </div> <!-- 12 -->
            </div> <!-- row -->
            <!-- / -->
          </div>


        </div>

        <!-- medicine type and barcode -->
        <div class="row">
          <div class="col-md-6">
            <!-- / -->
            <div class="row m-b-5">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-4">
                    <label>Item Desc. </label>
                  </div> <!-- 4 -->
                  <div class="col-md-8">
                    <select name="item_desc_id" class="m_select_btn" id="item_desc_id" tabindex="4">
                      <option value="-1"> Select Item Desc </option>
                      <?php
                      if (!empty($item_desc_list)) {
                        foreach ($item_desc_list as $iten_list) {
                          ?>
                          <option value="<?php echo $iten_list->id; ?>" <?php if ($iten_list->id == $form_data['item_desc_id']) {
                               echo 'selected="selected"';
                             } ?>>
                            <?php echo $iten_list->item_desc; ?>
                          </option>
                          <?php
                        }
                      }
                      ?>
                    </select>

                    <?php if (in_array('44', $users_data['permission']['action'])) {
                      ?>
                      <!-- <a href="javascript:void(0)" onclick=" return add_medicine_type();" class="btn-new">
                        <i class="fa fa-plus"></i> New
                      </a> -->
                    <?php } ?>
                    <?php if (!empty($form_error)) {
                      echo form_error('item_desc_id');
                    } ?>
                  </div> <!-- 8 -->
                </div> <!-- innerRow -->
              </div> <!-- 12 -->
            </div> <!-- row -->
            <!-- / -->
          </div>

          <div class="col-md-6">
            <!-- / -->
            <div class="row m-b-5">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-4">
                    <label>Mfg.Company</label>
                  </div> <!-- 4 -->
                  <div class="col-md-8">
                    <select name="manuf_company" class="m_select_btn" id="manuf_company" tabindex="11">
                      <option value=""> Select Mfg.Company</option>
                      <?php
                      if (!empty($manuf_company_list)) {
                        foreach ($manuf_company_list as $manuf_company) {
                          ?>
                          <option value="<?php echo $manuf_company->id; ?>" <?php if ($manuf_company->id == $form_data['manuf_company']) {
                               echo 'selected="selected"';
                             } ?>>
                            <?php echo $manuf_company->company_name; ?>
                          </option>
                          <?php
                        }
                      }
                      ?>
                    </select>
                    <?php //if(!empty($form_error)){ echo form_error('manuf_company'); } ?>
                    <?php //if(!empty($form_error)){ echo form_error('manuf_company'); } ?>
                    <!-- <a href="javascript:void(0)" onclick=" return add_manuf_company();" class="btn-new">
                      <i class="fa fa-plus"></i> New
                    </a> -->
                  </div> <!-- 8 -->
                </div> <!-- innerRow -->
              </div> <!-- 12 -->
            </div> <!-- row -->
            <!-- / -->
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <!-- / -->
            <div class="row m-b-5">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-4">
                    <label>QTY <span class="star">*</span></label>
                  </div> <!-- 4 -->
                  <div class="col-md-8">
                    <input type="text" maxlength="10" name="qty" id="qty" value="<?php echo $form_data['qty']; ?>"
                      class="price_float m_input_default" placeholder="Enter Qty" tabindex="12">
                    <?php if (!empty($form_error)) {
                      echo form_error('qty');
                    } ?>
                    <div class="text-danger" id="mrp_error"></div>
                  </div> <!-- 8 -->
                </div> <!-- innerRow -->
              </div> <!-- 12 -->
            </div> <!-- row -->
            <!-- / -->
          </div>

          <div class="col-md-6">
            <!-- / -->
            <div class="row m-b-5">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-4">
                    <label>Hospital Rate <span class="star">*</span> </label>

                  </div> <!-- 4 -->

                  <div class="col-md-8">
                    <input type="text" maxlength="10" name="hospital_rate" id="hospital_rate"
                      class="price_float m_input_default" value="<?php echo $form_data['hospital_rate']; ?>"
                      placeholder="Enter Purchase Rate" tabindex="13">
                    <?php
                    if (!empty($form_error)) {
                      echo form_error('hospital_rate');
                    }
                    ?>
                    <div class="text-danger" id="purchase_error"></div>
                  </div> <!-- 8 -->
                </div> <!-- innerRow -->
              </div> <!-- 12 -->
            </div> <!-- row -->
            <!-- / -->
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <!-- / -->
            <div class="row m-b-5">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-4">
                    <label>Status</label>
                  </div> <!-- 4 -->
                  <div class="col-md-8">
                    <input type="radio" name="status" <?php if ($form_data['status'] == 1) {
                      echo 'checked="checked"';
                    } ?> id="status" value="1" /> Active
                    <input type="radio" name="status" <?php if ($form_data['status'] == 0) {
                      echo 'checked="checked"';
                    } ?> id="status" value="0" /> Inactive
                  </div> <!-- 8 -->
                </div> <!-- innerRow -->
              </div> <!-- 12 -->
            </div> <!-- row -->
            <!-- / -->
          </div>
        </div>


        <!-- // seventh row -->

        <div class="row">

          <div class="col-md-6">
            <!-- / -->

            <!-- / -->
          </div>

        </div>







      </div> <!-- modal-body -->


      <div class="modal-footer">
        <button type="submit" tabindex="19" class="btn-update" name="submit">Save</button>
        <button type="button" tabindex="20" class="btn-cancel" data-dismiss="modal">Close</button>
      </div>
    </form>

    <script>
      $(document).ready(function () {
        //get_unit();

      })

      $(function () {
        var getData = function (request, response) {
          $.getJSON(
            "<?php echo base_url('hospital_code_entry/get_salt_vals/'); ?>" + request.term,
            function (data) {
              response(data);
            });
        };

        var selectItem = function (event, ui) {

          $("#medicine_salt").val(ui.item.value);
          //$("#medicine_salt_id").val(ui.item.id);
          return false;
        }

        $("#medicine_salt").autocomplete({
          source: getData,
          select: selectItem,
          minLength: 1,
          change: function () {
            //$("#medicine_types").val("").css("display", 2);
          }
        });
      });


      /* auto complete code for hsn no */
      $(function () {
        var getData = function (request, response) {
          $.getJSON(
            "<?php echo base_url('hospital_code_entry/get_hsn_vals/'); ?>" + request.term,
            function (data) {
              response(data);
            });
        };

        var selectItem = function (event, ui) {

          $("#medicine_hsn_no").val(ui.item.value);
          //$("#medicine_salt_id").val(ui.item.id);
          return false;
        }

        $("#medicine_hsn_no").autocomplete({
          source: getData,
          select: selectItem,
          minLength: 1,
          change: function () {
            //$("#medicine_types").val("").css("display", 2);
          }
        });
      });

      /* auto complete code for hsn no */


      /* $("input").keyup(function() {
          var purchas_value=$('#purchase_rate').val();
          var mrp=$('#mrp').val();
            if(mrp!=''&& purchas_value!=''){
            if(mrp<purchas_value || purchas_value.length>mrp.length){
            $('#mrp_error').html('MRP value is greater and equal to purchase rate');
            }else if(purchas_value>mrp || mrp.length<purchas_value.length) {
            $('#purchase_error').html('Purchase rate must be less and equal to MRP');
            }else{
            $('#purchase_error').html('');
            $('#mrp_error').html('');
            }
          }
      
      
      }); */

      function get_state(country_id) {
        var city_id = $('#city_id').val();
        $.ajax({
          url: "<?php echo base_url(); ?>general/state_list/" + country_id,
          success: function (result) {
            $('#state_id').html(result);
          }
        });
        get_city(city_id);
      }

      function get_city(state_id) {
        $.ajax({
          url: "<?php echo base_url(); ?>general/city_list/" + state_id,
          success: function (result) {
            $('#city_id').html(result);
          }
        });
      }

      function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
        } else {
          return true;
        }
      }

      $('input#conversion').keypress(function (e) {
        if (this.value.length == 0 && e.which == 48) {
          $('#error').html('Zero not allowed');
          //return false;
        } else {
          $('#error').html('');
        }
      });


      $("#emp_type").on("submit", function (event) {
        event.preventDefault();
        $('#overlay-loader').show();
        var ids = $('#type_id').val();
        if (ids != "" && !isNaN(ids)) {
          var path = 'edit/' + ids;
          var msg = 'Hospital Code updated successfully.';
        }
        else {
          var path = 'add/';
          var msg = 'New Hospital Code added successfully.';
        }
        //alert('ddd');return false;
        $.ajax({
          url: "<?php echo base_url('hospital_code_entry/'); ?>" + path,
          type: "post",
          data: $(this).serialize(),
          success: function (result) {
            if (result == 1) {
              $('#load_add_modal_popup').modal('hide');
              flash_session_msg(msg);
              reload_table();
            }
            else {
              $("#load_add_modal_popup").html(result);
            }
            $('#overlay-loader').hide();
          }
        });
      });

      $("button[data-number=1]").click(function () {
        $('#load_add_unit_modal_popup').modal('hide');
      });


      function add_unit() {

        var $modal = $('#load_add_medicine_unit_modal_popup');
        $modal.load('<?php echo base_url() . 'medicine_unit/add/' ?>',
          {
            //'id1': '1',
            //'id2': '2'
          },
          function () {
            $modal.modal('show');
          });
      }

      function add_rack_no() {
        var $modal = $('#load_add_medicine_rack_modal_popup');
        $modal.load('<?php echo base_url() . 'medicine_rack/add/' ?>',
          {
            //'id1': '1',
            //'id2': '2'
          },
          function () {
            $modal.modal('show');
          });
      }

      $("button[data-number=1]").click(function () {
        $('#load_add_medicine_type_modal_popup').modal('hide');
      });

      function add_medicine_type() {

        var $modal = $('#load_add_medicine_type_modal_popup');
        $modal.load('<?php echo base_url() . 'medicine_type/add/' ?>',
          {
            //'id1': '1',
            //'id2': '2'
          },
          function () {
            $modal.modal('show');
          });
      }
      function add_manuf_company() {
        var $modal = $('#load_add_manuf_company_modal_popup');
        $modal.load('<?php echo base_url() . 'manuf_company/add/' ?>',
          {
            //alert();
            //'id1': '1',
            //'id2': '2'
          },
          function () {
            $modal.modal('show');
          });
      }
      function get_unit() {
        $.ajax({
          url: "<?php echo base_url(); ?>medicine_unit/medicine_unit_dropdown/",
          success: function (result) {

            $('#unit_id').html(result);
            $('#unit_second_id').html(result);
          }
        });
      }
      function get_rack() {
        $.ajax({
          url: "<?php echo base_url(); ?>medicine_rack/medicine_rack_dropdown/",
          success: function (result) {
            $('#rack_no').html(result);
          }
        });
      }
      function get_company() {
        $.ajax({
          url: "<?php echo base_url(); ?>manuf_company/manuf_company_dropdown/",
          success: function (result) {
            $('#manuf_company').html(result);
          }
        });
      }

      function get_specilization() {
        $.ajax({
          url: "<?php echo base_url(); ?>specialization/specialization_dropdown/",
          success: function (result) {
            $('#specilization_id').html(result);
          }
        });
      }

      $('#vat').keyup(function () {
        if ($(this).val() > 100) {
          alert('<?php echo get_setting_value('MEDICINE_VAT_NAME'); ?> should be less then 100');
          //$('#error_msg_vat').html('Gst should be less then 100');
        }
      });

      $('#discount').keyup(function () {
        if ($(this).val() > 100) {
          alert('Discount should be less then 100');
          //$('#error_msg_vat').html('Gst should be less then 100');
        }
      });

      $('#cgst').keyup(function () {
        if ($(this).val() > 100) {
          alert('CGST should be less then 100');
          //$('#error_msg_vat').html('Gst should be less then 100');
        }
      });
      $('#sgst').keyup(function () {
        if ($(this).val() > 100) {
          alert('SGST should be less then 100');
          //$('#error_msg_vat').html('Gst should be less then 100');
        }
      });
      $('#igst').keyup(function () {
        if ($(this).val() > 100) {
          alert('IGST should be less then 100');
          //$('#error_msg_vat').html('Gst should be less then 100');
        }
      });
      $(".Cap_medicine_entry").on('keyup', function () {

        var str = $('.Cap_medicine_entry').val();
        var part_val = str.split(" ");
        for (var i = 0; i < part_val.length; i++) {
          var j = part_val[i].charAt(0).toUpperCase();
          part_val[i] = j + part_val[i].substr(1);
        }

        $('.Cap_medicine_entry').val(part_val.join(" "));

      });
    </script>
    <div id="load_add_medicine_type_modal_popup" class="modal fade modal-top" role="dialog" data-backdrop="static"
      data-keyboard="false"></div>
    <div id="load_add_manuf_company_modal_popup" class="modal fade" role="dialog" data-backdrop="static"
      data-keyboard="false"></div>
  </div><!-- /.modal-content -->
  <div id="load_add_medicine_unit_modal_popup" class="modal fade modal-top" role="dialog" data-backdrop="static"
    data-keyboard="false"></div>

  <div id="load_add_medicine_rack_modal_popup" class="modal fade modal-top" role="dialog" data-backdrop="static"
    data-keyboard="false"></div>

</div><!-- /.modal-dialog -->