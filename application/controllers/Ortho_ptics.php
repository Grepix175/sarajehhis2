<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ortho_ptics extends CI_Controller
{
    protected $fields;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ortho_ptics/Ortho_ptics_model', 'ortho_ptics');
        $this->load->model('opd_billing/opd_billing_model','opd_billing');
        $this->load->model('doctors/Doctors_model', 'doctor');
        $this->load->library('form_validation');
        // adding field array 
        $this->fields = array(
            'indication',
            'anterior_segment_evaluation',
            'spectacle_power_od',
            'spectacle_power_os',
            'keratometry_od',
            'keratometry_os',
            'hvid_od',
            'hvid_os',
            'contact_lens_trial_table',
            'trial_given',
            'final_order_table',
            'instruction_given_lens_dispensed_on',
            'consent_form'
        );
        error_reporting(0);
    }

    public function index()
    {
        
        $data['page_title'] = 'Ortho Ptics Records';
        $this->load->model('default_search_setting/default_search_setting_model');
        $default_search_data = $this->default_search_setting_model->get_default_setting();
        if (isset($default_search_data[1]) && !empty($default_search_data) && $default_search_data[1] == 1) {
            $start_date = '';
            $end_date = '';
        } else {
            $start_date = date('d-m-Y');
            $end_date = date('d-m-Y');
        }
        $data['form_data'] = array('patient_name' => '', 'patient_code' => '','mobile_no' => '', 'start_date' => $start_date, 'end_date' => $end_date,'emergency_booking'=>'');
        
        $this->load->view('ortho_ptics/list', $data);
    }

    public function ajax_list()
    {
        $list = $this->ortho_ptics->get_datatables();
        // echo "<pre>";
        // print_r($list);
        // die;
        $data = array();
        // $plist = $this->ortho_ptics->get_patient_name_by_booking_id($list->booking_id);

        $no = $_POST['start'];
        
        // echo "<pre>";print_r($list);die('okok');
        foreach ($list as $ortho_ptics) {
            $no++;

            $row = array();

            $age_y = $ortho_ptics->age_y;
            $age_m = $ortho_ptics->age_m;
            $age_d = $ortho_ptics->age_d;
      
            $age = "";
            if ($age_y > 0) {
              $year = 'Years';
              if ($age_y == 1) {
                $year = 'Year';
              }
              $age .= $age_y . " " . $year;
            }
            if ($age_m > 0) {
              $month = 'Months';
              if ($age_m == 1) {
                $month = 'Month';
              }
              $age .= ", " . $age_m . " " . $month;
            }
            if ($age_d > 0) {
              $day = 'Days';
              if ($age_d == 1) {
                $day = 'Day';
              }
              $age .= ", " . $age_d . " " . $day;
            }

            // Add a checkbox for selecting the record
            $row[] = '<input type="checkbox" name="refraction_ids[]" value="' . $ortho_ptics->refraction_id . '">';

            $row[] = $ortho_ptics->token;
            $row[] = $ortho_ptics->booking_id;
            $row[] = $ortho_ptics->patient_code;
            $row[] = $ortho_ptics->patient_name;
            // $row[] = $ortho_ptics->patient_category_name;
            $row[] = $ortho_ptics->mobile_no;
            $row[] = $age;
            // $row[] = "Dr. " . $ortho_ptics->doctor_name;
            // $row[] = $ortho_ptics->booking_id;
            // $row[] = $ortho_ptics->lens;
            // $row[] = $ortho_ptics->comment;

            // Check status and set active or not active
            $statuses = explode(',', $ortho_ptics->pat_status);

            // Trim any whitespace from the statuses and get the last one
            $last_status = trim(end($statuses));

            // Display the last status with the desired styling
            $row[] = '<font style="background-color: #228B30;color:white">'.$last_status.'</font>';
            $row[] = date('d-M-Y', strtotime($ortho_ptics->created));

            // Add action buttons
            $row[] = '<a onClick="return edit_refraction(' . $ortho_ptics->refraction_id . ');" class="btn-custom" href="javascript:void(0)" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                    <a href="javascript:void(0)" class="btn-custom" onClick="return print_window_page(\'' . base_url("ortho_ptics/print_oct_hfa/" . $ortho_ptics->booking_id."/".$ortho_ptics->id) . '\');">
                        <i class="fa fa-print"></i> Print
                    </a>';
            $row[] = $ortho_ptics->emergency_status;


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ortho_ptics->count_all(),
            "recordsFiltered" => $this->ortho_ptics->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);
    }



    public function add($booking_id = null, $id = null)
    {
        // echo "plp";die;
        // Load required models and libraries
        $this->load->library('form_validation');
       
        $data['page_title'] = 'Add Oct/hfa Record';
        $pres_id = 28;

        $result = $this->ortho_ptics->get_chief_complaints_by_patient_id($booking_id); // Adjust this method according to your model
        $chief_complaints = json_decode($result['chief_complaints']);
        $data['chief_complaints'] = (array) $chief_complaints;
        $data['referal_doctor_list'] = $this->opd_billing->referal_doctor_list();
        // echo "<pre>";print_r($data['chief_complaints']);die;
        
        $plist = $this->ortho_ptics->get_patient_name_by_booking_id($booking_id);
        // echo "<pre>";print_r($plist);die('ok');
        $data['booking_id'] = isset($booking_id) ? $booking_id : '';
        $result_refraction = $this->ortho_ptics->get_prescription_refraction_new_by_id($booking_id, $id);
        // echo "<pre>";print_r($booking_id);die;
        $data['booking_data'] = $this->ortho_ptics->get_bookings_by_id($booking_id);
        $data['doctor'] = $this->doctor->doctors_list();
        // echo "<pre>";print_r($data['booking_data']);die('kkkk');

        $oct_hfa_auto_refraction = isset($result_refraction['auto_refraction'])?json_decode($result_refraction['auto_refraction']):'';
        $data['refrtsn_auto_ref'] = (array) $oct_hfa_auto_refraction;
       
        // // Initialize form data
        $data['form_data'] = array(
            'booking_id' => isset($data['booking_data']['booking_id']) ? $data['booking_data']['booking_id'] : '', // Booking ID
            
            'branch_id' => isset($data['booking_data']['branch_id']) ? $data['booking_data']['branch_id'] : '', // To be filled from form
            'booking_code' => isset($data['booking_data']['booking_code']) ? $data['booking_data']['booking_code'] : '', // To be filled from form
            'pres_id' => isset($id) ? $id : '', // To be filled from form
            'patient_id' => isset($data['booking_data']['patient_id']) ? $data['booking_data']['patient_id'] : '', // To be filled from form
            'optometrist_signature' => '', // To be filled from form
            'doctor_signature' => '', // To be filled from form
            'referred_by' => '', // To be filled from form
            'main_complaints' => '', // To be filled from form
            'hours_of_work_computer' => '', // To be filled from form
            'associated_symptoms' => '', // To be filled from form
            'previ_his_of_ortho' => '', // To be filled from form
            'gene_heal_medi_deta' => '', // To be filled from form
            'refraction_tbl' => '', // To be filled from form
            'addi_test' => '', // To be filled from form
            'deta_rega_adap' => '', // To be filled from form
            'senso_evalu' => '', // To be filled from form
            'stere_with_rando_stere' => '', // To be filled from form
            'motor_evaluation' => '', // To be filled from form
            'distance_ipd' => '', // To be filled from form
            'ac_a_ratio' => '', // To be filled from form
            'heterophoria_method' => '', // To be filled from form
            'status' => 1, // Default value
            'is_deleted' => 0, // Default value
            'created_by' => $this->session->userdata('user_id'), // User ID from session
            'created_date' => date('Y-m-d H:i:s'), // Current timestamp
            'ip_address' => $this->input->ip_address(), // IP address
           
        ); 
        
        $data['form_data'] = array_merge($data['form_data']);
        // echo "<pre>";print_r($data['form_data']);die;

        $post = $this->input->post();
        // echo "<pre>";
        // print_r($post);
        // die;
       
        
        // // Check if the form is submitted
        // echo "<pre>";print_r($post);die('ss');
        if (isset($post) && !empty($post)) {
            // echo "<pre>";print_r($post);die('dfk');
    
            // Prepare the data for saving
            $id = $this->input->post('id');
            $branch_id = $this->input->post('branch_id');
            $booking_code = $this->input->post('booking_code');
            $pres_id = $this->input->post('pres_id');
            $patient_id = $this->input->post('patient_id');
            $booking_id = $this->input->post('booking_code');
            $remarks = $this->input->post('remarks');
            $referred_by = $this->input->post('referred_by');
            $main_complaints = $this->input->post('main_complaints');
            $hours_of_work_computer = $this->input->post('hours_of_work_computer');
            $associated_symptoms = $this->input->post('associated_symptoms');
            $previ_his_of_ortho = $this->input->post('previ_his_of_ortho');
            $gene_heal_medi_deta = $this->input->post('gene_heal_medi_deta');
            $addi_test = $this->input->post('addi_test');
            $deta_rega_adap = $this->input->post('deta_rega_adap');
            $senso_evalu = $this->input->post('senso_evalu');
            $stere_with_rando_stere = $this->input->post('stere_with_rando_stere');
            $motor_evaluation = $this->input->post('motor_evaluation');
            $distance_ipd = $this->input->post('distance_ipd');
            $ac_a_ratio = $this->input->post('ac_a_ratio');
            $heterophoria_method = $this->input->post('heterophoria_method');
            $created_by = $this->session->userdata('user_id');
            
            $refraction_tbl=array('visual_acuity_od'=>$post['visual_acuity_od'],'visual_acuity_os'=>$post['visual_acuity_os'],'duchrome_od'=>$post['duchrome_od'],'duchrome_os'=>$post['duchrome_os'],
			'pgp_od'=>$post['pgp_od'],'pgp_os'=>$post['pgp_os'],'static_retinoscopy_od'=>$post['static_retinoscopy_od'],'static_retinoscopy_os'=>$post['static_retinoscopy_os'],
			'acceptance_od'=>$post['acceptance_od'],'acceptance_os'=>$post['acceptance_os'],'jcc_refining_od'=>$post['jcc_refining_od'],'jcc_refining_os'=>$post['jcc_refining_os'],
			'add_od'=>$post['add_od'],'add_os'=>$post['add_os'],'after_binocular_balancing_od'=>$post['after_binocular_balancing_od'],'after_binocular_balancing_os'=>$post['after_binocular_balancing_os']);
            
            $eom_tbl=array('eom_od'=>$post['eom_od'],'eom_os'=>$post['eom_os']);
            
            $wfdt_tbl=array('wfdt_d'=>$post['wfdt_d'],'wfdt_n'=>$post['wfdt_n'],'cover_test_d'=>$post['cover_test_d'],'cover_test_n'=>$post['cover_test_n'],
			'maddox_rod_horizontal_d'=>$post['maddox_rod_horizontal_d'],'maddox_rod_horizontal_n'=>$post['maddox_rod_horizontal_n'],'maddox_rod_vertical_d'=>$post['maddox_rod_vertical_d'],'maddox_rod_vertical_n'=>$post['maddox_rod_vertical_n'],
			'pbct_d'=>$post['pbct_d'],'pbct_n'=>$post['pbct_n']);
            

            // Prepare the data to save
            $data_to_save = [
                'id' => isset($id) ? $id : '',
                'branch_id' => isset($branch_id) ? $branch_id : '',
                'booking_code' => isset($booking_code) ? $booking_code : '',
                'pres_id' => isset($pres_id) ? $pres_id : '',
                'patient_id' => isset($patient_id) ? $patient_id : '',
                'booking_id' => isset($booking_id) ? $booking_id : '',
                'referred_by' => isset($referred_by) ? $referred_by : '',
                'refraction_tbl' => json_encode(isset($refraction_tbl) ? $refraction_tbl : ''),           
                'eom_tbl' => json_encode(isset($eom_tbl) ? $eom_tbl : ''),           
                'wfdt_tbl' => json_encode(isset($wfdt_tbl) ? $wfdt_tbl : ''),           
                'remarks' => isset($remarks) ? $remarks : '',           
                'main_complaints' => isset($main_complaints) ? $main_complaints : '',           
                'hours_of_work_computer' => isset($hours_of_work_computer) ? $hours_of_work_computer : '',           
                'associated_symptoms' => isset($associated_symptoms) ? $associated_symptoms : '',           
                'previ_his_of_ortho' => isset($previ_his_of_ortho) ? $previ_his_of_ortho : '',           
                'gene_heal_medi_deta' => isset($gene_heal_medi_deta) ? $gene_heal_medi_deta : '',           
                'addi_test' => isset($addi_test) ? $addi_test : '',           
                'deta_rega_adap' => isset($deta_rega_adap) ? $deta_rega_adap : '',           
                'senso_evalu' => isset($senso_evalu) ? $senso_evalu : '',           
                'stere_with_rando_stere' => isset($stere_with_rando_stere) ? $stere_with_rando_stere : '',           
                'motor_evaluation' => isset($motor_evaluation) ? $motor_evaluation : '',           
                'distance_ipd' => isset($distance_ipd) ? $distance_ipd : '',           
                'ac_a_ratio' => isset($ac_a_ratio) ? $ac_a_ratio : '',           
                'heterophoria_method' => isset($heterophoria_method) ? $heterophoria_method : '',           
                'status' => 1,
                'is_deleted' => 0,
                'created_by' => isset($created_by) ? $created_by : '',
                'created_date' => date('Y-m-d H:i:s'),
                'ip_address' => $this->input->ip_address(),

            ];

            
            // echo "<pre>";
            // print_r($data_to_save); // For debugging
            // die("ok");

            // Save the data            
            $this->ortho_ptics->save($data_to_save);
            $this->session->set_flashdata('success', 'Ortho Ptics data saved successfully.');
            echo json_encode(['success' => true, 'message' => 'Ortho Ptics data saved successfully.']);
            return;

        }
        
        // $data['chief_complaints'] = $chief_complaints;

        // If the form is not submitted or validation fails, load the view with the existing data


        // Load the view with the data
        $this->load->view('ortho_ptics/add', $data);
    }

    public function fill_eye_data_auto_refraction($modal)
    {
        // echo "ijij";die;
        $data['page_title'] = $modal;
        $this->load->view('ortho_ptics/refraction_mod', $data);
    }

    public function edit($id = "")
    {
        // echo $id;die;         // Check user permissions
        $this->load->library('form_validation');

        unauthorise_permission('411', '2486');

        // Validate the ID
        if (isset($id) && !empty($id) && is_numeric($id)) {
            $data['page_title'] = 'Edit Ortho Paedic Record';
            $data['referal_doctor_list'] = $this->opd_billing->referal_doctor_list();
            // Retrieve the refraction record by ID
            $result = $this->ortho_ptics->get_by_id($id); // Adjust this method according to your model
            // echo "<pre>";print_r($result);die;
            $comp = $this->ortho_ptics->get_chief_complaints_by_booking_id($result['booking_id']);
            $refraction_tbl = json_decode($result['refraction_tbl']); // Adjust this method according to your model
            $data['refraction_tbl'] = (array) $refraction_tbl;
            // echo "<pre>";print_r($data['chief_complaints']);die;
            $eom_tbl = json_decode($result['eom_tbl']);
            $data['eom_tbl'] = (array) $eom_tbl;

            $wfdt_tbl = json_decode($result['wfdt_tbl']);
            $data['wfdt_tbl'] = (array) $wfdt_tbl;
            if (!$result) {
                // Handle case where no record is found
                show_error('Ortho Paedic record not found', 404);
                return;
            }

            // Prepare data for the view
           // Assuming $result['auto_refraction'] could be a JSON string
        //    $color_vision = json_decode($result['color_vision'], true); // Decode into an associative array
        //    $contrast_sensivity = json_decode($result['contrast_sensivity'], true); // Decode into an associative array
           $data['booking_data'] = $this->ortho_ptics->get_booking_by_id($result['booking_id']);
           $data['doctor'] = $this->doctor->doctors_list();
        //    echo "<pre>";print_r($data['eom_tbl']);die;

            // Check if decoding was successful
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Handle JSON decode error (for example, log it and set $auto_refraction_data to an empty array)
                log_message('error', 'JSON decode error: ' . json_last_error_msg());
                $color_vision = []; // Default to an empty array if there's an error
                $contrast_sensivity = []; // Default to an empty array if there's an error
            }
            // echo "<pre>";print_r($result);die;
            // Populate form data
            $data['form_data'] = array(
                'id' => $id,
                'booking_id' => $result['booking_id'],
                'patient_id' => $result['patient_id'],
                'editable' => true,
                'branch_id' => $result['branch_id'],
                'booking_code' => $result['booking_code'],
                'remarks' => $result['remarks'],
                'referred_by' => $result['referred_by'],
                'main_complaints' => $result['main_complaints'],           
                'hours_of_work_computer' => $result['hours_of_work_computer'],           
                'associated_symptoms' => $result['associated_symptoms'],           
                'previ_his_of_ortho' => $result['previ_his_of_ortho'],           
                'gene_heal_medi_deta' => $result['gene_heal_medi_deta'],           
                'addi_test' => $result['addi_test'],           
                'deta_rega_adap' => $result['deta_rega_adap'],           
                'senso_evalu' => $result['senso_evalu'],           
                'stere_with_rando_stere' => $result['stere_with_rando_stere'],           
                'motor_evaluation' => $result['motor_evaluation'],           
                'distance_ipd' => $result['distance_ipd'],           
                'ac_a_ratio' => $result['ac_a_ratio'],           
                'heterophoria_method' => $result['heterophoria_method'],
                'status' => $result['status'],
                'is_deleted' => $result['is_deleted'],                
            );
            // foreach($this->fields as $keys){
            //     if(isset($result[$keys])){
            //         $data['form_data'][$keys] = $result[$keys];
            //     }                
            // }
            // Check if there is form submission
            if ($this->input->post()) {
                // echo "<pre>";print_r($this->input->post());die('okok');
                
                
                // Convert the refraction data to JSON
                $color_vision_data_json = json_encode($color_vision_data);
                $contrast_data_json = json_encode($contrast_data);
            
                // Prepare the data for updating
                $data_to_update = [
                    'id' => $this->input->post('id'),
                    'branch_id' => $this->input->post('branch_id'),
                    'booking_code' => $this->input->post('booking_code'),
                    'pres_id' => $this->input->post('pres_id'),
                    'patient_id' => $this->input->post('patient_id'),
                    'booking_id' => $this->input->post('booking_id'),                   
                    'optometrist_signature' => $this->input->post('optometrist_signature'),
                    'doctor_signature' => $this->input->post('doctor_signature'),
                    'status' => 1, // Or whatever default value you need
                    'is_deleted' => 0, // Assuming this is default
                    'modified_date' => date('Y-m-d H:i:s'), // Current timestamp for update
                    'ip_address' => $this->input->ip_address(),
                ];
                foreach($this->fields as $keys){
                    $data_to_update[$keys] = $this->input->post($keys);
                }
            
                // Update the data
                $this->ortho_ptics->save($data_to_update); // Adjust this method according to your model
                $this->session->set_flashdata('success', 'Oct_hfa record updated successfully.');
                echo json_encode(['success' => true, 'message' => 'Oct_hfa record updated successfully.']);
                return; // Exit to prevent further output
            }
            
            // echo "<pre>";print_r($data);die;
            // Load the view with the prepared data
            $this->load->view('ortho_ptics/add', $data); // Adjust the view name as necessary
        } else {
            // Handle the case when the ID is not valid
            show_error('Invalid ID provided', 400);
        }
    }

    private function _validate() {
        // Set validation rules for your form fields
        $this->form_validation->set_rules('oct_hfa_col_vis_l', 'Left Eye Vision', 'required|trim');
        $this->form_validation->set_rules('oct_hfa_col_vis_r', 'Right Eye Vision', 'required|trim');
        $this->form_validation->set_rules('oct_hfa_contra_sens_l', 'Left Eye Contrast Sensitivity', 'required|trim');
        $this->form_validation->set_rules('oct_hfa_contra_sens_r', 'Right Eye Contrast Sensitivity', 'required|trim');
        $this->form_validation->set_rules('amsler_grid', 'Amsler Grid', 'trim');
        $this->form_validation->set_rules('optometrist_signature', 'Optometrist Signature', 'trim');
        $this->form_validation->set_rules('doctor_signature', 'Doctor Signature', 'trim');
    
        // Set custom error messages if needed
        $this->form_validation->set_message('required', 'The {field} field is required.');
    
        // Run validation
        if ($this->form_validation->run() == FALSE) {
            return false; // Validation failed
        }
        return true; // Validation passed
    }
    

    public function print_oct_hfa($booking_id = NULL ,$id = NULL)
    {
        // echo "ppk";die;
        $data['print_status'] = "1";
        $data['data_list'] = $this->ortho_ptics->search_report_data($booking_id,$id);
        $data['booking_data'] = $this->ortho_ptics->get_booking_by_id($booking_id);
        $data['doctor'] = $this->doctor->doctors_list();

        $refraction_tbl = json_decode($data['data_list']['refraction_tbl']); // Adjust this method according to your model
            $data['refraction_tbl'] = (array) $refraction_tbl;
            // echo "<pre>";print_r($data['chief_complaints']);die;
            $eom_tbl = json_decode($data['data_list']['eom_tbl']);
            $data['eom_tbl'] = (array) $eom_tbl;

            $wfdt_tbl = json_decode($data['data_list']['wfdt_tbl']);
            $data['wfdt_tbl'] = (array) $wfdt_tbl;


        // Fetch the OPD billing details based on the ID
        // $booking_id = isset($data['form_data']['booking_id'])?$data['form_data']['booking_id']:'';
        // $data['billing_data'] = $this->vision_model->get_patient_name_by_booking_id($booking_id);
        // echo "<pre>";print_r($data['data_list'][0]);die;

        // Load the print view with the data
        $this->load->view('ortho_ptics/print_ortho_paedic', $data);
    }

    public function update()
    {
        $post = $this->input->post();

        if (empty($post['data_id'])) {
            $this->session->set_flashdata('error', 'No record found to update');
            redirect('Oct_hfa');
        }

        $this->ortho_ptics->save();
        $this->session->set_flashdata('success', 'Record updated successfully');
        redirect('Oct_hfa');
    }

    
    public function ortho_peadics_excel()
    {
        // $list = $this->ortho_ptics->get_datatables();
        // echo "<pre>";print_r($list);die;   
        // Load the PHPExcel library (Make sure the 'excel' library is correctly loaded in your application)
        $this->load->library('excel');
        
        // Initialize PHPExcel
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("Oct_hfa List")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);

        $from_date = $this->input->get('start_date');
        $to_date = $this->input->get('end_date');

        // Main header with date range if provided
        $mainHeader = "Ortho Paedic List";
        if (!empty($from_date) && !empty($to_date)) {
            $mainHeader .= " (From: " . date('d-m-Y', strtotime($from_date)) . " To: " . date('d-m-Y', strtotime($to_date)) . ")";
        }

        // Set the main header in row 1
        $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $mainHeader);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(16);

        // Leave row 2 blank
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);

        // Field names (header row) should start in row 3
        $fields = array('Token No', 'OPD No', 'Patient Reg No.', 'Patient Name', 'Mobile No', 'Age','Patient Status','Created Date');

        $col = 0; // Initialize the column index
        foreach ($fields as $field) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 3, $field); // Row 3 for headers
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true); // Auto-size columns
            $col++;
        }

        // Style for header row (Row 3)
        $objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // Fetching the OPD data
        $list = $this->ortho_ptics->get_datatables();
        // echo "<pre>";print_r($list);die;

        // Populate the data starting from row 4
        $row = 4; // Start at row 4 for data
        if (!empty($list)) {
            foreach ($list as $ortho_ptics) {
                // Reset column index for each new row
                $col = 0;
                
                $age_y = $ortho_ptics->age_y;
                $age_m = $ortho_ptics->age_m;
                $age_d = $ortho_ptics->age_d;
        
                $age = "";
                if ($age_y > 0) {
                $year = 'Years';
                if ($age_y == 1) {
                    $year = 'Year';
                }
                $age .= $age_y . " " . $year;
                }
                if ($age_m > 0) {
                $month = 'Months';
                if ($age_m == 1) {
                    $month = 'Month';
                }
                $age .= ", " . $age_m . " " . $month;
                }
                if ($age_d > 0) {
                $day = 'Days';
                if ($age_d == 1) {
                    $day = 'Day';
                }
                $age .= ", " . $age_d . " " . $day;
                }
                $statuses = explode(',', $ortho_ptics->pat_status);
          
                // Trim any whitespace from the statuses and get the last one
                $last_status = trim(end($statuses));
                $created_date = date('d-m-Y h:i A', strtotime($ortho_ptics->created));
                // Prepare data to be populated
                $data = array(
                    $ortho_ptics->token,
                    $ortho_ptics->booking_id,
                    $ortho_ptics->patient_code,
                    $ortho_ptics->patient_name,
                    $ortho_ptics->mobile_no,
                    $age, // Adding missing 'Age' field
                    // $ortho_ptics->status == 1 ? 'Active' : 'Not Active',
                    $last_status,
                    $created_date
                );

                foreach ($data as $cellValue) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $cellValue);
                    $col++;
                }
                $row++; // Move to the next row
            }
        }

        // Send headers to force download of the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="ortho_paedics_list_' . time() . '.xls"');
        header('Cache-Control: max-age=0');

        // Write the Excel file
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean(); // Prevent any output before sending file
        $objWriter->save('php://output');
    }



    public function ortho_paedic_pdf()
    {
        // Increase memory limit and execution time for PDF generation
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 300);

        // Prepare data for the PDF
        // $data['print_status'] = "";
        // $from_date = $this->input->get('start_date');
        // $to_date = $this->input->get('end_date');

        // Fetch OPD data
        $data['data_list'] = $this->ortho_ptics->get_datatables();
        // echo "<pre>";
        // print_r($data);
        // die;
        // $data['data_list']['side_effect_name'] = $this->vision_model->get_side_effect_name($data['data_list']['side_effects']);
        // Create main header
        $data['mainHeader'] = "Ortho paedic List";
        // if (!empty($from_date) && !empty($to_date)) {
        // $data['mainHeader'] .= " (From: " . date('d-m-Y', strtotime($from_date)) . " To: " . date('d-m-Y', strtotime($to_date)) . ")";
        // }

        // Load the view and capture the HTML output
        $this->load->view('ortho_ptics/ortho_paedic_html', $data);
        $html = $this->output->get_output();

        // Load PDF library and convert HTML to PDF
        $this->load->library('pdf');
        $this->pdf->load_html($html);
        $this->pdf->render();

        // Stream the generated PDF to the browser
        $this->pdf->stream("ortho_paedic_list_" . time() . ".pdf", array("Attachment" => 1));
    }    
    public function reset_search()
    {
        $this->session->unset_userdata('prescription_search');
    }
    public function advance_search()
    {
        $this->load->model('general/general_model');
        $data['page_title'] = "Advance Search";
        $post = $this->input->post();

        $data['form_data'] = array(
            "start_date" => '',
            "end_date" => '',
            "patient_code" => "",
            "patient_name" => "",
        );
        if (isset($post) && !empty($post)) {
            $marge_post = array_merge($data['form_data'], $post);
            $this->session->set_userdata('prescription_search', $marge_post);

        }
        $prescription_search = $this->session->userdata('prescription_search');
        if (isset($prescription_search) && !empty($prescription_search)) {
            $data['form_data'] = $prescription_search;
        }
        $this->load->view('ortho_ptics/advance_search', $data);
    }

    public function deleteall()
    {
        $ids = $this->input->post('row_id');
        // echo "<pre>";
        // print_r($ids);
        // die;
        if (!empty($ids)) {
            $this->ortho_ptics->deleteall($ids);
            // echo json_encode(array("status" => TRUE));
            $response = "Dilate successfully deleted.";
            echo $response;
        }
    }

}