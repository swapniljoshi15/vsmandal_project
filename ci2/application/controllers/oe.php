<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Oe extends CI_Controller {

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
		$this->load->model('other_expenses_model');
		$this->load->model('ion_auth_model');
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
		redirect('oe/otherExpensesLanding', 'refresh');
	}

	function otherExpensesLanding(){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('otherExpensesLanding', $_POST);
		if(!$this->ion_auth->validate_function_access('otherExpensesLanding'))
			$this->ion_auth->logout();
		
		//fetch all raw material data here
		$otherExpenses = $this->other_expenses_model->getOtherExpenses();
		foreach($otherExpenses as $otherExpense){
			if($otherExpense->oaddedby > 0){
				$usersAdded = $this->ion_auth_model->user($otherExpense->oaddedby)->row();
				if(!count($usersAdded)>0)
					return NULL;
				$otherExpense->oaddedby = $usersAdded->username."(".$usersAdded->first_name." ".$usersAdded->last_name.")";
			}
			if($otherExpense->oeditedby > 0){
				$usersEdited = $this->ion_auth_model->user($otherExpense->oeditedby)->row();
				if(!count($usersEdited)>0)
					return NULL;
				$otherExpense->oeditedby = $usersEdited->username."(".$usersEdited->first_name." ".$usersEdited->last_name.")";
			}
			else{
				$otherExpense->oeditedby = "";
				$otherExpense->oeditedate = "";
			}
		}

		$this->data['otherExpenses'] = $otherExpenses;
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->_render_page($this->getUserGroupName().'/otherExpensesLanding', $this->data);
	}

	function addOtherExpenses(){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('addOtherExpenses', $_POST);
		if(!$this->ion_auth->validate_function_access('addOtherExpenses'))
			$this->ion_auth->logout();
		
		//validate form input
		$this->form_validation->set_rules('odesc', 'Expense Description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('oamnt', 'Expense Amount', 'trim|required|xss_clean');
		if($this->form_validation->run() == true){
			$date = date('Y-m-d H:i:s');
			$table_data = array(
					'odescription' => $this->input->post('odesc'),
					'oamount'  => $this->input->post('oamnt'),
					'oaddedby'    => $this->ion_auth->get_user_id(),
					'oaddeddate'      => $date,
					'ostatus'      => '1',
			);
			$this->other_expenses_model->addOtherExpenses($table_data);
			$this->session->set_flashdata('message', $this->other_expenses_model->messages());
			redirect("oe/otherExpensesLanding", 'refresh');

		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page($this->getUserGroupName().'/addOtherExpenses', $this->data);
		}
	}

	function editOtherExpenses($id){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('editOtherExpenses', $_POST);
		if(!$this->ion_auth->validate_function_access('editOtherExpenses'))
			$this->ion_auth->logout();
		
		//validate form input
		$this->form_validation->set_rules('odesc', 'Expense Description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('oamnt', 'Expense Amount', 'trim|required|xss_clean');
		if($this->form_validation->run() == true){
			$date = date('Y-m-d H:i:s');
			$table_data = array(
					'odescription' => $this->input->post('odesc'),
					'oamount'  => $this->input->post('oamnt'),
					'oeditedby'    => $this->ion_auth->get_user_id(),
					'oeditedate'      => $date,
					'ostatus'      => '1',
			);
			$this->other_expenses_model->editOtherExpenses($id,$table_data);
			$this->session->set_flashdata('message', $this->other_expenses_model->messages());
			redirect("oe/otherExpensesLanding", 'refresh');

		}else{
			$expenses = $this->other_expenses_model->getOtherExpense($id);
			if(count($expenses)>0)
				$expenses = $expenses[0];
			$this->data['expenses'] = $expenses;
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page($this->getUserGroupName().'/editOtherExpenses', $this->data);
		}
	}

	function removeOtherExpenses($id){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('removeOtherExpenses', $_POST);
		if(!$this->ion_auth->validate_function_access('removeOtherExpenses'))
			$this->ion_auth->logout();
		
		//validate form input
		$this->form_validation->set_rules('confirm', 'Cofirm', 'trim|required|xss_clean');
		if($this->form_validation->run() == true){
			$date = date('Y-m-d H:i:s');
			$table_data = array(
					'ostatus'      => '0',
			);
			$this->other_expenses_model->editOtherExpenses($id,$table_data);
			$this->session->set_flashdata('message', $this->other_expenses_model->messages());
			redirect("oe/otherExpensesLanding", 'refresh');

		}else{
			$expenses = $this->other_expenses_model->getOtherExpense($id);
			if(count($expenses)>0)
				$expenses = $expenses[0];
			$this->data['expenses'] = $expenses;
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page($this->getUserGroupName().'/removeOtherExpenses', $this->data);
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