<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ipd_discharge_bill_model extends CI_Model 
{
	var $table = 'hms_ipd_booking';
	var $column = array('hms_ipd_booking.id','hms_patient.patient_code','hms_ipd_booking.ipd_no', 'hms_patient.patient_name','hms_ipd_booking.admission_date', 'hms_ipd_booking.admission_time','hms_doctors.doctor_name','hms_ipd_rooms.room_no','hms_ipd_room_to_bad.bad_no','hms_specialization.specialization');  
	var $order = array('id' => 'desc'); 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$users_data = $this->session->userdata('auth_users');
		$parent_branch_details = $this->session->userdata('parent_branches_data');
        $sub_branch_details = $this->session->userdata('sub_branches_data');
		$search = $this->session->userdata('running_bill_serach');

		$this->db->select("hms_ipd_booking.*,hms_ipd_booking.id as ipd_book_id,hms_ipd_booking.patient_id as ipd_patient_id,hms_ipd_booking.patient_id as p_id,hms_patient.patient_name,hms_patient.patient_code,hms_doctors.doctor_name,hms_specialization.specialization,hms_ipd_rooms.room_no,hms_ipd_room_to_bad.bad_no"); 
		$this->db->join('hms_patient','hms_patient.id=hms_ipd_booking.patient_id');
		$this->db->join('hms_doctors','hms_doctors.id=hms_ipd_booking.attend_doctor_id');
		$this->db->join('hms_ipd_rooms','hms_ipd_rooms.id=hms_ipd_booking.room_id','left');
		$this->db->join('hms_ipd_room_to_bad','hms_ipd_room_to_bad.id=hms_ipd_booking.bad_id','left');
		$this->db->join('hms_specialization','hms_specialization.id=hms_doctors.specilization_id');
		$this->db->where('hms_patient.is_deleted','0'); 
	
            
       
        if(isset($search['branch_id']) && $search['branch_id']!=''){
		$this->db->where('hms_patient.branch_id IN ('.$search['branch_id'].')');
		}else{
		$this->db->where('hms_patient.branch_id',$users_data['parent_id']);
		}
		/////// Search query start //////////////

		if(isset($search) && !empty($search))
		{
			//print_r($search['search_criteria']);die;
            /*if(isset($search['start_date']) && !empty($search['start_date']))
			{
				$start_date = date('Y-m-d',strtotime($search['start_date'])).' 00:00:00';
				$this->db->where('hms_patient.created_date >= "'.$start_date.'"');
			}

			if(isset($search['end_date']) && !empty($search['end_date']))
			{
				$end_date = date('Y-m-d',strtotime($search['end_date'])).' 23:59:59';
				$this->db->where('hms_patient.created_date <= "'.$end_date.'"');
			}*/

			if(isset($search['search_criteria']) && !empty($search['search_criteria']) && $search['search_criteria']==3)
			{
				$this->db->where('hms_ipd_booking.patient_type',1);
			}
			if(isset($search['search_criteria']) && !empty($search['search_criteria']) && $search['search_criteria']==2)
			{
				$this->db->where('hms_ipd_booking.patient_type',2);
			}

			if(isset($search['patient_name']) && !empty($search['patient_name']))
			{
				$this->db->where('hms_patient.patient_name',$search['patient_name']);
			}
			if(isset($search['mobile_no']) && !empty($search['mobile_no']))
			{
				$this->db->where('hms_patient.mobile_no',$search['mobile_no']);
			}
	}

		/////// Search query end //////////////

		$this->db->from($this->table); 
		$i = 0;
	
		foreach ($this->column as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND. 
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column) - 1 == $i) //last loop+
					$this->db->group_end(); //close bracket
			}
			$column[$i] = $item; // set column array variable to order processing
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function save_running_data(){
			$post =$this->input->post();
			if(!empty($post['data_id']) && isset($post['data_id'])){
			$update_data= array(
				'end_date'=>date('Y-m-d',strtotime($post['end_date']))
				);
			$this->db->where(array('id'=>$post['data_id']));
			$this->db->update('hms_ipd_patient_to_charge',$update_data);
			}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get(); 
		//echo $this->db->last_query();die;
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	//function get_running_bill_info_datatables($book_id="",$patient_id="")
   // {
    	
	    //$this->_get_running_bill_info_datatables_query($book_id,$patient_id);
	   // if($_POST['length'] != -1)
	    //$this->db->limit($_POST['length'], $_POST['start']);
	    /*if(!empty($medicine_id) && !empty($batch_no))
	    {*/
	    //$query = $this->db->get(); 
	   // echo $this->db->last_query();die;
	   // return $query->result();
	    /*}
	    else
	    {
	    	$result = array();
	    	return $result;
	    }*/
   // }
   
   
   public  function get_discharge_bill_info_datatables($book_id="0",$patient_id="0")
    {
    	$type_value= get_ipd_discharge_time_setting_value();
		if(isset($type_value) && $type_value!='' && $type_value==1)
		{
			$users_data = $this->session->userdata('auth_users');
			$this->db->select("hms_ipd_patient_to_charge.*");
			$this->db->from('hms_ipd_patient_to_charge');
			$this->db->where('hms_ipd_patient_to_charge.type NOT IN (2,7,8)');
			$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
			$this->db->where('hms_ipd_patient_to_charge.is_deleted',0);
			$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
			//$this->db->group_by('group_code');
			 $res= $this->db->get()->result();
			// echo $this->db->last_query();die;
			 $data['CHARGES']='';
			 $data['advance_payment']='';
			 $res = json_decode(json_encode($res), true);
			 foreach($res as $data_new)
			 {
			 	
			 	if($data_new['start_date']!='0000-00-00 00:00:00' && $data_new['end_date']!='0000-00-00 00:00:00' && $data_new['type']!=1 && $data_new['type']!=5)
			 	{
			 		//echo $data_new['start_date'];
					$date1 = new DateTime(date('Y-m-d H:i:s',strtotime($data_new['start_date'])));
					$date2 = new DateTime(date('Y-m-d H:i:s',strtotime($data_new['end_date'])));
					$date2->modify("+1 days");
					$interval = $date1->diff($date2);
					$days= $interval->days;
					if($data_new['type']!=1)
					{
						/* new code here */

						$time_duration= date('H:i:s',strtotime($data_new['start_date']));
				     	$current_time= date('H:i:s');
						if($interval->h<=23 && $interval->h >0 && ($current_time < $time_duration))
						{
							$i=1;
							while($i <= $days) 
							{
								  	if(!empty($data_new['end_date']) && $data_new['end_date']!='')
									{
										$data_new['start_date'] = date('Y-m-d H:i:s', strtotime($data_new['end_date'])-($i*86400)); 
									}
									else
									{
										$data_new['start_date'] = date('Y-m-d H:i:s'); 
									}
								    $data['CHARGES'][]=$data_new;
									$i++;
							}
						}
						else
						{
							//echo $days;
							for($i=0;$i<$days;$i++)
							{ 
								if(!empty($data_new['end_date']) && $data_new['end_date']!='')
								{
									
									$data_new['start_date'] = date('Y-m-d H:i:s', strtotime($data_new['end_date'])-($i*86400));
								}
								else
								{

									$data_new['start_date'] = date('Y-m-d H:i:s'); 
								}
							    $data['CHARGES'][]=$data_new;
							} 
							//echo '<pre>'; print_r($data['CHARGES']);die;

						}
						/* new code here */


						// if(!empty($data_new['end_date']) && $data_new['end_date']!='')
		    //               {
		    //               	$data_new['start_date'] = date('Y-m-d', strtotime($data_new['end_date'])-($i*86400)); 
		    //               }
		    //               else
		    //               {
		    //               	$data_new['start_date'] = date('Y-m-d'); 
		    //               }
	                 
					/* start _date query */
						//$data_new['end_date'] = date('Y-m-d', strtotime($data_new['end_date'])-($i*86400)); 
						// $data_new->end_date = date('Y-m-d', strtotime('-'.$i.' day', strtotime($data_new->start_date))); 
						//echo $data_new->start_date;die;


						//$data_new->end_date = date('Y-m-d', strtotime('-'.$i.' day', $data_new->start_date));

					/* start date query */
						 
						//$data['CHARGES'][]=$data_new;
					 
					
					//(object) $array
					
				}
					
					}
			 	else
			 	{

			 		 //echo "<pre>"; print_r($data_new); exit;
			 	    $date1 = new DateTime(date('Y-m-d H:i:s',strtotime($data_new['start_date'])));
			 	    
					$date2 = new DateTime(date('Y-m-d H:i:s'));
					$date2->modify("+1 days");
					$interval = $date1->diff($date2);
					$days= $interval->days;
				     if($data_new['type']!=1 && $data_new['type']!=5)
				     {
						for($i=1;$i<=$days;$i++)
						{
						$data['CHARGES'][]=$data_new;
						}
				     }
				     else
				     {
				     	$data['CHARGES'][]=$data_new;
				     }

				 }

			 }
			$this->db->select("hms_ipd_patient_to_charge.branch_id, hms_ipd_patient_to_charge.ipd_id, hms_ipd_patient_to_charge.id, hms_ipd_patient_to_charge.type, hms_ipd_patient_to_charge.particular, hms_ipd_patient_to_charge.start_date, hms_ipd_patient_to_charge.end_date, (CASE WHEN hms_ipd_patient_to_charge.quantity >= 0 THEN 0 END) as quantity, (CASE WHEN hms_ipd_patient_to_charge.price >= 0 THEN '0.00' END) as price, sum(hms_ipd_patient_to_charge.net_price) as net_price"); 
			$this->db->from('hms_ipd_patient_to_charge');
			$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
			$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
			$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
			$this->db->where('hms_ipd_patient_to_charge.type',2); 
			$this->db->group_by('hms_ipd_patient_to_charge.type');
			$data['advance_payment']= $this->db->get()->result();

			$this->db->select("*"); 
			$this->db->from('hms_ipd_patient_to_charge');
			$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
			$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
			$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
			$this->db->where('hms_ipd_patient_to_charge.type',8); 
			//$this->db->group_by('hms_ipd_patient_to_charge.type');
			$data['medicine_payment']= $this->db->get()->result(); 
			//echo $this->db->last_query(); 
			$this->db->select("*"); 
			$this->db->from('hms_ipd_patient_to_charge');
			$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
			$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
			$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
			$this->db->where('hms_ipd_patient_to_charge.type',7); 
			//$this->db->group_by('hms_ipd_patient_to_charge.type');
			$data['pathology_payment']= $this->db->get()->result();

	       //print '<pre>'; print_r($data);die;
			return $data;
		

		}
		else
		{
			$users_data = $this->session->userdata('auth_users');
			$this->db->select("hms_ipd_patient_to_charge.*");
			$this->db->from('hms_ipd_patient_to_charge');
			$this->db->where('hms_ipd_patient_to_charge.type NOT IN (2,7,8)');
			$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
			$this->db->where('hms_ipd_patient_to_charge.is_deleted',0);
			$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
			//$this->db->group_by('hms_ipd_patient_to_charge.group_code');
		//	echo $this->db->last_query();die('gsgd');
			 $res= $this->db->get()->result();
			 $data['CHARGES']=array();
			 $data['advance_payment']='';
			 $res = json_decode(json_encode($res), true);
			 //echo "<pre>"; print_r($res); exit;
			 foreach($res as $data_new)
			 {
			 	
			 	if($data_new['start_date']!='0000-00-00 00:00:00' && $data_new['end_date']!='0000-00-00 00:00:00' && $data_new['type']!=1 && $data_new['type']!=5)
			 	{
					$date1 = new DateTime(date('Y-m-d',strtotime($data_new['start_date'])));
					$date2 = new DateTime(date('Y-m-d',strtotime($data_new['end_date'])));
					$date2->modify("+1 days");
					$interval = $date1->diff($date2);
					$days= $interval->days;
					if($data_new['type']!=1)
					{
					for($i=0;$i<$days;$i++)
					{ if(!empty($data_new['end_date']) && $data_new['end_date']!='')
	                  {
	                  	$data_new['start_date'] = date('Y-m-d', strtotime($data_new['end_date'])-($i*86400)); 
	                  }
	                  else
	                  {
	                  	$data_new['start_date'] = date('Y-m-d'); 
	                  }
	                 
					/* start _date query */
						//$data_new['end_date'] = date('Y-m-d', strtotime($data_new['end_date'])-($i*86400)); 
						// $data_new->end_date = date('Y-m-d', strtotime('-'.$i.' day', strtotime($data_new->start_date))); 
						//echo $data_new->start_date;die;


						//$data_new->end_date = date('Y-m-d', strtotime('-'.$i.' day', $data_new->start_date));

					/* start date query */
						 
						$data['CHARGES'][]=$data_new;
					} 
					
					//(object) $array
					
				}
					
					}
			 	else
			 	{
			 		 //echo "<pre>"; print_r($data_new); exit;
			 	    $date1 = new DateTime(date('Y-m-d',strtotime($data_new['start_date'])));
			 	    
					$date2 = new DateTime(date('Y-m-d'));
					$date2->modify("+1 days");
					$interval = $date1->diff($date2);
					$days= $interval->days;
				     if($data_new['type']!=1 && $data_new['type']!=5)
				     {
						for($i=1;$i<=$days;$i++)
						{
						$data['CHARGES'][]=$data_new;
						}
				     }
				     else
				     {
				     	$data['CHARGES'][]=$data_new;
				     }

				 }

			 }
			$this->db->select("hms_ipd_patient_to_charge.branch_id, hms_ipd_patient_to_charge.ipd_id, hms_ipd_patient_to_charge.id, hms_ipd_patient_to_charge.type, hms_ipd_patient_to_charge.particular, hms_ipd_patient_to_charge.start_date, hms_ipd_patient_to_charge.end_date, (CASE WHEN hms_ipd_patient_to_charge.quantity >= 0 THEN 0 END) as quantity, (CASE WHEN hms_ipd_patient_to_charge.price >= 0 THEN '0.00' END) as price, sum(hms_ipd_patient_to_charge.net_price) as net_price"); 
			$this->db->from('hms_ipd_patient_to_charge');
			$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
			$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
			$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
			$this->db->where('hms_ipd_patient_to_charge.type',2); 
			$this->db->group_by('hms_ipd_patient_to_charge.type');
			$data['advance_payment']= $this->db->get()->result();

			$this->db->select("*"); 
			$this->db->from('hms_ipd_patient_to_charge');
			$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
			$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
			$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
			$this->db->where('hms_ipd_patient_to_charge.type',8); 
			//$this->db->group_by('hms_ipd_patient_to_charge.type');
			$data['medicine_payment']= $this->db->get()->result(); 
			//echo $this->db->last_query(); 
			$this->db->select("*"); 
			$this->db->from('hms_ipd_patient_to_charge');
			$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
			$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
			$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
			$this->db->where('hms_ipd_patient_to_charge.type',7); 
			//$this->db->group_by('hms_ipd_patient_to_charge.type');
			$data['pathology_payment']= $this->db->get()->result();

	       //print '<pre>'; print_r($data);die;
	       /*if($users_data['parent_id']=='15')
	       {
	       echo "<pre>"; print_r($data); exit;
	       }*/
			return $data;
		}
			
		
    }
	 public  function get_discharge_bill_info_datatables20190201($book_id="0",$patient_id="0")
    {
		$users_data = $this->session->userdata('auth_users');
		$this->db->select("hms_ipd_patient_to_charge.*");
		$this->db->from('hms_ipd_patient_to_charge');
		//$this->db->where('hms_ipd_patient_to_charge.type!=',2);
		$this->db->where('hms_ipd_patient_to_charge.type NOT IN (2,7,8)');
		$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
		$this->db->where('hms_ipd_patient_to_charge.is_deleted',0);
		$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
		//$this->db->group_by('hms_ipd_patient_to_charge.start_date');
		 $res= $this->db->get()->result();
		 $data['CHARGES']='';
		 $data['advance_payment']='';
		 $res = json_decode(json_encode($res), true);
		 //echo "<pre>"; print_r($res); exit;
		 foreach($res as $data_new)
		 {
		 	
		 	if($data_new['start_date']!='0000-00-00 00:00:00' && $data_new['end_date']!='0000-00-00 00:00:00' && $data_new['type']!=1 && $data_new['type']!=5)
		 	{
				$date1 = new DateTime(date('Y-m-d',strtotime($data_new['start_date'])));
				$date2 = new DateTime(date('Y-m-d',strtotime($data_new['end_date'])));
				$date2->modify("+1 days");
				$interval = $date1->diff($date2);
				$days= $interval->days;
				if($data_new['type']!=1)
				{
				for($i=0;$i<$days;$i++)
				{ //print_r($data_new);die; 
                     
                  if(!empty($data_new['end_date']) && $data_new['end_date']!='')
                  {
                  	$data_new['start_date'] = date('Y-m-d', strtotime($data_new['end_date'])-($i*86400)); 
                  }
                  else
                  {
                  	$data_new['start_date'] = date('Y-m-d'); 
                  }
                 
				/* start _date query */
					//$data_new['end_date'] = date('Y-m-d', strtotime($data_new['end_date'])-($i*86400)); 
					// $data_new->end_date = date('Y-m-d', strtotime('-'.$i.' day', strtotime($data_new->start_date))); 
					//echo $data_new->start_date;die;


					//$data_new->end_date = date('Y-m-d', strtotime('-'.$i.' day', $data_new->start_date));

				/* start date query */
					 
					$data['CHARGES'][]=$data_new;
				} 
				
				//(object) $array
				
			}
				
				}
		 	else
		 	{
		 		 //echo "<pre>"; print_r($data_new); exit;
		 	    $date1 = new DateTime(date('Y-m-d',strtotime($data_new['start_date'])));
		 	    
				$date2 = new DateTime(date('Y-m-d'));
				$date2->modify("+1 days");
				$interval = $date1->diff($date2);
				$days= $interval->days;
			     if($data_new['type']!=1 && $data_new['type']!=5)
			     {
					for($i=1;$i<=$days;$i++)
					{
					$data['CHARGES'][]=$data_new;
					}
			     }
			     else
			     {
			     	$data['CHARGES'][]=$data_new;
			     }

			 }

		 }
		$this->db->select("hms_ipd_patient_to_charge.branch_id, hms_ipd_patient_to_charge.ipd_id, hms_ipd_patient_to_charge.id, hms_ipd_patient_to_charge.type, hms_ipd_patient_to_charge.particular, hms_ipd_patient_to_charge.start_date, hms_ipd_patient_to_charge.end_date, (CASE WHEN hms_ipd_patient_to_charge.quantity >= 0 THEN 0 END) as quantity, (CASE WHEN hms_ipd_patient_to_charge.price >= 0 THEN '0.00' END) as price, sum(hms_ipd_patient_to_charge.net_price) as net_price"); 
		$this->db->from('hms_ipd_patient_to_charge');
		$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
		$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
		$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
		$this->db->where('hms_ipd_patient_to_charge.type',2); 
		$this->db->group_by('hms_ipd_patient_to_charge.type');
		$data['advance_payment']= $this->db->get()->result();

		$this->db->select("*"); 
		$this->db->from('hms_ipd_patient_to_charge');
		$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
		$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
		$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
		$this->db->where('hms_ipd_patient_to_charge.type',8); 
		//$this->db->group_by('hms_ipd_patient_to_charge.type');
		$data['medicine_payment']= $this->db->get()->result(); 
		//echo $this->db->last_query(); 
		$this->db->select("*"); 
		$this->db->from('hms_ipd_patient_to_charge');
		$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
		$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
		$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
		$this->db->where('hms_ipd_patient_to_charge.type',7); 
		//$this->db->group_by('hms_ipd_patient_to_charge.type');
		$data['pathology_payment']= $this->db->get()->result();

       //print '<pre>'; print_r($data);die;
		return $data;
			
		
    }


    /* public  function get_unique_discharge_bill_info_datatables($book_id="0",$patient_id="0")
    {
		$users_data = $this->session->userdata('auth_users');
		$this->db->select("hms_ipd_patient_to_charge.id, hms_ipd_patient_to_charge.ipd_id, hms_ipd_patient_to_charge.patient_id, hms_ipd_patient_to_charge.parent_id, hms_ipd_patient_to_charge.type, hms_ipd_patient_to_charge.particulars, sum(.hms_ipd_patient_to_charge.qty*hms_ipd_patient_to_charge.price) as net_tot_price, hms_ipd_patient_to_charge.price");
		$this->db->from('hms_ipd_patient_to_charge');
		//$this->db->where('hms_ipd_patient_to_charge.type!=',2);
		$this->db->where('hms_ipd_patient_to_charge.type NOT IN (2,7,8)');
		$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
		$this->db->where('hms_ipd_patient_to_charge.is_deleted',0);
		$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
		$this->db->group_by('hms_ipd_patient_to_charge.particulars');
		 $res= $this->db->get()->result();
		 $data['CHARGES']='';
		 $data['advance_payment']='';
		 $res = json_decode(json_encode($res), true);
		 //echo "<pre>"; print_r($res); exit;
		 foreach($res as $data_new)
		 {
		 	
		 	if($data_new['start_date']!='0000-00-00 00:00:00' && $data_new['end_date']!='0000-00-00 00:00:00' && $data_new['type']!=1)
		 	{
				$date1 = new DateTime(date('Y-m-d',strtotime($data_new['start_date'])));
				$date2 = new DateTime(date('Y-m-d',strtotime($data_new['end_date'])));
				$date2->modify("+1 days");
				$interval = $date1->diff($date2);
				$days= $interval->days;
				if($data_new['type']!=1)
				{
				for($i=0;$i<$days;$i++)
				{ //print_r($data_new);die; 
                     
                  if(!empty($data_new['end_date']) && $data_new['end_date']!='')
                  {
                  	$data_new['start_date'] = date('Y-m-d', strtotime($data_new['end_date'])-($i*86400)); 
                  }
                  else
                  {
                  	$data_new['start_date'] = date('Y-m-d'); 
                  }
                 
				/* start _date query */
					//$data_new['end_date'] = date('Y-m-d', strtotime($data_new['end_date'])-($i*86400)); 
					// $data_new->end_date = date('Y-m-d', strtotime('-'.$i.' day', strtotime($data_new->start_date))); 
					//echo $data_new->start_date;die;


					//$data_new->end_date = date('Y-m-d', strtotime('-'.$i.' day', $data_new->start_date));

				/* start date query */
					 
					//$data['CHARGES'][]=$data_new;
				//} 
				
				//(object) $array
				
			//}
				
				//}
		 	//else
		 	//{
		 		 //echo "<pre>"; print_r($data_new); exit;
		 	   /* $date1 = new DateTime(date('Y-m-d',strtotime($data_new['start_date'])));
		 	    
				$date2 = new DateTime(date('Y-m-d'));
				$date2->modify("+1 days");
				$interval = $date1->diff($date2);
				$days= $interval->days;
			     if($data_new['type']!=1)
			     {
					for($i=1;$i<=$days;$i++)
					{
					$data['CHARGES'][]=$data_new;
					}
			     }
			     else
			     {
			     	$data['CHARGES'][]=$data_new;
			     }

			 }

		 }
		$this->db->select("hms_ipd_patient_to_charge.branch_id, hms_ipd_patient_to_charge.ipd_id, hms_ipd_patient_to_charge.id, hms_ipd_patient_to_charge.type, hms_ipd_patient_to_charge.particular, hms_ipd_patient_to_charge.start_date, hms_ipd_patient_to_charge.end_date, (CASE WHEN hms_ipd_patient_to_charge.quantity >= 0 THEN 0 END) as quantity, (CASE WHEN hms_ipd_patient_to_charge.price >= 0 THEN '0.00' END) as price, sum(hms_ipd_patient_to_charge.net_price) as net_price"); 
		$this->db->from('hms_ipd_patient_to_charge');
		$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
		$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
		$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
		$this->db->where('hms_ipd_patient_to_charge.type',2); 
		$this->db->group_by('hms_ipd_patient_to_charge.type');
		$data['advance_payment']= $this->db->get()->result();

		$this->db->select("*"); 
		$this->db->from('hms_ipd_patient_to_charge');
		$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
		$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
		$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
		$this->db->where('hms_ipd_patient_to_charge.type',8); 
		//$this->db->group_by('hms_ipd_patient_to_charge.type');
		$data['medicine_payment']= $this->db->get()->result(); 
		//echo $this->db->last_query(); 
		$this->db->select("*"); 
		$this->db->from('hms_ipd_patient_to_charge');
		$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
		$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
		$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
		$this->db->where('hms_ipd_patient_to_charge.type',7); 
		//$this->db->group_by('hms_ipd_patient_to_charge.type');
		$data['pathology_payment']= $this->db->get()->result();

       //print '<pre>'; print_r($data);die;
		return $data;
			
		
    }*/


    /*function get_running_bill_info_count_filtered($book_id="",$patient_id='')
	{
		$this->_get_running_bill_info_datatables_query($book_id,$patient_id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_running_bill_info_count_all($book_id="",$patient_id='')
	{
		$this->_get_running_bill_info_datatables_query($book_id,$patient_id);
		$query = $this->db->get();
		return $query->num_rows();

	}*/

	public function get_particular_data($vals="",$group="")
	{
			$response = '';
			if(!empty($vals))
			{
			    $users_data = $this->session->userdata('auth_users'); 
			    $this->db->select('*');
			    $this->db->where('group_code',$group);  
			    $this->db->where('status','1'); 
			    $this->db->order_by('particular','ASC');
			    $this->db->where('is_deleted',0);
			    $this->db->where('particular LIKE "'.$vals.'%"');
			    $this->db->where('branch_id',$users_data['parent_id']);  
			    $query = $this->db->get('hms_ipd_perticular');
			    $result = $query->result(); 
			    //echo $this->db->last_query();
			    if(!empty($result))
			    { 
			    	$data = array();
			    	foreach($result as $vals)
			    	{
			    		//$response[] = $vals->medicine_name;
						$name = $vals->particular.'|'.$vals->charge.'|'.$vals->id.'|'.$vals->particular_code;
						array_push($data, $name);
			    	}

			    	echo json_encode($data);
			    }
			    //return $response; 
			} 
	}
	
  public function save_particulars($ipd_id,$patient_id)
  {
   $post= $this->input->post();
   $this->db->select('*');
   $users_data = $this->session->userdata('auth_users');
 
	$particular_data = array(
							'branch_id'=>$users_data['parent_id'],
							'ipd_id'=>$ipd_id,
							'patient_id'=>$patient_id,
							'type'=>5,
							'particular_id'=>$post['particular_id'],
							'start_date'=>date('Y-m-d',strtotime($post['date'])),
							'group_name'=>$post['group_name'],
							'group_code'=>$post['group_code'],
							'particular'=>$post['particular'],
							'particular_code'=>$post['code'],
							'quantity'=>$post['qty'],
							'price'=>$post['charge'],
							'panel_price'=>$post['charge'],
							'net_price'=>$post['qty']*$post['charge'],
							'status'=>1,
							);

	$this->db->insert('hms_ipd_patient_to_charge',$particular_data);
	
   
  }

public function save()
  {

		$user_data = $this->session->userdata('auth_users');
		$users_data = $this->session->userdata('auth_users');

		$post = $this->input->post();
		
 		$blance ='';
		$referral_id = get_ipd_referral_doctor($post['ipd_id']);
		if(!empty($referral_id))
		{
			$referral_id =$referral_id;
		}
		

		if($post['total_advance_discount']>$post['total_amount'])
		{
			//if already exist delete the data and insert it
			
			if(!empty($post['ipd_id']) && !empty($post['patient_id']))
			{
				$this->db->where(array('branch_id'=>$user_data['parent_id'],'parent_id'=>$post['ipd_id'],'type'=>10));
				$this->db->delete('hms_expenses');
				
			}

			$data_expenses= array(
                    'branch_id'=>$users_data['parent_id'],
                    'type'=>10,
                    'vouchar_no'=>generate_unique_id(19),
                    'parent_id'=>$post['ipd_id'],
                    'expenses_date'=>date('Y-m-d H:i:s'),
                    'paid_to_id'=>$post['patient_id'],
                    'paid_amount'=>$post['total_refund_amount'],
                    'payment_mode'=>$post['payment_mode'],
                    'created_date'=>date('Y-m-d H:i:s'),
                    'modified_date'=>date('Y-m-d H:i:s'),
                    'modified_by'=>$users_data['id']
                    );
				//print_r($data_expenses);die;
                $this->db->insert('hms_expenses',$data_expenses);
				//echo $this->db->last_query(); die();
				//echo $insert_id;die;

				/*add sales banlk detail*/
            if(!empty($post['field_name']))
            {
                $post_field_value_name= $post['field_name'];
                $counter_name= count($post_field_value_name); 
                for($i=0;$i<$counter_name;$i++) 
                {
	                $data_field_value= array(
	                'field_value'=>$post['field_name'][$i],
	                'field_id'=>$post['field_id'][$i],
	                'type'=>17,
	                'section_id'=>17,
	                'p_mode_id'=>$post['payment_mode'],
	                'branch_id'=>$user_data['parent_id'],
	                'parent_id'=>$post['ipd_id'],
	                'ip_address'=>$_SERVER['REMOTE_ADDR']
	                );
	                $this->db->set('created_by',$user_data['id']);
	                $this->db->set('created_date',date('Y-m-d H:i:s'));
	                $this->db->insert('hms_payment_mode_field_value_acc_section',$data_field_value);

                }
             }

			

            /*add sales banlk detail*/
		}
		else
		{

	  	   		
				if(!empty($post['ipd_id']) && !empty($post['patient_id']))
				{

					$this->db->where('parent_id',$post['ipd_id']);
		            $this->db->where('section_id','5');
		            $this->db->where('type','5');
		            //$this->db->where('balance>0');
		            $this->db->where('patient_id',$post['patient_id']);
		            $query_d_pay = $this->db->get('hms_payment');
		            $row_d_pay = $query_d_pay->result();
		            //echo "<pre>";print_r($row_d_pay); die;
					/*$this->db->where(array('branch_id'=>$user_data['parent_id'],'patient_id'=>$post['patient_id'],'parent_id'=>$post['ipd_id'],'type'=>5,'section_id'=>5));
					$this->db->delete('hms_payment');*/
					
				}
	            

    		if(!empty($post['ipd_id']) && !empty($post['patient_id']) && !empty($row_d_pay) )
    		{
    			//echo "aa"; die;

    			
	            	foreach($row_d_pay as $row_d)
	            	{
	            		/*$this->db->set('payment_id',$payment_id);
						$this->db->where('parent_id',$post['ipd_id']);
						$this->db->where('payment_id',$row_d->id);  
						$this->db->where('section_id',3);
						$this->db->update('hms_branch_hospital_no');*/
                   if(!empty($post['total_discount']))
					{
						$total_credit = $post['total_amount']-$post['total_discount'];
					}
					else
					{
						$total_credit = $post['total_net_amount'];	
					}
					$payment_data = array(
						'parent_id'=>$post['ipd_id'],
						'branch_id'=>$user_data['parent_id'],
						'section_id'=>'5',
						'doctor_id'=>$referral_id,
						'type'=>5,
						'patient_id'=>$post['patient_id'],
						'total_amount'=>str_replace(',', '', $post['total_amount']),
						'discount_amount'=>$post['total_discount'],
						'net_amount'=>str_replace(',', '', $post['total_net_amount']),
						'credit'=>str_replace(',', '', $total_credit),
						'debit'=>str_replace(',', '', $post['total_paid_amount']),
						'pay_mode'=>$post['payment_mode'],
						'balance'=>$post['total_balance'],
						'paid_amount'=>$post['total_paid_amount'],
						'created_date'=>date('Y-m-d H:i:s',strtotime($post['discharge_date'])),//$post['discharge_date'],//$row_d->created_date,//date('Y-m-d H:i:s'),
                        'created_by'=>$user_data['id']
    	             );
					$this->db->where('id',$row_d->id); 
    				$this->db->update('hms_payment',$payment_data);
    				//echo $this->db->last_query(); exit; 
    		
	            }
	            

    		}
    		else
    		{
    			//echo "<pre>"; print_r($post); exit;
    			if(!empty($post['total_discount']))
					{
						$total_credit = $post['total_amount']-$post['total_discount'];
					}
					else
					{
						$total_credit = $post['total_net_amount'];	
					}
    			$payment_data = array(
						'parent_id'=>$post['ipd_id'],
						'branch_id'=>$user_data['parent_id'],
						'section_id'=>'5',
						'doctor_id'=>$referral_id,
						'type'=>5,
						'patient_id'=>$post['patient_id'],
						'total_amount'=>str_replace(',', '', $post['total_amount']),
						'discount_amount'=>$post['total_discount'],
						'net_amount'=>str_replace(',', '', $post['total_net_amount']),
						'credit'=>str_replace(',', '', $total_credit),
						'debit'=>str_replace(',', '', $post['total_paid_amount']),
						'pay_mode'=>$post['payment_mode'],
						//'bank_name'=>$bank_name,
						//'cheque_no'=>$cheque_no,
						//'cheque_date'=>$cheque_date,
						'balance'=>$post['total_balance'],
						'paid_amount'=>$post['total_paid_amount'],
						//'transection_no'=>$transaction_no,
                        'created_date'=>date('Y-m-d H:i:s'),
                        'created_by'=>$user_data['id']
    	             );
    		$this->db->insert('hms_payment',$payment_data);
    		$payment_id= $this->db->insert_id();

    			if($post['total_paid_amount']>0)
	    		{
	    			
	    			$hospital_receipt_no= check_hospital_receipt_no();
					$data_receipt_data= array(
								'branch_id'=>$user_data['parent_id'],
								'section_id'=>3,
								'payment_id'=>$payment_id,
								'parent_id'=>$post['ipd_id'],
								'reciept_prefix'=>$hospital_receipt_no['prefix'],
								'reciept_suffix'=>$hospital_receipt_no['suffix'],
								'created_by'=>$user_data['id'],
								'created_date'=>date('Y-m-d H:i:s')
								);
					$this->db->insert('hms_branch_hospital_no',$data_receipt_data);	
					//echo $this->db->last_query(); die;
	    		}	
    		}
    		/*add sales banlk detail*/
    		//genereate reciept no

    		//echo "yy"; die;


			if(!empty($post['field_name']))
                {
                $post_field_value_name= $post['field_name'];
                $counter_name= count($post_field_value_name); 
                for($i=0;$i<$counter_name;$i++) 
                {
	                $data_field_value= array(
	                'field_value'=>$post['field_name'][$i],
	                'field_id'=>$post['field_id'][$i],
	                'type'=>5,
	                'section_id'=>9,
	                'p_mode_id'=>$post['payment_mode'],
	                'branch_id'=>$user_data['parent_id'],
	                'parent_id'=>$post['ipd_id'],
	                'ip_address'=>$_SERVER['REMOTE_ADDR']
	                );
	                $this->db->set('created_by',$user_data['id']);
	                $this->db->set('created_date',date('Y-m-d H:i:s'));
	                $this->db->insert('hms_payment_mode_field_value_acc_section',$data_field_value);

                }
                }

            /*add sales banlk detail*/
        }

		/* update booking table  */
		$this->db->select('hms_ipd_booking.discharge_bill_no,hms_ipd_booking.ipd_discharge_created_date');
        $this->db->from('hms_ipd_booking'); 
        $this->db->where('hms_ipd_booking.id',$post['ipd_id']);
        $this->db->where('hms_ipd_booking.is_deleted','0');
        $query = $this->db->get(); 
        $ipd_record =  $query->row_array();
        if(!empty($ipd_record['discharge_bill_no']))
        {
           $bill_no = $ipd_record['discharge_bill_no'];
           $ipd_discharge_created_date = $ipd_record['ipd_discharge_created_date'];
        }
		else
		{
			$bill_no = generate_unique_id(24);
			$ipd_discharge_created_date = date('Y-m-d H:i:s');
		}
		$update_data=array('discharge_status'=>1,'discharge_date'=>date('Y-m-d H:i:s',strtotime($post['discharge_date'])),'total_amount_dis_bill'=>$post['total_amount'],'discount_amount_dis_bill'=>$post['total_discount'],'advance_payment_dis_bill'=>$post['total_advance_discount'],'net_amount_dis_bill'=>str_replace(',', '', $post['total_net_amount']),'paid_amount_dis_bill'=>$post['total_paid_amount'],'refund_amount_dis_bill'=>str_replace(',', '', $post['total_refund_amount']),'balance_amount_dis_bill'=>$post['total_balance'],'discharge_bill_no'=>$bill_no,'discharge_payment_mode'=>$post['payment_mode'],'ipd_discharge_created_date'=>$ipd_discharge_created_date);
		$this->db->where(array('id'=>$post['ipd_id'],'patient_id'=>$post['patient_id']));
		$this->db->update('hms_ipd_booking',$update_data);
		//echo $this->db->last_query(); exit;
		/* update booking table  */


		 /*add sales banlk detail*/
		 $this->db->where(array('branch_id'=>$user_data['parent_id'],'parent_id'=>$post['ipd_id'],'type'=>9,'section_id'=>9));
		$this->db->delete('hms_payment_mode_field_value_acc_section');

			if(!empty($post['field_name']))
                {
                $post_field_value_name= $post['field_name'];
                $counter_name= count($post_field_value_name); 
                for($i=0;$i<$counter_name;$i++) 
                {
	                $data_field_value= array(
	                'field_value'=>$post['field_name'][$i],
	                'field_id'=>$post['field_id'][$i],
	                'type'=>9,
	                'section_id'=>9,
	                'p_mode_id'=>$post['payment_mode'],
	                'branch_id'=>$user_data['parent_id'],
	                'parent_id'=>$post['ipd_id'],
	                'ip_address'=>$_SERVER['REMOTE_ADDR']
	                );
	                $this->db->set('created_by',$user_data['id']);
	                $this->db->set('created_date',date('Y-m-d H:i:s'));
	                $this->db->insert('hms_payment_mode_field_value_acc_section',$data_field_value);

                }
                }

            /*add sales banlk detail*/

        /* update charge entry table  */
			$this->db->select('*');
			$this->db->from('hms_ipd_patient_to_charge');
			$this->db->where(array('ipd_id'=>$post['ipd_id'],'patient_id'=>$post['patient_id']));
			$result_room= $this->db->get()->result();

			//echo "<pre>"; print_r($result_room); exit;
			foreach($result_room as $rooms_transfer)
			{

			$registration_patient_charge_update = array(
			"branch_id"=>$user_data['parent_id'],
			'ipd_id'=>$post['ipd_id'],
			'patient_id'=>$post['patient_id'],
			'end_date'=>date('Y-m-d',strtotime($post['discharge_date'])),
			'particular'=>$rooms_transfer->particular,
			'particular_code'=>$rooms_transfer->particular_code,
			'price'=>$rooms_transfer->price,
			'panel_price'=>$rooms_transfer->panel_price,
			'net_price'=>$rooms_transfer->net_price,
			'status'=>1,
			'created_date'=>date('Y-m-d H:i:s')
			);
			$this->db->where('hms_ipd_patient_to_charge.end_date','0000-00-00 00:00:00');
			$this->db->where(array('id'=>$rooms_transfer->id));
			$this->db->update('hms_ipd_patient_to_charge',$registration_patient_charge_update);

			}
            /* update charge entry table  */

            
  }
  

  public function get_paid_amount($ipd_id="",$patient_id=""){
  	  $user_data = $this->session->userdata('auth_users');
  	  $this->db->select('*');
  	  $this->db->where(array('id'=>$ipd_id,'patient_id'=>$patient_id,'branch_id'=>$user_data['parent_id']));
  	  $query=$this->db->get('hms_ipd_booking')->result();
  	  return $query;
  }
   function template_format($data=""){
    	$users_data = $this->session->userdata('auth_users'); 
    	$this->db->select('hms_ipd_branch_discharge_bill_print_setting.*');
    	$this->db->where($data);
    	//$this->db->where('branch_id  IN ('.$users_data['parent_id'].')'); 
    	$this->db->from('hms_ipd_branch_discharge_bill_print_setting');
    	$query=$this->db->get()->row();
    	//print_r($query);exit;
    	return $query;

    }

    public function update_charge_data(){
    	$post= $this->input->post();
    	if(isset($post['net_price']))
    	{
    		$net_price= $post['net_price'];
    	}
    	else
    	{
    		$net_price=$post['qty_edit']*$post['price_edit'];

    	}
    	if(isset($post['qty_edit'])){
    		$quantity=$post['qty_edit'];
    	}
    	else
    	{
    		$quantity=1;
    	}
    	if(isset($post['price_edit']))
    	{
          $price= $post['price_edit'];
    	}
    	else
    	{
    	 $price	='';
    	}
    	 $update_row= array('price'=>$price,'net_price'=>$net_price,'quantity'=>$quantity);
    	 //print '<pre>'; print_r($update_row);die;
    	 $this->db->where('id',$post['data_id']);
    	 return $this->db->update('hms_ipd_patient_to_charge',$update_row);
    }
    public function ipd_ipd_detail_data($ipd_id="",$patient_id="")
    {
       $this->db->select('*');
       $this->db->where(array('id'=>$ipd_id,'patient_id'=>$patient_id));
       $result= $this->db->get('hms_ipd_booking')->result();
       return $result;
    }
	public function delete_charges($id="",$ipd_id="",$patient_id="")
	{
		if(!empty($id) && $id>0)
		{
		$user_data = $this->session->userdata('auth_users');
		$this->db->set('is_deleted',1);
		$this->db->set('deleted_by',$user_data['id']);
		$this->db->set('deleted_date',date('Y-m-d H:i:s'));
		$this->db->where(array('id'=>$id));
		return $this->db->update('hms_ipd_patient_to_charge');
		//echo $this->db->last_query();die;
		} 
	}

	public function get_advance_payment_details($ipd_id="",$patient_id="")
	{
		   $users_data = $this->session->userdata('auth_users'); 
		   $this->db->select("hms_ipd_patient_to_charge.*,hms_ipd_booking.ipd_no,hms_ipd_booking.admission_date,hms_patient.patient_name,hms_ipd_patient_to_charge.patient_id,hms_patient.patient_name,hms_patient.patient_code");
			$this->db->where('hms_ipd_patient_to_charge.is_deleted','0');
			$this->db->where('hms_ipd_patient_to_charge.type','2');
			$this->db->where('hms_ipd_patient_to_charge.branch_id = "'.$users_data['parent_id'].'"');
			$this->db->join('hms_ipd_booking','hms_ipd_booking.id=hms_ipd_patient_to_charge.ipd_id','left');
			$this->db->where('hms_ipd_patient_to_charge.ipd_id',$ipd_id);
			$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
			// $this->db->join('hms_ipd_booking','hms_ipd_booking.patient_id=hms_ipd_patient_to_charge.patient_id','left');
			$this->db->join('hms_patient','hms_patient.id=hms_ipd_booking.patient_id','left');
			$result= $this->db->get('hms_ipd_patient_to_charge')->result();
			return $result;
	}

	public function save_advance_data()
	{
		    $post= $this->input->post();
		    $adavance_payment_date=$post['advance_payment_date'];
		 //print '<pre>';print_r($adavance_payment_date);die;
			//foreach($adavance_payment_date as $key=>$value){
                  // print_r($value['field_name']);
			//}
		   // die;

			$this->db->where('ipd_id',$post['ipd_id']);
			$this->db->where('type','2');
			$this->db->where('patient_id',$post['patient_id']);
			$users_data = $this->session->userdata('auth_users'); 
			$this->db->delete('hms_ipd_patient_to_charge',array('ipd_id'=>$post['ipd_id'],'patient_id'=>$post['patient_id'],'type'=>2));
			$this->db->where('parent_id',$post['ipd_id']);
			$this->db->where('section_id','5');
			$this->db->where('type','4');
			$this->db->where('patient_id',$post['patient_id']);
			$this->db->delete('hms_payment'); 
			
           //
         foreach($adavance_payment_date as $key=>$val)
           {
            
             
				 $data = array( 
							'branch_id'=>$users_data['parent_id'],
							'patient_id'=>$post['patient_id'],
							'ipd_id'=>$post['ipd_id'],
							'type'=>2,
							'particular'=>'Advance Payment',
							'payment_date'=>date('Y-m-d',strtotime($val['date'])),
							'start_date'=>date('Y-m-d',strtotime($val['date'])),
							'end_date'=>date('Y-m-d'),
							'quantity'=>1,
							'price'=>$val['net_price'],
							'panel_price'=>$val['net_price'],
							'net_price'=>$val['net_price'],
							'payment_mode'=>$val['payment_mode'],
							'created_date'=>date('Y-m-d',strtotime($val['date'])),
							'created_by'=>$users_data['id']
						 );

				 		$this->db->insert('hms_ipd_patient_to_charge',$data); 
				 		 $insert_id= $this->db->insert_id();
						$this->db->where(array('branch_id'=>$users_data['parent_id'],'parent_id'=>$key,'section_id'=>3,'type'=>10));
						$this->db->delete('hms_payment_mode_field_value_acc_section');

						
                       
							if(!empty($val['field_name']))
							{
								$post_field_value_name= $val['field_name'];
								$counter_name= count($post_field_value_name); 
								for($i=0;$i<$counter_name;$i++) 
								{
								$data_field_value= array(
								'field_value'=>$val['field_name'][$i],
								'field_id'=>$val['field_id'][$i],
								'section_id'=>3,
								'type'=>10,
								'p_mode_id'=>$val['payment_mode'],
								'branch_id'=>$users_data['parent_id'],
								'parent_id'=>$insert_id,
								'ip_address'=>$_SERVER['REMOTE_ADDR']
								);
								$this->db->set('created_by',$users_data['id']);
								$this->db->set('created_date',date('Y-m-d',strtotime($val['date'])));
								$this->db->insert('hms_payment_mode_field_value_acc_section',$data_field_value);
								//print '<pre>'; print_r($data_field_value);
								}
								
							}



		/*add sales banlk detail*/	
						
					
						$payment_data = array(
											'parent_id'=>$post['ipd_id'],
											'branch_id'=>$users_data['parent_id'],
											'section_id'=>'5',  //'section_id'=>'3',
											'patient_id'=>$post['patient_id'],
											'credit'=>'',
											'debit'=>$val['net_price'],
											'type'=>4,
											'pay_mode'=>$val['payment_mode'],
											//'bank_name'=>$bank_name,
											//'card_no'=>$transaction_no,
											//'cheque_no'=>$cheque_no,
											//'cheque_date'=>$cheque_date,
											//'transection_no'=>$transaction_no,
											'created_date'=>date('Y-m-d',strtotime($val['date'])),
											'created_by'=>$users_data['id']
					);

				        $this->db->insert('hms_payment',$payment_data);	
				        $this->db->where(array('branch_id'=>$users_data['parent_id'],'parent_id'=>$post['data_id'],'section_id'=>5,'type'=>10));
						$this->db->delete('hms_payment_mode_field_value_acc_section');
                        if(!empty($val['field_name']))
							{
							$post_field_value_name= $val['field_name'];
							$counter_name= count($post_field_value_name); 
							for($i=0;$i<$counter_name;$i++) 
							{
							$data_field_value= array(
							'field_value'=>$val['field_name'][$i],
							'field_id'=>$val['field_name'][$i],
							'section_id'=>5,
							'type'=>10,
							'p_mode_id'=>$val['payment_mode'],
							'branch_id'=>$users_data['parent_id'],
							'parent_id'=>$insert_id,
							'ip_address'=>$_SERVER['REMOTE_ADDR']
							);
							$this->db->set('created_by',$users_data['id']);
							$this->db->set('created_date',date('Y-m-d H:i:s'));
							$this->db->insert('hms_payment_mode_field_value_acc_section',$data_field_value);

							}
						}
				

				}
	}


/* Summarized Bill */
  public  function get_discharge_bill_info_according_to_group_datatables($book_id="0",$patient_id="0")
    {

		$users_data = $this->session->userdata('auth_users');
		$res=array();
		$data=array();
		$this->load->model('general/general_model');
		$get_group_name= array('Room & Nursing Charges','ICU Charges','OT Charges','Medicine and Consumables','Professional fees','Investigation Charges','Ambulance Charges','Miscellaneous Charges','Package Charges');
		$get_group_code= array('100000','200000','300000','400000','500000','600000','700000','800000','900000');

		$net_p_price='';
		$net_price_p_all='';
		$details_arr = [];

		 foreach($get_group_code as $group_code)
		 {

		 	//echo "<pre>";print_r($group_name);die;
		 	    //Registration Charge
		 		if($group_code==500000)
		 		{
		 			$group_name='Professional fees';
					$this->db->select("sum(hms_ipd_patient_to_charge.net_price) as net_price");
					//UNIX_TIMESTAMP
					$this->db->from('hms_ipd_patient_to_charge');

					$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
					//$this->db->where('hms_ipd_patient_to_charge.type IN (1)');
					$this->db->where('hms_ipd_patient_to_charge.group_code IN (500000)');
					$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
					$this->db->where('hms_ipd_patient_to_charge.is_deleted',0);
					$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
					//$this->db->group_by('hms_ipd_patient_to_charge.start_date');
					$res_reg_charge= $this->db->get()->result(); 
					if(!empty($res_reg_charge) && $res_reg_charge[0]->net_price!='')
					{
						$res['net_price']=$res_reg_charge[0]->net_price;
						$res['group_name']=$group_name;
						$res['group_code']=$group_code;
						$details_arr[] = $res;
					}
					

				}
		 		 //Registration Charge

				// room charge 

				else if($group_code==600000)
		 		{
		 			$group_name='Investigation Charges';
					$this->db->select("sum(hms_ipd_patient_to_charge.net_price) as net_price");
					//UNIX_TIMESTAMP
					$this->db->from('hms_ipd_patient_to_charge');

					$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
					//$this->db->where('hms_ipd_patient_to_charge.type IN (3)');
					$this->db->where('hms_ipd_patient_to_charge.group_code IN (600000)');
					$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
					$this->db->where('hms_ipd_patient_to_charge.is_deleted',0);
					$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
					//$this->db->group_by('hms_ipd_patient_to_charge.start_date');
					$res_room= $this->db->get()->result();
					$net_price=0;
					if(!empty($res_room) && $res_room[0]->net_price!='')
					{
						$res['net_price']=$res_room[0]->net_price;
						$res['group_name']=$group_name;
						$res['group_code']=$group_code;
						$details_arr[] = $res;
					} 

					//print '<pre>'; print_r($data);
				}
				//room charge 

				
				// particular code //
					
		 	 // particular code //

		 	 // particular all code //
		 

		 	/* adavance payment */

		 		else if($group_code==800000)
		 		{
		 			$group_name='Miscellaneous Charges';
					$this->db->select("sum(hms_ipd_patient_to_charge.net_price) as net_price");
					//UNIX_TIMESTAMP
					$this->db->from('hms_ipd_patient_to_charge');

					$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
					//$this->db->where('hms_ipd_patient_to_charge.type IN (2)');
					$this->db->where('hms_ipd_patient_to_charge.group_code IN (800000)');
					$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
					$this->db->where('hms_ipd_patient_to_charge.is_deleted',0);
					$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
					//$this->db->group_by('hms_ipd_patient_to_charge.start_date');
					$advance_payment= $this->db->get()->result();
					$net_price=0;
					if(!empty($advance_payment) && $advance_payment[0]->net_price!='')
					{
						$res['net_price']=$advance_payment[0]->net_price;
						$res['group_name']=$group_name;
						$res['group_code']=$group_code;
						$details_arr[] = $res;
					} 

				 }
 
		 	 /* advance payment */

		 	 /* ot management */

		 		else if($group_code==300000)
		 		{
					/* $this->db->select("sum(hms_ipd_patient_to_charge.net_price) as net_price");
					//UNIX_TIMESTAMP
					$this->db->from('hms_ipd_patient_to_charge');

					$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
					$this->db->where('hms_ipd_patient_to_charge.type IN (6)');
					$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
					$this->db->where('hms_ipd_patient_to_charge.ot_operation_id!=""');
					$this->db->where('hms_ipd_patient_to_charge.is_deleted',0);
					$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
					//$this->db->group_by('hms_ipd_patient_to_charge.start_date');
					$ot_mgt= $this->db->get()->result();
					$net_price=0;
					if(!empty($ot_mgt) && $ot_mgt[0]->net_price!='')
					{
						$res['net_price']=$ot_mgt[0]->net_price;
						$res['group_name']=$group_name->group_name;
						$res['group_code']=$group_name->group_code;
						$details_arr[] = $res;
					}*/
					
					$this->db->select("sum(hms_ipd_patient_to_charge.net_price) as net_price,hms_operation_booking.operation_name as operation_id,hms_operation_booking.package_id,(CASE WHEN hms_operation_booking.op_type =1 THEN hms_ot_management.name WHEN  hms_operation_booking.op_type=2 THEN hms_ot_pacakge.name END) as group_new_name");
                    //UNIX_TIMESTAMP
                    $this->db->from('hms_ipd_patient_to_charge');
                        $this->db->join('hms_operation_booking','hms_operation_booking.id=hms_ipd_patient_to_charge.ot_id','left');
                    $this->db->join('hms_ot_pacakge','hms_ot_pacakge.id=hms_operation_booking.package_id','left');
                    $this->db->join('hms_ot_management','hms_ot_management.id=hms_operation_booking.operation_name','left');

                    $this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
                    //$this->db->where('hms_ipd_patient_to_charge.type IN (6)');
                    $this->db->where('hms_ipd_patient_to_charge.group_code IN (500000)');
                    $this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
                    $this->db->where('hms_ipd_patient_to_charge.ot_id!=""');
                    $this->db->where('hms_ipd_patient_to_charge.is_deleted',0);
                    $this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
                    //$this->db->group_by('hms_ipd_patient_to_charge.start_date');
                    $ot_mgt= $this->db->get()->result();
                    //print_r($ot_mgt);
                    //echo $this->db->last_query();die;
                    $net_price=0;
                    if(!empty($ot_mgt) && $ot_mgt[0]->net_price!='')
                    {
                        $res['net_price']=$ot_mgt[0]->net_price;
                        $res['group_name']=$ot_mgt[0]->group_name;
                        $res['group_code']=$group_code;
                        $details_arr[] = $res;

                    }
				 }
 
		  /* ot management */

		   /* pathalogy */

		 		else if($group_code==100000)
		 		{
		 			$group_name='Room & Nursing Charges';

		 			$this->db->select("sum(hms_ipd_patient_to_charge.net_price) as net_price");
					//UNIX_TIMESTAMP
					$this->db->from('hms_ipd_patient_to_charge');

					$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
					//$this->db->where('hms_ipd_patient_to_charge.type IN (3)');
					$this->db->where('hms_ipd_patient_to_charge.group_code IN (100000)');
					$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
					$this->db->where('hms_ipd_patient_to_charge.is_deleted',0);
					$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
					//$this->db->group_by('hms_ipd_patient_to_charge.start_date');
					$pathlogy= $this->db->get()->result();
					$net_price=0;

					if(!empty($pathlogy) && $pathlogy[0]->net_price!='')
					{
						$res['net_price']=$pathlogy[0]->net_price;
						$res['group_name']=$group_name;
						$res['group_code']=$group_code;
						$details_arr[] = $res;
					} 

					//print '<pre>'; print_r($data);
				 }
 
		  	/* pathalogy */

		  	/* medicine sale */
		  	else if($group_code==200000)
		 		{
		 			$group_name='ICU Charges';
					$this->db->select("sum(hms_ipd_patient_to_charge.net_price) as net_price");
					//UNIX_TIMESTAMP
					$this->db->from('hms_ipd_patient_to_charge');

					$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
					//$this->db->where('hms_ipd_patient_to_charge.type IN (8)');
					$this->db->where('hms_ipd_patient_to_charge.group_code IN (200000)');
					$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
					$this->db->where('hms_ipd_patient_to_charge.is_deleted',0);
					$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
					//$this->db->group_by('hms_ipd_patient_to_charge.start_date');
					$medicine= $this->db->get()->result();
					$net_price=0;

					if(!empty($medicine) && $medicine[0]->net_price!='')
					{
						$res['net_price']=$medicine[0]->net_price;
						$res['group_name']=$group_name;
						$res['group_code']=$group_code;
						$details_arr[] = $res;
					} 

				 }

		  /* medicine sale */

		  /* Package */
		  	else if($group_code==700000)
		 		{
		 			$group_name='Ambulance Charges';
					$this->db->select("sum(hms_ipd_patient_to_charge.net_price) as net_price");
					//UNIX_TIMESTAMP
					$this->db->from('hms_ipd_patient_to_charge');

					$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
					//$this->db->where('hms_ipd_patient_to_charge.type IN (4)');
					$this->db->where('hms_ipd_patient_to_charge.group_code IN (700000)');
					$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
					$this->db->where('hms_ipd_patient_to_charge.is_deleted',0);
					$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
					//$this->db->group_by('hms_ipd_patient_to_charge.start_date');
					$package= $this->db->get()->result();
					//echo $this->db->last_query();die;
					$net_price=0;

					if(!empty($package) && $package[0]->net_price!='')
					{
						$res['net_price']=$package[0]->net_price;
						$res['group_name']=$group_name;
						$res['group_code']=$group_code;
						$details_arr[] = $res;
					} 

				}

		  /* Package */


		   /* ot pack management */

		 		else if($group_code==900000)
		 		{
		 			$group_name='Package Charges';
					$this->db->select("sum(hms_ipd_patient_to_charge.net_price) as net_price");
					//UNIX_TIMESTAMP
					$this->db->from('hms_ipd_patient_to_charge');

					$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
					//$this->db->where('hms_ipd_patient_to_charge.type IN (6)');
					$this->db->where('hms_ipd_patient_to_charge.group_code IN (900000)');
					$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
					//$this->db->where('hms_ipd_patient_to_charge.ot_package_id!=""');
					$this->db->where('hms_ipd_patient_to_charge.is_deleted',0);
					$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
					//$this->db->group_by('hms_ipd_patient_to_charge.start_date');
					$ot_pack= $this->db->get()->result();
					$net_price=0;
					if(!empty($ot_pack) && $ot_pack[0]->net_price!='')
					{
						$res['net_price']=$ot_pack[0]->net_price;
						$res['group_name']=$group_name;
						$res['group_code']=$group_code;
						$details_arr[] = $res;
					} 
					//print '<pre>'; print_r($details_arr);die;
				 }
 
		  /* ot pack management */

		 }
		return $details_arr;
			
		
    }

public function get_other_charges($book_id="0",$patient_id="0")
{
	$users_data = $this->session->userdata('auth_users');
		$this->db->select('hms_ipd_patient_to_charge.particular,hms_ipd_patient_to_charge.net_price');
		//UNIX_TIMESTAMP
		$this->db->from('hms_ipd_patient_to_charge');

		$this->db->where('hms_ipd_patient_to_charge.branch_id',$users_data['parent_id']);
		$this->db->where('hms_ipd_patient_to_charge.type IN (1)');
		$this->db->where('hms_ipd_patient_to_charge.group_code',NULL);
		$this->db->where('hms_ipd_patient_to_charge.ipd_id',$book_id);
		//$this->db->where('hms_ipd_patient_to_charge.ot_package_id!=""');
		$this->db->where('hms_ipd_patient_to_charge.is_deleted',0);
		$this->db->where('hms_ipd_patient_to_charge.patient_id',$patient_id);
		$other_charges= $this->db->get()->result_array();

		return $other_charges;
		//echo $this->db->last_query();die;


}


/* Summarized Bill */

} 
?>