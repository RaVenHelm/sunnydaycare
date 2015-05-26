<?php
	require_once('../../server/session.php');
    require_once('../../server/functions.php');
    require_once('../../server/objects/Medical.php');

	if (!$session->is_logged_in()) { redirect_to('../login.php'); }
    if ($_SESSION["permissions"] < 3) { 
    	$time = time()*60;
    	setcookie("Message", "You do not have the permissions to view this file", $time);
    	redirect_to('../index.php'); 
    }

    if (isset($_GET["submit"])) {
    	if (isset($_GET["id"])) {
    		$medical = Medical::getRecord($_GET["id"]);
    		$medical->decryptMembers();
    		var_dump($medical);
    		//echo json_encode($medical, JSON_PRETTY_PRINT);
    	}
    }
	
	function toArrayDecrypted($record)
	{
				
	}
?>