<?php

function my_connectDB()
{
    $host = "localhost";
    $user = "root";
    $pwd = "";
    $db = "alp_webprog";
    $conn = mysqli_connect($host, $user, $pwd, $db) or die("ERROR CONNECT TO DATABASE");

    return $conn;
}

function my_closeDB($conn)
{
    mysqli_close($conn);
}

function readMovielist()
{
    $allData = array();
    $conn = my_connectDB();

    if ($conn != null) {
        $sql_query = "
        SELECT
            movie.movie_id,
            movie.title,
            movie.synopsis,
            movie.genre,
            movie.duration,
            movie.released_date,
            movie.age,
            movie.image,
            times.time_id,
            times.times,
            showtimes.showtime_id,
            showtimes.time_id,
            showtimes.day
        FROM
            movie
        INNER JOIN
            showtimes ON movie.movie_id = showtimes.movie_id
        INNER JOIN
            times ON showtimes.time_id = times.time_id;
        ";

        $result = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Store data from database in array
                $data = array(
                    'movie_id' => $row['movie_id'],
                    'title' => $row['title'],
                    'synopsis' => $row['synopsis'],
                    'genre' => $row['genre'],
                    'duration' => $row['duration'],
                    'age' => $row['age'],
                    'released_date' => $row['released_date'],
                    'image' => $row['image'], // Store image path directly
                    'showtime_id' => $row['showtime_id'],
                    'day' => $row['day'],
                    'time_id' => $row['time_id'],
                    'times' => $row['times']
                );

                array_push($allData, $data);
            }
        }

        my_closeDB($conn);
    }

    return $allData;
}

function createMovie($photoUrl)
{
    $title = $_POST["title"];
    $synopsis = $_POST["synopsis"];
    $genre = $_POST["genre"];
    $duration = $_POST["duration"];
    $released_date = $_POST["released_date"];
    $age = $_POST["age"];
    $times = $_POST["times"];
    $day = $_POST["day"];

    $conn = my_connectDB();

    if ($conn != null) {
        // Query to insert data into the movie table
        $sql_query_movie = "INSERT INTO `movie` (title, synopsis, genre, duration, released_date, age, image) VALUES ('$title', '$synopsis', '$genre', '$duration', '$released_date', '$age', '$photoUrl')";
        // Execute the first query
        $result_movie = mysqli_query($conn, $sql_query_movie) or die(mysqli_error($conn));

        // Get the newly inserted movie_id
        $movie_id = mysqli_insert_id($conn);

        // Query to insert data into the times table
        $sql_query_times = "INSERT INTO `times` (times) VALUES ('$times')";
        // Execute the second query
        $result_times = mysqli_query($conn, $sql_query_times) or die(mysqli_error($conn));

        // Get the newly inserted time_id
        $time_id = mysqli_insert_id($conn);

        // Query to insert data into the showtimes table
        $sql_query_showtimes = "INSERT INTO `showtimes` (movie_id, time_id, day) VALUES ('$movie_id', '$time_id', '$day')";
        // Execute the third query
        $result_showtimes = mysqli_query($conn, $sql_query_showtimes) or die(mysqli_error($conn));

        // Check if all three queries were successfully executed
        if ($result_movie && $result_times && $result_showtimes) {
            return "Movie added successfully!";
        } else {
            return "Failed to add movie.";
        }
    }
}

function getMovieID($movie_id)
{
    $data = array();
    if ($movie_id > 0) {
        $conn = my_connectDB();
        $sql_query = "SELECT * FROM `movie` WHERE movie_id = $movie_id";
        $result = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Store data from database in array
                $data = array(
                    'movie_id' => $row['movie_id'],
                    'title' => $row['title'],
                    'synopsis' => $row['synopsis'],
                    'genre' => $row['genre'],
                    'duration' => $row['duration'],
                    'released_date' => $row['released_date'],
                    'age' => $row['age'],
                    'image' => $row['image'],
                );
            }
        }
        my_closeDB($conn);
        return $data;
    }
}

function getTimeID($time_id)
{
    $data = array();
    if ($time_id > 0) {
        $conn = my_connectDB();
        $sql_query = "SELECT * FROM `times` WHERE time_id = $time_id";
        $result = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Store data from database in array
                $data = array(
                    'time_id' => $row['time_id'],
                    'times' => $row['times']
                );
            }
        }
        my_closeDB($conn);
        return $data;
    }
}

function getShowtimeID($showtime_id)
{
    $data = array();
    if ($showtime_id > 0) {
        $conn = my_connectDB();
        $sql_query = "SELECT * FROM `showtimes` WHERE showtime_id = $showtime_id";
        $result = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Store data from database in array
                $data = array(
                    'showtime_id' => $row['showtime_id'],
                    'day' => $row['day']
                );
            }
        }
        my_closeDB($conn);
        return $data;
    }
}
?>
