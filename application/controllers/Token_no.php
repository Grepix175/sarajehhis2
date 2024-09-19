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
        $data['form_data'] = array('token_no' => '', 'patient_id' => '', 'status' => '');
        $this->load->view('token_grid/opd_token_list', $data);
    }

    // AJAX method to fetch the token list for display
    public function ajax_list()
{
    $users_data = $this->session->userdata('auth_users');
    $list = $this->token_no->get_datatables();  // Fetch token list with search applied
    $data = array();
    $no = $_POST['start'];
    $i = 1;

    foreach ($list as $test) {
        $no++;
        $row = array();

        // Add the "Token No." and "Patient Name"
        $row[] = $test->token_no;
        $row[] = $test->patient_name;

        // Add the "Status" as text instead of a dropdown
        $row[] = ($test->status == 1) ? 'Active' : 'Inactive';

        // Add Action button that redirects to another page and passes the patient ID
        $action_url = base_url("opd/booking/" . $test->patient_id);  // Assuming 'opd/booking' is the route to the booking page
        $row[] = '<a href="' . $action_url . '" class="btn-custom" style="23" title="Edit">Book Now</a>';

        $data[] = $row;
        $i++;
    }

    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->token_no->count_all(),  // Total record count
        "recordsFiltered" => $this->token_no->count_filtered(),  // Filtered record count after search
        "data" => $data,
    );

    echo json_encode($output);  // Return data in JSON format for DataTables
}




    // Method to handle search filters
    public function advance_search()
    {
        $post = $this->input->post();
        if (!empty($post)) {
            $this->session->set_userdata('token_search', $post);
        }
        $opd_search = $this->session->userdata('token_search');
        if (!empty($opd_search)) {
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