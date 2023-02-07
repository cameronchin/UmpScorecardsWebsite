<?php
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
	
	//perform search
	$sql = "SELECT scorecards.scorecard_id, scorecards.date, away_team_alias.team AS away, home_team_alias.team AS home, scorecards.home_team_runs, scorecards.away_team_runs, scorecards.pitches_called, scorecards.incorrect_calls, scorecards.correct_calls, scorecards.accuracy, scorecards.consistency, scorecards.favor_home, scorecards.total_run_impact, umpires.umpire
			FROM scorecards
				LEFT JOIN umpires 
					ON scorecards.umpire_id = umpires.umpire_id
				LEFT JOIN teams AS away_team_alias
					ON scorecards.away_team_id = away_team_alias.team_id
                LEFT JOIN teams AS home_team_alias
					ON scorecards.home_team_id = home_team_alias.team_id
			WHERE 1 = 1";

	if (isset($_GET['umpire_id']) && !empty($_GET['umpire_id'])) {
		$umpire_id = $_GET['umpire_id'];
		$sql = $sql . " AND umpires.umpire_id LIKE '$umpire_id'";
	}

	if (isset($_GET['away_team']) && !empty($_GET['away_team'])) {
		$away_team_id = $_GET['away_team'];
		$sql = $sql . " AND away_team_alias.team_id LIKE '$away_team_id'";
        echo $away_team_id;
	}

	if (isset($_GET['home_team']) && !empty($_GET['home_team'])) {
		$away_team_id = $_GET['home_team'];
		$sql = $sql . " AND home_team_alias.team_id LIKE '$away_team_id'";
	}
	if (isset($_GET['game_date_from']) && !empty($_GET['game_date_from']) && isset($_GET['game_date_to']) && !empty($_GET['game_date_to'])) {
		$game_date_from = $_GET['game_date_from'];
		$game_date_to = $_GET['game_date_to'];
		$sql = $sql . " AND scorecards.date BETWEEN '$game_date_from' AND '$game_date_to'";
	}

	if (isset($_GET['min_accuracy']) && !empty($_GET['min_accuracy'])) {
		$min_accuracy = $_GET['min_accuracy'];
		$sql = $sql . " AND scorecards.accuracy >= $min_accuracy";
	}

    if (isset($_GET['max_accuracy']) && !empty($_GET['max_accuracy'])) {
		$max_accuracy = $_GET['max_accuracy'];
		$sql = $sql . " AND scorecards.accuracy <= $max_accuracy";
	}

    if (isset($_GET['min_consistency']) && !empty($_GET['min_consistency'])) {
		$min_consistency = $_GET['min_consistency'];
		$sql = $sql . " AND scorecards.consistency >= $min_consistency";
	}

    if (isset($_GET['max_consistency']) && !empty($_GET['max_consistency'])) {
		$max_consistency = $_GET['max_consistency'];
		$sql = $sql . " AND scorecards.consistency <= $max_consistency";
	}

    if (isset($_GET['min_home_favor']) && !empty($_GET['min_home_favor'])) {
		$min_home_favor = $_GET['min_home_favor'];
        $sql = $sql . " AND scorecards.favor_home >= $min_home_favor";
	}

    if (isset($_GET['max_home_favor']) && !empty($_GET['max_home_favor'])) {
		$max_home_favor = $_GET['max_home_favor'];
        $sql = $sql . " AND scorecards.favor_home <= $max_home_favor";
	}

    if (isset($_GET['min_impact']) && !empty($_GET['min_impact'])) {
		$min_impact = $_GET['min_impact'];
		$sql = $sql . " AND scorecards.total_run_impact >= $min_impact";
	}

    if (isset($_GET['max_impact']) && !empty($_GET['max_impact'])) {
		$max_impact = $_GET['max_impact'];
		$sql = $sql . " AND scorecards.total_run_impact <= $max_impact";
	}

	$sql = $sql . ';';

	$results = $mysqli->query($sql);

	if ($results == false) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	//close connection
	$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>UmpScorecards Search Results</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styling.css">    
</head>
<style>
    tr:nth-child(1) { 
        border-top: 1px solid black; 
    }

    tr:nth-child(even) {
        background-color: #ECECEC;
    }
</style>    
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

	<h1>Umpire Scorecard Results</h1>
	
	<div class="container">
        <div class="row mb-4">
                <div class="col-12 mt-4">
                    <a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
                </div> <!-- .col -->
        </div> <!-- .row -->

		<div class="row">
			<div class="col-12">
				Showing <?php echo $results->num_rows; ?> result(s).
			</div> <!-- .col -->
			<div class="col-14">
				<table class="w3-table table-responsive mt-3">
                    <colgroup span="2"></colgroup>
                    <thead>
						<tr>
							<th>Umpire</th>
							<th>Game Date</th>
							<th>Away Team</th>
							<th>Home Team</th>
                            <th>Runs (Away)</th>
							<th>Runs (Home)</th>
                            <th>Pitches Called</th>
                            <th>Correct Calls</th>
                            <th>Incorrect Calls</th>
                            <th>Accuracy (%)</th>
                            <th>Consistency (%)</th>
                            <th>Home Favored (Runs)</th>
                            <th>Total Run Impact (Runs)</th>
                            <th colspan="2" scope="colgroup">Actions</th>
						</tr>
                        <tr>
                            <!-- <hr class="line"> -->
                        </tr>
					</thead>
                    
					<tbody>
						<?php while ($row = $results->fetch_assoc()) : ?>
							<tr>
								<td>
									<?php echo $row['umpire'] ?>
								</td>
								<td>
									<?php echo $row['date'] ?>
								</td>
								<td>
									<?php echo $row['away'] ?>
								</td>	
                                <td>
									<?php echo $row['home'] ?>
								</td>
                                <td>
									<?php echo $row['away_team_runs'] ?>
								</td>
                                <td>
									<?php echo $row['home_team_runs'] ?>
								</td>
                                <td>
									<?php echo $row['pitches_called'] ?>
								</td>	
                                <td>
									<?php echo $row['correct_calls'] ?>
								</td>	
                                <td>
									<?php echo $row['incorrect_calls'] ?>
								</td>	
                                <td>
									<?php echo $row['accuracy'] ?>
								</td>	
                                <td>
									<?php echo $row['consistency'] ?>
								</td>	
                                <td>
									<?php echo $row['favor_home'] ?>
								</td>	
                                <td>
									<?php echo $row['total_run_impact'] ?>
								</td>	
                                <!-- delete + edit button -->
								<td>
                                    <a href="edit_form.php?scorecard_id=<?php echo $row['scorecard_id'];?>" class="btn btn-sm btn-outline-dark">Edit </a>
								</td>
                                <td>
                                    <a href="delete.php?scorecard_id=<?php echo $row['scorecard_id'];?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this record?')">Delete </a>
								</td>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->

    <div id="footer">
        Cameron Chin © 2022
    </div>

</body>
</html>