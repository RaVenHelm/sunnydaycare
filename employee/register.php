<?php 
	require_once('../server/session.php');
	require_once('../server/functions.php');
	require_once('../server/objects/Employee.php');
	
	if (!$session->is_logged_in()) { redirect_to('../login.php'); }
	if($_SESSION["permissions"] != 4) { redirect_to('index.php'); }
	if (isset($_POST["register"])) { //Form has been submitted
		$middlename = $_POST["middlename"] == "" ? null : $_POST["middlename"];
		$emp = new Employee(NULL, $_POST["firstname"], $middlename, $_POST["lastname"], $_POST["username"], $_POST["permissions"]);
		if($emp->add($_POST["password"])){
			$name = $emp->getFullName();
			$msg = "Success! Employee {$name} created!";
		} else {
			$msg = "Error: the employee was not created.";
		}
	}
	else { //Form has not been submitted

	}
?>

<!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		
		<title>Sunny Day Care | Register Employee</title>
		<!-- Custom Styles-->
		<link rel="Stylesheet" href="../public/styles/normalize.css" />
		<link rel="Stylesheet" href="../public/styles/webpage.css" />
	</head>

	<body>
		<div class="header"><a href="/sunnydaycare/">Sunny Daycare</a></div>
			<div class="wrapper">
                <?php include('./templates/userbar.php'); ?>
				<div class="register">
					<h2>Register Employee</h2>
					<form id="registerForm" name="register" method="post" action="register.php" novalidate>
                        <label for="firstname">First Name: </label><br>
						<input type="text" name="firstname" id="firstname" placeholder="First Name" required><br>
                        <label for="middlename">Middle Name: </label><br>
						<input type="text" name="middlename" id="middlename" placeholder="Middle Name"><br>
                        <label for="lastname">Last Name: </label><br>
						<input type="text" name="lastname" id="lastname" placeholder="Last Name" required><br>

                        <label for="username">Username</label><br>
                        <input type="text" id="username" name="username"><br>

                        <label for="password">Password</label><br>
                        <input type="password" id="password" name="password"><br>

                        <label for="p_verify">Verify password</label><br>
                        <input type="password" id="p_verify" name="p_verify"><br>

                        <label for="permissions">Permissions</label><br>
                        <input type="number" min="1" max="4" id="permissions" name="permissions"><br>

						<br><input type="submit" name="register" id="registerSubmit" value="Register" >
					</form>
				</div>
			</div>
		<div id="msg" title="Messge"><?php if(isset($msg)) echo $msg; ?></div>
		<div id="error" title="Error"></div>
	</body>

    <!-- JQuery Core/UI -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>

	<script src="../public/scripts/underscore.min.js"></script>
	<script src="../public/scripts/register.js"></script>
</html>