<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Refraction_model extends CI_Model
{

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
        'hms_opd_refraction.created_date',
        'hms_patient.patient_name',
        'hms_patient.mobile_no',
        'hms_patient.patient_code'
    );


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $search = $this->session->userdata('prescription_search');
        $this->db->select("hms_opd_refraction.id as refraction_id,hms_opd_refraction.*,hms_patient.*,hms_patient_category.patient_category as patient_category_name,hms_opd_booking.*,hms_doctors.doctor_name");
        $this->db->from($this->table);
        $this->db->join('hms_patient', 'hms_patient.id = hms_opd_refraction.patient_id', 'left');
        $this->db->join('hms_patient_category', 'hms_patient_category.id=hms_patient.patient_category', 'left');
        $this->db->join('hms_opd_booking', 'hms_opd_booking.id = hms_opd_refraction.booking_id', 'left');
        $this->db->join('hms_doctors', 'hms_doctors.id = hms_opd_booking.attended_doctor', 'left');
        // $this->db->join($this->side_effects_table, 'hms_vision.side_effects = hms_side_effect.id', 'left'); // Join side effects
        $this->db->where('hms_opd_refraction.is_deleted', '0');

        $i = 0;
        foreach ($this->column as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $column[$i] = $item;
            $i++;
        }
        if (!empty($search)) {

			if (!empty($search['start_date'])) {
				$start_date = date('Y-m-d 00:00:00', strtotime($search['start_date']));
				$this->db->where('hms_opd_refraction.created_date >=', $start_date);
			}

			if (!empty($search['end_date'])) {
				$end_date = date('Y-m-d 23:59:59', strtotime($search['end_date']));
				$this->db->where('hms_opd_refraction.created_date <=', $end_date);
			}

            if (!empty($search['priority_type']) && $search['priority_type'] !== '4') {
				$this->db->where('hms_patient.emergency_status', $search['priority_type']);
			} else if ($search['priority_type'] === '4') {				
				$this->db->where('hms_patient.emergency_status', NULL);
			}

			if (!empty($search['patient_name'])) {
				$this->db->like('hms_patient.patient_name', $search['patient_name'], 'after');
			}

			if (!empty($search['patient_code'])) {
				$this->db->where('hms_patient.patient_code', $search['patient_code']);
			}
            if (!empty($search['mobile_no'])) {
				$this->db->where('hms_patient.mobile_no', $search['mobile_no']);
			}
            if ($search['emergency_booking'] == "4") {
				$this->db->where('hms_opd_booking.opd_type', 1);
			} else if ($search['emergency_booking'] == "3") {
				$this->db->where('hms_opd_booking.opd_type', 0);
			}
		}
        if (isset($_POST['order'])) {
            // Order by the specified column and direction
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            // Default sorting: change here for custom default sorting
            $this->db->order_by('hms_opd_refraction.created_date', 'DESC');  // Custom default sort by created_date descending
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
        $this->db->select('hms_opd_refraction.*, hms_patient.*,hms_opd_booking.*');
        $this->db->from($this->table);
        $this->db->join('hms_patient', 'hms_patient.id = hms_opd_refraction.patient_id', 'left');
        $this->db->join('hms_opd_booking', 'hms_opd_booking.id = hms_opd_refraction.booking_id', 'left');
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
        if (!empty($data['id'])) {
            // For updates, remove the 'created_date' if present to avoid updating it
            unset($data['created_date']);
            
            // Update only the modified_date and other fields
            $data['modified_date'] = date('Y-m-d H:i:s'); // Set current time for modified_date
            $this->db->where('patient_id', $data['id']);
            $this->db->update('hms_opd_refraction', $data);
        } else {
            // Set the created_date for new records
            $data['created_date'] = date('Y-m-d H:i:s'); // Set current time for created_date
            $data['modified_date'] = date('Y-m-d H:i:s'); // Set current time for modified_date
            
            // Insert a new record
            $this->db->insert($this->table, $data);

            if (!empty($data['patient_id'])) {
                // Retrieve the current 'pat_status' value for the given patient
                $this->db->select('pat_status');
                $this->db->where('id', $data['patient_id']);
                $query = $this->db->get('hms_patient');
            
                if ($query->num_rows() > 0) {
                    $current_status = $query->row()->pat_status;
            
                    // Concatenate the current status with 'Low vision'
                    $new_status = $current_status . ', Refraction above 8 years';
                    // echo "<pre>";print_r($new_status);die;
            
                    // Update the 'pat_status' field with the concatenated value
                    $this->db->where('id', $data['patient_id']);
                    $this->db->update('hms_patient', ['pat_status' => $new_status]);
                }
            }
        }
    }

    public function get_booking_by_id($booking_id)
	{
        // echo $booking_id;die;
		// Select all fields from both tables
		$this->db->select('hms_opd_booking.*, hms_patient.*'); // Select all fields
		$this->db->from('hms_opd_booking'); // Start with the bookings table
		$this->db->join('hms_patient', 'hms_patient.id = hms_opd_booking.patient_id', 'left'); // Join with the patient table

		// Filter by the booking ID
		$this->db->where('hms_opd_booking.booking_code', $booking_id); // Assuming 'id' is the primary key for bookings
		$query = $this->db->get();

		// Check if any results were returned
		if ($query->num_rows() > 0) {
			return $query->row_array(); // Return the first result as an associative array
		}

		return null; // Return null if no data found
	}
    
    public function get_booking_byp_id($booking_id)
	{
        // echo $booking_id;die;
		// Select all fields from both tables
		$this->db->select('hms_opd_booking.*, hms_patient.*'); // Select all fields
		$this->db->from('hms_opd_booking'); // Start with the bookings table
		$this->db->join('hms_patient', 'hms_patient.id = hms_opd_booking.patient_id', 'left'); // Join with the patient table

		// Filter by the booking ID
		$this->db->where('hms_opd_booking.patient_id', $booking_id); // Assuming 'id' is the primary key for bookings
		$query = $this->db->get();

		// Check if any results were returned
		if ($query->num_rows() > 0) {
			return $query->row_array(); // Return the first result as an associative array
		}

		return null; // Return null if no data found
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
