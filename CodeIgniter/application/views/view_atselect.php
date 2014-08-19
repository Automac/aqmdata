<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Select Parameters</title>
<link href="jquery-mobile/jquery.mobile.theme-1.3.0.min.css" rel="stylesheet" type="text/css">
<link href="jquery-mobile/jquery.mobile.structure-1.3.0.min.css" rel="stylesheet" type="text/css">

<script src="jquery-mobile/jquery-1.8.3.min.js" type="text/javascript"></script>
<!--<script src="js/cvselect.js" type="text/javascript"></script>-->
<script src="js/atscript.js" type="text/javascript"></script>
<script src="jquery-mobile/jquery.mobile-1.3.0.min.js" type="text/javascript"></script>
<script src="js/jquery.cookie.js" type="text/javascript"></script>
<script src="js/highstock.js"></script>
<script src="js/modules/exporting.js"></script>

</head>

<body>
<div data-role="page" id="page">
  <div data-role="header">
    <h1>aqmdata</h1>
  </div>
  <div data-role="content">
    <div data-role="fieldcontain" class="ui-hide-label">
      <!--<label for="sel_station" class="select"  >Select Station:</label>-->
      <select name="sel_station" id="sel_station" data-native-menu="false">
        <?php echo $this->Atselect_model->get_stations(); ?>
      </select>
    </div>
    <div data-role="fieldcontain" class="ui-hide-label">
      <!--<label for="sel_instrument" class="select"  >Select Instrument:</label>-->
      <select name="sel_instrument" id="sel_instrument" data-native-menu="false">
        <option >Select Instrument</option>
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
            
  </div>
  <div data-role="footer">
    <h4>
      <div class="ui-grid-a">
        <div class="ui-block-a"><a href="rootpage" data-role="button" data-icon="back">Back</a></div>
        <div class="ui-block-b"><a data-ajax="false" data-role="button" name="submit_query"  id = "submit_query">Submit</a></div>
      </div>
    </h4>
  </div>
</div>
<div data-role="page" id="page2">
       <div data-role="header" >
	    	<h1>Analyser</h1>
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