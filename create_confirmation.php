<?php
require('config/global.php');

$mysqli = new mysqli($host, $user, $pass, $db);

if($mysqli->connect_errno) {
    echo($mysqli->connect_error);
    // exit();
}

$watchlist_name = $_POST['watchlist_name'];
$creator = $_POST['watchlist_creator'];
$summary = $_POST['watchlist_introduction'];

$sql = "INSERT INTO creators (name)
        SELECT * FROM (SELECT '$creator' AS name) AS temp
        WHERE NOT EXISTS (
            SELECT name FROM creators WHERE name = '$creator');";
$results = $mysqli->query($sql);
if(!$results) {
    echo ($mysqli->error);
    $mysqli->close();
    exit();
}
$sql = "INSERT INTO watchlists (watchlists.name, edit_time, summary, creator_id, poster_id)
        VALUES ('$watchlist_name', CURRENT_TIMESTAMP, '$summary', (SELECT creator_id FROM creators WHERE name= '$creator'), 1 );";

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
    <title>Create List Confirmation</title>
    <link rel="stylesheet" href="style/nav_bar.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/global.css">
</head>
<body>
    <div class="container-fluid">
        <div class="nav_bar">
            <ul class="col-12 mt-4">
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="create_form.php">Create</a></li>
                <li style="float:right"><a href="project_summary.html">About</a></li>
            </ul>
        </div>

            
        <div class="header">
            <h1 class="col-12 mt-4">iWatchList</h1>
        </div>


    </div>
</body>
</html>