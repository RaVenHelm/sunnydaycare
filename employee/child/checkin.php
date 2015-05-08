<?php 
	include('../../server/session.php');
	include('../../server/functions.php');
	require_once('../../server/objects/Child.php');
	
	if (!$session->is_logged_in()) { redirect_to('../login.php'); }
	
	if(isset($_GET["submit"])){
		$result = Child::find_one(trim($_GET["firstname"]), (trim($_GET["middlename"]) == "" ? null : trim($_GET["middlename"])), trim($_GET["lastname"]));
		if(!$result) {$msg = "<ul><li>No child found.</li></ul>";}
		
		$name = $result["firstname"] . ($result["middlename"] ? " " . $result["middlename"] : "") . " " . $result["lastname"];
	}
	
	if(isset($_POST["submit"])){
		$msg = Child::checkInOut($_POST["childId"], $_POST["clientId"], $_POST["isCheckIn"]);
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
			#listHead{
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
                    <input type="text" name="firstname" id="firstname" placeholder="First Name" required><br>
                    <input type="text" name="middlename" id="middlename" placeholder="Middle Name"><br>
                    <input type="text" name="lastname" id="lastname" placeholder="Last Name" required><br>
                    <input type="submit" name="submit" id="searchSubmit" value="Search" >
                </form>
            </div>
            <div id="error" style="color:red;" title="Error"></div>
            <div id="msg" title="Message"><?php if(isset($msg)) echo $msg; ?></div>
            <div id="result">

                <?php if(isset($result) && $result){?>
                <div id="accordion">
                    <h3>Child</h3>
                    <div id="childName">
                        <p>
                        <?php echo $name . "<br>"; ?>
                        <?php if(!$result[1][0]["CheckIn"] && !$result["checkedIn"]){?>
                            <button id="checkIn">Check In</button>
                        <?php } else {
                            echo "Checked In: " . $result[1][0]["CheckIn"] . " by " . $result[1][0]["firstname"] . " " . $result[1][0]["lastname"] . "<br>";
                        }?>
                        <?php if(!$result[1][1]["CheckOut"] && $result["checkedIn"]){?>
                            <button id="checkOut">Check Out</button>
                        <?php
                        } else if($result[1][1]["CheckOut"]) {
                                echo "Checked Out: " . $result[1][1]["CheckOut"] . " by " . $result[1][1]["firstname"] . " " . $result[1][1]["lastname"] . "<br>";
                        } else {
                            echo "";
                        }
                        ?>
                        </p>
                    </div>
                    <h3 id="listHead">Who is checking in/out the child?</h3>
                    <div id="pickupList">
                        <form id="checkInForm" method="post" action="checkin.php">
                            <input hidden name="childId" id="childId" value="<?php echo $result["id"]; ?>" >
                            <input hidden name="isCheckIn" value="<?php echo !$result["checkedIn"] ? 1 : 0; ?>" >
                            <select name="clientId" class="pickupSelect">
                                <option value="">Select from this list:</option>
                                <?php for($i = 0; isset($result[0][$i]); $i++){ ?>
                                    <?php $pickupName = $result[0][$i]["firstname"] . " " . $result[0][$i]["middlename"] . " " . $result[0][$i]["lastname"] ;?>
                                        <option value="<?php echo $result[0][$i]["id"]; ?>">
                                        <?php echo $pickupName; ?>
                                        </option>
                                <?php } ?>
                            </select>
                            <input type="submit" name="submit" value="Submit">
                        </form>
                        <aside><i>Note: if the person is not on this list, <b>DO NOT RELEASE THE CHILD</b></i></aside>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
	</body>

	<script src="../../public/scripts/checkin.js"></script>
</html>