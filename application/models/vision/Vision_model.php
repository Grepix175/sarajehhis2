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
        $this->db->select("hms_vision.*, hms_side_effect.side_effect_name");
        $this->db->from($this->table);
        $this->db->join($this->side_effects_table, 'hms_vision.side_effects = hms_side_effect.id', 'left'); // Join side effects
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

    public function save()
    {
        $post = $this->input->post();
        // echo "<pre>";print_r($post);die;
        $data = array(
            'patient_code' => $post['patient_code'],
            'patient_name' => $post['patient_name'],
            'booking_id' => $post['booking_id'],
            'procedure_purpose' => $post['procedure_purpose'],
            'side_effects' => $post['side_effects'], // Assuming this is the ID of the side effect
            'informed_consent' => $post['informed_consent'],
            'previous_ffa' => $post['previous_ffa'],
            'history_allergy' => $post['history_allergy'],
            'history_asthma' => $post['history_asthma'],
            'history_epilepsy' => $post['history_epilepsy'],
            'accompanied_attendant' => $post['accompanied_attendant'],
            's_creatinine' => $post['s_creatinine'],
            'blood_sugar' => $post['blood_sugar'],
            'blood_pressure' => $post['blood_pressure'],
            'reason_ffa_not_done' => $post['reason_ffa_not_done'],
            'optometrist_signature' => $post['optometrist_signature'],
            'optometrist_date' => date('Y-m-d', strtotime($post['optometrist_date'])),
            'anaesthetist_signature' => $post['anaesthetist_signature'],
            'anaesthetist_date' => date('Y-m-d', strtotime($post['anaesthetist_date'])),
            'doctor_signature' => $post['doctor_signature'],
            'doctor_date' => date('Y-m-d', strtotime($post['doctor_date'])),
        );

        if (!empty($post['data_id']) && $post['data_id'] > 0) {
            $this->db->set('updated_at', date('Y-m-d H:i:s'));
            $this->db->where('id', $post['data_id']);
            $this->db->update($this->table, $data); // Changed to use the variable
        } else {
            // echo "<per>";
            // print_r('sagar');
            // print_r($data);
            // die;
            $this->db->set('created_at', date('Y-m-d H:i:s'));
            $this->db->insert($this->table, $data); // Changed to use the variable
            // $this->db->insert('hms_vision', $data); // Changed to use the variable
            // if ($this->db->affected_rows() > 0) {
            //     echo 'Insert successful';
            // } else {
            //     // Insert failed, check for errors
            //     $error = $this->db->error(); // Get the error code and message
            //     echo 'Error: ' . $error['message']; // Display or log the error message
            // }
        }
        $this->db->set('send_vision', 1);
        $this->db->where('booking_id', $post['booking_id']); // Use $post['booking_id']
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

    public function get_patient_name_by_booking_id($booking_id)
    {
        // Join hms_std_eye_prescription with hms_patient to get patient details
        $this->db->select('hms_patient.patient_name,hms_patient.patient_code'); // Only select patient_name
        $this->db->from('hms_std_eye_prescription');
        $this->db->join('hms_patient', 'hms_patient.id = hms_std_eye_prescription.patient_id', 'left');
        $this->db->where('hms_std_eye_prescription.booking_id', $booking_id); // Filter by booking_id
        $this->db->where('hms_std_eye_prescription.is_deleted', '0'); // Check if not deleted

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row(); // Get the result as an object
            $patientName = $result->patient_name; // Patient's name
            $patientCode = $result->patient_code; // Access other column data
            // Do something with the data...
            return [
                'patient_name' => $patientName,
                'patient_code' => $patientCode,
            ];
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
