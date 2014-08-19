<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Select Parameters</title>
<link href="jquery-mobile/jquery.mobile.theme-1.3.0.min.css" rel="stylesheet" type="text/css">
<link href="jquery-mobile/jquery.mobile.structure-1.3.0.min.css" rel="stylesheet" type="text/css">

<script src="jquery-mobile/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="js/cvselect.js" type="text/javascript"></script>
<script src="jquery-mobile/jquery.mobile-1.3.0.min.js" type="text/javascript"></script>
<script src="js/jquery.cookie.js" type="text/javascript"></script>

</head>

<body>
<div data-role="page" id="page">
  <div data-role="header">
    <h1>aqmdata</h1>
  </div>
  <div data-role="content">
    <div data-role="fieldcontain" class="ui-hide-label">
      <label for="sel_station" class="select"  >Select Station:</label>
      <select name="sel_station" id="sel_station" data-native-menu="false">
        <?php echo $this->Sciselect_model->get_stations(); ?>
      </select>
    </div>
  </div>
  <div data-role="footer">
    <h4>
      <div class="ui-grid-b">
        <div class="ui-block-a"><a href="rootpage" data-role="button" data-icon="back">Back</a></div>
        <div class="ui-block-b"><a href="ivats" data-ajax="false" data-role="button" id = "vsubmit">View Analyser</a></div>
        <div class="ui-block-c"><a href="ireps" data-ajax="false" data-role="button" id = "rsubmit">Replace Analyser</a></div>
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
           }
        );
</script>
</body>
</html>