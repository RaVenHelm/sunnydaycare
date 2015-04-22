<?php
    //include('objects/Error.php');
    
    class database
    {
        private $connection;
        private $error;
        
        public function __construct(){
            try{
                include('dbconnect.php');
                $this->connection = $connection;
            } catch (Exception $ex){
                //$this->$error = new Error($ex);
            }
        }
        
        /*
         * This method is for SELECT queries
         * Takes a SELECT query statment
         * Returns a PDOStatementObject
         */
        public function select($sql){
            try{
                //TODO: Validate if it is SELECT
                return $this->connection->query($sql);
            } catch (Exception $ex){
                $this->error = new Error($ex);
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
                $this->error = new Error($ex);
            }
        }
        
    }
    
    $database = new database();
?>