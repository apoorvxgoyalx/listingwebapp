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

$sort_order = "ASC";
$filter_location = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['sort_price'])) {
        $sort_order = $_POST['sort_price'];
    }
    if (isset($_POST['filter_location'])) {
        $filter_location = $_POST['filter_location'];
    }
}

$sql = "SELECT * FROM car_rentals WHERE 1";

if (!empty($filter_location)) {
    $sql .= " AND location LIKE '%$filter_location%'";
}

$sql .= " ORDER BY price $sort_order";

$result = $conn->query($sql);

$rentals = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rentals[] = $row;
    }
} else {
    echo "No car rentals available.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rentals</title>
    <link rel="stylesheet" href="styles4.css">
</head>
<body>
    <div class="container">
        <div class="logout">
            <form method="post" action="logout.php">
                <button type="submit" name="logout">Logout</button>
            </form>
        </div>

        <div class="greeting">
            <?php
            if (isset($_SESSION['username'])) {
                echo "<p>Hi, " . $_SESSION['username'] . "!</p>";
            } else {
                echo "<p>Hi, Guest!</p>";
            }
            ?>
        </div>
        <div class="back-to-dashboard">
            <a href="dashboard.php" class="dashboard-button">Back to Dashboard</a>
        </div>


        <h1>Available Car Rentals</h1>
        <div class="sidebar">
            <form method="post" action="car_rentals.php">
                <h2>Sort by Price</h2>
                <select name="sort_price">
                    <option value="ASC" <?php if ($sort_order == "ASC") echo 'selected'; ?>>Low to High</option>
                    <option value="DESC" <?php if ($sort_order == "DESC") echo 'selected'; ?>>High to Low</option>
                </select>
                <h2>Filter by Location</h2>
                <input type="text" name="filter_location" value="<?php echo $filter_location; ?>" placeholder="Enter location">
                <button type="submit">Apply Filters</button>
            </form>
        </div>

        <div class="rental-listings">
            <?php foreach ($rentals as $rental): ?>
                <div class="rental">
                    <img src="<?php echo $rental['image_url']; ?>" alt="<?php echo $rental['title']; ?>">
                    <h2><?php echo $rental['title']; ?></h2>
                    <p><strong>Location:</strong> <?php echo $rental['location']; ?></p>
                    <p><strong>Price:</strong> $<?php echo $rental['price']; ?></p>
                    <p><strong>Description:</strong><br><?php echo $rental['description']; ?></p>
                    <form method="POST" action="book_car_rental.php">
                        <input type="hidden" name="rental_id" value="<?php echo $rental['rental_id']; ?>">
                        <button type="submit" name="book_now">Book Now</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
