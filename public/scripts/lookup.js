$(document).ready(function () {
	'use strict';
	var errorElement = $("#error"), childElement = $("#accordion");
	errorElement.dialog({
		modal: true,
		autoOpen: false,
		minWidth: 400
	});
	$("#alert").dialog({
        modal: true,
        autoOpen: false,
        heightStyle: 'auto',
        minWidth: 600
    });
    childElement.dialog({
        autoOpen: false,
        heightStyle: 'auto',
        minWidth: 600,
        focus: function (e, ui) {
        	$(this).parent(".ui-dialog").css('z-index', 1);
        }
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
    $(".childSingle").click(function () {
		var id = $(this).attr("id"),
			child = {},
			gender = "";
		$.ajax({
			url: 'get.php',
			method: 'get',
			data: 'id=' + id,
			success: function (data) {
				var child = JSON.parse(data), childName = child.firstname + (child.middlename ? " " + child.middlename : "") +  " " + child.lastname, listName = "", isBillPayer = "", isPrimaryContact = "", i = 0;
				$(".name").html(childName);
				$(".checkIn").html((child.checkedIn === "0" ? "<b>Checked Out</b>" : "<b>Checked In</b>"));
				if (child.gender === "M") {
					gender = "Male";
				} else if (child.gender === "F") {
					gender = "Female";
				} else {
					gender = "Other/Not given";
				}
				$(".gender").html(gender);
				$(".comments").html((child.comments ? child.comments : "No comments"));
				$(".pickupList").append("<ul>");
				for (i = 0; i < child[0].length; i++) {
					listName = child[0][i].firstname + (child[0][i].middlename ? " " + child[0][i].middlename : "") + " " + child[0][i].lastname;
					isBillPayer = (child[0][i].billpayer === "1") ? "<b>(Bill Payer)</b>" : "";
					isPrimaryContact = (child[0][i].primarycontact === "1") ? "<b>(Primary Contact)</b>" : "";
					$(".pickupList").append("<li>" + listName + " " + isBillPayer + isPrimaryContact + "</li>");
				}
				$(".pickupList").append("</ul>");

				$("#accordion").dialog("open");
			}
		})
			.error(function (err) {
				errorElement.html("<ul><li>err</li></ul>");
				errorElement.dialog("open");
			});
	});
	$(".clientSingle").click(function () {
        var id = $(this).attr("id"),
            client = {},
            gender = "";
        if (id) {
            $.ajax({
                url: 'get.php',
                method: 'get',
                data: 'id=' + id + '&search=true',
                success: function (data) {
                    var res = JSON.parse(data),
                        client = res.client,
                        alerts = res.alerts,
                        clientName = client.firstname + (client.middlename ? " " + client.middlename : "") +  " " + client.lastname,
                        isBillPayer = client.billpayer !== "0" ? " <b>(Bill Payer)</b>" : "",
                        isPrimaryContact = client.primarycontact !== "0" ? " <b>(Primary Contact)</b>" : "";
                    $("#alert").html("");
                    if (alerts.length > 0) {
                    	for (var i = alerts.length - 1; i >= 0; i--) {
                    		$("#alert").append("<div>" + alerts[i]["type"] + ":<br> " + alerts[i]["descrip"] + "</div><br>");
                    	};
                    	$("#alert").dialog("open");
                    }
                    $(".name").html(clientName + isBillPayer + isPrimaryContact);
                    if (client.gender === "M") {
                        gender = "Male";
                    } else if (client.gender === "F") {
                        gender = "Female";
                    } else {
                        gender = "Other/Not given";
                    }
                    $(".gender").html(gender);
                    $(".primaryPhone").html(client.primaryphone);
                    $(".secondaryPhone").html(client.secondaryphone);
                    $(".comments").html((client.comments ? client.comments : "No comments"));
                    $("#accordion").dialog("open");
                }
            })
                .error(function (err) {
                    errorElement.html("<ul><li>err</li></ul>");
                    errorElement.dialog("open");
                });
        }
    });
	if($("#msg").html() !== "") $("#msg").dialog("open");
	$("input[type=submit], button").button();
});