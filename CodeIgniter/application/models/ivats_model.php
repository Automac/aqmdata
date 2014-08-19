<?php
class Ivats_model extends CI_Model
{
      function __construct()
    {
            // Call the Model constructor
            parent::__construct();
			$this->load->database();
    }
	
	
	public function get_rows()
	{
		
		$stat = $_COOKIE['the_station'];
		//$instr = $_COOKIE['the_instrument'];
		
		$sqlp = "SELECT serialnum, (SELECT modelnum FROM instrumentmodel WHERE id_model = inventory.id_model) AS mnum, (SELECT modelname FROM instrumentmodel WHERE id_model = inventory.id_model) AS mname FROM inventory WHERE inventory.id_instrumentlocation = ?";
		
		$queryp = $this->db->query($sqlp, array($stat));
		
		$tbl = '';
		foreach ($queryp->result_array() as $rowp)
		{
		   
		   //$rowp = $queryp->row();
		   $tbl .= "<tr><td>" . $rowp['mnum'] . "    " . $rowp['mname'] . "</td><td>" . $rowp['serialnum'] . "</td><td>" . "</td></tr>";
		}
		return $tbl;
	}
	public function get_parameters()
	{
		$this->db->select('parameter_id', 'value_avg', 'value_max', 'value_min');
		$this->db->where('id_instrumentmodel', $inp); 
		$this->db->order_by("parameter_id", "asc");
		$query = $this->db->get('data_numeric');
	}
	
} 
