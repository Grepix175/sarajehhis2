<?php 
$users_data = $this->session->userdata('auth_users'); 

if (array_key_exists("permission",$users_data)){
     $permission_section = $users_data['permission']['section'];
     $permission_action = $users_data['permission']['action'];
}
else{
     $permission_section = array();
     $permission_action = array();
}
$field_list = mandatory_section_field_list(6);
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

<!-- datatable js -->
<script src="<?php echo ROOT_JS_PATH; ?>jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT_JS_PATH; ?>dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>moment-with-locales.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datepicker.css">
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap-datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datetimepicker.css">
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap-datetimepicker.js"></script>
<script src="<?php echo ROOT_JS_PATH; ?>validation.js"></script>
<script>
$('document').ready(function(){
 <?php
 $ipd_booking_id = $this->session->userdata('ipd_booking_id');
 if(isset($_GET['status']) && isset($ipd_booking_id) && $_GET['status']=='print'){ ?>
  $('#confirm_print').modal({
      backdrop: 'static',
      keyboard: false
        })
  
  .one('click', '#cancel', function(e)
    { 
       // window.location.href='<?php echo base_url('opd/booking');?>'; 
    }); 
       
  <?php } ?>




   <?php if(isset($_GET['status']) && isset($ipd_booking_id) && isset($_GET['mlc_status']) && $_GET['mlc_status']==1){?>
  $('#confirm_mlc').modal({
      backdrop: 'static',
      keyboard: false
        })
  
    .one('click', '#cancel', function(e)
    { 
        //window.location.href='<?php echo base_url('ipd_booking');?>'; 
        //print_window_page('<?php echo base_url("ipd_booking"); ?>')
    }) ;
   
       
  <?php }?>

<?php if(isset($_GET['status']) && isset($ipd_booking_id) && isset($_GET['admission_form']) && $_GET['admission_form']=='print_admission'){?>
  $('#confirm_admission_print').modal({
      backdrop: 'static',
      keyboard: false
        })
  
  .one('click', '#cancel', function(e)
    { 
        //window.location.href='<?php echo base_url('ipd_booking');?>'; 
        //print_window_page('<?php echo base_url("ipd_booking"); ?>')
    }) ;
   
       
  <?php }?>
  
  <?php if($users_data['parent_id']=='113' && isset($_GET['status']) && isset($ipd_booking_id) && isset($_GET['admission_consent_form']) && $_GET['admission_consent_form']=='print_consent_form'){?>
  $('#confirm_admission_consent').modal({
      backdrop: 'static',
      keyboard: false
        })
  
  .one('click', '#cancel', function(e)
    { 
        //window.location.href='<?php echo base_url('ipd_booking');?>'; 
        //print_window_page('<?php echo base_url("ipd_booking"); ?>')
    }) ;
   
       
  <?php }?>
  
  });



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
 <form action="<?php echo current_url(); ?>" method="post" id="form_submit_data"> 
<input type="hidden" name="discharge_date" id="discharge_date" value="<?php echo $form_data['discharge_date']; ?>" />    
<input type="hidden" class="m_input_default" name="data_id" id="type_id" value="<?php echo $form_data['data_id']; ?>" />
    <input type="hidden" class="m_input_default"  name="patient_id" value="<?php if(isset($form_data['patient_id'])){echo $form_data['patient_id'];}else{ echo '';}?>"/>

<div class="row">
    <div class="col-sm-4">
         <?php 
                /*$checked_reg=''; 
                $checked_ipd='';
                $checked_nor='checked';
               ?>
                <?php if(isset($_GET['ipd']) && $_GET['ipd']!='') {

                $checked_ipd="checked";
                $checked_nor='';
                } */ ?>
                <?php 
                
                if(isset($_GET['ipd']) && $_GET['ipd']!='') 
                {
                $checked_reg="";
                $checked_nor='';
                $checked_ipd='checked';
                $set_payment_hide=1;
                }
                elseif(isset($form_data['data_id']) && $form_data['data_id']!='') 
                {
                    $checked_reg="";
                    $checked_nor='';
                    $checked_ipd ="checked";
                }
                else
                {
                    $checked_reg=''; 
                    $checked_ipd='';
                    $checked_nor='checked';  
                    $set_payment_hide=0;

                }

                ?>
               
        <!-- <div class="row m-b-5">
             <div class="col-sm-5"><label><input type="radio" name="" <?php //echo $checked_nor; ?> onClick="window.location='<?php// echo base_url('ipd_booking/');?>add/';"> New Patient</label></div> 
            <div class="col-sm-7">
                <label><input type="radio" name="" <?php //echo $checked_ipd; ?> onClick="window.location='<?php //echo base_url('patient');?>';"> <span>Registered</span></label>
            </div>
        </div> -->

        <div class="row m-b-2">
            <div class="col-sm-5"><label>MLC</label>
              <!-- <sup class="info"><a href="javascript:void(null)" class="small info"> ?<span>Medicolegal cases (MLC) are an integral part of medical practice that is frequently encountered by Medical Officers (MO). The occurrence of MLCs is on the increase, both in the Civil as well as in the Armed Forces.</span></a></sup> -->
            </div>
            <div class="col-sm-7">
           
                <label><input type="radio" name="mlc_status" value="1" <?php if($form_data['mlc_status']=="1"){echo 'checked';} ?> onchange="check_status(1);">Yes</label> &nbsp;
                <label><input type="radio" name="mlc_status" value="0" <?php if($form_data['mlc_status']=="0"){echo 'checked';} ?> onchange="check_status(0);">No</label>

                 <input type="text" name="mlc" value="<?php echo $form_data['mlc'];?>" id="mlc_status" <?php if($form_data['mlc_status']=='1'){echo "style='display:block;'";} else{echo "style='display:none;'";}?>/>

            </div>
        </div>
        
        <div class="row m-b-5">
            <div class="col-sm-5"><label><?php echo $data= get_setting_value('PATIENT_REG_NO');?><span class="star">*</span></label></div>
             <input type="hidden" class="m_input_default" value="<?php echo $form_data['patient_reg_code'];?>" name="patient_reg_code" />
            <div class="col-sm-7">
                <div class="ipdbox"><?php echo $form_data['patient_reg_code'];?></div>
            </div>
        </div>
        
        <div class="row m-b-5">
        <input type="hidden" value="<?php echo $form_data['ipd_no'];?>" name="ipd_no" />
            <div class="col-sm-5"><label>IPD No.<span class="star">*</span></label></div>
            <div class="col-sm-7">
                <div class="ipdbox"> <?php echo $form_data['ipd_no'];?> </div>
            </div>
        </div>
        
        <div class="row m-b-5">
            <div class="col-sm-5"><label>Patient Name <span class="star">*</span></label></div>
            <div class="col-sm-7">
                <select class="mr m_mr" name="simulation_id" id="simulation_id" onchange="find_gender(this.value)">
                  <option value="">Select</option>
                    <?php 
                    //$simulations_array = array('Mr','mR','mr','MR','Mr.','mR.','mr.','MR.');
                    $simulations_arr=[];
          if(!empty($simulation_array))
          {
              foreach($simulation_array as $simulation_array)
              {
                $simulations_arr[]=$simulation_array->id;
              }    
          }
                    foreach($simulation_list as $simulation){
                        $selected_simulation = '';
                        if(in_array($simulation->simulation,$simulations_arr))
                        {
                            $selected_simulation = 'selected="selected"';

                        }
                        else
                        {
                          if($simulation->id==$form_data['simulation_id'])
                          {
                               $selected_simulation = 'selected="selected"';
                          }
                         }

                         if($simulation->simulation == "Mr.")
                         {
                          $selected_simulation = 'selected="selected"';
                         }
                        ?>
                      <option value="<?php echo $simulation->id; ?>" <?php  echo $selected_simulation; ?>><?php echo $simulation->simulation;?></option>
                    <?php }
                    ?>
                </select>
                <input type="text" name="name" class="mr-name m_name txt_firstCap" value="<?php echo $form_data['name'];?>">

                <div class=""><?php if(!empty($form_error)){ echo form_error('simulation_id'); } ?>
                    </div>
                <div class=""><?php if(!empty($form_error)){ echo form_error('name'); } ?>
                    </div>
            </div>
        </div>

                    <!-- new code by mamta -->
    <div class="row m-b-5">
      <div class="col-sm-5">
        <strong> 
          <select name="relation_type"  class="w-90px" onchange="father_husband_son(this.value);">
          <?php foreach($gardian_relation_list as $gardian_list) 
          {?>
          <option value="<?php echo $gardian_list->id;?>" <?php if(isset($form_data['relation_type']) && $form_data['relation_type']==$gardian_list->id){echo 'selected';}?>><?php echo $gardian_list->relation;?></option>
          <?php }?>
          </select>

             </strong>
      </div>
      <div class="col-sm-7">
        <select class="mr m_mr" name="relation_simulation_id" id="relation_simulation_id">
          <option value="">Select</option>
          <?php
            // Ensure $simulations_array is defined and is an array
            $simulations_array = isset($simulations_array) && is_array($simulations_array) ? $simulations_array : [];

            // Check if $simulation_list is not empty
            if (!empty($simulation_list)) {
                foreach ($simulation_list as $simulation) {
                    $selected_simulation = '';

                    // Use in_array safely with the initialized array
                    if (in_array($simulation->simulation, $simulations_array) || $simulation->id == $form_data['relation_simulation_id']) {
                        $selected_simulation = 'selected="selected"';
                    }

                    // Output the option tag
                    echo '<option value="' . htmlspecialchars($simulation->id) . '" ' . $selected_simulation . '>' . htmlspecialchars($simulation->simulation) . '</option>';
                }
            }
            ?>


        </select> 
        <input type="text" value="<?php if(isset($form_data['relation_name'])){ echo $form_data['relation_name'];}?>" name="relation_name" id="relation_name" class="mr-name m_name"/>
      </div>
    </div> <!-- row -->

<!-- new code by mamta -->

        <div class="row m-b-5">
            <div class="col-sm-5"><label>Gender <span class="star">*</span></label></div>
            <!-- <div class="col-sm-7">
                <span class="text-normal"><input type="radio" name="gender" value="0" < ?php if($form_data['gender']==0){ echo 'checked';} ?>> <span>Male</span></span>
                <span class="text-normal"><input type="radio" name="gender"  value="1" < ?php if($form_data['gender']==1){ echo 'checked';} ?>> <span>Female</span></span>
            </div> -->
            <div class="col-sm-7" id="gender">
           <input type="radio" name="gender" checked value="1" <?php if($form_data['gender']==1){ echo 'checked="checked"'; } ?>> Male &nbsp;
            <input type="radio" name="gender" value="0" <?php if($form_data['gender']==0 && !empty($form_data['gender'])){ echo 'checked="checked"'; } ?>> Female
              <input type="radio" name="gender" value="2" <?php if($form_data['gender']==2){ echo 'checked="checked"'; } ?>> Others
            <?php if(!empty($form_error)){ echo form_error('gender'); } ?>
         </div>
        </div>
        <?php //echo "<pre>";print_r($form_data);die; ?>
                
        <div class="row m-b-5">
            <div class="col-sm-5"><label>Age <?php if(!empty($field_list)){
                    if($field_list[1]['mandatory_field_id']==31 && $field_list[1]['mandatory_branch_id']==$users_data['parent_id']){?>         
                         <span class="star">*</span>
                    <?php 
                    }
               } 
          ?></label></div>
            <div class="col-sm-7">
                <input type="text" name="age_y" class="input-tiny m_tiny"  value="<?php echo $form_data['age_y'];?>"> Y
                <input type="text" name="age_m" class="input-tiny m_tiny" value="<?php echo $form_data['age_m'];?>"> M
                <input type="text" name="age_d" class="input-tiny m_tiny" value="<?php echo $form_data['age_d'];?>"> D
                <?php if(!empty($field_list)){
                         if($field_list[1]['mandatory_field_id']=='31' && $field_list[1]['mandatory_branch_id']==$users_data['parent_id']){
                              if(!empty($form_error)){ echo form_error('age_y'); }
                         }
                    }
                ?>
            </div>

        </div>
        
        <div class="row m-b-5">
            <div class="col-sm-5"><label>Mobile No. <?php if(!empty($field_list)){
                    if($field_list[0]['mandatory_field_id']==30 && $field_list[0]['mandatory_branch_id']==$users_data['parent_id']){?>         
                         <span class="star">*</span>
                    <?php 
                    }
               } 
          ?></label></div>
            <div class="col-sm-7">
                 <input type="text" name="" readonly="readonly" value="<?php echo $form_data['country_code'];?>" class="country_code m_c_code" placeholder="+91" style="width:59px;"> 
                <input type="text" name="mobile" class="number m_number" id="mobile_no" maxlength="10" value="<?php echo $form_data['mobile'];?>" onKeyPress="return isNumberKey(event);" required>
                    <div class="">
                    <?php if(!empty($field_list)){
                         if($field_list[0]['mandatory_field_id']=='30' && $field_list[0]['mandatory_branch_id']==$users_data['parent_id']){
                              if(!empty($form_error)){ echo form_error('mobile'); }
                         }
                    }
          ?>
                    </div>
            </div>
        </div>
        
        <!-- <div class="row m-b-5">
            <div class="col-md-5">
               <div class="row">
                 
                 <div class="col-md-7" style="text-align: center;">
                    <a href="javascript:void(0);" class="show_hide_more" data-content="toggle-text" onclick="more_patient_info()">More Info</a>
                 </div>
               </div>
            </div>
          </div>  -->
          <!-- row -->

        <div class="more_content" id="patient_info" style="display: none;">
        
         <!-- <div class="row m-b-3">
            <div class="col-xs-5">
               <label>Address 1</label>
            </div>
            <div class="col-xs-7">
               <input type="text" name="address" id="" class="address" value="<?php echo $form_data['address'];?>"/>
               <?php //if(!empty($form_error)){ echo form_error('address'); } ?> -->
            <!-- </div>
          </div>

           <div class="row m-b-3">
            <div class="col-xs-5">
               <label>Address 2</label>
            </div>
            <div class="col-xs-7">
               <input type="text"  name="address_second" class="address" value="<?php echo $form_data['address_second'];?>"/>
              
            </div>
          </div>
           <div class="row m-b-3">
            <div class="col-xs-5">
               <label>Address 3</label>
            </div>
            <div class="col-xs-7">
               <input type="text" name="address_third" class="address" value="<?php echo $form_data['address_third'];?>"/>
               
            </div>
        </div> -->
        </div> <!--more div close -->

        <div class="row m-b-3">
            <div class="col-xs-5">
                <label>Email</label>
            </div>
            <div class="col-xs-7">
                <input type="text" name="patient_email1" required 
                    value="<?php echo isset($form_data['patient_email']) ? $form_data['patient_email'] : (isset($form_data['patient_email1']) ? $form_data['patient_email1'] : ''); ?>"
                    oninput="validateEmail(this)" />
                <br><span id="email_error" style="color: red;width:200px;"></span> <!-- Error message span -->
                <?php if(!empty($form_error)){ echo form_error('patient_email1'); } ?>
            </div>
        </div>
          <div class="row m-b-3">
              <div class="col-xs-5">
                  <label>Aadhaar No.</label>
              </div>
              <div class="col-xs-7">
              <input type="text" name="adhar_no" 
                    value="<?php echo isset($form_data['adhar_no']) ? $form_data['adhar_no'] : ''; ?>"
                    oninput="validateAadhaar(this)" maxlength="12"/>
                  <?php if(!empty($form_error)){ echo form_error('adhar_no'); } ?>
              </div>
          </div>

          <div class="row m-b-3">
              <div class="col-xs-5">
                  <label>Village/Town</label>
              </div>
              <div class="col-xs-7">
                  <input type="text" name="address" id="address" class="address" maxlength="255" value="<?php echo $form_data['address']; ?>"/>
                  <?php
                  //if(!empty($form_error)){ echo form_error('address'); } 
                  ?>
              </div>
          </div>

          <div class="row m-b-3">
              <div class="col-xs-5">
                  <label>Dist./Taluk/Thana</label>
              </div>
              <div class="col-xs-7">
                  <input type="text" name="address_second" id="address_second" class="address" maxlength="255" value="<?php echo $form_data['address_second']; ?>"/>
              </div>
          </div>

          <div class="row m-b-3">
              <div class="col-xs-5">
                  <label>State</label>
              </div>
              <div class="col-xs-7">
                <select name="state_id" id="state_id" onChange="return get_city(this.value)">
                  <option value="">Select State</option>
                  <?php $form_data['country_id']='99';//echo "<pre>";print_r($form_data['country_id']);die;
                  if (!empty($form_data['country_id'])) {
                      // Fetch the state list based on the selected country
                      $state_list = state_list($form_data['country_id']);
                      
                      if (!empty($state_list)) {
                          foreach ($state_list as $state) { 
                              // Removed the debug line with die and fixed the state variable
                              ?>
                              <?php //echo "<pre>";print_r($form_data['state_id']);die;?>
                              <option value="<?php echo $state->id; ?>" 
                                  <?php if (!empty($form_data['state_id']) && $form_data['state_id'] == $state->id) { 
                                      echo 'selected="selected"'; 
                                  } ?>
                              >
                                  <?php echo $state->state; ?>
                              </option>
                          <?php 
                          }
                      }
                  }
                  ?>
              </select>

          </div>
          </div>
          <?php if (in_array('411', $users_data['permission']['section'])) { ?>
            <div class="row m-b-5">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-5"><b>Category Type</b></div>
                        <div class="col-md-7">
                        <select name="patient_category" id="patient_category" class="m_select_btn" onChange="handlePaymentMode();">
                            <option value="">Select Category</option>
                            <?php //echo "<pre>";print_r($form_data['patient_category']);die;
                            if (!empty($patient_category)) {
                                foreach ($patient_category as $patientcategory) {
                            ?>
                                <option value="<?php echo $patientcategory->id; ?>"
                                    <?php if (!empty($form_data['patient_category']) && $form_data['patient_category'] == $patientcategory->id) {
                                        echo 'selected="selected"';
                                    } ?>
                                    data-category-name="<?php echo $patientcategory->patient_category; ?>">
                                    <?php echo $patientcategory->patient_category; ?>
                                </option>
                            <?php
                                }
                            }
                            ?>
                        </select>

                            <?php if (in_array('2486', $users_data['permission']['action'])) {
                            ?>
                            <!-- <a title="Add Patient Category" class="btn-new" id="patient_category_add_modal"><i
                                class="fa fa-plus"></i> New</a> -->
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php } else { ?>

            <input type="hidden" name="patient_category" value="0" id="patient_category">
            <?php }
                ?>

            <!-- Corporate Section -->
            <div id="corporate_box" style="">
                <div class="row m-b-5">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5"><b>Corporate Name</b></div>
                            <div class="col-md-7">
                                <select name="corporate_id" id="corporate_id" class="m_select_btn">
                                    <option value=""
                                        <?php echo (empty($form_data['corporate_id']) || !isset($form_data['corporate_id'])) ? 'selected="selected"' : ''; ?>>
                                        Select Corporate Name</option>
                                    
                                    <?php if (!empty($corporate_list)): ?>
                                    <?php foreach ($corporate_list as $corporate): ?>
                                    <option value="<?php echo $corporate->corporate_id; ?>"
                                        <?php echo (isset($form_data['corporate_id']) && $corporate->corporate_id == $form_data['corporate_id']) ? 'selected="selected"' : ''; ?>>
                                        <?php echo $corporate->corporate_name; ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- </div> -->
<!-- row -->

                <div class="row m-b-5">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5"><b>Auth No.</b></div>
                            <div class="col-md-7">
                                <input type="text" name="auth_no" class="auth_no" id="auth_no"
                                    value="<?php echo isset($form_data['auth_no']) ? htmlspecialchars($form_data['auth_no'], ENT_QUOTES) : ''; ?>"
                                    placeholder="Enter Authorization Number" required pattern="^[A-Za-z0-9\-]+$"
                                    title="Only alphanumeric characters and hyphens are allowed" />
                            </div>
                        </div>
                    </div>
                </div> <!-- row -->

                <div class="row m-b-5">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5"><b>Employee No</b></div>
                            <div class="col-md-7">
                                <input type="text" name="employee_no" class="employee_no" id="employee_no"
                                    value="<?php echo isset($form_data['employee_no'])?$form_data['employee_no']:''; ?>" />
                            </div>
                        </div>
                    </div>
                </div> <!-- row -->

                <div class="row m-b-5">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5"><b>Auth Issue Date</b></div>
                            <div class="col-md-7">
                                <div class="input-group date">
                                    <input type="text" name="auth_issue_date" class="w-180px datepicker m_input_default" value="<?php echo  isset($form_data['auth_issue_date'])?$form_data['auth_issue_date']:''; ?>" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- row -->

                <div class="row m-b-5">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5"><b>Department</b></div>
                            <div class="col-md-7">
                                <select name="department_id" id="department_id" class="m_select_btn">
                                    <option value=""
                                        <?php echo empty($form_data['department_id']) ? 'selected="selected"' : ''; ?>>Select
                                        Department Name</option>
                                    <?php if (!empty($department_list)): ?>
                                    
                                    <?php foreach ($department_list as $department): ?>
                                        <?php //echo "<pre>";print_r($department);die; ?>
                                        <option value="<?php echo $department->department_id; ?>"
                                        <?php echo (isset($form_data['department_id']) && $department->department_id == $form_data['department_id']) ? 'selected' : ''; ?>>
                                        <?php echo $department->department_name; ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div> <!-- row -->

                <div class="row m-b-5">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5"><b>Cost</b></div>
                            <div class="col-md-7">
                                <input type="text" name="cost" class="alpha_numeric" id="cost"
                                    value="<?php echo isset($form_data['cost']) ? $form_data['cost'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                </div> <!-- row -->
            </div>

            <!-- Subsidy Section -->
            <div id="subsidy_box" style="">
                <div class="row m-b-5">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5"><b>Subsidy Authority Name</b></div>
                            <div class="col-md-7">
                                <select name="subsidy_id" id="subsidy_id" class="m_select_btn">
                                    <option value=""
                                        <?php echo empty($form_data['subsidy_id']) ? 'selected="selected"' : ''; ?>>Select
                                        Subsidy Authority</option>
                                    <?php if (!empty($subsidy_list)): ?>
                                    <?php foreach ($subsidy_list as $subsidy): ?>
                                    <option value="<?php echo $subsidy->subsidy_id; ?>"
                                    <?php echo (isset($form_data['subsidy_id']) && $subsidy->subsidy_id == $form_data['subsidy_id']) ? 'selected="selected"' : ''; ?> >
                                        <?php echo $subsidy->subsidy_name; ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div> <!-- row -->

                <div class="row m-b-5">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5"><b>Subsidy Created</b></div>
                            <div class="col-md-7">
                            <input type="text" name="subsidy_created" class="w-180px datepicker m_input_default" value="<?php echo  isset($form_data['subsidy_created'])?$form_data['subsidy_created']:''; ?>" >

                            </div>
                        </div>
                    </div>
                </div> <!-- row -->

                <div class="row m-b-5">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5"><b>Subsidy Amount</b></div>
                            <div class="col-md-7">
                                <input type="text" name="subsidy_amount" class="alpha_numeric" id="subsidy_amount"
                                    value="<?php echo isset($form_data['subsidy_amount'])?$form_data['subsidy_amount']:''; ?>" />
                            </div>
                        </div>
                    </div>
                </div> <!-- row -->
            </div>

            <!-- Panel Type -->
            <div id="panel_box" style="">
                <div class="row m-b-5">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5"><b>Type</b></div>
                            <div class="col-md-7">
                                <select name="insurance_type_id" id="insurance_type_id" class="w-200px m_select_btn">
                                    <option value="">Select Insurance Type</option>
                                    <?php if (!empty($insurance_type_list)): ?>
                                    <?php foreach ($insurance_type_list as $insurance_type): ?>
                                    <option value="<?php echo $insurance_type->id; ?>"
                                    <?php echo (isset($form_data['insurance_type_id']) && $insurance_type->id == $form_data['insurance_type_id']) ? 'selected="selected"' : ''; ?>>
                                        <?php echo $insurance_type->insurance_type; ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row m-b-5">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5"><b>Name</b></div>
                            <div class="col-md-7">
                                <select name="ins_company_id" id="ins_company_id" class="w-200px m_select_btn"
                                    onchange="update_doctor_panel_charges();">
                                    <option value="">Select Insurance Company</option>
                                    <?php if (!empty($insurance_company_list)): ?>
                                    <?php foreach ($insurance_company_list as $insurance_company): ?>
                                    <option value="<?php echo $insurance_company->id; ?>"
                                    <?php echo (isset($form_data['department_id']) && $department->department_id == $form_data['department_id']) ? 'selected' : ''; ?>>
                                        <?php echo $insurance_company->insurance_company; ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row m-b-5">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5"><b>Policy No.</b></div>
                            <div class="col-md-7">
                                <input type="text" name="polocy_no" class="alpha_numeric" id="polocy_no"
                                    value="<?php echo isset($form_data['polocy_no'])?$form_data['polocy_no']:''; ?>"
                                    maxlength="20" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row m-b-5">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5"><b>Validity From</b></div>
                            <div class="col-md-7">
                            <input type="text" name="validity_from" class="w-180px datepicker m_input_default" value="<?php echo isset($form_data['validity_from'])?$form_data['validity_from']:''; ?>" >

                                <!-- <input type="text" name="validity_from" class="validity_date m_input_default"
                                    value="<?php echo isset($form_data['validity_from'])?$form_data['validity_from']:''; ?>"
                                    id="validity_date" readonly="true" /> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row m-b-5">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5"><b>Validity To</b></div>
                            <div class="col-md-7">
                            <input type="text" name="validity_to" class="w-180px datepicker m_input_default" value="<?php echo isset($form_data['validity_to'])?$form_data['validity_to']:''; ?>" >

                                <!-- <input type="text" name="validity_to" class="validity_date m_input_default"
                                    value="<?php echo isset($form_data['validity_to'])?$form_data['validity_to']:''; ?>"
                                    id="validity_date" readonly="true" /> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row m-b-5">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5"><b>Amount</b></div>
                            <div class="col-md-7">
                                <input type="text" name="amount" class="alpha_numeric" id="amount"
                                    value="<?php echo isset($form_data['amount'])?$form_data['amount']:''; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>


    </div> <!-- 4 -->


    


    <div class="col-sm-4">
       <?php if(in_array('117',$permission_section)){ ?>  
      <div class="row m-b-2">
            <div class="col-sm-5"><label>Package</label><sup class="info"><a href="javascript:void(null)" class="small info"> ?<span>According to the central government health scheme (CGHS), package is defined as a lump sum cost of inpatient treatment for which a patient has been referred by a competent authority or CGHS to the hospital or diagnostic center..</span></a></sup></div>
            <div class="col-sm-7">
                <label><input type="radio" name="package" value="1" <?php if($form_data['package']=="1"){echo 'checked';} ?>  onclick="package_val(this.value);"> No</label> &nbsp;
                <label><input type="radio" name="package" value="2" <?php if($form_data['package']=="2"){echo 'checked';} ?> onclick="package_val(this.value);"> Yes</label>


            </div>
        </div>

        <div class="row m-b-5" id="package_id1">
            <div class="col-sm-5">
                <label>Package Name <span class="star">*</span></label>
            </div>
            <div class="col-sm-7">
                <select name="package_id" class="m_input_default" id="package_id" onchange="updateAmount();">
                    <option value="">-Select-</option>
                    <?php foreach ($package_list as $ipd_package) { ?>
                        <option value="<?php echo htmlspecialchars($ipd_package->id); ?>" 
                                data-amount="<?php echo htmlspecialchars($ipd_package->amount); ?>" 
                                <?php echo (isset($form_data['package_id']) && $form_data['package_id'] == $ipd_package->id) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($ipd_package->name); ?>
                        </option>
                    <?php } ?>
                </select>

                <?php if (!empty($form_error)) { echo form_error('package_id'); } ?>
            </div>
        </div>
        <?php } else{  ?>
        <input type="hidden" name="package_id" value="0">
         <input type="hidden" name="package" value="0">
        <?php } ?>
        <div class="row m-b-5" id="amount_section1">
            <div class="col-sm-5">
                <label>Package Amount</label>
            </div>
            <div class="col-sm-7">
                <input type="text" name="amount" id="package_amount" class="m_input_default" 
                    value="<?php echo isset($form_data['amount']) ? htmlspecialchars($form_data['amount']) : ''; ?>" readonly>
            </div>
        </div>
        <div class="row m-b-5" id="room_id1">
            <div class="col-sm-5"><label>Room Type <span class="star">*</span></label></div>
            <div class="col-sm-7">
                <select name="room_id" class="m_input_default" value="room_id" onchange="room_no_select(this.value);" id="room_id">
                    <option value="">-Select-</option>
                    <?php foreach($room_type_list as $room_type){?>
                    <option value="<?php echo $room_type->id; ?>" <?php if($form_data['room_id']==$room_type->id){ echo 'selected';}?>><?php echo $room_type->room_category; ?></option>
                    <?php }?>
                </select>
                 <?php //if(!empty($form_error)){ echo form_error('room_id'); } ?>
            </div>
        </div>
        
        <div class="row m-b-5" id="room_no_id1">
            <div class="col-sm-5"><label>Room No. <span class="star">*</span></label></div>
            <div class="col-sm-7">
                <select name="room_no_id" class="m_input_default" id="room_no_id" onchange="select_no_bed(this.value);">
                    <option value="">-Select-</option>
                </select>
                 <?php //if(!empty($form_error)){ echo form_error('room_no_id'); } ?>
            </div>
        </div>
        
        <div class="row m-b-5" id="bed_no_id1">
            <div class="col-sm-5">
                <label>Bed No. <span class="star">*</span></label>
            </div>
            <div class="col-sm-7">
                <select name="bed_no_id" class="m_input_default" id="bed_no_id">
                    <option value="">-Select-</option>
                    <?php if (!empty($data['bed_no']) && is_array($data['bed_no'])): ?>
                      <?php foreach ($data['bed_no'] as $bed): ?>
                        <option value="<?php echo $bed->id; ?>"><?php echo htmlspecialchars($bed->bad_name); ?></option>
                        <?php endforeach; ?>
                        <?php else: ?>
                          <option value="Nonbe">No beds available</option>
                    <?php endif; ?>


                </select>
                <?php if (!empty($form_error) && isset($form_error['bed_no_id'])): ?>
                    <span class="error"><?php echo $form_error['bed_no_id']; ?></span>
                <?php endif; ?>
            </div>
        </div>


        <?php if(in_array('38',$users_data['permission']['section']) && in_array('174',$users_data['permission']['section'])) { ?>

        <div class="row m-b-5">
            <div class="col-md-12">
               <div class="row">
                 <div class="col-md-5"><b>Referred By</b></div>
                 <div class="col-md-7" id="referred_by">
                   <input type="radio" name="referred_by" value="0" <?php if($form_data['referred_by']==0){ echo 'checked="checked"'; } ?>> Doctor &nbsp;
                    <input type="radio" name="referred_by" value="1" <?php if($form_data['referred_by']==1){ echo 'checked="checked"'; } ?>> Hospital
                    <?php if(!empty($form_error)){ echo form_error('referred_by'); } ?>
                 </div>
               </div>
            </div>
          </div> <!-- row -->
        <?php //echo "<pre>";print_r($field_list); ?>
        <div class="row m-b-5" id="doctor_div" <?php if($form_data['referred_by']==0){  }else{ ?> style="display: none;" <?php  } ?> >
            <div class="col-sm-5"><label>Referred By Doctor <?php  if(!empty($field_list)){
                    if($field_list[2]['mandatory_field_id']==32 && $field_list[2]['mandatory_branch_id']==$users_data['parent_id']){ ?>         
                         <span class="star">*</span>
                    <?php 
                    }
               } 
          ?></label></div>
            <div class="col-sm-7">
                <select name="referral_doctor" class="m_input_default" id="refered_id">
                      <option value="">Select Doctor</option>
                      <?php
                      if(!empty($referal_doctor_list))
                      {
                        foreach($referal_doctor_list as $referal_doctor)
                        {
                          ?>
                            <option <?php if($form_data['referral_doctor']==$referal_doctor->id){ echo 'selected="selected"'; } ?> value="<?php echo $referal_doctor->id; ?>"><?php echo $referal_doctor->doctor_name; ?></option>
                            
                          <?php
                        }
                      }
                      ?>
                    </select> 

                <?php //if(!empty($form_error)){ echo form_error('referral_doctor'); } ?>

                <?php if(!empty($field_list)){
                         if($field_list[2]['mandatory_field_id']=='32' && $field_list[2]['mandatory_branch_id']==$users_data['parent_id']){
                              if(!empty($form_error)){ echo form_error('referral_doctor'); }
                         }
                    }
                ?>
            </div>
        </div>

        <div class="row m-b-5" id="hospital_div" <?php if($form_data['referred_by']==1){  }else{ ?> style="display: none;" <?php  } ?>>
    
         <div class="col-md-5"><b>Referred By Hospital <?php if(!empty($field_list)){
                    if($field_list[2]['mandatory_field_id']==32 && $field_list[2]['mandatory_branch_id']==$users_data['parent_id']){?>         
                         <span class="star">*</span>
                    <?php 
                    }
               } 
          ?></b></div>
         <div class="col-sm-7">
           <select name="referral_hospital" class="m_input_default" id="referral_hospital" >
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
            <?php //if(!empty($form_error)){ echo form_error('referral_hospital'); } ?>
            <?php if(!empty($field_list)){
                         if($field_list[2]['mandatory_field_id']=='32' && $field_list[2]['mandatory_branch_id']==$users_data['parent_id']){
                              if(!empty($form_error)){ echo form_error('referral_hospital'); }
                         }
                    }
                ?>
         </div>
      
  </div> <!-- row -->
<?php } else if(in_array('38',$users_data['permission']['section']) && !in_array('174',$users_data['permission']['section'])){ 

    ?>
    <div class="row m-b-5">
            <div class="col-sm-5"><label>Referred By Doctor <?php if(!empty($field_list)){
                    if($field_list[2]['mandatory_field_id']==32 && $field_list[2]['mandatory_branch_id']==$users_data['parent_id']){?>         
                         <span class="star">*</span>
                    <?php 
                    }
               } 
          ?></label></div>
            <div class="col-sm-7">
                <select name="referral_doctor" class="m_input_default" id="refered_id">
                      <option value="">Select Doctor</option>
                      <?php
                      if(!empty($referal_doctor_list))
                      {
                        foreach($referal_doctor_list as $referal_doctor)
                        {
                          ?>
                            <option <?php if($form_data['referral_doctor']==$referal_doctor->id){ echo 'selected="selected"'; } ?> value="<?php echo $referal_doctor->id; ?>"><?php echo $referal_doctor->doctor_name; ?></option>
                            
                          <?php
                        }
                      }
                      ?>
                    </select> 

                <?php //if(!empty($form_error)){ echo form_error('referral_doctor'); } ?>

                <?php if(!empty($field_list)){
                         if($field_list[2]['mandatory_field_id']=='32' && $field_list[2]['mandatory_branch_id']==$users_data['parent_id']){
                              if(!empty($form_error)){ echo form_error('referral_doctor'); }
                         }
                    }
                ?>
            </div>
        </div>
        <input type="hidden" name="referred_by" value="0">
  <input type="hidden" name="referral_hospital" value="0">
    <?php
    }else if(!in_array('38',$users_data['permission']['section']) && in_array('174',$users_data['permission']['section'])){

        ?>
        <div class="row m-b-5">
    
         <div class="col-md-5"><b>Referred by Hospital <?php if(!empty($field_list)){
                    if($field_list[2]['mandatory_field_id']==32 && $field_list[2]['mandatory_branch_id']==$users_data['parent_id']){?>         
                         <span class="star">*</span>
                    <?php 
                    }
               } 
          ?></b></div>
         <div class="col-sm-7">
           <select name="referral_hospital" class="m_input_default" id="referral_hospital" >
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
            <?php //if(!empty($form_error)){ echo form_error('referral_hospital'); } ?>
            <?php if(!empty($field_list)){
                         if($field_list[2]['mandatory_field_id']=='32' && $field_list[2]['mandatory_branch_id']==$users_data['parent_id']){
                              if(!empty($form_error)){ echo form_error('referral_hospital'); }
                         }
                    }
                ?>
         </div>
      
  </div> <!-- row -->
<input type="hidden" name="referred_by" value="1">
  <input type="hidden" name="referral_doctor" value="0">
        <?php 

    }

    ?>
        <div class="row m-b-5">
            <div class="col-sm-5"><label>Attended Doctor <span class="star">*</span></label></div>
            <div class="col-sm-7">
                <select name="attended_doctor" class="m_input_default">
                    <option value="">-Select-</option>
                    <?php foreach($attended_doctor as $attened_docotr_list){ ?>
                    <option value="<?php echo $attened_docotr_list->id;?>" <?php if($form_data['attended_doctor']==$attened_docotr_list->id){echo 'selected';}?>><?php echo ucfirst($attened_docotr_list->doctor_name); ?></option>
                    <?php }?>
                </select>

                <?php if(!empty($form_error)){ echo form_error('attended_doctor'); } ?>
            </div>
        </div>
        
        <div class="row m-b-5">
            <div class="col-sm-5"><label>Assigned Doctor <span class="star">*</span></label></div>
            <div class="col-sm-7">
                <div class="ipd_right_scroll_box m_input_default">
                <?php $assigned_doctor_list=array();
                if(isset($assigned_d_by_id) && !empty($assigned_d_by_id)){


                     foreach($assigned_d_by_id as $assigned_list){
                        $assigned_doctor_list[]=$assigned_list->doctor_id;

                     }
                  }
                    // print_r($assigned_doctor);
                foreach($assigned_doctor as $assigned_doctor) {
                      if(in_array($assigned_doctor->id, $assigned_doctor_list)){
                         $var="checked='checked'";
                      }else{
                        $var='';
                      }

                    ?>
                    <div class="list">
                        <input type="checkbox" name="assigned_doctor_list[]" <?php echo $var;?> value="<?php echo $assigned_doctor->id;?>">  <span><?php echo ucfirst($assigned_doctor->doctor_name);?></span>
                    </div>

                    <?php } ?>
                
                </div>
                <?php if(!empty($form_error)){ echo form_error('assigned_doctor_list[]'); } ?>
            </div>
        </div>
        <!-- Addded remarks and diagnosis from left side -->
        
        <div class="row m-b-5">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-5"><b>Token:</b></div>
                    <div class="col-md-7">
                        <input type="text" name="token" id="token" value="<?php echo isset($token) ? htmlspecialchars($token) : '1'; ?>" readonly class="m_input_default">
                    </div>
                </div>
            </div>
        </div>

        <div class="row m-b-5">
            <div class="col-sm-5"><label>Diagnosis</label></div>
            <div class="col-sm-7" >
                <select name="diagnosis[]" class="diagnosis_list form-control" id="" multiple style="width: 200px;">
                    <?php if(isset($form_data['diagnosis'])): ?>
                        <?php foreach($form_data['diagnosis'] as $diagnosis): ?>
                            <option value="<?php echo $diagnosis; ?>" selected><?php echo $diagnosis; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <div class="row m-b-2">
              <div class="col-sm-5">
                  <label>Eye Details</label>
              </div>
              <div class="col-sm-7">
                  <label>
                      <input type="radio" name="eye_details" value="lefteye" 
                          <?php if(isset($form_data['eye_details']) && $form_data['eye_details'] == "lefteye"){echo 'checked';} ?> 
                      > Left
                  </label> &nbsp;
                  <label>
                      <input type="radio" name="eye_details" value="righteye" 
                          <?php if(isset($form_data['eye_details']) && $form_data['eye_details'] == "righteye"){echo 'checked';} ?> 
                      > Right
                  </label> &nbsp;
                  <label>
                      <input type="radio" name="eye_details" value="botheye" 
                          <?php if(isset($form_data['eye_details']) && $form_data['eye_details'] == "botheye"){echo 'checked';} ?> 
                      > Both
                  </label>
              </div>
          </div>

          <div class="row m-b-2">
              <div class="col-sm-4 text-center"></div>
              <div class="col-sm-3 text-right">
                  <label><strong>Vision</strong></label>
              </div>
              <div class="col-sm-3 text-center">
                  <label><strong>Cataract Type</strong></label>
              </div>
          </div>

          <div class="row m-b-3">
              <div class="col-xs-5">
                  <label for="vision_right">Right</label>
              </div>
              <div class="col-xs-5" style="display:flex;">
                  <input type="text" id="vision_right" name="vision_right" class="" style="width:50%;" value="<?php echo isset($form_data['vision_right']) ? $form_data['vision_right'] : ''; ?>" placeholder="">
                  <input type="text" id="cataract_type_right" name="cataract_type_right" class="" style="width:50%;" value="<?php echo isset($form_data['cataract_type_right']) ? $form_data['cataract_type_right'] : ''; ?>" placeholder="">
              </div>
              <!-- <div class="col-xs-3">
              </div> -->
          </div>

          <div class="row m-b-3">
              <div class="col-xs-5">
                  <label for="vision_left">Left</label>
              </div>
              <div class="col-xs-5" style="display:flex;">
                  <input type="text" id="vision_left" name="vision_left" class="form-control" style="width:50%;" value="<?php echo isset($form_data['vision_left']) ? $form_data['vision_left'] : ''; ?>" placeholder="">
                  <input type="text" id="cataract_type_left" name="cataract_type_left" class="form-control" style="width:50%;" value="<?php echo isset($form_data['cataract_type_left']) ? $form_data['cataract_type_left'] : ''; ?>" placeholder="">
              </div>
              <!-- <div class="col-xs-3">
              </div> -->
          </div>


        <!-- hidden fields of advanced deposit -->
         
            <!-- <?php $data= get_setting_value('REG_CHARGE_IPD_BOOK'); 
            
                
                if(!empty($form_data['data_id']))
                {
                      
                
                    ?>
                      <div class="row m-b-5">
                          <div class="col-sm-5"><label>Registration Charge</label></div>
                          <div class="col-sm-7">
                              <input type="text" name="reg_charge" class="m_input_default" value="<?php echo $form_data['reg_charge'];?>" readonly>
                          </div>
                      </div>
                    <?php 
                }
                else if(!empty($data) && isset($data))
                {
                  ?>
                      <div class="row m-b-5">
                          <div class="col-sm-5"><label>Registration Charge</label></div>
                          <div class="col-sm-7">
                              <input type="text" name="reg_charge" class="m_input_default" value="<?php echo $data;?>" readonly>
                          </div>
                      </div>
                  
                  <?php 
                
              
              }else{?>

           <div class="row m-b-5">
                    <div class="col-sm-5"><label>Registration Charge</label></div>
                    <div class="col-sm-7">
                        <input type="text" name="reg_charge" class="m_input_default" value="0.00" readonly>
                    </div>
                </div>
           <?php  }?> -->
        
        <div class="row m-b-5">
            <div class="col-sm-5"><label></label></div>
            <div class="col-sm-7">
                
            </div>
        </div>
        
    </div> <!-- 4 -->

    <div class="col-sm-4">

    <!-- <div class="row m-b-2">
            <div class="col-sm-5"><label>Patient Type</label>
              <sup class="info"><a href="javascript:void(null)" class="small info"> ?<span>A doctor within a given area available for consultation by patients insured under the National Health Insurance Scheme It has two type <br> Normal: Having no policy. <br>Panel:Having policy.</span></a></sup>
            </div>
            <div class="col-sm-7">
                <label><input type="radio" name="patient_type" value="1" <?php if($form_data['patient_type']==1){ echo 'checked';}?>  onclick="patient_change(this.value);"> Normal</label> &nbsp;
                <label><input type="radio" name="patient_type" value="2" <?php if($form_data['patient_type']==2){ echo 'checked';}?> onclick="patient_change(this.value);"> Panel</label>
            </div>
        </div> -->
    <!-- <div id="panel_box" style="display:none;"> -->

    <!--<div class="row m-b-5">
            <div class="col-sm-5"><label>Type</label></div>
            <div class="col-sm-7">
                <select id="panel_type" class="m_input_default" name="panel_type">
                    <option value="">-Select-</option>
                    <?php foreach($panel_type_list as $type_list){ ?>
                    <option value="<?php echo $type_list->id; ?>" <?php if($form_data['panel_type']==$type_list->id){echo 'selected';}?>><?php echo $type_list->insurance_type; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        
        <div class="row m-b-5">
            <div class="col-sm-5"><label>Name</label></div>
            <div class="col-sm-7">
                <select id="company_name" class="m_input_default" name="company_name">
                    <option value="">-Select-</option>
                     <?php foreach($panel_company_list as $company_name){ ?>
                    <option value="<?php echo $company_name->id; ?>" <?php if($form_data['company_name']==$company_name->id){echo 'selected';}?>><?php echo $company_name->insurance_company; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        
        <div class="row m-b-5">
            <div class="col-sm-5"><label>Policy No.</label></div>
            <div class="col-sm-7">
                <input type="text" class="m_input_default" name="policy_number" id="policy_no" value="<?php echo $form_data['policy_number']; ?>">
            </div>
        </div>
        
        <div class="row m-b-5">
            <div class="col-sm-5"><label>ID No.</label></div>
            <div class="col-sm-7">
                <input type="text" name="id_number" class="m_input_default" id="id_number" value="<?php echo $form_data['id_number']; ?>">
            </div>
        </div>
        
        <div class="row m-b-5">
            <div class="col-sm-5"><label>Authorization Amt.</label></div>
            <div class="col-sm-7">
                <input type="text" class="m_input_default" name="authorization_amount" id="authorization_amount" value="<?php echo $form_data['authorization_amount']; ?>">
            </div>
        </div>
     </div>   --> 
        <div class="row m-b-5">
            <div class="col-sm-5 p-r-0"><b>Admission Date & Time (dd-mm-yyyy)<span class="star">*</span></b></div>
            <div class="col-sm-7">
                <input type="text" name="admission_date" class="w-130px datepicker m_input_default" placeholder="Date" value="<?php echo  $form_data['admission_date']; ?>" >
                <input type="text" name="admission_time" class="w-65px datepicker3 m_input_default" placeholder="Time" value="<?php echo $form_data['admission_time']; ?>">
              
            </div>
        </div>

    

    <!-- Hidden authorize person and mode of payment -->
    <!-- <div class="row m-b-5">
            <div class="col-sm-5"><b>Authorize Person</b></div>
            <div class="col-sm-7">
              <select name="authorize_person" id="authorize_person" class="w-200px m_select_btn">
                  <option value="">Select Authorize Person</option>
                  <?php
                  if(!empty($authrize_person_list))
                  {
                    foreach($authrize_person_list as $authrizelist)
                    {
                      ?>
                        <option <?php if($form_data['authorize_person']==$authrizelist->id){ echo 'selected="selected"'; } ?> value="<?php echo $authrizelist->id; ?>"><?php echo $authrizelist->authorize_person; ?></option>
                        
                      <?php
                    }
                  }
                  ?>
            </select> 
            <?php if(in_array('2493',$users_data['permission']['action'])) {
            ?><a title="Add authorize person" class="btn-new" id="authorize_person_add_modal"><i class="fa fa-plus"></i> New</a>
            <?php } ?>
            </div>
          </div> -->

          <?php if(in_array('774', $permission_action)) { ?> 
                <div class="row m-b-5">
                    <div class="col-sm-5"><label>Advance Deposit</label></div>
                    <div class="col-sm-7">
                        <input type="text" <?php if(!empty($form_data['advance_deposite'])) { echo "readonly"; } ?> 
                            name="advance_deposite" id="advance_deposit" class="price_float m_input_default" 
                            value="<?php echo $form_data['advance_deposite']; ?>">
                    </div>
                    <?php if(!empty($form_error)) { echo form_error('advance_deposite'); } ?>
                </div>
            <?php } else { ?>  
                <input type="hidden" name="advance_deposite" class="m_input_default" value="0.00">
            <?php } ?>

            <div class="col-md-12">
              <div class="row m-b-5 opd_m_left">
                <div class="col-md-5"><b>Mode of Payment</b></div>
                <div class="col-md-7 opd_p_left">
                  <select name="payment_mode" id="payment_mode" class="m_input_default"
                    onChange="payment_function(this.value, '');">
                    <?php
                    foreach ($payment_mode as $mode) {
                      // Check if the current form's payment_mode matches OR if patient_category_name is Corporate, Subsidy, or Panel
                      $is_selected = $form_data['payment_mode'] == $mode->id
                        || in_array($form_data['patient_category_name'], ['Corporate', 'Subsidy', 'Panel']) && strtolower($mode->payment_mode) == 'billed';
                      ?>
                      <option value="<?php echo $mode->id; ?>" <?php if ($is_selected)
                           echo 'selected'; ?>>
                        <?php echo $mode->payment_mode; ?>
                      </option>
                    <?php } ?>
                  </select>

                </div>
              </div>
            </div>

            <div id="updated_payment_detail">
              <?php if (!empty($form_data['field_name'])) {
                foreach ($form_data['field_name'] as $field_names) {
                  $tot_values = explode('_', $field_names);

                  ?>

                  <div class="row m-b-5">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-5"><b><?php echo $tot_values[1]; ?><span class="star">*</span></b></div>
                        <div class="col-md-7">
                          <input type="text" name="field_name[]" value="<?php echo $tot_values[0]; ?>" /><input
                            type="hidden" value="<?php echo $tot_values[2]; ?>" name="field_id[]" />
                          <?php
                          if (empty($tot_values[0])) {
                            if (!empty($form_error)) {
                              echo '<div class="text-danger">The ' . strtolower($tot_values[1]) . ' field is required.</div>';
                            }
                          }
                          ?>
                        </div>

                      </div>
                    </div>
                  </div>


                <?php }
              } ?>

            </div>

            <div id="payment_detail">


            </div>

            <div class="row m-b-5" id="op_name">
                <div class="col-sm-5"><b>Operation Name</b></div>
                <div class="col-sm-7 ">
                    <select name="operation_name" id="operation_name" class="m_input_default" >
                        <option value="">Select Operation</option>
                        <?php foreach ($operation_list as $op_list) { ?>
                            <option value="<?php echo $op_list->id; ?>" 
                                <?php if (isset($form_data['operation_name']) && $form_data['operation_name'] == $op_list->id) { echo 'selected'; } ?>>
                                <?php echo htmlspecialchars($op_list->name); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>



          <div class="row m-b-5" id="doctor_div" >
              
              <div class="col-sm-5">
                  <label>Surgeon Name
                      
                  </label>
              </div>

              <div class="col-sm-7">
                  <select name="referral_doctor" class="m_input_default" id="refered_id">
                      <option value="">Select Doctor</option>
                      <?php if (!empty($referal_doctor_list)) {
                          foreach ($referal_doctor_list as $referal_doctor) { ?>
                              <option value="<?php echo $referal_doctor->id; ?>" 
                                  <?php echo ($form_data['referral_doctor'] == $referal_doctor->id) ? 'selected="selected"' : ''; ?>>
                                  <?php echo $referal_doctor->doctor_name; ?>
                              </option>
                          <?php } 
                      } ?>
                  </select>

                  <?php if (!empty($field_list)) {
                      if ($field_list[2]['mandatory_field_id'] == '32' && $field_list[2]['mandatory_branch_id'] == $users_data['parent_id']) {
                          if (!empty($form_error)) {
                              echo form_error('referral_doctor');
                          }
                      }
                  } ?>
              </div>
          </div>


          <div class="row m-b-5">
              <div class="col-sm-5"><b>Anaesthesia </b></div>
              <div class="col-sm-7">
                  <select name="anaesthesia" class="m_input_default" onChange="anaesthesia_function(this.value);">
                      <option value="">Select Anaesthesia Type</option>
                      <option value="Topical" <?php if(isset($form_data['anaesthesia']) && $form_data['anaesthesia'] == 'Topical'){ echo 'selected'; } ?>>Topical</option>
                      <option value="Regional Block" <?php if(isset($form_data['anaesthesia']) && $form_data['anaesthesia'] == 'Regional Block'){ echo 'selected'; } ?>>Regional Block</option>
                      <option value="Parental Sedation" <?php if(isset($form_data['anaesthesia']) && $form_data['anaesthesia'] == 'Parental Sedation'){ echo 'selected'; } ?>>Parental Sedation</option>
                      <option value="GA" <?php if(isset($form_data['anaesthesia']) && $form_data['anaesthesia'] == 'GA'){ echo 'selected'; } ?>>General Anaesthesia (GA)</option>
                  </select>
              </div>
          </div>

          <div class="row m-b-5">
              <div class="col-sm-5">
                  <b>Type of Surgery/Group </b>
              </div>
              <div class="col-sm-7">
                  <select name="surgery_type" class="m_input_default" onChange="surgery_type_function(this.value);">
                      <option value="">Select Type of Surgery</option>
                      <option value="Super Major" <?php if (isset($form_data['surgery_type']) && $form_data['surgery_type'] == 'Super Major') { echo 'selected'; } ?>>Super Major</option>
                      <option value="Major" <?php if (isset($form_data['surgery_type']) && $form_data['surgery_type'] == 'Major') { echo 'selected'; } ?>>Major</option>
                      <option value="Minor" <?php if (isset($form_data['surgery_type']) && $form_data['surgery_type'] == 'Minor') { echo 'selected'; } ?>>Minor</option>
                  </select>
              </div>
          </div>

          <div class="row m-b-5">
            <div class="col-sm-5"><b>IOL Power</b></div>
            <div class="col-sm-7">
              <select name="iol_power" id="iol_power" class="m_input_default" onchange="filterIOLData(this.value);">
                <option value="">Select</option>
                <?php if (isset($iol_data) && $iol_data != "empty") {
                  foreach ($iol_data as $iol) { ?>
                    <option value="<?php echo htmlspecialchars($iol->iol_section); ?>" <?php if ($form_data['iol_power'] == $iol->iol_section) { echo 'selected'; } ?>>
                      <?php echo htmlspecialchars($iol->iol_section); ?>
                    </option>
                <?php } } ?>
              </select>
            </div>
          </div>

          <div class="row m-b-5" id="iol_data_row" style="display: none;">
            <div class="col-sm-5"><b>IOL Type</b></div>
            <div class="col-sm-7">
                <!-- <div class="grid-box" style="width: 200px; height: auto; border: 1px solid #aaa; padding: 5px;"> -->
                    <!-- <div class="grid-body" style="width: 150px;"> -->
                        <?php if (isset($iol_data) && $iol_data != "empty") { ?>
                            <?php foreach ($iol_data as $iol) { ?>
                                <!-- <div class="form-group"> -->
                                    <!-- <label><?php echo htmlspecialchars($iol->iol_section); ?></label> -->
                                    <input type="text" style="width: 200px;" name="iol_data[<?php echo $iol->id; ?>]" class="form-control" placeholder="Enter data for <?php echo htmlspecialchars($iol->iol_section); ?>">
                                <!-- </div> -->
                            <?php } ?>
                        <?php } else { ?>
                            <p>No  available.</p>
                        <?php } ?>
                    <!-- </div> -->
                <!-- </div> -->
            </div>
        </div>

          <div class="row m-b-5">
              <div class="col-sm-5"><b>Brand</b></div>
              <div class="col-sm-7">
                  <select name="brand" id="brand">
                    <option value="">Select</option>
                        <?php //echo "<pre>";print_r($form_data['brand']);die;
                        // Ensure $brand_list is not empty and is an array
                        if (!empty($brand_list) && is_array($brand_list)) {
                            foreach ($brand_list as $brand) {
                                // Safely retrieve brand properties
                                $brandId = isset($brand->id) ? $brand->id : null;
                                $companyName = isset($brand->brand_name) ? $brand->brand_name : 'Unknown Company';
                                
                                // Pre-select the brand if it matches the form data
                                $selected = (isset($form_data['brand']) && $form_data['brand'] == $brandId) ? 'selected="selected"' : '';
                                
                                // Render the option element
                                echo "<option value='{$brandId}' {$selected}>{$companyName}</option>";
                            }
                        } else {
                            echo '<option value="">No brands available</option>';
                        }
                        ?>

                    </select>

              </div>
          </div>


          <div class="row m-b-5" id="corporate_full_facility1">
            <div class="col-sm-5"><b>Corporate Full Facility</b></div>
            <div class="col-sm-7">
              <select name="corporate_full_facility" id="corporate_full_facility" onchange="handleCorporateFacilityChange();">
                <option value="">Select</option>
                <option value="yes" <?php if (isset($form_data['corporate_full_facility']) && $form_data['corporate_full_facility'] == 'yes') { echo 'selected'; } ?>>Yes</option>
                <option value="no" <?php if (isset($form_data['corporate_full_facility']) && $form_data['corporate_full_facility'] == 'no') { echo 'selected'; } ?>>No</option>
              </select>
            </div>
          </div>

          <?php if(isset($form_data['corporate_full_facility']) && $form_data['corporate_full_facility'] == 'no'){ ?>
            <div id="additional-fields" style="display: block;">
          <?php }else{?>
            <div id="additional-fields" style="display: none;">
          <?php } ?>
            <div class="row m-b-5">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-5"><b>Total Amount</b></div>
                        <div class="col-md-7">
                            <input type="text" readonly name="total_amount" id="total_amount" class="price_float m_input_default" 
                                  value="<?php echo isset($form_data['total_amount']) ? number_format(floatval($form_data['total_amount']), 2, '.', '') : htmlspecialchars($ipd_package->amount); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row m-b-5">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-5"><b>Corporate Amount</b></div>
                        <div class="col-md-7">
                            <input type="text" id="corporate_amount" class="price_float m_input_default"
                                value="<?php echo isset($form_data['cost']) ? number_format(floatval($form_data['cost']), 2, '.', '') : '0.00'; ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row m-b-5">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-5"><b>Difference Amount</b></div>
                        <div class="col-md-7">
                            <input type="text" id="difference_amount" class="price_float m_input_default"
                                value="0.00" readonly />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row m-b-5">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-5"><b>Previous Advance</b></div>
                        <div class="col-md-7">
                            <input type="text" id="previous_advance" class="price_float m_input_default"
                                value="<?php echo isset($form_data['advance_deposite']) ? number_format(floatval($form_data['advance_deposite']), 2, '.', '') : '0.00'; ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>

            

            <div class="row m-b-5">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-5"><b>Balance</b></div>
                        <div class="col-md-7">
                            <input type="text" name="balance" id="balance" class="price_float m_input_default"
                                value="0.00" readonly />
                        </div>
                    </div>
                </div>
            </div>
          </div>

            <div class="row m-b-5 hidden" >
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-5"><b>Operator</b></div>
                        <div class="col-md-7">
                          <?php //echo "<pre>" ; print_r($this->session->userdata());die;
                             $operator_name  = $this->session->userdata("auth_users"); ?>
                            <input type="text" name="operator" id="operator"  value="<?php echo isset($operator_name['username']) ? htmlspecialchars($operator_name['username']) : 'hehe'; ?>" readonly class="m_input_default">
                        </div>
                    </div>
                </div>
            </div>

            <script>

            $(document).ready(function() {
                // Function to calculate the difference and balance
                function calculateAmounts() {
                    var totalAmount = parseFloat($('#package_amount').val()) || 0.00;
                    var corporateAmount = parseFloat($('#corporate_amount').val()) || 0.00;
                    var previousAmount = parseFloat($('#previous_advance').val()) || 0.00;

                    // Calculate the difference: Total - Corporate
                    var difference = totalAmount - corporateAmount;

                    // If the difference is less than 0, set it to 0
                    if (difference < 0) {
                        difference = 0;
                    }
                    $('#difference_amount').val(difference.toFixed(2));

                    // Calculate the balance: Previous Amount - Difference
                    var balance = previousAmount - difference;
                    $('#balance').val(balance.toFixed(2));
                }

                // Initial calculation on page load
                calculateAmounts();

                // Listen for manual input changes in the "Total Amount", "Corporate Amount", and "Cost" fields
                $('#package_amount, #corporate_amount, #cost').on('input', function() {
                    // If the "Cost" field is changed, update the "Corporate Amount" field
                    if ($(this).attr('id') === 'cost') {
                        var newCost = parseFloat($(this).val()) || 0.00;
                        $('#corporate_amount').val(newCost.toFixed(2));
                    }

                    // Recalculate the difference and balance whenever total or corporate amount changes
                    calculateAmounts();
                });

                // Listen for input changes in the "Advance Deposit" field
                $('#advance_deposit').on('input', function() {
                    var newAdvance = parseFloat($(this).val()) || 0.00;

                    // Update the "Previous Advance" field with the new advance amount
                    $('#previous_advance').val(newAdvance.toFixed(2));

                    // Recalculate the balance after updating the advance deposit
                    calculateAmounts();
                });
            });

            function payment_function(value, error_field) {
                $('#updated_payment_detail').html('');
                $.ajax({
                type: "POST",
                url: "<?php echo base_url('ipd_booking/get_payment_mode_data') ?>",
                data: { 'payment_mode_id': value, 'error_field': error_field },
                success: function (msg) {
                    $('#payment_detail').html(msg);
                }
                });



            }

            function handleCorporateFacilityChange() {
                var facilitySelect = document.getElementById('corporate_full_facility');
                var additionalFields = document.getElementById('additional-fields');
                
                if (facilitySelect.value === 'no') {
                    additionalFields.style.display = 'block'; // Show the fields
                } else {
                    additionalFields.style.display = 'none';  // Hide the fields
                }
            }
            function filterIOLData(selectedValue) {
                const rows = document.querySelectorAll('.iol-row');  // Select all rows with class 'iol-row'
                const iolDataRow = document.getElementById('iol_data_row');  // Select the container for IOL data

                if (selectedValue === "") {
                    // Hide the IOL Data section if no option is selected
                    iolDataRow.style.display = 'none';
                    return;
                } else {
                    iolDataRow.style.display = 'block'; // Show the IOL Data section
                }

                // Show/Hide rows based on the selection value
                rows.forEach(row => {
                    const section = row.getAttribute('data-iol-section');  // Get the data attribute from each row
                    if (section === selectedValue) {
                        row.style.display = ''; // Show the row if it matches the selected value
                    } else {
                        row.style.display = 'none'; // Hide the row if it doesn't match
                    }
                });
            }

            function validateAadhaar(input) {
                var aadhaarPattern = /^[0-9]{12}$/;
                var aadhaarError = document.getElementById("aadhaar_error");

                // Allow only numbers
                input.value = input.value.replace(/[^0-9]/g, '');

                if (aadhaarPattern.test(input.value)) {
                    aadhaarError.textContent = ""; // Clear error message
                } else {
                    aadhaarError.textContent = "Invalid Aadhaar number! Must be 12 digits.";
                }
            }


            function updateAmount() {
                var packageSelect = document.getElementById("package_id");
                var selectedOption = packageSelect.options[packageSelect.selectedIndex];
                var amountInput = document.getElementById("package_amount");
                var tInput = document.getElementById("total_amount");
                

                // Get the amount from the selected option's data attribute
                var amount = selectedOption.getAttribute("data-amount");
                
                // Update the amount input field with the selected package's amount
                amountInput.value = amount ? amount : ''; // Set it to the amount or clear it if no selection
                tInput.value = amount ? amount : ''; // Set it to the amount or clear it if no selection
            }

        // Initial call to set the amount field when the page loads
        document.addEventListener("DOMContentLoaded", function() {
            updateAmount(); // Set the initial value based on the selected package
        });


            <?php
                if(isset($_GET['lid']) && !empty($_GET['lid']) && $_GET['lid']>0 && !empty($lead_ot_id))
            {
                ?>
                $(document).ready(function(){
                get_operation_prices('<?php echo $lead_ot_id; ?>');
                });
                <?php
            }
                ?>
                function get_operation_prices(val)
                {
                // alert('PLPL');
                $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "<?php echo base_url('ot_booking/get_amount_details_operation_management');?>",
                            data: {op_mgmt_id:val  },
                            success: function(result) 
                            {
                            
                                $("#total_amount").val(result.amount);
                                // calculateAmounts();
                                var totalAmount = parseFloat($('#package_amount').val()) || 0.00;
                                var corporateAmount = parseFloat($('#corporate_amount').val()) || 0.00;
                                var previousAmount = parseFloat($('#previous_advance').val()) || 0.00;

                                // Calculate the difference: Total - Corporate
                                var difference = totalAmount - corporateAmount;

                                // If the difference is less than 0, set it to 0
                                if (difference < 0) {
                                    difference = 0;
                                }

                                $('#difference_amount').val(difference.toFixed(2));

                                // Calculate the balance: Previous Amount - Difference
                                var balance = previousAmount - difference;
                                $('#balance').val(balance.toFixed(2));
                            }

                        });
                }


            function validateEmail(input) {
                const emailError = document.getElementById('email_error');
                const emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/; // Regex for @gmail.com

                if (!emailPattern.test(input.value)) {
                    emailError.textContent = "Please enter a valid email ending with @gmail.com";
                    input.setCustomValidity("Invalid email"); // Set custom validity message
                } else {
                    emailError.textContent = ""; // Clear error message
                    input.setCustomValidity(""); // Reset custom validity
                }
            }

            </script>

        <div class="row m-b-5">
            <div class="col-sm-5"><label>Remarks</label></div>
            <div class="col-sm-7">
                <textarea type="text" class="m_input_default" name="remarks"><?php echo $form_data['remarks'];?></textarea>
            </div>
        </div>

    <div id="updated_payment_detail">
        <?php if(!empty($form_data['field_name']))
                 { foreach ($form_data['field_name'] as $field_names) {
                     $tot_values= explode('_',$field_names);

                    ?>

        <div class="row m-b-5" id="branch">
            <div class="col-md-5">
                <strong><?php echo $tot_values[1];?><span class="star">*</span></strong>
            </div>
            <div class="col-md-7">
                <input type="text" class="m_input_default" name="field_name[]"
                    value="<?php echo $tot_values[0];?>" /><input type="hidden" class="m_input_default"
                    value="<?php echo $tot_values[2];?>" name="field_id[]" />
                <?php 
                      if(empty($tot_values[0]))
                      {
                      if(!empty($form_error)){ echo '<div class="text-danger">The '.strtolower($tot_values[1]).' field is required.</div>'; } 
                      }
                      ?>
            </div>
        </div>
        <?php } }?>

    </div>

    <div id="payment_detail">


    </div>

    <div class="row m-b-5">
        <div class="col-sm-5"><label></label></div>
        <div class="col-sm-7">

            <button class="btn-update" type="button" name="" id="ipd_booking_save" onclick="button_disabled();"><i
                    class="fa fa-floppy-o"></i> <?php echo $btn_name; ?></button>

            <a href="<?php echo base_url('ipd_booking'); ?>" class="btn-anchor"><i class="fa fa-sign-out"></i> Exit</a>
        </div>
    </div>

    



</div> <!-- 4 -->
</div> <!-- main row -->
</form>
</section> <!-- section close -->
<?php
$this->load->view('include/footer');
?>
 
</div><!-- container-fluid -->
</body>
</html>

<script>
<?php
 $flash_success = $this->session->flashdata('success');
 if(isset($flash_success) && !empty($flash_success))
 {
    echo 'flash_session_msg("'.$flash_success.'");';
   ?>
  <?php
}

?>

$('.datepicker').datepicker({
    format: 'dd-mm-yyyy', 
    autoclose: true 
  });

 $('.datepicker3').datetimepicker({
     format: 'LT'
  });
/*function check_status(check_status)
{
  if(check_status==1)
  {
    $('#mlc_status').show();
  }
  else
  {
    $('#mlc_status').val('');
    $('#mlc_status').hide();
  }
  
}*/

function check_status(check_status)
{
  if(check_status==1)
  {
    <?php $arr=check_hospital_mlc_no(); $mlc_no=$arr['prefix'].$arr['suffix'];?>
    $('#mlc_status').show();
    if($('#mlc_status').val()=='')
    $('#mlc_status').val('<?php echo $mlc_no;?>');//.attr('readonly', true);
  }
  else
  {
    $('#mlc_status').val('');
    $('#mlc_status').hide();
  }
  
}

function button_disabled()
{
    $('#ipd_booking_save').attr('disabled','disabled');
    $("#form_submit_data" ).submit();
}

$(document).ready(function(){
var $modal = $('#load_add_modal_popup');

$('#hospital_add_modal').on('click', function(){
$modal.load('<?php echo base_url().'hospital/add/' ?>',
{
  //'id1': '1',
  //'id2': '2'
  },
function(){
$modal.modal('show');
});

});

});
$(document).ready(function() {
    $("input[name$='referred_by']").click(function() 
    {
      var test = $(this).val();
      if(test==0)
      {
        $("#hospital_div").hide();
        $("#doctor_div").show();
        $('#referral_hospital').val('');
        
      }
      else if(test==1)
      {
          $("#doctor_div").hide();
          $("#ref_by_other").css("display","none"); 
          $("#hospital_div").show();
          $('#refered_id').val('');
          //$("#refered_id :selected").val('');
      }
        
    });
});

function form_submit()
{
  $('#search_form_list').delay(200).submit();
}

$("#search_form_list").on("submit", function(event) { 
  event.preventDefault(); 
  $('#overlay-loader').show();
   
  $.ajax({
    url: "<?php echo base_url('patient/advance_search/'); ?>",
    type: "post",
    data: $(this).serialize(),
    success: function(result) 
    {
      $('#load_add_modal_popup').modal('hide'); 
      reload_table();       
      $('#overlay-loader').hide();
    }
  });
});



$('.start_datepicker').datepicker({
    format: 'dd-mm-yyyy', 
    autoclose: true, 
    endDate : new Date(), 
  }).on("change", function(selectedDate) 
  { 
      var start_data = $('.start_datepicker').val();
      $('.end_datepicker').datepicker('setStartDate', start_data); 
      form_submit();
  });

  $('.end_datepicker').datepicker({
    format: 'dd-mm-yyyy',     
    autoclose: true,  
  }).on("change", function(selectedDate) 
  {   
     form_submit();
  });

function select_payment_mode(value_s){
     if(value_s==2){
          
            $('#card_no').css("display", "block");
            $('#bank_name').css("display", "block");
            $('#cheque_no').css("display", "none");
            $('#transaction_no').css("display", "none");
            $('#cheque_date').css("display", "none");
     }

     else if(value_s==3){

            $('#cheque_no').css("display", "block");
            $('#cheque_date').css("display", "block");
            $('#bank_name').css("display", "block"); 
            $('#transaction_no').css("display", "none"); 
            $('#card_no').css("display", "none"); 
     }
     else if(value_s==4){
            $('#transaction_no').css("display", "block");
            $('#bank_name').css("display", "block");  
            $('#cheque_no').css("display", "none");
            $('#card_no').css("display", "none"); 
            $('#cheque_date').css("display", "none");
     }
     else{
       
            $('#cheque_no').html('');
            $('#card_no').html('');
            $('#bank_name').html('');
            $('#transaction_no').html('');
            $('#cheque_date').html('');
     }


    
}


 function payment_function(value,error_field){
    $('#updated_payment_detail').html('');
     $.ajax({
        type: "POST",
        url: "<?php echo base_url('ipd_booking/get_payment_mode_data')?>",
        data: {'payment_mode_id' : value,'error_field':error_field},
       success: function(msg){
         $('#payment_detail').html(msg);
        }
    });
     
   
 
   
  }

 function package_val(value_p)
 {
    if(value_p==1)
    { 
        $('#package_id1').slideUp();
        $('#room_id1').slideUp();
        $('#room_no_id1').slideUp();
        $('#bed_no_id1').slideUp();
        $('#amount_section1').slideUp();
    }
    else
    {
        $('#package_id1').slideDown(); 
        $('#room_id1').slideDown(); 
        $('#room_no_id1').slideDown(); 
        $('#bed_no_id1').slideDown(); 
        $('#amount_section1').slideDown(); 
    }

}

 function patient_change(value_p)
 {
         if(value_p==1)
         {
             $('#panel_box').slideUp();
            $('#panel_type').attr("disabled", true); 
            $('#company_name').attr("disabled", true); 
            $('#policy_no').attr("disabled", true); 
            $('#id_number').attr("disabled", true); 
            $('#authorization_amount').attr("disabled", true); 
        }
        else
        {
            $('#panel_box').slideDown();
            $('#panel_type').attr("disabled", false); 
            $('#company_name').attr("disabled", false); 
            $('#policy_no').attr("disabled", false); 
            $('#id_number').attr("disabled", false); 
            $('#authorization_amount').attr("disabled", false); 
        }

}
  function room_no_select(value_room,room_no_id){
            $.ajax({
                url: "<?php echo base_url('ipd_booking/select_room_number/'); ?>",
                type: "post",
                data: {room_id:value_room,room_no_id:room_no_id},
                success: function(result) 
                {
                  $('#room_no_id').html(result);
                }
            });
     }

     function select_no_bed(value_bed,bed_id){

        var room_id= $("#room_id option:selected").val();
        var ipd_id = $("#type_id").val();
        
        $.ajax({
                url: "<?php echo base_url('ipd_booking/select_bed_no_number/'); ?>",
                type: "post",
                data: {room_id:room_id,room_no_id:value_bed,bed_id:bed_id,ipd_id:ipd_id},
                success: function(result) 
                {
                  $('#bed_no_id').html(result);
                }
            });

     }

/*$(document).ready(function (){
     package_val('<?php echo $form_data['package'];?>');
    patient_change('<?php echo $form_data['patient_type'];?>');

    room_no_select('<?php echo $form_data['room_id'];?>','<?php echo $form_data['room_no_id'];?>');
    select_no_bed('<?php echo $form_data['room_no_id'];?>','<?php echo $form_data['bed_no_id'];?>')

});*/

$(document).ready(function ()
{
  package_val('<?php echo $form_data['package'];?>');
  <?php  if(!empty($form_data['patient_type'])){ ?>
  patient_change('<?php echo $form_data['patient_type'];?>');
  <?php }
  if(!empty($form_data['room_id']))
  {
   ?>
    room_no_select('<?php echo $form_data['room_id'];?>','<?php echo $form_data['room_no_id'];?>');
  <?php } ?>
  <?php  if(!empty($form_data['room_no_id'])) { ?>
  select_no_bed('<?php echo $form_data['room_no_id'];?>','<?php echo $form_data['bed_no_id'];?>')

  <?php } ?>
});

 function isNumberKey(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode;
      if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
      } else {
          return true;
      }      
  }
    function find_gender(id){
     if(id!==''){
          $.post('<?php echo base_url().'simulation/find_gender' ?>',{'simulation_id':id},function(result){
               if(result!==''){
                    $("#gender").html(result);
               }
          })
     }
 }
 $(document).ready(function()
{
       var simulation_id = $("#simulation_id :selected").val();
        find_gender(simulation_id);
 })

$(".txt_firstCap").on('keyup', function(){

   var str = $('.txt_firstCap').val();
   var part_val = str.split(" ");
    for ( var i = 0; i < part_val.length; i++ )
    {
      var j = part_val[i].charAt(0).toUpperCase();
      part_val[i] = j + part_val[i].substr(1);
    }
      
   $('.txt_firstCap').val(part_val.join(" "));
  
  });
</script>
<link href = "<?php echo ROOT_CSS_PATH; ?>jquery-ui.css" rel = "stylesheet">
<script src = "<?php echo ROOT_JS_PATH; ?>jquery-ui.js"></script>
<script type="text/javascript">

function handlePaymentMode() {
        var patientCategoryElement = document.getElementById("patient_category");
        var selectedCategory = patientCategoryElement.options[patientCategoryElement.selectedIndex].getAttribute("data-category-name");

        var paymentModeElement = document.getElementById("payment_mode");

        // Automatically select "Billed" if category is Corporate, Subsidy, or Panel, otherwise "Cash"
        if (['Corporate', 'Subsidy', 'Panel'].includes(selectedCategory)) {
          for (var i = 0; i < paymentModeElement.options.length; i++) {
            if (paymentModeElement.options[i].text.toLowerCase() === 'billed') {
              paymentModeElement.selectedIndex = i;
              break;
            }
          }
        } else {
          for (var i = 0; i < paymentModeElement.options.length; i++) {
            if (paymentModeElement.options[i].text.toLowerCase() === 'cash') {
              paymentModeElement.selectedIndex = i;
              break;
            }
          }
        }
      }
      function toggleSections() {
          var selectedCategory = $('#patient_category option:selected').text().trim().toLowerCase();
          // alert(selectedCategory);

          if (selectedCategory === 'corporate') {
            $('#corporate_full_facility1').slideDown();
            $('#corporate_box').slideDown();
            $('#subsidy_box').slideUp();
            $('#panel_box').slideUp();
          } else if (selectedCategory === 'subsidy') {
            $('#corporate_full_facility1').slideUp();
            $('#corporate_box').slideUp();
            $('#subsidy_box').slideDown();
            $('#panel_box').slideUp();
          } else if (selectedCategory === 'panel') {
            $('#corporate_full_facility1').slideUp();
            $('#corporate_box').slideUp();
            $('#subsidy_box').slideUp();
            $('#panel_box').slideDown();
          } else {
            $('#corporate_full_facility1').slideUp();
            $('#corporate_box').slideUp();
            $('#subsidy_box').slideUp();
            $('#panel_box').slideUp();
          }
        }
        $(document).ready(function () {
          toggleSections();
          $('#patient_category').on('change', function () {
            toggleSections();
          });
        });


// function more_patient_info()
//  {
//      var txt = $(".more_content").is(':visible') ? 'More Info' : 'Less Info';
//         $(".show_hide_more").text(txt);
        
//    $("#patient_info").slideToggle();
//  }

</script>
<script type="text/javascript">
$(document).ready(function(){
<?php
if(empty($_POST))
{

if((empty($package_list)) || (empty($room_type_list)) || (empty($simulation_list)) || (empty($room_no)) || (empty($bed_no)) || (empty($referal_doctor_list)) || (empty($assigned_doctor)) || (empty($attended_doctor)))
{
  
?>  

 
  $('#ipd_row_count1').modal({
     backdrop: 'static',
      keyboard: false
        })
<?php 

}
}
?>

});
$(document).ready(function(){
var $modal = $('#load_add_patient_category_modal_popup');
$('#patient_category_add_modal').on('click', function(){
$modal.load('<?php echo base_url().'patient_category/add/' ?>',
{
  //'id1': '1',
  //'id2': '2'
  },
function(){
$modal.modal('show');
});

});

});

$(document).ready(function(){
var $modal = $('#load_add_authorize_person_modal_popup');

$('#authorize_person_add_modal').on('click', function(){
$modal.load('<?php echo base_url().'authorize_person/add/' ?>',
{
  //'id1': '1',
  //'id2': '2'
  },
function(){
$modal.modal('show');
});


});
});
$(document).ready(function() {
   $('#load_add_patient_category_modal_popup').on('shown.bs.modal', function(e){
    $('.inputFocus').focus();
  });
  $('#load_add_authorize_person_modal_popup').on('shown.bs.modal', function(e){
    $('.inputFocus').focus();
  });
});
</script>

<div id="ipd_row_count1" class="modal fade dlt-modal">
      <div class="modal-dialog">
        <div class="modal-content bg-r-border">
            <div class="modal-header bg-theme bg-red"><b><span>Notice</span></b><button type="button" class="close close1" data-dismiss="modal" data-number="4" aria-label="Close"><span aria-hidden="true">×</span></button></div>
          <div class="modal-footer  text-l">
            <?php if(empty($simulation_list)) {
          ?> <p><i class="fa fa-star" aria-hidden="true"></i><span class="text1">Simulation is required.</span></p><?php } ?>
          <?php if(empty($package_list)) {
          ?> <p><i class="fa fa-star" aria-hidden="true"></i><span class="text1">Package Name is required.</span></p><?php } ?>
          <!-- <?php if(empty($room_type_list)) { ?>
           <p><i class="fa fa-star" aria-hidden="true"></i><span class="text1">Room Type is required.</span></p>
          <?php } ?>
             <?php if(empty($room_no)) { ?>
           <p><i class="fa fa-star" aria-hidden="true"></i><span class="text1">Room No. is required.</span></p> -->
          <?php } ?>
             <!--  -->
              <?php if(empty($referal_doctor_list)) { ?>
           <p><i class="fa fa-star" aria-hidden="true"></i><span class="text1">Referral Doctor is required.</span></p>
          <?php } ?>
              <?php if(empty($assigned_doctor)) { ?>
           <p><i class="fa fa-star" aria-hidden="true"></i><span class="text1">Assigned Doctor is required.</span></p>
          <?php } ?>
              <?php if(empty($attended_doctor)) { ?>
           <p><i class="fa fa-star" aria-hidden="true"></i><span class="text1">Attended Doctor is required.</span></p>
          <?php } ?>
          
          </div>
        </div>
      </div>  
    </div>
    
    
    
    <div id="confirm_print" class="modal fade dlt-modal">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-theme"><h4>Are You Sure?</h4></div>
          <!-- <div class="modal-body"></div> -->
          <div class="modal-footer">
            <a type="button" data-dismiss="modal" class="btn-anchor"  onClick="return print_window_page('<?php echo base_url("ipd_booking/print_ipd_booking_recipt"); ?>');" >Print</a>
            <button type="button" data-dismiss="modal" class="btn-cancel" id="cancel">Close</button>
          </div>
        </div>
      </div>  
    </div>

    <div id="confirm_mlc" class="modal fade dlt-modal">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-theme"><h4>Are You Sure?</h4></div>
          <!-- <div class="modal-body"></div> -->
          <div class="modal-footer">
            <a type="button" data-dismiss="modal" class="btn-anchor"  onClick="return print_window_page('<?php echo base_url("ipd_booking/mlc_print"); ?>');" >Print</a>
            <button type="button" data-dismiss="modal" class="btn-cancel" id="cancel">Close</button>
          </div>
        </div>
      </div>  
    </div>
    <div id="confirm_admission_print" class="modal fade dlt-modal">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-theme"><h4>Are You Sure?</h4></div>
          
          <div class="modal-footer">
            <a type="button" data-dismiss="modal" class="btn-anchor"  onClick="return print_window_page('<?php echo base_url("ipd_booking/print_ipd_adminssion_card"); ?>');" >Print</a>
            <button type="button" data-dismiss="modal" class="btn-cancel" id="cancel">Close</button>
          </div>
        </div>
      </div>  
    </div>

    <div id="confirm_discharge" class="modal fade dlt-modal">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-theme"><h4>Are You Sure For Discharge?</h4></div>
          
          <div class="modal-footer">
            <a type="button" data-dismiss="modal" class="btn-anchor"  id="yes" onClick="" >Yes</a>
            <button type="button" data-dismiss="modal" class="btn-cancel" id="cancel">No</button>
          </div>
        </div>
      </div>  
    </div>

    <div id="confirm_readmit" class="modal fade dlt-modal">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-theme"><h4>Are You Sure For Re-admit?</h4></div>
          
          <div class="modal-footer">
            <a type="button" data-dismiss="modal" class="btn-anchor"  id="yes" onClick="" >Yes</a>
            <button type="button" data-dismiss="modal" class="btn-cancel" id="cancel">No</button>
          </div>
        </div>
      </div>  
    </div>

     

    <div id="confirm" class="modal fade dlt-modal">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-theme"><h4>Are You Sure?</h4></div>
          <!-- <div class="modal-body"></div> -->
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn-update" id="delete">Confirm</button>
            <button type="button" data-dismiss="modal" class="btn-cancel">Close</button>
          </div>
        </div>
      </div>  
    </div> <!-- modal -->
<div id="load_add_authorize_person_modal_popup" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false"></div> 
<div id="load_add_patient_category_modal_popup" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false"></div> 
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('.diagnosis_list').select2({
  ajax: {
    url: '<?=base_url('medication_chart/diagnosis_list')?>',
    dataType: 'json',
    data: function (params) {

        var queryParameters = {
            term: params.term
        }
        return queryParameters;
    },
        processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.diagnosis,
                        id: item.id
                    }
                })
            };
        }
    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
  }
});
// 
</script>