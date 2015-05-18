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
			$msg = "<b style='color:red;'>User Name / Password Incorrect</b>";
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
		<!-- JQuery Core/UI -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>

		<!-- Custom Styles-->
		<link rel="Stylesheet" href="../public/styles/normalize.css" />
		<link rel="Stylesheet" href="../public/styles/webpage.css" />
	</head>

	<body>
		<div class="header"><a href="/">Sunny Daycare</a></div>
		<div id="login">
			<label for="login">Employee Login</label>
			<form id="loginForm" name="login" method="post" action="login.php">
				<input type="text" name="username" id="username" placeholder="Username" required>
				<input type="password" name="password" id="password" placeholder="Password" required><br>
				<input type="submit" name="submit" id="loginSubmit" value="Login" >
			</form>
		</div>
		<div id="error" title="Error"></div>
		<div id="msg" title="Message"><?php if(isset($msg)) echo $msg; ?></div>
	</body>

	<script src="../public/scripts/login.js"></script>
</html>