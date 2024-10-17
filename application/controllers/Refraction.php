<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Refraction extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->model('vision/vision_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['page_title'] = 'Refraction Records';
        $this->load->view('refraction/list', $data);
    }

    public function add($booking_id = null)
    {
        // Load required models and libraries
        $this->load->library('form_validation');
        $this->load->model('vision/vision_model'); // Ensure this model is loaded
        $data['side_effects'] = $this->vision_model->get_all_side_effects(); // Fetch side effects
        $data['page_title'] = 'Add Vision Record';
        $data['booking_id'] = isset($booking_id) ? $booking_id : '';

        $patient_details = $this->vision_model->get_patient_name_by_booking_id($booking_id);
        // echo "<pre>";
        // print_r($booking_id);
        // die;
        if ($booking_id && $patient_details) {
            $data['patient_name'] = $patient_details['patient_name'];
        } else {
            $data['patient_name'] = ''; // Default value if no booking_id is provided
        }

        // Initialize form data
        $data['form_data'] = array(
            "booking_id" => $booking_id,
            "patient_name" => $patient_details['patient_name'] ?? '',
            "patient_code" => $patient_details['patient_code'] ?? '',
            "procedure_purpose" => '',
            "side_effects" => '',
            'informed_consent' => '',
            'previous_ffa' => '',
            'history_allergy' => '',
            'history_asthma' => '',
            'history_epilepsy' => '',
            'accompanied_attendant' => '',
            's_creatinine' => '',
            'blood_sugar' => '',
            'blood_pressure' => '',
            'reason_ffa_not_done' => '',
            'optometrist_signature' => '',
            'optometrist_date' => '',
            'anaesthetist_signature' => '',
            'anaesthetist_date' => '',
            'doctor_signature' => '',
            'doctor_date' => '',
        );


        $post = $this->input->post();
        // echo "<pre>";
        // print_r('abhay');
        // print_r($post);
        // die;
        // Check if the form is submitted
        if (isset($post) && !empty($post)) {
            // Validate the form
            $valid_response = $this->_validate();

            // Check if validation passed
            if ($valid_response === true) {
                // If validation passes, save the record
                $this->vision_model->save($this->input->post()); // Save the validated data
                $this->session->set_flashdata('success', 'Vision store successfully.');
                echo json_encode(['success' => true, 'message' => 'Vision store successfully.']);
                return; // Exit to prevent further output
            } else {
                // Handle validation errors
                $data['form_data'] = $valid_response['form_data']; // Retain form data for re-display
                $data['form_error'] = validation_errors(); // Get validation errors
            }
        }




        // If the form is not submitted or validation fails, load the view with the existing data


        // Load the view with the data
        $this->load->view('refraction/add', $data);
    }

    

}
