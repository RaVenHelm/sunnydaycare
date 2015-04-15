<?php 
    include('../../server/static/get_all.php');
    if(isset($_GET['q'])){
        
    }
    
    $rates = get_all('RATE');
    ?>
    <pre><?php print_r($rates[0]["rate"]); ?></pre>
