<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate input
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "All fields are required.";
    } elseif ($password !== $confirm_password) {
        echo "Passwords do not match.";
    } elseif (strlen($password) < 8) {
        echo "Password must be at least 8 characters long.";
    } elseif (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/\d/', $password) || !preg_match('/[!@#$%^&*()\-_=+{};:,<.>ยง~]/', $password)) {
        echo "Password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful. <a href='index.html'>Login here</a>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
