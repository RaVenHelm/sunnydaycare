<?php 
	require_once('../../server/session.php');
	require_once('../../server/functions.php');
	
	if (!$session->is_logged_in()) { redirect_to('../login.php'); }
	if (isset($_POST["submit"])) { //Form has been submitted
        var_dump($_POST);
	}
	else { //Form has not been submitted

	}
?>

<!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<!-- JQuery Core/UI -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>

		<!-- Custom Styles-->
		<link rel="Stylesheet" href="../../public/styles/normalize.css" />
		<link rel="Stylesheet" href="../../public/styles/webpage.css" />
	</head>

	<body>
		<div class="header"><a href="/sunnydaycare/">Sunny Daycare</a></div>
			<div class="wrapper">
                <?php include('../templates/userbar.php'); ?>
				<div id="search">
					<h2>Register Child</h2>
					<form id="registerForm" name="register" method="post" action="register.php" novalidate>
                        <label for="firstname">First Name: </label><br>
						<input type="text" name="firstname" id="firstname" placeholder="First Name" required><br>
                        <label for="middlename">Middle Name: </label><br>
						<input type="text" name="middlename" id="middlename" placeholder="Middle Name"><br>
                        <label for="lastname">Last Name: </label><br>
						<input type="text" name="lastname" id="lastname" placeholder="Last Name" required><br>

                        <label for="bday">Birthday: (yyyy-mm-dd)</label><br>
                        <input type="text" name="bday" id="bday" required><br><br>

                        <label for="gender">Gender</label><br>
                        <select name="gender" id="gender" required>
                            <option value="">Select one:</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                            <option value="O">Other/Not disclosed</option>
                        </select><br>

                        <label for="allergy">Allergies?</label><br>
                        <input type="text" name="allergy" class="allergy"><br>

                        <label for="medical">Medical Information</label><br>
                        <input type="text" name="medical[section]" class="medical" placeholder="Section"><br>
                        <input type="text" name="medical[description]" class="medical" placeholder="Description"><br>

                        <label for="restriction">Restrictions?</label><br>
                        <input type="text" name="restriction[type]" class="restriction" placeholder="Type"><br>
                        <input type="text" name="restriction[detail]" class="restriction" placeholder="Detail"><br>

                        <form method="get" action="../client/lookup.php">
                            <label for="client">Clients</label><br>
                            <input type="text" name="client[firstname]" id="clientFirst" placeholder="First Name" required><br>
                            <input type="text" name="client[middlename]" id="clientMiddle" placeholder="Middle Name"><br>
                            <input type="text" name="client[lastname]" id="clientLast" placeholder="Last Name" required><br>
                            <input type="submit" name="search" id="lookupSubmit" value="Search" >
                        </form>

						<br><input type="submit" name="register" id="registerSubmit" value="Register" >
					</form>
				</div>
				<div id="result"></div>
			</div>
		<div id="msg" title="Messge"><?php if(isset($msg)) echo $msg; ?></div>
		<div id="error" title="Error"></div>
	</body>

	<script src="../../public/scripts/register.js"></script>
</html>