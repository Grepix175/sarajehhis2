<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visitor_archive_model extends CI_Model {

	var $table = 'hms_visitor';
	// 	'hms_patient.village',
	var $column = array('hms_visitor.id', 'hms_visitor.branch_id', 'hms_visitor.visitor_type_id', 'hms_visitor.from', 'hms_visitor.visitor_name', 'hms_visitor.mobile_no', 'hms_visitor.purpose', 'hms_visitor.emp_id', 'hms_visitor.created_date','hms_visitor.simulation_id','hms_visitor.is_deleted');
	var $order = array('id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	private function _get_datatables_query()
	{
		$user_data = $this->session->userdata('auth_users');
		// print_r($user_data);die;
		// changes by Nitin sharma 04/02/2024
		$this->db->select("hms_visitor.id, 
				   hms_visitor.branch_id,
                   hms_visitor.visitor_type_id, 
                   hms_visitor.from, 
                   hms_visitor.visitor_name, 
                   hms_visitor.mobile_no, 
                   hms_visitor.purpose, 
                   hms_visitor.is_deleted, 
                   hms_visitor.created_date, 
                   hms_visitor.emp_id,
                   hms_visitor_type.visitor_type as visitor_type_name,
                   hms_employees.name as employee_name");

		// $this->db->from('hms_visitor');
		$this->db->where('hms_visitor.is_deleted', '1'); 
		$this->db->join('hms_visitor_type', 'hms_visitor_type.id = hms_visitor.visitor_type_id', 'left');
		$this->db->join('hms_employees', 'hms_employees.id = hms_visitor.emp_id', 'left');
		// $this->db->where('hms_visitor_type.is_deleted', '1'); 
		// $this->db->where('hms_visitor.branch_id = "'.$user_data['parent_id'].'"'); 
		$this->db->from($this->table); 
		$i = 0;
	
		foreach ($this->column as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND. 
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column) - 1 == $i) //last loop+
					$this->db->group_end(); //close bracket
			}
			$column[$i] = $item; // set column array variable to order processing
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get(); 
		// echo $this->db->last_query();die;
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function restore($id="")
    {
    	if(!empty($id) && $id>0)
    	{
			$user_data = $this->session->userdata('auth_users');
			$this->db->set('is_deleted',0);
			$this->db->set('deleted_by',$user_data['id']);
			$this->db->set('deleted_date',date('Y-m-d H:i:s'));
			$this->db->where('id',$id);
			$this->db->update('hms_visitor');
    	} 
    }

    public function restoreall($ids=array())
    {
    	if(!empty($ids))
    	{
    		$id_list = [];
    		foreach($ids as $id)
    		{
    			if(!empty($id) && $id>0)
    			{
                  $id_list[]  = $id;
    			} 
    		}
    		$branch_ids = implode(',', $id_list);
			$user_data = $this->session->userdata('auth_users');
			$this->db->set('is_deleted',0);
			$this->db->set('deleted_by',$user_data['id']);
			$this->db->set('deleted_date',date('Y-m-d H:i:s'));
			$this->db->where('id IN ('.$branch_ids.')');
			$this->db->update('hms_visitor');

    	} 
    }

    public function trash($id="")
    {
    	if(!empty($id) && $id>0)
    	{  
			/*$this->db->select('*');  
			$this->db->where('id',$id);
			$query = $this->db->get('hms_patient');
			$result = $query->result();
			if(!empty($result))
			{
			  if(!empty($result[0]->photo))
			  {
			  	unlink(DIR_UPLOAD_PATH.'patients/'.$result[0]->photo);
			  }	
                          $this->db->where('id',$id);
			  $this->db->delete('hms_patient');
			} */ 
			$user_data = $this->session->userdata('auth_users');
			$this->db->set('is_deleted',2);
			$this->db->set('deleted_by',$user_data['id']);
			$this->db->set('deleted_date',date('Y-m-d H:i:s'));
			$this->db->where('id',$id);
			$this->db->update('hms_visitor');
    	} 
    }

    public function trashall($ids=array())
    {
   //  	if(!empty($ids))
   //  	{
   //  		$id_list = [];
   //  		foreach($ids as $id)
   //  		{
   //  			if(!empty($id) && $id>0)
   //  			{
   //                $id_list[]  = $id;
   //  			} 
   //  		}
   //  		$branch_ids = implode(',', $id_list); 
			// $this->db->where('id IN ('.$branch_ids.')');
			// //$this->db->delete('hms_doctors');
   //  	} 
    	if(!empty($ids))
    	{
    		$id_list = [];
    		foreach($ids as $id)
    		{
    			if(!empty($id) && $id>0)
    			{
                  $id_list[]  = $id;
    			} 
    		}
    		$branch_ids = implode(',', $id_list); 
		    $user_data = $this->session->userdata('auth_users');
			$this->db->set('is_deleted',2);
			$this->db->set('deleted_by',$user_data['id']);
			$this->db->set('deleted_date',date('Y-m-d H:i:s'));
			$this->db->where('id IN ('.$branch_ids.')');
			$this->db->update('hms_visitor');
    	}  
    }
 

}
?>