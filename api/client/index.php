<?php 
    try{
        include('../../server/db/database.php');
        //echo "Success!";
        $result = $database->select("SELECT firstname, middlename, lastname FROM client WHERE isactive = TRUE;");
        $children = '<ul class="clients">';
        while($row  = $result->fetch(PDO::FETCH_ASSOC)){
            $name = "<li>" . $row["firstname"] . " " . $row["middlename"]  . " " . $row["lastname"] . "</li>";
            $children .= $name;
        }
        $children .= "</ul>";
        echo $children;
    } catch (Exception $ex){
        echo $ex->getMessage();
    }
?>