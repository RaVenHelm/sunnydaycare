<?php 
    //Get all the active children in the DB
    try{
        include('../../server/db/database.php');
        //echo "Success!";
        $result = $database->select("SELECT firstname, middlename, lastname FROM child WHERE isactive = TRUE;");
        $children = '<ul class="children">';
        while($row  = $result->fetch(PDO::FETCH_ASSOC)){
            $name = "<li>" . $row["firstname"] . " " . $row["middlename"]  . " " . $row["lastname"] . "</li>";
            $children .= $name;
        }
        $children .= "</ul>";
        echo $children;
        //echo json_encode($children, JSON);
    } catch (Exception $ex){
        echo $ex->getMessage();
    }
?>