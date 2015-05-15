<?php
	include 'db/database.php';
	include 'functions.php';
	include 'DOI.php';

	global $database;


	//echo encrypt($doi);
	// $sql = "INSERT INTO medical VALUES(NULL, '29', :type, :desc);";
	// $sth = $database->prepare($sql);
	// $sth->execute(array(':type' => encrypt("Personal"), ':desc' => encrypt($doi)));

	$sql = "SELECT * FROM medical";

	$result = $database->select($sql);

	$result = $result->fetchAll(PDO::FETCH_ASSOC);

	var_dump($result);

	$section =& decrypt($result[8]["section"]); 
	$desc =& decrypt($result[8]["description"]); 
	echo $section . '<br>';
	echo $desc;
?>