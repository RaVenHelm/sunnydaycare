$(document).ready(function () {
	var errorElement = $('#error'), clientAccordion = $('#clientAccordion'), childAccordion = $('#childAccordion'),
		dialogOptions = {
	        modal: true,
	        autoOpen: false,
	        heightStyle: 'auto',
	        minWidth: 600
    	},
    	accordionOptions = {
    		active: false,
    		collapsible: true
    	};
	clientAccordion.dialog(dialogOptions);
	clientAccordion.accordion(accordionOptions);
	childAccordion.dialog(dialogOptions);
	childAccordion.accordion(accordionOptions);
	$("#result").css('height', '541.625px');
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
	$(".childSingle").click(function () {
		$.ajax({
			url: 'get.php',
			type: 'get',
			data: {
				type: 'child',
				id: $(this).val()
			}
		})
		.done(function(res) {
			incidents = JSON.parse(res);
			//Reset the accordion
			childAccordion.html("");
			if (incidents.length == 0) {
				childAccordion.html("<ul><li><b>No incidents found</b></li></ul>");
			} else {
				childAccordion.attr('title', $(".childSingle").html() + "'s Incidents");
				childAccordion.append("<h3>" + $(".childSingle").html() + "</h3>");
				childAccordion.append("<div></div>");
				$.each(incidents, function (index, el) {
					childAccordion.append("<h4>Type</h4>");
					childAccordion.append("<div>" + el.type + "</div>");
					childAccordion.append("<h4>Date</h4>");
					childAccordion.append("<div>" + moment(el.date).format("MM-DD-YYYY") + "</div>");
					childAccordion.append("<h4>Description</h4>");
					childAccordion.append("<div>" + el.descrip + "</div>");
				});
			}
			childAccordion.dialog("open");
		})
		.fail(function(error) {
			errorElement.html(error);
			errorElement.dialog("open");
		});		
	});
	$(".clientSingle").click(function () {
		var incidents = "";
		$.ajax({
			url: 'get.php',
			type: 'get',
			data: {
				type: 'client',
				id: $(this).val()
			}
		})
		.done(function(res) {
			incidents = JSON.parse(res);
			clientAccordion.html("");
			if (incidents.length !== 0) {
				$.each(incidents, function(index, el) {
					clientAccordion.append("<h4>Type</h4>");
					clientAccordion.append("<div>" + el.type + "</div>");
					clientAccordion.append("<h4>Date</h4>");
					clientAccordion.append("<div>" + moment(el.date).format("MM-DD-YYYY") + "</div>");
					clientAccordion.append("<h4>Description</h4>");
					clientAccordion.append("<div>" + el.descrip + "</div>");
				});
			} else {
				clientAccordion.html("<ul><li><b>No incidents found</b></li></ul>");
			}
			clientAccordion.dialog("open");
		})
		.fail(function() {
			errorElement.html(error);
			errorElement.dialog("open");
		});
	});
	$("input[type=submit], button").button();
});
