<?php
    require_once('config/config.php');
     
    //MySQL DSN
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
     
    //Using PDO here for more portability
    //Make sure DB is set-up before calling this method
    //If running from C9
    //$connection = new pdo('mysql:host=hostname;dbname=dbname',$username, $pass);
    
    class Database
    {
        private $connection;
        
        public function __construct(){
            $this->openConnection();
        }
        
        public function openConnection(){
            try{
                $this->connection = new pdo('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
                //echo "Success!";
            } catch (Exception $ex){
                die($ex->getMessage());
            }
        }
        
        /*
         * This method is for SELECT queries
         * Takes a SELECT query statment
         * Returns a PDOStatementObject
         */
        public function select($sql){
            try{
                return $this->connection->query($sql);
            } catch (Exception $ex){
                //$this->error = new Error($ex);
            }
        }
        
        /*
         * This method is for non-SELECT queries
         * Takes a non-SELECT query statment
         * Returns an integer of the rows affected
         */
        public function query($sql){
            try{
                //TODO: Validate if it is non-SELECT
                return $connection->exec($sql);
            } catch (Exception $ex){
                $this->error = "Query could not be executed.";
            }
        }
        
        /*
         * Preparing a SQL prepared statement
         *
         *
         *
         */
        public function prepare($sql){
            try{
                return $this->connection->prepare($sql);
            } catch (Exception $ex){
                echo $ex->getMessage();
            }
        }
        
    }
    
    $database = new Database();
?>