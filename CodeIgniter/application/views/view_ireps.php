<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Select Parameters</title>
<link href="jquery-mobile/jquery.mobile.theme-1.3.0.min.css" rel="stylesheet" type="text/css">
<link href="jquery-mobile/jquery.mobile.structure-1.3.0.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet"  href="jquery-mobile/jquery.mobile-1.2.0-rc.2.css" />
<link rel="stylesheet" href="jquery-mobile/jqm-docs.css"/>

<script src="jquery-mobile/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="jquery-mobile/jquery.mobile-1.3.0.min.js" type="text/javascript"></script>
<script src="js/jquery.cookie.js" type="text/javascript"></script>

</head>

<body>
<div data-role="page" id="page">

<div data-role="popup" id="popupConfirm" data-overlay-theme="a" data-theme="a" style="max-width:400px;" class="ui-corner-all">
			<div data-role="header" data-theme="a" class="ui-corner-top">
				<h1>Commit Change?</h1>
			</div>
			<div data-role="content" data-theme="a" class="ui-corner-bottom ui-content">
				<h3 class="ui-title">Are you sure you want to update the inventory?</h3>
				<p>This action cannot be undone. (Does nothing for now)</p>
				<a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Cancel</a>    
				<a href="#" data-role="button" data-inline="true" data-rel="back" data-transition="flow" data-theme="b">Confirm</a>  
			</div>
		</div>
  <div data-role="header">
    <h1>aqmdata</h1>
  </div>
  <div data-role="content">
    <div data-role="fieldcontain" class="ui-hide-label">
      <label for="sel_inst_rem" class="select"  >Select Instrument To Remove:</label>
      <select name="sel_inst_rem" id="sel_inst_rem" data-native-menu="false">
        <?php echo $this->Ireps_model->get_instr_remove(); ?>
      </select>
    </div>
    <div data-role="fieldcontain" class="ui-hide-label">
      <label for="sel_inst_rep" class="select"  >Select Instrument To Install:</label>
      <select name="sel_inst_rep" id="sel_inst_rep" data-native-menu="false">
        <?php echo $this->Ireps_model->get_instr_replace(); ?>
      </select>
    </div>
  </div>
  <div data-role="footer">
    <h4>
      <div class="ui-grid-a">
        <div class="ui-block-a"><a href="rootpage" data-role="button" data-icon="back">Back</a></div>
        <div class="ui-block-c"><a href="#" data-ajax="false" data-role="button" data-role="button" id = "rsubmit">Commit Location Change</a></div>
          

      </div>
    </h4>
  </div>
</div>



<script>

        $("#vsubmit").click( function()
           {
				$.cookie('the_station', $("#sel_station").val());
           }
        );
</script>
<script>

        $("#rsubmit").click( function()
           {
				$.cookie('the_station', $("#sel_station").val());
				
				$( "#popupConfirm" ).popup( "open" );
           }
        );
</script>
</body>
</html>