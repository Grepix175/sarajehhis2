<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contact_lens extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('contact_lens/contact_lens_model', 'contact_lens');
        $this->load->model('opd/opd_model', 'opd');
        $this->load->model('doctors/Doctors_model', 'doctor');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['page_title'] = 'Contact Lens List';
        $this->load->model('default_search_setting/default_search_setting_model');
        $default_search_data = $this->default_search_setting_model->get_default_setting();
        if (isset($default_search_data[1]) && !empty($default_search_data) && $default_search_data[1] == 1) {
            $start_date = '';
            $end_date = '';
        } else {
            $start_date = date('d-m-Y');
            $end_date = date('d-m-Y');
        }
        $data['form_data'] = array('patient_name' => '', 'patient_code' => '', 'start_date' => $start_date, 'end_date' => $end_date);
        $this->load->view('contact_lens/list', $data);
    }

    public function ajax_list()
    {
        $list = $this->contact_lens->get_datatables();
        // echo "<pre>";
        // print_r($list);
        // die;
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        $total_num = '';
        foreach ($list as $contact_lens) {
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
            $patient_status = $this->opd->get_by_id_patient_status($contact_lens->booking_id);
            if ($patient_status == 1) {
                $pat_status = '<font style="background-color: #228B22;color:white">Vision</font>';
            } else {
                $pat_status = '<font style="background-color: #1CAF9A;color:white">Not Arrived</font>';
            }
            $age_y = $contact_lens->age_y;
            $age_m = $contact_lens->age_m;
            $age_d = $contact_lens->age_d;

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
            // $row[] = $contact_lens->id;
            $gender = array('0' => 'Female', '1' => 'Male', '2' => 'Others');
            $row[] = '<input type="checkbox" name="prescription[]" class="checklist" value="' . $contact_lens->id . '">' . $check_script;
            $row[] = $contact_lens->token_no;
            $row[] = $contact_lens->booking_code;
            $row[] = $contact_lens->patient_code;
            // $row[] = $contact_lens->patient_code;
            $row[] = $contact_lens->patient_name;
            $row[] = $gender[$contact_lens->gender];
            $row[] = $contact_lens->mobile_no;
            $row[] = $age;
            $row[] = $contact_lens->status == 0 ? '<font color="green">Pending</font>' : '<font color="red">Completed</font>';
            $statuses = explode(',', $contact_lens->pat_status);

            // Trim any whitespace from the statuses and get the last one
            $last_status = trim(end($statuses));

            // Display the last status with the desired styling
            $row[] = '<font style="background-color: #228B30;color:white">' . $last_status . '</font>';
            // Trim any whitespace from the statuses and get the last one
            $last_status = trim(end($statuses));            // $row[] = $contact_lens->hospital_code;
            // $row[] = $contact_lens->item_description;
            // $row[] = $contact_lens->menufacturer;
            // $row[] = $contact_lens->qty;
            // $row[] = $contact_lens->unit;
            // $row[] = $contact_lens->hospital_rate;
            $row[] = date('d-m-Y h:i A', strtotime($contact_lens->created_date));

            $send_to = '';
            // echo "<pre>";print_r($list);die;

            if ($contact_lens->status == 0) {
                $send_to = '<button type="button" class="btn-custom open-popup-send-to" 
                            id="open-popup" 
                            data-booking-id="' . $contact_lens->booking_id . '" 
                            data-patient-id="' . $contact_lens->patient_id . '" 
                            data-referred-by="' . $contact_lens->attended_doctor . '" 
                            data-mod-type="contact_lens" 
                            data-url="' . $contact_lens->url . '" 
                            title="">Send To</button>';
            } else {
                $send_to = '<a class="btn-custom disabled" href="javascript:void(0);" title="Send To Vision" style="pointer-events: none; opacity: 0.6;" data-url="512"> Send To</a>';
            }

            // Add action buttons
            $row[] = '<a onClick="return edit(' . $contact_lens->id . ', ' . $contact_lens->booking_id . ', ' . $contact_lens->patient_id . ');" class="btn-custom" href="javascript:void(0)" title="Edit">
            <i class="fa fa-pencil" aria-hidden="true"></i> Edit
        </a>
        <a href="javascript:void(0)" class="btn-custom m-b-2" 
           onClick="return print_con_lens_page(' . $contact_lens->id . ', ' . $contact_lens->booking_id . ', ' . $contact_lens->patient_id . ');">
            <i class="fa fa-print"></i> Print
        </a>
        
        ' . $send_to;
            $row[] = $contact_lens->emergency_status;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->contact_lens->count_all(),
            "recordsFiltered" => $this->contact_lens->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function add($booking_id = null, $patient_id = null)
    {

        // Load required models and libraries
        $this->load->library('form_validation');
        $this->load->model('contact_lens/contact_lens_model'); // Ensure this model is loaded
        $this->load->model('hospital_code_entry/hospital_code_entry_model', 'hospital_entry');
        // $data['side_effects'] = $this->contact_lens->get_all_side_effects(); // Fetch side effects
        $data['page_title'] = 'Add Contact Lens Record';
        $data['booking_id'] = isset($booking_id) ? $booking_id : '';
        $data['hospital_code_list'] = $this->hospital_entry->hospital_code_list();
        $data['item_desc_list'] = $this->hospital_entry->item_desc_list();
        $data['unit_list'] = $this->hospital_entry->unit_list();
        $data['manuf_company_list'] = $this->hospital_entry->manuf_company_list();
        $data['booking_data'] = $this->contact_lens->get_booking_by_id($booking_id);
        $data['doctor'] = $this->doctor->doctors_list();
        // Initialize form data
        $data['form_data'] = array(
            "booking_id" => $booking_id,
            "patient_id" => $patient_id,
            'hospital_code' => '',
            'item_descripation' => '',
            'menufacturer' => '',
            'qty' => '',
            'unit' => '',
            'hospital_rate' => '',
            'optometrist_signature' => '',
            'doctor_signature' => ''
        );

        $post = $this->input->post();
        // echo "<pre>";
        // print_r($post);
        // die;
        // Check if the form is submitted
        if (isset($post) && !empty($post)) {
            //     echo "<pre>";
            //   print_r( 'sagar');
            //   die;
            $patient_exists = $this->contact_lens->patient_exists($post['patient_id']);
            //   echo "<pre>";
            // print_r( $patient_exists);
            // die;
            if (empty($post['data_id'])) {
                if ($patient_exists) {
                    // Redirect to OPD list page with a warning message
                    $this->session->set_flashdata('warning', 'Patient ' . $patient_exists['patient_name'] . ' is already in contact lens.');
                    echo json_encode(['faield' => true, 'message' => 'Patient ' . $patient_exists['patient_name'] . ' is already in contact lens.']);
                    // redirect('help_desk'); // Change 'opd_list' to your OPD list page route
                    return;
                }
            }

            $this->contact_lens->save(); // Save the validated data
            $this->session->set_flashdata('success', 'Contact Lens store successfully.');
            echo json_encode(['success' => true, 'message' => 'Contact Lens store successfully.']);
            return;

        }
        // Load the view with the data
        $this->load->view('contact_lens/add', $data);
    }

    public function book_patient()
    {
        // public function book_patient() {
        $patient_id = $this->input->post('patient_id');
        // $this->load->model('token_no');

        // Perform booking logic
        $booking_result = $this->contact_lens->book_patient($patient_id);

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
        $status = $this->contact_lens->get_booking_status($patient_id);
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
        $updated = $this->contact_lens->update_patient_list_opd_status($patientId, 'new_status'); // Adjust as needed

        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'Status updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update status.']);
        }
    }

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




    public function edit($id = "", $booking_id = "", $patient_id = "")
    {
        $this->load->model('hospital_code_entry/hospital_code_entry_model', 'hospital_entry');
        // Validate the ID
        if (isset($id) && !empty($id) && is_numeric($id)) {
            $data['page_title'] = 'Edit Contact Lens';
            $data['hospital_code_list'] = $this->hospital_entry->hospital_code_list();
            $data['item_desc_list'] = $this->hospital_entry->item_desc_list();
            $data['unit_list'] = $this->hospital_entry->unit_list();
            $data['manuf_company_list'] = $this->hospital_entry->manuf_company_list();
            $data['booking_data'] = $this->contact_lens->get_booking_by_id($booking_id);
            $data['doctor'] = $this->doctor->doctors_list();
            // $data['contact_lens'] = 

            // Retrieve the brand by ID
            $result = $this->contact_lens->get_by_id($id, $booking_id, $patient_id);
            // echo "<pre>";print_r($result);die;

            // If no result is found, you might want to handle this case
            if (!$result) {
                // Optionally, set an error message or redirect
                show_error('Vision not found', 404);
                return;
            }
            // Prepare data for the view
            $data['page_title'] = "Update Contact lens";
            $data['form_error'] = '';
            $data['form_data'] = array(
                'items' => $result ?? [],
                'data_id' => $id,
                'booking_id' => $booking_id,
                'patient_id' => $patient_id,
                'optometrist_signature' => $result[0]['optometrist_signature'],
                'doctor_signature' => $result[0]['doctor_signature']
            );



            // Check if there is form submission
            if ($this->input->post()) {
                // Validate the form
                $data['form_data'] = $this->_validate();
                if ($this->form_validation->run() == TRUE) {
                    $this->contact_lens->save();
                    echo 1;
                    return;
                } else {
                    $data['form_error'] = validation_errors();
                }
            }
            // echo "ok";die;
            // Load the view with the prepared data
            $this->load->view('contact_lens/add', $data);
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
            redirect('contact_lens/add');
        } else {
            // Save the record
            $this->contact_lens->save();
            $this->session->set_flashdata('success', 'Record saved successfully');
            redirect('contact_lens');
        }
    }

    public function update()
    {
        $post = $this->input->post();

        if (empty($post['data_id'])) {
            $this->session->set_flashdata('error', 'No record found to update');
            redirect('contact_lens');
        }

        $this->contact_lens->save();
        $this->session->set_flashdata('success', 'Record updated successfully');
        redirect('contact_lens');
    }


    public function contact_lens_excel()
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
        $mainHeader = "Contact Lens List";
        if (!empty($from_date) && !empty($to_date)) {
            $mainHeader .= " (From: " . date('d-m-Y', strtotime($from_date)) . " To: " . date('d-m-Y', strtotime($to_date)) . ")";
        }

        // Set the main header in row 1
        $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $mainHeader);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(16);

        // Leave row 2 blank
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);

        // Field names (header row) should start in row 3
        $fields = array('Token No', 'OPD No', 'Patient Reg. No', 'Patient Name', 'Mobile No', 'Age', 'Created at');

        $col = 0; // Initialize the column index
        foreach ($fields as $field) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 3, $field); // Row 3 for headers
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true); // Auto-size columns
            $col++;
        }

        // Style for header row (Row 3)
        $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // Fetching the OPD data
        $list = $this->contact_lens->get_datatables();

        // Populate the data starting from row 4
        $row = 4; // Start at row 4 for data
        if (!empty($list)) {
            foreach ($list as $contact_lens) {
                // Reset column index for each new row
                $col = 0;
                $age_y = $contact_lens->age_y;
                $age_m = $contact_lens->age_m;
                $age_d = $contact_lens->age_d;

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

                // Prepare data to be populated
                $data = array(
                    $contact_lens->token_no,
                    $contact_lens->booking_code,
                    $contact_lens->patient_code,
                    $contact_lens->patient_name,
                    $contact_lens->mobile_no,
                    $age, // Make sure this is retrieved correctly
                    $contact_lens->created_date,
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
        header('Content-Disposition: attachment;filename="contact_lens_list_' . time() . '.xls"');
        header('Cache-Control: max-age=0');

        // Write the Excel file
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        $objWriter->save('php://output');
    }


    public function contact_lens_pdf()
    {
        // Increase memory limit and execution time for PDF generation
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 300);

        // Prepare data for the PDF
        // $data['print_status'] = "";
        // $from_date = $this->input->get('start_date');
        // $to_date = $this->input->get('end_date');

        // Fetch OPD data
        $data['data_list'] = $this->contact_lens->get_datatables();
        // echo "<pre>";
        // print_r($data);
        // die;
        // $data['data_list']['side_effect_name'] = $this->contact_lens->get_side_effect_name($data['data_list']['side_effects']);
        // Create main header
        $data['mainHeader'] = "Contact Lens List";
        // if (!empty($from_date) && !empty($to_date)) {
        // $data['mainHeader'] .= " (From: " . date('d-m-Y', strtotime($from_date)) . " To: " . date('d-m-Y', strtotime($to_date)) . ")";
        // }

        // Load the view and capture the HTML output
        $this->load->view('contact_lens/contact_lens_pdf_html', $data);
        $html = $this->output->get_output();

        // Load PDF library and convert HTML to PDF
        $this->load->library('pdf');
        $this->pdf->load_html($html);
        $this->pdf->render();

        // Stream the generated PDF to the browser
        $this->pdf->stream("contact_lens_list_" . time() . ".pdf", array("Attachment" => 1));
    }

    public function delete($id)
    {
        $this->contact_lens->delete($id);
        $this->session->set_flashdata('success', 'Record deleted successfully');
        redirect('contact_lens');
    }

    public function delete_multiple()
    {
        $ids = $this->input->post('row_id');
        // echo "<pre>";
        // print_r($ids);
        // die;
        if (!empty($ids)) {
            $this->contact_lens->deleteall($ids);
            // echo json_encode(array("status" => TRUE));
            $response = "Vision successfully deleted.";
            echo $response;
        }
    }

    public function print_vision($id)
    {
        $data['print_status'] = "1";

        // Fetch the form data based on the ID
        $data['form_data'] = $this->contact_lens->get_by_id($id);

        // Fetch the side effect name based on the side_effect ID from form data
        if (!empty($data['form_data']['side_effects'])) {
            $side_effect_id = $data['form_data']['side_effects'];
            $data['form_data']['side_effect_name'] = $this->contact_lens->get_side_effect_name($side_effect_id);
        }

        // Fetch the OPD billing details based on the ID
        $booking_id = isset($data['form_data']['booking_id']) ? $data['form_data']['booking_id'] : '';
        $data['billing_data'] = $this->contact_lens->get_patient_name_by_booking_id($booking_id);
        // echo "<pre>";print_r($data);die;

        // Load the print view with the data
        $this->load->view('contact_lens/print_vision', $data);
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
            "patient_name" => '',
            "patient_code" => '',
            "hospital_code" => "",
            "item_description" => "",
            "menufacturer" => "",
            "unit" => "",
            "hospital_rate" => "",
        );
        if (isset($post) && !empty($post)) {
            $marge_post = array_merge($data['form_data'], $post);
            $this->session->set_userdata('prescription_search', $marge_post);

        }
        $prescription_search = $this->session->userdata('prescription_search');
        if (isset($prescription_search) && !empty($prescription_search)) {
            $data['form_data'] = $prescription_search;
        }
        $this->load->view('contact_lens/advance_search', $data);
    }

    public function print_contact_lens($id = '', $booking_id = '', $patient_id = '')
    {
        $data['print_status'] = "1";
        $data['data_list'] = $this->contact_lens->search_report_data($id, $booking_id, $patient_id);

        $created_date = '';
        if (!empty($data['data_list'][0]['contact_lens']) && is_array($data['data_list'][0]['contact_lens'])) {
            foreach ($data['data_list'][0]['contact_lens'] as $contactLens) {
                if (isset($contactLens['created_date'])) {
                    $created_date = $contactLens['created_date'];
                    // Optionally break the loop if you only need the first created_date
                    break;
                }
            }
        }
        $data['created_date'] = $created_date;
       

        $this->load->view('contact_lens/contact_lens_html', $data);
    }


    public function get_item_details()
    {

        $this->load->model('hospital_code_entry/hospital_code_entry_model', 'hospital_entry');
        $hospital_code_id = $this->input->post('hospital_code');


        if ($hospital_code_id) {
            // Fetch data based on hospital_code
            $data = $this->hospital_entry->get_item_by_code($hospital_code_id);
            // echo "<pre>";
            // print_r($data);
            // die;
            if (!empty($data)) {
                echo json_encode(['success' => true, 'data' => $data]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No data found for this hospital code.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid hospital code ID.']);
        }
    }
    // public function get_item_details() {
    //     $hospital_code = $this->input->post('hospital_code');
    //     $this->load->model('hospital_code_entry/hospital_code_entry_model', 'hospital_entry');

    //     $item_details = $this->hospital_entry->get_item_by_code($hospital_code); // Implement this in your model

    //     if ($item_details) {
    //         echo json_encode(['item' => $item_details]);
    //     } else {
    //         echo json_encode(['item' => null]);
    //     }
    // }

}
