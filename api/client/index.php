<?php 
    try{
        include('../../server/db/database.php');
        //echo "Success!";
        $children = [];
        $result = $database->select("SELECT * FROM client;");
        while($row  = $result->fetch(PDO::FETCH_ASSOC)){
            $child = $row;
            //array_push($child, "firstname", $row["firstname"]);
            //array_push($child, "lastname", $row["lastname"]);
            $json = json_encode($child, JSON_PRETTY_PRINT);
            array_push($children, $json);
        }
        
        echo $children;
    } catch (Exception $ex){
        echo $ex->getMessage();
    }
?>