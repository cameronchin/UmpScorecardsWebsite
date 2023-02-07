<?php
//make sure scorecard is valid
	if (!isset($_GET['scorecard_id']) || trim($_GET['scorecard_id']) == '') {
		//if not, show error
		$error = "Invalid URL";
	} else {

	//1 Define credentials
	$host = "303.itpwebdev.com";
	$user = "camerokc_db_user";
	$pass = "uscitp2022";
	$db = "camerokc_umpscorecards_db";
	
	//Establishing MySQL Connection
	$mysqli = new mysqli($host, $user, $pass, $db);

	//Check for MySQL Connection Errors
	if ($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	$mysqli->set_charset('utf8');
	
	//perform delete
	$scorecard_id = $_GET['scorecard_id'];

	$sql = "DELETE FROM scorecards
			WHERE scorecard_id = $scorecard_id;";

	$results = $mysqli->query($sql);

	if ($results == false) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	//close connection
	$mysqli->close();
}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Delete a Scorecard | UmpScorecards Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styling.css">    
</head>
<body>

    <div id="header">
    </div>
    
    <ul id="navbar">
        <li>
            <a href="index.php">Home</a>
        </li>
        <li>
            <a href="search_form.php">Search Database</a>
        </li> 
        <li>
            <a href="add_form.php">Add to Database</a>
        </li>
    </ul>  

    <h1>Delete a Scorecard</h1>
	
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

			<?php if (isset($error) && !empty($error)) : ?>
				<div class="text-danger font-italic">
					<?php echo $error; ?>
				</div>
				<?php else : ?>
					<div class="text-success"><span class="font-italic"> Scorecard <?php echo $_GET['scorecard_id']; ?> </span> was successfully deleted.</div>
				<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_results.php" role="button" class="btn btn-primary">Back to Search Results</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
    <div id="footer">
        Cameron Chin © 2022
    </div>
</body>
</html>