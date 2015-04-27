$(document).ready(function () {
	'use strict';
	$("#login").submit(function (event) {
		//TODO: Add password RegExp
		var errors = [],
			max_length = 25,
			min_length = 8,
			errorElement = $("#error"),
			forbidden = new RegExp(/[\[\(\);"'.,\\|\]\/]/),
			index = 0;
		//Clear out error div before reuse
		errorElement.html("");
		//Validate both inputs have values
		if ($("#username").val().trim() === "" || $("#password").val().trim() === "") {
			errors.push("Username or password can't be blank");
		}
		//Check for forbidden chars
		if (forbidden.exec($("#username").val().trim()) || forbidden.exec($("#password").val().trim())) {
			errors.push("Forbidden characters: " + ["[]", ",", "\\", ".", "|", "(", ")"].join(" "));
		}
		//Username validations
		if ($("#username").val().length > max_length) {
			errors.push("Username can't be more than " + max_length + " character long");
		}
		if ($("#username").val().length < min_length) {
			errors.push("Username can't be less than " + min_length + " characters long");
		}
		//Password validations
		if ($("#password").val().length > max_length) {
			errors.push("Password can't be more than " + max_length + " character long");
		}
		if ($("#password").val().length < min_length) {
			errors.push("Password can't be less than " + min_length + " characters long");
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