<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Am extends CI_Controller {

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
		$this->load->model('acc_model');
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
	}

	function accountManagement(){
		//here use ACL
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		$this->trasaction_logging_model->addTransactionLog('accountManagement', $_POST);
		if(!$this->ion_auth->validate_function_access('accountManagement'))
			$this->ion_auth->logout();
		//validate form input
		$this->form_validation->set_rules('userid', 'userid', 'trim|required|xss_clean');
		if($this->form_validation->run() == true){
			$this->data['message'] = '';
			$this->data['userid'] = $this->input->post('userid');
			$this->_render_page($this->getUserGroupName().'/accountManagement', $this->data);
		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			redirect('um/userProfile/'.$this->data['userid'], 'refresh');
		}
	}

	function receiveAmount($userid){
		//here use ACL
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		$this->trasaction_logging_model->addTransactionLog('receiveAmount', $_POST);
		if(!$this->ion_auth->validate_function_access('receiveAmount'))
			$this->ion_auth->logout();
			
		$user = $this->um_model->getUser($userid);
		//validate form input
		$this->form_validation->set_rules('amount', 'amount', 'trim|required|matches[ramount]|xss_clean');
		$this->form_validation->set_rules('ramount', 'amount', 'trim|required|xss_clean');
               
		if($this->form_validation->run() == true){
                        
			$this->acc_model->editAccount($userid,$this->input->post('amount'),'received');
			$this->session->set_flashdata('message', $this->acc_model->messages());
			redirect('um/userProfile/'.$userid, 'refresh');
		}else{
			//get user
			$this->data['user'] = $user;
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page($this->getUserGroupName().'/receiveAmount', $this->data);
		}
	}

	function paybackAmount($userid){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('paybackAmount', $_POST);
		if(!$this->ion_auth->validate_function_access('paybackAmount'))
			$this->ion_auth->logout();
		
		$user = $this->um_model->getUser($userid);
		//validate form input
		$this->form_validation->set_rules('amount', 'amount', 'trim|required|matches[ramount]|xss_clean');
		$this->form_validation->set_rules('ramount', 'amount', 'trim|required|xss_clean');
		if($this->form_validation->run() == true){
			$this->acc_model->editAccount($userid,$this->input->post('amount'),'payback');
			$this->session->set_flashdata('message', $this->acc_model->messages());
			redirect('um/userProfile/'.$userid, 'refresh');
		}else{
			//get user
			$this->data['user'] = $user;
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page($this->getUserGroupName().'/paybackAmount', $this->data);
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