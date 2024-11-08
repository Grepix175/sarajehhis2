<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Help_desk extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    auth_users();
    $this->load->model('help_desk/help_desk_model', 'prescription');
    $this->load->model('opd/opd_model', 'opd');
    $this->load->model('contact_lens/Contact_lens_model', 'contact_lens');
    $this->load->model('low_vision/Low_vision_model', 'low_vision');
  }


  public function index()
  {
    unauthorise_permission('389', '2413');
    $data['page_title'] = 'Help Desk List';
    $this->load->model('default_search_setting/default_search_setting_model');
    $default_search_data = $this->default_search_setting_model->get_default_setting();
    if (isset($default_search_data[1]) && !empty($default_search_data) && $default_search_data[1] == 1) {
      $start_date = '';
      $end_date = '';
    } else {
      $start_date = date('d-m-Y');
      $end_date = date('d-m-Y');
    }
    $data['form_data'] = array('patient_name' => '', 'mobile_no' => '', 'patient_code' => '', 'mobile_no' => '', 'start_date' => $start_date, 'end_date' => $end_date);
    $this->load->view('help_desk/list', $data);
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
      $contact_lens_status = $this->contact_lens->get_by_contact_lens_status($prescription->booking_id, $prescription->patient_id);
      $low_vision_status = $this->low_vision->get_by_low_vision_status($prescription->booking_id, $prescription->patient_id);
     
      $refraction_exists = $this->opd->get_by_id_refraction($prescription->booking_id);
      $dilate_exists = $this->opd->get_by_id_dilate($prescription->patient_id);
      $pat_status = ($patient_status == 1)
        ? '<font style="background-color: #228B22;color:white">Vision</font>'
        : '';

      // Determine contact lens status
      $contact_lens_txt = ($contact_lens_status == 1)
        ? '<font style="background-color: #228B30;color:white">Contact Lens</font>'
        : '';
      $hess_chart = ($prescription->drawing_flag == 1)
        ? '<font style="background-color: #228B30;color:white">Hess Chart</font>'
        : '';
        $refraction_below8 = ($prescription->refraction_below8 == 1)
        ? '<font style="background-color: #228B30;color:white">Refraction Below 8 Year</font>'
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
      $values = array_filter([$pat_status, $contact_lens_txt, $hess_chart,$refraction_below8]);

      // $row[] = trim($pat_status . (!empty($pat_status) && !empty($hess_chart) && !empty($contact_lens_txt) ? ' / ' : '') . $contact_lens_txt);
      $row[] = !empty($values) ? implode(' / ', $values) : 'Not Arrived';

      $row[] = date('d-M-Y', strtotime($prescription->created_date));

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
      $btn_low_vision = "";
      $btn_refraction_below8 = "";
      $dilate = "";

      if ($users_data['parent_id'] == $prescription->branch_id) {
        if (in_array('2413', $users_data['permission']['action'])) {
          $flag = 'eye_history';
          $btn_edit = '<a class="btn-custom" href="' . base_url("eye/add_eye_prescription/test/" . $prescription->booking_id . '/' . $prescription->id) . '?flag=' . $flag . '" title="Edit History"><i class="fa fa-pencil"></i> Edit History</a>';

        }
        $btn_delete = '';
        // if (in_array('2413', $users_data['permission']['action'])) {
        //   $btn_delete = ' <a class="btn-custom" onClick="return delete_eye_prescription(' . $prescription->id . ')" href="javascript:void(0)" title="Delete" data-url="512"><i class="fa fa-trash"></i> Delete</a>';
        // }
      }
      // echo "<pre>";
      // print_r($contact_lens_status);
      // die;
      if ($contact_lens_status == '1') {
        $btn_contact_lens = '<a class="btn-custom disabled" href="javascript:void(0);" title="Contact Lens" style="pointer-events: none; opacity: 0.6;" data-url="512">  Contact Lens</a>';
      } else {
        // $btn_contact_lens = '<a class="btn-custom" href="' . base_url("eye/add_eye_prescription/test/" . $prescription->booking_id . '/' . $prescription->id) . '?flag=' . $flag . '" title=" Contact Lens"> Contact Lens</a>';
        $btn_contact_lens = '<a class="btn-custom" href="' . base_url("contact_lens/add/" . $prescription->booking_id . '/' . $prescription->patient_id) . '" title="Contact Lens" data-url="512">Contact Lens</a>';
      }
      if ($low_vision_status == '1') {
        $btn_low_vision = '<a class="btn-custom disabled" href="javascript:void(0);" title="Contact Lens" style="pointer-events: none; opacity: 0.6;" data-url="512"> Low Vision</a>';
      } else {
        // $btn_contact_lens = '<a class="btn-custom" href="' . base_url("eye/add_eye_prescription/test/" . $prescription->booking_id . '/' . $prescription->id) . '?flag=' . $flag . '" title=" Contact Lens"> Contact Lens</a>';
        $btn_low_vision = '<a class="btn-custom" href="' . base_url("low_vision/add/" . $prescription->booking_id . '/' . $prescription->patient_id) . '" title="Contact Lens" data-url="512">Low vision</a>';
      }
      if ($prescription->drawing_flag == 0) {
        $flag = 'hess_chart';
        $type = 'help_desk';
        $btn_hess_chart = '<a class="btn-custom" href="' . base_url("eye/add_eye_prescription/test/" . $prescription->booking_id . '/' . $prescription->id) . '?flag=' . $flag . "&type=" . $type . '" title="Hess Chart">Hess Chart</a>';
      } else {
        $btn_hess_chart = '<a class="btn-custom disabled" href="javascript:void(0);" title="Hess Chart" style="pointer-events: none; opacity: 0.6;" data-url="512">  Hess Chart</a>';
      }

      if ($prescription->refraction_below8 == 0) {
        

        $flag = 'refraction_below_8_years';
        $type = 'help_desk';
        $btn_refraction_below8 = '<a class="btn-custom" href="' . base_url("eye/add_eye_prescription/test/" . $prescription->booking_id . '/' . $prescription->id) . '?flag=' . $flag . "&type=" . $type . '" title="Refraction below 8 Years">Refraction Below 8 Years</a>';
        
      } else {

        $btn_refraction_below8 = '<a class="btn-custom disabled" href="javascript:void(0);" title="Refraction below 8 Years" style="pointer-events: none; opacity: 0.6;" data-url="512">Refraction Below 8 Years</a>';
      }

      


      /* if(in_array('2413',$users_data['permission']['action'])) 
            {
               $btn_view_pre = ' <a class="btn-custom"  href="'.base_url('eye/add_eye_prescription/view_prescription/'.$prescription->id.'/'.$prescription->booking_id).'" title="View Eye Prescription" target="_blank" data-url="512"><i class="fa fa-info-circle"></i> View Eye Prescription</a>';
            } */
      if (in_array('2413', $users_data['permission']['action'])) {
        $print_url = "'" . base_url('eye/add_eye_prescription/view_prescription/' . $prescription->id . '/' . $prescription->booking_id) . "'";
        $btn_print_pre = ' <a class="btn-custom" onClick="return print_window_page(' . $print_url . ')" href="javascript:void(0)" title="Print History"  data-url="512"><i class="fa fa-print"></i> Print History</a>';
      }
      if (in_array('2413', $users_data['permission']['action'])) {
        if ($refraction_exists == 1) {

          $refraction = '<a class="btn-custom " disabled href="' . base_url("refraction/add/" . $prescription->patient_id . '/' . $prescription->id) . '" title="Refraction" data-url="512">Refraction</a>';
        } else {
          $refraction = '<a class="btn-custom" href="' . base_url("refraction/add/" . $prescription->patient_id . '/' . $prescription->id) . '" title="Refraction" data-url="512">Refraction</a>';

        }
      }
      if (in_array('2413', $users_data['permission']['action'])) {
        if ($dilate_exists == 1) {
            // Enable the "Dilate" button if dilate exists
            $dilate = '<a class="btn-custom " disabled href="javascript:void(0)" title="Dilate" style="pointer-events: none; opacity: 0.6;">Dilate</a>';
          } else {
            // Disable the "Dilate" button and change its style to look inactive
            $dilate = '<a class="btn-custom" href="' . base_url("dilate/add/" . $prescription->patient_id . '/' . $prescription->id) . '" title="Dilate" data-url="512">Dilate</a>';
        }
      
      }
      if (in_array('2413', $users_data['permission']['action'])) {
        $print_url = "'" . base_url('eye/add_eye_prescription/view_prescription/' . $prescription->id . '/' . $prescription->booking_id) . "'";
        if ($patient_status == 1) {
          $send_to_vission = '<a class="btn-custom disabled" href="javascript:void(0);" title="Send To Vision" style="pointer-events: none; opacity: 0.6;" data-url="512"> Vision</a>';
        } else {
          $send_to_vission = '<a class="btn-custom" href="' . base_url("vision/add/" . $prescription->booking_id . '/' . $prescription->id) . '" title="Vision" data-url="512">Vision</a>';
        }
      }

      // $print_chasma_url = "'" . base_url('eye/add_eye_prescription/print_chasma_details/' . $prescription->id . '/' . $prescription->booking_id) . "'";
      // $btn_print_chasma_pre = ' <a class="btn-custom" onClick="return print_window_page(' . $print_chasma_url . ')" href="javascript:void(0)" title="Print Chasma Detail"  data-url="512"><i class="fa fa-print"></i> Print Chasma Detail</a>';

      // . $btn_print_chasma_pre
      $row[] = $btn_print_pre . $btn_upload_pre . $btn_view_upload_pre . $btn_edit . $btn_view . $btn_delete . $refraction . $send_to_vission . $btn_contact_lens . $btn_low_vision.
        $btn_hess_chart.$btn_refraction_below8.$dilate;
      // print_r($row);
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
    $this->load->view('help_desk/advance_search', $data);
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
    $mainHeader = "Help Desk List";
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
    $fields = array('Token No.', 'OPD. No.', 'Patient Reg. No.', 'Patient Name', 'Mobile No.', 'Age', 'Patient Status');

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
          $pat_status,
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
    header('Content-Disposition: attachment;filename="help_desk_list_' . time() . '.xls"');
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
    $data['mainHeader'] = "Help Desk List";
    if (!empty($from_date) && !empty($to_date)) {
      $data['mainHeader'] .= " (From: " . date('d-m-Y', strtotime($from_date)) . " To: " . date('d-m-Y', strtotime($to_date)) . ")";
    }

    // Load the view and capture the HTML output
    $this->load->view('help_desk/help_desk_html', $data);
    $html = $this->output->get_output();

    // Load PDF library and convert HTML to PDF
    $this->load->library('pdf');
    $this->pdf->load_html($html);
    $this->pdf->render();

    // Stream the generated PDF to the browser
    $this->pdf->stream("help_desk_list_" . time() . ".pdf", array("Attachment" => 1));
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

}
?>