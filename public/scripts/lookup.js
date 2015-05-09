$(document).ready(function () {
	'use strict';
	var errorElement = $("#error"), childElement = $("#accordion");
	errorElement.dialog({
		modal: true,
		autoOpen: false,
		minWidth: 400
	});
    childElement.dialog({
        modal: true,
        autoOpen: false,
        heightStyle: 'auto',
        minWidth: 600
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
        var id = $(".childSingle").attr("id"),
            child = {},
            gender = "";
        console.log(id);
        if (id) {
            $.ajax({
                url: 'get.php',
                method: 'get',
                data: 'id=' + id,
                success: function (data) {
                    child = JSON.parse(data);
                    console.log(child);

                    var childName = child.firstname + (child.middlename ? " " + child.middlename : "") +  " " + child.lastname,
                        listName = child[0][0].firstname + (child[0][0].middlename ? " " + child[0][0].middlename : "") + " " + child[0][0].lastname;

                    $(".name").html(childName);
                    $(".checkIn").html((child.checkedIn === "0" ? "<b>Checked Out</b>" : "<b>Checked In</b>" ));
                    if(child.gender === "M"){
                        gender = "Male";
                    } else if (child.gender === "F") {
                        gender = "Female";
                    } else {
                        gender = "Other/Not given";
                    }
                    $(".gender").html(gender);
                    $(".comments").html((child.comments ? child.comments : "No comments"));
                    $(".pickupList").html(listName);

                    $("#accordion").dialog("open");
                }
            })
                .error(function (err) {
                    errorElement.html("<ul><li>err</li></ul>");
                    errorElement.dialog("open");
                });
        }
    });
	
	$(".clientSingle").click(function () {
        var id = $(".clientSingle").attr("id"),
            client = {},
            gender = "";
        console.log(id);
        if (id) {
            $.ajax({
                url: 'get.php',
                method: 'get',
                data: 'id=' + id,
                success: function (data) {
                    client = JSON.parse(data);
                    console.log(client);

                    var clientName = client.firstname + (client.middlename ? " " + client.middlename : "") +  " " + client.lastname,
                        listName = client[0][0].firstname + (client[0][0].middlename ? " " + client[0][0].middlename : "") + " " + client[0][0].lastname;

                    $(".name").html(clientName);
                    $(".checkIn").html((client.checkedIn === "0" ? "<b>Checked Out</b>" : "<b>Checked In</b>" ));
                    if(client.gender === "M"){
                        gender = "Male";
                    } else if (client.gender === "F") {
                        gender = "Female";
                    } else {
                        gender = "Other/Not given";
                    }
                    $(".gender").html(gender);
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

	$("input[type=submit], button").button();
});