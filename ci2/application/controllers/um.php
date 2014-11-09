<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Um extends CI_Controller {

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
		/*elseif (!$this->ion_auth->is_admin()) //remove this elseif if you want to enable this for non-admins
		 {
			//redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
			}*/
		else
		{
			//open corresponding landing view from here ie user search view
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page($this->getUserGroupName().'/searchUser', $this->data);
		}
	}

	function searchUser(){

		//check for logged in
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}else{
			$this->trasaction_logging_model->addTransactionLog('searchUser', $_POST);
			if(!$this->ion_auth->validate_function_access('searchUser'))
			$this->ion_auth->logout();
				
			//login successful
			//validate input
			$this->data['title'] = "Search user";

			//validate form input
			$this->form_validation->set_rules('searchCriteria', 'SearchCriteria', 'required');
			$this->form_validation->set_rules('searchid', 'Searchid', 'required');
			$row_info = array();
			if ($this->form_validation->run() == true)
			{
				//now based on searchCriteria call model method
				if($this->input->post('searchCriteria') == "Namewise"){
					$rows = $this->um_model->searchUserNameWise($this->input->post('searchid'));
					//open table view for user
					foreach($rows as $row){
						$row_data = array(
							'user_id'=>$row->id,
							'username'=>$row->username,
							'email'=>$row->email,
							'firstname'=>$row->first_name,
							'lastname'=>$row->last_name,
							'company'=>$row->company,
							'phone'=>$row->phone,
							'address'=>$row->address,
							'libraryid'=>$row->libraryid,
							'status'=>$row->active
						);
						$row_info[] = $row_data;
					}
					$this->data['rows'] = $row_info;
					$this->_render_page($this->getUserGroupName().'/listUsers', $this->data);
				}elseif ($this->input->post('searchCriteria') == "Mobilewise"){
					$rows = $this->um_model->searchUserMobileNoWise($this->input->post('searchid'));
					//open table view for user
					foreach($rows as $row){
						$row_data = array(
							'user_id'=>$row->id,
							'username'=>$row->username,
							'email'=>$row->email,
							'firstname'=>$row->first_name,
							'lastname'=>$row->last_name,
							'company'=>$row->company,
							'phone'=>$row->phone,
							'address'=>$row->address,
							'libraryid'=>$row->libraryid,
							'status'=>$row->active
						);
						$row_info[] = $row_data;
					}
					$this->data['rows'] = $row_info;
					$this->_render_page($this->getUserGroupName().'/listUsers', $this->data);
				}else{
					$this->data['message'] = "Invalid Search Criteria";
					$this->_render_page($this->getUserGroupName().'/searchUser', $this->data);
				}
			}else{
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->_render_page($this->getUserGroupName().'/searchUser', $this->data);
			}
		}
	}

	function createNewUser(){

		//check for logged in
		$this->data['title'] = "Create User";

		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}else{
			$this->trasaction_logging_model->addTransactionLog('createNewUser', $_POST);
			if(!$this->ion_auth->validate_function_access('createNewUser'))
			$this->ion_auth->logout();
				
			//validate form input
			$this->form_validation->set_rules('username', 'username', 'trim|required||min_length[10]|max_length[10]|is_unique[users.username]|xss_clean');
			$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|xss_clean|matches[confirmemail]');
			$this->form_validation->set_rules('confirmemail', 'confirmation email', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules('firstname', 'firstname', 'trim|required|xss_clean');
			$this->form_validation->set_rules('surname', 'surname', 'trim|required|xss_clean');
			$this->form_validation->set_rules('group', 'group', 'trim|required|xss_clean');
			$this->form_validation->set_rules('address', 'address', 'trim|required|xss_clean');
			$this->form_validation->set_rules('libraryid', 'libraryid', 'trim|xss_clean');

			if($this->form_validation->run() == true){
				
				$username = strtolower(strtolower($this->input->post('username')));
				$email    = strtolower(strtolower($this->input->post('email')));

				$additional_data = array(
					'first_name' => $this->input->post('firstname'),
					'last_name'  => $this->input->post('surname'),
					'phone'    => $this->input->post('username'),
					'libraryid'      => $this->input->post('libraryid'),
					'address'      => $this->input->post('address'),
				);

				//generate password here and send it to mentioned email address
				$password = $this->generatePassword();
				//email that password on user entered email address
				$data['message'] = "Use your this email id as username for login.Your password is ".$password.". Plase conatct
				administrator in case of any issue.Thanks..:)";
				$data['subject'] = "Utana System - Account Acivated";
				$this->_send_email('new_password',strtolower($this->input->post('email')),$data);

				if($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data) ){
					$groupData = $this->input->post('group');
					if (isset($groupData) && !empty($groupData)) {
						//find user based on username
						$user = $this->ion_auth->find_User($username);
						$this->ion_auth->add_to_group($groupData, $user->id);
					}
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect("um/index", 'refresh');
				}
			}else{
				$groups=$this->ion_auth->groups()->result_array();
				$this->data['groups'] = $groups;
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->_render_page($this->getUserGroupName().'/createNewUser', $this->data);
			}
		}
	}

	function userProfile(){

		//check for logged in
		$this->data['title'] = "User Profile Page";

		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}else{
			$this->trasaction_logging_model->addTransactionLog('userProfile', $_POST);
			if(!$this->ion_auth->validate_function_access('userProfile'))
			$this->ion_auth->logout();
				
			$this->data['userid'] = $this->uri->segment(3);
				
			//load packet batch distribution
			$packetDistributions = $this->packet_distribution_model->getPacketDistribution($this->data['userid']);
			$packets = $this->packet_mgmt_model->getPackets();
			$this->data['packetDistributions'] = $packetDistributions;
			$this->data['packets'] = $packets;
			//load data for account info
			$this->load->model('acc_model');
			$account = $this->acc_model->getUserAccount($this->data['userid']);
			$this->data['account'] = $account;
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->_render_page($this->getUserGroupName().'/userProfilePage', $this->data);
		}
	}

	function editUser($id){

		//check for logged in
		$this->data['title'] = "Edit User";

		if (!$this->ion_auth->logged_in() && !($this->ion_auth->user()->row()->id == $id))
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		$this->trasaction_logging_model->addTransactionLog('editUser', $_POST);
		if(!$this->ion_auth->validate_function_access('editUser'))
		$this->ion_auth->logout();

		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;

		//validate form input
		if($user->username == $this->input->post('username')){
			$this->form_validation->set_rules('username', 'username', 'trim|required||min_length[10]|max_length[10]|xss_clean');
		}else{
			$this->form_validation->set_rules('username', 'username', 'trim|required||min_length[10]|max_length[10]|is_unique[users.username]|xss_clean');
		}

		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|xss_clean|matches[confirmemail]');
		$this->form_validation->set_rules('confirmemail', 'confirmation email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('firstname', 'firstname', 'trim|required|xss_clean');
		$this->form_validation->set_rules('surname', 'surname', 'trim|required|xss_clean');
		$this->form_validation->set_rules('group', 'group', 'trim|required|xss_clean');
		$this->form_validation->set_rules('address', 'address', 'trim|required|xss_clean');
		$this->form_validation->set_rules('libraryid', 'libraryid', 'trim|xss_clean');
			

		if(isset($_POST) && !empty($_POST) && $this->form_validation->run() == true){
			$username = strtolower(strtolower($this->input->post('username')));
			$email    = strtolower(strtolower($this->input->post('email')));

			if(!($this->input->post('accountStatus') == '0' || $this->input->post('accountStatus') == '1')){
				$this->ion_auth->set_message('Account Status Invalid');
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->_render_page($this->getUserGroupName().'/editUser', $this->data);
			}
				
				
			$data = array(
					'username' => $this->input->post('username'),
					'email' => $this->input->post('email'),
					'first_name' => $this->input->post('firstname'),
					'last_name'  => $this->input->post('surname'),
					'phone'    => $this->input->post('username'),
					'libraryid'      => $this->input->post('libraryid'),
					'address'      => $this->input->post('address'),
					'active'      => $this->input->post('accountStatus'),
			);

			if($this->ion_auth->update($user->id, $data)){

				//Update the groups user belongs to
				$groupData = $this->input->post('group');
				if (isset($groupData) && !empty($groupData)) {
					$this->ion_auth->remove_from_group('', $id);
					$this->ion_auth->add_to_group($groupData, $id);

				}
				//email that password on user entered email address
				$data['message'] = "Your profile information is updated by administrator.Please login to check updated information.:)";
				$data['subject'] = "Utana System - Profile Updated";
				$this->_send_email('profile_updated',strtolower($this->input->post('email')),$data);
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("um/index", 'refresh');
			}

		}else{
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->_render_page($this->getUserGroupName().'/editUser', $this->data);
		}

	}

	function removeUser($id){

		//check for logged in
		$this->data['title'] = "Remove User";

		if (!$this->ion_auth->logged_in() && !($this->ion_auth->user()->row()->id == $id))
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}

		$this->trasaction_logging_model->addTransactionLog('removeUser', $_POST);
		if(!$this->ion_auth->validate_function_access('removeUser'))
		$this->ion_auth->logout();

		$this->form_validation->set_rules('confirm', 'confirm', 'trim|required|xss_clean');
			
		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['user'] = $this->ion_auth->user($id)->row();

		if(strtolower($this->input->post('confirm')) == 'yes'){
				
			if(strtolower($this->input->post('confirm')) == 'yes'){
				//deacrivate account here
				$this->ion_auth->deactivate($id);
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("um/index", 'refresh');
			}else{
				//show account here
				//set the flash data error message if there is one
				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
				$this->_render_page($this->getUserGroupName().'/removeUser', $this->data);
			}
		}else{
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->_render_page($this->getUserGroupName().'/removeUser', $this->data);
		}

	}

	function changePassword(){

		$this->data['title'] = "Change Password";

		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
			//$this->load->view('template/index1');
		}
		$this->trasaction_logging_model->addTransactionLog('changePassword', $_POST);
		if(!$this->ion_auth->validate_function_access('changePassword'))
		$this->ion_auth->logout();

		$userid = $this->ion_auth->get_user_id();
		$this->form_validation->set_rules('oldpassword', 'Old password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean|matches[confirmpassword]');
		$this->form_validation->set_rules('confirmpassword', 'password', 'trim|required|xss_clean');
		if($this->form_validation->run() == true){
			$user = $this->ion_auth->user($userid)->row();
			$flag = $this->ion_auth_model->change_password($user->email,$this->input->post('oldpassword'),$this->input->post('password'));
			if($flag){
				$this->data['message'] = "Password Changed Successfully.";
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				//$this->_render_page($this->getUserGroupName().'/landing', $this->data);
				redirect('auth/redirectLanding', 'refresh');
			}else{
				$this->data['message'] = "Password Not Changed Successfully.";
				$this->_render_page($this->getUserGroupName().'/editPassword', $this->data);
			}
		}else{
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->_render_page($this->getUserGroupName().'/editPassword', $this->data);
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

	private function _send_email($type, $email, $data)
	{
		$this->load->library('email');
		$this->email->set_newline("\r\n");
		$this->email->from('vsmandal.utana.project.system@gmail.com','vsmandal utana project');
		$this->email->reply_to('vsmandal.utana.project.system@gmail.com','vsmandal utana project');
		$this->email->to($email);
		$this->email->subject($data['subject']);
		$this->email->message($data['message']);
		$this->email->send();

		/*$this->load->library('email');
		 $this->email->set_newline("\r\n");
		 $this->email->from('swapnil.joshi015@gmail.com', 'swap josh'); // change it to yours
		 //$this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		 //$this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		 $this->email->to($email);
		 //$this->email->subject(sprintf($this->lang->line('auth_subject_'.$type), $this->config->item('website_name', 'tank_auth')));
		 $this->email->subject('Test sub');
		 $this->email->message('Test Message');
		 //$this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE));
		 //$this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE));
		 $this->email->send();
		 echo $this->email->print_debugger();*/
	}

	private function generatePassword(){
		return $this->rand_string(8);
	}

	private function rand_string( $length ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

		$size = strlen( $chars );
		$str = "";
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}

		return $str;
	}
}