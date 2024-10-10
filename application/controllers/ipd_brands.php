<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ipd_brands extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        auth_users();
        $this->load->model('ipd_brands/ipd_brands_model', 'ipd_brands');
        $this->load->library('form_validation');
    }

    public function index()
    {

        unauthorise_permission('411', '2485');
        $data['page_title'] = 'Brands List';
        $this->load->view('ipd_brands/list', $data);
    }

    public function ajax_list()
    {
        unauthorise_permission('411', '2485');
        $users_data = $this->session->userdata('auth_users');
        $sub_branch_details = $this->session->userdata('sub_branches_data');
        $parent_branch_details = $this->session->userdata('parent_branches_data');
        $list = $this->ipd_brands->get_datatables();
        // echo "<pre>";
        // print_r($list);
        // die;
        $data = array();
        $no = isset($_POST['start']) ? $_POST['start'] : 0;
        $i = 1;
        $total_num = count($list);
        foreach ($list as $brand) {
            // print_r($expense_category);die;
            $no++;
            $row = array();
            // if (is_object($brand) && property_exists($brand, 'brand_status')) {
                $no++;
                $row = array();
                if (is_object($brand) && $brand->brand_status == 'active') {
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
            // if($users_data['parent_id']==$brand->branch_id)
            if (is_object($brand) && property_exists($brand, 'id')) {
                // Create a checkbox with the brand ID
                $row[] = '<input type="checkbox" name="employee[]" class="checklist" value="' . $brand->id . '">' . $check_script;
            } else {
                // If $brand is not valid, set an empty value for this row
                $row[] = '';
            }
            

            if (property_exists($brand, 'brand_name')) {
                $row[] = $brand->brand_name;
            } else {
                $row[] = 'N/A'; // Default value if brand_name is missing
            }
       

            // Format created date
            if (property_exists($brand, 'created_date') && !empty($brand->created_date)) {
                $row[] = date('d-M-Y H:i A', strtotime($brand->created_date));
            } else {
                $row[] = 'N/A'; // Default value if created_date is missing or invalid
            }            $row[] = $status;
            $btnedit = '';
            $btndelete = '';

            if ($brand) {
                if (in_array('2487', $users_data['permission']['action'])) {
                    if (is_object($brand) && isset($brand->id)) {
                        // print_r($brand->id);die;
                        $btnedit = ' <a onClick="return edit_brand(' . $brand->id . ');" class="btn-custom" href="javascript:void(0)" style="' . $brand->id . '" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                    } else {
                        // $btnedit = '<span class="btn-custom" title="Edit" style="pointer-events: none; cursor: default;">Edit</span>'; // Optional: Provide a fallback
                    }
                                    }
                if (in_array('2488', $users_data['permission']['action'])) {
                    if (is_object($brand) && isset($brand->id)) {
                        $btndelete = ' <a class="btn-custom" onClick="return delete_brand(' . $brand->id . ')" href="javascript:void(0)" title="Delete" data-url="550"><i class="fa fa-trash"></i> Delete</a> ';
                    } else {
                        $btndelete = '<span class="btn-custom" title="Delete" style="pointer-events: none; cursor: default;">Delete</span>'; // Optional: Provide a fallback
                    }
                                    }
            }


            $row[] = $btnedit . $btndelete;


            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => isset($_POST['draw'])?$_POST['draw']:'',
            "recordsTotal" => $this->ipd_brands->count_all(),
            "recordsFiltered" => $this->ipd_brands->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function add()
    {
        unauthorise_permission('411', '2486');
        $data['page_title'] = "Add Brand";
        $post = $this->input->post();
        $data['form_error'] = [];
        $data['form_data'] = array(
            'data_id' => "",
            'brand_name' => "",
            'brand_status' => "1",

        );

        // echo "<pre>";print_r($post);
        if (isset($post) && !empty($post)) {
            // echo "2";
            $data['form_data'] = $this->_validate();
            // echo "2";
            if ($this->form_validation->run() == TRUE) {
                // die;
                $this->ipd_brands->save();
                echo 1;
                return false;

            } else {
                $data['form_error'] = validation_errors();
            }
        }
        $this->load->view('ipd_brands/add', $data);
    }

    public function edit($id = "")
    {
        // Check user permissions
        unauthorise_permission('411', '2486');
        
        // Validate the ID
        if (isset($id) && !empty($id) && is_numeric($id)) {
            // Retrieve the brand by ID
            $result = $this->ipd_brands->get_by_id($id);
            
            // If no result is found, you might want to handle this case
            if (!$result) {
                // Optionally, set an error message or redirect
                show_error('Brand not found', 404);
                return;
            }

            // Prepare data for the view
            $data['page_title'] = "Update Brand";
            $data['form_error'] = '';
            $data['form_data'] = array(
                'data_id' => $result['id'],
                'brand_name' => $result['brand_name'],
                'brand_status' => $result['brand_status'],
            );

            // Check if there is form submission
            if ($this->input->post()) {
                // Validate the form
                $data['form_data'] = $this->_validate();
                if ($this->form_validation->run() == TRUE) {
                    // Save the updated brand details
                    $this->ipd_brands->save();
                    echo 1; // Return a success response
                    return;
                } else {
                    // Capture validation errors
                    $data['form_error'] = validation_errors();
                }
            }
            
            // Load the view with the prepared data
            $this->load->view('ipd_brands/add', $data);
        } else {
            // Handle the case when the ID is invalid
            show_error('Invalid Brand ID', 400);
        }
    }


     private function _validate()
    {
        $post = $this->input->post();
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('brand_name', 'Brand name', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $reg_no = generate_unique_id(2);
            $data['form_data'] = array(
                // 'data_id'=>$post['data_id'],
                'brand_name' => $post['brand_name'],
                'brand_status' => $post['brand_status'],

            );
            return $data['form_data'];
        }
    }

    public function delete($id = "")
    {
        // echo "hihi";die;
        unauthorise_permission('411', '2488');
        if (!empty($id) && $id > 0) {

            $result = $this->ipd_brands->delete($id);
            $response = "Brand successfully deleted.";
            echo $response;
        }
    }

    function deleteall()
    {
        unauthorise_permission('411', '2488');
        $post = $this->input->post();
        if (!empty($post)) {
            $result = $this->ipd_brands->deleteall($post['row_id']);
            $response = "Brand successfully deleted.";
            echo $response;
        }
    }

    public function view($id = "")
    {
        if (isset($id) && !empty($id) && is_numeric($id)) {
            $data['form_data'] = $this->ipd_brands->get_by_id($id);
            $data['page_title'] = $data['form_data']['brand_name'] . " detail";
            $this->load->view('ipd_brands/view', $data);
        }
    }


    ///// employee Archive Start  ///////////////
    public function archive()
    {
        unauthorise_permission('411', '2489');
        $data['page_title'] = 'Brand Archive List';
        $this->load->helper('url');
        $this->load->view('ipd_brands/archive', $data);
    }

    // public function archive_ajax_list()
    // {
    //     unauthorise_permission('411', '2489');
    //     $this->load->model('ipd_brands/brand_archive_model', 'subsid_archive');
    //     $users_data = $this->session->userdata('auth_users');
    //     // $branch_id = $this->input->post('branch_id');
    //     $list = '';

    //     $list = $this->subsid_archive->get_datatables();


    //     $data = array();
    //     $no = $_POST['start'];
    //     $i = 1;
    //     $total_num = count($list);
    //     foreach ($list as $brand) {
    //         // print_r($expense_category);die;
    //         $no++;
    //         $row = array();
    //         if ($brand->brand_status == 1) {
    //             $status = '<font color="green">Active</font>';
    //         } else {
    //             $status = '<font color="red">Inactive</font>';
    //         }

    //         ////////// Check  List /////////////////
    //         $check_script = "";
    //         if ($i == $total_num) {
    //             $check_script = "<script>$('#selectAll').on('click', function () { 
    //                               if ($(this).hasClass('allChecked')) {
    //                                   $('.checklist').prop('checked', false);
    //                               } else {
    //                                   $('.checklist').prop('checked', true);
    //                               }
    //                               $(this).toggleClass('allChecked');
    //                           })</script>";
    //         }
    //         ////////// Check list end ///////////// 
    //         if ($users_data['parent_id'] == $brand->branch_id) {
    //             $row[] = '<input type="checkbox" name="employee[]" class="checklist" value="' . $brand->id . '">' . $check_script;
    //         } else {
    //             $row[] = '';
    //         }
    //         $row[] = $brand->brand_name;
    //         $row[] = $status;
    //         $row[] = date('d-M-Y H:i A', strtotime($brand->created_date));

    //         $btnrestore = '';
    //         $btndelete = '';
    //         if ($users_data['parent_id'] == $brand->branch_id) {
    //             if (in_array('2491', $users_data['permission']['action'])) {
    //                 $btnrestore = ' <a onClick="return restore_patient_category(' . $brand->id . ');" class="btn-custom" href="javascript:void(0)"  title="Restore"><i class="fa fa-window-restore" aria-hidden="true"></i> Restore </a>';
    //             }
    //             if (in_array('2490', $users_data['permission']['action'])) {
    //                 $btndelete = ' <a onClick="return trash(' . $brand->id . ');" class="btn-custom" href="javascript:void(0)" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
    //             }
    //         }
    //         $row[] = $btnrestore . $btndelete;


    //         $data[] = $row;
    //         $i++;
    //     }

    //     $output = array(
    //         "draw" => $_POST['draw'],
    //         "recordsTotal" => $this->subsid_archive->count_all(),
    //         "recordsFiltered" => $this->subsid_archive->count_filtered(),
    //         "data" => $data,
    //     );
    //     //output to json format
    //     echo json_encode($output);
    // }

    public function restore($id = "")
    {
        // unauthorise_permission('411', '2491');
        // $this->load->model('ipd_brands/brand_archive_model', 'subsid_archive');
        // if (!empty($id) && $id > 0) {
        //     $result = $this->subsid_archive->restore($id);
        //     $response = "Brand successfully restore in Expense Category list.";
        //     echo $response;
        // }
    }

    function restoreall()
    {
        // unauthorise_permission('411', '2491');
        // $this->load->model('ipd_brands/brand_archive_model', 'subsid_archive');
        // $post = $this->input->post();
        // if (!empty($post)) {
        //     $result = $this->subsid_archive->restoreall($post['row_id']);
        //     $response = "Brand successfully restore in Brand list.";
        //     echo $response;
        // }
    }

    public function trash($id = "")
    {
        // unauthorise_permission('411', '2490');
        // $this->load->model('ipd_brands/brand_archive_model', 'subsid_archive');
        // if (!empty($id) && $id > 0) {
        //     $result = $this->subsid_archive->trash($id);
        //     $response = "Brand successfully deleted parmanently.";
        //     echo $response;
        // }
    }

    function trashall()
    {
        // unauthorise_permission('411', '2490');
        // $this->load->model('ipd_brands/brand_archive_model', 'subsid_archive');
        // $post = $this->input->post();
        // if (!empty($post)) {
        //     $result = $this->subsid_archive->trashall($post['row_id']);
        //     $response = "Brand successfully deleted parmanently.";
        //     echo $response;
        // }
    }
    ///// employee Archive end  ///////////////

    public function patient_category_dropdown()
    {
        $corporate_list = $this->ipd_brands->corporate_list();
        $dropdown = '<option value="">Select Brand</option>';
        if (!empty($corporate_list)) {
            foreach ($corporate_list as $brand) {
                $dropdown .= '<option value="' . $brand->id . '">' . $brand->patient_category . '</option>';
            }
        }
        echo $dropdown;
    }


    ///// rate Archive end  ///////////////
}
?>