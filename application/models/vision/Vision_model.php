<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vision_model extends CI_Model
{
    var $table = 'hms_vision';
    var $side_effects_table = 'hms_side_effect'; // New table for side effects
    var $column = array(
        'hms_vision.id', 
        'hms_vision.patient_name', 
        'hms_vision.patient_code', 
        'hms_vision.booking_id', 
        'hms_vision.procedure_purpose', 
        'hms_side_effect.side_effect_name', // Change to fetch side effect name
        'hms_vision.informed_consent',
        'hms_vision.previous_ffa',
        'hms_vision.history_allergy',
        'hms_vision.history_asthma',
        'hms_vision.history_epilepsy',
        'hms_vision.accompanied_attendant',
        'hms_vision.s_creatinine',
        'hms_vision.blood_sugar',
        'hms_vision.blood_pressure',
        'hms_vision.reason_ffa_not_done',
        'hms_vision.optometrist_signature',
        'hms_vision.optometrist_date',
        'hms_vision.anaesthetist_signature',
        'hms_vision.anaesthetist_date',
        'hms_vision.doctor_signature',
        'hms_vision.doctor_date',
        'hms_vision.created_at',
        'hms_vision.updated_at'
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
        $this->db->select("hms_vision.*, hms_patient.id as patient_id, hms_side_effect.side_effect_name,hms_patient.emergency_status,hms_patient.pat_status, hms_patient.patient_code_auto,hms_patient.gender,hms_patient.age,hms_patient.age_y,hms_patient.age_d,hms_patient.age_m,hms_patient.age_h, hms_patient.mobile_no, hms_opd_booking.booking_code");
        $this->db->from($this->table);
        $this->db->join('hms_patient', 'hms_patient.patient_code = hms_vision.patient_code', 'left');
        $this->db->join('hms_opd_booking', 'hms_opd_booking.id = hms_vision.booking_id', 'left');
        $this->db->join('hms_side_effect', 'hms_vision.side_effects = hms_side_effect.id', 'left'); // Replace $this->side_effects_table with table name directly
        $this->db->where('hms_vision.is_deleted', '0');

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
				$this->db->where('hms_vision.created_at >=', $start_date);
			}

            if (!empty($search['priority_type'])) {
                $this->db->where('hms_patient.emergency_status', $search['priority_type']);
            }

			if (!empty($search['end_date'])) {
				$end_date = date('Y-m-d 23:59:59', strtotime($search['end_date']));
				$this->db->where('hms_vision.created_at <=', $end_date);
			}

			if (!empty($search['patient_name'])) {
				$this->db->like('hms_vision.patient_name', $search['patient_name'], 'after');
			}

			if (!empty($search['patient_code'])) {
				$this->db->where('hms_vision.patient_code', $search['patient_code']);
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
    
    public function get_by_id($id)
    {
        $this->db->select('hms_vision.*');
        $this->db->from($this->table);
        $this->db->where('hms_vision.id', $id);
        $this->db->where('hms_vision.is_deleted', '0');
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
        $post = $this->input->post();
        
        $data = array(
            'patient_code' => isset($post['patient_code']) ? $post['patient_code'] : '',
            'patient_name' => isset($post['patient_name']) ? $post['patient_name'] : '',
            'booking_id' => isset($post['booking_id']) ? $post['booking_id'] : '',
            'procedure_purpose' => isset($post['procedure_purpose']) ? $post['procedure_purpose'] : '',
            'side_effects' => isset($post['side_effects']) ? $post['side_effects'] : '',
            'informed_consent' => isset($post['informed_consent']) ? $post['informed_consent'] : '',
            'previous_ffa' => isset($post['previous_ffa']) ? $post['previous_ffa'] : '',
            'history_allergy' => isset($post['history_allergy']) ? $post['history_allergy'] : '',
            'history_asthma' => isset($post['history_asthma']) ? $post['history_asthma'] : '',
            'history_epilepsy' => isset($post['history_epilepsy']) ? $post['history_epilepsy'] : '',
            'accompanied_attendant' => isset($post['accompanied_attendant']) ? $post['accompanied_attendant'] : '',
            's_creatinine' => isset($post['s_creatinine']) ? $post['s_creatinine'] : '',
            'blood_sugar' => isset($post['blood_sugar']) ? $post['blood_sugar'] : '',
            'blood_pressure' => isset($post['blood_pressure']) ? $post['blood_pressure'] : '',
            'reason_ffa_not_done' => isset($post['reason_ffa_not_done']) ? $post['reason_ffa_not_done'] : '',
            'optometrist_signature' => isset($post['optometrist_signature']) ? $post['optometrist_signature'] : '',
            'optometrist_date' => isset($post['optometrist_date']) ? date('Y-m-d', strtotime($post['optometrist_date'])) : null,
            'anaesthetist_signature' => isset($post['anaesthetist_signature']) ? $post['anaesthetist_signature'] : '',
            'anaesthetist_date' => isset($post['anaesthetist_date']) ? date('Y-m-d', strtotime($post['anaesthetist_date'])) : null,
            'doctor_signature' => isset($post['doctor_signature']) ? $post['doctor_signature'] : '',
            'doctor_date' => isset($post['doctor_date']) ? date('Y-m-d', strtotime($post['doctor_date'])) : null,
        );

        if (!empty($post['data_id']) && $post['data_id'] > 0) {
            // For update
            $this->db->set('updated_at', date('Y-m-d H:i:s'));
            $this->db->where('id', $post['data_id']);
            $this->db->update($this->table, $data);
        } else {
            // For insert
            $this->db->set('created_at', date('Y-m-d H:i:s'));
            $this->db->insert($this->table, $data);

            if (!empty($data['patient_code'])) {
                // Retrieve the current 'pat_status' value for the given patient
                $this->db->select('pat_status');
                $this->db->where('patient_code', $post['patient_code']);
                $query = $this->db->get('hms_patient');
            
                if ($query->num_rows() > 0) {
                    $current_status = $query->row()->pat_status;
            
                    // Concatenate the current status with 'Low vision'
                    $new_status = $current_status . ', Vision';
                    // echo "<pre>";print_r($new_status);die;
            
                    // Update the 'pat_status' field with the concatenated value
                    $this->db->where('patient_code', $post['patient_code']);
                    $this->db->update('hms_patient', ['pat_status' => $new_status]);
                }
            }
            
            
        }

        // Update hms_std_opd_patient_status for the corresponding booking_id
        $this->db->set('send_vision', 1);
        $this->db->where('booking_id', $post['booking_id']);
        $this->db->update('hms_std_opd_patient_status');
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
