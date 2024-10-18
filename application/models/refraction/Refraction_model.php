<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Refraction_model extends CI_Model {

    var $table = 'hms_opd_refraction'; // Define the table name
    var $order = array('pres_id' => 'desc'); // Define the default order

    // Define the columns you want to retrieve from the table
    var $column = array(
        'hms_opd_refraction.id',
        'hms_opd_refraction.branch_id', // Added new column
        'hms_opd_refraction.booking_code', // Added new column
        'hms_opd_refraction.pres_id', 
        'hms_opd_refraction.patient_id', // Added new column
        'hms_opd_refraction.booking_id', 
        'hms_opd_refraction.auto_refraction', // Added new column
        'hms_opd_refraction.lens', // Added new column
        'hms_opd_refraction.comment', // Added new column
        'hms_opd_refraction.optometrist_signature', 
        'hms_opd_refraction.doctor_signature', 
        'hms_opd_refraction.status', // Added new column
        'hms_opd_refraction.is_deleted', // Added new column
        'hms_opd_refraction.deleted_by', // Added new column
        'hms_opd_refraction.deleted_date', // Added new column
        'hms_opd_refraction.ip_address', 
        'hms_opd_refraction.created_by', 
        'hms_opd_refraction.modified_by', 
        'hms_opd_refraction.modified_date', 
        'hms_opd_refraction.created_date'
    );


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	private function _get_datatables_query()
    {
        $this->db->select("hms_opd_refraction.*");
        $this->db->from($this->table);
        // $this->db->join($this->side_effects_table, 'hms_vision.side_effects = hms_side_effect.id', 'left'); // Join side effects
        $this->db->where('hms_opd_refraction.is_deleted', '0');

        $i = 0;
        // foreach ($this->column as $item) {
        //     if ($_POST['search']['value']) {
        //         if ($i === 0) {
        //             $this->db->group_start();
        //             $this->db->like($item, $_POST['search']['value']);
        //         } else {
        //             $this->db->or_like($item, $_POST['search']['value']);
        //         }

        //         if (count($this->column) - 1 == $i) {
        //             $this->db->group_end();
        //         }
        //     }
        //     $column[$i] = $item;
        //     $i++;
        // }

        if (isset($_POST['order'])) {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        // if ($_POST['length'] != -1) {
        //     $this->db->limit($_POST['length'], $_POST['start']);
        // }
        $query = $this->db->get();
        return $query->result();
    }

	public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

	public function get_by_id($id)
    {
        $this->db->select('hms_opd_refraction.*');
        $this->db->from($this->table);
        $this->db->where('hms_opd_refraction.id', $id);
        $this->db->where('hms_opd_refraction.is_deleted', '0');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function count_all()
    {
		$this->db->from($this->table);
        return $this->db->count_all_results();
    }
	
	public function get_patient_name_by_booking_id($booking_id)
    {
        // Join hms_std_eye_prescription with hms_patient, hms_token, and hms_patient_category to get all details
        $this->db->select('hms_std_eye_prescription.*, hms_patient.*, hms_token.token_no, hms_patient_category.patient_category'); // Select necessary columns including category_name
        $this->db->from('hms_std_eye_prescription');
        $this->db->join('hms_patient', 'hms_patient.id = hms_std_eye_prescription.patient_id', 'left');
        $this->db->join('hms_token', 'hms_token.patient_id = hms_patient.id', 'left'); // Join with hms_token on patient_id
        $this->db->join('hms_patient_category', 'hms_patient_category.id = hms_patient.patient_category', 'left'); // Join with hms_patient_category on patient_category
        $this->db->where('hms_std_eye_prescription.patient_id', $booking_id); // Filter by booking_id
        $this->db->where('hms_std_eye_prescription.is_deleted', '0'); // Check if not deleted

        $query = $this->db->get();
		// echo "<pre>";print_r($query);

        if ($query->num_rows() > 0) {
            return $query->row_array(); // Return all columns as an associative array including category_name
        }

        return null; // Return null if no patient is found
    }

    // Method to get prescription refraction details by booking ID and prescription ID
    public function get_prescription_refraction_new_by_id($booking_id = '', $presc_id = '')
    {
        $this->db->select('*');
        $this->db->from($this->table); // Use the defined table name
        $this->db->where('pres_id', $presc_id);
        $this->db->where('patient_id', $booking_id);
        
        $result = $this->db->get()->row_array();
        return $result; // Return the result as an associative array
    }

    // New method to fetch all non-deleted refractions
    public function get_all_refractions()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('is_deleted', 0); // Filter out deleted records
        $query = $this->db->get();
        return $query->result(); // Return the result as an array of objects
    }

    // Method to save or update a refraction record
    public function save($data)
    {
		// echo "<pre>";print_r($data);die('dsfsdfsf');
        // If a pres_id exists, update the record
        if (!empty($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update($this->table, $data);
        } else {
            // Otherwise, insert a new record
			// echo "<pre>";print_r($data);die;
            $this->db->insert($this->table, $data);
        }
    }

    // Method to delete a refraction record
    public function delete($pres_id = "")
    {
        if (!empty($pres_id)) {
            $this->db->set('is_deleted', 1);
            $this->db->where('pres_id', $pres_id);
            $this->db->update($this->table); // Update the record to mark it as deleted
        }
    }
}
