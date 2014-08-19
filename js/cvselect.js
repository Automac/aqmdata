// JavaScript Document
	$(document).bind("pageinit",function(){
			$("select#sel_instrument").selectmenu('disable');
			
			$("#changeme").bind("click",function(){
				$("#changeme").attr("href", 'cvedit/' + $("#sel_station").val() + '/' + $("#sel_instrument").val());
			});
			
			$("select#sel_station").bind("change",function(){
				$("select#sel_instrument").selectmenu('disable');
				$("select#sel_instrument").html("<option>-- wait --</option>");
					var id = $("#sel_station").val();
				$.post("/index.php/cvselect/select_instrument/" + id, function(data){
					$("select#sel_instrument").selectmenu('enable');
					$("select#sel_instrument").html(data);
					$("#sel_instrument").selectmenu('refresh', true);
				});
			});

});
