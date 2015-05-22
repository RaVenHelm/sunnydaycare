$(document).ready(function () {
	'use strict';
	var calendar = $('#calendar'), eventElement = $('#event'), errorElement = $('#error'),
		dialogOptions = {
			modal: true,
			autoOpen: false,
			minWidth: 400
		};
	eventElement.dialog(dialogOptions);
    errorElement.dialog(dialogOptions);
    $("#msg").dialog(dialogOptions);
    $("#addDialog").dialog(dialogOptions);
    $("#date").datepicker({
    	minDate: "c",
    	maxDate: "+1 y",
    	changeMonth: true,
    	changeYear: true,
    	dateFormat: "yy-mm-dd"
    });
    $.ajax({
		url: '../events/get.php',
		method: 'get',
		data: {events: 'true'}
	})
		.done(function (res) {
			var events = $.parseJSON(res);
			calendar.clndr({
			//template: $("#template-calendar").html(),
				daysOfTheWeek: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
				events: events,
				clickEvents: {
					click: function (target) {
						var eventTime = "", i = 0;
						if (target.events.length > 0) {
							for (i; i < target.events.length; i++) {
								eventTime = moment(target.events[i].date + " " + target.events[i].time).format("h:mm a");
								eventElement.append("<h4>" + target.events[i].title + "</h4><i>" + eventTime + "</i><p>" + target.events[i].description + "</p>");
								eventElement.dialog("open");
							}
						}
					}
				},
				forceSixRows: true
			});
		})
		.fail(function (error) {
			errorElement.html("Error finding events: " + error);
			errorElement.dialog("open");
		});
	eventElement.on('dialogclose', function () {
		eventElement.html("");
	});
	$("#addEvent").submit(function () {
	});
	$("#add").click(function () {
		$("#addDialog").dialog("open");
	});
	if ($("#msg").html() !== "") {
		$("#msg").dialog("open");
	}
	$("input[type=submit], button").button();
});
