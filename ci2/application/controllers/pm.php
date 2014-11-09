<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pm extends CI_Controller {

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
			redirect('pm/packetManagementLanding', 'refresh');
		}
	}

	function packetManagementLanding(){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('packetManagementLanding', $_POST);
		if(!$this->ion_auth->validate_function_access('packetManagementLanding'))
			$this->ion_auth->logout();
		
		//fetch all raw material data here
		$packets = $this->packet_mgmt_model->getPackets();
		//open landing page and pass objects
		$this->data['packets'] = $packets;
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->_render_page($this->getUserGroupName().'/packetManagementLanding', $this->data);
	}

	function addPacket(){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('addPacket', $_POST);
		if(!$this->ion_auth->validate_function_access('addPacket'))
			$this->ion_auth->logout();
		
		//validate form input
		$this->form_validation->set_rules('packetname', 'packetname', 'trim|required|xss_clean');
		$this->form_validation->set_rules('packetquantity', 'packetquantity', 'trim|required|xss_clean');
		$this->form_validation->set_rules('packetref', 'packetref', 'trim|required|xss_clean');
		$this->form_validation->set_rules('packetunit', 'packetunit', 'trim|required|xss_clean');
		if($this->form_validation->run() == true){
			$table_data = array(
					'packet_name' => strtolower($this->input->post('packetname')),
					'packet_quantity'  => strtolower($this->input->post('packetquantity')),
					'packet_unit'    => $this->input->post('packetunit'),
					'packet_reference'    => $this->input->post('packetref')
			);
			$this->packet_mgmt_model->addPacket($table_data);
			$this->session->set_flashdata('message', $this->packet_mgmt_model->messages());
			redirect("pm/packetManagementLanding", 'refresh');
		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page($this->getUserGroupName().'/addPacket', $this->data);
		}
	}

	function editPacket($id){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('editPacket', $_POST);
		if(!$this->ion_auth->validate_function_access('editPacket'))
			$this->ion_auth->logout();
		
		//validate form input
		$this->form_validation->set_rules('packetname', 'packetname', 'trim|required|xss_clean');
		$this->form_validation->set_rules('packetquantity', 'packetquantity', 'trim|required|xss_clean');
		$this->form_validation->set_rules('packetref', 'packetref', 'trim|required|xss_clean');
		$this->form_validation->set_rules('packetunit', 'packetunit', 'trim|required|xss_clean');
		$table_data = NULL;
		if($this->form_validation->run() == true){
			$table_data = array(
					'packet_name' => strtolower($this->input->post('packetname')),
					'packet_quantity'  => strtolower($this->input->post('packetquantity')),
					'packet_unit'    => $this->input->post('packetunit'),
					'packet_reference'    => $this->input->post('packetref')
			);
			$this->packet_mgmt_model->editPacket($id,$table_data);
			$this->session->set_flashdata('message', $this->packet_mgmt_model->messages());
			redirect("pm/packetManagementLanding", 'refresh');

		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$packets = $this->packet_mgmt_model->getPacket($id);
			if(count($packets)>0){
				$this->data['packet'] = $packets[0];
			}
			else{
				redirect("pm/editPacket/".$id, 'refresh');
			}
			$this->_render_page($this->getUserGroupName().'/editPacket', $this->data);
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