<?php
	//1 Define credentials
	$host = "303.itpwebdev.com";
	$user = "camerokc_db_user";
	$pass = "uscitp2022";
	$db = "camerokc_umpscorecards_db";

	//Establishing MySQL Connection
	$mysqli = new mysqli($host, $user, $pass, $db);

	// Check for MySQL Connection Errors
	if ($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

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
	<title>Umpire Scorecards Search Form</title>
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

    <h1><b>Search Scorecards</b></h1>

	<div class="container">
        <form action="search_results.php" method="GET">
        <div class="form-group row">
            <div class="col-sm-6 text-lg-right">
                <a href="glossary.html">Terms Glossary</a>
            </div>
        </div> <!-- .form-group -->
        <div class="form-group row">
            <label for="umpire-id" class="col-sm-3 col-form-label text-sm-right">Umpire: </label>
            <div class="col-sm-6">
                <select name="umpire_id" id="umpire-id" class="form-control">
                    <option value="" selected>-- All --</option>
                    <?php while ($row = $results_umpires->fetch_assoc()) : ?>
                        <option value="<?php echo $row['umpire_id'] ?>">
                        <?php echo $row['umpire'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div> <!-- .form-group -->
            <div class="form-group row">
                <label class="col-sm-3 col-form-label text-sm-right">Game Date:</label>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="form-check-label my-1">From: </label>
                            <input type="date" class="form-control" name="game_date_from">  
                        </div> <!-- .col -->
                        <div class="col-sm-6">
                            <label class="form-check-label my-1">To: </label>
                            <input type="date" class="form-control" name="game_date_to">
                        </div> <!-- .col -->
                    </div> <!-- .row -->
                </div> <!-- .col -->
            </div> <!-- .form-group -->
            <div class="form-group row">

            <label class="col-sm-3 col-form-label text-sm-right"></label>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col">
                        <label for="away_team-id" class="col-form-label text-sm-right">Away Team:</label>
                            <select name="away_team" id="away_team-id" class="form-control">
                                <option value="" selected>-- All --</option>

                                <?php while ($row = $results_away_teams->fetch_assoc()) : ?>
                                    <option value="<?php echo $row['team_id'] ?>">
                                    <?php echo $row['team'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                    </div>
                    <div class="col">
                        <label for="home_team-id" class="col-form-label text-sm-right">Home Team:</label>
                            <select name="home_team" id="home_team-id" class="form-control">
                                <option value="" selected>-- All --</option>
                                
                                <?php while ($row = $results_home_teams->fetch_assoc()) : ?>
                                    <option value="<?php echo $row['team_id'] ?>">
                                    <?php echo $row['team'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                    </div>
                </div>
            </div>
        </div> <!-- .form-group -->

            <div class="form-group row">
                <label for="min-accuracy-id" class="col-sm-3 col-form-label text-sm-right">Accuracy (%):</label>
                <div class="col-sm-6">
                <div class="row">
                        <div class="col-sm-6">
                            <label class="form-check-label my-1">Min: </label>
                            <input type="number" step="0.01" min=0 class="form-control" id="min-accuracy" name="min_accuracy">
                        </div> <!-- .col -->
                        <div class="col-sm-6">
                            <label class="form-check-label my-1">Max: </label>
                            <input type="number" step="0.01" min=0 class="form-control" id="max-accuracy" name="max_accuracy">
                        </div> <!-- .col -->
                    </div> <!-- .row -->
                </div>
            </div> <!-- .form-group -->
                                
            <div class="form-group row">
                <label for="min-consistency-id" class="col-sm-3 col-form-label text-sm-right">Consistency (%):</label>
                <div class="col-sm-6">
                <div class="row">
                        <div class="col-sm-6">
                            <label class="form-check-label my-1">Min: </label>
                            <input type="number" step="0.01" min=0 class="form-control" id="min-consistency" name="min-consistency">
                        </div> <!-- .col -->
                        <div class="col-sm-6">
                            <label class="form-check-label my-1">Max: </label>
                            <input type="number" step="0.01" min=0 class="form-control" id="max-consistency" name="max_consistency">         
                        </div> <!-- .col -->
                    </div> <!-- .row -->
                </div>
            </div> <!-- .form-group -->
            <div class="form-group row">
                <label for="min-home_favor-id" class="col-sm-3 col-form-label text-sm-right">Home Favor (# Runs):</label>
                <div class="col-sm-6">
                <div class="row">
                        <div class="col-sm-6">
                            <label class="form-check-label my-1">Min: </label>
                            <input type="number" step="0.01" class="form-control" id="min-home_favor" name="min_home_favor">
                        </div> <!-- .col -->
                        <div class="col-sm-6">
                            <label class="form-check-label my-1">Max: </label>
                            <input type="number" step="0.01" class="form-control" id="max-home_favor" name="max_home_favor">         
                        </div> <!-- .col -->
                    </div> <!-- .row -->
                </div>
            </div> <!-- .form-group -->
            <div class="form-group row">
                <label for="min-impact-id" class="col-sm-3 col-form-label text-sm-right">Total Run Impact (# Runs):</label>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="form-check-label my-1">Min: </label>
                             <input type="number" step="0.01" min=0 class="form-control" id="min-impact" name="min_impact">
                        </div> <!-- .col -->
                        <div class="col-sm-6">
                            <label class="form-check-label my-1">Max: </label>
                            <input type="number" step="0.01" min=0 class="form-control" id="max-impact" name="max_impact">
                        </div> <!-- .col -->
                    </div> <!-- .row -->
                </div>
            </div> <!-- .form-group -->

            <div class="form-group row">
                <div class="col-sm-3"></div>
                <div class="col-sm-9 mt-3">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                </div>
            </div> <!-- .form-group -->
		</form>
	</div> <!-- .container -->

    <div id="footer">
        Cameron Chin © 2022
    </div>
</body>
</html>