<?php 
    include('../../server/db/database.php');
    include("../../server/functions.php");
    
    session_start();

    echo $_SESSION["name"];
    
    if(isset($_POST["username"]) && isset($_POST["password"])){
    	
    	$sql = 'SELECT * FROM employee WHERE username=:username;';
    	$stmt = $database->prepare($sql);
    
    	$stmt->execute(array(':username' => $_POST["username"]));
    	$result = $stmt->fetch(PDO::FETCH_ASSOC);
    	
    	
    	if (password_verify($_POST["password"], $result["password_hash"])){
    	    $_SESSION["name"] = $result["firstname"] . " " . $result["lastname"];
    	    $_SESSION["user_id"] = $result["id"];
    	    $_SESSION["permissions"] = $result["permissions"];
    	    
    	    redirect_to("employee.php");
    	} else {
    	    echo "Invalid username or password!";
    	    redirect_to("../../login.html");
    	}
    } else {
        echo "Username or password was not given.";
    }
?>