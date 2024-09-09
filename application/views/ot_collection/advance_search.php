 <div class="modal-dialog advance-search-modal">
    <div class="overlay-loader" id="overlay-loader">
        <img src="<?php echo ROOT_IMAGES_PATH; ?>loader.gif" class="aj-loader">
    </div>
  <div class="modal-content"> 
      <form  id="ot_collection_search_form" class="form-inline"> 
      
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    <h4><?php echo $page_title; ?></h4> 
                </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-xs-12">
                    <!-- ===============start================ -->
                    <div class="advance-search">
                      <div class="inner">




                        <div class="row m-b-5">
                          <label class="col-md-4">Branches</label>
                          <div class="col-md-8">
                             
                               <?php    $users_data = $this->session->userdata('auth_users');
                                        $sub_branch_details = $this->session->userdata('sub_branches_data');
                                        $parent_branch_details = $this->session->userdata('parent_branches_data');
                                        //$branch_name = get_branch_name($parent_branch_details[0]);
                                    ?>
                                <select name="branch_id" id="branch_id">
                                   <option value="">Select Branch</option>
                                   <option  selected="selected" <?php if($form_data['branch_id']==$users_data['parent_id']){ echo 'selected="selected"'; } ?> value="<?php echo $users_data['parent_id'];?>">Self</option>';
                                     <?php 
                                     if(!empty($sub_branch_details)){
                                         $i=0;
                                        foreach($sub_branch_details as $key=>$value){
                                             ?>
                                             <option value="<?php echo $sub_branch_details[$i]['id'];?>" <?php if($form_data['branch_id']==$sub_branch_details[$i]['id']){ echo 'selected="selected"'; } ?> ><?php echo $sub_branch_details[$i]['branch_name'];?> </option>
                                             <?php 
                                             $i = $i+1;
                                         }
                                       
                                     }
                                    ?> 
                                    </select>
                                 </div>

                           </div>



                        
                        <div class="row m-b-5">
                          <label class="col-md-4">From Date</label>
                          <div class="col-md-8">
                            <input type="text" class="datepicker start_datepicker" name="from_date" value="<?php echo $form_data['from_date']; ?>">
                          </div>
                        </div>
                        
                        <!-- <div class="grp">
                          <label>Referred By</label>
                          <select name="refered_id" id="refered_id">
                          <option value="">Select Referred By</option>
                          <?php
                          if(!empty($referal_doctor_list))
                          {
                            foreach($referal_doctor_list as $referal_doctor)
                            {
                              ?>
                                <option <?php if($form_data['refered_id']==$referal_doctor->id){ echo 'selected="selected"'; } ?> value="<?php echo $referal_doctor->id; ?>"><?php echo $referal_doctor->doctor_name; ?></option>
                              <?php
                            }
                          }
                          ?>
                        </select>
                        </div> -->

                        <?php if(in_array('38',$users_data['permission']['section']) && in_array('174',$users_data['permission']['section'])) { ?>
                           <div class="row  m-b-5"> 
                           <label class="col-md-4 label-control">Referred By</label>
                           <div class="col-md-8">
                                <div id="referred_by_1">
                                       <input type="radio" name="referred_by" value="0" <?php if($form_data['referred_by']==0){ echo 'checked="checked"'; } ?>> Doctor &nbsp;
                                        <input type="radio" name="referred_by" value="1" <?php if($form_data['referred_by']==1){ echo 'checked="checked"'; } ?>> Hospital
                                        
                                </div>
                            </div>
                        </div> <!-- innerrow -->

                        <div class="row m-b-5" id="doctor_div_1" <?php if($form_data['referred_by']==0){  }else{ ?> style="display: none;" <?php  } ?> >
                            
                                <label class="col-md-4">Referred By</label>

                              <div class="col-md-8">
                            
                                <select  name="refered_id" id="refered_id_1">
                                    <option value="">Select Doctor</option>
                                    <?php foreach($doctors_list as $doctors) {?>
                                    <option value="<?php echo $doctors->id;?>" <?php if($form_data['refered_id']==$doctors->id){ echo 'selected';}?>><?php echo $doctors->doctor_name;?></option>
                                    <?php }?>
                                </select>
                                   

                           </div>
                        </div> 

                        <div class="row m-b-5" id="hospital_div_1" <?php if($form_data['referred_by']==1){  }else{ ?> style="display: none;" <?php  } ?>>
                            
                            <label class="col-md-4">Referred By</label>
                            <div class="col-md-8">
                                <select name="referral_hospital" id="referral_hospital_1" class="" >
                                  <option value="">Select Hospital</option>
                                  <?php
                                  if(!empty($referal_hospital_list))
                                  {
                                    foreach($referal_hospital_list as $referal_hospital)
                                    {
                                      ?>
                                        <option <?php if($form_data['referral_hospital']==$referal_hospital->id){ echo 'selected="selected"'; } ?> value="<?php echo $referal_hospital->id; ?>"><?php echo $referal_hospital->hospital_name; ?></option>
                                        
                                      <?php
                                    }
                                  }
                                  ?>

                              
                            </select> 
                            </div>
                            
                           
                        </div> 
                        <?php } else if(in_array('38',$users_data['permission']['section']) && !in_array('174',$users_data['permission']['section']))
                        {  ?>
                          <div class="row m-b-5">
                            
                                <label class="col-md-4">Referred By</label>
                              <div class="col-md-8">
                                <select  name="refered_id" id="refered_id_1">
                                    <option value="">Select Doctor</option>
                                    <?php foreach($doctors_list as $doctors) {?>
                                    <option value="<?php echo $doctors->id;?>" <?php if($form_data['refered_id']==$doctors->id){ echo 'selected';}?>><?php echo $doctors->doctor_name;?></option>
                                    <?php }?>
                                </select>
                            </div>
                                   

                           
                        </div> <!-- row -->
                        <input type="hidden" name="referred_by" value="0">
                        <input type="hidden" name="referral_hospital" value="0">
                        <?php 
                        } else if(in_array('38',$users_data['permission']['section']) && !in_array('174',$users_data['permission']['section']))
                        {  
                          ?>

                          <div class="row m-b-5">
                            
                                <label class="col-md-4">Referred By</label>

                                <div class="col-md-8">
                            
                                <select name="referral_hospital" id="referral_hospital_1"  >
                              <option value="">Select Hospital</option>
                              <?php
                              if(!empty($referal_hospital_list))
                              {
                                foreach($referal_hospital_list as $referal_hospital)
                                {
                                  ?>
                                    <option <?php if($form_data['referral_hospital']==$referal_hospital->id){ echo 'selected="selected"'; } ?> value="<?php echo $referal_hospital->id; ?>"><?php echo $referal_hospital->hospital_name; ?></option>
                                    
                                  <?php
                                }
                              }
                              ?>

                              
                            </select> 
                            </div>
                          
                        </div>
                        <input type="hidden" name="referred_by" value="1">
                        <input type="hidden" name="refered_id" value="0">
                          <?php 

                          } ?>
                        
                        

                        <div class="row m-b-5">
                          <label class="col-md-4">Booking Code</label>
                          <div class="col-md-8">
                          <input type="text" name="booking_code" id="booking_code" value="<?php echo $form_data['booking_code']; ?>" />
                          </div>
                        </div>

                        

                        <div class="row m-b-5">
                          <label class="col-md-4">Mobile No. </label>
                          <div class="col-md-8">
                            <input type="text" maxlength="10" name="mobile_no" value="<?php echo $form_data['mobile_no']; ?>" onkeypress="return isNumberKey(event);">
                          </div> 
                        </div> 

                      </div> <!-- inner -->

                      <div class="inner">
                        
                        <div class="row m-b-5">
                          <label class="col-md-4">To Date</label>
                          <div class="col-md-8">
                            <input type="text" name="end_date" class="datepicker end_datepicker" value="<?php echo $form_data['end_date']; ?>">
                          </div>
                        </div>
                          
                      
                        
                        <div class="row m-b-5">
                          <label class="col-md-4">Patient Name</label>
                          <div class="col-md-8">
                            <input type="text" name="patient_name" id="patient_name" value="<?php echo $form_data['patient_name']; ?>" />
                          </div>  
                        </div>


                      
                   <?php if(isset($users_data['emp_id']) && $users_data['emp_id']=='0') 
                        { ?>
                    <div class="row m-b-5">
                          <label class="col-md-4">User</label>
                          <div class="col-md-8">
                            <select name="employee" class="m_input_default" id="employee">
                                <option value="">Select User</option>
                                <option value="<?php echo $users_data['id']; ?>">Self</option>
                                <?php 
                                  if(!empty($employee_list))
                                  {
                                    foreach($employee_list as $employee)
                                    {
                                      echo '<option value="'.$employee->id.'">'.$employee->name.'</option>';
                                    }
                                  }
                                ?> 
                            </select>
                        </div>  
                        </div>  
                      <?php 
                        } 
                        else 
                        { ?>
                        <input type="hidden" name="employee" value="<?php echo $users_data['parent_id'];?>" />

                  <?php }?>

                    <div class="row m-b-5">
                          <label class="col-md-4">Insurance Type</label>
                          <div class="col-md-8"> 
                              <input type="radio" name="insurance_type" value="0" <?php if($form_data['insurance_type']==0){ echo 'checked="checked"'; } ?> onclick="return set_tpa(0)">Normal &nbsp; 
                              <input type="radio" name="insurance_type" value="1" <?php if($form_data['insurance_type']==1){ echo 'checked="checked"'; } ?> onclick="return set_tpa(1)">TPA 
                        </div>  
                        </div>  


                        <div class="row m-b-5">
                          <label class="col-md-4">Type</label>
                          <div class="col-md-8">
                           <select name="insurance_type_id" id="insurance_type_id">
                                    <option value="">Select Insurance Type</option>
                                    <?php
                                    if(!empty($insurance_type_list))
                                    {
                                      foreach($insurance_type_list as $insurance_type)
                                      {
                                        $selected_ins_type = "";
                                        if($insurance_type->id==$form_data['insurance_type_id'])
                                        {
                                          $selected_ins_type = 'selected="selected"';
                                        }
                                        echo '<option value="'.$insurance_type->id.'" '.$selected_ins_type.'>'.$insurance_type->insurance_type.'</option>';
                                      }
                                    }
                                    ?> 
                                  </select> 
                        </div>  
                        </div>  


                        <div class="row m-b-5">
                          <label class="col-md-4">Company</label>
                          <div class="col-md-8">
                           <select name="ins_company_id" id="ins_company_id">
                                    <option value="">Select Insurance Company</option>
                                    <?php
                                    if(!empty($insurance_company_list))
                                    {
                                      foreach($insurance_company_list as $insurance_company)
                                      {
                                        $selected_company = '';
                                        if($insurance_company->id == $form_data['ins_company_id'])
                                        {
                                          $selected_company = 'selected="selected"';
                                        }
                                        echo '<option value="'.$insurance_company->id.'" '.$selected_company.'>'.$insurance_company->insurance_company.'</option>';
                                      }
                                    }
                                    ?> 
                                  </select> 
                        </div>  
                        </div>     
                       
                           

                      </div> <!-- inner -->
                    </div> <!-- advance-search -->

                    <!-- ==================== ends ============= -->
                </div> <!-- 12 -->
              </div> <!-- row -->
            </div> <!-- modal-body -->  
                 
                 
            <div class="modal-footer"> 
               <input type="submit"  class="btn-update" name="submit" value="Search" />
               <!-- <input type="reset" onclick="return reset_search();" class="btn-reset" name="reset" value="Reset" /> -->
               <input value="Reset" class="btn-reset" onclick="reset_search(this.form)" type="button">
               <button type="button" class="btn-cancel" data-dismiss="modal">Close</button>
            </div>
    </form>     

<script> 

function reset_search(ele)
{
  
  $.ajax({url: "<?php echo base_url(); ?>ot_collection_report/reset_date_search/", 
    success: function(result)
    {
      /*$("#medicine_collection_search_form").reset();

      reload_table();*/
      $(ele).find(':input').each(function() {
                switch(this.type) {

                case 'select-multiple':
                case 'select-one':
                case 'text':
                case 'textarea':
                $(this).val('');
                break;
                case 'checkbox':
                case 'radio':
                this.checked = false;
                }
          });
        reload_table();
    } 
  }); 
} 
    $(document).ready(function() {
    $("input[name$='referred_by']").click(function() 
    {
      var test2 = $(this).val();
      if(test2==0)
      {
        $("#hospital_div_1").hide();
        $("#doctor_div_1").show();
        $('#referral_hospital_1').val('');
        
      }
      else if(test2==1)
      {
          
          $("#doctor_div_1").hide();
          $("#hospital_div_1").show();
          $('#refered_id_1').val('');
          //$("#refered_id :selected").val('');
      }
        
    });
}); 
  $("#ot_collection_search_form").on("submit", function(event) { 
    event.preventDefault(); 
    $('#overlay-loader').show();
     
    $.ajax({
      url: "<?php echo base_url('ot_collection_report/advance_search/'); ?>",
      type: "post",
      data: $(this).serialize(),
      success: function(result) 
      {
        $('#load_advance_search_modal_popup').modal('hide'); 
        reload_table();        
      }
    });
  });  

  /*$('.datepicker').datepicker({
    format: 'dd-mm-yyyy', 
    autoclose: true
  });*/


    $('.start_datepicker').datepicker({
    format: 'dd-mm-yyyy', 
    autoclose: true, 
    endDate : new Date(), 
  }).on("change", function(selectedDate) 
  { 
      var start_data = $('.start_datepicker').val();
      $('.end_datepicker').datepicker('setStartDate', start_data); 
  });

  $('.end_datepicker').datepicker({
    format: 'dd-mm-yyyy',     
    autoclose: true,  
  }).on("change", function(selectedDate) 
  {   
  });


   function set_tpa(val)
 { 
    if(val==0)
    {
      $('#insurance_type_id').attr("disabled", true);
      $('#insurance_type_id').val('');
      $('#ins_company_id').attr("disabled", true);
      $('#ins_company_id').val('');
      $('#polocy_no').attr("readonly", "readonly");
      $('#polocy_no').val('');
      $('#tpa_id').attr("readonly", "readonly");
      $('#tpa_id').val('');
      $('#ins_amount').attr("readonly", "readonly");
      $('#ins_amount').val('');
    }
    else
    {
      $('#insurance_type_id').attr("disabled", false);
      $('#ins_company_id').attr("disabled", false);
      $('#polocy_no').removeAttr("readonly", "readonly");
      $('#tpa_id').removeAttr("readonly", "readonly");
      $('#ins_amount').removeAttr("readonly", "readonly");
    }
 }

  set_tpa(<?php echo $form_data['insurance_type']; ?>);

   
</script>  
<!-- Delete confirmation box -->  
<!-- Delete confirmation end --> 
  </div><!-- /.modal-content -->     
</div><!-- /.modal-dialog -->