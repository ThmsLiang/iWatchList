<?php
require('config/global.php');

$watchlist_id = $_GET['watchlist_id'];

$mysqli = new mysqli($host, $user, $pass, $db);
if($mysqli->connect_errno) {
    $error = $error . $mysqli->connect_error;
    // exit();
}
$mysqli->set_charset('utf8');

$sql = "SELECT watchlists.name AS name, summary, movies FROM watchlists WHERE watchlist_id = " . $watchlist_id . ";";

$results = $mysqli->query($sql);

if (!$results) {
    echo($mysqli->error);
    $mysqli->close();
    exit();
}

$row = $results->fetch_assoc();
$watchlist_name = $row['name'];
$summary = $row['summary'];
$str = $row['movies'];
$movie_ids = explode(',', $str);
$movie_results = array();
foreach ($movie_ids as $temp) {
    //echo ($temp);
    if ($temp == "") {
        continue;
    }
    $int = (int) $temp;
    $sql = "SELECT movie_id, imdb_id, title, year, posters.url AS poster, types.type FROM movies
            LEFT JOIN posters
                ON movies.poster_id = posters.poster_id
            LEFT JOIN types
                on movies.type_id = types.type_id
            WHERE movie_id = " . $int . ";";
    $tmp = $mysqli->query($sql);
    if (!$tmp) {
        echo($mysqli->error);
        $mysqli->close();
        exit();
    }
    $movie_results[] = $tmp->fetch_assoc();
}

$mysqli->close();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watchlist Detail</title>
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
            <h1><?php echo ($watchlist_name); ?></h1>
        </div>

        <div class="row">
            <h3><?php echo ($summary); ?></h3>
        </div>

        <div class="row">
            <div class="col">
                <button type="button" class="btn btn-info" onclick="window.location = 'search_form.php?watchlist_id=<?php echo ($watchlist_id); ?>'" >Add</button>
            </div>

            <div class="col">
                <button type="button" class="btn btn-info" onclick="window.location = 'edit_form.php?watchlist_id=<?php echo ($watchlist_id); ?>'" >Edit watchlist title or introduction</button>

            </div>
        </div>

        <div class="row">
            <table class="table table-striped col-20 mt-8">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Movie Title</th>
						<th scope="col">IMDB ID</th>
						<th scope="col">Year</th>
						<th scope="col"></th>
                        <th></th>
					</tr>
				</thead>
				<tbody>
                    <?php foreach($movie_results as $movie):
                        if ($movie == null) {
                            break;
                        }
                        ?>
                    <tr>
                        <td><?php echo($movie['title']); ?></td>
                        <td><?php echo($movie['imdb_id']); ?></td>
                        <td><?php echo($movie['year']); ?></td>
                        <td><img src=<?php echo($movie['poster']); ?> height='100px' width='auto' ></td>
                        <td><button type="button" class="btn btn-danger" onclick="window.location = 'delete_confirmation.php?watchlist_id=<?php echo ($watchlist_id); ?>&movie_id=<?php echo ($movie['movie_id']); ?>'">Delete</button></td>
                    </tr>

                    <?php endforeach; ?>

				</tbody>
			</table>
        </div>

    </div>
</body>
</html>