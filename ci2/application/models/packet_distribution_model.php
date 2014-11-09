<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Packet_distribution_model extends CI_Model{

	protected $messages;
	protected $errors;
	private $tableName;

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
		$this->load->model('packet_mgmt_model');
		$this->load->model('acc_model');


		$this->tableName  	= 'packet_distribution';

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

	public function addPacketDistribution($userid,$data = array()){
		$this->db->trans_begin();
		$this->db->insert($this->tableName, $data);
		$id = $this->db->insert_id();
		//return (isset($id)) ? $id : FALSE;
		if(isset($id)){
			//update total no of packets in packet tabel (instock)
			$instock = $this->packet_mgmt_model->getPacket($data['packetid']);
			if(count($instock)){
				$instock = $instock[0]->instock;
			}
			$updateInstock = $instock - $data['noofpackets'];
			if($updateInstock >= 0){
				$packet_table_data = array(
				'instock' => $updateInstock
				);
				$this->packet_mgmt_model->editPacket($data['packetid'],$packet_table_data);
			}else{
				$this->db->trans_rollback();
				$this->set_message('distribution_batch_insufficient_packets');
				return FALSE;
			}

			if($this->acc_model->updateAccount($userid))
				$this->db->trans_commit();
			else
				$this->db->trans_rollback();
			$this->set_message('distribution_batch_add_successful');
			return TRUE;
		}else{
			$this->db->trans_rollback();
			$this->set_message('distribution_batch_add_unsuccessful');
			return FALSE;
		}
	}

	public function editPacketDistribution($userid,$id, $data = array(),$flag){

		if(isset($id)){
			$this->db->trans_begin();

			if($this->db->update($this->tableName, $data, array('id' =>$id))){
				if(isset($data['noofpackets'])){
					//update total no of packets in packet tabel (instock)
					$instock = $this->packet_mgmt_model->getPacket($data['packetid']);
					if(count($instock)>0){
						$instock = $instock[0]->instock;
					}
					if($flag=='return')
					$updateInstock = $instock + $this->input->post('noofpacket');
					else
					$updateInstock = $instock - $this->input->post('noofpacket');
					if($updateInstock >= 0){
						$packet_table_data = array(
							'instock' => $updateInstock
						);
						$this->packet_mgmt_model->editPacket($data['packetid'],$packet_table_data);
					}else{
						$this->db->trans_rollback();
						if($flag=='return')
							$this->set_message('distribution_batch_insufficient_packets');
						else
							$this->set_message('distribution_batch_insufficient_packets');
					}
				}
				if($this->acc_model->updateAccount($userid))
					$this->db->trans_commit();
				else
					$this->db->trans_rollback();
				if($flag=='return')
					$this->set_message('distribution_batch_return_packet_successful');
				else
					$this->set_message('distribution_batch_add_packet_successful');
				return TRUE;
			}else{
				$this->db->trans_rollback();
				if($flag=='return')
					$this->set_message('distribution_batch_return_packet_unsuccessful');
				else
					$this->set_message('distribution_batch_add_packet_unsuccessful');
				return FALSE;
			}

		}else{
			//return error here
			//$this->set_message('update_successful');
			$this->db->trans_rollback();
			if($flag=='return')
				$this->set_message('distribution_batch_return_packet_unsuccessful');
			else
				$this->set_message('distribution_batch_add_packet_unsuccessful');
			return FALSE;
		}
	}

	public function removePacketDistribution($id){

		$this->db->trans_begin();
		$this->db->delete($this->tableName, array('id' => $id));
		if ($this->db->affected_rows() == 0)
		{
			return FALSE;
		}
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->set_message('delete_unsuccessful');
			return FALSE;
		}

		if($this->acc_model->updateAccount($id))
			$this->db->trans_commit();
		else 
			$this->db->trans_rollback();

		$this->set_message('delete_successful');
		return TRUE;

	}

	public function getPacketDistribution($userid){
		if (empty($userid))
		{
			$this->set_message('distribution_batch_fetch_unsuccessful');
			return FALSE;
		}
		$this->db->where('userid', $userid);
		return $this->response = $this->db->get($this->tableName)->result();
	}

	public function getPacketDistributionForId($id){
		if (empty($id))
		{
			$this->set_message('distribution_batch_fetch_unsuccessful');
			return FALSE;
		}
		$this->db->where('id', $id);
		return $this->response = $this->db->get($this->tableName)->result();
	}

	public function getUserId($id){
		if (empty($id))
		{
			$this->set_message('distribution_batch_fetch_unsuccessful');
			return FALSE;
		}
		$this->db->where('id', $id);
		$dist = $this->db->get($this->tableName)->result();
		if(count($dist)>0){
			return $dist[0]->userid;
		}else{
			return FALSE;
		}
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