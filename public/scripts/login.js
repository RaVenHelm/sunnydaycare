$(document).ready(function () {
	'use strict';
	$("#login").click(function (event) {
		if ($("#username").val() === "" || $("#password").val() === "") {
			$("#error").html("Username nor password can be blank");
			event.preventDefault();
		}
	});
});