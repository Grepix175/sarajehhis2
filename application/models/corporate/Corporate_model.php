<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Corporate_model extends CI_Model
{

	var $table = 'hms_corporate';
	var $column = array('hms_corporate.corporate_id', 'hms_corporate.corporate_name', 'hms_corporate.corporate_status', 'hms_corporate.created_date');
	var $order = array('corporate_id' => 'desc');

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
		$this->db->select("hms_corporate.*");
		$this->db->from($this->table);
		// $this->db->where('hms_corporate.is_deleted', '0');

		// $this->db->where('hms_corporate.branch_id', $users_data['parent_id']);

		$i = 0;

		foreach ($this->column as $item) // loop column 
		{
			if ($_POST['search']['value']) // if datatable send POST for search
			{

				if ($i === 0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND. 
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column) - 1 == $i) //last loop+
					$this->db->group_end(); //close bracket
			}
			$column[$i] = $item; // set column array variable to order processing
			$i++;
		}

		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();

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

	public function corporate_list()
	{
		$user_data = $this->session->userdata('auth_users');
		$this->db->select('*');
		// $this->db->where('branch_id', $user_data['parent_id']);
		$this->db->where('corporate_status', 1);
		// $this->db->where('is_deleted', 0);
		$this->db->order_by('corporate_id', 'ASC');
		$query = $this->db->get('hms_corporate');
		return $query->result();
	}

	public function get_by_id($id)
	{
		$this->db->select('hms_corporate.*');
		$this->db->from('hms_corporate');
		$this->db->where('hms_corporate.corporate_id', $id);
		// $this->db->where('hms_corporate.is_deleted', '0');
		$query = $this->db->get();
		return $query->row_array();
	}

	public function save()
	{
		$user_data = $this->session->userdata('auth_users');
		$post = $this->input->post();
		$data = array(
			// 'branch_id' => $user_data['parent_id'],
			'corporate_name' => $post['corporate_name'],
			'corporate_status' => $post['corporate_status'],

			// 'ip_address' => $_SERVER['REMOTE_ADDR']
		);
		if (!empty($post['data_id']) && $post['data_id'] > 0) {
			// $this->db->set('modified_by', $user_data['id']);
			// $this->db->set('modified_date', date('Y-m-d H:i:s'));
			$this->db->where('corporate_id', $post['data_id']);
			$this->db->update('hms_corporate', $data);
		} else {
			// $this->db->set('created_by', $user_data['id']);
			$this->db->set('created_date', date('Y-m-d H:i:s'));
			$this->db->insert('hms_corporate', $data);
		}
	}
	public function delete($id = "")
	{
		if (!empty($id) && $id > 0) {
			// Permanently delete the record from the database
			$this->db->where('corporate_id', $id);
			$this->db->delete('hms_corporate');
	
			// Optionally: check if the deletion was successful
			if($this->db->affected_rows() > 0) {
				return true; // Record successfully deleted
			} else {
				return false; // Failed to delete record
			}
		} else {
			return false; // Invalid ID
		}
	}
	

	public function deleteall($ids = array())
	{
		if (!empty($ids)) {

			$id_list = [];
			foreach ($ids as $id) {
				if (!empty($id) && $id > 0) {
					$id_list[] = $id;
				}
			}
			$branch_ids = implode(',', $id_list);
			$user_data = $this->session->userdata('auth_users');
			// $this->db->set('is_deleted', 1);
			// $this->db->set('deleted_by', $user_data['id']);
			// $this->db->set('deleted_date', date('Y-m-d H:i:s'));
			$this->db->where('corporate_id IN (' . $branch_ids . ')');
			$this->db->delete('hms_corporate');
			//echo $this->db->last_query();die;
		}
	}

}
?>