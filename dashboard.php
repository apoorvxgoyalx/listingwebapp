<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="outer">
        <div class="welcome-message">
            <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
        </div>
        <div class="logout">
            <form method="post" action="logout.php">
                <button type="submit" name="logout">Logout</button>
            </form>
        </div>
        <div class="dashboard">
            <a href="cars.php" class="dashboard-button">
                <div class="dashboard-text">Cars</div>
            </a>
            <a href="hotel.php" class="dashboard-button">
                <div class="dashboard-text">Hotels</div>
            </a>
            <a href="rentals.php" class="dashboard-button">
                
                <div class="dashboard-text">Property Rentals</div>
            </a>
            <a href="car_rentals.php" class="dashboard-button">
                
                <div class="dashboard-text">Car Rentals</div>
            </a>
        </div>
    </div>
</body>
</html>
