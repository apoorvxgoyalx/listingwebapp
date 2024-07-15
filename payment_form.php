<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gateway</title>
    <link rel="stylesheet" href="styles6.css">
</head>
<body>
    <div class="container">
        <h2>Payment Gateway</h2>
        <form id="payment-form" action="process_payment.php" method="POST">
            <label for="cardholder-name">Cardholder Name</label>
            <input type="text" id="cardholder-name" name="cardholder_name" required>

            <label for="card-number">Card Number</label>
            <input type="number" id="card-number" name="card_number" required>

            <label for="expiry-date">Expiry Date</label>
            <input type="text" id="expiry-date" name="expiry_date" placeholder="MM/YY" required>

            <label for="cvv">CVV</label>
            <input type="number" id="cvv" name="cvv" required>

            <button type="submit">Pay Now</button>
        </form>

        <div id="confirmation-message" style="display: none;">
            <p>Payment Successful! Your transaction has been completed.</p>
            <a href="dashboard.php">Return to Dashboard</a>
        </div>
    </div>
</body>
</html>
