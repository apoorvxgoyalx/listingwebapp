<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
$username = $_SESSION['username'];
// Debugging
echo "Session Username: " . $username;


include 'connect.php'; // Include your database connection script

// Prepare the SQL query
$query = "SELECT id, username, email FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $userId = $user['id'];
    $userEmail = $user['email'];
    // Continue fetching other user details as needed
} else {
    die("User not found.");
}

// Fetch user bookings from different tables
$carBookingsQuery = "
    SELECT 'Car' AS type, c.title AS item, cb.booking_date AS date
    FROM car_bookings cb
    JOIN cars c ON cb.car_id = c.car_id
    WHERE cb.user_id = $userId
";
$hotelBookingsQuery = "
    SELECT 'Hotel' AS type, h.title AS item, hb.booking_date AS date
    FROM hotel_bookings hb
    JOIN hotels h ON hb.hotel_id = h.hotel_id
    WHERE hb.user_id = $userId
";
$rentalBookingsQuery = "
    SELECT 'Rental' AS type, r.title AS item, rb.booking_date AS date
    FROM rental_bookings rb
    JOIN rentals r ON rb.rental_id = r.rental_id
    WHERE rb.user_id = $userId
";
$carRentalBookingsQuery = "
    SELECT 'Car Rental' AS type, cr.title AS item, crb.booking_date AS date
    FROM car_rental_bookings crb
    JOIN car_rental cr ON crb.car_rental_id = cr.car_rental_id
    WHERE crb.user_id = $userId
";

// Execute the queries
$bookingsResult = $conn->query("
    ($carBookingsQuery)
    UNION
    ($hotelBookingsQuery)
    UNION
    ($rentalBookingsQuery)
    UNION
    ($carRentalBookingsQuery)
");

if (!$bookingsResult) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="outer">
        <div class="profile-section">
            <h1>User Profile</h1>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        </div>
        <div class="bookings-section">
            <h2>Your Bookings</h2>
            <?php if ($bookingsResult->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Item</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($booking = $bookingsResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($booking['type']); ?></td>
                                <td><?php echo htmlspecialchars($booking['item']); ?></td>
                                <td><?php echo htmlspecialchars($booking['date']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No bookings found.</p>
            <?php endif; ?>
        </div>
        <div class="logout">
            <form method="post" action="logout.php">
                <button type="submit" name="logout">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>
