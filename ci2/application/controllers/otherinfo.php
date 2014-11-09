<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Otherinfo extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{

	}

	public function contactLanding(){
		$this->data['message'] = '';
		$this->_render_page('template/contact', $this->data);
	}

	public function aboutLanding(){
		$this->data['message'] = '';
		$this->_render_page('template/about', $this->data);
	}

	function _render_page($view, $data=null, $render=false)
	{

		$this->viewdata = (empty($data)) ? $this->data: $data;

		$view_html = $this->load->view($view, $this->viewdata, $render);

		if (!$render) return $view_html;
	}

}