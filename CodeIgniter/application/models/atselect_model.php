<?php
class Atselect_model extends CI_Model
{
      function __construct()
    {
            // Call the Model constructor
            parent::__construct();
			$this->load->database();
    }
	
	public function get_stations (){
		
	        $this->db->select('id_location, ams_name_short, ams_name_long');
			
			$this->db->order_by("id_location", "asc");
			
			
			$query = $this->db->get('location');
	      
	        $station = '<option value="0">-- Select Station --</option>';
			
	        if($query->result()){
	            foreach ($query->result() as $row) {
					if ($row->id_location != INVENTORY) {
					$station .= '<option value="' . $row->id_location . '">' . $row->ams_name_short . ' - ' . $row->ams_name_long . '</option>';
					}
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
		
		public function get_datam($stat, $instr, $nums)
		{
			// Select distinct the parameter_id in a query and then query for each of those? With name and add to array.
			$sqld = "SELECT id_parameter, parname, polling_answer_prefix FROM parameter WHERE id_parameter IN(SELECT DISTINCT parameter_id FROM (SELECT * FROM data_numeric WHERE id_inventory = (SELECT id_inventory FROM inventory WHERE id_instrumentlocation= ? AND id_model=?) LIMIT 500) T1 WHERE parameter_id > 0)";
			
			$sql = "SELECT * FROM data_numeric WHERE id_inventory = (SELECT id_inventory FROM inventory WHERE id_instrumentlocation= ? AND id_model=?) AND parameter_id = ? ORDER BY id_data_numeric DESC LIMIT $nums";
			
			$queryd = $this->db->query($sqld, array($stat, $instr));
			
			$seriesOptions = array();
			
			foreach ($queryd->result_array() as $rowd)
			{
				$rid = $rowd['id_parameter'];
				$rnm = $rowd['parname'];
				$query = $this->db->query($sql, array($stat, $instr, $rid));
				$rowsavg = array();
				foreach ($query->result_array() as $row)
				{
					
					
					$milliseconds = strtotime($row['timestamp']) * 1000;
					
					$tva =  $row['value_avg'];
					
					$rowsavg[] = [$milliseconds, $tva];
					
	
					
				}
				$seriesOptions[] = [$rnm,array_reverse($rowsavg)];
			}
			
			
			
			
			
			return $seriesOptions;
			
		}
		
		
} 
