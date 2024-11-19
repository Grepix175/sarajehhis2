<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Token_no extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        auth_users(); // Assuming this is for authentication check
        $this->load->model('token_no/tokenno_model', 'token_no');
        $this->load->model('general/general_model');
        // $this->load->library('form_validation');
    }

    // Method to show the token status list
    public function index()
    {
        // echo "hi";die;
        $this->session->unset_userdata('token_search');
        // $this->session->unset_userdata('booked_patients');
        // Default Search Setting
        $this->load->model('default_search_setting/default_search_setting_model');
        $default_search_data = $this->default_search_setting_model->get_default_setting();
        if (isset($default_search_data[1]) && !empty($default_search_data) && $default_search_data[1] == 1) {
            $start_date = '';
            $end_date = '';
        } else {
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d');
        }

        $data['page_title'] = 'Patient List';
        $data['form_data'] = array('token_no' => '', 'patient_code' => '', 'patient_id' => '', 'status' => '', 'from_date' => $start_date, 'to_date' => $end_date);
        $this->load->view('token_grid/opd_token_list', $data);
    }

    // AJAX method to fetch the token list for display
    public function ajax_list()
    {
        
        $users_data = $this->session->userdata('auth_users');
        $opd_search = $this->session->userdata('token_search'); // Get filter criteria from session

        // Check if search criteria are set and adjust the query accordingly
        if (!empty($opd_search)) {
            $this->token_no->set_filter_criteria($opd_search); // Pass the filter criteria to the model
        }

        $list = $this->token_no->get_datatables();  // Fetch token list with filter criteria
        $data = array();
        $no = $_POST['start'];
        $i = 1;

        foreach ($list as $test) {
            $no++;
            $row = array();

            // Add a class based on emergency_status
            $row_class = '';
            if ($test->emergency_status == 1) {
                $row_class = 'border-red'; // Class for red border
            } elseif ($test->emergency_status == 2) {
                $row_class = 'border-blue'; // Class for blue border
            } elseif ($test->emergency_status == 3) {
                $row_class = 'border-yellow'; // Class for yellow border
            }

            // Add token_no directly
            $row[] = $test->token_no; // Add token_no directly

            // Add other patient details
            $row[] = $test->patient_code;
            $row[] = $test->patient_name;

            // Display status
            $status = ($test->status == 1) ? 'Pending' : 'Completed';
            $row[] = $status;

            // Generate action button (hide if status is 'Complete')
            if ($test->status == 1) {  // Show button only if status is 'Pending'
                $action_url = base_url("opd/booking/" . $test->patient_id);
                // $row[] = '<a href="' . $action_url . '" class="btn-custom" title="Edit">Book Now</a>';
                $bookedPatients = $this->session->userdata('booked_patients') ?? [];

                $isBooked = in_array($test->patient_id, $bookedPatients);
                if ($isBooked) {
                    // Render disabled button for already booked patients
                    $row[] = '<button class="btn-custom book-now-btn" disabled>Booking...</button>';
                } else {
                    // Render active button for patients not yet booked
                    $row[] = '<button class="btn-custom book-now-btn" title="Book Now" 
        data-id="' . $test->patient_id . '" 
        data-url="' . base_url('opd/booking/' . $test->patient_id) . '">Book Now</button>';
                }

            } else {
                $row[] = '';  // Leave action column empty for 'Complete' status
            }

            // Add emergency_status to the row
            $row[] = $test->emergency_status; // Add emergency_status to the row

            // Add the row to data
            $data[] = $row; // Each row now includes emergency_status
            $i++;
        }
        // echo "<pre>";print_r($data);die;
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->token_no->count_all(),  // Correct reference to model
            "recordsFiltered" => $this->token_no->count_filtered(),  // Correct reference to model
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function book_patient()
    {
        $patientId = $this->input->post('patient_id'); // Get patient ID from POST
        $bookedPatients = $this->session->userdata('booked_patients') ?? [];

        // Check if the patient is already booked
        if (in_array($patientId, $bookedPatients)) {
            echo json_encode(['status' => 'error', 'message' => 'This patient is already booked.']);
            return;
        }

        // Simulate booking logic (e.g., save booking to the database)
        // Add patient ID to session
        $bookedPatients[] = $patientId;
        $this->session->set_userdata('booked_patients', $bookedPatients);

        echo json_encode(['status' => 'success', 'message' => 'Patient booked successfully.']);
    }

    public function clear_booking_session()
    {
        $this->session->unset_userdata('booked_patients');
        echo "Booking session cleared!";
    }


    // Method to handle search filters
    public function advance_search()
    {
        $post = $this->input->post();
        if (!empty($post)) {
            // Check if search_type is 1, and set priority_type accordingly
            $priority_type = null;
            if (isset($post['search_type']) && $post['search_type'] == 1) {
                $priority_type = !empty($post['priority_type']) ? $post['priority_type'] : null;
            }

            // Set the filter criteria (status, from_date, to_date) in the session
            $search_criteria = array(
                'search_type' => $post['search_type'],   // Status filter
                'priority_type' => $priority_type,        // Priority type filter (null if search_type is not 1)
                'from_date' => !empty($post['from_date']) ? $post['from_date'] : null,   // From date filter
                'to_date' => !empty($post['to_date']) ? $post['to_date'] : null          // To date filter
            );

            // Save the search criteria in the session
            $this->session->set_userdata('token_search', $search_criteria);
        }

        // Retrieve search criteria from session (if available)
        $opd_search = $this->session->userdata('token_search');
        if (!empty($opd_search)) {
            // Optionally prepare the response data for form pre-filling or debugging
            $data['form_data'] = $opd_search;
        }

        return 'ok';
    }



    // Method to update the status of a token
    public function update_token_status()
    {
        $post = $this->input->post();
        $result = $this->token_no->update_token_status($post['token_id'], $post['token_no']);
        if ($result) {
            echo "Status successfully updated.";
        }
    }

    // Method to display the OPD token list
    public function opd_token()
    {
        $users_data = $this->session->userdata('auth_users');
        $data['branch_type'] = $this->token_no->get_branch_token_type($users_data['parent_id']);
        $data['page_title'] = 'Token Display List';
        $data['specialization_list'] = $this->general_model->specialization_list();

        $this->load->view('token_no/opd_token_display', $data);
    }

    // AJAX method to display the token status for patients
    public function ajax_list_display()
    {
        $users_data = $this->session->userdata('auth_users');
        $branch_type = $this->token_no->get_branch_token_type($users_data['parent_id']);
        $list = $this->token_no->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $token) {
            $no++;
            $row = array();

            // Handle status display based on status
            $status_labels = array(
                0 => '<font color="red">Waiting</font>',
                1 => '<font color="green">In Progress</font>',
                2 => '<font color="blue">Done</font>',
                3 => '<font color="orange">Emergency</font>',
                4 => '<font color="gray">Cancel</font>'
            );
            $row[] = $token->token_no;
            $row[] = $token->patient_name;
            $row[] = ($branch_type == 2) ? ucfirst(get_specilization_name($token->specialization_id)) : ucfirst(get_doctor_name($token->doctor_id));
            $row[] = $status_labels[$token->status];

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->token_no->count_all(),
            "recordsFiltered" => $this->token_no->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // Method to display patient token list
    public function token_patient_display()
    {
        $users_data = $this->session->userdata('auth_users');
        $data['branch_type'] = $this->token_no->get_branch_token_type($users_data['parent_id']);
        $data['page_title'] = 'Token Patient Display List';
        $data['specialization_list'] = $this->general_model->specialization_list();

        $this->load->view('token_no/opd_token_patient_display', $data);
    }

    public function token_no_excel()
    {

        // Starting the PHPExcel library
        $this->load->library('excel');
        $this->excel->IO_factory();
        $objPHPExcel = new PHPExcel();
        // "<pre>";print_r('Hello'); die;
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);

        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');
        // Main header with date range if provided
        $mainHeader = "Token No List";
        if (!empty($from_date) && !empty($to_date)) {
            $mainHeader .= " (From: " . date('d-m-Y', strtotime($from_date)) . " To: " . date('d-m-Y', strtotime($to_date)) . ")";
        }
        $objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $mainHeader);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(16);

        // Blank row after the main header
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20); // Set height for visibility
        $headerRow = 2;
        if (!empty($from_date) || !empty($to_date)) {
            $dateRange = '';
            if (!empty($from_date)) {
                $dateRange .= 'From Date: ' . date('d-m-Y', strtotime($from_date)) . ' ';
            }
            if (!empty($to_date)) {
                $dateRange .= 'To Date: ' . date('d-m-Y', strtotime($to_date));
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $headerRow);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $headerRow)->getFont()->setItalic(true);
            $headerRow++;
        }

        // Field names in the next row
        // $data = get_setting_value('PATIENT_REG_NO');
        $fields = array('Token No.', 'Patient Reg. No.', 'Patient Name', 'Mobile No.', 'Status', 'Created Date');

        $objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $col = 0;
        foreach ($fields as $field) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $headerRow, $field);
            $col++;
        }

        $headerStyle = array(
            'font' => array(
                'bold' => true
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A' . $headerRow . ':F' . $headerRow)->applyFromArray($headerStyle);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

        // Fetching the table data
        $list = $this->token_no->search_patient_data();
        // "<pre>";print_r($list); die;
        $rowData = array();
        $data = array();
        if (!empty($list)) {
            $i = 0;
            foreach ($list as $token) {
                $created_date = date('d-m-Y h:i A', strtotime($token->created_date));

                $relation_name = '';
                if (!empty($token->relation_name)) {
                    $relation_name = $token->patient_relation . " " . $token->relation_name;
                }
                $status = $token->status == 1 ? 'Pending' : 'Completed';
                array_push($rowData, $token->token_no, $token->patient_code, $token->patient_name, $token->mobile_no, $status, $created_date);
                $count = count($rowData);
                for ($j = 0; $j < $count; $j++) {
                    $data[$i][$fields[$j]] = $rowData[$j];
                }
                unset($rowData);
                $rowData = array();
                $i++;
            }
        }

        $row = $headerRow + 1;
        if (!empty($data)) {
            foreach ($data as $patients_data) {
                $col = 0;
                foreach ($fields as $field) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $patients_data[$field]);
                    $objPHPExcel->getActiveSheet()->getStyle($row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle($row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $col++;
                }
                $row++;
            }
            $objPHPExcel->setActiveSheetIndex(0);
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        }

        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel charset=UTF-8');
        header("Content-Disposition: attachment; filename=token-no_list_" . time() . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        if (!empty($data)) {
            ob_end_clean();
            $objWriter->save('php://output');
        }
    }

    public function reset_search()
    {
        $this->session->unset_userdata('token_search');
    }


}
?>