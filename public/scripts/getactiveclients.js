$(document).ready(function(){
    $.ajax({
		method: 'GET',
		url: 'api/client/index.php',
		//dataType: "html",
		//data: 'client_id=' + $("#client_id").val(),
		//data: params, ====> Data can be passed as a string, array, or JSON
		success: function(clients){
			$("#serviceResult").html(clients);	    
		}
	})
	.error(function(error){
	    console.log(error);
	    $("#children").html(error);
	});
});