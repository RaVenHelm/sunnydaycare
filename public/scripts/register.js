$(document).ready(function () {
	'use strict';
	var errorElement = $(".error");
	$("#bday").datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: '-5y',
        maxDate: '-1m -14d',
        changeMonth: true,
        changeYear: true,
        yearRange: 'c-5:c'
    });
	//Check for errors before sending to server
	$("#registerForm").submit(function (event) {
		var errors = [], index = 0;
		//Clear previous errors
		errorElement.html("");
		$(".result").html("");
		if ($("#firstname").val().trim() === "" || $("#lastname").val().trim() === "") {
			errors.push("First/Last name cannot be blank");
		}
		if ($("#mailing").val().trim() === "" || $("#billing").val().trim() === "") {
			errors.push("Address cannot be blank");
		}
		if ($("#gender").val() === "") {
			errors.push("Gender cannot be null");
		}
		//Check for if any errors exist
		if (errors.length > 0) {
			event.preventDefault();
			errorElement.append("<ul>");
			for (index; index < errors.length; index++) {
				errorElement.append("<li>" +  errors[index] + "</li>");
			}
			errorElement.append("</ul>");
			errorElement.dialog("open");
		}
	});
    $("input[type=submit], .userbar button").button();
	$("#msg").dialog({
		modal: true,
		minWidth: 400,
		autoOpen: false
	});
	if ($("#msg").html() !== "") {
		$("#msg").dialog("open");
	}

});