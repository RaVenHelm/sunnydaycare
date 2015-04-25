$(document).ready(function(){
    $.ajax({
		method: 'GET',
		url: '/sunnydaycare/api/client/index.php',
		success: function(clients){
			$("#serviceResult").html(clients);	    
		}
	})
	.error(function(error){
	    console.log(error);
	    $("#serviceResult").html(error);
	});
});