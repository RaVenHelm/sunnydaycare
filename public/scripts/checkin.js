$(document).ready(function () {
	'use strict';
	var errorElement = $("#error"), viewLog = $(".viewLog");
	$("button, input[type=submit]").button();
	errorElement.dialog({
		modal: true,
		autoOpen: false,
		minWidth: 400
	});
	$("#msg").dialog({
        modal: true,
        autoOpen: false,
        minWidth: 400
    });
	viewLog.dialog({
		modal: true,
		autoOpen: false,
		minWidth: 400
	});
	$("#lookup").submit(function (event) {
		var forbidden = new RegExp(/[\[\(\):;"'.,\\|\]\/]/),
			errors = [],
			index = 0;
		errorElement.html("");
		$(".result").html("");
		if ($("#firstname").val().trim() === "" || $("#lastname").val().trim() === "") {
			errors.push("First/Last name cannot be blank");
		}
		//Check for forbidden chars
		if (forbidden.exec($("#firstname").val().trim()) || forbidden.exec($("#middlename").val().trim()) || forbidden.exec($("#middlename").val().trim())) {
			errors.push("Forbidden characters: " + ["[]", ",", "\\", "/", ":", ".", "|", "(", ")"].join(" "));
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
	$("#accordion").accordion({
		collapsible: false,
		active: 0
	});
    if ($("#msg").html() !== "") {
        $("#msg").dialog("open");
    }
	$(".checkInForm").submit(function (event) {
		var id = 0, index = 0, errors = [];
		errorElement.html("");
		id = $(this).children(".pickupSelect").val();
		console.log(id);
		if (id === "") {
			errors.push("Select the person on this list");
		}
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
});