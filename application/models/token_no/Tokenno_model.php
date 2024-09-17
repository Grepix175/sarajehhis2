<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tokenno_model extends CI_Model 
{
	var $table = 'hms_token';
	var $column = array('hms_token.id','hms_token.token_no','hms_token.status','hms_token.patient_id'); 

	var $order = array('id' => 'desc'); 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_token()
	{
        $this->db->select("hms_token.token_no");
        $this->db->from("hms_token");

        // Get today's date in the format you want (assuming 'created_date' is in 'Y-m-d' format)
        $today_date = date('Y-m-d');

        // Apply the WHERE condition to filter records created today
        $this->db->where('DATE(created_date)', $today_date);

        // Execute the query
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();

        // Fetch results
        // $result = $query->result();
        $result = $query->row();

        if (empty($result)) {
            return 1; // Return 1 if no results found
        }else{
            return $result->token_no+1;
        }
		//$this->session->unset_userdata('token_search');
	}

    public function save($data)
    {
        $this->db->insert('hms_token',$data);	
        
    }



	// function get_datatables()
	// {
	// 	$this->_get_datatables_query();		
	// 	if($_POST['length'] != -1)
	// 	$this->db->limit($_POST['length'], $_POST['start']);
	// 	$query = $this->db->get(); 
	// 	//echo $this->db->last_query();die();
	// 	return $query->result();
	// }

	     
} 
?>