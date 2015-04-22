<?php

    echo 'Hello?';

        include('../../server/db/database.php');
        //$database = new database();
        
        $hash = password_hash("101_anchor", PASSWORD_BCRYPT);
        $sql = "INSERT INTO employee VALUES (NULL, 'tenders0302', '". $hash ."', 'Tyberius', 'Caine', 'Enders', 4);";
        $database->select($sql);

?>