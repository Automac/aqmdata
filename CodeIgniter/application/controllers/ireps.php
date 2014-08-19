<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ireps extends CI_Controller {

	function Ireps()
	{
		parent::__construct();
		
		$this->load->model('Ireps_model');
		
		//$this->view_data = array();
	}
	
	public function index()
	{
		
		$this->load->view('view_ireps');
	}
	
	public function select_instrument()
		{
		
			$whatsup = $this->uri->segment(3);
			
			$out = $this->Ireps_model->select_instrument($whatsup);
			
			$this->output->set_header('Content-Type: application/json; charset=utf-8');
			echo (json_encode($out));
		}
	
	public function select_parameter()
		{	
			$whatsup = $this->uri->segment(3);
			
			$out = $this->Ireps_model->select_parameter($whatsup);
			
			$this->output->set_header('Content-Type: application/json; charset=utf-8');
			echo (json_encode($out));
		}
}
