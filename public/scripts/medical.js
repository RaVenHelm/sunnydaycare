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
		collapsible: true,
		heightStyle: 'content'
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
		var name = $(this).html();
		$(".medical").html("");
		$(".allergies").html("");
		$(".restrictions").html("");
		$.ajax({
			url: 'get.php',
			type: 'get',
			data: {
				submit: 'true',
				id: $(this).val()
			},
			success: function (res) {
				var record = $.parseJSON(res), medical = record.medical, allergies = record.allergies, restriction = record.restrictions,
					medicalOut = "", allergyOut = "", restrictionOut = "",
					i = (medical !== undefined ? medical.length - 1 : 0),
					j = (allergies !== undefined ? allergies.length - 1 : 0),
					k = (restriction !== undefined ? restriction.length - 1 : 0);
				
				console.log(record);
				$(".name").html(name);

				$(".medical").append("<ul>");
				for (i; i >= 0; i--) {
					medicalOut += "<li>" + medical[i].section + ": " + medical[i].description + "</li>";
				};
				console.log(medicalOut);
				$(".medical").append(medicalOut);
				$(".medical").append("</ul>");

				$(".allergies").append("<ul>");
				for (j; j >= 0; j--) {
					allergyOut += "<li>" + allergies[j].type + "</li>";
				};
				console.log(allergyOut);
				$(".allergies").append(allergyOut);
				$(".allergies").append("</ul>");

				$(".restrictions").append("<ul>");
				for (k; k >= 0; k--) {
					restrictionOut += "<li>" + restriction[k].type + ": " + restriction[k].detail + "</li>";
				};
				console.log(restrictionOut);
				$(".restrictions").append(restrictionOut);
				$(".restrictions").append("</ul>");

				childAccordion.dialog("open");
			}
		})
		.fail(function(error) {
			console.log(error);
		});
	});
	$("input[type=submit], button").button();
});