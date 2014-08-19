// This is the custom JavaScript file referenced by index.html. You will notice
// that this file is currently empty. By adding code to this empty file and
// then viewing index.html in a browser, you can experiment with the example
// page or follow along with the examples in the book.
//
// See README.txt for more information.

	$(document).bind("pageinit",function(){
			$("select#sel_parameter").selectmenu('disable');
			$("select#sel_instrument").selectmenu('disable');
			
			$("select#sel_station").bind("change",function(){
				$("select#sel_instrument").selectmenu('disable');
				$("select#sel_instrument").html("<option>-- wait --</option>");
				$("select#sel_parameter").selectmenu('disable');
				$("select#sel_parameter").html("<option>-- wait --</option>>");
					var id = $("#sel_station").val();
				$.post("/index.php/charts/select_instrument/" + id, function(data){
					$("select#sel_instrument").selectmenu('enable');
					$("select#sel_instrument").html(data);
					$("#sel_instrument").selectmenu('refresh', true);
				});
			});

			$("select#sel_instrument").bind("change",function(){
				$("select#sel_parameter").selectmenu('disable');
				$("select#sel_parameter").html("<option>-- wait --</option>>");
				var id = $("#sel_instrument").val();
				$.post("/index.php/charts/select_parameter/" + id, function(data){
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
				var chart;
				//$.post("get_data.php", {stat:stat, instr:instr, para:para }, function(data){
					//$(document).on('pageshow', '#page2', function(){    
					    $(document).ready(function() {
					
							var options = {
								chart: {
			                		renderTo: 'container'
			                		//type: 'line',
			                		//marginRight: 130,
			                		//marginBottom: 25
			            		},
			            		title: {
			                		text: 'Analyser Parameter',
			                		x: -20 //center
			            		},
			            		subtitle: {
			                		text: 'WBEA Diagnostics Database',
			                		x: -20
			            		},
								plotOptions: {
									spline: {
										turboThreshold: 2000,
									
										}
								},
			            		xAxis: {
			                		type: 'datetime',
									pointInterval: 3600 * 1000,
									//tickInterval: 3600 * 60, //one minute
									//tickwidth: 0,
									gridlineWidth: 1,
									labels: {
										align: 'center',
										x: -3,
										y: 20,
										formatter: function() {
											return Highcharts.dateFormat('%H%M', this.value);
										}
									}
			            		},
			            		yAxis: {
			                		title: {
										text: 'Units'
			            			},
									plotLines: [{
										value: 0,
										width: 1,
										color: '#808080'
									}]
								},
								legend: {
									layout: 'vertical',
									align: 'right',
									verticalAlign: 'top',
									x: -10,
									y: 100,
									borderWidth: 0
								},
			            		series: [{
									name: 'Parameter'
								}]
							}
								
							jQuery.post("/index.php/charts/get_data/" + stat + "/" + instr + "/" + para, null, function(numdata) {
								var line = [];
								var value = [];
								try {
									// split the data return into lines and parse them
									numdata = numdata.split(/\n/g);
									jQuery.each(numdata, function(i, line) {
										line = line.split(/\t/);
										//date = Date.parse(line[0].replace(' ', 'T') + 'Z');
										value.push([
										parseInt(line[0]),
										parseFloat(line[1].replace(',', ''), 10)									
										]);
									});
								} catch (e) { }
								options.series[0].data = value;
								chart = new Highcharts.StockChart(options);
							});
						});
		});
	});

