<?php 
    include('../../server/db/database.php');
    if ((isset($_GET["firstname"]) && $_GET["firstname"] !== "") && (isset($_GET["lastname"]) && $_GET["lastname"] !== "")) {
        $result = "<ul>";
        try{
            if(!isset($_GET["isDetailed"])){
                $stmt = $database->prepare("SELECT firstname, middlename, lastname, checkedIn FROM child WHERE firstname = :fname AND lastname = :lname AND isactive = TRUE LIMIT 1; ");
            } else {
                $stmt = $database->prepare("SELECT * FROM child WHERE firstname = :fname AND lastname = :lname AND isactive = TRUE LIMIT 1; ");
            }
            
            $stmt->execute(array(':fname' => $_GET["firstname"], ':lname' => $_GET["lastname"]));
            
            $child = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
            
            if($count != 0){
                if(!$_GET["isDetailed"]){
                    $result .= "<li>" . $child["firstname"] . " " . $child["middlename"] . " " . $child["lastname"] . "</li>";
                } else {
                    $result .= "<li>" . $child["firstname"] . " " . $child["middlename"] . " " . $child["lastname"] . "</li>";
                    $result .= "<ul><li><i>" .  (isset($child["comments"]) ? $child["comments"] : "No comments")  . "</i></li>";
                    $result .= "<li><b>" . ($child["checkedIn"] ? "Checked In" : "Checked Out") . "</b></li>";
					$result .= "<li><img width=\"200\" height=\"200\" src=\"". (isset($child["piclink"]) ? $child["piclink"] : "/sunnydaycare/pics/child/_blank.jpg") . "\" alt=\"Child\"></li></ul>";
                }
                $result .= "</ul>";
                echo $result;
            } else {
                echo false;
            }
        } catch (Exception $ex){
            echo $ex->getMessage();
        }
    } else {
        echo false;
    }
    
?>