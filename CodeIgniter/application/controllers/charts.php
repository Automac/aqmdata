<?php if ( ! defined('BASEPATH')) exit('No direct Chart access allowed');

class Charts extends CI_Controller {

	function Charts()
	{
		parent::__construct();
		
		$this->load->model('Charts_model');
		
		$this->view_data = array();
	}
	
	public function index()
	{
		/*
		[{
	            name: 'Jane',
	            data: [1, 0, 4]
	        }, {
	            name: 'John',
	            data: [5, 7, 3]
	        }]
		*/
		
		//$series_data[] = array('name' => 'Upper', 'data' => array(8,7,4));
		//$series_data[] = array('name' => 'Lower', 'data' => array(4,5,1));
		
		//$this->view_data['series_data'] = json_encode($series_data);
		//log_message('info', 'About to load view_charts');
		$this->load->view('view_charts', $this->view_data);
	}
	
	public function select_instrument()
		{
		
			$whatsup = $this->uri->segment(3);
			//log_message('info', 'select_instrument called with param ' . $whatsup);
			$out = $this->Charts_model->select_instrument($whatsup);
			//log_message('info', 'select_instrument returned ' . $out);
			$this->output->set_header('Content-Type: application/json; charset=utf-8');
			echo (json_encode($out));
		}
	
	
		public function select_parameter()
		{	
			$whatsup = $this->uri->segment(3);
			
			$out = $this->Charts_model->select_parameter($whatsup);
			
			$this->output->set_header('Content-Type: application/json; charset=utf-8');
			echo (json_encode($out));
		}
		
		public function get_data($whatstat, $whatinstr, $whatpara, $nums)
		{
			
			$out = $this->Charts_model->get_data($whatstat, $whatinstr, $whatpara, $nums);
			
			$this->output->set_header('Content-Type: application/json; charset=utf-8');
		
			echo (json_encode($out, JSON_NUMERIC_CHECK));
			
		}
		public function get_datam($whatstat, $whatinstr, $whatpara, $nums)
		{
			
			$out = $this->Charts_model->get_datam($whatstat, $whatinstr, $whatpara, $nums);
			
			$this->output->set_header('Content-Type: application/json; charset=utf-8');
			
			echo (json_encode($out, JSON_NUMERIC_CHECK));
		
		}
	
}
