<?php
require_once('../../server/db/database.php');
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

    }
}