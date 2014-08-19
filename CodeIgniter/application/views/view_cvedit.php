<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>

<link href="jquery-mobile/jquery.mobile.theme-1.3.0.min.css" rel="stylesheet" type="text/css">
<link href="jquery-mobile/jquery.mobile.structure-1.3.0.min.css" rel="stylesheet" type="text/css">
<script src="jquery-mobile/jquery-1.8.3.min.js" type="text/javascript"></script>



<script src="jquery-mobile/jquery.mobile-1.3.0.min.js" type="text/javascript"></script> 


</head>

<body>
<div data-role="page" id="page">
  <div data-role="header">
    <h1>Parameter Values</h1>
  </div>
  <div data-role="content">
    <table id="dtTable" data-role="table" data-mode="columntoggle" class="ui-responsive table-stripe" >
        <thead>
            <tr>
            		<th data-priority="6">Timestamp</th>
                <th>Parameter</th>
                <th data-priority="4">Average</th>
                <th>Max</th>
                <th>Min</th>
            </tr>
        </thead>
        <tbody>
 <?php echo $this->Cvedit_model->get_rows(); ?>
 </tbody>
        <tfoot>
            <tr>
            	<th>Timestamp</th>
                <th>Parameter</th>
                <th>Average</th>
                <th>Max</th>
                <th>Min</th>
            </tr>
        </tfoot>
    </table>
  </div>
  <div data-role="footer">
    <h4><a href="cvselect" data-role="button" data-ajax="false" data-icon="back">Back</a></h4>
  </div>
</div>
</body>
</html>