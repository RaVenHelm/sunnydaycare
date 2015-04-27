<?php 
	require_once('../../server/session.php');
	require_once('../../server/functions.php');
	require_once('../../server/objects/Child.php');
	
	if (!$session->is_logged_in()) { redirect_to('../login.php'); }
	if (isset($_GET["lookupAllSubmit"])){ 
		$result = Child::get_all(true, false);
	}
	if(isset($_GET["submit"])){
		$result = Child::find_one($_GET["firstname"], ($_GET["middlename"] == "" ? null : $_GET["middlename"]), $_GET["lastname"]);
		if(!$result) {$msg = "No child found.";}
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
		<form id="lookupAll" name="lookupAll" action="lookup.php">
			<label for="lookupAll">Lookup All?</label>
			<input type="checkbox" name="lookupCheck" id="all">
			<input type="submit" name="lookupAllSubmit" id="lookupAllSubmit" style="display:none;">
		</form>
		<form id="lookup" method="get" action="lookup.php">
			<input type="text" name="firstname" id="firstname" placeholder="First Name" required>
			<input type="text" name="middlename" id="middlename" placeholder="Middle Name" >
			<input type="text" name="lastname" id="lastname" placeholder="Last Name" required>
			<input type="submit" name="submit" id="lookupSubmit" value="Search" >
		</form>
		<div id="error" style="color:red;"><?php if(isset($msg)) echo $msg; ?></div>
		<div class="result">
		<?php 
			if($result){ 
				print_r($result);
			}
		?>
		</div>
	</body>

	<script src="../../public/scripts/lookup.js"></script>
</html>