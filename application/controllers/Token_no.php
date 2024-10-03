<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Token_no extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        auth_users(); // Assuming this is for authentication check
        $this->load->model('token_no/tokenno_model', 'token_no');
        $this->load->model('general/general_model');
        // $this->load->library('form_validation');
    }

    // Method to show the token status list
    public function index()
    {
        // echo "hi";die;
        $this->session->unset_userdata('patient_search');
        // Default Search Setting
        $this->load->model('default_search_setting/default_search_setting_model');
        $default_search_data = $this->default_search_setting_model->get_default_setting();
        if (isset($default_search_data[1]) && !empty($default_search_data) && $default_search_data[1] == 1) {
            $start_date = '';
            $end_date = '';
        } else {
            $start_date = date('d-m-Y');
            $end_date = date('d-m-Y');
        }

        $data['page_title'] = 'Token List';
        $data['form_data'] = array('token_no' => '', 'patient_code' => '', 'patient_id' => '', 'status' => '', 'from_date' => '', 'to_date' => '');
        $this->load->view('token_grid/opd_token_list', $data);
    }

    // AJAX method to fetch the token list for display
    public function ajax_list()
    {
        $users_data = $this->session->userdata('auth_users');
        $opd_search = $this->session->userdata('token_search'); // Get filter criteria from session
    
        // Check if search criteria are set and adjust the query accordingly
        if (!empty($opd_search)) {
            $this->token_no->set_filter_criteria($opd_search); // Pass the filter criteria to the model
        }
    
        $list = $this->token_no->get_datatables();  // Fetch token list with filter criteria
        $data = array();
        $no = $_POST['start'];
        $i = 1;
    
        foreach ($list as $test) {
            $no++;
            $row = array();
            $row[] = $test->token_no;
            $row[] = $test->patient_name;
            $row[] = $test->patient_code;
    
            // Display status
            $status = ($test->status == 1) ? 'Pending' : 'Complete';
            $row[] = $status;
    
            // Generate action button (hide if status is 'Complete')
            if ($test->status == 1) {  // Show button only if status is 'Pending'
                $action_url = base_url("opd/booking/" . $test->patient_id);
                $row[] = '<a href="' . $action_url . '" class="btn-custom" title="Edit">Book Now</a>';
            } else {
                $row[] = '';  // Leave action column empty for 'Complete' status
            }
    
            $data[] = $row;
            $i++;
        }
    
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->token_no->count_all(),  // Correct reference to model
            "recordsFiltered" => $this->token_no->count_filtered(),  // Correct reference to model
            "data" => $data,
        );
    
        echo json_encode($output);
    }
    
    // Method to handle search filters
    public function advance_search()
    {
        $post = $this->input->post();
        if (!empty($post)) {
            // Set the filter criteria (status, from_date, to_date) in the session
            $search_criteria = array(
                'search_type' => $post['search_type'],   // Status filter
                'from_date' => !empty($post['from_date']) ? $post['from_date'] : null,   // From date filter
                'to_date' => !empty($post['to_date']) ? $post['to_date'] : null          // To date filter
            );

            $this->session->set_userdata('token_search', $search_criteria);
        }

        $opd_search = $this->session->userdata('token_search');
        if (!empty($opd_search)) {
            // Optionally prepare the response data for form pre-filling or debugging
            $data['form_data'] = $opd_search;
        }

        return 'ok';
    }


    // Method to update the status of a token
    public function update_token_status()
    {
        $post = $this->input->post();
        $result = $this->token_no->update_token_status($post['token_id'], $post['token_no']);
        if ($result) {
            echo "Status successfully updated.";
        }
    }

    // Method to display the OPD token list
    public function opd_token()
    {
        $users_data = $this->session->userdata('auth_users');
        $data['branch_type'] = $this->token_no->get_branch_token_type($users_data['parent_id']);
        $data['page_title'] = 'Token Display List';
        $data['specialization_list'] = $this->general_model->specialization_list();

        $this->load->view('token_no/opd_token_display', $data);
    }

    // AJAX method to display the token status for patients
    public function ajax_list_display()
    {
        $users_data = $this->session->userdata('auth_users');
        $branch_type = $this->token_no->get_branch_token_type($users_data['parent_id']);
        $list = $this->token_no->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $token) {
            $no++;
            $row = array();

            // Handle status display based on status
            $status_labels = array(
                0 => '<font color="red">Waiting</font>',
                1 => '<font color="green">In Progress</font>',
                2 => '<font color="blue">Done</font>',
                3 => '<font color="orange">Emergency</font>',
                4 => '<font color="gray">Cancel</font>'
            );
            $row[] = $token->token_no;
            $row[] = $token->patient_name;
            $row[] = ($branch_type == 2) ? ucfirst(get_specilization_name($token->specialization_id)) : ucfirst(get_doctor_name($token->doctor_id));
            $row[] = $status_labels[$token->status];

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->token_no->count_all(),
            "recordsFiltered" => $this->token_no->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // Method to display patient token list
    public function token_patient_display()
    {
        $users_data = $this->session->userdata('auth_users');
        $data['branch_type'] = $this->token_no->get_branch_token_type($users_data['parent_id']);
        $data['page_title'] = 'Token Patient Display List';
        $data['specialization_list'] = $this->general_model->specialization_list();

        $this->load->view('token_no/opd_token_patient_display', $data);
    }
}
?>