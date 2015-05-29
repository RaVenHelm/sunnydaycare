$(document).ready(function() {
    'use strict';
    var errorElement = $("#error"),
        childElement = $("#update"),
        msgElement = $("#msg");
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
    }),
    msgElement.dialog({
        modal: true,
        autoOpen: false,
        minWidth: 600
    });
    $("#clientList").dialog({
        modal: true,
        autoOpen: false,
        minWidth: 600
    });
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
        if (forbidden.exec($("#firstname").val().trim()) || forbidden.exec($("#middlename").val().trim()) || forbidden.exec($("#middlename").val().trim())) {
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
    $("#accordion").accordion({
        collapsible: true,
        active: false
    });
    $(".childSingle").click(function() {
        var id = $(this).attr("id"),
            child = {},
            gender = "";
        $.ajax({
            url: 'get.php',
            method: 'get',
            data: 'id=' + id,
            success: function(data) {
                var child = JSON.parse(data),
                    childName = child.firstname + (child.middlename ? " " + child.middlename : "") + " " + child.lastname,
                    listName = "",
                    isBillPayer = "",
                    isPrimaryContact = "",
                    i = 0;
                console.log(child);
                $(".pickupList").html("");

                $("#id").val(child.id);
                $("#form_firstname").val(child.firstname);
                $("#form_middlename").val(child.middlename);
                $("#form_lastname").val(child.lastname);
                $(".checkIn").html((child.checkedIn === "0" ? "<b>Checked Out</b>" : "<b>Checked In</b>"));
                $("#bday").val(child.birthday);
                $("#gender").val(child.gender);
                $(".comments").html((child.comments ? child.comments : "No comments"));
                $("#isactive").attr("checked", (child.isactive === "1" ? "checked" : ""));
                $("#assist").attr("checked", (child.stateassistance === "1" ? "checked" : ""));
                $(".pickupList").append("<ul>");
                for (i; i < child[0].length; i++) {
                    listName = child[0][i].firstname + (child[0][i].middlename ? " " + child[0][i].middlename : "") + " " + child[0][i].lastname;
                    isBillPayer = (child[0][i].billpayer === "1") ? "<b>(Bill Payer)</b>" : "";
                    isPrimaryContact = (child[0][i].primarycontact === "1") ? "<b>(Primary Contact)</b>" : "";
                    $(".pickupList").append("<li>" + listName + " " + isBillPayer + isPrimaryContact + "</li>");
                }
                $(".pickupList").append("</ul>");

                $("#update").dialog("open");
            }
        })
            .error(function(err) {
                errorElement.html("<ul><li>err</li></ul>");
                errorElement.dialog("open");
            });
    });
    $(".clientSingle").click(function() {
        var id = $(this).attr("id"),
            client = {},
            gender = "";
        if (id) {
            $.ajax({
                url: 'get.php',
                method: 'get',
                data: 'id=' + id + '&search=true',
                success: function(data) {
                    var res = JSON.parse(data),
                        client = res.client,
                        alerts = res.alerts,
                        clientName = client.firstname + (client.middlename ? " " + client.middlename : "") + " " + client.lastname,
                        isBillPayer = client.billpayer !== "0" ? true : false,
                        stateAssistance = client.stateassistance !== "0" ? true : false,
                        isActive = client.isactive !== "0" ? true : false,
                        isPrimaryContact = client.primarycontact !== "0" ? true : false;
                    $(".id").val(client.id);
                    $(".firstname").val(client.firstname);
                    $(".middlename").val(client.middlename);
                    $(".lastname").val(client.lastname);
                    $(".gender").val(client.gender);
                    $("#primary").val(client.primaryphone);
                    $("#secondary").val(client.secondaryphone);
                    $("#mailing").val(client.mailingAddr);
                    $("#billing").val(client.billingAddr);
                    $(".relationship").val(client.relationship);
                    if (isActive) {
                        $(".isactive").prop('checked', 'checked');
                    }
                    if (isPrimaryContact) {
                        $(".primarycontact").prop('checked', 'checked');
                    }
                    if (isBillPayer) {
                        $(".billpayer").prop('checked', 'checked');
                    }
                    if (stateAssistance) {
                        $("#assist").prop('checked', 'checked');
                    }
                    $(".comments").val((client.comments ? client.comments : "No comments"));

                    $("#update").dialog("open");
                }
            })
                .error(function(err) {
                    errorElement.html("<ul><li>err</li></ul>");
                    errorElement.dialog("open");
                });
        }
    });
    if (msgElement.html() !== "") {
        msgElement.dialog("open");
    }
    $("input[type=submit], button").button();
});