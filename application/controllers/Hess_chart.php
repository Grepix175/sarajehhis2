<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hess_chart extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    auth_users();
    $this->load->model('hess_chart/hess_chart_model', 'prescription');
    $this->load->model('opd/opd_model', 'opd');
    $this->load->model('contact_lens/Contact_lens_model', 'contact_lens');
  }


  public function index()
  {
    // echo "<pre>";
    // print_r('hello');
    // die;
    unauthorise_permission('389', '2413');
    $data['page_title'] = 'Hess Chart List';
    $this->load->model('default_search_setting/default_search_setting_model');
    $default_search_data = $this->default_search_setting_model->get_default_setting();
    if (isset($default_search_data[1]) && !empty($default_search_data) && $default_search_data[1] == 1) {
      $start_date = '';
      $end_date = '';
    } else {
      $start_date = date('d-m-Y');
      $end_date = date('d-m-Y');
    }
    $data['form_data'] = array('patient_name' => '', 'mobile_no' => '', 'patient_code' => '', 'mobile_no' => '', 'start_date' => $start_date, 'end_date' => $end_date,'emergency_booking'=>'');
    $this->load->view('hess_chart/list', $data);
  }

  public function ajax_list()
  {
    unauthorise_permission('389', '2413');
    $users_data = $this->session->userdata('auth_users');
    $this->load->model('opd/opd_model', 'opd');
    $list = $this->prescription->get_datatables();
    // echo "<pre>";
    // print_r($list);
    // die;
    $data = array();
    $no = $_POST['start'];
    $i = 1;
    $total_num = count($list);
    foreach ($list as $prescription) {
      $no++;
      $row = array();
      if ($prescription->status == 1) {
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
      $d_status = '';
      if ($prescription->dilate_status == 0) {
        $d_status = '<span style="color:orange!important;"> Undilated </span>';
      } else if ($prescription->dilate_status == 1) {
        $d_status = '<span style="color:red!important;"> D </span>';
      } else if ($prescription->dilate_status == 2) {
        $d_status = '<span style="color:green!important;"> Dilated </span>';
      }


      if ($prescription->app_type == 0) {
        $app_type = '<font style="background-color: rgb(147, 255, 51);">New</font>';
      } else if ($prescription->app_type == 1) {
        $app_type = '<font style="background-color: rgb(51, 255, 215);">Review</font>';
      } else if ($prescription->app_type == 2) {
        $app_type = '<font style="background-color: rgb(255, 51, 172);">Post OP</font>';
      }
      // print_r($prescription->booking_id);
      // print_r($prescription->booking_id);
      $pat_status = '';
      $contact_lens_txt = '';
      $patient_status = $this->opd->get_by_id_patient_status($prescription->booking_id);
      $contact_lens_status = $this->contact_lens->get_by_contact_lens_status($prescription->booking_id,$prescription->patient_id);
      // echo "<pre>";
      // print_r($patient_status);
      // die;
      $refraction_exists = $this->opd->get_by_id_refraction($prescription->booking_id);
      $pat_status = ($patient_status == 1) 
        ? '<font style="background-color: #228B22;color:white">Vision</font>' 
        : '<font style="background-color: #1CAF9A;color:white">Not Arrived</font>';

    // Determine contact lens status
    $contact_lens_txt = ($contact_lens_status == 1) 
        ? '<font style="background-color: #228B30;color:white">Contact Lens</font>' 
        : '';
    $hess_chart = ($prescription->drawing_flag == 1) 
        ? '<font style="background-color: #228B30;color:white">Hess Chart</font>' 
        : '';
      $age_y = $prescription->age_y;
      $age_m = $prescription->age_m;
      $age_d = $prescription->age_d;

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
      $row[] = '<input type="checkbox" name="prescription[]" class="checklist" value="' . $prescription->id . '">' . $check_script;
      $row[] = $prescription->token_no;
      $row[] = $prescription->booking_code;
      $row[] = $prescription->patient_code;
      $row[] = $prescription->patient_name;
      $row[] = $gender[$prescription->gender];
      $row[] = $prescription->mobile_no;
      $row[] = $age;
      $row[] = $prescription->hess_chart_status == 0 ? '<font color="green">Pending</font>' : '<font color="red">Completed</font>';
      $statuses = explode(',', $prescription->pat_status);

      // Trim any whitespace from the statuses and get the last one
      $last_status = trim(end($statuses));

      // Display the last status with the desired styling
      $row[] = '<font style="background-color: #228B30;color:white">'.$last_status.'</font>';
      // Trim any whitespace from the statuses and get the last one
      $last_status = trim(end($statuses));
      $values = array_filter([$pat_status, $contact_lens_txt, $hess_chart]);

      // $row[] = trim($pat_status . (!empty($pat_status) && !empty($hess_chart) && !empty($contact_lens_txt) ? ' / ' : '') . $contact_lens_txt);
      // $row[] = implode(' / ', $values);
    
      $row[] = date('d-m-Y h:i A', strtotime($prescription->created_date));

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

      // if ($users_data['parent_id'] == $prescription->branch_id) {
        if (in_array('2413', $users_data['permission']['action'])) {
          $flag = 'hess_chart';
          $btn_edit = '<a class="btn-custom" href="' . base_url("eye/add_eye_prescription/test/" . $prescription->booking_id . '/' . $prescription->id) . '?flag=' . $flag . '" title="Edit History"><i class="fa fa-pencil"></i> Edit Hess chart</a>';

        }
      //   $btn_delete = '';
      //   // if (in_array('2413', $users_data['permission']['action'])) {
      //   //   $btn_delete = ' <a class="btn-custom" onClick="return delete_eye_prescription(' . $prescription->id . ')" href="javascript:void(0)" title="Delete" data-url="512"><i class="fa fa-trash"></i> Delete</a>';
      //   // }
      // }
      // echo "<pre>";
      // print_r($contact_lens_status);
      // die;
      // if ($contact_lens_status == '1') {
      //   $btn_contact_lens = '<a class="btn-custom disabled" href="javascript:void(0);" title="Contact Lens" style="pointer-events: none; opacity: 0.6;" data-url="512">  Contact Lens</a>';
      // } else {
      //   // $btn_contact_lens = '<a class="btn-custom" href="' . base_url("eye/add_eye_prescription/test/" . $prescription->booking_id . '/' . $prescription->id) . '?flag=' . $flag . '" title=" Contact Lens"> Contact Lens</a>';
      //   $btn_contact_lens = '<a class="btn-custom" href="' . base_url("contact_lens/add/" . $prescription->booking_id . '/' . $prescription->patient_id) . '" title="Contact Lens" data-url="512">Contact Lens</a>';
      // }
      // if($prescription->drawing_flag == 0){
      //   $flag = 'hess_chart'; 
      //   $type = 'help_desk';
      //   $btn_hess_chart = '<a class="btn-custom" href="' . base_url("eye/add_eye_prescription/test/" . $prescription->booking_id . '/' . $prescription->id) . '?flag=' . $flag . "&type=" . $type . '" title="Hess Chart">Hess Chart</a>';
      // }else{
      //   $btn_hess_chart = '<a class="btn-custom disabled" href="javascript:void(0);" title="Hess Chart" style="pointer-events: none; opacity: 0.6;" data-url="512">  Hess Chart</a>';
      // }

      
      /* if(in_array('2413',$users_data['permission']['action'])) 
            {
               $btn_view_pre = ' <a class="btn-custom"  href="'.base_url('eye/add_eye_prescription/view_prescription/'.$prescription->id.'/'.$prescription->booking_id).'" title="View Eye Prescription" target="_blank" data-url="512"><i class="fa fa-info-circle"></i> View Eye Prescription</a>';
            } */
      if (in_array('2413', $users_data['permission']['action'])) {
          $flag = 'hess_chart'; 
        $type = 'help_desk';
        $print_url = "'" . base_url('eye/add_eye_prescription/view_prescription/' . $prescription->id . '/' . $prescription->booking_id) . '?flag=' . $flag . "&type=" . $type . "'";
        $btn_print_pre = ' <a class="btn-custom" onClick="return print_window_page(' . $print_url . ')" href="javascript:void(0)" title="Print History"  data-url="512"><i class="fa fa-print"></i> Print Hess Chart</a>';
      }
      //   if (in_array('2413', $users_data['permission']['action'])) {
      //     // Logic for $refraction
      //     if ($refraction_exists == 1) {
      //         $refraction = '<a class="btn-custom" disabled href="#" title="Refraction" style="pointer-events: none; opacity: 0.6;">Refraction</a>';
      //     } else {
      //         $refraction = '<a class="btn-custom" href="' . base_url("refraction/add/" . $prescription->patient_id . '/' . $prescription->id) . '" title="Refraction">Refraction</a>';
      //     }
      //     // Logic for $send_to_vission
      //     if ($patient_status == 1) {
      //         $send_to_vission = '<a class="btn-custom disabled" href="#" title="Send To Vision" style="pointer-events: none; opacity: 0.6;">Vision</a>';
      //     } else {
      //         $send_to_vission = '<a class="btn-custom" href="' . base_url("vision/add/" . $prescription->booking_id . '/' . $prescription->id) . '" title="Vision">Vision</a>';
      //     }
      // }

      $send_to = '';
      if ($prescription->hess_chart_status == 0) {
          $send_to = '<button type="button" class="btn-custom open-popup-send-to" 
                      id="open-popup" 
                      data-booking-id="' . $prescription->booking_id . '" 
                      data-patient-id="' . $prescription->patient_id . '" 
                      data-referred-by="' . $prescription->attended_doctor . '" 
                      data-mod-type="hess_chart" 
                      data-url="' . $prescription->url . '" 
                      title="">Send To</button>';
        }else{
          $send_to = '<a class="btn-custom disabled" href="javascript:void(0);" title="Send To Vision" style="pointer-events: none; opacity: 0.6;" data-url="512"> Send To</a>';
        }

      // Add buttons to the row
      $row[] = $btn_print_pre . $btn_upload_pre . $btn_view_upload_pre . $btn_edit . $btn_view . $btn_delete . $btn_contact_lens . $btn_hess_chart . $send_to;
      $row[] = $prescription->emergency_status;

      $data[] = $row;
      $i++;
  }

  $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->prescription->count_all(),
      "recordsFiltered" => $this->prescription->count_filtered(),
      "data" => $data,
  );
  echo json_encode($output);
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
      "mobile_no" => "",
      'branch_id' => '',
    );
    if (isset($post) && !empty($post)) {
      $marge_post = array_merge($data['form_data'], $post);
      $this->session->set_userdata('prescription_search', $marge_post);

    }
    $prescription_search = $this->session->userdata('prescription_search');
    if (isset($prescription_search) && !empty($prescription_search)) {
      $data['form_data'] = $prescription_search;
    }
    $this->load->view('hess_chart/advance_search', $data);
  }

  public function reset_search()
  {
    $this->session->unset_userdata('prescription_search');
  }

  public function help_desk_excel()
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
    $mainHeader = "Hess Chart List";
    if (!empty($from_date) && !empty($to_date)) {
      $mainHeader .= " (From: " . date('d-m-Y', strtotime($from_date)) . " To: " . date('d-m-Y', strtotime($to_date)) . ")";
    }

    // Set the main header in row 1
    $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
    $objPHPExcel->getActiveSheet()->setCellValue('A1', $mainHeader);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(16);

    // Leave row 2 blank (you can set row height if needed)
    $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);

    // Field names (header row) should start in row 3
    $fields = array('Token No.', 'OPD. No.', 'Patient Reg. No.', 'Patient Name', 'Mobile No.', 'Age', 'Created Date');

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

    // Fetching the OPD data (assuming you have the data in $list)

    $list = $this->prescription->search_help_desk_data();
    // echo "<pre>";
    // print_r($list);
    // die;
    // Populate the data starting from row 4
    $row = 4; // Start at row 4 for data
    if (!empty($list)) {
      foreach ($list as $opds) {
        $col = 0;
        $referredBy = $opds->referred_by == 0 ? 'Doctor' : 'Hospital';
        $age_y = $opds->age_y;
        $age_m = $opds->age_m;
        $age_d = $opds->age_d;

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
        $pat_status = '';
        $patient_status = $this->opd->get_by_id_patient_details($opds->booking_id);

        if ($patient_status['completed'] == '1') {
          $pat_status = 'Completed';
        } else if ($patient_status['doctor'] == '1') {
          $pat_status = 'Doctor';
        } else if ($patient_status['optimetrist'] == '1') {
          $pat_status = 'Opt.Optom';
        } else if ($patient_status['reception'] == '1') {
          $pat_status = 'Reception';
        } else if ($patient_status['arrive'] == '1') {
          $pat_status = 'Arrived';
        } else {
          $pat_status = 'Not Arrived';
        }
        $data = array(
          $opds->token_no,
          $opds->booking_code,
          $opds->patient_code,
          $opds->patient_name,
          $opds->mobile_no,
          $age,
          date('d-M-Y', strtotime($opds->created_date)),
        );

        foreach ($data as $cellValue) {
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $cellValue);
          $col++;
        }
        $row++;
      }
    }

    // Send headers to force download of the file
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="hess_chart_list_' . time() . '.xls"');
    header('Cache-Control: max-age=0');

    // Write the Excel file
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    ob_end_clean();
    $objWriter->save('php://output');
  }

  public function help_desk_pdf()
  {
    // Increase memory limit and execution time for PDF generation
    ini_set('memory_limit', '2048M');
    ini_set('max_execution_time', 300);

    // Prepare data for the PDF
    $data['print_status'] = "";
    $from_date = $this->input->get('start_date');
    $to_date = $this->input->get('end_date');

    // Fetch OPD data
    $data['data_list'] = $this->prescription->search_help_desk_data();
    // echo "<pre>";
    // print_r($data);
    // die;
    // Create main header
    $data['mainHeader'] = "Hess Chart List";
    if (!empty($from_date) && !empty($to_date)) {
      $data['mainHeader'] .= " (From: " . date('d-m-Y', strtotime($from_date)) . " To: " . date('d-m-Y', strtotime($to_date)) . ")";
    }

    // Load the view and capture the HTML output
    $this->load->view('hess_chart/help_desk_html', $data);
    $html = $this->output->get_output();

    // Load PDF library and convert HTML to PDF
    $this->load->library('pdf');
    $this->pdf->load_html($html);
    $this->pdf->render();

    // Stream the generated PDF to the browser
    $this->pdf->stream("hess_chart_list_" . time() . ".pdf", array("Attachment" => 1));
  }

  function deleteall()
    {
        unauthorise_permission('411', '2488');
        $post = $this->input->post();
        if (!empty($post)) {
            $result = $this->prescription->deleteall($post['row_id']);
            $response = "Help Desk successfully deleted.";
            echo $response;
        }
    }

    public function book_patient()
    {
        // public function book_patient() {
        $patient_id = $this->input->post('patient_id');
        // $this->load->model('token_no');

        // Perform booking logic
        $booking_result = $this->prescription->book_patient($patient_id);

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
        $status = $this->prescription->get_booking_status($patient_id);
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
        $updated = $this->prescription->update_patient_list_opd_status($patientId, 'new_status'); // Adjust as needed

        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'Status updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update status.']);
        }
    }

}
?>