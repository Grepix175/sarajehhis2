<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Department_master extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        auth_users();
        $this->load->model('department_master/department_master_model', 'department_master');
        $this->load->library('form_validation');
    }

    public function index()
    {
        unauthorise_permission('411', '2485');
        $data['page_title'] = 'Department Master List';
        $this->load->view('department_master/list', $data);
    }

    public function ajax_list()
    {
        unauthorise_permission('411', '2485');
        $users_data = $this->session->userdata('auth_users');
        $sub_branch_details = $this->session->userdata('sub_branches_data');
        $parent_branch_details = $this->session->userdata('parent_branches_data');
        $list = $this->department_master->get_datatables();
        // echo "<pre>";
        // print_r($list);
        // die;
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        $total_num = count($list);
        foreach ($list as $dept) {
            // print_r($expense_category);die;
            $no++;
            $row = array();
            if ($dept->department_status == 1) {
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
            // if($users_data['parent_id']==$dept->branch_id)
            if ($dept) {
                $row[] = '<input type="checkbox" name="employee[]" class="checklist" value="' . $dept->department_id . '">' . $check_script;
            } else {
                $row[] = '';
            }

            $row[] = $dept->department_name;
            $row[] = $status;
            $row[] = date('d-M-Y H:i A', strtotime($dept->created_date));
            $btnedit = '';
            $btndelete = '';

            if ($dept) {
                if (in_array('2487', $users_data['permission']['action'])) {
                    $btnedit = ' <a onClick="return edit_subsidy(' . $dept->department_id . ');" class="btn-custom" href="javascript:void(0)" style="' . $dept->department_id . '" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                }
                if (in_array('2488', $users_data['permission']['action'])) {
                    $btndelete = ' <a class="btn-custom" onClick="return delete_subsidy(' . $dept->department_id . ')" href="javascript:void(0)" title="Delete" data-url="550"><i class="fa fa-trash"></i> Delete</a> ';
                }
            }


            $row[] = $btnedit . $btndelete;


            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->department_master->count_all(),
            "recordsFiltered" => $this->department_master->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function add()
    {
        unauthorise_permission('411', '2486');
        $data['page_title'] = "Add Department Master";
        $post = $this->input->post();
        $data['form_error'] = [];
        $data['form_data'] = array(
            'data_id' => "",
            'department_name' => "",
            'department_status' => "1",

        );

        if (isset($post) && !empty($post)) {
            $data['form_data'] = $this->_validate();
            if ($this->form_validation->run() == TRUE) {
                $this->department_master->save();
                echo 1;
                return false;

            } else {
                $data['form_error'] = validation_errors();
            }
        }
        $this->load->view('department_master/add', $data);
    }

    public function edit($id = "")
    {
        unauthorise_permission('411', '2486');
        if (isset($id) && !empty($id) && is_numeric($id)) {
            $result = $this->department_master->get_by_id($id);
            $data['page_title'] = "Update Department Master";
            $post = $this->input->post();
            $data['form_error'] = '';
            $data['form_data'] = array(
                'data_id' => $result['department_id'],
                'department_name' => $result['department_name'],
                'department_status' => $result['department_status'],

            );

            if (isset($post) && !empty($post)) {
                $data['form_data'] = $this->_validate();
                if ($this->form_validation->run() == TRUE) {
                    $this->department_master->save();
                    echo 1;
                    return false;

                } else {
                    $data['form_error'] = validation_errors();
                }
            }
            $this->load->view('department_master/add', $data);
        }
    }

    private function _validate()
    {
        $post = $this->input->post();
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('department_name', 'Subsidy name', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $reg_no = generate_unique_id(2);
            $data['form_data'] = array(
                // 'data_id'=>$post['data_id'],
                'department_name' => $post['department_name'],
                'department_status' => $post['department_status'],

            );
            return $data['form_data'];
        }
    }

    public function delete($id = "")
    {
        unauthorise_permission('411', '2488');
        if (!empty($id) && $id > 0) {

            $result = $this->department_master->delete($id);
            $response = "Department Master successfully deleted.";
            echo $response;
        }
    }

    function deleteall()
    {
        unauthorise_permission('411', '2488');
        $post = $this->input->post();
        if (!empty($post)) {
            $result = $this->department_master->deleteall($post['row_id']);
            $response = "Department Master successfully deleted.";
            echo $response;
        }
    }

    public function view($id = "")
    {
        if (isset($id) && !empty($id) && is_numeric($id)) {
            $data['form_data'] = $this->department_master->get_by_id($id);
            $data['page_title'] = $data['form_data']['department_name'] . " detail";
            $this->load->view('department_master/view', $data);
        }
    }


    ///// employee Archive Start  ///////////////
    public function archive()
    {
        unauthorise_permission('411', '2489');
        $data['page_title'] = 'Department Master Archive List';
        $this->load->helper('url');
        $this->load->view('department_master/archive', $data);
    }

    public function archive_ajax_list()
    {
        unauthorise_permission('411', '2489');
        $this->load->model('department_master/department_master_archive_model', 'department_master_archive');
        $users_data = $this->session->userdata('auth_users');
        // $branch_id = $this->input->post('branch_id');
        $list = '';

        $list = $this->department_master_archive->get_datatables();


        $data = array();
        $no = $_POST['start'];
        $i = 1;
        $total_num = count($list);
        foreach ($list as $dept) {
            // print_r($expense_category);die;
            $no++;
            $row = array();
            if ($dept->department_status == 1) {
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
            if ($users_data['parent_id'] == $dept->branch_id) {
                $row[] = '<input type="checkbox" name="employee[]" class="checklist" value="' . $dept->department_id . '">' . $check_script;
            } else {
                $row[] = '';
            }
            $row[] = $dept->department_name;
            $row[] = $status;
            $row[] = date('d-M-Y H:i A', strtotime($dept->created_date));

            $btnrestore = '';
            $btndelete = '';
            if ($users_data['parent_id'] == $dept->branch_id) {
                if (in_array('2491', $users_data['permission']['action'])) {
                    $btnrestore = ' <a onClick="return restore_patient_category(' . $dept->department_id . ');" class="btn-custom" href="javascript:void(0)"  title="Restore"><i class="fa fa-window-restore" aria-hidden="true"></i> Restore </a>';
                }
                if (in_array('2490', $users_data['permission']['action'])) {
                    $btndelete = ' <a onClick="return trash(' . $dept->department_id . ');" class="btn-custom" href="javascript:void(0)" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
                }
            }
            $row[] = $btnrestore . $btndelete;


            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->department_master_archive->count_all(),
            "recordsFiltered" => $this->department_master_archive->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function restore($id = "")
    {
        unauthorise_permission('411', '2491');
        $this->load->model('department_master/department_master_archive_model', 'department_master_archive');
        if (!empty($id) && $id > 0) {
            $result = $this->department_master_archive->restore($id);
            $response = "Department master archive successfully restore in Expense department master list.";
            echo $response;
        }
    }

    function restoreall()
    {
        unauthorise_permission('411', '2491');
        $this->load->model('department_master/department_master_archive_model', 'department_master_archive');
        $post = $this->input->post();
        if (!empty($post)) {
            $result = $this->department_master_archive->restoreall($post['row_id']);
            $response = "Department master archive successfully restore in department master list.";
            echo $response;
        }
    }

    public function trash($id = "")
    {
        unauthorise_permission('411', '2490');
        $this->load->model('department_master/department_master_archive_model', 'department_master_archive');
        if (!empty($id) && $id > 0) {
            $result = $this->department_master_archive->trash($id);
            $response = "Department master archive successfully deleted parmanently.";
            echo $response;
        }
    }

    function trashall()
    {
        unauthorise_permission('411', '2490');
        $this->load->model('department_master/department_master_archive_model', 'department_master_archive');
        $post = $this->input->post();
        if (!empty($post)) {
            $result = $this->department_master_archive->trashall($post['row_id']);
            $response = "Department master archive successfully deleted parmanently.";
            echo $response;
        }
    }
}
?>