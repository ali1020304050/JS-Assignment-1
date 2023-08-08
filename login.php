<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['pass'];

    // Perform custom validation
    if (empty($email) || empty($password)) {
        // Validation failed
        echo "Both fields must be filled out.";
        exit();
    }

    $validCredentials = validateUserCredentials($email, $password);

    if ($validCredentials) {
        // User credentials are valid, set the session variables
        $_SESSION['user_email'] = $email;
        $_SESSION['user_logged_in'] = true;
        $_SESSION['name'] = 'UMSI';
        $_SESSION['user_id'] = 1;

        // Redirect the user to the main page or any other desired page
        header('Location: index.php');
        exit();
    } else {
        // Invalid credentials
        echo "Invalid email address or password.";
        exit();
    }
}

// Custom function to validate user credentials
function validateUserCredentials($email, $password) {
    // Your database credentials
    $db_email = 'umsi@umich.edu';
    $db_password_hash = '218140990315bb39d948a523d61549b4'; // MD5 hash of 'php123'

    // Check if the provided email matches the one in the database
    if ($email === $db_email) {
        // Hash the user-provided password for comparison
        $hashed_password = md5($password);

        // Check if the hashed password matches the one in the database
        if ($hashed_password === $db_password_hash) {
            return true;
        }
    }

    return false;
}
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
        <h1>Please Log In</h1>
        <form method="POST" onsubmit="return doValidate();" action="login.php">
            <label for="email">Email</label>
            <input type="text" name="email" id="email"><br>
            <label for="id_1723">Password</label>
            <input type="password" name="pass" id="id_1723"><br>
            <input type="submit" value="Log In">
            <button type="button" name="cancel" onclick="location.href='index.php';">Cancel</button>
        </form>
    </div>

    <script>
    function doValidate() {
        console.log('Validating...');
        try {
            const addr = document.getElementById('email').value;
            const pw = document.getElementById('id_1723').value;
            console.log("Validating addr=" + addr + " pw=" + pw);

            if (addr.trim() === '' || pw.trim() === '') {
                alert("Both fields must be filled out");
                return false;
            }

            if (addr.indexOf('@') === -1) {
                alert("Invalid email address");
                return false;
            }

            // If validation passes, the form will be submitted
            return true;
        } catch (e) {
            return false;
        }
        return false;
    }
    </script>

</body>

</html>