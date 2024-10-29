<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Item_desc extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        auth_users();
        $this->load->model('item_desc/item_desc_model', 'item_desc');
        $this->load->library('form_validation');
    }

    public function index()
    {

        unauthorise_permission('53', '347');
        $data['page_title'] = 'Item Description List';
        $this->load->view('item_desc/list', $data);
    }

    public function ajax_list()
    {
        unauthorise_permission('53', '347');
        $list = $this->item_desc->get_datatables();
        // echo "<pre>";
        // print_r($list);
        // die;
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        $total_num = count($list);
        foreach ($list as $item_desc) {
            // print_r($unit);die;
            $no++;
            $row = array();
            if ($item_desc->status == 1) {
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
            $row[] = '<input type="checkbox" name="employee[]" class="checklist" value="' . $item_desc->id . '">' . $check_script;
            $row[] = $item_desc->item_desc;
            $row[] = $status;
            //$row[] = date('d-M-Y H:i A',strtotime($item_desc->created_date)); 

            $users_data = $this->session->userdata('auth_users');
            $btnedit = '';
            $btndelete = '';
            if (in_array('349', $users_data['permission']['action'])) {
                $btnedit = '<a onClick="return edit_medicine_unit(' . $item_desc->id . ');" class="btn-custom" href="javascript:void(0)" style="' . $item_desc->id . '" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
            }

            if (in_array('350', $users_data['permission']['action'])) {
                $btndelete = '<a class="btn-custom" onClick="return delete_medicine_unit(' . $item_desc->id . ')" href="javascript:void(0)" title="Delete" data-url="512"><i class="fa fa-trash"></i> Delete</a>';
            }
            $row[] = $btnedit . $btndelete;
            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->item_desc->count_all(),
            "recordsFiltered" => $this->item_desc->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function add()
    {
        unauthorise_permission('53', '348');
        $data['page_title'] = "Add Item Description";
        $post = $this->input->post();
        // echo "<pre>";
		// print_r($post);
		// die;
        $data['form_error'] = [];
        $data['form_data'] = array(
            'data_id' => "",
            'item_desc' => "",
            'status' => "1"
        );

        if (isset($post) && !empty($post)) {
            $data['form_data'] = $this->_validate();
            if ($this->form_validation->run() == TRUE) {
                $this->item_desc->save();
                echo 1;
                return false;

            } else {
                $data['form_error'] = validation_errors();
            }
        }
        $this->load->view('item_desc/add', $data);
    }

    public function edit($id = "")
    {
        unauthorise_permission('53', '349');
        if (isset($id) && !empty($id) && is_numeric($id)) {
            $result = $this->item_desc->get_by_id($id);
            $data['page_title'] = "Update Item Description";
            $post = $this->input->post();
            $data['form_error'] = '';
            $data['form_data'] = array(
                'data_id' => $result['id'],
                'item_desc' => $result['item_desc'],
                'status' => $result['status']
            );

            if (isset($post) && !empty($post)) {
                $data['form_data'] = $this->_validate();
                if ($this->form_validation->run() == TRUE) {
                    $this->item_desc->save();
                    echo 1;
                    return false;

                } else {
                    $data['form_error'] = validation_errors();
                }
            }
            $this->load->view('item_desc/add', $data);
        }
    }

    private function _validate()
    {
        $post = $this->input->post();
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('item_desc', 'medicine unit', 'trim|required');

        if ($this->form_validation->run() == FALSE) {

            $reg_no = generate_unique_id(2);
            $data['form_data'] = array(
                'data_id' => $post['data_id'],
                'item_desc' => $post['item_desc'],
                'status' => $post['status']
            );
            return $data['form_data'];
        }
    }

    public function delete($id = "")
    {
        unauthorise_permission('53', '350');
        if (!empty($id) && $id > 0) {
            $result = $this->item_desc->delete($id);
            $response = "Medicine unit successfully deleted.";
            echo $response;
        }
    }

    function deleteall()
    {
        unauthorise_permission('53', '350');
        $post = $this->input->post();
        if (!empty($post)) {
            $result = $this->item_desc->deleteall($post['row_id']);
            $response = "Medicine units successfully deleted.";
            echo $response;
        }
    }

    public function view($id = "")
    {

        if (isset($id) && !empty($id) && is_numeric($id)) {
            $data['form_data'] = $this->item_desc->get_by_id($id);
            $data['page_title'] = $data['form_data']['item_desc'] . " detail";
            $this->load->view('item_desc/view', $data);
        }
    }


    ///// employee Archive Start  ///////////////
    public function archive()
    {
        unauthorise_permission('53', '416');
        $data['page_title'] = 'Item Descripation Archive List';
        $this->load->helper('url');
        $this->load->view('item_desc/archive', $data);
    }

    public function archive_ajax_list()
    {
        unauthorise_permission('53', '416');
        $this->load->model('item_desc/item_desc_archive_model', 'item_desc_archive');

        $list = $this->item_desc_archive->get_datatables();
        // echo "<pre>";
        // print_r($list);
        // die;
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        $total_num = count($list);
        foreach ($list as $item_desc) {
            // print_r($unit);die;
            $no++;
            $row = array();
            if ($item_desc->status == 1) {
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
            $row[] = '<input type="checkbox" name="employee[]" class="checklist" value="' . $item_desc->id . '">' . $check_script;
            $row[] = $item_desc->item_desc;
            $row[] = $status;
            //$row[] = date('d-M-Y H:i A',strtotime($item_desc->created_date)); 
            $users_data = $this->session->userdata('auth_users');

            $btnrestore = '';
            $btndelete = '';
            if (in_array('353', $users_data['permission']['action'])) {
                $btnrestore = ' <a onClick="return restore_medicine_unit(' . $item_desc->id . ');" class="btn-custom" href="javascript:void(0)"  title="Restore"><i class="fa fa-window-restore" aria-hidden="true"></i> Restore </a>';
            }
            if (in_array('352', $users_data['permission']['action'])) {
                $btndelete = '<a onClick="return trash(' . $item_desc->id . ');" class="btn-custom" href="javascript:void(0)" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
            }

            $row[] = $btndelete . $btnrestore;
            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->item_desc_archive->count_all(),
            "recordsFiltered" => $this->item_desc_archive->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function restore($id = "")
    {
        unauthorise_permission('53', '353');
        $this->load->model('item_desc/item_desc_archive_model', 'item_desc_archive');
        if (!empty($id) && $id > 0) {
            $result = $this->item_desc_archive->restore($id);
            $response = "Medicine unit successfully restore in unit list.";
            echo $response;
        }
    }

    function restoreall()
    {
        unauthorise_permission('53', '353');
        $this->load->model('item_desc/item_desc_archive_model', 'item_desc_archive');
        $post = $this->input->post();
        if (!empty($post)) {
            $result = $this->item_desc_archive->restoreall($post['row_id']);
            $response = "Item Desc successfully restore in unit list.";
            echo $response;
        }
    }

    public function trash($id = "")
    {
        unauthorise_permission('53', '352');
        $this->load->model('item_desc/item_desc_archive_model', 'item_desc_archive');
        if (!empty($id) && $id > 0) {
            $result = $this->item_desc_archive->trash($id);
            $response = "Item Desc successfully deleted parmanently.";
            echo $response;
        }
    }

    function trashall()
    {
        unauthorise_permission('53', '352');
        $this->load->model('item_desc/item_desc_archive_model', 'item_desc_archive');
        $post = $this->input->post();
        if (!empty($post)) {
            $result = $this->item_desc_archive->trashall($post['row_id']);
            $response = "Item Desc successfully deleted parmanently.";
            echo $response;
        }
    }
    ///// employee Archive end  ///////////////

    public function medicine_unit_dropdown()
    {
        $medicine_unit_list = $this->item_desc->medicine_unit_list();
        $dropdown = '<option value="">Select Unit</option>';
        if (!empty($medicine_unit_list)) {
            foreach ($medicine_unit_list as $item_desc) {
                $dropdown .= '<option value="' . $item_desc->id . '">' . $item_desc->item_desc . '</option>';
            }
        }
        echo $dropdown;
    }

}
?>