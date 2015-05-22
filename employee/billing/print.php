<?php
require_once('../../server/session.php');
require_once('../../server/functions.php');
require_once('../../server/objects/Client.php');
require_once('../../server/objects/Invoice.php');

if (!$session->is_logged_in()) { redirect_to('../login.php'); }

if(isset($_GET["print"])){
	
	if (isset($_GET["id"])) {
		$client = Client::find_one_id($_GET["id"]);
		$invoices = Invoice::getAll($client->getId());
	} else {
		$msg = "No id given;";
	}
    
    if(!$client) {$msg = "<ul><li>No client found.</li></ul>";}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Billing Invoice for <?php  echo $client->getFullName(); ?></title>
	<link rel="Stylesheet" href="../../public/styles/normalize.css" type="text/css"/>
	<link rel="stylesheet" href="../../public/styles/print.css">
</head>
<body>
	<a href="<?php echo $_SERVER["HTTP_REFERER"]; ?>" rel="prev"><< Go back to the viewing page</a>
	<div class="wrapper">
		<div id="invoices">
			<?php 
				if (isset($invoices)) {
					foreach ($invoices as $invoice) {
						if ($invoice["isFullyPaid"] === "0") {
							?>
							<ul class="invoice">
								<li>
									<h3 class="invoiceNum">
										<p>Sunny Day Care</p>
										<p>Invoice Number <?php echo $invoice["id"]; ?><p>
									</h3>
								</li>
								<li>
									<h3>Client Name</h3>
									<p><?php echo $client->getFullName(); ?></p>
								</li>
								<li>
									<h3>Addressess</h3>
									<ul class="addresses">
										<li class="mailing">Mailing Address: <span><?php echo $client->getAddr(false); ?></span></li>
										<li class="billing">Billing Address: <span><?php echo $client->getAddr(true); ?></span></li>
									</ul>
								</li>
								<li>
									<h3>Phone Numbers</h3>
									<ul class="phoneNums">
										<li class="primaryPhone">Priamry Phone: <span class="phone"><?php echo $client->getPhone(true); ?></span></li>
										<li class="secondaryPhone">Secondary Phone: <spanc class="phone"><?php echo $client->getPhone(false); ?></span></li>
									</ul>
								</li>
								<li>
									<h3>Date Made:</h3>
									<p class="date"><?php echo $invoice["datemade"]; ?></p>
								</li>
								<li>
									<h3>Date Due:</h3>
									<p class="date"><?php echo $invoice["datedue"]; ?></p>
								</li>
								<li>
									<h3>Amount Due: </h3>
									<p>$<?php echo number_format(floatval($invoice["total"]), 2); ?></p>
								</li>
								<li>
									<h3>Last Date Payment Was Made:</h3>
									<p class="date"><?php echo $invoice["paymentdate"] ? $invoice["paymentdate"] : "No payment made"; ?></p>
								</li>
							</ul>
						<?php
						}
					}
				}
			?>
		</div>
	</div>
	<div id="msg"><?php if(isset($msg)) echo $msg; ?></div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="../../public/scripts/moment.min.js"></script>
<script>
	$(document).ready(function () {
		$(".date").each(function (index, el) {
			if (el.innerHTML !== "No payment made") {
				el.innerHTML = moment(el.innerHTML).format("MMMM DD, YYYY");
			}
		});
	});
</script>
</html>