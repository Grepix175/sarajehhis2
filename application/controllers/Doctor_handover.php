<?php
class Doctor_handover extends CI_Controller
{
    protected $gender;
    public function __construct()
    {
        parent::__construct();
       
        $this->load->model('doctor_handover/doctor_handover_model','doctor_handover');
        $this->load->library('form_validation');
        $this->gender = ["Female","Male"];
        
    }

    public function index()
    {
        $data['page_title'] = 'Doctor Handover List'; 
        $this->load->view('doctor_handover/list',$data);
    }

    public function ajax_list()
    { 
        unauthorise_permission(10,50);
        $users_data = $this->session->userdata('auth_users');

        $sub_branch_details = $this->session->userdata('sub_branches_data');
       $parent_branch_details = $this->session->userdata('parent_branches_data');
    
       
            $list = $this->doctor_handover->get_datatables();
     
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        $total_num = count($list);
        foreach ($list as $mc) {
         // print_r($religion);die;
            $no++;
            $row = array();
           
            
            ////////// Check  List /////////////////
            $check_script = "";
            if($i==$total_num)
            {
            $check_script = "<script>$('#selectAll').on('click', function () { 
                                  if ($(this).hasClass('allChecked')) {
                                      $('.checklist').prop('checked', false);
                                  } else {
                                      $('.checklist').prop('checked', true);
                                  }
                                  $(this).toggleClass('allChecked');
                              })</script>";
            }                 
            ////////// Check list end ///////////// 
            if($users_data['parent_id']==$mc->branch_id){
               $row[] = '<input type="checkbox" data-patient_code="'.$mc->patient_code.'" name="employee[]" class="checklist" value="'.$mc->id.'">'.$check_script; 
             }else{
               $row[]='';
             }
            $row[] = $mc->ipd_no;  
            $row[] = $mc->patient_code;
            $row[] = $mc->patient_name;
            $row[] = $mc->shift; 
            $row[] = $this->gender[$mc->gender];
            $row[] = $mc->age_y;         
            $row[] = date('d-M-Y H:i A',strtotime($mc->created_date)); 
 
            //Action button /////
            $btnedit = ""; 
            $btndelete = "";
         
            if($users_data['parent_id']==$mc->branch_id){
              
                 if(in_array('52',$users_data['permission']['action'])) 
                 {
                    
                    $btnedit = ' <a href="'.base_url('doctor_handover/edit/').$mc->id.'" class="btn-custom" href="javascript:void(0)" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                 }
                 if(in_array('53',$users_data['permission']['action'])) 
                 {
                    $btndelete = ' <a class="btn-custom" onClick="return delete_religion('.$mc->id.')" href="javascript:void(0)" title="Delete" data-url="512"><i class="fa fa-trash"></i> Delete</a>';
                 } 
                 $print_medication_chart_print = "'".base_url('doctor_handover/print_details/'.$mc->id)."'";
            
                $btn_medication_chart_print = '<a class="btn-custom" href="javascript:void(0)" onClick="return print_window_page('.$print_medication_chart_print.')"  title="Print Doctor Handover" ><i class="fa fa-bar-chart"></i> Print</a>';
            }

            // End Action Button //
            
    
             $row[] = $btnedit.$btndelete.$btn_medication_chart_print;
             
             
        
            $data[] = $row;
            $i++;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->doctor_handover->count_all(),
                        "recordsFiltered" => $this->doctor_handover->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function add($booking_id="")
    {
//         ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
        $data['prescription_tab_setting'] = get_ipd_prescription_tab_setting();
        $data['prescription_medicine_tab_setting'] = get_ipd_prescription_medicine_tab_setting();
        $this->load->model('opd/opd_model','opd');
        $this->load->model('general/general_model'); 
        
        $data['gardian_relation_list'] = $this->general_model->gardian_relation_list();
        $post = $this->input->post();
        $patient_id = "";
        $patient_code = "";
        $simulation_id = "";
        $patient_name = "";
        $mobile_no = "";
        $gender = "";
        $age_y = "";
        $age_m = "";
        $age_d = "";
        $address = "";
        $city_id = "";
        $state_id = "";
        $country_id = ""; 
        $this->load->model('ipd_booking/ipd_booking_model');
        $this->load->model('patient/patient_model');
        //  $ipd_booking_data = $this->ipd_booking_model->get_by_id($booking_id);
   
       
        $data['simulation_list'] = $this->general_model->simulation_list();
   
        $data['page_title'] = "Add Doctor Handover";
        
        $post = $this->input->post();
        
        $data['form_error'] = []; 
     
        if(isset($post) && !empty($post))
        {   
          
          $this->doctor_handover->save();
          
          // $this->session->set_userdata('ipd_prescription_id',$prescription_id);
          $this->session->set_flashdata('success','Medication chart successfully added.');
          redirect(base_url('doctor_handover/?status=print'));
        }   
        $this->load->model('ipd_booking/ipd_booking_model');
        $this->load->model('patient/patient_model');
        if(!empty($booking_id)) {
            $ipd_booking_data = $this->ipd_booking_model->get_by_id($booking_id);
// dd($ipd_booking_data);
            $data['form_data'] = [
                'ipd_id' => $ipd_booking_data['id'],
                'ipd_no' => $ipd_booking_data['ipd_no'],
                'patient_id' => $ipd_booking_data['patient_id'],
                'patient_code' => $ipd_booking_data['patient_code'],
                'patient_name' => $ipd_booking_data['patient_name'],
                'age_y' => $ipd_booking_data['age_y'],
                'age_m' => $ipd_booking_data['age_m'],
                'age_d' => $ipd_booking_data['age_d'],
                'mobile_no' => $ipd_booking_data['mobile_no'],
                'gender' => $ipd_booking_data['gender'],
            ];
        }
        
        $data['templates'] = $this->db->get('hms_ipd_doctor_handover_template')->result_array();
        // $data['medication_chart_list'] = $this->db->where(['booking_id'=>$booking_id,'patient_id'=>$patient_id])->get('hms_ipd_medication_chart')->result_array();
        $this->load->view('doctor_handover/add',$data);
    }

    public function get_ipd_details($term="")
    {
        $this->load->model('ipd_booking/ipd_booking_model');
        $this->load->model('patient/patient_model');
        $ipd_booking_data = $this->ipd_booking_model->get_by_id("",$term);
       $data = $ipd_booking_data['patient_name'] . ' ('.$ipd_booking_data['ipd_no'].')
       |' . $ipd_booking_data['ipd_no'].'
       |' . $ipd_booking_data['id'];
        echo json_encode([$data]);
    }

    public function get_full_ipd_details($booking_id="")
    {
        $this->load->model('ipd_booking/ipd_booking_model');
        $this->load->model('patient/patient_model');
        $ipd_booking_data = $this->ipd_booking_model->get_by_id($booking_id);
    
        echo json_encode($ipd_booking_data);
    }

    public function edit($id="")
    {
        $data['prescription_tab_setting'] = get_ipd_prescription_tab_setting();
        $data['prescription_medicine_tab_setting'] = get_ipd_prescription_medicine_tab_setting();
        
        $this->load->model('general/general_model'); 
        
        $data['gardian_relation_list'] = $this->general_model->gardian_relation_list();
        $post = $this->input->post();
        $patient_id = "";
        
        $this->load->model('ipd_booking/ipd_booking_model');
        $this->load->model('patient/patient_model');
        //  $ipd_booking_data = $this->ipd_booking_model->get_by_id($booking_id);
   
       
        $data['simulation_list'] = $this->general_model->simulation_list();
   
        $data['page_title'] = "Add Doctor Handover";
        
        $post = $this->input->post();
        
        $data['form_error'] = []; 
        $data['all_details'] = $this->doctor_handover->get_by_id($id);
        $this->load->model('ipd_booking/ipd_booking_model');
        $this->load->model('patient/patient_model');
        $ipd_booking_data = $this->ipd_booking_model->get_by_id($data['all_details']['ipd_id'],"");
        $data['form_data'] = [
            'ipd_no' => $ipd_booking_data['ipd_no'],
            'mobile_no' => $ipd_booking_data['mobile_no'],
            'patient_code' => $ipd_booking_data['patient_code'],
            'gender' => $ipd_booking_data['gender'],
            'patient_name' => $ipd_booking_data['patient_name'],
            'age_y' => $ipd_booking_data['age_y'],
            'age_m' => $ipd_booking_data['age_m'],
            'age_d' => $ipd_booking_data['age_d'],
            'ipd_id' => $ipd_booking_data['id'],
            'simulation_id' => $ipd_booking_data['simulation_id'],
            'morning_shift_date_time' => $data['all_details']['morning_shift_date_time']
        ];
        if(isset($post) && !empty($post))
        {   
          
          $this->doctor_handover->update($id);
          $this->session->set_userdata('madication_chart_id',$id);
          // $this->session->set_userdata('ipd_prescription_id',$prescription_id);
          $this->session->set_flashdata('success','Medication chart successfully updated.');
          redirect(base_url('doctor_handover/?status=print'));
        } 
       
        $data['templates'] = $this->db->get('hms_ipd_doctor_handover_template')->result_array();
        $this->load->view('doctor_handover/add',$data);
    }
    public function delete($id="")
    {
       
        $this->doctor_handover->delete($id);
        $this->session->set_flashdata('success','Doctor Handover successfully deleted.');
        redirect(base_url('doctor_handover'));
    }

    public function print_details($id="")
    {
        if(empty($id))
            $id= $this->session->userdata('doctor_handover_id');
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        // error_reporting(E_ALL);
        $data = [];
        $this->load->model('ipd_booking/ipd_booking_model');
        $this->load->model('patient/patient_model');
        $this->load->model('general/general_model');  
        $ids = explode(',',$id);
        $ids = array_reverse($ids);
        $all_details = [];
        $ipd_booking_data = [];
        foreach($ids as $i){
            $all_details[] = $this->doctor_handover->get_by_id($i);
            $ipd_booking_data = $this->ipd_booking_model->get_by_id($this->doctor_handover->get_by_id($i)['ipd_id']);
        }
        $data['all_details'] = $all_details;
        // $ipd_booking_data = $this->ipd_booking_model->get_by_id($data['all_details']['ipd_id']);
       
        $patient_id = $ipd_booking_data['patient_id'];
        $data['diagnosis_name'] = $this->db->where('id',$data['all_details']['diagnosis_id'])->get('hms_opd_diagnosis')->row_array()['diagnosis'];
       
        
        $data['data'] = $ipd_booking_data; //attend_doctor_id
        $data['doctor'] = get_doctor_signature($ipd_booking_data['attend_doctor_id']);
        $data['panel_company_name'] = $this->general_model->panel_company_details($data['data']['panel_name']);

        $this->load->view('doctor_handover/print_details',$data);
    }

    function deleteall()
    {
   
    $post = $this->input->post();  
   
        if(!empty($post))
        {
            $result = $this->doctor_handover->deleteall($post['row_id']);
            $response = "Doctor Handovers successfully deleted.";
            echo $response;
        }
    }

    public function diagnosis_list(){
        $term = $this->input->get();
        $data = [];
        // $this->db->select("diagnosis as text,id");
        if(!empty($term['term'])){
            $this->db->like('diagnosis', $term['term']);
            $this->db->limit(10);
            $data = $this->db->get('hms_opd_diagnosis')->result_array();
        } 
        else {
            $this->db->limit(10);
            $data = $this->db->get('hms_opd_diagnosis')->result_array();
        }
        echo json_encode($data);
    }

    public function loadEmployees($vals) {
        // Get the session data
        $user_data = $this->session->userdata('auth_users');
        
        // Select the employee name from the database
        $this->db->select('hms_employees.name');
        $this->db->where('branch_id', $user_data['parent_id']);
        // Uncomment and modify the lines below if you need additional filters
        $this->db->where('status', 1); 
        $this->db->where('is_deleted', 0); 
        $this->db->where('emp_type_id', 1490);
    
        if (!empty($vals)) {
            $vals = urldecode($vals);
            $this->db->like('name', $vals, 'after');
        }
    
        $this->db->order_by('hms_employees.name', 'ASC'); 
        $query = $this->db->get('hms_employees');
        $data = $query->result_array();
        
        echo json_encode($data);
    }
    
}
?>