$(document).ready(function () {
	'use strict';
	var calendar = $('#calendar'), eventElement = $('#event'), errorElement = $('#error');
	eventElement.dialog({
		modal: true,
		autoOpen: false,
		minWidth: 400
	});
    errorElement.dialog({
        modal: true,
        autoOpen: false,
        minWidth: 400
    });
    $.ajax({
		url: '../employee/events/get.php',
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
	$("input[type=submit], button").button();
});
