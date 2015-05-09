<?php
require_once('../../server/db/database.php');
date_default_timezone_set('America/Denver');

class Incident {

    private $data = array();

    private $type;

    public static function getAll(){
        $childIncidents = Incident::getChildIncidents();
        $clientIncidents = Incident::getClientIncidents();
        $employeeIncidents = Incident::getEmployeeIncidents();

        return array('child' => $childIncidents, 'client' => $clientIncidents, 'employee' => $employeeIncidents);
    }

    public static function getChildIncidents(){
        global $database;

        $sql = "SELECT type, descrip, date FROM `child incident`;";

        $sth = $database->prepare($sql);
        if($sth->execute()){
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }

    public static function getClientIncidents(){
        global $database;

        $sql = "SELECT type, descrip, date FROM `client incident`;";

        $sth = $database->prepare($sql);
        if($sth->execute()){
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }

    public static function getEmployeeIncidents(){
        global $database;

        $sql = "SELECT type, descrip, date FROM `employee incident`;";

        $sth = $database->prepare($sql);
        if($sth->execute()){
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }
}