<?php 
	if (empty($_FILES['file_name'])) {
		$error = "Missing file.";
	} else if ($_FILES['file_name']['error'] > 0) {
		$error = "File upload error # " . $_FILES['file_name']['error'];
	} else {
		$source = $_FILES['file_name']['tmp_name'];

		$file = $_FILES['file_name']['name'];
		$destination = 'final_project' . $file;
		//$destination = preg_replace('/\s/', '_', $destination );
        
		move_uploaded_file($source, $destination);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Umpire Scorecards File Upload</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styling.css">

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

	<div id = "Blurb">
		<?php if ( !empty($error) ) : ?>
			<p class="text-danger">
				<?php echo $error; ?>
			</p>

		<?php else : ?>
			<p id="p1">
				Your file was successfully uploaded <a href="<?php echo $destination ?>" target="_blank">here</a>. The ability to use your own database on this website is coming soon, stay tuned!
			</p>
		<?php endif; ?>
	</div>
	
    <div class="row mt-4 mb-4">
        <div class="col-12">
            <a href="../index.php" role="button" class="btn btn-primary">Back to Homepage</a>
        </div> <!-- .col -->
	</div> <!-- .row -->

    <div id="footer">
        Cameron Chin © 2022
    </div>

</body>
</html>