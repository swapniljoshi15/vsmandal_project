<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Online_order_model extends CI_Model{

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

		$this->tableName  	= 'online_orders';
		$this->tableNamePacketInfo  	= 'onlineorder_packetinfo';

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

	public function addOnlineOrder($data = array(),$packet_data = array()){
		$this->db->trans_begin();
		$this->db->insert($this->tableName, $data);
		$id = $this->db->insert_id();
		//return (isset($id)) ? $id : FALSE;
		if(isset($id)){
			//now add entry for packetinfo
			foreach($packet_data as $pdata){
				$pdata['online_order_id'] = $id;
				$pid = $this->db->insert($this->tableNamePacketInfo, $pdata);
				if(!isset($pid)){
					$this->db->trans_rollback();
					$this->set_error('online_order_add_unsuccessful');
					return FALSE;
				}
			}
			$this->db->trans_commit();
			$this->set_message('online_order_add_successful');
			return TRUE;
		}else{
			$this->db->trans_rollback();
			$this->set_error('online_order_add_unsuccessful');
			return FALSE;
		}
	}

	public function editOnlineOrder($id,$data = array(),$packet_data = array()){
		$this->db->trans_begin();
		$updateResult = $this->db->update($this->tableName, $data, array('orderid' =>$id));
		//return (isset($id)) ? $id : FALSE;
		if($updateResult){
			//now add entry for packetinfo
			foreach($packet_data as $pdata){
				$pupdate = $this->db->update($this->tableNamePacketInfo, $pdata, array('online_order_id' =>$id,'packet_id'=>$pdata['packet_id']));
				if(!$pupdate){
					$this->db->trans_rollback();
					$this->set_error('online_order_edit_unsuccessful');
					return FALSE;
				}
			}
			$this->db->trans_commit();
			$this->set_message('online_order_edit_successful');
			return TRUE;
		}else{
			$this->db->trans_rollback();
			$this->set_error('online_order_edit_unsuccessful');
			return FALSE;
		}
	}

	public function getOrders(){
		return $this->response = $this->db->get($this->tableName)->result();
	}

	public function getOrder($id){
		if (empty($id))
		{
			$this->set_error('online_order_fetch_unsuccessful');
			return FALSE;
		}
		$this->db->where('orderid', $id);
		return $this->response = $this->db->get($this->tableName)->result();
	}

	public function getOrderPackets($id){
		if (empty($id))
		{
			$this->set_error('online_order_fetch_unsuccessful');
			return FALSE;
		}
		$this->db->where('online_order_id', $id);
		return $this->response = $this->db->get($this->tableNamePacketInfo)->result();
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