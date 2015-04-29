$(document).ready(function () {
	'use strict';
	$("#lookup").submit(function (event) {
		var errors = [], errorElement = $("#error"), index = 0;
		errorElement.html("");
		$(".result").html("");
		if ($("#firstname").val().trim() === "" || $("#lastname").val().trim() === "") {
			errors.push("First/Last name cannot be blank");
		}
		//Check for if any errors exist
		if (errors.length > 0) {
			event.preventDefault();
			errorElement.append("<ul>");
			for (index; index < errors.length; index++) {
				errorElement.append("<li>" +  errors[index] + "</li>");
			}
			errorElement.append("</ul>");
		}
	});
});