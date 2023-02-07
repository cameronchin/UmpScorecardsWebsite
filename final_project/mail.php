<?php
if(isset($_POST['submit'])){
    $destination = $_POST['email'];
    $subject = 'Email from Cameron';
    $message = '<h2>Hi!</h2>
                    Thank you for using my Umpire Scorecards website. More information about my website is coming soon. For more info about the original @UmpScorecards, feel free to visit their website at <a href="https://umpscorecards.com/">https://umpscorecards.com/</a>. Thanks!';
    $header = [
        "content-type" => "text/html",
        "from" => "ttrojan@usc.edu",
        "reply-to" => "no-reply@usc.edu"
    ];
}
if ( mail($destination, $subject, $message, $header) ) {
	echo 'Success! '. 'email sent to '. $_POST['email'];
} else {
	echo 'Error';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Umpire Scorecards Email Sent</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styling.css">

    <style>
        .btn {
            margin-left: 100px;
        }

        #p1 {
            margin-left: 100px;
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

    <h1><b>Success!</b></h1>

    <div id="Blurb">              
        <p id="p1">
            Email has been sent to <?php echo $_POST['email']?>
    </div>
	
    <div class="row mt-4 mb-4">
        <div class="col-12">
            <a href="index.php" role="button" class="btn btn-primary">Back to Homepage</a>
        </div> <!-- .col -->
	</div> <!-- .row -->
           

    <div id="footer">
        Cameron Chin © 2022
    </div>
</body>
</html>