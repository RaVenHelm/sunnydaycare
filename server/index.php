<?php 
	//Place in API?
	//Convert into HTML, and use AJAX calls
    try{
        require_once('db/dbconnect.php'); 
        $query = "SELECT * FROM users ORDER BY id;";
		$result = $connection->query($query);
		
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
		    <?php while($row = $result->fetch()){ ?>
		    <tr>
		        <td><?php echo $row['id']; ?></td>
		        <td><?php echo $row['username']; ?></td>
		    </tr>
		    <?php } ?>
		</table>
		<input type="text" id="userAdd" placeholder="Add user name"/>
		<input type="submit" name="submit" id="submit" value="Submit"/>
		<div id="result"></div>
	</body>
	<script>
		$(document).ready(function(){
			$("#submit").click(function(){
				$.ajax({
					type: "POST",
					url: "add_user.php",
					data: "username=" + $("#userAdd").val(),
					success: function(data){
						$("#result").html(data);
						console.log(data);
					},
					error: function(error, textStatus){
						$("#result").html(textStatus + ": " + error);
						console.log("Error");
					}
				});
			});
		});
	</script>

</html>
