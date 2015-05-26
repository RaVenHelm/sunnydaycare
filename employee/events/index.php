<?php
require_once('../../server/session.php');
require_once('../../server/functions.php');
require_once('../../server/objects/Event.php');

if (!$session->is_logged_in()) { redirect_to('../login.php'); }
if (isset($_POST["add"])) {
    
    if (Event::add($_POST["title"], $_POST["date"], $_POST["time"], $_POST["description"])) {
        $msg = "Event Added!";
    } else {
        $msg = "Event could not be added.";
    }
}

?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">

    <!-- Custom styles -->
    <link rel="Stylesheet" href="../../public/styles/normalize.css" type="text/css"/>
    <link rel="Stylesheet" href="../../public/styles/webpage.css" type="text/css" />
</head>

<body>
<div class="header"><a href="../">Sunny Daycare</a></div>
<div class="wrapper" style="background-color: cornsilk;">
    <?php include('../templates/userbar.php'); ?>

    <div id="calendar" class="clearfix">  
    </div><br>

    <div id="event" title="Event"></div>
    
    <div id="error" title="Error"></div>

    <div id="msg" title="Message"><?php if(isset($msg)) echo $msg; ?></div>
    <button id="add">Add</button>
    <div id="addDialog" title="Add An Event">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="add" id="addEvent" method="post">
            <label for="title">Title</label><br>
            <input type="text" id="title" name="title"><br>
            <label for="date">Date</label><br>
            <input type="text" id="date" name="date"><br>
            <label for="time">Time</label><br>
            <input type="time" id="time" name="time"><br>
            <label for="description">Description</label><br>
            <textarea id="description" name="description"></textarea><br>
            <input type="submit" name="add" value="Add">
        </form>
    </div>
</div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>

    <script src="../../public/scripts/moment.min.js"></script>
    <script src="../../public/scripts/underscore.min.js"></script>
    <script src="../../public/scripts/clndr.min.js"></script>

<script src="../../public/scripts/employee.events.js"></script>
</html>