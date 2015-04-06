/* 
 * Simple use of an AJAX JQuery Call
 * Flickr API Key: a6df65ab22ae2539575ab0427c4393d8
 */
$(document).ready(function (){
	$.ajax("https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=a6df65ab22ae2539575ab0427c4393d8&tags=Fire&format=json&nojsoncallback=1")
		.done(function(data) {
			alert("Success!");
			//console.log(data);
			//$("#photoResult").html(data.photos.photo[1].title);
			
			//console.log(titles);
			for(var i = 0; i < data.photos.photo.length; i++){
				$("#titles").append("<li>" + data.photos.photo[i].title + "</li>");
			} 
		})
		.fail(function(data){
			alert("Failure!");
			console.log(data);
		});
		
	
});


/* function getTitles(photos){
	var result = [];
	for (var i = 0; i < photos.length; i++){
		result[i] = photos[i];
	}
	
	return result;
} */