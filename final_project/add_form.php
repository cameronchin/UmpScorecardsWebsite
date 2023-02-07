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
	
	// 2. Perform SQL Statements
	$sql_umpires = "SELECT * FROM umpires";
	$results_umpires = $mysqli->query($sql_umpires);

	$sql_teams = "SELECT * FROM teams";
	$results_away_teams = $mysqli->query($sql_teams);
    $results_home_teams = $mysqli->query($sql_teams);

	// check for sql errors
	if ($results_umpires == false) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	if ($results_away_teams == false) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	if ($results_home_teams == false) {
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
	<title>Add Form | UmpScorecards Database</title>
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
            <a href="search_form.php">Search Scorecards</a>
        </li> 
        <li>
            <a href="add_form.php">Add Scorecard</a>
        </li>
    </ul>  

    <h1><b>Add A Scorecard</b></h1>

	<div class="container">

		<form action="add_confirmation.php" method="POST">
            <div class="form-group row">
				<div class="ml-auto col-sm-10">
					<span class="text-danger font-italic">* Required</span>
				</div>
			</div> <!-- .form-group -->
            <div class="form-group row">
                <div class="col-sm-6 text-lg-right">
                    <a href="glossary.html"> Terms Glossary</a>
                    <br>
                </div>
            </div> <!-- .form-group -->

            <div class="form-group row">
				<label for="umpire-id" class="col-sm-3 col-form-label text-sm-right">Umpire: <span class="text-danger">*</span></label>
				<div class="col-sm-6">
					<select name="umpire_id" id="umpire-id" class="form-control">
						<option value="" selected disabled>-- Select One --</option>

						<?php while ($row = $results_umpires->fetch_assoc()) : ?>
							<option value="<?php echo $row['umpire_id'] ?>">
							<?php echo $row['umpire'] ?>
							</option>
						<?php endwhile; ?>

					</select>
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="game-date-id" class="col-sm-3 col-form-label text-sm-right">Game Date: <span class="text-danger">*</span></label>
				<div class="col-sm-6">
					<input type="date" class="form-control" id="game-date-id" name="game_date">
				</div>
			</div> <!-- .form-group -->

            <div class="form-group row">
                <label class="col-sm-3 col-form-label text-sm-right"></label>
				<div class="col-sm-3">
                <label for="away_team-id" class="col-form-label text-sm-right">Away Team: <span class="text-danger">*</span></label>
					<select name="away_team" id="away_team-id" class="form-control">
						<option value="" selected disabled>-- Select One --</option>

						<?php while ($row = $results_away_teams->fetch_assoc()) : ?>
							<option value="<?php echo $row['team_id'] ?>">
							<?php echo $row['team'] ?>
							</option>
						<?php endwhile; ?>
					</select>
				</div>
                <div class="col-sm-3">
                <label for="away_team-id" class="col-form-label text-sm-right">Home Team: <span class="text-danger">*</span></label>
					<select name="home_team" id="home_team-id" class="form-control">
						<option value="" selected disabled>-- Select One --</option>

						<?php while ($row = $results_home_teams->fetch_assoc()) : ?>
							<option value="<?php echo $row['team_id'] ?>">
							<?php echo $row['team'] ?>
							</option>
						<?php endwhile; ?>

					</select>
				</div>
			</div> <!-- .form-group -->

            <div class="form-group row">
                <label class="col-sm-3 col-form-label text-sm-right"></label>
				<div class="col-sm-3">
                <label for="away_team_runs-id" class="col-form-label text-sm-right">Away Team Runs:</label>
					<input type="number" min=0 class="form-control" id="away_team_runs-id" name="away_team_runs">
				</div>
            
				<div class="col-sm-3">
                <label for="home_team_runs-id" class="col-form-label text-sm-right">Home Team Runs:</label>
					<input type="number" min=0 class="form-control" id="home_team_runs-id" name="home_team_runs">
				</div>
			</div> <!-- .form-group -->


            <div class="form-group row">
                <label class="col-sm-3 col-form-label text-sm-right"></label>
				<div class="col-sm-2">
                    <label for="pitches_called-id" class="col-form-label text-sm-right">Pitches Called:</label>
					<input type="number" min=0 class="form-control" id="pitches_called-id" name="pitches_called">
				</div>
                <div class="col-sm-2">
                    <label for="correct_calls-id" class="col-form-label text-sm-right">Correct Calls:</label>            
					<input type="number" min=0 class="form-control" id="correct_calls-id" name="correct_calls">
				</div>
                <div class="col-sm-2">
                    <label for="incorrect_calls-id" class="col-form-label text-sm-right">Incorrect Calls:</label>
					<input type="number" min=0 class="form-control" id="incorrect_calls-id" name="incorrect_calls">
				</div>
			</div> <!-- .form-group -->

            <div class="form-group row">
                <label class="col-sm-3 col-form-label text-sm-right"></label>
				<div class="col-sm-3">
                    <label for="accuracy-id" class="col-form-label text-sm-right">Accuracy (%): <span class="text-danger">*</span></label>
					<input type="number" step="0.01" min=0 class="form-control" id="accuracy-id" name="accuracy">
				</div>
                <div class="col-sm-3">
                    <label for="consistency-id" class="col-form-label text-sm-right">Consistency (%):</label>
					<input type="number" step="0.01" min=0 class="form-control" id="consistency-id" name="consistency">
				</div>
			</div> <!-- .form-group -->

            <div class="form-group row">
                <label class="col-sm-3 col-form-label text-sm-right"></label>
				<div class="col-sm-3">
                    <label for="home_favor-id" class="col-form-label text-sm-right">Home Favor (Runs):</label>
					<input type="number" step="0.01" class="form-control" id="home_favor-id" name="home_favor">
				</div>
                <div class="col-sm-3">
                    <label for="total_impact-id" class="col-form-label text-sm-right">Total Run Impact (Runs):</label>
					<input type="number" step="0.01" min=0 class="form-control" id="total_impact-id" name="total_impact">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="reset" class="btn btn-light">Reset</button>
				</div>
			</div> <!-- .form-group -->
		</form>
            
	</div> <!-- .container -->

    <div id="footer">
        Cameron Chin © 2022
    </div>

</body>
</html>