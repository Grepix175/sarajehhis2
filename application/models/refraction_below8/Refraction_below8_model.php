<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Refraction_below8_model extends CI_Model
{

    // var $table = 'hms_std_eye_prescription_refraction'; // Define the table name

	// var $column = array(
	// 	'hms_std_eye_prescription_refraction.id',
	// 	'hms_patient.patient_name',
	// 	'hms_patient.patient_code',
	// 	'hms_patient.mobile_no',
	// 	'hms_patient.age_y',
	// 	'hms_patient.age_m',
	// 	'hms_patient.age_d',
	// 	'hms_opd_booking.dilate_status',
	// 	'hms_opd_booking.app_type',
	// 	'hms_opd_booking.token_no',
		
	// 	// 'hms_std_eye_prescription.id', 
	// 	// 'hms_std_eye_prescription.booking_code',
	// 	// 'hms_std_eye_prescription.status', 
	// 	// 'hms_std_eye_prescription.created_date', 
	// 	// 'hms_std_eye_prescription.modified_date',
		
	// 	'hms_std_eye_prescription_refraction.created_date',
	// 	'hms_std_eye_prescription_refraction.booking_code',
	// 	'hms_std_eye_prescription_refraction.pres_id',
	// 	'hms_std_eye_prescription_refraction.patient_id',
	// 	'hms_std_eye_prescription_refraction.booking_id',
	// 	'hms_std_eye_prescription_refraction.visual_acuity',
	// 	'hms_std_eye_prescription_refraction.keratometry',
	// 	'hms_std_eye_prescription_refraction.pgp',
	// 	'hms_std_eye_prescription_refraction.auto_refraction',
	// 	'hms_std_eye_prescription_refraction.dry_refraction',
	// 	'hms_std_eye_prescription_refraction.refraction_delated',
	// 	'hms_std_eye_prescription_refraction.retinoscopy',
	// 	'hms_std_eye_prescription_refraction.pmt',
	// 	'hms_std_eye_prescription_refraction.glass_prescription',
	// 	'hms_std_eye_prescription_refraction.inter_glass_presc',
	// 	'hms_std_eye_prescription_refraction.contact_lens_presc',
	// 	'hms_std_eye_prescription_refraction.color_vision',
	// 	'hms_std_eye_prescription_refraction.contrast_sensivity',
	// 	'hms_std_eye_prescription_refraction.intraocular_press',
	// 	'hms_std_eye_prescription_refraction.orthoptics',
	// 	'hms_std_eye_prescription_refraction.status',
	// 	'hms_std_eye_prescription_refraction.is_deleted',
	// 	'hms_std_eye_prescription_refraction.deleted_by',
	// 	'hms_std_eye_prescription_refraction.deleted_date',
	// 	'hms_std_eye_prescription_refraction.ip_address',
	// 	'hms_std_eye_prescription_refraction.created_by',
	// 	'hms_std_eye_prescription_refraction.modified_by',
	// 	'hms_std_eye_prescription_refraction.modified_date',
	// 	'hms_std_eye_prescription_refraction.pupillary_reaction',
	// 	'hms_std_eye_prescription_refraction.ropgas',
	// 	'hms_std_eye_prescription_refraction.vision_with_cl',
	// 	'hms_std_eye_prescription_refraction.hirschberg_test'
	// ); // List of columns for query

	var $table = 'hms_std_eye_prescription';
	var $column = array('hms_std_eye_prescription.id', 'hms_std_eye_prescription.booking_code', 'hms_std_eye_prescription.status', 'hms_std_eye_prescription.created_date', 'hms_std_eye_prescription.modified_date', 'hms_patient.patient_name', 'hms_patient.patient_code', 'hms_patient.mobile_no');
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
		// print_r($search);

		// die('end');
		// Select fields with proper aliasing if needed
		$this->db->select("hms_std_eye_prescription.*, hms_patient.simulation_id, hms_patient.patient_name,hms_patient.emergency_status,hms_patient.gender, hms_patient.patient_code, hms_patient.mobile_no, hms_patient.age_y, hms_patient.age_m, hms_patient.age_d, hms_opd_booking.dilate_status, hms_opd_booking.app_type, hms_opd_booking.token_no");
		$this->db->from('hms_std_eye_prescription');
		$this->db->join('hms_opd_booking', 'hms_opd_booking.id = hms_std_eye_prescription.booking_id');
		$this->db->join('hms_patient', 'hms_patient.id = hms_std_eye_prescription.patient_id', 'left');

		$this->db->where('hms_std_eye_prescription.is_deleted', '0');
		$this->db->where('hms_std_eye_prescription.refraction_below8', '1');
		
		// Handle branch_id filtering
		if (!empty($search['branch_id'])) {
			$this->db->where_in('hms_std_eye_prescription.branch_id', explode(',', $search['branch_id']));
		} else {
			$this->db->where('hms_std_eye_prescription.branch_id', $user_data['parent_id']);
		}

		
		// Search conditions
		if (!empty($search)) {
			if (!empty($search['start_date'])) {
				$start_date = date('Y-m-d 00:00:00', strtotime($search['start_date']));
				$this->db->where('hms_std_eye_prescription.created_date >=', $start_date);
			}

			if (!empty($search['end_date'])) {
				$end_date = date('Y-m-d 23:59:59', strtotime($search['end_date']));
				$this->db->where('hms_std_eye_prescription.created_date <=', $end_date);
			}

			if (!empty($search['priority_type'])) {
                $this->db->where('hms_patient.emergency_status', $search['priority_type']);
            }

			if (!empty($search['patient_name'])) {
				$this->db->like('hms_patient.patient_name', $search['patient_name'], 'after');
			}

			if (!empty($search['patient_code'])) {
				$this->db->where('hms_patient.patient_code', $search['patient_code']);
			}

			if (!empty($search['mobile_no'])) {
				$this->db->like('hms_patient.mobile_no', $search['mobile_no'], 'after');
			}
		}

		// Exclude prescription ID 1
		$this->db->where('hms_std_eye_prescription.id !=', 1);

		// Handle employee-specific data
		$emp_ids = $user_data['emp_id'] > 0 && $user_data['record_access'] == '1' 
				? $user_data['id'] 
				: (!empty($get["employee"]) && is_numeric($get['employee']) ? $get["employee"] : '');

		if (!empty($emp_ids)) {
			$this->db->where_in('hms_std_eye_prescription.created_by', explode(',', $emp_ids));
		}

		// Add search functionality for DataTables
		foreach ($this->column as $i => $item) {
			if ($_POST['search']['value']) {
				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if ($i === count($this->column) - 1) {
					$this->db->group_end();
				}
			}
		}

		// Group results
		$this->db->group_by('hms_std_eye_prescription.id');

		// Handle ordering
		if (isset($_POST['order'])) {
			$this->db->order_by($this->column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$this->db->order_by(key($this->order), $this->order[key($this->order)]);
		}
	}




	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

    public function save($emeId = '')
	{
		$user_data = $this->session->userdata('auth_users');
		$post = $this->input->post();
		// 		echo "sagar";
		// echo "<pre>"; print_r( $post); die;

		$history_flag = 0;
		$drawing_flag = 0;
		// if($post['flag'] == 'hess_chart'){
		// 	$history_flag = 1;
		// 	$drawing_flag = isset($post['print_drawing_flag']) ? '1' : '0';
		// }else{

		// 	$history_flag = isset($post['print_history_flag']) ? '1' : '0';
		// }
		$contactlens_flag = isset($post['print_contactlens_flag']) ? '1' : '0';
		$glassesprescriptions_flag = isset($post['print_glassesprescriptions_flag']) ? '1' : '0';
		$intermediate_glasses_prescriptions_flag = isset($post['print_intermediate_glasses_prescriptions_flag']) ? '1' : '0';
		$examination_flag = isset($post['print_examination_flag']) ? '1' : '0';
		
		$diagnosis_flag = isset($post['print_diagnosis_flag']) ? '1' : '0';
		$investigations_flag = isset($post['print_investigations_flag']) ? '1' : '0';
		$advice_flag = isset($post['print_advice_flag']) ? '1' : '0';
		$biometry_flag = isset($post['print_biometry_flag']) ? '1' : '0';
		// $pres_data = array('branch_id' => $post['branch_id'], 'booking_code' => $post['booking_code'], 'patient_id' => $post['patient_id'], 'booking_id' => $post['booking_id'], 'history_flag' => $history_flag, 'contactlens_flag' => $contactlens_flag, 'glassesprescriptions_flag' => $glassesprescriptions_flag, 'intermediate_glasses_prescriptions_flag' => $intermediate_glasses_prescriptions_flag, 'examination_flag' => $examination_flag, 'drawing_flag' => $drawing_flag, 'diagnosis_flag' => $diagnosis_flag, 'investigations_flag' => $investigations_flag, 'advice_flag' => $advice_flag, 'biometry_flag' => $biometry_flag, 'status' => 1, 'ip_address' => $_SERVER['REMOTE_ADDR'], 'created_by' => $post['branch_id']);
		
		

		$keratometry = array(
			'refraction_km_l_kh' => $post['refraction_km_l_kh'],
			'refraction_km_l_kh_a' => $post['refraction_km_l_kh_a'],
			'refraction_km_r_kh' => $post['refraction_km_r_kh'],
			'refraction_km_r_kh_a' => $post['refraction_km_r_kh_a'],
			'refraction_km_l_kv' => $post['refraction_km_l_kv'],
			'refraction_km_l_kv_a' => $post['refraction_km_l_kv_a'],
			'refraction_km_r_kv' => $post['refraction_km_r_kv'],
			'refraction_km_r_kv_a' => $post['refraction_km_r_kv_a']
		);

		$pgp = array(
			'refraction_pgp_l_dt_sph' => $post['refraction_pgp_l_dt_sph'],
			'refraction_pgp_l_dt_cyl' => $post['refraction_pgp_l_dt_cyl'],
			'refraction_pgp_l_dt_axis' => $post['refraction_pgp_l_dt_axis'],
			'refraction_pgp_l_dt_vision' => $post['refraction_pgp_l_dt_vision'],
			
			'refraction_pgp_l_nr_sph' => $post['refraction_pgp_l_nr_sph'],
			'refraction_pgp_l_nr_cyl' => $post['refraction_pgp_l_nr_cyl'],
			'refraction_pgp_l_nr_axis' => $post['refraction_pgp_l_nr_axis'],
			'refraction_pgp_l_nr_vision' => $post['refraction_pgp_l_nr_vision'],

			'refraction_pgp_r_dt_sph' => $post['refraction_pgp_r_dt_sph'],
			'refraction_pgp_r_dt_cyl' => $post['refraction_pgp_r_dt_cyl'],
			'refraction_pgp_r_dt_axis' => $post['refraction_pgp_r_dt_axis'],
			'refraction_pgp_r_dt_vision' => $post['refraction_pgp_r_dt_vision'],
			
			'refraction_pgp_r_nr_sph' => $post['refraction_pgp_r_nr_sph'],
			'refraction_pgp_r_nr_cyl' => $post['refraction_pgp_r_nr_cyl'],
			'refraction_pgp_r_nr_axis' => $post['refraction_pgp_r_nr_axis'],
			'refraction_pgp_r_nr_vision' => $post['refraction_pgp_r_nr_vision'],
		);

			// $auto_ref = array(
			// 	'refraction_ar_l_dry_sph' => $post['refraction_ar_l_dry_sph'],
			// 	'refraction_ar_l_dry_cyl' => $post['refraction_ar_l_dry_cyl'],
			// 	'refraction_ar_l_dry_axis' => $post['refraction_ar_l_dry_axis'],
			// 	'refraction_ar_l_dd_sph' => $post['refraction_ar_l_dd_sph'],
			// 	'refraction_ar_l_dd_cyl' => $post['refraction_ar_l_dd_cyl'],
			// 	'refraction_ar_l_dd_axis' => $post['refraction_ar_l_dd_axis'],
			// 	// 'refraction_ar_l_b1_sph' => $post['refraction_ar_l_b1_sph'],
			// 	// 'refraction_ar_l_b1_cyl' => $post['refraction_ar_l_b1_cyl'],
			// 	// 'refraction_ar_l_b1_axis' => $post['refraction_ar_l_b1_axis'],
			// 	// 'refraction_ar_l_b2_sph' => $post['refraction_ar_l_b2_sph'],
			// 	// 'refraction_ar_l_b2_cyl' => $post['refraction_ar_l_b2_cyl'],
			// 	// 'refraction_ar_l_b2_axis' => $post['refraction_ar_l_b2_axis'],
			// 	// 'refraction_ar_r_dry_sph' => $post['refraction_ar_r_dry_sph'],
			// 	// 'refraction_ar_r_dry_cyl' => $post['refraction_ar_r_dry_cyl'],
			// 	// 'refraction_ar_r_dry_axis' => $post['refraction_ar_r_dry_axis'],
			// 	'refraction_ar_r_dd_sph' => $post['refraction_ar_r_dd_sph'],
			// 	'refraction_ar_r_dd_cyl' => $post['refraction_ar_r_dd_cyl'],
			// 	'refraction_ar_r_dd_axis' => $post['refraction_ar_r_dd_axis']
			// );

		$dry_ref = array(
			'refraction_dry_ref_l_dt_sph' => $post['refraction_dry_ref_l_dt_sph'],
			'refraction_dry_ref_l_dt_cyl' => $post['refraction_dry_ref_l_dt_cyl'],
			'refraction_dry_ref_l_dt_axis' => $post['refraction_dry_ref_l_dt_axis'],
			'refraction_dry_ref_l_dt_vision' => $post['refraction_dry_ref_l_dt_vision'],
			'refraction_dry_ref_l_ad_sph' => $post['refraction_dry_ref_l_ad_sph'],
			'refraction_dry_ref_l_nr_sph' => $post['refraction_dry_ref_l_nr_sph'],
			'refraction_dry_ref_l_nr_cyl' => $post['refraction_dry_ref_l_nr_cyl'],
			'refraction_dry_ref_l_nr_axis' => $post['refraction_dry_ref_l_nr_axis'],
			'refraction_dry_ref_l_nr_vision' => $post['refraction_dry_ref_l_nr_vision'],

			'refraction_dry_ref_r_dt_sph' => $post['refraction_dry_ref_r_dt_sph'],
			'refraction_dry_ref_r_dt_cyl' => $post['refraction_dry_ref_r_dt_cyl'],
			'refraction_dry_ref_r_dt_axis' => $post['refraction_dry_ref_r_dt_axis'],
			'refraction_dry_ref_r_dt_vision' => $post['refraction_dry_ref_r_dt_vision'],
			'refraction_dry_ref_r_ad_sph' => $post['refraction_dry_ref_r_ad_sph'],
			'refraction_dry_ref_r_ad_vision' => $post['refraction_dry_ref_r_ad_vision'],
			'refraction_dry_ref_r_nr_sph' => $post['refraction_dry_ref_r_nr_sph'],
			'refraction_dry_ref_r_nr_cyl' => $post['refraction_dry_ref_r_nr_cyl'],
			'refraction_dry_ref_r_nr_axis' => $post['refraction_dry_ref_r_nr_axis'],
			'refraction_dry_ref_r_nr_vision' => $post['refraction_dry_ref_r_nr_vision'],
		);

		$ref_dtd = array(
			'refraction_ref_dtd_l_dt_sph' => $post['refraction_ref_dtd_l_dt_sph'],
			'refraction_ref_dtd_l_dt_cyl' => $post['refraction_ref_dtd_l_dt_cyl'],
			'refraction_ref_dtd_l_dt_axis' => $post['refraction_ref_dtd_l_dt_axis'],
			'refraction_ref_dtd_l_dt_vision' => $post['refraction_ref_dtd_l_dt_vision'],
			'refraction_ref_dtd_l_nr_sph' => $post['refraction_ref_dtd_l_nr_sph'],
			'refraction_ref_dtd_l_nr_cyl' => $post['refraction_ref_dtd_l_nr_cyl'],
			'refraction_ref_dtd_l_nr_axis' => $post['refraction_ref_dtd_l_nr_axis'],
			'refraction_ref_dtd_l_nr_vision' => $post['refraction_ref_dtd_l_nr_vision'],

			'refraction_ref_dtd_r_dt_sph' => $post['refraction_ref_dtd_r_dt_sph'],
			'refraction_ref_dtd_r_dt_cyl' => $post['refraction_ref_dtd_r_dt_cyl'],
			'refraction_ref_dtd_r_dt_axis' => $post['refraction_ref_dtd_r_dt_axis'],
			'refraction_ref_dtd_r_dt_vision' => $post['refraction_ref_dtd_r_dt_vision'],
			'refraction_ref_dtd_r_nr_sph' => $post['refraction_ref_dtd_r_nr_sph'],
			'refraction_ref_dtd_r_nr_cyl' => $post['refraction_ref_dtd_r_nr_cyl'],
			'refraction_ref_dtd_r_nr_axis' => $post['refraction_ref_dtd_r_nr_axis'],
			'refraction_ref_dtd_r_nr_vision' => $post['refraction_ref_dtd_r_nr_vision'],
		);


		$pmt = array(
			'refraction_pmt_l_dt_sph' => $post['refraction_pmt_l_dt_sph'],
			'refraction_pmt_l_dt_cyl' => $post['refraction_pmt_l_dt_cyl'],
			'refraction_pmt_l_dt_axis' => $post['refraction_pmt_l_dt_axis'],
			'refraction_pmt_l_dt_vision' => $post['refraction_pmt_l_dt_vision'],
			'refraction_pmt_l_nr_sph' => $post['refraction_pmt_l_nr_sph'],
			'refraction_pmt_l_nr_cyl' => $post['refraction_pmt_l_nr_cyl'],
			'refraction_pmt_l_nr_axis' => $post['refraction_pmt_l_nr_axis'],
			'refraction_pmt_l_nr_vision' => $post['refraction_pmt_l_nr_vision'],

			'refraction_pmt_r_dt_sph' => $post['refraction_pmt_r_dt_sph'],
			'refraction_pmt_r_dt_cyl' => $post['refraction_pmt_r_dt_cyl'],
			'refraction_pmt_r_dt_axis' => $post['refraction_pmt_r_dt_axis'],
			'refraction_pmt_r_dt_vision' => $post['refraction_pmt_r_dt_vision'],
			'refraction_pmt_r_nr_sph' => $post['refraction_pmt_r_nr_sph'],
			'refraction_pmt_r_nr_cyl' => $post['refraction_pmt_r_nr_cyl'],
			'refraction_pmt_r_nr_axis' => $post['refraction_pmt_r_nr_axis'],
			'refraction_pmt_r_nr_vision' => $post['refraction_pmt_r_nr_vision']
		);

		



		

		$ref_data = array( 'keratometry' => json_encode($keratometry), 'pgp' => json_encode($pgp), 'auto_refraction' => json_encode($auto_ref), 'dry_refraction' => json_encode($dry_ref), 'refraction_delated' => json_encode($ref_dtd), 'retinoscopy' => json_encode($retinoscopy), 'pmt' => json_encode($pmt), 'glass_prescription' => json_encode($glass_pres), 'inter_glass_presc' => json_encode($inter_gls_pres), 'contact_lens_presc' => json_encode($cont_lens_pres), 'color_vision' => json_encode($color_vision), 'contrast_sensivity' => json_encode($conta_sens), 'intraocular_press' => json_encode($intra_press), 'orthoptics' => json_encode($orthoptics), 'status' => 1, 'ip_address' => $_SERVER['REMOTE_ADDR'], 'created_by' => $user_data['id'], 'created_date' => date('Y-m-d H:i:s'));

		

		// echo "<pre>";
		// print_r($family_history);
		// print_r($chief_complaints);
		// print_r($ophthalmic);
		// print_r($systematic_history);
		// print_r($family_history);
		$his_data = array(
			'branch_id' => $post['branch_id'],
			'pres_id' => $prescriptionid,
			'booking_code' => $post['booking_code'],
			'patient_id' => $post['patient_id'],
			'booking_id' => $post['booking_id'],
			'symptom_fever' => $post['symptom_fever'],
			'symptom_cough' => $post['symptom_cough'],
			'symptom_smell_taste' => $post['symptom_smell_taste'],
			'symptom_loose_stools' => $post['symptom_loose_stools'],
			'symptom_local_zone' => $post['symptom_local_zone'],
			'symptom_travel' => $post['symptom_travel'],
			'symptom_contact' => $post['symptom_contact'],
			'free_test' => $post['visit_comm']
			,
			'medical' => $post['medical_history'],
			'chief_complaints' => json_encode($chief_complaints),
			'ophthalmic' => json_encode($ophthalmic),
			'systemic' => json_encode($systematic_history),
			'family_history' => json_encode($family_history_new),
			'drug_allergies' => json_encode($drug),
			'contact_allergies' => json_encode($contact_allergies),
			'food_allergies' => json_encode($food_allergies),
			'temperature' => $history_vital_temp,
			'pulse' => $history_vital_pulse,
			'blood_pressure' => $history_vital_bp,
			'rr' => $history_vital_rr,
			'height' => $history_anthropometry_height,
			'weight' => $history_anthropometry_weight,
			'bmi' => $history_anthropometry_bmi,
			'comment' => $history_anthropometry_comm,
			'status' => 1,
			'ip_address' => $_SERVER['REMOTE_ADDR'],
			'created_by' => $user_data['id'],
			'created_date' => date('Y-m-d H:i:s')
		);

		//Diagnosis
		$diagnosis_set = $post['diagnosis']['icd_data'];

		$diagnosis_check = isset($post['diagnosis_check']) ? '1' : '0';
		$data_diagnosis = array('branch_id' => $post['branch_id'], 'booking_code' => $post['booking_code'], 'pres_id' => $prescriptionid, 'patient_id' => $post['patient_id'], 'booking_id' => $post['booking_id'], 'diagnosis_data' => json_encode($diagnosis_set), 'provisional_check' => $diagnosis_check, 'provisional_cmnt' => $post['diagnosis_cmnt'], 'status' => 1, 'ip_address' => $_SERVER['REMOTE_ADDR'], 'created_by' => $user_data['id'], 'created_date' => date('Y-m-d H:i:s'));


		//Diagnosis
		echo "<pre>";print_r($ref_data);die;

		if (!empty($post['prescrption_id']) || $post['prescrption_id'] != '') {
			//   print_r($his_data);
			//echo "<pre>";
			//   print_r($post);
			//   print_r('prescrption_id IF');
			//          die;
			$this->db->where(array('branch_id' => $post['branch_id'], 'booking_id' => $post['booking_id'], 'type' => 1));
			$this->db->delete('hms_branch_vitals');
			//         echo "<pre>";
			//   print_r($post);
			//          die;
			if (!empty($post['data'])) {
				$current_date = date('Y-m-d H:i:s');
				foreach ($post['data'] as $key => $val) {

					$data = array(
						"branch_id" => $post['branch_id'],
						"type" => 1,
						"booking_id" => $post['booking_id'],
						"vitals_id" => $key,
						"vitals_value" => $val['name'],

					);

					$this->db->insert('hms_branch_vitals', $data);
					$id = $this->db->insert_id();
				}
			}
			

			$this->db->where('pres_id', $post['prescrption_id']);
			$this->db->where('booking_id', $post['booking_id']);
			$this->db->where('branch_id', $post['branch_id']);
			$this->db->update('hms_std_eye_prescription_refraction', $ref_data);

		} else {

			if (!empty($post['data'])) {
				$current_date = date('Y-m-d H:i:s');
				foreach ($post['data'] as $key => $val) {

					$data = array(
						"branch_id" => $post['branch_id'],
						"type" => 1,
						"booking_id" => $post['booking_id'],
						"vitals_id" => $key,
						"vitals_value" => $val['name'],

					);
					//  echo "<pre>";
					//  print_r($data);
					//  die;

					$this->db->insert('hms_branch_vitals', $data);
					$id = $this->db->insert_id();
				}
			}
			// echo "<pre>";
			// print_r($emeId);
			// die;

			$this->update_status_eme_booking($emeId);



			$this->db->insert('hms_std_eye_prescription_history', $his_data);
			$this->db->insert('hms_std_eye_prescription_refraction', $ref_data);
			$this->db->insert('hms_std_eye_prescription_examination', $data_exam);
			$this->db->insert('hms_std_eye_prescription_biometry', $data_biometry);
			$this->db->insert('hms_std_eye_prescription_investigation', $data_investigation);
			$this->db->insert('hms_std_eye_prescription_diagnosis_hierarchy', $data_diagnosis);
			$this->db->insert('hms_std_eye_prescription_advice', $data_advice);
		}
		//   print_r($his_data);
		//   print_r('else out');
		//          die;

		// Set drawing $prescriptionid
		$this->db->where('pres_id', $prescriptionid);
		$this->db->where('booking_id', $post['booking_id']);
		$this->db->delete('hms_eye_prescription_drawing');

		$drawing_data = $this->session->userdata('drawing_data');
		$user_data = $this->session->userdata('auth_users');
		if (!empty($drawing_data)) {
			foreach ($drawing_data as $drawing) {
				$d_arr = array(
					"booking_id" => $post['booking_id'],
					"pres_id" => $prescriptionid,
					"image" => $drawing['image'],
					"remark" => $drawing['remark'],
					"created_by" => $user_data['id'],
					"created_date" => date('Y-m-d H:i:s')
				);
				$this->db->insert('hms_eye_prescription_drawing', $d_arr);
			}
		}
		$drawing_data = $this->session->unset_userdata('drawing_data');

		// $prescriptionid

		$eye_file_upload = $this->session->userdata('eye_file_upload');
		//echo "<pre>"; print_r($eye_file_upload); exit;
		if (!empty($eye_file_upload)) {
			$this->db->where('booking_id', $post['booking_id']);
			$this->db->where('pres_id', $prescriptionid);
			$this->db->delete('hms_eye_std_prescription_files');
			foreach ($eye_file_upload as $eye_file) {
				$arr = array(
					'booking_id' => $post['booking_id'],
					'pres_id' => $prescriptionid,
					'file_name' => $eye_file['file_name'],
					'orig_name' => $eye_file['orig_name'],
					'created_date' => date('Y-m-d H:i:s')
				);
				$this->db->insert('hms_eye_std_prescription_files', $arr);
				//echo $this->db->last_query();//die();
			}
		}
		//die; 
		$this->session->unset_userdata('eye_file_upload');

		// End drawing
		return 1;
	}

	public function get_by_id($id) {
		// Select all fields from the hms_std_eye_prescription_refraction table
		$this->db->select('*');
		$this->db->from('hms_std_eye_prescription_refraction');
		$this->db->where('pres_id', $id); // Filter by the given id
		
		$query = $this->db->get(); // Execute the query
	
		// Check if any row is returned
		if ($query->num_rows() > 0) {
			return $query->row(); // Return a single row as an object
		} else {
			return false; // Return false if no record is found
		}
	}


	function get_by_refraction_below8_status($booking_id = '', $patient_id = '')
	{
		$user_data = $this->session->userdata('auth_users');
		$this->db->select('booking_id');
		$this->db->from('hms_std_eye_prescription');
		$this->db->where('hms_std_eye_prescription.booking_id', $booking_id);
		$this->db->where('hms_std_eye_prescription.patient_id', $patient_id);
		$this->db->where('hms_std_eye_prescription.is_deleted', 0);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return 1; // Return 1 if a match is found
		}

		return 0; //

	}
	
}