<?php // This is a template page for the user bar?>

<div id="userbar">
	Hello <?php echo $_SESSION["name"]; //Session will store the full name?>!
	<a href="/sunnydaycare/api/employee/employee.php"><button>Home</button></a>
	<form method="get" action="/sunnydaycare/api/employee/logout.php">
		<input type="submit" value="Logout"/>
	</form>
</div>