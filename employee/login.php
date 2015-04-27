<?php 
	require_once('../server/session.php');
	require_once('../server/functions.php');
	require_once('../server/objects/Employee.php');
	
	if ($session->is_logged_in()) { redirect_to('index.php'); }
	if (isset($_POST["submit"])) { //Form has been submitted
		$username = trim($_POST["username"]);
		$password = trim($_POST["password"]);

		//Authenticate the user and set the response to a new Employee object
		$found = Employee::authenticate($username, $password);
    
		if ($found) {
			$session->login($found);
			//If making a copy of an object, use a dereference operator
			//$employee =& $found;
			redirect_to('index.php');
		}
		else {
			$msg = "Invalid credentials";
		}
}
else { //Form has not been submitted
    $username = "";
    $password = "";
}
?>

<!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
	</head>

	<body>
		<div>
			<h1>Welcome!</h1>
		</div>
		<form id="login" method="post" action="login.php">
			<input type="text" name="username" id="username" placeholder="Username" required>
			<input type="password" name="password" id="password" placeholder="Password" required>
			<input type="submit" name="submit" id="loginSubmit" value="Login" >
		</form>
		<div id="error" style="color:red;"><?php if(isset($msg)) echo $msg; ?></div>
	    
	</body>

	<script src="../public/scripts/login.js"></script>
</html>