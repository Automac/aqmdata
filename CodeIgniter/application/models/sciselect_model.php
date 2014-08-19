<?php
class Sciselect_model extends CI_Model
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
		
		
} 
