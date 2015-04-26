<?php 
	require_once('../server/session.php');
	require_once('../server/functions.php');
	require_once('../server/objects/Employee.php');
	
	//if ($session->is_logged_in()) { redirect_to('index.php'); }
	
	if(isset($_POST["username"])){ //Form has been submitted
		$username = $_POST["username"];
		$password = $_POST["password"];
		
		$found = Employee::authenticate($username, $password);
		
		if($found){
			$session->login($found);
			redirect_to('index.php');
		} else {
			$msg = "Invalid credentials";
		}
		
	} else { //Form has not been submitted
		$username="";
		$password="";
		echo "Bang";
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
		<div id="login">
		    <form method="post" action="login.php">
		        <input type="text" name="username" id="username" placeholder="Username" />
		        <input type="password" name="password" id="password" placeholder="Password" />
		        <input type="submit" name="submit" id="loginSubmit" value="Login" />
		    </form>
		</div>
		<div id="error"><?php if(isset($msg)) echo $msg; ?></div>
	    
	</body>

	<script src="/sunnydaycare/public/scripts/login.js"></script>
</html>
<?php //} ?>