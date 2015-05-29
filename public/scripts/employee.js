$(function() {
    'use strict';
    var errorElement = $("#error"),
        msgElement = $("#msg"),
        updateElement = $("#update"),
        dialogOptions = {
            modal: true,
            autoOpen: false,
            minWidth: 400
        };
    errorElement.dialog(dialogOptions);
    msgElement.dialog(dialogOptions);
    updateElement.dialog(dialogOptions);
    $("#lookup").submit(function(event) {
        var errors = [],
            forbidden = new RegExp(/[\[\(\);:"'.,\\|\]\/@?<>\{\}\^`~\|%#!0-9]/),
            index = 0;
        errorElement.html("");
        $(".result").html("");
        if ($("#firstname").val().trim() === "" || $("#lastname").val().trim() === "") {
            errors.push("First/Last name cannot be blank");
        }
        //Check for forbidden chars
        if (forbidden.exec($("#firstname").val().trim()) || forbidden.exec($("#middlename").val().trim())) {
            errors.push("Forbidden characters: " + ["[]", ",", "\\", ";", ":", ".", "|", "(", ")"].join(" "));
        }
        //Check for if any errors exist
        if (errors.length > 0) {
            event.preventDefault();
            errorElement.append("<ul>");
            for (index; index < errors.length; index++) {
                errorElement.append("<li>" + errors[index] + "</li>");
            }
            errorElement.append("</ul>");
            errorElement.dialog("open");
        }
    });
    $(".employeeSingle").click(function (event) {
        updateElement.dialog("open");
    });
    $("#updateForm").submit(function(event) {
        var errors = [],
            max_length = 25,
            min_length = 8,
            forbidden = new RegExp(/[\[\(\);"'.,\\|\]\/\^@&$#*~]/),
            index = 0;
        //Clear out error div before reuse
        errorElement.html("");
        //Validate both inputs have values
        if ($("#username").val().trim() === "" || $("#password").val().trim() === "") {
            errors.push("Username or password can't be blank");
        }
        //Check for forbidden chars
        if (forbidden.exec($("#username").val().trim()) || forbidden.exec($("#password").val().trim())) {
            errors.push("Forbidden characters: " + ["[]", ",", ";", "\"", "'", "\\", ".", "|", "(", ")"].join(" "));
        }
        //Username validations
        if ($("#username").val().length > max_length) {
            errors.push("Username can't be more than " + max_length + " character long");
        }
        if ($("#username").val().length < min_length) {
            errors.push("Username can't be less than " + min_length + " characters long");
        }
        //Password validations
        if ($("#password").val().length > max_length) {
            errors.push("Password can't be more than " + max_length + " character long");
        }
        if ($("#password").val().length < min_length) {
            errors.push("Password can't be less than " + min_length + " characters long");
        }
        if($("#password").val() !== $("#p_verify").val()){
            errors.push("Passwords much match");
        }
        //Check for if any errors exist
        if (errors.length > 0) {
            event.preventDefault();
            errorElement.append("<ul>");
            for (index; index < errors.length; index++) {
                errorElement.append("<li>" + errors[index] + "</li>");
            }
            errorElement.append("</ul>");
            errorElement.dialog("open");
        }
    });
    if(msgElement.html() !== "") {
        msgElement.dialog("open");
    }
    $("button, input[type=submit]").button();
});