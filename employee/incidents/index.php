<?php 
    require_once('../../server/session.php');
    require_once('../../server/functions.php');
    require_once('../../server/objects/Child.php');
    require_once('../../server/objects/Client.php');
    
    if (!$session->is_logged_in()) { redirect_to('../login.php'); }
    if(isset($_GET["child"])){
        $result = Child::search(trim($_GET["firstname"]), (trim($_GET["middlename"]) == "" ? null : trim($_GET["middlename"])), trim($_GET["lastname"]));
        if(!$result) {$msg = "<ul><li>No child found.</li></ul>";}
    }
    if(isset($_GET["client"])){
        $client = Client::search(trim($_GET["firstname"]), (trim($_GET["middlename"]) == "" ? null : trim($_GET["middlename"])), trim($_GET["lastname"]));
        if(!$client) {$msg = "<ul><li>No client found.</li></ul>";}
    }
?>

<!DOCTYPE html>

<html>

    <head>
        <meta charset="utf-8">
        <title>Sunny Day Care | Incidents Page</title>
        
        <!-- Custom styles -->
        <link rel="Stylesheet" href="../../public/styles/normalize.css" type="text/css"/>
        <link rel="Stylesheet" href="../../public/styles/webpage.css" type="text/css" />
    </head>

    <body>
        <div class="header"><a href="../">Sunny Daycare</a></div>
        <div class="wrapper">
            <?php include('../templates/userbar.php'); ?>
            <div id="search">
                <h2>Child Incidents Search</h2>
                <form id="childLookup" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label for"firstname">First Name</label><br>
                    <input type="text" name="firstname" id="firstname" placeholder="First Name" required><br>
                    <label for"firstname">Middle Name</label><br>
                    <input type="text" name="middlename" id="middlename" placeholder="Middle Name" ><br>
                    <label for"firstname">Last Name</label><br>
                    <input type="text" name="lastname" id="lastname" placeholder="Last Name" required><br>
                    <input type="submit" name="child" id="lookupSubmit" value="Search" >
                </form>
                <br>
                <h2>Client Incidents Search</h2>
                <form id="clientLookup" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label for"firstname">First Name</label><br>
                    <input type="text" name="firstname" id="firstname" placeholder="First Name" required><br>
                    <label for"firstname">Middle Name</label><br>
                    <input type="text" name="middlename" id="middlename" placeholder="Middle Name" ><br>
                    <label for"firstname">Last Name</label><br>
                    <input type="text" name="lastname" id="lastname" placeholder="Last Name" required><br>
                    <input type="submit" name="client" id="lookupSubmit" value="Search" >
                </form>
            </div>
            
            <div id="error" title="Error"></div>
            <div id="result">
                <?php if(isset($result) && $result){ ?>
                        <?php for($i = 0; $i < count($result); $i++) {?>
                            <button class="childSingle" id="<?php echo $result[$i]["id"]; ?>" value="<?php echo $result[$i]["id"]; ?>"><?php echo $result[$i]["firstname"] . " " . $result[$i]["middlename"] . " " . $result[$i]["lastname"]; ?></button><br>
                        <?php } ?>
                <?php } ?>
                <?php if(isset($client) && $client){ ?>
                        <?php for($i = 0; $i < count($client); $i++) {?>
                            <button class="clientSingle" id="<?php echo $client[$i]["id"]; ?>" value="<?php echo $client[$i]["id"]; ?>"><?php echo $client[$i]["firstname"] . " " . $client[$i]["middlename"] . " " . $client[$i]["lastname"]; ?></button><br>
                        <?php } ?>
                <?php } ?>
                <div id="childAccordion" title="Child Data"></div>
                <div id="clientAccordion" title="Client Data"></div>
                <div id="msg"><?php if(isset($msg)) echo $msg; ?></div>
            </div>
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
    <script src="../../public/scripts/moment.min.js"></script>
    <script src="../../public/scripts/incidents.js"></script>
</html>