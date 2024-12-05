<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['add_to_wishlist'])) {

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_wishlist_numbers) > 0) {
        $message[] = 'already added to favorites';
    } elseif (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'to cart';
    } else {
        mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
        $message[] = 'product added to favorites';
    }
}

if (isset($_POST['add_to_cart'])) {

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    // Fetch the current stock of the product
    $fetch_stock = mysqli_query($conn, "SELECT quantity FROM `products` WHERE id = '$product_id'") or die('query failed');
    $fetch_stock_data = mysqli_fetch_assoc($fetch_stock);
    $current_stock = $fetch_stock_data['quantity'];

    // Ensure the product quantity doesn't exceed the stock
    $product_quantity = min($product_quantity, $current_stock);

    // Check if the product is already in the cart
    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE pid = '$product_id' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        // Product is already in the cart, update the quantity
        $fetch_cart_data = mysqli_fetch_assoc($check_cart_numbers);
        $existing_quantity = $fetch_cart_data['quantity'];
        $new_quantity = $existing_quantity + $product_quantity;

        // Update the cart with the new quantity, ensuring it doesn't exceed the stock
        mysqli_query($conn, "UPDATE `cart` SET quantity = '$new_quantity' WHERE pid = '$product_id' AND user_id = '$user_id'") or die('query failed');
    } else {
        // Product is not in the cart, add it
        $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

        if (mysqli_num_rows($check_wishlist_numbers) > 0) {
            mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
        }

        // Add the product to the cart
        mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
    }

    // Update the stock in the products table
    $new_stock = $current_stock - $product_quantity;
    mysqli_query($conn, "UPDATE `products` SET quantity = '$new_stock' WHERE id = '$product_id'") or die('query failed');

    $message[] = 'product added to cart';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shop</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
        .out-of-stock {
            color: #fff; /* White text color */
            background-color: #f00; /* Red background color */
            font-size: 1.5em; /* Larger font size */
            font-weight: bold; /* Bold text */
            text-align: center; /* Center align text */
            padding: 10px; /* Add padding */
            border-radius: 5px; /* Rounded corners */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Optional: Add shadow for better visibility */
        }

        .items-left {
            color: #000; /* Black text color for better readability */
            font-size: 1.2em; /* Slightly larger font size */
            font-weight: bold; /* Bold text */
            text-align: center; /* Center align text */
            padding: 8px; /* Add padding */
        }
    </style>
</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>Our Shop</h3>
    <p> <a href="home.php">Home</a> / Shop </p>
</section>

<section class="products">

      <h1 class="title">All Items</h1>

      <div class="box-container">

         <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
         ?>
               <form action="" method="POST" class="box">
                  <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="fas fa-eye"></a>
                  <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
                  
                  <!-- Show 'items left' with the new class -->
                  <div class="items-left"><?php echo $fetch_products['quantity'] . " items left."; ?></div>

                  <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
                  <div class="name"><?php echo $fetch_products['name']; ?></div>

                  <?php if ($fetch_products['quantity'] > 0): ?>
                     <input type="number" name="product_quantity" value="1" min="1" max="<?php echo $fetch_products['quantity']; ?>" class="qty">
                     <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                     <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                     <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                     <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                     <input type="submit" value="add to favorites" name="add_to_wishlist" class="option-btn">
                     <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                  <?php else: ?>
                     <div class="out-of-stock">Out of stock</div>
                  <?php endif; ?>
               </form>

         <?php
            }
         } else {
            echo '<p class="empty">No products added yet!</p>';
         }
         ?>

      </div>

      <div class="more-btn">
         <a href="shop.php" class="option-btn">Load More</a>
      </div>

   </section>

   <?php @include 'footer.php'; ?>

   <script src="js/script.js"></script>

</body>
</html>
