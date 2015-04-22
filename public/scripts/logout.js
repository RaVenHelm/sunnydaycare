$(document).ready(function(){
    $("#logout").click(function(){
       $.ajax({
    		method: 'GET',
    		url: 'logout.php',
    	})
    	.error(function(error){
    	    console.log(error);
    	}); 
    });
});