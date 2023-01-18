<?php
require("config/global.php");

$movie_id = $_GET['movie_id'];
$watchlist_id = $_GET['watchlist_id'];

$mysqli = new mysqli($host, $user, $pass, $db);
if($mysqli->connect_errno) {
    echo($mysqli->connect_error);
    // exit();
}

$sql = "SELECT movies FROM watchlists WHERE watchlist_id = $watchlist_id;";
$results = $mysqli->query($sql);
if(!$results) {
    echo ($mysqli->error);
    $mysqli->close();
    exit();
}
$movies = $results->fetch_assoc()['movies'];
$new_movies = str_replace("$movie_id" . ",", "", $movies);

$sql = "UPDATE watchlists SET movies = '$new_movies' WHERE watchlist_id = $watchlist_id;";
$results = $mysqli->query($sql);
if(!$results) {
    echo ($mysqli->error);
    $mysqli->close();
    exit();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Confirmation</title>
    <link rel="stylesheet" href="style/global.css">
    <link rel="stylesheet" href="style/nav_bar.css">
    <link rel="stylesheet" href="style/table.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

</head>
<body>
    <div class="container-fluid">
        <div class="nav_bar">
            <ul class="col-12 mt-4">
                <li><a href="index.php">Home</a></li>
                <li><a href="create_form.php">Create</a></li>
                <li style="float:right"><a href="project_summary.html">About</a></li>
            </ul>
        </div>

        <div class="header">
            <h1 class="col-12 mt-4">iWatchList</h1>
        </div>

        <div class="row">
            <span>Delete movie <?php echo($movie_id); ?> Successfully</span>
        </div>
    </div>
</body>
</html>