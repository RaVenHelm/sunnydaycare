<?php 
	require_once('../../server/session.php');
	require_once('../../server/functions.php');
	require_once('../../server/objects/Child.php');
	
	if (!$session->is_logged_in()) { redirect_to('../login.php'); }
	
	if(isset($_GET["submit"])){
		$result = Child::find_one(trim($_GET["firstname"]), (trim($_GET["middlename"]) == "" ? null : trim($_GET["middlename"])), trim($_GET["lastname"]));
		if(!$result) {$msg = "<ul><li>No child found.</li></ul>";}
	}
?>

<!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
	</head>

	<body>
		<div>
			<h1>Child Lookup</h1>
		</div>
		<?php include('../templates/userbar.php'); ?>
		<form id="lookup" method="get" action="lookup.php" >
			<input type="text" name="firstname" id="firstname" placeholder="First Name" required>
			<input type="text" name="middlename" id="middlename" placeholder="Middle Name" >
			<input type="text" name="lastname" id="lastname" placeholder="Last Name" required>
			<input type="submit" name="submit" id="lookupSubmit" value="Search" >
		</form>
		<div id="error" style="color:red;"><?php if(isset($msg)) echo $msg; ?></div>
		<div class="result">
		<?php if(isset($result) && $result){ ?>
				<ul>
					<li><?php echo $result["firstname"] . " " . $result["middlename"] . " " . $result["lastname"]; ?></li>
					<ul>
						<li><b><?php echo $result["checkedIn"] ? "Checked In" : "Checked Out"; ?></b></li>
						<li>
							<?php
								if($result["gender"] == "M"){
									echo "Male";
								} else if ($result["gender"] == "F"){
									echo "Female";
								} else {
									echo "Other";
								}
							?>
						</li>
						<li><?php echo $result["comments"] ? "Comments: " . $result["comments"] : "No comments"; ?></li>
						<li>
							People who can pick up <?php echo $result["firstname"]; ?><br>
							<ul>
								<?php for($i = 0; isset($result[0][$i]); $i++){ ?>
										<li>
										<?php echo $result[0][$i]["firstname"] . " " . $result[0][$i]["middlename"] . " " . $result[0][$i]["lastname"] ; ?>
										<b><?php if($result[0][$i]["billpayer"]) echo "Bill Payer"; ?></b>
										</li>
								<?php } ?>
							</ul>
						</li>
					</ul>
				</ul>
		<?php } ?>
		</div>
	</body>

	<script src="../../public/scripts/lookup.js"></script>
</html>