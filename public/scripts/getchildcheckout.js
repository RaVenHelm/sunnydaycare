$(document).ready(function(){
    $("#submit").click(function() {
        //TODO: Validations
        var child = {};
        child.firstname = ($("#child_firstname").val());
        child.lastname = ($("#child_lastname").val());
        $.ajax({
    		method: 'GET',
    		url: '../../../api/child/getchild.php',
    		data: 'firstname=' + child.firstname + '&' + 'lastname=' + child.lastname,
    		success: function(result){
    		  //console.log(result);
    		    if(result != false){
    			    $(".result").html(result + " <button id=\"checkin\">Check In</button> <button id=\"checkout\">Check Out</button>");	  
    		    } else {
    		        $(".result").html("<p class=\"error\">No child found</p>");
    		    } 
    		}
    	})
    	.error(function(error){
    	    console.log(error);
    	    $("#result").html(error);
    	});
    });
});