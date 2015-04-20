<?php

    echo 'Hello?';

        include('../../server/db/database.php');
        $database = new database();
        
        $hash = password_hash("password!", PASSWORD_BCRYPT);
        $sql = "INSERT INTO employee VALUES (NULL, 'joegordon', '". $hash ."', 'Joesph', NULL, 'Gordon-Levitt', 1);";
        $database->select($sql);

?>