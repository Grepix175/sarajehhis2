<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Emg_reg_charge extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        auth_users();
        $this->load->model('emg_reg_charge/Emg_reg_charge_model', 'emg_reg_charge');
        $this->load->library('form_validation');
    }

    public function index()
    {
        // echo "<pre>";
        // print_r('hiiii');
        // die;
        unauthorise_permission('411', '2485');
        $data['page_title'] = 'Emergency Register Charge List';
        $this->load->view('emg_reg_charge/list', $data);
    }

    public function ajax_list()
    {
        unauthorise_permission('411', '2485');
        $users_data = $this->session->userdata('auth_users');
        $sub_branch_details = $this->session->userdata('sub_branches_data');
        $parent_branch_details = $this->session->userdata('parent_branches_data');
        $list = $this->emg_reg_charge->get_datatables();
        // echo "<pre>";
        // print_r($list);
        // die;
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        $total_num = count($list);
        foreach ($list as $emg_charge) {
            // print_r($expense_category);die;
            $no++;
            $row = array();
            if ($emg_charge->status == 1) {
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
            // if($users_data['parent_id']==$corporate->branch_id)
            if ($emg_charge) {
                $row[] = '<input type="checkbox" name="employee[]" class="checklist" value="' . $emg_charge->id . '">' . $check_script;
            } else {
                $row[] = '';
            }

            $row[] = number_format((float)$emg_charge->charge, 2, '.', '');

            $row[] = $status;
            $row[] = date('d-M-Y H:i A', strtotime($emg_charge->created_date));
            $btnedit = '';
            $btndelete = '';

            if ($emg_charge) {
                if (in_array('2487', $users_data['permission']['action'])) {
                    $btnedit = ' <a onClick="return edit_patient_category(' . $emg_charge->id . ');" class="btn-custom" href="javascript:void(0)" style="' . $emg_charge->id . '" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                }
                if (in_array('2488', $users_data['permission']['action'])) {
                    $btndelete = ' <a class="btn-custom" onClick="return delete_patient_category(' . $emg_charge->id . ')" href="javascript:void(0)" title="Delete" data-url="550"><i class="fa fa-trash"></i> Delete</a> ';
                }
            }


            $row[] = $btnedit . $btndelete;


            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->emg_reg_charge->count_all(),
            "recordsFiltered" => $this->emg_reg_charge->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function add()
    {
        unauthorise_permission('411', '2486');
        $data['page_title'] = "Add Eme. Reg. Charge";
        $post = $this->input->post();
        $data['form_error'] = [];
        $data['form_data'] = array(
            'data_id' => "",
            'charge' => "",
            'status' => "1",

        );

        if (isset($post) && !empty($post)) {
            $data['form_data'] = $this->_validate();
            if ($this->form_validation->run() == TRUE) {
                $this->emg_reg_charge->save();
                echo 1;
                return false;

            } else {
                $data['form_error'] = validation_errors();
            }
        }
        $this->load->view('emg_reg_charge/add', $data);
    }

    public function edit($id = "")
    {
        unauthorise_permission('411', '2486');
        if (isset($id) && !empty($id) && is_numeric($id)) {
            $result = $this->emg_reg_charge->get_by_id($id);
            $data['page_title'] = "Eme. Reg. Charge";
            $post = $this->input->post();
            $data['form_error'] = '';
            $data['form_data'] = array(
                'data_id' => $result['id'],
                'charge' => $result['charge'],
                'status' => $result['status'],

            );

            if (isset($post) && !empty($post)) {
                $data['form_data'] = $this->_validate();
                if ($this->form_validation->run() == TRUE) {
                    $this->emg_reg_charge->save();
                    echo 1;
                    return false;

                } else {
                    $data['form_error'] = validation_errors();
                }
            }
            $this->load->view('emg_reg_charge/add', $data);
        }
    }

    private function _validate()
    {
        $post = $this->input->post();
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('charge', 'Charge', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $reg_no = generate_unique_id(2);
            $data['form_data'] = array(
                // 'data_id'=>$post['data_id'],
                'charge' => $post['charge'],
                'status' => $post['status'],

            );
            return $data['form_data'];
        }
    }

    public function delete($id = "")
    {
        unauthorise_permission('411', '2488');
        if (!empty($id) && $id > 0) {

            $result = $this->emg_reg_charge->delete($id);
            $response = "Eme. Reg. Charge successfully deleted.";
            echo $response;
        }
    }

    function deleteall()
    {
        unauthorise_permission('411', '2488');
        $post = $this->input->post();
        if (!empty($post)) {
            $result = $this->emg_reg_charge->deleteall($post['row_id']);
            $response = "Eme. Reg. Charge successfully deleted.";
            echo $response;
        }
    }

    public function view($id = "")
    {
        if (isset($id) && !empty($id) && is_numeric($id)) {
            $data['form_data'] = $this->emg_reg_charge->get_by_id($id);
            $data['page_title'] = $data['form_data']['charge'] . " detail";
            $this->load->view('emg_reg_charge/view', $data);
        }
    }


    ///// employee Archive Start  ///////////////
    public function archive()
    {
        unauthorise_permission('411', '2489');
        $data['page_title'] = 'Eme. Reg. Charge Archive List';
        $this->load->helper('url');
        $this->load->view('emg_reg_charge/archive', $data);
    }

    public function archive_ajax_list()
    {
        unauthorise_permission('411', '2489');
        $this->load->model('emg_reg_charge/Emg_reg_archive_model', 'emg_reg_archive');
        $users_data = $this->session->userdata('auth_users');
        $branch_id = $this->input->post('branch_id');
        $list = '';

        $list = $this->emg_reg_archive->get_datatables();


        $data = array();
        $no = $_POST['start'];
        $i = 1;
        $total_num = count($list);
        foreach ($list as $eme_reg) {
            // print_r($expense_category);die;
            $no++;
            $row = array();
            if ($eme_reg->status == 1) {
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
            if ($users_data['parent_id'] == $eme_reg->branch_id) {
                $row[] = '<input type="checkbox" name="employee[]" class="checklist" value="' . $eme_reg->id . '">' . $check_script;
            } else {
                $row[] = '';
            }
            $row[] = $eme_reg->charge;
            $row[] = $status;
            $row[] = date('d-M-Y H:i A', strtotime($eme_reg->created_date));

            $btnrestore = '';
            $btndelete = '';
            if ($users_data['parent_id'] == $eme_reg->branch_id) {
                if (in_array('2491', $users_data['permission']['action'])) {
                    $btnrestore = ' <a onClick="return restore_patient_category(' . $eme_reg->id . ');" class="btn-custom" href="javascript:void(0)"  title="Restore"><i class="fa fa-window-restore" aria-hidden="true"></i> Restore </a>';
                }
                if (in_array('2490', $users_data['permission']['action'])) {
                    $btndelete = ' <a onClick="return trash(' . $eme_reg->id . ');" class="btn-custom" href="javascript:void(0)" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
                }
            }
            $row[] = $btnrestore . $btndelete;


            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->emg_reg_archive->count_all(),
            "recordsFiltered" => $this->emg_reg_archive->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function restore($id = "")
    {
        unauthorise_permission('411', '2491');
        $this->load->model('emg_reg_charge/Emg_reg_archive_model', 'emg_reg_archive');
        if (!empty($id) && $id > 0) {
            $result = $this->emg_reg_archive->restore($id);
            $response = "Emg. Reg. Charge successfully restore in Expense Emg. Reg. Charge  list.";
            echo $response;
        }
    }

    function restoreall()
    {
        unauthorise_permission('411', '2491');
        $this->load->model('emg_reg_charge/Emg_reg_archive_model', 'emg_reg_archive');
        $post = $this->input->post();
        if (!empty($post)) {
            $result = $this->emg_reg_archive->restoreall($post['row_id']);
            $response = "Emg. Reg. Charge successfully restore in Emg. Reg. Charge  list.";
            echo $response;
        }
    }

    public function trash($id = "")
    {
        unauthorise_permission('411', '2490');
        $this->load->model('emg_reg_charge/Emg_reg_archive_model', 'emg_reg_archive');
        if (!empty($id) && $id > 0) {
            $result = $this->emg_reg_archive->trash($id);
            $response = "Emg. Reg. Charge successfully deleted parmanently.";
            echo $response;
        }
    }

    function trashall()
    {
        unauthorise_permission('411', '2490');
        $this->load->model('emg_reg_charge/Emg_reg_archive_model', 'emg_reg_archive');
        $post = $this->input->post();
        if (!empty($post)) {
            $result = $this->emg_reg_archive->trashall($post['row_id']);
            $response = "Emg. Reg. Charge successfully deleted parmanently.";
            echo $response;
        }
    }
    ///// employee Archive end  ///////////////

}
?>