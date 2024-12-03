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
    $this->load->model('prosthetic/Prosthetic_model', 'prosthetic');
    $this->load->model('oct_hfa/Oct_hfa_model', 'oct_hfa');
    $this->load->model('ortho_ptics/Ortho_ptics_model', 'ortho_ptics');
    $this->load->model('send_to_token/Send_to_token_model', 'send_to_token');
    $this->load->model('doctore_patient/Doctore_patient_model', 'doctore_patient');
    $this->load->model('refraction/Refraction_model', 'refraction');
    $this->load->model('eye/add_prescription/add_new_prescription_model', 'add_prescript');
    $this->load->model('general/general_model');
    $this->load->model('dilate/Dilate_model', 'dilate');
    error_reporting(0);
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
      $prosthetic_status = $this->prosthetic->get_by_low_vision_status($prescription->booking_id, $prescription->patient_id);
      $oct_hfa_status = $this->oct_hfa->get_by_booking_id($prescription->booking_id, $prescription->patient_id);
      $ortho_ptics_status = $this->ortho_ptics->get_ortho_by_booking_id($prescription->booking_id, $prescription->patient_id);
      $doct_patient_status = $this->doctore_patient->get_doct_patient_booking_id($prescription->booking_id, $prescription->patient_id);
      // echo $oct_hfa_status;die;
      //   echo "<pre>";
      // print_r($doct_patient_status);
      // die;

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
      $prosthetic = ($prosthetic_status == 1)
        ? '<font style="background-color: #228B30;color:white">Prosthetic</font>'
        : '';
      $oct_hfa = ($oct_hfa_status == 1)
        ? '<font style="background-color: #228B30;color:white">OCT HFA</font>'
        : '';
      $ortho_ptics = ($ortho_ptics_status == 1)
        ? '<font style="background-color: #228B30;color:white">Ortho/Paedic</font>'
        : '';
      $doct_patient = ($doct_patient_status == 1)
        ? '<font style="background-color: #228B30;color:white">Doctore</font>'
        : '';
      $refraction_below8 = ($prescription->refraction_below8 == 1)
        ? '<font style="background-color: #228B30;color:white">Refraction Below 8 Year</font>'
        : '';
      $low_vision = ($low_vision_status == 1)
        ? '<font style="background-color: #228B30;color:white">Low vision</font>'
        : '';
      $dilate = ($dilate_exists == 1)
        ? '<font style="background-color: #228B30;color:white">Dilate</font>'
        : '';
      $refraction = ($refraction_exists == 1)
        ? '<font style="background-color: #228B30;color:white">Refraction above 8 years</font>'
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
      // Assuming pat_status contains comma-separated values like 'Contact Lens, Low vision'
      $statuses = explode(',', $prescription->pat_status);

      // Initialize an empty array to hold the formatted statuses
      $formatted_statuses = [];

      // Remove any empty values from the statuses array
      $statuses = array_filter(array_map('trim', $statuses));

      // Check if there are any valid statuses
      if (!empty($statuses)) {
        // Loop through each status and format it with your desired style
        foreach ($statuses as $status) {
          // Apply the style to each non-empty status
          $formatted_statuses[] = '<font style="background-color: #228B30;color:white;">' . $status . '</font>';
        }

        // Join the formatted statuses with ' / ' as the separator
        $row[] = implode(' / ', $formatted_statuses);
      } else {
        // If no valid statuses are found, display a default message (history)
        $row[] = '<font style="background-color: #228B30;color:white;">History</font>';
      }




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
      $prosthetic = "";
      $oct_hfa = "";
      $btn_ortho_ptics = "";

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
      // print_r($prescription);
      // die;
      if ($contact_lens_status == '1') {
        $btn_contact_lens = '<a class="btn-custom disabled" href="javascript:void(0);" title="Contact Lens" style="pointer-events: none; opacity: 0.6;" data-url="512">  Contact Lens</a>';
      } else {
        // $btn_contact_lens = '<a class="btn-custom" href="' . base_url("eye/add_eye_prescription/test/" . $prescription->booking_id . '/' . $prescription->id) . '?flag=' . $flag . '" title=" Contact Lens"> Contact Lens</a>';
        // $btn_contact_lens = '<a class="btn-custom" href="' . base_url("contact_lens/add/" . $prescription->booking_id . '/' . $prescription->patient_id) . '" title="Contact Lens" data-url="512">Contact Lens</a>';
        if ($prescription->cont_lens_status == 1) {
          // Render disabled button for already booked patients
          $btn_contact_lens = '<div class="action-buttons">
                  <button class="btn-custom book-now-btn book-now-btn-contact-lens" disabled>
                      <i class="fa fa-spinner fa-spin"></i> In Progress
                  </button>
                  <a href="javascript:void(0);" title="Refresh" class="btn btn-secondary refresh-btn-contact-lens" data-patient_id="' . $prescription->patient_id . '" >
                      <i class="fa fa-refresh"></i>
                  </a>
                  </div>';
        } else {
          $btn_contact_lens = '<button class="btn-custom book-now-btn-url-contact-lens" title="Book Now" 
                  data-id="' . $prescription->patient_id . '" 
                  data-url="' . base_url("contact_lens/add/" . $prescription->booking_id . '/' . $prescription->patient_id) . '">Contact Lens</button>';
        }
      }
      if ($low_vision_status == '1') {
        $btn_low_vision = '<a class="btn-custom disabled" href="javascript:void(0);" title="Contact Lens" style="pointer-events: none; opacity: 0.6;" data-url="512"> Low Vision</a>';
      } else {
        // $btn_contact_lens = '<a class="btn-custom" href="' . base_url("eye/add_eye_prescription/test/" . $prescription->booking_id . '/' . $prescription->id) . '?flag=' . $flag . '" title=" Contact Lens"> Contact Lens</a>';
        // $btn_low_vision = '<a class="btn-custom" href="' . base_url("low_vision/add/" . $prescription->booking_id . '/' . $prescription->patient_id) . '" title="Contact Lens" data-url="512">Low vision</a>';
        if ($prescription->low_vision_status == 1) {
          // Render disabled button for already booked patients
          $btn_low_vision = '<div class="action-buttons">
                  <button class="btn-custom book-now-btn book-now-btn-low-vision" disabled>
                      <i class="fa fa-spinner fa-spin"></i> In Progress
                  </button>
                  <a href="javascript:void(0);" title="Refresh" class="btn btn-secondary refresh-btn-low-vision" data-patient_id="' . $prescription->patient_id . '" >
                      <i class="fa fa-refresh"></i>
                  </a>
                  </div>';
        } else {
          $btn_low_vision = '<button class="btn-custom book-now-btn-url-low-vision" title="Low vision" 
                  data-id="' . $prescription->patient_id . '" 
                  data-url="' . base_url("low_vision/add/" . $prescription->booking_id . '/' . $prescription->patient_id) . '">Low vision</button>';
        }
      }
      if ($prescription->drawing_flag == 0) {
        $flag = 'hess_chart';
        $type = 'help_desk';
        // $btn_hess_chart = '<a class="btn-custom" href="' . base_url("eye/add_eye_prescription/test/" . $prescription->booking_id . '/' . $prescription->id) . '?flag=' . $flag . "&type=" . $type . '" title="Hess Chart">Hess Chart</a>';
        if ($prescription->hess_chart_status == 1) {
          // Render disabled button for already booked patients
          $btn_hess_chart = '<div class="action-buttons">
                  <button class="btn-custom book-now-btn book-now-btn-hess-chart" disabled>
                      <i class="fa fa-spinner fa-spin"></i> In Progress
                  </button>
                  <a href="javascript:void(0);" title="Refresh" class="btn btn-secondary refresh-btn-hess-chart" data-patient_id="' . $prescription->patient_id . '" >
                      <i class="fa fa-refresh"></i>
                  </a>
                  </div>';
        } else {
          $btn_hess_chart = '<button class="btn-custom book-now-btn-url-hess-chart" title="Hess Chart" 
                  data-id="' . $prescription->patient_id . '" 
                  data-url="' . base_url("eye/add_eye_prescription/test/" . $prescription->booking_id . '/' . $prescription->id) . '?flag=' . $flag . "&type=" . $type . '">Hess Chart</button>';
        }
      } else {
        $btn_hess_chart = '<a class="btn-custom disabled" href="javascript:void(0);" title="Hess Chart" style="pointer-events: none; opacity: 0.6;" data-url="512">  Hess Chart</a>';
      }
      // echo "<pre>";
      // print_r($prescription->refraction_below8);
      // die('sagar');
      // if ($prescription->refraction_below8 == 0) {
      if ($prescription->refraction_below8 == 0) {
        $flag = 'refraction_below_8_years';
        $type = 'help_desk';
        // $btn_refraction_below8 = '<a class="btn-custom" href="' . base_url("eye/add_eye_prescription/test/" . $prescription->booking_id . '/' . $prescription->id) . '?flag=' . $flag . "&type=" . $type . '" title="Refraction below 8 Years">Refraction Below 8 Years</a>';
        if ($prescription->ref_below_status == 1) {
          // Render disabled button for already booked patients
          $btn_refraction_below8 = '<div class="action-buttons">
                  <button class="btn-custom book-now-btn book-now-btn-refraction-below" disabled>
                      <i class="fa fa-spinner fa-spin"></i> In Progress
                  </button>
                  <a href="javascript:void(0);" title="Refresh" class="btn btn-secondary refresh-btn-refraction-below" data-patient_id="' . $prescription->patient_id . '" >
                      <i class="fa fa-refresh"></i>
                  </a>
                  </div>';
        } else {
          $btn_refraction_below8 = '<button class="btn-custom book-now-btn-url-refraction-below" title="Refraction below 8 Years" 
                  data-id="' . $prescription->patient_id . '" 
                  data-url="' . base_url("eye/add_eye_prescription/test/" . $prescription->booking_id . '/' . $prescription->id) . '?flag=' . $flag . "&type=" . $type . '">Refraction below 8 Years</button>';
        }
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
        // echo "<pre>";
        // print_r($refraction_exists == 1);
        // die('sagar');
        if ($refraction_exists == 1) {
          // if ($prescription->ref_abouve_status == 1) {

          $refraction = '<a class="btn-custom disabled " style="pointer-events: none; opacity: 0.6;" href="' . base_url("refraction/add/" . $prescription->patient_id . '/' . $prescription->id) . '" title="Refraction" data-url="512">Refraction above 8 years</a>';
        } else {

          // $refraction = '<a class="btn-custom" href="' . base_url("refraction/add/" . $prescription->patient_id . '/' . $prescription->id) . '" title="Refraction" data-url="512">Refraction above 8 years</a>';
          if ($prescription->ref_abouve_status == 1) {
            // Render disabled button for already booked patients
            $refraction = '<div class="action-buttons">
                    <button class="btn-custom book-now-btn book-now-btn" disabled>
                        <i class="fa fa-spinner fa-spin"></i> In Progress
                    </button>
                    <a href="javascript:void(0);" title="Refresh" class="btn btn-secondary refresh-btn" data-patient_id="' . $prescription->patient_id . '" >
                        <i class="fa fa-refresh"></i>
                    </a>
                    </div>';
            // $row[] = '<a title="Print"><i class="fa fa-refresh"></i></a>';
          } else {
            // Render active button for patients not yet booked
            $refraction = '<button class="btn-custom book-now-btn-url" title="Book Now" 
                    data-id="' . $prescription->patient_id . '" 
                    data-url="' . base_url("refraction/add/" . $prescription->patient_id . '/' . $prescription->id) . '">Refraction above 8 years</button>';
          }

        }
      }
      if (in_array('2413', $users_data['permission']['action'])) {
        if ($dilate_exists == 1) {
          // Enable the "Dilate" button if dilate exists
          $dilate = '<a class="btn-custom " disabled href="javascript:void(0)" title="Dilate" style="pointer-events: none; opacity: 0.6;">Dilate</a>';
        } else {
          // Disable the "Dilate" button and change its style to look inactive
          // $dilate = '<a class="btn-custom" href="' . base_url("dilate/add/" . $prescription->booking_id . '/' . $prescription->patient_id) . '" title="Dilate" data-url="512">Dilate</a>';
          if ($prescription->help_dilate_status == 1) {
            // Render disabled button for already booked patients
            $dilate = '<div class="action-buttons">
                    <button class="btn-custom book-now-btn book-now-btn-dilate" disabled>
                        <i class="fa fa-spinner fa-spin"></i> In Progress
                    </button>
                    <a href="javascript:void(0);" title="Refresh" class="btn btn-secondary refresh-btn-dilate" data-patient_id="' . $prescription->patient_id . '" >
                        <i class="fa fa-refresh"></i>
                    </a>
                    </div>';
            // $row[] = '<a title="Print"><i class="fa fa-refresh"></i></a>';
          } else {
            // Render active button for patients not yet booked
            $dilate = '<button class="btn-custom book-now-btn-url-dilate" title="Dilate" 
                    data-id="' . $prescription->patient_id . '" 
                    data-url="' . base_url("dilate/add/" . $prescription->booking_id . '/' . $prescription->patient_id) . '">Dilate</button>';
          }
        }

      }
      if ($prosthetic_status == '1') {
        $btn_prosthetic = '<a class="btn-custom disabled" href="javascript:void(0);" title="Contact Lens" style="pointer-events: none; opacity: 0.6;" data-url="512"> Prosthetic</a>';
      } else {
        // $btn_contact_lens = '<a class="btn-custom" href="' . base_url("eye/add_eye_prescription/test/" . $prescription->booking_id . '/' . $prescription->id) . '?flag=' . $flag . '" title=" Contact Lens"> Contact Lens</a>';
        $btn_prosthetic = '<a class="btn-custom" href="' . base_url("prosthetic/add/" . $prescription->booking_id . '/' . $prescription->patient_id) . '" title="Contact Lens" data-url="512">Prosthetic</a>';
        if ($prescription->prosthetic_status == 1) {
          // Render disabled button for already booked patients
          $btn_prosthetic = '<div class="action-buttons">
                  <button class="btn-custom book-now-btn book-now-btn-prosthetic" disabled>
                      <i class="fa fa-spinner fa-spin"></i> In Progress
                  </button>
                  <a href="javascript:void(0);" title="Refresh" class="btn btn-secondary refresh-btn-prosthetic" data-patient_id="' . $prescription->patient_id . '" >
                      <i class="fa fa-refresh"></i>
                  </a>
                  </div>';
          // $row[] = '<a title="Print"><i class="fa fa-refresh"></i></a>';
        } else {
          // Render active button for patients not yet booked
          $btn_prosthetic = '<button class="btn-custom book-now-btn-url-prosthetic" title="Prosthetic" 
                  data-id="' . $prescription->patient_id . '" 
                  data-url="' . base_url("prosthetic/add/" . $prescription->booking_id . '/' . $prescription->patient_id) . '">Prosthetic</button>';
        }
      }
      if ($oct_hfa_status == '1') {
        $btn_oct_hfa = '<a class="btn-custom disabled" href="javascript:void(0);" title="OCT HFA" style="pointer-events: none; opacity: 0.6;" data-url="512"> OCT HFA</a>';
      } else {
        // $btn_contact_lens = '<a class="btn-custom" href="' . base_url("eye/add_eye_prescription/test/" . $prescription->booking_id . '/' . $prescription->id) . '?flag=' . $flag . '" title=" Contact Lens"> Contact Lens</a>';
        // $btn_oct_hfa = '<a class="btn-custom" href="' . base_url("oct_hfa/add/" . $prescription->booking_id . '/' . $prescription->patient_id) . '" title="OCT HFA" data-url="512">OCT HFA</a>';
        if ($prescription->octhfa_status == 1) {
          // Render disabled button for already booked patients
          $btn_oct_hfa = '<div class="action-buttons">
                  <button class="btn-custom book-now-btn book-now-btn-octhfa" disabled>
                      <i class="fa fa-spinner fa-spin"></i> In Progress
                  </button>
                  <a href="javascript:void(0);" title="Refresh" class="btn btn-secondary refresh-btn-octhfa" data-patient_id="' . $prescription->patient_id . '" >
                      <i class="fa fa-refresh"></i>
                  </a>
                  </div>';
        } else {
          // Render active button for patients not yet booked
          $btn_oct_hfa = '<button class="btn-custom book-now-btn-url-octhfa" title="octhfa" 
                  data-id="' . $prescription->patient_id . '" 
                  data-url="' . base_url("oct_hfa/add/" . $prescription->booking_id . '/' . $prescription->patient_id) . '">OCT HFA</button>';
        }
      }
      if ($ortho_ptics_status == '1') {
        $btn_ortho_ptics = '<a class="btn-custom disabled" href="javascript:void(0);" title="Ortho Paedic" style="pointer-events: none; opacity: 0.6;" data-url="512"> Ortho Paedic</a>';
      } else {
        // $btn_contact_lens = '<a class="btn-custom" href="' . base_url("eye/add_eye_prescription/test/" . $prescription->booking_id . '/' . $prescription->id) . '?flag=' . $flag . '" title=" Contact Lens"> Contact Lens</a>';
        // $btn_ortho_ptics = '<a class="btn-custom" href="' . base_url("ortho_ptics/add/" . $prescription->booking_id . '/' . $prescription->patient_id) . '" title="Ortho Paedic" data-url="512">Ortho Paedic</a>';
        if ($prescription->ortho_ptics_status == 1) {
          // Render disabled button for already booked patients
          $btn_ortho_ptics = '<div class="action-buttons">
                  <button class="btn-custom book-now-btn book-now-btn-ortho-ptics" disabled>
                      <i class="fa fa-spinner fa-spin"></i> In Progress
                  </button>
                  <a href="javascript:void(0);" title="Refresh" class="btn btn-secondary refresh-btn-ortho-ptics" data-patient_id="' . $prescription->patient_id . '" >
                      <i class="fa fa-refresh"></i>
                  </a>
                  </div>';
        } else {
          // Render active button for patients not yet booked
          $btn_ortho_ptics = '<button class="btn-custom book-now-btn-url-ortho-ptics" title="octhfa" 
                  data-id="' . $prescription->patient_id . '" 
                  data-url="' . base_url("ortho_ptics/add/" . $prescription->booking_id . '/' . $prescription->patient_id) . '">Ortho Paedic</button>';
        }

      }
      if ($doct_patient_status == '1') {
        $btn_doctor = '<a class="btn-custom disabled" href="javascript:void(0);" title="Ortho Paedic" style="pointer-events: none; opacity: 0.6;" data-url="512"> Doctor</a>';
      } else {
        // $btn_contact_lens = '<a class="btn-custom" href="' . base_url("eye/add_eye_prescription/test/" . $prescription->booking_id . '/' . $prescription->id) . '?flag=' . $flag . '" title=" Contact Lens"> Contact Lens</a>';
        // $btn_doctor = '<button type="button" class="btn-custom open-popup" 
        //           id="open-popup" 
        //           data-booking-id="' . $prescription->booking_id . '" 
        //           data-patient-id="' . $prescription->patient_id . '" 
        //           data-referred-by="' . $prescription->attended_doctor . '" 
        //           data-url="' . $prescription->url . '" 
        //           title="Doctore">Doctore</button>';

        if ($prescription->doctor_status == 1) {
          // Render disabled button for already booked patients
          $btn_doctor = '<div class="action-buttons">
                            <button class="btn-custom book-now-btn book-now-btn-ortho-ptics" disabled>
                                <i class="fa fa-spinner fa-spin"></i> In Progress
                            </button>
                            <a href="javascript:void(0);" title="Refresh" class="btn btn-secondary refresh-btn-doctore" data-patient_id="' . $prescription->patient_id . '" >
                                <i class="fa fa-refresh"></i>
                            </a>
                            </div>';
        } else {
          // Render active button for patients not yet booked
          // $btn_doctor = '<button class="btn-custom book-now-btn-url-ortho-ptics" title="octhfa" 
          //                   data-id="' . $prescription->patient_id . '" 
          //                   data-url="' . base_url("ortho_ptics/add/" . $prescription->booking_id . '/' . $prescription->patient_id) . '">Doctore</button>';
          $btn_doctor = '<button type="button" class="btn-custom open-popup" 
                  id="open-popup" 
                  data-booking-id="' . $prescription->booking_id . '" 
                  data-patient-id="' . $prescription->patient_id . '" 
                  data-referred-by="' . $prescription->attended_doctor . '" 
                  data-url="' . $prescription->url . '" 
                  title="">Doctor</button>';
        }
      }
      // $btn_doctor = 

      // if (in_array('2413', $users_data['permission']['action'])) {
      //   $print_url = "'" . base_url('eye/add_eye_prescription/view_prescription/' . $prescription->id . '/' . $prescription->booking_id) . "'";
      //   if ($patient_status == 1) {
      //     $send_to_vission = '<a class="btn-custom disabled" href="javascript:void(0);" title="Send To Vision" style="pointer-events: none; opacity: 0.6;" data-url="512"> Vision</a>';
      //   } else {
      //     // $send_to_vission = '<a class="btn-custom" href="' . base_url("vision/add/" . $prescription->booking_id . '/' . $prescription->patient_id) . '" title="Vision" data-url="512">Vision</a>';
      //     if ($prescription->vision_status == 1) {
      //       // Render disabled button for already booked patients
      //       $send_to_vission = '<div class="action-buttons">
      //               <button class="btn-custom book-now-btn book-now-btn" disabled>
      //                   <i class="fa fa-spinner fa-spin"></i> In Progress
      //               </button>
      //               <a href="javascript:void(0);" title="Refresh" class="btn btn-secondary refresh-btn-vision" data-patient_id="' . $prescription->patient_code . '" >
      //                   <i class="fa fa-refresh"></i>
      //               </a>
      //               </div>';
      //     } else {
      //       $send_to_vission = '<button class="btn-custom book-now-btn-url-vision" title="Book Now" 
      //               data-id="' . $prescription->patient_code . '" 
      //               data-url="' . base_url("vision/add/" . $prescription->booking_id . '/' . $prescription->patient_id) . '">Vision</button>';
      //     }
      //   }
      // }

      // $print_chasma_url = "'" . base_url('eye/add_eye_prescription/print_chasma_details/' . $prescription->id . '/' . $prescription->booking_id) . "'";
      // $btn_print_chasma_pre = ' <a class="btn-custom" onClick="return print_window_page(' . $print_chasma_url . ')" href="javascript:void(0)" title="Print Chasma Detail"  data-url="512"><i class="fa fa-print"></i> Print Chasma Detail</a>';
      if (empty($prescription->send_to_status)) {
        $send_to = '<button type="button" class="btn-custom open-popup-send-to" 
                    id="open-popup" 
                    data-booking-id="' . $prescription->booking_id . '" 
                    data-patient-id="' . $prescription->patient_id . '" 
                    data-referred-by="' . $prescription->attended_doctor . '" 
                    data-mod-type="help_desk" 
                    data-url="' . $prescription->url . '" 
                    title="">Send To</button>';
      } else {
        $send_to = '<a class="btn-custom disabled" href="javascript:void(0);" title="Send To Vision" style="pointer-events: none; opacity: 0.6;" data-url="512"> Send To</a>';
      }
      // $send_to = '<button type="button" class="btn-custom open-popup-send-to" 
      //               id="open-popup" 
      //               data-booking-id="' . $prescription->booking_id . '" 
      //               data-patient-id="' . $prescription->patient_id . '" 
      //               data-referred-by="' . $prescription->attended_doctor . '" 
      //               data-url="' . $prescription->url . '" 
      //               title="">Send To</button>';

      // . $btn_print_chasma_pre
      // $row[] = $btn_print_pre . $btn_upload_pre . $btn_view_upload_pre . $btn_edit . $btn_view . $btn_delete . $refraction . $send_to_vission . $btn_contact_lens . $btn_low_vision .
      //   $btn_hess_chart . $btn_refraction_below8 . $dilate . $btn_prosthetic . $btn_oct_hfa . $btn_ortho_ptics . $btn_doctor;
      $row[] = $btn_print_pre . $btn_edit . $send_to;
      // . $btn_doctor
      $row[] = $prescription->emergency_status; // Add emergency_status to the row
      // echo "<pre>";print_r($row);die;
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

  public function add($booking_id = null, $patient_id = null, $mod_type = null, $referred_by = null)
  {
    // $post = $this->input->post();
    // echo "<pre>";
    // print_r($booking_id);
    // print_r($patient_id);
    // print_r($referred_by);
    // print_r($mod_type);
    // die('sagar');
    // Load required models and libraries
    $user_data = $this->session->userdata('auth_users');
    $this->load->library('form_validation');
    $this->load->model('doctore_patient/doctore_patient_model'); // Ensure this model is loaded
    $data['page_title'] = 'Send To';
    $data['booking_id'] = isset($booking_id) ? $booking_id : '';
    $data['patient_id'] = isset($patient_id) ? $patient_id : '';
    $data['booking_data'] = $this->doctore_patient->get_booking_patient_details($data['patient_id']);

    $get_by_send_to_status = $this->add_prescript->get_by_send_to_status($data['booking_id'], $data['patient_id']);
    $result = [];
    foreach ($get_by_send_to_status as $row) {
      // Split `send_to_status` by commas and trim whitespace
      $statuses = array_map('trim', explode(',', $row['send_to_status']));

      // Filter out empty values
      $statuses = array_filter($statuses);

      // Add to the result array
      $result[] = $statuses;
    }
    $data['send_to_status'] = $result;
    // Initialize form data
    $data['form_data'] = array(
      "booking_id" => $booking_id,
      "patient_id" => $patient_id,
      "mod_type" => $mod_type,
      "send_to_type" => '',
      "referred_by" => $referred_by,
    );
    // echo "<pre>";
    // print_r($data['form_data']);
    // die('sagar');
    // Option for drop-down
    $data['dropdown_options'] = array(
      'Refraction above 8 years',
      'Vision',
      'Contact Lens',
      'Low Vision',
      'Hess Chart',
      'Refraction below 8 years',
      'Dilate',
      'Prosthetic',
      'OCT HFA',
      'Ortho Paedic',
      'Sent To Token'
    );


    $post = $this->input->post();
    // Check if the form is submitted
    if (isset($post) && !empty($post)) {
      // echo "<pre>";
      // print_r($post);
      // die('sagar');
      // Validate the form
      $valid_response = $this->_validate();

      // Check if validation passed
      if ($valid_response === true) {
        $this->add_prescript->send_to_status_update($post['booking_id'], $post['patient_id'], $post['send_to_type']);
        // If validation passes, save the record
        $send_to_type_mapping = [
          'Refraction above 8 years' => ['model' => 'refraction', 'url' => 'refraction'],
          'Contact Lens' => ['model' => 'contact_lens', 'url' => 'contact_lens'],
          'Vision' => ['model' => 'vision/vision_model', 'url' => 'vision'],
          'Low Vision' => ['model' => 'low_vision', 'url' => 'low_vision'],
          'Dilate' => ['model' => 'dilate', 'url' => 'dilate'],
          'Prosthetic' => ['model' => 'prosthetic', 'url' => 'prosthetic'],
          'OCT HFA' => ['model' => 'oct_hfa', 'url' => 'oct_hfa'],
          'Ortho Paedic' => ['model' => 'ortho_ptics', 'url' => 'ortho_ptics'],
          'Hess Chart' => ['model' => 'add_prescript', 'url' => 'hess_chart'],
          'Refraction below 8 years' => ['model' => 'add_prescript', 'url' => 'refraction_below8'],
          'Sent To Token' => ['model' => 'send_to_token', 'url' => 'send_to_token'],
      ];
      
      if (isset($send_to_type_mapping[$post['send_to_type']])) {
          $type = $send_to_type_mapping[$post['send_to_type']];
          
          // Load model if necessary
          if (strpos($type['model'], '/') !== false) {
              $this->load->model($type['model']);
          }
          
          $model = strpos($type['model'], '/') !== false ? basename($type['model']) : $type['model'];
      
          $data_to_save = [
              'branch_id' => $user_data['parent_id'] ?? null,
              'booking_id' => $post['booking_id'] ?? '',
              'patient_id' => $post['patient_id'] ?? '',
              'status' => 0,
              'is_deleted' => 0,
              'created_date' => date('Y-m-d H:i:s'),
              'created_by' => $user_data['id'] ?? null,
              'ip_address' => $this->input->ip_address(),
          ];
      
          // Additional fields for specific types
          if ($post['send_to_type'] === 'Refraction above 8 years') {
              $data_to_save = array_merge($data_to_save, [
                  'booking_code' => '',
                  'pres_id' => '',
                  'auto_refraction' => '',
                  'lens' => '',
                  'comment' => '',
                  'optometrist_signature' => '',
                  'doctor_signature' => '',
              ]);
          } 
          if ($post['send_to_type'] === 'OCT HFA') {
              // $data_to_save['chief_complaints'] = '';
              $this->{$model}->save($data_to_save,$chief_complaints = '');
          }elseif($post['send_to_type'] === 'Hess Chart' || $post['send_to_type'] === 'Refraction below 8 years'){
            $prescrption_id = $this->add_prescript->get_prescription_std_eye_by_id($post['booking_id'], $post['patient_id']);
            if(!empty($prescrption_id)){
              $post['prescrption_id'] = $prescrption_id['id'];
            }else{
              $post['prescrption_id'] = '';
            }
            // echo "<pre>";
            // print_r($model);
            // die('sagar');
            $this->{$model}->save($post);
          }
          else{

            // Save data using model
            $this->{$model}->save($data_to_save);
          }
      
      
          // Set success message and return response
          $this->session->set_flashdata('success', 'Send to successfully.');
          $url = base_url() . $type['url'];
          echo json_encode(['success' => true, 'url' => $url, 'message' => ucfirst($post['send_to_type']) . ' stored successfully.']);
          return;
      }
      
      echo json_encode(['success' => false, 'message' => 'Invalid send_to_type provided.']);
      return;

        // $this->doctore_patient->save($this->input->post()); // Save the validated data
      } else {
        // Handle validation errors
        $data['form_data'] = $valid_response['form_data']; // Retain form data for re-display
        $data['form_error'] = validation_errors(); // Get validation errors
      }
    }
    $this->load->view('help_desk/send_to_add', $data);
  }

  private function _validate()
  {
    $this->load->library('form_validation');
    $post = $this->input->post();

    // Assuming this function returns the necessary fields
    $field_list = mandatory_section_field_list(2);
    $users_data = $this->session->userdata('auth_users');
    $data['form_data'] = [];
    $data['photo_error'] = [];

    $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

    // Validation rules for required fields
    $this->form_validation->set_rules('send_to_type', 'Send to Name', 'trim|required');


    // Run validation
    if ($this->form_validation->run() == FALSE) {
      // Prepare form data to retain user inputs
      $data['form_data'] = array(
        "data_id" => isset($post['data_id']) ? $post['data_id'] : '',
        "send_to_type" => isset($post['send_to_type']) ? $post['send_to_type'] : '',

      );

      return $data; // Return the form data with errors
    }
    return true; // Return true if validation passes
  }

}
?>