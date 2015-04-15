<?php
	//Should go into API folder
	try{
		include('db/dbconnect.php');
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
			$stmt = 'INSERT INTO users (id, username) VALUES (NULL,"'  . $_POST["username"] . '")';
			$result = $connection->exec($stmt);
			
			if($result !== 0){
				$json = array("id"=>($connection->lastInsertId()), "username"=>$_POST["username"]);
				echo json_encode($json, JSON_PRETTY_PRINT);
			} else {
				echo "MySQL Error: " . $connection->error_get_last();
			}
		
		} catch (Exception $ex){
			echo $ex->getMessage();
		}
	}

?>