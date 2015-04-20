<?php

    echo 'Hello?';

        include('../../server/db/database.php');
        $database = new database();
        
        $hash = password_hash("password!");
        $sql = "INSERT INTO employee VALUES (NULL, 'scarjo101', '". $hash ."', 'Scarlett', NULL, 'Johansson', 1);";
        $database->select($sql);

?>