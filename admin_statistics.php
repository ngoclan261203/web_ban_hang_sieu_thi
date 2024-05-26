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
      $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);
      $update_orders = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
      $update_orders->execute([$update_payment, $order_id]);
      $message[] = 'payment has been updated!';
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
   <title>statistics</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

   <style>
      .box {
         overflow-x: auto;
         background-color: white;
      }
      .table {
         width: 100%;
         border-collapse: collapse;
         font-size: 16px;
      }
      .table th, .table td {
         padding: 8px;
         text-align: left;
         border: 1px solid #ddd;
         font-size: 16px; 
      }
      .table th {
         background-color: #f2f2f2;
         font-size: 18px;
      }
   </style>

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="placed-orders">

   <h1 class="title">Statistics on import/export quantity</h1>

   <div class="box">
      <table class="table">
         <thead>
            <tr>
               <th scope="col">#</th>
               <th scope="col">Product name</th>
               <th scope="col">Price per kg</th>
               <th scope="col">Sold quantities</th>
               <th scope="col">Inventories</th>
               <th scope="col">Revenue</th>
            </tr>
         </thead>
      <?php
         $stmt = $conn->prepare("SELECT * FROM `products`");
         $query = $stmt->execute();
         if($query) {
            $count = 0;
            $revenue = 0;
            $total_revenue = 0;
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      ?>
         <tbody>
            <tr>
               <th scope="row"><?php echo ++$count ?></th>
               <td><?php echo $row['name']?></td>
               <td><?php echo $row['price']?></td>
               <td><?php echo $row['sold']?></td>
               <td><?php echo $row['inventories']?></td>
               <?php
                  $revenue = $row['sold']*$row['price'];
                  $total_revenue += $revenue;
               ?>
               <td style="background-color:yellow;"><?php echo $revenue."$"?></td>
            </tr>
         </tbody>
      <?php
            }
         }
      ?>
      </table>
         <h1 style="float:right; font-size:30px;">Total revenue: <?php echo $total_revenue;?>$</h1>
   </div><br>

   <div class="box" style="width:500px;">
      <table class="table">
         <thead>
            <tr>
               <th scope="col">Day/month/year</th>
               <th scope="col">Revenue</th>
               <th scope="col"></th>
            </tr>
         </thead>
         <tbody>
         <?php
            $day = '';
            $month = '';
            $year = '';
            $required = '';
            $search_option = ['search_option'];
            if (isset($_POST['search'])) {
               $day = $_POST['day'];
               $month = $_POST['month'];
               $year = $_POST['year'];
            }
            $sql = "SELECT SUM(total_price) AS total_revenue FROM `orders` WHERE placed_on LIKE '%{$day}/{$month}/{$year}%'";
            if ($month != '' && $year != '' ) {
               $sql = "SELECT SUM(total_price) AS total_revenue FROM `orders` WHERE placed_on LIKE '%{$month}/{$year}%'";
            } else if ($year != '') {
               $sql = "SELECT SUM(total_price) AS total_revenue FROM `orders` WHERE placed_on LIKE '%{$year}%'";
            } else if ($day != '' && $month != '' && $year != '') {
               $sql = "SELECT SUM(total_price) AS total_revenue FROM `orders` WHERE placed_on LIKE '%{$day}/{$month}/{$year}%'";
            }
            if ($day != '' && $month == '' ) {
               $required = 'required';
            }
            $stmt = $conn->prepare($sql);
            $query = $stmt->execute();
            if($query) {
               $row = $stmt->fetch(PDO::FETCH_ASSOC);
               $revenue = $row['total_revenue'];
         ?>
            <tr>
               <td style="width:20%;">
                  <form method="POST">
                     <input type="text" value="<?= $day; ?>" name="day" id="day" style="border: 1px solid black; font-size:20px; width: 40px;">
                     <input type="text" <?php echo $required;?> value="<?= $month; ?>" name="month" id="month" style="border: 1px solid black; font-size:20px; width: 40px;">
                     <input type="text" required value="<?= $year; ?>" name="year" id="year" style="border: 1px solid black; font-size:20px; width: 60px;">
                     <td style="background-color:yellow;width:20%;"><?php echo $revenue.'$';?></td>
                     <td style="width:10%;">
                        <input class="delete-btn" type="submit" name="search" value="Search"></input>
                     </td>
                  </form>
               </td>
            </tr>
         </tbody>
      </table>
      <?php
         }
      ?>
   </div>
</section>
<script src="js/script.js"></script>

</body>
</html>