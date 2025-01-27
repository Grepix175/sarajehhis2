<?php
$users_data = $this->session->userdata('auth_users');
//print_r($discharge_vital_setting_list);
//echo "<pre>"; print_r($patient_details); exit;
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
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>jquery-ui.css">
<!-- js -->
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>jquery.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap.min.js"></script> 
<!-- datatable js -->
<script src="<?php echo ROOT_JS_PATH; ?>jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT_JS_PATH; ?>dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>validation.js"></script> 
<script src="<?php echo ROOT_JS_PATH; ?>jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>moment-with-locales.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datepicker.css">
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap-datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datetimepicker.css">
<script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap-datetimepicker.js"></script>
</head>

<body>


<div class="container-fluid">
 <?php
  $this->load->view('include/header');
  $this->load->view('include/inner_header');
 ?>
 <section class="userlist">
 
  <form  id="ipd_patient_discharge_summary" class="form-inline" action="<?php echo current_url(); ?>" method="post" >
  <input type="hidden" name="data_id" id="type_id" value="<?php echo $form_data['data_id']; ?>" />  
  <!-- ////////////////////////////// -->
 <div class="row">
   
   <div class="col-md-6">
     <!-- ============================ -->
        
        <div class="row m-b-5">
          <div class="col-xs-4">
              <strong> Name <span class="star">*</span></strong>
            </div>
            <div class="col-xs-8"> 
              <input type="text" name="name"  id="name" value="<?php echo $form_data['name']; ?>" class="mr-name txt_firstCap" autofocus/> 
                <?php if(!empty($form_error)){ echo form_error('name'); } ?>
            </div>
        </div>

       
       
     

          <div class="row m-b-5">
             <div class="col-xs-4"></div>
             <div class="col-xs-8 font-default">
                <label class="font-default"><input type="radio" name="summery_type" id="summery_type" <?php if($form_data['summery_type']==0){ echo 'checked="checked"'; } ?> value="0"> LAMA</label> &nbsp;
                <label class="font-default"><input type="radio" name="summery_type" id="summery_type" <?php if($form_data['summery_type']==1){ echo 'checked="checked"'; } ?> value="1"> REFERRAL</label> &nbsp;
                <label class="font-default"><input type="radio" name="summery_type" id="summery_type" <?php if($form_data['summery_type']==2){ echo 'checked="checked"'; } ?> value="2"> DISCHARGE</label> &nbsp;
                <label class="font-default"><input type="radio" name="summery_type" id="summery_type" <?php if($form_data['summery_type']==3){ echo 'checked="checked"'; } ?> value="3"> D.O.P.R</label> &nbsp;
                <label class="font-default"><input type="radio" name="summery_type" id="summery_type" <?php if($form_data['summery_type']==4){ echo 'checked="checked"'; } ?> value="4"> NORMAL</label>&nbsp;
                <label class="font-default"><input type="radio" name="summery_type" id="summery_type" <?php if($form_data['summery_type']==5){ echo 'checked="checked"'; } ?> value="5"> Expired</label>
             </div>
          </div> <!-- row --> 
<div id="content">
          <?php
          //echo "<pre>"; print_r($discharge_labels_setting_list);  exit; 
          if(!empty($discharge_labels_setting_list))
          {
            $i=1;
            foreach ($discharge_labels_setting_list as $value) 
            {
              

              

              if(strcmp(strtolower($value['setting_name']),'cheif_complaints')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                        <textarea class="textarea-100" id="chief_complaints" name="chief_complaints"><?php echo $form_data['chief_complaints']; ?></textarea>
                        <?php if(!empty($form_error)){ echo form_error('chief_complaints'); } ?>
                     </div>
                  </div> <!-- row -->

                <?php 

              }



              if(strcmp(strtolower($value['setting_name']),'ho_presenting_illness')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                      <textarea id="h_o_presenting" name="h_o_presenting" class="textarea-100"><?php echo $form_data['h_o_presenting']; ?></textarea>
                      <?php if(!empty($form_error)){ echo form_error('h_o_presenting'); } ?>
                   </div>
                  </div> <!-- row -->

                <?php 

              }

              if(strcmp(strtolower($value['setting_name']),'on_examination')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                      <textarea name="on_examination" id="on_examination" class="textarea-100"><?php echo $form_data['on_examination']; ?></textarea>
                      <?php if(!empty($form_error)){ echo form_error('on_examination'); } ?>
                   </div>
                  </div> <!-- row -->

                <?php 

              }
              
              if(strcmp(strtolower($value['setting_name']),'past_history')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                      <textarea id="past_history" name="past_history" class="textarea-100"><?php echo $form_data['past_history']; ?></textarea>
                      <?php if(!empty($form_error)){ echo form_error('past_history'); } ?>
                   </div>
                  </div> <!-- row -->

                <?php 

              }

              if(strcmp(strtolower($value['setting_name']),'menstrual_history')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                      <textarea id="menstrual_history" name="menstrual_history" class="textarea-100"><?php echo $form_data['menstrual_history']; ?></textarea>
                      <?php if(!empty($form_error)){ echo form_error('menstrual_history'); } ?>
                   </div>
                  </div> <!-- row -->

                <?php 

              }

              if(strcmp(strtolower($value['setting_name']),'obstetric_history')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                      <textarea id="obstetric_history" name="obstetric_history" class="textarea-100"><?php echo $form_data['obstetric_history']; ?></textarea>
                      <?php if(!empty($form_error)){ echo form_error('obstetric_history'); } ?>
                   </div>
                  </div> <!-- row -->

                <?php 

              }

              if(strcmp(strtolower($value['setting_name']),'vitals')=='0')
              {
                if(!empty($discharge_vital_setting_list))
                  { ?>
                  


        <div class="row m-b-5">
             <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
             <div class="col-xs-8">
                  
                  <?php 
                  
                    $j=$i;
                    $r_i = 1;
                    $c_i = 1;
                    foreach ($discharge_vital_setting_list as $vital_value) 
                    {  
                        ?>
                        
                        
                   <div class="row m-b-2 ">
                   
                        <?php 
                        if(strcmp(strtolower($vital_value['setting_name']),'pulse')=='0')
                        {
                        ?>
                          <div class="col-sm-6 ">
                           <label class="w-80px"><?php if(!empty($vital_value['setting_value'])) { echo $vital_value['setting_value']; } else { echo $vital_value['var_title']; } ?></label>
                           <input name="vitals_pulse" id="vitals_pulse" class=" w-90px" type="text"  value="<?php echo $form_data['vitals_pulse']; ?>">
                           <?php if(!empty($form_error)){ echo form_error('vitals_pulse'); } ?>
                        </div>
                        <?php 
                        }

                        if(strcmp(strtolower($vital_value['setting_name']),'chest')=='0')
                        {
                        ?>
                          <div class="col-sm-6">
                           <label class="w-80px"><?php if(!empty($vital_value['setting_value'])) { echo $vital_value['setting_value']; } else { echo $vital_value['var_title']; } ?></label>
                           <input id="vitals_chest" name="vitals_chest" class=" w-90px" type="text" value="<?php echo $form_data['vitals_chest']; ?>">
                           <?php if(!empty($form_error)){ echo form_error('vitals_chest'); } ?>
                        </div> 
                        <?php 
                        }

                        ?>
                       
                   </div><!-- innerrow -->  
                   


                    
                   <div class="row m-b-2">
                   
                      <?php 
                      if(strcmp(strtolower($vital_value['setting_name']),'bp')=='0')
                      {
                      ?>
                          <div class="col-sm-6">
                           <label class="w-80px"><?php if(!empty($vital_value['setting_value'])) { echo $vital_value['setting_value']; } else { echo $vital_value['var_title']; } ?></label>
                           <input id="vitals_bp" type="text" name="vitals_bp" class=" w-90px" value="<?php echo $form_data['vitals_bp']; ?>">
                       <?php if(!empty($form_error)){ echo form_error('vitals_bp'); } ?>
                    </div> 
                        <?php 
                        }

                        if(strcmp(strtolower($vital_value['setting_name']),'cvs')=='0')
                        {
                        ?>
                          <div class="col-sm-6">
                           <label class="w-80px"><?php if(!empty($vital_value['setting_value'])) { echo $vital_value['setting_value']; } else { echo $vital_value['var_title']; } ?></label>
                           <input type="text" id="vitals_cvs" class=" w-90px" name="vitals_cvs" value="<?php echo $form_data['vitals_cvs']; ?>">
                         <?php if(!empty($form_error)){ echo form_error('vitals_cvs'); } ?>
                      </div> 
                        <?php 
                        }

                        ?>
                   
                   </div><!-- innerrow -->  
                
                   
                   <div class="row m-b-2">
                   
                        <?php 
                        if(strcmp(strtolower($vital_value['setting_name']),'temp')=='0')
                        {
                        ?>
                          <div class="col-sm-6">
                           <label class="w-80px"><?php if(!empty($vital_value['setting_value'])) { echo $vital_value['setting_value']; } else { echo $vital_value['var_title']; } ?></label>
                           <input type="text" id="vitals_temp" class=" w-90px" name="vitals_temp" value="<?php echo $form_data['vitals_temp']; ?>">
                       <?php if(!empty($form_error)){ echo form_error('vitals_temp'); } ?>
                    </div> 
                        <?php 
                        }

                        if(strcmp(strtolower($vital_value['setting_name']),'cns')=='0')
                        {
                        ?>
                          <div class="col-sm-6">
                           <label class="w-80px"><?php if(!empty($vital_value['setting_value'])) { echo $vital_value['setting_value']; } else { echo $vital_value['var_title']; } ?></label>
                          <input type="text" id="vitals_cns" class="w-90px" name="vitals_cns" value="<?php echo $form_data['vitals_cns']; ?>">
                         <?php if(!empty($form_error)){ echo form_error('vitals_cns'); } ?>
                      </div> 
                        <?php 
                        }

                        ?>
                  
                   </div><!-- innerrow -->  
                  

                   
                   <div class="row m-b-2">
                  
                        <?php 
                        if(strcmp(strtolower($vital_value['setting_name']),'p_a')=='0')
                        {
                        ?>
                          <div class="col-sm-6">
                           <label class="w-80px"><?php if(!empty($vital_value['setting_value'])) { echo $vital_value['setting_value']; } else { echo $vital_value['var_title']; } ?></label>
                           <input type="text" id="vitals_p_a" class="w-90px" name="vitals_p_a" value="<?php echo $form_data['vitals_p_a']; ?>">
                       <?php if(!empty($form_error)){ echo form_error('vitals_p_a'); } ?>
                    </div> 
                        <?php 
                        }

                        if(strcmp(strtolower($vital_value['setting_name']),'r_r')=='0')
                        {
                        ?>
                          <div class="col-sm-6">
                           <label class="w-80px"><?php if(!empty($vital_value['setting_value'])) { echo $vital_value['setting_value']; } else { echo $vital_value['var_title']; } ?></label>
                          <input type="text" id="vitals_r_r" class="w-90px" name="vitals_r_r" value="<?php echo $form_data['vitals_r_r']; ?>">
                         <?php if(!empty($form_error)){ echo form_error('vitals_r_r'); } ?>
                      </div> 
                        <?php 
                        }

                        if(strcmp(strtolower($vital_value['setting_name']),'saturation')=='0')
                        {
                        ?>
                          <div class="col-sm-6">
                           <label class="w-80px"><?php if(!empty($vital_value['setting_value'])) { echo $vital_value['setting_value']; } else { echo $vital_value['var_title']; } ?></label>
                          <input type="text" id="vitals_saturation" class="w-90px" name="vitals_saturation" value="<?php echo $form_data['vitals_saturation']; ?>">
                         <?php if(!empty($form_error)){ echo form_error('vitals_saturation'); } ?>
                      </div> 
                        <?php 
                        }

                        if(strcmp(strtolower($vital_value['setting_name']),'pupils')=='0')
                        {
                        ?>
                          <div class="col-sm-6">
                           <label class="w-80px"><?php if(!empty($vital_value['setting_value'])) { echo $vital_value['setting_value']; } else { echo $vital_value['var_title']; } ?></label>
                          <input type="text" id="vitals_pupils" class="w-90px" name="vitals_pupils" value="<?php echo $form_data['vitals_pupils']; ?>">
                         <?php if(!empty($form_error)){ echo form_error('vitals_pupils'); } ?>
                      </div> 
                        <?php 
                        }


                        if(strcmp(strtolower($vital_value['setting_name']),'pallor')=='0')
                        {
                        ?>
                          <div class="col-sm-6">
                           <label class="w-80px"><?php if(!empty($vital_value['setting_value'])) { echo $vital_value['setting_value']; } else { echo $vital_value['var_title']; } ?></label>
                          <input type="text" id="vitals_pallor" class="w-90px" name="vitals_pallor" value="<?php echo $form_data['vitals_pallor']; ?>">
                         <?php if(!empty($form_error)){ echo form_error('vitals_pallor'); } ?>
                      </div> 
                        <?php 
                        }

                        if(strcmp(strtolower($vital_value['setting_name']),'icterus')=='0')
                        {
                        ?>
                          <div class="col-sm-6">
                           <label class="w-80px"><?php if(!empty($vital_value['setting_value'])) { echo $vital_value['setting_value']; } else { echo $vital_value['var_title']; } ?></label>
                          <input type="text" id="vitals_icterus" class="w-90px" name="vitals_icterus" value="<?php echo $form_data['vitals_icterus']; ?>">
                         <?php if(!empty($form_error)){ echo form_error('vitals_icterus'); } ?>
                      </div> 
                        <?php 
                        }

                        if(strcmp(strtolower($vital_value['setting_name']),'cyanosis')=='0')
                        {
                        ?>
                          <div class="col-sm-6">
                           <label class="w-80px"><?php if(!empty($vital_value['setting_value'])) { echo $vital_value['setting_value']; } else { echo $vital_value['var_title']; } ?></label>
                          <input type="text" id="vitals_cyanosis" class="w-90px" name="vitals_cyanosis" value="<?php echo $form_data['vitals_cyanosis']; ?>">
                         <?php if(!empty($form_error)){ echo form_error('vitals_cyanosis'); } ?>
                      </div> 
                        <?php 
                        }

                        if(strcmp(strtolower($vital_value['setting_name']),'clubbing')=='0')
                        {
                        ?>
                          <div class="col-sm-6">
                           <label class="w-80px"><?php if(!empty($vital_value['setting_value'])) { echo $vital_value['setting_value']; } else { echo $vital_value['var_title']; } ?></label>
                          <input type="text" id="vitals_clubbing" class="w-90px" name="vitals_clubbing" value="<?php echo $form_data['vitals_clubbing']; ?>">
                         <?php if(!empty($form_error)){ echo form_error('vitals_clubbing'); } ?>
                      </div> 
                        <?php 
                        }

                        if(strcmp(strtolower($vital_value['setting_name']),'edema')=='0')
                        {
                        ?>
                          <div class="col-sm-6">
                           <label class="w-80px"><?php if(!empty($vital_value['setting_value'])) { echo $vital_value['setting_value']; } else { echo $vital_value['var_title']; } ?></label>
                          <input type="text" id="vitals_edema" class="w-90px" name="vitals_edema" value="<?php echo $form_data['vitals_edema']; ?>">
                         <?php if(!empty($form_error)){ echo form_error('vitals_edema'); } ?>
                      </div> 
                        <?php 
                        }
                         if(strcmp(strtolower($vital_value['setting_name']),'lymphadenopathy')=='0')
                        {
                        ?>
                          <div class="col-sm-6">
                           <label class="w-80px"><?php if(!empty($vital_value['setting_value'])) { echo $vital_value['setting_value']; } else { echo $vital_value['var_title']; } ?></label>
                          <input type="text" id="vitals_lymphadenopathy" class="w-90px" name="vitals_lymphadenopathy" value="<?php echo $form_data['vitals_lymphadenopathy']; ?>">
                         <?php if(!empty($form_error)){ echo form_error('vitals_lymphadenopathy'); } ?>
                      </div> 
                        <?php 
                        }

                        
                        ?>
                  
                   </div><!-- innerrow -->  
                   

                        <?php 
                        
                    $r_i++;
                    $c_i++;
                    
                    }
                  

                    ?>

             </div> 
          </div>

                <?php  } 

              }

              if(strcmp(strtolower($value['setting_name']),'provisional_diagnosis')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                      <textarea name="provisional_diagnosis" id="provisional_diagnosis" class="textarea-100"><?php echo $form_data['provisional_diagnosis']; ?></textarea>
                      <?php if(!empty($form_error)){ echo form_error('provisional_diagnosis'); } ?>
                   </div>
                  </div> <!-- row -->

                <?php 

              }

              if(strcmp(strtolower($value['setting_name']),'final_diagnosis')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                     <textarea name="final_diagnosis" id="final_diagnosis" class="textarea-100"><?php echo $form_data['final_diagnosis']; ?></textarea>
                    <?php if(!empty($form_error)){ echo form_error('final_diagnosis'); } ?>
                 </div>
                  </div> <!-- row -->

                <?php 

              }

              if(strcmp(strtolower($value['setting_name']),'course_in_hospital')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                      <textarea name="course_in_hospital" id="course_in_hospital" class="textarea-100"><?php echo $form_data['course_in_hospital']; ?></textarea>
                      <?php if(!empty($form_error)){ echo form_error('course_in_hospital'); } ?>
                   </div>
                  </div> <!-- row -->

                <?php 

              }
              
              
               if(strcmp(strtolower($value['setting_name']),'surgery_preferred')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                      <textarea name="surgery_preferred" id="surgery_preferred" class="textarea-100"><?php echo $form_data['surgery_preferred']; ?></textarea>
                      <?php if(!empty($form_error)){ echo form_error('surgery_preferred'); } ?>
                   </div>
                  </div> <!-- row -->

                <?php 

              }

              if(strcmp(strtolower($value['setting_name']),'operation_notes')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                      <textarea name="operation_notes" id="operation_notes" class="textarea-100"><?php echo $form_data['operation_notes']; ?></textarea>
                      <?php if(!empty($form_error)){ echo form_error('operation_notes'); } ?>
                   </div>
                  </div> <!-- row -->

                <?php 

              }

              if(strcmp(strtolower($value['setting_name']),'treatment_given')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                      <textarea name="treatment_given" id="treatment_given" class="textarea-100"><?php echo $form_data['treatment_given']; ?></textarea>
                      <?php if(!empty($form_error)){ echo form_error('treatment_given'); } ?>
                   </div>
                  </div> <!-- row -->

                <?php 

              }

             

              if(strcmp(strtolower($value['setting_name']),'investigation')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                      <textarea name="investigations" id="investigations" class="textarea-100"><?php echo $form_data['investigations']; ?></textarea>
                      <?php if(!empty($form_error)){ echo form_error('investigations'); } ?>
                   </div>
                  </div> <!-- row -->

                <?php 

              }

              if(strcmp(strtolower($value['setting_name']),'condition_at_discharge_time')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                       <textarea name="discharge_time_condition" id="discharge_time_condition" class="textarea-100"><?php echo $form_data['discharge_time_condition']; ?></textarea>
                      <?php if(!empty($form_error)){ echo form_error('discharge_time_condition'); } ?>
                   </div>
                  </div> <!-- row -->

                <?php 

              }

              if(strcmp(strtolower($value['setting_name']),'advise_on_discharge')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                      <textarea name="discharge_advice" id="discharge_advice" class="textarea-100"><?php echo $form_data['discharge_advice']; ?></textarea>
                      <?php if(!empty($form_error)){ echo form_error('discharge_advice'); } ?>
                   </div>
                  </div> <!-- row -->

                <?php 

              }

             
              if(strcmp(strtolower($value['setting_name']),'diagnosis')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                        <textarea class="textarea-100" id="diagnosis" name="diagnosis"><?php echo $form_data['diagnosis']; ?></textarea>
                        <?php if(!empty($form_error)){ echo form_error('diagnosis'); } ?>
                     </div>
                  </div> <!-- row -->

                <?php 

              }

              

              if(strcmp(strtolower($value['setting_name']),'family_history')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                        <textarea class="textarea-100" id="family_history" name="family_history"><?php echo $form_data['family_history']; ?></textarea>
                        <?php if(!empty($form_error)){ echo form_error('family_history'); } ?>
                     </div>
                  </div> <!-- row -->

                <?php 

              }

               if(strcmp(strtolower($value['setting_name']),'birth_history')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                        <textarea class="textarea-100" id="birth_history" name="birth_history"><?php echo $form_data['birth_history']; ?></textarea>
                        <?php if(!empty($form_error)){ echo form_error('birth_history'); } ?>
                     </div>
                  </div> <!-- row -->

                <?php 

              }


               if(strcmp(strtolower($value['setting_name']),'general_history')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                        <textarea class="textarea-100" id="general_history" name="general_history"><?php echo $form_data['general_history']; ?></textarea>
                        <?php if(!empty($form_error)){ echo form_error('general_history'); } ?>
                     </div>
                  </div> <!-- row -->

                <?php 

              }

               if(strcmp(strtolower($value['setting_name']),'systemic_examination')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                        <textarea class="textarea-100" id="systemic_examination" name="systemic_examination"><?php echo $form_data['systemic_examination']; ?></textarea>
                        <?php if(!empty($form_error)){ echo form_error('systemic_examination'); } ?>
                     </div>
                  </div> <!-- row -->

                <?php 

              }

               if(strcmp(strtolower($value['setting_name']),'local_examination')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                        <textarea class="textarea-100" id="local_examination" name="local_examination"><?php echo $form_data['local_examination']; ?></textarea>
                        <?php if(!empty($form_error)){ echo form_error('local_examination'); } ?>
                     </div>
                  </div> <!-- row -->

                <?php 

              }

               if(strcmp(strtolower($value['setting_name']),'specific_findings')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                        <textarea class="textarea-100" id="specific_findings" name="specific_findings"><?php echo $form_data['specific_findings']; ?></textarea>
                        <?php if(!empty($form_error)){ echo form_error('specific_findings'); } ?>
                     </div>
                  </div> <!-- row -->

                <?php 

              }



              

             /* if(strcmp(strtolower($value['setting_name']),'review_time_and_date')=='0')
              {
                ?>
                  <div class="row m-b-5">
                     <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                     <div class="col-xs-8">
                      <input type="text" name="review_time_date" class="w-130px datepicker" placeholder="Date" value="<?php echo  $form_data['review_time_date']; ?>" >
                      <input type="text" name="review_time" class="w-65px datepicker3" placeholder="Time" value="<?php  echo $form_data['review_time']; ?>">

                      <?php if(!empty($form_error)){ echo form_error('review_time_date'); } ?>
                   </div>
                  </div> <!-- row -->

                  <?php 
                  }*/

                  if(strcmp(strtolower($value['setting_name']),'pulse')=='0')
                  {
                    ?>
                      <div class="row m-b-5">
                         <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                         <div class="col-xs-8">
                         
                         <textarea name="vitals_pulse" id="vitals_pulse" class="textarea-100"><?php echo $form_data['vitals_pulse']; ?></textarea>
                          <?php if(!empty($form_error)){ echo form_error('vitals_pulse'); } ?>
                       </div>
                      </div> <!-- row -->

                    <?php 

                  }

                  if(strcmp(strtolower($value['setting_name']),'chest')=='0')
                  {
                    ?>
                      <div class="row m-b-5">
                         <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                         <div class="col-xs-8">
                        
                        <textarea name="vitals_chest" id="vitals_chest" class="textarea-100"><?php echo $form_data['vitals_chest']; ?></textarea>
                           <?php if(!empty($form_error)){ echo form_error('vitals_chest'); } ?>
                       </div>
                      </div> <!-- row -->

                    <?php 

                  }

                  if(strcmp(strtolower($value['setting_name']),'bp')=='0')
                  {
                    ?>
                      <div class="row m-b-5">
                         <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                         <div class="col-xs-8">
                         
                        <textarea name="vitals_bp" id="vitals_bp" class="textarea-100"><?php echo $form_data['vitals_bp']; ?></textarea>

                         
                       <?php if(!empty($form_error)){ echo form_error('vitals_bp'); } ?>
                       </div>
                      </div> <!-- row -->

                    <?php 

                  }

                  if(strcmp(strtolower($value['setting_name']),'cvs')=='0')
                  {
                    ?>
                      <div class="row m-b-5">
                         <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                         <div class="col-xs-8">
                         <textarea name="vitals_cvs" id="vitals_cvs" class="textarea-100"><?php echo $form_data['vitals_cvs']; ?></textarea>
                         
                         <?php if(!empty($form_error)){ echo form_error('vitals_cvs'); } ?>
                       </div>
                      </div> <!-- row -->

                    <?php 

                  }

                  if(strcmp(strtolower($value['setting_name']),'temp')=='0')
                  {
                    ?>
                      <div class="row m-b-5">
                         <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                         <div class="col-xs-8">
                         <textarea name="vitals_temp" id="vitals_temp" class="textarea-100"><?php echo $form_data['vitals_temp']; ?></textarea>
                         
                       <?php if(!empty($form_error)){ echo form_error('vitals_temp'); } ?>
                       </div>
                      </div> <!-- row -->

                    <?php 

                  }

                  if(strcmp(strtolower($value['setting_name']),'cns')=='0')
                  {
                    ?>
                      <div class="row m-b-5">
                         <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                         <div class="col-xs-8">
                         <textarea name="vitals_cns" id="vitals_cns" class="textarea-100"><?php echo $form_data['vitals_cns']; ?></textarea>
                          
                         <?php if(!empty($form_error)){ echo form_error('vitals_cns'); } ?>
                       </div>
                      </div> <!-- row -->

                    <?php 

                  }

                  if(strcmp(strtolower($value['setting_name']),'p_a')=='0')
                  {
                    ?>
                      <div class="row m-b-5">
                         <div class="col-xs-4"><label><?php if(!empty($value['setting_value'])) { echo $value['setting_value']; } else { echo $value['var_title']; } ?></label></div>
                         <div class="col-xs-8">
                         <textarea name="vitals_p_a" id="vitals_p_a" class="textarea-100"><?php echo $form_data['vitals_p_a']; ?></textarea>
                          
                       <?php if(!empty($form_error)){ echo form_error('vitals_p_a'); } ?>
                       </div>
                      </div> <!-- row -->

                    <?php 

                  }
                  if(strcmp(strtolower($vital_value['setting_name']),'r_r')=='0')
                  {
                  ?>
                    <div class="col-sm-6">
                     <label class="w-80px"><?php if(!empty($vital_value['setting_value'])) { echo $vital_value['setting_value']; } else { echo $vital_value['var_title']; } ?></label>
                    <input type="text" id="vitals_r_r" class="w-90px" name="vitals_r_r" value="<?php echo $form_data['vitals_r_r']; ?>">
                   <?php if(!empty($form_error)){ echo form_error('vitals_r_r'); } ?>
                </div> 
                  <?php 
                  }



              $i++;
            }
          } ?>
         </div>  

          <div class="row m-b-5" id="remarks_d">
                     <div class="col-xs-4"><label>Remarks</label></div>
                     <div class="col-xs-8">
                        <textarea class="textarea-100" id="remarks" name="remarks"><?php  echo $form_data['remarks']; ?></textarea>
                       
                     </div>
                  </div> <!-- row --> 
          
           <div class="row m-b-5">
             <div class="col-xs-4"><label>Status</label></div>
             <div class="col-xs-8">
                 <input type="radio" name="status" value="1" <?php if($form_data['status']==1){ echo 'checked="checked"'; } ?>> Active &nbsp;
                 <input type="radio" name="status" value="0" <?php if($form_data['status']==0){ echo 'checked="checked"'; } ?>> Inactive
             </div>
          </div> <!-- row --> 
     <!-- ============================ -->
   </div> <!-- left portion -->


   <div class="col-md-6">
     <!-- ======================== -->

      
     
     
     
              <div class="row m-b-5">
                <div class="col-xs-12">
               <table class="table table-bordered table-striped" id="prescription_name_table" style="margin-top:50px;margin-left:-150px;">
                   <thead><tr><th colspan="9">Medication Prescribed  </th></tr></thead>
              <tbody>
                     <tr>
                      
                      <?php 
                    $m=0;

                    foreach ($prescription_medicine_tab_setting as $med_value) { ?>
                            <td <?php  if($m=0){ ?> class="text-left" <?php } ?> ><?php if(!empty($med_value->setting_value)) { echo $med_value->setting_value; } else { echo $med_value->var_title; } ?></td>
                                <?php 
                           $m++; 
                            }
                            ?> 
                                                    
                        <td width="40">
                            <a href="javascript:void(0)" style="width:40px;" class="btn-w-60 addprescriptionrow">Add</a>
                        </td>
                    </tr>

                      <?php 

                      if(!empty($prescription_presc_list))
                      { 
                           $l=1;
                         //  print_r($prescription_presc_list);die;
                          foreach ($prescription_presc_list as $prescription_presc) 
                          {
                            
                          ?>
                     <tr>
                       <?php
                        
                        foreach ($prescription_medicine_tab_setting as $tab_value) 

                        { 
                        if(strcmp(strtolower($tab_value->setting_name),'medicine')=='0')
                        { 
                        ?>
                        <td><input type="text" name="medicine_name[]" style="width:100px;" class="medicine_val<?php echo $l; ?>" value="<?php echo $prescription_presc->medicine_name; ?>"></td>
                        <?php 
                        }

                        if(strcmp(strtolower($tab_value->setting_name),'brand')=='0')
                        {
                        ?>
                        <td><input type="text" name="medicine_brand[]" style="width:80px;" class="" id="brand<?php echo $l; ?>" value="<?php echo $prescription_presc->medicine_brand; ?>"></td>
                        <?php 
                        } 

                        if(strcmp(strtolower($tab_value->setting_name),'salt')=='0')
                        {
                        ?>
                        <td><input type="text" name="medicine_salt[]" style="width:80px;" id="salt<?php echo $l; ?>" class="" value="<?php echo $prescription_presc->medicine_salt; ?>"></td>
                        <?php 
                        } 

                        if(strcmp(strtolower($tab_value->setting_name),'type')=='0')
                        { ?>
                        <td><input type="text" style="width:80px;" name="medicine_type[]" id="type<?php echo $l; ?>" class="input-small medicine_type_val<?php echo $l; ?>" value="<?php echo $prescription_presc->medicine_type; ?>"></td>
                        <?php 
                        }
                        if(strcmp(strtolower($tab_value->setting_name),'dose')=='0')
                        { ?>
                        <td><input type="text" style="width:80px;" name="medicine_dose[]" class="input-small dosage_val<?php echo $l; ?>" value="<?php echo $prescription_presc->medicine_dose; ?>"></td>
                        <?php 
                        } 
                        if(strcmp(strtolower($tab_value->setting_name),'duration')=='0')
                        {  ?>
                        <td><input type="text" style="width:80px;" name="medicine_duration[]" class="medicine-name duration_val<?php echo $l; ?>" value="<?php echo $prescription_presc->medicine_duration; ?>"></td>
                        <?php 
                        }
                        if(strcmp(strtolower($tab_value->setting_name),'frequency')=='0')
                        {
                        ?>
                        <td><input type="text" style="width:80px;" name="medicine_frequency[]" class="medicine-name frequency_val<?php echo $l; ?>" value="<?php echo $prescription_presc->medicine_frequency; ?>"></td>
                        <?php 
                        } 
                        if(strcmp(strtolower($tab_value->setting_name),'advice')=='0')
                        { 
                        ?>
                        <td><input type="text" style="width:80px;" name="medicine_advice[]" class="medicine-name advice_val<?php echo $l; ?>" value="<?php echo $prescription_presc->medicine_advice; ?>"></td>
                        <?php } }
                        ?>
                        <script type="text/javascript">
                          
                    /* script start */
                      $(function () 
                      {
                            var getData = function (request, response) { 
                              row = <?php echo $l; ?> ;
                              $.ajax({
                              url : "<?php echo base_url('opd/get_medicine_auto_vals/'); ?>" + request.term,
                              dataType: "json",
                              method: 'post',
                            data: {
                               name_startsWith: request.term,
                               type: 'country_table',
                               row_num : row
                            },
                             success: function( data ) {
                               response( $.map( data, function( item ) {
                                var code = item.split("|");
                                return {
                                  label: code[0],
                                  value: code[0],
                                  data : item
                                }
                              }));
                            }
                            });

                             
                          };

                          var selectItem = function (event, ui) {

                                var names = ui.item.data.split("|");

                                $('.medicine_val'+<?php echo $l; ?>).val(names[0]);
                                $('#type'+<?php echo $l; ?>).val(names[1]);
                                $('#brand'+<?php echo $l; ?>).val(names[2]);
                                $('#salt'+<?php echo $l; ?>).val(names[3]);
                              //$(".medicine_val").val(ui.item.value);
                              return false;
                          }

                          $(".medicine_val"+<?php echo $l; ?>).autocomplete({
                              source: getData,
                              select: selectItem,
                              minLength: 1,
                              change: function() {
                                  //$("#test_val").val("").css("display", 2);
                              }
                          });
                          });


                      $(function () {
                          var getData = function (request, response) { 
                              $.getJSON(
                                  "<?php echo base_url('opd/get_type_vals/'); ?>" + request.term,
                                  function (data) {
                                      response(data);
                                  });
                          };

                          var selectItem = function (event, ui) {
                              $(".medicine_type_val"+<?php echo $l; ?>).val(ui.item.value);
                              return false;
                          }

                          $(".medicine_type_val"+<?php echo $l; ?>).autocomplete({
                              source: getData,
                              select: selectItem,
                              minLength: 1,
                              change: function() {
                                  //$("#test_val").val("").css("display", 2);
                              }
                          });
                          });

                      $(function () {
                          var getData = function (request, response) { 
                              $.getJSON(
                                  "<?php echo base_url('opd/get_dosage_vals/'); ?>" + request.term,
                                  function (data) {
                                      response(data);
                                  });
                          };

                          var selectItem = function (event, ui) {
                              $(".dosage_val"+<?php echo $l; ?>).val(ui.item.value);
                              return false;
                          }

                          $(".dosage_val"+<?php echo $l; ?>).autocomplete({
                              source: getData,
                              select: selectItem,
                              minLength: 1,
                              change: function() {
                                  //$("#test_val").val("").css("display", 2);
                              }
                          });
                          });

                      $(function () {
                          var getData = function (request, response) { 
                              $.getJSON(
                                  "<?php echo base_url('opd/get_duration_vals/'); ?>" + request.term,
                                  function (data) {
                                      response(data);
                                  });
                          };

                          var selectItem = function (event, ui) {
                              $(".duration_val"+<?php echo $l; ?>).val(ui.item.value);
                              return false;
                          }

                          $(".duration_val"+<?php echo $l; ?>).autocomplete({
                              source: getData,
                              select: selectItem,
                              minLength: 1,
                              change: function() {
                                  //$("#test_val").val("").css("display", 2);
                              }
                          });
                          });
                      $(function () {
                          var getData = function (request, response) { 
                              $.getJSON(
                                  "<?php echo base_url('opd/get_frequency_vals/'); ?>" + request.term,
                                  function (data) {
                                      response(data);
                                  });
                          };

                          var selectItem = function (event, ui) {
                              $(".frequency_val"+<?php echo $l; ?>).val(ui.item.value);
                              return false;
                          }

                          $(".frequency_val"+<?php echo $l; ?>).autocomplete({
                              source: getData,
                              select: selectItem,
                              minLength: 1,
                              change: function() {
                                  //$("#test_val").val("").css("display", 2);
                              }
                          });
                          });

                      $(function () {
                          var getData = function (request, response) { 
                              $.getJSON(
                                  "<?php echo base_url('opd/get_advice_vals/'); ?>" + request.term,
                                  function (data) {
                                      response(data);
                                  });
                          };

                          var selectItem = function (event, ui) {
                              $(".advice_val"+<?php echo $l; ?>).val(ui.item.value);
                              return false;
                          }

                          $(".advice_val"+<?php echo $l; ?>).autocomplete({
                              source: getData,
                              select: selectItem,
                              minLength: 1,
                              change: function() {
                                  //$("#test_val").val("").css("display", 2);
                              }
                          });
                          });
                              /* script end*/
                        function delete_prescr_row(r)
                        { 
                            var i = r.parentNode.parentNode.rowIndex;
                            document.getElementById("prescription_name_table").deleteRow(i);
                        }
                        </script>
                        

                                                        
                        <td width="40">
                            <a onclick="delete_prescr_row(this)" href="javascript:void(0)" style="width:50px;" class="btn-w-60">Delete</a>
                        </td>
                    </tr>
                    <?php $l++; } }else{ ?>

                    <tr>
                        <?php
                        foreach ($prescription_medicine_tab_setting as $tab_value) 
                        { 
                        if(strcmp(strtolower($tab_value->setting_name),'medicine')=='0')
                        {
                        ?>
                        <td><input type="text" style="width:100px;" name="medicine_name[]" class="medicine_val"></td>
                        <?php 
                        }
                        if(strcmp(strtolower($tab_value->setting_name),'brand')=='0')
                        {
                        ?>
                        <td><input type="text" style="width:100px;" name="medicine_brand[]" class="" id="brand"></td>
                        <?php 
                        } 

                        if(strcmp(strtolower($tab_value->setting_name),'salt')=='0')
                        {
                        ?>
                        <td><input type="text" style="width:100px;" name="medicine_salt[]" class=""  id="salt"></td>
                        <?php 
                        }

                        if(strcmp(strtolower($tab_value->setting_name),'type')=='0')
                        { ?>
                        <td><input type="text" style="width:100px;" name="medicine_type[]" class="input-small" id="type"></td>
                        <?php 
                        }
                        if(strcmp(strtolower($tab_value->setting_name),'dose')=='0')
                        { ?>
                        <td><input type="text" style="width:100px;" name="medicine_dose[]" class="input-small dosage_val"></td>
                        <?php 
                        } 
                        if(strcmp(strtolower($tab_value->setting_name),'duration')=='0')
                        {  ?>
                        <td><input type="text" style="width:100px;" name="medicine_duration[]" class="medicine-name duration_val"></td>
                        <?php 
                        }
                        if(strcmp(strtolower($tab_value->setting_name),'frequency')=='0')
                        {
                        ?>
                        <td><input type="text" style="width:100px;" name="medicine_frequency[]" class="medicine-name frequency_val"></td>
                        <?php 
                        } 
                        if(strcmp(strtolower($tab_value->setting_name),'advice')=='0')
                        { 
                        ?>
                        <td><input type="text" style="width:100px;" name="medicine_advice[]" class="medicine-name advice_val"></td>
                        <?php } 
                      }
                   ?>
                    <td width="40">
                        <a href="javascript:void(0)" style="width:50px;" class="btn-w-60">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>



                </div>
               </div>
               <!--- Medicine Section ---->
              <?php //} ?>
             <!--- Investigation Section ---->
               <div class="row m-b-5">
                <div class="col-xs-12">

                  <?php if(1==2){ ?>
               <table class="table table-bordered table-striped" id="test_name_table" style="margin-left:-150px;">
                    <thead><tr><th colspan="4">Investigation</th></tr></thead>
              <tbody>
                     <tr>
                      
                      <td>Test Name</td>
                    <td>Date</td>
                    <td>Result</td>
                    
                                                    
                        <td width="80">
                            <a href="javascript:void(0)" class="btn-w-60 addtestrow">Add</a>
                        </td>
                    </tr>

                      <?php 

                      if(!empty($test_list))
                      { 
                           $l=1;
                         //  print_r($prescription_presc_list);die;
                          foreach ($discharge_test_list as $discharge_test) 
                          {
                            
                          ?>
                     <tr>
                       
                        <td><input type="text" name="test_name[]" class="test_val<?php echo $l; ?>" value="<?php echo $discharge_test->test_name; ?>">
                          <input type="hidden" name="test_id[]" class="test_id<?php echo $l; ?>" value="<?php echo $discharge_test->id; ?>">
                        </td>
                        
                        <td><input type="text" name="test_date[]" class="datepicker1<?php echo $l; ?>" value="<?php echo date('d-m-Y',strtotime($discharge_test->test_date)); ?>"></td>
                                              
                        <td><input type="text" name="test_result[]" class="medicine-name result_val<?php echo $l; ?>" value="<?php echo $discharge_test->result; ?>"></td>
                       
                        
                       
                          <script>
                    /* script start */
                      $(function () 
                      {
                            var getData = function (request, response) { 
                              row = <?php echo $l; ?> ;
                              $.ajax({
                              url : "<?php echo base_url('opd/get_test_vals/'); ?>" + request.term,
                              dataType: "json",
                              method: 'post',
                            data: {
                               name_startsWith: request.term,
                               type: 'country_table',
                               row_num : row
                            },
                             success: function( data ) {
                               response( $.map( data, function( item ) {
                                var code = item.split("|");
                                return {
                                  label: code[0],
                                  value: code[0],
                                  data : item
                                }
                              }));
                            }
                            });

                             
                          };

                          var selectItem = function (event, ui) {

                                var names = ui.item.data.split("|");

                                $('.test_val'+<?php echo $l; ?>).val(names[0]);
                                $('.test_id'+<?php echo $l; ?>).val(names[1]);
                                
                              //$(".medicine_val").val(ui.item.value);
                              return false;
                          }

                          $(".test_val"+<?php echo $l; ?>).autocomplete({
                              source: getData,
                              select: selectItem,
                              minLength: 1,
                              change: function() {
                                  //$("#test_val").val("").css("display", 2);
                              }
                          });


                            $('.datepicker1'+<?php echo $l; ?>).datepicker({
                  format: 'dd-mm-yyyy', 
                  autoclose: true 
                });
                          });


                      
                              /* script end*/
                        function delete_test_row(r)
                        { 
                            var i = r.parentNode.parentNode.rowIndex;
                            document.getElementById("test_name_table").deleteRow(i);
                        }
                        </script>
                        

                                                        
                        <td width="80">
                            <a onclick="delete_test_row(this)" href="javascript:void(0)" class="btn-w-60">Delete</a>
                        </td>
                    </tr>
                    <?php $l++; } }else{ ?>

                    <tr>
                       
                        <td><input type="text" name="test_name[]" class="test_val"></td>
                        
                       <input type="hidden" name="test_id[]" class="test_id" value="<?php echo $discharge_test->id; ?>">
                       
                        <td><input type="text" name="test_date[]" class="datepicker1"></td>
                        
                        
                        <td><input type="text" name="test_result[]" class="medicine-name result_val"></td>
                
                    <td width="80">
                        <a href="javascript:void(0)" style="width:50px;" class="btn-w-60">Delete</a>
                    </td>
                </tr>
                <?php } ?>


               
            </tbody>
        </table>

      <?php 
          }
          else 
          { 
            //echo $test_report_data;   
          }

        ?>


                 

               

        </div>
       </div>
              
   </div> <!-- right portion -->

</div>


      <div class="modal-footer r-btn-cntr"> 
         <input type="submit"  class="btn-update " name="submit" value="Save" />
        
         <button type="button" onclick="window.location.href='<?php echo base_url('ipd_advance_discharge_summary_template'); ?>'" class="btn-cancel" data-number="1">Close</button>
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


$("button[data-number=1]").click(function(){
    $('#load_add_ipd_patient_discharge_summary_modal_popup').modal('hide');
});

function get_ipd_patient_discharge_summary()
{
   $.ajax({url: "<?php echo base_url(); ?>ipd_patient_advance_discharge_summary/ipd_patient_discharge_summary_dropdown/", 
    success: function(result)
    {
      $('#ipd_patient_discharge_summary_id').html(result); 
    } 
  });
}

  $('#template_list').change(function(){  
      var template_id = $(this).val();
      $.ajax({url: "<?php echo base_url(); ?>ipd_patient_advance_discharge_summary/get_template_data/"+template_id, 
        success: function(result)
        {
           load_values(result);
        } 
      }); 
  });

  function load_values(jdata)
  {
       var obj = JSON.parse(jdata);

       $('#h_o_presenting').val(obj.h_o_presenting);
       $('#chief_complaints').val(obj.chief_complaints);
       $('#on_examination').val(obj.on_examination);
       $('#vitals_pulse').val(obj.vitals_pulse);
       $('#vitals_chest').val(obj.vitals_chest);
       $('#vitals_bp').val(obj.vitals_bp);
       $('#vitals_cvs').val(obj.vitals_cvs);
       $('#vitals_temp').val(obj.vitals_temp);
       $('#vitals_cns').val(obj.vitals_cns);
       $('#vitals_p_a').val(obj.vitals_p_a);
       $('#provisional_diagnosis').val(obj.provisional_diagnosis);
       $('#final_diagnosis').val(obj.final_diagnosis);
       $('#course_in_hospital').val(obj.course_in_hospital);
       $('#investigations').val(obj.investigations);
       $('#discharge_time_condition').val(obj.discharge_time_condition);
       $('#discharge_advice').val(obj.discharge_advice);
       $('#review_time_date').val(obj.review_time_date);
  };

$(document).ready(function ()
{
  $('.datepicker').datepicker({
    format: 'dd-mm-yyyy', 
    autoclose: true 
  });
 $('.datepicker3').datetimepicker({
     format: 'LT'
  });

});


/******* Add Medicine *************/


$(".addprescriptionrow").click(function(){

  var i=$('#prescription_name_table tr').length;
        $("#prescription_name_table").append('<tr><?php foreach ($prescription_medicine_tab_setting as $tab_value) 
                        { 
                        if(strcmp(strtolower($tab_value->setting_name),'medicine')=='0')
                        {
                        ?><td><input type="text" style="width:100px;" name="medicine_name[]" class="medicine_val'+i+'"></td>                        <?php 
                        }
                       if(strcmp(strtolower($tab_value->setting_name),'brand')=='0')
                        {
                        ?>   <td><input style="width:80px;" type="text" name="medicine_brand[]" id="brand'+i+'"  class="" ></td>                        <?php 
                        } 

                        if(strcmp(strtolower($tab_value->setting_name),'salt')=='0')
                        {
                        ?>  <td><input style="width:80px;" type="text" id="salt'+i+'"  name="medicine_salt[]" class=""  ></td>                        <?php 
                        } 
                        if(strcmp(strtolower($tab_value->setting_name),'type')=='0')
                        { ?>  <td><input style="width:80px;" type="text" id="type'+i+'"  name="medicine_type[]" class="input-small medicine_type_val"></td>                        <?php 
                        }
                        if(strcmp(strtolower($tab_value->setting_name),'dose')=='0')
                        { ?> <td><input  style="width:80px;" type="text" name="medicine_dose[]" class="input-small dosage_val'+i+'"></td>                        <?php 
                        } 
                        if(strcmp(strtolower($tab_value->setting_name),'duration')=='0')
                        {  ?>  <td><input type="text" style="width:80px;" name="medicine_duration[]" class="medicine-name duration_val'+i+'"></td>                        <?php 
                        }
                        if(strcmp(strtolower($tab_value->setting_name),'frequency')=='0')
                        {
                        ?> <td><input style="width:80px;" type="text" name="medicine_frequency[]" class="medicine-name frequency_val'+i+'"></td>                        <?php 
                        } 
                        if(strcmp(strtolower($tab_value->setting_name),'advice')=='0')
                        { 
                        ?>  <td><input style="width:80px;" type="text" name="medicine_advice[]" class="medicine-name advice_val'+i+'"></td>                        <?php 
                        } 
                      } ?><td width="80"><a href="javascript:void(0);" class="btn-w-60 remove_prescription_row" style="width:50px;">Delete</a></td></tr>');
      

      /* script start */
$(function () 
{

      var getData = function (request, response) {  
        row = i;
        $.ajax({
        url : "<?php echo base_url('opd/get_medicine_auto_vals/'); ?>" + request.term,
        dataType: "json",
        method: 'post',
      data: {
         name_startsWith: request.term,
         type: 'country_table',
         row_num : row
      },
       success: function( data ) {
         response( $.map( data, function( item ) {
          var code = item.split("|");
          return {
            label: code[0],
            value: code[0],
            data : item
          }
        }));
      }
      });

       
    };

    var selectItem = function (event, ui) {

          var names = ui.item.data.split("|");

          $('.medicine_val'+i).val(names[0]);
          
        //$(".medicine_val").val(ui.item.value);
        return false;
    }

    $(".medicine_val"+i).autocomplete({
        source: getData,
        select: selectItem,
        minLength: 1,
        change: function() {
            //$("#test_val").val("").css("display", 2);
        }
    });
    });

    });
    $("#prescription_name_table").on('click','.remove_prescription_row',function(){
        $(this).parent().parent().remove();
    });

/******* Medicine *************/


/************** Add Test ***********/
$(".addtestrow").click(function(){

  var i=$('#test_name_table tr').length;
        $("#test_name_table").append('<tr><td><input type="text" name="test_name[]" class="test_val'+i+'"></td><input type="hidden" name="test_id[]" class="test_id'+i+'" ><td><input type="text" name="test_date[]" class="datepicker1'+i+'"></td>                       <td><input type="text" name="test_result[]" class="medicine-name result_val'+i+'"></td>                        <td width="80"><a href="javascript:void(0);" class="btn-w-60 remove_test_row">Delete</a></td></tr>');
      

      /* script start */
$(function () 
{

      var getData = function (request, response) {  
        row = i;
        $.ajax({
        url : "<?php echo base_url('opd/get_test_vals/'); ?>" + request.term,
        dataType: "json",
        method: 'post',
      data: {
         name_startsWith: request.term,
         type: 'country_table',
         row_num : row
      },
       success: function( data ) {
       
         response( $.map( data, function( item ) {
          var code = item.split("|");

          return {
            label: code[0],
            value: code[0],
            data : item
          }
        }));
      }
      });

       
    };

    var selectItem = function (event, ui) {
          var names = ui.item.data.split("|");
          $('.test_val'+i).val(names[0]); 
          $('.test_id'+i).val(names[1]);
        //$(".medicine_val").val(ui.item.value);
        return false;
    }

    $(".test_val"+i).autocomplete({
        source: getData,
        select: selectItem,
        minLength: 1,
        change: function() {
            //$("#test_val").val("").css("display", 2);
        }
    });

    $('.datepicker1'+i).datepicker({
    format: 'dd-mm-yyyy', 
    autoclose: true 
  });
    });

 });
    $("#test_name_table").on('click','.remove_test_row',function(){
        $(this).parent().parent().remove();
    });

    /************** Add Test ***********/


/**********Auto complete ***********/
$(function () 
{
    var i=$('#prescription_name_table tr').length;
      var getData = function (request, response) { 
        row = i ;
        $.ajax({
        url : "<?php echo base_url('opd/get_medicine_auto_vals/'); ?>" + request.term,
        dataType: "json",
        method: 'post',
      data: {
         name_startsWith: request.term,
         type: 'country_table',
         row_num : row
      },
       success: function( data ) {
         response( $.map( data, function( item ) {
          var code = item.split("|");
          return {
            label: code[0],
            value: code[0],
            data : item
          }
        }));
      }
      });

     
    };

    var selectItem = function (event, ui) {

          var names = ui.item.data.split("|");
          $('.medicine_val').val(names[0]);
          $('#type').val(names[1]);
          $('#brand').val(names[2]);
          $('#salt').val(names[3]);
        //$(".medicine_val").val(ui.item.value);
        return false;
    }

    $(".medicine_val").autocomplete({
        source: getData,
        select: selectItem,
        minLength: 1,
        change: function() {
            //$("#test_val").val("").css("display", 2);
        }
    });
    });

/**********Auto complete ***********/


/**********test Auto complete ***********/
$(function () 
{
    var i=$('#test_name_table tr').length;
      var getData = function (request, response) { 
        row = i ;
        $.ajax({
        url : "<?php echo base_url('opd/get_test_vals/'); ?>" + request.term,
        dataType: "json",
        method: 'post',
      data: {
         name_startsWith: request.term,
         type: 'country_table',
         row_num : row
      },
       success: function( data ) {
         response( $.map( data, function( item ) {
          var code = item.split("|");
          return {
            label: code[0],
            value: code[0],
            data : item
          }
        }));
      }
      });

     
    };

    var selectItem = function (event, ui) {

          var names = ui.item.data.split("|");
          $('.test_val').val(names[0]);
           $('.test_id').val(names[1]);
          
        //$(".medicine_val").val(ui.item.value);
        return false;
    }

    $(".test_val").autocomplete({
        source: getData,
        select: selectItem,
        minLength: 1,
        change: function() {
            //$("#test_val").val("").css("display", 2);
        }
    });
    });

/**********Test Auto complete ***********/
</script>  
<script type="text/javascript">
  $('#content, #content1 ,#remarks_d').on('change keyup keydown paste cut', 'textarea', function () {
        $(this).height(70).height(this.scrollHeight);
    }).find('textarea').change();
</script>
</section> <!-- section close -->
<?php
$this->load->view('include/footer');
?>