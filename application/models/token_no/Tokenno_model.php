<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tokenno_model extends CI_Model
{
    var $table = 'hms_token';
    var $column = array('hms_token.id', 'hms_token.token_no', 'hms_token.status', 'hms_token.patient_id');

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
        } else {
            return $result->token_no + 1;
        }
        //$this->session->unset_userdata('token_search');
    }
    public function _get_datatables_query()
    {
        $this->db->select("hms_token.token_no, hms_token.status, hms_token.patient_id, hms_patient.patient_name");
        $this->db->from("hms_token");
        $this->db->join('hms_patient', 'hms_patient.id = hms_token.patient_id', 'left');

        // Get today's date to filter records created today
        $today_date = date('Y-m-d');
        $this->db->where('DATE(hms_token.created_date)', $today_date);

        // Search functionality
        if (!empty($_POST['search']['value'])) {
            $search_value = $_POST['search']['value'];

            // Apply search filter for token_no and patient_name
            $this->db->group_start();  // Open parenthesis
            $this->db->like('hms_token.token_no', $search_value);
            $this->db->or_like('hms_patient.patient_name', $search_value);
            $this->db->group_end();  // Close parenthesis
        }

        // Ordering and limit for pagination
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('hms_token.id', 'desc');
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from('hms_token');
        return $this->db->count_all_results();
    }

    public function save($data)
    {
        $this->db->insert('hms_token', $data);

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