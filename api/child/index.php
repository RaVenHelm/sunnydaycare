<?php 
    include('../../server/static/get_all.php');
    if(isset($_GET['q'])){
        
    }
    
    $rates = get_all('RATE');
    
    print_r($rates);
?>