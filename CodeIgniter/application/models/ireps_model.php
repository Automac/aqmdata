<?php
class Ireps_model extends CI_Model
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
		
		public function get_instr_replace() 
		{
			
			
			$sqlp = "SELECT id_inventory, serialnum, (SELECT modelnum FROM instrumentmodel WHERE id_model = inventory.id_model) AS mnum, (SELECT modelname FROM instrumentmodel WHERE id_model = inventory.id_model) AS mname FROM inventory WHERE inventory.id_instrumentlocation = 22";
		
		$queryp = $this->db->query($sqlp, array($stat));
			$instrument = '<option value="0">-- Select Instrument To Install --</option>';
			
			foreach ($queryp->result_array() as $row)
			{
				$instrument .= '<option value="' . $row['id_inventory'] . '">' . $row['mnum'] . "   " . $row['mname'] . "   " . $row['serialnum'] . '</option>';
			}
			
			return $instrument;
		}
		
		public function get_instr_remove() 
		{
			
			$stat = $_COOKIE['the_station'];
			$sqlp = "SELECT id_inventory, serialnum, (SELECT modelnum FROM instrumentmodel WHERE id_model = inventory.id_model) AS mnum, (SELECT modelname FROM instrumentmodel WHERE id_model = inventory.id_model) AS mname FROM inventory WHERE inventory.id_instrumentlocation = ?";
		
		$queryp = $this->db->query($sqlp, array($stat));
			$instrument = '<option value="0">-- Select Instrument To Remove --</option>';
			
			foreach ($queryp->result_array() as $row)
			{
				$instrument .= '<option value="' . $row['id_inventory'] . '">' . $row['mnum'] . "   " . $row['mname'] . "   " . $row['serialnum'] . '</option>';
			}
			
			return $instrument;
		}
		
		
} 
