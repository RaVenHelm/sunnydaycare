<?php 
    try{
        include('../../server/db/database.php');
        //echo "Success!";
        $result = $database->select("SELECT firstname, middlename, lastname FROM client WHERE isactive = TRUE;");
        $clients = '<select class="clients"><option value="">Select a client name</option>';
        while($row  = $result->fetch(PDO::FETCH_ASSOC)){
            $name = "<option value =\"" . $row["firstname"] . " " . $row["lastname"] ."\">" . $row["firstname"] . " " . $row["middlename"]  . " " . $row["lastname"] . "</option>";
            $clients .= $name;
        }
        $clients .= "</select>";
        echo $clients;
    } catch (Exception $ex){
        echo $ex->getMessage();
    }
?>