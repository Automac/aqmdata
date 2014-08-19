<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sciselect extends CI_Controller {

	function Sciselect()
	{
		parent::__construct();
		
		$this->load->model('Sciselect_model');
		
		//$this->view_data = array();
	}
	
	public function index()
	{
		
		$this->load->view('view_sciselect');
	}
	
	public function select_instrument()
		{
		
			$whatsup = $this->uri->segment(3);
			
			$out = $this->Sciselect_model->select_instrument($whatsup);
			
			$this->output->set_header('Content-Type: application/json; charset=utf-8');
			echo (json_encode($out));
		}
	
	public function select_parameter()
		{	
			$whatsup = $this->uri->segment(3);
			
			$out = $this->Sciselect_model->select_parameter($whatsup);
			
			$this->output->set_header('Content-Type: application/json; charset=utf-8');
			echo (json_encode($out));
		}
}
