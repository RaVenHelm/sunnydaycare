<?php

require_once('../../server/objects/Client.php');
require_once('../../server/objects/Alert.php');

if($_GET["search"]){

    $id = $_GET["id"];

    $alerts = Alert::getClient($id);

    $client = Client::find_one_id($id);

    var_dump($client);

    return json_encode(array('client' => $client, 'alerts' => $alerts));
} else {
    return json_encode(false);
}

?>