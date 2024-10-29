<?php
class Menu_model extends CI_Model 
{
	var $table = 'hms_prescription_setting'; 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
 
	public function get_master_menu($parent_id = '0')
  {
    $user_data = $this->session->userdata('auth_users');
    
    $this->db->select('hms_branch_menu.*');
    $this->db->from('hms_branch_menu'); 
    $this->db->where('hms_branch_menu.parent_id', $parent_id);
    $this->db->where('hms_branch_menu.branch_id', $user_data['parent_id']); 
    $this->db->where('hms_branch_menu.status', '1'); // Check for active status
    $this->db->order_by('sort_order', 'ASC'); 

    $query = $this->db->get();
    //echo $this->db->last_query();
    
    return $query->result();
  }

	
	public function save()
  {  
      $user_data = $this->session->userdata('auth_users');
      $post = $this->input->post(); 
      // echo 'Current max_input_vars: ' . ini_get('max_input_vars');

      // echo "<pre>";print_r(count($post['data']));die;

      if (!empty($post['data'])) {    
          $current_date = date('Y-m-d H:i:s');

          foreach ($post['data'] as $key => $val) {
              // Ensure that 'parent_id', 'name', 'sort_order', and 'id' keys are set before using them
              $parent_id = isset($val['parent_id']) ? $val['parent_id'] : null;
              $name = isset($val['name']) ? $val['name'] : null;
              $sort_order = isset($val['sort_order']) ? $val['sort_order'] : null;
              $id = isset($val['id']) ? $val['id'] : null;

              // Only proceed if essential values are present
              if (!is_null($parent_id) && !is_null($name) && !is_null($sort_order) && !is_null($id)) {
                  $data = array(
                      "branch_id" => $user_data['parent_id'],
                      "parent_id" => $parent_id,
                      "name" => $name,
                      "status" => 1,
                      'sort_order' => $sort_order,
                      "ip_address" => $_SERVER['REMOTE_ADDR'],
                      "created_by" => $user_data['id'], 
                      "created_date" => $current_date
                  );
                  
                  // Perform the update
                  $this->db->where('id', $id);
                  $this->db->where('branch_id', $user_data['parent_id']);
                  $this->db->update('hms_branch_menu', $data);
              }
          }
      }
  }
 
  public function get_sub_master_menu($parent_id='0')
  {
    $user_data = $this->session->userdata('auth_users');
    $this->db->select('hms_branch_menu.*');
    $this->db->from('hms_branch_menu'); 
    $this->db->where('hms_branch_menu.parent_id',$parent_id);
    $this->db->where('hms_branch_menu.branch_id',$user_data['parent_id']);
    $this->db->where('hms_branch_menu.status','1'); 
    $this->db->order_by('hms_branch_menu.sort_order','ASC'); 
    $query = $this->db->get();
    //echo $this->db->last_query();
    return $query->result();
  }

    public function get_hms_prescription_page()
    {
    	$this->db->select('page_data');  
        $query = $this->db->get('hms_prescription_page');
        $result = $query->row();
        $data='';
        if(!empty($result))
        {
        	$data = $result->page_data;
        }
        return $data;
    } 
} 
?>