<?php 
    try{
        include('../../server/db/database.php');
        //echo "Success!";
        $result = $database->select("SELECT * FROM child LIMIT 1;");
        $children = [];
        while($row  = $result->fetch(PDO::FETCH_ASSOC)){
            $json = [];
            foreach( $row as $key => $value){
                $json[$key] = $value;
            }
            array_push($children, json_encode($row, JSON_PRETTY_PRINT));
        }
        
        echo json_encode($children, JSON_PRETTY_PRINT);
    } catch (Exception $ex){
        echo $ex->getMessage();
    }
?>