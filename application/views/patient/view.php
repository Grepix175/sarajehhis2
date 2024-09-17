<?php //print_r($form_data);die; ?>
<div class="modal-dialog modal-lg w-1200px">

  <div class="modal-content">  
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><?php echo $page_title; ?></h4> 
            </div>
      <div class="modal-body">  
        
      <div class="row">
        <div class="col-sm-6">
            <div class="row m-b-5">
              <div class="col-xs-6"><label><?php echo $data= get_setting_value('PATIENT_REG_NO');?></label></div>
              <div class="col-xs-6">
                <?php echo $form_data['patient_code']; ?>
              </div>
            </div>

            

            <div class="row m-b-5">
              <div class="col-xs-6"><label>Patient Category </label></div>
              <div class="col-xs-6">
                <?php echo $form_data['patient_category_name']; ?>
              </div>
            </div>
            
            <div class="row m-b-5">
              <div class="col-xs-6"><label>Patient Name </label></div>
              <div class="col-xs-6">
                <?php echo $form_data['simulation'].' '.$form_data['patient_name']; ?>
              </div>
            </div>

            <div class="row m-b-5">
              <div class="col-xs-6"><label> Mobile No. </label></div>
              <div class="col-xs-6">
                <?php echo $form_data['mobile_no']; ?>
              </div>
            </div>
            <div class="row m-b-5">
              <div class="col-xs-6"><label>Email </label></div>
              <div class="col-xs-6">
                <?php echo $form_data['patient_email']; ?>
              </div>
            </div>
            <div class="row m-b-5">
              <div class="col-xs-6"><label>Gender </label></div>
              <div class="col-xs-6">
                <?php 
                    $gender = array('0'=>'Female','1'=>'Male','2'=>'Others');
                    echo $gender[$form_data['gender']]; 
                   ?>
              </div>
            </div>
            
            <div class="row m-b-5">
              <div class="col-xs-6"><label> Aadhaar No. </label></div>
              <div class="col-xs-6">
                <?php echo $form_data['adhar_no']; ?>
              </div>
            </div>
            
            <div class="row">
              <div class="col-xs-6"><label>Age </label></div>
              <div class="col-xs-6">
                <?php 
                    $age = "";
                    if($form_data['age_y']>0)
                    {
                      $year = 'Years';
                      if($form_data['age_y']==1)
                      {
                        $year = 'Year';
                      }
                      $age .= $form_data['age_y']." ,".$year;
                    }
                    if($form_data['age_m']>0)
                    {
                      $month = 'Months';
                      if($form_data['age_m']==1)
                      {
                        $month = 'Month';
                      }
                      $age .= " ".$form_data['age_m']." ".$month;
                    }
                    if($form_data['age_d']>0)
                    {
                      $day = 'Days';
                      if($form_data['age_d']==1)
                      {
                        $day = 'Day';
                      }
                      $age .= ", ".$form_data['age_d']." ".$day;
                    }
                    if($form_data['age_h']>0)
                    {
                      $hours = 'Hours';
                      $age .= ", ".$form_data['age_h']." ".$hours;
                    }
                    echo $age; 
                  ?> 
              </div>
            </div>

            

            <div class="row m-b-5">
              <div class="col-xs-6"><label> Village/Town </label></div>
              <div class="col-xs-6">
                <?php echo $form_data['address']; ?>
              </div>
            </div>
            <div class="row m-b-5">
              <div class="col-xs-6"><label> Dist./Taluk/Thana </label></div>
              <div class="col-xs-6">
                <?php echo $form_data['address2']; ?>
              </div>
            </div>
           

            <div class="row m-b-5">
              <div class="col-xs-6"><label> State </label></div>
              <div class="col-xs-6">
                <?php echo ucfirst(strtolower($form_data['state'])); ?> 
              </div>
            </div>

           
           

            

            
            <?php if($form_data['dob']!='1970-01-01' && $form_data['dob']!='0000-00-00'){ ?>
            <div class="row m-b-5">
              <div class="col-xs-6"><label>DOB</label></div>
              <div class="col-xs-6">
                <?php echo date('d-m-Y',strtotime($form_data['dob'])); ?>
              </div>
            </div>
            <?php } ?>
            
             <div class="row m-b-5">
              <div class="col-xs-6"><label> <?php echo $form_data['relation']; ?></label></div>
              <div class="col-xs-6">
                <?php if(!empty($form_data['relation_name'])){ echo $form_data['rel_simulation'].' '.$form_data['relation_name']; } ?>
              </div>
            </div>

            
     
           


        </div> <!-- 4 -->



         <!-- 4 -->



        <div class="col-sm-6">

            <div class="row m-b-5">
              <div class="col-xs-12 text-center"><label>Patient Photo</label></div>
                <?php
                   $img_path  = $file_img = base_url('assets/images/photo.png');
                   if(!empty($form_data['photo']) && file_exists(DIR_UPLOAD_PATH.'patients/'.$form_data['photo']))
                      {
                        $img_path = ROOT_UPLOADS_PATH.'patients/'.$form_data['photo'];
                      }  
                  ?>
                  
            </div>

            <div class="row m-b-5">
              <div class="col-xs-12 text-center"><img src="<?php echo $img_path; ?>" width="100px"></div>
            </div>

            <!--  -->
          
        </div> <!-- 4 -->
      </div> <!-- row -->






           
          
      </div>     
             
             
        <div class="modal-footer">  
           <button type="button" class="btn-cancel" data-dismiss="modal">Close</button>
        </div> 
 
        </div><!-- /.modal-content -->
<script>
function comission(ids)
{ 
  var $modal = $('#load_add_comission_modal_popup');
  $modal.load('<?php echo base_url().'doctors/view_comission/' ?>',
  {
    //'id1': '1',
    'id': ids
    },
  function(){
  $modal.modal('show');
  });
} 
</script>        
<div id="load_add_comission_modal_popup" class="modal fade modal-top" role="dialog" data-backdrop="static" data-keyboard="false"></div>     
</div><!-- /.modal-dialog -->