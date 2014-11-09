<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Batch_model extends CI_Model{

	protected $messages;
	protected $errors;
	private $tableName;
	private $rmtableName;
	private $tableNamePacketBatch;

	protected $error_start_delimiter;
	protected $error_end_delimiter;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->config('ion_auth', TRUE);
		$this->load->helper('cookie');
		$this->load->helper('date');
		$this->lang->load('ion_auth');
		$this->load->model('raw_material_model');
		$this->load->model('packet_mgmt_model');

		$this->tableName  	= 'batch';
		$this->rmtableName  	= 'batch_rawmaterial';
		$this->tableNamePacketBatch  	= 'packets_batch';
		

		//initialize messages and error
		$this->messages    = array();
		$this->errors      = array();
		$delimiters_source = $this->config->item('delimiters_source', 'ion_auth');

		//load the error delimeters either from the config file or use what's been supplied to form validation
		if ($delimiters_source === 'form_validation')
		{
			//load in delimiters from form_validation
			//to keep this simple we'll load the value using reflection since these properties are protected
			$this->load->library('form_validation');
			$form_validation_class = new ReflectionClass("CI_Form_validation");

			$error_prefix = $form_validation_class->getProperty("_error_prefix");
			$error_prefix->setAccessible(TRUE);
			$this->error_start_delimiter = $error_prefix->getValue($this->form_validation);
			$this->message_start_delimiter = $this->error_start_delimiter;

			$error_suffix = $form_validation_class->getProperty("_error_suffix");
			$error_suffix->setAccessible(TRUE);
			$this->error_end_delimiter = $error_suffix->getValue($this->form_validation);
			$this->message_end_delimiter = $this->error_end_delimiter;
		}
		else
		{
			//use delimiters from config
			$this->message_start_delimiter = $this->config->item('message_start_delimiter', 'ion_auth');
			$this->message_end_delimiter   = $this->config->item('message_end_delimiter', 'ion_auth');
			$this->error_start_delimiter   = $this->config->item('error_start_delimiter', 'ion_auth');
			$this->error_end_delimiter     = $this->config->item('error_end_delimiter', 'ion_auth');
		}
	}

	function createNewBatch($batchdata = array(),$rmdata = array(),$material_update = array(),$packet_data = array()){
		$this->db->trans_begin();
		$this->db->insert($this->tableName, $batchdata);
		$id = $this->db->insert_id();
		$counter = 0;
		if(isset($id)){
			foreach($rmdata as $data){
				$data['batchid'] = $id;
				$this->db->insert($this->rmtableName, $data);
				$rmid = $this->db->insert_id();
				//remove material from availability
				$this->raw_material_model->editRawMaterial($data['rawmaterialid'],$material_update[$counter]);
				$counter++;
			}
			foreach($packet_data as $data){
				$data['batchid'] = $id;
				$this->db->insert($this->tableNamePacketBatch, $data);
				$pmid = $this->db->insert_id();
			}
			$this->db->trans_commit();
			$this->set_message('batch_management_add_successful');
			return $id;
		}else{
			$this->db->trans_rollback();
			$this->set_error('batch_management_add_unsuccessful');
			return FALSE;
		}
	}

	function editBatch($id,$batchdata = array(),$rmdata = array(),$material_update = array(),$packetInputs = array()){
		$this->db->trans_begin();
		$updateResult = $this->db->update($this->tableName, $batchdata, array('id' =>$id));
		$counter = 0;
		if(isset($id) && $updateResult){
			foreach($rmdata as $data){
				$this->db->update($this->rmtableName, $data, array('batchid' =>$id,'rawmaterialid'=>$data['rawmaterialid']));
				//remove material from availability
				//$this->raw_material_model->editRawMaterial($counter+1,$material_update[$counter]);
                                $this->raw_material_model->editRawMaterial($data['rawmaterialid'],$material_update[$counter]);
				$counter++;
			}
			foreach($packetInputs as $packetInput){
				$this->db->update($this->tableNamePacketBatch, $packetInput, array('batchid' =>$id,'packetid'=>$packetInput['packetid']));
				//get packet for packet id
				$packet = $this->packet_mgmt_model->getPacket($packetInput['packetid']);
				if(count($packet)>0){
					$packetUpdatedCount = $packet[0]->instock + $this->input->post('packet'.$packetInput['packetid']);
				}
				//update packet instock
				$packetUpdatedData = array(
							'instock' => $packetUpdatedCount
				);
				$this->packet_mgmt_model->editPacket($packetInput['packetid'],$packetUpdatedData);
			}
			$this->db->trans_commit();
			$this->set_message('batch_management_edit_successful');
			return $id;
		}else{
			$this->db->trans_rollback();
			$this->set_error('batch_management_edit_unsuccessful');
			return FALSE;
		}
	}


        //newly added packets patch
	function enterNewlyAddedPacketsEntry($id){
		$this->db->trans_begin();
		//get all packet list
		$flag =false;
		$packets = $this->packet_mgmt_model->getPackets();
		//get all packets right now assosiated with batch
		$packetinfo = $this->packet_mgmt_model->getPacketInfo($id);
		foreach($packets as $packet){
			$flag = true;
			foreach($packetinfo as $pinfo){
				if($packet->packet_id == $pinfo->packetid){
					//do nothing
					$flag = false;
					break;
				}else{
					$flag = true;
				}
			}
			if($flag){
				//now insert new packet for particular batch in table packets_batch
				$data = array(
				'batchid' => $id,
				'packetid' => $packet->packet_id,
				'received' => 0,
				);
				$data['batchid'] = $id;
				$this->db->insert($this->tableNamePacketBatch, $data);
			}
		}
		$this->db->trans_commit();
	}

        //newly added raw material patch

	function enterNewlyAddedRawMaterialEntry($id){
		$this->db->trans_begin();
		//get all packet list
		$flag =false;
		$raw_materials = $this->raw_material_model->getRawMaterials();
		//get all packets right now assosiated with batch
		$raw_materials_info = $this->getRawMaterialForBatchId($id);
		foreach($raw_materials as $raw_material){
			$flag = true;
			foreach($raw_materials_info as $raw_material_info){
				if($raw_material->material_id == $raw_material_info->rawmaterialid){
					//do nothing
					$flag = false;
					break;
				}else{
					$flag = true;
				}
			}
			if($flag){
				//now insert new packet for particular batch in table packets_batch
				$data = array(
				'batchid' => $id,
				'rawmaterialid' => $raw_material->material_id,
				'rawmaterialname' => $raw_material->material_name,
				'rawmaterialquantity' => 0
				);
				$this->db->insert($this->rmtableName, $data);
			}
		}
		$this->db->trans_commit();
	}

	function getBatchList(){
		return $this->response = $this->db->get($this->tableName)->result();
	}

	function getBatch($id){
		if (empty($id))
		{
			$this->set_error('batch_management_fetch_unsuccessful');
			return FALSE;
		}
		$this->db->where('id', $id);
		return $this->response = $this->db->get($this->tableName)->result();
	}


	function getRawMaterialForBatchId($id){
		if (empty($id))
		{
			$this->set_error('batch_management_fetch_unsuccessful');
			return FALSE;
		}
		$this->db->where('batchid', $id);
		return $this->response = $this->db->get($this->rmtableName)->result();

	}

	public function set_message($message)
	{
		$this->messages[] = $message;

		return $message;
	}

	public function set_error($error)
	{
		$this->errors[] = $error;

		return $error;
	}

	public function messages()
	{
		$_output = '';
		foreach ($this->messages as $message)
		{
			$messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';
			$_output .= $this->message_start_delimiter . $messageLang . $this->message_end_delimiter;
		}

		return $_output;
	}
}