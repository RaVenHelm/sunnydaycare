<?php

require_once('../../server/objects/Client.php');
require_once('../../server/objects/Alert.php');

if($_GET["search"]){
	if (isset($_GET["id"])) {
		$id = $_GET["id"];

		$alerts = Alert::getClient($id);

    	$client = Client::find_one_id($id)->to_array();

    	$json = array('client' => $client, 'alerts' => $alerts);

    	echo json_encode($json, JSON_PRETTY_PRINT);
	}
	else if (isset($_GET["byName"])) {
		$clients = Client::search(trim($_GET["firstname"]), (trim($_GET["middlename"]) == "" ? null : trim($_GET["middlename"])), trim($_GET["lastname"]));
		echo json_encode($clients, JSON_PRETTY_PRINT);
	}
	else {
		echo json_encode(false);
	}
} else {
    echo json_encode(false);
}

?>