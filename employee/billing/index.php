<?php 
	include('../../server/session.php');
	include('../../server/functions.php');
	include('../../server/objects/Client.php');
	
	if (!$session->is_logged_in()) { redirect_to('../login.php'); }
	if(isset($_GET["submit"])){
    	$result = Client::search(trim($_GET["firstname"]), (trim($_GET["middlename"]) == "" ? null : trim($_GET["middlename"])), trim($_GET["lastname"]));

    	if(!$result) $msg = "<ul><li>No client found.</li></ul>";
    }


    if (isset($_POST["billing"])) {
    	var_dump($_POST);
    }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sunny Day Care | Billing Page</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
	
	<!-- Custom styles -->
	<link rel="Stylesheet" href="../../public/styles/normalize.css" type="text/css"/>
	<link rel="Stylesheet" href="../../public/styles/webpage.css" type="text/css" />
</head>
<body>
<div class="container">
	<div class="header"><a href="/sunnydaycare/">Sunny Daycare</a></div>
		<div class="wrapper">
			<?php include('../templates/userbar.php'); ?>
			<div id="search">
				<h2>Client Billing</h2>
		        <form id="lookup" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		            <label for"firstname">First Name</label><br>
		            <input type="text" name="firstname" id="firstname" placeholder="First Name" required><br>
		            <label for"firstname">Middle Name</label><br>
		            <input type="text" name="middlename" id="middlename" placeholder="Middle Name" ><br>
		            <label for"firstname">Last Name</label><br>
		            <input type="text" name="lastname" id="lastname" placeholder="Last Name" required><br>
		            <input type="submit" name="submit" id="lookupSubmit" value="Search" >
		        </form>
			</div>
			<div id="result">
				<?php if(isset($result) && $result){ ?>
		            <?php for($i = 0; $i < count($result); $i++) {?>
		                <button class="clientSingle" id="<?php echo $result[$i]["id"]; ?>" value="<?php echo $result[$i]["id"]; ?>"><?php echo $result[$i]["firstname"] . " " . $result[$i]["middlename"] . " " . $result[$i]["lastname"]; ?></button><br>
		            <?php } ?>
	        	<?php } ?>
			</div>
			<div id="accordion" title="Client Data">
	            <form id="createBilling" method="post" name="billing" action="index.php">
	            	<label for="startEndDates"></label><br>
	            	<input type="text" class="startEndDates" name="startDate" placeholder="Start Date" required><br>
	            	<input type="text" class="startEndDates" name="endDate" placeholder="End Date" required><br>
	            	<input type="hidden" name="id" id="id">
	            	<input type="submit" name="billing" value="Submit">
	            </form>
	        </div>
			<div id="msg" title="Message"><?php if(isset($msg)) echo $msg; ?></div>
		</div>
		<div id="error" title="Error"></div>
</div>
<script src="../../public/scripts/billing.js"></script>
</body>
</html>