<?php 
	require_once('../../server/session.php');
	require_once('../../server/functions.php');
	require_once('../../server/objects/Child.php');
	
	if (!$session->is_logged_in()) { redirect_to('../login.php'); }
	
	if(isset($_GET["submit"])){
		$result = Child::search(trim($_GET["firstname"]), (trim($_GET["middlename"]) == "" ? null : trim($_GET["middlename"])), trim($_GET["lastname"]));
		if(!$result) {$msg = "<ul><li>No child found.</li></ul>";}
	}

	if(isset($_POST["update"])){
		$child = Child($_POST["firstname"], $_POST["middlename"], $_POST["lastname"], $_POST["bday"], $_POST["gender"], isset($_POST["active"])? true :  false, null, isset($_POST["stateassistance"]) ? true : false, $_POST["comments"], null, null, null, null);
		$msg = "Child Record Updated";
	}
?>

<!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
		
		<!-- Custom styles -->
		<link rel="Stylesheet" href="../../public/styles/normalize.css" type="text/css"/>
		<link rel="Stylesheet" href="../../public/styles/webpage.css" type="text/css" />
	</head>

	<body>
		<div class="header"><a href="../">Sunny Daycare</a></div>
		<div class="wrapper">
			<?php include('../templates/userbar.php'); ?>
			<div id="search">
				<h2>Child Search</h2>
				<form id="lookup" method="get" action="update.php">
					<label for"firstname">First Name</label><br>
					<input type="text" name="firstname" id="firstname" placeholder="First Name" required><br>
					<label for"middlename">Middle Name</label><br>
					<input type="text" name="middlename" id="middlename" placeholder="Middle Name" ><br>
					<label for"lastname">Last Name</label><br>
					<input type="text" name="lastname" id="lastname" placeholder="Last Name" required><br>
					<input type="submit" name="submit" id="lookupSubmit" value="Search" >
				</form>
			</div>
			
			<div id="error" title="Error"></div>
			<div id="result">
				<?php if(isset($result) && $result){ ?>
						<?php for($i = 0; $i < count($result); $i++) {?>
							<button class="childSingle" id="<?php echo $result[$i]["id"]; ?>" value="<?php echo $result[$i]["id"]; ?>"><?php echo $result[$i]["firstname"] . " " . $result[$i]["middlename"] . " " . $result[$i]["lastname"]; ?></button><br>
						<?php } ?>
				<?php } ?>
                <div id="update" title="Child Data">
                    <form id="registerForm" name="register" method="post" action="update.php" novalidate>
                        <label for="firstname">First Name: </label><br>
						<input type="text" name="firstname" id="firstname" placeholder="First Name" required><br>
                        <label for="middlename">Middle Name: </label><br>
						<input type="text" name="middlename" id="middlename" placeholder="Middle Name"><br>
                        <label for="lastname">Last Name: </label><br>
						<input type="text" name="lastname" id="lastname" placeholder="Last Name" required><br>

                        <label for="bday">Birthday: (yyyy-mm-dd)</label><br>
                        <input type="text" name="bday" id="bday" required><br><br>

                        <label for="isactive">Active?</label>
            			<input type="checkbox" name="isactive" class="isactive"><br>

            			<label for="stateassistance">On state assistance?</label>
            			<input type="checkbox" name="stateassistance" id="assist"><br>

                        <label for="gender">Gender</label><br>
                        <select name="gender" id="gender" required>
                            <option value="">Select one:</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                            <option value="O">Other/Not disclosed</option>
                        </select><br>

                        <label for="comments">Comments</label>
            			<textarea name="comments" class="comments" cols="30" rows="10"></textarea>

						<br><input type="submit" name="update" id="updateSubmit" value="Update" >
					</form>
                </div>
				<div id="msg"><?php if(isset($msg)) echo $msg; ?></div>
			</div>
		</div>
	</body>

	<script src="../../public/scripts/update.js"></script>
</html>