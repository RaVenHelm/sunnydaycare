<?php
require_once('../server/db/database.php');
date_default_timezone_set('America/Denver');

class Alert {

    public static function getClient($id = 0){
        global $database;
        if($id !== 0){
            $sql = "SELECT type, descrip FROM `client alert` WHERE Client_id = :id";
            $sth = $database->prepare($sql);
            $sth->execute(array(':id' => $id));

            return $sth->fetchAll(PDO::FETCH_ASSOC);
        } else if($id === 0) {
            $sql = "SELECT type, descrip FROM `client alert`";

            $sth = $database->prepare($sql);
            $sth->execute();

            return $sth->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
    public static function getChild($id = 0){
        global $database;
        if($id !== 0){
            $sql = "SELECT type, descrip FROM `child alert` WHERE Client_id = :id";

            $sth = $database->prepare($sql);
            $sth->execute(array(':id' => $id));

            return $sth->fetchAll(PDO::FETCH_ASSOC);
        } else if($id === 0) {
            $sql = "SELECT type, descrip FROM `child alert`";

            $sth = $database->prepare($sql);
            $sth->execute();

            return $sth->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public static function getAll(){
        global $database;

        $result = [];

        $sql = "SELECT `firstname`, `middlename`, `lastname`, `client alert`.`id`,`type`, `descrip` FROM `client alert` LEFT JOIN `client` ON `Client_id` = `client`.`id` ORDER BY `lastname`;";
        $sth = $database->prepare($sql);
        $sth->execute();

        array_push($result,$sth->fetchAll(PDO::FETCH_ASSOC));

        $sql = "SELECT `firstname`, `middlename`, `lastname`, `child alert`.`id`, `type`, `descrip` FROM `child alert` LEFT JOIN `child` ON `Child_id` = `child`.`id` ORDER BY `lastname`;";
        $sth = $database->prepare($sql);
        $sth->execute();

        array_push($result,$sth->fetchAll(PDO::FETCH_ASSOC));
        return $result;
    }

    public static function delete($id, $isClient)
    {
        global $database;
        
        if ($isClient) {
            $sql = "DELETE FROM `client alert` WHERE `id` = ?;";
            $sth = $database->prepare($sql);
            return $sth->execute(array($id));
        } else {
            $sql = "DELETE FROM `child alert` WHERE `id` = ?;";
            $sth = $database->prepare($sql);
            return $sth->execute(array($id));
        }
    }
}