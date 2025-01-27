<?php
class Receipt_no_setting_model extends CI_Model 
{
	var $table = 'hospital_reciept_setting'; 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
 
	public function get_master_unique()
	{
		$user_data = $this->session->userdata('auth_users');
		$this->db->select('hospital_reciept_setting.*');
		
		$this->db->from('hospital_reciept_setting');
		$this->db->where('hospital_reciept_setting.branch_id',$user_data['parent_id']);  
		$query = $this->db->get(); 
		return $query->result();
	}
	
	public function save()
	{  
		$user_data = $this->session->userdata('auth_users');
		$post = $this->input->post();
		//print '<pre>'; print_r($post);die;
		if(!empty($post))
		{    
			$current_date = date('Y-m-d H:i:s');

			$this->db->where('branch_id',$user_data['parent_id']);
			
			$data = array(
                               "branch_id"=>$user_data['parent_id'],
                               "prefix"=>$post['prefix'],
                               "suffix"=>$post['suffix'],
                               "ip_address"=>$_SERVER['REMOTE_ADDR'],
                               "created_by"=>$user_data['id'], 
                               "created_date"=>$current_date
            		         );
			
           if(!empty($post['data_id']) && isset($post['data_id']))
             {
            	$this->db->update('hospital_reciept_setting',$data);
            }
            else
            {
            	$this->db->insert('hospital_reciept_setting',$data);
            }
		} 
	}
 
  
} 
?>