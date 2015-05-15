<?php 
	require_once('../../server/session.php');
	require_once('../../server/functions.php');
	require_once('../../server/objects/Child.php');
	
	if (!$session->is_logged_in()) { redirect_to('../login.php'); }
	if (isset($_POST["register"])) { //Form has been submitted
		$middlename = $_POST["middlename"] == "" ? null : $_POST["middlename"];
		$allergies = isset($_POST["allergy"]) ? $_POST["allergy"] : null;
		$restrictions = isset($_POST["restriction"]) ? $_POST["restriction"] : null;
		$medical = isset($_POST["medical"]) ? $_POST["medical"] : null;

        $child = new Child($_POST["firstname"], $middlename, $_POST["lastname"], $_POST["bday"], $_POST["gender"], true, false, false, null, $allergies, $restrictions, $medical, $_POST["client"]);
        
        if($result = $child->add()) $msg = "Child " . $result->getFullName() . " created!";
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
				<div class="register">
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
                        <button id="allergyBttn" name="allergy">Add</button><br>
                        
                        <div id="allergyDia" title="Allergies">
                        	<input type="text" id="allergy" class="allergy" placeholder="Allergy"><br>
                        	<button id="removeAllergy">Remove All</button>
                        	<button id="allergyAdd">Add</button>
                        </div>
                        <div id="allergyList"></div>

                        <label for="medical">Medical Information</label><br>
                        <button id="medicalBttn">Add</button><br>

                        <div id="medicalDia" title="Medical">
                        	<input type="text" id="section" class="medical" placeholder="Section"><br>
                        	<input type="text" id="description" class="medical" placeholder="Description"><br>
                        	<button id="removeMedical">Remove All</button>
                        	<button id="medicalAdd">Add</button>

                        </div>
                        <div id="medicalList"></div>

                        <label for="restriction">Restrictions?</label><br>
                        <button id="restrictionBttn" name="restriction">Add</button><br>

                        <div id="restrictionDia" title="Restrictions">
                        	<input type="text" id="type" class="restriction" placeholder="Type"><br>
                        	<input type="text" id="detail" class="restriction" placeholder="Detail"><br>
                        	<button id="removeRestriction">Remove All</button>
                        	<button id="restrictionAdd">Add</button>
                        </div>
                        <div id="restrictionList"></div>

                        <label for="client">Clients</label><br>
                        <input type="text" name="clientFirst" id="clientFirst" placeholder="First Name" required><br>
                        <input type="text" name="clientMiddle" id="clientMiddle" placeholder="Middle Name"><br>
                        <input type="text" name="clientLast" id="clientLast" placeholder="Last Name" required><br>
                        <input type="submit" name="search" id="lookupSubmit" value="Search" >

                        <div id="clientList" title="Clients"></div>
                        <div id="clientsToAdd"></div>

						<br><input type="submit" name="register" id="registerSubmit" value="Register" >
					</form>
				</div>
			</div>
		<div id="msg" title="Messge"><?php if(isset($msg)) echo $msg; ?></div>
		<div id="error" title="Error"></div>
	</body>
	<script src="../../public/scripts/underscore-min.js"></script>
	<script src="../../public/scripts/register.js"></script>
</html>