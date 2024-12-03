<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Prosthetic_model extends CI_Model
{

    var $table = 'hms_prosthetic'; // Define the table name
    var $order = array('pres_id' => 'desc'); // Define the default order

    // Define the columns you want to retrieve from the table
    var $column = array(
        'hms_prosthetic.id',
        'hms_prosthetic.branch_id',
        'hms_prosthetic.booking_code',
        'hms_prosthetic.pres_id',
        'hms_prosthetic.patient_id',
        'hms_prosthetic.booking_id',
        'hms_prosthetic.optometrist_signature',
        'hms_prosthetic.doctor_signature',
        'hms_prosthetic.status',
        'hms_prosthetic.is_deleted',
        'hms_prosthetic.deleted_by',
        'hms_prosthetic.deleted_date',
        'hms_prosthetic.ip_address',
        'hms_prosthetic.created_by',
        'hms_prosthetic.modified_by',
        'hms_prosthetic.modified_date',
        'hms_prosthetic.created_date',
        'hms_patient.patient_name',
        'hms_patient.mobile_no',
        'hms_patient.patient_code',
        'hms_prosthetic.indication',
        'hms_prosthetic.anterior_segment_evaluation',
        'hms_prosthetic.spectacle_power_od',
        'hms_prosthetic.spectacle_power_os',
        'hms_prosthetic.keratometry_od',
        'hms_prosthetic.keratometry_os',
        'hms_prosthetic.hvid_od',
        'hms_prosthetic.hvid_os',
        'hms_prosthetic.cl_trial',
        'hms_prosthetic.trial_given',
        'hms_prosthetic.final_order',
        'hms_prosthetic.instruction_given'
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

        // Select relevant columns
        $this->db->select("hms_prosthetic.id as refraction_id, hms_prosthetic.*, hms_patient.*, hms_patient_category.patient_category as patient_category_name, hms_opd_booking.*, hms_doctors.doctor_name, hms_opd_booking.token_no as token, hms_patient.emergency_status, hms_prosthetic.created_date as created, hms_prosthetic.status as pro_status");

        $this->db->from($this->table);

        // Joining tables
        $this->db->join('hms_patient', 'hms_patient.id = hms_prosthetic.patient_id', 'left');
        $this->db->join('hms_patient_category', 'hms_patient_category.id = hms_patient.patient_category', 'left');
        $this->db->join('hms_opd_booking', 'hms_opd_booking.id = hms_prosthetic.booking_id', 'left');
        $this->db->join('hms_doctors', 'hms_doctors.id = hms_opd_booking.attended_doctor', 'left');

        // Filter deleted entries
        $this->db->where('hms_prosthetic.is_deleted', '0');

        // Group by to prevent duplicate rows
        $this->db->group_by('hms_prosthetic.id');

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
                $this->db->where('hms_prosthetic.created_date >=', $start_date);
            }

            if (!empty($search['end_date'])) {
                $end_date = date('Y-m-d 23:59:59', strtotime($search['end_date']));
                $this->db->where('hms_prosthetic.created_date <=', $end_date);
            }

            if (isset($search['search_type']) && $search['search_type'] != "") {
                $this->db->where('hms_prosthetic.status', $search['search_type']);
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

        // Handle ordering from DataTables or default ordering
        if (isset($_POST['order'])) {
            // Order by the specified column and direction
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            // Default sorting: change here for custom default sorting
            $this->db->order_by('hms_prosthetic.created_date', 'DESC');  // Custom default sort by created_date descending
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
        $this->db->select('hms_prosthetic.*, hms_prosthetic.status as pro_status,hms_patient.*');
        $this->db->from($this->table);
        $this->db->join('hms_patient', 'hms_patient.id = hms_prosthetic.patient_id', 'left');
        $this->db->where('hms_prosthetic.id', $id);
        $this->db->where('hms_prosthetic.is_deleted', '0');
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

    public function get_booking_by_id($booking_id, $patient_id)
    {
        // echo $booking_id;die;
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
        $post = $this->input->post();
        // echo "<pre>";print_r($data);die;
        // Check if data has an 'id' field for update operation
        if (!empty($data['id'])) {
            // Update the existing record
            $this->db->where('id', $data['id']);
            if ($this->db->update($this->table, $data)) {
                return true; // Return true if update is successful
            } else {
                // Log or handle error (update failed)
                log_message('error', 'Failed to update record: ' . $this->db->last_query());
                return false; // Return false if update failed
            }
        } else {
            // echo $this->table;die;
            // Insert new record
            // if ($this->db->insert($this->table, $data)) {
            // echo "<pre>";print_r($post);
            // echo "<pre>";print_r($data);die;

            if (!empty($post['send_to_type'] === 'Prosthetic') || $post['mod_type'] === 'help_desk') {
                // Insert a new record
                $this->db->insert($this->table, $data);
            }

            if ($post['mod_type'] === 'refraction_above') {
                $data = ['status' => 1]; // Assuming 1 means booked
                $this->db->where('booking_id', $post['booking_id']);
                $this->db->where('patient_id', $post['patient_id']);
                $query = $this->db->get('hms_opd_refraction');
                // echo $this->db->last_query(); 
                // die('okay');
                // If the record exists, proceed with the update
                if ($query->num_rows() > 0) {
                    // Perform the update
                    $this->db->where('booking_id', $post['booking_id']);
                    $this->db->where('patient_id', $post['patient_id']);
                    $this->db->update('hms_opd_refraction', $data);
                }

            } else if ($post['mod_type'] === 'vision') {
                $data = ['status' => 1]; // Assuming 1 means booked
                $this->db->where('booking_id', $post['booking_id']);
                $this->db->where('patient_id', $post['patient_id']);
                $query = $this->db->get('hms_vision');

                // If the record exists, proceed with the update
                if ($query->num_rows() > 0) {
                    // Perform the update
                    $this->db->where('booking_id', $post['booking_id']);
                    $this->db->where('patient_id', $post['patient_id']);
                    $this->db->update('hms_vision', $data);
                }
            } else if ($post['mod_type'] === 'contact_lens') {
                $data = ['status' => 1]; // Assuming 1 means booked
                $this->db->where('booking_id', $post['booking_id']);
                $this->db->where('patient_id', $post['patient_id']);
                $query = $this->db->get('hms_contact_lens');

                // If the record exists, proceed with the update
                if ($query->num_rows() > 0) {
                    // Perform the update
                    $this->db->where('booking_id', $post['booking_id']);
                    $this->db->where('patient_id', $post['patient_id']);
                    $this->db->update('hms_contact_lens', $data);
                }
            } else if ($post['mod_type'] === 'low_vision') {
                $data = ['status' => 1]; // Assuming 1 means booked
                $this->db->where('booking_id', $post['booking_id']);
                $this->db->where('patient_id', $post['patient_id']);
                $query = $this->db->get('hms_low_vision');

                // If the record exists, proceed with the update
                if ($query->num_rows() > 0) {
                    // Perform the update
                    $this->db->where('booking_id', $post['booking_id']);
                    $this->db->where('patient_id', $post['patient_id']);
                    $this->db->update('hms_low_vision', $data);
                }
            } else if ($post['mod_type'] === 'prosthetic') {
                $data = ['status' => 1]; // Assuming 1 means booked
                $this->db->where('booking_id', $post['booking_id']);
                $this->db->where('patient_id', $post['patient_id']);
                $query = $this->db->get('hms_prosthetic');

                // If the record exists, proceed with the update
                if ($query->num_rows() > 0) {
                    // Perform the update
                    $this->db->where('booking_id', $post['booking_id']);
                    $this->db->where('patient_id', $post['patient_id']);
                    $this->db->update('hms_prosthetic', $data);
                }
            } else if ($post['mod_type'] === 'dilate') {
                $data = ['status' => 1]; // Assuming 1 means booked
                $this->db->where('booking_id', $post['booking_id']);
                $this->db->where('patient_id', $post['patient_id']);
                $query = $this->db->get('hms_dilated');

                // If the record exists, proceed with the update
                if ($query->num_rows() > 0) {
                    // Perform the update
                    $this->db->where('booking_id', $post['booking_id']);
                    $this->db->where('patient_id', $post['patient_id']);
                    $this->db->update('hms_dilated', $data);
                }
            } else if ($post['mod_type'] === 'oct_hfa') {
                $data = ['status' => 1]; // Assuming 1 means booked
                $this->db->where('booking_id', $post['booking_id']);
                $this->db->where('patient_id', $post['patient_id']);
                $query = $this->db->get('hms_oct_hfa');

                // If the record exists, proceed with the update
                if ($query->num_rows() > 0) {
                    // Perform the update
                    $this->db->where('booking_id', $post['booking_id']);
                    $this->db->where('patient_id', $post['patient_id']);
                    $this->db->update('hms_oct_hfa', $data);
                }
            } else if ($post['mod_type'] === 'ortho_ptics') {
                $data = ['status' => 1]; // Assuming 1 means booked
                $this->db->where('booking_id', $post['booking_id']);
                $this->db->where('patient_id', $post['patient_id']);
                $query = $this->db->get('hms_ortho_ptics');

                // If the record exists, proceed with the update
                if ($query->num_rows() > 0) {
                    // Perform the update
                    $this->db->where('booking_id', $post['booking_id']);
                    $this->db->where('patient_id', $post['patient_id']);
                    $this->db->update('hms_ortho_ptics', $data);
                }
            } else if ($post['mod_type'] === 'hess_chart') {
                $data = ['hess_chart_status' => 1]; // Assuming 1 means booked
                $this->db->where('booking_id', $post['booking_id']);
                $this->db->where('patient_id', $post['patient_id']);
                $query = $this->db->get('hms_std_eye_prescription');

                // If the record exists, proceed with the update
                if ($query->num_rows() > 0) {
                    // Perform the update
                    $this->db->where('booking_id', $post['booking_id']);
                    $this->db->where('patient_id', $post['patient_id']);
                    $this->db->update('hms_std_eye_prescription', $data);
                }
            } else if ($post['mod_type'] === 'refraction_below8') {
                $data = ['refra_below_status' => 1]; // Assuming 1 means booked
                $this->db->where('booking_id', $post['booking_id']);
                $this->db->where('patient_id', $post['patient_id']);
                $query = $this->db->get('hms_std_eye_prescription');

                // If the record exists, proceed with the update
                if ($query->num_rows() > 0) {
                    // Perform the update
                    $this->db->where('booking_id', $post['booking_id']);
                    $this->db->where('patient_id', $post['patient_id']);
                    $this->db->update('hms_std_eye_prescription', $data);
                }
            } else if ($post['mod_type'] === 'send_to_token') {
                $data = ['status' => 1]; // Assuming 1 means booked
                $this->db->where('booking_id', $post['booking_id']);
                $this->db->where('patient_id', $post['patient_id']);
                $query = $this->db->get('hms_send_to_token');

                // If the record exists, proceed with the update
                if ($query->num_rows() > 0) {
                    // Perform the update
                    $this->db->where('booking_id', $post['booking_id']);
                    $this->db->where('patient_id', $post['patient_id']);
                    $this->db->update('hms_send_to_token', $data);
                }
            }
            // Check if patient_id is provided
            if (

                (isset($post['send_to_type']) &&
                    in_array($post['send_to_type'], ['Prosthetic'])
                )
            ) {
                if (!empty($post['patient_id'])) {
                    // Retrieve the current 'pat_status' value for the given patient
                    $this->db->select('pat_status');
                    $this->db->where('id', $post['patient_id']);
                    $query = $this->db->get('hms_patient');

                    if ($query->num_rows() > 0) {
                        $current_status = $query->row()->pat_status;

                        // Concatenate the current status with 'Low vision'
                        $new_status = $current_status . ', Prosthetic';

                        // Update the 'pat_status' field with the concatenated value
                        $this->db->where('id', $post['patient_id']);
                        if (!$this->db->update('hms_patient', ['pat_status' => $new_status])) {
                            log_message('error', 'Failed to update pat_status for patient ID: ' . $data['patient_id']);
                            return false;
                        }
                    }
                }
            }

            // return true; // Return true if insert and update are successful
            // } else {
            //     // Log or handle error (insert failed)
            //     log_message('error', 'Failed to insert record: ' . $this->db->last_query());
            //     return false; // Return false if insert failed
            // }

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

    public function search_report_data($booking_id = '', $id = '')
    {
        // echo $booking_id;die;
        // echo $booking_id;die;
        $this->db->select("
            hms_prosthetic.id AS low_vision_id,           
            hms_prosthetic.*,
            hms_prosthetic.doctor_signature,
            hms_prosthetic.created_date,
            hms_prosthetic.booking_id,
            hms_prosthetic.patient_id,
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
            hms_opd_booking.booking_code
        ");

        $this->db->from('hms_prosthetic');
        $this->db->join('hms_patient', 'hms_patient.id = hms_prosthetic.patient_id', 'left');
        $this->db->join('hms_opd_booking', 'hms_opd_booking.id = hms_prosthetic.booking_id', 'left');
        $this->db->where('hms_prosthetic.booking_id', $booking_id);
        $this->db->where('hms_prosthetic.is_deleted', '0');

        $query = $this->db->get();
        // echo "<pre>";print_r($query);die;

        // Check if the query executed successfully
        if ($query->num_rows() > 0) {
            // Return the result as an array of objects
            return $query->result();
        } else {
            // Return an empty array if no results were found
            return [];
        }
    }

    function get_by_low_vision_status($booking_id = '', $patient_id = '')
    {
        $user_data = $this->session->userdata('auth_users');
        $this->db->select('booking_id');
        $this->db->from('hms_prosthetic');
        $this->db->where('hms_prosthetic.booking_id', $booking_id);
        $this->db->where('hms_prosthetic.patient_id', $patient_id);
        $this->db->where('hms_prosthetic.is_deleted', 0);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return 1; // Return 1 if a match is found
        }

        return 0; //

    }

    public function get_booking_status($patient_id)
    {
        $this->db->select('prosthetic_status');
        $this->db->from('hms_patient'); // Replace 'bookings' with your table name
        $this->db->where('id', $patient_id);
        $query = $this->db->get();
        $result = $query->row();

        if ($result) {
            // echo "<pre>";
            // print_r($result->opd_status);
            // die('status');
            return $result->opd_status; // Return status (1 or 0)
        }
        return 0; // Default to not booked
    }

    public function book_patient($patient_id)
    {
        // Update database to mark patient as booked
        $data = ['prosthetic_status' => 1]; // Assuming 1 means booked
        $this->db->where('id', $patient_id);
        return $this->db->update('hms_patient', $data);
    }

    public function update_patient_list_opd_status($patient_id = '')
    {
        $this->db->set('hms_patient.prosthetic_status', 0);
        $this->db->where('hms_patient.id', $patient_id);
        $query = $this->db->update('hms_patient');
        return $query;
    }

    public function patient_exists($patient_id = "")
    {

        $user_data = $this->session->userdata('auth_users');
        $this->db->select('hms_prosthetic.id as pros_id*, hms_patient.id,hms_patient.patient_name');

        $this->db->from('hms_prosthetic');
        $this->db->join('hms_patient', 'hms_patient.id = hms_prosthetic.patient_id');
        $this->db->where('hms_prosthetic.branch_id', $user_data['parent_id']);
        $this->db->where('hms_prosthetic.patient_id', $patient_id);
        $this->db->where('hms_prosthetic.is_deleted', '0');
        $query = $this->db->get();
        return $query->row_array();
    }

}
