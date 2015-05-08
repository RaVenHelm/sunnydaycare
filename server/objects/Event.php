<?php
require_once('../../server/db/database.php');
date_default_timezone_set('America/Denver');

class Event {

    public static function getAll(){
        global $database;

        $sql = "SELECT * FROM event WHERE date >= CURRENT_DATE;";
        $sth = $database->prepare($sql);
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}