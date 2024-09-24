<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subsidy extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        auth_users();
        $this->load->model('subsidy/Subsidy_model', 'subsidy');
        $this->load->library('form_validation');
    }

    public function index()
    {

        unauthorise_permission('411', '2485');
        $data['page_title'] = 'Subsidy List';
        $this->load->view('subsidy/list', $data);
    }

    public function ajax_list()
    {
        unauthorise_permission('411', '2485');
        $users_data = $this->session->userdata('auth_users');
        $sub_branch_details = $this->session->userdata('sub_branches_data');
        $parent_branch_details = $this->session->userdata('parent_branches_data');
        $list = $this->subsidy->get_datatables();
        // echo "<pre>";
        // print_r($list);
        // die;
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        $total_num = count($list);
        foreach ($list as $subsidy) {
            // print_r($expense_category);die;
            $no++;
            $row = array();
            if ($subsidy->subsidy_status == 1) {
                $status = '<font color="green">Active</font>';
            } else {
                $status = '<font color="red">Inactive</font>';
            }

            ////////// Check  List /////////////////
            $check_script = "";
            if ($i == $total_num) {
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
            $checkboxs = "";
            // if($users_data['parent_id']==$subsidy->branch_id)
            if ($subsidy) {
                $row[] = '<input type="checkbox" name="employee[]" class="checklist" value="' . $subsidy->subsidy_id . '">' . $check_script;
            } else {
                $row[] = '';
            }

            $row[] = $subsidy->subsidy_name;
            $row[] = $status;
            $row[] = date('d-M-Y H:i A', strtotime($subsidy->created_date));
            $btnedit = '';
            $btndelete = '';

            if ($subsidy) {
                if (in_array('2487', $users_data['permission']['action'])) {
                    $btnedit = ' <a onClick="return edit_subsidy(' . $subsidy->subsidy_id . ');" class="btn-custom" href="javascript:void(0)" style="' . $subsidy->subsidy_id . '" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                }
                if (in_array('2488', $users_data['permission']['action'])) {
                    $btndelete = ' <a class="btn-custom" onClick="return delete_subsidy(' . $subsidy->subsidy_id . ')" href="javascript:void(0)" title="Delete" data-url="550"><i class="fa fa-trash"></i> Delete</a> ';
                }
            }


            $row[] = $btnedit . $btndelete;


            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->subsidy->count_all(),
            "recordsFiltered" => $this->subsidy->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function add()
    {
        unauthorise_permission('411', '2486');
        $data['page_title'] = "Add Subsidy";
        $post = $this->input->post();
        $data['form_error'] = [];
        $data['form_data'] = array(
            'data_id' => "",
            'subsidy_name' => "",
            'subsidy_status' => "1",

        );

        if (isset($post) && !empty($post)) {
            $data['form_data'] = $this->_validate();
            if ($this->form_validation->run() == TRUE) {
                $this->subsidy->save();
                echo 1;
                return false;

            } else {
                $data['form_error'] = validation_errors();
            }
        }
        $this->load->view('subsidy/add', $data);
    }

    public function edit($id = "")
    {
        unauthorise_permission('411', '2486');
        if (isset($id) && !empty($id) && is_numeric($id)) {
            $result = $this->subsidy->get_by_id($id);
            $data['page_title'] = "Update Subsidy";
            $post = $this->input->post();
            $data['form_error'] = '';
            $data['form_data'] = array(
                'data_id' => $result['subsidy_id'],
                'subsidy_name' => $result['subsidy_name'],
                'subsidy_status' => $result['subsidy_status'],

            );

            if (isset($post) && !empty($post)) {
                $data['form_data'] = $this->_validate();
                if ($this->form_validation->run() == TRUE) {
                    $this->subsidy->save();
                    echo 1;
                    return false;

                } else {
                    $data['form_error'] = validation_errors();
                }
            }
            $this->load->view('subsidy/add', $data);
        }
    }

    private function _validate()
    {
        $post = $this->input->post();
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('subsidy_name', 'Subsidy name', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $reg_no = generate_unique_id(2);
            $data['form_data'] = array(
                // 'data_id'=>$post['data_id'],
                'subsidy_name' => $post['subsidy_name'],
                'subsidy_status' => $post['subsidy_status'],

            );
            return $data['form_data'];
        }
    }

    public function delete($id = "")
    {
        unauthorise_permission('411', '2488');
        if (!empty($id) && $id > 0) {

            $result = $this->subsidy->delete($id);
            $response = "Subsidy successfully deleted.";
            echo $response;
        }
    }

    function deleteall()
    {
        unauthorise_permission('411', '2488');
        $post = $this->input->post();
        if (!empty($post)) {
            $result = $this->subsidy->deleteall($post['row_id']);
            $response = "Subsidy successfully deleted.";
            echo $response;
        }
    }

    public function view($id = "")
    {
        if (isset($id) && !empty($id) && is_numeric($id)) {
            $data['form_data'] = $this->subsidy->get_by_id($id);
            $data['page_title'] = $data['form_data']['subsidy_name'] . " detail";
            $this->load->view('subsidy/view', $data);
        }
    }


    ///// employee Archive Start  ///////////////
    public function archive()
    {
        unauthorise_permission('411', '2489');
        $data['page_title'] = 'Subsidy Archive List';
        $this->load->helper('url');
        $this->load->view('subsidy/archive', $data);
    }

    public function archive_ajax_list()
    {
        unauthorise_permission('411', '2489');
        $this->load->model('subsidy/subsidy_archive_model', 'subsid_archive');
        $users_data = $this->session->userdata('auth_users');
        // $branch_id = $this->input->post('branch_id');
        $list = '';

        $list = $this->subsid_archive->get_datatables();


        $data = array();
        $no = $_POST['start'];
        $i = 1;
        $total_num = count($list);
        foreach ($list as $subsidy) {
            // print_r($expense_category);die;
            $no++;
            $row = array();
            if ($subsidy->subsidy_status == 1) {
                $status = '<font color="green">Active</font>';
            } else {
                $status = '<font color="red">Inactive</font>';
            }

            ////////// Check  List /////////////////
            $check_script = "";
            if ($i == $total_num) {
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
            if ($users_data['parent_id'] == $subsidy->branch_id) {
                $row[] = '<input type="checkbox" name="employee[]" class="checklist" value="' . $subsidy->subsidy_id . '">' . $check_script;
            } else {
                $row[] = '';
            }
            $row[] = $subsidy->subsidy_name;
            $row[] = $status;
            $row[] = date('d-M-Y H:i A', strtotime($subsidy->created_date));

            $btnrestore = '';
            $btndelete = '';
            if ($users_data['parent_id'] == $subsidy->branch_id) {
                if (in_array('2491', $users_data['permission']['action'])) {
                    $btnrestore = ' <a onClick="return restore_patient_category(' . $subsidy->subsidy_id . ');" class="btn-custom" href="javascript:void(0)"  title="Restore"><i class="fa fa-window-restore" aria-hidden="true"></i> Restore </a>';
                }
                if (in_array('2490', $users_data['permission']['action'])) {
                    $btndelete = ' <a onClick="return trash(' . $subsidy->subsidy_id . ');" class="btn-custom" href="javascript:void(0)" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
                }
            }
            $row[] = $btnrestore . $btndelete;


            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->subsid_archive->count_all(),
            "recordsFiltered" => $this->subsid_archive->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function restore($id = "")
    {
        unauthorise_permission('411', '2491');
        $this->load->model('subsidy/subsidy_archive_model', 'subsid_archive');
        if (!empty($id) && $id > 0) {
            $result = $this->subsid_archive->restore($id);
            $response = "Subsidy successfully restore in Expense Category list.";
            echo $response;
        }
    }

    function restoreall()
    {
        unauthorise_permission('411', '2491');
        $this->load->model('subsidy/subsidy_archive_model', 'subsid_archive');
        $post = $this->input->post();
        if (!empty($post)) {
            $result = $this->subsid_archive->restoreall($post['row_id']);
            $response = "Subsidy successfully restore in Subsidy list.";
            echo $response;
        }
    }

    public function trash($id = "")
    {
        unauthorise_permission('411', '2490');
        $this->load->model('subsidy/subsid_archive_model', 'subsid_archive');
        if (!empty($id) && $id > 0) {
            $result = $this->subsid_archive->trash($id);
            $response = "Subsidy successfully deleted parmanently.";
            echo $response;
        }
    }

    function trashall()
    {
        unauthorise_permission('411', '2490');
        $this->load->model('subsidy/subsidy_archive_model', 'subsid_archive');
        $post = $this->input->post();
        if (!empty($post)) {
            $result = $this->subsid_archive->trashall($post['row_id']);
            $response = "Subsidy successfully deleted parmanently.";
            echo $response;
        }
    }
    ///// employee Archive end  ///////////////

    public function patient_category_dropdown()
    {
        $corporate_list = $this->subsidy->corporate_list();
        $dropdown = '<option value="">Select Subsidy</option>';
        if (!empty($corporate_list)) {
            foreach ($corporate_list as $subsidy) {
                $dropdown .= '<option value="' . $subsidy->id . '">' . $subsidy->patient_category . '</option>';
            }
        }
        echo $dropdown;
    }


    ///// rate Archive end  ///////////////
}
?>