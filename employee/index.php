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
		<script src="../public/scripts/jquery-1.11.3.js"></script>
		<link rel="stylesheet" href="../public/scripts/jquery-ui.min.css" />
		<script src="../public/scripts/jquery-ui.min.js"></script>
		<!-- Custom Styles-->
		<link rel="Stylesheet" href="../public/styles/normalize.css" />
		<link rel="Stylesheet" href="../public/styles/webpage.css" />
	</head>
	<body>
		<div class="header"><a href="/sunnydaycare">Sunny Daycare</a></div>
		<div class="container">
			<div class="wrapper">
				<?php include('templates/userbar.php'); ?>
				<ul class="employeeNav">
					<li class="levelOne"><a href="child/checkin.php">Check In / Check Out</a></li>
					<li class="levelOne"><a href="client/register.php">Register a new Client</a></li>
					<li class="levelOne"><a href="child/register.php">Register a new Child</a></li>
					<li class="levelOne"><a href="client/lookup.php">Client Lookup</a></li>
					<li class="levelOne"><a href="child/lookup.php">Child Lookup</a></li>
					<li class="levelOne"><a href="events">Events</a></li>
					<?php if($_SESSION["permissions"] >= 2){?>
					<li class="levelTwo"><a href="incidents">Incidents</a></li>
					<li class="levelTwo"><a href="alert/index.php">Alerts</a></li>
					<li class="levelTwo"><a href="billing">Billing</a></li>
					<?php } ?>
					<?php if($_SESSION["permissions"] >= 3){ ?>
					<li class="levelThree"><a href="client/update.php">Update Client Information</a></li>
					<li class="levelThree"><a href="child/update.php">Update Child Information</a></li>
					<li class="levelThree"><a href="Medical">Medical</a></li>
					<?php } ?>
					<?php if($_SESSION["permissions"] == 4){ ?>
					<li class="levelFour"><a href="register.php">Create a new Employee</a></li>
					<li class="levelFour"><a href="update.php">Edit Employee</a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<div id="error" title="Error"><?php if(isset($msg)) echo $msg; ?></div>
		
	</body>
	<script src="../public/scripts/index.js"></script>
</html>