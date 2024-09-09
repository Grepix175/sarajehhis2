<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_company extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        auth_users();
        $this->load->model('inventory_company/inventory_company_model','manuf_company');
        $this->load->library('form_validation');
    }

    public function index()
    { 
     
       unauthorise_permission('164','946');
        $data['page_title'] = 'Manufacturing company list'; 
        $this->load->view('inventory_company/list',$data);
    }

    public function ajax_list()
    { 
      unauthorise_permission('164','946');
        $list = $this->manuf_company->get_datatables();  
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        $total_num = count($list);
        foreach ($list as $manuf_company) {
         // print_r($unit);die;
            $no++;
            $row = array();
            if($manuf_company->status==1)
            {
                $status = '<font color="green">Active</font>';
            }   
            else{
                $status = '<font color="red">Inactive</font>';
            } 
            
            ////////// Check  List /////////////////
            $check_script = "";
            if($i==$total_num)
            {
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
            $row[] = '<input type="checkbox" name="employee[]" class="checklist" value="'.$manuf_company->id.'">'.$check_script; 
            $row[] = $manuf_company->company_name;  
            $row[] = $status;
            //$row[] = date('d-M-Y H:i A',strtotime($manuf_company->created_date)); 
 
       $users_data = $this->session->userdata('auth_users');
       $btnedit='';
       $btndelete='';
      if(in_array('947',$users_data['permission']['action'])){
          $btnedit = '<a onClick="return edit_manuf_company('.$manuf_company->id.');" class="btn-custom" href="javascript:void(0)" style="'.$manuf_company->id.'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
       }
        
        if(in_array('949',$users_data['permission']['action'])){
               $btndelete = '<a class="btn-custom" onClick="return delete_manuf_company('.$manuf_company->id.')" href="javascript:void(0)" title="Delete" data-url="512"><i class="fa fa-trash"></i> Delete</a>';   
            }
          $row[] = $btnedit.$btndelete;
            $data[] = $row;
            $i++;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->manuf_company->count_all(),
                        "recordsFiltered" => $this->manuf_company->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
    
    
    public function add()
    {
       unauthorise_permission('164','947');
        $data['page_title'] = "Add manufacturing company";  
        $post = $this->input->post();
        $data['form_error'] = []; 
        $data['form_data'] = array(
                                  'data_id'=>"", 
                                  'company_name'=>"",
                                  'status'=>"1"
                                  );    

        if(isset($post) && !empty($post))
        {   
            $data['form_data'] = $this->_validate();
            if($this->form_validation->run() == TRUE)
            {
                $this->manuf_company->save();
                echo 1;
                return false;
                
            }
            else
            {
                $data['form_error'] = validation_errors();  
            }     
        }
       $this->load->view('inventory_company/add',$data);       
    }
    
    public function edit($id="")
    {
     unauthorise_permission('164','947');
     if(isset($id) && !empty($id) && is_numeric($id))
      {      
        $result = $this->manuf_company->get_by_id($id);  
        $data['page_title'] = "Update manufacturing company";  
        $post = $this->input->post();
        $data['form_error'] = ''; 
        $data['form_data'] = array(
                                  'data_id'=>$result['id'],
                                  'company_name'=>$result['company_name'], 
                                  'status'=>$result['status']
                                  );  
        
        if(isset($post) && !empty($post))
        {   
            $data['form_data'] = $this->_validate();
            if($this->form_validation->run() == TRUE)
            {
                $this->manuf_company->save();
                echo 1;
                return false;
                
            }
            else
            {
                $data['form_error'] = validation_errors();  
            }     
        }
       $this->load->view('inventory_company/add',$data);       
      }
    }
     
    private function _validate()
    {
    
        $post = $this->input->post();    
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');  

        $this->form_validation->set_rules('company_name', 'Company Name', 'required|callback_check_company');
       

        
        if ($this->form_validation->run() == FALSE) 
        {  
            $reg_no = generate_unique_id(2); 
            $data['form_data'] = array(
                                        'data_id'=>$post['data_id'],
                                        'company_name'=>$post['company_name'], 
                                        'status'=>$post['status']
                                       ); 
            return $data['form_data'];
        }   
    }

   public function check_company($str)
  {
    $post = $this->input->post();
    if(!empty($str))
    {
        $this->load->model('general/general_model','general'); 
        if(!empty($post['data_id']) && $post['data_id']>0)
        {
                return true;
        }
        else
        {
                $companydata = $this->general->check_inventory_company($str);
                if(empty($companydata))
                {
                   return true;
                }
                else
                {
            $this->form_validation->set_message('check_company', 'The manufacturing company  already exists.');
            return false;
                }
        }  
    }
    else
    {
      $this->form_validation->set_message('check_company', 'The manufacturing company field is required.');
            return false; 
    } 
  }
 
    public function delete($id="")
    {  
       unauthorise_permission('164','949');
       if(!empty($id) && $id>0)
       {
           $result = $this->manuf_company->delete($id);
           $response = "Manufacturing company successfully deleted.";
           echo $response;
       }
    }

    function deleteall()
    {
       unauthorise_permission('164','949');
        $post = $this->input->post();  
        if(!empty($post))
        {
            $result = $this->manuf_company->deleteall($post['row_id']);
            $response = "Manufacturing company successfully deleted.";
            echo $response;
        }
    }

    public function view($id="")
    {  
     
     if(isset($id) && !empty($id) && is_numeric($id))
      {      
        $data['form_data'] = $this->manuf_company->get_by_id($id);  
        $data['page_title'] = $data['form_data']['manuf_company']." detail";
        $this->load->view('inventory_company/view',$data);     
      }
    }  


    ///// employee Archive Start  ///////////////
    public function archive()
    {
       unauthorise_permission('164','950');
        $data['page_title'] = 'Manufacturing company archive list';
        $this->load->helper('url');
        $this->load->view('inventory_company/archive',$data);
    }

    public function archive_ajax_list()
    {
       unauthorise_permission('164','950');
        $this->load->model('inventory_company/inventory_company_archive_model','manuf_company_archive'); 

        $list = $this->manuf_company_archive->get_datatables();  
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        $total_num = count($list);
        foreach ($list as $manuf_company) {
         // print_r($unit);die;
            $no++;
            $row = array();
            if($manuf_company->status==1)
            {
                $status = '<font color="green">Active</font>';
            }   
            else{
                $status = '<font color="red">Inactive</font>';
            } 
            
            ////////// Check  List /////////////////
            $check_script = "";
            if($i==$total_num)
            {
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
            $row[] = '<input type="checkbox" name="employee[]" class="checklist" value="'.$manuf_company->id.'">'.$check_script; 
            $row[] = $manuf_company->company_name;  
            $row[] = $status;
            //$row[] = date('d-M-Y H:i A',strtotime($manuf_company->created_date)); 
           $users_data = $this->session->userdata('auth_users');

           $btnrestore='';
           $btndelete='';
         if(in_array('946',$users_data['permission']['action'])){
             $btnrestore = ' <a onClick="return restore_manuf_company('.$manuf_company->id.');" class="btn-custom" href="javascript:void(0)"  title="Restore"><i class="fa fa-window-restore" aria-hidden="true"></i> Restore </a>';      
         }
         if(in_array('946',$users_data['permission']['action'])){
      $btndelete = '<a onClick="return trash('.$manuf_company->id.');" class="btn-custom" href="javascript:void(0)" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>'; 
         }
             
          $row[] = $btndelete.$btnrestore;
            $data[] = $row;
            $i++;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->manuf_company_archive->count_all(),
                        "recordsFiltered" => $this->manuf_company_archive->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function restore($id="")
    {
        unauthorise_permission('164','947');
        $this->load->model('inventory_company/inventory_company_archive_model','manuf_company_archive');
       if(!empty($id) && $id>0)
       {
           $result = $this->manuf_company_archive->restore($id);
           $response = "Manufacturing company successfully restore in company list.";
           echo $response;
       }
    }

    function restoreall()
    { 
        unauthorise_permission('164','947');
        $this->load->model('inventory_company/inventory_company_archive_model','manuf_company_archive');
        $post = $this->input->post();  
        if(!empty($post))
        {
            $result = $this->manuf_company_archive->restoreall($post['row_id']);
            $response = "Manufacturing company successfully restore in company list.";
            echo $response;
        }
    }

    public function trash($id="")
    {
        unauthorise_permission('164','949');
        $this->load->model('inventory_company/inventory_company_archive_model','manuf_company_archive');
       if(!empty($id) && $id>0)
       {
           $result = $this->manuf_company_archive->trash($id);
           $response = "Manufacturing company successfully deleted parmanently.";
           echo $response;
       }
    }

    function trashall()
    {
        unauthorise_permission('164','949');
        $this->load->model('inventory_company/inventory_company_archive_model','manuf_company_archive');
        $post = $this->input->post();  
        if(!empty($post))
        {
            $result = $this->manuf_company_archive->trashall($post['row_id']);
            $response = "Manufacturing company successfully deleted parmanently.";
            echo $response;
        }
    }
    ///// employee Archive end  ///////////////

  public function manuf_company_dropdown()
  {
      $manuf_companylist = $this->manuf_company->manuf_company_list();
      $dropdown = '<option value="">Select Manufacturing Company Name</option>'; 
      if(!empty($manuf_companylist))
      {
        foreach($manuf_companylist as $company_list)
        {
           $dropdown .= '<option value="'.$company_list->id.'">'.$company_list->company_name.'</option>';
        }
      } 
      echo $dropdown; 
  }

}
?>