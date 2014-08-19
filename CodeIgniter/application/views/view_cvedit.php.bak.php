<html>
  <head>

    <link href="js/jtable/themes/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
	<link href="js/jtable/themes/lightcolor/blue/jtable.css" rel="stylesheet" type="text/css" />
	
	<script src="jquery-mobile/jquery-1.8.3.min.js" type="text/javascript"></script>
    <script src="jquery-mobile/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
    <script src="js/jtable/jquery.jtable.js" type="text/javascript"></script>
    <script src="js/jquery.cookie.js" type="text/javascript"></script>
	
  </head>
  <body>
	<div id="ParameterTableContainer" style="width: 600px;"></div>
  <script type="text/javascript">

		$(document).ready(function () {

		    //Prepare jTable
			$('#ParameterTableContainer').jtable({
				title: 'Table of parameters',
				paging: true, //Enable paging
            	pageSize: 10, //Set page size (default: 10)
				actions: {
					listAction: '/index.php/cvedit/get_data',
					createAction: 'ParameterActions.php?action=create',
					updateAction: 'ParameterActions.php?action=update',
					deleteAction: 'ParameterActions.php?action=delete'
				},
				fields: {
					id_data_numeric: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					parname: {
						title: 'Parameter',
						width: '40%'
					},
					value_avg: {
						title: 'Average',
						width: '20%'
					},
					
					value_max: {
						title: 'Maximum',
						width: '20%'
					},
					
					value_min: {
						title: 'Minimum',
						width: '20%'
					}
				}
			});

			//Load paraemter list from server
			$('#ParameterTableContainer').jtable('load');

		});

	</script>
    <div data-role="footer">
    <h4>
    <div class="ui-grid-a">
        <div class="ui-block-a"><a href="cvselect" data-role="button" data-icon="back">Back</a></div>
    </h4>
    </div>
 
  </body>
</html>
