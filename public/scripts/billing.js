$(document).ready(function() {
    'use strict';
    var errorElement = $("#error"),
        childElement = $("#accordion"),
        messageElement = $("#msg"),
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
    $("#lookup").submit(function(event) {
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
                errorElement.append("<li>" + errors[index] + "</li>");
            }
            errorElement.append("</ul>");
            errorElement.dialog("open");
        }
    });
    $("input[type=submit], button").button();
    $('.clientSingle').click(function() {
        $("#createBilling").children("label").html("<b>" + $(this).html() + "</b>");
        $("#id").val($(this).val());
        childElement.dialog("open");
    });
    $(".billingSingle").click(function() {
        $.ajax({
            url: 'get.php',
            type: 'get',
            data: {
                search: true,
                id: $(this).val()
            }
        })
            .done(function(res) {
                var invoices = $.parseJSON(res);
                if (invoices.length === 0) {
                    errorElement.html("<p>Error: No invoices for this Client</p>");
                    errorElement.dialog("open");
                }
                $.each(invoices, function(index, val) {
                    var invoice = invoices[index],
                        accordionString = '<h3>Invoice</h3><div><ul>' + '<li>Invoice Date: ' + invoice.datemade + '</li>' + '<li>Date Due: ' + invoice.datedue + '</li>' + '<li>Amount: $' + invoice.total + '</li>' + '<li>Is it paid off? ' + (invoice.isFullyPaid === "1" ? "<li>Paid Off</li>" : '<li>NOT PAID OFF</li>') + '<li>Payment Date: ' + (invoice.paymentdate !== null ? "<li>" + invoice.paymentdate + "</li>" : '<li>NO PAYMENTS MADE</li>') + '</ul></div>';
                    $("#invoiceList").append(accordionString);
                });
                $("#accordion").append('<form name="print" action="print.php" method="get"><input type="submit" class="print" name="print" value="Print"><input type="hidden" name="id" value=' + $(".billingSingle").val() + '></form>');
                childElement.dialog("open");
                $("#invoiceList").accordion();
            })
            .fail(function(error) {
                errorElement.html("<p>Error: " + error + "</p>");
                errorElement.dialog("open");
            });
    });
    $(".paymentSingle").click(function() {
        var name = $(this).html();
        $.ajax({
            url: 'get.php',
            type: 'get',
            data: {
                search: true,
                id: $(this).val(),
                unpaid: true
            },
            success: function(res) {
                var invoices = $.parseJSON(res);
                if (invoices.length === 0) {
                    $("#invoices").html("<p>No invoices for this Client</p>");
                    childElement.dialog("open");
                } else {
                	$("#invoices").html("");
                    $("#name").html(name);
                    $.each(invoices, function(index, el) {
                        var invoice = el,
                            outString = "<ul>";
                        outString += "<h4><b>Invoice " + invoice.id + "</b></h4>";
                        outString += "<li><b>Date Made:</b> " + invoice.datemade + "<br></li>";
                        outString += "<li><b>Date Due:</b> " + invoice.datedue + "<br></li>";
                        outString += "<li><b>Amount Due:</b> " + new Intl.NumberFormat("en", {
                            style: "currency",
                            currency: "USD",
                            minimumFractionDigits: 2
                        }).format(invoice.total - invoice.amountPaid) + "<br></li>";
                        outString += "</ul>";
                        outString += "<label for='paymentInput'>Amount to pay:</label>";
                        outString += "<input type='text' name='payment[" + index + "][" + invoice.id + "][amount]' value='0.00' class='paymentInput'>";
                        outString += "<input type='hidden' name='payment[" + index + "][" + invoice.id + "][due]' value='" + (invoice.total - invoice.amountPaid) + "' class='paymentInput'>";
                        outString += "<input type='hidden' name='payment[" + index + "][" + invoice.id + "][paidOff]' value='" + invoice.amountPaid + "' class='paymentInput'>";
                        $("#invoices").append(outString);
                    });
                    $("#invoices").append("<br><input type='submit' name='pay' value='Pay'>");
                    childElement.dialog("open");
                }
            }
        })
            .fail(function(error) {
                console.log(error);
            });
    });
    if (messageElement.html() !== "") {
        messageElement.dialog("open");
    }
});