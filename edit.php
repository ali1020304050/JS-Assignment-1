<?php
session_start();
require_once "db_connection.php";

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}

// Check if the cancel button is clicked
if (isset($_POST['cancel'])) {
    // Redirect the user to index.php if "Cancel" is clicked
    header("Location: index.php");
    return;
}

// Get the profile_id from the URL
if (!isset($_GET['profile_id'])) {
    die("No profile_id provided.");
}
$profile_id = $_GET['profile_id'];

// Fetch the specific profile data from the database based on the provided profile_id and user_id
$stmt = $pdo->prepare("SELECT * FROM Profile WHERE profile_id = :pid AND user_id = :uid");
$stmt->execute(array(':pid' => $profile_id, ':uid' => $_SESSION['user_id']));
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the profile exists and belongs to the logged-in user
if (!$profile) {
    die("Profile not found or unauthorized access.");
}

// Check if the form is submitted
if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) &&
    isset($_POST['headline']) && isset($_POST['summary'])) {

    // Perform server-side validation (you may add more validation as per your requirements)
    if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email']) ||
        empty($_POST['headline']) || empty($_POST['summary'])) {

        $_SESSION['error'] = "All fields are required";
        header("Location: edit.php?profile_id=" . urlencode($profile_id));
        return;
    }

    // Update the profile data in the database
    $stmt = $pdo->prepare('UPDATE Profile SET
        first_name = :fn,
        last_name = :ln,
        email = :em,
        headline = :he,
        summary = :su
        WHERE profile_id = :pid AND user_id = :uid');

    $stmt->execute(array(
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':he' => $_POST['headline'],
        ':su' => $_POST['summary'],
        ':pid' => $profile_id,
        ':uid' => $_SESSION['user_id'])
    );

    // Redirect to index.php after successful update
    $_SESSION['success'] = "Profile updated successfully";
    header("Location: index.php");
    return;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Profile</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
        integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1>Edit Profile</h1>
        <?php
        // Display error message if there was an error during form submission
        if (isset($_SESSION['error'])) {
            echo '<p style="color:red">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);
        }
        ?>
        <form method="post">
            <p>First Name:
                <input type="text" name="first_name" size="60" value="<?php echo htmlentities($profile['first_name']); ?>">
            </p>
            <p>Last Name:
                <input type="text" name="last_name" size="60" value="<?php echo htmlentities($profile['last_name']); ?>">
            </p>
            <p>Email:
                <input type="text" name="email" size="30" value="<?php echo htmlentities($profile['email']); ?>">
            </p>
            <p>Headline:<br>
                <input type="text" name="headline" size="80" value="<?php echo htmlentities($profile['headline']); ?>">
            </p>
            <p>Summary:<br>
                <textarea name="summary" rows="8" cols="80"><?php echo htmlentities($profile['summary']); ?></textarea>
            </p>
            <p>
                <input type="submit" value="Save">
                <input type="submit" name="cancel" value="Cancel">
            </p>
        </form>
    </div>
</body>

</html>
