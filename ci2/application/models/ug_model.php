<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ug_model extends CI_Model{

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

		$this->tableName  	= 'utana_groups';

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

	public function addUtanaGroup($data = array()){
		$this->db->trans_begin();
		$this->db->insert($this->tableName, $data);
		$id = $this->db->insert_id();
		//return (isset($id)) ? $id : FALSE;
		if(isset($id)){
			$this->db->trans_commit();
			$this->set_message('utana_group_management_add_successful');
			return TRUE;
		}else{
			$this->db->trans_rollback();
			$this->set_error('utana_group_management_add_unsuccessful');
			return FALSE;
		}
	}

	public function groupIdCheck($id){
		if (empty($id))
		{
			$this->set_error('utana_group_management_fetch_unsuccessful');
			return FALSE;
		}

		return $this->db->where('ug_id', $id)
		->count_all_results($this->tableName) > 0;
	}

	public function groupNameCheck($name){
		$name = strtolower($name);
		if (empty($name))
		{
			$this->set_error('utana_group_management_fetch_unsuccessful');
			return FALSE;
		}

		return $this->db->where('ug_name', $name)
		->count_all_results($this->tableName) > 0;
	}

	public function editUtanaGroup($id, $data = array()){

		if(isset($id) && $this->groupIdCheck($id)){
			$this->db->trans_begin();

			if($this->db->update($this->tableName, $data, array('ug_id' =>$id))){
				$this->db->trans_commit();
				$this->set_message('utana_group_management_edit_successful');
				return TRUE;
			}else{
				$this->db->trans_rollback();
				$this->set_error('utana_group_management_edit_unsuccessful');
				return FALSE;
			}

		}else{
			//return error here
			$this->db->trans_rollback();
			$this->set_error('utana_group_management_edit_unsuccessful');
			return FALSE;
		}
	}

	public function removeUtanaGroup($id){

		$this->db->trans_begin();
		$this->db->delete($this->tableName, array('ug_id' => $id));
		if ($this->db->affected_rows() == 0)
		{
			$this->set_error('utana_group_management_delete_unsuccessful');
			return FALSE;
		}
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->set_error('utana_group_management_delete_unsuccessful');
			return FALSE;
		}

		$this->db->trans_commit();

		$this->set_message('utana_group_management_delete_successful');
		return TRUE;

	}

	public function getUtanaGroups(){
		return $this->response = $this->db->get($this->tableName)->result();
	}

	public function getUtanaGroup($id){
		if (empty($id))
		{
			$this->set_error('utana_group_management_fetch_unsuccessful');
			return FALSE;
		}
		$this->db->where('ug_id', $id);
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