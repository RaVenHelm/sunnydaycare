$(document).ready(function () {
	'use strict';
	var errorElement = $("#error"),
		dialogOptions = {
			modal: true,
			minWidth: 400,
			autoOpen: false
		};
	$("#bday").datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: '-5y',
        maxDate: '-1m -14d',
        changeMonth: true,
        changeYear: true,
        yearRange: 'c-5:c'
    });
    errorElement.dialog(dialogOptions);
    $("#clientList").dialog(dialogOptions);
	//Check for errors before sending to server
	$("#registerForm").submit(function (event) {
		//event.preventDefault();
		var errors = [],
			index = 0,
			forbidden = new RegExp(/[\[;"'\\|\]\/@$%\^&!\(\)=]/),
			username = new RegExp(/[a-zA-Z0-9]{8,25}/),
			password = new RegExp(/[a-zA-Z0-9!@$#%_^&*\(\)~]{8,25}/),
			birthday = new RegExp(/^[0-9]{4}-[0-9]{2}-[0-9]{2}/),
			phone = new RegExp(/^(\([0-9]{3}\)|[0-9]{3}-)[0-9]{3}-[0-9]{4}$/);
		//Clear previous errors
		errorElement.html("");
		$(".result").html("");
		if ($("#firstname").val().trim() === "" || $("#lastname").val().trim() === "") {
			errors.push("First/Last name cannot be blank");
		}
        if (forbidden.exec($("#firstname").val().trim()) !== null || forbidden.exec($("#middlename").val().trim()) !== null || forbidden.exec($("#lastname").val().trim()) !== null){
            errors.push("Forbidden characters: " + ["[]", ",", ";", "\"", "'", "\\", ".", "|", "(", ")"].join(" "));
        }
		if ($("#mailing").val() !== undefined || $("#billing").val() !== undefined) {
			if ($("#mailing").val().trim() === "" || $("#billing").val().trim() === "") {
				errors.push("Address cannot be blank");
			}
		}
		if ($("#relationship").val() === "") {
			errors.push("Relationship must be selected");
		}
		if ($("#gender").val() === "") {
			errors.push("Gender must be selected");
		}
		if ($(".phone").val() !== undefined) {
			if (!phone.exec($(".phone").val().trim())) {
				errors.push("Phone number must be of the format: ###-###-#### or (###)###-####");
			}
		}
		if ($("#username") !== undefined && $("#password") !== undefined && $("#p_verify") !== undefined && $("#permissions") !== undefined) {
			if (username.exec($("#username").val()) === null) {
				errors.push("Username must be 8-25 letters and numbers");
			}
			if (password.exec($("#password").val()) === null || password.exec($("#p_verify").val()) !== null) {
				errors.push("Password must be 8-25 characters long, at least one special character (!@#$%_^*)")
			}
		}
		// $("input").each(function () {
		// 	if (forbidden.exec($(this).val().trim())) {
		// 		errors.push("Forbidden characters: " + ["[]", ",", ";", "\"", "'", "\\", ".", "|", "(", ")"].join(" "));
		// 	}
		// });
		if ($("#bday").val() !== undefined) {
			if (!birthday.exec($("#bday").val().trim())) {
				errors.push("Birthday must be in: yyyy-mm-dd format");
			}
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
	$("#addressSame").change(function () {
		var same = $(this);
		if (same.prop("checked")) {
			$("#billing").val($("#mailing").val());
		} else {
			$("#billing").val(null);
		}
	});
	$("#lookupSubmit").click(function (event) {
		var params = {
			'byName': true,
			'search': true,
			'firstname': $("#clientFirst").val(),
			'middlename': $("#clientMiddle").val(),
			'lastname': $("#clientLast").val()
		},
			clientsToAdd = [];
		$("#clientList").html("");
		event.preventDefault();
		$.ajax({
			url: '../client/get.php',
			method: 'get',
			data: params,
			success: function (data) {
				var index = 0,
					clients = JSON.parse(data),
					clientName = "";
				$("#clientList").append('<h4>Clients To Add:</h4>');
				if (clients.length !== 0) {
					for (index; index < clients.length; index++) {
						clientName = clients[index].firstname + (clients[index].middlename ? " " + clients[index].middlename : "") + " " + clients[index].lastname;
						$("#clientList").append('<button class="clientSingle" id="' + clients[index].id + '">' +  clientName + '</button> <span class="res" name="' + clients[index].id + '"></span><br>');
					}
					$("#clientList").append('<button id="remove">Remove All</button>');
				} else {
					$("#clientList").html('<p class="error"><b>No client found</b></p>');
				}
				$("#clientList").dialog("open");
				$(".clientSingle").click(function () {
					var id = $(this).attr("id"),
						name = $(this).html(),
						count  = $("#clientsToAdd").children("#clients").length;
					$("span[name=" + id + "]").html('Added!');
					$("#clientsToAdd").append('<h2 id="clients">' + name + '</h2>');
					$("#clientsToAdd").append('<input type="hidden" name="client[' + count + ']" value="' + id + '">');
				});
				$("#remove").click(function () {
					//Reset the array
					clientsToAdd = [];
					$("#clientsToAdd").html("");
				});
			}
		});
	});
	$("#restrictionDia").dialog(dialogOptions);
	$("#restrictionBttn").click(function (event) {
		event.preventDefault();
		$("#restrictionDia").dialog("open");
	});
	$("#restrictionAdd").click(function () {
		var list = $("#restrictionList"),
			count = list.children("div.restriction").length,
			type = $("#type").val(),
			detail = $("#detail").val().trim();
		if (type !== "" && detail !== "") {
			list.append('<div class="restriction"><input name="restriction[' + count + '][type]" value="' + type + '"><br><input name="restriction[' + count + '][detail]" value="' + detail + '"><br></div>');
		}
		$("#type").val('');
		$("#detail").val('');
	});
	$("#medicalDia").dialog(dialogOptions);
	$("#medicalBttn").click(function (event) {
		event.preventDefault();
		$("#medicalDia").dialog("open");
	});
	$("#medicalAdd").click(function () {
		var list = $("#medicalList"),
			count = list.children("div.medical").length,
			section = $("#section").val(),
			description = $("#description").val().trim();
		if (section !== "" && description !== "") {
			list.append('<div class="medical"><input name="medical[' + count + '][section]" value="' + section + '"><br><input name="medical[' + count + '][description]" value="' + description + '"><br></div>');
		}
		$("#section").val('');
		$("#description").val('');
	});
	$("#allergyDia").dialog(dialogOptions);
	$("#allergyBttn").click(function (event) {
		event.preventDefault();
		$("#allergyDia").dialog("open");
	});
	$("#allergyAdd").click(function () {
		var list = $("#allergyList"),
			count = list.children("div.allergy").length,
			type = $("#allergy").val();
		if (type !== "") {
			list.append('<div class="allergy"><input name="allergy[' + count + '][type]" value="' + type + '"><br></div>');
		}
		//Reset the text
		$("input#allergy").val("");
	});
    $("input[type=submit], button").button();
	$("#msg").dialog(dialogOptions);
	if ($("#msg").html() !== "") {
		$("#msg").dialog("open");
	}
});