<?php 
	include('db/database.php');
	
	global $database;
	
	$password = password_hash("password!", PASSWORD_BCRYPT);
	
	$sql = "INSERT INTO employee VALUES (NULL, 'generic', :pass, 'Generic', NULL, 'User', 4)";
	
	$sth = $database->prepare($sql);
	
	$sth->execute(array(':pass' => $password));
?>