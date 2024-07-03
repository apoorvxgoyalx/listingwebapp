<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "User not logged in. Please log in to book a hotel.";
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['book_now'])) {
    $user_id = $_SESSION['user_id'];
    $hotel_id = $_POST['hotel_id'];

    $sql = "INSERT INTO hotel_bookings (user_id, hotel_id) VALUES ($user_id, $hotel_id)";

    if ($conn->query($sql) === TRUE) {
        echo "Booking successful!";
        echo "<a href='hotel.php'>Back to Hotels</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
