<?php 
	include('../../server/db/database.php');

	$db = new Database();
	
	$sql = 'SELECT password_hash FROM employee WHERE id=1';
	$result = $db->select($sql);

	$true_hash = $result->fetch();
	//print_r($true_hash);
	
	//echo $true_hash[0];
	
	if (password_verify('scarlett', $true_hash[0])){
		echo 'Right!';
	} else {
		echo 'Nope';
	}
?>