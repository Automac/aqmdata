<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Atselect extends CI_Controller {

	function Atselect()
	{
		parent::__construct();
		
		$this->load->model('Atselect_model');
		
		//$this->view_data = array();
	}
	
	public function index()
	{
		
		$this->load->view('view_atselect');
	}
	
	public function select_instrument()
		{
		
			$whatsup = $this->uri->segment(3);
			
			$out = $this->Atselect_model->select_instrument($whatsup);
			
			$this->output->set_header('Content-Type: application/json; charset=utf-8');
			echo (json_encode($out));
		}
	
	public function select_parameter()
		{	
			$whatsup = $this->uri->segment(3);
			
			$out = $this->Atselect_model->select_parameter($whatsup);
			
			$this->output->set_header('Content-Type: application/json; charset=utf-8');
			echo (json_encode($out));
		}
		public function get_datam($whatstat, $whatinstr, $nums)
		{
			
			$out = $this->Atselect_model->get_datam($whatstat, $whatinstr, $nums);
			
			$this->output->set_header('Content-Type: application/json; charset=utf-8');
			
			echo (json_encode($out, JSON_NUMERIC_CHECK));
		
		}
}
