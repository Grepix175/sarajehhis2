<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Refraction_below8 extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('refraction_below8/Refraction_below8_model', 'refraction_below8');
    $this->load->library('form_validation');

  }

  public function index()
  {
    // error_reporting(0);
    $data['page_title'] = 'Refraction Below 8 Records';
    $this->load->model('default_search_setting/default_search_setting_model');
    $default_search_data = $this->default_search_setting_model->get_default_setting();
    if (isset($default_search_data[1]) && !empty($default_search_data) && $default_search_data[1] == 1) {
      $start_date = '';
      $end_date = '';
    } else {
      $start_date = date('d-m-Y');
      $end_date = date('d-m-Y');
    }
    $data['form_data'] = array('patient_name' => '', 'patient_code' => '', 'mobile_no' => '', 'start_date' => $start_date, 'end_date' => $end_date, 'emergency_booking' => '');

    $this->load->view('refraction_below8/list', $data);
  }

  public function ajax_list()
  {
    unauthorise_permission('389', '2413');
    $users_data = $this->session->userdata('auth_users');
    $this->load->model('opd/opd_model', 'opd');
    $list = $this->refraction_below8->get_datatables();
    // echo "<pre>";
    // print_r($list);
    // die;
    $data = array();
    $no = $_POST['start'];
    $i = 1;
    $total_num = count($list);
    foreach ($list as $refraction_below8) {
      $no++;
      $row = array();
      if ($refraction_below8->status == 1) {
        $status = '<font color="green">Active</font>';
      } else {
        $status = '<font color="red">Inactive</font>';
      }

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

      // print_r($refraction_below8->booking_id);
      // print_r($refraction_below8->booking_id);
      $pat_status = '';
      // $contact_lens_txt = '';
      $patient_status = $this->opd->get_by_id_patient_status($refraction_below8->booking_id);
      // $contact_lens_status = $this->contact_lens->get_by_contact_lens_status($refraction_below8->booking_id,$refraction_below8->patient_id);
      // echo "<pre>";
      // print_r($patient_status);
      // die;
      //   $refraction_exists = $this->opd->get_by_id_refraction($refraction_below8->booking_id);
      $pat_status = ($patient_status == 1)
        ? '<font style="background-color: #228B22;color:white">Vision</font>'
        : '<font style="background-color: #1CAF9A;color:white">Not Arrived</font>';

      // // Determine contact lens status
      // $contact_lens_txt = ($contact_lens_status == 1) 
      //     ? '<font style="background-color: #228B30;color:white">Contact Lens</font>' 
      //     : '';
      // $hess_chart = ($refraction_below8->drawing_flag == 1) 
      //     ? '<font style="background-color: #228B30;color:white">Hess Chart</font>' 
      //     : '';
      $age_y = $refraction_below8->age_y;
      $age_m = $refraction_below8->age_m;
      $age_d = $refraction_below8->age_d;

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
      $row[] = '<input type="checkbox" name="refraction_below8[]" class="checklist" value="' . $refraction_below8->id . '">' . $check_script;
      $row[] = $refraction_below8->token_no;
      $row[] = $refraction_below8->booking_code;
      $row[] = $refraction_below8->patient_code;
      $row[] = $refraction_below8->patient_name;
      $row[] = $gender[$refraction_below8->gender];
      $row[] = $refraction_below8->mobile_no;
      $row[] = $age;
      $row[] = $refraction_below8->refra_below_status == 0 ? '<font color="green">Pending</font>' : '<font color="red">Completed</font>';
      $statuses = explode(',', $refraction_below8->pat_status);

      // Trim any whitespace from the statuses and get the last one
      $last_status = trim(end($statuses));

      // Display the last status with the desired styling
      $row[] = '<font style="background-color: #228B30;color:white">' . $last_status . '</font>';
      // Trim any whitespace from the statuses and get the last one
      $last_status = trim(end($statuses));
      // $row[] = trim($pat_status . (!empty($pat_status) && !empty($hess_chart) && !empty($contact_lens_txt) ? ' / ' : '') . $contact_lens_txt);
      // $row[] = implode(' / ', $values);

      $row[] = date('d-m-Y h:i A', strtotime($refraction_below8->created_date));

      //Action button /////
      $btn_edit = "";
      $btn_view = "";
      $btn_delete = "";
      $btn_view_pre = "";
      $btn_print_pre = "";
      $btn_upload_pre = "";
      $btn_view_upload_pre = "";
      $btn_contact_lens = "";
      $btn_hess_chart = "";

      // if ($users_data['parent_id'] == $refraction_below8->branch_id) {
      if (in_array('2413', $users_data['permission']['action'])) {
        $flag = 'refraction_below_8_years';
        $btn_edit = '<a class="btn-custom" href="' . base_url("eye/add_eye_prescription/test/" . $refraction_below8->booking_id . '/' . $refraction_below8->id) . '?flag=' . $flag . "&type=help_desk" . '" title="Edit"><i class="fa fa-pencil"></i> Edit</a>';

      }
      //   $btn_delete = '';
      //   // if (in_array('2413', $users_data['permission']['action'])) {
      //   //   $btn_delete = ' <a class="btn-custom" onClick="return delete_eye_refraction_below8(' . $refraction_below8->id . ')" href="javascript:void(0)" title="Delete" data-url="512"><i class="fa fa-trash"></i> Delete</a>';
      //   // }
      // }
      // echo "<pre>";
      // print_r($contact_lens_status);
      // die;
      // if ($contact_lens_status == '1') {
      //   $btn_contact_lens = '<a class="btn-custom disabled" href="javascript:void(0);" title="Contact Lens" style="pointer-events: none; opacity: 0.6;" data-url="512">  Contact Lens</a>';
      // } else {
      //   // $btn_contact_lens = '<a class="btn-custom" href="' . base_url("eye/add_eye_refraction_below8/test/" . $refraction_below8->booking_id . '/' . $refraction_below8->id) . '?flag=' . $flag . '" title=" Contact Lens"> Contact Lens</a>';
      //   $btn_contact_lens = '<a class="btn-custom" href="' . base_url("contact_lens/add/" . $refraction_below8->booking_id . '/' . $refraction_below8->patient_id) . '" title="Contact Lens" data-url="512">Contact Lens</a>';
      // }
      // if($refraction_below8->drawing_flag == 0){
      //   $flag = 'hess_chart'; 
      //   $type = 'help_desk';
      //   $btn_hess_chart = '<a class="btn-custom" href="' . base_url("eye/add_eye_refraction_below8/test/" . $refraction_below8->booking_id . '/' . $refraction_below8->id) . '?flag=' . $flag . "&type=" . $type . '" title="Hess Chart">Hess Chart</a>';
      // }else{
      //   $btn_hess_chart = '<a class="btn-custom disabled" href="javascript:void(0);" title="Hess Chart" style="pointer-events: none; opacity: 0.6;" data-url="512">  Hess Chart</a>';
      // }


      /* if(in_array('2413',$users_data['permission']['action'])) 
            {
              $btn_view_pre = ' <a class="btn-custom"  href="'.base_url('eye/add_eye_refraction_below8/view_refraction_below8/'.$refraction_below8->id.'/'.$refraction_below8->booking_id).'" title="View Eye refraction_below8" target="_blank" data-url="512"><i class="fa fa-info-circle"></i> View Eye refraction_below8</a>';
            } */

      if (in_array('2413', $users_data['permission']['action'])) {
        $flag = 'refraction_below_8_years';
        $type = 'help_desk';
        $print_url = "'" . base_url('eye/add_eye_prescription/view_prescription/' . $refraction_below8->id . '/' . $refraction_below8->booking_id) . '?flag=' . $flag . "&type=" . $type . "'";

        // $print_url = "'" . base_url('refraction_below8/print_refraction/' . $refraction_below8->id . '/' . $refraction_below8->booking_id) . '?flag=' . $flag . "&type=" . $type . "'";
        $btn_print_pre = ' <a class="btn-custom" onClick="return print_window_page(' . $print_url . ')" href="javascript:void(0)" title="Print"  data-url="512"><i class="fa fa-print"></i> Print</a>';
      }
      if (in_array('2413', $users_data['permission']['action'])) {
        // Logic for $refraction
        // if ($refraction_exists == 1) {
        //     $refraction = '<a class="btn-custom" disabled href="#" title="Refraction" style="pointer-events: none; opacity: 0.6;">Refraction</a>';
        // } else {
        //     $refraction = '<a class="btn-custom" href="' . base_url("refraction/add/" . $refraction_below8->patient_id . '/' . $refraction_below8->id) . '" title="Refraction">Refraction</a>';
        // }
        // Logic for $send_to_vission
        if ($patient_status == 1) {
          $send_to_vission = '<a class="btn-custom disabled" href="#" title="Send To Vision" style="pointer-events: none; opacity: 0.6;">Vision</a>';
        } else {
          $send_to_vission = '<a class="btn-custom" href="' . base_url("vision/add/" . $refraction_below8->booking_id . '/' . $refraction_below8->id) . '" title="Vision">Vision</a>';
        }
      }
      $send_to = '';
      if ($refraction_below8->refra_below_status == 0) {
        $send_to = '<button type="button" class="btn-custom open-popup-send-to" 
                      id="open-popup" 
                      data-booking-id="' . $refraction_below8->booking_id . '" 
                      data-patient-id="' . $refraction_below8->patient_id . '" 
                      data-referred-by="' . $refraction_below8->attended_doctor . '" 
                      data-mod-type="refraction_below8" 
                      data-url="' . $refraction_below8->url . '" 
                      title="">Send To</button>';
      } else {
        $send_to = '<a class="btn-custom disabled" href="javascript:void(0);" title="Send To Vision" style="pointer-events: none; opacity: 0.6;" data-url="512"> Send To</a>';
      }

      // Add buttons to the row
      $row[] = $btn_print_pre . $btn_upload_pre . $btn_view_upload_pre . $btn_edit . $btn_view . $btn_delete . $send_to;
      $row[] = $refraction_below8->emergency_status;


      $data[] = $row;
      $i++;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->refraction_below8->count_all(),
      "recordsFiltered" => $this->refraction_below8->count_filtered(),
      "data" => $data,
    );
    echo json_encode($output);
  }


  public function add()
  {
    // echo "<pre>"; print_r( $this->input->post()); die;
    $post = $this->input->post();
    $data['page_title'] = 'Add Refraction Below 8 Records';
    $this->load->model('default_search_setting/default_search_setting_model');
    // $default_search_data = $this->default_search_setting_model->get_default_setting();
    // if (isset($default_search_data[1]) && !empty($default_search_data) && $default_search_data[1] == 1) {
    //     $start_date = '';
    //     $end_date = '';
    // } else {
    //     $start_date = date('d-m-Y');
    //     $end_date = date('d-m-Y');
    // }
    // $data['form_data'] = array('patient_name' => '', 'patient_code' => '','mobile_no' => '', 'start_date' => $start_date, 'end_date' => $end_date);

    if (!empty($post)) {
      // $emeId = $test_id = $this->uri->segment(4);;
      // echo"<pre>";
      // print_r($emeId);
      // die;
      $this->refraction_below8->save();
      $this->session->set_flashdata('success', 'refraction_below8 successfully added.');
      // $flag = $this->input->get('flag');
      // if($flag == 'eye_history'){
      redirect(base_url('refraction_below8'));

      // }else{
      //   // echo "<pre>";
      //   // print_r('$post');
      //   // die;
      //   return redirect(base_url('hess_chart'));
      // }
    }
    $this->load->view('refraction_below8/add', $data);
  }

  public function print_refraction($id)
  {
    // echo $id;die;
    $data['print_status'] = "1";

    // Fetch the form data based on the ID
    $result = $this->refraction_below8->get_by_id($id);
    // $data['booking_data'] = $this->dilate->get_booking_by_id($result[0]['booking_code']);
    // $data['medicine'] = $this->dilate->get_item_by_medicine($result['drop_name']);
    // $data['medicines'] = $this->dilate->get_all_medicines();
    echo "<pre>";
    print_r($result);
    die;

    // If no result is found, handle the error
    if (!$result) {
      show_error('Dilate not found', 404);
      return;
    }

    // Prepare the data for the view
    $data['page_title'] = "Print Refraction Below8";
    // $data['form_error'] = '';
    // $data['form_data'] = array(
    //     'items' => $result ?? [],
    //     'data_id' => $id,
    //     'booking_id' => $result[0]['booking_id'],
    //     'patient_id' => $result[0]['patient_id'],
    //     'remarks' => $result[0]['remarks']
    // );
    // $data['booking_id'] = isset($result[0]['booking_id']) ? $result[0]['booking_id'] : '';
    // $data['patient_id'] = isset($result[0]['patient_id']) ? $result[0]['patient_id'] : '';


    // Fetch the side effect name based on the side_effect ID from form data


    // Fetch the OPD billing details based on the ID
    // $booking_id = isset($data['form_data']['booking_id']) ? $data['form_data']['booking_id'] : '';
    // $data['billing_data'] = $this->dilate->get_patient_name_by_booking_id($booking_id);
    // echo "<pre>";print_r($data);die;

    // Load the print view with the data
    $this->load->view('refraction_below8/print_refraction', $data);
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
    $mainHeader = "Refraction below 8 years List";
    if (!empty($from_date) && !empty($to_date)) {
      $mainHeader .= " (From: " . date('d-m-Y', strtotime($from_date)) . " To: " . date('d-m-Y', strtotime($to_date)) . ")";
    }

    // Set the main header in row 1
    $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
    $objPHPExcel->getActiveSheet()->setCellValue('A1', $mainHeader);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(16);

    // Leave row 2 blank
    $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);

    // Field names (header row) should start in row 3
    $fields = array(
      'Token No.',
      'OPD No.',
      'Patient Reg No.',
      'Patient Name',
      'Gender',
      'Mobile No.',
      'Age',
      'Created Date'
    );

    // Set header fields in row 3
    $col = 0; // Initialize the column index
    foreach ($fields as $field) {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 3, $field); // Row 3 for headers
      $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true); // Auto-size columns
      $col++;
    }

    // Style for header row (Row 3)
    $objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    // Fetching the OPD data from get_datatables()
    $list = $this->refraction_below8->get_datatables();

    // Populate the data starting from row 4
    $row = 4; // Start at row 4 for data
    if (!empty($list)) {
      foreach ($list as $record) {
        $col = 0; // Reset column index for each row

        // Populate each column with the corresponding data
        $data = array(
          $record->token_no,         // Token No.
          $record->opd_no,           // OPD No.
          $record->patient_reg_no,   // Patient Reg No.
          $record->patient_name,     // Patient Name
          $record->gender,           // Gender
          $record->mobile_no,        // Mobile No.
          $record->age,              // Age
          date('d-M-Y', strtotime($record->created_date)) // Created Date
        );

        // Populate each cell in the row
        foreach ($data as $cellValue) {
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $cellValue);
          $col++;
        }

        // Move to the next row
        $row++;
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
    $list = $this->refraction_below8->get_datatables();

    // // Assuming you want to fetch booking data based on the first patient's booking_id
    // $data['booking_data'] = $this->dilate->get_booking_by_id($list[0]->booking_id);


    // Prepare the main header for the PDF
    $data['mainHeader'] = "Refraction Below 8years List";

    // Load the view and capture the HTML output
    $this->load->view('refraction_below8/refraction_below8_html', $data);
    $html = $this->output->get_output();

    // Load PDF library and convert HTML to PDF
    $this->load->library('pdf');
    $this->pdf->load_html($html);
    $this->pdf->render();

    // Stream the generated PDF to the browser
    $this->pdf->stream("dilate_list_" . time() . ".pdf", array("Attachment" => 1));
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
    $this->load->view('refraction_below8/advance_search', $data);
  }

  public function book_patient()
  {
    // public function book_patient() {
    $patient_id = $this->input->post('patient_id');
    // $this->load->model('token_no');

    // Perform booking logic
    $booking_result = $this->refraction_below8->book_patient($patient_id);

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
    $status = $this->refraction_below8->get_booking_status($patient_id);
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
    $updated = $this->refraction_below8->update_patient_list_opd_status($patientId, 'new_status'); // Adjust as needed

    if ($updated) {
      echo json_encode(['status' => 'success', 'message' => 'Status updated successfully.']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to update status.']);
    }
  }

}