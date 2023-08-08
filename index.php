<?php
session_start();
$_SESSION['test'] = 'Hello, session!';
require_once "db_connection.php";

// Check if the user is logged in and get their name and user_id from the session
if (isset($_SESSION['name']) && isset($_SESSION['user_id'])) {
    $user_name = $_SESSION['name'];
    $user_id = $_SESSION['user_id'];
}

// Fetch all profiles from the database
$stmt = $pdo->query("SELECT * FROM Profile");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
        <title>Ali Nadeem</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
        integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Profile Database - <?php echo htmlentities($user_name ?? 'Guest'); ?></h1>
        <?php if (isset($user_id)) { ?>
            <p><a href="logout.php">Logout</a></p>
        <?php } else { ?>
            <p><a href="login.php">Please log in</a></p>
        <?php } ?>
    </div>
    <div class="container">
        <h2>Profiles</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Headline</th>
                    <?php if (isset($user_id)) { ?>
                        <th>Action</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row) { ?>
                    <tr>
                        <td>
                            <a href="view.php?profile_id=<?php echo htmlentities($row['profile_id']); ?>">
                                <?php echo htmlentities($row['first_name'].' '.$row['last_name']); ?>
                            </a>
                        </td>
                        <td><?php echo htmlentities($row['headline']); ?></td>
                        <?php if (isset($user_id)) { ?>
                            <td>
                                <a href="edit.php?profile_id=<?php echo htmlentities($row['profile_id']); ?>">Edit</a> /
                                <a href="delete.php?profile_id=<?php echo htmlentities($row['profile_id']); ?>">Delete</a>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php if (isset($user_id)) { ?>
            <p><a href="add.php">Add New Entry</a></p>
        <?php } ?>
    </div>
</body>
</html>
