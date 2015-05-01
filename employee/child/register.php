<?php 
	require_once('../../server/session.php');
	require_once('../../server/functions.php');
	
	if (!$session->is_logged_in()) { redirect_to('../login.php'); }
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
		<!-- JQuery Core/UI -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>

		<!-- Custom Styles-->
		<link rel="Stylesheet" href="../../public/styles/normalize.css" />
		<link rel="Stylesheet" href="../../public/styles/webpage.css" />
	</head>

	<body>
		<div class="header"><a href="/sunnydaycare/">Sunny Daycare</a></div>
			<div class="wrapper">
				<div id="search">
					<label for="registerForm">Register Child</label>
					<form id="registerForm" name="register" method="post" action="register.php">
						<input type="text" name="firstname" id="firstname" placeholder="First Name" required><br>
						<input type="password" name="middlename" id="middlename" placeholder="Middle Name"><br>
						<input type="password" name="lastname" id="lastname" placeholder="Last Name" required><br>
						<input type="submit" name="submit" id="registerSubmit" value="Register" >
					</form>
				</div>
				<div id="result"></div>
			</div>
		<div id="msg" title="Messge"><?php if(isset($msg)) echo $msg; ?></div>
		<div id="error" title="Error"></div>
	</body>

	<script src="../../public/scripts/register.js"></script>
</html>