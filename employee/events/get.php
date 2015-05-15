<?php
	require_once('../../server/functions.php');
	require_once('../../server/objects/Event.php');
	
	if(isset($_GET["events"])) {
		$events = Event::getAll();

		echo json_encode($events, JSON_PRETTY_PRINT);
	}
?>