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

	// sql aggregate functions

	$sql_umpires_count = "SELECT COUNT(umpire)
                          FROM umpires";
	$results_umpires_count = $mysqli->query($sql_umpires_count);
   
	$sql_scorecards_count = "SELECT COUNT(scorecard_id) 
                             FROM scorecards";
    $results_scorecards_count = $mysqli->query($sql_scorecards_count);

    $sql_earliest_date = "SELECT MIN(scorecards.date) 
                             FROM scorecards";
    $results_earliest_date = $mysqli->query($sql_earliest_date);

    $sql_latest_date = "SELECT MAX(scorecards.date) 
                             FROM scorecards";
    $results_latest_date = $mysqli->query($sql_latest_date);

    

	// check for sql errors
	if ($results_umpires_count == false) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

    if ($results_scorecards_count == false) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

    if ($results_earliest_date == false) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

    if ($results_latest_date == false) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}
	$mysqli->close();    
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            Cameron Chin | Final Project
        </title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
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

        <div id="main" class="container">
            <div class="row">
                <div id="content" class="col-12 col-lg-8">
                    <div id="Overview">
                        <h2><b>Overview</b></h2>
                        <p id="p1">
                            Umpire Scorecards are a data-driven method of evaluating the performance of home-plate umpires in Major League Baseball.
                        </p>
                            <p id="p2">
                            All credit for this website idea goes to Ethan Singer, owner and operator of the <a href="https://twitter.com/UmpScorecards"> @UmpScorecards</a> Twitter account, and Ethan Schwartz, chief advisor. Their work has been discussed extensively by baseball fans and content creators, as evidenced by their >300k followers.
                        </p>
                        <br>
                    </div>
    
                    <div id="About-The-Data">
                        <h2><b>About the Data</b></h2>
                        <p id="p3">
                            The dataset for this project was found on <a href="https://www.kaggle.com/datasets/mattop/mlb-baseball-umpire-scorecards-2015-2022"> Kaggle</a>; it is titled "MLB Baseball Umpire Scorecards (2015 - 2022)" and was created by user Matt OP. According to the description, this dataset was pulled and cleaned up from <a href="https://umpscorecards.com"> umpscorecards.com</a>.
                        </p>
                        <p id="p4">
                            Because the dataset was quite large, I reduced the number of records and columns. The cleaned-up dataset consists of a sample of <b><?php while($row = mysqli_fetch_array($results_scorecards_count)) { echo $row['COUNT(scorecard_id)']; }?></b> MLB games played between <b><?php while($row = mysqli_fetch_array($results_earliest_date)) { echo $row['MIN(scorecards.date)']; }?></b> and <b><?php while($row = mysqli_fetch_array($results_latest_date)) { echo $row['MAX(scorecards.date)']; }?></b>. There were <b><?php while($row = mysqli_fetch_array($results_umpires_count)) { echo $row['COUNT(umpire)']; }?></b> different home-plate umpires during that timespan.
                        </p>
                        <p id="p5">
                            The database consists of 3 tables: scorecards, umpires, and teams; the latter two were created when normalizing the database. The data in the scorecards table largely reflect the data shown in the game visualizations on @UmpScorecards; an example can be seen <a href="https://twitter.com/UmpScorecards/status/1589281551727984645"> here</a>.
                        </p>
                        <p id="p5">
                            The database diagram is shown below:
                        </p>
                        
                        <img src="img/umpscorecard_model_pic.png" alt="database model" id="database_model">
                        <br>
                    </div>
                    
                    <div id="How-to-Use-This-Site">
                        <h2><b>How to Use This Site</b></h2>
                        <p id="p5">
                            You can search the dataset using the <b>"Search Scorecards"</b> tab. After searching, you will be taken to a results table, where you will be able to <b>edit</b> or <b>delete</b> certain records using the buttons on the rightmost column of the table. Lastly, you can add scorecards using the <b>"Add Scorecard"</b> tab. As of now, only umpires already listed in the database can be added to a new scorecard.
                        </p>
                        <p id="p6">
                            To view a glossary of the terms used in the scorecards table, click <a href="glossary.html"> here</a> or click the <b>Search</b> or <b>Add</b> tabs.
                        </p>
                        <hr>
                    </div>
                    <div id="Email-Blurb">
                        <p id="p7">Feel free to enter your email below to receive more information about this website:</p>
                    </div>
                </div>  
            </div>
        </div>
        <form action="mail.php" method="POST">
            <div class="form-group row">
                <label class="col-sm-1 col-form-label text-sm-right"></label>
                <div class="col-sm-5">
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="email" class="col-sm-3 col-form-label text-sm-right">Email:</label>
                            <input type="text" name="email">
                        </div> <!-- .col -->
                        <div class="col-sm-6">
                            <input type="submit" name="submit" value="Submit">
                        </div> <!-- .col -->
                    </div> <!-- .row -->
                </div>
            </div> <!-- .form-group -->
        </form>
        <div id="main" class="container">
            <div class="row">
                <div id="content" class="col-12 col-lg-8">
                    <div id="File-Blurb">
                        <p id="p7">
                            <br>
                            If you want to upload your own UmpScorecards dataset (only .csv supported), you can do so below: 
                        </p>
                    </div>
                </div>  
            </div>
        </div>

        <form id="upload-form" action="file_upload/file_confirmation.php" method="POST" enctype="multipart/form-data">
			<div class="form-group row">
                <label class="col-sm-1 col-form-label text-sm-right"></label>
                <div class="col-sm-5">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="file" accept=".csv" id="file-id" name="file_name">
                        </div> <!-- .col -->
                        <div class="col-sm-5">
                            <input type="submit" name="submit" value="Upload">
                            <input type="reset" name="reset" value="Reset">
                        </div> <!-- .col -->
                    </div> <!-- .row -->
                </div>
			</div> <!-- .form-group -->
		</form>
        <br>
    <div id="footer">
        Cameron Chin © 2022
    </div>

    </body>
</html>