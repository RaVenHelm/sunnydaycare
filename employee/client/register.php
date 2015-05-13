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

        $client = new Client($_POST["firstname"], $middle, $_POST["lastname"], $_POST["gender"], true, $contact, $payer, $state, $_POST["telephone"]["primary"], $secondary, $_POST["relationship"]);

        //TODO: Add Client object validations
        if($client->add()){
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
    <div class="register">
        <h2>Register Client</h2>
        <form id="registerForm" name="register" method="post" action="register.php">
            (<span style="color:red;">*</span>) Required<br>
            <label for="firstname">First Name: <span style="color:red;">*</span></label><br>
            <input type="text" name="firstname" id="firstname" placeholder="First Name" required><br>
            <label for="middlename">Middle Name: </label><br>
            <input type="text" name="middlename" id="middlename" placeholder="Middle Name"><br>
            <label for="lastname">Last Name: <span style="color:red;">*</span></label><br>
            <input type="text" name="lastname" id="lastname" placeholder="Last Name" required><br>

            <label for="gender">Gender <span style="color:red;">*</span></label><br>
            <select name="gender" id="gender" required>
                <option value="">Select one:</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
                <option value="O">Other/Not disclosed</option>
            </select><br>

            <label for="relationship">Relationship <span style="color:red;">*</span></label><br>
            <select name="relationship" id="relationship" required>
                <option value="">Select one:</option>
                <option value="Mother">Mother</option>
                <option value="Father">Father</option>
                <option value="Brother">Brother</option>
                <option value="Sister">Sister</option>
                <option value="Grandmother">Grand Mother</option>
                <option value="Grandfather">Grand Father</option>
                <option value="Uncle">Uncle</option>
                <option value="Aunt">Aunt</option>
                <option value="Other">Other</option>
            </select><br>

            <label for="primarycontact">Is the primary contact?</label>
            <input type="checkbox" name="primarycontact"><br>

            <label for="telephone[primary]">Primary Phone Number <span style="color:red;">*</span></label><br>
            <input type="tel" name="telephone[primary]" class="phone" placeholder="###-###-####" required><br>

            <label for="telephone[secondary]">Secondary Phone Number</label><br>
            <input type="tel" name="telephone[secondary]" class="phone" placeholder="###-###-####"><br>

            <label for="billpayer">Is the bill payer?</label>
            <input type="checkbox" name="billpayer"><br>

            <label for="address[mailing]">Mailing Address <span style="color:red;">*</span></label><br>
            <input type="text" name="address[mailing]" placeholder="Mailing Address" id="mailing" required><br>

            <label for="addressSame">Is the Billing Address the same as Mailing Address?</label>
            <input type="checkbox" name="addressSame" id="addressSame"><br>

            <label for="address[billing]">Billing Address <span style="color:red;">*</span></label><br>
            <input type="text" name="address[billing]" placeholder="Billing Address" id="billing" required><br>

            <label for="stateassistance">On state assistance?</label>
            <input type="checkbox" name="stateassistance"><br>

            <br><input type="submit" name="register" id="registerSubmit" value="Register" >
        </form>
    </div>
</div>
<div id="msg" title="Message"><?php if(isset($msg)) echo $msg; ?></div>
<div id="error" title="Error"></div>
</body>

<script src="../../public/scripts/register.js"></script>
</html>