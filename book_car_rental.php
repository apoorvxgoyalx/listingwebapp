<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        die("User not logged in. Please log in to book a car rental.");
    }

    // Validate and sanitize rental_id
    $rental_id = $_POST['rental_id'];
    $rental_id = $conn->real_escape_string($rental_id);

    // Retrieve user_id from session
    $user_id = $_SESSION['user_id'];

    // Insert booking into car_rentals_booking table
    $sql = "INSERT INTO car_rentals_booking (rental_id, user_id)
            VALUES ('$rental_id', '$user_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Booking successful!";
        echo "<br><a href='car_rentals.php'>Back to Cars Rentals</a>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
