<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pathology_appointment extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        ob_start();
        auth_users();
         
        $this->load->model('test/pathology_appointment_model','test');
        $this->load->library('form_validation');
        $this->load->helper('cookie');
    }
    public function index()
    {   
        unauthorise_permission(145,871);
        $data['branch_list'] = $this->session->userdata('sub_branches_data');
        $this->session->unset_userdata('advance_result');
        $users_data = $this->session->userdata('auth_users');
        $this->session->set_userdata('complation_status',-1);
        //echo '<pre>'; print_r($users_data);
        $search_date = $this->session->userdata('search_booking_date');
        $this->session->unset_userdata('set_profile');
        $this->session->unset_userdata('booking_set_branch');
        $this->session->unset_userdata('booking_doctor_type'); 
        $this->session->unset_userdata('test_panel_rate'); 
        // Default Search Setting
        $this->load->model('default_search_setting/default_search_setting_model'); 
        $default_search_data = $this->default_search_setting_model->get_default_setting();
        if(isset($default_search_data[1]) && !empty($default_search_data) && $default_search_data[1]==1)
        {
            $start_date = '';
            $end_date = '';
        }
        else
        {
            $start_date = date('d-m-Y');
            $end_date = date('d-m-Y');
        }
        // End Defaul Search
        $data['form_data'] = array('start_date'=>$start_date, 'end_date'=>$end_date,'referred_by'=>'0');
        if(isset($search_date) && !empty($search_date))
        {
           $data['form_data'] = array('start_date'=>$search_date['start_date'], 'end_date'=>$search_date['end_date'],'referred_by'=>'0');
        }
        $data['page_title'] = 'Test Appointment List'; 
        $this->load->view('pathology_appointment/list',$data);
    }

    public function ajax_list()
    {     
          unauthorise_permission(145,871);
          $this->session->unset_userdata('book_test');
          $this->session->unset_userdata('set_profile');
          $users_data = $this->session->userdata('auth_users');
         $print_value=$this->test->get_print_value($users_data['parent_id']);
        	$this->session->set_userdata('letter_print');
          $list = $this->test->get_datatables();
         //print '<pre>'; print_r($users_data);die;
          $data = array();
          $no = $_POST['start'];
          $i = 1;
          $total_num = count($list);
          foreach ($list as $test) {
               //$result_times='';
               // print_r($test);die;
               $no++;
               $row = array(); 
               //$result_times="'".$test->result_prefix.' '.$test->result_time."'";
               ////////// Check  List /////////////////
               $check_script = "";
               $times='';
               if($i==$total_num){
                    $check_script = "<script>$('#selectAll').on('click', function () { 
                                  if ($(this).hasClass('allChecked')) {
                                      $('.checklist').prop('checked', false);
                                  } else {
                                      $('.checklist').prop('checked', true);
                                  }
                                  $(this).toggleClass('allChecked');
                              });                                                         
                        </script>";
               } 

               /*$times="<script>
                               var countDownDate".$test->id." = new Date(".$result_times.").getTime();
                               var x".$test->id." = setInterval(function() {
                               var now".$test->id." = new Date().getTime();
                               var distance".$test->id." = countDownDate".$test->id." - now".$test->id.";
                               var minutes".$test->id." = Math.floor((distance".$test->id." % (1000 * 60 * 60)) / (1000 * 60));
                               var seconds".$test->id." = Math.floor((distance".$test->id." % (1000 * 60)) / 1000);
                              if (distance".$test->id." < 900000 && distance".$test->id.">0) {
                                $('#countdown".$test->id."').html(minutes".$test->id."+':'+seconds".$test->id.");
                              } 
                              else{
                                 $('#countdown".$test->id."').html('');
                              }                         
                            }, 1000);                            
                        </script>";      */          
               ////////// Check list end ///////////// 
               //check for child branches test list permission
               if($users_data['users_role']!=4 && $users_data['parent_id']==$test->branch_id)
               {
                   $row[] = '<input type="checkbox" name="employee[]" class="checklist" value="'.$test->id.'">'.$check_script; 
               }
               else
               {
                         $row[]=' ';
               }
               
               if($test->delivered_status==1)
               {
                   $report_status = '<font class="bg_delivered" >Delivered</font><script> $(".bg_delivered").closest("tr").addClass("btn_delivered");</script>';
               }
               else if($test->verify_status==1)
               {
                 $report_status = '<font class="bg_verified" >Verified</font><script> $(".bg_verified").closest("tr").addClass("btn_verified");</script>';
               }
               else if($test->complation_status==1)
               {
                 $report_status = '<font class="bg_completed" >Completed</font><script> $(".bg_completed").closest("tr").addClass("btn_completed");</script>';
               }
               else if($test->complation_status==0)
               {
                 $report_status = '<font class="bg_pending" >Pending</font><script> $(".bg_pending").closest("tr").addClass("btn_pending");</script>';
               }
 
               $relation_name = '';
               if(!empty($test->relation_name))
               {
                  $relation_name = $test->patient_relation." ".$test->relation_name;
               }
                $blink='';
                if($test->complation_status=='0')
                {
                   $blink=" <mark class='blink_text' id='countdown".$test->id."'></mark>";
                } 
                else{
                  $blink="";
                } 

               $row[] = $test->patient_code; 
               $row[] = $test->lab_reg_no;
               $row[] = $test->patient_name;
               $row[] = $test->department;  
               
               $row[] = $test->mobile_no;
               $row[] = $test->token_no;
               $row[] = $test->ins_type;
               $row[] = $test->insurance_type;
               $row[] = $test->insurance_company;

               $row[] = $test->polocy_no;
               $row[] = $test->tpa_id;
               $row[] = $test->ins_amount;
               $row[] = $test->ins_authorization_no;
               $row[] = $test->patient_gender; 
                ///////////// Age calculation //////////
                $age_y = $test->age_y;
                $age_m = $test->age_m;
                $age_d = $test->age_d;
                $age_h = $test->age_h;
                $age = "";
                if($age_y>0)
                {
                $year = 'Years';
                if($age_y==1)
                {
                  $year = 'Year';
                }
                $age .= $age_y." ".$year;
                }
                if($age_m>0)
                {
                $month = 'Months';
                if($age_m==1)
                {
                  $month = 'Month';
                }
                $age .= ", ".$age_m." ".$month;
                }
                if($age_d>0)
                {
                $day = 'Days';
                if($age_d==1)
                {
                  $day = 'Day';
                }
                $age .= ", ".$age_d." ".$day;
                }
                if($age_h>0)
                {
                $hours = 'Hours';
                
                $age .= " ".$age_h." ".$hours;
                } 
               ///////////////////////////////////////
               $row[] = $age; 
               $row[] = trim($test->patient_address,', ,');
               $row[] = $test->path_form_f;
               $row[] = $test->tube_no;

               $row[] = $test->doctor_hospital_name;
               $row[] = $test->sample_collected;
               $row[] = $test->staff_reference;
               $row[] = date('d M Y',strtotime($test->booking_date));
               $row[] = $test->remarks;
               $row[] = $test->payment_mode;
               $row[] = $test->total_amount;
               $row[] = $test->home_collection_amount;
               $row[] = $test->discount;
               $row[] = $test->net_amount;
               $row[] = $test->paid_amount; 
               if($test->doctor_pay_type==2)
               {
                 $row[] = '0.00'; 
               }
               else
               {
                 $row[] = $test->balance; 
               } 
               $row[] = $test->created_name;
			   $row[] = $relation_name;
			   $row[] = $test->patient_email;
               $row[] = $report_status; 
               //Action button /////
              $btn_edit = ""; 
              $btn_delete = ""; 
              $btn_report_fill = ""; 
              $btn_report_print = "";
              $btn_report_download = "";

              $btn_print_bill =""; 
              $btn_delivered = "";
              $btn_sample_collected="";
              $btn_sample_recieved="";
              $print_report_config = get_setting_value('PATHOLOGY_REPORT_PRINT');

              /* for check dept avilable or not */
              $result_dept = $this->test->get_dept_common_data($test->id);
              //print_r($result_dept);
              /* for check dept avilable or not */
               // if($users_data['parent_id']==$test->branch_id)
               //{
           if(in_array('873',$users_data['permission']['action']))
           {
             if($test->complation_status==1)
             {
                if($users_data['emp_id']==0)
                {
                   //$btn_edit = ' <a class="btn-custom" href="'.base_url("test/edit_booking/".$test->id).'" title="Edit"><i class="fa fa-pencil"></i> Edit</a>';
                   $btn_edit = '<a href="javascript:void(0)" class="btn-custom" onClick="return edit_test('.$test->id.')"  title="Edit" ><i class="fa fa-pencil"></i> Edit </a>';
                }
              
             }
             else if($test->complation_status==0)
             {
               
                   $btn_edit = ' <a class="btn-custom" href="'.base_url("pathology_appointment/edit_booking/".$test->id).'" title="Edit"><i class="fa fa-pencil"></i> Edit</a>';
             } 
             
             
               
          }
          
          
          
        
         
           $print_url = "'".base_url('pathology_appointment/print_test_booking_report/').$test->id."'";
            $btn_print_bill = '<li><a href="javascript:void(0)" onclick = "return print_window_page('.$print_url.');" title="Print Bill" ><i class="fa fa-print"></i> Print Bill </a></li>';
         
              
          
          // End Action Button //
               
          $btn_a = '<div class="slidedown">
            <button disabled class="btn-custom">More <span class="caret"></span></button>
              <ul class="slidedown-content">
              '.$btn_delete.$btn_report_fill.$btn_report_print.$btn_report_download.$btn_print_bill.$btn_delivered.'
            </ul>
          </div> ';

               $row[] = $btn_edit.$btn_sample_collected.$btn_sample_recieved.$btn_a;   
               $data[] = $row;
               $i++;
          }
          $output = array(
               "draw" => $_POST['draw'],
               "recordsTotal" => $this->test->count_all(),
               "recordsFiltered" => $this->test->count_filtered(),
               "data" => $data,
          );
          //output to json format
          echo json_encode($output);
     }
     
    public function search_date()
    {

       $post = $this->input->post();



       if(!empty($post))
       {
          if(isset($post['referred_by']))
          {
            $data['selected_data'] =array("referred_by"=>'1');
          }
          else
          {
            $data['selected_data'] = array("referred_by"=>'0');
          }
          $marge_post = array_merge($data['selected_data'],$post);
          

         $this->session->set_userdata('search_booking_date',$marge_post);
       }
    }

    public function reset_date_search()
    {
       $this->session->unset_userdata('search_booking_date');
    }

    public function advance_search()
    {
        $this->load->model('general/general_model'); 
        $data['page_title'] = "Advance Search";
        $post = $this->input->post();
        $data['country_list'] = $this->general_model->country_list();
        $data['simulation_list'] = $this->general_model->simulation_list(); 
        $data['referal_doctor_list'] = $this->test->referal_doctor_list();
        $data['attended_doctor_list'] = $this->test->attended_doctor_list();    
        $search_data = $this->session->userdata('search_booking_date');
        $data['referal_hospital_list'] = $this->general_model->referal_hospital_list();
        $data['doctors_list']= $this->general_model->doctors_list();
        
        if(isset($search_data) && !empty($search_data))
        {
          $gender = "";
          if(isset($search_data['gender']))
          {
            $gender = $search_data['gender'];
          }
          $bar_code="";
          if(isset($search_data['bar_code']))
          {
            $bar_code = $search_data['bar_code'];
          }
          $tube_no="";
          if(isset($search_data['tube_no']))
          {
          $tube_no = $search_data['tube_no'];
          }

          $mobile_no = "";
          if(isset($search_data['mobile_no']))
          {
            $mobile_no = $search_data['mobile_no'];
          }
          $simulation_id = "";
          if(isset($search_data['simulation_id']))
          {
            $simulation_id = $search_data['simulation_id'];
          }
          $patient_name = "";
          if(isset($search_data['patient_name']))
          {
            $patient_name = $search_data['patient_name'];
          }
          $patient_code = "";
          if(isset($search_data['patient_code']))
          {
            $patient_code = $search_data['patient_code'];
          }
          $age_to = "";
          if(isset($search_data['age_to']))
          {
            $age_to = $search_data['age_to'];
          }
          $age_from = "";
          if(isset($search_data['age_from']))
          {
            $age_from = $search_data['age_from'];
          }
          $lab_reg_no = "";
          if(isset($search_data['lab_reg_no']))
          {
            $lab_reg_no = $search_data['lab_reg_no'];
          }
          $city_id = "";
          if(isset($search_data['city_id']))
          {
            $city_id = $search_data['city_id'];
          }
          $state_id='';
          if(isset($search_data['state_id']))
          {
            $state_id = $search_data['state_id'];
          }
          $country_id='';
          if(isset($search_data['country_id']))
          {
            $country_id = $search_data['country_id'];
          }
          $pincode='';
          if(isset($search_data['pincode']))
          {
            $pincode = $search_data['pincode'];
          }
          $referral_doctor='';
          if(isset($search_data['referral_doctor']))
          {
            $referral_doctor = $search_data['referral_doctor'];
          }
          $attended_doctor='';
          if(isset($search_data['attended_doctor']))
          {
            $attended_doctor = $search_data['attended_doctor'];
          }

          $complation_status='';
          if(isset($search_data['complation_status']))
          {
            $complation_status = $search_data['complation_status'];
          }

           if(isset($search_data['referred_by']) && !empty($search_data['referred_by']))
           {
              $referred_by = $search_data['referred_by'];
           }
           else
           {
             $referred_by='0';
           }
            if(isset($search_data['referral_hospital']) && !empty($search_data['referral_hospital']))
           {
              $referral_hospital = $search_data['referral_hospital'];
           }
           else
           {
             $referral_hospital='';
           }
            if(isset($search_data['refered_id']) && !empty($search_data['refered_id']))
           {
              $refered_id = $search_data['refered_id'];
           }
           else
           {
            $refered_id='';
           }


          $data['form_data'] = array(
                                    "start_date"=>$search_data['start_date'],
                                    "end_date"=>$search_data['end_date'],
                                    "bar_code"=>$bar_code,
                                    "tube_no"=>$tube_no,
                                    "patient_code"=>$patient_code, 
                                    "patient_name"=>$patient_name,
                                    "simulation_id"=>$simulation_id,
                                    "mobile_no"=>$mobile_no,
                                    "gender"=>$gender,
                                    "age_to"=>$age_to,
                                    "age_from"=>$age_from, 
                                    "lab_reg_no"=>$lab_reg_no, 
                                    "city_id"=>$city_id,
                                    "state_id"=>$state_id,
                                    "country_id"=>$country_id,
                                    "pincode"=>$pincode, 
                                    "referral_doctor"=>$referral_doctor,
                                    "attended_doctor"=>$attended_doctor,
                                    'complation_status'=>$complation_status,
                                    'referred_by'=>$referred_by,
                                    'referral_hospital'=>$referral_hospital,

                                    'refered_id'=>$refered_id,
                                  );
        }
        else
        {
          $data['form_data'] = array(
                                    "start_date"=>"",
                                    "end_date"=>"",
                                    "bar_code"=>"",
                                    "tube_no"=>"",
                                    "patient_code"=>"", 
                                    "patient_name"=>"",
                                    "simulation_id"=>"",
                                    "mobile_no"=>"",
                                    "gender"=>"",
                                    "age_to"=>"",
                                    "age_from"=>"", 
                                    "lab_reg_no"=>"", 
                                    "city_id"=>"",
                                    "state_id"=>"",
                                    "country_id"=>"99",
                                    "pincode"=>"", 
                                    "referral_doctor"=>"",
                                    "attended_doctor"=>"",
                                    'complation_status'=>'',
                                    "referred_by"=>"",
                                    "refered_id"=>"",
                                    "referral_hospital"=>"",
                                  );
        }
        
        if(isset($post) && !empty($post))
        {
            $this->session->set_userdata('test_search', $post);
        }
        $test_search = $this->session->userdata('test_search');
        if(isset($test_search) && !empty($test_search))
        {
            $data['form_data'] = $test_search;
        }
        $this->load->view('pathology_appointment/advance_search',$data);
    }

    public function booking($pid="",$ipd_id='')
    {  
      //$this->output->enable_profiler(TRUE);
        unauthorise_permission(145,872);
        $users_data = $this->session->userdata('auth_users');
        $this->load->model('general/general_model');  
        $data['payment_mode']=$this->general_model->payment_mode();
        $post = $this->input->post();
        $patient_id = "";
        $patient_code = "";
        $simulation_id = "";
        $patient_name = "";
        $patient_email = "";
        $mobile_no = "";
        $gender = "";
        $age_y = "";
        $age_m = "";
        $age_d = "";
        $age_h = "";
        $city_id = "";
        $state_id = "";
        $country_id = "99"; 
        $balance_amount = '0.00';
        $barcode_image='';
        $barcode_text='';
        $referred_by='';
        $referred_by='';
        $referral_hospital='';
        $insurance_type='';
        $insurance_type_id='';
        $ins_company_id='';
        $polocy_no='';
        $tpa_id='';
        $ins_amount='';
        $ins_authorization_no='';
        $address="";
        $address_second="";
        $address_third="";
        $relation_type='';
        $relation_name='';
        $relation_simulation_id='';
        $booking_time=date('H:i A');

        if($pid>0)
        {
           $balance_amount = $this->test->check_patient_balance($pid); 
           $this->load->model('patient/patient_model');
           $patient_data = $this->patient_model->get_by_id($pid);
           if(!empty($patient_data))
           {
              $patient_id = $patient_data['id'];
              $patient_code = $patient_data['patient_code'];
              $simulation_id = $patient_data['simulation_id'];
              $patient_name = $patient_data['patient_name'];
              $patient_email = $patient_data['patient_email'];
              $mobile_no = $patient_data['mobile_no'];
              $gender = $patient_data['gender'];
              $age_y = $patient_data['age_y'];
              $age_m = $patient_data['age_m'];
              $age_d = $patient_data['age_d'];
              $age_h = $patient_data['age_h'];
              
              if($patient_data['dob']=='1970-01-01' || $patient_data['dob']=="0000-00-00")
              {
                $dob ='';
                if($patient_data['dob']!='0000-00-00' && $patient_data['dob']!='1970-01-01')
                {
                    $dob = date('d-m-Y',strtotime($patient_data['dob']));
                }
                $present_age = get_patient_present_age($dob,$patient_data);
                //print_r($present_age);
                $age_y = $present_age['age_y'];
                $age_m = $present_age['age_m'];
                $age_d = $present_age['age_d'];
                if(!empty($present_age['age_h']))
                {
                  $age_h = $present_age['age_h'];
                }
                else
                {
                  $age_h = '0';
                }
                
                //echo "<pre>"; print_r($present_age);
              }
              else
              {
                $dob=date('d-m-Y',strtotime($patient_data['dob']));
                $present_age = get_patient_present_age($patient_data['dob']); 
                $age_y = $present_age['age_y'];
                $age_m = $present_age['age_m'];
                $age_d = $present_age['age_d'];
                $age_h = $present_age['age_h'];
              }
              $address = $patient_data['address'];
              $address_second = $patient_data['address2'];
              $address_third = $patient_data['address3'];
              $city_id = $patient_data['city_id'];
              $state_id = $patient_data['state_id'];
              $country_id = $patient_data['country_id']; 
              $insurance_type=$patient_data['insurance_type'];
              $insurance_type_id=$patient_data['insurance_type_id'];
              $ins_company_id=$patient_data['ins_company_id'];
              $polocy_no=$patient_data['polocy_no'];
              $tpa_id=$patient_data['tpa_id'];
              $ins_amount=$patient_data['ins_amount'];
              $ins_authorization_no=$patient_data['ins_authorization_no']; 
              $relation_type=$patient_data['relation_type']; 
              $relation_name=$patient_data['relation_name']; 
              $relation_simulation_id=$patient_data['relation_simulation_id']; 
           }
        }
        $data['country_list'] = $this->general_model->country_list();
        $data['simulation_list'] = $this->general_model->simulation_list();
        $data['referal_doctor_list'] = $this->test->referal_doctor_list();
        $data['attended_doctor_list'] = $this->test->attended_doctor_list();
        $data['employee_list'] = $this->test->employee_list();
        $data['profile_list'] = $this->test->profile_list();
        $data['gardian_relation_list'] = $this->general_model->gardian_relation_list();

        // Added on 05-Feb-2018 for home collection
           $data['home_collection']=$this->test->get_home_collection_data();
        // Added on 05-Feb-2018 for home collection

        //$data['dept_list'] = $this->general_model->department_list(5);
        if(!empty($post['branch_id']))
        {
          $data['dept_list'] = $this->general_model->active_department_list(5,$post['branch_id']);
        }
        else
        {
          $data['dept_list'] = $this->general_model->active_department_list(5);
        }
         if(!empty($post['branch_id']))
        {
          $data['insurance_type_list'] = $this->general_model->insurance_type_list($post['branch_id']);
        }
        else
        {
          $data['insurance_type_list'] = $this->general_model->insurance_type_list();  
        }
        if(!empty($post['branch_id']))
        {
        $data['insurance_company_list'] = $this->general_model->insurance_company_list($post['branch_id']);
        }
        else
        {
          $data['insurance_company_list'] = $this->general_model->insurance_company_list(); 
        }

        $data['referal_hospital_list'] = $this->test->referal_hospital_list(); 
        $data['page_title'] = "Test Booking";  
        $booking_list = $this->session->userdata('book_test');
        if(!empty($booking_list))
        { 
          $test_ids_arr = array_keys($booking_list);
          $test_ids = implode(',', $test_ids_arr);
          $data['booked_test_list'] = $this->test->test_list($test_ids);
        }
        
        $post = $this->input->post();
        if(empty($pid))
        {
          $patient_code = generate_unique_id(4);
        }
        
       // $lab_reg_no = generate_unique_id(26);
          $lab_reg_no = '';
        $users_data = $this->session->userdata('auth_users'); 
        $booking_set_branch = $this->session->userdata('booking_set_branch'); 
        if(isset($booking_set_branch) && !empty($booking_set_branch))
        {
           $branch_id = $booking_set_branch;
        }
        else
        {
           $branch_id = $users_data['parent_id'];
        }

        $data['form_error'] = []; 
        $data['form_data'] = array(
                                  'data_id'=>"", 
                                  'branch_id'=>$branch_id, 
                                  'profile_id'=>"", 
                                  'patient_id'=>$patient_id,
                                  'patient_code'=>$patient_code,
                                  'lab_reg_no'=>$lab_reg_no,
                                  'pannel_type'=>0,
                                  'simulation_id'=>$simulation_id,
                                  'patient_name'=>$patient_name,
                                  'patient_email'=>$patient_email,
                                  'mobile_no'=>$mobile_no,
                                  'gender'=>$gender,
                                  'age_y'=>$age_y,
                                  'age_m'=>$age_m,
                                  'age_d'=>$age_d,
                                  'age_h'=>$age_h,
                                  'dept_id'=>"",
                                  'address'=>$address,
                                  "address_second"=>$address_second,
                                  "address_third"=>$address_third,
                                  "relation_type"=>$relation_type,
                                  "relation_name"=>$relation_name,
                                  "relation_simulation_id"=>$relation_simulation_id,
                                  'city_id'=>$city_id,
                                  'state_id'=>$state_id,
                                  'country_id'=>$country_id,
                                  'field_name'=>'',
                                  'referral_doctor'=>"",
                                  'referral_hospital'=>"",
                                  'payment_mode'=>"1",
                                  'form_f'=>'2',
                                  'tube_no'=>'',
                                  //'transaction_no'=>"",
                                  //'bank_name'=>"",
                                  'remarks'=>'',
                                  //'cheque_no'=>"",
                                  //'cheque_date'=>date('d-m-Y'),
                                  //'card_no'=>"",
                                  'attended_doctor'=>"",
                                  'sample_collected_by'=>"",
                                  'staff_refrenace_id'=>"",
                                  'booking_date'=>date('d-m-Y'),  
                                  'total_amount'=>"0.00",
                                  'net_amount'=>"0.00",
                                  'paid_amount'=>"0.00",
                                  'discount'=>"0.00",
                                  'profile_price'=>'0.00',
                                  'balance'=>$balance_amount,
                                  'ipd_id'=>$ipd_id,
                                  "insurance_type"=>$insurance_type,
                                  "insurance_type_id"=>$insurance_type_id,
                                  "ins_company_id"=>$ins_company_id,
                                  "polocy_no"=>$polocy_no,
                                  "tpa_id"=>$tpa_id,
                                  "ins_amount"=>$ins_amount,
                                  "ins_authorization_no"=>$ins_authorization_no,
                                  'referred_by'=>'',
                                  'referral_hospital'=>'',
                                  'ref_by_other'=>'',
                                  'booking_time'=>date('h:i A'),
                                  );     
        if(isset($post) && !empty($post))
        {
           // print_r($post);die;

            if(!empty($post['dept_id']))
            {
              $data['head_list'] = $this->test->test_head_list($post['dept_id']);
            }
            $data['form_data'] = $this->_validate();

            if($this->form_validation->run() == TRUE)
            {
                $booking_id = $this->test->save();
                ////////// Send SMS /////////////////////
                if(in_array('640',$users_data['permission']['action']))
                {
                  
                      
                  if(!empty($post['mobile_no']))
                  { 
                      //echo $booking_id; exit;
                    send_sms('test_booking',22,'',$post['mobile_no'],array('{patient_name}'=>$post['patient_name'],'{amount}'=>$post['net_amount'],'{booking_no}'=>$post['lab_reg_no'], '{booking_date}'=>$post['booking_date']));  
                  }
                }
                //////////////////////////////////////////
                ////////// SEND EMAIL ///////////////////
                if(in_array('641',$users_data['permission']['action']))
                {
                  if(!empty($post['patient_email']))
                  { 
                    $this->load->library('general_library'); 
                    $this->general_library->email($post['patient_email'],'','','','','','test_booking','22',array('{patient_name}'=>$post['patient_name'],'{amount}'=>$post['net_amount'],'{booking_no}'=>$post['lab_reg_no'],'{booking_date}'=>$post['booking_date'])); 
                  }
                }
                
                ////////////////////////////////////////



                ////////////////////
                
                /*$this->load->library('general_library');
                ////// Patient credentails 
                $this->load->model('email_template/Email_template_model','email_template');
                $email_type='3';
                $email_template = $this->email_template->get_email_template($email_type);
                        //print_r($email_template);die;
                if(!empty($email_template))
                {
                  $subject = $email_template[0]->subject;
                  $link = base_url();
                            $company_data = $this->session->userdata('company_data'); 
                  $search = array("{name}","{company_name}","{username}","{password}","{url}");
                  $patient_id = $this->session->userdata('booking_patient_id');
                  $relaced = array($post['patient_name'], $company_data['branch_name'], 'PAT000'.$patient_id, 'PASS'.$patient_id,$link);
                  $this->session->unset_userdata('booking_patient_id');
                  $message=str_replace($search,$relaced,$email_template[0]->message);
                
                  $this->general_library->email($post['patient_email'],$subject,$message);   
                }*/
                ///////////////////////////
                //////////////////////
                $this->session->set_userdata('test_booking_id',$booking_id);
                $this->session->set_flashdata('success','Test booking successfully booked.');
                redirect(base_url('pathology_appointment/booking/?status=print&form_f_status='.$_POST['form_f'].''));

                //redirect(base_url('test'));
                
            }
            else
            {
                $data['form_error'] = validation_errors();
                
            }     
        }
       $this->load->view('pathology_appointment/booking',$data);       
    }
    public function get_referrel_doctor_list(){
       $referal_doctor_list = $this->test->referal_doctor_list();
       $referal_doctor="<option>Select Referred Doctors</option>";
       if(!empty($referal_doctor_list)){
          foreach($referal_doctor_list as $referal_doctors)
          {
               $referal_doctor .= '<option value="'.$referal_doctors->id.'">'.$referal_doctors->doctor_name.'</option>';
          }
       }
       echo $referal_doctor;
    }
    public function edit_booking($id="")
    { 
       unauthorise_permission(145,873);
      if(isset($id) && !empty($id) && is_numeric($id))
      {      
        $this->load->model('general/general_model'); 
        $post = $this->input->post();
        $result = $this->test->get_by_id($id); 
        $this->session->set_userdata('booking_set_branch', $result['branch_id']);
        $data['country_list'] = $this->general_model->country_list();
        $data['simulation_list'] = $this->general_model->simulation_list($result['branch_id']);
        $data['referal_doctor_list'] = $this->test->referal_doctor_list($result['branch_id']);
        $data['attended_doctor_list'] = $this->test->attended_doctor_list($result['branch_id']);
        $data['employee_list'] = $this->test->employee_list($result['branch_id']);
        $data['profile_list'] = $this->test->profile_list($result['branch_id']);
        $booked_profile_list = $this->test->get_booking_profile($id);
        //$data['dept_list'] = $this->general_model->department_list(5);
        $data['dept_list'] = $this->general_model->active_department_list(5); 
        $data['referal_hospital_list'] = $this->test->referal_hospital_list();
         $data['gardian_relation_list'] = $this->general_model->gardian_relation_list(); 
        $booked_test_list = $this->test->get_booked_test_list($id); 
        //print_r($booked_test_list);die;
        $data['page_title'] = "Test Booking";  
        $booking_list = $this->session->userdata('book_test');
         // Added on 05-Feb-2018 for home collection
           $data['home_collection']=$this->test->get_home_collection_data();
        // Added on 05-Feb-2018 for home collection
        $data['payment_mode']=$this->general_model->payment_mode();
        $get_payment_detail= $this->test->payment_mode_detail_according_to_field($result['payment_mode'],$id);
        $total_values='';
        for($i=0;$i<count($get_payment_detail);$i++) {
        $total_values[]= $get_payment_detail[$i]->field_value.'_'.$get_payment_detail[$i]->field_name.'_'.$get_payment_detail[$i]->field_id;

        }
        //echo "<pre>";print_r($booking_list);die;
        if(!isset($booking_list))
        {  
            $this->session->set_userdata('book_test',$booked_test_list);
        }
        $booking_list = $this->session->userdata('book_test');
        if(!empty($booking_list))
        { 
          $booking_ids_arr = array_keys($booking_list);
          $test_ids = implode(',', $booking_ids_arr); 
          $data['booked_test_list'] = $this->test->test_list($test_ids, $result['branch_id']);
        }
        //echo "<pre>";print_r($booked_profile_list);die;
        ////// Set Test Profile ////////
        $profile_print_status = get_profile_print_status('test_booking');
        $profile_status = $profile_print_status->profile_status;
        $print_status = $profile_print_status->print_status;

        $profile_price = '0.00';
        if($booked_profile_list && empty($post['data_id']))
        {
            $p_i=1;
            $total_test = 1;
            if(!empty($booking_list))
            {
              $total_test = count($booking_list);
            } 
           foreach($booked_profile_list as $booked_profile)
           {


            if($profile_status==1 && $print_status==1)
            {
              if(!empty($booked_profile->print_name))
              {
                $profile_name = $booked_profile->profile_name.' ('.$booked_profile->print_name.')';
              }
              else
              {
                $profile_name = $booked_profile->profile_name;
              }
            }
            elseif($profile_status==1 && $print_status==0)
            {
              $profile_name = $booked_profile->profile_name;
            }
            elseif($profile_status==0 && $print_status==1)
            {
            if(!empty($booked_profile->print_name))
            {
              $profile_name = $booked_profile->print_name;
            }
            else
            {
              $profile_name = $booked_profile->profile_name;
            }

            }
            elseif($profile_status==0 && $print_status==0)
            {
              $profile_name = $booked_profile->profile_name;
            }             


$profile_arr[$booked_profile->profile_id] = array('id'=>$booked_profile->profile_id, 'name'=>$profile_name, 'order'=>$total_test+$p_i, 'price'=>$booked_profile->master_price,'base_price'=>$booked_profile->base_price);
             $p_i++;
           }
		   
		  // print_r($profile_arr);
           /*$profile_price = 0;
           $this->session->set_userdata('set_profile',$profile_arr);*/
            if(empty($post))
            {
              $profile_price = 0;
              $this->session->set_userdata('set_profile',$profile_arr);
            }
        }  

        ///////////////////////////////


        $data['page_title'] = "Update Test Booking";  
        $post = $this->input->post();
        $data['form_error'] = ''; 
        if(!empty($result['dept_id']))
            {
              $data['head_list'] = $this->test->test_head_list($result['dept_id'],$result['branch_id']);
            }
        $balance_amount = $this->test->check_patient_balance($result['patient_id'],$result['branch_id']); 
        $this->check_doctor_type(2,$result['referral_doctor'],1);  
        $cheque_date = '';
        if($result['cheque_date']!='0000-00-00')
        {
          $cheque_date = date('d-m-Y',strtotime($result['cheque_date']));
        }   
        if(!empty($post['branch_id']))
        {
        $data['insurance_company_list'] = $this->general_model->insurance_company_list($post['branch_id']);
        }
        else
        {
        $data['insurance_company_list'] = $this->general_model->insurance_company_list(); 
        }
          if(!empty($post['branch_id']))
        {
          $data['insurance_type_list'] = $this->general_model->insurance_type_list($post['branch_id']);
        }
        else
        {
          $data['insurance_type_list'] = $this->general_model->insurance_type_list();  
        }
        
        //present age of patient
          if($result['dob']=='1970-01-01' || $result['dob']=="0000-00-00")
          {
            $present_age = get_patient_present_age('',$result);
            //echo "<pre>"; print_r($present_age);
          }
          else
          {
            $dob=date('d-m-Y',strtotime($result['dob']));
            $present_age = get_patient_present_age($dob,$result);
          }
          
          $age_y = $present_age['age_y'];
          $age_m = $present_age['age_m'];
          $age_d = $present_age['age_d'];
          $age_h = $present_age['age_h'];
          //present age of patient 
        $data['form_data'] = array(
                                    'data_id'=>$result['id'],
                                    'branch_id'=>$result['branch_id'], 
                                    'profile_id'=>$result['profile_id'],
                                    'profile_price'=>$result['profile_amount'], 
                                    'patient_id'=>$result['patient_id'],  
                                    'patient_code'=>$result['patient_code'],
                                    'lab_reg_no'=>$result['lab_reg_no'],
                                    'simulation_id'=>$result['simulation_id'],
                                    'patient_name'=>$result['patient_name'],
                                    'patient_email'=>$result['patient_email'],
                                    'mobile_no'=>$result['mobile_no'],
                                    'gender'=>$result['gender'],
                                    'age_y'=>$age_y,
                                    'age_m'=>$age_m,
                                    'age_d'=>$age_d,
                                    'age_h'=>$age_h,
                                    'pannel_type'=>$result['pannel_type'],
                                    'dept_id'=>$result['dept_id'],
                                    "address"=>$result['address'],
                                    "address_second"=>$result['address2'],
                                    "address_third"=>$result['address3'],
                                    'city_id'=>$result['city_id'],
                                    'remarks'=>$result['remarks'],
                                    'state_id'=>$result['state_id'],
                                    'country_id'=>$result['country_id'],
                                    'referral_doctor'=>$result['referral_doctor'],
                                    'attended_doctor'=>$result['attended_doctor'],
                                    'payment_mode'=>$result['payment_mode'],
                                   // 'transaction_no'=>$result['transaction_no'],
                                    //'bank_name'=>$result['bank_name'],
                                    //'cheque_no'=>$result['cheque_no'],
                                   // 'cheque_date'=>$cheque_date,
                                    "field_name"=>$total_values,
                                   // 'card_no'=>$result['card_no'],
                                    'sample_collected_by'=>$result['sample_collected_by'],
                                    'staff_refrenace_id'=>$result['staff_refrenace_id'],
                                    'booking_date'=>date('d-m-Y',strtotime($result['booking_date'])),
                                    'total_amount'=>$result['total_amount'],
                                    'net_amount'=>$result['net_amount'],
                                    'paid_amount'=>$result['paid_amount'],
                                    'discount'=>$result['discount'],
                                    'form_f'=>$result['form_f'],
                                    'tube_no'=>$result['tube_no'],
                                    'balance'=>$balance_amount,
                                    'ipd_id'=>$result['ipd_id'],
                                    'referred_by'=>$result['referred_by'],
                                    "insurance_type"=>$result['insurance_type'],
                                    "insurance_type_id"=>$result['insurance_type_id'],
                                    "ins_company_id"=>$result['ins_company_id'],
                                    "polocy_no"=>$result['polocy_no'],
                                    "tpa_id"=>$result['tpa_id'],
                                    "ins_amount"=>$result['ins_amount'],
                                    "relation_type"=>$result['relation_type'],
                                    "relation_name"=>$result['relation_name'],
                                    "relation_simulation_id"=>$result['relation_simulation_id'],
                                    "ins_authorization_no"=>$result['ins_authorization_no'],
                                    'referral_hospital'=>$result['referral_hospital'],
                                    'ref_by_other'=>$result['ref_by_other'],
                                    'booking_time'=>$result['booking_time'],
                                  );  
        
        if(isset($post) && !empty($post))
        {   
            if(!empty($post['dept_id']))
            {
              $data['head_list'] = $this->test->test_head_list($post['dept_id']);
            }
            $data['form_data'] = $this->_validate();
            if($this->form_validation->run() == TRUE)
            {
                $booking_id = $this->test->save();
                $this->session->set_userdata('test_booking_id',$booking_id);
                $this->session->set_flashdata('success','Test booking successfully updated.');
                redirect(base_url('pathology_appointment/?status=print&form_f_status='.$_POST['form_f'].''));
                /*echo 1;
                return false;*/
                
            }
            else
            {
                $data['form_error'] = validation_errors(); 
                //print_r($data['form_error']); exit;
            }     
        }

       $this->load->view('pathology_appointment/booking',$data);       
      }
    }
     
    private function _validate()
    {
        $post = $this->input->post();  
        $field_list = mandatory_section_field_list(8); 
        $users_data = $this->session->userdata('auth_users'); 
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');  
        $this->form_validation->set_rules('patient_name', 'patient name', 'trim|required');
        $this->form_validation->set_rules('patient_email', 'patient email', 'trim|callback_check_email');
        $this->form_validation->set_rules('simulation_id', 'simulation', 'trim|required'); 
        /*if($post['referred_by']=='1')
        {
          $this->form_validation->set_rules('referral_hospital', 'referral by hospital', 'trim|required'); 
        }
        else
        {
          $this->form_validation->set_rules('referral_doctor', 'referral by doctor', 'trim|required'); 
        }*/

        if(in_array('38',$users_data['permission']['section']) && $post['referred_by']=='0')
           {
              $this->form_validation->set_rules('referral_doctor', 'referred by doctor', 'trim|required');
          }
         else if(in_array('174',$users_data['permission']['section']) && $post['referred_by']=='1')
         {
            $this->form_validation->set_rules('referral_hospital', 'referred by hospital', 'trim|required');
         }

        if(isset($post['pannel_type']) && $post['pannel_type']==1)
        {
          $this->form_validation->set_rules('ins_company_id', 'company name', 'trim|required');
          $this->form_validation->set_rules('insurance_type_id', 'insurance type', 'trim|required');
          $this->form_validation->set_rules('polocy_no', 'policy no', 'trim|required');
          $this->form_validation->set_rules('tpa_id', 'tpa id', 'trim|required');
          $this->form_validation->set_rules('ins_amount', 'insurance amount', 'trim|required');
          $this->form_validation->set_rules('ins_authorization_no', 'insurance authorization no.', 'trim|required');
        }
        
        
        $this->form_validation->set_rules('gender', 'gender', 'trim|required');
          if(!empty($field_list)){
             
               if($field_list[0]['mandatory_field_id']=='37' && $field_list[0]['mandatory_branch_id']==$users_data['parent_id']){ 
                   // $this->form_validation->set_rules('age_y', 'age', 'trim|required|numeric|max_length[3]');
                   
                  if(($post['age_y']=='0' && $post['age_m']=='0' && $post['age_d']=='0' && $post['age_h']=='0') || ((empty($post['age_y']) && empty($post['age_m']) && empty($post['age_d']) && empty($post['age_h']))) )
                    {
                         
                        $this->form_validation->set_rules('age_y', 'age', 'trim|required|numeric|is_natural_no_zero|max_length[3]');
                    }
               }

               if($field_list[1]['mandatory_field_id']=='38' && $field_list[1]['mandatory_branch_id']==$users_data['parent_id']){ 
                    $this->form_validation->set_rules('mobile_no', 'mobile no.', 'trim|required|numeric|min_length[10]|max_length[10]');
               }
              
              if($field_list[2]['mandatory_field_id']=='39' && $field_list[2]['mandatory_branch_id']==$users_data['parent_id']){ 
                    $this->form_validation->set_rules('tube_no', 'tube no.', 'trim|required');
               }

               if($field_list[3]['mandatory_field_id']=='40' && $field_list[3]['mandatory_branch_id']==$users_data['parent_id']){ 
                    $this->form_validation->set_rules('remarks', 'remarks', 'trim|required');
               }
          } 
           if(isset($post['field_name']))
        {
          $this->form_validation->set_rules('field_name[]', 'field', 'trim|required'); 
        }

         $total_values=array();
        if(isset($post['field_name']))
        {
            $count_field_names= count($post['field_name']);  
            $get_payment_detail= $this->general_model->payment_mode_detail($post['payment_mode']);
            for($i=0;$i<$count_field_names;$i++) 
            {
              $total_values[]= $post['field_name'][$i].'_'.$get_payment_detail[$i]->field_name.'_'.$get_payment_detail[$i]->id;

            }
        }
        //$this->form_validation->set_rules('payment_mode', 'payment mode', 'trim|required');
           /* if($post['payment_mode']=='4'){
                  $this->form_validation->set_rules('bank_name', 'bank name', 'trim|required');
                $this->form_validation->set_rules('cheque_no', 'cheque no', 'trim|required');
                 $this->form_validation->set_rules('bank_name', 'bank name', 'trim|required');
                $this->form_validation->set_rules('cheque_date', 'cheque date', 'trim|required');

            }else if($post['payment_mode']=='3'){
                  $this->form_validation->set_rules('transaction_no', 'transaction no', 'trim|required');
                    $this->form_validation->set_rules('bank_name', 'bank name', 'trim|required');
            }
            else if($post['payment_mode']=='2'){
                $this->form_validation->set_rules('card_no', 'card no', 'trim|required');
                $this->form_validation->set_rules('bank_name', 'bank name', 'trim|required');
            }*/
        $booking_list = $this->session->userdata('book_test');
        
        if(!isset($booking_list) && empty($booking_list))
        {
          $this->form_validation->set_rules('test', 'test', 'trim|callback_check_booked_test');
        }   
        
        if ($this->form_validation->run() == FALSE) 
        {  
            $reg_no = generate_unique_id(4); 
            $balance_amount = $this->test->check_patient_balance($post['patient_id']);  
            $profile_data = $this->session->userdata('set_profile');
            $profile_price = "0.00";
            if(!empty($profile_data))
            {
              $profile_price = $profile_data['price'];
            }

            if(isset($booking_set_branch) && !empty($booking_set_branch))
            {
               $branch_id = $booking_set_branch;
            }
            else
            {
               $branch_id = $users_data['parent_id'];
            }

            if(!empty($post['branch_id']))
            {
              $data['insurance_company_list'] = $this->general_model->insurance_company_list($post['branch_id']);
            }
            else
            {
              $data['insurance_company_list'] = $this->general_model->insurance_company_list(); 
            }
            if(!empty($post['branch_id']))
            {
              $data['insurance_type_list'] = $this->general_model->insurance_type_list($post['branch_id']);
            }
            else
            {
              $data['insurance_type_list'] = $this->general_model->insurance_type_list();  
            }
            $data['form_data'] = array(
                                        'data_id'=>$post['data_id'],
                                        'branch_id'=>$branch_id,
                                        'profile_id'=>$post['profile_id'],
                                        'profile_price'=>$profile_price, 
                                        'patient_id'=>$post['patient_id'], 
                                        'patient_code'=>$post['patient_code'],
                                        'lab_reg_no'=>$post['lab_reg_no'],
                                        'simulation_id'=>$post['simulation_id'],
                                        'patient_name'=>$post['patient_name'],
                                        'patient_email'=>$post['patient_email'],
                                        'mobile_no'=>$post['mobile_no'],
                                        'remarks'=>$post['remarks'],
                                        'gender'=>$post['gender'],
                                        'age_y'=>$post['age_y'],
                                        'age_m'=>$post['age_m'],
                                        'age_d'=>$post['age_d'],
                                        'age_h'=>$post['age_h'],
                                        'dept_id'=>$post['dept_id'],
                                        'address'=>$post['address'],
                                        'city_id'=>$post['city_id'],
                                        'state_id'=>$post['state_id'],
                                        'country_id'=>$post['country_id'],
                                        'referral_doctor'=>$post['referral_doctor'],
                                        'payment_mode'=>$post['payment_mode'],
                                        'field_name'=>$total_values,
                                        'pannel_type'=>$post['pannel_type'],
                                        "address"=>$post['address'],
                                        "address_second"=>$post['address_second'],
                                        "address_third"=>$post['address_third'],
                                        "relation_type"=>$post['relation_type'],
                                        "relation_name"=>$post['relation_name'],
                                        "relation_simulation_id"=>$post['relation_simulation_id'],
                                       // "insurance_type"=>$post['insurance_type'],
                                        "insurance_type_id"=>$post['insurance_type_id'],
                                        "ins_company_id"=>$post['ins_company_id'],
                                        "polocy_no"=>$post['polocy_no'],
                                        "tpa_id"=>$post['tpa_id'],
                                        "ins_amount"=>$post['ins_amount'],
                                        "ins_authorization_no"=>$post['ins_authorization_no'],




                                        //'transaction_no'=>$post['transaction_no'],
                                       // 'bank_name'=>$post['bank_name'],
                                     //   'cheque_no'=>$post['cheque_no'],
                                       // 'card_no'=>$post['card_no'],
                                       // 'cheque_date'=>$post['cheque_date'],
                                        'attended_doctor'=>$post['attended_doctor'],
                                        'sample_collected_by'=>$post['sample_collected_by'],
                                        'staff_refrenace_id'=>$post['staff_refrenace_id'],
                                        'booking_date'=>$post['booking_date'],
                                        'total_amount'=>$post['total_amount'],
                                        'net_amount'=>$post['net_amount'],
                                        'paid_amount'=>$post['paid_amount'],
                                        'discount'=>$post['discount'],
                                        'form_f'=>$post['form_f'],
                                        'tube_no'=>$post['tube_no'],
                                        'balance'=>$balance_amount,
                                        'ipd_id'=>$post['ipd_id'],
                                        'referred_by'=>$post['referred_by'],
                                        'referral_hospital'=>$post['referral_hospital'],
                                        'ref_by_other'=>$post['ref_by_other'],
                                        'booking_time'=>$post['booking_time'],
                                       ); 
            return $data['form_data'];
        }   
    }

    public function check_email($str)
    {
        if(!empty($str))
        {
          $this->load->model('general/general_model','general');
          $post = $this->input->post();
          if(!empty($post['data_id']) && $post['data_id']>0)
          {
              return true;
          }
          else
          {
              $userdata = $this->general->check_email($str); 
              if(empty($userdata))
              {
                 return true;
              }
              else
              { 
                  $this->form_validation->set_message('check_email', 'Email already exists.');
                  return false;
              }
          }
        }
    }
 
    public function delete($id="")
    {

       unauthorise_permission(145,874); 
       if(!empty($id) && $id>0)
       {
           $result = $this->test->delete($id);
           $response = "Test Booking successfully deleted.";
           echo $response;
       }
    }
    public function delivered_test($id="",$status='0')
    {
       //unauthorise_permission(145,874); 
       if(!empty($id) && $id>0)
       {
           $result = $this->test->update_delivered_test($id,$status);
           if($status==1)
           {
              $response = "Test Booking mark as delivered.";
           }
           else
           {
              $response = "Test Booking mark as un-delivered.";
           }
           
           echo $response;
       }
    }

    function deleteall()
    {
        unauthorise_permission(145,874); 
        $post = $this->input->post();  
        if(!empty($post))
        {
            $result = $this->test->deleteall($post['row_id']);
            $response = "Tests successfully deleted.";
            echo $response;
        }
    }

    function updatealltest()
    {
        //unauthorise_permission(145,150); 
        $post = $this->input->post();  
        if(!empty($post))
        {
            $result = $this->test->updatealltest($post['row_id']);
            $response = "Test successfully updated.";
            echo $response;
        }
    }
 


   

    public function restore($id="")
    {
          unauthorise_permission(145,877);
        $this->load->model('test/test_archive_model','test_archive');
       if(!empty($id) && $id>0)
       {
           $result = $this->test_archive->restore($id);
           $response = "Test Booking successfully restore in Test list.";
           echo $response;
       }
    }

    function restoreall()
    { 
          unauthorise_permission(145,877);
        $this->load->model('test/test_archive_model','test_archive');
        $post = $this->input->post();  
        if(!empty($post))
        {
            $result = $this->test_archive->restoreall($post['row_id']);
            $response = "Test Booking successfully restore in Test list.";
            echo $response;
        }
    }

    public function trash($id="")
    {
          unauthorise_permission(145,876);
        $this->load->model('test/test_archive_model','test_archive');
       if(!empty($id) && $id>0)
       {
           $result = $this->test_archive->trash($id);
           $response = "Test Booking successfully deleted parmanently.";
           echo $response;
       }
    }

    function trashall()
    {
         unauthorise_permission(145,876);
        $this->load->model('test/test_archive_model','test_archive');
        $post = $this->input->post();  
        if(!empty($post))
        {
            $result = $this->test_archive->trashall($post['row_id']);
            $response = "Test Booking successfully deleted parmanently.";
            echo $response;
        }
    }

    function dept_test_heads($dept_id="")
    {
      if($dept_id>0)
      {
         $options = "";
         $test_head_list = $this->test->test_head_list($dept_id);
         if(!empty($test_head_list))
         {
            foreach($test_head_list as $test_head)
            {
               $options .= '<option value="'.$test_head->id.'">'.ucwords(strtolower($test_head->test_heads)).'</option>';
            } 
         }
         echo $options;
      }
    }

    function test_list($head_id="",$profile_id="",$search="",$dept_id="")
    {
      $users_data = $this->session->userdata('auth_users');
      $post=$this->input->post();
      if(isset($post) && !empty($post))
      {
        $head_id=$this->input->post('test_head_id');
        $profile_id=$this->input->post('profile_id');
        $search=$this->input->post('search_text');
        $dept_id=$this->input->post('dept_id');
      }
      $rows = '<tr>
                    <th width="60" align="center">
                     <input name="selectall" class="" onClick="toggle(this);" value="" type="checkbox">
                    </th>
                    <th>Test ID</th>
                    <th>Test Name</th>
                    <th>Sample Type</th>
                    <th>Rate</th>
                  </tr>';
      if($head_id>0 OR $profile_id>0 OR !empty($search)  OR $dept_id>0)
      { 
         $child_list = $this->test->head_test_list($head_id,$profile_id,$search,$dept_id);
         //print_r($child_list);die
          $booking_set_branch = $this->session->userdata('booking_set_branch');
          if(isset($booking_set_branch) && !empty($booking_set_branch))
          {
            $branch_id = $booking_set_branch;
          }
          else
          {
            $branch_id = $users_data['parent_id'];
          };
         if(!empty($child_list))
         {  
            $booking_doctor_type = $this->session->userdata('booking_doctor_type'); 
            if(!isset($booking_doctor_type) || empty($booking_doctor_type))
            {
               $booking_doctor_type = 0;
            }
            foreach($child_list as $child)
            {  
               if(isset($booking_doctor_type) && !empty($booking_doctor_type))
               {   
                  $rate_data = doctor_test_rate($branch_id,$booking_doctor_type[0]['id'],$child->id);
                   if(!empty($rate_data))
                   {
                     $master_rate = $rate_data['rate'];
                   }
                   else
                   {
                     $rate_branch_data = doctor_test_rate($branch_id,'',$child->id);
                      if(!empty($rate_branch_data))
                      { 
                        $master_rate = $rate_branch_data['rate'];
                        $master_rate = $this->make_master_price($master_rate);
                      }
                      else
                      { 
                        $master_rate = $this->make_master_price($child->rate);
                      } 
                   }
               } 
               else
               {  
                $rate_data = doctor_test_rate($branch_id,'',$child->id);
                if(!empty($rate_data))
                { 
                  $master_rate = $rate_data['rate'];
                }
                else
                { 
                  $master_rate = $child->rate;
                }
               }

                 ///////////// Set Panel Test Rate  ///////////////
                $test_panel_rate = $this->session->userdata('test_panel_rate');
             
                if(isset($test_panel_rate) && !empty($test_panel_rate))
                {
                if(!empty($test_panel_rate['ins_company_id']) && isset($test_panel_rate['ins_company_id']))
                  {
                    $rate_branch_data = panel_test_rate($branch_id,$test_panel_rate['ins_company_id'],$child->id);
                    //print_r($rate_branch_data);die;
                    if(!empty($rate_branch_data) && $rate_branch_data['path_price']>0 && isset($rate_branch_data['path_price']) )
                    {
                      
                       $master_rate=$rate_branch_data['path_price'];
                    }

                     
                   // print_r($rate_branch_data);die;
                  }
                 // print_r($test_panel_rate['ins_company_id']);die;
                  // not penal id then no funciton will use
                  //1 function helper = (branch,testid,panelid)
                  // hellper function not empty
                  // $master_rate
                }

              /*$this->load->model('test_master/test_master_model','test_master');
              $sample_type_list=$this->test_master->sample_type_list();
              print_r($sample_type_list);*/
               $sample_type_list=$this->test->sample_type_list($child->id,$child->sample_test);
               $rows .= '<tr>
                            <td width="60" align="center"><input type="checkbox" name="test_data['.$child->id.'][id]" class="child_checkbox" value="'.$child->id.'" ></td>
                            <td>'.$child->test_code.'</td>
                            <td>'.$child->test_name.'</td>
                            <td>'.$sample_type_list.'</td>
                            <td><input type="text" class="input-small" name="test_data['.$child->id.'][price]" value="'.$master_rate.'" /></td>
                        </tr>';
            } 
         }
         else
         {
             $rows .= '<tr>  
                        <td colspan="5"><div class="text-danger">Test not available.</div></td>
                      </tr>';
         }
         echo $rows;
      }
    }



    public function set_booking_test()
    {
      
       $post =  $this->input->post();
       if(isset($post['test_data']) && !empty($post['test_data']))
       {
         $booked_test = $this->session->userdata('book_test');
         
         $book_test = [];
         if(!empty($post['test_data']))
         { 
           $post_test = [];
           foreach($post['test_data'] as $test_data)
           {
             if(!empty($test_data['id']))
             {
               $post_test[$test_data['id']] = array('id'=>$test_data['id'], 'price'=>$test_data['price'],'sample_type_id'=>$test_data['sample_type_id']);
             }
             
           }
         }

         if(isset($booked_test) && !empty($booked_test))
         { 
            $book_test_arr = $booked_test+$post_test;
         } 
         else
         {
            $book_test_arr = $post_test;
         }
        // $book_test = array_unique($book_test);
         
         $this->session->set_userdata('book_test',$book_test_arr);
         $this->list_booked_test();
       }
    }
  

    public function list_booked_test()
    {
       $booked_test = $this->session->userdata('book_test');
       $profile_data = $this->session->userdata('set_profile'); 
       //echo '<pre>'; print_r($profile_data);die;
       $total_test = count($booked_test);  
       $profile_row = "";
       $p_order = 1;
       $profile_order = 1;
       $profile_order_cell = 0;
       if(isset($profile_data) && !empty($profile_data))
        {  

          foreach($profile_data as $profile)
          {
             $profile_order_cell = $profile['order'];
             $profile_row .= '<tr>
                              <td width="40" align="center">
                                 <input type="checkbox" name="test_id[]" class="booked_checkbox" value="p_'.$profile['id'].'" >
                              </td>
                              <td>'.$profile['id'].'</td>
                              <td>'.$profile['name'].'</td>
                              <td></td>
                              <td>'.$profile['price'].'</td>
                          </tr>';
          } 
        }

       $rows = '<tr> 
                    <th width="60" align="center">
                     <input name="selectall" class="" onClick="final_toggle(this);" value="" type="checkbox">
                    </th>
                    <th>Test ID</th>
                    <th>Test Name</th>
                    <th>Sample Type</th>
                    <th>Rate</th>
                  </tr>';  
         
         if(isset($booked_test) && !empty($booked_test))
         { 
            $test_ids_arr = array_keys($booked_test);
            $test_ids = implode(',',$test_ids_arr);
            $test_list = $this->test->test_list($test_ids);
            $i = 1;
            if($total_test>1)
            {
              $profile_order = $total_test-$profile_order_cell;
              if($profile_order==0)
              {
                $profile_order = 1;
              }
            }
              
            foreach($test_list as $test)
            { 
               $master_rate = $booked_test[$test->id]['price'];//$this->make_master_price($test->rate);
               $sample_type_id = $booked_test[$test->id]['sample_type_id'];
               $rows .= '<tr>
                                  <td width="60" align="center"><input type="checkbox" name="test_id[]" class="booked_checkbox" value="'.$test->id.'" ></td>
                                  <td>'.$test->test_code.'</td>
                                  <td>'.$test->test_name.'</td>
                                  <td>'.$sample_type_id.'</td>
                                  <td>'.$master_rate.'</td>
                              </tr>';
              if(isset($profile_data) && !empty($profile_data))
              {
                 if($i==$profile_order)
                 {
                   $rows .= $profile_row;
                 }
              }                
            $i++;
            } 
         }
         else
         {
            if(isset($profile_data) && !empty($profile_data))
            {
              $rows .= $profile_row;
            }
            else
            {
             $rows .= '<tr>  
                        <td colspan="5"><div class="text-danger">Test not available.</div></td>
                      </tr>';
            }          
         }
         echo $rows;
    }


    public function reset_booked_test()
    {
      $booked_test = $this->session->userdata('book_test');
       $test_panel_rate = $this->session->userdata('test_panel_rate');
      //print_r($booked_test);die;
      if(!empty($booked_test))
      {
        $booking_doctor_type = $this->session->userdata('booking_doctor_type'); 

        foreach($booked_test as $booked)
        {
          if(!empty($booking_doctor_type) && empty($test_panel_rate))
          {
          if(!empty($booking_doctor_type))
          {
            $price = $this->make_master_price($booked['price']);
            $sample_type_id = '';
          }
          else
          {
            $price_data = get_test($booked['id']);
            $price = $price_data->rate;
            $sample_type_id = $price_data->sample_test;
          }
          
          unset($booked_test[$booked['id']]);
          $booked_test[$booked['id']] = array('id'=>$booked['id'], 'price'=>$price,'sample_type_id'=>$sample_type_id);
         }
         /* panel type selection */
         
        if(isset($test_panel_rate)|| $test_panel_rate>0) 
        {

          $users_data = $this->session->userdata('auth_users'); 
          $rate_branch_data = panel_test_rate($users_data['parent_id'],$test_panel_rate['ins_company_id'],$booked['id']);
          //echo $booked['id'];
        //print_r($rate_branch_data);
            if(!empty($rate_branch_data) && $rate_branch_data>0)
            {
              $price = $rate_branch_data['path_price'];
              $sample_type_id = $rate_branch_data['sample_test'];
            }
            else
            {
              $price_data = get_test($booked['id']);
              $price = $price_data->rate;
              $sample_type_id = $price_data->sample_test;
            }
           
              unset($test_panel_rate[$booked['id']]);
              $booked_test[$booked['id']] = array('id'=>$booked['id'], 'price'=>$price, 'sample_type_id'=>$sample_type_id);
         
        }

          /* panel type selection */

        } 
      } 
      $this->session->set_userdata('book_test',$booked_test);
      $booked_test = $this->session->userdata('book_test');
      $this->list_booked_test();   

    }

    public function check_test_panel_type()
    {
        $post= $this->input->post();
         $this->session->unset_userdata('test_panel_rate');
        //$this->session->unset_userdata('test_panel_payment');
        //print_r($this->session->userdata('test_panel_payment'));die;
        $polocy_no="";
        $insurance_type_id="";
        $ins_company_id="";
        $tpa_id="";
        $insurance_amount="";
        $ins_authorization_no="";
        $panel_type="";

        if(isset($post['insurance_type_id']))
        {
          $insurance_type_id= $post['insurance_type_id'];
        }
        if(isset($post['panel_type']))
        {
          $panel_type= $post['panel_type'];
        }
        if(isset($post['ins_company_id']))
        {
          $ins_company_id= $post['ins_company_id'];
        }
        if(isset($post['tpa_id']))
        {
          $tpa_id= $post['tpa_id'];
        }
         if(isset($post['insurance_amount']))
        {
          $insurance_amount= $post['insurance_amount'];
        }
        if(isset($post['ins_authorization_no']))
        {
        $ins_authorization_no= $post['ins_authorization_no'];
        }
        if(isset($post['polocy_no']))
        {
        $polocy_no= $post['polocy_no'];
        }


            $new_session_array= array('insurance_type'=>$insurance_type_id,'panel_type'=>$panel_type,'ins_company_id'=>$ins_company_id,'tpa_id'=>$tpa_id,'insurance_amount'=>$insurance_amount,'authorization_no'=>$ins_authorization_no,'polocy_no'=>$polocy_no);
          if(!empty($new_session_array))
          {

            if($panel_type==1)
            {
              $this->session->set_userdata('test_panel_rate',$new_session_array);
              $test_panel_payment = $this->session->userdata('test_panel_rate');
            }
            else
            {

             $this->session->unset_userdata('test_panel_rate');

            }
           
            $result= 1;  
          } 
          else
          {
            $result= 2;
          }
           echo $result;
    }

    public function make_master_price_for_panel($rate)
    {
      $master_rate = $rate;
      $test_panel_rate = $this->session->userdata('test_panel_rate');
      if(!empty($test_panel_rate))
        {  
           if($test_panel_rate[0]['master_type']==1)
           { 
             $master_rate = (($rate/100)*$test_panel_rate[0]['master_rate'])+$rate;
             
           }
           else
           {
             $master_rate = $booking_doctor_type[0]['master_rate']+$rate;
           }
           
        }
      return  number_format($master_rate, 2, '.', '');
    //return number_format($master_rate,2);
    }
    public function remove_booked_test()
    {
       $post =  $this->input->post();
       if(isset($post['test_id']) && !empty($post['test_id']))
       {
           $booked_test = $this->session->userdata('book_test');
           $booked_session_test = $booked_test;
           $profile_data = $this->session->userdata('set_profile');
           $test_data = [];

           if(!empty($booked_test))
           {
              foreach($post['test_id'] as $tid)
              {
                 if(is_numeric($tid) && array_key_exists($tid,$booked_test))
                 {
                    unset($booked_test[$tid]);
                 } 
              }
              //$profile_data = $this->session->userdata('set_profile');
              //$test_ids_arr = array_keys($booked_test);
              //$test_data = array_diff($test_ids_arr,$post['test_id']);  
              //print_r($profile_data);die;
           }

           if(!empty($profile_data))
           {
              $profile_data = $this->session->userdata('set_profile');
              $profile_list = $profile_data;
              foreach($post['test_id'] as $tid)
              { 
                 if(isset($profile_data) && !empty($profile_data) && !is_numeric($tid))
                 {

                    foreach($profile_data as $p_key=>$profile)
                    {
                      if($tid == 'p_'.$p_key)
                      {  
                         unset($profile_list[$p_key]); 
                      }
                    } 
                    
                 }
              }
              $this->session->set_userdata('set_profile',$profile_list); 
           }
           
           if(!empty($booked_session_test))
           {
             $test_ids_arr = array_keys($booked_test);
             $this->session->set_userdata('book_test',$booked_test);
             $test_ids = implode(',', $test_ids_arr);
           } 
           
           $this->list_booked_test();
       }
    } 


    public function check_booked_test()
    {
       $booking_list = $this->session->userdata('book_test');
       $set_profile = $this->session->userdata('set_profile');
       if((isset($booking_list) && !empty($booking_list)) || !empty($set_profile))
       {
          return true;
       }
       else
       {
          $this->form_validation->set_message('check_booked_test', 'Please book atleast one test.');
          return false;
       }
    }

    public function payment_calc($vals="")
    {
       $post = $this->input->post(); 
       if(isset($post) && !empty($post))
       {
         $total_amount = '0.00';
         $booking_list = $this->session->userdata('book_test');
         $profile_data = $this->session->userdata('set_profile');
         //$test_ids_arr = array_keys($booking_list);
        if(!empty($booking_list))
         { 
           foreach($booking_list as $test)
           {
             /////////// Transection doctor payment ///////// 
               //$test_data = get_test($test);
               //$master_rate = $this->make_master_price($test_data->rate);
            //////////////////////////////////////////////////
             
             $total_amount = $total_amount+$test['price'];
           }
          }  
           //Profile Price set start
           $profile_price = 0;
           if(isset($profile_data) && !empty($profile_data))
           {
             foreach ($profile_data as $profile) 
             {
                $profile_price = $profile_price+$profile['price'];
             }
             
           } 
           $total_amount = $total_amount+$profile_price;
           //Profile Price set end 
           $discount = $post['discount'];

           if(!empty($post['home_collection']))
           {
              $home_collection=$post['home_collection'];
           }
           else
           {
            $home_collection='0.00';
           }

           //$home_collection=$post['home_collection'];
           //$net_amount = $total_amount-$discount+$home_collection;
           $total_amount = $total_amount+$home_collection;
           $net_amount = $total_amount-$discount;
           
           $booking_doctor_type = $this->session->userdata('booking_doctor_type'); 
           if($post['paid_amount']=='0.00' || $post['paid_amount'] < 1)
           { 

              if(isset($booking_doctor_type) && !empty($booking_doctor_type))
              {
                $post['paid_amount'] = '0.00'; 
              }
              else
              {
                $post['paid_amount'] = '0.00'; 
                // commented on 15-feb-2018
                //$post['paid_amount'] = $net_amount;  
              } 
           }
           else
           { 
             $post['paid_amount'] = $post['paid_amount'];
             if(empty($vals) || $vals==0)
             {
               $post['paid_amount'] = $net_amount; 
             }
           }
           $balance = $net_amount-$post['paid_amount'];
           if(isset($booking_doctor_type) && !empty($booking_doctor_type))
           {
               $balance = '0.00'; 
           } 
           $balance = number_format($balance,2, '.', '');
           $paid_amount = number_format($post['paid_amount'],2, '.', '');
           $net_amount = number_format($net_amount,2, '.', '');
           $pay_arr = array(
                             'total_amount'=>$total_amount, 
                             'net_amount'=>$net_amount, 
                             'discount'=>$discount, 
                             'balance'=>$balance, 
                             'paid_amount'=>$paid_amount,
                             'home_collection'=>$home_collection,
                           );
           $json = json_encode($pay_arr,true);
           echo $json; 
       }
    }

    public function discount_percentage($percent="")
    {
       if($percent>0)
       {
         $booking_list = $this->session->userdata('book_test');
         if(!empty($booking_list))
         { 
           $total_amount = '0.00';
           foreach($booking_list as $test)
           { 
             $total_amount = $total_amount+$test['price'];
           } 

           $discount = ($total_amount/100)*$percent;
           $net_amount = $total_amount-$discount;
           $balance = $post['balance'];
           $paid_amount = number_format($post['paid_amount'],2, '.', '');
           $net_amount = number_format($net_amount,2, '.', '');
           $pay_arr = array(
                             'total_amount'=>$total_amount, 
                             'net_amount'=>$net_amount, 
                             'discount'=>$discount, 
                             'balance'=>$net_amount-$paid_amount, 
                             'paid_amount'=>$paid_amount
                           );
           $json = json_encode($pay_arr,true);
           echo $json;
         }
       }
    }


    public function report($id="")
    { 
       $users_data = $this->session->userdata('auth_users'); 
       $this->load->model('test_report_verify/test_report_verify_model','test_report_verify');
       $data['branch_verify_dept'] = $this->test_report_verify->branch_verify_dept();
       $data['report_setting_data'] = $this->test_report_verify->branch_report_setting();
       $post = $this->input->post();
       $dept_ids=array();
       $dept_unique_ids='';
       $tube_no='';
       if(!empty($id) && $id>0)
       {
          $result = $this->test->get_by_id($id); 
          $this->session->set_userdata('booking_set_branch',$result['branch_id']);
          $sub_branches_data = $this->session->userdata('sub_branches_data');
          if(!empty($sub_branches_data))
          {
            $branch_list = array_unique(array_column($sub_branches_data, 'id'));
            $branch_list[] = $users_data['parent_id'];
          }
          else
          {
            $branch_list[] = $users_data['parent_id'];
          } 
           
          if(!in_array($result['branch_id'],$branch_list))
          { 
            redirect(base_url(401));
          }
          $data['signature_list'] = $this->test->signature_list('',$result['branch_id']);
          $data['booking_data'] = $this->test->booking_data($id);
          //echo "<pre>";print_r($data['booking_data']);die;
          $data['employee_list'] = $this->test->employee_list($id);
          $data['booked_profile_list'] = $this->test->get_booking_profile($id);
          $data['booking_id'] = $id;
          if(!empty($data['booking_data']))
          {
            if(isset($post) && !empty($post) && !empty($post['booked_test_id']))
             { 
                   $this->test->updatealltest($id); 
                   echo 1;
                   return false;
             }
            $data['test_list'] = $this->test->report_test_list($id,'','0'); 
            //echo "<pre>";print_r($data['test_list']);die;
            foreach($data['test_list'] as $dept_list)
            {
              $dept_ids[]= $dept_list->dept_id;
            }
             
            $dept_unique_ids= array_unique($dept_ids);
           
           /* tube no code */
            $required=array('10','11');
            $tube_status = 0;
            //echo "<pre>"; print_r($dept_unique_ids);die;
            if(!empty($dept_unique_ids))
            {
               foreach($dept_unique_ids as $dept_check)
                {
                   if(!in_array($dept_check,$required))
                   {
                     $tube_status++;
                   }
                }
            }

            $data['profile_test_list'] = $this->test->report_test_list($id,'','1,2'); 
            if(!empty($result['tube_no']))
            {
              $tube_status = 1;
            }            

            if($tube_status>0)
            {  
                $tube_no = $result['tube_no'];
            }
            else
            {
                $tube_no = '';
            }
           
          /* tube no code */
            $data['all_dept'] = $dept_unique_ids;
            $data['page_title'] = 'Test Report';

            $gender = $result['gender'];

            $genders = array('0'=>'F','1'=>'M');
            $gender = $genders[$gender];

            $age_y = $result['age_y'];
            $age_m = $result['age_m'];
            $age_d = $result['age_d'];
            $age_h = $result['age_h'];
            $age = "";
            if($age_y>0)
            {
            $year = 'Y';
            if($age_y==1)
            {
              $year = 'Y';
            }
            $age .= $age_y." ".$year;
            }
            if($age_m>0)
            {
            $month = 'M';
            if($age_m==1)
            {
              $month = 'M';
            }
            $age .= ", ".$age_m." ".$month;
            }
            if($age_d>0)
            {
            $day = 'D';
            if($age_d==1)
            {
              $day = 'D';
            }
            $age .= ", ".$age_d." ".$day;
            }
            if($age_h>0)
            {
            $hours = 'H';
            if($age_h==1)
            {
              $hours = 'H';
            }
            $age .= $age_h." ".$hours;
            }
            $patient_age =  $age;
            $gender_age = $gender.'/'.$patient_age;
            $doctor_name = get_doctor_name($result['attended_doctor']);


            $patient_address = $result['address'];
            $data['tube_no'] = $tube_no;
            //$data['tube_no'] = $tube_no;//$result['tube_no'];

            /* for check dept avilable or not */
             $result_dept = $this->test->get_dept_common_data($id);
             $data['dept_status']=$result_dept;
            /* for check dept avilable or not */

            $data['patient_name'] = $result['patient_name'];
            $data['booking_id'] = $id;
            $data['booking_date'] = date('d-m-Y',strtotime($result['booking_date']));
            $data['patient_code'] = $result['patient_code'];
            $data['lab_reg_no'] = $result['lab_reg_no'];
            $data['gender_age'] = $gender_age;
            $data['doctor_name'] = $doctor_name;
            $data['mobile_no'] = $result['mobile_no'];
            $data['referred_by'] = get_doctor_name($result['referral_doctor']);
            $data['address'] = $patient_address;
            $this->load->view('pathology_appointment/report',$data);
          } 
          else
          {            
            redirect(base_url(401));
          }
       } 
       else
       {
         
         redirect(base_url(401));
       }
    }

    public function advance_report_result($booking_id="",$test_id="")
    {

        if(!empty($test_id) && !empty($booking_id)) 
        { 
           $data['test_id'] = $test_id;
           $data['booking_id'] = $booking_id; 
           $test_data = $this->test->get_test_details($booking_id,$test_id);
           $data['test_type_id']= $test_data->test_type_id;
           $data['page_title'] = 'Advance Result'; 
           $post = $this->input->post();
           //print_r($post); exit;
           $advance_result_data = $this->session->userdata('advance_result');
           $advance_result = "";
           $advance_remark = "";
           if(isset($advance_result_data[$test_id]) && !empty($advance_result_data[$test_id]))
           {
              $advance_result = $advance_result_data[$test_id]['result'];
              //$advance_remark = $advance_result_data[$test_id]['remark'];
           }
           //echo $test_data->interpratation_data;die;
            

           $data['form_data'] = array(
                                       'booking_id'=>$booking_id,
                                       'test_id'=>$test_id,
                                       'test_name'=>$test_data->test_name,
                                       'result'=>$test_data->result,
                                       'range_from'=>$test_data->range_from,
                                       'range_to'=>$test_data->range_to, 
                                     );
           if(!empty($post))
           {
                   $advance_result = $this->session->userdata('advance_result'); 
                   if(empty($advance_result))
                   {
                     $advance_result = [];
                   } 

                   $advance_result[$post['test_id']] = $post; 
                   $this->session->set_userdata('advance_result',$advance_result); 
                    echo 1; die;
           }

           $this->load->view('pathology_appointment/report_result_advance',$data);
        }
    }

    /* inventory code here by mamta */


      public function inventory_report_result($booking_id="",$test_id="")
      {

        if(!empty($test_id) && !empty($booking_id)) 
        { 
            $data['test_id'] = $test_id;
            $data['booking_id'] = $booking_id;

            $data['item_list']= $this->test->item_list($test_id, $booking_id); 

             $post = $this->input->post();
             $inventory_data = $this->session->userdata('inventory_item_ids');
             if(!empty($inventory_data))
             {
                $inventory_data = array();
                $this->session->set_userdata('inventory_item_ids',$inventory_data);
             }
        
           // if(isset($post) && !empty($post))
            //{
            $inventory_data = array();
            $i=0;
            foreach ($data['item_list'] as $medicine_id) {

             

              $inventory_data[$i]['item_id'] = $medicine_id->item_id;
              $inventory_data[$i]['item_name'] =  $medicine_id->item;
              $inventory_data[$i]['unit_value'] = $medicine_id->unit_id;

            $i++;
            }
            
          // print '<pre>';print_r($inventory_data);die;

               $this->session->set_userdata('inventory_item_ids', $inventory_data);
             
        // } 
        
         $data['page_title'] = 'Items in Inventory';
         
        
        

         $row='';
          $r = 0;
          $i=1;
         $total_num = count($data['item_list']);
         if(!empty($data['item_list']))
         {
              // echo "<pre>"; print_r($data['item_list']);die;
               foreach($data['item_list'] as $item)
               {
                        $get_unit_according_item= get_units_by_item($item->item_id);
                        $get_unit_by_unit_id= get_units_by_id($item->unit_id);

                         
                        
                         $option_name='';
                            $option_name='<select  name="unit_value['.$r.']" id="unit_dropdown_'.$r.'"><option value="">Select Unit</option>';
                            if(!empty($get_unit_according_item[0])) 
                            { 
                            foreach($get_unit_according_item[0] as $get_unit)
                            {

                            if(!empty($get_unit))
                            {
                            
                                if(!empty($item->booking_status) && $item->booking_unit>0)
                                {
                                   if($item->booking_unit==$get_unit['id'])
                                   {
                                      $selected='selected="selected"';
                                   }
                                   else
                                   {
                                       $selected='';
                                   }
                                  
                                }
                                else if(empty($item->booking_status) && $get_unit['id']==$get_unit_by_unit_id[0]->id)
                                {
                                $selected='selected="selected"';
                                } 
                                else
                                {
                                  $selected='';
                                }


                            $option_name.='<option value="'.$get_unit['id'].'" '.$selected.'>'.$get_unit['first_name'].'</option>';
                            } } }

                            $option_name.='</select>';

                            $qty = $item->inventory_qty;
                            if(!empty($item->booking_status) && $item->booking_status>0)
                            {
                               $qty = $item->booking_qty;
                            } 

                            $row.= '<tr><td align="center">'.$i.'</td><td> <input type="text" name="item_name['.$r.']" value="'.$item->item.'" class="" id="item_name_'.$r.'" readonly/><input type="hidden" name="item_id['.$r.']" value="'.$item->item_id.'" class="" id="item_id_'.$r.'" /></td><td><input type="text" name="quantity['.$r.']" value="'.$qty.'" id="quantity_'.$r.'" onkeyup="check_stock_quantity('.$item->item_id.');"/><div  id="stock_error_'.$item->item_id.'" style="color:red;">
                                   </div>
                            </td> <td>'.$option_name.'</td></tr>';
                    $i++;

                    $r++;
               }
          }else{
               $row  = '<tr id="nodata"><td class="text-danger text-center" colspan="5">No Records Founds</td></tr>'; 
          }
          $data['item_inventory_list'] = $row;
       

        
         $this->load->view('pathology_appointment/report_result_inventory',$data);
        }
      }


    public function insert_inventory_item_booking()
    {
          unauthorise_permission('165','953');
          $post = $this->input->post();
         
          $data['test_id']= $post['test_id'];
          $data['booking_id']= $post['booking_id'];
          $users_data = $this->session->userdata('auth_users');
          $data['page_title'] = 'Items in Inventory';
          $data['item_list'] = '';
          if(isset($post) && !empty($post))
          {
              if($users_data['users_role']=='2')
              {

                      $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
                      $inventory_item_ids = $this->session->userdata('inventory_item_ids');

                      $this->form_validation->set_rules('item_id', 'item_id', 'trim|callback_check_stock_purchase_item_id');
                      
      
                     if($this->form_validation->run() == TRUE)
                     {
                            
                          
                            $this->test->insert_invntory();
                            echo 1;
                            return false;
                     }
                    
                    else
                    {
                        
                         $data['item_list']= $this->test->item_list($data['test_id'],$data['booking_id']); 
                         $row='';
                         $i=0;
                         $r=0;
                         $total_num = count($data['item_list']);
                         if(!empty($data['item_list']))
                         {
                            
                          foreach($data['item_list'] as $item)
                          {

                              $get_unit_according_item= get_units_by_item($item->item_id);
                              $get_unit_by_unit_id= get_units_by_id($item->unit_id);
                              if(!empty($item->booking_unit) && $item->booking_unit>0)
                              {
                              $get_unit_by_unit_id= get_units_by_id($item->booking_unit);
                              }

                             $option_name='';
                              $option_name='<select  name="unit_value['.$r.']" id="unit_dropdown_'.$r.'"><option value="">Select Unit</option>';
                               if(!empty($get_unit_according_item[0])) 
                                  { 
                                 foreach($get_unit_according_item[0] as $get_unit)
                                   {

                                    if(!empty($get_unit))
                                    {
                                        if(!empty($item->booking_status) && $item->booking_unit>0)
                                        {
                                          if($item->booking_unit==$get_unit['id'])
                                          {
                                          $selected='selected="selected"';
                                          }
                                          else
                                          {
                                          $selected='';
                                          }

                                        }
                                        else if(empty($item->booking_status) && $get_unit['id']==$get_unit_by_unit_id[0]->id)
                                        {
                                        $selected='selected="selected"';
                                        } 
                                        else
                                        {
                                        $selected='';
                                        } 

                                        $option_name.='<option value="'.$get_unit['id'].'" '.$selected.'>'.$get_unit['first_name'].'</option>';
                                      } 
                                    } 
                                  }

                                  $option_name.='</select>';

                                  $qty = $item->inventory_qty;
                                  if(!empty($item->booking_status) && $item->booking_status>0)
                                  {
                                  $qty = $item->booking_qty;
                                  } 

                                  $row.= '<tr><td align="center">'.$i.'</td><td> <input type="text" name="item_name['.$r.']" value="'.$item->item.'" class="" id="item_name_'.$r.'" readonly/><input type="hidden" name="item_id['.$r.']" value="'.$item->item_id.'" class="" id="item_id_'.$r.'" /></td><td><input type="text" name="quantity['.$r.']" value="'.$qty.'" id="quantity_'.$r.'" onkeyup="check_stock_quantity('.$item->item_id.');"/>
                                   <div  id="stock_error_'.$item->item_id.'" style="color:red;">
                                   </div></td><td>'.$option_name.'</td>
                                   </tr>';
                                $i++;

                                  $r++;
                          }    
                         }
                         else{
                              $row  = '<tr id="nodata"><td class="text-danger text-center" colspan="5">No Records Founds</td></tr>'; 
                         }

                         $data['item_inventory_list'] = $row;
                         $data['form_error'] = validation_errors(); 

                      
                    }

               }
          }
          
         $this->load->view('pathology_appointment/report_result_inventory',$data);
     }
    function check_stock_quantity()
    {
      $this->load->model('item_manage/item_manage_model','item_manage'); 
      $item_id= $this->input->post('item_id');
      if(!empty($item_id))
      {
         $return= $this->item_manage->get_item_quantity($item_id);
         if($return['total_qty']>0)
        {
          echo '0';exit;
        }
        else
        {
          echo '1';exit;
        }
      }

    }

     public function check_stock_purchase_item_id()
    {
       $inventory_item_ids = $this->session->userdata('inventory_item_ids');
       if(isset($inventory_item_ids) && !empty($inventory_item_ids))
       {
          return true;
       }
       else
       {
          $this->form_validation->set_message('check_stock_purchase_item_id', 'Please select a item.');
          return false;
       }
    }
/* inventory code here by mamta */

 public function check_result_range($booking_id="",$test_id="")
  {
    $result = urldecode($_GET['result']); 
    $this->update_test_result($booking_id,$test_id,$result);
    if(!empty($result) && is_numeric($result) && !empty($booking_id) && !empty($test_id))
    {  
      $result = urldecode($result);
      $booking_data = $this->test->get_by_id($booking_id);
      
      $gender = $booking_data['gender'];
      $advance_range = $this->test->get_test_advance_range($test_id,$gender,$booking_data['age_y'],$booking_data['age_m'],$booking_data['age_d'],$booking_data['age_h']);
      
      if(!empty($advance_range))
      {
       if($advance_range[0]->age_type==2)
        {    
         if($booking_data['age_y'] >= $advance_range[0]->start_age && $booking_data['age_y'] <= $advance_range[0]->end_age)
         { 
           if($result>=$advance_range[0]->range_from && $result<=$advance_range[0]->range_to)
           {
              echo "1";die;
           }
           else
           {
              echo "2";die;
           } 
         }
         else
         {
            $this->check_main_test_range($booking_id,$test_id,$result);
         }
        }
        else if($advance_range[0]->age_type==1)
        { 
           $total_months = ($booking_data['age_y']*12)+$booking_data['age_m'];  
           if($total_months >= $advance_range[0]->start_age && $total_months <= $advance_range[0]->end_age)
         { 
           if($advance_range[0]->range_from>=$result && $result<=$advance_range[0]->range_to)
           {
              echo "1";die;
           }
           else
           {
              echo "2";die;
           } 
         }
         else
         {  
            $this->check_main_test_range($booking_id,$test_id,$result);
         }
        }
        else if($advance_range[0]->age_type==0)
        {
          $total_days = ($booking_data['age_y']*365)+($booking_data['age_m']*30)+$booking_data['age_d']; 
        if($total_days >= $advance_range[0]->start_age && $total_days <= $advance_range[0]->end_age)
         {
           if($advance_range[0]->range_from>=$result && $result<=$advance_range[0]->range_to)
           {
              echo "1";die;
           }
           else
           {
              echo "2";die;
           } 
         }
         else
         {
            $this->check_main_test_range($booking_id,$test_id,$result);
         }
        }

        else if($advance_range[0]->age_type==3)
        {

          $total_hours = $booking_data['age_h'];
         
        if($advance_range[0]->start_age <= $total_hours && $total_hours <= $advance_range[0]->end_age)
         {
          
           if($result >= $advance_range[0]->range_from && $result<=$advance_range[0]->range_to)
           {
             
              echo "1";die;
           }
           else
           {
              echo "2";die;
           } 
         }
         else
         {
            $this->check_main_test_range($booking_id,$test_id,$result);
         }
        }
      }
      else
      {
         $this->check_main_test_range($booking_id,$test_id,$result);
      } 
    }
    
  }
  
  
  private function check_main_test_range($booking_id,$test_id,$result)
  {
     $test_data = get_test($test_id);
     if(!empty($test_data->range_from) && is_numeric($test_data->range_from) && !empty($test_data->range_to) && is_numeric($test_data->range_to))
     {
       $result = urldecode($result);
       if($result>=$test_data->range_from && $result<=$test_data->range_to)
       {
         echo 1; die;
       }
       else
       {
         echo 2; die;
       }
     }
     
     
  }
  
  private function update_test_result($booking_id="",$test_id="",$result="")
    {
     if(!empty($booking_id) && !empty($test_id))
     {
        $result = urldecode($result);
        $this->test->update_test_result($booking_id,$test_id,$result);
     }
  }

  public function set_formula($booking_id="",$test_id="")
  { 
     $result = urldecode($_GET['result']);  
     if(!empty($booking_id) && !empty($test_id))
     {
      if(is_numeric($result))
        {
           //$result = number_format($result,2,'.','');
           //$result = $result;
           $result = round($result,2);
        }
      $this->update_test_result($booking_id,$test_id,$result); 
      $result = urldecode($result);
      $test_list = $this->test->booking_test_list($booking_id);
      $formula_test_list = $this->test->formula_test_list($booking_id,$test_id); 
      if(!empty($formula_test_list))
      {  
        foreach($formula_test_list as $formula_test_id)
        {
           $test_formula = $this->test->test_formula_ids($booking_id,$formula_test_id);  
            if(!empty($test_formula))
            {
              $booking_test_list = $this->test->booking_test_list($booking_id);   
              $test_avl = '';
              foreach($test_formula as $formula)
               {   
                  if(is_numeric($formula->formula_val))
                  {
                     if(in_array($formula->formula_val,$booking_test_list))
                      {
                         if($test_avl==1 || $test_avl == '')
                         {
                           $test_avl = 1;
                         } 
                      }
                      else
                      {
                         $test_avl = 2; 
                      }
                  } 
               } 


               if($test_avl==1)
               {    
                   $main_string = '';  
                   $res = 0; 
                   foreach($test_formula as $formula)
                   { 
                     $total_id = $formula->test_id;
                     if($formula->formula_val!='=' && $res==0)
                     {
                        if(is_numeric($formula->formula_val) && $formula->type==0)
                        {
                          $test_result = $this->test->get_test_result($booking_id, $formula->formula_val);
                          $main_string .= $test_result;
                        } 
                        else if(is_numeric($formula->formula_val) && $formula->type==1)
                        { 
                          $main_string .= str_replace('|', '', $formula->formula_val);
                        }
                        else
                        {
                          $main_string .= $formula->formula_val;
                        }
                     } 
                     else
                     {
                       $res = 1; 
                     }
                   }
                   
                   $total_result = '';
                   if(strlen($main_string)>=3)
                   {   
                      $main_string = str_replace('|', '', $main_string);
                      $total_result = $this->calc_string($main_string);
                      if(is_numeric($total_result))
                        {
                           //$total_result = $total_result;//number_format($total_result,2,'.','');
                           $total_result = round($total_result,2);
                        }
                   } 
                   $response = array('id'=>$total_id, 'result'=>$total_result);
                   
                   echo json_encode($response,true);die;
               }


            }
        }
      }
 
     }
     $this->update_test_result($booking_id,$test_id,$total_result);
  }

  private function calc_string( $mathString )
  { 
          $cf_DoCalc='';
          if(!empty($mathString))
          {
              $cf_DoCalc = create_function("", "return (" . $mathString . ");" );
              if(is_numeric($cf_DoCalc))
              {
              $cf_DoCalc = $cf_DoCalc;//number_format($cf_DoCalc,2,'.','');
              }  
          }
          
          return $cf_DoCalc();
  }


  /*public function set_condition($booking_id="",$test_id="",$result="")
  {

     if(!empty($booking_id) && !empty($test_id) && !empty($result))
     {
           if(is_numeric($result))
            {
               $result = number_format($result,2,'.','');
            }
           $result = urldecode($result);
           $this->update_test_result($booking_id,$test_id,$result); 
           $test_condition = $this->test->test_condition_ids($booking_id,$test_id);  

            if(!empty($test_condition))
            {
              $booking_test_list = $this->test->booking_test_list($booking_id);   
              $test_avl = '';
              foreach($test_condition as $condition)
               {   
                  if(!empty($condition->condition_val) && is_numeric($condition->condition_val))
                  {
                     if(in_array($condition->condition_val,$booking_test_list))
                      {
                         if($test_avl==1 || $test_avl == '')
                         {
                           $test_avl = 1;
                         } 
                      }
                      else
                      {
                         $test_avl = 2; 
                      }
                  } 
               } 
            
               
               if($test_avl==1)
               {
                   $main_string = '';  
                   $res = 0; 
                   $condition_result = '';
                   foreach($test_condition as $condition)
                   { 
                     $total_id = $condition->test_id;
                     if(!empty($condition->condition_result))
                     { 
                       $condition_result = $condition->condition_result;
                     }

                     if(!empty($condition->condition_val))
                     {
                        if(is_numeric($condition->condition_val))
                        {
                          $test_result = $this->test->get_test_result($booking_id, $condition->condition_val);
                          $main_string .= $test_result;
                        } 
                        else
                        {
                          $main_string .= $condition->condition_val;
                        }
                     } 
                     else
                     {
                       $res = 1; 
                     }
                   }
                   
                   $total_result = $this->calc_string($main_string); 
                   $split_result = str_split($condition_result);
                   $con_result = '';
                   $con_result_action = '';
                   
                   foreach($split_result as $rslt)
                   {
                     if(!is_numeric($rslt))
                     {
                       $con_result_action = $rslt;
                     }
                     else
                     {
                       $con_result .= $rslt;
                     }
                   }
                   
                   if(!empty($con_result_action))
                   {
                     if($con_result_action=="=")
                     {
                       if($total_result==$con_result)
                       {
                          $response = array('id'=>$total_id, 'result'=>1);
                          echo json_encode($response,true);die;
                       }
                       else
                       {
                          $response = array('id'=>$total_id, 'result'=>2);
                          echo json_encode($response,true);die;
                       }
                     }
                     else if($con_result_action=="!=")
                     {
                       if($total_result!=$con_result)
                       {
                          $response = array('id'=>$total_id, 'result'=>1);
                          echo json_encode($response,true);die;
                       }
                       else
                       {
                          $response = array('id'=>$total_id, 'result'=>2);
                          echo json_encode($response,true);die;
                       }
                     }
                     else if($con_result_action=="<")
                     {
                       if($total_result<$con_result)
                       {
                          $response = array('id'=>$total_id, 'result'=>1);
                          echo json_encode($response,true);die;
                       }
                       else
                       {
                          $response = array('id'=>$total_id, 'result'=>2);
                          echo json_encode($response,true);die;
                       }
                     }

                     else if($con_result_action==">")
                     { 
                       if($total_result>$con_result)
                       { 
                          $response = array('id'=>$total_id, 'result'=>1);
                          echo json_encode($response,true);die;
                       }
                       else
                       {
                          $response = array('id'=>$total_id, 'result'=>2);
                          echo json_encode($response,true);die;
                       }
                     }

                   } 
               }
 
      }
 
     }
  }*/

    public function set_condition($booking_id="",$test_id="")
  {
     $result = urldecode($_GET['result']); 
     if(!empty($booking_id) && !empty($test_id) && !empty($result))
     {
           if(is_numeric($result))
            {
               //$result = number_format($result,2,'.','');
               //$result = $result;
               $result = round($result,2);
            }
           $result = urldecode($result);
           $this->update_test_result($booking_id,$test_id,$result); 
           $test_condition = $this->test->test_condition_ids($booking_id,$test_id);  
           //print_r($test_condition);die;
            if(!empty($test_condition))
            {
              $booking_test_list = $this->test->booking_test_list($booking_id);   
              $test_avl = '';
              //print_r($booking_test_list);die;
              foreach($test_condition as $condition)
               {   
                  if(!empty($condition->condition_val) && is_numeric($condition->condition_val))
                  {
                     if(in_array($condition->condition_val,$booking_test_list))
                      {
                         if($test_avl==1 || $test_avl == '')
                         {
                           $test_avl = 1;
                         } 
                      }
                      else
                      {
                         $test_avl = 2; 
                      }
                  } 
               } 
               
               //echo $test_avl;die;
               if($test_avl==1)
               {
                   $main_string = '';  
                   $res = 0; 
                   $condition_result = '';
                   foreach($test_condition as $condition)
                   { 
                     $total_id = $condition->test_id;
                     if(!empty($condition->condition_result))
                     { 
                       $condition_result = $condition->condition_result;
                     }

                     if(!empty($condition->condition_val))
                     {
                        if(is_numeric($condition->condition_val))
                        {
                          $test_result = $this->test->get_test_result($booking_id, $condition->condition_val);
                          if(empty($test_result))
                          {
                            $test_result = 0;
                          }
                          $main_string .= $test_result;
                        } 
                        else
                        {
                          $main_string .= $condition->condition_val;
                        }
                     } 
                     else
                     {
                       $res = 1; 
                     }
                   }
                   
                   $total_result = $this->calc_string($main_string);  
                   $split_result = str_split($condition_result);
                   $con_result = '';
                   $con_result_action = '';
                   
                   foreach($split_result as $rslt)
                   {
                     if(!is_numeric($rslt))
                     {
                       $con_result_action = $rslt;
                     }
                     else
                     {
                       $con_result .= $rslt;
                     }
                   }
                   //echo "<pre>"; print_r($condition_result);die;

                   if(!empty($con_result_action))
                   {
                     if($con_result_action=="=")
                     {
                       if($total_result==$con_result)
                       {
                          $response = array('id'=>$total_id, 'result'=>1);
                          echo json_encode($response,true);die;
                       }
                       else
                       {
                          $response = array('id'=>$total_id, 'result'=>2);
                          echo json_encode($response,true);die;
                       }
                     }
                     else if($con_result_action=="!=")
                     {
                       if($total_result!=$con_result)
                       {
                          $response = array('id'=>$total_id, 'result'=>1);
                          echo json_encode($response,true);die;
                       }
                       else
                       {
                          $response = array('id'=>$total_id, 'result'=>2);
                          echo json_encode($response,true);die;
                       }
                     }
                     else if($con_result_action=="<")
                     {
                       if($total_result<$con_result)
                       {
                          $response = array('id'=>$total_id, 'result'=>1);
                          echo json_encode($response,true);die;
                       }
                       else
                       {
                          $response = array('id'=>$total_id, 'result'=>2);
                          echo json_encode($response,true);die;
                       }
                     }

                     else if($con_result_action==">")
                     { 
                       if($total_result>$con_result)
                       { 
                          $response = array('id'=>$total_id, 'result'=>1);
                          echo json_encode($response,true);die;
                       }
                       else
                       {
                          $response = array('id'=>$total_id, 'result'=>2);
                          echo json_encode($response,true);die;
                       }
                     }
                     else
                     { 
                        if(is_numeric($condition_result) && is_numeric($result))
                        {
                           if($condition_result!=$total_result)
                           {
                             $response = array('id'=>$total_id, 'result'=>2);
                             echo json_encode($response,true);die;
                           }
                           else
                           {
                            $response = array('id'=>$total_id, 'result'=>1);
                             echo json_encode($response,true);die;
                           }
                        }
                     }

                   }
                   else
                     { 
                        if(is_numeric($condition_result) && is_numeric($result))
                        {
                           if($condition_result!=$total_result)
                           {
                             $response = array('id'=>$total_id, 'result'=>2);
                             echo json_encode($response,true);die;
                           }
                           else
                           {
                            $response = array('id'=>$total_id, 'result'=>1);
                             echo json_encode($response,true);die;
                           }
                        }
                     } 
               }
 
      }
 
     }
  }
 

    public function check_doctor_type($type="",$id="",$action="")
    {
      $this->session->unset_userdata('booking_doctor_type');
      if(!empty($id) && $id>0)
      {
        $result_list = $this->test->get_doctors($id,$type); 
        if(!empty($result_list))
        {
          $this->session->set_userdata('booking_doctor_type',$result_list);
          $booking_doctor_type = $this->session->userdata('booking_doctor_type');
          $result= 1;  
        } 
        else
        {
          $result= 2;
        }
      }
      else
      {
         $result= 0;
      }

      if(empty($action))
      {
        echo $result;
      }
    }

    public function make_master_price($rate)
    {
      $master_rate = $rate;
      $booking_doctor_type = $this->session->userdata('booking_doctor_type');
      if(!empty($booking_doctor_type))
          {  
             if($booking_doctor_type[0]['master_type']==1)
             { 
               $master_rate = (($rate/100)*$booking_doctor_type[0]['master_rate'])+$rate;
               
             }
             else
             {
               $master_rate = $booking_doctor_type[0]['master_rate']+$rate;
             }
             
          }
        return  number_format($master_rate, 2, '.', '');
      //return number_format($master_rate,2);
    }

    public function make_base_price($profile_base_rate)
    { 
      $booking_doctor_type = $this->session->userdata('booking_doctor_type'); 
      $this->load->model('test_price/test_price_model','test_price');
      if(isset($booking_doctor_type[0]['id']) && !empty($booking_doctor_type[0]['id']))
          {
            $rate_plan_data = $this->test_price->doctor_rate_plan($booking_doctor_type[0]['id']);
            if(!empty($rate_plan_data))
              {
                /* Doctor Base rate */
                if($rate_plan_data[0]->base_type==1)
                  {
                    $pos_base = strpos($rate_plan_data[0]->base_rate,'-');
                    if ($pos_base === true) 
                       {
                          $base_rate = str_replace('-', '',$rate_plan_data[0]->base_rate);
                          $base_rate = $profile_base_rate-(($profile_base_rate/100)*$rate_plan_data[0]->base_rate);
                       }
                    else
                       {
                            $base_rate = str_replace('+', '',$rate_plan_data[0]->base_rate);
                            $base_rate = $profile_base_rate+(($profile_base_rate/100)*$rate_plan_data[0]->base_rate); 
                       }

                    }
                    else
                    {
                        $pos_base = strpos($rate_plan_data[0]->base_rate,'-');
                         if ($pos_base === true) 
                         {
                            $base_rate = str_replace('-', '',$rate_plan_data[0]->base_rate);
                            $base_rate = $profile_base_rate-$rate_plan_data[0]->base_rate;
                         }
                         else
                         {
                              $base_rate = str_replace('+', '',$rate_plan_data[0]->base_rate);
                              $base_rate = $profile_base_rate+$rate_plan_data[0]->base_rate;
                         }
                    }
                    //////////////////////////
                }
                else
                {
                  $base_rate = $profile_base_rate;
                }
                $profile_base_rate = $base_rate;
              }  
        return  number_format($profile_base_rate, 2, '.', ''); 
    }

    


    public function print_test_booking_report($id="")
    {
       unauthorise_permission(149,902);
        $data['page_title'] = "Print Test Booking";
        $test_booking_id= $this->session->userdata('test_booking_id');
        //profile and print name
        $profile_master_status = get_profile_print_status('print_booking');
  $profile_print_status = $profile_master_status->profile_status;
  $print_name_status = $profile_master_status->print_status;

        if(!empty($id))
        {
          $test_booking_id = $id;
        }
        else if(isset($test_booking_id) && !empty($test_booking_id))
        {
          $test_booking_id =$test_booking_id;
        }
        else
        {
          $test_booking_id = '';
        } 

        $booking_data = $this->test->get_by_id($test_booking_id); 
        $get_by_id_data = $this->test->get_all_detail_print($test_booking_id, $booking_data['branch_id']);
        $get_profile_list = $this->test->get_booking_profile($test_booking_id);
		//echo "<pre>";print_r($get_by_id_data);die;
        $template_format = $this->test->template_format(array('section_id'=>3,'types'=>2), $booking_data['branch_id']); 

        $data['home_collection']=$this->test->get_home_collection_data();
        $data['template_data']=$template_format;
        $data['all_detail']= $get_by_id_data;
        $data['all_profile']= $get_profile_list;
        //echo "<pre>";print_r($data['all_profile']);die;
         
        //print '<pre>';print_r($get_by_id_data); exit;
        //print '<pre>';print_r($data['all_detail']); exit;
        $this->load->view('pathology_appointment/print_test_template',$data);
    }

     

    public function report_html_height($part="")
    {  
       ob_flush();
       $data['html'] = $this->test->report_html_template($part); 
       
       $this->load->view('pathology_appointment/report_html_height',$data); 
         
    }

    public function write_height($height="")
    {
       $this->session->set_userdata('part_height',$height);
    }
    
    
    public function print_test_report($booking_id='',$type='',$print_option='')
    {
   
      $suggestions_data=array(); 
      $this->load->model('test_report_verify/test_report_verify_model');
      $report_break_setting = $this->test_report_verify_model->branch_report_setting(); 
      if(!empty($report_break_setting))
      {
        $report_break_status = $report_break_setting->report_break;
      }
      else
      {
        $report_break_status = 0;
      }
       //echo "<pre>";print_r($report_break_setting);die;
      $profile_master_status = get_profile_print_status('print_booking');
      $profile_print_status = $profile_master_status->profile_status;
      $print_name_status = $profile_master_status->print_status;
      if(!empty($booking_id)) 
      {  
        //$booked_total_department = $this->test->booked_total_department($booking_id);;
        $test_heading_interpretation = '';
        $book_data = $this->test->get_by_id($booking_id);
        $this->load->library('m_pdf');
        $report_templ_part = $this->test->report_html_template('',$book_data['branch_id']);

        $get_by_id_data = $this->test->test_booking_print($booking_id, $book_data['branch_id']);        
        $booking_data = $get_by_id_data['booking_list'][0];
        //echo "<pre>"; print_r($booking_data); die;
        $test_head_list = $get_by_id_data['booking_list']['test_head_list']; 
        //echo "<pre>";print_r($test_head_list);die;
        $pdf_data['signature_data'] = $get_by_id_data['booking_list']['signature_data'];
        
        //print '<pre>'; print_r($pdf_data['signature_data']); exit;
        $profile_id = $booking_data->profile_id;
        $profile_name = $booking_data->profile_name;
        $profile_interpretation = $book_data['profile_interpretation'];
        $patient_code = $booking_data->patient_code;
        $address = $booking_data->address;
        $pincode = $booking_data->pincode;
        $lab_reg_no = $booking_data->lab_reg_no;
        $attended_doctor = $booking_data->attended_doctor;
        $sample_collected_by = $booking_data->sample_collected_by;

        $employee_data = get_employee($sample_collected_by);
        //echo "<pre>"; print_r($employee_data['name']); exit;
        $staff_refrenace_id = $booking_data->staff_refrenace_id;
        $dept_id = $booking_data->dept_id;
        $total_amount = $booking_data->total_amount;
        $net_amount = $booking_data->net_amount;
        $total_master_amount = $booking_data->total_master_amount;
        $master_net_amount = $booking_data->master_net_amount;
        $total_base_amount = $booking_data->total_base_amount;
        $base_net_amount = $booking_data->base_net_amount;
        $paid_amount = $booking_data->paid_amount;
        $discount = $booking_data->discount;
        $balance = $booking_data->balance;
        $booking_code = $booking_data->booking_code;
        $patient_name = $booking_data->patient_name;
        $ref_by_other = $booking_data->ref_by_other;
        if($booking_data->complation_status==1) //completion time
        {
            $report_date = date('d-m-Y', strtotime($booking_data->complation_date)).' '. date('h:i A', strtotime($booking_data->complation_time));
            $report_time ='';
        }
        else
        {
            $report_date = ' ';
            $report_time = ' ';
        }
        if((!empty($booking_data->verify_date) && $booking_data->verify_date!='null') && $booking_data->verify_status==1) //completion time
        {
            $verify_date = date('d-m-Y h:i:A', strtotime($booking_data->verify_date));
            
        }
        else
        {
            $verify_date = ' ';
        }
        if((!empty($booking_data->delivered_date) && $booking_data->delivered_date!='null') && $booking_data->delivered_status==1) //completion time
        {
            $delivered_date = date('d-m-Y h:i:A', strtotime($booking_data->delivered_date));
            //$delivered_time
        }
        else
        {
            $delivered_date = ' ';
        }

        if(!empty($booking_data->sample_collected_date) && $booking_data->sample_collected_date!='null') //completion time
        {
            $sample_collected_date = date('d-m-Y h:i:A', strtotime($booking_data->sample_collected_date));
            //$delivered_time
        }
        else
        {
            $sample_collected_date = ' ';
        }

        if(!empty($booking_data->sample_received_date) && $booking_data->sample_received_date!='null') //completion time
        {
            $sample_received_date = date('d-m-Y h:i:A', strtotime($booking_data->sample_received_date));
            //$delivered_time
        }
        else
        {
            $sample_received_date = ' ';
        }
        

        $mobile_no = $booking_data->mobile_no;
        $tube_no = $booking_data->tube_no;
        $gender = $booking_data->gender;
        $age_y = $booking_data->age_y;
        $age_m = $booking_data->age_m;
        $age_d = $booking_data->age_d;
        $age_h = $booking_data->age_h;
        $booking_date = $booking_data->booking_date;
        $booking_time = $booking_data->booking_time;
        $genders = array('0'=>'F','1'=>'M');
        $gender = $genders[$gender];
        $signature_image = get_doctor_signature($attended_doctor);
        $file_name="";
        $signature="";
        if(!empty($signature_image))
        {
          $signature = $signature_image->signature;
          $signature_image = $signature_image->sign_img;
          $file_name = UPLOAD_FS_FOOTER_IMAGES.$signature_image;
          
        }

        $age = "";
        if($age_y>0)
        {
        $year = 'Y';
        if($age_y==1)
        {
          $year = 'Y';
        }
        $age .= $age_y." ".$year;
        }
        if($age_m>0)
        {
        $month = 'M';
        if($age_m==1)
        {
          $month = 'M';
        }
        $age .= ", ".$age_m." ".$month;
        }
        if($age_d>0)
        {
        $day = 'D';
        if($age_d==1)
        {
          $day = 'D';
        }
        $age .= ", ".$age_d." ".$day;
        }
        if($age_h>0)
        {
        $hours = 'H';
        if($age_h==1)
        {
          $hours = 'H';
        }
        $age .= $age_h." ".$hours;
        }
        $patient_age =  $age; 
        $doctor_name = get_doctor_name($attended_doctor);
        $qualification= get_doctor_qualifications($attended_doctor);
      /*******Format***********/
      $template_format = $this->test->test_report_template_format(array('setting_name'=>'TEST_REPORT_PRINT_SETTING','unique_id'=>1));
      /**********Format********/
       
      $test_report_data ='<div class="row" style="float:left;width:100%;min-height:100px;clear:both;margin-top:1em;border:0px solid #111;border-top:none;"> 
      <table width="100%" cellpadding="0" cellspacing="0" border="0" style="float:left;border-collapse:collapse;">
         <thead>
            <tr>
               <td colspan="4"></td>
            </tr>
         </thead>
         <tbody>
         </tbody></table>';
///////////////////////////////////////  profile      //////////////////////
  /**********Profile***************/
  //$booked_profile_data = $this->test->get_booking_profile($test_headlist->booking_id); 
$booked_profile_data = $this->test->get_booking_profile_print_name($booking_id); 
//echo "<pre>";print_r($booked_profile_data); exit;
  if(!empty($booked_profile_data))
  {
     $pf_i = 1;
     foreach($booked_profile_data as $booked_profl)
      {
       /*print and name*/

      if($profile_print_status==1 && $print_name_status==1)
            {
              if(!empty($booked_profl->print_name))
              {
                $profilename = $booked_profl->profile_name.' ('.$booked_profl->print_name.')';
              }
              else
              {
                $profilename = $booked_profl->profile_name;
              }
            }
            elseif($profile_print_status==1 && $print_name_status==0)
            {
              $profilename = $booked_profl->profile_name;
            }
            elseif($profile_print_status==0 && $print_name_status==1)
            {
            if(!empty($booked_profl->print_name))
            {
              $profilename = $booked_profl->print_name;
            }
            else
            {
              $profilename = $booked_profl->profile_name;
            }

            }
            elseif($profile_print_status==0 && $print_name_status==0)
            {
              $profilename = $booked_profl->profile_name;
            }
            //echo $profilename; die;
            /* profile name */        
//$test_headlist->booking_id
$profile_test_data_list = get_all_profile_test_list($booking_id,$test_headlist->thead_id,$booked_profl->profile_id);


          $profile_interpretation = '';
          if(!empty($profile_test_data_list))
          { //$test_headlist->booking_id
            $profile_interpretation_data = $this->test->get_profile_interpretation($booking_id,$booked_profl->profile_id);
            
            if(!empty($profile_interpretation_data))
            {
              $profile_interpretation = $profile_interpretation_data->interpretation;
            }

            $pf_i_break = ""; 
            if($report_break_status==0 && $pf_i>1)
            {
                $pf_i_break = "page-break-inside:avoid";
            }

            if($report_break_status==2 && $pf_i>1)
            {
                $test_report_data .= "<pagebreak />";
                //$pf_i_break = "page-break-after:avoid";
            }
            
           
            $test_report_data .='<table width="100%" cellpadding="0" cellspacing="0" border="0" style="float:left;border-collapse:collapse; '.$pf_i_break.' "><tr><th colspan="4"><span class="test_head_name" style="width:100%; padding-top:20px; text-align:center; text-decoration:underline; font-size:12px; font-weight:bold; margin-top:1em; margin-bottom:1em;">'.$profilename.'</span></th></tr>
            ';


            $test_report_data .='<thead>
                 <tr>
                     <th align="left" style="font-size: small;padding:5px; border:1px solid #111;border-left:none; border-right:none; width:35%;">Parameter</th>
                     <th align="left" style="font-size: small;padding:5px; border:1px solid #111;border-left:none;width:20%; border-right:none; ">Result</th>
                     <th align="left" style="font-size: small;padding:5px;border:1px solid #111;border-left:none;width:20%; border-right:none; ">Unit</th>
                     <th align="left" style="font-size: small;padding:5px;border:1px solid #111;border-left:none;border-right:none;width:25%;">Reference Range</th>
                  </tr>
               </thead>
               <tbody>';
             
            $j=0;
            $profile_check_array = array();
            foreach ($profile_test_data_list as $profile_test_list) 
            { 
                    // $child_ids
                    $child_ids_array =array();
                    $child_ids_array = $this->test->getChildtest($profile_test_list->test_id,$j);
                    $style='';
                    if($profile_test_list->test_type_id=='1' || count($child_ids_array) > 0)
                    {
                      $style = 'font-weight:bold; ';
                    }
                    $test_type_id = $profile_test_list->test_type_id;
                    if(is_numeric($profile_test_list->result))
                    {
                        $test_list1 = $this->check_test_result_range($profile_test_list->booking_id,$profile_test_list->test_id,$profile_test_list->result);


                          if(!empty($test_list1))
                              {
                                
                                $range_val =  $test_list1[0]->range_from_pre.' '.$test_list1[0]->range_from.' '.$test_list1[0]->range_from_post.' - '.$test_list1[0]->range_to_pre.' '.$test_list1[0]->range_to.' '.$test_list1[0]->range_to_post;
                                if(!empty($test_list1['range_result']))
                                {
                                  $range_val = $range_val.'('.$test_list1['range_result'].')';
                                }

                              }
                              else
                              {
                                $range_val =  $profile_test_list->range_from_pre.' '.$profile_test_list->range_from.' '.$profile_test_list->range_from_post.' - '.$profile_test_list->range_to_pre.' '.$profile_test_list->range_to.' '.$profile_test_list->range_to_post; 
                              }

            $test_result="";
            if(!empty($test_list1))
            {

              if($profile_test_list->result > $test_list1[0]->range_to && !empty($profile_test_list->result) && !empty($test_list1[0]->range_to))
            {
                $high_text=get_setting_value('TEST_RANGE_HIGH');
                $test_result='';
                if(!empty($high_text) && !empty($profile_test_list->result))
                {
                  $test_result="(".$high_text.")";  
                }
                $test_result_val = '<strong>'.$profile_test_list->result.'</strong>';
            }
            elseif($profile_test_list->result < $test_list1[0]->range_from && !empty($profile_test_list->result) && !empty($test_list1[0]->range_from))
            {
              $low_text=get_setting_value('TEST_RANGE_LOW');
              $test_result='';
              if(!empty($low_text) && !empty($profile_test_list->result))
              {
                $test_result="(".$low_text.")";  
              }

              $test_result_val = '<strong>'.$profile_test_list->result.'</strong>';
            }
            else
            {
              $test_result="";
              $test_result_val = $profile_test_list->result;
            }


            

            }
            else if($profile_test_list->result > $profile_test_list->range_to && !empty($profile_test_list->result) && !empty($profile_test_list->range_to))
                          {
                            $high_text=get_setting_value('TEST_RANGE_HIGH');
                            $test_result='';
                            if(!empty($high_text))
                            {
                              $test_result="(".$high_text.")";  
                            }
                            
                            $test_result_val = '<strong>'.$profile_test_list->result.'</strong>';
                          }
                          elseif($profile_test_list->result < $profile_test_list->range_from && !empty($profile_test_list->result) && !empty($profile_test_list->range_from ))
                          {
                            $low_text=get_setting_value('TEST_RANGE_LOW');
                            $test_result='';
                            if(!empty($low_text))
                            {
                              $test_result="(".$low_text.")";  
                            }
                            
                            $test_result_val = '<strong>'.$profile_test_list->result.'</strong>';
                          }
                          else
                          {
                            $test_result="";
                            $test_result_val = $profile_test_list->result;
                          }
                          $result_style = '';
                  }
                  else
                  {
                     $range_val =  $profile_test_list->range_from_pre.' '.$profile_test_list->range_from.' '.$profile_test_list->range_from_post.' - '.$profile_test_list->range_to_pre.' '.$profile_test_list->range_to.' '.$profile_test_list->range_to_post; 

                         $default_value = get_default_val(1,$profile_test_list->result);
                         $default_value_2 = get_default_val_to_test($profile_test_list->result,2,$test_list->test_id);
                         $default_value_3 = get_default_val_to_test($profile_test_list->result,3);
                         //echo "<pre>";print_r($default_value_3);die;
                         $def_val_3_test = array_unique(array_column($default_value_3, 'test_id')); 
                         
                        //echo "<pre>";print_r($def_val_3_test);die;
                         if(!empty($default_value_2))
                         {
                            $result_style = 'font-weight:bold;';
                         }
                         else if(!empty($default_value_3) && !in_array($profile_test_list->test_id, $def_val_3_test))
                         {
                           $result_style = 'font-weight:bold;';
                         }
                         else if(in_array($profile_test_list->result, $default_value))
                         {
                            $result_style = 'font-weight:bold;';
                         }
                         else
                         {
                            $result_style = '';
                         }

                    
                     $test_result_val = $profile_test_list->result;
                     $test_result="";
                  }
              

                
                if(!in_array($profile_test_list->test_id, $profile_check_array))
                {      
                    $test_report_data .='<tr>
                         <td style="'.$style.' text-align:left;font-size: small;padding:5px;width:35%;text-align:left;">'.$profile_test_list->test_name.'</td>
                         <td style="font-size: small;padding:5px;text-align:left;'.$result_style.'width:20%;">'.$test_result_val.' '.$test_result.'</td>
                         <td style="font-size: small;padding:5px;width:20%;text-align:left;">'.unite_name($profile_test_list->unit_id).'</td>
                         <td style="font-size: small;padding:5px;width:25%;text-align:left;">'.$range_val.'</td>
                      </tr>';
                      /**********New*****************/
                     if($template_format->method==1 && !empty($profile_test_list->test_method))
                      {
                      $test_report_data .='<tr>
                         <td style="'.$style.' text-align:left;font-size: 8px;padding:5px;width:25%;text-align:left;"><b>Method</b>- '.$profile_test_list->test_method.'</td>
    
                      </tr>';
                    }
                    if($template_format->sample_type==1 && !empty($profile_test_list->sample_type))
                    {
                      $test_report_data .='<tr>
                   
                         <td style="'.$style.' text-align:left;font-size: 8px;padding:5px;width:25%;text-align:left;"><b>Sample</b>- '.$profile_test_list->sample_type.'</td>
    
                      </tr>';
                    }
                      /**********New*****************/



        // Profile Interpretation Start /////////              
        //echo "<pre>";print_r($profile_test_list);die;
      if($profile_test_list->interpretation==1)   
      {             
        $multi_interpretation_data = test_multi_interpration($profile_test_list->test_id);
      
        if(!empty($profile_test_list->adv_interpretation_status) && $profile_test_list->adv_interpretation_status==1)
        {     
           $test_report_data .='<tr>
                   <td colspan="4" style="text-align:left;">
                      <div style="float:left;width:100%;margin:0;padding:0px 4px;">
                         <div style="font-size:small;line-height:18px;">
                         '.$profile_test_list->interpratation_data.'
                         </div>
                      </div>
                   </td>
                </tr>'; 
            //echo $test_report_data;die;   
        }  
        else if(!empty($multi_interpretation_data))
        {
            $multi_inter_condition_arr = array_column($multi_interpretation_data, 'range_condition');
           
           if(in_array('0',$multi_inter_condition_arr))
           {
              $multi_int_key = array_search('0',$multi_inter_condition_arr);
              $inter_data = test_multi_interpration($profile_test_list->test_id,'0');  
              $test_report_data .='<tr>
                   <td colspan="4" style="text-align:left;">
                      <div style="float:left;width:100%;margin:0;padding:0px 4px;">
                         <div style="font-size:small;line-height:18px;">
                         '.$inter_data[0]['interpration'].'
                         </div>
                      </div>
                   </td>
                </tr>';
           }

           else if(in_array('1',$multi_inter_condition_arr) && !empty($profile_test_list->result) && $profile_test_list->result > $profile_test_list->range_to)
           {
              $multi_int_key = array_search('1',$multi_inter_condition_arr);
              $inter_data = test_multi_interpration($profile_test_list->test_id,'1'); 
              $test_report_data .='<tr>
                   <td colspan="4" style="text-align:left;">
                      <div style="float:left;width:100%;margin:0;padding:0px 4px;">
                         <div style="font-size:small;line-height:18px;">
                         '.$inter_data[0]['interpration'].'
                         </div>
                      </div>
                   </td>
                </tr>';
           }
           else if(in_array('3',$multi_inter_condition_arr) && !empty($profile_test_list->result) && $profile_test_list->result < $profile_test_list->range_from)
           {   
              $inter_data = test_multi_interpration($profile_test_list->test_id,'3'); 
              $test_report_data .='<tr>
                   <td colspan="4" style="text-align:left;">
                      <div style="float:left;width:100%;margin:0;padding:0px 4px;">
                         <div style="font-size:small;line-height:18px;">
                         '.$inter_data[0]['interpration'].'
                         </div>
                      </div>
                   </td>
                </tr>';
              //echo $test_heading_interpretation;die;
           } 
           else
           { 
              $multi_int_key = array_search('2',$multi_inter_condition_arr);
              $inter_data = test_multi_interpration($profile_test_list->test_id,'2'); 
              $test_report_data .='<tr>
                   <td colspan="4" style="text-align:left;">
                      <div style="float:left;width:100%;margin:0;padding:0px 4px;">
                         <div style="font-size:small;line-height:18px;">
                         '.$inter_data[0]['interpration'].'
                         </div>
                      </div>
                   </td>
                </tr>';
          } 
        } 
        else
        { 
           if(!empty($profile_test_list->interpratation_data))
           {
             $test_report_data .='<tr>
               <td colspan="4"  style="text-align:left;">
                  <div style="float:left;width:100%;margin:0;padding:0px 4px;">
                     <div style="font-size:small;line-height:18px;">
                     '.$profile_test_list->interpratation_data.'
                     </div>
                  </div>
               </td>
            </tr>';
           }   
        }
       }
         
       // Profile Interpretation End /////////     

        }
                $profile_check_array[] =  $profile_test_list->test_id;

                

            

         

          }

           if(!empty($profile_interpretation))
          {
            $test_report_data .='<tr>
                   <td colspan="4"  style="text-align:left;">
                      <div style="float:left;width:100%;margin:0;padding:0px 4px;">
                         <div style="font-size:small;line-height:18px;">
                         '.$profile_interpretation.'</div>
                      </div>
                   </td>
                </tr>';  
          }

          

           $j++;

           $test_report_data .='</tbody></table>';  
           $pf_i++;
           if($report_break_status==2)
          {
            //$test_report_data .= '<page_break>';
          }
          }





          //////////// Set Child Profile Data ////////////////////////
          
      $booked_cprofile_data = $this->test->get_booking_profile_print_name($booking_id,$booked_profl->profile_id);   
      //echo "<pre>"; print_r($booked_cprofile_data);die;
      if(!empty($booked_cprofile_data) && $booked_cprofile_data!='')
      { 
         foreach($booked_cprofile_data as $booked_cprofl)
          {  
            if($report_break_status==2)
            {
                $test_report_data .= "<pagebreak />";
                //$pf_i_break = "page-break-after:avoid";
            }
      /*print and name*/
      if($profile_print_status==1 && $print_name_status==1)
            {
              if(!empty($booked_cprofl->print_name))
              {
                $profilename = $booked_cprofl->profile_name.' ('.$booked_cprofl->print_name.')';
              }
              else
              {
                $profilename = $booked_cprofl->profile_name;
              }
            }
            elseif($profile_print_status==1 && $print_name_status==0)
            {
              $profilename = $booked_cprofl->profile_name;
            }
            elseif($profile_print_status==0 && $print_name_status==1)
            {
            if(!empty($booked_cprofl->print_name))
            {
              $profilename = $booked_cprofl->print_name;
            }
            else
            {
              $profilename = $booked_cprofl->profile_name;
            }

            }
            elseif($profile_print_status==0 && $print_name_status==0)
            {
              $profilename = $booked_cprofl->profile_name;
            }
            //echo $profilename; die;
            /* profile name */        
        //$test_headlist->booking_id
        $profile_test_data_list = get_all_profile_test_list($booking_id,$test_headlist->thead_id,$booked_cprofl->profile_id);
        //echo "<pre>"; print_r($profile_test_data_list);die;
          $profile_interpretation = '';
          if(!empty($profile_test_data_list))
          { //$test_headlist->booking_id
            $profile_interpretation_data = $this->test->get_profile_interpretation($booking_id,$booked_cprofl->profile_id);
            //print_r($profile_interpretation_data);die;
            if(!empty($profile_interpretation_data))
            {
              $profile_interpretation = $profile_interpretation_data->interpretation;
            } 
            //<div style="float:left;width:100%;text-align:center;text-decoration:underline;font-size:medium;font-weight:bold;margin-bottom:0.5em;">'.$profilename.'</div>
            $test_report_data .='<table width="100%" cellpadding="0" cellspacing="0" border="0" style="float:left;border-collapse:collapse;   page-break-inside:avoid"><tr><th colspan="4"><span class="test_head_name" style="width:100%; padding-top:20px; text-align:center; text-decoration:underline; font-size:12px; font-weight:bold; margin-top:1em; margin-bottom:1em;">'.$profilename.'</span></th></tr>';
             

              $test_report_data .='<thead>
                   <tr>
                       <th align="left" style="font-size: small;padding:5px; border:1px solid #111;border-left:none; border-right:none; width:35%;">Parameter</th>
                       <th align="left" style="font-size: small;padding:5px; border:1px solid #111;border-left:none;width:20%; border-right:none; ">Result</th>
                       <th align="left" style="font-size: small;padding:5px;border:1px solid #111;border-left:none;width:20%; border-right:none; ">Unit</th>
                       <th align="left" style="font-size: small;padding:5px;border:1px solid #111;border-left:none;border-right:none;width:25%;">Reference Range</th>
                    </tr>
                 </thead><tbody>'; 
             
            $j=0;
            $pfc_i =1;
            $pf_i_break = "";
            $profile_check_array = array();
            foreach ($profile_test_data_list as $profile_test_list) 
            {  
                  if($report_break_status==0)
                  {
                    $pf_i_break = "page-break-inside:avoid";
                  }
                  
               
                
              
                    // $child_ids
                    $child_ids_array =array();
                    $child_ids_array = $this->test->getChildtest($profile_test_list->test_id,$j);
                    $style='';
                    if($profile_test_list->test_type_id=='1' || count($child_ids_array) > 0)
                    {
                      $style = 'font-weight:bold; ';
                    }
                    $test_type_id = $profile_test_list->test_type_id;
                    if(is_numeric($profile_test_list->result))
                    {
                        $test_list1 = $this->check_test_result_range($profile_test_list->booking_id,$profile_test_list->test_id,$profile_test_list->result);
                        
                          

                          if(!empty($test_list1))
                              {
                                
                                //$range_val =  $test_list1[0]->range_from_pre.' '.$test_list1[0]->range_from.' '.$test_list1[0]->range_from_post.' - '.$test_list1[0]->range_to_pre.' '.$test_list1[0]->range_to.' '.$test_list1[0]->range_to_post;
								$range_val =  $test_list1[0]->range_from_pre.' '.$test_list1[0]->range_from.' '.$test_list1[0]->range_from_post.' - '.$test_list1[0]->range_to_pre.' '.$test_list1[0]->range_to.' '.$test_list1[0]->range_to_post;
                                if(!empty($test_list1['range_result']))
                                {
                                  $range_val = $range_val.'('.$test_list1['range_result'].')';
                                }

                              }
                              else
                              {
                                //$range_val =  $test_list->range_from_pre.' '.$test_list->range_from.' '.$test_list->range_from_post.' - '.$test_list->range_to_pre.' '.$test_list->range_to.' '.$test_list->range_to_post;
								$range_val =  $profile_test_list->range_from_pre.' '.$profile_test_list->range_from.' '.$profile_test_list->range_from_post.' - '.$profile_test_list->range_to_pre.' '.$profile_test_list->range_to.' '.$profile_test_list->range_to_post; 
                              }

                          $test_result="";
                          
                          if(!empty($test_list1))
                        {
            
                          if($profile_test_list->result > $test_list1[0]->range_to && !empty($profile_test_list->result) && !empty($test_list1[0]->range_to))
                        {
                            $high_text=get_setting_value('TEST_RANGE_HIGH');
                            $test_result='';
                            if(!empty($high_text) && !empty($profile_test_list->result))
                            {
                              $test_result="(".$high_text.")";  
                            }
                            $test_result_val = '<strong>'.$profile_test_list->result.'</strong>';
                        }
                        elseif($profile_test_list->result < $test_list1[0]->range_from && !empty($profile_test_list->result) && !empty($test_list1[0]->range_from))
                        {
                          $low_text=get_setting_value('TEST_RANGE_LOW');
                          $test_result='';
                          if(!empty($low_text) && !empty($profile_test_list->result))
                          {
                            $test_result="(".$low_text.")";  
                          }
            
                          $test_result_val = '<strong>'.$profile_test_list->result.'</strong>';
                        }
                        else
                        {
                          $test_result="";
                          $test_result_val = $profile_test_list->result;
                        }
            
            
                        
            
                        }
                        else if($profile_test_list->result > $profile_test_list->range_to && !empty($profile_test_list->result) && !empty($profile_test_list->range_to))
                          {
                            $high_text=get_setting_value('TEST_RANGE_HIGH');
                            $test_result='';
                            if(!empty($high_text))
                            {
                              $test_result="(".$high_text.")";  
                            }
                            
                            $test_result_val = '<strong>'.$profile_test_list->result.'</strong>';
                          }
                          elseif($profile_test_list->result < $profile_test_list->range_from && !empty($profile_test_list->result) && !empty($profile_test_list->range_from))
                          {
                            $low_text=get_setting_value('TEST_RANGE_LOW');
                            $test_result='';
                            if(!empty($low_text))
                            {
                              $test_result="(".$low_text.")";  
                            }
                            
                            $test_result_val = '<strong>'.$profile_test_list->result.'</strong>';
                          }
                          else
                          {
                            $test_result="";
                            $test_result_val = $profile_test_list->result;
                          }
                          $result_style = '';
                  }
                  else
                  {
                     $range_val =  $profile_test_list->range_from_pre.' '.$profile_test_list->range_from.' '.$profile_test_list->range_from_post.' - '.$profile_test_list->range_to_pre.' '.$profile_test_list->range_to.' '.$profile_test_list->range_to_post; 

                         $default_value = get_default_val(1,$profile_test_list->result);
                         $default_value_2 = get_default_val_to_test($profile_test_list->result,2,$test_list->test_id);
                         $default_value_3 = get_default_val_to_test($profile_test_list->result,3);
                         //echo "<pre>";print_r($default_value_3);die;
                         $def_val_3_test = array_unique(array_column($default_value_3, 'test_id')); 
                         
                        //echo "<pre>";print_r($def_val_3_test);die;
                         if(!empty($default_value_2))
                         {
                            $result_style = 'font-weight:bold;';
                         }
                         else if(!empty($default_value_3) && !in_array($profile_test_list->test_id, $def_val_3_test))
                         {
                           $result_style = 'font-weight:bold;';
                         }
                         else if(in_array($profile_test_list->result, $default_value))
                         {
                            $result_style = 'font-weight:bold;';
                         }
                         else
                         {
                            $result_style = '';
                         }

                     
                     $test_result_val = $profile_test_list->result;
                     $test_result="";
                  }
              

                
                if(!in_array($profile_test_list->test_id, $profile_check_array))
                {      
                    $test_report_data .='<tr>
                         <td style="'.$style.' text-align:left;font-size: small;padding:5px;width:35%;text-align:left;">'.$profile_test_list->test_name.'</td>
                         <td style="font-size: small;padding:5px;text-align:left;'.$result_style.'width:20%;">'.$test_result_val.' '.$test_result.'</td>
                         <td style="font-size: small;padding:5px;width:20%;text-align:left;">'.unite_name($profile_test_list->unit_id).'</td>
                         <td style="font-size: small;padding:5px;width:25%;text-align:left;">'.$range_val.'</td>
                      </tr>';
                // Profile Interpretation Start /////////              
                //echo "<pre>";print_r($profile_test_list);die;
              if($profile_test_list->interpretation==1)   
              {             
                $multi_interpretation_data = test_multi_interpration($profile_test_list->test_id);
              
                if(!empty($profile_test_list->adv_interpretation_status) && $profile_test_list->adv_interpretation_status==1)
                {     
                   $test_report_data .='<tr>
                           <td colspan="4" style="text-align:left;">
                              <div style="float:left;width:100%;margin:0;padding:0px 4px;">
                                 <div style="font-size:small;line-height:18px;">
                                 '.$profile_test_list->interpratation_data.'
                                 </div>
                              </div>
                           </td>
                        </tr>'; 
                    //echo $test_report_data;die;   
                }  
                else if(!empty($multi_interpretation_data))
                {
                   $multi_inter_condition_arr = array_column($multi_interpretation_data, 'range_condition');
                   
                   if(in_array('0',$multi_inter_condition_arr))
                   {
                      $multi_int_key = array_search('0',$multi_inter_condition_arr);
                      $inter_data = test_multi_interpration($profile_test_list->test_id,'0');  
                      $test_report_data .='<tr>
                           <td colspan="4" style="text-align:left;">
                              <div style="float:left;width:100%;margin:0;padding:0px 4px;">
                                 <div style="font-size:small;line-height:18px;">
                                 '.$inter_data[0]['interpration'].'
                                 </div>
                              </div>
                           </td>
                        </tr>';
                   }

                   else if(in_array('1',$multi_inter_condition_arr) && !empty($profile_test_list->result) && $profile_test_list->result > $profile_test_list->range_to)
                   {
                      $multi_int_key = array_search('1',$multi_inter_condition_arr);
                      $inter_data = test_multi_interpration($profile_test_list->test_id,'1'); 
                      $test_report_data .='<tr>
                           <td colspan="4" style="text-align:left;">
                              <div style="float:left;width:100%;margin:0;padding:0px 4px;">
                                 <div style="font-size:small;line-height:18px;">
                                 '.$inter_data[0]['interpration'].'
                                 </div>
                              </div>
                           </td>
                        </tr>';
                   }
                   else if(in_array('3',$multi_inter_condition_arr) && !empty($profile_test_list->result) && $profile_test_list->result < $profile_test_list->range_from)
                   {   
                      $inter_data = test_multi_interpration($profile_test_list->test_id,'3'); 
                      $test_report_data .='<tr>
                           <td colspan="4" style="text-align:left;">
                              <div style="float:left;width:100%;margin:0;padding:0px 4px;">
                                 <div style="font-size:small;line-height:18px;">
                                 '.$inter_data[0]['interpration'].'
                                 </div>
                              </div>
                           </td>
                        </tr>';
                      //echo $test_heading_interpretation;die;
                   }
                   else
                   {
                      $multi_int_key = array_search('2',$multi_inter_condition_arr);
                      $inter_data = test_multi_interpration($profile_test_list->test_id,'2'); 
                      $test_report_data .='<tr>
                           <td colspan="4" style="text-align:left;">
                              <div style="float:left;width:100%;margin:0;padding:0px 4px;">
                                 <div style="font-size:small;line-height:18px;">
                                 '.$inter_data[0]['interpration'].'
                                 </div>
                              </div>
                           </td>
                        </tr>';
                   } 
                } 
                else
                { 
                   if(!empty($profile_test_list->interpratation_data))
                     {
                       $test_report_data .='<tr>
                         <td colspan="4"  style="text-align:left;">
                            <div style="float:left;width:100%;margin:0;padding:0px 4px;">
                               <div style="font-size:small;line-height:18px;">
                               '.$profile_test_list->interpratation_data.'
                               </div>
                            </div>
                         </td>
                      </tr>';
                     }   
                }
               }
                 
            

                }
            $profile_check_array[] =  $profile_test_list->test_id;
            $pfc_i++;
            }

            if(!empty($profile_interpretation))
            {
              $test_report_data .=' <tr>
                     <td colspan="4"  style="text-align:left;">
                        <div style="float:left;width:100%;margin:0;padding:0px 4px;">
                           <div style="font-size:small;line-height:18px;">
                           '.$profile_interpretation.'</div>
                        </div>
                     </td>
                  </tr>';  
            }

                   $j++;

                   //$test_report_data .='</tbody></table></td></tr>';  
                  }
              $test_report_data .= "</tbody></table>";
              if($report_break_status==2)
              {
                //$test_report_data .= '<pagebreak>';
              }
            }
            }      
               
          //////////// End Child Profile Data ////////////////////////
          ///$test_report_data .= '</td></tr></tbody></table>'; 
          if($report_break_status==2)
          {
            //$test_report_data .= '<pagebreak>';
          }  
      }
  }

  /**********Profile***************/


/**********Test***************/
$q=0;
if(!empty($test_head_list)) 
{    

      $th_test_list = get_all_test_list($test_head_list[0]->booking_id,$test_head_list[0]->thead_id); 
       
      if(!empty($booked_profile_data) && $report_break_status==2)
      {
          $test_report_data .= "<pagebreak />";
          //$pf_i_break = "page-break-after:avoid";
      } 
      
      if(!empty($booked_profile_data) && !empty($th_test_list))
      { 
          if($report_break_status==0)
          {
            $test_report_data .= '<pagebreak>';
          }
          
          $dept_id = $test_head_list[0]->dept_id; 
           
      }  

      $test_data_list ="";
      $test_report_data .= '';
      /* Test Head list*/ 
      $p=0;
      //echo "<pre>"; print_r($test_head_list);die;
       
      $dept_id = '';
      $d = 1;
      $th_i=1;
      $dept_id = $test_head_list[0]->dept_id;

      foreach ($test_head_list as $test_headlist) 
      { 
             $test_data_list = get_all_test_list($test_headlist->booking_id,$test_headlist->thead_id);

            if(!empty($test_headlist) && !empty($test_data_list) && $dept_id!=$test_headlist->dept_id)
            {    
               //echo $test_report_data; die; 
               if($report_break_status==0) 
               {
                $test_report_data .= ' <page_break>';
               }
                
                $dept_id = $test_list->dept_id; 
              
            } 
              
            $table_break = '';   
            if($th_i==1 && empty($booked_profile_data))
            {
              $table_break = ''; 
            }
            else
            {
              if($report_break_status==0)
              {
                $table_break = ' page-break-inside:avoid'; 
              }

            }

            if($report_break_status==2)
              {
                $table_break = ' page-break-inside:avoid'; 
              }

              
         
          //echo "<pre>";print_r($test_data_list);die;
          if(!empty($test_data_list) )
          {
            
            $test_report_data .='<table width="100%" cellpadding="0" cellspacing="0" border="0" style="float:left;border-collapse:collapse;  '.$table_break.'"><tbody><tr><th colspan="4"><span class="test_head_name" style="float:left;width:100%; text-align:center; padding-top:20px; text-decoration:underline; font-size:12px; font-weight:bold; margin-top:1em; margin-bottom:1em;">'.$test_headlist->test_heads.'</span></th></tr></table>';
            

//condition for test and test head
            $test_list_head = $this->test->test_list($test_headlist->test_id);
            $depts_ids = $test_list_head[0]->dept_id;
            if($depts_ids=='10' || $depts_ids=='11')
            {
              
            }
            else
            {
              $test_report_data .= '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="float:left;border-collapse:collapse;"><tr>
                 <th align="left" style="font-size: small;padding:5px; border:1px solid #111;border-left:none; border-right:none; width:35%;">Parameter</th>
                 <th align="left" style="font-size: small;padding:5px; border:1px solid #111;border-left:none;width:20%; border-right:none; ">Result</th>
                 <th align="left" style="font-size: small;padding:5px;border:1px solid #111;border-left:none;width:20%; border-right:none; ">Unit</th>
                 <th align="left" style="font-size: small;padding:5px;border:1px solid #111;border-left:none;border-right:none;width:25%;">Reference Range</th>
              </tr></table>';
            }
 


                  $i=0;
                  $check_array = array();
                  $heading_int='';  
                  //echo "<pre>"; print_r($test_data_list);die;
                  ///// Sort Order of test ////////
                  $test_datas_list = []; 
                  $not_in_array = [];
                
                }
                /////////////////////////////////
                 
                foreach ($test_data_list as $test_list) 
                { 
                       //echo "<pre>"; print_r($test_list);
                  
                        
                        // $child_ids
                        $child_ids_array =array();
                        //$child_ids_array = $this->test->getChildtest($test_list->test_id,$i);
                        $style='';
                        //$total_child_test = count($child_ids_array);
                        if($test_list->test_type_id=='1')
                        {
                          $style = 'style="font-weight:bold; "';
                        }
                         
                        $test_type_id = $test_list->test_type_id;
                        //print_r($test_list->result);die;
              
                        if(is_numeric($test_list->result))
                        {

                            $test_list1 = $this->check_test_result_range($test_list->booking_id,$test_list->test_id,$test_list->result);
                            
                             

                              if(!empty($test_list1))
                              {
                                
                                $range_val =  $test_list1[0]->range_from_pre.' '.$test_list1[0]->range_from.' '.$test_list1[0]->range_from_post.' - '.$test_list1[0]->range_to_pre.' '.$test_list1[0]->range_to.' '.$test_list1[0]->range_to_post;
                                if(!empty($test_list1['range_result']))
                                {
                                  $range_val = $range_val.'('.$test_list1['range_result'].')';
                                }

                              }
                              else
                              {
                                $range_val =  $test_list->range_from_pre.' '.$test_list->range_from.' '.$test_list->range_from_post.' - '.$test_list->range_to_pre.' '.$test_list->range_to.' '.$test_list->range_to_post;
                              }

                              if($test_list->all_range_show==1)
                              {
                                 $this->load->model('test_master/test_master_model','test_master');
                                 $adv_range_list = $this->test_master->advance_range_list($test_list->test_id);
                                 //echo "<pre>"; print_r($adv_range_list);die;
                                 if(!empty($adv_range_list))
                                 {
                                    $range_gender = array('0'=>'Female', '1'=>'Male');
                                    $range_age_type = array('1'=>'Days','2'=>'Months','3'=>'Years');
                                   foreach($adv_range_list as $adv_range)
                                   { 
                                      $range_val .= '<br/>'.$adv_range->range_from_pre.' '.$adv_range->range_from.' '.$adv_range->range_from_post.' - '.$adv_range->range_to_pre.' '.$adv_range->range_to.' '.$adv_range->range_from_post.'  '.$range_gender[$adv_range->gender].'/'.$adv_range->start_age.'-'.$adv_range->end_age.' '.$range_age_type[$adv_range->age_type].' ';
                                   }
                                 }

                              }
                           
                              $test_result="";

                              if(!empty($test_list1) && $test_list->result > $test_list1[0]->range_to && !empty($test_list->result) && !empty($test_list1[0]->range_to))
                              {
                                $high_text = get_setting_value('TEST_RANGE_HIGH');
                                $get_suggested_test=$this->test->get_suggested_test_for_range('1',$test_list->test_id);
                                if($get_suggested_test!="empty")
                                {
                                  foreach($get_suggested_test as $suggestion)
                                  {
                                    $ar=array();
                                    $arr['condition']="High";
                                    $arr['test_name']=$test_list->test_name;
                                    $arr['suggested_test']=$suggestion->test_name;
                                    array_push($suggestions_data, $arr);  
                                  }
                                }
                                $test_result='';
                                if(!empty($high_text))
                                {
                                  $test_result="(".$high_text.")";  
                                }
                                
                                $test_result_val = '<strong>'.$test_list->result.'</strong>';
                              }
                              elseif(!empty($test_list1) && $test_list->result < $test_list1[0]->range_from && !empty($test_list->result) && !empty($test_list1[0]->range_from))
                              {

                                $low_text = get_setting_value('TEST_RANGE_LOW');
                                $get_suggested_test_low=$this->test->get_suggested_test_for_range('2',$test_list->test_id);
                                //print_r($get_suggested_test_low);die;
                                if($get_suggested_test_low!="empty")
                                {
                                  foreach($get_suggested_test_low as $suggestion_low)
                                  {
                                    $ar=array();
                                    $arr['condition']="Low";
                                    $arr['test_name']=$test_list->test_name;
                                    $arr['suggested_test']=$suggestion_low->test_name;
                                    array_push($suggestions_data, $arr);  
                                  }
                                }
                                
                                $test_result='';
                                if(!empty($low_text))
                                {
                                  $test_result="(".$low_text.")";  
                                }
                                $test_result_val = '<strong>'.$test_list->result.'</strong>';
                              }
                              else
                              {

                                //print_r($test_list1);die;
                                $test_result="";
                                $get_suggested_test_normal=$this->test->get_suggested_test_for_range('0', $test_list->test_id );
                               if($get_suggested_test_normal!="empty")
                                {
                                  foreach($get_suggested_test_normal as $suggestion_normal)
                                  {
                                    $ar=array();
                                    $arr['condition']="Normal";
                                    $arr['test_name']=$test_list->test_name;
                                    $arr['suggested_test']=$suggestion_normal->test_name;
                                    array_push($suggestions_data, $arr);  
                                  }
                                }
                                
                                ///here need to change 16may2019
                              if(!empty($test_list1) && $test_list->result > $test_list1[0]->range_to && !empty($test_list->result) && !empty($test_list1[0]->range_to))
                              {
                                $high_text = get_setting_value('TEST_RANGE_HIGH');
                                 $test_result='';
                                if(!empty($high_text))
                                {
                                  $test_result="(".$high_text.")";  
                                }
                              }
                              elseif(!empty($test_list1) &&  $test_list->result < $test_list1[0]->range_from && !empty($test_list->result) && !empty($test_list1[0]->range_from))
                              {

                                $low_text = get_setting_value('TEST_RANGE_LOW');
                                 $test_result='';
                                if(!empty($low_text))
                                {
                                  $test_result="(".$low_text.")";  
                                }
                              }
                              else
                              {
                                  //31may 2019
                                   $test_result='';
                                    if($test_list->result > $test_list->range_to && !empty($test_list->result) && !empty($test_list->range_to))
                                    {
                                            $test_result='';
                                             $high_text = get_setting_value('TEST_RANGE_HIGH');
                                            if(!empty($high_text))
                                            {
                                              $test_result="(".$high_text.")";  
                                            }
                                            
                                           
                                      }
                                      elseif($test_list->result < $test_list->range_from && !empty($test_list->result) && !empty($test_list->range_from))
                                      {
                                           $test_result='';
                                            $low_text = get_setting_value('TEST_RANGE_LOW');
                                            if(!empty($low_text))
                                            {
                                              $test_result="(".$low_text.")";  
                                            }
                                            
                                      }
                                      else
                                      {
                                           $test_result='';
                                      } //31may 2019
                              }
                                
                                //here chnage end 16may2019

                                $test_result_val = $test_list->result;
                              }
                              $result_style = '';
                      }
                      else
                      {

                         $range_val =  $test_list->range_from_pre.' '.$test_list->range_from.' '.$test_list->range_from_post.' - '.$test_list->range_to_pre.' '.$test_list->range_to.' '.$test_list->range_to_post;
                         //echo "<pre>";print_r($test_list);die; 
                         $default_value = get_default_val(1,$test_list->result);
                         $default_value_2 = get_default_val_to_test($test_list->result,2,$test_list->test_id);
                         $default_value_3 = get_default_val_to_test($test_list->result,3);
                         //echo "<pre>";print_r($default_value_3);die;
                         $def_val_3_test = array_unique(array_column($default_value_3, 'test_id')); 
                         
                        //echo "<pre>";print_r($def_val_3_test);die;
                         if(!empty($default_value_2))
                         {
                            $result_style = 'font-weight:bold;';
                         }
                         else if(!empty($default_value_3) && !in_array($test_list->test_id, $def_val_3_test))
                         {
                           $result_style = 'font-weight:bold;';
                         }
                         else if(in_array($test_list->result, $default_value))
                         {
                            $result_style = 'font-weight:bold;';
                         }
                         else
                         {
                            $result_style = '';
                         }
                         //$range_val  = '-';//$test_list->result;
                         $test_result_val = $test_list->result;
                         $test_result="";
                      }
                  

                    
          if(!in_array($test_list->test_id, $check_array))
          { 
        $bold_class = "";
        if(!empty($style))
      {
        $bold_class= "text_box";
      }
            $test_report_data .='<table width="100%" cellpadding="0" cellspacing="0" border="0" style="float:left;border-collapse:collapse;"><tr '.$style.' class="'.$bold_class.'">
            <td style="font-size: small;padding:5px;width:35%;text-align:left;" ><b>'.$test_list->test_name.'</b></td>
            <td style="font-size: small;padding:5px;'.$result_style.'width:20%;text-align:left;">'.$test_result_val.' '.$test_result.'</td>
            <td style="font-size: small;padding:5px;width:20%;text-align:left;">'.unite_name($test_list->unit_id).'</td>
            <td style="font-size: small;padding:5px;width:25%;text-align:left;">'.$range_val.'</td>
            </tr></table>';

            /**********New*****************/
                      if($template_format->method==1 && !empty($test_list->test_method))
                      {
                      $test_report_data .='<tr>
                         <td style="'.$style.' text-align:left;font-size: 8px;padding:5px;width:25%;text-align:left;"><b>Method</b>- '.$test_list->test_method.'</td>
    
                      </tr>';
                    }
                    if($template_format->sample_type==1 && !empty($test_list->sample_type))
                    {
                      $test_report_data .='<tr>
                   
                         <td style="'.$style.' text-align:left;font-size: 8px;padding:5px;width:25%;text-align:left;"><b>Sample</b>- '.$test_list->sample_type.'</td>
    
                      </tr>';
                    }
                      /**********New*****************/
          }
          $check_array[] =  $test_list->test_id; 
      
      
      
      //echo "<pre>"; print_r($test_list);die;
      $test_heading_interpretation = '';    
      if($test_list->interpretation==1)
      {
         $multi_interpretation_data = test_multi_interpration($test_list->test_id);
        if(!empty($test_list->adv_interpretation_status) && $test_list->adv_interpretation_status==1)
          {  
             $test_heading_interpretation ='<tr><td colspan="4"> '.$test_list->interpratation_data.'</td></tr>';
          }  
          else if(!empty($multi_interpretation_data))
          {
             $multi_inter_condition_arr = array_column($multi_interpretation_data, 'range_condition');
             
             if(in_array('0',$multi_inter_condition_arr))
             {
                $multi_int_key = array_search('0',$multi_inter_condition_arr);
                $inter_data = test_multi_interpration($test_list->test_id,'0'); 
                $test_heading_interpretation ='<tr><td colspan="4">'.$inter_data[0]['interpration'].'</td></tr>';
             }

              else if(in_array('1',$multi_inter_condition_arr) && !empty($test_list->result) && $test_list->result > $test_list->range_to)
             {
                $multi_int_key = array_search('1',$multi_inter_condition_arr);
                $inter_data = test_multi_interpration($test_list->test_id,'1'); 
                $test_heading_interpretation ='<tr><td colspan="4">'.$inter_data[0]['interpration'].'</td></tr>';
             }
             else if(in_array('3',$multi_inter_condition_arr) && !empty($test_list->result) && $test_list->result < $test_list->range_from)
             {   
                $inter_data = test_multi_interpration($test_list->test_id,'3'); 
                $test_heading_interpretation ='<tr><td colspan="4"> '.$inter_data[0]['interpration'].'</td></tr>';
                //echo $test_heading_interpretation;die;
             }
             else
             {
                $multi_int_key = array_search('2',$multi_inter_condition_arr);
                $inter_data = test_multi_interpration($test_list->test_id,'2'); 
                if(!empty($inter_data[0]['interpration']))
                {
                    $test_heading_interpretation ='<tr><td colspan="4"> '.$inter_data[0]['interpration'].'</td></tr>';
                }
                
             } 
          } 
          else
          { 
            if(!empty($profile_test_list->interpratation_data))
           {
             $test_heading_interpretation ='<tr><td colspan="4">'.$test_list->interpratation_data.'</td></tr>';
           }
             
          }
      }



      if($test_list->test_type_id==1)
       {
          $test_heading_interpretation = $test_heading_interpretation;
       }
       else
       {
          $test_report_data .= $test_heading_interpretation;
          $test_heading_interpretation = '';
       }


      
     $i++;  
  }
       if(!empty($test_heading_interpretation))
            {
               $test_report_data .= $test_heading_interpretation;
               $test_heading_interpretation = '';
            } 
       $test_report_data .=$heading_int; 

      // $test_report_data .= '</body></table>';
      
      $total_th = count($test_head_list);
      if($report_break_status==2 && $total_th!=$th_i)
          {
            $test_report_data .= '<pagebreak />';
          }
      $th_i++;    
    } 
      $q++;
      
    } 

    /**********Test************/
    if($depts_ids=='10' || $depts_ids=='11')
    {
      
    }
    else
    {
      //$test_report_data .='</tbody></table></td></tr>'; 
    }

    
    
  } 
   
  
   
   $test_report_data .='</div>';
   $doctor_position="";
   $technie_position="";
//echo $test_report_data;die;
   $test_report_data = str_replace('&lt;FONT face=Cambria&gt;', ' ', $test_report_data);
   $test_report_data =  str_replace('</FONT>', ' ', $test_report_data);
   
    $signature_reprt_data ='';
    $img='';
    $img_doc='';
//echo "<pre>"; print_r($test_report_data);die;
    if(!empty($pdf_data['signature_data']))
     {
      $signature_reprt_data.='<table border="0" cellpadding="4px" cellspacing="0" width="100%" style="border-collapse: collapse;font-size:13px;margin-top: 20px;"><tr>';
       
                         
        /* condition here */
        if($template_format->doctor_signature_position==1)
        {
           if(!empty($pdf_data['signature_data'][0]->sign_doctor) && file_exists(DIR_UPLOAD_PATH.'doctor_signature/'.$pdf_data['signature_data'][0]->sign_doctor) || $pdf_data['signature_data'][0]->doctor_name!='')
           {
                     
            $signature_reprt_data.='<td align="left">';
           if(!empty($pdf_data['signature_data'][0]->sign_doctor) && file_exists(DIR_UPLOAD_PATH.'doctor_signature/'.$pdf_data['signature_data'][0]->sign_doctor) || $pdf_data['signature_data'][0]->doctor_name!=''){
        // print_r($template_format);die;
				           	if($template_format->doctor_signature_text==1)
				           	{
				           		 $signature_reprt_data.='<div><b>Signature</b></div>';
				           	}
				           	else{
				           		$signature_reprt_data.='';
				           	}

                                }
                                 if(!empty($pdf_data['signature_data'][0]->sign_doctor) && file_exists(DIR_UPLOAD_PATH.'doctor_signature/'.$pdf_data['signature_data'][0]->sign_doctor))
                                    {
                                      $img_doc='<img width="90px" src="'.ROOT_UPLOADS_PATH.'doctor_signature/'.$pdf_data['signature_data'][0]->sign_doctor.'">';
                                    }
                                    else
                                    {
                                      $img_doc='';
                                    }
                                      
                                    
                                    $signature_reprt_data.='<div>'.$img_doc.'</div>';
                                    

                                    if($pdf_data['signature_data'][0]->doctor_name!=''){
                                     $signature_reprt_data.='<div>Dr.'.$pdf_data['signature_data'][0]->doctor_name.'</div>';
                                   }
                                   
                                    $qualification= get_doctor_qualifications($attended_doctor);
                                   if(!empty($qualification))
                                   {
                                    $signature_reprt_data.='<div>'.$qualification.'</div>';
                                   }
                                   
                                   $signature_reprt_data.='</td>';
                          }

      if(!empty($pdf_data['signature_data'][0]->sign_img) && file_exists(DIR_UPLOAD_PATH.'technician_signature/'.$pdf_data['signature_data'][0]->sign_img) || $pdf_data['signature_data'][0]->signature!='')

            {
            
           $signature_reprt_data.='<td align="right">';
           if(!empty($pdf_data['signature_data'][0]->sign_img) && file_exists(DIR_UPLOAD_PATH.'technician_signature/'.$pdf_data['signature_data'][0]->sign_img) || $pdf_data['signature_data'][0]->signature!=''){
           		 	//print_r($template_format);die;
           //	print_r($template_format);die;
           						if($template_format->doctor_signature_text==1)
					           	{
					           		 $signature_reprt_data.='<div><b>Signature</b></div>';
					           	}
					           	else{
					           		$signature_reprt_data.='';
					           	}

                                 // $signature_reprt_data.='<div><b>Signature</b></div>';
                                }
                                 if(!empty($pdf_data['signature_data'][0]->sign_img) && file_exists(DIR_UPLOAD_PATH.'technician_signature/'.$pdf_data['signature_data'][0]->sign_img))
                                    {
                                      $img='<img width="90px" src="'.ROOT_UPLOADS_PATH.'technician_signature/'.$pdf_data['signature_data'][0]->sign_img.'">';
                                    }
                                    else
                                    {
                                      $img='';
                                    }
                                      
                                    
                                    $signature_reprt_data.='<div>'.$img.'</div>';
                                    

                                    if($pdf_data['signature_data'][0]->signature!=''){
                                     $signature_reprt_data.='<div>'.$pdf_data['signature_data'][0]->signature.'</div>';
                                   }
                                    
                                   $signature_reprt_data.='</td>';
                               }    

         }
         else
         {


          if(!empty($pdf_data['signature_data'][0]->sign_img) && file_exists(DIR_UPLOAD_PATH.'technician_signature/'.$pdf_data['signature_data'][0]->sign_img) || $pdf_data['signature_data'][0]->signature!='')
            {
            
            $signature_reprt_data.='<td align="left">';
           if(!empty($pdf_data['signature_data'][0]->sign_img) && file_exists(DIR_UPLOAD_PATH.'technician_signature/'.$pdf_data['signature_data'][0]->sign_img) || $pdf_data['signature_data'][0]->signature!=''){
           			 //	print_r($template_format);die;
						           	if($template_format->doctor_signature_text==1)
						           	{
						           		$signature_reprt_data.='<div><b>Signature</b></div>';
						           	}
						           	else{
						           		$signature_reprt_data.='';
						           	}
                                //  $signature_reprt_data.='<div><b>Signature</b></div>';
                                }
                                 if(!empty($pdf_data['signature_data'][0]->sign_img) && file_exists(DIR_UPLOAD_PATH.'technician_signature/'.$pdf_data['signature_data'][0]->sign_img))
                                    {
                                      $img='<img width="90px" src="'.ROOT_UPLOADS_PATH.'technician_signature/'.$pdf_data['signature_data'][0]->sign_img.'">';
                                    }
                                    else
                                    {
                                      $img='';
                                    }
                                      
                                    
                                    $signature_reprt_data.='<div>'.$img.'</div>';
                                    

                                    if($pdf_data['signature_data'][0]->signature!=''){
                                     $signature_reprt_data.='<div>'.$pdf_data['signature_data'][0]->signature.'</div>';
                                   }
                                    
                                   $signature_reprt_data.='</td>';
           }    

          if(!empty($pdf_data['signature_data'][0]->sign_doctor) && file_exists(DIR_UPLOAD_PATH.'doctor_signature/'.$pdf_data['signature_data'][0]->sign_doctor) || $pdf_data['signature_data'][0]->doctor_name!='')
          {
                     
            $signature_reprt_data.='<td align="right">';
           if(!empty($pdf_data['signature_data'][0]->sign_doctor) && file_exists(DIR_UPLOAD_PATH.'doctor_signature/'.$pdf_data['signature_data'][0]->sign_doctor) || $pdf_data['signature_data'][0]->doctor_name!=''){
 	//print_r($template_format);die;
           							if($template_format->doctor_signature_text==1)
						           	{
						           		$signature_reprt_data.='<div><b>Signature</b></div>';
						           	}
						           	else{
						           		$signature_reprt_data.='';
						           	}

                                  //$signature_reprt_data.='<div><b>Signature</b></div>';
                                }
                                 if(!empty($pdf_data['signature_data'][0]->sign_doctor) && file_exists(DIR_UPLOAD_PATH.'doctor_signature/'.$pdf_data['signature_data'][0]->sign_doctor))
                                    {
                                      $img_doc='<img width="90px" src="'.ROOT_UPLOADS_PATH.'doctor_signature/'.$pdf_data['signature_data'][0]->sign_doctor.'">';
                                    }
                                    else
                                    {
                                      $img_doc='';
                                    }
                                      
                                    
                                    $signature_reprt_data.='<div>'.$img_doc.'</div>';
                                    

                                    if($pdf_data['signature_data'][0]->doctor_name!=''){
                                     $signature_reprt_data.='<div>Dr.'.$pdf_data['signature_data'][0]->doctor_name.'</div>';
                                   }
                                   
                                    $qualification= get_doctor_qualifications($attended_doctor);
                                   if(!empty($qualification))
                                   {
                                    $signature_reprt_data.='<div>'.$qualification.'</div>';
                                   }
                                   
                                   $signature_reprt_data.='</td>';
                                }
      
        }

        /* condition here */
        
        $signature_reprt_data.='</tr>
        </table>';
      }
  
   


        $data['signature_reprt_data'] = $signature_reprt_data;
        $data['test_report_data'] = $test_report_data;
        //echo "<pre>";print_r(get_doctor_name($booking_data->referral_doctor));die; 
        $data['template_data']=$template_format->setting_value;
        $data['booking_data']= $booking_data;
        $data['patient_code'] = $patient_code;
        $data['simulation_id'] = $booking_data->simulation_id;
        $data['patient_name'] = $patient_name;
        $data['address'] = $address;
        $data['pincode'] = $pincode;
        
        $data['gender'] = $gender;
        $data['patient_age'] = $patient_age;
        $data['doctor_name'] = $doctor_name;
        $data['lab_reg_no'] = $lab_reg_no;
        $data['mobile_no'] = $mobile_no;
        $data['tube_no'] = $tube_no;
        $data['booking_date'] = $booking_date;
        $data['booking_time'] = $booking_time;
        $data['file_name'] = $file_name;  
        $data['signature'] = $signature;
        if(!empty($ref_by_other))
        {
          $referral_doctor_name = $ref_by_other;
        }
        else
        {
          $referral_doctor_name = get_doctor_name($booking_data->referral_doctor);
        }
        $data['referred_by'] = $referral_doctor_name;
        $data['staff_refrenace_id'] = get_doctor_name($staff_refrenace_id);
        
      //$pdf_template = $this->load->view('pathology_appointment/test_pdf_template',$pdf_data,true);
       ///////////////
      $header_replace_part = $report_templ_part->page_details;
      $simulation = get_simulation_name($data['simulation_id']);
      $header_replace_part = str_replace("{patient_name}",$simulation.' '.$data['patient_name'],$header_replace_part); 
      $booking_date_time = date('d-m-Y',strtotime($data['booking_date'])); 

      $test_booking_time =' ';
      if(!empty($data['booking_time']) && $data['booking_time']!='00:00:00' && strtotime($data['booking_time'])>0)
      {
           $test_booking_time = date('h:i A', strtotime($data['booking_time']));    
      }
      //exit;

      if(!empty($pincode))
      {
        $pincode  =' - '.$pincode;
      }
      $patient_address = $address.$pincode;
      
      /* for doctor qualification */

      $doctot_quali='';
      if(!empty($qualification))
      {
        $doctot_quali = $qualification;
    
      }
      else
      {
      $doctot_quali='';
      }
      
      /* for doctor qualification */
      $header_replace_part = str_replace("{address}",$patient_address,$header_replace_part);

      $header_replace_part = str_replace("{patient_reg_no}",$patient_code,$header_replace_part);

      $header_replace_part = str_replace("{mobile_no}",$mobile_no,$header_replace_part);

      $header_replace_part = str_replace("{lab_reg_no}",$lab_reg_no,$header_replace_part);
      $header_replace_part = str_replace("{booking_date}",$booking_date_time,$header_replace_part);

      $header_replace_part = str_replace("{tube_no}",$tube_no,$header_replace_part);


      $header_replace_part = str_replace("{qualification}",$doctot_quali,$header_replace_part);

      $header_replace_part = str_replace("{booking_time}", $test_booking_time, $header_replace_part);
      //booking time//
      $header_replace_part = str_replace("{report_date}",$report_date,$header_replace_part);
      $header_replace_part = str_replace("{report_time}",$report_time,$header_replace_part);
      
      $header_replace_part = str_replace("{ref_doctor_name}",'Dr. '.$data['referred_by'],$header_replace_part);
	    $header_replace_part = str_replace("{token_no}",$booking_data->token_no,$header_replace_part);
      $header_replace_part = str_replace("{verify_report_date}",$verify_date,$header_replace_part);
      $header_replace_part = str_replace("{delivered_report_date}",$delivered_date,$header_replace_part);
      $header_replace_part = str_replace("{sample_collected_date}",$sample_collected_date,$header_replace_part);
      $header_replace_part = str_replace("{sample_received_date}",$sample_received_date,$header_replace_part);
     
     
      if(!empty($sample_collected_by))
      {
         $employee_data = get_employee($sample_collected_by);
         $header_replace_part = str_replace("{sample_collected_by}",$employee_data['name'],$header_replace_part);
      }
      else
      {
       $header_replace_part = str_replace("{sample_collected_by}",'',$header_replace_part);   
       $header_replace_part = str_replace("Source :",'',$header_replace_part); 
      }

      
      if(!empty($doctor_name))
      {
      $doctorname = 'Dr. '.$doctor_name;
      }
      else
      {
      $doctorname = '';
      }
      $header_replace_part = str_replace("{doctor_name}",$doctorname,$header_replace_part);


      $gender_age = $gender.'/'.$patient_age;

      $header_replace_part = str_replace("{patient_age}",$gender_age,$header_replace_part);

      $barcode="";
        if(!empty($booking_data->barcode_image))
        {
            $barcode_image = $booking_data->barcode_image;
            
             if($booking_data->barcode_type=='vertical')
            {
               
               if(!empty($booking_data->barcode_year) && !empty($booking_data->barcode_month))
                {
                  $barcodepath = BARCODE_FS_PATH.$booking_data->barcode_year.'/'.$booking_data->barcode_month.'/'.$booking_data->branch_id.'/';
                }
                else
                {
                    $barcodepath = BARCODE_FS_PATH;
                }
                $barcode = '<img width="90px" src="'.$barcodepath.$barcode_image.'" style="max-height:100px;">';
                $barcode .= '<br><span style="font-size:11px;text-indent:15px;display:inline-block">'.$booking_data->barcode_text.'</span>';
            }
            else
            {   
                if(!empty($booking_data->barcode_year) && !empty($booking_data->barcode_month))
                {
                  $barcodepath = BARCODE_FS_PATH.$booking_data->barcode_year.'/'.$booking_data->barcode_month.'/'.$booking_data->branch_id.'/';
                }
                else
                {
                    $barcodepath = BARCODE_FS_PATH;
                }
               
            $barcode ='<img src="'.$barcodepath.$barcode_image.'" style="display:block;width:70px">';

              
            }
        }

      $header_replace_part = str_replace("{bar_code}",$barcode,$header_replace_part);

      $middle_replace_part = $report_templ_part->page_middle;
      $pos_start = strpos($middle_replace_part, '{start_loop}');
      $pos_end = strpos($middle_replace_part, '{end_loop}');
      $row_last_length = $pos_end-$pos_start;
      $row_loop = substr($middle_replace_part,$pos_start+12,$row_last_length-12);

    // suggestion print starts here
      $userss_data = $this->session->userdata('auth_users');
      if(in_array('223',$userss_data['permission']['section'])) 
      { 
        if(!empty($suggestions_data) && $suggestions_data!="")
        {
          $test_report_data.='<div class="abc_flex"><div class="head">Suggestions:</div><ul>';
          foreach($suggestions_data as $dt)
          {
            $test_report_data.="<li>".$dt['suggested_test']." is suggested as you have ".strtolower($dt['condition'])." results in test ".$dt['test_name']."</li>";
          }
          $test_report_data.='</ul></div>';
        }
      }
      // suggestion print ends here


      $middle_replace_part = str_replace("{test_report_data}",$test_report_data,$middle_replace_part);



       $middle_replace_part = str_replace("{signature_reprt_data}",$signature_reprt_data,$middle_replace_part);
        
        //echo "<pre>"; print_r($report_templ_part->page_footer);die;
        $footer_data_part = $report_templ_part->page_footer;

        $footer_data_part = str_replace("{signature_reprt_data}",$signature_reprt_data,$footer_data_part);

//echo $middle_replace_part; exit;
        ////////////////////

      $stylesheet = file_get_contents(ROOT_CSS_PATH.'report_pdf.css'); 
      $this->m_pdf->pdf->WriteHTML($stylesheet,1); 

      //echo $type;die;
      if($type=='send')
      {
        if($template_format->header_pdf==1)
        {
           $page_header = $report_templ_part->page_header;
        }
        else
        {
           $page_header = '<div style="visibility:hidden">'.$report_templ_part->page_header.'</div>';
        }

        if($template_format->details_pdf==1)
        {
           $header_replace_part = $header_replace_part;
        }
        else
        {
           $header_replace_part = '';
        }

        if($template_format->middle_pdf==1)
        {
           $middle_replace_part = $middle_replace_part;
        }
        else
        {
           $middle_replace_part = '';
        }

        if($template_format->footer_pdf==1)
        {
           $footer_data_part = $footer_data_part;
        }
        else
        {
           $footer_data_part = '';
        }

        $this->m_pdf->pdf->setAutoTopMargin = 'stretch'; 
        $this->m_pdf->pdf->SetHeader($page_header.$header_replace_part);

        $this->m_pdf->pdf->setAutoBottomMargin = 'stretch';
        $this->m_pdf->pdf->SetFooter($footer_data_part);
        $patient_name = str_replace(' ', '-', $patient_name);
        $pdfFilePath = $patient_name.'_report.pdf'; 
        $pdfFilePath = DIR_UPLOAD_PATH.'temp/'.$pdfFilePath; 
        // $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($middle_replace_part,2);
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "F");
    }
    else if($type=='Download')
    {
        if($template_format->header_pdf==1)
        {
           $page_header = $report_templ_part->page_header;
        }
        else
        {
           $page_header = '<div style="visibility:hidden">'.$report_templ_part->page_header.'</div>';
        }

        if($template_format->details_pdf==1)
        {
           $header_replace_part = $header_replace_part;
        }
        else
        {
           $header_replace_part = '';
        }

        if($template_format->middle_pdf==1)
        {
           $middle_replace_part = $middle_replace_part;
        }
        else
        {
           $middle_replace_part = '';
        }

        if($template_format->footer_pdf==1)
        {
           $footer_data_part = $footer_data_part;
        }
        else
        {
           $footer_data_part = '';
        }
        $this->m_pdf->pdf->setAutoTopMargin = 'stretch'; 
        $this->m_pdf->pdf->SetHeader($page_header.$header_replace_part);

        $this->m_pdf->pdf->setAutoBottomMargin = 'stretch';
        $this->m_pdf->pdf->SetFooter($footer_data_part);
         $patient_name = str_replace(' ', '-', $patient_name);
        $pdfFilePath = $patient_name.'_report.pdf';  
          $this->m_pdf->pdf->WriteHTML($middle_replace_part,2);
        //download it.
          $this->m_pdf->pdf->Output($pdfFilePath, "D");//$pdfFilePath, "D"
        
    }
    else 
    { 
        
        if($template_format->header_print==1)
        {
           $page_header = $report_templ_part->page_header;
        }
        else
        {
           $page_header = '<div style="visibility:hidden">'.$report_templ_part->page_header.'</div><br></br>';
        }

        if($template_format->details_print==1)
        {
           $header_replace_part = $header_replace_part;
        }
        else
        {
           $header_replace_part = '';
        }

        if($template_format->middle_print==1)
        {
           $middle_replace_part = $middle_replace_part;
        }
        else
        {
           $middle_replace_part = '';
        }

        if($template_format->footer_print==1)
        {
           $footer_data_part = $footer_data_part;
        }
        else
        {
           $footer_data_part = '';
           $footer_data_part = '<p style="height:'.$template_format->pixel_value.'px;"></p>'; 
            $this->m_pdf->pdf->defaultfooterline = 0;
        }

          $print_letter_head=$this->uri->segment(4);
 
        if($print_letter_head!=1){
        	$page_header="";
        	$header_replace_part="";
        	$footer_data_part="";
        }
        

        $this->m_pdf->pdf->setAutoTopMargin = 'stretch'; 
        $this->m_pdf->pdf->SetHeader($page_header.$header_replace_part);

        $this->m_pdf->pdf->setAutoBottomMargin = 'stretch';
        $this->m_pdf->pdf->SetFooter($footer_data_part); 
        $patient_name = str_replace(' ', '-', $patient_name);
        $pdfFilePath = $patient_name.'_report.pdf';  
        $this->m_pdf->pdf->WriteHTML($middle_replace_part,2);
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "I"); // I open pdf
    }  
  
  
      
    }
  
    
   
 
 
public function check_test_result_range($booking_id="",$test_id="",$result="")
 { 
     
     
    if(!empty($result) && is_numeric($result) && !empty($booking_id) && !empty($test_id))
    {  
      $booking_data = $this->test->get_by_id($booking_id);
      $gender = $booking_data['gender'];
      
      $advance_range = $this->test->get_test_advance_range($test_id,$gender,$booking_data['age_y'],$booking_data['age_m'],$booking_data['age_d'],$booking_data['age_h']);
      
     
      
      if(!empty($advance_range))
      {
        
        if($advance_range[0]->age_type==2)
        {  

         if($booking_data['age_y'] >= $advance_range[0]->start_age && $booking_data['age_y'] <= $advance_range[0]->end_age)
         { //echo $advance_range[0]->range_from.$result.$advance_range[0]->range_to; 
           //echo "<pre>";print_r($advance_range); exit;
           //if($advance_range[0]->range_from<=$result && $advance_range[0]->range_to>=$result)
           if($advance_range[0]->range_from>=$result && $result<=$advance_range[0]->range_to)
           {

            
              return $advance_range;
           }
           else
           {
               return $advance_range;
           } 
         }
         else
         {
            $this->check_main_test_result_range($booking_id,$test_id,$result);
         }
        }
        else if($advance_range[0]->age_type==1)
        { 
           $total_months = ($booking_data['age_y']*12)+$booking_data['age_m'];  
           if($total_months >= $advance_range[0]->start_age && $total_months <= $advance_range[0]->end_age)
         { 
           if($advance_range[0]->range_from>=$result && $result<=$advance_range[0]->range_to)
           {
              return $advance_range;
              //return $result;
           }
           else
           {
              return $advance_range;
           }
           
         }
         else
         {  
            $this->check_main_test_result_range($booking_id,$test_id,$result);
         }
        }
        else if($advance_range[0]->age_type==0)
        {
          $total_days = ($booking_data['age_y']*365)+($booking_data['age_m']*30)+$booking_data['age_d']; 
        if($total_days >= $advance_range[0]->start_age && $total_days <= $advance_range[0]->end_age)
         {
           if($advance_range[0]->range_from>=$result && $result<=$advance_range[0]->range_to)
           {
              //return $result;
            
            return $advance_range;
           }
           else
           {
               return $advance_range;
           } 
         }
         else
         {
            $this->check_main_test_result_range($booking_id,$test_id,$result);
         }
        }
      }
      else
      {
        $this->check_main_test_result_range($booking_id,$test_id,$result);
      } 
    }
    
  }

 public function check_test_result_range20190405($booking_id="",$test_id="",$result="")
 {
    if(!empty($result) && is_numeric($result) && !empty($booking_id) && !empty($test_id))
    {  
        $booking_data = $this->test->get_by_id($booking_id);
      $gender = $booking_data['gender'];
      $advance_range = $this->test->get_test_advance_range($test_id,$gender);
      
      if(!empty($advance_range))
      {
          if($advance_range[0]->age_type==2)
        {  
         if($booking_data['age_y'] >= $advance_range[0]->start_age && $booking_data['age_y'] <= $advance_range[0]->end_age)
         {
           if($advance_range[0]->range_from>=$result && $result<=$advance_range[0]->range_to)
           {
             
              return $result;
           }
           else
           {
              return;
           } 
         }
         else
         {
            $this->check_main_test_result_range($booking_id,$test_id,$result);
         }
        }
        else if($advance_range[0]->age_type==1)
        { 
           $total_months = ($booking_data['age_y']*12)+$booking_data['age_m'];  
           if($total_months >= $advance_range[0]->start_age && $total_months <= $advance_range[0]->end_age)
         { 
           if($advance_range[0]->range_from>=$result && $result<=$advance_range[0]->range_to)
           {
              return $result;
           }
           else
           {
              return;
           }
           
         }
         else
         {  
            $this->check_main_test_result_range($booking_id,$test_id,$result);
         }
        }
        else if($advance_range[0]->age_type==0)
        {
          $total_days = ($booking_data['age_y']*365)+($booking_data['age_m']*30)+$booking_data['age_d']; 
        if($total_days >= $advance_range[0]->start_age && $total_days <= $advance_range[0]->end_age)
         {
           if($advance_range[0]->range_from>=$result && $result<=$advance_range[0]->range_to)
           {
              return $result;
           }
           else
           {
              return;
           } 
         }
         else
         {
            $this->check_main_test_result_range($booking_id,$test_id,$result);
         }
        }
      }
      else
      {
        $this->check_main_test_result_range($booking_id,$test_id,$result);
      } 
    }
    
  }

  private function check_main_test_result_range($booking_id,$test_id,$result)
  {
     $test_data = get_test($test_id);
     //print_r($test_data); exit;
     if(!empty($test_data->range_from) && is_numeric($test_data->range_from) && !empty($test_data->range_to) && is_numeric($test_data->range_to))
     {
       if($result>=$test_data->range_from && $result<=$test_data->range_to)
       {
         return $result; 
       }
       else
       {
         return;
       }
     }
     
     
  }
 
  public function formatted_data($result=array()){
     $booking_data='';
     $booking_data.='<table id="table" class="table table-striped table-bordered test_booking_list"  
                     cellspacing="0" width="100%">
                         <thead class="bg-theme">
                              <tr>
                                   
                                   <th> Lab Ref. No. </th> 
                                   <th> Patient Name </th> 
                                   <th> Booking Date </th> 
                                   <th> Total Amount </th> 
                                   <th> Paid Amount </th>  
                                   <th> Discount </th>  
                                   <th> Created Date </th> 
                                
                              </tr>
                         </thead>';
     $booking_data.='<tbody><tr>';
     if(!empty($result)){
          //echo '<pre>';
          $booking_data .= '<td>'.$result[0]->lab_reg_no.'</td><td>'.$result[0]->patient_name.'</td><td>'.$result[0]->booking_date.'</td><td>'.$result[0]->total_master_amount.'</td><td>'.$result[0]->paid_amount.'</td><td>'.$result[0]->discount.'</td><td>'.$result[0]->created_date.'</td>';
          $booking_data.='</tr></tbody></table>';
     }
     return $booking_data;
  }


  public function send_email($booking_id="",$type='')
  { 
        unauthorise_permission(101,641);
        if(!empty($booking_id) && $booking_id>0)
        {
            $data['page_title'] = 'Send Email';   
            $this->load->model('general/general_model'); 
            
            $get_by_id_data = $this->test->test_booking_print($booking_id);
          $booking_data = $get_by_id_data['booking_list'][0];
          
          $patient_code = $booking_data->patient_code;
          $lab_reg_no = $booking_data->lab_reg_no;
          $attended_doctor = $booking_data->attended_doctor;
          $sample_collected_by = $booking_data->sample_collected_by;
          $staff_refrenace_id = $booking_data->staff_refrenace_id;
          $dept_id = $booking_data->dept_id;
          $total_amount = $booking_data->total_amount;
          $net_amount = $booking_data->net_amount;
          $total_master_amount = $booking_data->total_master_amount;
          $master_net_amount = $booking_data->master_net_amount;
          $total_base_amount = $booking_data->total_base_amount;
          $base_net_amount = $booking_data->base_net_amount;
          $paid_amount = $booking_data->paid_amount;
          $discount = $booking_data->discount;
          $balance = $booking_data->balance;
          $booking_code = $booking_data->booking_code;
          $patient_name = str_replace(' ', '-', $booking_data->patient_name);
          $mobile_no = $booking_data->mobile_no;
          $gender = $booking_data->gender;
          $age_y = $booking_data->age_y;
          $age_m = $booking_data->age_m;
          $age_d = $booking_data->age_d;
          $booking_date = $booking_data->booking_date;  


            $data['form_error'] = [];
            $data['sign_error'] = [];
            $post = $this->input->post();
            $data['form_data'] = array(
                                         'booking_id'=>$booking_id,
                                         'type'=>$type,
                                         'subject'=>'',
                                         'email'=>'',
                                         'message'=>'',
                                         'email'=>''
                                      );
            if(isset($post) && !empty($post))
            {   
                

                $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');  
                $this->form_validation->set_rules('email', 'Email', 'trim|required');
                $this->form_validation->set_rules('message', 'Message', 'trim|required'); 
                $this->form_validation->set_rules('subject', 'Subject', 'trim|required'); 

               if($this->form_validation->run() == TRUE)
               {
                 //print_r($post); exit;
                  $booking_id = $post['booking_id'];
                  $type = $post['type'];
          //create pdf
          $this->print_test_report($booking_id,'send');
          $email = $post['email'];
                  $subject = $post['subject'];
                  $message = $post['message'];
          $attachment = DIR_UPLOAD_PATH.'temp/'.$patient_name.'_report.pdf'; 
          $this->load->library('general_library');
            //$this->general_library->email($email,$subject,$message,'',$attachment);                                                      //$email_response = $this->general_library->email($email,$subject,$message,'',$attachment,'','','','',$booking_data->branch_id); //print_r($email_response);die;
        //if(!empty($attachment) && file_exists($attachment)) 
                    //{
                        //unlink($attachment);
                    //} 

                    //echo 1;
                  //return false;

$response = $this->general_library->email($email,$subject,$message,'',$attachment,'','','','',$booking_data->branch_id);
          
                    if(!empty($attachment) && file_exists($attachment)) 
                          {
                              unlink($attachment);
                          } 

                          echo 1;
                        return false;
                

               }
               else
               {
                  $data['form_data'] = array(
                                            'booking_id'=>$post['booking_id'],
                                            'type'=>$post['type'],
                                            'email'=>$post['email'],
                                          'subject'=>$post['subject'],
                                          'message'=>$post['message'],
                                         );

                  $data['form_error'] = validation_errors();
               }  

                  
                     

            }
            $this->load->view('pathology_appointment/send_email',$data);
        }
        
    }


    public function export_excel()
    { 
            // Starting the PHPExcel library
        $this->load->library('excel');
        $this->excel->IO_factory();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);
        // Field names in the first row
        
        $fields = array('Lab Ref. No.','Patient Name' , 'Referred By' ,'Booking Date','Net Amount','Paid Amount','Balance','Status');
          $col = 0;
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
        $list = $this->test->advance_search_result();
        $rowData = array();
        $data= array();
        if(!empty($list))
        {
           
            $i=0;
            foreach($list as $test)
            {
                $create_date = date('d-M-Y H:i A',strtotime($test->created_date)); 
                $booking_date = date('d-M-Y',strtotime($test->booking_date)); 
                $complate_status = array('0'=>'Pending','1'=>'Complete');
                $doctor_name = get_doctor($test->referral_doctor);
                array_push($rowData,$test->lab_reg_no,$test->patient_name, $test->doctor_hospital_name,$booking_date,$test->net_amount,$test->paid_amount,$test->balance,$complate_status[$test->complation_status]);
                $count = count($rowData);
                for($j=0;$j<$count;$j++)
                {
                    $data[$i][$fields[$j]] = $rowData[$j];
                }
                unset($rowData);
                $rowData = array();
                $i++;  
            }
             
        }

          // Fetching the table data
          $row = 2;
          if(!empty($data))
          {
              foreach($data as $test_data)
              {
                   $col = 0;
                   foreach ($fields as $field)
                   { 
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $test_data[$field]);
                        $col++;
                   }
                   $row++;
              }
              $objPHPExcel->setActiveSheetIndex(0);
              $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          }
          
          // Sending headers to force the user to download the file
          header('Content-Type: application/octet-stream charset=UTF-8');
          header("Content-Disposition: attachment; filename=test_booking_list_".time().".xls");
         header("Pragma: no-cache"); 
         header("Expires: 0");
         if(!empty($data))
         {
             ob_end_clean();
            $objWriter->save('php://output');
        }
        // $list = $this->test->advance_search_result();
        // $columnHeader = '';  
        // $columnHeader = "Lab Ref. No." . "\t" . "Patient Code" . "\t" . "Patient Name" . "\t" . "Booking Date" . "\t". "Total Amount" . "\t" . "Discount". "\t" . "Net Amount". "\t" . "Paid Amount". "\t" . "Balance". "\t" . "Referred Doctor " . "\t" . "Attended Doctor" . "\t" . "Create Date";       
        // $setData = '';
        // foreach ($list as $test) 
        // {    
        //     $create_date = date('d-M-Y H:i A',strtotime($test->created_date)); 
        //     $booking_date = date('d-M-Y',strtotime($test->booking_date)); 
      
        //     $rowData = $test->lab_reg_no . "\t" . $test->patient_code . "\t" . $test->patient_name . "\t" . $booking_date . "\t" . $test->total_amount . "\t" . $test->discount . "\t" . $test->net_amount . "\t" . $test->balance. "\t" . $test->paid_amount . "\t" . $test->referral. "\t" . $test->attended_doctor . "\t". $create_date; 
        //         $setData .= trim($rowData) . "\n";    
        // }
        // header("Content-type: application/octet-stream");  
        // header("Content-Disposition: attachment; filename=test_booking_list_".time().".xls");  
        // header("Pragma: no-cache");  
        // header("Expires: 0");  

        // echo ucwords($columnHeader) . "\n" . $setData . "\n"; 
    }

    public function export_csv()
    {
        $this->load->model('general/general_model');
        // Starting the PHPExcel library
        $this->load->library('excel');
        $this->excel->IO_factory();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);
        // Field names in the first row
        
        $fields = array('Lab Ref. No.','Patient Name','Referred By','Booking Date','Net Amount','Paid Amount','Balance','Status');
          $col = 0;
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
        $list = $this->test->advance_search_result();
        $rowData = array();
        $data= array();
        if(!empty($list))
        {
           
            $i=0;
            foreach($list as $test)
            {
                $create_date = date('d-M-Y H:i A',strtotime($test->created_date)); 
                $booking_date = date('d-M-Y',strtotime($test->booking_date)); 
                $complate_status = array('0'=>'Pending','1'=>'Complete');
                $doctor_name = get_doctor($test->referral_doctor);
                array_push($rowData,$test->lab_reg_no,$test->patient_name, $test->doctor_hospital_name,$booking_date,$test->net_amount,$test->paid_amount,$test->balance,$complate_status[$test->complation_status]);
                $count = count($rowData);
                for($j=0;$j<$count;$j++)
                {
                    $data[$i][$fields[$j]] = $rowData[$j];
                }
                unset($rowData);
                $rowData = array();
                $i++;  
            }
             
        }

          // Fetching the table data
          $row = 2;
          if(!empty($data))
          {
              foreach($data as $test_data)
              {
                   $col = 0;
                   foreach ($fields as $field)
                   { 
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $test_data[$field]);
                        $col++;
                   }
                   $row++;
              }
              $objPHPExcel->setActiveSheetIndex(0);
              $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
          }
          
          // Sending headers to force the user to download the file
          header('Content-Type: application/octet-stream charset=UTF-8');
          header("Content-Disposition: attachment; filename=test_booking_list_".time().".csv");
         header("Pragma: no-cache"); 
         header("Expires: 0");
         if(!empty($data))
         {
             ob_end_clean();
            $objWriter->save('php://output');
        }
      
    }

    public function export_pdf()
    {     
        $data['print_status']="";
        $data['data_list'] = $this->test->advance_search_result();
        $this->load->view('pathology_appointment/booking_export_print',$data);
        $html = $this->output->get_output();
        // Load library
        $this->load->library('pdf');
        // Convert to PDF
        $this->pdf->load_html($html);
        $this->pdf->render();
        $this->pdf->stream("test_booking_list_".time().".pdf");
    }
    public function export_print()
    {      
      $data['print_status']="1";
      $data['data_list'] = $this->test->advance_search_result();
      $this->load->view('pathology_appointment/booking_export_print',$data); 
    }

    public function profile_price($id="",$panel_id="")
    {
     $master_rate ='0.00';   
     if(!empty($id) && is_numeric($id) && $id>0)
     {
       $booking_doctor_type = $this->session->userdata('booking_doctor_type'); 
       $this->load->model('test_profile/test_profile_model');
       $result = $this->test_profile_model->profile_price($id,$panel_id);
       if(!empty($result))
       {
          if(!empty($result['profile_master_rate']) && $result['profile_master_rate']>0)
          {
             $master_rate = $result['profile_master_rate'];
          }
          else
          {
             $master_rate = $result['master_rate'];
             if(isset($booking_doctor_type) && !empty($booking_doctor_type))
             {
                $master_rate = $this->make_master_price($master_rate);            
             }
          }
       }
       
     }
    // echo 'Rs. '.$master_rate; 
    echo $master_rate; 
  }

  public function set_profile($profile_id="")
  {
      $post=$this->input->post();
       if(!empty($profile_id) && is_numeric($profile_id) && $profile_id>0)
       {
          $profile_arr = $this->session->userdata('set_profile'); 
          if(!isset($profile_arr))
          {
            $profile_arr = [];
          }
          $booking_doctor_type = $this->session->userdata('booking_doctor_type'); 
          $booking_list = $this->session->userdata('book_test');
          $this->load->model('test_profile/test_profile_model');
          $result = $this->test_profile_model->profile_price($profile_id); 
          $master_rate = 0;
          $base_rate = 0;
          ////// Set Profile Price ///
           if(!empty($result))
           {
              if(!empty($result['profile_master_rate']) && $result['profile_master_rate']>0)
              {
                 //$master_rate = $result['profile_master_rate'];
                 $master_rate = $post['profile_price_updated'];
              }
              else
              {
                 $master_rate = $post['profile_price_updated'];//$result['master_rate'];
                 if(isset($booking_doctor_type) && !empty($booking_doctor_type))
                 {
                    $master_rate = $this->make_master_price($post['profile_price_updated']);        
                 }
              }

              if(!empty($result['profile_base_rate']) && $result['profile_base_rate']>0)
              {
                 $base_rate = $post['profile_price_updated'];//$result['profile_base_rate'];
              }
              else
              {
                 $base_rate = $post['profile_price_updated'];//$result['base_rate'];
                 if(isset($booking_doctor_type) && !empty($booking_doctor_type))
                 {
                    $base_rate = $this->make_base_price($post['profile_price_updated']);        
                 }
              }
           }
          ////// End Profile Price //////
          $total_test = 1;
          if(!empty($booking_list))
          {
            $total_test = count($booking_list);
          }

/*print and name*/
            $profile_print_status = get_profile_print_status('test_booking');
            $profile_status = $profile_print_status->profile_status;
            $print_status = $profile_print_status->print_status;
            if($profile_status==1 && $print_status==1)
            {
              if(!empty($result['print_name']))
              {
                $profile_name = $result['profile_name'].' ('.$result['print_name'].')';
              }
              else
              {
                $profile_name = $result['profile_name'];
              }
            }
            elseif($profile_status==1 && $print_status==0)
            {
              $profile_name = $result['profile_name'];
            }
            elseif($profile_status==0 && $print_status==1)
            {
            if(!empty($result['print_name']))
            {
              $profile_name = $result['print_name'];
            }
            else
            {
              $profile_name = $result['profile_name'];
            }

            }
            elseif($profile_status==0 && $print_status==0)
            {
              $profile_name = $result['profile_name'];
            } 
          $profile_arr[$profile_id] = array('id'=>$profile_id, 'name'=>$profile_name, 'order'=>$total_test, 'price'=>$master_rate,'base_price'=>$base_rate);
         // echo "<pre>";print_r($profile_arr);die;
          $this->session->set_userdata('set_profile',$profile_arr);
          echo 1; 
       }
       else
       {
         echo 'Please select test profile.';
       }
  }


  public function complete_test_report($booking_id="",$status="")
  { 
       
       if(!empty($booking_id) && $booking_id>0)
       {
          $users_data = $this->session->userdata('auth_users');
          $data['booking_id'] = $booking_id;
          $this->test->complete_test_report($booking_id,$status); 
          $booking_data = $this->test->get_by_id($booking_id); 
          //echo "<pre>"; print_r($booking_data);die;
          ////////// Send SMS /////////////////////
          if(in_array('640',$users_data['permission']['action']))
          {
            if(!empty($booking_data['mobile_no']))
            { 
              send_sms('test_report_complete',23,'',$booking_data['mobile_no'],array('{patient_name}'=>$booking_data['patient_name'],'{booking_no}'=>$booking_data['lab_reg_no'],'{report_complete_date}'=>$booking_data['complation_date']));  
            }
          }
          //////////////////////////////////////////

          ////////// SEND EMAIL ///////////////////
                if(!empty($booking_data['patient_email']))
                  { 
                    $this->load->library('general_library'); 
                    $this->general_library->email($booking_data['patient_email'],'','','','','','test_report_complete','23',array('{patient_name}'=>$booking_data['patient_name'],'{booking_no}'=>$booking_data['lab_reg_no'],'{report_complete_date}'=>$booking_data['complation_date'])); 
                  }
          //////////////////////////////////////// 


          echo 1;
          return false;
          
       } 
      
  }

   public function add_interpretation($booking_id="",$test_id="")
   {
	   ini_set('memory_limit', '-1');
      $data['page_title'] = 'Add Interpretation';      
      $data['form_error'] = [];
      $interpretation = ""; 
      $interpretation_data = $this->test->get_test_details($booking_id,$test_id); 
      if(!empty($interpretation_data))
      {
        $interpretation = $interpretation_data->interpratation_data;
      } 
      $data['multi_interpretation']  = test_multi_interpration($test_id);
      $data['booking_id'] = $booking_id;
      $data['test_id'] = $test_id; 
      $data['form_data'] = array(
                                   'booking_id'=>$booking_id,
                                   'test_id'=>$test_id,
                                   'interpretation_data'=>$interpretation
                                ); 
      $post = $this->input->post();   
     //echo "<pre>"; print_r($post); exit;
      if(!empty($post))
      {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');  
        $this->form_validation->set_rules('interpretation_data', 'Interpretation', 'trim|required');
        if($this->form_validation->run() == TRUE) 
        { 
          
           $this->test->save_adv_interpretation();
           echo 1; return false;
        }
        else
        {
          $data['form_error'] = validation_errors();  
          $data['form_data'] = array(
                                   'booking_id'=>$post['booking_id'],
                                   'test_id'=>$post['test_id'],
                                   'interpretation_data'=>$post['interpretation_data']
                                ); 
        }
      } 
      $this->load->view('pathology_appointment/add_interpretation',$data);
    }


    public function booking_set_branch($bid="")
    {
      if(!empty($bid) && is_numeric($bid))
      {
        $this->session->set_userdata('booking_set_branch',$bid);
      }
    }

  
  public function add_profile_interpretation($booking_id="",$profile_id="")
  {
      $data['page_title'] = 'Add Interpretation'; 
      $booking_data = $this->test->get_profile_interpretation($booking_id,$profile_id);     
      $data['form_error'] = [];
      $interpretation = ""; 
      $interpretation = $this->session->userdata('profile_interpretation_data');
       
      if(empty($interpretation) && isset($booking_data->interpretation) && !empty($booking_data->interpretation))
      {  
        $interpretation = $booking_data->interpretation;
      }

      $data['form_data'] = array(
                                   'data_id'=>$booking_id,
                                   'profile_id'=>$profile_id,
                                   'profile_interpretation'=>$interpretation
                                ); 
      $post = $this->input->post();   

      if(!empty($post))
      {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');  
        $this->form_validation->set_rules('profile_interpretation', 'Interpretation', 'trim|required');
        if($this->form_validation->run() == TRUE) 
        { 
           $this->test->save_profile_interpretation($post['data_id'],$post['profile_interpretation'],$post['profile_id']);
           echo 1; return false;
        }
        else
        {
          $data['form_error'] = validation_errors();  
          $data['form_data'] = array(
                                   'data_id'=>$post['data_id'],
                                   'profile_id'=>$post['profile_id'],
                                   'profile_interpretation'=>$post['profile_interpretation']
                                ); 
        }
      } 
      $this->load->view('pathology_appointment/add_profile_interpretation',$data);
  } 
  public function get_payment_mode_data()
  {
    $this->load->model('general/general_model'); 
    $payment_mode_id= $this->input->post('payment_mode_id');
    $error_field= $this->input->post('error_field');
    
    $get_payment_detail= $this->general_model->payment_mode_detail($payment_mode_id); 
    $html='';
    $var_form_error='';
    foreach($get_payment_detail as $payment_detail)
    {

      if(!empty($error_field))
        {
         
         $var_form_error= $error_field; 
        }
       $html.='<div class="row m-b-5"><div class="col-md-5"><label>'.$payment_detail->field_name.'<label class="star">*</span></div> <div class="col-md-7"> <input type="text" name="field_name[]" value="" /><input type="hidden" value="'.$payment_detail->id.'" name="field_id[]" /><div class="f_right">'.$var_form_error.'</div></div></div>';
    }
    echo $html;exit;
    
  } 

  function form_f_print()
    {
      $test_booking_id= $this->session->userdata('test_booking_id');
      
      if(!empty($id))
      {
        $test_booking_id = $id;
      }
      else if(isset($test_booking_id) && !empty($test_booking_id))
      {
        $test_booking_id =$test_booking_id;
      }
      else
      {
        $test_booking_id = '';
      } 
      $book_data = $this->test->get_by_id($test_booking_id);
      $get_by_id_data = $this->test->test_booking_print($test_booking_id, $book_data['branch_id']);
      //print  '<pre>'; print_r($get_by_id_data);die;
      $data['get_by_id_data']=$get_by_id_data;
      //print '<pre>';print_r($data['get_by_id_data']['ipd_list'][0]);die;
      $this->load->view('pathology_appointment/form_f_pathalogy',$data);
    }

    public function print_barcode($booking_id='')
    {
      /*$users_data = $this->session->userdata('auth_users'); 
      if(!empty($booking_id))
      {
        $booking_data = $this->test->get_by_id($booking_id);
        $barcode_setting = barcode_setting($users_data['parent_id']);
        $data['total_receipt'] = $barcode_setting->total_receipt;
        
        $data['barcode_image'] = $booking_data['barcode_image'];
        $data['barcode_type'] = $booking_data['barcode_type'];
        //echo "<pre>";print_r($barcode_setting); exit;

        $this->load->view('pathology_appointment/print_barcode_template',$data);
      }*/
      
      $users_data = $this->session->userdata('auth_users'); 
      if(!empty($booking_id))
      {
        $booking_data = $this->test->get_by_id($booking_id);
        //echo "<pre>"; print_r($booking_data); exit;
        $barcode_setting = barcode_setting($users_data['parent_id']);
        //echo "<pre>"; print_r($barcode_setting); exit;
        $data['total_receipt'] = $barcode_setting->total_receipt;
        $data['type_barcode'] = $barcode_setting->type;
        $data['barcode_image'] = $booking_data['barcode_image'];
        $data['barcode_type'] = $booking_data['barcode_type'];
        $data['barcode_text'] = $booking_data['barcode_text'];

        //echo "<pre>";print_r($barcode_setting); exit;
        

        $this->load->view('pathology_appointment/print_barcode_template',$data);
      }
    }

    function status_filter()
    {
      //print_r($this->input->post());
      $this->session->set_userdata('complation_status',$this->input->post('val'));
    }

    public function verify_status($booking_id="",$status="")
    {
      if(!empty($booking_id) && $status!="")
      {
        $this->test->update_verify_status($booking_id,$status);
        if($status==1)
        {
          echo 1;die;
        }
        else
        {
          echo 2;die;
        }
      }
    }


   public function multi_interpretation_change_data($id="")
   {
    if(!empty($id))
    {  
       $result = $this->test->multi_interpretation_change_data($id);
       if(!empty($result))
       {
        echo $result[0]['interpration'];
       }

    }
   } 

   public function get_dept_common_data($id="")
   {
      if(!empty($id))
      {  
         $result = $this->test->get_dept_common_data($id);
          echo  $result;die;

      }
   }
   
   public function set_prescription_booking_test($prescription_id)
   {
      //$post =  $this->input->post();
      $users_data = $this->session->userdata('auth_users');
      $this->load->model('prescription/prescription_model','prescription');
      $get_by_id_data = $this->prescription->get_by_prescription_id($prescription_id);
      $prescription_test_list = $get_by_id_data['prescription_list']['prescription_test_list'];

      $booking_doctor_type = $this->session->userdata('booking_doctor_type');
      $branch_id = $users_data['parent_id']; 
      if(!isset($booking_doctor_type) || empty($booking_doctor_type))
      {
        $booking_doctor_type = 0;
      }
      if(isset($prescription_test_list) && !empty($prescription_test_list))
      {
          $post_test = [];
          foreach($prescription_test_list as $prescription_test)
          {
              $test_list = $this->test->test_list($prescription_test->test_id);
              foreach($test_list as $test)
              { 
                 
                 
               if(isset($booking_doctor_type) && !empty($booking_doctor_type))
               {   
                  $rate_data = doctor_test_rate($branch_id,$booking_doctor_type[0]['id'],$test->id);
                   if(!empty($rate_data))
                   {
                     $master_rate = $rate_data['rate'];
                   }
                   else
                   {
                     $rate_branch_data = doctor_test_rate($branch_id,'',$test->id);
                      if(!empty($rate_branch_data))
                      { 
                        $master_rate = $rate_branch_data['rate'];
                        $master_rate = $this->make_master_price($master_rate);
                      }
                      else
                      { 
                        $master_rate = $this->make_master_price($test->rate);
                      } 
                   }
               } 
               else
               {  
                $rate_data = doctor_test_rate($branch_id,'',$test->id);
                if(!empty($rate_data))
                { 
                  $master_rate = $rate_data['rate'];
                }
                else
                { 
                  $master_rate = $test->rate;
                }
               }

               $test_panel_rate = $this->session->userdata('test_panel_rate');
              if(isset($test_panel_rate) && !empty($test_panel_rate))
              {
              if(!empty($test_panel_rate['ins_company_id']) && isset($test_panel_rate['ins_company_id']))
                {
                  $rate_branch_data = panel_test_rate($branch_id,$test_panel_rate['ins_company_id'],$child->id);
                  //print_r($rate_branch_data);die;
                  if(!empty($rate_branch_data) && $rate_branch_data['path_price']>0 && isset($rate_branch_data['path_price']) )
                  {
                    
                     $master_rate=$rate_branch_data['path_price'];
                  }
                 }
               }

               /* $sample_type_list=$this->test->sample_type_list($test->id,);*/
                $sample_type_name = $this->test->get_test_sample_name($test->sample_test);
            
                //$sample_type_list = $sample_type_data->sample_test;

                $post_test[$test->id] = array('id'=>$test->id, 'price'=>$master_rate,'sample_type_id'=>$sample_type_name);               
                 
              } 
          }

          $this->session->set_userdata('book_test',$post_test);
          echo $result = $this->list_prescription_booked_test();

      }


    }

     public function list_prescription_booked_test()
    {
       $booked_test = $this->session->userdata('book_test');
       $profile_data = $this->session->userdata('set_profile'); 
       //echo '<pre>'; print_r($booked_test);die;
       $total_test = count($booked_test);  
       $profile_row = "";
       $p_order = 1;
       $profile_order = 1;
       $profile_order_cell = 0;
       if(isset($profile_data) && !empty($profile_data))
        {  

          foreach($profile_data as $profile)
          {
             $profile_order_cell = $profile['order'];
             $profile_row .= '<tr>
                              <td width="40" align="center">
                                 <input type="checkbox" name="test_id[]" class="booked_checkbox" value="p_'.$profile['id'].'" >
                              </td>
                              <td>'.$profile['id'].'</td>
                              <td>'.$profile['name'].'</td>
                              <td></td>
                              <td>'.$profile['price'].'</td>
                          </tr>'; //.$profile['sample_type_id'].
          } 
        }

       $rows = '<tr> 
                    <th width="60" align="center">
                     <input name="selectall" class="" onClick="final_toggle(this);" value="" type="checkbox">
                    </th>
                    <th>Test ID</th>
                    <th>Test Name</th>
                    <th>Sample Type</th>
                    <th>Rate</th>
                  </tr>';  
         
         if(isset($booked_test) && !empty($booked_test))
         { 
            $test_ids_arr = array_keys($booked_test);
            $test_ids = implode(',',$test_ids_arr);
            $test_list = $this->test->test_list($test_ids);
            $i = 1;
            if($total_test>1)
            {
              $profile_order = $total_test-$profile_order_cell;
              if($profile_order==0)
              {
                $profile_order = 1;
              }
            }
              
            foreach($test_list as $test)
            { 
               //echo "<pre>";print_r($test); exit;
               $master_rate = $booked_test[$test->id]['price'];//$this->make_master_price($test->rate);
               $sample_type_id = $booked_test[$test->id]['sample_type_id'];
               $rows .= '<tr>
                                  <td width="60" align="center"><input type="checkbox" name="test_id[]" class="booked_checkbox" value="'.$test->id.'" ></td>
                                  <td>'.$test->test_code.'</td>
                                 
                                  <td>'.$test->test_name.'</td>
                                   <td>'.$sample_type_id.'</td>
                                  <td>'.$master_rate.'</td>
                              </tr>';
              if(isset($profile_data) && !empty($profile_data))
              {
                 if($i==$profile_order)
                 {
                   $rows .= $profile_row;
                 }
              }                
            $i++;
            } 
         }
         else
         {
            if(isset($profile_data) && !empty($profile_data))
            {
              $rows .= $profile_row;
            }
            else
            {
             $rows .= '<tr>  
                        <td colspan="5"><div class="text-danger">Test not available.</div></td>
                      </tr>';
            }          
         }
         return $rows;
    }
    
     function open_sample_collected($test_id)
   {
    //echo $test_id; die;
    $data['title'] = 'Sample Collected';
    $data['testid'] = $test_id;
    $sample_date =$this->test->get_by_id($data['testid']);
    $data['sample_date'] = $sample_date['sample_collected_date'];
    $this->load->view('pathology_appointment/sample_collected', $data);
    
   }

   function update_sample_collected()
   {
    $post= $this->input->post();
    //print_r($post); die;
    if(!empty($post))
    {
      $result = $this->test->update_sample_collected();
      if(!empty($result) && $result==1)
      {
        $data=array('success'=>1,'msg'=>'sample collected date is updated');
        echo json_encode($data);
        return false;
      }
      else
      {
        $data=array('success'=>0);
        echo json_encode($data);
        return false;
      }
    }

   }

   function open_sample_received($test_id)
   {
    //echo $test_id; die;
    $data['title'] = 'Sample Received';
    $sample_date =$this->test->get_by_id($test_id);
    $data['sample_receive_date'] = $sample_date['sample_received_date'];
    $data['testid'] = $test_id;
    $this->load->view('pathology_appointment/sample_received', $data);
    
   }

   function update_sample_received()
   {
    $post= $this->input->post();
    //print_r($post); die;
    if(!empty($post))
    {
      $result = $this->test->update_sample_recieved();
      if(!empty($result) && $result==1)
      {
        $data=array('success'=>1,'msg'=>'sample received date is updated');
        echo json_encode($data);
        return false;
      }
      else
      {
        $data=array('success'=>0);
        echo json_encode($data);
        return false;
      }
    }
   }
   
   //neha 14-2-2019
   function get_patient_detail_no_mobile($mobile)
   {
    //echo $mobile;
     //$lab_reg_no = generate_unique_id(26);
     $patient_data = $this->test->get_by_mobile_no($mobile);
     //echo "<pre>"; print_r($patient_data); die;
     $html="";
     if(!empty($patient_data))
     { 
      //$html .='<select name="patient_id" id="patient_id" class="form-control" onchange="get_patient_id()">';
       foreach($patient_data as $patient_list)
       {
          $html.='<input type="radio" value="'.$patient_list->id.'" class="term" name="patient_id"> '.$patient_list->patient_name.'<br>';
       }
           $data=array('st'=>1,'patient_list'=>$html);
            echo json_encode($data);
            return false;
            
     }
    else{
            $data=array('st'=>0);
            echo json_encode($data);
            return false;
          }
   
 }
//neha 14-2-2019
 //neha 25-2-2019
 function get_patient_detail_byid($patient_id)
   {
    //echo $mobile;
     //$lab_reg_no = generate_unique_id(26);
     $patient_data = $this->test->get_patient_byid($patient_id);
     //print_r($patient_data);die;
     if(!empty($patient_data))
          {
            $data=array('st'=>1,'patient_detail'=>$patient_data);
            echo json_encode($data);
            return false;
          }
      else
          {
            $data=array('st'=>0);
            echo json_encode($data);
            return false;
          }

   }

/************Letter Print *****************/
  public function print_template($id)
    {
        $data['page_title'] = 'Select Letter Head Option';
        //$post = $this->input->post();  
        $data['id'] = $id;
        $this->load->view('pathology_appointment/letter_head_template',$data);
   
    }


   public function dept_ref_no($dept_id)
   {
     $last_ref=get_last_depaertment_id($dept_id);
      echo $last_ref;
   }
/*********** Letter Print ********/

public function expect_result_time($booking_id='')
{ 
    $data['page_title'] = 'Exprected Report Time';
    $this->load->model('token_status/path_token_model','path_token');
    $post = $this->input->post();
    $record=$this->path_token->path_get_result_time($booking_id);
    if(!empty($post))
    {
      $result=$this->path_token->path_update_result_time();
      if($result)
      {
        echo 1; exit;
      }
    }
    if(!empty($record))
    {
      $prefix=date('d-m-Y');
      $time=date('h:i A');
      if(!empty($record->result_prefix) && $record->result_prefix !='')
      {
        $prefix=$record->result_prefix;
      }
      if(!empty($record->result_time) && $record->result_time !='')
      {
        $time=$record->result_time;
      }
      $data['form_data'] = array(
                                 'data_id'=>$record->id,
                                 'booking_id'=>$booking_id,
                                 'prefix'=>$prefix,
                                 'result_time'=>$time
                              );   
    }
    $this->load->view('pathology_appointment/result_times',$data);
 }

   public function expect_result_update($booking_id='')
   {
    $this->load->model('token_status/path_token_model','path_token');
     $result=$this->path_token->expect_result_update($booking_id);
     if($result)
     {
       echo 'Report Status updated';
     }
   }

// Please write code above this    
}
?>