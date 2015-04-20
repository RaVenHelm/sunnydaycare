<?php 
	include('../../server/db/database.php');
	
	$db = new Database();
	
	$sql = "UPDATE employee SET password_hash = '" . password_hash('scarlett', PASSWORD_BCRYPT) . "' WHERE firstname = 'Scarlett'";
	$db->select($sql);
?>