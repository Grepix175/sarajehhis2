<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Visitor_type extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        auth_users();
        $this->load->model('visitor_type/Visitor_type_model', 'visitor_type');
        $this->load->library('form_validation');
    }

    public function index()
    {

        unauthorise_permission('411', '2485');
        $data['page_title'] = 'Visitor Type List';
        $this->load->view('visitor_type/list', $data);
    }

    public function ajax_list()
    {
        unauthorise_permission('411', '2485');
        $users_data = $this->session->userdata('auth_users');
        $sub_branch_details = $this->session->userdata('sub_branches_data');
        $parent_branch_details = $this->session->userdata('parent_branches_data');
        $list = $this->visitor_type->get_datatables();
        // echo "<pre>";
        // print_r($list);
        // die;
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        $total_num = count($list);
        foreach ($list as $visitor_type) {
            // print_r($expense_category);die;
            $no++;
            $row = array();
            if ($visitor_type->status == 1) {
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
            // if($users_data['parent_id']==$visitor_type->branch_id)
            if ($visitor_type) {
                $row[] = '<input type="checkbox" name="employee[]" class="checklist" value="' . $visitor_type->id . '">' . $check_script;
            } else {
                $row[] = '';
            }

            $row[] = $visitor_type->visitor_type;
            $row[] = $status;
            $row[] = date('d-M-Y H:i A', strtotime($visitor_type->created_date));
            $btnedit = '';
            $btndelete = '';

            if ($visitor_type) {
                if (in_array('2487', $users_data['permission']['action'])) {
                    $btnedit = ' <a onClick="return edit_patient_category(' . $visitor_type->id . ');" class="btn-custom" href="javascript:void(0)" style="' . $visitor_type->id . '" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                }
                if (in_array('2488', $users_data['permission']['action'])) {
                    $btndelete = ' <a class="btn-custom" onClick="return delete_patient_category(' . $visitor_type->id . ')" href="javascript:void(0)" title="Delete" data-url="550"><i class="fa fa-trash"></i> Delete</a> ';
                }
            }


            $row[] = $btnedit . $btndelete;


            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->visitor_type->count_all(),
            "recordsFiltered" => $this->visitor_type->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function add()
    {
        unauthorise_permission('411', '2486');
        $data['page_title'] = "Add Visitor Type";
        $post = $this->input->post();
        $data['form_error'] = [];
        $data['form_data'] = array(
            'data_id' => "",
            'visitor_type' => "",
            'status' => "1",

        );

        if (isset($post) && !empty($post)) {
            $data['form_data'] = $this->_validate();
            if ($this->form_validation->run() == TRUE) {
                $this->visitor_type->save();
                echo 1;
                return false;

            } else {
                $data['form_error'] = validation_errors();
            }
        }
        $this->load->view('visitor_type/add', $data);
    }

    public function edit($id = "")
    {
        unauthorise_permission('411', '2486');
        if (isset($id) && !empty($id) && is_numeric($id)) {
            $result = $this->visitor_type->get_by_id($id);
            $data['page_title'] = "Update Visitor type";
            $post = $this->input->post();
            $data['form_error'] = '';
            $data['form_data'] = array(
                'data_id' => $result['id'],
                'visitor_type' => $result['visitor_type'],
                'status' => $result['status'],

            );

            if (isset($post) && !empty($post)) {
                $data['form_data'] = $this->_validate();
                if ($this->form_validation->run() == TRUE) {
                    $this->visitor_type->save();
                    echo 1;
                    return false;

                } else {
                    $data['form_error'] = validation_errors();
                }
            }
            $this->load->view('visitor_type/add', $data);
        }
    }

    private function _validate()
    {
        $post = $this->input->post();
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('visitor_type', 'Visitor type name', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $reg_no = generate_unique_id(2);
            $data['form_data'] = array(
                // 'data_id'=>$post['data_id'],
                'visitor_type' => $post['visitor_type'],
                'status' => $post['status'],

            );
            return $data['form_data'];
        }
    }

    public function delete($id = "")
    {
        unauthorise_permission('411', '2488');
        if (!empty($id) && $id > 0) {

            $result = $this->visitor_type->delete($id);
            $response = "Visitor type successfully deleted.";
            echo $response;
        }
    }

    function deleteall()
    {
        unauthorise_permission('411', '2488');
        $post = $this->input->post();
        if (!empty($post)) {
            $result = $this->visitor_type->deleteall($post['row_id']);
            $response = "Visitor type successfully deleted.";
            echo $response;
        }
    }

    public function view($id = "")
    {
        if (isset($id) && !empty($id) && is_numeric($id)) {
            $data['form_data'] = $this->visitor_type->get_by_id($id);
            $data['page_title'] = $data['form_data']['visitor_type'] . " detail";
            $this->load->view('visitor_type/view', $data);
        }
    }


    ///// employee Archive Start  ///////////////
    public function archive()
    {
        unauthorise_permission('411', '2489');
        $data['page_title'] = 'Visitor type Archive List';
        $this->load->helper('url');
        $this->load->view('visitor_type/archive', $data);
    }

    public function archive_ajax_list()
    {
        unauthorise_permission('411', '2489');
        $this->load->model('visitor_type/Visitor_type_archive_model', 'visitor_type_archive');
        $users_data = $this->session->userdata('auth_users');
        $branch_id = $this->input->post('branch_id');
        $list = '';

        $list = $this->visitor_type_archive->get_datatables();


        $data = array();
        $no = $_POST['start'];
        $i = 1;
        $total_num = count($list);
        foreach ($list as $visitor_type) {
            // print_r($expense_category);die;
            $no++;
            $row = array();
            if ($visitor_type->status == 1) {
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
            if ($users_data['parent_id'] == $visitor_type->branch_id) {
                $row[] = '<input type="checkbox" name="employee[]" class="checklist" value="' . $visitor_type->id . '">' . $check_script;
            } else {
                $row[] = '';
            }
            $row[] = $visitor_type->visitor_type;
            $row[] = $status;
            $row[] = date('d-M-Y H:i A', strtotime($visitor_type->created_date));

            $btnrestore = '';
            $btndelete = '';
            if ($users_data['parent_id'] == $visitor_type->branch_id) {
                if (in_array('2491', $users_data['permission']['action'])) {
                    $btnrestore = ' <a onClick="return restore_patient_category(' . $visitor_type->id . ');" class="btn-custom" href="javascript:void(0)"  title="Restore"><i class="fa fa-window-restore" aria-hidden="true"></i> Restore </a>';
                }
                if (in_array('2490', $users_data['permission']['action'])) {
                    $btndelete = ' <a onClick="return trash(' . $visitor_type->id . ');" class="btn-custom" href="javascript:void(0)" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
                }
            }
            $row[] = $btnrestore . $btndelete;


            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->visitor_type_archive->count_all(),
            "recordsFiltered" => $this->visitor_type_archive->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function restore($id = "")
    {
        unauthorise_permission('411', '2491');
        $this->load->model('visitor_type/visitor_type_archive_model', 'visitor_type_archive');
        if (!empty($id) && $id > 0) {
            $result = $this->visitor_type_archive->restore($id);
            $response = "Visitor type successfully restore in Expense Category list.";
            echo $response;
        }
    }

    function restoreall()
    {
        unauthorise_permission('411', '2491');
        $this->load->model('visitor_type/visitor_type_archive_model', 'visitor_type_archive');
        $post = $this->input->post();
        if (!empty($post)) {
            $result = $this->visitor_type_archive->restoreall($post['row_id']);
            $response = "Visitor type successfully restore in Visitor type list.";
            echo $response;
        }
    }

    public function trash($id = "")
    {
        unauthorise_permission('411', '2490');
        $this->load->model('visitor_type/visitor_type_archive_model', 'visitor_type_archive');
        if (!empty($id) && $id > 0) {
            $result = $this->visitor_type_archive->trash($id);
            $response = "Visitor type successfully deleted parmanently.";
            echo $response;
        }
    }

    function trashall()
    {
        unauthorise_permission('411', '2490');
        $this->load->model('visitor_type/visitor_type_archive_model', 'visitor_type_archive');
        $post = $this->input->post();
        if (!empty($post)) {
            $result = $this->visitor_type_archive->trashall($post['row_id']);
            $response = "Visitor type successfully deleted parmanently.";
            echo $response;
        }
    }
    ///// employee Archive end  ///////////////

}
?>