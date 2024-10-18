<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Refraction extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('refraction/Refraction_model', 'refraction');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['page_title'] = 'Refraction Records';
        $this->load->view('refraction/list', $data);
    }

    public function ajax_list()
    {
        $list = $this->refraction->get_datatables();
        $data = array();
        // $plist = $this->refraction->get_patient_name_by_booking_id($list->booking_id);

        // echo "<pre>";print_r($list);die;
        $no = $_POST['start'];

        foreach ($list as $refraction) {
            $no++;

            $row = array();

            // Add a checkbox for selecting the record
            $row[] = '<input type="checkbox" name="refraction_ids[]" value="' . $refraction->id . '">';

            $row[] = $refraction->booking_id;
            $row[] = $refraction->lens;
            $row[] = $refraction->comment;

            // Check status and set active or not active
            $row[] = ($refraction->status == 1) ? 'Active' : 'Not Active';

            // Add action buttons
            $row[] = '<a onClick="return edit_refraction(' . $refraction->id . ');" class="btn-custom" href="javascript:void(0)" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                    <a href="javascript:void(0)" class="btn-custom" onClick="return print_window_page(\'' . base_url("refraction/print_refraction/" . $refraction->booking_id."/".$refraction->id) . '\');">
                        <i class="fa fa-print"></i> Print
                    </a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->refraction->count_all(),
            "recordsFiltered" => $this->refraction->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);
    }



    public function add($booking_id = null, $id = null)
    {
        // Load required models and libraries
        $this->load->library('form_validation');
        $this->load->model('refraction/refraction_model'); // Ensure this model is loaded
        // $data['side_effects'] = $this->refraction->get_all_side_effects(); // Fetch side effects
        $data['page_title'] = 'Add refraction Record';
        // $pres_id = 28;
        
        $plist = $this->refraction->get_patient_name_by_booking_id($booking_id);
        // echo "<pre>";print_r($plist);die('ok');
        $data['booking_id'] = isset($booking_id) ? $booking_id : '';
        $result_refraction = $this->refraction->get_prescription_refraction_new_by_id($booking_id, $id);
        // echo "<pre>";print_r($result_refraction);die;

        $refraction_auto_refraction = isset($result_refraction['auto_refraction'])?json_decode($result_refraction['auto_refraction']):'';
        $data['refrtsn_auto_ref'] = (array) $refraction_auto_refraction;

        // $patient_details = $this->refraction->get_patient_name_by_booking_id($booking_id);
        // echo "<pre>";
        // print_r($plist);
        
        // if ($booking_id && $patient_details) {
        //     $data['patient_name'] = $patient_details['patient_name'];
        // } else {
        //     $data['patient_name'] = ''; // Default value if no booking_id is provided
        // }

        // // Initialize form data
        $data['form_data'] = array(
            'booking_id' => isset($plist['booking_id'])?$plist['booking_id']:'', // Booking ID
            'refraction_ar_l_dv_sph' => '', // Left eye dry sph
            'refraction_ar_l_dv_cyl' => '', // Left eye dry cyl
            'refraction_ar_l_dv_axis' => '', // Left eye dry axis
            'refraction_ar_l_nv_sph' => '', // Left eye dd sph
            'refraction_ar_l_nv_cyl' => '', // Left eye dd cyl
            'refraction_ar_l_nv_axis' => '', // Left eye dd axis
            'refraction_ar_l_b1_sph' => '', // Left eye B1 sph
            'refraction_ar_l_b1_cyl' => '', // Left eye B1 cyl
            'refraction_ar_l_b1_axis' => '', // Left eye B1 axis
            'refraction_ar_l_b2_sph' => '', // Left eye B2 sph
            'refraction_ar_l_b2_cyl' => '', // Left eye B2 cyl
            'refraction_ar_l_b2_axis' => '', // Left eye B2 axis
            'refraction_ar_r_dv_sph' => '', // Right eye dry sph
            'refraction_ar_r_dv_cyl' => '', // Right eye dry cyl
            'refraction_ar_r_dv_axis' => '', // Right eye dry axis
            'refraction_ar_r_nv_sph' => '', // Right eye dd sph
            'refraction_ar_r_nv_cyl' => '', // Right eye dd cyl
            'refraction_ar_r_nv_axis' => '', // Right eye dd axis
            'refraction_ar_r_b1_sph' => '', // Right eye B1 sph
            'refraction_ar_r_b1_cyl' => '', // Right eye B1 cyl
            'refraction_ar_r_b1_axis' => '', // Right eye B1 axis
            'refraction_ar_r_b2_sph' => '', // Right eye B2 sph
            'refraction_ar_r_b2_cyl' => '', // Right eye B2 cyl
            'refraction_ar_r_b2_axis' => '', // Right eye B2 axis
            'branch_id' => isset($plist['branch_id'])?$plist['branch_id']:'', // To be filled from form
            'booking_code' => isset($plist['booking_code'])?$plist['booking_code']:'', // To be filled from form
            'pres_id' => isset($id)?$id:'', // To be filled from form
            'patient_id' => isset($plist['patient_id'])?$plist['patient_id']:'', // To be filled from form
            'lens' => '', // To be filled from form
            'comment' => '', // To be filled from form
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
        // echo "<pre>";print_r($plist);die('ss');
        if (isset($post) && !empty($post)) {
            // echo "<pre>";
            // // print_r('abhay');
            // print_r($post);
            // die;
            // Prepare the refraction data for JSON
            $refraction_data = [
                'refraction_ar_l_dv_sph' => $this->input->post('refraction_ar_l_dv_sph'),
                'refraction_ar_l_dv_cyl' => $this->input->post('refraction_ar_l_dv_cyl'),
                'refraction_ar_l_dv_axis' => $this->input->post('refraction_ar_l_dv_axis'),
                'refraction_ar_l_nv_sph' => $this->input->post('refraction_ar_l_nv_sph'),
                'refraction_ar_l_nv_cyl' => $this->input->post('refraction_ar_l_nv_cyl'),
                'refraction_ar_l_nv_axis' => $this->input->post('refraction_ar_l_nv_axis'),
                'refraction_ar_l_b1_sph' => $this->input->post('refraction_ar_l_b1_sph'),
                'refraction_ar_l_b1_cyl' => $this->input->post('refraction_ar_l_b1_cyl'),
                'refraction_ar_l_b1_axis' => $this->input->post('refraction_ar_l_b1_axis'),
                'refraction_ar_l_b2_sph' => $this->input->post('refraction_ar_l_b2_sph'),
                'refraction_ar_l_b2_cyl' => $this->input->post('refraction_ar_l_b2_cyl'),
                'refraction_ar_l_b2_axis' => $this->input->post('refraction_ar_l_b2_axis'),
                'refraction_ar_r_dv_sph' => $this->input->post('refraction_ar_r_dv_sph'),
                'refraction_ar_r_dv_cyl' => $this->input->post('refraction_ar_r_dv_cyl'),
                'refraction_ar_r_dv_axis' => $this->input->post('refraction_ar_r_dv_axis'),
                'refraction_ar_r_nv_sph' => $this->input->post('refraction_ar_r_nv_sph'),
                'refraction_ar_r_nv_cyl' => $this->input->post('refraction_ar_r_nv_cyl'),
                'refraction_ar_r_nv_axis' => $this->input->post('refraction_ar_r_nv_axis'),
                'refraction_ar_r_b1_sph' => $this->input->post('refraction_ar_r_b1_sph'),
                'refraction_ar_r_b1_cyl' => $this->input->post('refraction_ar_r_b1_cyl'),
                'refraction_ar_r_b1_axis' => $this->input->post('refraction_ar_r_b1_axis'),
                'refraction_ar_r_b2_sph' => $this->input->post('refraction_ar_r_b2_sph'),
                'refraction_ar_r_b2_cyl' => $this->input->post('refraction_ar_r_b2_cyl'),
                'refraction_ar_r_b2_axis' => $this->input->post('refraction_ar_r_b2_axis'),
            ];


        
            // Convert the refraction data to JSON
            $auto_refraction_json = json_encode($refraction_data);
        
            // Prepare the data for saving
            $id = $this->input->post('id');
            $branch_id = $this->input->post('booking_id');
            $booking_code = $this->input->post('booking_code');
            $pres_id = $this->input->post('pres_id');
            $patient_id = $this->input->post('patient_id');
            $booking_id = $this->input->post('booking_id');
            $lens = $this->input->post('lens');
            $comment = $this->input->post('comment');
            $optometrist_signature = $this->input->post('optometrist_signature');
            $doctor_signature = $this->input->post('doctor_signature');
            $created_by = $this->session->userdata('user_id');

            $data_to_save = [
                'id' => isset($id)?$id:'',
                'branch_id' => isset($branch_id)?$branch_id:'22',
                'booking_code' => isset($booking_code) ? $booking_code : '',
                'pres_id' => isset($pres_id) ? $pres_id : '',
                'patient_id' => isset($patient_id) ? $patient_id : '',
                'booking_id' => isset($booking_id) ? $booking_id : '',
                'auto_refraction' => $auto_refraction_json, // JSON string of refraction data
                'lens' => isset($lens) ? $lens : '',
                'comment' => isset($comment) ? $comment : '',
                'optometrist_signature' => isset($optometrist_signature) ? $optometrist_signature : '',
                'doctor_signature' => isset($doctor_signature) ? $doctor_signature : '',
                'status' => 1, // Or whatever default value you need
                'is_deleted' => 0, // Assuming this is default
                'created_by' => isset($created_by) ? $created_by : '', // Check if user_id exists
                'created_date' => date('Y-m-d H:i:s'), // Current timestamp
                'ip_address' => $this->input->ip_address(), // Capture IP address
            ];
            // echo "<pre>";print_r($data_to_save);die; 

        
            // Save the data
            $this->refraction->save($data_to_save);
            $this->session->set_flashdata('success', 'Refraction store successfully.');
            echo json_encode(['success' => true, 'message' => 'Refraction store successfully.']);
            return; // Exit to prevent further output
        }
        

        // If the form is not submitted or validation fails, load the view with the existing data


        // Load the view with the data
        $this->load->view('refraction/add', $data);
    }

    public function fill_eye_data_auto_refraction($modal)
    {
        // echo "ijij";die;
        $data['page_title'] = $modal;
        $this->load->view('refraction/refraction_mod', $data);
    }

    public function edit($id = "")
    {
        // echo "<pre>";print_r($this->input->post());die('EDIT DONE');
        // Check user permissions
        unauthorise_permission('411', '2486');

        // Validate the ID
        if (isset($id) && !empty($id) && is_numeric($id)) {
            $data['page_title'] = 'Edit Refraction Record';

            // Retrieve the refraction record by ID
            $result = $this->refraction->get_by_id($id); // Adjust this method according to your model
            // echo "<pre>";print_r($result);die;
            if (!$result) {
                // Handle case where no record is found
                show_error('Refraction record not found', 404);
                return;
            }

            // Prepare data for the view
           // Assuming $result['auto_refraction'] could be a JSON string
           $auto_refraction_data = json_decode($result['auto_refraction'], true); // Decode into an associative array

            // Check if decoding was successful
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Handle JSON decode error (for example, log it and set $auto_refraction_data to an empty array)
                log_message('error', 'JSON decode error: ' . json_last_error_msg());
                $auto_refraction_data = []; // Default to an empty array if there's an error
            }
            // echo "<pre>";print_r($auto_refraction_data);die;
            // Populate form data
            $data['form_data'] = array(
                'id' => $result['id'],
                'booking_id' => $result['booking_id'],
                'branch_id' => $result['branch_id'],
                'booking_code' => $result['booking_code'],
                'pres_id' => $result['pres_id'],
                'patient_id' => $result['patient_id'],
                'lens' => $result['lens'],
                'comment' => $result['comment'],
                'optometrist_signature' => $result['optometrist_signature'],
                'doctor_signature' => $result['doctor_signature'],
                'status' => $result['status'],
                'is_deleted' => $result['is_deleted'],
                // Populate refraction data safely
                'refraction_ar_l_dv_sph' => $auto_refraction_data['refraction_ar_l_dv_sph'] ?? '',
                'refraction_ar_l_dv_cyl' => $auto_refraction_data['refraction_ar_l_dv_cyl'] ?? '',
                'refraction_ar_l_dv_axis' => $auto_refraction_data['refraction_ar_l_dv_axis'] ?? '',
                'refraction_ar_l_nv_sph' => $auto_refraction_data['refraction_ar_l_nv_sph'] ?? '',
                'refraction_ar_l_nv_cyl' => $auto_refraction_data['refraction_ar_l_nv_cyl'] ?? '',
                'refraction_ar_l_nv_axis' => $auto_refraction_data['refraction_ar_l_nv_axis'] ?? '',
                'refraction_ar_l_b1_sph' => $auto_refraction_data['refraction_ar_l_b1_sph'] ?? '',
                'refraction_ar_l_b1_cyl' => $auto_refraction_data['refraction_ar_l_b1_cyl'] ?? '',
                'refraction_ar_l_b1_axis' => $auto_refraction_data['refraction_ar_l_b1_axis'] ?? '',
                'refraction_ar_l_b2_sph' => $auto_refraction_data['refraction_ar_l_b2_sph'] ?? '',
                'refraction_ar_l_b2_cyl' => $auto_refraction_data['refraction_ar_l_b2_cyl'] ?? '',
                'refraction_ar_l_b2_axis' => $auto_refraction_data['refraction_ar_l_b2_axis'] ?? '',
                'refraction_ar_r_dv_sph' => $auto_refraction_data['refraction_ar_r_dv_sph'] ?? '',
                'refraction_ar_r_dv_cyl' => $auto_refraction_data['refraction_ar_r_dv_cyl'] ?? '',
                'refraction_ar_r_dv_axis' => $auto_refraction_data['refraction_ar_r_dv_axis'] ?? '',
                'refraction_ar_r_nv_sph' => $auto_refraction_data['refraction_ar_r_nv_sph'] ?? '',
                'refraction_ar_r_nv_cyl' => $auto_refraction_data['refraction_ar_r_nv_cyl'] ?? '',
                'refraction_ar_r_nv_axis' => $auto_refraction_data['refraction_ar_r_nv_axis'] ?? '',
                'refraction_ar_r_b1_sph' => $auto_refraction_data['refraction_ar_r_b1_sph'] ?? '',
                'refraction_ar_r_b1_cyl' => $auto_refraction_data['refraction_ar_r_b1_cyl'] ?? '',
                'refraction_ar_r_b1_axis' => $auto_refraction_data['refraction_ar_r_b1_axis'] ?? '',
                'refraction_ar_r_b2_sph' => $auto_refraction_data['refraction_ar_r_b2_sph'] ?? '',
                'refraction_ar_r_b2_cyl' => $auto_refraction_data['refraction_ar_r_b2_cyl'] ?? '',
                'refraction_ar_r_b2_axis' => $auto_refraction_data['refraction_ar_r_b2_axis'] ?? '',
            );
            
            // Check if there is form submission
            if ($this->input->post()) {
                
                // Validate the form
                $data['form_data'] = $this->_validate(); // Adjust validation method as needed
                if ($this->form_validation->run() == TRUE) {
                    // Prepare the refraction data for JSON
                    $refraction_data = [
                        'refraction_ar_l_dv_sph' => $this->input->post('refraction_ar_l_dv_sph'),
                        'refraction_ar_l_dv_cyl' => $this->input->post('refraction_ar_l_dv_cyl'),
                        'refraction_ar_l_dv_axis' => $this->input->post('refraction_ar_l_dv_axis'),
                        'refraction_ar_l_nv_sph' => $this->input->post('refraction_ar_l_nv_sph'),
                        'refraction_ar_l_nv_cyl' => $this->input->post('refraction_ar_l_nv_cyl'),
                        'refraction_ar_l_nv_axis' => $this->input->post('refraction_ar_l_nv_axis'),
                        'refraction_ar_l_b1_sph' => $this->input->post('refraction_ar_l_b1_sph'),
                        'refraction_ar_l_b1_cyl' => $this->input->post('refraction_ar_l_b1_cyl'),
                        'refraction_ar_l_b1_axis' => $this->input->post('refraction_ar_l_b1_axis'),
                        'refraction_ar_l_b2_sph' => $this->input->post('refraction_ar_l_b2_sph'),
                        'refraction_ar_l_b2_cyl' => $this->input->post('refraction_ar_l_b2_cyl'),
                        'refraction_ar_l_b2_axis' => $this->input->post('refraction_ar_l_b2_axis'),
                        'refraction_ar_r_dv_sph' => $this->input->post('refraction_ar_r_dv_sph'),
                        'refraction_ar_r_dv_cyl' => $this->input->post('refraction_ar_r_dv_cyl'),
                        'refraction_ar_r_dv_axis' => $this->input->post('refraction_ar_r_dv_axis'),
                        'refraction_ar_r_nv_sph' => $this->input->post('refraction_ar_r_nv_sph'),
                        'refraction_ar_r_nv_cyl' => $this->input->post('refraction_ar_r_nv_cyl'),
                        'refraction_ar_r_nv_axis' => $this->input->post('refraction_ar_r_nv_axis'),
                        'refraction_ar_r_b1_sph' => $this->input->post('refraction_ar_r_b1_sph'),
                        'refraction_ar_r_b1_cyl' => $this->input->post('refraction_ar_r_b1_cyl'),
                        'refraction_ar_r_b1_axis' => $this->input->post('refraction_ar_r_b1_axis'),
                        'refraction_ar_r_b2_sph' => $this->input->post('refraction_ar_r_b2_sph'),
                        'refraction_ar_r_b2_cyl' => $this->input->post('refraction_ar_r_b2_cyl'),
                        'refraction_ar_r_b2_axis' => $this->input->post('refraction_ar_r_b2_axis'),
                    ];

                    // Convert the refraction data to JSON
                    $auto_refraction_json = json_encode($refraction_data);

                    // Prepare the data for updating
                    $data_to_update = [
                        'id' => $this->input->post('id'),
                        'branch_id' => $this->input->post('branch_id'),
                        'booking_code' => $this->input->post('booking_code'),
                        'pres_id' => $this->input->post('pres_id'),
                        'patient_id' => $this->input->post('patient_id'),
                        'booking_id' => $this->input->post('booking_id'),
                        'auto_refraction' => $auto_refraction_json,
                        'lens' => $this->input->post('lens'),
                        'comment' => $this->input->post('comment'),
                        'optometrist_signature' => $this->input->post('optometrist_signature'),
                        'doctor_signature' => $this->input->post('doctor_signature'),
                        'status' => 1, // Or whatever default value you need
                        'is_deleted' => 0, // Assuming this is default
                        'updated_at' => date('Y-m-d H:i:s'), // Current timestamp for update
                        'ip_address' => $this->input->ip_address(),
                    ];

                    // Update the data
                    $this->refraction->update($id, $data_to_update); // Adjust this method according to your model
                    $this->session->set_flashdata('success', 'Refraction record updated successfully.');
                    echo json_encode(['success' => true, 'message' => 'Refraction record updated successfully.']);
                    return; // Exit to prevent further output
                } else {
                    // Capture validation errors
                    $data['form_error'] = validation_errors();
                }
            }
            // echo "<pre>";print_r($data);die;
            // Load the view with the prepared data
            $this->load->view('refraction/add', $data); // Adjust the view name as necessary
        } else {
            // Handle the case when the ID is not valid
            show_error('Invalid ID provided', 400);
        }
    }

    public function print_refraction($booking_id = NULL ,$id = NULL)
    {
        // echo "ppk";die;
        $data['print_status'] = "1";

        // Fetch the form data based on the ID
        $result = $this->refraction->get_by_id($id);
        $plist = $this->refraction->get_patient_name_by_booking_id($booking_id);
        // echo "<pre>";print_r($result);die('ok');
        $data['booking_id'] = isset($booking_id) ? $booking_id : '';
        $result_refraction = $this->refraction->get_prescription_refraction_new_by_id($booking_id, $id);
        // echo "<pre>";print_r($result_refraction);die;

        $refraction_auto_refraction = isset($result_refraction['auto_refraction'])?json_decode($result_refraction['auto_refraction']):'';
        $data['refrtsn_auto_ref'] = (array) $refraction_auto_refraction;

        $auto_refraction_data = json_decode($result['auto_refraction'], true); // Decode into an associative array

            // Check if decoding was successful
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Handle JSON decode error (for example, log it and set $auto_refraction_data to an empty array)
                log_message('error', 'JSON decode error: ' . json_last_error_msg());
                $auto_refraction_data = []; // Default to an empty array if there's an error
            }

        $data['form_data'] = array(
            'data_id' => $result['id'],
            'booking_id' => $result['booking_id'],
            'branch_id' => $result['branch_id'],
            'booking_code' => $result['booking_code'],
            'pres_id' => $result['pres_id'],
            'patient_id' => $result['patient_id'],
            'lens' => $result['lens'],
            'comment' => $result['comment'],
            'optometrist_signature' => $result['optometrist_signature'],
            'doctor_signature' => $result['doctor_signature'],
            'status' => $result['status'],
            'is_deleted' => $result['is_deleted'],
            // Populate refraction data safely
            'refraction_ar_l_dv_sph' => $auto_refraction_data['refraction_ar_l_dv_sph'] ?? '',
            'refraction_ar_l_dv_cyl' => $auto_refraction_data['refraction_ar_l_dv_cyl'] ?? '',
            'refraction_ar_l_dv_axis' => $auto_refraction_data['refraction_ar_l_dv_axis'] ?? '',
            'refraction_ar_l_nv_sph' => $auto_refraction_data['refraction_ar_l_nv_sph'] ?? '',
            'refraction_ar_l_nv_cyl' => $auto_refraction_data['refraction_ar_l_nv_cyl'] ?? '',
            'refraction_ar_l_nv_axis' => $auto_refraction_data['refraction_ar_l_nv_axis'] ?? '',
            'refraction_ar_l_b1_sph' => $auto_refraction_data['refraction_ar_l_b1_sph'] ?? '',
            'refraction_ar_l_b1_cyl' => $auto_refraction_data['refraction_ar_l_b1_cyl'] ?? '',
            'refraction_ar_l_b1_axis' => $auto_refraction_data['refraction_ar_l_b1_axis'] ?? '',
            'refraction_ar_l_b2_sph' => $auto_refraction_data['refraction_ar_l_b2_sph'] ?? '',
            'refraction_ar_l_b2_cyl' => $auto_refraction_data['refraction_ar_l_b2_cyl'] ?? '',
            'refraction_ar_l_b2_axis' => $auto_refraction_data['refraction_ar_l_b2_axis'] ?? '',
            'refraction_ar_r_dv_sph' => $auto_refraction_data['refraction_ar_r_dv_sph'] ?? '',
            'refraction_ar_r_dv_cyl' => $auto_refraction_data['refraction_ar_r_dv_cyl'] ?? '',
            'refraction_ar_r_dv_axis' => $auto_refraction_data['refraction_ar_r_dv_axis'] ?? '',
            'refraction_ar_r_nv_sph' => $auto_refraction_data['refraction_ar_r_nv_sph'] ?? '',
            'refraction_ar_r_nv_cyl' => $auto_refraction_data['refraction_ar_r_nv_cyl'] ?? '',
            'refraction_ar_r_nv_axis' => $auto_refraction_data['refraction_ar_r_nv_axis'] ?? '',
            'refraction_ar_r_b1_sph' => $auto_refraction_data['refraction_ar_r_b1_sph'] ?? '',
            'refraction_ar_r_b1_cyl' => $auto_refraction_data['refraction_ar_r_b1_cyl'] ?? '',
            'refraction_ar_r_b1_axis' => $auto_refraction_data['refraction_ar_r_b1_axis'] ?? '',
            'refraction_ar_r_b2_sph' => $auto_refraction_data['refraction_ar_r_b2_sph'] ?? '',
            'refraction_ar_r_b2_cyl' => $auto_refraction_data['refraction_ar_r_b2_cyl'] ?? '',
            'refraction_ar_r_b2_axis' => $auto_refraction_data['refraction_ar_r_b2_axis'] ?? '',
        );

        // Fetch the side effect name based on the side_effect ID from form data
        // if (!empty($data['form_data']['side_effects'])) {
        //     $side_effect_id = $data['form_data']['side_effects'];
        //     $data['form_data']['side_effect_name'] = $this->vision_model->get_side_effect_name($side_effect_id);
        // }

        // Fetch the OPD billing details based on the ID
        $booking_id = isset($data['form_data']['booking_id'])?$data['form_data']['booking_id']:'';
        // $data['billing_data'] = $this->vision_model->get_patient_name_by_booking_id($booking_id);
        // echo "<pre>";print_r($data);die;

        // Load the print view with the data
        $this->load->view('refraction/print_refraction', $data);
    }

    public function update()
    {
        $post = $this->input->post();

        if (empty($post['data_id'])) {
            $this->session->set_flashdata('error', 'No record found to update');
            redirect('Refraction');
        }

        $this->refraction->save();
        $this->session->set_flashdata('success', 'Record updated successfully');
        redirect('Refraction');
    }

    

}
