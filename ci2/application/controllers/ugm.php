<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ugm extends CI_Controller {

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
		$this->load->model('ug_model');
		$this->load->model('batch_model');
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
			redirect('ugm/ugmLanding', 'refresh');
		}
	}

	function ugmLanding(){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('ugmLanding', $_POST);
		if(!$this->ion_auth->validate_function_access('ugmLanding'))
			$this->ion_auth->logout();
		
		//fetch all raw material data here
		$utanaGroups = $this->ug_model->getUtanaGroups();
		//open landing page and pass objects
		$this->data['utanaGroups'] = $utanaGroups;
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->_render_page($this->getUserGroupName().'/utanaGroupLanding', $this->data);
	}

	function addUtanaGroup(){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('addUtanaGroup', $_POST);
		if(!$this->ion_auth->validate_function_access('addUtanaGroup'))
			$this->ion_auth->logout();
		
		//validate form input
		$this->form_validation->set_rules('ugname', 'ugname', 'trim|required|is_unique[utana_groups.ug_name]|xss_clean');
		$this->form_validation->set_rules('ugaddress', 'ugaddress', 'trim|required|xss_clean');
		$this->form_validation->set_rules('ugcontactno', 'ugcontactno', 'trim|required|xss_clean');
		$this->form_validation->set_rules('ugcontactname', 'ugcontactname', 'trim|required|xss_clean');
		if($this->form_validation->run() == true){
			$table_data = array(
					'ug_name' => strtolower($this->input->post('ugname')),
					'ug_address'  => strtolower($this->input->post('ugaddress')),
					'ug_contact_phone'    => $this->input->post('ugcontactno'),
					'ug_contact_name'      => $this->input->post('ugcontactname'),
					'ug_addedby'      => $this->ion_auth->get_user_id(),
					'ug_active'      => '1',
			);
			$this->ug_model->addUtanaGroup($table_data);
			$this->session->set_flashdata('message', $this->ug_model->messages());
			redirect("ugm/ugmLanding", 'refresh');

		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page($this->getUserGroupName().'/addUtanaGroup', $this->data);
		}
	}

	function editUtanaGroup($id){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('editUtanaGroup', $_POST);
		if(!$this->ion_auth->validate_function_access('editUtanaGroup'))
			$this->ion_auth->logout();
		
		$utanaGroups = $this->ug_model->getUtanaGroup($id);
		//validate form input
		if(count($utanaGroups)>0 && strtolower($utanaGroups[0]->ug_name) == strtolower($this->input->post('ugname')))
			$this->form_validation->set_rules('ugname', 'Utana Group Name', 'trim|required|xss_clean');
		else 
			$this->form_validation->set_rules('ugname', 'Utana Group Name', 'trim|required|is_unique[utana_groups.ug_name]|xss_clean');
		$this->form_validation->set_rules('ugaddress', 'Utana Group Address', 'trim|required|xss_clean');
		$this->form_validation->set_rules('ugcontactno', 'Utana Group Contactno', 'trim|required|xss_clean');
		$this->form_validation->set_rules('ugcontactname', 'Utana Group Contactname', 'trim|required|xss_clean');
		$this->form_validation->set_rules('groupStatus', 'Utana Group Status', 'trim|required|xss_clean');
		$table_data = NULL;
		if($this->form_validation->run() == true){
			$table_data = array(
					'ug_name' => strtolower($this->input->post('ugname')),
					'ug_address'  => strtolower($this->input->post('ugaddress')),
					'ug_contact_phone'    => $this->input->post('ugcontactno'),
					'ug_contact_name'      => $this->input->post('ugcontactname'),
					'ug_addedby'      => $this->ion_auth->get_user_id(),
					'ug_active'      => $this->input->post('groupStatus')
			);
			$this->ug_model->editUtanaGroup($id,$table_data);
			$this->session->set_flashdata('message', $this->ug_model->messages());
			redirect("ugm/ugmLanding", 'refresh');

		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			if(count($utanaGroups)>0){
				$this->data['utanaGroup'] = $utanaGroups[0];
			}
			else{
				redirect("ugm/editUtanaGroup/".$id, 'refresh');
			}
			$this->_render_page($this->getUserGroupName().'/editUtanaGroup', $this->data);
		}
	}

	function removeUtanaGroup($id){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('removeUtanaGroup', $_POST);
		if(!$this->ion_auth->validate_function_access('removeUtanaGroup'))
			$this->ion_auth->logout();
		
		//validate form input
		$table_data = NULL;
		if(strtolower($this->input->post('confirm'))=='yes'){
			$table_data = array(
					'ug_active'      => '0',
			);
			$this->ug_model->editUtanaGroup($id,$table_data);
			$this->session->set_flashdata('message', $this->ug_model->messages());
			redirect("ugm/ugmLanding", 'refresh');

		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$utanaGroups = $this->ug_model->getUtanaGroup($id);
			if(count($utanaGroups)>0){
				$this->data['utanaGroup'] = $utanaGroups[0];
			}
			else{
				redirect("ugm/removeUtanaGroup/".$id, 'refresh');
			}
			$this->_render_page($this->getUserGroupName().'/removeUtanaGroup', $this->data);
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
