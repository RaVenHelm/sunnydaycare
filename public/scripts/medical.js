$(function(){
	'use strict';
	var errorElement = $("#error"), childAccordion = $("#childAccordion");
	childAccordion.dialog({
        modal: true,
        autoOpen: false,
        heightStyle: 'auto',
        minWidth: 600
    });
	childAccordion.accordion({
		active: false,
		collapsible: true
	});
	errorElement.dialog({
        modal: true,
        autoOpen: false,
        heightStyle: 'auto',
        minWidth: 600
    });
	$("#lookup").submit(function (event) {
		var errors = [],
			forbidden = new RegExp(/[\[\(\);:"'.,\\|\]\/\^&*!@#$%~0-9]/),
			index = 0;
		errorElement.html("");
		$(".result").html("");
		if ($(this).children("#firstname").val().trim() === "" || $(this).children("#lastname").val().trim() === "") {
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
	$(".childSingle").click(function (event) {
		console.log("Bang");
	});
	$("input[type=submit], button").button();
});