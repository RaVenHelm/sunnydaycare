<?php 
    include("../../server/functions.php");
    
    session_start();
    
    if(!isset($_SESSION["user_id"])) {
        redirect_to('../../../login.html'); 
    } else {
        //echo "You're in!";
?>

<!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<title>Sunny Day Care Employee</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
	</head>

	<body>
		<div>
			<h1>Sunny Day Care Employee Home Page</h1>
		</div>
		
		<div id="username">
		    Hello <?php echo $_SESSION["name"]; ?>!
		    <form method="get" action="logout.php">
		        <input type="submit" value="Logout"/>
		    </form>
		</div>
		
		<?php //print_r($_SESSION); ?>
		
		<ul>
		    <li><a href="child/checkinpage.php">CheckIn/CheckOut A Child</a></li>
		    <li><a href="child/lookup.php">Child Lookup</a></li>
		    <li><a href="#">Client Lookup</a></li>
		    <li><a href="#">Events Calendar</a></li>
		    <li><a href="#">Incidents</a></li>
		    <li><a href="#">Billing</a></li>
		    <li><a href="#">Reports</a></li>
		</ul>
	    
	</body>
</html>

<?php
    }
?>