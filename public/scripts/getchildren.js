$(document).ready(function(){
    $.ajax({
		method: 'GET',
		url: 'api/child/index.php',
		//dataType: "json",
		//data: 'client_id=' + $("#client_id").val(),
		//data: params, ====> Data can be passed as a string, array, or JSON
		success: function(children){
			console.log(children);
			for(var i = 0; i < children.length; i++){
                $("#children").append("<li>" + children[i] + "</li>");   
			}	    
		}
	})
	.error(function(error){
	    console.log(error);
	    $("#children").html(error);
	});
});