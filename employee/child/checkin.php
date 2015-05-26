<?php 
	include('../../server/session.php');
	include('../../server/functions.php');
	require_once('../../server/objects/Child.php');
	
	if (!$session->is_logged_in()) { redirect_to('../login.php'); }
	
	if(isset($_GET["submit"])){
		$result = Child::find_one(trim($_GET["firstname"]), (trim($_GET["middlename"]) == "" ? null : trim($_GET["middlename"])), trim($_GET["lastname"]));
		if(!$result) {$msg = "<ul><li>No child found.</li></ul>";}
	}
	
	if(isset($_POST["submit"])){
		$msg = Child::checkInOut($_POST["childId"], $_POST["clientId"], ($_POST["isCheckIn"] == "0" ? false : true));
	}
?>

<!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
		<style>
			.listHead{
				display: none;
			}
		</style>

        <!-- Custom styles -->
        <link rel="Stylesheet" href="../../public/styles/normalize.css" type="text/css"/>
        <link rel="Stylesheet" href="../../public/styles/webpage.css" type="text/css" />
	</head>

	<body>
        <div class="header"><a href="/sunnydaycare">Sunny Daycare</a></div>
        <div class="wrapper">
            <?php include('../templates/userbar.php'); ?>
            <div id="search">
                <h2>Child Check In / Check Out</h2>
                <form id="lookup" method="get">
					<label for="firstname">First Name</label><br>
                    <input type="text" name="firstname" id="firstname" placeholder="First Name" required><br>
					<label for="middlename">Middle Name</label><br>
                    <input type="text" name="middlename" id="middlename" placeholder="Middle Name"><br>
					<label for="lastname">Last Name</label><br>
                    <input type="text" name="lastname" id="lastname" placeholder="Last Name" required><br>
                    <input type="submit" name="submit" id="searchSubmit" value="Search" >
                </form>
            </div>
            <div id="error" style="color:red;" title="Error"></div>
            <div id="msg" title="Message"><?php if(isset($msg)) echo $msg; ?></div>
            <div id="result">

                <?php if(isset($result) && $result){?>
                <div id="accordion">
                    <?php foreach ($result as $child) { ?>
                        <!-- <h3>Child</h3> -->
                        <h3 class="childName">
                            <?php echo $child["child"]->getFullName(); ?>
                        </h3>
                        <div>
                            <?php if ($child["child"]->getCheckedIn()) { ?>
                                <h3 class="checkIn">Checked In</h3>
                            <?php } ?> 
                            <?php if (!$child["child"]->getCheckedIn()) { ?>
                                <h3 class="checkOut">Checked Out</h3>
                            <?php } ?>
                            <h3 class="listHead">Who is checking in/out the child?</h3>
                            <div class="pickupList">
                                <label for="checkInOutForm">Click to <?php echo ($child["child"]->getCheckedIn()) ? "Check Out" : "Check In";?></label>
                                <form class="checkInForm" name="checkInOutForm" method="post" action="checkin.php">
                                    <input hidden name="childId" id="childId" value="<?php echo $child["child"]->getId(); ?>" >
                                    <input hidden name="isCheckIn" value="<?php echo $child["child"]->getCheckedIn() ? 1 : 0; ?>" >
                                    <select name="clientId" class="pickupSelect">
                                        <option value="">Select from this list:</option>
                                        <?php foreach ($child["child"]->getClientList() as $clients) { ?>
                                            <option value="<?php echo $clients["id"];?>"><?php echo $clients["firstname"] . " " . $clients["lastname"]; ?></option>
                                        <?php } ?>
                                    </select>
                                    <input type="submit" name="submit" value="Submit">
                                </form>
                                <aside><i>Note: if the person is not on this list, <b>DO NOT RELEASE THE CHILD</b></i></aside>
                            </div>                                 
                        </div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </div>
	</body>

	<script src="../../public/scripts/checkin.js"></script>
</html>