<?php 

    function redirect_to( $location = null ){
        if( $location != null ){
            header("Location: {$location}");
            exit;
        }
    }
    
    function __autoload($class_name){
        $class_name = strtolower($class_name);
        $path = "objects/{$class_name}.php";
        if(file_exists($path)){
            require_once($path);
        } else {
            die("The file {$path} could not be found.");
        }
    }
?>