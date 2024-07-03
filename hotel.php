<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set default sorting and filtering options
$sort_order = "ASC";
$filter_location = "";
$filter_price = "";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['sort_price'])) {
        $sort_order = $_POST['sort_price'];
    }
    if (isset($_POST['filter_location'])) {
        $filter_location = $_POST['filter_location'];
    }
    if (isset($_POST['filter_price'])) {
        $filter_price = $_POST['filter_price'];
    }
}

// Query to fetch all hotels from the database with sorting and filtering
$sql = "SELECT * FROM hotels WHERE 1";

if (!empty($filter_location)) {
    $sql .= " AND location LIKE '%$filter_location%'";
}
if (!empty($filter_price)) {
    $sql .= " AND price <= $filter_price";
}

$sql .= " ORDER BY price $sort_order";

$result = $conn->query($sql);

$hotels = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $hotels[] = $row;
    }
} else {
    echo "No hotels available.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Listings</title>
    <link rel="stylesheet" href="styles2.css">
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


        <h1>Available Hotels</h1>
        <div class="sidebar">
            <form method="post" action="hotel.php">
                <h2>Sort by Price</h2>
                <select name="sort_price">
                    <option value="ASC" <?php if ($sort_order == "ASC") echo 'selected'; ?>>Low to High</option>
                    <option value="DESC" <?php if ($sort_order == "DESC") echo 'selected'; ?>>High to Low</option>
                </select>
                <h2>Filter by Location</h2>
                <input type="text" name="filter_location" value="<?php echo $filter_location; ?>" placeholder="Enter location">
                <h2>Filter by Price</h2>
                <input type="number" name="filter_price" value="<?php echo $filter_price; ?>" placeholder="Enter maximum price">
                <button type="submit">Apply Filters</button>
            </form>
        </div>
        <div class="hotel-listings">
            <?php foreach ($hotels as $hotel): ?>
                <div class="hotel">
                    <img src="<?php echo $hotel['image_url']; ?>" alt="<?php echo $hotel['name']; ?>">
                    <h2><?php echo $hotel['name']; ?></h2>
                    <p><strong>Location:</strong> <?php echo $hotel['location']; ?></p>
                    <p><strong>Price:</strong> $<?php echo $hotel['price']; ?></p>
                    <p><strong>Description:</strong><br><?php echo $hotel['description']; ?></p>
                    <form method="POST" action="book_hotel.php">
                        <input type="hidden" name="hotel_id" value="<?php echo $hotel['hotel_id']; ?>">
                        <button type="submit" name="book_now">Book Now</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
