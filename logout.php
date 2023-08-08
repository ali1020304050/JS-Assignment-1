<?php
session_start();

// Clear all session data
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect back to the index.php page
header("Location: index.php");
return;
?>
