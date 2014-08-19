<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cvedit extends CI_Controller {

	function Cvedit()
	{
		parent::__construct();
		
		$this->load->model('Cvedit_model');
		
		//$this->view_data = array();
	}
	
	public function index()
	{
		$this->load->view('view_cvedit');
	}
	
	public function get_data()
	{
			
			log_message('debug', 'cvedit get_data function entered');
			$out = $this->Cvedit_model->get_data();
			log_message('debug', '$out = ' . print_r($out, true));
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
        $aColumns = array('parname', 'value_avg', 'value_max', 'value_min');
        
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
		
			   $sql = "SELECT (SELECT parname FROM parameter WHERE id_parameter = parameter_id) AS parname, value_avg, value_max, value_min FROM data_numeric WHERE id_inventory = (SELECT id_inventory FROM inventory WHERE id_instrumentlocation= ? AND id_model=?) LIMIT " . $iDisplayStart . "," . $iDisplayLength ." ";
				
				//$sqlCount = "SELECT COUNT(*) AS cnt FROM data_numeric WHERE id_inventory = (SELECT id_inventory FROM inventory WHERE id_instrumentlocation= ? AND id_model=?)";
				
				//$query = $this->db->query($sql, array($stat, $instr));
				//$row = $query->row(); 
				//$iTotal = $row['cnt'];
				//$iTotal = 1000000;
		//log_message('debug', 'cvedit get_dtdata $sEcho = '. $sEcho);
    
        // Paging
  //      if(isset($iDisplayStart) && $iDisplayLength != '-1')
//        {
//            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
//        }
//        
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
		$iFilteredTotal = 50000; // Meanwhile
    
       
    
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
		//log_message('debug', '(after query) $iDisplayStart = ' . $iDisplayStart . '$iDisplayLength = ' . $iDisplayLength);
		//$query = $this->db->query($sql, array($stat, $instr, 0, 10));
       //$query = $this->db->query($sql, array(1, 1, 0, 10));
	   log_message('debug', 'Entering foreach $aRow');
	   if ($query->num_rows() > 0)
	   {
	    foreach ($query->result_array() as $aRow)
        {
            $row = array();
            //log_message('debug', 'inside foreach $query->result() as $aRow');
            foreach($aColumns as $col)
            {
				//log_message('debug', 'inside foreach $aColumns as $col');
              $row[] = $aRow[$col];
            }
    		//log_message('debug', 'cvedit $row = ', print_r($row));
            $output['aaData'][] = $row;
        }
	   }
	   else
	   {
		   log_message('debug', 'query had no rows');
	   }
		//log_message('debug', 'cvedit $output = ', print_r($output));
    	//$this->output->set_header('Content-Type: application/json; charset=utf-8');
       echo json_encode($output);
    }
}
	
