<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Side_effect extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        auth_users();
        $this->load->model('side_effect/side_effect_model', 'side_effect'); // Load your side effect model
        $this->load->library('form_validation');
    }

    public function index()
    {
        unauthorise_permission('411', '2485');
        $data['page_title'] = 'Side Effect List';
        $this->load->view('side_effect/list', $data);
    }

    public function ajax_list()
    {
        unauthorise_permission('411', '2485');
        $list = $this->side_effect->get_datatables(); // Fetch the side effects

        $data = array();
        $no = isset($_POST['start']) ? $_POST['start'] : 0;

        foreach ($list as $side_effect) {
            $no++;
            $row = array();

            // Create a checkbox for each side effect with its ID
            $row[] = '<input type="checkbox" name="side_effect_ids[]" class="checklist" value="' . (isset($side_effect->id) ? $side_effect->id : '') . '">';

            // Display side effect name or default value if it's missing
            $row[] = property_exists($side_effect, 'side_effect_name') ? $side_effect->side_effect_name : 'N/A';

            // Format the created date
            $row[] = property_exists($side_effect, 'created_date') && !empty($side_effect->created_date) 
                ? date('d-M-Y H:i A', strtotime($side_effect->created_date)) 
                : 'N/A';

            // Generate Edit and Delete buttons based on permissions
            $btnedit = '';
            $btndelete = '';
            if (isset($side_effect->id)) {
                if (in_array('2487', $this->session->userdata('auth_users')['permission']['action'])) {
                    $btnedit = ' <a onClick="return edit_side_effect(' . $side_effect->id . ');" class="btn-custom" href="javascript:void(0)" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                }
                if (in_array('2488', $this->session->userdata('auth_users')['permission']['action'])) {
                    $btndelete = ' <a class="btn-custom" onClick="return delete_side_effect(' . $side_effect->id . ')" href="javascript:void(0)" title="Delete"><i class="fa fa-trash"></i> Delete</a>';
                }
            }

            // Append action buttons (edit and delete)
            $row[] = $btnedit . $btndelete;

            // Add row to the data array
            $data[] = $row;
        }

        // Output the data in JSON format for DataTables
        $output = array(
            "draw" => isset($_POST['draw']) ? $_POST['draw'] : '',
            "recordsTotal" => $this->side_effect->count_all(),
            "recordsFiltered" => $this->side_effect->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);
    }


    public function add()
    {
        unauthorise_permission('411', '2486');
        $data['page_title'] = "Add Side Effect";
        $post = $this->input->post();
        $data['form_error'] = [];
        $data['form_data'] = array(
            'data_id' => "",
            'side_effect_name' => "",
            // 'side_effect_status' => "1",
        );

        if (isset($post) && !empty($post)) {
            $data['form_data'] = $this->_validate();
            if ($this->form_validation->run() == TRUE) {
                $this->side_effect->save(); // Save side effect
                echo 1;
                return false;
            } else {
                $data['form_error'] = validation_errors();
            }
        }
        $this->load->view('side_effect/add', $data);
    }

    public function edit($id = "")
    {
        unauthorise_permission('411', '2486');
        
        if (isset($id) && !empty($id) && is_numeric($id)) {
            $result = $this->side_effect->get_by_id($id);
            if (!$result) {
                show_error('Side effect not found', 404);
                return;
            }

            $data['page_title'] = "Update Side Effect";
            $data['form_error'] = '';
            $data['form_data'] = array(
                'data_id' => $result['id'],
                'side_effect_name' => $result['side_effect_name'],
                // 'side_effect_status' => $result['side_effect_status'],
            );

            if ($this->input->post()) {
                $data['form_data'] = $this->_validate();
                if ($this->form_validation->run() == TRUE) {
                    $this->side_effect->save(); // Save updated side effect
                    echo 1; // Return a success response
                    return;
                } else {
                    $data['form_error'] = validation_errors();
                }
            }
            $this->load->view('side_effect/add', $data); // Load the edit view
        } else {
            show_error('Invalid Side Effect ID', 400);
        }
    }

    private function _validate()
    {
        $post = $this->input->post();
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('side_effect_name', 'Side effect name', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            return array(
                'side_effect_name' => $post['side_effect_name'],
                // 'side_effect_status' => $post['side_effect_status'],
            );
        }
        return [];
    }

    public function delete($id = "")
    {
        unauthorise_permission('411', '2488');
        if (!empty($id) && $id > 0) {
            $this->side_effect->delete($id);
            echo "Side effect successfully deleted.";
        }
    }

    public function deleteall()
    {
        unauthorise_permission('411', '2488');
        $post = $this->input->post();
        if (!empty($post)) {
            $this->side_effect->deleteall($post['row_id']);
            echo "Side effects successfully deleted.";
        }
    }

    public function view($id = "")
    {
        if (isset($id) && !empty($id) && is_numeric($id)) {
            $data['form_data'] = $this->side_effect->get_by_id($id);
            $data['page_title'] = $data['form_data']['side_effect_name'] . " detail";
            $this->load->view('side_effect/view', $data);
        }
    }

    public function archive()
    {
        unauthorise_permission('411', '2489');
        $data['page_title'] = 'Side Effect Archive List';
        $this->load->view('side_effect/archive', $data);
    }

    // Uncomment and implement the following methods if needed
    // public function archive_ajax_list() { /* ... */ }
}
