<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scripts extends CI_Controller {

	function Scripts()
	{
		parent::__construct();
		
		$this->load->model('Scripts_model');
		
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
		
		$series_data[] = array('name' => 'Upper', 'data' => array(8,7,4));
		$series_data[] = array('name' => 'Lower', 'data' => array(4,5,1));
		
		$this->view_data['series_data'] = json_encode($series_data);
		$this->load->view('view_scripts', $this->view_data);
	}
	
	public function select_instrument()
		{
		
			$whatsup = $this->uri->segment(3);
			log_message('info', 'select_instrument called with param ' . $whatsup);
			$out = $this->Scripts_model->select_instrument($whatsup);
			log_message('info', 'select_instrument returned ' . $out);
			$this->output->set_header('Content-Type: application/json; charset=utf-8');
			echo (json_encode($out));
		}
	
	
		public function select_parameter()
		{	
			$whatsup = $this->uri->segment(3);
			log_message('info', 'select_parameter called with param ' . $whatsup);
			$out = $this->Scripts_model->select_parameter($whatsup);
			log_message('info', 'select_parameter returned ' . $out);
			$this->output->set_header('Content-Type: application/json; charset=utf-8');
			echo (json_encode($out));
		}
		
		public function get_data()
		{
			$whatstat = $this->uri->segment(3);
			$whatinstr = $this->uri->segment(4);
			$whatpara = $this->uri->segment(4);
			log_message('info', 'get_data called with params ' . $whatstat . ', ' . $whatinstr . ', ' . $whatpara);
			$out = $this->Scripts_model->get_data($whatstat, $whatinstr, $whatpara);
			log_message('info', 'get_data returned ');
			$this->output->set_header('Content-Type: application/json; charset=utf-8');
			echo (json_encode($out));
		}
	
}
