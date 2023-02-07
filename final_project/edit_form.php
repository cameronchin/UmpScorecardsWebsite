<?php
if (!isset($_GET['scorecard_id']) || empty($_GET['scorecard_id'])) {
	echo "Invalid URL";
	exit();
} 
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

// retrieve scorecard info:
$scorecard_id = $_GET['scorecard_id'];

$sql_scorecard = "SELECT *
			FROM scorecards
			WHERE scorecard_id = $scorecard_id;";

$result_scorecard = $mysqli->query($sql_scorecard);

if ( $result_scorecard == false ) {
	echo $mysqli->error;
	$mysqli->close();
	exit();
}

$row_scorecard = $result_scorecard->fetch_assoc();

//close connection
$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Form | UmpScorecards Database</title>
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

    <h1 class="col-12 mt-4 mb-4">Edit a Scorecard</h1>

	<div class="container">

				<?php if (isset($error) && !empty($error)) : ?>
				<div class="text-danger font-italic">
					<?php echo $error; ?>
				</div>
				<?php endif; ?>

			<form action="edit_confirmation.php" method="POST">

				<input type="hidden" name="scorecard_id" value="<?php echo $scorecard_id; ?>">

                <div class="form-group row">
                    <label for="umpire-id" class="col-sm-3 col-form-label text-sm-right">Umpire: <span class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <select name="umpire_id" id="umpire-id" class="form-control">
                            <option value="" selected>-- Select One --</option>

                            <?php while( $row = $results_umpires->fetch_assoc() ): ?>

                                <?php if ($row['umpire_id'] == $row_scorecard['umpire_id']) : ?>

                                    <option value="<?php echo $row['umpire_id']; ?>" selected>
                                        <?php echo $row['umpire']; ?>
                                    </option>

                                <?php else : ?>

                                    <option value="<?php echo $row['umpire_id']; ?>">
                                        <?php echo $row['umpire']; ?>
                                    </option>
                                <?php endif; ?>

                            <?php endwhile; ?>

                        </select>
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group row">
                    <label for="game-date-id" class="col-sm-3 col-form-label text-sm-right">Game Date: <span class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="game-date-id" name="game_date" value="<?php echo $row_scorecard['date']?>">
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-sm-right"></label>
                    <div class="col-sm-3">
                    <label for="away_team-id" class="col-form-label text-sm-right">Away Team: <span class="text-danger">*</span></label>
                        <select name="away_team_id" id="away_team-id" class="form-control">
                            <option value="" selected>-- Select One --</option>
                            <?php while( $row = $results_away_teams->fetch_assoc() ): ?>

                                <?php if ($row['team_id'] == $row_scorecard['away_team_id']) : ?>

                                    <option value="<?php echo $row['team_id']; ?>" selected>
                                        <?php echo $row['team']; ?>
                                    </option>

                                <?php else : ?>

                                    <option value="<?php echo $row['team_id']; ?>">
                                        <?php echo $row['team']; ?>
                                    </option>
                                <?php endif; ?>

                            <?php endwhile; ?>

                        </select>
                    </div>
                    <div class="col-sm-3">
                    <label for="home_team-id" class="col-form-label text-sm-right">Home Team: <span class="text-danger">*</span></label>
                        <select name="home_team_id" id="home_team-id" class="form-control">
                            <option value="" selected>-- Select One --</option>

                            <?php while( $row = $results_home_teams->fetch_assoc() ): ?>

                                <?php if ($row['team_id'] == $row_scorecard['home_team_id']) : ?>
                                    <option value="<?php echo $row['team_id']; ?>" selected>
                                        <?php echo $row['team']; ?>
                                    </option>

                                <?php else : ?>

                                    <option value="<?php echo $row['team_id']; ?>">
                                        <?php echo $row['team']; ?>
                                    </option>
                                <?php endif; ?>

                            <?php endwhile; ?>

                        </select>
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-sm-right"></label>
                    <div class="col-sm-3">
                    <label for="away_team_runs-id" class="col-form-label text-sm-right">Away Team Runs:</label>
                        <input type="number" class="form-control" id="away_team_runs-id" name="away_team_runs" value="<?php echo $row_scorecard['away_team_runs']?>">
                    </div>
                
                    <div class="col-sm-3">
                    <label for="home_team_runs-id" class="col-form-label text-sm-right">Home Team Runs:</label>
                        <input type="number" class="form-control" id="home_team_runs-id" name="home_team_runs" value="<?php echo $row_scorecard['home_team_runs']?>">
                    </div>
                </div> <!-- .form-group -->


                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-sm-right"></label>
                    <div class="col-sm-2">
                        <label for="pitches_called-id" class="col-form-label text-sm-right">Pitches Called:</label>
                        <input type="number" class="form-control" id="pitches_called-id" name="pitches_called" value="<?php echo $row_scorecard['pitches_called']?>">
                    </div>
                    <div class="col-sm-2">
                        <label for="correct_calls-id" class="col-form-label text-sm-right">Correct Calls:</label>            
                        <input type="number" class="form-control" id="correct_calls-id" name="correct_calls" value="<?php echo $row_scorecard['correct_calls']?>">
                    </div>
                    <div class="col-sm-2">
                        <label for="incorrect_calls-id" class="col-form-label text-sm-right">Incorrect Calls:</label>
                        <input type="number" class="form-control" id="incorrect_calls-id" name="incorrect_calls" value="<?php echo $row_scorecard['incorrect_calls']?>">
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-sm-right"></label>
                    <div class="col-sm-3">
                        <label for="accuracy-id" class="col-form-label text-sm-right">Accuracy (%): <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="accuracy-id" name="accuracy" value="<?php echo $row_scorecard['accuracy']?>">
                    </div>
                    <div class="col-sm-3">
                        <label for="consistency-id" class="col-form-label text-sm-right">Consistency (%):</label>
                        <input type="number" class="form-control" id="consistency-id" name="consistency" value="<?php echo $row_scorecard['consistency']?>">
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-sm-right"></label>
                    <div class="col-sm-3">
                        <label for="home_favor-id" class="col-form-label text-sm-right">Home Favor (Runs):</label>
                        <input type="number" class="form-control" id="home_favor-id" name="home_favor" value="<?php echo $row_scorecard['favor_home']?>">
                    </div>
                    <div class="col-sm-3">
                        <label for="total_impact-id" class="col-form-label text-sm-right">Total Run Impact (Runs):</label>
                        <input type="number" class="form-control" id="total_impact-id" name="total_impact" value="<?php echo $row_scorecard['total_run_impact']?>">
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