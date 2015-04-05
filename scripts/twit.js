/* WARNING!!!
 * Ty: Haven't tested this code yet
 *
 */
$(document).ready(function (){
	$.ajax("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=twitterapi&count=2")
		.done(function(data) {
			alert("Success!");
			console.log(data);
		})
		.fail(function(data){
			alert("Failure!");
			console.log(data);
		});
});