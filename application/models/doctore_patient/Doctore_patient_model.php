<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Doctore_patient_model extends CI_Model
{
    var $table = 'hms_doct_patient';
    var $side_effects_table = 'hms_side_effect'; // New table for side effects
    var $column = array(
        'hms_doct_patient.id',
        'hms_doct_patient.patient_id',
        'hms_doct_patient.booking_id',
        'hms_doct_patient.referred_by',
        'hms_doct_patient.room_id',
        'hms_doct_patient.status',
        'hms_doct_patient.created_date',
    );
    var $order = array('id' => 'desc');

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $user_data = $this->session->userdata('auth_users');
        $search = $this->session->userdata('prescription_search');
        // echo "<pre>";
        // print_r($search);
        // die;
        $this->db->select("hms_doct_patient.*, hms_patient.id as patient_id,hms_patient.patient_name,hms_patient.patient_code,hms_patient.emergency_status,hms_patient.pat_status, hms_patient.patient_code_auto,hms_patient.gender,hms_patient.age,hms_patient.age_y,hms_patient.age_d,hms_patient.age_m,hms_patient.age_h, hms_patient.mobile_no, hms_opd_booking.booking_code,hms_opd_booking.token_no,hms_doctors.doctor_name,hms_room_master.room_no");
        $this->db->from($this->table);
        $this->db->join('hms_patient', 'hms_patient.id = hms_doct_patient.patient_id', 'left');
        $this->db->join('hms_doctors', 'hms_doctors.id = hms_doct_patient.referred_by', 'left');
        $this->db->join('hms_room_master', 'hms_room_master.id = hms_doct_patient.room_id', 'left');
        $this->db->join('hms_opd_booking', 'hms_opd_booking.id = hms_doct_patient.booking_id', 'left');
        $this->db->where('hms_doct_patient.is_deleted', '0');

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
                $this->db->where('hms_doct_patient.created_date >=', $start_date);
            }

            if (!empty($search['priority_type']) && $search['priority_type'] !== '4') {
                $this->db->where('hms_patient.emergency_status', $search['priority_type']);
            } else if ($search['priority_type'] === '4') {
                $this->db->where('hms_patient.emergency_status', NULL);
            }

            if (!empty($search['end_date'])) {
                $end_date = date('Y-m-d 23:59:59', strtotime($search['end_date']));
                $this->db->where('hms_doct_patient.created_date <=', $end_date);
            }

            if (!empty($search['doc_id'])) {
                $this->db->like('hms_doct_patient.referred_by', $search['doc_id'], 'after');
            }
            if (!empty($search['room_id'])) {
                $this->db->like('hms_doct_patient.room_id', $search['room_id'], 'after');
            }
            if (isset($search['status']) && $search['status'] != "") {
				$this->db->where('hms_doct_patient.status', $search['status']);
			}
            if (!empty($search['patient_name'])) {
                $this->db->like('hms_patient.patient_name', $search['patient_name'], 'after');
            }

            if (!empty($search['patient_code'])) {
                $this->db->where('hms_patient.patient_code', $search['patient_code']);
            }
            if ($search['emergency_booking'] == "4") {
                $this->db->where('hms_opd_booking.opd_type', 1);
            } else if ($search['emergency_booking'] == "3") {
                $this->db->where('hms_opd_booking.opd_type', 0);
            }
        }

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
        // if (!$query) {
        //     print_r($this->db->last_query());
        //     echo $this->db->error()['message'];
        //     return false;
        // }
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
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function room_no_list()
    {
    	 $users_data = $this->session->userdata('auth_users');
        $this->db->select('*');  
        $this->db->where('is_deleted','0');
        $this->db->where('hms_room_master.branch_id',$users_data['parent_id']);
        $query = $this->db->get('hms_room_master');
        $result = $query->result(); 
        return $result; 
    }

    public function get_by_id($id)
    {
        $this->db->select('hms_doct_patient.id as doc_pat_id,hms_doct_patient.*,hms_opd_booking.*,hms_patient.*');
        $this->db->from($this->table);
        $this->db->join('hms_patient', 'hms_patient.id = hms_doct_patient.patient_id', 'left');
        $this->db->join('hms_opd_booking', 'hms_opd_booking.id = hms_doct_patient.booking_id', 'left');
        $this->db->where('hms_doct_patient.id', $id);
        $this->db->where('hms_doct_patient.is_deleted', '0');
        $query = $this->db->get();
        return $query->row_array();

    }

    public function print_vision_details($id)
    {
        $this->db->select('hms_doct_patient.id as doc_pat_id,
        hms_doct_patient.*, 
        hms_patient.*, 
        hms_opd_booking.*, 
        optometrist.doctor_name as doc_name, 
    ');
        $this->db->from($this->table);
        $this->db->join('hms_patient', 'hms_patient.patient_code = hms_doct_patient.patient_code', 'left');
        $this->db->join('hms_opd_booking', 'hms_opd_booking.id = hms_doct_patient.booking_id', 'left');
        $this->db->join('hms_doctors as optometrist', 'optometrist.id = hms_doct_patient.referred_by', 'left');
        $this->db->where('hms_doct_patient.id', $id);
        $this->db->where('hms_doct_patient.is_deleted', '0');
        $query = $this->db->get();
        return $query->row_array();
    }


    public function get_side_effect_name($side_effect_id)
    {
        $this->db->select('side_effect_name');
        $this->db->from('hms_side_effect'); // Assuming your table name is `side_effects`
        $this->db->where('id', $side_effect_id);
        $query = $this->db->get();

        // Return the side effect name if found
        if ($query->num_rows() > 0) {
            return $query->row()->side_effect_name;
        }

        return null; // Return null if no side effect found
    }

    public function save()
    {
        $user_data = $this->session->userdata('auth_users');
        $post = $this->input->post();
        // echo "<pre>";
        // print_r($post);
        // die('sagar');
        $data = array(
            'patient_id' => isset($post['patient_id']) ? $post['patient_id'] : '',
            'booking_id' => isset($post['booking_id']) ? $post['booking_id'] : '',
            'referred_by' => isset($post['referred_by']) ? $post['referred_by'] : '',
            'room_id' => isset($post['room_no']) ? $post['room_no'] : '',
            'status' => 0,
            'created_by' => $user_data['parent_id'],
            'ip_address' => $_SERVER['REMOTE_ADDR'],
        );
    

        if (!empty($post['data_id']) && $post['data_id'] > 0) {
            // echo "<pre>";
            // print_r($data);
            // die;
            // For update
            $this->db->set('updated_date', date('Y-m-d H:i:s'));
            $this->db->where('id', $post['data_id']);
            $this->db->update($this->table, $data);
        } else {
            // For insert
            $this->db->set('created_date', date('Y-m-d H:i:s'));
            $this->db->insert($this->table, $data);
            // echo $this->db->last_query();

            if (!empty($data['patient_id'])) {
                // Retrieve the current 'pat_status' value for the given patient
                $this->db->select('pat_status');
                $this->db->where('id', $post['patient_id']);
                $query = $this->db->get('hms_patient');
                // echo $this->db->last_query();
                // die();
                if ($query->num_rows() > 0) {
                    $current_status = $query->row()->pat_status;

                    // Concatenate the current status with 'Low vision'
                    $new_status = $current_status . ', Pricescribe';
                    // echo "<pre>";print_r($new_status);die;

                    // Update the 'pat_status' field with the concatenated value
                    $this->db->where('id', $post['patient_id']);
                    $this->db->update('hms_patient', ['pat_status' => $new_status]);
                }
            }


        }

        // Update hms_std_opd_patient_status for the corresponding booking_id
        // $this->db->set('send_vision', 1);
        // $this->db->where('booking_id', $post['booking_id']);
        // $this->db->update('hms_std_opd_patient_status');
    }

    public function get_doct_patient_booking_id($booking_id,$patient_id)
    {
       
        // Select fields from hms_ortho_ptics and hms_patient
        $this->db->select('hms_doct_patient.*, hms_patient.*');
        $this->db->from($this->table);
        $this->db->join('hms_patient', 'hms_patient.id = hms_doct_patient.patient_id', 'left');
        $this->db->where('hms_doct_patient.booking_id', $booking_id);
        $this->db->where('hms_doct_patient.patient_id', $patient_id);
        $this->db->where('hms_doct_patient.is_deleted', '0');
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


    public function delete($id = "")
    {
        if (!empty($id) && $id > 0) {
            $this->db->set('is_deleted', 1);
            $this->db->where('id', $id);
            $this->db->update($this->table); // Changed to use the variable
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
            $side_effect_ids = implode(',', $id_list);
            $this->db->set('is_deleted', 1);
            $this->db->where('id IN (' . $side_effect_ids . ')');
            $this->db->update($this->table); // Changed to use the variable
        }
    }

    public function get_opd_billing_by_id($id)
    {
        $this->db->where('patient_id', $id); // Assuming 'patient_id' relates to the form ID
        $query = $this->db->get('opd_billing');
        return $query->row_array();
    }


    public function get_patient_name_by_booking_id($booking_id)
    {
        // Join hms_std_eye_prescription with hms_patient, hms_token, and hms_patient_category to get all details
        $this->db->select('hms_std_eye_prescription.*, hms_patient.*, hms_token.token_no, hms_patient_category.patient_category'); // Select necessary columns including category_name
        $this->db->from('hms_std_eye_prescription');
        $this->db->join('hms_patient', 'hms_patient.id = hms_std_eye_prescription.patient_id', 'left');
        $this->db->join('hms_token', 'hms_token.patient_id = hms_patient.id', 'left'); // Join with hms_token on patient_id
        $this->db->join('hms_patient_category', 'hms_patient_category.id = hms_patient.patient_category', 'left'); // Join with hms_patient_category on patient_category
        $this->db->where('hms_std_eye_prescription.booking_id', $booking_id); // Filter by booking_id
        $this->db->where('hms_std_eye_prescription.is_deleted', '0'); // Check if not deleted

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array(); // Return all columns as an associative array including category_name
        }

        return null; // Return null if no patient is found
    }


    public function get_booking_patient_details($booking_id)
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
    public function get_booking_patient_details_edit($booking_id)
    {
        // echo $booking_id;die;
        // Select all fields from both tables
        $this->db->select('hms_opd_booking.*, hms_patient.*'); // Select all fields
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

    // New method to fetch all non-deleted side effects
    public function get_all_side_effects()
    {
        $this->db->select('id, side_effect_name');
        $this->db->from('hms_side_effect');
        $this->db->where('is_deleted', 0); // Assuming you filter deleted records
        $query = $this->db->get();
        return $query->result();
    }
}
