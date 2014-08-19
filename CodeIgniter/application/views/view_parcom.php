<?php if( ! defined('BASEPATH') ) exit('No direct script access allowed');
/**
 * WTG
 */
?><!DOCTYPE html>
<html lang="en">
<head>
	
<link href="jquery-mobile/jquery.mobile.theme-1.3.0.min.css" rel="stylesheet" type="text/css">
<link href="jquery-mobile/jquery.mobile.structure-1.3.0.min.css" rel="stylesheet" type="text/css">

<script src="jquery-mobile/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="js/parcom.js" type="text/javascript"></script>
<script src="jquery-mobile/jquery.mobile-1.3.0.min.js" type="text/javascript"></script>
<script src="js/highstock.js"></script>
<script src="js/modules/exporting.js"></script>
<!--
<script src="http://code.highcharts.com/highcharts.js"></script>

--></head>
	<!--
	<script src="js/jquery.mobile-1.4.2.js"></script>
-->	

  <body>
	<div data-role="content">
		<div data-role="page" id="page" >
	  		<div data-role="header" >
	    		<h1>Parameter Comparison</h1>
	  		</div><!-- /header -->
  	
          
	      	<div data-role="fieldcontain">
	      	<!--<label for="sel_instrument" class="ui-select"></label>-->
	  	  	<select name="sel_instrument" id="sel_instrument" data-native-menu="false">
	  			<?php echo $this->Parcom_model->get_instruments(); ?>
	      	</select> 
	      	</div>
        
	        <div data-role="fieldcontain">
	      	<!--<label for="sel_parameter" class="ui-select"></label>-->
	  	  	<select name="sel_parameter" id="sel_parameter" data-native-menu="false">
	  			<option value="0">-- Parameter --</option>
	      	</select>
	        </div>
            <div data-role="fieldcontain">
	          <!--<label for="selectmenu" class="select">Options:</label>-->
	          <select name="selectnumdays" id="selectnumdays" data-native-menu="false">
	            <option value="option1">One Day</option>
	            <option value="option7">One Week</option>
	            <option value="option14">Two Weeks</option>
                <option value="option30">Thirty Days</option>
                <option value="option90">Ninety Days</option>
                <option value="option180">Six Months</option>
                <option value="option365">One Year</option>
              </select>
          </div>
            
        
	  		
	 <div data-role="footer">
    <h4>
      <div class="ui-grid-a">
        <div class="ui-block-a"><a href="rootpage" data-role="button" data-icon="back">Back</a></div>
        <div class="ui-block-b"><a data-ajax="false" data-role="button" name="submit_query"  id = "submit_query">Submit</a></div>
      </div>
    </h4>
  </div>
	  		<!-- /footer -->
		</div><!-- /Page -->
    
	<div data-role="page" id="page2">
        <div data-role="header" >
	    		<h1>Data Viewer</h1>
	  		</div>
    	
	        	
	            <div id="container" style="width:100%; height:80%;"></div>
                <div data-role="footer">
    <h4>
      
        <div><a href="rootpage" data-role="button" data-icon="back">Back</a></div>
       
        </h4>
	    </div>
	</div>
  </body>
</html>