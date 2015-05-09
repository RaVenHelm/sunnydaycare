<?php
require_once('../../server/session.php');
require_once('../../server/functions.php');
require_once('../../server/objects/Incident.php');

if (!$session->is_logged_in()) { redirect_to('../login.php'); }

$incidents = Incident::getAll();

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
<div class="wrapper" style="background-color: cornsilk;">
    <?php include('../templates/userbar.php'); ?>

    <div class="calendar">
        <?php if($incidents){?>
			<?php echo $incidents["child"][0]["type"] . "<br>" . $incidents["child"][0]["descrip"]; ?>
        <?php } ?>
    </div>
    <div id="error" title="Error"></div>

    <div id="msg"><?php if(isset($msg)) echo $msg; ?></div>

</div>
</body>

<script src="../../public/scripts/incidents.js"></script>
</html>