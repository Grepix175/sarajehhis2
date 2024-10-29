<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Contact_lens_model extends CI_Model
{
	var $table = 'hms_contact_lens';
	var $column = array('hms_contact_lens.id', 'hms_contact_lens.patient_id', 'hms_contact_lens.booking_id', 'hms_contact_lens.hospital_code', 'hms_contact_lens.item_description', 'hms_contact_lens.menufacturer', 'hms_contact_lens.qty', 'hms_contact_lens.unit', 'hms_contact_lens.hospital_rate', 'hms_contact_lens.status', 'hms_contact_lens.created_date', 'hms_contact_lens.modified_date');
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
		// Select only required fields from hms_patient and hms_opd_booking
		$this->db->select("hms_contact_lens.id,hms_contact_lens.booking_id,hms_contact_lens.patient_id,hms_patient.simulation_id,hms_patient.patient_name,hms_patient.patient_code,hms_patient.mobile_no,hms_patient.age_y,hms_patient.age_m,hms_patient.age_d,hms_opd_booking.dilate_status,hms_opd_booking.app_type,hms_opd_booking.token_no, hms_opd_booking.booking_code,hms_contact_lens.created_date");
		$this->db->from('hms_contact_lens');
		$this->db->join('hms_patient', 'hms_patient.id = hms_contact_lens.patient_id', 'left');
		$this->db->join('hms_opd_booking', 'hms_opd_booking.id = hms_contact_lens.booking_id', 'left');

		// Filter records that are not deleted
		$this->db->where('hms_contact_lens.is_deleted', '0');

		// Branch filtering
		if (!empty($search['branch_id'])) {
			$this->db->where_in('hms_contact_lens.branch_id', explode(',', $search['branch_id']));
		} else {
			$this->db->where('hms_contact_lens.branch_id', $user_data['parent_id']);
		}

		// Search conditions
		if (!empty($search)) {
			if (!empty($search['start_date'])) {
				$start_date = date('Y-m-d 00:00:00', strtotime($search['start_date']));
				$this->db->where('hms_contact_lens.created_date >=', $start_date);
			}

			if (!empty($search['end_date'])) {
				$end_date = date('Y-m-d 23:59:59', strtotime($search['end_date']));
				$this->db->where('hms_contact_lens.created_date <=', $end_date);
			}

			if (isset($search['patient_name']) && !empty($search['patient_name'])) {
				$this->db->where('hms_patient.patient_name LIKE "%' . trim($search['patient_name']) . '%"');
			}

			if (!empty($search['patient_code'])) {
				$this->db->where('hms_patient.patient_code', $search['patient_code']);
			}

			if (!empty($search['mobile_no'])) {
				$this->db->like('hms_patient.mobile_no', $search['mobile_no'], 'after');
			}
		}

		// DataTables search functionality
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

		// Group by booking_id and patient_id
		$this->db->group_by(['hms_contact_lens.booking_id', 'hms_contact_lens.patient_id']);

		// Ordering for DataTables
		if (isset($_POST['order'])) {
			// Specify the table for the ordering column
			$order_column = $this->column[$_POST['order']['0']['column']];

			// Assuming you're using the contact_lens table
			$this->db->order_by('hms_contact_lens.' . $order_column, $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$this->db->order_by('hms_contact_lens.' . key($this->order), $this->order[key($this->order)]);
		}

	}


	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		// $last_query = $this->db->last_query();
		// echo "<pre>";
		// print_r($last_query);
		// echo "</pre>";

		// // Optionally display the results
		// if ($query->num_rows() > 0) {
		// 	$results = $query->result_array();
		// 	print_r($results); // Display results if needed
		// } else {
		// 	echo "No records found.";
		// }
		return $query->result();
	}


	function count_filtered()
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

	public function get_by_id($id, $booking_id, $patient_id)
	{
		$this->db->select("hms_contact_lens.*");
		$this->db->from('hms_contact_lens');
		$this->db->where('hms_contact_lens.booking_id', $booking_id);
		$this->db->where('hms_contact_lens.patient_id', $patient_id);
		$this->db->where('hms_contact_lens.is_deleted', '0');

		$query = $this->db->get();
		return $query->result_array(); // Return all records as an array
	}


	public function save()
	{
		$user_data = $this->session->userdata('auth_users');
		$post = $this->input->post();
		// echo "<pre>";
		// print_r($post['contact_lens_items']);
		// die;
		// Initializing the data ID
		$data_id = $post['data_id'] ?? null;

		// Prepare the common data fields for both insert and update
		$data = [
			'branch_id' => $user_data['parent_id'],
			'booking_id' => $post['booking_id'],
			'patient_id' => $post['patient_id'],
			'modified_date' => date('Y-m-d H:i:s')
		];

		// If `data_id` exists, perform an update
		if (!empty($data_id) && $data_id > 0) {
			// Update the main contact lens entry
			// $this->db->where('id', $data_id);
			// $this->db->update($this->table, $data);

			// Now handle the items update (assuming items are related to this main entry)
			if (isset($post['items']) && !empty($post['items'])) {
				// Optional: Clear the existing items before updating (if needed)
				// $this->db->where('contact_lens_id', $data_id);
				$this->db->where('booking_id', $post['booking_id']);
				$this->db->where('patient_id', $post['patient_id']);
				$this->db->delete('hms_contact_lens');

				// Insert new or updated items
				$this->insert_items($data_id, $post['contact_lens_items'], $user_data, $post);
			}

		} else { // If `data_id` is not provided, perform an insert
			// Insert new data into the main table
			// $data['created_at'] = date('Y-m-d H:i:s');
			// $this->db->set('ip_address', $_SERVER['REMOTE_ADDR']);
			// $this->db->set('created_by', $user_data['id']);
			// $this->db->insert('hms_contact_lens');

			// Get the last inserted ID for the new record
			// Insert the items if available
			if (isset($post['contact_lens_items']) && !empty($post['contact_lens_items'])) {
				$this->insert_items($data_id, $post['contact_lens_items'], $user_data, $post);
			}
			$data_id = $this->db->insert_id();

		}

		// Return the ID of the inserted or updated record
		return $data_id;
	}

	// Helper function to insert items related to the main contact lens entry
	private function insert_items($data_id, $contact_lens_items_json, $user_data, $post)
	{
		$items = json_decode($contact_lens_items_json, true);
		// echo "<pre>";
		// print_r($items);
		// die;
		foreach ($items as $item) {
			$item_data = [
				// 'contact_lens_id' => $data_id,
				// 'sl_no' => isset($item['sl_no']) ? $item['sl_no'] : null,
				'branch_id' => $user_data['parent_id'],
				'booking_id' => $post['booking_id'],
				'patient_id' => $post['patient_id'],
				'hospital_code' => isset($item['hospital_code_name']) ? $item['hospital_code_name'] : null,
				'item_description' => isset($item['item_description_name']) ? $item['item_description_name'] : null,
				'menufacturer' => isset($item['manufacturer_name']) ? $item['manufacturer_name'] : null,
				'qty' => isset($item['qty']) ? $item['qty'] : null,
				'unit' => isset($item['unit_name']) ? $item['unit_name'] : null,
				'hospital_rate' => isset($item['hospital_rate']) ? $item['hospital_rate'] : null,
				'created_date' => date('Y-m-d H:i:s'),
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				'created_by' => $user_data['id']
			];

			// print_r($item_data);
			// die;
			// Insert each item into the items table
			$this->db->insert('hms_contact_lens', $item_data);
		}
		// die('okay');
	}



	public function delete($id = "")
	{
		if (!empty($id) && $id > 0) {
			$user_data = $this->session->userdata('auth_users');
			$this->db->set('is_deleted', 1);
			$this->db->set('deleted_by', $user_data['id']);
			$this->db->set('deleted_date', date('Y-m-d H:i:s'));
			$this->db->where('id', $id);
			$this->db->update('hms_contact_lens');
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
			$helpdesk_ids = implode(',', $id_list);
			$user_data = $this->session->userdata('auth_users');
			$this->db->set('is_deleted', 1);
			$this->db->set('deleted_by', $user_data['id']);
			$this->db->set('deleted_date', date('Y-m-d H:i:s'));
			$this->db->where('id IN (' . $helpdesk_ids . ')');
			$this->db->update('hms_contact_lens');
			//echo $this->db->last_query();die;
		}
	}

	function get_by_contact_lens_status($booking_id = '', $patient_id = '')
	{
		$user_data = $this->session->userdata('auth_users');
		$this->db->select('booking_id');
		$this->db->from('hms_contact_lens');
		$this->db->where('hms_contact_lens.booking_id', $booking_id);
		$this->db->where('hms_contact_lens.patient_id', $patient_id);
		$this->db->where('hms_contact_lens.is_deleted', 0);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return 1; // Return 1 if a match is found
		}

		return 0; //

	}

	function search_report_data($id = '', $booking_id = '', $patient_id = '')
	{
		$search = $this->session->userdata('ipd_booking_search');
		$user_data = $this->session->userdata('auth_users');

		$this->db->select("
		hms_contact_lens.id AS contact_lens_id,
		hms_contact_lens.hospital_code,
		hms_contact_lens.item_description,
		hms_contact_lens.menufacturer,
		hms_contact_lens.qty,
		hms_contact_lens.unit,
		hms_contact_lens.hospital_rate,
		hms_contact_lens.created_date,
		hms_contact_lens.booking_id,
		hms_contact_lens.patient_id,
		hms_patient.simulation_id,
		hms_patient.patient_name,
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
	
	$this->db->from('hms_contact_lens');
	$this->db->join('hms_patient', 'hms_patient.id = hms_contact_lens.patient_id', 'left');
	$this->db->join('hms_opd_booking', 'hms_opd_booking.id = hms_contact_lens.booking_id', 'left');

	$this->db->where('hms_contact_lens.booking_id', $booking_id);
	$this->db->where('hms_contact_lens.patient_id', $patient_id);
	
	// Filter out deleted records
	$this->db->where('hms_contact_lens.is_deleted', '0');
	
	// Role-based filtering (if necessary)
	if ($user_data['users_role'] == 4) {
		if (!empty($branch_id)) {
			$this->db->where('hms_contact_lens.patient_id', $branch_id);
		} else {
			$this->db->where('hms_contact_lens.patient_id', $user_data['parent_id']);
		}
	} elseif ($user_data['users_role'] == 3) {
		$this->db->where('hms_opd_booking.referral_doctor', $user_data['parent_id']);
	} else {
		if (!empty($branch_id)) {
			$this->db->where('hms_contact_lens.branch_id', $branch_id);
		} else {
			$this->db->where('hms_contact_lens.branch_id', $user_data['parent_id']);
		}
	}
	
	// Execute the query
	$query = $this->db->get();
	
	// Check for errors
	if (!$query) {
		log_message('error', 'Query failed: ' . $this->db->last_query());
		log_message('error', 'Error message: ' . $this->db->error()['message']);
		return []; // Handle error appropriately
	}
	
	// Initialize an array to hold the structured results
	$results = [];
	
	// Process the query results
	foreach ($query->result() as $row) {
		// Create a unique key based on patient and booking ID
		$key = $row->patient_id . '-' . $row->booking_id;
	
		// Check if the patient already exists in the results
		if (!isset($results[$key])) {
			// Initialize the patient object
			$results[$key] = [
				'patient_id' => $row->patient_id,
				'simulation_id' => $row->simulation_id,
				'patient_name' => $row->patient_name,
				'patient_code' => $row->patient_code,
				'mobile_no' => $row->mobile_no,
				'age_y' => $row->age_y,
				'age_m' => $row->age_m,
				'age_d' => $row->age_d,
				'dilate_status' => $row->dilate_status,
				'app_type' => $row->app_type,
				'token_no' => $row->token_no,
				'booking_code' => $row->booking_code,
				'contact_lens' => [] // Initialize empty array for contact lens records
			];
		}
	
		// Add the contact lens record to the patient's contact lens array
		$results[$key]['contact_lens'][] = [
			'id' => $row->contact_lens_id,
			'booking_id' => $row->booking_id,
			'hospital_code' => $row->hospital_code,
			'item_description' => $row->item_description,
			'menufacturer' => $row->menufacturer,
			'qty' => $row->qty,
			'unit' => $row->unit,
			'hospital_rate' => $row->hospital_rate,
			'created_date' => $row->created_date
		];
	}
	
	// Return the structured array as an array of objects
	return array_values($results); // Convert associative array back to indexed array
	




	}
}
?>