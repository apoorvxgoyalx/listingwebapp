<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$cardholder_name = $_POST['cardholder_name'];
$card_number = $_POST['card_number'];
$expiry_date = $_POST['expiry_date'];
$cvv = $_POST['cvv'];
$user_id = $_SESSION['user_id'];

// Insert payment details into database
$sql = "INSERT INTO payments (user_id, cardholder_name, card_number, expiry_date, cvv) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("issss", $user_id, $cardholder_name, $card_number, $expiry_date, $cvv);

if ($stmt->execute()) {
    $confirmation_message = "Payment Successful! Your transaction has been completed.";
} else {
    $confirmation_message = "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <link rel="stylesheet" href="styles6.css">
</head>
<body>
    <div class="container">
        <h2>Payment Confirmation</h2>
        <p><?php echo $confirmation_message; ?></p>
        <a href="dashboard.php">Return to Dashboard</a>
    </div>
</body>
</html>