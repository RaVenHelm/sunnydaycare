/* 
 * Simple use of an AJAX JQuery Call
 * Flickr API Key: a6df65ab22ae2539575ab0427c4393d8
 */
$(document).ready(function (){
	$("#photoSubmit").click(function(){
		var urlString = "https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=a6df65ab22ae2539575ab0427c4393d8&";
		urlString += "&tags=" + $("#searchText").val();
		urlString += "&format=json&nojsoncallback=1";
		
		//Clear the photoresult div
		$("#titles").html("");
		
		$.ajax(urlString)
			.done(function(data) {
				console.log("Success!");
				console.log(data);
				//$("#photoResult").html(data.photos.photo[1].title);
				
				
				for(var i = 0; i < data.photos.photo.length; i++){
					var photo = data.photos.photo[i];
					//getFlickrJpg(photo.farm, photo.server, photo.id, photo.secret)
					$("#titles").append("<li>" + photo.title + "<br /><img src='" + getFlickrJpg(photo.farm, photo.server, photo.id, photo.secret) + "' alt='" + photo.title + "'/></li>");
				} 
			})
			.fail(function(data){
				console.log("Failure!");
				console.log(data);
				$("#photoResult").html("Could not connect to Flickr");
			});
	});
});

function getFlickrJpg(farmID, server, photoID, secret){
	//Template https://farm{farm-id}.staticflickr.com/{server-id}/{id}_{secret}.jpg
	var url = "https://farm" + farmID + ".staticflickr.com/" + server + "/" + photoID + "_" + secret + ".jpg";
	// console.log(url);
	// var ajax = $.ajax(url);
	// //console.log(ajax);
	// var response = ajax.resoponseText;
	// if(response !== null){
	// 	console.log(atob(response));
	// }
	return url;
}