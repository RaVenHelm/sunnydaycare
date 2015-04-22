$(document).ready(function(){
    $.ajax({
		method: 'GET',
		url: 'api/child/index.php',
		//dataType: "html",
		//data: 'client_id=' + $("#client_id").val(),
		//data: params, ====> Data can be passed as a string, array, or JSON
		success: function(children){
			$("#serviceResult").html(children);	    
		}
	})
	.error(function(error){
	    console.log(error);
	    $("#children").html(error);
	});
});