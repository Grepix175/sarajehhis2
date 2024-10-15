<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vision extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('vision/vision_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['page_title'] = 'Vision Records';
        $this->load->view('vision/list', $data);
    }

    public function ajax_list()
    {
        $list = $this->vision_model->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $vision) {
            $no++;
            $row = array();
            $row[] = $vision->id;
            $row[] = $vision->patient_name;
            $row[] = $vision->procedure_purpose;
            $row[] = $vision->side_effect_name;
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
            $row[] = $vision->created_at;
            // $row[] = $vision->updated_at;

            // Add action buttons
            $row[] = '  <a onClick="return edit_vision(' . $vision->id . ');" class="btn-custom" href="javascript:void(0)" style="' . $vision->id . '" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                       <a class="btn-custom" disabled onClick="return delete_vision(' . $vision->id . ')" href="javascript:void(0)" title="Print" data-url="550"><i class="fa fa-print"></i> Print</a>';

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

    public function add($booking_id = null)
    {
        $data['side_effects'] = $this->vision_model->get_all_side_effects(); // Fetch side effects
        $data['page_title'] = 'Add Vision Record';
        $data['booking_id'] = isset($booking_id)?$booking_id:'';
        
        // Fetch patient name using booking_id if it is provided
        if ($booking_id) {
            $data['patient_name'] = $this->vision_model->get_patient_name_by_booking_id($booking_id);
        } else {
            $data['patient_name'] = ''; // Default value if no booking_id is provided
        }
        // print_r($data['patient_name'] );
        // die;

        $post = $this->input->post();

        if (isset($post) && !empty($post)) {
            // Save the form data
            $this->vision_model->save();

            // Return a JSON response indicating success
            echo json_encode(['success' => true]);
            return; // Exit to prevent further output
        }

        // If the form is not submitted, load the view
        $this->load->view('vision/add', $data);
    }



    public function edit($id = "")
    {
        // Check user permissions
        unauthorise_permission('411', '2486');
        $data['side_effects'] = $this->vision_model->get_all_side_effects(); // Fetch side effects

        
        // Validate the ID
        if (isset($id) && !empty($id) && is_numeric($id)) {
            $data['page_title'] = 'Edit Vision Record';
            // $data['vision'] = 
    
            // Retrieve the brand by ID
            $result = $this->vision_model->get_by_id($id);
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
                'data_id' => $result['id'],
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
            


            // Check if there is form submission
            if ($this->input->post()) {
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
        echo "kodfs";die;
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

    public function delete($id)
    {
        $this->vision_model->delete($id);
        $this->session->set_flashdata('success', 'Record deleted successfully');
        redirect('vision');
    }

    public function delete_multiple()
    {
        $ids = $this->input->post('ids');
        if (!empty($ids)) {
            $this->vision_model->deleteall($ids);
            echo json_encode(array("status" => TRUE));
        }
    }
}
