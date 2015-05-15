$(document).ready(function () {
	var errorElement = $('#error'), clientAccordion = $('#clientAccordion'), childAccordion = $('#childAccordion'),
		dialogOptions = {
        modal: true,
        autoOpen: false,
        heightStyle: 'auto',
        minWidth: 600
    };
	clientAccordion.dialog(dialogOptions).accordion();
	childAccordion.dialog(dialogOptions).accordion();
	$("form").submit(function (event) {
		var errors = [],
			forbidden = new RegExp(/[\[\(\);:"'.,\\|\]\/\^&*!@#$%~]/),
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
	$("input[type=submit], button").button();
});
