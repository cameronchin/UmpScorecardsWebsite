<?php
	// Check to see if any required fields are missing.

	if ( !isset($_POST['umpire_id']) || trim($_POST['umpire_id']) == ''
    || !isset($_POST['game_date']) || trim($_POST['game_date']) == ''
    || !isset($_POST['away_team']) || trim($_POST['away_team']) == ''
    || !isset($_POST['home_team']) || trim($_POST['home_team']) == ''
    || !isset($_POST['accuracy']) || trim($_POST['accuracy']) == '' ){
		// One or more of the required fields is empty.
		$error = "Please fill out all required fields.";
	} else {
		// All required fields provided. Continue with the ADD workflow.

	$host = "303.itpwebdev.com";
	$user = "camerokc_db_user";
	$pass = "uscitp2022";
	$db = "camerokc_umpscorecards_db";

		// DB Connection.
		$mysqli = new mysqli($host, $user, $pass, $db);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}
		$umpire_id = $_POST['umpire_id'];
		$game_date = $_POST['game_date'];
		$away_team_id = $_POST['away_team'];
		$home_team_id = $_POST['home_team'];
		$away_team_runs = $_POST['away_team_runs'];
		$home_team_runs = $_POST['home_team_runs'];
		$pitches_called = $_POST['pitches_called'];
        $correct_calls = $_POST['correct_calls'];
        $incorrect_calls = $_POST['incorrect_calls'];
        $accuracy = $_POST['accuracy'];
        $consistency = $_POST['consistency'];
        $home_favor = $_POST['home_favor'];
        $total_impact = $_POST['total_impact'];

		if ( isset($_POST['away_team_runs']) && trim($_POST['away_team_runs']) != '' ) {
			$away_team_runs = $_POST['away_team_runs'];
		} else {
			$away_team_runs = "0";
		}

		if ( isset($_POST['home_team_runs']) && trim($_POST['home_team_runs']) != '' ) {
			$home_team_runs = $_POST['home_team_runs'];
		} else {
			$home_team_runs = "0";
		}

		if ( isset($_POST['pitches_called']) && trim($_POST['pitches_called']) != '' ) {
			$pitches_called = $_POST['pitches_called'];
		} else {
			$pitches_called = "0";
		}

		if ( isset($_POST['correct_calls']) && trim($_POST['correct_calls']) != '' ) {
			$correct_calls = $_POST['correct_calls'];
		} else {
			$correct_calls = "0";
		}

		if ( isset($_POST['incorrect_calls']) && trim($_POST['incorrect_calls']) != '' ) {
			$incorrect_calls = $_POST['incorrect_calls'];
		} else {
			$incorrect_calls = "0";
		}
		
		if ( isset($_POST['consistency']) && trim($_POST['consistency']) != '' ) {
			$consistency = $_POST['consistency'];
		} else {
			$consistency = "0";
		}

        if ( isset($_POST['home_favor']) && trim($_POST['home_favor']) != '' ) {
			$home_favor = $_POST['home_favor'];
		} else {
			$home_favor = "0";
		}

        if ( isset($_POST['total_impact']) && trim($_POST['total_impact']) != '' ) {
			$total_impact = $_POST['total_impact'];
		} else {
			$total_impact = "0";
		}

		$sql = "INSERT INTO scorecards (umpire_id, scorecards.date, away_team_id, home_team_id, away_team_runs, home_team_runs, pitches_called, correct_calls, incorrect_calls, accuracy, consistency, favor_home, total_run_impact)
						        VALUES ($umpire_id, '$game_date', $away_team_id, $home_team_id, '$away_team_runs', '$home_team_runs', '$pitches_called', '$correct_calls', '$incorrect_calls', '$accuracy', '$consistency', '$home_favor', '$total_impact');";


		$results = $mysqli->query($sql);
        echo $sql;
		if (!$results) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}
        echo $game_date;
		$mysqli->close();

	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add Confirmation | UmpScorecards Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styling.css">    
    <style>
        .btn {
            font-size: 14px;
            margin-left: 15px;
        }
    </style>


</head>
<body>
	
    <div id="header">
    </div>
    
    <ul id="navbar">
        <li>
            <a href="index.php">Home</a>
        </li>
        <li>
            <a href="search_form.php">Search Scorecards</a>
        </li> 
        <li>
            <a href="add_form.php">Add Scorecard</a>
        </li>
    </ul>  

    <h1><b>Add A Scorecard</b></h1>

	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

				<?php if (isset($error) && !empty($error)) : ?>
				<div class="text-danger font-italic">
					<?php echo $error; ?>
				</div>
				<?php else : ?>
					<div class="text-success"> Game was successfully added.</div>
				<?php endif; ?>

			</div> <!-- .col -->

        <div class="row mt-3 mb-4">
		    <div class="col-6">
				<a href="add_form.php" role="button" class="btn btn-primary">Add Another Scorecard</a>
			</div> <!-- .col -->
		</div> <!-- .row -->

		<div class="row mt-3 mb-4">
			<div class="col-6">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Search Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
        
	</div> <!-- .container -->

    <div id="footer">
        Cameron Chin © 2022
    </div>

</body>
</html>