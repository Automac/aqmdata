<?php
class Xtest_model extends CI_Model
{
      function __construct()
    {
            // Call the Model constructor
            parent::__construct();
			$this->load->database();
    }
	
	public function get_locations (){
		
	        $this->db->select('id_location, ams_name_short');
			
			$this->db->order_by("id_location", "asc");
			
			
			$query = $this->db->get('location');
	      
	        $station = '<option value="0">-- Select Station --</option>';
			
	        if($query->result()){
	            foreach ($query->result() as $row) {
					$station .= '<option value="' . $row->id_location . '">' . $row->ams_name_short . '</option>';
	            }
	            return $station;
	        } else {
	            return FALSE;
	        }
	    }
		
		
		public function select_instrument($inp)
		{
			$query = $this->db->query('SELECT * FROM instrumentmodel WHERE id_model IN (SELECT id_model FROM inventory WHERE id_instrumentlocation=' . $inp . ')');
			$instrument = '<option value="0">-- Select Instrument --</option>';
			
			foreach ($query->result_array() as $row)
			{
				$instrument .= '<option value="' . $row['id_model'] . '">' . $row['modelnum'] . '</option>';
			}
			
			return $instrument;
		}
	
		public function select_parameter($inp)
		{
			$instrument = '<option value="0">-- Select Parameter --</option>';
			$this->db->select('id_parameter, parname');
			$this->db->where('id_instrumentmodel', $inp); 
			$query = $this->db->get('parameter');
			
			
			foreach ($query->result_array() as $row)
			{
				$instrument .= '<option value="' . $row['id_parameter'] . '">' . $row['parname'] . '</option>';
			}
			
			return $instrument;
		}
		
		public function oldget_data($stat, $instr, $para)
		{
			
			$sql = "SELECT * FROM data_numeric WHERE id_inventory = (SELECT id_inventory FROM inventory WHERE id_instrumentlocation= ? AND id_model=?) AND parameter_id = ? ORDER BY TIMESTAMP LIMIT 160";
			
			$query = $this->db->query($sql, array($stat, $instr, $para));
			
			$numdata = '';
			foreach ($query->result_array() as $row)
			{
				
				
				$milliseconds = strtotime($row['timestamp']) * 1000;
				$temp = $milliseconds  . "\t" . $row['value_avg'] . "\n";
				
				$numdata .= $temp;
				
			}
			return $numdata;
		}
		public function get_data($stat, $instr, $para, $nums)
		{
			
			$sql = "SELECT * FROM (SELECT * FROM data_numeric WHERE id_inventory = (SELECT id_inventory FROM inventory WHERE id_instrumentlocation= ? AND id_model=?) AND parameter_id = ? ORDER BY TIMESTAMP DESC LIMIT $nums) T1 ORDER BY TIMESTAMP";
			
			log_message('info', 'Nums value is  ' . $nums);
			$this->db->limit($nums);
			$query = $this->db->query($sql, array($stat, $instr, $para));
			log_message('info', 'Last qeury is  ' . $this->db->last_query());
			
			$rows = array();
			$result['name'] = 'Trial Chart Thing';
			foreach ($query->result_array() as $row)
			{
				
				
				$milliseconds = strtotime($row['timestamp']) * 1000;
				$tva =  $row['value_avg'];
				
				$rows[] = [$milliseconds, $tva];
				//$rows[] = array("x" => "$milliseconds", "y" => "$tva");
				//$result['category'][] = $milliseconds;
    			//$result['data'][] = $tva;
				
			}
			return $rows;
			//return $result;
		}
		
} 
