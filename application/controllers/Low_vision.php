<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Low_vision extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('low_vision/Low_vision_model', 'low_vision');
        $this->load->model('doctors/Doctors_model', 'doctor');
        $this->load->library('form_validation');
    }

    public function index()
    {

        $data['page_title'] = 'Low vision Records';
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
        
        $this->load->view('low_vision/list', $data);
    }

    public function ajax_list()
    {
        $list = $this->low_vision->get_datatables();
        $data = array();
        // $plist = $this->low_vision->get_patient_name_by_booking_id($list->booking_id);

        $no = $_POST['start'];
        
        // echo "<pre>";print_r($list);die('okok');
        foreach ($list as $low_vision) {
            $no++;

            $row = array();

            $age_y = $low_vision->age_y;
            $age_m = $low_vision->age_m;
            $age_d = $low_vision->age_d;
      
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
            $row[] = '<input type="checkbox" name="refraction_ids[]" value="' . $low_vision->refraction_id . '">';

            $row[] = $low_vision->token;
            // $row[] = $low_vision->booking_id;
            $row[] = $low_vision->booking_code;
            $row[] = $low_vision->patient_code;
            $row[] = $low_vision->patient_name;
            // $row[] = $low_vision->patient_category_name;
            $row[] = $low_vision->mobile_no;
            $row[] = $age;
            // $row[] = "Dr. " . $low_vision->doctor_name;
            // $row[] = $low_vision->booking_id;
            // $row[] = $low_vision->lens;
            // $row[] = $low_vision->comment;

            // Check status and set active or not active
            // Assuming pat_status contains comma-separated values like 'Contact Lens, Low vision'
            $statuses = explode(',', $low_vision->pat_status);

            // Trim any whitespace from the statuses and get the last one
            $last_status = trim(end($statuses));

            // Display the last status with the desired styling
            $row[] = '<font style="background-color: #228B30;color:white">'.$last_status.'</font>';
            $row[] = date('d-M-Y', strtotime($low_vision->created));

            // Add action buttons
            $row[] = '<a onClick="return edit_refraction(' . $low_vision->refraction_id . ');" class="btn-custom" href="javascript:void(0)" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                    <a href="javascript:void(0)" class="btn-custom" onClick="return print_window_page(\'' . base_url("low_vision/print_low_vision/" . $low_vision->booking_id."/".$low_vision->refraction_id) . '\');">
                        <i class="fa fa-print"></i> Print
                    </a>';
            $row[] = $low_vision->emergency_status;


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->low_vision->count_all(),
            "recordsFiltered" => $this->low_vision->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);
    }



    public function add($booking_id = null, $id = null)
    {
        // echo "<pre>";
        // print_r($booking_id);
        // print_r($id);
        // die('oka');
        // echo "plp";die;
        // Load required models and libraries
        $this->load->library('form_validation');
        // $this->load->model('low_vision/refraction_model'); // Ensure this model is loaded
        // $data['side_effects'] = $this->low_vision->get_all_side_effects(); // Fetch side effects
        $data['page_title'] = 'Add Low vision Record';
        // $pres_id = 28;
        
        $plist = $this->low_vision->get_patient_name_by_booking_id($booking_id);
        // echo "<pre>";print_r($plist);die('ok');
        $data['booking_id'] = isset($booking_id) ? $booking_id : '';
        $result_refraction = $this->low_vision->get_prescription_refraction_new_by_id($booking_id, $id);
        // echo "<pre>";print_r($booking_id);die;
        $data['booking_data'] = $this->low_vision->get_bookings_by_id($booking_id);
        $data['doctor'] = $this->doctor->doctors_list();
        // echo "<pre>";print_r($data['booking_data']);die('kkkk');

        $low_vision_auto_refraction = isset($result_refraction['auto_refraction'])?json_decode($result_refraction['auto_refraction']):'';
        $data['refrtsn_auto_ref'] = (array) $low_vision_auto_refraction;

        // $patient_details = $this->low_vision->get_patient_name_by_booking_id($booking_id);
        // echo "<pre>";
        // print_r($plist);die;
        
        // if ($booking_id && $patient_details) {
        //     $data['patient_name'] = $patient_details['patient_name'];
        // } else {
        //     $data['patient_name'] = ''; // Default value if no booking_id is provided
        // }

        // // Initialize form data
        $data['form_data'] = array(
            // 'booking_id' => isset($data['booking_data']['booking_id']) ? $data['booking_data']['booking_id'] : '', // Booking ID
            'booking_id' => isset($data['booking_data']['opd_id']) ? $data['booking_data']['opd_id'] : '', // Booking ID
            'low_vision_col_vis_l' => '', // Left eye dry sph
            'low_vision_col_vis_r' => '', // Left eye dry cyl
            'low_vision_contra_sens_l' => '', // Left eye dry axis
            'low_vision_contra_sens_r' => '', // Left eye dd sph
            'branch_id' => isset($data['booking_data']['branch_id']) ? $data['booking_data']['branch_id'] : '', // To be filled from form
            'booking_code' => isset($data['booking_data']['booking_code']) ? $data['booking_data']['booking_code'] : '', // To be filled from form
            'pres_id' => isset($id) ? $id : '', // To be filled from form
            'patient_id' => isset($data['booking_data']['patient_id']) ? $data['booking_data']['patient_id'] : '', // To be filled from form
            'patient_name' => isset($data['booking_data']['patient_name']) ? $data['booking_data']['patient_name'] : '',
            'amsler_grid' => '',
            'lva_trial' => '',
            'distance_lva' => '',
            'near_lva' => '',
            'non_optical_device' => '',
            'final_advice' => '',
            'referred_for' => '',
            'follow_up' => '',
            'optometrist_signature' => '', // To be filled from form
            'doctor_signature' => '', // To be filled from form
            'status' => 1, // Default value
            'is_deleted' => 0, // Default value
            'created_by' => $this->session->userdata('user_id'), // User ID from session
            'created_date' => date('Y-m-d H:i:s'), // Current timestamp
            'ip_address' => $this->input->ip_address(), // IP address
        );
        
        // echo "<pre>";print_r($data);die;

        $post = $this->input->post();
        
        // // Check if the form is submitted
        // echo "<pre>";print_r($post);die('ss');
        if (isset($post) && !empty($post)) {
            // echo "<pre>";print_r($post);die('dfk');
            $patient_exists = $this->low_vision->patient_exists($post['patient_id']);
            //   echo "<pre>";
            // print_r( $patient_exists);
            // die;
            if(empty($post['id'])){
                if ($patient_exists) {
                    // Redirect to OPD list page with a warning message
                    $this->session->set_flashdata('warning', 'Patient ' . $patient_exists['patient_name'] . ' is already in Low Vision.');
                    echo json_encode(['faield' => true, 'message' => 'Patient ' . $patient_exists['patient_name'] . ' is already in Low Vision.']);
                    // redirect('help_desk'); // Change 'opd_list' to your OPD list page route
                    return;
                }

            }

        
            // Prepare the refraction data based on received fields
            $color_vision_data = [
                'low_vision_col_vis_l' => $this->input->post('low_vision_col_vis_l'),
                'low_vision_col_vis_r' => $this->input->post('low_vision_col_vis_r'),
            ];

            $contrast_data = [
                'low_vision_contra_sens_l' => $this->input->post('low_vision_contra_sens_l'),
                'low_vision_contra_sens_r' => $this->input->post('low_vision_contra_sens_r'),
            ];
        
            // Convert the refraction data to JSON
            $color_vision_data_json = json_encode($color_vision_data);
            $contrast_data_json = json_encode($contrast_data);
        
            // Prepare the data for saving
            $id = $this->input->post('id');
            $branch_id = $this->input->post('branch_id');
            $booking_code = $this->input->post('booking_code');
            $pres_id = $this->input->post('pres_id');
            $patient_id = $this->input->post('patient_id');
            $booking_id = $this->input->post('booking_id');
            $optometrist_signature = $this->input->post('optometrist_signature');
            $doctor_signature = $this->input->post('doctor_signature');
            $created_by = $this->session->userdata('user_id');

            // Removed lens and comment
            // Add new fields from your POST data
            $color_vision = $this->input->post('color_vision');
            $contrast_sensivity = $this->input->post('contrast_sensivity');
            $patient_name = $this->input->post('patient_name');
            $amsler_grid = $this->input->post('amsler_grid');
            $lva_trial = $this->input->post('lva_trial');
            $distance_lva = $this->input->post('distance_lva');
            $near_lva = $this->input->post('near_lva');
            $non_optical_device = $this->input->post('non_optical_device');
            $final_advice = $this->input->post('final_advice');
            $referred_for = $this->input->post('referred_for');
            $follow_up = $this->input->post('follow_up');

            // Prepare the data to save
            $data_to_save = [
                'id' => isset($id) ? $id : '',
                'branch_id' => isset($branch_id) ? $branch_id : '',
                'booking_code' => isset($booking_code) ? $booking_code : '',
                'pres_id' => isset($pres_id) ? $pres_id : '',
                'patient_id' => isset($patient_id) ? $patient_id : '',
                'booking_id' => isset($booking_id) ? $booking_id : '',
                'optometrist_signature' => isset($optometrist_signature) ? $optometrist_signature : '',
                'doctor_signature' => isset($doctor_signature) ? $doctor_signature : '',
                'color_vision' => isset($color_vision_data_json) ? $color_vision_data_json : '',
                'contrast_sensivity' => isset($contrast_data_json) ? $contrast_data_json : '',
                'patient_name' => isset($patient_name) ? $patient_name : '',
                'amsler_grid' => isset($amsler_grid) ? $amsler_grid : '',
                'lva_trial' => isset($lva_trial) ? $lva_trial : '',
                'distance_lva' => isset($distance_lva) ? $distance_lva : '',
                'near_lva' => isset($near_lva) ? $near_lva : '',
                'non_optical_device' => isset($non_optical_device) ? $non_optical_device : '',
                'final_advice' => isset($final_advice) ? $final_advice : '',
                'referred_for' => isset($referred_for) ? $referred_for : '',
                'follow_up' => isset($follow_up) ? $follow_up : '',
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
            $this->low_vision->save($data_to_save);
            $this->session->set_flashdata('success', 'Low vision data saved successfully.');
            echo json_encode(['success' => true, 'message' => 'Low vision data saved successfully.']);
            return;

        }
        
        

        // If the form is not submitted or validation fails, load the view with the existing data


        // Load the view with the data
        $this->load->view('low_vision/add', $data);
    }

    public function book_patient()
    {
        // public function book_patient() {
        $patient_id = $this->input->post('patient_id');
        // $this->load->model('token_no');

        // Perform booking logic
        $booking_result = $this->low_vision->book_patient($patient_id);

        if ($booking_result) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Booking failed.']);
        }
        // }
    }

    public function check_booking_status()
    {
        $patient_id = $this->input->post('patient_id');
        // $this->load->model('Booking_model');

        // Check status in the database
        $status = $this->low_vision->get_booking_status($patient_id);
        // echo "<pre>";
        // print_r($status);
        // die('sagar');
        if ($status == 1) {
            echo json_encode(['status' => '1']); // Already in progress
        } else {
            echo json_encode(['status' => '0']); // Not booked yet
        }
    }

    public function update_status_opd()
    {
        $patientId = $this->input->post('patient_id');

        if (!$patientId) {
            echo json_encode(['status' => 'error', 'message' => 'Patient ID is required.']);
            return;
        }

        // Update status logic
        $updated = $this->low_vision->update_patient_list_opd_status($patientId, 'new_status'); // Adjust as needed

        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'Status updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update status.']);
        }
    }

    public function fill_eye_data_auto_refraction($modal)
    {
        // echo "ijij";die;
        $data['page_title'] = $modal;
        $this->load->view('low_vision/refraction_mod', $data);
    }

    public function edit($id = "")
    {
        // echo $id;die;         // Check user permissions
        $this->load->library('form_validation');

        unauthorise_permission('411', '2486');

        // Validate the ID
        if (isset($id) && !empty($id) && is_numeric($id)) {
            $data['page_title'] = 'Edit Low Vision Record';

            // Retrieve the refraction record by ID
            $result = $this->low_vision->get_by_id($id); // Adjust this method according to your model
            // echo "<pre>";print_r($result);die;
            if (!$result) {
                // Handle case where no record is found
                show_error('Low Vision record not found', 404);
                return;
            }

            // Prepare data for the view
           // Assuming $result['auto_refraction'] could be a JSON string
           $color_vision = json_decode($result['color_vision'], true); // Decode into an associative array
           $contrast_sensivity = json_decode($result['contrast_sensivity'], true); // Decode into an associative array
           $data['booking_data'] = $this->low_vision->get_booking_by_id($result['booking_id']);
           $data['doctor'] = $this->doctor->doctors_list();
        //    echo "<pre>";print_r($data['doctor']);die;

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
                'editable' => true,
                'branch_id' => $result['branch_id'],
                'booking_code' => $result['booking_code'],
                'pres_id' => $result['pres_id'],
                'patient_id' => $result['patient_id'],
                'low_vision_col_vis_l' => $color_vision['low_vision_col_vis_l']??'', // Left eye dry sph
                'low_vision_col_vis_r' => $color_vision['low_vision_col_vis_r']??'',  // Left eye dry cyl
                'low_vision_contra_sens_l' => $contrast_sensivity['low_vision_contra_sens_l']??'',  // Left eye dry axis
                'low_vision_contra_sens_r' => $contrast_sensivity['low_vision_contra_sens_r']??'',  // Left eye dd sph
                'optometrist_signature' => $result['optometrist_signature'],
                'doctor_signature' => $result['doctor_signature'],
                'status' => $result['status'],
                'is_deleted' => $result['is_deleted'],
                'patient_name' => $result['patient_name'],
                'amsler_grid' =>$result['amsler_grid'],
                'lva_trial' =>  $result['lva_trial'],
                'distance_lva' =>$result['distance_lva'],
                'near_lva' => $result['near_lva'],
                'non_optical_device' => $result['non_optical_device'],
                'final_advice' => $result['final_advice'],
                'referred_for' => $result['referred_for'],
                'follow_up' =>  $result['follow_up'],
            );
            // Check if there is form submission
            if ($this->input->post()) {
                // echo "<pre>";print_r($this->input->post());die('okok');
                // Prepare the refraction data for JSON
                $color_vision_data = [
                    'low_vision_col_vis_l' => $this->input->post('low_vision_col_vis_l'),
                    'low_vision_col_vis_r' => $this->input->post('low_vision_col_vis_r'),
                ];
            
                // Check if contrast sensitivity fields are empty, if yes, retain the previous values
                $contrast_data = [
                    'low_vision_contra_sens_l' => $this->input->post('low_vision_contra_sens_l') !== '' 
                        ? $this->input->post('low_vision_contra_sens_l') 
                        : $contrast_sensivity['low_vision_contra_sens_l'],
                        
                    'low_vision_contra_sens_r' => $this->input->post('low_vision_contra_sens_r') !== '' 
                        ? $this->input->post('low_vision_contra_sens_r') 
                        : $contrast_sensivity['low_vision_contra_sens_r'],
                ];
            
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
                    'color_vision' => isset($color_vision_data_json) ? $color_vision_data_json : '',
                    'contrast_sensivity' => isset($contrast_data_json) ? $contrast_data_json : '',
                    'patient_name' => $this->input->post('patient_name'),
                    'amsler_grid' => $this->input->post('amsler_grid'),
                    'lva_trial' => $this->input->post('lva_trial'),
                    'distance_lva' => $this->input->post('distance_lva'),
                    'near_lva' => $this->input->post('near_lva'),
                    'non_optical_device' => $this->input->post('non_optical_device'),
                    'final_advice' => $this->input->post('final_advice'),
                    'referred_for' => $this->input->post('referred_for'),
                    'follow_up' => $this->input->post('follow_up'),
                    'optometrist_signature' => $this->input->post('optometrist_signature'),
                    'doctor_signature' => $this->input->post('doctor_signature'),
                    'status' => 1, // Or whatever default value you need
                    'is_deleted' => 0, // Assuming this is default
                    'modified_date' => date('Y-m-d H:i:s'), // Current timestamp for update
                    'ip_address' => $this->input->ip_address(),
                ];
            
                // Update the data
                $this->low_vision->save($data_to_update); // Adjust this method according to your model
                $this->session->set_flashdata('success', 'Low Vision record updated successfully.');
                echo json_encode(['success' => true, 'message' => 'Low Vision record updated successfully.']);
                return; // Exit to prevent further output
            }
            
            // echo "<pre>";print_r($data);die;
            // Load the view with the prepared data
            $this->load->view('low_vision/add', $data); // Adjust the view name as necessary
        } else {
            // Handle the case when the ID is not valid
            show_error('Invalid ID provided', 400);
        }
    }

    private function _validate() {
        // Set validation rules for your form fields
        $this->form_validation->set_rules('low_vision_col_vis_l', 'Left Eye Vision', 'required|trim');
        $this->form_validation->set_rules('low_vision_col_vis_r', 'Right Eye Vision', 'required|trim');
        $this->form_validation->set_rules('low_vision_contra_sens_l', 'Left Eye Contrast Sensitivity', 'required|trim');
        $this->form_validation->set_rules('low_vision_contra_sens_r', 'Right Eye Contrast Sensitivity', 'required|trim');
        $this->form_validation->set_rules('patient_name', 'Patient Name', 'required|trim');
        $this->form_validation->set_rules('amsler_grid', 'Amsler Grid', 'trim');
        $this->form_validation->set_rules('lva_trial', 'LVA Trial', 'trim');
        $this->form_validation->set_rules('distance_lva', 'Distance LVA', 'trim');
        $this->form_validation->set_rules('near_lva', 'Near LVA', 'trim');
        $this->form_validation->set_rules('non_optical_device', 'Non-Optical Device', 'trim');
        $this->form_validation->set_rules('final_advice', 'Final Advice', 'trim');
        $this->form_validation->set_rules('referred_for', 'Referred For', 'trim');
        $this->form_validation->set_rules('follow_up', 'Follow Up', 'trim');
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
    

    public function print_low_vision($booking_id = NULL ,$id = NULL)
    {
        // echo "ppk";die;
        // echo "<pre>";
        // print_r($booking_id);
        // print_r($id);
        // die();
        $data['print_status'] = "1";
        $data['data_list'] = $this->low_vision->search_report_data($booking_id,$id);
        $data['booking_data'] = $this->low_vision->get_booking_by_id($booking_id);
        $data['doctor'] = $this->doctor->doctors_list();


        // Fetch the OPD billing details based on the ID
        // $booking_id = isset($data['form_data']['booking_id'])?$data['form_data']['booking_id']:'';
        // $data['billing_data'] = $this->vision_model->get_patient_name_by_booking_id($booking_id);
        // echo "<pre>";print_r($data['booking_data']);die;

        // Load the print view with the data
        $this->load->view('low_vision/print_low_vision', $data);
    }

    public function update()
    {
        $post = $this->input->post();

        if (empty($post['data_id'])) {
            $this->session->set_flashdata('error', 'No record found to update');
            redirect('Low Vision');
        }

        $this->low_vision->save();
        $this->session->set_flashdata('success', 'Record updated successfully');
        redirect('Low Vision');
    }

    
    public function low_vision_excel()
{
    // Load the PHPExcel library (Make sure the 'excel' library is correctly loaded in your application)
    $this->load->library('excel');
    
    // Initialize PHPExcel
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setTitle("Low Vision List")->setDescription("none");
    $objPHPExcel->setActiveSheetIndex(0);

    $from_date = $this->input->get('start_date');
    $to_date = $this->input->get('end_date');

    // Main header with date range if provided
    $mainHeader = "Low Vision List";
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
    $fields = array('Token No', 'OPD No', 'Patient Reg No.', 'Patient Name', 'Mobile No', 'Age', 'Status');

    $col = 0; // Initialize the column index
    foreach ($fields as $field) {
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 3, $field); // Row 3 for headers
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true); // Auto-size columns
        $col++;
    }

    // Style for header row (Row 3)
    $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    // Fetching the OPD data
    $list = $this->low_vision->get_datatables();
    // echo "<pre>";print_r($list);die;

    // Populate the data starting from row 4
    $row = 4; // Start at row 4 for data
    if (!empty($list)) {
        foreach ($list as $low_vision) {
            // Reset column index for each new row
            $col = 0;
            
            $age_y = $low_vision->age_y;
            $age_m = $low_vision->age_m;
            $age_d = $low_vision->age_d;
      
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

            // Prepare data to be populated
            $data = array(
                $low_vision->token_no,
                $low_vision->booking_code,
                $low_vision->patient_code,
                $low_vision->patient_name,
                $low_vision->mobile_no,
                $age, // Adding missing 'Age' field
                $low_vision->status == 1 ? 'Active' : 'Not Active',
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
    header('Content-Disposition: attachment;filename="low_vision_list_' . time() . '.xls"');
    header('Cache-Control: max-age=0');

    // Write the Excel file
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    ob_end_clean(); // Prevent any output before sending file
    $objWriter->save('php://output');
}



    public function low_vision_pdf()
    {
        // Increase memory limit and execution time for PDF generation
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 300);

        // Prepare data for the PDF
        // $data['print_status'] = "";
        // $from_date = $this->input->get('start_date');
        // $to_date = $this->input->get('end_date');

        // Fetch OPD data
        $data['data_list'] = $this->low_vision->get_datatables();
        // echo "<pre>";
        // print_r($data);
        // die;
        // $data['data_list']['side_effect_name'] = $this->vision_model->get_side_effect_name($data['data_list']['side_effects']);
        // Create main header
        $data['mainHeader'] = "Low Vision List";
        // if (!empty($from_date) && !empty($to_date)) {
        // $data['mainHeader'] .= " (From: " . date('d-m-Y', strtotime($from_date)) . " To: " . date('d-m-Y', strtotime($to_date)) . ")";
        // }

        // Load the view and capture the HTML output
        $this->load->view('low_vision/low_vision_html', $data);
        $html = $this->output->get_output();

        // Load PDF library and convert HTML to PDF
        $this->load->library('pdf');
        $this->pdf->load_html($html);
        $this->pdf->render();

        // Stream the generated PDF to the browser
        $this->pdf->stream("low_vision_list_" . time() . ".pdf", array("Attachment" => 1));
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
        $this->load->view('low_vision/advance_search', $data);
    }

}
