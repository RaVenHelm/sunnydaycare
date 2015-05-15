$(document).ready(function() {
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
	    }),
	errorElement.dialog(dialogOptions);
	childElement.dialog(dialogOptions);
	messageElement.dialog(dialogOptions);
	$("input[type=submit], button").button();
	$('.clientSingle').click(function(event) {
		$("#createBilling").children("label").html("<b>" + $(this).html() + "</b>");
		$("#id").val($(this).val());
		childElement.dialog("open");
	});
	if (messageElement.html() !== "") {
		messageElement.dialog("open");
	}
});