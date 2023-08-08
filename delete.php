<?php
require_once "db_connection.php";

// Check if the profile_id is provided in the URL
if (!isset($_GET['profile_id'])) {
    die("No profile_id provided.");
}

$profile_id = $_GET['profile_id'];

// Fetch the profile data from the database using profile_id
$stmt = $pdo->prepare('SELECT * FROM Profile WHERE profile_id = :pid');
$stmt->execute(array(':pid' => $profile_id));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the profile exists
if (!$row) {
    die("Profile not found.");
}

// Check if the form is submitted for deletion
if (isset($_POST['delete'])) {
    // Perform deletion of the profile from the database
    $stmt = $pdo->prepare('DELETE FROM Profile WHERE profile_id = :pid');
    $stmt->execute(array(':pid' => $profile_id));

    // Redirect to index.php after successful deletion
    header("Location: index.php");
    return;
}

// Check if the form is submitted for canceling the deletion
if (isset($_POST['cancel'])) {
    // Redirect to index.php without performing deletion
    header("Location: index.php");
    return;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Profile</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
        integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Delete Profile</h1>
        <p>Are you sure you want to delete the following profile?</p>
        <p>First Name: <?php echo htmlentities($row['first_name']); ?></p>
        <p>Last Name: <?php echo htmlentities($row['last_name']); ?></p>
        <p>Email: <?php echo htmlentities($row['email']); ?></p>
        <p>Headline:<br><?php echo htmlentities($row['headline']); ?></p>
        <p>Summary:<br><?php echo htmlentities($row['summary']); ?></p>

        <form method="post">
            <input type="hidden" name="profile_id" value="<?php echo $profile_id; ?>">
            <input type="submit" name="delete" value="Delete">
            <input type="submit" name="cancel" value="Cancel">
        </form>
    </div>
</body>
</html>
