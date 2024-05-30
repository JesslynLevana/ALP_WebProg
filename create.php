<?php include_once("controller.php")?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie</title>
</head>
<body>
    <h1>Add Movie</h1>
    <form action="create.php" method="post">
        <label for="name">Name: </label>
        <input type="text" name="name" id="name" required><br><br>
        <label for="email">Email: </label>
        <input type="text" name="email" id="email" required><br><br>
        <label for="message">Message: </label>
        <textarea name="message" id="message" required></textarea><br><br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <br><br>
    <?php
    if(isset($_POST['submit'])){
        $result = createMovie();
        echo $result;
    }
    ?>
</body>
</html>
