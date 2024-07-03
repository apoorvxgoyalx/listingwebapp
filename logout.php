<?php
// Check if the logout button is clicked
if (isset($_POST['logout'])) {
    // Clear all session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to the login page or any other page
    header("Location: index.html");
    exit();
}
?>