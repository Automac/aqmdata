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
    <h1>View Analysers</h1>
  </div>
  <div data-role="content">
    <table id="dtTable" data-role="table" data-mode="columntoggle" class="ui-responsive table-stripe" >
        <thead>
            <tr>
                <th>Parameter</th>
                <th>Serial No</th>
            </tr>
        </thead>
        <tbody>
 <?php echo $this->Ivats_model->get_rows(); ?>
 </tbody>
        <tfoot>
            <tr>
                <th>Parameter</th>
                <th>Serial No</th>
            </tr>
        </tfoot>
    </table>
  </div>
  <div data-role="footer">
    <h4><a href="sciselect" data-role="button" data-ajax="false" data-icon="back">Back</a></h4>
  </div>
</div>
</body>
</html>