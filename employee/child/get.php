<?php
/**
 * Created by PhpStorm.
 * User: Ty
 * Date: 5/5/2015
 * Time: 10:57 PM
 */

include('../../server/objects/Child.php');

if (isset($_GET)) {
    if($_GET["id"]){
        /* Will return JSON to calling page */
        $child = Child::find_one_id($_GET["id"]);

        echo json_encode($child, JSON_PRETTY_PRINT);
    } else {
        echo json_encode("{error: 'Invalid parameters'}");
    }
}