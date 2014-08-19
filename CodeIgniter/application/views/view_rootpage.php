<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>rootPage</title>
<link href="jquery-mobile/jquery.mobile.theme-1.3.0.min.css" rel="stylesheet" type="text/css">
<link href="jquery-mobile/jquery.mobile.structure-1.3.0.min.css" rel="stylesheet" type="text/css">
<script src="jquery-mobile/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="jquery-mobile/jquery.mobile-1.3.0.min.js" type="text/javascript"></script>
</head>

<body>
<div data-role="page" id="page">
  <div data-role="header">
    <h1>aqmdata</h1>
  </div>
  <div data-role="content">
  <div data-role="collapsible-set">
  <div data-role="collapsible">
   <h3>Data Viewer</h3>
   <div data-role="controlgroup"><a href="cvselect" data-ajax="false" data-role="button">Current Values</a><a href="charts" data-ajax="false" data-role="button">Parameter</a><a href="atselect" data-ajax="false" data-role="button">Analyser</a><a href="parcom" data-ajax="false" data-role="button">Parameter Comparison</a></div>
   
  </div>
  <div data-role="collapsible">
   <h3>Station Configuration</h3>
   <div data-role="controlgroup"><a href="sciselect" data-ajax="false"  	data-role="button">Inventory</a><a href="#" data-role="button">Edit CR3000 Config File</a><a href="#" data-role="button">Alarms Configuration</a></div>
   
  </div>
  <div data-role="collapsible">
   <h3>Maintenance</h3>
   <div data-role="controlgroup"><a href="#" data-role="button">Button</a><a href="#" data-role="button">Button</a><a href="#" data-role="button">Button</a><a href="#" data-role="button">Button</a></div>
   
  </div>
  <div data-role="collapsible">
   <h3>Reference</h3>
   <div data-role="controlgroup"><a href="#" data-role="button">Button</a><a href="#" data-role="button">Button</a><a href="#" data-role="button">Button</a><a href="#" data-role="button">Button</a></div>
   
  </div>
  </div>
  
  </div>
  <div data-role="footer">
    <h4><a href="/" data-role="button" data-ajax="false" data-icon="back">Back</a></h4>
  </div>
</div>
</body>
</html>