<?php
    require_once('../../server/db/database.php');
    date_default_timezone_set('America/Denver');

class Client {
    private $data= array();

    private $id;

    private $firstName;
    private $middleName;
    private $lastName;

    private $gender;

    private $isActive;
    private $isPrimaryContact;
    private $isBillPayer;
    private $hasStateAssistance;
    private $relationship;

    private $primaryPhone;
    private $secondaryPhone;

    private $alerts;
    private $comments;
    private $incidents;

    private $children;

    private $picLink;

    function __construct($f, $m, $l, $gender, $active, $primary, $payer, $state, $pPhone, $sPhone, $relation){
        $this->firstName = $f;
        $this->middleName = $m;
        $this->lastName = $l;
        $this->gender = $gender;
        $this->isActive = $active;
        $this->isPrimaryContact = $primary;
        $this->isBillPayer = $payer;
        $this->hasStateAssistance = $state;
        $this->primaryPhone = $pPhone;
        $this->secondaryPhone = $sPhone;
        $this->relationship = $relation;
        $this->alerts = null;
        $this->comments = null;
        $this->incidents = null;
        $this->children = null;
        $this->picLink = null;

        $this->add();
    }

    public function __set($name, $val){
        $this->data[$name] = $val;
    }

    public function  __get($name){
        if(array_key_exists($name, $this->data)){
            return $this->data[$name];
        }
        return null;
    }

    public function save(){
        global $database;

        $sql = "UPDATE client SET firstname = :fname, middlename = :mname, lastname = :lname, gender = :gender, primarycontact = :primaryContact, billpayer = :bill, primaryphone = :primaryPhone, secondaryphone = :secondaryPhone, isactive = :active, relationship = :relation, stateassistance = :state, piclink = :link WHERE id = :id;";
        $sth = $database->prepare($sql);

        $params = array(':fname' => $this->firstName, ':mname' => $this->middleName, ':lname' => $this->lastName, ':gender' => $this->gender, ':primaryContact' => $this->isPrimaryContact, ':bill' => $this->isBillPayer, ':primaryPhone' => $this->primaryPhone, ':secondaryPhone' => $this->secondaryPhone, ':active' => $this->isActive, ':relation' => $this->relationship, ':state' => $this->hasStateAssistance, ':link' => $this->picLink, ':id' => $this->id );

        return $sth->execute($params);
    }

    public function getFullName(){
        return $this->firstName . ( isset($this->middleName) ? " " . $this->middleName : "") . " " . $this->lastname;
    }

    public static function find_one_id($id){
        global $database;

        $sql = "SELECT * FROM client WHERE id LIKE :id AND isActive = TRUE ;";
        $stmt = $database->prepare($sql);
        $stmt->execute(array(':id' => $id));

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $client = new Client($result["firstname"], $result["middlename"], $result["lastname"], $result["isactive"], $result["primarycontact"], $result["billpayer"], $result["stateassistance"], $result["primaryphone"], $result["secondaryphone"], $result["relationship"], $result["piclink"]);

        $id = $client->id;

        $client->alerts = Client::getAlerts($id);
        $client->incidents = Client::getIncidents($id);
        $client->comments = Client::getComments($id);
        $client->children = Client::getChildList($id);

        return $result;
    }

    public static function getAlerts($id){

    }

    public static function getIncidents($id){

    }

    public static function getComments($id){

    }

    public static function getChildList($id){

    }

    //Private functions
    private function add(){
        global $database;

        $sql = "INSERT INTO client VALUES(NULL, :gender, :link, :contact, :payer, :pPhone, :sPhone, :active, :relation, :state, :fname, :mname, :lname ); ";
        $sth = $database->prepare($sql);

        $params = array(':gender' => $this->gender, ':link' => $this->picLink, ':contact' => $this->isPrimaryContact, ':payer' => $this->isBillPayer, ':pPhone' => $this->primaryPhone, ':sPhone' => $this->secondaryPhone, ':active' => $this->isActive, ':relation' => $this->relationship, ':state' => $this->hasStateAssistance, ':fname' => $this->firstName, ':mname' => $this->middleName, ':lname' => $this->lastName);

        return $sth->execute($params);
    }
}