<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ortho_ptics_model extends CI_Model
{

    var $table = 'hms_ortho_ptics'; // Define the table name
    var $order = array('pres_id' => 'desc'); // Define the default order

    // Define the columns you want to retrieve from the table
    var $column = array(
        'hms_ortho_ptics.id',
        'hms_ortho_ptics.branch_id', 
        'hms_ortho_ptics.booking_code', 
        'hms_ortho_ptics.pres_id',
        'hms_ortho_ptics.patient_id', 
        'hms_ortho_ptics.booking_id',
        'hms_ortho_ptics.main_complaints',
        'hms_ortho_ptics.hours_of_work_computer',
        'hms_ortho_ptics.associated_symptoms',
        'hms_ortho_ptics.previ_his_of_ortho',
        'hms_ortho_ptics.gene_heal_medi_deta',
        'hms_ortho_ptics.remarks',
        'hms_ortho_ptics.refraction_tbl',
        'hms_ortho_ptics.medical_history',
        'hms_ortho_ptics.addi_test',
        'hms_ortho_ptics.deta_rega_adap',
        'hms_ortho_ptics.stere_with_rando_stere',
        'hms_ortho_ptics.motor_evaluation',
        'hms_ortho_ptics.senso_evalu',
        'hms_ortho_ptics.eom_tbl',
        'hms_ortho_ptics.wfdt_tbl',
        'hms_ortho_ptics.distance_ipd',
        'hms_ortho_ptics.ac_a_ratio',
        'hms_ortho_ptics.heterophoria_method',
        'hms_ortho_ptics.status', 
        'hms_ortho_ptics.is_deleted', 
        'hms_ortho_ptics.deleted_by', 
        'hms_ortho_ptics.deleted_date', 
        'hms_ortho_ptics.ip_address',
        'hms_ortho_ptics.created_by',
        'hms_ortho_ptics.modified_by',
        'hms_ortho_ptics.modified_date',
        'hms_ortho_ptics.created_date',
        'hms_patient.patient_name', // Assuming patient information is coming from a related table
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
        
        // Use DISTINCT to avoid duplicate rows
        $this->db->distinct();
        
        // Select relevant columns (including hms_ortho_ptics and related tables)
        $this->db->select("hms_ortho_ptics.id as refraction_id, hms_ortho_ptics.*, hms_patient.*, hms_patient_category.patient_category as patient_category_name, hms_opd_booking.*, hms_doctors.doctor_name, hms_opd_booking.token_no as token, hms_patient.emergency_status, hms_ortho_ptics.created_date as created");
        
        $this->db->from($this->table);
        
        // Joining tables
        $this->db->join('hms_patient', 'hms_patient.id = hms_ortho_ptics.patient_id', 'left');
        $this->db->join('hms_patient_category', 'hms_patient_category.id = hms_patient.patient_category', 'left');
        // $this->db->join('hms_opd_booking', 'hms_opd_booking.booking_code = hms_ortho_ptics.booking_id', 'left');
        $this->db->join('hms_opd_booking', 'hms_opd_booking.id = hms_ortho_ptics.booking_id', 'left');
        $this->db->join('hms_doctors', 'hms_doctors.id = hms_opd_booking.attended_doctor', 'left');
        
        // Filter deleted entries
        $this->db->where('hms_ortho_ptics.is_deleted', '0');
        
        // Group by to prevent duplicate rows
        $this->db->group_by('hms_ortho_ptics.id');

        $this->db->order_by('hms_ortho_ptics.created_date', 'DESC');
        
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
            // Additional filters based on search
            if (!empty($search['start_date'])) {
                $start_date = date('Y-m-d 00:00:00', strtotime($search['start_date']));
                $this->db->where('hms_ortho_ptics.created_date >=', $start_date);
                $this->db->where('hms_opd_booking.created_date >=', $start_date);
            }

            if (!empty($search['end_date'])) {
                $end_date = date('Y-m-d 23:59:59', strtotime($search['end_date']));
                $this->db->where('hms_ortho_ptics.created_date <=', $end_date);
                $this->db->where('hms_opd_booking.created_date <=', $end_date);
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

            // Additional filters for the new fields (if applicable)
            if (!empty($search['chief_complaints'])) {
                $this->db->like('hms_ortho_ptics.chief_complaints', $search['chief_complaints']);
            }

            if (!empty($search['squint_history'])) {
                $this->db->like('hms_ortho_ptics.squint_history', $search['squint_history']);
            }

            if (!empty($search['remarks'])) {
                $this->db->like('hms_ortho_ptics.remarks', $search['remarks']);
            }
            if ($search['emergency_booking'] == "4") {
				$this->db->where('hms_opd_booking.opd_type', 1);
			} else if ($search['emergency_booking'] == "3") {
				$this->db->where('hms_opd_booking.opd_type', 0);
			}
        }

        // Handle ordering from DataTables or default ordering
        if (isset($_POST['order'])) {
            // Order by the specified column and direction
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            // Default sorting: change here for custom default sorting
            $this->db->order_by('hms_ortho_ptics.created_date', 'DESC');  // Custom default sort by created_date descending
        }
    }



    public function get_datatables()
    {
        // Call the query builder method
        $this->_get_datatables_query();

        // Execute the query
        $query = $this->db->get();
       
        // Display the last executed query for debugging

        // Return the query results as usual
        // echo "<pre>";
        // print_r($query->result());
        // die('sagar');
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
        // echo $id;die;
        $this->db->select('hms_ortho_ptics.*, hms_patient.*');
        $this->db->from($this->table);
        $this->db->join('hms_patient', 'hms_patient.id = hms_ortho_ptics.patient_id', 'left');
        $this->db->where('hms_ortho_ptics.id', $id);
        $this->db->where('hms_ortho_ptics.is_deleted', '0');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_ortho_by_booking_id($booking_id,$patient_id)
    {
       
        // Select fields from hms_ortho_ptics and hms_patient
        $this->db->select('hms_ortho_ptics.*, hms_patient.*');
        $this->db->from($this->table);
        $this->db->join('hms_patient', 'hms_patient.id = hms_ortho_ptics.patient_id', 'left');
        $this->db->where('hms_ortho_ptics.booking_id', $booking_id);
        $this->db->where('hms_ortho_ptics.patient_id', $patient_id);
        $this->db->where('hms_ortho_ptics.is_deleted', '0');
        $query = $this->db->get();
//         // Print the result set
// echo "<pre>";
// print_r($query->result_array()); // Use result_array() to print as an array
// die;
        // Check if the query returns any row
        if ($query->num_rows() > 0) {
            return true; // Record found
        } else {
            return false; // No record found
        }
    }


    public function get_chief_complaints_by_patient_id($booking_id)
    {
        // echo $booking_id;die;
        // Select the chief_complaints field from hms_std_eye_prescription_history
        $this->db->select('chief_complaints');
        $this->db->from('hms_std_eye_prescription_history');
        
        // Filter by the given patient_id
        $this->db->where('booking_id', $booking_id);
        
        // Fetch the result
        $query = $this->db->get();
        
        // Return the result as a single row (since patient_id is unique)
        return $query->row_array(); // Will return only the chief_complaints field in the array
    }
    public function get_chief_complaints_by_booking_id($booking_id)
    {
        // echo $booking_id;die;
        // Select the chief_complaints field from hms_std_eye_prescription_history
        $this->db->select('chief_complaints');
        $this->db->from('hms_std_eye_prescription_history');
        
        // Filter by the given patient_id
        $this->db->where('booking_code', $booking_id);
        
        // Fetch the result
        $query = $this->db->get();
        
        // Return the result as a single row (since patient_id is unique)
        return $query->row_array(); // Will return only the chief_complaints field in the array
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
            // echo "ok";die;
			$branch_ids = implode(',', $id_list);
            // echo "<pre>";print_r($branch_ids);die;
			$user_data = $this->session->userdata('auth_users');
			$this->db->set('is_deleted', 1);
			$this->db->set('deleted_by', $user_data['id']);
			$this->db->set('deleted_date', date('Y-m-d H:i:s'));
			$this->db->where('id IN (' . $branch_ids . ')');
			$this->db->update('hms_ortho_ptics');
		}
	}

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_patient_name_by_booking_id($booking_id)
    {
        // echo $booking_id;
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

    public function get_bookings_by_id($booking_id)
	{
        // echo $booking_id;die;
		// Select all fields from both tables
		$this->db->select('hms_opd_booking.id as opd_id,hms_opd_booking.*, hms_patient.*'); // Select all fields
		$this->db->from('hms_opd_booking'); // Start with the bookings table
		$this->db->join('hms_patient', 'hms_patient.id = hms_opd_booking.patient_id', 'left'); // Join with the patient table

		// Filter by the booking ID
		$this->db->where('hms_opd_booking.id', $booking_id); // Assuming 'id' is the primary key for bookings
		$query = $this->db->get();

		// Check if any results were returned
		if ($query->num_rows() > 0) {
			return $query->row_array(); // Return the first result as an associative array
		}

		return null; // Return null if no data found
	}

    public function get_booking_by_id($booking_id,$patient_id)
	{
        // echo $booking_id,$patient_id;die;
		// Select all fields from both tables
		$this->db->select('hms_opd_booking.*, hms_patient.*'); // Select all fields
		$this->db->from('hms_opd_booking'); // Start with the bookings table
		$this->db->join('hms_patient', 'hms_patient.id = hms_opd_booking.patient_id', 'left'); // Join with the patient table

		// Filter by the booking ID
		$this->db->where('hms_opd_booking.id', $booking_id); // Assuming 'id' is the primary key for bookings
		$this->db->where('hms_opd_booking.patient_id', $patient_id); // Assuming 'id' is the primary key for bookings
		$query = $this->db->get();

		// Check if any results were returned
		if ($query->num_rows() > 0) {
			return $query->row_array(); // Return the first result as an associative array
		}

		return null; // Return null if no data found
	}

    // Method to save or update a refraction record
    public function save($data)
    {
        // Debugging prints (remove in production)
        // echo "<br>"; print_r($data); die;

        // Start a transaction to ensure atomic operations
        $this->db->trans_start();

        // Check if data has an 'id' field for update operation
        if (!empty($data['id'])) {
            // Do not update the created_date field when updating the record
            if (isset($data['created_date'])) {
                unset($data['created_date']);
            }
        
            // Update the existing record in hms_ortho_ptics table
            $this->db->where('id', $data['id']);
            if (!$this->db->update($this->table, $data)) {
                // If update fails, log the error and rollback
                log_message('error', 'Failed to update record in ' . $this->table . ': ' . $this->db->last_query());
                $this->db->trans_rollback();
                return false; // Return false if update fails
            }
        } else {
            // Insert new record into hms_ortho_ptics table
            if (!$this->db->insert($this->table, $data)) {
                // If insert fails, log the error and rollback
                log_message('error', 'Failed to insert record in ' . $this->table . ': ' . $this->db->last_query());
                $this->db->trans_rollback();
                return false; // Return false if insert fails
            }
            if (!empty($data['patient_id'])) {
                // echo "Ok";die;
                // Retrieve the current 'pat_status' value for the given patient
                $this->db->select('pat_status');
                $this->db->where('id', $data['patient_id']);
                $query = $this->db->get('hms_patient');
                
                if ($query->num_rows() > 0) {
                    $current_status = $query->row()->pat_status;
            
                    // Concatenate the current status with the new status (e.g., 'Low vision')
                    $new_status = $current_status . ', ' . 'Ortho Paedic';
            
                    // Update the 'pat_status' field with the concatenated value
                    $this->db->where('id', $data['patient_id']);
                    $this->db->update('hms_patient', ['pat_status' => $new_status]);
                }
            }
        }
        // echo $data['patient_id'];die;

        

        // Now, update the chief_complaints in the hms_std_eye_prescription_history table
        if (!empty($chief_complaints)) {
            // Assuming $chief_complaints is an array or a single value to be updated
            // Update the 'chief_complaints' in hms_std_eye_prescription_history
            $update_data = [
                'chief_complaints' => $chief_complaints
            ];
            // Update query for the appropriate record in hms_std_eye_prescription_history table
            // Assuming 'patient_id' or some other identifying field is available
            $this->db->where('patient_id', $data['patient_id']);
            if (!$this->db->update('hms_std_eye_prescription_history', $update_data)) {
                // If update fails, log the error and rollback
                log_message('error', 'Failed to update chief_complaints in hms_std_eye_prescription_history: ' . $this->db->last_query());
                $this->db->trans_rollback();
                return false; // Return false if the update fails
            }
        }

        // Commit the transaction
        $this->db->trans_complete();

        // Check if the transaction was successful
        if ($this->db->trans_status() === FALSE) {
            // If the transaction failed, return false
            return false;
        }

        return true; // Return true if all operations were successful
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

    public function search_report_data($booking_id = '', $id = '')
    {
        $this->db->select("
            hms_ortho_ptics.id AS low_vision_id,           
            hms_ortho_ptics.*,
            hms_patient.simulation_id,
            hms_patient.patient_code,
            hms_patient.gender,
            hms_patient.mobile_no,
            hms_patient.age_y,
            hms_patient.age_m,
            hms_patient.age_d,
            hms_opd_booking.dilate_status,
            hms_opd_booking.app_type,
            hms_opd_booking.token_no,
            hms_opd_booking.booking_code,
            hms_std_eye_prescription_history.chief_complaints,
            hms_doctors.doctor_name
        ");

        // From hms_ortho_ptics table
        $this->db->from('hms_ortho_ptics');

        // Join with hms_patient table
        $this->db->join('hms_patient', 'hms_patient.id = hms_ortho_ptics.patient_id', 'left');

        // Join with hms_opd_booking table
        $this->db->join('hms_opd_booking', 'hms_opd_booking.id = hms_ortho_ptics.booking_id', 'left');

        // Join with hms_std_eye_prescription_history to get chief_complaints
        $this->db->join('hms_std_eye_prescription_history', 'hms_std_eye_prescription_history.patient_id = hms_ortho_ptics.patient_id', 'left');

        $this->db->join('hms_doctors', 'hms_doctors.id = hms_ortho_ptics.referred_by', 'left');

        // Apply filters
        $this->db->where('hms_ortho_ptics.booking_id', $booking_id);
        $this->db->where('hms_ortho_ptics.is_deleted', '0');

        // Execute the query
        $query = $this->db->get();

        // Check if the query executed successfully and return the result
        if ($query->num_rows() > 0) {
            return $query->row_array();  // Return the result as an array of objects
        } else {
            return [];  // Return an empty array if no results were found
        }
    }


    function get_by_low_vision_status($booking_id = '', $patient_id = '')
	{
		$user_data = $this->session->userdata('auth_users');
		$this->db->select('booking_id');
		$this->db->from('hms_ortho_ptics');
		$this->db->where('hms_ortho_ptics.booking_id', $booking_id);
		// $this->db->where('hms_ortho_ptics.patient_id', $patient_id);
		$this->db->where('hms_ortho_ptics.is_deleted', 0);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return 1; // Return 1 if a match is found
		}

		return 0; //

	}

}
