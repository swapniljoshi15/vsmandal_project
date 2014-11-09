<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bm extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('url');

		// Load MongoDB library instead of native db driver if required
		$this->config->item('use_mongodb', 'ion_auth') ?
		$this->load->library('mongo_db') :

		$this->load->database();

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->load->helper('language');
		$this->load->model('um_model');
		$this->load->model('raw_material_model');
		$this->load->model('batch_model');
		$this->load->model('ug_model');
		$this->load->model('packet_mgmt_model');
		$this->load->model('trasaction_logging_model');
	}

	function index()
	{
		//here use ACL
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		/*elseif (!$this->ion_auth->is_admin()) //remove this elseif if you want to enable this for non-admins
		 {
			//redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
			}*/
		else
		{
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			//open corresponding landing view from here ie user search view
			//$this->_render_page($this->getUserGroupName().'/rawMaterialLanding', $this->data);
			redirect('bm/batchLanding', 'refresh');
		}
	}

	function batchLanding(){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('batchLanding', $_POST);
		if(!$this->ion_auth->validate_function_access('batchLanding'))
			$this->ion_auth->logout();
		
		//fetch all raw material data here
		$batchList = $this->batch_model->getBatchList();
		$utanaGroups = array();
		foreach($batchList as $batch){
			$temp_utanaGroups = $this->ug_model->getUtanaGroup($batch->groupid);
			if(count($temp_utanaGroups)>0)
				$utanaGroups[$batch->groupid] = $temp_utanaGroups[0];
		}
		//open landing page and pass objects
		$this->data['batchList'] = $batchList;
		$this->data['utanaGroups'] = $utanaGroups;
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->_render_page($this->getUserGroupName().'/batchLanding', $this->data);
	}

	function createNewBatch(){
		//here use ACL
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		$this->trasaction_logging_model->addTransactionLog('createNewBatch', $_POST);
		if(!$this->ion_auth->validate_function_access('createNewBatch'))
			$this->ion_auth->logout();
		
		//validation
		//validate form input
		$rawMaterials = $this->raw_material_model->getRawMaterials();
		$utanaGroups = $this->ug_model->getUtanaGroups();
		$packets =  $this->packet_mgmt_model->getPackets();
		foreach($rawMaterials as $rawMaterial){
			//validate input
			$this->form_validation->set_rules($rawMaterial->material_id, $rawMaterial->material_name, 'trim|required|xss_clean');
		}
		$this->form_validation->set_rules('groupid', 'groupid', 'trim|required|xss_clean');
		if($this->form_validation->run() == true && $this->ug_model->groupIdCheck($this->input->post('groupid'))){
			$date = date('Y-m-d H:i:s');
			$batch_data = array(
					'groupid' => strtolower($this->input->post('groupid')),
					'creationdate'  => $date,
					'status'      => 'created',
					'createdby'      => $this->ion_auth->get_user_id()
			);
			$rm_data = array();
			$counter = 0;
			$material_update = array();
			foreach($rawMaterials as $rawMaterial){
				if($this->input->post($rawMaterial->material_id) >= 0 && $this->input->post($rawMaterial->material_id) <= $rawMaterial->material_quantity){
					$temp_data = array(
						'batchid' => '',
						'rawmaterialid' => $rawMaterial->material_id,
						'rawmaterialname' => $rawMaterial->material_name,
						'rawmaterialquantity' => $this->input->post($rawMaterial->material_id)
					);
					$rm_data[$counter] = $temp_data;
				}
				$postRawMaterial = $this->input->post($rawMaterial->material_id);
				$totalQuantity = $rawMaterial->material_quantity - $postRawMaterial;
				$material_update_temp = array(
					'material_quantity' => $totalQuantity,
				);
				$material_update[$counter] = $material_update_temp;
				$counter++;
			}
			$counter = 0;
			$packet_data = array();
			foreach($packets as $packet){
				$temp_packet_data = array(
						'batchid' => '',
						'packetid' => $packet->packet_id,
						'received' => 0,
				);
				$packet_data[$counter] = $temp_packet_data;
				$counter++;
			}
			$batch_id = $this->batch_model->createNewBatch($batch_data,$rm_data,$material_update,$packet_data);
			if($batch_id){
				$this->session->set_flashdata('message', $this->batch_model->messages());
				//$this->data['messages'] = "Batch Created";
				redirect("bm/batchLanding", 'refresh');
			}else{
				$this->session->set_flashdata('message', $this->batch_model->messages());
				//$this->data['messages'] = "Batch Not Created";
				redirect("bm/createNewBatch", 'refresh');
			}

		}else{
			$this->data['rawMaterials'] = $rawMaterials;
			$this->data['utana_groups'] = $utanaGroups;
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page($this->getUserGroupName().'/addBatch', $this->data);
		}
	}

	function editBatch($id){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('editBatch', $_POST);
		if(!$this->ion_auth->validate_function_access('editBatch'))
			$this->ion_auth->logout();
		
		//validation
		//validate form input
		$rawMaterials = $this->raw_material_model->getRawMaterials();
		$utanaGroups = $this->ug_model->getUtanaGroups();
		$packetInfo = $this->packet_mgmt_model->getPacketInfo($id);
		$packets = array();
		if(isset($id)){
			$counter = 0;
			foreach($packetInfo as $info){
				$packets[$counter] = $this->packet_mgmt_model->getPacket($info->packetid);
				$counter++;
			}
		}

		$batchUtanaGroup = NULL;
		/*if(sizeof($batchList)>0)
			$batchUtanaGroup = $this->ug_model->getUtanaGroup($batchList[0]->groupid);*/
		$batch = $this->batch_model->getBatch($id);
		if(sizeof($batch)>0)
		$batch = $batch[0];

		$batchRawMaterials = $this->batch_model->getRawMaterialForBatchId($id);
		foreach($rawMaterials as $rawMaterial){
			//validate input
			$this->form_validation->set_rules($rawMaterial->material_id, $rawMaterial->material_name, 'trim|required|xss_clean');
		}
		//packets
		foreach($packetInfo as $info){
			//validate input
			$this->form_validation->set_rules('packet'.$info->packetid, 'packet information', 'trim|required|xss_clean');
		}
		$this->form_validation->set_rules('groupid', 'groupid', 'trim|required|xss_clean');
		if(isset($packetsinput))
		$this->form_validation->set_rules('packetreceived', 'packetreceived', 'trim|required|xss_clean');
		$this->form_validation->set_rules('status', 'status', 'trim|required|xss_clean');
		if($this->form_validation->run() == true && $this->ug_model->groupIdCheck($this->input->post('groupid'))){
			$date = date('Y-m-d H:i:s');
			$batch_data = array(
					'groupid' => strtolower($this->input->post('groupid')),
					'status'      => strtolower($this->input->post('status')),
					'lastupdatedate'   => $date
			);
			$rm_data = array();
			$counter = 0;
			$material_update = array();
			foreach($rawMaterials as $rawMaterial){
				if($this->input->post($rawMaterial->material_id) >= -$batchRawMaterials[$counter]->rawmaterialquantity && $this->input->post($rawMaterial->material_id) <= $rawMaterial->material_quantity){
					$temp_data = array(
						'rawmaterialquantity' => $batchRawMaterials[$counter]->rawmaterialquantity + $this->input->post($rawMaterial->material_id),
						'rawmaterialid' => $rawMaterial->material_id
					);
					$rm_data[$counter] = $temp_data;
				}
				$postRawMaterial = $this->input->post($rawMaterial->material_id);
				$totalQuantity = $rawMaterial->material_quantity - $postRawMaterial;
				$material_update_temp = array(
					'material_quantity' => $totalQuantity,
				);
				$material_update[$counter] = $material_update_temp;
				$counter++;
			}
			//packets received update
			$packetInputs = array();
			$counter = 0;
			foreach($packetInfo as $info){
				//validate input
				$packetnos = $this->input->post('packet'.$info->packetid) + $info->received;
				$temp_packetInput = array(
					'packetid'   => $info->packetid,
					'received'   => $packetnos
				);
				$packetInputs[$counter] = $temp_packetInput;
				$counter++;
			}
			$batch_id = $this->batch_model->editBatch($id,$batch_data,$rm_data,$material_update,$packetInputs);

			if($batch_id){
				$this->session->set_flashdata('message', $this->batch_model->messages());
				//$this->data['messages'] = "Batch Created";
				redirect("bm/batchLanding", 'refresh');
			}else{
				$this->session->set_flashdata('message', $this->batch_model->messages());
				//$this->data['messages'] = "Batch Not Created";
				redirect("bm/editBatch", 'refresh');
			}

		}else{

                        //now here we take care of newly added packet :)
			$this->batch_model->enterNewlyAddedPacketsEntry($id);
                        //now here we take care of newly added raw material :)
			$this->batch_model->enterNewlyAddedRawMaterialEntry($id);
			//refresh varables
			$packetInfo = $this->packet_mgmt_model->getPacketInfo($id);
			$packets = $this->packet_mgmt_model->getPackets();
                        $batchRawMaterials = $this->batch_model->getRawMaterialForBatchId($id);
			//packets
			$counter = 0;
			foreach($packetInfo as $info){
				$packets[$counter] = $this->packet_mgmt_model->getPacket($info->packetid);
				$counter++;
			}

			$this->data['rawMaterials'] = $rawMaterials;
			$this->data['utana_groups'] = $utanaGroups;
			$this->data['batch'] = $batch;
			$this->data['packetInfo'] = $packetInfo;
			$this->data['packets'] = $packets;
			//$this->data['batchUtanaGroup'] = $batchUtanaGroup;
			$this->data['batchRawMaterials'] = $batchRawMaterials;
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page($this->getUserGroupName().'/editBatch', $this->data);
		}
	}

	function openRawMaterial($id){
		//here use ACL
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		$this->trasaction_logging_model->addTransactionLog('openRawMaterial', $_POST);
		if(!$this->ion_auth->validate_function_access('openRawMaterial'))
			$this->ion_auth->logout();
		
		if(isset($id)){
			$this->data['batchRawMaterials'] = $this->batch_model->getRawMaterialForBatchId($id);
			$this->data['rawMaterials'] = $this->raw_material_model->getRawMaterials();
			$this->data['batchId'] = $id;
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page($this->getUserGroupName().'/openRawMaterial', $this->data);
		}
	}

	public function packetReceived($batchId){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('packetReceived', $_POST);
		if(!$this->ion_auth->validate_function_access('packetReceived'))
			$this->ion_auth->logout();
		
		if(isset($batchId)){
			$packetInfo = $this->packet_mgmt_model->getPacketInfo($batchId);
			$packets = array();
			$counter = 0;
			foreach($packetInfo as $info){
				$packets[$counter] = $this->packet_mgmt_model->getPacket($info->packetid);
				$counter++;
			}
			$this->data['packetInfo'] = $packetInfo;
			$this->data['packets'] = $packets;
			$this->data['batchId'] = $batchId;
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page($this->getUserGroupName().'/openPacketInfo', $this->data);
		}
	}

	function _render_page($view, $data=null, $render=false)
	{

		$this->viewdata = (empty($data)) ? $this->data: $data;

		$view_html = $this->load->view($view, $this->viewdata, $render);

		if (!$render) return $view_html;
	}

	function getUserGroupName(){
		$user_id = $this->ion_auth->get_user_id();
		$user_groups = $this->ion_auth->get_users_groups($user_id)->result();
		if(count($user_groups)>0)
		return $user_groups[0]->name;
		else{
			redirect('auth/logout','refresh');
			return null;
		}
	}
}