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

if (isset($_POST['book_now'])) {
    // Ensure user_id is set in the session
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        die("User not logged in. Please log in to book a car.");
    }

    // Ensure car_id is set in the POST data
    if (isset($_POST['car_id'])) {
        $car_id = $_POST['car_id'];
    } else {
        die("Car ID is not set.");
    }

    // Debugging: Print user_id and car_id
    echo "User ID: $user_id<br>";
    echo "Car ID: $car_id<br>";

    // Escape the values to prevent SQL injection
    $user_id = $conn->real_escape_string($user_id);
    $car_id = $conn->real_escape_string($car_id);

    // Insert into bookings table
    $sql = "INSERT INTO car_bookings (user_id, car_id) VALUES ('$user_id', '$car_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Booking successful!";
        echo "<br><a href='payment_form.php'>PAYMENT GATEWAY</a>";
        echo "<br><a href='cars.php'>Back to Cars</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
