<?php
require_once('../../server/session.php');
require_once('../../server/functions.php');
require_once('../../server/objects/Client.php');
if (!$session->is_logged_in()) { redirect_to('../login.php'); }
if(isset($_GET["submit"])){
$result = Client::search(trim($_GET["firstname"]), (trim($_GET["middlename"]) == "" ? null : trim($_GET["middlename"])), trim($_GET["lastname"]));
if(!$result) {$msg = "<ul><li>No client found.</li></ul>";}
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
                <h2>Client Search</h2>
                <form id="lookup" method="get" action="lookup.php">
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
                <button class="clientSingle" id="<?php echo $result[$i]["id"]; ?>" value="<?php echo $result[$i]["id"]; ?>"><?php echo $result[$i]["firstname"] . " " . $result[$i]["middlename"] . " " . $result[$i]["lastname"]; ?></button><br>
                <?php } ?>
                <?php } ?>
                <div id="alert" title="Alert!"></div>
                <div id="accordion" title="Client Data">
                    <h3 class="name"></h3>
                    <div></div>
                    <h3>Gender</h3>
                    <div class="gender"></div>
                    <h3>Primary Phone Number</h3>
                    <div class="primaryPhone"></div>
                    <h3>Secondary Phone Number</h3>
                    <div class="secondaryPhone"></div>
                    <h3>Comments</h3>
                    <div class="comments"></div>
                </div>
                <div id="msg" title="Message"><?php if(isset($msg)) echo $msg; ?></div>
            </div>
        </div>
    </body>
    <script src="../../public/scripts/lookup.js"></script>
</html>