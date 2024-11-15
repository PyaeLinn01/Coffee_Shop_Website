<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('Location: login.php');
    exit();
}

// Ensure the connection is established
if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php @include 'header.php'; ?>

<section class="heading">
    <h3>Your Orders</h3>
    <p><a href="home.php">Home</a> / Orders</p>
</section>

<section class="placed-orders">

    <h1 class="title">Placed Orders</h1>

    <div class="box-container">
    <?php
        $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('Query failed');
        if (mysqli_num_rows($select_orders) > 0) {
            while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
    ?>
    <div class="box">
        <p>Placed on: <span><?php echo htmlspecialchars($fetch_orders['placed_on']); ?></span></p>
        <p>Name: <span><?php echo htmlspecialchars($fetch_orders['name']); ?></span></p>
        <p>Number: <span><?php echo htmlspecialchars($fetch_orders['number']); ?></span></p>
        <p>Address: <span><?php echo htmlspecialchars($fetch_orders['address']); ?></span></p>
        <p>Payment method: <span><?php echo htmlspecialchars($fetch_orders['method']); ?></span></p>
        <p>Your orders: <span><?php echo htmlspecialchars($fetch_orders['total_products']); ?></span></p>
        <p>Total price: <span>$<?php echo htmlspecialchars($fetch_orders['total_price']); ?>/-</span></p>
        <p>Status: <span style="color:<?php echo $fetch_orders['payment_status'] === 'pending' ? 'tomato' : 'green'; ?>"><?php echo htmlspecialchars($fetch_orders['payment_status']); ?></span></p>

       <!-- <?php if ($fetch_orders['method'] === 'credit card'): ?>
            <p>Card number: <span><?php echo htmlspecialchars($fetch_orders['card_number']); ?></span></p>
            <p>Expiry date: <span><?php echo htmlspecialchars($fetch_orders['expiry_date']); ?></span></p>
            <p>CVV: <span><?php echo htmlspecialchars($fetch_orders['cvv']); ?></span></p>
        <?php endif; ?> -->

    </div>
    <?php
            }
        } else {
            echo '<p class="empty">No orders placed yet!</p>';
        }
    ?>
    </div>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
