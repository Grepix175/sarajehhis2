<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Insurance_type_model extends CI_Model {

	var $table = 'hms_insurance_type';
	var $column = array('hms_insurance_type.id','hms_insurance_type.insurance_type', 'hms_insurance_type.status','hms_insurance_type.created_date');  
	var $order = array('id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
        $users_data = $this->session->userdata('auth_users');
          $parent_branch_details = $this->session->userdata('parent_branches_data');
         $sub_branch_details = $this->session->userdata('sub_branches_data');
		$this->db->select("hms_insurance_type.*"); 
		$this->db->from($this->table); 
        $this->db->where('hms_insurance_type.is_deleted','0');
       
            $this->db->where('hms_insurance_type.branch_id',$users_data['parent_id']);
		
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
		//echo $this->db->last_query();die;
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
    
    public function insurance_type_list()
    {
    	$user_data = $this->session->userdata('auth_users');
    	$this->db->select('*');
    	$this->db->where('branch_id',$user_data['parent_id']);
    	$this->db->where('status',1); 
    	$this->db->where('is_deleted',0); 
    	$this->db->order_by('insurance_type','ASC'); 
    	$query = $this->db->get('hms_insurance_type');
		return $query->result();
    }

	public function get_by_id($id)
	{
		$this->db->select('hms_insurance_type.*');
		$this->db->from('hms_insurance_type'); 
		$this->db->where('hms_insurance_type.id',$id);
		$this->db->where('hms_insurance_type.is_deleted','0');
		$query = $this->db->get(); 
		return $query->row_array();
	}
	
	public function save()
	{
		$user_data = $this->session->userdata('auth_users');
		$post = $this->input->post();  
		$data = array( 
					'branch_id'=>$user_data['parent_id'],
					'insurance_type'=>$post['insurance_type'],
					'status'=>$post['status'],
					'ip_address'=>$_SERVER['REMOTE_ADDR']
		         );
		if(!empty($post['data_id']) && $post['data_id']>0)
		{    
            $this->db->set('modified_by',$user_data['id']);
			$this->db->set('modified_date',date('Y-m-d H:i:s'));
            $this->db->where('id',$post['data_id']);
			$this->db->update('hms_insurance_type',$data);  
		}
		else{    
			$this->db->set('created_by',$user_data['id']);
			$this->db->set('created_date',date('Y-m-d H:i:s'));
			$this->db->insert('hms_insurance_type',$data);               
		} 	
	}

    public function delete($id="")
    {
    	if(!empty($id) && $id>0)
    	{

			$user_data = $this->session->userdata('auth_users');
			$this->db->set('is_deleted',1);
			$this->db->set('deleted_by',$user_data['id']);
			$this->db->set('deleted_date',date('Y-m-d H:i:s'));
			$this->db->where('id',$id);
			$this->db->update('hms_insurance_type');
			//echo $this->db->last_query();die;
    	} 
    }

    public function deleteall($ids=array())
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
			$this->db->set('is_deleted',1);
			$this->db->set('deleted_by',$user_data['id']);
			$this->db->set('deleted_date',date('Y-m-d H:i:s'));
			$this->db->where('id IN ('.$branch_ids.')');
			$this->db->update('hms_insurance_type');
			//echo $this->db->last_query();die;
    	} 
    }
    
    public function save_all_insurance($insurance_all_data = array())
	{
		

		//echo "hello";echo "<pre>";print_r($insurance_all_data); //$patient_data['relation_type']
 		$users_data = $this->session->userdata('auth_users');
        if(!empty($insurance_all_data))
        {
            foreach($insurance_all_data as $insurance_data)
            {
            	//print_r($doctor_data);
            	if(!empty($insurance_data['insurance_type']))
            	{
				
          
				$insurance_data_array = array( 
				        'branch_id'=>$users_data['parent_id'],
	                    'insurance_type'=>$insurance_data['insurance_type'],
						'status'=>1,					
	                    'ip_address'=>$_SERVER['REMOTE_ADDR'],
                        'created_date'=>date('Y-m-d H:i:s'),
				        'modified_date'=>date('Y-m-d H:i:s'),
				        'created_by'=>$users_data['parent_id']
				        
				    );

                //print_r($vaccination_data_array);
				    $this->db->insert('hms_insurance_type',$insurance_data_array);
	                //echo $this->db->last_query(); exit;
	            }
            }   	
        }
	}
     
public function check_unique_value($branch_id, $insurance_type, $id='')
    {
    	$this->db->select('hms_insurance_type.*');
		$this->db->from('hms_insurance_type'); 
		$this->db->where('hms_insurance_type.branch_id',$branch_id);
		$this->db->where('hms_insurance_type.insurance_type',$insurance_type);
		if(!empty($id))
		$this->db->where('hms_insurance_type.id !=',$id);
		$this->db->where('hms_insurance_type.is_deleted','0');
		$query = $this->db->get(); 
		//echo $this->db->last_query();die;
		$result=$query->row_array();
		if(!empty($result))
		{
			return 1;
		}
		else{
			return 0;
		}
    }


}
?>