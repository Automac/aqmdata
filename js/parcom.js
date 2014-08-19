	$(document).bind("pageinit",function(){
			$("select#sel_parameter").selectmenu('disable');
			//$("select#sel_instrument").selectmenu('disable');
			
//			$("select#sel_station").bind("change",function(){
//				$("select#sel_instrument").selectmenu('disable');
//				$("select#sel_instrument").html("<option>-- wait --</option>");
//				$("select#sel_parameter").selectmenu('disable');
//				$("select#sel_parameter").html("<option>-- wait --</option>>");
//					var id = $("#sel_station").val();
//				$.post("/index.php/parcom/select_instrument/" + id, function(data){
//					$("select#sel_instrument").selectmenu('enable');
//					$("select#sel_instrument").html(data);
//					$("#sel_instrument").selectmenu('refresh', true);
//				});
//			});

			$("select#sel_instrument").bind("change",function(){
				$("select#sel_parameter").selectmenu('disable');
				$("select#sel_parameter").html("<option>-- wait --</option>>");
				var id = $("#sel_instrument").val();
				$.post("/index.php/parcom/select_parameter/" + id, function(data){
					$("select#sel_parameter").selectmenu('enable');
					$("select#sel_parameter").html(data);
					$("#sel_parameter").selectmenu('refresh', true);
				});
			});
	
		
			$("#submit_query").on("click touch",function(event){
				
				$.mobile.changePage("#page2", {transition: "flip"} );
				var stat= $("#sel_station").val(); //this variable contains the id_location
				var instr = $("#sel_instrument").val(); //this variable contains the id_inventory
				var para = $("#sel_parameter").val(); //this variable contains the id_parameter
				var nums = $("#selectnumdays").val().substr(6); //this variable contains number of days to plot
				nums = parseInt(nums) * 288;
				var avgorall = $("#selectmaxmin").val();
				var names = ['value_avg', 'value_max', 'value_min'];
				var chart;
				var seriesOptions = [];
				
					    $(document).ready(function() {
					
							var options = {
								
								title : {
								  text : $("select[id=sel_instrument] option:selected").text() + ' ' + $("select[id=sel_parameter] option:selected").text()
								},
								  
								rangeSelector : {
								selected : 1,
								inputEnabled: $('#container').width() > 480
								},
												chart: {
			                		renderTo: 'container',
			            		},
			            		
								
			            		xAxis: {
			                		type: 'datetime'
									
			            		},
						
								legend: {
									align: 'right',
									layout: 'vertical',
									verticalAlign: 'top',
									x: 0,
									y: 100,
									enabled : true
								},
			            		
			            		tooltip: {
									pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
									valueDecimals: 2
								}
							}
							Highcharts.setOptions({
								global: {
									useUTC: false
								}
							});

							$.mobile.loading('show');
								$.getJSON("/index.php/parcom/get_datam/" + instr + "/" + para + "/" + nums, null, function(numdata) {
									$.each( numdata, function( key, value ) {
  										seriesOptions[key] = {
										name: numdata[key][0],
										data: numdata[key][1]
									};
									});
										
									Highcharts.setOptions({
									  global: {
										  useUTC: false
									  }
								  });

								options.series = seriesOptions;
								$.mobile.loading('hide');
								chart = new Highcharts.StockChart(options);
							})
							
						});
		});
	});

