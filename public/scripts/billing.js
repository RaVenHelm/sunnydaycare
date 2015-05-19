$(document).ready(function () {
	'use strict';
	var errorElement = $("#error"), childElement = $("#accordion"), messageElement = $("#msg"),
		dialogOptions = {
			modal: true,
			autoOpen: false,
			minWidth: 400
		};
	$(".startEndDates").datepicker({
		dateFormat: 'yy-mm-dd',
		maxDate: 'c +1m',
		changeMonth: true,
		changeYear: true,
		yearRange: 'c-5:c'
	});
	errorElement.dialog(dialogOptions);
	childElement.dialog(dialogOptions);
	messageElement.dialog(dialogOptions);
	$("#lookup").submit(function (event) {
		var forbidden = new RegExp(/[\[\(\):;"'.,\\|\]\/@$\^&*%!@#]/),
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
	$("input[type=submit], button").button();
	$('.clientSingle').click(function () {
		$("#createBilling").children("label").html("<b>" + $(this).html() + "</b>");
		$("#id").val($(this).val());
		childElement.dialog("open");
	});
	$(".billingSingle").click(function () {
		$.ajax({
			url: 'get.php',
			type: 'get',
			data: {
				search: true,
				id : $(this).val()
			}
		})
			.done(function (res) {
				var invoices = $.parseJSON(res);
				if (invoices.length === 0) {
					errorElement.html("<p>Error: No invoices for this Client</p>");
					errorElement.dialog("open");
				} else {
					$(".invoice").append('<ul>');
				}
				$.each(invoices, function (index, val) {
					var invoice = invoices[index];
					console.log(invoice);
					$(".invoice").append('<li>Invoice Date: ' + invoice.datemade + '</li>');
					$(".invoice").append('<li>Date Due: ' + invoice.datedue + '</li>');
					$(".invoice").append('<li>Amount: $' + invoice.total  + '</li>');
					$(".invoice").append('<li>Is it paid off? ' + (invoice.isFullyPaid === "1" ? "<li><b>Paid Off</b></li>" : '<li><p class="error"><b>NOT PAID OFF</b></p></li>'));
					$(".invoice").append('<li>Payment Date: ' + (invoice.paymentdate !== null ? "<li>" + invoice.paymentdate + "</li>" : '<li><p class="error"><b>NO PAYMENTS MADE</b></p></li>'));
				});
				$(".invoice").append('</ul>');
				childElement.dialog("open");
				childElement.accordion();
			})
			.fail(function (error) {
				errorElement.html("<p>Error: " + error + "</p>");
				errorElement.dialog("open");
			});
	});
	if (messageElement.html() !== "") {
		messageElement.dialog("open");
	}
});