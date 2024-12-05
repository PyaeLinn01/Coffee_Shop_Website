<?php
@include 'config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items
$grand_total = 0;
$select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('Query failed');
$cart_items = [];

if (mysqli_num_rows($select_cart) > 0) {
    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
        $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
        $grand_total += $total_price;
        $cart_items[] = $fetch_cart;
    }
} else {
    $cart_items[] = ['message' => 'Your cart is empty'];
}

// Handle form submission
if (isset($_POST['order'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $flat = mysqli_real_escape_string($conn, $_POST['flat']);
    $street = mysqli_real_escape_string($conn, $_POST['street']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $address = $flat . ', ' . $street . ', ' . $city;
    $placed_on = date('d-M-Y');

    $card_number = isset($_POST['card_number']) ? mysqli_real_escape_string($conn, $_POST['card_number']) : '';
    $expiry_date = isset($_POST['expiry_date']) ? mysqli_real_escape_string($conn, $_POST['expiry_date']) : '';
    $cvv = isset($_POST['cvv']) ? mysqli_real_escape_string($conn, $_POST['cvv']) : '';

    $total_products = implode(', ', array_map(function ($item) {
        return $item['name'] . ' (' . $item['quantity'] . ')';
    }, $cart_items));

    // Insert order details into the database
    $insert_order = mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, method, address, total_products, total_price, placed_on, card_number, expiry_date, cvv) VALUES('$user_id', '$name', '$number', '$method', '$address', '$total_products', '$grand_total', '$placed_on', '$card_number', '$expiry_date', '$cvv')") or die('Query failed');

    // Clear the user's cart
    $delete_cart = mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('Query failed');

    // Redirect to orders.php
    header('Location: orders.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <!-- Your Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Ensure the map container has a defined height */
        #map {
            height: 300px; /* Adjust height as needed */
            width: 100%;   /* Full width of the container */
        }
        .error-message {
            color: red;
            display: none;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php @include 'header.php'; ?>

    <!-- Page Heading -->
    <section class="heading">
        <h3>Checkout Order</h3>
        <p><a href="home.php">Home</a> / Checkout</p>
    </section>

    <!-- Display Order Items -->
    <section class="display-order">
        <?php
        if (!empty($cart_items)) {
            foreach ($cart_items as $item) {
                if (isset($item['message'])) {
                    echo '<p class="empty">' . htmlspecialchars($item['message']) . '</p>';
                } else {
                    echo '<p>' . htmlspecialchars($item['name']) . ' <span>($' . htmlspecialchars($item['price']) . '/- x ' . htmlspecialchars($item['quantity']) . ')</span></p>';
                }
            }
            echo '<div class="grand-total">Grand Total: <span>$' . htmlspecialchars($grand_total) . '/-</span></div>';
        }
        ?>
    </section>

    <!-- Map and Checkout Form -->
    <section class="checkout">
        <form action="" method="POST" id="order-form">
            <h3>Place Your Order</h3>
            <div class="flex">
                <div class="inputBox">
                    <span>Your Name:</span>
                    <input type="text" name="name" placeholder="Enter your name" required>
                </div>
                <div class="inputBox">
                    <span>Your Phone Number:</span>
                    <input type="text" name="number" id="phone-number" maxlength="11" placeholder="Enter your number" required>
                    <p class="error-message" id="phone-error" style="display: none;">Phone number must be exactly 11 digits long.</p>
                </div>

                <div class="inputBox">
                    <span>Payment Method:</span>
                    <select name="method" id="payment-method" onchange="toggleCreditCardFields()" required>
                        <option value="cash on delivery">Cash on Delivery</option>
                        <option value="credit card">Credit Card</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>Street Name:</span>
                    <input type="text" id="street" name="street" placeholder="will be automatically filled by tapping on the map" required>
                </div>
                <div class="inputBox">
                    <span>Flat Number:</span>
                    <input type="text" id="flat" name="flat" placeholder="e.g. flat no.">
                </div>
                <div class="inputBox">
                    <span>City:</span>
                    <input type="text" id="city" name="city" placeholder="will be automatically filled by tapping on the map" required>
                </div>
                <div id="credit-card-fields" style="display:none;">
                    <div class="inputBox">
                        <span>Card Number:</span>
                        <input type="text" name="card_number" placeholder="starts with 4 and 13 or 16 digits long" pattern="^4[0-9]{12}(?:[0-9]{3})?$" title="Visa card number must start with 4 and be 13 or 16 digits long">
                    </div>
                    <div class="inputBox">
                        <span>Expiry Date:</span>
                        <input type="text" name="expiry_date" placeholder="MM/YY(e.g. 04/24)" pattern="(0[1-9]|1[0-2])\/[0-9]{2}" title="Expiry date must be in MM/YY format">
                    </div>
                    <div class="inputBox">
                        <span>CVV:</span>
                        <input type="password" name="cvv" placeholder="Enter CVV:(CVV has only 3 digits)" pattern="[0-9]{3}" title="CVV must be 3 digits">
                    </div>
                </div>
            </div>
            <input type="submit" name="order" class="btn" value="Place Order">
            <br>
            <h3 >Choose Your Address</h3>
     
        </form>
       
       
       
        <!-- Map Container -->
        <div id="map"></div>
    </section>

    <!-- Footer -->
    <?php @include 'footer.php'; ?>

    <!-- Leaflet JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <!-- Your Custom JavaScript -->
    <script src="js/script.js"></script>