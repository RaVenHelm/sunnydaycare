<?php 
	require_once('../server/session.php');
	require_once('../server/functions.php');
	require_once('../server/objects/Employee.php');
	
	if (!$session->is_logged_in()) { redirect_to('login.php'); }
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
		<?php include('templates/userbar.php'); ?>
		<ul class="employeeNav">
			<li><a href="#">Check In / Check Out</a></li>
			<li><a href="#">Register a new Client</a></li>
			<li><a href="#">Register a new Child</a></li>
			<li><a href="child/lookup.php">Client Lookup</a></li>
			<li><a href="#">Child Lookup</a></li>
			<li><a href="#">Events</a></li>
			<li><a href="#">Incidents</a></li>
			<li><a href="#">Reports</a></li>
			<?php 
				if($_SESSION["permissions"] == 4){
			?>
			<br />
			<li><a href="#">Create a new Employee</a></li>
			<li><a href="#">View Employee Incidents</a></li>
			<li><a href="#">Edit Employee Permissions</a></li>
			<?php } ?>
		</ul>
		<div id="error"><?php if(isset($msg)) echo $msg; ?></div>
	    
	</body>

	<script src="../public/scripts/login.js"></script>
</html>