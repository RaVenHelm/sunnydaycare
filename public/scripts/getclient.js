$(document).ready(function () {
	'use strict';
	//Validate data before it goes out to server
	$('#submit').click(function () {
		if ($('#client_firstname').val() === "" || $('#client_lastname') === "") {
			alert("First/last name can't be blank");
		} else {
			var fname = $('#client_firstname').val(), lname = $('#client_lastname').val(), result = $('.result');
			$.ajax({
				method: 'get',
				url: '/sunnydaycare/api/client/search.php',
				data: 'firstname=' + fname + '&' + 'lastname=' + lname,
				success: function (data) {
					if (data !== false) {
						result.html(data);
					} else {
						alert("No good: " + data);
					}
				}
			});
		}
	});
});