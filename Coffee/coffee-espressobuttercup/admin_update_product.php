<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
   exit();
}

$message = []; // Array to store messages

// Fetch categories from the database
$categories_query = mysqli_query($conn, "SELECT * FROM `categories`") or die('Query failed: ' . mysqli_error($conn));
$categories = mysqli_fetch_all($categories_query, MYSQLI_ASSOC);

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $details = mysqli_real_escape_string($conn, $_POST['details']);
   $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
   $category_id = mysqli_real_escape_string($conn, $_POST['category_id']); // Get selected category ID

   // Check if quantity is within allowed limit
   if($quantity > 100){
      $message[] = 'Quantity cannot exceed 100!';
   } else {
      $update_query = "UPDATE `products` SET name = '$name', details = '$details', price = '$price', quantity = '$quantity', category_id = '$category_id' WHERE id = '$update_p_id'";
      mysqli_query($conn, $update_query) or die('Query failed: ' . mysqli_error($conn));

      $image = $_FILES['image']['name'];
      $image_size = $_FILES['image']['size'];
      $image_tmp_name = $_FILES['image']['tmp_name'];
      $image_folder = 'uploaded_img/'.$image;
      $old_image = $_POST['update_p_image'];

      if(!empty($image)){
         if($image_size > 2000000){
            $message[] = 'Image file size is too large!';
         }else{
            mysqli_query($conn, "UPDATE `products` SET image = '$image' WHERE id = '$update_p_id'") or die('Query failed: ' . mysqli_error($conn));
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('uploaded_img/'.$old_image);
            $message[] = 'Image updated successfully!';
         }
      }

      $message[] = 'Product updated successfully!'; // Update message
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Product</title>

   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="update-product">

<?php
   // Display messages if any
   if(!empty($message)){
      foreach($message as $msg){
         echo '<p class="message">'.$msg.'</p>';
      }
   }

   $update_id = $_GET['update'];
   $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('Query failed');
   if(mysqli_num_rows($select_products) > 0){
      while($fetch_products = mysqli_fetch_assoc($select_products)){
?>

<form action="" method="post" enctype="multipart/form-data">
   <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" class="image" alt="">
   <input type="hidden" value="<?php echo $fetch_products['id']; ?>" name="update_p_id">
   <input type="hidden" value="<?php echo $fetch_products['image']; ?>" name="update_p_image">
   <input type="text" class="box" value="<?php echo $fetch_products['name']; ?>" required placeholder="Update product name" name="name">
   <input type="number" min="0" class="box" value="<?php echo $fetch_products['price']; ?>" required placeholder="Update product price" name="price">
   <textarea name="details" class="box" required placeholder="Update product details" cols="30" rows="10"><?php echo $fetch_products['details']; ?></textarea>
   <input type="number" min="0" class="box" value="<?php echo $fetch_products['quantity']; ?>" required placeholder="Update product quantity" name="quantity">

   <!-- Category dropdown -->
   <select name="category_id" class="box" required>
      <option value="" disabled selected>Select a category</option>
      <?php foreach ($categories as $category) : ?>
         <option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $fetch_products['category_id']) ? 'selected' : ''; ?>>
            <?php echo $category['name']; ?>
         </option>
      <?php endforeach; ?>
   </select>

   <input type="file" accept="image/jpg, image/jpeg, image/png" class="box" name="image">
   <input type="submit" value="Update Product" name="update_product" class="btn">
   <a href="admin_products.php" class="option-btn">Go back</a>
</form>

<?php
      }
   } else {
      echo '<p class="empty">No product selected for update</p>';
   }
?>

</section>

<script src="js/admin_script.js"></script>

</body>
</html>
