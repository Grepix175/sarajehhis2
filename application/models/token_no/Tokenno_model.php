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

        if (empty($result) || !is_numeric($result->token_no)) {
            return 1; // Return 1 if no results found or token_no is not numeric
        } else {
            return (int)$result->token_no + 1; // Cast token_no to integer before adding
        }
        //$this->session->unset_userdata('token_search');
    }
    public function _get_datatables_query()
    {
        $this->db->select("hms_token.token_no, hms_token.status, hms_token.patient_id, hms_patient.patient_name,hms_patient.patient_code, hms_token.created_date, hms_patient.emergency_status");
        $this->db->from("hms_token");
        $this->db->join('hms_patient', 'hms_patient.id = hms_token.patient_id', 'left');

        // Get filter criteria from session (date range and status)
        $opd_search = $this->session->userdata('token_search');
        // echo "<pre>";
        // print_r($opd_search);
        // die;
        // Check if any filters are applied (status or date range)
        if (!empty($opd_search['from_date']) || !empty($opd_search['to_date'])) {

            // Apply date filter if provided
            if (!empty($opd_search['from_date']) && !empty($opd_search['to_date'])) {
                $start_date = date('Y-m-d 00:00:00', strtotime($opd_search['from_date']));
                $end_date = date('Y-m-d 23:59:59', strtotime($opd_search['to_date']));
                $this->db->where('DATE(hms_token.created_date) >=', $start_date);
                $this->db->where('DATE(hms_token.created_date) <=', $end_date);
            } elseif (!empty($opd_search['from_date'])) {
                $start_date = date('Y-m-d 00:00:00', strtotime($opd_search['from_date']));
                $this->db->where('DATE(hms_token.created_date) >=', $start_date);
            } elseif (!empty($opd_search['to_date'])) {
                $end_date = date('Y-m-d 23:59:59', strtotime($opd_search['to_date']));
                $this->db->where('DATE(hms_token.created_date) <=', $end_date);
            }

            // Apply status filter if provided
            if (!empty($opd_search['search_type'])) {
                $this->db->where('hms_token.status', $opd_search['search_type']);
            }

        }
        //  else {
        //     if (!empty($opd_search['search_type'])) {
        //         $this->db->where('hms_token.status', $opd_search['search_type']);
        //     }
        //     // If no filters are applied, default to today's date and only pending records (status = 1)
        //     $today_date = date('Y-m-d');
        //     $this->db->where('DATE(hms_token.created_date)', $today_date);
        //     $this->db->where('hms_token.status', 1);  // Pending status
        // }

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


    public function set_filter_criteria($criteria)
    {
        if (!empty($criteria)) {
            // Apply status filter
            if (!empty($criteria['search_type'])) {
                $this->db->where('hms_token.status', $criteria['search_type']);
            }
            if (!empty($criteria['priority_type']) && $criteria['priority_type'] !== '4') {
                $this->db->where('hms_patient.emergency_status', $criteria['priority_type']);
            }else if ($criteria['priority_type'] === '4') {				
				$this->db->where('hms_patient.emergency_status', NULL);
			}

            // Apply date filter
            // if (!empty($criteria['from_date']) && !empty($criteria['to_date'])) {
            //     $this->db->where('DATE(hms_token.created_date) >=', $criteria['from_date']);
            //     $this->db->where('DATE(hms_token.created_date) <=', $criteria['to_date']);
            // } elseif (!empty($criteria['from_date'])) {
            //     $this->db->where('DATE(hms_token.created_date) >=', $criteria['from_date']);
            // } elseif (!empty($criteria['to_date'])) {
            //     $this->db->where('DATE(hms_token.created_date) <=', $criteria['to_date']);
            // }
            if (!empty($opd_search['from_date']) && !empty($opd_search['to_date'])) {
                $start_date = date('Y-m-d 00:00:00', strtotime($opd_search['from_date']));
                $end_date = date('Y-m-d 23:59:59', strtotime($opd_search['to_date']));
                $this->db->where('DATE(hms_token.created_date) >=', $start_date);
                $this->db->where('DATE(hms_token.created_date) <=', $end_date);
            } elseif (!empty($opd_search['from_date'])) {
                $start_date = date('Y-m-d 00:00:00', strtotime($opd_search['from_date']));
                $this->db->where('DATE(hms_token.created_date) >=', $start_date);
            } elseif (!empty($opd_search['to_date'])) {
                $end_date = date('Y-m-d 23:59:59', strtotime($opd_search['to_date']));
                $this->db->where('DATE(hms_token.created_date) <=', $end_date);
            }
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

    function search_patient_data()
    {

        $opd_search = $this->session->userdata('token_search');
        $this->db->select("hms_token.token_no, hms_token.status, hms_token.patient_id, hms_patient.patient_name,hms_patient.patient_code,hms_patient.mobile_no, hms_token.created_date");
        $this->db->from("hms_token");
        $this->db->join('hms_patient', 'hms_patient.id = hms_token.patient_id', 'left');

        if (!empty($opd_search['from_date']) || !empty($opd_search['to_date'])) {

            // Apply date filter if provided
            if (!empty($opd_search['from_date']) && !empty($opd_search['to_date'])) {
                $this->db->where('DATE(hms_token.created_date) >=', $opd_search['from_date']);
                $this->db->where('DATE(hms_token.created_date) <=', $opd_search['to_date']);
            } elseif (!empty($opd_search['from_date'])) {
                $this->db->where('DATE(hms_token.created_date) >=', $opd_search['from_date']);
            } elseif (!empty($opd_search['to_date'])) {
                $this->db->where('DATE(hms_token.created_date) <=', $opd_search['to_date']);
            }

            // Apply status filter if provided
            if (!empty($opd_search['search_type'])) {
                $this->db->where('hms_token.status', $opd_search['search_type']);
            }

        } else {
            if (!empty($opd_search['search_type'])) {
                $this->db->where('.status', $opd_search['search_type']);
            }
            // If no filters are applied, default to today's date and only pending records (status = 1)
            $today_date = date('Y-m-d');
            $this->db->where('DATE(hms_token.created_date)', $today_date);
            $this->db->where('hms_token.status', 1);  // Pending status
        }

        $this->db->order_by('hms_token.id', 'desc');
        $query = $this->db->get();
        // echo $this->db->last_query();
        $data = $query->result();

        return $data;
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