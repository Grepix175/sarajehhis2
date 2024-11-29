<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vision extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('vision/vision_model');
        $this->load->model('opd/opd_model', 'opd');
        $this->load->model('doctors/Doctors_model', 'doctor');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['page_title'] = 'Vision List';
        $this->load->model('default_search_setting/default_search_setting_model');
        $default_search_data = $this->default_search_setting_model->get_default_setting();
        if (isset($default_search_data[1]) && !empty($default_search_data) && $default_search_data[1] == 1) {
            $start_date = '';
            $end_date = '';
        } else {
            $start_date = date('d-m-Y');
            $end_date = date('d-m-Y');
        }
        $data['form_data'] = array('patient_name' => '', 'patient_code' => '', 'start_date' => $start_date, 'end_date' => $end_date,'emergency_booking'=>'');
        $this->load->view('vision/list', $data);
    }

    public function ajax_list()
    {
        $list = $this->vision_model->get_datatables();
            // echo "<pre>";
            // print_r($list);
            // die;
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $vision) {
            $no++;
            $row = array();
            ////////// Check  List /////////////////
            $check_script = "";
            if ($i == $total_num) {

                $check_script = "<script>$('#selectAll').on('click', function () { 
                                  if ($(this).hasClass('allChecked')) {
                                      $('.checklist').prop('checked', false);
                                  } else {
                                      $('.checklist').prop('checked', true);
                                  }
                                  $(this).toggleClass('allChecked');
                              })</script>";
            }
            $pat_status = '';
            $patient_status = $this->opd->get_by_id_patient_status($prescription->booking_id);
            if ($patient_status == 1) {
                $pat_status = '<font style="background-color: #228B22;color:white">Vision</font>';
            }
            // else if ($patient_status['doctor'] == '1') {
            //   $pat_status = '<font style="background-color: #1CAF9A;color:white">Doctor</font>';
            // }
            //  else if ($patient_status['optimetrist'] == '1') {
            //   $pat_status = '<font style="background-color: #1CAF9A;color:white">Opt.Optom</font>';
            // } 
            // else if ($patient_status['reception'] == '1') {
            //   $pat_status = '<font style="background-color: #1CAF9A;color:white">Reception</font>';
            // }
            //  else if ($patient_status['arrive'] == '1') {
            //   $pat_status = '<font style="background-color: #1CAF9A;color:white">Arrived</font>';
            // } 
            else {
                $pat_status = '<font style="background-color: #1CAF9A;color:white">Not Arrived</font>';
            }
            $age_y = $vision->age_y;
            $age_m = $vision->age_m;
            $age_d = $vision->age_d;

            $age = "";
            if ($age_y > 0) {
                $year = 'Years';
                if ($age_y == 1) {
                    $year = 'Year';
                }
                $age .= $age_y . " " . $year;
            }
            if ($age_m > 0) {
                $month = 'Months';
                if ($age_m == 1) {
                    $month = 'Month';
                }
                $age .= ", " . $age_m . " " . $month;
            }
            if ($age_d > 0) {
                $day = 'Days';
                if ($age_d == 1) {
                    $day = 'Day';
                }
                $age .= ", " . $age_d . " " . $day;
            }
            $gender = array('0' => 'Female', '1' => 'Male', '2' => 'Others');
            // $row[] = $vision->id;
            $row[] = '<input type="checkbox" name="prescription[]" class="checklist" value="' . $vision->id . '">' . $check_script;
            // $row[] = $vision->patient_code_auto;
            $row[] = $vision->token_no;
            $row[] = $vision->booking_code;
            $row[] = $vision->patient_code;
            $row[] = $vision->patient_name;
            $row[] = $gender[$vision->gender];
            $row[] = $vision->mobile_no;
            $row[] = $age;
            $row[] = $vision->status == 0 ? '<font color="green">Pending</font>' : '<font color="red">Completed</font>';
            $statuses = explode(',', $vision->pat_status);

            // Trim any whitespace from the statuses and get the last one
            $last_status = trim(end($statuses));

            // Display the last status with the desired styling
            $row[] = '<font style="background-color: #228B30;color:white">'.$last_status.'</font>';
            // Trim any whitespace from the statuses and get the last one
            $last_status = trim(end($statuses));
            // $row[] = $vision->procedure_purpose;
            // $row[] = $vision->side_effect_name;
            // $row[] = $vision->informed_consent ? 'Yes' : 'No';
            // $row[] = $vision->previous_ffa ? 'Yes' : 'No';
            // $row[] = $vision->history_allergy ? 'Yes' : 'No';
            // $row[] = $vision->history_asthma ? 'Yes' : 'No';
            // $row[] = $vision->history_epilepsy ? 'Yes' : 'No';
            // $row[] = $vision->accompanied_attendant ? 'Yes' : 'No';
            // $row[] = $vision->s_creatinine;
            // $row[] = $vision->blood_sugar;
            // $row[] = $vision->blood_pressure;
            // $row[] = $vision->reason_ffa_not_done;
            // $row[] = $vision->optometrist_signature;
            // $row[] = $vision->optometrist_date;
            // $row[] = $vision->anaesthetist_signature;
            // $row[] = $vision->anaesthetist_date;
            // $row[] = $vision->doctor_signature;
            // $row[] = $vision->doctor_date;
            $row[] = date('d-M-Y', strtotime($vision->created_at));
            // $row[] = $vision->created_at;
            // $row[] = $vision->updated_at;

            $send_to = '';
        // echo "<pre>";print_r($list);die;

            if ($vision->status == 0) {
                $send_to = '<button type="button" class="btn-custom open-popup-send-to" 
                            id="open-popup" 
                            data-booking-id="' . $vision->booking_id . '" 
                            data-patient-id="' . $vision->patient_id . '" 
                            data-referred-by="' . $vision->attended_doctor . '" 
                            data-mod-type="vision" 
                            data-url="' . $vision->url . '" 
                            title="">Send To</button>';
              }else{
                $send_to = '<a class="btn-custom disabled" href="javascript:void(0);" title="Send To Vision" style="pointer-events: none; opacity: 0.6;" data-url="512"> Send To</a>';
              }

            // Add action buttons
            $row[] = '  <a onClick="return edit_vision(' . $vision->id . ');" class="btn-custom" href="javascript:void(0)" style="' . $vision->id . '" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                       <a href="javascript:void(0)" class="btn-custom" onClick="return print_window_page(\'' . base_url("vision/print_vision/" . $vision->id) . '\');">
                <i class="fa fa-print"></i> Print
            </a>' . $send_to;
            $row[] = $vision->emergency_status;


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->vision_model->count_all(),
            "recordsFiltered" => $this->vision_model->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function add($booking_id = null,$patient_id = null)
    {
        // echo "<pre>";
        // print_r($booking_id);
        // die('sagar');
        // Load required models and libraries
        $this->load->library('form_validation');
        $this->load->model('vision/vision_model'); // Ensure this model is loaded
        $data['side_effects'] = $this->vision_model->get_all_side_effects(); // Fetch side effects
        $data['page_title'] = 'Add Vision Record';
        $data['booking_id'] = isset($booking_id) ? $booking_id : '';
        $data['patient_id'] = isset($patient_id) ? $patient_id : '';
        $data['booking_data'] = $this->vision_model->get_booking_patient_details($data['patient_id']);
        $data['doctor'] = $this->doctor->doctors_list();
        // echo "<pre>";
        // print_r($data['booking_data']);
        // die;
        $patient_details = $this->vision_model->get_patient_name_by_booking_id($booking_id);
        if ($booking_id && $patient_details) {
            $data['patient_name'] = $patient_details['patient_name'];
        } else {
            $data['patient_name'] = ''; // Default value if no booking_id is provided
        }

        // Initialize form data
        $data['form_data'] = array(
            "booking_id" => $booking_id,
            "patient_name" => $patient_details['patient_name'] ?? '',
            "patient_code" => $patient_details['patient_code'] ?? '',
            "procedure_purpose" => '',
            "side_effects" => '',
            'informed_consent' => '',
            'previous_ffa' => '',
            'history_allergy' => '',
            'history_asthma' => '',
            'history_epilepsy' => '',
            'accompanied_attendant' => '',
            's_creatinine' => '',
            'blood_sugar' => '',
            'blood_pressure' => '',
            'reason_ffa_not_done' => '',
            'optometrist_signature' => '',
            'optometrist_date' => '',
            'anaesthetist_signature' => '',
            'anaesthetist_date' => '',
            'doctor_signature' => '',
            'doctor_date' => '',
        );


        $post = $this->input->post();
        // echo "<pre>";
        // print_r('abhay');
        // print_r($post);
        // die;
        // Check if the form is submitted
        if (isset($post) && !empty($post)) {
            $patient_exists = $this->vision_model->patient_exists($post['patient_code']);
            //   echo "<pre>";
            // print_r( $patient_exists);
            // die;
            if (empty($post['data_id'])) {

                if ($patient_exists) {
                    // Redirect to OPD list page with a warning message
                    $this->session->set_flashdata('warning', 'Patient ' . $patient_exists['patient_name'] . ' is already in Vision.');
                    echo json_encode(['faield' => true, 'message' => 'Patient ' . $patient_exists['patient_name'] . ' is already in Vision.']);
                    // redirect('help_desk'); // Change 'opd_list' to your OPD list page route
                    return;
                }
            }
            // Validate the form
            $valid_response = $this->_validate();

            // Check if validation passed
            if ($valid_response === true) {
                // If validation passes, save the record
                $this->vision_model->save($this->input->post()); // Save the validated data
                $this->session->set_flashdata('success', 'Vision store successfully.');
                echo json_encode(['success' => true, 'message' => 'Vision store successfully.']);
                return; // Exit to prevent further output
            } else {
                // Handle validation errors
                $data['form_data'] = $valid_response['form_data']; // Retain form data for re-display
                $data['form_error'] = validation_errors(); // Get validation errors
            }
        }




        // If the form is not submitted or validation fails, load the view with the existing data


        // Load the view with the data
        $this->load->view('vision/add', $data);
    }

    public function book_patient()
    {
        // public function book_patient() {
        $patient_id = $this->input->post('patient_id');
        // $this->load->model('token_no');

        // Perform booking logic
        $booking_result = $this->vision_model->book_patient($patient_id);

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
        $status = $this->vision_model->get_booking_status($patient_id);
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
        $updated = $this->vision_model->update_patient_list_opd_status($patientId, 'new_status'); // Adjust as needed

        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'Status updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update status.']);
        }
    }

    // public function add($booking_id = null)
    // {
    //     $data['side_effects'] = $this->vision_model->get_all_side_effects(); // Fetch side effects
    //     $data['page_title'] = 'Add Vision Record';
    //     $data['booking_id'] = isset($booking_id)?$booking_id:'';

    //     // Fetch patient name using booking_id if it is provided
    //     if ($booking_id) {
    //         $data['patient_name'] = $this->vision_model->get_patient_name_by_booking_id($booking_id);
    //     } else {
    //         $data['patient_name'] = ''; // Default value if no booking_id is provided
    //     }
    //     // print_r($data['patient_name'] );
    //     // die;

    //     $post = $this->input->post();

    //     if (isset($post) && !empty($post)) {
    //         // Save the form data
    //         $this->vision_model->save();

    //         // Return a JSON response indicating success
    //         echo json_encode(['success' => true]);
    //         return; // Exit to prevent further output
    //     }

    //     // If the form is not submitted, load the view
    //     $this->load->view('vision/add', $data);
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




    public function edit($id = "")
    {
        // Check user permissions
        unauthorise_permission('411', '2486');
        $data['side_effects'] = $this->vision_model->get_all_side_effects(); // Fetch side effects
        $this->load->model('vision/vision_model');

        // Validate the ID
        if (isset($id) && !empty($id) && is_numeric($id)) {
            $data['page_title'] = 'Edit Vision Record';
            // $data['vision'] = 

            // Retrieve the brand by ID
            $result = $this->vision_model->get_by_id($id);
            $data['booking_data'] = $this->vision_model->get_booking_patient_details_edit($result['booking_id']);
            $data['doctor'] = $this->doctor->doctors_list();
            // echo "<pre>";print_r($result);die;
            // If no result is found, you might want to handle this case
            if (!$result) {
                // Optionally, set an error message or redirect
                show_error('Vision not found', 404);
                return;
            }


            // Prepare data for the view
            $data['page_title'] = "Update Vision";
            $data['form_error'] = '';
            $data['form_data'] = array(
                'data_id' => $result['vision_id'],
                'patient_code' => $result['patient_code'],
                'patient_name' => $result['patient_name'],
                'booking_id' => $result['booking_id'],
                'procedure_purpose' => $result['procedure_purpose'],
                'side_effects' => $result['side_effects'],
                'informed_consent' => $result['informed_consent'],
                'previous_ffa' => $result['previous_ffa'],
                'history_allergy' => $result['history_allergy'],
                'history_asthma' => $result['history_asthma'],
                'history_epilepsy' => $result['history_epilepsy'],
                'accompanied_attendant' => $result['accompanied_attendant'],
                's_creatinine' => $result['s_creatinine'],
                'blood_sugar' => $result['blood_sugar'],
                'blood_pressure' => $result['blood_pressure'],
                'reason_ffa_not_done' => $result['reason_ffa_not_done'],
                'optometrist_signature' => $result['optometrist_signature'],
                'optometrist_date' => $result['optometrist_date'],
                'anaesthetist_signature' => $result['anaesthetist_signature'],
                'anaesthetist_date' => $result['anaesthetist_date'],
                'doctor_signature' => $result['doctor_signature'],
                'doctor_date' => $result['doctor_date'],
                'created_at' => $result['created_at'],
                'updated_at' => $result['updated_at'],
                'is_deleted' => $result['is_deleted'],
            );

                // echo "<pre>";
                // print_r('$post');
                // print_r($data['form_data']);
                // die;

            // Check if there is form submission
            if ($this->input->post()) {
                // echo "<pre>";
                // print_r('$post');
                // print_r($post);
                // die;
                // Validate the form
                $data['form_data'] = $this->_validate();
                if ($this->form_validation->run() == TRUE) {
                    // Save the updated brand details
                    $this->vision_model->save();
                    echo 1; // Return a success response
                    return;
                } else {
                    // Capture validation errors
                    $data['form_error'] = validation_errors();
                }
            }
            // echo "ok";die;
            // Load the view with the prepared data
            $this->load->view('vision/add', $data);
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
            redirect('vision/add');
        } else {
            // Save the record
            $this->vision_model->save();
            $this->session->set_flashdata('success', 'Record saved successfully');
            redirect('vision');
        }
    }

    public function update()
    {
        $post = $this->input->post();

        if (empty($post['data_id'])) {
            $this->session->set_flashdata('error', 'No record found to update');
            redirect('vision');
        }

        $this->vision_model->save();
        $this->session->set_flashdata('success', 'Record updated successfully');
        redirect('vision');
    }


    public function vision_excel()
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
        $mainHeader = "Vision List";
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
        $fields = array('Patient Name', 'Procedure Purpose', 'Side Effects', 'Created at');

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
        $list = $this->vision_model->get_datatables();

        // Populate the data starting from row 4
        $row = 4; // Start at row 4 for data
        if (!empty($list)) {
            foreach ($list as $vision) {
                // Reset column index for each new row
                $col = 0;

                // Prepare data to be populated
                $data = array(
                    $vision->patient_name,
                    $vision->procedure_purpose,
                    $vision->side_effect_name, // Make sure this is retrieved correctly
                    $vision->created_at,
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
        header('Content-Disposition: attachment;filename="help_desk_list_' . time() . '.xls"');
        header('Cache-Control: max-age=0');

        // Write the Excel file
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        $objWriter->save('php://output');
    }


    public function vision_pdf()
    {
        // Increase memory limit and execution time for PDF generation
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 300);

        // Prepare data for the PDF
        // $data['print_status'] = "";
        // $from_date = $this->input->get('start_date');
        // $to_date = $this->input->get('end_date');

        // Fetch OPD data
        $data['data_list'] = $this->vision_model->get_datatables();
        // echo "<pre>";
        // print_r($data);
        // die;
        $data['data_list']['side_effect_name'] = $this->vision_model->get_side_effect_name($data['data_list']['side_effects']);
        // Create main header
        $data['mainHeader'] = "Help Desk List";
        // if (!empty($from_date) && !empty($to_date)) {
        // $data['mainHeader'] .= " (From: " . date('d-m-Y', strtotime($from_date)) . " To: " . date('d-m-Y', strtotime($to_date)) . ")";
        // }

        // Load the view and capture the HTML output
        $this->load->view('vision/vision_html', $data);
        $html = $this->output->get_output();

        // Load PDF library and convert HTML to PDF
        $this->load->library('pdf');
        $this->pdf->load_html($html);
        $this->pdf->render();

        // Stream the generated PDF to the browser
        $this->pdf->stream("help_desk_list_" . time() . ".pdf", array("Attachment" => 1));
    }

    public function delete($id)
    {
        $this->vision_model->delete($id);
        $this->session->set_flashdata('success', 'Record deleted successfully');
        redirect('vision');
    }

    public function delete_multiple()
    {
        $ids = $this->input->post('row_id');
        // echo "<pre>";
        // print_r($ids);
        // die;
        if (!empty($ids)) {
            $this->vision_model->deleteall($ids);
            // echo json_encode(array("status" => TRUE));
            $response = "Vision successfully deleted.";
            echo $response;
        }
    }

    public function print_vision($id)
    {
        $data['print_status'] = "1";

        // Fetch the form data based on the ID
        $data['form_data'] = $this->vision_model->print_vision_details($id);
        // echo "<pre>";print_r($data['form_data']);die;

        // Fetch the side effect name based on the side_effect ID from form data
        if (!empty($data['form_data']['side_effects'])) {
            $side_effect_id = $data['form_data']['side_effects'];
            $data['form_data']['side_effect_name'] = $this->vision_model->get_side_effect_name($side_effect_id);
        }

        // Fetch the OPD billing details based on the ID
        $booking_id = isset($data['form_data']['booking_id']) ? $data['form_data']['booking_id'] : '';
        $data['billing_data'] = $this->vision_model->get_patient_name_by_booking_id($booking_id);

        // Load the print view with the data
        $this->load->view('vision/print_vision', $data);
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
        $this->load->view('vision/advance_search', $data);
    }

}
