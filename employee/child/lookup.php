<?php 
	require_once('../../server/session.php');
	require_once('../../server/functions.php');
	require_once('../../server/objects/Child.php');
	
	if (!$session->is_logged_in()) { redirect_to('../login.php'); }
	
	if(isset($_GET["submit"])){
		$result = Child::search(trim($_GET["firstname"]), (trim($_GET["middlename"]) == "" ? null : trim($_GET["middlename"])), trim($_GET["lastname"]));
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
		
		<!-- Custom styles -->
		<link rel="Stylesheet" href="../../public/styles/normalize.css" type="text/css"/>
		<link rel="Stylesheet" href="../../public/styles/webpage.css" type="text/css" />
	</head>

	<body>
		<div class="header"><a href="/sunnydaycare/">Sunny Daycare</a></div>
		<div class="wrapper">
			<?php include('../templates/userbar.php'); ?>
			<div id="search">
				<h2>Child Search</h2>
				<form id="lookup" method="get" action="lookup.php" novalidate>
					<label for"firstname">First Name</label><br>
					<input type="text" name="firstname" id="firstname" placeholder="First Name" required><br>
					<label for"firstname">Middle Name</label><br>
					<input type="text" name="middlename" id="middlename" placeholder="Middle Name" ><br>
					<label for"firstname">Last Name</label><br>
					<input type="text" name="lastname" id="lastname" placeholder="Last Name" required><br>
					<input type="submit" name="submit" id="lookupSubmit" value="Search" >
				</form>
			</div>
			
			<div id="error" title="Error"></div>
			<div id="result">
				<?php if(isset($result) && $result){ ?>
						<?php for($i = 0; $i < count($result); $i++) {?>
							<button><?php echo $result[$i]["firstname"] . " " . $result[$i]["middlename"] . " " . $result[$i]["lastname"]; ?></button><br>
						<?php } ?>
				<?php } ?>
				<div id="msg"><?php if(isset($msg)) echo $msg; ?></div>
			</div>
			<div id="accordion" style="display:none;">
				<h3>Name</h3>
				<div><p><?php echo $result["firstname"] . " " . $result["middlename"] . " " . $result["lastname"]; ?></p></div>
				<h3>Check In Status</h3>
				<div><p><b><?php echo $result["checkedIn"] ? "Checked In" : "Checked Out"; ?></b></p></div>
				<h3>Gender</h3>
				<div>
					<p>
					<?php
						if($result["gender"] == "M"){
							echo "Male";
						} else if ($result["gender"] == "F"){
							echo "Female";
						} else {
							echo "Other";
						}
					?>
					</p>
				</div>
				<h3>Comments</h3>
				<div><p><i><?php echo $result["comments"] ? $result["comments"] : "No comments"; ?></i></p></div>
				<h3>People who can pick up <?php echo $result["firstname"]; ?></h3>
				<div>
					<ul>
						<?php for($i = 0; isset($result[0][$i]); $i++){ ?>
								<li>
								<?php echo $result[0][$i]["firstname"] . " " . $result[0][$i]["middlename"] . " " . $result[0][$i]["lastname"] ; ?>
								<b><?php if($result[0][$i]["billpayer"]) echo "(Bill Payer)"; ?></b>
								</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</body>

	<script src="../../public/scripts/lookup.js"></script>
</html>