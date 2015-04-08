<?php 
	try{
		include('dbconnect.php');
		$result = $connection->query("SELECT COUNT(id) FROM users");
		$idnum = $result->fetch();
	} catch (Exception $ex){
		echo $ex->getMessage();
	}
?>
<?php
	if(!isset($_POST["username"])){
		echo "Username not defined";
	} elseif ($_POST["username"] == "") {
		echo "Username not defined";
	} else{
		try{
			$stmt = "INSERT (id,username)INTO users VALUES (" . ++$idnum[0] . "," . $_POST["username"] . ")";
			$result = $connection->exec($stmt);
		} catch (Exception $ex){
			echo $ex->getMessage();
		}
		$json = array("id"=>$idnum[0], "username"=>$_POST["username"]);
		echo json_encode($json, JSON_PRETTY_PRINT);
	}
?>