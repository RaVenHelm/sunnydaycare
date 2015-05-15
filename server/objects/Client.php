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

    private $billingAddr;
    private $mailingAddr;

    private $alerts;
    private $comments;
    private $incidents;

    private $children;

    private $picLink;

    function __construct($f, $m, $l, $gender, $active, $primary, $payer, $state, $pPhone, $sPhone, $relation, $bAddr, $mAddr){
        $this->firstName = $f;
        $this->middleName = ($m == "" || $m == null) ? null : $m;
        $this->lastName = $l;
        $this->gender = $gender;
        $this->isActive = $active;
        $this->isPrimaryContact = $primary;
        $this->isBillPayer = $payer;
        $this->hasStateAssistance = $state;
        $this->primaryPhone = $pPhone;
        $this->secondaryPhone = ($sPhone == "" || $sPhone == null) ? null : $sPhone;
        $this->relationship = $relation;
        $this->billingAddr = $bAddr;
        $this->mailingAddr = $mAddr;
        $this->alerts = null;
        $this->comments = null;
        $this->incidents = null;
        $this->children = null;
        $this->picLink = null;

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

    public function to_array(){
        return array('firstname' => $this->firstName, 'middlename' => $this->middleName, 'lastname' => $this->lastName, 'gender' => $this->gender, 'primaryphone' => $this->primaryPhone, 'secondaryphone' => $this->secondaryPhone, 'primarycontact' => $this->isPrimaryContact, 'billpayer' => $this->isBillPayer);
    }

    public function getFullName(){
        return $this->firstName . ( isset($this->middleName) ? " " . $this->middleName : "") . " " . $this->lastName;
    }
    public function getAddr($isBilling)
    {
        if($isBilling){
            return $this->billingAddr;
        } else {
            return $this->mailingAddr;
        }
    }

    public static function find_one_id($id){
        global $database;

        $sql = "SELECT * FROM client WHERE id = :id AND isActive = TRUE ;";
        $stmt = $database->prepare($sql);
        $stmt->execute(array(':id' => $id));

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $client = new Client($result["firstname"], $result["middlename"], $result["lastname"], $result["gender"], $result["isactive"], $result["primarycontact"], $result["billpayer"], $result["stateassistance"], $result["primaryphone"], $result["secondaryphone"], $result["relationship"], $result["piclink"], null);

        $id = $client->id;
        $addresses = Client::getAddresses($id);

        $client->alerts = Client::getAlerts($id);
        $client->billingAddr = $addresses["billing"];
        $client->mailingAddr = $addresses["mailing"];
        $client->incidents = Client::getIncidents($id);
        $client->comments = Client::getComments($id);
        $client->children = Client::getChildList($id);

        return $client;
    }

    public static function search($firstname, $middlename, $lastname){
        global $database;

        $wcFirst = "%{$firstname}%";
        $wcMiddle = "%{$middlename}%";
        $wcLast = "%{$lastname}%";


        $sql = "SELECT id, firstname, middlename, lastname FROM client ";
        if(!isset($firstname) && !isset($middlename)){
            $sql .= "WHERE lastname LIKE :lname ORDER BY lastname;";
            $stmt = $database->prepare($sql);
            $stmt->execute(array(':lname' => $wcLast));
        } elseif(!isset($middlename)) {
            $sql .= "WHERE firstname LIKE :fname AND lastname LIKE :lname ORDER BY lastname;";
            $stmt = $database->prepare($sql);
            $stmt->execute(array(':fname' => $wcFirst, ':lname' => $wcLast));
        } elseif(!isset($lastname)) {
            $sql .= "WHERE firstname LIKE :fname AND middlename LIKE :mname ORDER BY lastname;";
            $stmt = $database->prepare($sql);
            $stmt->execute(array(':fname' => $wcFirst, ':mname' => $wcMiddle));
        } elseif(!isset($firstname)) {
            $sql .= "WHERE middlename LIKE :mname AND lastname LIKE :lname ORDER BY lastname;";
            $stmt = $database->prepare($sql);
            $stmt->execute(array(':mname' => $wcMiddle, ':lname' => $wcLast));
        } else {
            $sql .= "WHERE firstname LIKE :fname AND middlename LIKE :mname AND lastname LIKE :lname ORDER BY lastname;";
            $stmt = $database->prepare($sql);
            $stmt->execute(array(':fname' => $wcFirst, ':mname' => $wcMiddle, ':lname' => $wcLast));
        }
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getAddresses($id){
        global $database;

        $billing = "";
        $mailing = "";

        $sql = "SELECT type, address FROM address WHERE Client_id = :id";

        $sth = $database->prepare($sql);
        $sth->execute(array(':id' => $id));

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $addr){
            if($addr["type"] = "Billing"){
                $billing = $addr["address"];
            }
            if($addr["type"] = "Mailing"){
                $mailing = $addr["address"];
            }
        }

        return array('billing' => $billing, 'mailing' => $mailing);
    }

    public static function getAlerts($id){
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

    public static function getIncidents($id){
        global $database;

        $sql = "SELECT * FROM `client incident` WHERE Client_id = :id;";

        $sth = $database->prepare($sql);
        if($sth->execute(array(':id' => $id))){
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }

    public static function getComments($id){

    }

    public static function getChildList($id){

    }


    public function add(){
        global $database;

        $sql = "INSERT INTO client VALUES(NULL, :gender, :link, :contact, :payer, :pPhone, :sPhone, :active, :relation, :state, :fname, :mname, :lname ); ";
        $sth = $database->prepare($sql);

        $params = array(':gender' => $this->gender, ':link' => $this->picLink, ':contact' => $this->isPrimaryContact, ':payer' => $this->isBillPayer, ':pPhone' => $this->primaryPhone, ':sPhone' => $this->secondaryPhone, ':active' => $this->isActive, ':relation' => $this->relationship, ':state' => $this->hasStateAssistance, ':fname' => $this->firstName, ':mname' => $this->middleName, ':lname' => $this->lastName);

        if(!$sth->execute($params)) {
            return false;
        }



        $sql = "SELECT id from client WHERE firstname = :fname AND middlename = :mname AND lastname = :lname;";
        $sth = $database->prepare($sql);
        $params = array(':fname' => $this->firstName, ':mname' => $this->middleName, ':lname' => $this->lastName);

        if (!$sth->execute($params)) {
            return false;
        }

        $id = $sth->fetch(PDO::FETCH_ASSOC);
        
        $this->id = $id["id"];


        $this->insertAddress(true);
        $this->insertAddress(false);        

        return $this;
    }

    private function insertAddress($isBilling) {
        global $database;

        $sql = "INSERT INTO address VALUES(NULL, :type, :address, :id);";

        $sth = $database->prepare($sql);

        if ($isBilling) {
            $params = array(':type' => 'Billing', ':address' => $this->billingAddr, ':id' => $this->id);
        } else {
            $params = array(':type' => 'Mailling', ':address' => $this->mailingAddr, ':id' => $this->id);
        }

        return $sth->execute($params);
    }
}