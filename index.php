<?php
    require("config/global.php");

    $mysqli = new mysqli($host, $user, $pass, $db);

    if($mysqli->connect_errno) {
        echo($mysqli->connect_error);
        // exit();
    }

    $mysqli->set_charset('utf8');

    $sql = "SELECT watchlist_id, watchlists.name, edit_time, summary, creators.name AS creator, posters.url AS poster
            FROM watchlists
            LEFT JOIN creators
                ON watchlists.creator_id = creators.creator_id
            LEFT JOIN posters
                ON watchlists.poster_id = posters.poster_id;";

    $results = $mysqli->query($sql);

    if (!$results) {
        echo($mysqli->error);
        $mysqli->close();
        // exit();
    }

    $mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iWatchList</title>
    <link rel="stylesheet" href="style/nav_bar.css">
    <link rel="stylesheet" href="style/table.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/global.css">
    <style>
        img {
            height: 100px;
            width: auto;
        }
    </style>
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

        <div class="row">
        <table class="table table-striped col-20 mt-8">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Title</th>
						<th scope="col">creator</th>
						<th scope="col">Last Edit</th>
						<th scope="col"></th>
                        <th></th>
					</tr>
				</thead>
				<tbody>
                    <?php while ( $row = $results->fetch_assoc() ):  ?>
                    <tr>
                        <td><?php echo($row['name']); ?></td>
                        <td><?php echo($row['creator']); ?></td>
                        <td><?php echo($row['edit_time']); ?></td>
                        <td><img src=<?php echo($row['poster']); ?> height='200px' width='auto' ></td>
                        <td><button type="button" class="btn btn-primary" onclick="window.location = 'list_detail.php?watchlist_id=<?php echo ($row['watchlist_id']); ?>'">Detail</button></td>
                    </tr>

                    <?php endwhile; ?>

				</tbody>
			</table>
        </div>

    </div>


</body>
</html>