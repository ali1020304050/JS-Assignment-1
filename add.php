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

// Check if the form is submitted
if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) &&
    isset($_POST['headline']) && isset($_POST['summary'])) {

    // Perform server-side validation (you may add more validation as per your requirements)
    if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email']) ||
        empty($_POST['headline']) || empty($_POST['summary'])) {

        $_SESSION['error'] = "All fields are required";
        header("Location: add.php");
        return;
    }

    // Insert the profile data into the database
    $stmt = $pdo->prepare('INSERT INTO Profile
        (user_id, first_name, last_name, email, headline, summary)
        VALUES (:uid, :fn, :ln, :em, :he, :su)');
    $stmt->execute(array(
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':he' => $_POST['headline'],
        ':su' => $_POST['summary'])
    );

    // Redirect to index.php after successful insertion
    $_SESSION['success'] = "Profile added successfully";
    header("Location: index.php");
    return;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Profile</title>
    <!-- Add your CSS styles or other libraries if required -->
</head>

<body>
    <div class="container">
        <h1>Adding Profile for UMSI</h1>
        <?php
        // Display error message if there was an error during form submission
        if (isset($_SESSION['error'])) {
            echo '<p style="color:red">'.$_SESSION['error'].'</p>';
            unset($_SESSION['error']);
        }
        ?>
        <form method="post">
            <p>First Name:
                <input type="text" name="first_name" size="60">
            </p>
            <p>Last Name:
                <input type="text" name="last_name" size="60">
            </p>
            <p>Email:
                <input type="text" name="email" size="30">
            </p>
            <p>Headline:<br>
                <input type="text" name="headline" size="80">
            </p>
            <p>Summary:<br>
                <textarea name="summary" rows="8" cols="80"></textarea>
            </p>
            <p>
                <input type="submit" value="Add">
                <input type="submit" name="cancel" value="Cancel">
            </p>
        </form>
    </div>
</body>

</html>
