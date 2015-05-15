<?php

require_once('../../server/objects/Client.php');
require_once('../../server/objects/Invoice.php');

if($_GET["search"]){
	if (isset($_GET["id"])) {
		$id = $_GET["id"];

    	$invoices = Invoice::getAll($id);

    	echo json_encode($invoices, JSON_PRETTY_PRINT);
	}
	else {
		echo json_encode(false);
	}
} else {
    echo json_encode(false);
}

?>