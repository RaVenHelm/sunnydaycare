<?php 
	include('../../server/session.php');
	include('../../server/functions.php');
	include('../../server/objects/Client.php');
	include('../../server/objects/Invoice.php');
	
	if (!$session->is_logged_in()) { redirect_to('../login.php'); }
	if(isset($_GET["submit"])){
    	$result = Client::search(trim($_GET["firstname"]), (trim($_GET["middlename"]) == "" ? null : trim($_GET["middlename"])), trim($_GET["lastname"]));

    	if(!$result) $msg = "<ul><li>No client found.</li></ul>";
    }
    if(isset($_POST["pay"]) && isset($_POST["payment"])){
		$payments = $_POST["payment"];
		foreach ($payments as $payment) {
			foreach ($payment as $key => $value) {
				$id = intval($key);
				$due = floatval($value["due"]);
				$pay = floatval($value["amount"]);
				$paidOff = floatval($value["paidOff"]);
				if($pay == 0.00){
					continue;
				} else {
					$res = Invoice::pay($id, $due, $pay, $paidOff);
					if (isset($res["error"])) {
						$msg = $res["error"];
					} else {
						$msg = $res["success"];
					}
				}
			}
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sunny Day Care | Payment Page</title>

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
				<h2>Make a Payment</h2>
		        <form id="lookup" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" novalidate>
		            <label for"firstname">First Name</label><br>
		            <input type="text" name="firstname" id="firstname" placeholder="First Name" required><br>
		            <label for"firstname">Middle Name</label><br>
		            <input type="text" name="middlename" id="middlename" placeholder="Middle Name" ><br>
		            <label for"firstname">Last Name</label><br>
		            <input type="text" name="lastname" id="lastname" placeholder="Last Name" required><br>
		            <input type="submit" name="submit" id="lookupSubmit" value="Search" >
		        </form>
		        <button id="back"><a href="index.php">Billing Home Page</a></button>
			</div>
			<div id="result">
				<?php if(isset($result) && $result){ ?>
		            <?php for($i = 0; $i < count($result); $i++) {?>
		                <button class="paymentSingle" id="<?php echo $result[$i]["id"]; ?>" value="<?php echo $result[$i]["id"]; ?>"><?php echo $result[$i]["firstname"] . " " . $result[$i]["middlename"] . " " . $result[$i]["lastname"]; ?></button><br>
		            <?php } ?>
	        	<?php } ?>
			</div>
			<div id="accordion" title="Billing Data">
	            <form id="paymentForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
	            	<h3 id="name"></h3>
	            	<div id="invoices"></div>
	            </form>
	        </div>
			<div id="msg" title="Message"><?php if(isset($msg)) echo $msg; ?></div>
		</div>
		<div id="error" title="Error"></div>
</div>
<script src="../../public/scripts/billing.js"></script>
</body>
</html>