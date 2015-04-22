<?php 
    include("../../server/functions.php");
    
    session_start();
    
    if(!isset($_SESSION["user_id"])) {
        redirect_to('../../../login.html'); 
    } else {
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
			<h1>Check In/Check Out Page</h1>
		</div>
		
		<div id="username">
		    Hello <?php echo $_SESSION["name"]; ?>!
		    <form method="get" action="../logout.php">
		        <input type="submit" value="Logout"/>
		    </form>
		</div>
		
		<div class="search">
		    <input type="text" name="firstname" id="child_firstname" placeholder="First Name" />
		    <input type="text" name="lastname" id="child_lastname" placeholder="Last Name" />
		    <input type="submit" id="submit" value="Search" />
		</div>
		<div class="result"></div>
	    
	</body>
	<script src="/public/scripts/getchildcheckout.js"></script>
</html>

<?php } ?>