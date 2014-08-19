<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rootpage extends CI_Controller {

	function Rootpage()
	{
		parent::__construct();
		
		//$this->load->model('Rootpage_model');
		
		//$this->view_data = array();
	}
	
	public function index()
	{
		
		$this->load->view('view_rootpage');
	}
	
	
	
}
