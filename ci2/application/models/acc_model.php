<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acc_model extends CI_Model{

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

		$this->tableName  	= 'user_account';

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

	function updateAccount($userId){
		$this->load->model('packet_distribution_model');
		//get userid from packet distribution id
		//$userId = $this->packet_distribution_model->getUserId($id);

		//first calculate amount to update from packet distributions
		$packetDistributions = $this->packet_distribution_model->getPacketDistribution($userId);
		$amount = 0;
		foreach($packetDistributions as $packetDistribution){
			$amount = $amount + ($packetDistribution->noofpackets * $packetDistribution->amountofpacket);
		}
		//now update amount
		//check if entry exist or not if not create if yes update
		if($this->existUserEntry($userId)){
			$account = $this->acc_model->getUserAccount($userId);
			
			$accountamnt = $account->accamnt;
			$packetsamnt = $amount;
			if($accountamnt > $packetsamnt){
				$remainingamnt = 0;
				$accbalance = $accountamnt - $packetsamnt;
			}else{
				$remainingamnt = $packetsamnt - $accountamnt;
				$accbalance = 0;
			}
			$data = array(
			'accuserid' => $userId,
			'pkttotalamnt' => $amount,
			'remamnt'	=>	$remainingamnt,
			'accbaln'	=>	$accbalance
			);
			//update
			if($this->db->update($this->tableName, $data, array('accuserid' =>$userId)))
			return TRUE;
			else
			return FALSE;
		}else{
			//create new
			$data = array(
			'accuserid' => $userId,
			'pkttotalamnt' => $amount,
			'remamnt'	=>	$amount,
			'accbaln'	=>	0
			);
			$this->db->insert($this->tableName, $data);
			$id = $this->db->insert_id();
			if(isset($id)){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}

       function editAccount($userid,$amount,$flag){
		$this->db->trans_begin();
		$this->updateAccount($userid);
		$account = $this->acc_model->getUserAccount($userid);
		if($flag == 'received'){
			$accountamnt = $account->accamnt + $amount;
			$packetsamnt = $account->pkttotalamnt;
			if($accountamnt > $packetsamnt){
				$remainingamnt = 0;
				$accbalance = $accountamnt - $packetsamnt;
			}else{
				$remainingamnt = $packetsamnt - $accountamnt;
				$accbalance = 0;
			}
		}else if($flag == 'payback' && $account->remamnt<=0 && $amount<=$account->accbaln){
			$accountamnt = $account->accamnt - $amount;
			$packetsamnt = $account->pkttotalamnt;
			$remainingamnt = 0;
			$accbalance = $accountamnt - $packetsamnt;
		}else{
			//do nothing to account just throw error
			$this->set_message('account_management_update_unsuccessful');
			$this->db->trans_rollback();
			return FALSE;
		}
		$account_data = array(
			'accamnt'	=>	$accountamnt,
			'remamnt'	=>	$remainingamnt,
			'accbaln'	=>	$accbalance,
			'updatedby' => 	$this->ion_auth->get_user_id()
		);
		//update table entry for userid
		if($this->db->update($this->tableName, $account_data, array('accuserid' =>$userid))){
			$this->db->trans_commit();
			$this->set_message('account_management_update_successful');
			return TRUE;
		}else{
			$this->db->trans_rollback();
			$this->set_message('account_management_update_unsuccessful');
			return FALSE;
		}
	}

	function getUserAccount($userid){
		if (empty($userid))
		{
			$this->set_message('account_management_fetch_unsuccessful');
			return FALSE;
		}
		$this->db->where('accuserid', $userid);
		$result = $this->db->get($this->tableName)->result();
		if(count($result)>0){
			return $this->response = $result[0];
		}
		return FALSE;
	}

	function existUserEntry($userId){
		if (empty($userId))
		{
			$this->set_message('account_management_fetch_unsuccessful');
			return FALSE;
		}
		$this->db->where('accuserid', $userId);
		return $this->response = $this->db->get($this->tableName)->result();
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