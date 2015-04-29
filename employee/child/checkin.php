<?php 
	include('../../server/session.php');
	include('../../server/functions.php');
	
	if (!$session->is_logged_in()) { redirect_to('../login.php'); }
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
			<h1>Check-In/Check-Out</h1>
		</div>
		<?php include('../templates/userbar.php'); ?>
		<form id="search" method="get">
			<input type="text" name="firstname" id="firstname" placeholder="First Name" required>
			<input type="text" name="middlename" id="middlename" placeholder="Middle Name">
			<input type="text" name="lastname" id="lastname" placeholder="Last Name" required>
			<input type="submit" name="submit" id="loginSubmit" value="Login" >
		</form>
		<div id="error" style="color:red;"><?php if(isset($msg)) echo $msg; ?></div>
	    
	</body>

	<script src="../../public/scripts/checkin.js"></script>
</html>