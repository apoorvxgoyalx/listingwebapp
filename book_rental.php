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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_now'])) {
    $rental_id = $_POST['rental_id'];
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

    // Example: Fetch rental details based on rental_id
    $sql_rental = "SELECT * FROM rentals WHERE rental_id = $rental_id";
    $result_rental = $conn->query($sql_rental);

    if ($result_rental->num_rows > 0) {
        $rental = $result_rental->fetch_assoc();

        // Example: Calculate total price (assuming flat rate for simplicity)
        $total_price = $rental['price'];

        // Insert booking into rental_bookings table
        $sql_booking = "INSERT INTO rental_bookings (rental_id, user_id , total_price)
                        VALUES ($rental_id, $user_id , $total_price)";

        if ($conn->query($sql_booking) === TRUE) {
            echo "Booking successful!";
            echo "<a href='rentals.php'>Back to Rentals</a>";
        } else {
            echo "Error: " . $sql_booking . "<br>" . $conn->error;
        }
    } else {
        echo "Rental not found.";
    }
}

$conn->close();
?>
