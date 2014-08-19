<?php if( ! defined('BASEPATH') ) exit('No direct script access allowed');
/**
 * WTG
 */
?><!DOCTYPE html>
<html lang="en">
<head>
	
<!--
	<script type="text/javascript" src="http://localhost:8080/js/jquery.js"></script>
	<script type="text/javascript" src="http://localhost:8080/js/js/highcharts.js"></script>

	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
	<style type="text/css">

-->
    <meta charset="utf-8">
    <title>A Christmas Carol</title>

   
	<?php echo link_tag( array( 'href' => 'css/03.css', 'type' => 'text/css', 'rel' => 'stylesheet' ) ) . "\n";?>
	<link rel="stylesheet" href="css/jquery.mobile-1.3.2.min.css" />
	
<!--	
	<script src="js/jQuery.js"></script>
	-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/scripts.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquerymobile/1.4.2/jquery.mobile.js"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
	
	<!--
	<script src="js/jquery.mobile-1.4.2.js"></script>
-->	

  <body>
	<div data-role="content">
		<div data-role="page" id="page" data-theme="b">
	  		<div data-role="header" data-theme="c">
	    		<h1>Data Viewer</h1>
	  		</div><!-- /header -->
  	
	  		<div data-role="fieldcontain">
	  	  	<!--<label for="sel_station" class="ui-select"></label>-->
	  	  	<select name="sel_station" id="sel_station">
	  		<?php echo $this->Scripts_model->get_locations(); ?>
	        </select>
	        </div>
           
	      	<div data-role="fieldcontain">
	      	<!--<label for="sel_instrument" class="ui-select"></label>-->
	  	  	<select name="sel_instrument" id="sel_instrument">
	  			<option value="0">-- Instrument --</option>
	      	</select> 
	      	</div>
        
	        <div data-role="fieldcontain">
	      	<!--<label for="sel_parameter" class="ui-select"></label>-->
	  	  	<select name="sel_parameter" id="sel_parameter">
	  			<option value="0">-- Parameter --</option>
	      	</select>
	        </div>
        
	  		<div class="ui-body ui-body-b">
			<fieldset class="ui-grid-a">
	        	<div data-role="fieldcontain">
					<div class="ui-block-a"><button type="button" data-theme="d">Cancel</button></div>
					<!--<div class="ui-block-b"><button type="submit" name="select_form" id="select_form" data-theme="a" >Submit</button></div>-->
	                <div class="ui-block-b"><button type="button" data-theme="a" name="submit_query" id="submit_query">Submit</button></div>
	            </div>    
		    </fieldset>
			</div>
 		
	  		<div data-role="footer" class="footer-docs" data-theme="c">
	              <p align="center"><em>2013 Automac Technical Services</em></p>
	  		</div><!-- /footer -->
		</div><!-- /Page -->
    
		<div data-role="page" id="page2">
    	
	        	<!--<div id="result"></div>
	            <div id="stat"></div>
	            <div id="instr"></div>
	            <div id="para"></div>-->
	            <div id="container" style="width:100%; height:100%;"></div>
        
	    </div>
	</div>
  </body>
</html>