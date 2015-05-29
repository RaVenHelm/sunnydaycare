<?php
    require_once('../../server/session.php');
    require_once('../../server/functions.php');
    require_once('../../server/objects/Client.php');
    if (!$session->is_logged_in()) { redirect_to('../login.php'); }
    if(isset($_GET["submit"])){
        $result = Client::search(trim($_GET["firstname"]), (trim($_GET["middlename"]) == "" ? null : trim($_GET["middlename"])), trim($_GET["lastname"]));
        if(!$result) {$msg = "<ul><li>No client found.</li></ul>";}
    }
    if (isset($_POST["update"])) {
        $client = new Client($_POST["firstname"], $_POST["middlename"], $_POST["lastname"], $_POST["gender"], isset($_POST["isactive"]) ? true: false, isset($_POST["primarycontact"]) ? true : false, isset($_POST["billpayer"]) ? true : false, isset($_POST["stateassistance"]) ? true : false , $_POST["telephone"]["primary"], $_POST["telephone"]["secondary"], $_POST["relationship"], $_POST["address"]["billing"], $_POST["address"]["mailing"]);
        $client->setComments($_POST["comments"]);
        $client->setId($_POST["id"]);
        if($client->save()){
            $msg = "Client Data Saved";
        }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
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
                <form id="lookup" method="get" action="update.php">
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
                <div id="update" title="Client Data">
                    <form id="updateForm" name="register" method="post" action="update.php">
                        (<span style="color:red;">*</span>) Required<br>
                        <label for="firstname">First Name: <span style="color:red;">*</span></label><br>
                        <input type="text" name="firstname" class="firstname" placeholder="First Name" required><br>
                        <label for="middlename">Middle Name: </label><br>
                        <input type="text" name="middlename" class="middlename" placeholder="Middle Name"><br>
                        <label for="lastname">Last Name: <span style="color:red;">*</span></label><br>
                        <input type="text" name="lastname" class="lastname" placeholder="Last Name" required><br>
                        <label for="gender">Gender <span style="color:red;">*</span></label><br>
                        <select name="gender" class="gender" required>
                            <option value="">Select one:</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                            <option value="O">Other/Not disclosed</option>
                        </select><br>
                        <label for="relationship">Relationship <span style="color:red;">*</span></label><br>
                        <select name="relationship" class="relationship" required>
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
                        <label for="isactive">Active?</label>
                        <input type="checkbox" name="isactive" class="isactive"><br>
                        <label for="primarycontact">Is the primary contact?</label>
                        <input type="checkbox" name="primarycontact" class="primarycontact"><br>
                        <label for="telephone[primary]">Primary Phone Number <span style="color:red;">*</span></label><br>
                        <input type="tel" name="telephone[primary]" id="primary" class="phone" placeholder="###-###-####" required><br>
                        <label for="telephone[secondary]">Secondary Phone Number</label><br>
                        <input type="tel" name="telephone[secondary]" id="secondary" class="phone" placeholder="###-###-####"><br>
                        <label for="billpayer">Is the bill payer?</label>
                        <input type="checkbox" name="billpayer" class="billpayer"><br>
                        <label for="address[mailing]">Mailing Address <span style="color:red;">*</span></label><br>
                        <input type="text" name="address[mailing]" placeholder="Mailing Address" id="mailing" required><br>
                        <label for="address[billing]">Billing Address <span style="color:red;">*</span></label><br>
                        <input type="text" name="address[billing]" placeholder="Billing Address" id="billing" required><br>
                        <label for="stateassistance">On state assistance?</label>
                        <input type="checkbox" name="stateassistance" id="assist"><br>
                        <label for="comments">Comments</label><br>
                        <textarea name="comments" class="comments" cols="30" rows="10"></textarea>
                        <input type="hidden" name="id" class="id">
                        <br><input type="submit" name="update" id="updateSubmit" value="Update" >
                    </form>
                </div>
                <div id="msg" title="Message"><?php if(isset($msg)) echo $msg; ?></div>
            </div>
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
    <script src="../../public/scripts/update.js"></script>
</html>