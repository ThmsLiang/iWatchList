<?php
$watchlist_id = $_GET['watchlist_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create A Watchlist</title>
    <link rel="stylesheet" href="style/nav_bar.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/global.css">

</head>
<body>
    <div class="container-fluid">

        <div class="nav_bar">
            <ul class="col-12 mt-4">
                <li><a href="index.php">Home</a></li>
                <li class="active"><a href="create_form.php">Create</a></li>
                <li style="float:right"><a href="project_summary.html">About</a></li>
            </ul>
        </div>

        <div class="header">
            <h1 class="col-12 mt-4">iWatchList</h1>
        </div>
        
        <div class="row">
            <h1>Edit List <?php echo ($watchlist_id); ?></h1>
        </div>

        <div class="row">
            <form action="edit_confirmation.php" method="POST">
                <input type="hidden" id="watchlist_id" name="watchlist_id" value=<?php echo ($watchlist_id); ?>>

                <div class="form-group">
                    <label for="watchlist_name">Name</label>
                    <input type="text" class="form-control" name="watchlist_name" id="watchlist_name" placeholder="Enter watchlist name...">
                </div>

                <div class="form-group">
                    <label for="watchlist_creator">Your Name</label>
                    <input type="text" class="form-control" name="watchlist_creator" id="watchlist_creator" placeholder="Enter your name...">
                    <small class="form-text text-muted">Your name will be shown to public as list creator</small>
                </div>

                <div class="form-group">
                    <label for="watchlist_introduction">Summary</label>
                    <textarea class="form-control" name="watchlist_introduction" id="watchlist_introduction" rows="3" placeholder="Enter a brief introduction of your watchlist..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
            
    </div>
</body>
</html>