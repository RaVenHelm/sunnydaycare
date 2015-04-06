/* 
 * Simple use of an AJAX JQuery Call
 * Flickr API Key: a6df65ab22ae2539575ab0427c4393d8
 */
$(document).ready(function (){
	$.ajax("https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=a6df65ab22ae2539575ab0427c4393d8&tags=Fire&format=json&nojsoncallback=1")
		.done(function(data) {
			console.log("Success!");
			//$("#photoResult").html(data.photos.photo[1].title);
			
			for(var i = 0; i < data.photos.photo.length; i++){
				$("#titles").append("<li>" + data.photos.photo[i].title + "</li>");
			} 
		})
		.fail(function(data){
			console.log("Failure!");
			console.log(data);
		});
		
	
});