<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_order'])){
   $order_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];

   if ($update_payment == 'completed') {
      $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);
      $update_orders = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
      $update_orders->execute([$update_payment, $order_id]);
      $message[] = 'payment has been updated!';
   
      $total_products = $_POST['total_products'];
      $arr1 = explode(",", $total_products);
      $allSubelements = array();
      foreach ($arr1 as $element) {
         $element = trim($element);
         $arr2 = explode("kg ", $element);
         $currentSubelements = array();
         foreach ($arr2 as $subelement) {
            $currentSubelements[] = $subelement;
         }
         $allSubelements[] = $currentSubelements;
      }
      for ($i = 0; $i < count($allSubelements); $i++) {
         $stmt = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
         $stmt->execute([$allSubelements[$i][1]]);
         if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $invent = $row['inventories'];
            $sold = $row['sold'];
            $update_inventories = $conn->prepare("UPDATE `products` SET inventories = ? WHERE name = ?");
            $newInventories = $invent-$allSubelements[$i][0];
            $update_inventories->execute([$newInventories,$allSubelements[$i][1]]);
            $update_sold = $conn->prepare("UPDATE `products` SET sold = ? WHERE name = ?");
            $newSold = $sold+$allSubelements[$i][0];
            $update_sold->execute([$newSold,$allSubelements[$i][1]]);
         }   
      }
   }

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_orders->execute([$delete_id]);
   header('location:admin_orders.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="placed-orders">
   <h1 class="title">placed orders</h1>

   <div class="box-container">

      <?php
         $select_orders = $conn->prepare("SELECT * FROM `orders`");
         $select_orders->execute();
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box">
         <p> user id : <span><?= $fetch_orders['user_id']; ?></span> </p>
         <p> placed on : <span><?= $fetch_orders['placed_on']; ?></span> </p>
         <p> name : <span><?= $fetch_orders['name']; ?></span> </p>
         <p> email : <span><?= $fetch_orders['email']; ?></span> </p>
         <p> number : <span><?= $fetch_orders['number']; ?></span> </p>
         <p> address : <span><?= $fetch_orders['address']; ?></span> </p>
         <p> total products : <span><?= $fetch_orders['total_products']; ?></span> </p>
         <p> total price : <span>$<?= $fetch_orders['total_price']; ?>/-</span> </p>
         <p> payment method : <span><?= $fetch_orders['method']; ?></span> </p>
         <form action="" method="POST">
            <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
            <input type="hidden" name="total_products" value="<?= $fetch_orders['total_products']; ?>">
            <select name="update_payment" class="drop-down">
               <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
               <option value="pending">pending</option>
               <option value="completed">completed</option>
            </select>
            <div class="flex-btn">
               <?php
                  if ($fetch_orders['payment_status'] == 'completed') {
                     $disabled = 'disabled';
                  } else {
                     $disabled = '';
                  }
               ?>
               <input type="submit" name="update_order" class="option-btn" value="update" <?php echo $disabled; ?>>
               <a href="admin_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
            </div>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
      ?>

   </div>

</section>












<script src="js/script.js"></script>

</body>
</html>