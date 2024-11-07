<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dilate_model extends CI_Model
{
	var $table = 'hms_dilated';
	var $column = array(
		'hms_dilated.id',
		'hms_dilated.branch_id',
		'hms_dilated.patient_id',
		'hms_dilated.booking_id',
		'hms_dilated.drop_name',
		'hms_dilated.salt',
		'hms_dilated.percentage',
		'hms_dilated.remarks',
		'hms_dilated.dilate_start_time',
		'hms_dilated.dilate_time',
		'hms_dilated.dilate_status',
		'hms_dilated.status',
		'hms_dilated.is_deleted', // Added to reflect the actual field
		'hms_dilated.deleted_by', // Added to reflect the actual field
		'hms_dilated.deleted_date', // Added to reflect the actual field
		'hms_dilated.ip_address',
		'hms_dilated.created_by',
		'hms_dilated.modified_by',
		'hms_dilated.modified_date',
		'hms_dilated.created_date'
	);
	var $order = array('hms_dilated.id' => 'desc');


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$search = $this->session->userdata('dilated_entry_search'); // Adjust session key as necessary
		$user_data = $this->session->userdata('auth_users');

		// Select fields relevant to hms_dilated table
		$this->db->select("hms_dilated.*, 
		hms_patient.patient_name, 
		hms_opd_booking.booking_code, 
		hms_opd_booking.token_no,  
		hms_medicine_entry.medicine_name"); 
		$this->db->from('hms_dilated'); // Main table
		$this->db->where('hms_dilated.is_deleted', '0');
		$this->db->where('hms_dilated.status', 1);

		// Example joins
		$this->db->join('hms_patient', 'hms_patient.id = hms_dilated.patient_id', 'left');
		$this->db->join('hms_opd_booking', 'hms_opd_booking.id = hms_dilated.booking_id', 'left');
		$this->db->join('hms_medicine_entry', 'hms_medicine_entry.id = hms_dilated.drop_name', 'left'); // Correct join based on the relationship

		// Adjust branch filtering logic
		if (!empty($search['branch_type']) && trim(strtolower($search['branch_type'])) == "self") {
			$this->db->where('hms_dilated.branch_id', $user_data['parent_id']);
		} else {
			if ($search['branch_type'] != "") {
				$this->db->where_in('hms_dilated.branch_id', $search['branch_type']);
			} else {
				$this->db->where_in('hms_dilated.branch_id', $user_data['parent_id']);
			}
		}

		// Search filters
		if (!empty($search['start_date'])) {
			$start_date = date('Y-m-d', strtotime($search['start_date'])) . ' 00:00:00';
			$this->db->where('hms_dilated.created_date >=', $start_date);
		}

		if (!empty($search['end_date'])) {
			$end_date = date('Y-m-d', strtotime($search['end_date'])) . ' 23:59:59';
			$this->db->where('hms_dilated.created_date <=', $end_date);
		}

		// Update search for `medicine_name` instead of `drop_name`
		if (!empty($search['drop_name'])) {
			$this->db->like('hms_medicine_entry.medicine_name', $search['drop_name']); // Search by medicine_name
		}

		if (!empty($search['percentage'])) {
			$this->db->where('hms_dilated.percentage', $search['percentage']);
		}

		if (isset($search['dilate_status']) && $search['dilate_status'] != "") {
			$this->db->where('hms_dilated.dilate_status', $search['dilate_status']);
		}

		// Implement search functionality for DataTables
		$i = 0;
		foreach ($this->column as $item) {
			if ($_POST['search']['value']) {
				if ($i === 0) {
					$this->db->group_start(); // Open grouping for where like conditions
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column) - 1 == $i) {
					$this->db->group_end(); // Close grouping for where like conditions
				}
			}
			$column[$i] = $item;
			$i++;
		}

		// Order processing
		if (isset($_POST['order'])) {
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}

		// Pagination - make sure it's implemented correctly
		if (isset($_POST['length']) && $_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
	}




	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die;
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->num_rows();
	}

	public function count_all()
	{
		// Retrieve session data
		$search = $this->session->userdata('medicine_entry_search');
		$user_data = $this->session->userdata('auth_users');

		// Set the table to count from
		$this->db->from('hms_dilated'); // Change this to your actual table name if it's different

		// Apply search conditions if they exist
		if (isset($search['branch_type']) && !empty($search['branch_type'])) {
			if ($search['branch_type'] == "self") {
				$this->db->where('branch_id', $user_data['parent_id']);
			} else {
				$this->db->where_in('branch_id', $search['branch_type']);
			}
		} else {
			$this->db->where('branch_id', $user_data['parent_id']);
		}

		// Check if the entry is not deleted
		$this->db->where('is_deleted', 0);

		// Count the results
		return $this->db->count_all_results();
	}


    public function get_booking_by_id($booking_id) {
        // Select all fields from both tables
        $this->db->select('hms_opd_booking.*, hms_patient.*');
        $this->db->from('hms_opd_booking');
        $this->db->join('hms_patient', 'hms_patient.id = hms_opd_booking.patient_id', 'left');
        $this->db->where('hms_opd_booking.booking_code', $booking_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
		// echo $this->db->last_query();die;
        return null;
    }
    public function get_booking_by_p_id($booking_id) {
		// echo "hihi";die;
        // Select all fields from both tables
        $this->db->select('hms_opd_booking.*, hms_patient.*');
        $this->db->from('hms_opd_booking');
        $this->db->join('hms_patient', 'hms_patient.id = hms_opd_booking.patient_id', 'left');
        $this->db->where('hms_opd_booking.patient_id', $booking_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
		// echo $this->db->last_query();die;
        return null;
    }

	public function dilate_start($id = '')
	{
		$time = strtotime(date('H:i:s'));
		$start_time_save = date("Y-m-d H:i:s");
		$endTime = date("H:i:s", strtotime('+30 minutes', $time));
		$end = date('Y-m-d ') . $endTime;

		// Update hms_opd_booking
		$this->db->set('dilate_time', $end);
		$this->db->set('dilate_start_time', $start_time_save);
		$this->db->set('dilate_status', 1);
		$this->db->where('id', $id);
		$this->db->update('hms_opd_booking');

		// Update hms_dilated table for the same booking_id
		$this->db->set('dilate_time', $end);
		$this->db->set('dilate_start_time', $start_time_save);
		$this->db->set('dilate_status', 1);
		$this->db->where('booking_id', $id); // Assuming `booking_id` in `hms_dilated` corresponds to `id` in `hms_opd_booking`
		$query = $this->db->update('hms_dilated');

		return $query;
	}

	public function dilate_stop($booked_id = 's')
	{
		if (empty($booked_id)) {
			return false;
		}

		// Assuming 'dilate_status' 2 means "stopped"
		// Update hms_opd_booking table
		$this->db->set('dilate_status', 2);  // Set status to 'stopped'
		$this->db->where('id', $booked_id);
		$this->db->update('hms_opd_booking');

		// Update hms_dilated table for the same booking_id
		$this->db->set('dilate_status', 2);  // Set status to 'stopped'
		$this->db->where('booking_id', $booked_id);  // Assuming booking_id corresponds to id in hms_opd_booking
		return $this->db->update('hms_dilated');
	}

    public function get_item_by_medicine($medicine_id) {
        // Select all fields from hms_medicine_entry
        $this->db->select('*');
        $this->db->from('hms_medicine_entry');
        $this->db->where('id', $medicine_id); // Assuming 'id' is the primary key in the medicine table
        $query = $this->db->get();

        // Check if any results were returned
        if ($query->num_rows() > 0) {
            return $query->row_array(); // Return the first result as an associative array
        }

        return null; // Return null if no data found
    }

    public function get_all_medicines() {
        $this->db->select('*');
        $this->db->from('hms_medicine_entry');
        $query = $this->db->get();

        // Return the result set as an array
        return $query->result_array();
    }


	function search_report_data()
	{

		$search = $this->session->userdata('medicine_entry_search');
		// print_r($search);die;
		$user_data = $this->session->userdata('auth_users');
		$this->db->select("hms_hospital_code_entry.*, hms_medicine_company.company_name, hms_medicine_unit.medicine_unit, hms_item_desc.item_desc, hms_hospital_code.hospital_code");
		$this->db->from($this->table);
		$this->db->where('hms_hospital_code_entry.is_deleted', '0');
		$this->db->join('hms_medicine_company', 'hms_medicine_company.id = hms_hospital_code_entry.manuf_company', 'left');
		$this->db->join('hms_medicine_unit', 'hms_medicine_unit.id = hms_hospital_code_entry.unit_id', 'left');
		$this->db->join('hms_item_desc', 'hms_item_desc.id = hms_hospital_code_entry.item_desc_id', 'left');
		$this->db->join('hms_hospital_code', 'hms_hospital_code.id = hms_hospital_code_entry.hos_code_id', 'left');



		if (!empty($search['branch_type']) && trim(strtolower($search['branch_type'])) == "self") {
			$this->db->where('hms_hospital_code_entry.branch_id', $user_data['parent_id']);
		} else {
			if ($search['branch_type'] != "") {
				$this->db->where_in('hms_hospital_code_entry.branch_id', $search['branch_type']);
			} else {
				$this->db->where_in('hms_hospital_code_entry.branch_id', $user_data['parent_id']);
			}
			/* $this->db->where('hms_hospital_code_entry.id NOT IN (select download_id from hms_hospital_code_entry where branch_id = "'.$user_data['parent_id'].'" AND is_deleted != 2)');*/

		}
		// $this->db->from($this->table);
		$i = 0;
		if (isset($search) && !empty($search)) {
			if (!empty($search['start_date'])) {
				$start_date = date('Y-m-d', strtotime($search['start_date'])) . ' 00:00:00';
				$this->db->where('hms_hospital_code_entry.created_date >= "' . $start_date . '"');
			}

			if (!empty($search['end_date'])) {
				$end_date = date('Y-m-d', strtotime($search['end_date'])) . ' 23:59:59';
				$this->db->where('hms_hospital_code_entry.created_date <= "' . $end_date . '"');
			}

			if (!empty($search['medicine_name'])) {
				$this->db->where('hms_hospital_code_entry.medicine_name LIKE "' . $search['medicine_name'] . '%"');
			}

			if (!empty($search['medicine_company'])) {
				$this->db->join('hms_medicine_company', 'hms_medicine_company.id = hms_hospital_code_entry.manuf_company', 'left');
				$this->db->where('hms_medicine_company.company_name LIKE"' . $search['medicine_company'] . '%"');
			}

			if (!empty($search['medicine_code'])) {

				$this->db->where('hms_hospital_code_entry.medicine_code', $search['medicine_code']);
			}



			if (isset($search['unit1']) && $search['unit1'] != "") {
				$this->db->where('hms_hospital_code_entry.unit_id = "' . $search['unit1'] . '"');
			}

			if (isset($search['unit2']) && $search['unit2'] != "") {
				$this->db->where('hms_hospital_code_entry.unit_second_id ="' . $search['unit2'] . '"');
			}

			if (isset($search['packing']) && $search['packing'] != "") {

				//$this->db->where('packing',$search['packing']);
				$this->db->where('hms_hospital_code_entry.packing LIKE "' . $search['packing'] . '%"');
			}

			if (isset($search['hsn_no']) && $search['hsn_no'] != "") {

				//$this->db->where('packing',$search['packing']);
				$this->db->where('hms_hospital_code_entry.hsn_no LIKE "' . $search['hsn_no'] . '%"');
			}

			if (isset($search['cgst']) && $search['cgst'] != "") {

				//$this->db->where('packing',$search['packing']);
				$this->db->where('hms_hospital_code_entry.cgst LIKE "' . $search['cgst'] . '%"');
			}
			if (isset($search['sgst']) && $search['sgst'] != "") {

				//$this->db->where('packing',$search['packing']);
				$this->db->where('hms_hospital_code_entry.sgst LIKE "' . $search['sgst'] . '%"');
			}
			if (isset($search['igst']) && $search['igst'] != "") {

				//$this->db->where('packing',$search['packing']);
				$this->db->where('hms_hospital_code_entry.igst LIKE "' . $search['igst'] . '%"');
			}

			if (isset($search['mrp_to']) && $search['mrp_to'] != "") {
				$this->db->where('hms_hospital_code_entry.mrp >="' . $search['mrp_to'] . '"');
			}

			if (isset($search['mrp_from']) && $search['mrp_from'] != "") {
				$this->db->where('hms_hospital_code_entry.mrp <="' . $search['mrp_from'] . '"');
			}

			if (isset($search['purchase_to']) && $search['purchase_to'] != "") {
				$this->db->where('hms_hospital_code_entry.purchase_rate >= "' . $search['purchase_to'] . '"');
			}

			if (isset($search['purchase_from']) && $search['purchase_from'] != "") {
				$this->db->where('hms_hospital_code_entry.purchase_rate <="' . $search['purchase_from'] . '"');
			}

			if (isset($search['rack_no']) && $search['rack_no'] != "") {
				//$this->db->join('hms_medicine_racks','hms_medicine_racks.id = hms_hospital_code_entry.rack_no','left');
				$this->db->where('hms_medicine_racks.rack_no', $search['rack_no']);

			}
			if (isset($search['min_alert']) && $search['min_alert'] != "") {
				$this->db->where('hms_hospital_code_entry.min_alrt', $search['min_alert']);
			}
			if (isset($search['discount']) && $search['discount'] != "") {
				$this->db->where('hms_hospital_code_entry.discount', $search['discount']);
			}
		}
		$query = $this->db->get();

		$data = $query->result();

		return $data;
	}



	public function get_by_id($id)
	{
		// Select fields from the main 'hms_dilated' table and join other related tables
		$this->db->select("hms_dilated.*, hms_medicine.medicine_name"); // Assuming you want to get medicine name

		// Specify the main table 'hms_dilated'
		$this->db->from('hms_dilated');

		// Apply where condition for the specific patient_id
		$this->db->where('hms_dilated.patient_id', $id);
		$this->db->where('hms_dilated.is_deleted', '0');
		$this->db->where('hms_dilated.status', '1');

		// Join with the 'hms_medicine' table (adjust if your table or field names are different)
		// Assuming 'drop_name' stores the medicine name and not an ID. If it is an ID, adjust the join condition accordingly
		$this->db->join('hms_medicine', 'hms_medicine.id = hms_dilated.drop_name', 'left');

		// Get the result and return it as an associative array
		$query = $this->db->get();

		// Return all the matching records for the patient_id as an array
		return $query->result_array(); // Changed to result_array to return all records
	}






	public function save()
	{
		$user_data = $this->session->userdata('auth_users');
		$post = $this->input->post();
		
		// Fetch dilate_start_time, dilate_time, and dilate_status from hms_opd_booking using booking_id
		$this->db->select('dilate_start_time, dilate_time, dilate_status');
		$this->db->where('id', $post['booking_id']);
		$booking_data = $this->db->get('hms_opd_booking')->row();

		// Prepare arrays to hold data for insert and update
		$insert_data = [];
		$update_data = [];
		$update_status_data = [];

		// Loop through the items to gather data
		foreach ($post['items'] as $item) {
			// Check if the record already exists based on booking_id and drop_name (medicine_name)
			$this->db->select('id, drop_name');
			$this->db->where('booking_id', $post['booking_id']);
			$this->db->where('drop_name', $item['medicine_name']);
			$existing_record = $this->db->get('hms_dilated')->row();

			// Prepare common data array for both insert and update
			$data = array(
				'branch_id' => $user_data['parent_id'],
				'patient_id' => $post['patient_id'], // Assuming patient_id is passed in POST
				'booking_id' => $post['booking_id'], // Assuming booking_id is passed in POST
				'drop_name' => $item['medicine_name'], // Fetching medicine_name from item
				'salt' => $item['salt'], // Fetching salt from item
				'percentage' => $item['percentage'], // Fetching percentage from item
				'remarks' => $post['remarks'], // Assuming remarks is passed in POST
				'dilate_start_time' => isset($booking_data->dilate_start_time) ? $booking_data->dilate_start_time : '', // Get from booking data
				'dilate_time' => isset($booking_data->dilate_time) ? $booking_data->dilate_time : '', // Get from booking data
				'dilate_status' => isset($booking_data->dilate_status) ? $booking_data->dilate_status : '', // Get from booking data
				'status' => $post['status'] ?? 1, // Default status
				'ip_address' => $this->input->ip_address(), // Get the client's IP address
			);

			// If the medicine already exists in the database, update it
			if ($existing_record) {
				// Prepare data for update
				$data['modified_by'] = $user_data['id'];
				$data['modified_date'] = date('Y-m-d H:i:s');
				$update_data[] = [
					'id' => $existing_record->id,
					'data' => $data,
				];
			} else {
				// If no record exists, prepare for insert
				$data['created_by'] = $user_data['id'];
				$data['created_date'] = date('Y-m-d H:i:s');
				$insert_data[] = $data;
			}
		}

		// Insert new records
		if (!empty($insert_data)) {
			$this->db->insert_batch('hms_dilated', $insert_data);
		}

		// Update existing records
		if (!empty($update_data)) {
			foreach ($update_data as $record) {
				$this->db->where('id', $record['id']);
				$this->db->update('hms_dilated', $record['data']);
			}
		}

		// Handle removing or deactivating any medicines not in the 'items' list (edit mode only)
		// Get all existing medicines for the current booking_id
		$this->db->select('id, drop_name');
		$this->db->where('booking_id', $post['booking_id']);
		$this->db->where('patient_id', $post['patient_id']);
		$existing_medicines = $this->db->get('hms_dilated')->result_array();

		// Find medicines that exist in the database but not in 'post['items']' array
		$medicine_names_in_post = array_column($post['items'], 'medicine_name');
		foreach ($existing_medicines as $existing_medicine) {
			// Check if the current medicine's 'drop_name' is not in the POST data and if the patient_id matches
			if (!in_array($existing_medicine['drop_name'], $medicine_names_in_post) ) {
				// Mark the medicine as inactive (status = 0) only if the patient_id matches
				$update_status_data[] = [
					'id' => $existing_medicine['id'],
					'data' => array(
						'status' => 0, // Deactivate the record
						'modified_by' => $user_data['id'],
						'modified_date' => date('Y-m-d H:i:s'),
					),
				];
			}
		}
		// echo "<pre>";print_r($update_status_data);

		// die;
		// Update the removed/deactivated medicines in the database
		if (!empty($update_status_data)) {
			foreach ($update_status_data as $record) {
				$this->db->where('id', $record['id']);
				$this->db->update('hms_dilated', $record['data']);
			}
		}
	}





	public function delete($id = "")
	{
		if (!empty($id) && $id > 0) {
			$user_data = $this->session->userdata('auth_users');
			$this->db->set('is_deleted', 1);
			$this->db->set('deleted_by', $user_data['id']);
			$this->db->set('deleted_date', date('Y-m-d H:i:s'));
			$this->db->where('id', $id);
			$this->db->update('hms_hospital_code_entry');
		}
	}

	public function deleteall($ids = array())
	{
		// echo "ok";die;
		if (!empty($ids)) {
			$id_list = [];
			foreach ($ids as $id) {
				if (!empty($id) && $id > 0) {
					$id_list[] = $id;
				}
			}
			$branch_ids = implode(',', $id_list);
			$user_data = $this->session->userdata('auth_users');
			$this->db->set('is_deleted', 1);
			$this->db->set('deleted_by', $user_data['id']);
			$this->db->set('deleted_date', date('Y-m-d H:i:s'));
			$this->db->where('patient_id IN (' . $branch_ids . ')');
			$this->db->update('hms_dilated');
		}
	}

	public function check_medicine($ids = array(), $branch_id = "", $self_id = "")
	{
		$reg_no = generate_unique_id(10);
		if (!empty($ids)) {
			$id_list = [];
			foreach ($ids as $id) {
				if (!empty($id) && $id > 0) {
					$ids_list[] = $id;

				}
			}
			$medicine_ids = implode(',', $ids_list);
			$user_data = $this->session->userdata('auth_users');

			$this->db->select("hms_hospital_code_entry.*,hms_medicine_company.company_name, hms_medicine_unit.medicine_unit,hms_medicine_unit_2.medicine_unit as medicine_second_unit,hms_medicine_racks.rack_no as rack_nu");
			$this->db->where('hms_hospital_code_entry.id IN (' . $medicine_ids . ')');
			$this->db->where('hms_hospital_code_entry.is_deleted', '0');
			$this->db->join('hms_medicine_company', 'hms_medicine_company.id=hms_hospital_code_entry.manuf_company', 'left');
			$this->db->join('hms_medicine_racks', 'hms_medicine_racks.id=hms_hospital_code_entry.rack_no', 'left');
			$this->db->join('hms_medicine_unit', 'hms_medicine_unit.id=hms_hospital_code_entry.unit_id', 'left');
			$this->db->join('hms_medicine_unit as hms_medicine_unit_2', 'hms_medicine_unit_2.id=hms_hospital_code_entry.unit_second_id', 'left');
			$result = $this->db->get('hms_hospital_code_entry')->result();
			foreach ($result as $result_data) {


				/* insert into unit table  */
				$result_new_unit = $result_data->unit_id;
				if (isset($result_new_unit) && !empty($result_new_unit)) {
					$medicine_unit = $result_data->medicine_unit;
					if (isset($medicine_unit) && !empty($medicine_unit)) {
						$unit = $this->check_unit($medicine_unit);
						if (!empty($unit)) {
							$unit_id = $unit[0]->id;
						} else {
							$data_unit = array(
								'branch_id' => $user_data['parent_id'],
								'medicine_unit' => $result_data->medicine_unit,
								'status' => 1,
								'ip_address' => $_SERVER['REMOTE_ADDR']
							);
							$this->db->set('created_by', $user_data['id']);
							$this->db->set('created_date', date('Y-m-d H:i:s'));
							$this->db->insert('hms_medicine_unit', $data_unit);
							$unit_id = $this->db->insert_id();
						}



					}

				} else {
					$unit_id = '0';
				}
				/* insert into unit table  */

				/* insert into second unit table  */
				$result_new_second_unit = $result_data->unit_second_id;
				if (isset($result_new_second_unit) && !empty($result_new_second_unit)) {
					$medicine_second_unit = $result_data->medicine_second_unit;
					if (isset($medicine_second_unit) && !empty($medicine_second_unit)) {
						$unit_second = $this->check_unit_second($medicine_second_unit);
						if (!empty($unit_second)) {
							$unit_second = $unit_second[0]->id;
						} else {
							$data_second_unit = array(
								'branch_id' => $user_data['parent_id'],
								'medicine_unit' => $result_data->medicine_second_unit,
								'status' => 1,
								'ip_address' => $_SERVER['REMOTE_ADDR']
							);
							$this->db->set('created_by', $user_data['id']);
							$this->db->set('created_date', date('Y-m-d H:i:s'));
							$this->db->insert('hms_medicine_unit', $data_second_unit);
							$unit_second = $this->db->insert_id();
						}



					}

				} else {
					$unit_second = '0';
				}
				/* insert into second unit table  */

				/* insert into rack table  */


				$result_new_rack = $result_data->rack_no;
				if (isset($result_new_rack) && !empty($result_new_rack)) {
					$medicine_rack = $result_data->rack_nu;
					if (isset($medicine_rack) && !empty($medicine_rack)) {
						$rack = $this->check_rack_no($medicine_rack);// print_r($rack);die;
						if (!empty($rack)) {
							$rack_id = $rack[0]->id;
						} else {

							$data_rack_no = array(
								'branch_id' => $user_data['parent_id'],
								'rack_no' => $result_data->rack_nu,
								'status' => 1,
								'ip_address' => $_SERVER['REMOTE_ADDR']
							);
							$this->db->set('created_by', $user_data['id']);
							$this->db->set('created_date', date('Y-m-d H:i:s'));
							$this->db->insert('hms_medicine_racks', $data_rack_no);
							$rack_id = $this->db->insert_id();
						}

					}

				} else {
					$rack_id = '';
				}

				/* insert into rack table  */


				/* insert into company table  */
				$result_new_company = $result_data->manuf_company;
				if (isset($result_new_company) && !empty($result_new_company)) {
					$medicine_comapny = $result_data->company_name;
					if (isset($medicine_comapny) && !empty($medicine_comapny)) {
						$company = $this->check_comapny_name($medicine_comapny);

						if (!empty($company)) {
							$company_id = $company[0]->id;
						} else {
							$data_company = array(
								'branch_id' => $user_data['parent_id'],
								'company_name' => $result_data->company_name,
								'status' => 1,
								'ip_address' => $_SERVER['REMOTE_ADDR']
							);
							$this->db->set('created_by', $user_data['id']);
							$this->db->set('created_date', date('Y-m-d H:i:s'));
							$this->db->insert('hms_medicine_company', $data_company);
							$company_id = $this->db->insert_id();
						}

					}

				} else {
					$company_id = '';
				}

				/* insert into company table  */


				/* insert into medicine table  */
				$data_medicine_entry = array(
					"medicine_code" => $reg_no,
					"medicine_name" => $result_data->medicine_name,
					'branch_id' => $user_data['parent_id'],
					"unit_id" => $unit_id,
					"unit_second_id" => $unit_second,
					"conversion" => $result_data->conversion,
					"min_alrt" => $result_data->min_alrt,
					"packing" => $result_data->packing,
					"rack_no" => $rack_id,
					"salt" => $result_data->salt,
					"manuf_company" => $company_id,
					"mrp" => $result_data->mrp,
					"purchase_rate" => $result_data->purchase_rate,
					"hsn_no" => $result_data->hsn_no,
					"discount" => $result_data->discount,
					'download_id' => $result_data->id,
					//"vat"=>$post['vat'],
					'cgst' => $result_data->cgst,
					'sgst' => $result_data->sgst,
					'igst' => $result_data->igst,
					"status" => $result_data->status
				);

				$this->db->set('created_by', $user_data['id']);
				$this->db->set('created_date', date('Y-m-d H:i:s'));
				$this->db->insert('hms_hospital_code_entry', $data_medicine_entry);
				/* insert into medicine table  */

			}
		}
	}

	public function medicine_entry_list()
	{
		$this->db->select('*');
		$query = $this->db->get('hms_hospital_code_entry');
		$result = $query->result();
		return $result;
	}

	public function check_unit($medicine_unit = "")
	{
		$users_data = $this->session->userdata('auth_users');
		$this->db->select('*');
		if (!empty($medicine_unit)) {
			$this->db->where('medicine_unit', $medicine_unit);
		}
		$this->db->where('branch_id', $users_data['parent_id']);

		$query = $this->db->get('hms_medicine_unit');
		$result = $query->result();

		return $result;
	}


	public function check_unit_second($medicine_unit = "")
	{
		$users_data = $this->session->userdata('auth_users');
		$this->db->select('*');
		if (!empty($medicine_unit)) {
			$this->db->where('medicine_unit', $medicine_unit);
		}
		$this->db->where('branch_id', $users_data['parent_id']);

		$query = $this->db->get('hms_medicine_unit');
		$result = $query->result();

		return $result;
	}



	public function check_rack_no($medicine_rack_no = "")
	{
		$users_data = $this->session->userdata('auth_users');
		$this->db->select('*');
		if (!empty($medicine_rack_no)) {
			$this->db->where('rack_no', $medicine_rack_no);
		}
		$this->db->where('branch_id', $users_data['parent_id']);
		$query = $this->db->get('hms_medicine_racks');
		$result = $query->result();
		return $result;
	}

	public function check_comapny_name($medicine_comapny_name = "")
	{
		$users_data = $this->session->userdata('auth_users');
		$this->db->select('*');
		if (!empty($medicine_comapny_name)) {
			$this->db->where('company_name', $medicine_comapny_name);
		}
		$this->db->where('branch_id', $users_data['parent_id']);
		$query = $this->db->get('hms_medicine_company');
		$result = $query->result();

		return $result;
	}
	public function check_medicine_name($medicine_comapny_name = "", $self_id = "")
	{
		$users_data = $this->session->userdata('auth_users');
		$this->db->select('*');
		if (!empty($medicine_comapny_name)) {
			$this->db->where('company_name', $medicine_comapny_name);
		}
		if (!empty($self_id)) {
			$this->db->where('branch_id', $self_id);

		}
		$query = $this->db->get('hms_medicine_company');
		$result = $query->result();

		return $result;
	}

	public function unit_second_list($unit_second_id = "")
	{
		$users_data = $this->session->userdata('auth_users');
		$this->db->select('*');
		$this->db->where('status', '1');
		if (!empty($unit_second_id)) {
			$this->db->where('id', $unit_second_id);
		}
		$this->db->order_by('medicine_unit', 'ASC');
		$this->db->where('is_deleted', 0);
		$this->db->where('branch_id', $users_data['parent_id']);
		$query = $this->db->get('hms_medicine_unit');
		$result = $query->result();
		return $result;
	}
	public function unit_list($unit_id = "")
	{
		//echo $unit_id;
		$users_data = $this->session->userdata('auth_users');
		$this->db->select('*');
		$this->db->where('status', '1');
		if (!empty($unit_id)) {

			$this->db->where('id', $unit_id);
		}
		$this->db->order_by('medicine_unit', 'ASC');
		$this->db->where('is_deleted', 0);
		$this->db->where('hms_medicine_unit.branch_id', $users_data['parent_id']);
		$query = $this->db->get('hms_medicine_unit');
		$result = $query->result();
		//print '<pre>'; print_r($result);
		return $result;
	}
	public function hospital_code_list($unit_id = "")
	{
		//echo $unit_id;
		$users_data = $this->session->userdata('auth_users');
		$this->db->select('*');
		$this->db->where('status', '1');
		if (!empty($unit_id)) {

			$this->db->where('id', $unit_id);
		}
		$this->db->order_by('hospital_code', 'ASC');
		$this->db->where('is_deleted', 0);
		$this->db->where('hms_hospital_code.branch_id', $users_data['parent_id']);
		$query = $this->db->get('hms_hospital_code');
		$result = $query->result();
		// print '<pre>'; print_r($result);
		return $result;
	}
	public function item_desc_list($unit_id = "")
	{
		//echo $unit_id;
		$users_data = $this->session->userdata('auth_users');
		$this->db->select('*');
		$this->db->where('status', '1');
		if (!empty($unit_id)) {

			$this->db->where('id', $unit_id);
		}
		$this->db->order_by('item_desc', 'ASC');
		$this->db->where('is_deleted', 0);
		$this->db->where('hms_item_desc.branch_id', $users_data['parent_id']);
		$query = $this->db->get('hms_item_desc');
		$result = $query->result();
		//print '<pre>'; print_r($result);
		return $result;
	}


	public function rack_list($rack_id = "")
	{
		$users_data = $this->session->userdata('auth_users');
		$this->db->select('*');
		if (!empty($rack_id)) {
			$this->db->where('id', $rack_id);
		}
		$this->db->where('status', '1');
		$this->db->order_by('rack_no', 'ASC');
		$this->db->where('is_deleted', 0);
		$this->db->where('hms_medicine_racks.branch_id', $users_data['parent_id']);
		$query = $this->db->get('hms_medicine_racks');
		$result = $query->result();
		return $result;
	}

	public function manuf_company_list($company_id = "")
	{
		$users_data = $this->session->userdata('auth_users');
		$this->db->select('*');
		if (!empty($company_id)) {
			$this->db->where('id', $company_id);
		}
		$this->db->where('status', '1');
		$this->db->order_by('company_name', 'ASC');
		$this->db->where('is_deleted', 0);
		$this->db->where('hms_medicine_company.branch_id', $users_data['parent_id']);
		$query = $this->db->get('hms_medicine_company');
		$result = $query->result();
		// echo $this->db->last_query();die;
		return $result;
	}


	public function get_salt_vals($vals = "")
	{
		$response = '';
		if (!empty($vals)) {
			$users_data = $this->session->userdata('auth_users');
			$this->db->select('hms_medicine_salt_master.salt');
			$this->db->order_by('hms_medicine_salt_master.salt', 'ASC');
			$this->db->where('hms_medicine_salt_master.salt LIKE "' . $vals . '%"');
			$query = $this->db->get('hms_medicine_salt_master');
			$result = $query->result();
			if (!empty($result)) {
				foreach ($result as $vals) {
					$response[] = $vals->salt;
				}
			}
			return $response;
		}
	}

	public function get_hsn_vals($vals = "")
	{
		$response = '';
		if (!empty($vals)) {
			$users_data = $this->session->userdata('auth_users');
			$this->db->select('hms_hsn_no_master.hsn_no');
			$this->db->order_by('hms_hsn_no_master.hsn_no', 'ASC');
			$this->db->where('hms_hsn_no_master.hsn_no LIKE "' . $vals . '%"');
			$query = $this->db->get('hms_hsn_no_master');
			$result = $query->result();
			if (!empty($result)) {
				foreach ($result as $vals) {
					$response[] = $vals->hsn_no;
				}
			}
			return $response;
		}
	}


	public function medicine_type_list($id = "")
	{
		//echo $unit_id;
		$users_data = $this->session->userdata('auth_users');
		$this->db->select('*');
		$this->db->where('hms_medicine_type.status', '1');
		if (!empty($unit_id)) {

			$this->db->where('hms_medicine_type.id', $id);
		}
		$this->db->order_by('hms_medicine_type.medicine_type_name', 'ASC');
		$this->db->where('hms_medicine_type.is_deleted', 0);
		$this->db->where('hms_medicine_type.branch_id', $users_data['parent_id']);
		$query = $this->db->get('hms_medicine_type');
		$result = $query->result();
		//print '<pre>'; print_r($result);
		return $result;
	}

	public function save_all_medicine($medicine_all_data = array())
	{
		$users_data = $this->session->userdata('auth_users');
		$user_data = $this->session->userdata('auth_users');
		if (!empty($medicine_all_data)) {
			foreach ($medicine_all_data as $medicine_data) {
				if (!empty($medicine_data['unit_id'])) {
					//check simulation start
					$unit_id = '';
					if (!empty($medicine_data['unit_id'])) {
						$this->db->select("hms_medicine_unit.*");
						$this->db->from('hms_medicine_unit');
						$this->db->where('LOWER(hms_medicine_unit.medicine_unit)', strtolower($medicine_data['unit_id']));
						$this->db->where('hms_medicine_unit.branch_id=' . $users_data['parent_id']);
						$query = $this->db->get();
						// echo $this->db->last_query();die;
						$unit_data = $query->result_array();

						if (!empty($unit_data)) {
							$unit_id = $unit_data[0]['id'];
						} else {
							$units_data = array(
								'branch_id' => $users_data['parent_id'],
								'medicine_unit' => $medicine_data['unit_id'],
								'status' => 1,
								'ip_address' => $_SERVER['REMOTE_ADDR']
							);


							$this->db->set('created_by', $user_data['id']);
							$this->db->set('created_date', date('Y-m-d H:i:s'));
							$this->db->insert('hms_medicine_unit', $units_data);
							$unit_id = $this->db->insert_id();

						}
					}
					/*second unite id */

					$unit_second_id = '';
					if (!empty($medicine_data['unit_second_id'])) {
						$this->db->select("hms_medicine_unit.*");
						$this->db->from('hms_medicine_unit');
						$this->db->where('LOWER(hms_medicine_unit.medicine_unit)', strtolower($medicine_data['unit_second_id']));
						$this->db->where('hms_medicine_unit.branch_id=' . $users_data['parent_id']);
						$query = $this->db->get();
						// echo $this->db->last_query();die;
						$second_unit_data = $query->result_array();

						if (!empty($second_unit_data)) {
							$unit_second_id = $second_unit_data[0]['id'];
						} else {
							$second_units_data = array(
								'branch_id' => $users_data['parent_id'],
								'medicine_unit' => $medicine_data['unit_second_id'],
								'status' => 1,
								'ip_address' => $_SERVER['REMOTE_ADDR']
							);


							$this->db->set('created_by', $user_data['id']);
							$this->db->set('created_date', date('Y-m-d H:i:s'));
							$this->db->insert('hms_medicine_unit', $second_units_data);
							$unit_second_id = $this->db->insert_id();

						}
					}

					/* end of second unique */

					/*  manufacturing company*/

					//insurance company
					$manuf_company = '';
					if (!empty($medicine_data['manuf_company'])) {
						$this->db->select("hms_medicine_company.*");
						$this->db->from('hms_medicine_company');
						$this->db->where('LOWER(hms_medicine_company.company_name)', strtolower($medicine_data['manuf_company']));
						$this->db->where('hms_medicine_company.branch_id=' . $users_data['parent_id']);
						$query = $this->db->get();
						// echo $this->db->last_query();die;
						$manuf_company_data = $query->result_array();

						if (!empty($manuf_company_data)) {
							$manuf_company = $manuf_company_data[0]['id'];
						} else {
							$manuf_company_data = array(
								'branch_id' => $user_data['parent_id'],
								'company_name' => $medicine_data['manuf_company'],
								'status' => 1,
								'ip_address' => $_SERVER['REMOTE_ADDR']
							);
							$this->db->set('created_by', $user_data['id']);
							$this->db->set('created_date', date('Y-m-d H:i:s'));
							$this->db->insert('hms_medicine_company', $manuf_company_data);
							$manuf_company = $this->db->insert_id();
						}
					}

					/* end of manufactoring company */

					//rake no
					$rack_no = '';
					if (!empty($medicine_data['rack_no'])) {
						$this->db->select("hms_medicine_racks.*");
						$this->db->from('hms_medicine_racks');
						$this->db->where('LOWER(hms_medicine_racks.rack_no)', strtolower($medicine_data['rack_no']));
						$this->db->where('hms_medicine_racks.branch_id=' . $users_data['parent_id']);
						$query = $this->db->get();
						// echo $this->db->last_query();die;
						$rack_no_data = $query->result_array();

						if (!empty($rack_no_data)) {
							$rack_no = $rack_no_data[0]['id'];
						} else {
							$rack_no_datas = array(
								'branch_id' => $user_data['parent_id'],
								'rack_no' => $medicine_data['rack_no'],
								'status' => 1,
								'ip_address' => $_SERVER['REMOTE_ADDR']
							);
							$this->db->set('created_by', $user_data['id']);
							$this->db->set('created_date', date('Y-m-d H:i:s'));
							$this->db->insert('hms_medicine_racks', $rack_no_datas);
							$rack_no = $this->db->insert_id();
						}
					}

					/* end of rack no */

					if (!empty($medicine_data['min_alrt'])) {
						$min_alrt = $medicine_data['min_alrt'];
					} else {
						$min_alrt = '0';
					}
					if (!empty($medicine_data['mrp'])) {
						$mrp = $medicine_data['mrp'];
					} else {
						$mrp = '0';
					}
					if (!empty($medicine_data['purchase_rate'])) {
						$purchase_rate = $medicine_data['purchase_rate'];
					} else {
						$purchase_rate = '0';
					}
					$data_medicine = array(
						"medicine_name" => $medicine_data['medicine_name'],
						'branch_id' => $user_data['parent_id'],
						"unit_id" => $unit_id,
						"unit_second_id" => $unit_second_id,
						"conversion" => $medicine_data['conversion'],
						"min_alrt" => $min_alrt,
						"packing" => $medicine_data['packing'],
						"rack_no" => $rack_no,
						"salt" => $medicine_data['salt'],
						"manuf_company" => $manuf_company,
						"mrp" => $mrp,
						"purchase_rate" => $purchase_rate,
						"hsn_no" => $medicine_data['hsn_no'],
						"discount" => $medicine_data['discount'],
						//"vat"=>$post['vat'],
						'cgst' => $medicine_data['cgst'],
						'sgst' => $medicine_data['sgst'],
						'igst' => $medicine_data['igst'],
						"status" => 1,
						'bar_code' => $medicine_data['bar_code'],
						'medicine_type' => $medicine_data['medicine_type']
					);

					$reg_no = generate_unique_id(10);
					$this->db->set('medicine_code', $reg_no);
					$this->db->set('created_by', $user_data['id']);
					$this->db->set('created_date', date('Y-m-d H:i:s'));
					$this->db->insert('hms_hospital_code_entry', $data_medicine);
					$medicine_id = $this->db->insert_id();
					//echo $this->db->last_query(); exit;
					//barcode image and text generation 
					if (!empty($medicine_id)) {
						if (!empty($medicine_data['bar_code'])) {
							$text = $medicine_data['bar_code'];
						} else {
							$text = $medicine_id . time();
						}

						$barcode_settings = barcode_setting();
						if (!empty($barcode_settings)) {
							$orientation = $barcode_settings->type;
							$size = $barcode_settings->size;
							$barcode_text = generate_medicine_barcode($text, $orientation, $code_type = 'code128', $size);

							if (!empty($barcode_text)) {
								$this->db->set('bar_code', $barcode_text);
								$this->db->set('barcode_type', $orientation);
								$this->db->set('barcode_image', $barcode_text . '.png');
								$this->db->where('id', $medicine_id);
								$this->db->update('hms_hospital_code_entry');
								//echo $this->db->last_query(); exit;
							}
						}

					}
					///ends
					//echo $this->db->last_query(); exit;
				}
			}
		}

	}

	public function medicine_list_search()
	{
		$users_data = $this->session->userdata('auth_users');
		$post = $this->input->post();
		$this->db->select('hms_hospital_code_entry.id,hms_hospital_code_entry.medicine_name');
		if (!empty($post['medicine_name'])) {
			$this->db->where('hms_hospital_code_entry.medicine_name LIKE "' . $post['medicine_name'] . '%"');
		}
		$this->db->where('hms_hospital_code_entry.branch_id  IN (' . $users_data['parent_id'] . ')');
		$this->db->where('hms_hospital_code_entry.is_deleted', '0');
		$this->db->limit(50);
		$this->db->from('hms_hospital_code_entry');
		$query = $this->db->get();
		return $query->result();
	}

	public function medicine_com_list_search()
	{
		$users_data = $this->session->userdata('auth_users');
		$post = $this->input->post();
		//print_r($post);die();
		$this->db->select('hms_medicine_company.id,hms_medicine_company.company_name');
		if (!empty($post['company_name'])) {
			$this->db->where('hms_medicine_company.company_name LIKE "' . $post['company_name'] . '%"');
		}
		$this->db->where('hms_medicine_company.branch_id  IN (' . $users_data['parent_id'] . ')');
		$this->db->where('hms_medicine_company.is_deleted', '0');
		$this->db->limit(50);
		$this->db->from('hms_medicine_company');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_item_by_code($hospital_code_id)
	{
		// Fetch item details based on hospital_code
		$this->db->select('hms_hospital_code_entry.*, hms_medicine_company.company_name, hms_medicine_unit.medicine_unit, hms_item_desc.item_desc, hms_hospital_code.hospital_code');
		$this->db->from('hms_hospital_code_entry');
		$this->db->join('hms_hospital_code', 'hms_hospital_code.id=hms_hospital_code_entry.hos_code_id', 'left');
		$this->db->join('hms_item_desc', 'hms_item_desc.id=hms_hospital_code_entry.item_desc_id', 'left');
		$this->db->join('hms_medicine_unit', 'hms_medicine_unit.id=hms_hospital_code_entry.unit_id', 'left');
		$this->db->join('hms_medicine_company', 'hms_medicine_company.id=hms_hospital_code_entry.manuf_company', 'left');
		$this->db->where('hms_hospital_code_entry.hos_code_id', $hospital_code_id);
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die;
		// return $q
		// Check if the query was successful
		if (!$query) {
			// Log the error message for debugging
			log_message('error', 'Database error: ' . $this->db->last_query());
			log_message('error', 'Error Message: ' . $this->db->error()['message']); // Log the error message
			return []; // Return an empty array if there was an error
		}

		// Return the result set
		return $query->result();
	}



}
?>