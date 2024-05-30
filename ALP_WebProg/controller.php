<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

// function untuk connect database
function my_connectDB()
{
    $host = "localhost";
    $user = "root";
    $pwd = "";
    $db = "alpwebprog";
    $conn = mysqli_connect($host, $user, $pwd, $db) or die("ERROR CONNECT TO DATABASE");

    return $conn;
}

//function untuk close connection

function my_closeDB($conn)
{
    mysqli_close($conn);
}

// Function to read database
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
            showtime.showtime_id,
            showtime.time_id
        FROM
            movie
        INNER JOIN
            showtime ON movie.movie_id = showtime.movie_id;
        ";
        $result = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Simpan data dari database ke dalam array
                $data = array(
                    'movie_id' => $row['movie_id'],
                    'title' => $row['title'],
                    'synopsis' => $row['synopsis'],
                    'genre' => $row['genre'],
                    'duration' => $row['duration'],
                    'age' => $row['age'],
                    'released_date' => $row['released_date'],
                    'image' => base64_encode($row['image']),
                    'showtime_id' => $row['showtime_id'],
                    'time_id' => $row['time_id']
                );

                array_push($allData, $data);
            }
        }

        my_closeDB($conn);
    }
    return $allData;   
}

$result = readMovielist();
 ?>
</body>
</html>
