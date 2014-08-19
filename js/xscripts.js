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
				var nums = $("#selectnumdays").val().substr(6); //this variable contains number of days to plot
				nums = parseInt(nums) * 288;
				var chart;
				//$.post("get_data.php", {stat:stat, instr:instr, para:para }, function(data){
					//$(document).on('pageshow', '#page2', function(){    
					    $(document).ready(function() {
					
							var options = {
								title : {
								  text : $("select[id=sel_station] option:selected").text() + ' ' + $("select[id=sel_instrument] option:selected").text() + ' ' + $("select[id=sel_parameter] option:selected").text()
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
			            		
			            		series: [{
									name: 'Xtest Param'
								}]
							}
							//$.getJSON('http://www.highcharts.com/samples/data/jsonp.php?filename=aapl-c.json&callback=?', function(numdata)	{
							//jQuery.post("/index.php/xtest/get_data/" + stat + "/" + instr + "/" + para, null, function(numdata) {
								$.getJSON("/index.php/xtest/get_data/" + stat + "/" + instr + "/" + para + "/" + nums, null, function(numdata) {
								 
								var line = [];
								var value = [];
								try {
									jQuery.each(numdata, function(i, line) {
										value.push([
										parseInt(line[0]),
										parseFloat(line[1])									
										]);
									});
								} catch (e) { }
								options.series[0].data = numdata;
								chart = new Highcharts.StockChart(options);
							});
						});
		});
	});

