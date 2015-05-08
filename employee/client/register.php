<?php
require_once('../../server/session.php');
require_once('../../server/functions.php');
require_once('../../server/objects/Client.php');

if (!$session->is_logged_in()) { redirect_to('../login.php'); }
if (isset($_POST["register"])) { //Form has been submitted
    try{
        $middle = isset($_POST["middlename"]) ? $_POST["middlename"] : null;
        $contact = isset($_POST["primarycontact"]) ? true : false;
        $payer = isset($_POST["billpayer"]) ? true : false;
        $state = isset($_POST["stateassistance"]) ? true : false;
        $secondary = isset($_POST["telephone"]["secondary"]) ? $_POST["telephone"]["secondary"] : null;

        $client = new Client($_POST["firstname"], $_POST["middlename"], $_POST["lastname"], $_POST["gender"], true, $contact, $payer, $state, $_POST["telephone"]["primary"], $secondary, $_POST["relationship"]);

        if(isset($client)){
            $msg = "Client " . $client->getFullName() . " created!";
        }

    } catch (Exception $ex){
        $msg = $ex->getMessage();
    }
}
else { //Form has not been submitted

}
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <!-- JQuery Core/UI -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>

    <!-- Custom Styles-->
    <link rel="Stylesheet" href="../../public/styles/normalize.css" />
    <link rel="Stylesheet" href="../../public/styles/webpage.css" />
</head>

<body>
<div class="header"><a href="/sunnydaycare/">Sunny Daycare</a></div>
<div class="wrapper">
    <?php include('../templates/userbar.php'); ?>
    <div id="search">
        <h2>Register Client</h2>
        <form id="registerForm" name="register" method="post" action="register.php" novalidate>
            <label for="firstname">First Name: </label><br>
            <input type="text" name="firstname" id="firstname" placeholder="First Name" required><br>
            <label for="middlename">Middle Name: </label><br>
            <input type="text" name="middlename" id="middlename" placeholder="Middle Name"><br>
            <label for="lastname">Last Name: </label><br>
            <input type="text" name="lastname" id="lastname" placeholder="Last Name" required><br>

            <label for="gender">Gender</label><br>
            <select name="gender" id="gender" required>
                <option value="">Select one:</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
                <option value="O">Other/Not disclosed</option>
            </select><br>

            <label for="relationship">Relationship</label><br>
            <select name="relationship" id="relationship" required>
                <option value="">Select one:</option>
                <option value="mother">Mother</option>
                <option value="father">Father</option>
                <option value="brother">Brother</option>
                <option value="sister">Sister</option>
                <option value="grandmother">Grand Mother</option>
                <option value="grandfather">Grand Father</option>
                <option value="uncle">Uncle</option>
                <option value="aunt">Aunt</option>
                <option value="other">Other</option>
            </select><br>

            <label for="primarycontact">Is the primary contact?</label>
            <input type="checkbox" name="primarycontact"><br>

            <label for="telephone[primary]">Primary Phone Number</label><br>
            <input type="tel" name="telephone[primary]" placeholder="##########"><br>

            <label for="telephone[secondary]">Secondary Phone Number</label><br>
            <input type="tel" name="telephone[secondary]" placeholder="##########"><br>

            <label for="billpayer">Is the bill payer?</label>
            <input type="checkbox" name="billpayer"><br>

            <label for="address[mailing]">Mailing Address</label><br>
            <input type="text" name="address[mailing]" placeholder="Mailing Address"><br>

            <label for="address[billing]">Billing Address</label><br>
            <input type="text" name="address[billing]" placeholder="Billing Address"><br>

            <label for="stateassistance">On state assistance?</label>
            <input type="checkbox" name="stateassistance"><br>

            <br><input type="submit" name="register" id="registerSubmit" value="Register" >
        </form>
    </div>
    <div id="result"></div>
</div>
<div id="msg" title="Messge"><?php if(isset($msg)) echo $msg; ?></div>
<div id="error" title="Error"></div>
</body>

<script src="../../public/scripts/register.js"></script>
</html>