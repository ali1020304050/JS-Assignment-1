<?php
require_once "db_connection.php";

// Get the profile_id from the URL
$profile_id = $_GET['profile_id'];

// Fetch the profile data from the database using profile_id
$stmt = $pdo->prepare('SELECT * FROM Profile WHERE profile_id = :pid');
$stmt->execute(array(':pid' => $profile_id));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile information</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
        integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Profile information</h1>
        <p>First Name: <?php echo htmlentities($row['first_name']); ?></p>
        <p>Last Name: <?php echo htmlentities($row['last_name']); ?></p>
        <p>Email: <?php echo htmlentities($row['email']); ?></p>
        <p>Headline:<br><?php echo htmlentities($row['headline']); ?></p>
        <p>Summary:<br><?php echo htmlentities($row['summary']); ?></p>
        <p><a href="index.php">Done</a></p>
    </div>
</body>
</html>
