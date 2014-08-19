<?php
class Parcom_model extends CI_Model
{
      function __construct()
    {
            // Call the Model constructor
            parent::__construct();
			$this->load->database();
    }
	
	public function get_locations (){
		
	        $this->db->select('id_location, ams_name_short, ams_name_long');
			
			$this->db->order_by("id_location", "asc");
			
			
			$query = $this->db->get('location');
	      
	        $station = '<option value="0">-- Select Station --</option>';
			
	        if($query->result()){
	            foreach ($query->result() as $row) {
					$station .= '<option value="' . $row->id_location . '">' . $row->ams_name_short . ' - ' . $row->ams_name_long . '</option>';
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
		
		public function get_instruments()
		{
			$query = $this->db->query('SELECT id_model, modelnum FROM instrumentmodel');
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
		
		public function get_data($stat, $instr, $para, $nums)
		{
			
			$sql = "	";
			
			//log_message('info', 'Nums value is  ' . $nums);
			$this->db->limit($nums);
			$query = $this->db->query($sql, array($stat, $instr, $para));
			//log_message('info', 'Last query is  ' . $this->db->last_query());
			
			$rows = array();
			$result['name'] = 'Trial Chart Thing';
			foreach ($query->result_array() as $row)
			{
				
				
				$milliseconds = strtotime($row['timestamp']) * 1000;
				
				$tva =  $row['value_avg'];
				$rows[] = [$milliseconds, $tva];			
				
			}
			return $rows;
			
		}
		
		
		public function get_datam($instr, $para, $nums)
		{
			// Select distinct the location in a query and then query for each of those? With name and add to array.
			$sqld = "SELECT id_instrumentlocation, id_inventory FROM inventory WHERE id_model = ?";
			
			$sql = "SELECT * FROM data_numeric WHERE id_inventory = ? AND location_id = ? AND parameter_id = ? ORDER BY id_data_numeric DESC LIMIT $nums";
			
			$sqll = "SELECT ams_name_long FROM location WHERE id_location = ?";
			
			$queryd = $this->db->query($sqld, array($instr));
			
			$seriesOptions = array();
			
			foreach ($queryd->result_array() as $rowd)
			{
				$rloc = $rowd['id_instrumentlocation'];
				$rinv = $rowd['id_inventory'];
				$queryl = $this->db->query($sqll, array($rloc));
				$rowl = $queryl->row();
				$rlocn = $rowl->ams_name_long;
				$query = $this->db->query($sql, array($rinv, $rloc, $para));
				$rowsavg = array();
				if ($query->num_rows() > 0)
				{
				  foreach ($query->result_array() as $row)
				  {
					  
					  
					  $milliseconds = strtotime($row['timestamp']) * 1000;
					  
					  $tva =  $row['value_avg'];
					  
					  $rowsavg[] = [$milliseconds, $tva];
					  
	  
					  
				  }
				  $seriesOptions[] = [$rlocn, array_reverse($rowsavg)];
				}
			}
			
			
			
			
			
			return $seriesOptions;
			
		}
		
} 
