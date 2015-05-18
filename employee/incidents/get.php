<?php
	require_once('../../server/functions.php');
	require_once('../../server/objects/Incident.php');
	
	if($_GET["type"] == "child") {
		$childInc = Incident::getChildIncidents($_GET["id"]);

		echo json_encode($childInc, JSON_PRETTY_PRINT);
	}
	if($_GET["type"] == "client") {
		$clientInc = Incident::getClientIncidents($_GET["id"]);

		echo json_encode($clientInc, JSON_PRETTY_PRINT);
	}
?>