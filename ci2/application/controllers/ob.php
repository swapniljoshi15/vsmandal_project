<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('application/third_party/recaptchalib.php');

class Ob extends CI_Controller {


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
		$this->load->model('packet_mgmt_model');
		$this->load->model('online_order_model');
		$this->load->model('trasaction_logging_model');

	}

	function index()
	{
		//no login required so direct request to onlinebooking page
		redirect('ob/onlineBooking','refresh');
	}

	function onlineBooking(){
		$this->trasaction_logging_model->addTransactionLog('onlineBooking', $_POST);
		if(!$this->ion_auth->validate_function_access('onlineBooking'))
			$this->ion_auth->logout();
		//packet type is needed so get it
		$packets = $this->packet_mgmt_model->getPackets();
		$this->data['packets'] = $packets;
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->_render_page('template/onlineBooking', $this->data);
	}

	function placedOrders(){
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		
		$this->trasaction_logging_model->addTransactionLog('placedOrders', $_POST);
		if(!$this->ion_auth->validate_function_access('placedOrders'))
			$this->ion_auth->logout();
		$packets = $this->packet_mgmt_model->getPackets();
		$orders = $this->online_order_model->getOrders();
		$this->data['packets'] = $packets;
		$this->data['orders'] = $orders;
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->_render_page($this->getUserGroupName().'/placedOrderLanding', $this->data);
	}

	function placeOnlineOrder(){
		$this->trasaction_logging_model->addTransactionLog('placeOnlineOrder', $_POST);
		if(!$this->ion_auth->validate_function_access('placeOnlineOrder'))
			$this->ion_auth->logout();
		//validate captcha
		//$privatekey = "6Lf8D_ESAAAAAK_bwrPXJBdAfuw-tDG5ngPbZLO0";
                  $privatekey = "6LdsVvESAAAAAF-Ylpr0VhTyrw_NHbvl_PfFEZiw";
		$resp = recaptcha_check_answer ($privatekey,
		$_SERVER["REMOTE_ADDR"],
		$this->input->post("recaptcha_challenge_field"),
		$this->input->post("recaptcha_response_field"));
		if ($resp->error == 'false') {
			$packets = $this->packet_mgmt_model->getPackets();
			$this->data['packets'] = $packets;
			$this->data['message'] = 'Invalid Recaptcha.Please try again.';
			$this->_render_page('template/onlineBooking', $this->data);
		}else{
			$packets = $this->packet_mgmt_model->getPackets();
			foreach($packets as $packet){
				//validate input
				$this->form_validation->set_rules($packet->packet_id, $packet->packet_name, 'trim|required|xss_clean');
			}
			$this->form_validation->set_rules('firstname', 'firstname', 'trim|required|xss_clean');
			$this->form_validation->set_rules('lastname', 'lastname', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'email', 'trim|required|xss_clean');
			$this->form_validation->set_rules('phoneno', 'phoneno', 'trim|required|xss_clean');
			$this->form_validation->set_rules('address', 'address', 'trim|required|xss_clean');
			$this->form_validation->set_rules('refname', 'refname', 'trim|xss_clean');
			if($this->form_validation->run() == true){
				$date = date('Y-m-d H:i:s');
				$table_data = array(
				'first_name' => strtolower($this->input->post('firstname')),
				'last_name' => strtolower($this->input->post('lastname')),
				'email' => strtolower($this->input->post('email')),
				'phone' => $this->input->post('phoneno'),
				'address' => $this->input->post('address'),
				'person_reference' => strtolower($this->input->post('refname')),
				'order_status' => 'new',
				'dateAdded' => $date
				);
				$packet_update = array();
				$counter = 0;
				foreach($packets as $packet){
					$temp_data = array(
						'online_order_id' => '',
						'packet_id' => $packet->packet_id,
						'no_of_packets' => $this->input->post($packet->packet_id)
					);
					$packet_update[$counter] = $temp_data;
					$counter++;
				}
				$order_id = $this->online_order_model->addOnlineOrder($table_data,$packet_update);
				if($order_id){
					$this->data['packets'] = $packets;
					$this->data['message'] = 'Online order placed successfully. Our team will contact you shortly.';
					$this->_render_page('template/onlineBooking', $this->data);
				}else{
					$this->data['packets'] = $packets;
					$this->data['message'] = 'There is some problem occured while placing order.Your order is not placed.Please call on XXXXXXXXXXX to place your order.Thank You.';
					$this->_render_page('template/onlineBooking', $this->data);
				}
			}else{
				$this->data['packets'] = $packets;
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->_render_page('template/onlineBooking', $this->data);
			}
		}
	}

	function editOnlineOrder($orderid){
		if (!$this->ion_auth->logged_in())
			{
				//redirect them to the login page
				redirect('auth/login', 'refresh');
				//$this->load->view('template/index1');
			}
		
		$this->trasaction_logging_model->addTransactionLog('editOnlineOrder', $_POST);
		if(!$this->ion_auth->validate_function_access('editOnlineOrder'))
			$this->ion_auth->logout();
		$packets = $this->packet_mgmt_model->getPackets();
		foreach($packets as $packet){
			//validate input
			$this->form_validation->set_rules($packet->packet_id, $packet->packet_name, 'trim|required|xss_clean');
		}
		$this->form_validation->set_rules('firstname', 'firstname', 'trim|required|xss_clean');
		$this->form_validation->set_rules('lastname', 'lastname', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'email', 'trim|required|xss_clean');
		$this->form_validation->set_rules('phoneno', 'phoneno', 'trim|required|xss_clean');
		$this->form_validation->set_rules('address', 'address', 'trim|required|xss_clean');
		$this->form_validation->set_rules('refname', 'refname', 'trim|xss_clean');
		$this->form_validation->set_rules('status', 'status', 'trim|required|xss_clean');
		$this->form_validation->set_rules('comment', 'comment', 'trim|required|xss_clean');
		if($this->form_validation->run() == true){
			$table_data = array(
				'first_name' => strtolower($this->input->post('firstname')),
				'last_name' => strtolower($this->input->post('lastname')),
				'email' => strtolower($this->input->post('email')),
				'phone' => $this->input->post('phoneno'),
				'address' => $this->input->post('address'),
				'person_reference' => strtolower($this->input->post('refname')),
				'comment' => $this->input->post('comment'),
				'order_status' => strtolower($this->input->post('status'))
			);
			$packet_update = array();
			$counter = 0;
			foreach($packets as $packet){
				$temp_data = array(
						'packet_id' => $packet->packet_id,
						'no_of_packets' => $this->input->post($packet->packet_id)
				);
				$packet_update[$counter] = $temp_data;
				$counter++;
			}
			$order_id = $this->online_order_model->editOnlineOrder($orderid,$table_data,$packet_update);
			if($order_id){
				$this->session->set_flashdata('message', $this->online_order_model->messages());
				redirect("ob/placedOrders", 'refresh');
			}else{
				$this->session->set_flashdata('message', $this->online_order_model->messages());
				redirect("ob/editOnlineOrder/".$orderid, 'refresh');
			}
		}else{
			$this->session->set_flashdata('message', $this->online_order_model->messages());
			$this->data['messages'] = "";
			$packets = $this->packet_mgmt_model->getPackets();
			$orders = $this->online_order_model->getOrder($orderid);
			$order_packets = $this->online_order_model->getOrderPackets($orderid);
			if(count($orders)>0){
				$orders = $orders[0];
			}
			$this->data['packets'] = $packets;
			$this->data['orders'] = $orders;
			$this->data['order_packets'] = $order_packets;
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page($this->getUserGroupName().'/editOnlineOrder', $this->data);
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