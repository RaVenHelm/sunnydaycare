$(document).ready(function(){
    $("#submit").click(function() {
        //TODO: Validations
        var child = {};
        child.firstname = ($("#child_firstname").val());
        child.lastname = ($("#child_lastname").val());
        child.detailed = ($("#isDetailed").prop("checked"));
        $.ajax({
    		method: 'GET',
    		url: '../../../api/child/getchild.php',
    		data: 'firstname=' + child.firstname + '&' + 'lastname=' + child.lastname + '&' + 'isDetailed=' + (child.detailed ? 1 : 0),
    		success: function(result){
    		    //console.log(child.detailed);
    		    if(result != false){
    			    $(".result").html(result);	  
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