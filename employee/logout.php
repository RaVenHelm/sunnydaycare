<?php 
	require_once('../server/session.php');
	require_once('../server/functions.php');
	
	$session->logout();
	
	redirect_to('login.php');
?>