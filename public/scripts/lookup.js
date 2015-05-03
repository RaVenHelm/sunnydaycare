$(document).ready(function () {
	'use strict';
	var errorElement = $("#error");
	errorElement.dialog({
		modal: true,
		autoOpen: false,
		minWidth: 400
	});
	$("#lookup").submit(function (event) {
		var errors = [],
			forbidden = new RegExp(/[\[\(\);:"'.,\\|\]\/]/),
			index = 0;
		errorElement.html("");
		$(".result").html("");
		if ($("#firstname").val().trim() === "" || $("#lastname").val().trim() === "") {
			errors.push("First/Last name cannot be blank");
		}
		//Check for forbidden chars
		if (forbidden.exec($("#firstname").val().trim()) || forbidden.exec($("#middlename").val().trim()) || forbidden.exec($("#middlename").val().trim())) {
			errors.push("Forbidden characters: " + ["[]", ",", "\\", ";", ":", ".", "|", "(", ")"].join(" "));
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
		collapsible: true,
		active: false
	});
	$("input[type=submit], button").button();
});