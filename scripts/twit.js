/* 
 * Simple use of an AJAX JQuery Call
 * Flickr API Key: a6df65ab22ae2539575ab0427c4393d8
 */
$(document).ready(function (){
	$.ajax("https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=7f0c439ac459799265eb7fbbfd6c8117&tags=Fire&format=json&nojsoncallback=1&api_sig=469542d7601f559b0a1007a0e4283bda")
		.done(function(data) {
			alert("Success!");
			console.log(data);
		})
		.fail(function(data){
			alert("Failure!");
			console.log(data);
		});
});