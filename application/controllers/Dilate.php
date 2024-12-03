<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dilate extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('dilate/Dilate_model', 'dilate');
        $this->load->model('opd/Opd_model', 'opd');
        $this->load->library('form_validation');
        $this->load->model('eye/add_prescription/add_new_prescription_model', 'add_prescript');
        error_reporting(0);

    }

    public function index()
    {

        $data['page_title'] = 'Dilate Records';
        $this->load->model('default_search_setting/default_search_setting_model');
        $default_search_data = $this->default_search_setting_model->get_default_setting();
        if (isset($default_search_data[1]) && !empty($default_search_data) && $default_search_data[1] == 1) {
            $start_date = '';
            $end_date = '';
        } else {
            $start_date = date('d-m-Y');
            $end_date = date('d-m-Y');
        }
        $data['form_data'] = array('patient_name' => '', 'patient_code' => '','mobile_no' => '', 'start_date' => $start_date, 'end_date' => $end_date);
        
        $this->load->view('dilate/list', $data);
    }



    public function ajax_list()
    {
        $list = $this->dilate->get_datatables();
        // Assuming you want to fetch booking data based on the first patient's booking_id
        // echo "<pre>";print_r($list);die;
        $data['booking_data'] = $this->dilate->get_booking_by_id($list[0]->booking_id,$list[0]->patient_id);
        $data['opd'] = $this->dilate->get_booking_by_p_id($list[0]->booking_id,$list[0]->patient_id);
        $data = array();
        $no = $_POST['start'];
        
        // Group records by patient_id
        $grouped_data = [];
        foreach ($list as $dilated) {
            $grouped_data[$dilated->patient_id][] = $dilated;
        }
        
        // echo "<pre>";print_r($grouped_data);die;
        // Iterate through grouped data (grouped by patient_id)
        foreach ($grouped_data as $patient_id => $records) {
            // echo "<pre>";print_r($records);die;
            $no++;
            $row = array();

            // Checkbox for selection (use patient_id or any unique identifier for selection)
            $row[] = '<input type="checkbox" name="prescription[]" class="checklist" value="' . $patient_id . '">';

            // Patient code auto (you can replace it with actual logic if needed)
            $row[] = $records[0]->token??1;

            // Assuming you want to show patient_id for the first record in the group
            $row[] = $records[0]->patient_no;

            // Booking code (showing booking_id from the first record)
            $row[] = $records[0]->booking_code;

            // Concatenate medicine names, salts, and percentages for all records with the same patient_id
            $medicine_names = [];
            $salts = [];
            $percentages = [];
            foreach ($records as $dilated) {
                $medicine_names[] = $dilated->medicine_name;
                $salts[] = $dilated->salt;
                $percentages[] = $dilated->percentage;
            }

            // Combine medicine names as a comma-separated string
            $row[] = implode(', ', $medicine_names);

            // Patient name (showing patient name from the first record in the group)
            $row[] = $records[0]->patient_name;

            // Age (showing age from the booking data)
            $row[] = implode(', ', $salts);
            $row[] = $records[0]->status == 0 ? '<font color="green">Pending</font>' : '<font color="red">Completed</font>';

            $statuses = explode(',', $records[0]->pat_status);

            // Trim any whitespace from the statuses and get the last one
            $last_status = trim(end($statuses));

            // Display the last status with the desired styling
            $row[] = '<font style="background-color: #228B30;color:white">'.$last_status.'</font>';

            // Created at date (showing created date from the first record in the group)
            $row[] = date('d-M-Y', strtotime($records[0]->created_date));
            
            // echo "<pre>";
            // print_r($patient_id);
            // die('okay');
            // Add action buttons
            $send_to = '';
            if ($records[0]->status == 0) {
                $send_to = '<button type="button" class="btn-custom open-popup-send-to" 
                            id="open-popup" 
                            data-booking-id="' . $records[0]->booking_id . '" 
                            data-patient-id="' . $records[0]->patient_id . '" 
                            data-referred-by="' . $records[0]->attended_doctor . '" 
                            data-mod-type="dilate" 
                            data-url="' . $records[0]->url . '" 
                            title="">Send To</button>';
              }else{
                $send_to = '<a class="btn-custom disabled" href="javascript:void(0);" title="Send To Vision" style="pointer-events: none; opacity: 0.6;" data-url="512"> Send To</a>';
              }
            $row[] = '<a onClick="return edit_dilate(\'' . $patient_id . '\');" class="btn-custom" href="javascript:void(0)" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                    <a href="javascript:void(0)" class="btn-custom" onClick="return print_window_page(\'' . base_url("dilate/print_dilate/" . $patient_id) . '\');">
                        <i class="fa fa-print"></i> Print
                    </a>' . $send_to ;
            $row[] = $records[0]->emergency_status;


            // Add row to data array
            $data[] = $row;
        }

        // Output response for DataTable
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->dilate->count_all(),
            "recordsFiltered" => $this->dilate->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);
    }




    public function add($booking_id = null, $patient_id = null)
    {
        // echo "<pre>";
        // print_r($booking_id);
        // print_r($patient_id);
        // die('okay');
        // Load required models and libraries
        $this->load->library('form_validation');
        $this->load->model('contact_lens/contact_lens_model'); // Ensure this model is loaded
        $this->load->model('contact_lens/contact_lens_model'); // Ensure this model is loaded
        // $data['side_effects'] = $this->contact_lens->get_all_side_effects(); // Fetch side effects
        $data['page_title'] = 'Add Dilate Record';
        $result = $this->add_prescript->get_new_data_by_id($booking_id);
        $data['datas'] = $result;

        // echo "<pre>";print_r($booking_id);die;
        $data['booking_id'] = isset($booking_id) ? $booking_id : '';
        $data['hospital_code_list'] = $this->dilate->hospital_code_list();
        $data['item_desc_list'] = $this->dilate->item_desc_list();
        $data['unit_list'] = $this->dilate->unit_list();
        $data['manuf_company_list'] = $this->dilate->manuf_company_list();
        // echo $booking_id;die;
        $data['booking_data'] = $this->dilate->get_booking_by_p_id($booking_id,$patient_id);
        //  echo "<pre>";
        // print_r($data['booking_data']);
        // die('okay');
        $data['medicines'] = $this->dilate->get_all_medicines();
        // echo "<pre>";print_r($booking_id);die;
        // Initialize form data
        $data['form_data'] = array(
            "booking_id" => $result['booking_code'],
            "patient_id" => $booking_id ??'0',
            'hospital_code' => '',
            'item_descripation' => '',
            'menufacturer' => '',
            'qty' => '',
            'unit' => '',
            'hospital_rate' => '',
        );

        $post = $this->input->post();
        // echo "<pre>";
        // print_r($post);
        // die('ndfnd');
        // Check if the form is submitted
        if (isset($post) && !empty($post)) {

            $patient_exists = $this->dilate->patient_exists($post['patient_id']);
            //   echo "<pre>";
            // print_r( $patient_exists);
            // die;
            if(empty($post['data_id'])){
                if ($patient_exists) {
                    // Redirect to OPD list page with a warning message
                    $this->session->set_flashdata('warning', 'Patient ' . $patient_exists['patient_name'] . ' is already in Dilate.');
                    echo json_encode(['faield' => true, 'message' => 'Patient ' . $patient_exists['patient_name'] . ' is already in Dilate.']);
                    // redirect('help_desk'); // Change 'opd_list' to your OPD list page route
                    return;
                }
            }

            $this->dilate->save(); // Save the validated data
            $this->session->set_flashdata('success', 'Contact Lens store successfully.');
            echo json_encode(['success' => true, 'message' => 'Contact Lens store successfully.']);
            return;

        }
        // Load the view with the data
        $this->load->view('dilate/add', $data);
    }

    public function book_patient()
    {
        // public function book_patient() {
        $patient_id = $this->input->post('patient_id');
        // $this->load->model('token_no');

        // Perform booking logic
        $booking_result = $this->dilate->book_patient($patient_id);

        if ($booking_result) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Booking failed.']);
        }
        // }
    }

    public function check_booking_status()
    {
        $patient_id = $this->input->post('patient_id');
        // $this->load->model('Booking_model');

        // Check status in the database
        $status = $this->dilate->get_booking_status($patient_id);
        // echo "<pre>";
        // print_r($status);
        // die('sagar');
        if ($status == 1) {
            echo json_encode(['status' => '1']); // Already in progress
        } else {
            echo json_encode(['status' => '0']); // Not booked yet
        }
    }

    public function update_status_opd()
    {
        $patientId = $this->input->post('patient_id');

        if (!$patientId) {
            echo json_encode(['status' => 'error', 'message' => 'Patient ID is required.']);
            return;
        }

        // Update status logic
        $updated = $this->dilate->update_patient_list_opd_status($patientId, 'new_status'); // Adjust as needed

        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'Status updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update status.']);
        }
    }


    // public function add($booking_id = null)
    // {
    //     $data['side_effects'] = $this->dilate->get_all_side_effects(); // Fetch side effects
    //     $data['page_title'] = 'Add Dilate Record';
    //     $data['booking_id'] = isset($booking_id)?$booking_id:'';

    //     // Fetch patient name using booking_id if it is provided
    //     if ($booking_id) {
    //         $data['patient_name'] = $this->dilate->get_patient_name_by_booking_id($booking_id);
    //     } else {
    //         $data['patient_name'] = ''; // Default value if no booking_id is provided
    //     }
    //     // print_r($data['patient_name'] );
    //     // die;

    //     $post = $this->input->post();

    //     if (isset($post) && !empty($post)) {
    //         // Save the form data
    //         $this->dilate->save();

    //         // Return a JSON response indicating success
    //         echo json_encode(['success' => true]);
    //         return; // Exit to prevent further output
    //     }

    //     // If the form is not submitted, load the view
    //     $this->load->view('dilate/add', $data);
    // }

    private function _validate()
    {
        $this->load->library('form_validation');
        $post = $this->input->post();
        // echo "<pre>";print_r($post);die;

        // Assuming this function returns the necessary fields
        $field_list = mandatory_section_field_list(2);
        $users_data = $this->session->userdata('auth_users');
        $data['form_data'] = [];
        $data['photo_error'] = [];

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        // Validation rules for required fields
        $this->form_validation->set_rules('patient_name', 'Patient Name', 'trim|required');
        $this->form_validation->set_rules('side_effects', 'Side Effect', 'trim|required');
        $this->form_validation->set_rules('procedure_purpose', 'Purpose of the Procedure', 'trim|required');

        // Custom validation for mobile number if certain conditions are met
        // if (!empty($field_list)) {
        //     if ($field_list[0]['mandatory_field_id'] == '5' && $field_list[0]['mandatory_branch_id'] == $users_data['parent_id']) {
        //         $this->form_validation->set_rules('mobile_no', 'Mobile No.', 'trim|required|numeric|min_length[10]|max_length[10]');
        //     }
        // }
        // Run validation
        if ($this->form_validation->run() == FALSE) {
            // Prepare form data to retain user inputs
            $data['form_data'] = array(
                "data_id" => isset($post['data_id']) ? $post['data_id'] : '',
                "patient_name" => isset($post['patient_name']) ? $post['patient_name'] : '',
                "side_effects" => isset($post['side_effects']) ? $post['side_effects'] : '',
                "procedure_purpose" => isset($post['procedure_purpose']) ? $post['procedure_purpose'] : '',

            );

            return $data; // Return the form data with errors
        }
        return true; // Return true if validation passes
    }

    public function get_item_details_by_medicine()
    {
        // Load the necessary model if not already loaded
        // $this->load->model('medicine_entry/medicine_entry_model', 'medicine_entry');
    
        $medicine_id = $this->input->post('medicine_name');
    
        if ($medicine_id) {
            // Fetch data based on medicine_id
            $data = $this->dilate->get_item_by_medicine($medicine_id);
    
            // Check if the data is not empty
            if (!empty($data)) {
                // Return the data as a JSON response
                echo json_encode(['success' => true, 'data' => $data]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No data found for this medicine.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid medicine ID.']);
        }
    }
    
    public function dilated_start() {
        $booked_id = $this->input->post('booked_id');  // Ensure you are receiving this from the POST request
        if (!empty($booked_id)) {
            if ($this->dilate) { // Check if the model is loaded
                $result = $this->dilate->dilate_start($booked_id);  // Pass the booked ID to the model
                if ($result) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to update record']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Model not loaded']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid booked ID']);
        }
    }
    
    
    public function dilated_stop() {
        $booked_id = $this->input->post('booked_id');
        $result = $this->dilate->dilate_stop($booked_id);
        $this->session->set_flashdata('success', 'Dilate stop.');
        return 1;
       
        
    }

    public function edit($id = "")
    {
        // Check user permissions
        unauthorise_permission('411', '2486');
        
        // Validate the ID
        if (isset($id) && !empty($id)) {
            $data['page_title'] = 'Edit Dilate Record';

            // Retrieve the brand by ID
            $result = $this->dilate->get_by_id($id);
            // echo "<pre>";
            // print_r($result);
            // die;
            $data['booking_data'] = $this->dilate->get_booking_by_p_id($result[0]['booking_id'],$result[0]['patient_id']);
            $data['medicine'] = $this->dilate->get_item_by_medicine($result['drop_name']);
            $data['medicines'] = $this->dilate->get_all_medicines();
            // echo "<pre>";print_r($result);die;

            // If no result is found, handle the error
            if (!$result) {
                show_error('Dilate not found', 404);
                return;
            }

            // Prepare the data for the view
            $data['page_title'] = "Update Dilate";
            $data['form_error'] = '';
            $data['form_data'] = array(
                // 'items' => $result ?? [],
                'items' => array_filter($result, function ($item) {
                    return !empty($item); // Remove empty items
                }),
                'data_id' => $id,
                'booking_id' => $result[0]['booking_id'],
                'patient_id' => $result[0]['patient_id'],
                'remarks' => $result[0]['remarks']
            );
            $data['booking_id'] = isset($result[0]['booking_id']) ? $result[0]['booking_id'] : '';
            $data['patient_id'] = isset($result[0]['patient_id']) ? $result[0]['patient_id'] : '';


            // Check if there is form submission
            if ($this->input->post()) {
                // Fetch the posted data
                $post_data = $this->input->post();
                // Initialize an array to hold only modified fields
                $modified_data = [];

                // Compare each field in the result with the posted data
                foreach ($data['form_data'] as $key => $value) {
                    // If the field is different from the original, add it to modified data
                    if (isset($post_data[$key]) && $post_data[$key] != $value) {
                        $modified_data[$key] = $post_data[$key];
                    }
                }

                // If there are modified fields, save the data
                if (!empty($modified_data)) {
                    // Update only the modified fields
                    $this->dilate->update($id, $modified_data);
                    echo 1; // Return success response
                    return;
                } else {
                    echo 0; // No changes made
                    return;
                }
            }
            // echo "<pre>";print_r($data['form_data']);die;
            // Load the view with the prepared data
            $this->load->view('dilate/add', $data);
        } else {
            // Handle the case when the ID is invalid
            show_error('Invalid Brand ID', 400);
        }
    }



    public function save()
    {
        // echo "kodfs";die;
        $post = $this->input->post();

        // Validation rules
        $this->form_validation->set_rules('patient_name', 'Patient Name', 'required');
        // Add other validation rules for your fields as needed
        $this->form_validation->set_rules('s_creatinine', 'Serum Creatinine', 'required|numeric');
        $this->form_validation->set_rules('blood_sugar', 'Blood Sugar', 'required|numeric');
        $this->form_validation->set_rules('blood_pressure', 'Blood Pressure', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed
            $this->session->set_flashdata('error', validation_errors());
            redirect('dilate/add');
        } else {
            // Save the record
            $this->dilate->save();
            $this->session->set_flashdata('success', 'Record saved successfully');
            redirect('dilate');
        }
    }

    public function update()
    {
        $post = $this->input->post();

        if (empty($post['data_id'])) {
            $this->session->set_flashdata('error', 'No record found to update');
            redirect('dilate');
        }

        $this->dilate->save();
        $this->session->set_flashdata('success', 'Record updated successfully');
        redirect('dilate');
    }


    public function dilate_excel()
    {
        // Starting the PHPExcel library
        $this->load->library('excel');
        $this->excel->IO_factory();

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);

        $from_date = $this->input->get('start_date');
        $to_date = $this->input->get('end_date');

        // Main header with date range if provided
        $mainHeader = "Dilate List";
        if (!empty($from_date) && !empty($to_date)) {
            $mainHeader .= " (From: " . date('d-m-Y', strtotime($from_date)) . " To: " . date('d-m-Y', strtotime($to_date)) . ")";
        }

        // Set the main header in row 1
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $mainHeader);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(16);

        // Leave row 2 blank
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);

        // Field names (header row) should start in row 3
        $fields = array('OPD No.','Drop Name','Patient Name', 'Created at');

        $col = 0; // Initialize the column index
        foreach ($fields as $field) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 3, $field); // Row 3 for headers
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true); // Auto-size columns
            $col++;
        }

        // Style for header row (Row 3)
        $objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // Fetching the OPD data
        $list = $this->dilate->get_datatables();
        // Assuming you want to fetch booking data based on the first patient's booking_id
        $data['booking_data'] = $this->dilate->get_booking_by_id($list[0]->booking_id,$list[0]->patient_id);
        // $data = array();
        // $no = $_POST['start'];
        // echo "<pre>";print_r($data['booking_data']);die;

        // Group records by patient_id
        $grouped_data = [];
        foreach ($list as $dilated) {
            $grouped_data[$dilated->patient_id][] = $dilated;
        }

        // Populate the data starting from row 4
        $row = 4; // Start at row 4 for data
        if (!empty($grouped_data)) {
            foreach ($grouped_data as $patient_id => $records) {
                // Reset column index for each new row
                $col = 0;

                $medicine_names = [];
                $salts = [];
                $percentages = [];
                foreach ($records as $dilated) {
                    $medicine_names[] = $dilated->medicine_name;
                    $salts[] = $dilated->salt;
                    $percentages[] = $dilated->percentage;
                }

                // Prepare data to be populated
                $data = array(
                    $records[0]->booking_id,
                    implode(', ', $medicine_names),
                    $records[0]->patient_name, // Make sure this is retrieved correctly
                    date('d-M-Y', strtotime($records[0]->created_date)),
                );

                foreach ($data as $cellValue) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $cellValue);
                    $col++;
                }
                $row++; // Move to the next row
            }
        }

        // Send headers to force download of the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="dilate_list_' . time() . '.xls"');
        header('Cache-Control: max-age=0');

        // Write the Excel file
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        $objWriter->save('php://output');
    }


    public function dilate_pdf()
    {
        // Increase memory limit and execution time for PDF generation
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 300);

        // Fetch the list of dilate data
        $list = $this->dilate->get_datatables();
        
        // Assuming you want to fetch booking data based on the first patient's booking_id
        $data['booking_data'] = $this->dilate->get_booking_by_id($list[0]->booking_id,$list[0]->booking_id);
        
        // Group records by patient_id
        $grouped_data = [];
        foreach ($list as $dilated) {
            $grouped_data[$dilated->patient_id][] = $dilated;
        }

        // Prepare data array to be passed to the view
        $data['grouped_data'] = [];
        foreach ($grouped_data as $patient_id => $records) {
            $row = [];

            // Patient code (you can replace it with actual logic if needed)
            $row['patient_code'] = '1';

            // Patient ID and Booking ID
            $row['patient_id'] = $patient_id;
            $row['booking_id'] = $records[0]->booking_id;

            // Concatenate medicine names, salts, and percentages for each patient group
            $medicine_names = [];
            $salts = [];
            $percentages = [];
            foreach ($records as $dilated) {
                $medicine_names[] = $dilated->medicine_name;
                $salts[] = $dilated->salt;
                $percentages[] = $dilated->percentage;
            }

            // Store medicine, salt, and percentage data
            $row['medicine_names'] = implode(', ', $medicine_names);
            $row['salts'] = implode(', ', $salts);
            $row['percentages'] = implode(', ', $percentages);

            // Patient name and status
            $row['patient_name'] = $records[0]->patient_name;
            $row['patient_status'] = '<font style="background-color: #1CAF9A;color:white">Not Arrived</font>';

            // Created date
            $row['created_date'] = date('d-M-Y', strtotime($records[0]->created_date));

            // Append this row to grouped data
            $data['grouped_data'][] = $row;
        }

        // Prepare the main header for the PDF
        $data['mainHeader'] = "Dilate List";

        // Load the view and capture the HTML output
        $this->load->view('dilate/dilate_html', $data);
        $html = $this->output->get_output();

        // Load PDF library and convert HTML to PDF
        $this->load->library('pdf');
        $this->pdf->load_html($html);
        $this->pdf->render();

        // Stream the generated PDF to the browser
        $this->pdf->stream("dilate_list_" . time() . ".pdf", array("Attachment" => 1));
    }


    public function delete($id)
    {
        $this->dilate->delete($id);
        $this->session->set_flashdata('success', 'Record deleted successfully');
        redirect('dilate');
    }

    public function delete_multiple()
    {
        $ids = $this->input->post('row_id');
        // echo "<pre>";
        // print_r($ids);
        // die;
        if (!empty($ids)) {
            $this->dilate->deleteall($ids);
            // echo json_encode(array("status" => TRUE));
            $response = "Dilate successfully deleted.";
            echo $response;
        }
    }

    public function print_dilate($id)
    {
        $data['print_status'] = "1";

        // Fetch the form data based on the ID
        $result = $this->dilate->get_by_id($id);
        // echo "<pre>";
        // print_r($result[0]['booking_id']);
        // print_r($result[0]['patient_id']);
        // die();
        $data['booking_data'] = $this->dilate->get_booking_by_id($result[0]['booking_id'],$result[0]['patient_id']);
        // echo "<pre>";
        // print_r($data['booking_data']);
        // die();
        $data['medicine'] = $this->dilate->get_item_by_medicine($result['drop_name']);
        $data['medicines'] = $this->dilate->get_all_medicines();
        // echo "<pre>";print_r($data);die;

        // If no result is found, handle the error
        if (!$result) {
            show_error('Dilate not found', 404);
            return;
        }

        // Prepare the data for the view
        $data['page_title'] = "Print Dilate";
        $data['form_error'] = '';
        $data['form_data'] = array(
            'items' => $result ?? [],
            'data_id' => $id,
            'booking_id' => $result[0]['booking_id'],
            'patient_id' => $result[0]['patient_id'],
            'remarks' => $result[0]['remarks']
        );
        $data['booking_id'] = isset($result[0]['booking_id']) ? $result[0]['booking_id'] : '';
        $data['patient_id'] = isset($result[0]['patient_id']) ? $result[0]['patient_id'] : '';


        // Fetch the side effect name based on the side_effect ID from form data
       

        // Fetch the OPD billing details based on the ID
        // $booking_id = isset($data['form_data']['booking_id']) ? $data['form_data']['booking_id'] : '';
        // $data['billing_data'] = $this->dilate->get_patient_name_by_booking_id($booking_id);
        // echo "<pre>";print_r($data);die;

        // Load the print view with the data
        $this->load->view('dilate/print_dilate', $data);
    }
    public function reset_search()
    {
        $this->session->unset_userdata('prescription_search');
    }

    public function advance_search()
    {
        $this->load->model('general/general_model');
        $data['page_title'] = "Advance Search";
        $post = $this->input->post();

        $data['form_data'] = array(
            "start_date" => '',
            "end_date" => '',
            "patient_code" => "",
            "patient_name" => "",
        );
        if (isset($post) && !empty($post)) {
            $marge_post = array_merge($data['form_data'], $post);
            $this->session->set_userdata('prescription_search', $marge_post);

        }
        $prescription_search = $this->session->userdata('prescription_search');
        if (isset($prescription_search) && !empty($prescription_search)) {
            $data['form_data'] = $prescription_search;
        }
        $this->load->view('dilate/advance_search', $data);
    }

}
