<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ivats extends CI_Controller {

	function Ivats()
	{
		parent::__construct();
		
		$this->load->model('Ivats_model');
		
		//$this->view_data = array();
	}
	
	public function index()
	{
		$this->load->view('view_ivats');
	}
	
	public function get_data()
	{
			
			
			$out = $this->Ivats_model->get_data();
			
			$this->output->set_header('Content-Type: application/json; charset=utf-8');
			echo (json_encode($out));	
	}
	
	public function get_dtdata()
	{
       log_message('debug', 'cvedit get_dtdata function entered');
	   
			
			//$stat = $this->input->cookie('the_station');
			//$instr = $this->input->cookie('the_instrument');
			$stat = $_COOKIE['the_station'];
			$instr = $_COOKIE['the_instrument']; 
		
		
		
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
         */
        $aColumns = array('timestamp', 'parname', 'value_avg', 'value_max', 'value_min');
        
        // DB table to use
        //$sTable = 'data_table';
        //
    	// Get POST values
        $iDisplayStart = $this->input->get_post('start', true);
        $iDisplayLength = $this->input->get_post('length', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);
		
			  
			   
			   $sqlCount = "SELECT COUNT(*) AS cnt FROM data_numeric WHERE id_inventory = (SELECT id_inventory FROM inventory WHERE id_instrumentlocation= ? AND id_model=?)";
			   	$query = $this->db->query($sqlCount, array($stat, $instr));
				$row = $query->row(); 
				$iTotal = $row->cnt;
				
    		$sqlc = "SELECT COUNT(DISTINCT parameter_id) AS cnt FROM data_numeric WHERE id_inventory = (SELECT id_inventory FROM inventory WHERE id_instrumentlocation= ? AND id_model=?)";
	
			$query = $this->db->query($sqlc, array($stat, $instr));
				$row = $query->row(); 
				$iGetC = $row->cnt;
				
				 $sql = "SELECT timestamp, (SELECT parname FROM parameter WHERE id_parameter = parameter_id) AS parname, value_avg, value_max, value_min FROM data_numeric WHERE id_inventory = (SELECT id_inventory FROM inventory WHERE id_instrumentlocation= ? AND id_model=?) ORDER BY timestamp DESC LIMIT 0" . "," . $iGetC ." ";
        // Ordering
        //if(isset($iSortCol_0))
//        {
//            for($i=0; $i<intval($iSortingCols); $i++)
//            {
//                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
//                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
//                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);
//    
//                if($bSortable == 'true')
//                {
//                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
//                }
//            }
//        }
//        
        /* 
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        //if(isset($sSearch) && !empty($sSearch))
//        {
//            for($i=0; $i<count($aColumns); $i++)
//            {
//                $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
//                
//                // Individual column filtering
//                if(isset($bSearchable) && $bSearchable == 'true')
//                {
//                    $this->db->or_like($aColumns[$i], $this->db->escape_like_str($sSearch));
//                }
//            }
//        }
        
        // Select Data
        //$this->db->select('SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        //$rResult = $this->db->get($sTable);
    
        // Data set length after filtering
        //$this->db->select('FOUND_ROWS() AS found_rows');
        //$iFilteredTotal = $this->db->get()->row()->found_rows;
		$iFilteredTotal = $iTotal;
    
      
    
        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );
        
		if (isset($iDisplayStart) && $iDisplayLength != '-1')
		{
			//log_message('debug', '(isset) $iDisplayStart = ' . print_r($iDisplayStart) . '$iDisplayLength = ' . print_r($iDisplayLength));
			//$iDisplayStart = 0;
			//$iDisplayLength = 10;
			
		}
		if (! (is_numeric($iDisplayStart) && is_numeric($iDisplayLength)))
		{
			//log_message('debug', '(is_numeric) $iDisplayStart = ' . $iDisplayStart . '$iDisplayLength = ' . $iDisplayLength);
			$iDisplayStart = 0;
			$iDisplayLength = 10;
			
		}
		
		$query = $this->db->query($sql, array($stat, $instr));
		
	   if ($query->num_rows() > 0)
	   {
	    foreach ($query->result_array() as $aRow)
        {
            $row = array();
            
            foreach($aColumns as $col)
            {
				
              $row[] = $aRow[$col];
            }
    		
            $output['aaData'][] = $row;
        }
	   }
	   else
	   {
		   log_message('debug', 'query had no rows');
	   }
		
       echo json_encode($output);
    }
}
	
