<?php
	require_once('../server/session.php');
	require_once('../server/functions.php');
	require_once('../server/objects/Alert.php');
	
	if (!$session->is_logged_in()) { redirect_to('login.php'); }

	if (isset($_POST["submit"])) {
		$post = $_POST;
		if ($post["type"] == "client") {
			$res = Alert::delete($post["id"], true);
		} else {
			$res = Alert::delete($post["id"], false);
		}
		if ($res == "1") {
			$msg = "Delete successful";
		} else {
			$msg = "Delete was not successful";
		}
	}
	
	$alerts = Alert::getAll();
	$clientAlerts = $alerts[0];
	$childAlerts = $alerts[1];

	$self= $_SERVER["PHP_SELF"];
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
				<?php include('templates/userbar.php'); ?>
				<ul class="alerts">
					<?php
						foreach ($clientAlerts as $alert) {
					?>
						<li>
							<h3><?php echo "{$alert["firstname"]} {$alert["lastname"]}"; ?></h3>
							<div>
								<?php echo "{$alert["type"]}: {$alert["descrip"]}";  ?>
								<form action="<?php echo $self; ?>" method="post">
									<input type="hidden" name="id" value="<?php echo $alert["id"]; ?>">
									<input type="hidden" name="type" value="client">
									<input type="submit" name="submit" value="Delete">
								</form>
							</div>
						</li>
					<?php } ?>
					<br>
					<?php 
						foreach ($childAlerts as $alert) {
					?>
						<li>
							<h3><?php echo "{$alert["firstname"]} {$alert["lastname"]}"; ?></h3>
							<div>
								<?php echo "{$alert["type"]}: {$alert["descrip"]}";  ?>
								<form action="<?php echo $self; ?>" method="post">
									<input type="hidden" name="id" value="<?php echo $alert["id"]; ?>">
									<input type="hidden" name="type" value="child">
									<input type="submit" name="submit" value="Delete">
								</form>
							</div>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<div id="message" title="Message"><?php if(isset($msg)) echo $msg; ?></div>
		
	</body>
</html>