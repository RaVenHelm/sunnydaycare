<?php 
    try{
        require_once('dbconnect.php'); 
        $query = "SELECT * FROM users;";
    } catch (Exception $ex){
        $error = $ex->getMessage();
    }
?>
<!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
	</head>

	<body>
		<nav><h1>Welcome!</h1></nav>
		
		<?php 
		    if(isset($error)){
		        echo "<p>" . $error . "</p>";
		    }
		?>
		<table>
		    <tr>
                <th>User ID</th>
                <th>User Name</th>
		    </tr>
		    <?php foreach($connection->query($query) as $row){ ?>
		    <tr>
		        <td><?php echo $row['id']; ?></td>
		        <td><?php echo $row['username']; ?></td>
		    </tr>
		    <?php } ?>
		</table>
		
	</body>

</html>
