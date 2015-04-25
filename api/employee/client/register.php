<?php 
	include("../../../server/functions.php");
    
    session_start();
    
    if(!isset($_SESSION["user_id"])) {
        redirect_to('../../../login.html'); 
    } else {
?>

<!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<title>Sunny Day Care Employee: Register Client</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
	</head>

	<body>
		<div>
			<h1>Register a new Client</h1>
		</div>
		
		<?php include("../../../public/templates/userbar.php"); ?>
		
		<form>
			<input type="text" />
		</form>
		<div class="result"></div>
	    
	</body>
	<script src="/sunnydaycare/public/scripts/registerclient.js"></script>
</html>
<?php } ?>