<?php
require('config/global.php');

$watchlist_id = $_GET['watchlist_id'];
$title = $_GET['title'];
$imdb_id = $_GET['imdb_id'];
$year = $_GET['year'];
$poster = $_GET['poster'];
$type = $_GET['type'];

$mysqli = new mysqli($host, $user, $pass, $db);
if($mysqli->connect_errno) {
    echo($mysqli->connect_error);
    $mysqli->close();
    exit();
}


// insert type
$sql = "INSERT INTO types (type) 
        SELECT * FROM (SELECT '$type' AS type) AS temp
        WHERE NOT EXISTS (SELECT type from types WHERE type = '$type');";
$results = $mysqli->query($sql);
if (!$results) {
    echo ($mysqli->error);
    exit();
}

// insert poster
$sql = "INSERT INTO posters (url) 
SELECT * FROM (SELECT '$poster' AS url) AS temp
WHERE NOT EXISTS (SELECT url from posters WHERE url = '$poster');";
$results = $mysqli->query($sql);
if (!$results) {
    echo ($mysqli->error);
    exit();
}


// insert movie
$sql = "INSERT INTO movies (imdb_id, title, year, poster_id, type_id) 
SELECT * FROM (SELECT '$imdb_id' AS imdb_id, '$title' AS title, '$year' AS year, (SELECT poster_id FROM posters WHERE url = '$poster') AS poster_id, (SELECT type_id FROM types WHERE type = '$type') AS type_id) AS temp
WHERE NOT EXISTS (SELECT * from movies WHERE imdb_id = '$imdb_id');";
$results = $mysqli->query($sql);
if (!$results) {
    echo ($mysqli->error);
    exit();
}

// add movie to watchlist
$sql = "SELECT movies FROM watchlists WHERE watchlist_id = $watchlist_id";
$results = $mysqli->query($sql);
if (!$results) {
    echo ($mysqli->error); 
}
$row = $results->fetch_assoc()['movies'];
$sql = "SELECT movie_id FROM movies WHERE imdb_id = '$imdb_id'";
$results = $mysqli->query($sql);
if (!$results) {
    echo ($mysqli->error); 
}
$new_movie = $results->fetch_assoc()['movie_id'];
$row = $row . $new_movie . ',';
$sql = "UPDATE watchlists 
        SET movies = '$row', edit_time = CURRENT_TIMESTAMP, poster_id = (SELECT poster_id FROM posters WHERE url = '$poster')
        WHERE watchlist_id = $watchlist_id;";
$results = $mysqli->query($sql);
if (!$results) {
    echo ($mysqli->error); 
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
            <span>Add <?php echo ($title); ?> To List <?php echo($watchlist_id); ?> successfully</span>
        </div>
    </div>
</body>
</html>