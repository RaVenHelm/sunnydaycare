$(document).ready(function (){
	$("#bday").datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: '-5y',
        maxDate: '-1m -14d',
        changeMonth: true,
        changeYear: true,
        yearRange: 'c-5:c'
    });
    $("input[type=submit], .userbar button").button();

});