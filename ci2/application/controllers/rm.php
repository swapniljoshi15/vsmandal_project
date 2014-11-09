<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rm extends CI_Controller {

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
			redirect('rm/rawMaterialLanding', 'refresh');
		}
	}

	function rawMaterialLanding(){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('rawMaterialLanding', $_POST);
		if(!$this->ion_auth->validate_function_access('rawMaterialLanding'))
			$this->ion_auth->logout();
		
		//fetch all raw material data here
		$rawMaterials = $this->raw_material_model->getRawMaterials();
		//open landing page and pass objects
		$this->data['rawMaterials'] = $rawMaterials;
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->_render_page($this->getUserGroupName().'/rawMaterialLanding', $this->data);
	}

	function addRawMaterial(){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('addRawMaterial', $_POST);
		if(!$this->ion_auth->validate_function_access('addRawMaterial'))
		$this->ion_auth->logout();
		
		//validate form input
		$this->form_validation->set_rules('materialname', 'materialname', 'trim|required|is_unique[raw_material.material_name]|xss_clean');
		$this->form_validation->set_rules('materialunit', 'materialunit', 'trim|required|xss_clean');
		$this->form_validation->set_rules('materialref', 'materialref', 'trim|required|xss_clean');
		if($this->form_validation->run() == true){
			$table_data = array(
					'material_name' => strtolower($this->input->post('materialname')),
					'material_unit'  => strtolower($this->input->post('materialunit')),
					'material_reference'    => $this->input->post('materialref'),
					'material_updatedby'      => $this->ion_auth->get_user_id(),
					'material_active'      => '1',
			);
			$this->raw_material_model->addRawMaterial($table_data);
			$this->data['message'] = 'Raw Material added successfully.';
			$this->session->set_flashdata('message', $this->raw_material_model->messages());
			redirect("rm/rawMaterialLanding", 'refresh');

		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page($this->getUserGroupName().'/addRawMaterial', $this->data);
		}
	}

	function editRawMaterial($id){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('editRawMaterial', $_POST);
		if(!$this->ion_auth->validate_function_access('editRawMaterial'))
			$this->ion_auth->logout();
		
		//validate form input
		$this->form_validation->set_rules('materialname', 'materialname', 'trim|required|xss_clean');
		$this->form_validation->set_rules('materialunit', 'materialunit', 'trim|required|xss_clean');
		$this->form_validation->set_rules('materialref', 'materialref', 'trim|required|xss_clean');
		$this->form_validation->set_rules('materialStatus', 'material status', 'trim|required|xss_clean');
		$table_data = NULL;
		if($this->form_validation->run() == true){
			$table_data = array(
					'material_name' => strtolower($this->input->post('materialname')),
					'material_unit'  => strtolower($this->input->post('materialunit')),
					'material_reference'    => $this->input->post('materialref'),
					'material_updatedby'      => $this->ion_auth->get_user_id(),
					'material_active'      => $this->input->post('materialStatus'),
			);
			$this->raw_material_model->editRawMaterial($id,$table_data);
			$this->session->set_flashdata('message', $this->raw_material_model->messages());
			redirect("rm/rawMaterialLanding", 'refresh');

		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$rawMaterials = $this->raw_material_model->getRawMaterial($id);
			if(count($rawMaterials)>0){
				$this->data['rawMaterial'] = $rawMaterials[0];
			}
			else{
				redirect("rm/editRawMaterial/".$id, 'refresh');
			}
			$this->_render_page($this->getUserGroupName().'/editRawMaterial', $this->data);
		}
	}

	function removeRawMaterial($id){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('removeRawMaterial', $_POST);
		if(!$this->ion_auth->validate_function_access('removeRawMaterial'))
			$this->ion_auth->logout();
		
		//validate form input
		$table_data = NULL;
		if(strtolower($this->input->post('confirm'))=='yes'){
			$table_data = array(
					'material_active'      => '0',
			);
			$this->raw_material_model->editRawMaterial($id,$table_data);
			$this->session->set_flashdata('message', $this->raw_material_model->messages());
			//redirect("rm/index", 'refresh');
			redirect("rm/rawMaterialLanding", 'refresh');
		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$rawMaterials = $this->raw_material_model->getRawMaterial($id);
			if(count($rawMaterials)>0){
				$this->data['rawMaterial'] = $rawMaterials[0];
			}
			else{
				redirect("rm/removeRawMaterial/".$id, 'refresh');
			}
			$this->_render_page($this->getUserGroupName().'/removeRawMaterial', $this->data);
		}
	}

	function inputRawMaterialAvailability(){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('inputRawMaterialAvailability', $_POST);
		if(!$this->ion_auth->validate_function_access('inputRawMaterialAvailability'))
			$this->ion_auth->logout();
		
		$rawMaterials = $this->raw_material_model->getRawMaterials();
		foreach($rawMaterials as $rawMaterial){
			//validate input
			$this->form_validation->set_rules($rawMaterial->material_id, $rawMaterial->material_name, 'trim|required|xss_clean');
		}
		if($this->form_validation->run() == true){
			foreach($rawMaterials as $rawMaterial){
				$postRawMaterial = $this->input->post($rawMaterial->material_id);
				if($postRawMaterial<0 || $postRawMaterial>32767){
					$postRawMaterial = 0;
				}
				$totalQuantity = $postRawMaterial + $rawMaterial->material_quantity;
				$table_data = array(
					'material_quantity' => $totalQuantity,
				);
				$this->raw_material_model->editRawMaterial($rawMaterial->material_id,$table_data);
			}
			$this->session->set_flashdata('message', $this->raw_material_model->messages());
			redirect("bm/batchLanding", 'refresh');
		}else{

		}
	}

	function displayRawMaterials(){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('displayRawMaterials', $_POST);
		if(!$this->ion_auth->validate_function_access('displayRawMaterials'))
			$this->ion_auth->logout();
		
		$rawMaterials = $this->raw_material_model->getRawMaterials();
		$this->data['rawMaterials'] = $rawMaterials;
		$this->data['message'] = '';
		$this->_render_page($this->getUserGroupName().'/inputRawMaterials', $this->data);
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