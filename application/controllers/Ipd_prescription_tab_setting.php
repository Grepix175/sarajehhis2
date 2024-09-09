<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ipd_prescription_tab_setting extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        auth_users();
        
        $this->load->model('ipd_prescription_tab_setting/prescription_tab_setting_model','prescriptiontabsetting');
        $this->load->library('form_validation');
    }

    public function index()
    {
       unauthorise_permission(121,733);
        $data['page_title'] = 'Prescription Tab Settings'; 
        $post = $this->input->post();

        if(!empty($post))
        { 
            $this->prescriptiontabsetting->save();
            echo 'Your Prescription Tab Settings successfully updated.';;
            return false;
        }
        $data['prescription_tab_setting_list'] = $this->prescriptiontabsetting->get_master_unique();
        $this->load->view('ipd_prescription_tab_setting/add',$data);
    } 
      
   
}
?>