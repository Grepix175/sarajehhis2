<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Oct_hfa extends CI_Controller
{
    protected $fields;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('oct_hfa/Oct_hfa_model', 'oct_hfa');
        $this->load->model('doctors/Doctors_model', 'doctor');
        $this->load->library('form_validation');
        // adding field array 
        $this->fields = array(
            'indication',
            'anterior_segment_evaluation',
            'spectacle_power_od',
            'spectacle_power_os',
            'keratometry_od',
            'keratometry_os',
            'hvid_od',
            'hvid_os',
            'contact_lens_trial_table',
            'trial_given',
            'final_order_table',
            'instruction_given_lens_dispensed_on',
            'consent_form'
        );
        error_reporting(0);
    }

    public function index()
    {
        
        $data['page_title'] = 'OCT HFA Records';
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
        
        $this->load->view('oct_hfa/list', $data);
    }

    public function ajax_list()
    {
        $list = $this->oct_hfa->get_datatables();

        $data = array();
        // $plist = $this->oct_hfa->get_patient_name_by_booking_id($list->booking_id);

        $no = $_POST['start'];
        
        // echo "<pre>";print_r($list);die('okok');
        foreach ($list as $oct_hfa) {
            $no++;

            $row = array();

            $age_y = $oct_hfa->age_y;
            $age_m = $oct_hfa->age_m;
            $age_d = $oct_hfa->age_d;
      
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

            // Add a checkbox for selecting the record
            $row[] = '<input type="checkbox" name="refraction_ids[]" value="' . $oct_hfa->refraction_id . '">';

            $row[] = $oct_hfa->token;
            $row[] = $oct_hfa->booking_code;
            $row[] = $oct_hfa->patient_code;
            $row[] = $oct_hfa->patient_name;
            // $row[] = $oct_hfa->patient_category_name;
            $row[] = $oct_hfa->mobile_no;
            $row[] = $age;
            $row[] = $oct_hfa->oct_status == 0 ? '<font color="green">Pending</font>' : '<font color="red">Completed</font>';
            // $row[] = "Dr. " . $oct_hfa->doctor_name;
            // $row[] = $oct_hfa->booking_id;
            // $row[] = $oct_hfa->lens;
            // $row[] = $oct_hfa->comment;

            // Check status and set active or not active
            $statuses = explode(',', $oct_hfa->pat_status);

            // Trim any whitespace from the statuses and get the last one
            $last_status = trim(end($statuses));

            // Display the last status with the desired styling
            $row[] = '<font style="background-color: #228B30;color:white">'.$last_status.'</font>';
            $row[] = date('d-m-Y h:i A', strtotime($oct_hfa->created));
            $send_to = '';
            if ($oct_hfa->oct_status == 0) {
                $send_to = '<button type="button" class="btn-custom open-popup-send-to" 
                            id="open-popup" 
                            data-booking-id="' . $oct_hfa->booking_id . '" 
                            data-patient-id="' . $oct_hfa->patient_id . '" 
                            data-referred-by="' . $oct_hfa->attended_doctor . '" 
                            data-mod-type="oct_hfa" 
                            data-url="' . $oct_hfa->url . '" 
                            title="">Send To</button>';
              }else{
                $send_to = '<a class="btn-custom disabled" href="javascript:void(0);" title="Send To Vision" style="pointer-events: none; opacity: 0.6;" data-url="512"> Send To</a>';
              }

            // Add action buttons
            $row[] = '<a onClick="return edit_refraction(' . $oct_hfa->refraction_id . ');" class="btn-custom" href="javascript:void(0)" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                    <a href="javascript:void(0)" class="btn-custom" onClick="return print_window_page(\'' . base_url("oct_hfa/print_oct_hfa/" . $oct_hfa->booking_id."/".$oct_hfa->patient_id) . '\');">
                        <i class="fa fa-print"></i> Print
                    </a>' . $send_to;
            $row[] = $oct_hfa->emergency_status;


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->oct_hfa->count_all(),
            "recordsFiltered" => $this->oct_hfa->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);
    }



    public function add($booking_id = null, $id = null)
    {
        // echo "<pre>";
        // print_r($booking_id);
        // print_r($id);
        // die('sagar');
        // echo "plp";die;
        // Load required models and libraries
        $this->load->library('form_validation');
        // $this->load->model('oct_hfa/refraction_model'); // Ensure this model is loaded
        // $data['side_effects'] = $this->oct_hfa->get_all_side_effects(); // Fetch side effects
        $data['page_title'] = 'Add Oct/hfa Record';
        $pres_id = 28;

        $result = $this->oct_hfa->get_chief_complaints_by_patient_id($booking_id); // Adjust this method according to your model
        $chief_complaints = json_decode($result['chief_complaints']);
        $data['chief_complaints'] = (array) $chief_complaints;
        // echo "<pre>";print_r($data['chief_complaints']);die;
        
        $plist = $this->oct_hfa->get_patient_name_by_booking_id($booking_id);
        // echo "<pre>";print_r($plist);die('ok');
        $data['booking_id'] = isset($booking_id) ? $booking_id : '';
        $result_refraction = $this->oct_hfa->get_prescription_refraction_new_by_id($booking_id, $id);
        // echo "<pre>";print_r($booking_id);die;
        $data['booking_data'] = $this->oct_hfa->get_bookings_by_id($booking_id);
        // echo "<pre>";print_r($data['booking_data']);die('kkkk');
        $data['doctor'] = $this->doctor->doctors_list();

        $oct_hfa_auto_refraction = isset($result_refraction['auto_refraction'])?json_decode($result_refraction['auto_refraction']):'';
        $data['refrtsn_auto_ref'] = (array) $oct_hfa_auto_refraction;
       
        // // Initialize form data
        $data['form_data'] = array(
            // 'booking_id' => isset($data['booking_data']['booking_id']) ? $data['booking_data']['booking_id'] : '', // Booking ID
            'booking_id' => isset($data['booking_data']['opd_id']) ? $data['booking_data']['opd_id'] : '', // Booking ID
            
            'branch_id' => isset($data['booking_data']['branch_id']) ? $data['booking_data']['branch_id'] : '', // To be filled from form
            'booking_code' => isset($data['booking_data']['booking_code']) ? $data['booking_data']['booking_code'] : '', // To be filled from form
            'pres_id' => isset($id) ? $id : '', // To be filled from form
            'patient_id' => isset($data['booking_data']['patient_id']) ? $data['booking_data']['patient_id'] : '', // To be filled from form
            'optometrist_signature' => '', // To be filled from form
            'doctor_signature' => '', // To be filled from form
            'status' => 0, // Default value
            'is_deleted' => 0, // Default value
            'created_by' => $this->session->userdata('user_id'), // User ID from session
            'created_date' => date('Y-m-d H:i:s'), // Current timestamp
            'ip_address' => $this->input->ip_address(), // IP address
            // 'booking_id' => isset($data['booking_data']['booking_id']) ? $data['booking_data']['booking_id'] : '', // Booking ID
           
        );       
        // $chief_complaints = array(
        //     'indication' => isset($data['indication']) ? $data['indication'] : '',
        //     'anterior_segment_evaluation' => isset($data['anterior_segment_evaluation']) ? $data['anterior_segment_evaluation'] : '',
        //     'spectacle_power_od' => isset($data['spectacle_power_od']) ? $data['spectacle_power_od'] : '',
        //     'spectacle_power_os' => isset($data['spectacle_power_os']) ? $data['spectacle_power_os'] : '',
        //     'keratometry_od' => isset($data['keratometry_od']) ? $data['keratometry_od'] : '',
        //     'keratometry_os' => isset($data['keratometry_os']) ? $data['keratometry_os'] : '',
        //     'hvid_od' => isset($data['hvid_od']) ? $data['hvid_od'] : '',
        //     'hvid_os' => isset($data['hvid_os']) ? $data['hvid_os'] : '',
        //     'contact_lens_trial_table' => isset($data['contact_lens_trial_table']) ? json_encode($data['contact_lens_trial_table']) : '',
        //     'trial_given' => isset($data['trial_given']) ? $data['trial_given'] : '',
        //     'final_order_table' => isset($data['final_order_table']) ? json_encode($data['final_order_table']) : '',            
        //     'instruction_given_lens_dispensed_on' => isset($data['instruction_given_lens_dispensed_on']) ? $data['instruction_given_lens_dispensed_on'] : '',
        //     'consent_form' => isset($_FILES['consent_form']) ? $_FILES['consent_form'] : ''
        // );
        
        $data['form_data'] = array_merge($data['form_data']);
        // echo "<pre>";print_r($data['form_data']);die;

        $post = $this->input->post();
        // if(isset($post) && !empty($post)){
        //     print_r($post);
        //     die;
        // }
       
        
        // // Check if the form is submitted
        // echo "<pre>";print_r($post);die('ss');
        if (isset($post) && !empty($post)) {
            // echo "<pre>";print_r($post);die('dfk');
            $patient_exists = $this->oct_hfa->patient_exists($post['patient_id']);
            $result_exists = $this->oct_hfa->get_by_id($post['id']);
            //   echo "<pre>";
            // print_r( $result_exists['status']);
            // die;
            if(empty($post['id'])){
                if ($patient_exists) {
                    // Redirect to OPD list page with a warning message
                    $this->session->set_flashdata('warning', 'Patient ' . $patient_exists['patient_name'] . ' is already in OCT HFA.');
                    echo json_encode(['faield' => true, 'message' => 'Patient ' . $patient_exists['patient_name'] . ' is already in OCT HFA.']);
                    // redirect('help_desk'); // Change 'opd_list' to your OPD list page route
                    return;
                }

            }


    
            // Prepare the data for saving
            $id = $this->input->post('id');
            $branch_id = $this->input->post('branch_id');
            $booking_code = $this->input->post('booking_code');
            $pres_id = $this->input->post('pres_id');
            $patient_id = $this->input->post('patient_id');
            // $booking_id = $this->input->post('booking_code');
            $booking_id = $this->input->post('booking_id');
            $remarks = $this->input->post('remarks');
            $ocular_history = $this->input->post('ocular_history');
            $medical_history = $this->input->post('medical_history');
            $no_of_child = $this->input->post('no_of_child');
            $milestone = $this->input->post('milestone');
            $delivery_type = $this->input->post('delivery_type');
            $birth_weight = $this->input->post('birth_weight');
            $recent_weight = $this->input->post('recent_weight');
            $birth_asphyxia = $this->input->post('birth_asphyxia');
            $cried_after_birth = $this->input->post('cried_after_birth');
            $infection_history = $this->input->post('infection_history');
            $convulsion_history = $this->input->post('convulsion_history');
            $consanguinity_history = $this->input->post('consanguinity_history');
            // $workup_by = $this->input->post('workup_by');
            // $optometrist_signature = $this->input->post('optometrist_signature');
            // $doctor_signature = $this->input->post('doctor_signature');
            $created_by = $this->session->userdata('user_id');

            // Removed lens and comment
            $chief_complaints = array(
                'bdv_m' => $post['bdv_m'] ?$post['bdv_m']:'' ,
                'history_chief_blurr_side' => $post['history_chief_blurr_side'],
                'history_chief_blurr_dur' => $post['history_chief_blurr_dur'],
                'history_chief_blurr_unit' => $post['history_chief_blurr_unit'],
                'history_chief_blurr_comm' => $post['history_chief_blurr_comm'],
                'history_chief_blurr_dist' => $history_chief_blurr_dist,
                'history_chief_blurr_near' => $history_chief_blurr_near,
                'history_chief_blurr_pain' => $history_chief_blurr_pain,
                'history_chief_blurr_ug' => $history_chief_blurr_ug,
                'pain_m' => $post['pain_m']?$post['pain_m']:'',
                'history_chief_pains_side' => $post['history_chief_pains_side'],
                'history_chief_pains_dur' => $post['history_chief_pains_dur'],
                'history_chief_pains_unit' => $post['history_chief_pains_unit'],
                'history_chief_pains_comm' => $post['history_chief_pains_comm'],
                'redness_m' => $post['redness_m']?$post['redness_m']:'',
                'history_chief_rednes_side' => $post['history_chief_rednes_side'],
                'history_chief_rednes_dur' => $post['history_chief_rednes_dur'],
                'history_chief_rednes_unit' => $post['history_chief_rednes_unit'],
                'history_chief_rednes_comm' => $post['history_chief_rednes_comm'],
                'injury_m' => $post['injury_m']?$post['injury_m']:'',
                'history_chief_injuries_side' => $post['history_chief_injuries_side'],
                'history_chief_injuries_dur' => $post['history_chief_injuries_dur'],
                'history_chief_injuries_unit' => $post['history_chief_injuries_unit'],
                'history_chief_injuries_comm' => $post['history_chief_injuries_comm'],
                'water_m' => $post['water_m']?$post['water_m']:'',
                'history_chief_waterings_side' => $post['history_chief_waterings_side'],
                'history_chief_waterings_dur' => $post['history_chief_waterings_dur'],
                'history_chief_waterings_unit' => $post['history_chief_waterings_unit'],
                'history_chief_waterings_comm' => $post['history_chief_waterings_comm'],
                'discharge_m' => $post['discharge_m']?$post['discharge_m']:'',
                'history_chief_discharges_side' => $post['history_chief_discharges_side'],
                'history_chief_discharges_dur' => $post['history_chief_discharges_dur'],
                'history_chief_discharges_unit' => $post['history_chief_discharges_unit'],
                'history_chief_discharges_comm' => $post['history_chief_discharges_comm'],
                'dryness_m' => $post['dryness_m']?$post['dryness_m']:'',
                'history_chief_dryness_side' => $post['history_chief_dryness_side'],
                'history_chief_dryness_dur' => $post['history_chief_dryness_dur'],
                'history_chief_dryness_unit' => $post['history_chief_dryness_unit'],
                'history_chief_dryness_comm' => $post['history_chief_dryness_comm'],
                'itch_m' => $post['itch_m']?$post['itch_m']:'',
                'history_chief_itchings_side' => $post['history_chief_itchings_side'],
                'history_chief_itchings_dur' => $post['history_chief_itchings_dur'],
                'history_chief_itchings_unit' => $post['history_chief_itchings_unit'],
                'history_chief_itchings_comm' => $post['history_chief_itchings_comm'],
                'fbd_m' => $post['fbd_m']?$post['fbd_m']:'',
                'history_chief_fbsensation_side' => $post['history_chief_fbsensation_side'],
                'history_chief_fbsensation_dur' => $post['history_chief_fbsensation_dur'],
                'history_chief_fbsensation_unit' => $post['history_chief_fbsensation_unit'],
                'history_chief_fbsensation_comm' => $post['history_chief_fbsensation_comm'],
                'devs_m' => $post['devs_m']?$post['devs_m']:'',
                'history_chief_dev_squint_side' => $post['history_chief_dev_squint_side'],
                'history_chief_dev_squint_dur' => $post['history_chief_dev_squint_dur'],
                'history_chief_dev_squint_unit' => $post['history_chief_dev_squint_unit'],
                'history_chief_dev_squint_comm' => $post['history_chief_dev_squint_comm'],
                'history_chief_dev_diplopia' => $post['history_chief_dev_diplopia'],
                'history_chief_dev_truma' => $post['history_chief_dev_truma'],
                'history_chief_dev_ps' => $post['history_chief_dev_ps'],
                'heads_m' => $post['heads_m']?$post['heads_m']:'',
                'history_chief_head_strain_side' => $post['history_chief_head_strain_side'],
                'history_chief_head_strain_dur' => $post['history_chief_head_strain_dur'],
                'history_chief_head_strain_unit' => $post['history_chief_head_strain_unit'],
                'history_chief_head_strain_comm' => $post['history_chief_head_strain_comm'],
                'canss_m' => $post['canss_m']?$post['canss_m']:'',
                'history_chief_size_shape_side' => $post['history_chief_size_shape_side'],
                'history_chief_size_shape_dur' => $post['history_chief_size_shape_dur'],
                'history_chief_size_shape_unit' => $post['history_chief_size_shape_unit'],
                'history_chief_size_shape_comm' => $post['history_chief_size_shape_comm'],
                'ovs_m' => $post['ovs_m']?$post['ovs_m']:'',
                'history_chief_ovs_side' => $post['history_chief_ovs_side'],
                'history_chief_ovs_dur' => $post['history_chief_ovs_dur'],
                'history_chief_ovs_unit' => $post['history_chief_ovs_unit'],
                'history_chief_ovs_comm' => $post['history_chief_ovs_comm'],
                'history_chief_ovs_glare' => $history_chief_ovs_glare,
                'history_chief_ovs_floaters' => $history_chief_ovs_floaters,
                'history_chief_ovs_photophobia' => $history_chief_ovs_photophobia,
                'history_chief_ovs_color_halos' => $history_chief_ovs_color_halos,
                'history_chief_ovs_metamorphopsia' => $history_chief_ovs_metamorphopsia,
                'history_chief_ovs_chromatopsia' => $history_chief_ovs_chromatopsia,
                'history_chief_ovs_dnv' => $history_chief_ovs_dnv,
                'history_chief_ovs_ddv' => $history_chief_ovs_ddv,
                'sdv_m' => $post['sdv_m']?$post['sdv_m']:'',
                'history_chief_sdiv_side' => $post['history_chief_sdiv_side'],
                'history_chief_sdiv_dur' => $post['history_chief_sdiv_dur'],
                'history_chief_sdiv_unit' => $post['history_chief_sdiv_unit'],
                'history_chief_sdiv_comm' => $post['history_chief_sdiv_comm'],
                'doe_m' => $post['doe_m']?$post['doe_m']:'',
                'history_chief_doe_side' => $post['history_chief_doe_side'],
                'history_chief_doe_dur' => $post['history_chief_doe_dur'],
                'history_chief_doe_unit' => $post['history_chief_doe_unit'],
                'history_chief_doe_comm' => $post['history_chief_doe_comm'],
                'swel_m' => $post['swel_m']?$post['swel_m']:'',
                'history_chief_swell_side' => $post['history_chief_swell_side'],
                'history_chief_swell_dur' => $post['history_chief_swell_dur'],
                'history_chief_swell_unit' => $post['history_chief_swell_unit'],
                'history_chief_swell_comm' => $post['history_chief_swell_comm'],
                'burns_m' => $post['burns_m']?$post['burns_m']:'',
                'history_chief_sen_burn_side' => $post['history_chief_sen_burn_side'],
                'history_chief_sen_burn_dur' => $post['history_chief_sen_burn_dur'],
                'history_chief_sen_burn_unit' => $post['history_chief_sen_burn_unit'],
                'history_chief_sen_burn_comm' => $post['history_chief_sen_burn_comm'],
                'ptosis_sx' => $post['ptosis_sx']?$post['ptosis_sx']:'',
                'history_chief_ptosis_side' => $post['history_chief_ptosis_side'],
                'history_chief_ptosis_dur' => $post['history_chief_ptosis_dur'],
                'history_chief_ptosis_unit' => $post['history_chief_ptosis_unit'],
                'history_chief_ptosis_comm' => $post['history_chief_ptosis_comm'],
                'lid_sx' => $post['lid_sx']?$post['lid_sx']:'',
                'history_chief_lid_sx_side' => $post['history_chief_lid_sx_side'],
                'history_chief_lid_sx_dur' => $post['history_chief_lid_sx_dur'],
                'history_chief_lid_sx_unit' => $post['history_chief_lid_sx_unit'],
                'history_chief_lid_sx_comm' => $post['history_chief_lid_sx_comm'],
                'corneal_sx' => $post['corneal_sx']?$post['corneal_sx']:'',
                'history_chief_corneal_sx_side' => $post['history_chief_corneal_sx_side'],
                'history_chief_corneal_sx_dur' => $post['history_chief_corneal_sx_dur'],
                'history_chief_corneal_sx_unit' => $post['history_chief_corneal_sx_unit'],
                'history_chief_corneal_sx_comm' => $post['history_chief_corneal_sx_comm'],
                'cataract_sx' => $post['cataract_sx']?$post['cataract_sx']:'',
                'history_chief_cataract_sx_side' => $post['history_chief_cataract_sx_side'],
                'history_chief_cataract_sx_due' => $post['history_chief_cataract_sx_due'],
                'history_chief_cataract_sx_unit' => $post['history_chief_cataract_sx_unit'],
                'history_chief_cataract_sx_comm' => $post['history_chief_cataract_sx_comm'],
                'squint_sx' => $post['squint_sx']?$post['squint_sx']:'',
                'history_chief_squint_sx_side' => $post['history_chief_squint_sx_side'],
                'history_chief_squint_sx_due' => $post['history_chief_squint_sx_due'],
                'history_chief_squint_sx_unit' => $post['history_chief_squint_sx_unit'],
                'history_chief_squint_sx_comm' => $post['history_chief_squint_sx_comm'],
                'pterygium_sx' => $post['pterygium_sx']?$post['pterygium_sx']:'',
                'history_chief_pterygium_sx_side' => $post['history_chief_pterygium_sx_side'],
                'history_chief_pterygium_sx_due' => $post['history_chief_pterygium_sx_due'],
                'history_chief_pterygium_sx_unit' => $post['history_chief_pterygium_sx_unit'],
                'history_chief_pterygium_sx_comm' => $post['history_chief_pterygium_sx_comm'],
                'dcr' => $post['dcr']?$post['dcr']:'',
                'history_chief_dcr_sx_side' => $post['history_chief_dcr_sx_side'],
                'history_chief_dcr_sx_due' => $post['history_chief_dcr_sx_due'],
                'history_chief_dcr_sx_unit' => $post['history_chief_dcr_sx_unit'],
                'history_chief_dcr_sx_comm' => $post['history_chief_dcr_sx_comm'],
                'dct_sx' => $post['dct_sx']?$post['dct_sx']:'',
                'history_chief_dct_sx_side' => $post['history_chief_dct_sx_side'],
                'history_chief_dct_sx_due' => $post['history_chief_dct_sx_due'],
                'history_chief_dct_sx_unit' => $post['history_chief_dct_sx_unit'],
                'history_chief_dct_sx_comm' => $post['history_chief_dct_sx_comm'],
                'patching_therapy' => $post['patching_therapy']?$post['patching_therapy']:'',
                'history_chief_patching_therapy_side' => $post['history_chief_patching_therapy_side'],
                'history_chief_patching_therapy_due' => $post['history_chief_patching_therapy_due'],
                'history_chief_patching_therapy_unit' => $post['history_chief_patching_therapy_unit'],
                'history_chief_patching_therapy_comm' => $post['history_chief_patching_therapy_comm'],
                'history_chief_comm' => $post['history_chief_comm']
            );

            $squint_history = [
                'inward' => $this->input->post('inward'),
                'outward' => $this->input->post('outward'),
                'upward' => $this->input->post('upward'),
                'prev_squint' => $this->input->post('prev_squint'),
                'double_vision' => $this->input->post('double_vision'),
                'constant' => $this->input->post('constant'),
                'antisupression' => $this->input->post('antisupression'),
                'history_chief_inward_side' => $this->input->post('history_chief_inward_side'),
                'history_chief_inward_dur' => $this->input->post('history_chief_inward_dur'),
                'history_chief_inward_unit' => $this->input->post('history_chief_inward_unit'),
                'history_chief_inward_comm' => $this->input->post('history_chief_inward_comm'),
                'history_chief_outward_side' => $this->input->post('history_chief_outward_side'),
                'history_chief_outward_dur' => $this->input->post('history_chief_outward_dur'),
                'history_chief_outward_unit' => $this->input->post('history_chief_outward_unit'),
                'history_chief_outward_comm' => $this->input->post('history_chief_outward_comm'),
                'history_chief_upward_side' => $this->input->post('history_chief_upward_side'),
                'history_chief_upward_dur' => $this->input->post('history_chief_upward_dur'),
                'history_chief_upward_unit' => $this->input->post('history_chief_upward_unit'),
                'history_chief_upward_comm' => $this->input->post('history_chief_upward_comm'),
                'history_chief_prev_squint_side' => $this->input->post('history_chief_prev_squint_side'),
                'history_chief_prev_squint_dur' => $this->input->post('history_chief_prev_squint_dur'),
                'history_chief_prev_squint_unit' => $this->input->post('history_chief_prev_squint_unit'),
                'history_chief_prev_squint_comm' => $this->input->post('history_chief_prev_squint_comm'),
                'history_chief_double_vision_side' => $this->input->post('history_chief_double_vision_side'),
                'history_chief_double_vision_dur' => $this->input->post('history_chief_double_vision_dur'),
                'history_chief_double_vision_unit' => $this->input->post('history_chief_double_vision_unit'),
                'history_chief_double_vision_comm' => $this->input->post('history_chief_double_vision_comm'),
                'history_chief_constant_side' => $this->input->post('history_chief_constant_side'),
                'history_chief_constant_dur' => $this->input->post('history_chief_constant_dur'),
                'history_chief_constant_unit' => $this->input->post('history_chief_constant_unit'),
                'history_chief_constant_comm' => $this->input->post('history_chief_constant_comm'),
                'history_chief_antisupression_side' => $this->input->post('history_chief_antisupression_side'),
                'history_chief_antisupression_dur' => $this->input->post('history_chief_antisupression_dur'),
                'history_chief_antisupression_unit' => $this->input->post('history_chief_antisupression_unit'),
                'history_chief_antisupression_comm' => $this->input->post('history_chief_antisupression_comm'),
                'squint_comm' => $this->input->post('squint_comm'),
            ];

            // Prepare the data to save
            $data_to_save = [
                'id' => isset($id) ? $id : '',
                'branch_id' => isset($branch_id) ? $branch_id : '',
                'booking_code' => isset($booking_code) ? $booking_code : '',
                'pres_id' => isset($pres_id) ? $pres_id : '',
                'patient_id' => isset($patient_id) ? $patient_id : '',
                'booking_id' => isset($booking_id) ? $booking_id : '',
                'squint_history' => json_encode(isset($squint_history) ? $squint_history : ''),           
                'remarks' => isset($remarks) ? $remarks : '',           
                'ocular_history' => isset($ocular_history) ? $ocular_history : '',           
                'medical_history' => isset($medical_history) ? $medical_history : '',           
                'no_of_child' => isset($no_of_child) ? $no_of_child : '',           
                'delivery_type' => isset($delivery_type) ? $delivery_type : '',           
                'milestone' => isset($milestone) ? $milestone : '',           
                'birth_weight' => isset($birth_weight) ? $birth_weight : '',           
                'recent_weight' => isset($recent_weight) ? $recent_weight : '',           
                'birth_asphyxia' => isset($birth_asphyxia) ? $birth_asphyxia : '',           
                'cried_after_birth' => isset($cried_after_birth) ? $cried_after_birth : '',           
                'infection_history' => isset($infection_history) ? $infection_history : '',           
                'convulsion_history' => isset($convulsion_history) ? $convulsion_history : '',           
                'consanguinity_history' => isset($consanguinity_history) ? $consanguinity_history : '',           
                'status' => isset($result_exists) && $result_exists['oct_status'] == 1 ? 1 : 0,
                'is_deleted' => 0,
                'created_by' => isset($created_by) ? $created_by : '',
                'created_date' => date('Y-m-d H:i:s'),
                'ip_address' => $this->input->ip_address(),

            ];
            $chief_complaints = json_encode(isset($chief_complaints) ? $chief_complaints : '');         

            
            // echo "<pre>";
            // print_r($data_to_save); // For debugging
            // die("ok");

            // Save the data            
            $this->oct_hfa->save($data_to_save,$chief_complaints);
            $this->session->set_flashdata('success', 'Oct_hfa data saved successfully.');
            echo json_encode(['success' => true, 'message' => 'Oct_hfa data saved successfully.']);
            return;

        }
        
        // $data['chief_complaints'] = $chief_complaints;

        // If the form is not submitted or validation fails, load the view with the existing data


        // Load the view with the data
        $this->load->view('oct_hfa/add', $data);
    }


    public function book_patient()
    {
        // public function book_patient() {
        $patient_id = $this->input->post('patient_id');
        // $this->load->model('token_no');

        // Perform booking logic
        $booking_result = $this->oct_hfa->book_patient($patient_id);

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
        $status = $this->oct_hfa->get_booking_status($patient_id);
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
        $updated = $this->oct_hfa->update_patient_list_opd_status($patientId, 'new_status'); // Adjust as needed

        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'Status updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update status.']);
        }
    }

    public function fill_eye_data_auto_refraction($modal)
    {
        // echo "ijij";die;
        $data['page_title'] = $modal;
        $this->load->view('oct_hfa/refraction_mod', $data);
    }

    public function edit($id = "")
    {
        // echo $id;die;         // Check user permissions
        $this->load->library('form_validation');

        unauthorise_permission('411', '2486');

        // Validate the ID
        if (isset($id) && !empty($id) && is_numeric($id)) {
            $data['page_title'] = 'Edit Oct_hfa Record';

            // Retrieve the refraction record by ID
            $result = $this->oct_hfa->get_by_id($id); // Adjust this method according to your model
            // echo "<pre>";print_r($result);die;
            $comp = $this->oct_hfa->get_chief_complaints_by_booking_id($result['booking_id']);
            $chief_complaints = json_decode($comp['chief_complaints']); // Adjust this method according to your model
            $data['chief_complaints'] = (array) $chief_complaints;
            // echo "<pre>";print_r($data['chief_complaints']);die;
            $squint_history = json_decode($result['squint_history']);
            $data['squint_history'] = (array) $squint_history;
            if (!$result) {
                // Handle case where no record is found
                show_error('Oct_hfa record not found', 404);
                return;
            }

            // Prepare data for the view
           // Assuming $result['auto_refraction'] could be a JSON string
        //    $color_vision = json_decode($result['color_vision'], true); // Decode into an associative array
        //    $contrast_sensivity = json_decode($result['contrast_sensivity'], true); // Decode into an associative array
           $data['booking_data'] = $this->oct_hfa->get_booking_by_id($result['booking_id'],$result['patient_id']);
        //    echo "<pre>";print_r($data['booking_data']);die;
           $data['doctor'] = $this->doctor->doctors_list();

            // Check if decoding was successful
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Handle JSON decode error (for example, log it and set $auto_refraction_data to an empty array)
                log_message('error', 'JSON decode error: ' . json_last_error_msg());
                $color_vision = []; // Default to an empty array if there's an error
                $contrast_sensivity = []; // Default to an empty array if there's an error
            }
            // echo "<pre>";print_r($result);die;
            // Populate form data
            $data['form_data'] = array(
                'id' => $id,
                'booking_id' => $result['booking_id'],
                'editable' => true,
                'branch_id' => $result['branch_id'],
                'booking_code' => $result['booking_code'],
                'remarks' => $result['remarks'],
                'ocular_history' => $result['ocular_history'],
                'medical_history' => $result['medical_history'],
                'no_of_child' => $result['no_of_child'],
                'delivery_type' => $result['delivery_type'],
                'birth_weight' => $result['birth_weight'],
                'recent_weight' => $result['recent_weight'],
                'birth_asphyxia' => $result['birth_asphyxia'],
                'milestone' => $result['milestone'],
                'cried_after_birth' => $result['cried_after_birth'],
                'infection_history' => $result['infection_history'],
                'convulsion_history' => $result['convulsion_history'],
                'consanguinity_history' => $result['consanguinity_history'],
                'pres_id' => $result['pres_id'],
                'patient_id' => $result['patient_id'],
                'optometrist_signature' => $result['optometrist_signature'],
                'doctor_signature' => $result['doctor_signature'],
                'status' => 0,
                'is_deleted' => $result['is_deleted'],                
            );
            // foreach($this->fields as $keys){
            //     if(isset($result[$keys])){
            //         $data['form_data'][$keys] = $result[$keys];
            //     }                
            // }
            // Check if there is form submission
            if ($this->input->post()) {
                // echo "<pre>";print_r($this->input->post());die('okok');
                
                
                // Convert the refraction data to JSON
                $color_vision_data_json = json_encode($color_vision_data);
                $contrast_data_json = json_encode($contrast_data);
            
                // Prepare the data for updating
                $data_to_update = [
                    'id' => $this->input->post('id'),
                    'branch_id' => $this->input->post('branch_id'),
                    'booking_code' => $this->input->post('booking_code'),
                    'pres_id' => $this->input->post('pres_id'),
                    'patient_id' => $this->input->post('patient_id'),
                    'booking_id' => $this->input->post('booking_id'),                   
                    'optometrist_signature' => $this->input->post('optometrist_signature'),
                    'doctor_signature' => $this->input->post('doctor_signature'),
                    'status' => 0, // Or whatever default value you need
                    'is_deleted' => 0, // Assuming this is default
                    'modified_date' => date('Y-m-d H:i:s'), // Current timestamp for update
                    'ip_address' => $this->input->ip_address(),
                ];
                foreach($this->fields as $keys){
                    $data_to_update[$keys] = $this->input->post($keys);
                }
            
                // Update the data
                $this->oct_hfa->save($data_to_update); // Adjust this method according to your model
                $this->session->set_flashdata('success', 'Oct_hfa record updated successfully.');
                echo json_encode(['success' => true, 'message' => 'Oct_hfa record updated successfully.']);
                return; // Exit to prevent further output
            }
            
            // echo "<pre>";print_r($data);die;
            // Load the view with the prepared data
            $this->load->view('oct_hfa/add', $data); // Adjust the view name as necessary
        } else {
            // Handle the case when the ID is not valid
            show_error('Invalid ID provided', 400);
        }
    }

    private function _validate() {
        // Set validation rules for your form fields
        $this->form_validation->set_rules('oct_hfa_col_vis_l', 'Left Eye Vision', 'required|trim');
        $this->form_validation->set_rules('oct_hfa_col_vis_r', 'Right Eye Vision', 'required|trim');
        $this->form_validation->set_rules('oct_hfa_contra_sens_l', 'Left Eye Contrast Sensitivity', 'required|trim');
        $this->form_validation->set_rules('oct_hfa_contra_sens_r', 'Right Eye Contrast Sensitivity', 'required|trim');
        $this->form_validation->set_rules('amsler_grid', 'Amsler Grid', 'trim');
        $this->form_validation->set_rules('optometrist_signature', 'Optometrist Signature', 'trim');
        $this->form_validation->set_rules('doctor_signature', 'Doctor Signature', 'trim');
    
        // Set custom error messages if needed
        $this->form_validation->set_message('required', 'The {field} field is required.');
    
        // Run validation
        if ($this->form_validation->run() == FALSE) {
            return false; // Validation failed
        }
        return true; // Validation passed
    }
    

    public function print_oct_hfa($booking_id = NULL ,$id = NULL)
    {
        // echo "ppk";die;
        $data['print_status'] = "1";
        $data['page_title'] = "OCT HFA";
        $data['data_list'] = $this->oct_hfa->search_report_data($booking_id,$id);
        $data['booking_data'] = $this->oct_hfa->get_booking_by_id($booking_id,$id);
        // echo "<pre>";print_r($booking_id);print_r($id);die;
        // echo "<pre>";print_r($data['booking_data']);die;
        $data['doctor'] = $this->doctor->doctors_list();


        // Fetch the OPD billing details based on the ID
        // $booking_id = isset($data['form_data']['booking_id'])?$data['form_data']['booking_id']:'';
        // $data['billing_data'] = $this->vision_model->get_patient_name_by_booking_id($booking_id);

        // Load the print view with the data
        $this->load->view('oct_hfa/print_oct_hfa', $data);
    }

    public function update()
    {
        $post = $this->input->post();

        if (empty($post['data_id'])) {
            $this->session->set_flashdata('error', 'No record found to update');
            redirect('Oct_hfa');
        }

        $this->oct_hfa->save();
        $this->session->set_flashdata('success', 'Record updated successfully');
        redirect('Oct_hfa');
    }

    
    public function oct_hfa_excel()
    {
        
        // Load the PHPExcel library (Make sure the 'excel' library is correctly loaded in your application)
        $this->load->library('excel');
        
        // Initialize PHPExcel
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("Oct_hfa List")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);

        $from_date = $this->input->get('start_date');
        $to_date = $this->input->get('end_date');

        // Main header with date range if provided
        $mainHeader = "Oct_hfa List";
        if (!empty($from_date) && !empty($to_date)) {
            $mainHeader .= " (From: " . date('d-m-Y', strtotime($from_date)) . " To: " . date('d-m-Y', strtotime($to_date)) . ")";
        }

        // Set the main header in row 1
        $objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $mainHeader);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(16);

        // Leave row 2 blank
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);

        // Field names (header row) should start in row 3
        $fields = array('Token No', 'OPD No', 'Patient Reg No.', 'Patient Name', 'Mobile No', 'Age','Patient Status','Created Date');

        $col = 0; // Initialize the column index
        foreach ($fields as $field) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 3, $field); // Row 3 for headers
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true); // Auto-size columns
            $col++;
        }

        // Style for header row (Row 3)
        $objPHPExcel->getActiveSheet()->getStyle('A3:F3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // Fetching the OPD data
        $list = $this->oct_hfa->get_datatables();
        // echo "<pre>";print_r($list);die;

        // Populate the data starting from row 4
        $row = 4; // Start at row 4 for data
        if (!empty($list)) {
            foreach ($list as $oct_hfa) {
                // Reset column index for each new row
                $col = 0;
                
                $age_y = $oct_hfa->age_y;
                $age_m = $oct_hfa->age_m;
                $age_d = $oct_hfa->age_d;
        
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
                $statuses = explode(',', $oct_hfa->pat_status);
          
                // Trim any whitespace from the statuses and get the last one
                $last_status = trim(end($statuses));
                $created_date = date('d-m-Y h:i A', strtotime($oct_hfa->created));
                // Prepare data to be populated
                $data = array(
                    $oct_hfa->token,
                    $oct_hfa->booking_id,
                    $oct_hfa->patient_code,
                    $oct_hfa->patient_name,
                    $oct_hfa->mobile_no,
                    $age, // Adding missing 'Age' field
                    // $oct_hfa->status == 1 ? 'Active' : 'Not Active',
                    $last_status,
                    $created_date
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
        header('Content-Disposition: attachment;filename="oct_hfa_list_' . time() . '.xls"');
        header('Cache-Control: max-age=0');

        // Write the Excel file
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean(); // Prevent any output before sending file
        $objWriter->save('php://output');
    }



    public function oct_hfa_pdf()
    {
        // Increase memory limit and execution time for PDF generation
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 300);

        // Prepare data for the PDF
        // $data['print_status'] = "";
        // $from_date = $this->input->get('start_date');
        // $to_date = $this->input->get('end_date');

        // Fetch OPD data
        $data['data_list'] = $this->oct_hfa->get_datatables();
        // echo "<pre>";
        // print_r($data);
        // die;
        // $data['data_list']['side_effect_name'] = $this->vision_model->get_side_effect_name($data['data_list']['side_effects']);
        // Create main header
        $data['mainHeader'] = "Oct_hfa List";
        // if (!empty($from_date) && !empty($to_date)) {
        // $data['mainHeader'] .= " (From: " . date('d-m-Y', strtotime($from_date)) . " To: " . date('d-m-Y', strtotime($to_date)) . ")";
        // }

        // Load the view and capture the HTML output
        $this->load->view('oct_hfa/oct_hfa_html', $data);
        $html = $this->output->get_output();

        // Load PDF library and convert HTML to PDF
        $this->load->library('pdf');
        $this->pdf->load_html($html);
        $this->pdf->render();

        // Stream the generated PDF to the browser
        $this->pdf->stream("oct_hfa_list_" . time() . ".pdf", array("Attachment" => 1));
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
        $this->load->view('oct_hfa/advance_search', $data);
    }

    public function deleteall()
    {
        $ids = $this->input->post('row_id');
        // echo "<pre>";
        // print_r($ids);
        // die;
        if (!empty($ids)) {
            $this->oct_hfa->deleteall($ids);
            // echo json_encode(array("status" => TRUE));
            $response = "Dilate successfully deleted.";
            echo $response;
        }
    }

}
