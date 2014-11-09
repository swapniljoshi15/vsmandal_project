<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pd extends CI_Controller {

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
		$this->load->model('packet_distribution_model');
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
	}

	function addPacketDistribution($userid){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('addPacketDistribution', $_POST);
		if(!$this->ion_auth->validate_function_access('addPacketDistribution'))
			$this->ion_auth->logout();
		
		$this->form_validation->set_rules('packettype', 'packettype', 'trim|required|xss_clean');
		$this->form_validation->set_rules('noofpacket', 'noofpacket', 'trim|required|xss_clean');
		$this->form_validation->set_rules('amount', 'amount', 'trim|required|xss_clean');
		if($this->form_validation->run() == true){
			$table_data = array(
					'userid' => $userid,
					'packetid' => $this->input->post('packettype'),
					'noofpackets'  => $this->input->post('noofpacket'),
					'amountofpacket'    => $this->input->post('amount'),
					'status'      => '1'
					);
					$this->packet_distribution_model->addPacketDistribution($userid,$table_data);
					$this->session->set_flashdata('message', $this->packet_distribution_model->messages());
					redirect("um/userProfile/".$userid, 'refresh');

		}else{
			$packets = $this->packet_mgmt_model->getPackets();
			$this->data['packets'] = $packets;
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page($this->getUserGroupName().'/addPacketDistribution', $this->data);
		}
	}

	function returnPacketsFromBatch($id){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('returnPacketsFromBatch', $_POST);
		if(!$this->ion_auth->validate_function_access('returnPacketsFromBatch'))
			$this->ion_auth->logout();
		
		$packetDistribution = $this->packet_distribution_model->getPacketDistributionForId($id);
		if(count($packetDistribution)>0)
		$packetDistribution = $packetDistribution[0];
		$packet = $this->packet_mgmt_model->getPacket($packetDistribution->packetid);
		if(count($packet)>0)
		$packet = $packet[0];
		$this->form_validation->set_rules('noofpacket', 'noofpacket', 'trim|required|xss_clean');
		if($this->form_validation->run() == true){

			$noofpackets = $packetDistribution->noofpackets - $this->input->post('noofpacket');
			if($noofpackets < 0){
				$this->session->set_flashdata('message', 'Sonething went wrong');
				redirect("um/userProfile/".$packetDistribution->userid, 'refresh');
			}else{
				$table_data = array(
					'packetid' => $packet->packet_id,
					'noofpackets'  => $noofpackets
				);

				$this->packet_distribution_model->editPacketDistribution($packetDistribution->userid,$id,$table_data,'return');
				$this->session->set_flashdata('message', $this->packet_distribution_model->messages());
				redirect("um/userProfile/".$packetDistribution->userid, 'refresh');
			}
				

		}else{
			$this->data['packet'] = $packet;
			$this->data['packetDistribution'] = $packetDistribution;
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page($this->getUserGroupName().'/returnPacketsFromBatch', $this->data);
		}
	}

	function addPacketsToBatch($id){
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		//here use ACL
		$this->trasaction_logging_model->addTransactionLog('addPacketsToBatch', $_POST);
		if(!$this->ion_auth->validate_function_access('addPacketsToBatch'))
			$this->ion_auth->logout();
		
		$packetDistribution = $this->packet_distribution_model->getPacketDistributionForId($id);
		if(count($packetDistribution)>0)
		$packetDistribution = $packetDistribution[0];
		$packet = $this->packet_mgmt_model->getPacket($packetDistribution->packetid);
		if(count($packet)>0)
		$packet = $packet[0];
		$this->form_validation->set_rules('noofpacket', 'noofpacket', 'trim|required|xss_clean');
		if($this->form_validation->run() == true){

			$noofpackets = $packetDistribution->noofpackets + $this->input->post('noofpacket');
			if($noofpackets < 0 || $packet->instock < $this->input->post('noofpacket')){
				$this->session->set_flashdata('message', 'Sonething went wrong');
				redirect("um/userProfile/".$packetDistribution->userid, 'refresh');
			}
			$table_data = array(
					'packetid' => $packet->packet_id,
					'noofpackets'  => $noofpackets
			);

			$this->packet_distribution_model->editPacketDistribution($packetDistribution->userid,$id,$table_data,'add');
			$this->session->set_flashdata('message', $this->packet_distribution_model->messages());
			redirect("um/userProfile/".$packetDistribution->userid, 'refresh');

		}else{
			$this->data['packet'] = $packet;
			$this->data['packetDistribution'] = $packetDistribution;
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page($this->getUserGroupName().'/addPacketsToBatch', $this->data);
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