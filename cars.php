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

// Set default sorting and filtering options
$sort_order = "ASC";
$filter_year = "";
$filter_make = "";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['sort_price'])) {
        $sort_order = $_POST['sort_price'];
    }
    if (isset($_POST['filter_year'])) {
        $filter_year = $_POST['filter_year'];
    }
    if (isset($_POST['filter_make'])) {
        $filter_make = $_POST['filter_make'];
    }
}

// Query to fetch all cars from the database with sorting and filtering
$sql = "SELECT * FROM cars WHERE 1";

if (!empty($filter_year)) {
    $sql .= " AND year >= $filter_year";
}
if (!empty($filter_make)) {
    $sql .= " AND make LIKE '%$filter_make%'";
}

$sql .= " ORDER BY price $sort_order";

$result = $conn->query($sql);

$cars = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cars[] = $row;
    }
} else {
    echo "No cars available.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Listings</title>
    <link rel="stylesheet" href="styles1.css">
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
            // Display greeting if user is logged in
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


        <h1>Available Cars</h1>
        <div class="sidebar">
            <form method="post" action="cars.php">
                <h2>Sort by Price</h2>
                <select name="sort_price">
                    <option value="ASC" <?php if ($sort_order == "ASC") echo 'selected'; ?>>Low to High</option>
                    <option value="DESC" <?php if ($sort_order == "DESC") echo 'selected'; ?>>High to Low</option>
                </select>
                <h2>Filter by Year</h2>
                <input type="number" name="filter_year" value="<?php echo $filter_year; ?>" placeholder="Enter year">
                <h2>Filter by Make</h2>
                <input type="text" name="filter_make" value="<?php echo $filter_make; ?>" placeholder="Enter make">
                <button type="submit">Apply Filters</button>
            </form>
        </div>
        <div class="car-listings">
            <?php foreach ($cars as $car): ?>
                <div class="car">
                    <img src="<?php echo $car['image_url']; ?>" alt="<?php echo $car['make'] . ' ' . $car['model']; ?>">
                    <h2><?php echo $car['make'] . ' ' . $car['model']; ?></h2>
                    <p><strong>Year:</strong> <?php echo $car['year']; ?></p>
                    <p><strong>Price:</strong> $<?php echo $car['price']; ?></p>
                    <p><strong>Mileage:</strong> <?php echo $car['mileage']; ?> miles</p>
                    <p><strong>Description:</strong><br><?php echo $car['description']; ?></p>
                    <form method="POST" action="book_car.php">
                        <input type="hidden" name="car_id" value="<?php echo $car['car_id']; ?>">
                        <button type="submit" name="book_now">Book Now</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
