<?php
class Cvedit_model extends CI_Model
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
		$instr = $_COOKIE['the_instrument'];
		
		$sqlp = "SELECT DISTINCT parameter_id FROM data_numeric WHERE id_inventory = (SELECT id_inventory FROM inventory WHERE id_instrumentlocation = ? AND id_model = ?) AND parameter_id > 0 AND parameter_id <> 90";
		$sqla = "SELECT timestamp, (SELECT parname FROM parameter WHERE id_parameter = ?) AS parname, value_avg, value_max, value_min FROM data_numeric WHERE id_inventory = (SELECT id_inventory FROM inventory WHERE parameter_id=? AND id_instrumentlocation=? AND id_model=?) ORDER BY id_data_numeric DESC LIMIT 1";
		$queryp = $this->db->query($sqlp, array($stat, $instr));
		
		$tbl = '';
		foreach ($queryp->result_array() as $rowp)
		{
		   $pid =  $rowp['parameter_id'];
		  
		   $querya = $this->db->query($sqla, array($pid, $pid, $stat, $instr));
		   $rowa = $querya->row();
		   $tbl .= "<tr><td>" . $rowa->timestamp . "</td><td>" . $rowa->parname . "</td><td>" . $rowa->value_avg . "</td><td>" . $rowa->value_max . "</td><td>" . $rowa->value_min . "</td></tr>";
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
	
	public function get_data() // Used for jTable version
		{
			$sqlc = "SELECT COUNT(DISTINCT parameter_id) AS CNT FROM data_numeric WHERE id_inventory = (SELECT id_inventory FROM inventory WHERE id_instrumentlocation= ? AND id_model=?)";

			$sql = "SELECT id_data_numeric, TIMESTAMP, (SELECT parname FROM parameter WHERE id_parameter = parameter_id) AS parname, value_avg, value_max, value_min FROM data_numeric WHERE id_inventory = (SELECT id_inventory FROM inventory WHERE id_instrumentlocation= ? AND id_model=?) ORDER BY TIMESTAMP DESC LIMIT ?, ?";
			//$stat = $this->input->cookie('the_station');
			//$instr = $this->input->cookie('the_instrument');
			$stat = $_COOKIE['the_station'];
			$instr = $_COOKIE['the_instrument'];
			log_message('debug', '$stat = ' . $stat);
			log_message('debug', '$instr = ' . $instr);
			$queryc = $this->db->query($sqlc, array($stat, $instr));
			$rowc = $queryc->row();
			$numents = $rowc->CNT;
			
			$query = $this->db->query($sql, array($stat, $instr, 0, $numents));
			$num_rows = count($query->result_array());
			log_message('debug', '$num_rows = ' . $num_rows);
			$rows = array();
			foreach ($query->result_array() as $row)
			{
				$rows[] = $row;							
			}
			
		//log_message('debug', '$rows = ' . print_r($rows,true));
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Records'] = $rows;
		
		log_message('debug', '$jTableResult = ' . print_r($jTableResult,true));

			
			
			return $jTableResult;
		}	
} 
