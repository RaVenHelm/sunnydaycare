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
				}
				$.each(invoices, function (index, val) {
					var invoice = invoices[index],
						accordionString  = '<h3>Invoice</h3><div><ul>' + '<li>Invoice Date: ' + invoice.datemade + '</li>' + '<li>Date Due: ' + invoice.datedue + '</li>' + '<li>Amount: $' + invoice.total  + '</li>' + '<li>Is it paid off? ' + (invoice.isFullyPaid === "1" ? "<li>Paid Off</li>" : '<li>NOT PAID OFF</li>') + '<li>Payment Date: ' + (invoice.paymentdate !== null ? "<li>" + invoice.paymentdate + "</li>" : '<li>NO PAYMENTS MADE</li>') + '</ul></div>';
					// $("#accordion").append('<h3>Invoice</h3><div><ul>');
					// $("#accordion").append('<li>Invoice Date: ' + invoice.datemade + '</li>');
					// $("#accordion").append('<li>Date Due: ' + invoice.datedue + '</li>');
					// $("#accordion").append('<li>Amount: $' + invoice.total  + '</li>');
					// $("#accordion").append('<li>Is it paid off? ' + (invoice.isFullyPaid === "1" ? "<li>Paid Off</li>" : '<li>NOT PAID OFF</li>'));
					// $("#accordion").append('<li>Payment Date: ' + (invoice.paymentdate !== null ? "<li>" + invoice.paymentdate + "</li>" : '<li>NO PAYMENTS MADE</li>'));
					// $("#accordion").append('</ul></div>');
					$("#invoiceList").append(accordionString);
				});
				$("#accordion").append('<form name="print" action="print.php" method="get"><input type="submit" class="print" name="print" value="Print"><input type="hidden" name="id" value=' + $(".billingSingle").val() + '></form>');
				childElement.dialog("open");
				$("#invoiceList").accordion();
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