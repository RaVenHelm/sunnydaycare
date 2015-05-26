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
    		$medicalEncrypt = Medical::getRecord($_GET["id"]);
			//var_dump($medicalEncrypt);
			if (!is_array($medicalEncrypt)) {

	  			$medical = $medicalEncrypt->decryptMembers();
    			echo str_replace('\\u0000', "", json_encode($medical->toArray(), JSON_PRETTY_PRINT));
	  		} else {
	  			echo json_encode($medicalEncrypt, JSON_PRETTY_PRINT);
	  		}		
    		
    	}
    }
?>