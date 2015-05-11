<?php 
	require_once('../server/session.php');
	require_once('../server/functions.php');
	require_once('../server/objects/Employee.php');
	
	if (!$session->is_logged_in()) { redirect_to('login.php'); }
	
	Session::regen();
?>

<!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
        <title>Sunny Day Care Employee</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>

		<!-- Custom Styles-->
		<link rel="Stylesheet" href="../public/styles/normalize.css" />
		<link rel="Stylesheet" href="../public/styles/webpage.css" />
	</head>

	<body>
		<div class="header"><a href="/sunnydaycare">Sunny Daycare</a></div>
		<div class="container">
			<div class="wrapper">
			<ul class="employeeNav">
				<?php include('templates/userbar.php'); ?>
					<li><a href="child/checkin.php">Check In / Check Out</a></li>
					<li><a href="client/register.php">Register a new Client</a></li>
					<li><a href="child/register.php">Register a new Child</a></li>
					<li><a href="client/lookup.php">Client Lookup</a></li>
					<li><a href="child/lookup.php">Child Lookup</a></li>
					<li><a href="events">Events</a></li><br>
					<?php if($_SESSION["permissions"] >= 2){?>
					<li><a href="incidents">Incidents</a></li>
					<li><a href="reports.php">Reports</a></li>
					<?php } ?>
					<?php if($_SESSION["permissions"] >= 3){ ?>
					<br>
					<li><a href="#">Update Client Information</a></li>
					<li><a href="#">Update Child Information</a></li>
					<li><a href="#">Billing</a></li>
					<?php } ?> 
					<?php if($_SESSION["permissions"] == 4){ ?>
					<br />
					<li><a href="#">Create a new Employee</a></li>
					<li><a href="#">View Employee Incidents</a></li>
					<li><a href="#">Edit Employee</a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<div id="error" title="Error"><?php if(isset($msg)) echo $msg; ?></div>
	    
	</body>

	<script src="../public/scripts/index.js"></script>
</html>