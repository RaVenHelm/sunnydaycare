<?php 
	include('db/database.php');
	
	global $database;
	
	$password = password_hash("garyspassword", PASSWORD_BCRYPT);
	
	$sql = "INSERT INTO employee VALUES (NULL, 'generic', :pass, 'Gary', NULL, 'The Janitor', 1)";
	
	$sth = $database->prepare($sql);
	
	$sth->execute(array(':pass' => $password));
?>