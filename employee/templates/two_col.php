<?php 
	include('../server/session.php');
	include('../server/functions.php');
	
	if (!$session->is_logged_in()) { redirect_to('../login.php'); }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Reports Page</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
	
	<!-- Custom styles -->
	<link rel="Stylesheet" href="../public/styles/normalize.css" type="text/css"/>
	<link rel="Stylesheet" href="../public/styles/webpage.css" type="text/css" />
</head>
<body>
<div class="container">
	<div class="header"><a href="/sunnydaycare/">Sunny Daycare</a></div>
		<div class="wrapper">
			<?php include('templates/userbar.php'); ?>
			<div id="search">
				
			</div>
			<div id="result">
				
			</div>
		</div>
</div>
<footer><footer>
</body>
</html>
