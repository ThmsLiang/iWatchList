<?php
$watchlist_id = $_GET['watchlist_id'];
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search A Movie</title>
    <link rel="stylesheet" href="style/nav_bar.css">
    <link rel="stylesheet" href="style/global.css">
    <link rel="stylesheet" href="style/table.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

</head>
<body>
    <div class="container-fluid">
        <div class="nav_bar row">
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
            <span id="watchlist_id"><?php echo($watchlist_id);?></span>
        </div>

        <div class="row justify-content-center">
            <h1>Search</h1>
        </div>

        <div class="row justify-content-center">
            <form id="search-form">
                <div class="form-row">
                    <label for="search_name">Find a movie</label>
                    <input type="text" class="form-control" size="20" id="search_name" placeholder="Enter movie title...">
                
                    <button type="submit" class="btn btn-primary">Search</button>

                </div>
            </form>
        </div>

        <div class="row justify-content-center">
            <table class="table table-striped col-20 mt-8">
                <thead class="thead-dark">
                    <tr>
						<th scope="col">Title</th>
						<th scope="col">Release Year</th>
						<th scope="col">Type</th>
						<th scope="col"></th>
                        <th scope="col"></th>
					</tr>
                </thead>
                <tbody id="table-body">

                </tbody>
            </table>
        </div>
        
    </div>
    <script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript">
        console.log("In Javascript");

        function createItem(movie) {
            var tr = document.createElement('tr');
            var poster = document.createElement('img');
            var title = document.createElement('span');
            var release_year = document.createElement('span');
            var type = document.createElement('span');
            var add_btn = document.createElement('button');

            if(movie.Poster == "N/A") {
                poster.src = "img/blank.png";
            } else {
                poster.src = movie.Poster;
            }
            title.innerHTML = movie.Title;
            release_year.innerHTML = movie.Year;
            poster.style.height = '100px'; poster.style.width = 'auto';
            poster.alt = movie.Title;
            type.innerHTML = movie.Type;

            add_btn.type = 'button';
            add_btn.classList.add("btn", "btn-outline-primary");
            add_btn.onclick = function() {
                var title_to_pass = String(movie.Title);
                console.log(title_to_pass);
                var watchlist_id = document.querySelector("#watchlist_id").innerHTML;
                var url = "search_result.php?imdb_id=" + movie.imdbID + "&watchlist_id=" + watchlist_id + "&title=" + movie.Title + "&year=" + movie.Year + "&poster=" + movie.Poster + "&type=" + movie.Type;
                console.log(url);
                window.location = url;
            };
            add_btn.innerHTML = "Add";

            var th_title = document.createElement('th');
            th_title.appendChild(title);
            tr.appendChild(th_title);
            var th_year = document.createElement('th');
            th_year.appendChild(release_year);
            tr.appendChild(th_year);
            var th_type = document.createElement('th');
            th_type.appendChild(type);
            tr.appendChild(th_type);
            var th_poster = document.createElement('th');
            th_poster.appendChild(poster);
            tr.appendChild(th_poster);
            var th_btn = document.createElement('th');
            th_btn.appendChild(add_btn);
            tr.appendChild(th_btn);
            
            document.querySelector("#table-body").appendChild(tr);
        }

        document.querySelector("#search-form").onsubmit = function() {
            console.log("submitted");
            var term = document.querySelector("#search_name").value.trim();
            console.log("start searching: " + term);

            if(term.length > 0) {
                document.querySelector("#table-body").innerHTML = '';
                const url = "https://www.omdbapi.com/?s=" + term + "&apikey=8ff044fd";
                console.log(url);

                $.ajax({
                    url: url,
                    datatype: 'json'
                }).then((data) => {
                    if (data.Error == "Too many results.") {
                        alert('Too many results! Please add more search terms.');
                    } else {
                        var count = 0;
                        for( movie of data.Search) {
                            if (count == 20) {
                                break;
                            } else {
                                createItem(movie);
                                count++;
                            }
                        }
                    }
                }).fail((erro) => {
                    alert("AJAX ERROR, please try different terms");
                    console.log(erro);
                })


            } else {
                alert("Search cannot be null");
            }
            return false;
        }
    </script>
</body>
</html>