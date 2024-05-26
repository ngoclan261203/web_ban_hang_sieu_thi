<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="about">

   <div class="row">
      <div class="box">
         <span style="font-size: 50px;">D3Market was founded in 1980s</span><br><br>
         <span style="font-size: 30px;">D3Market provides food lines taken from standard farms in Vietnam as well as around the world. Our products are diverse from vegetables, fruits, meat, eggs, milk, seafood,....</span><br><br>
         <a href="contact.php" class="btn">contact us</a>
         <a href="shop.php" class="btn">our shop</a>
      </div>   
   </div>

</section>

<section class="reviews">

   <h1 class="title">clients reviews</h1>

   <div class="box-container">

      <div class="box">
         <img src="./images/duybeo.jpg" alt="">
         <p>sản phẩm chất lượng, tuyệt vời. Nhất định sẽ quay lại.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
         </div>
         <h3>Duy Beo</h3>
      </div>

      <div class="box">
         <img src="./images/duybeo.jpg" alt="">
         <p>chất lượng sản phẩm tốt, không thể chê vào đâu được.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Duy Gay</h3>
      </div>

      <div class="box">
         <img src="./images/duybeo.jpg" alt="">
         <p>good, tôi sẽ ủng hộ và giới thiệu tới gia đình và bạn bè.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Tran Dat</h3>
      </div>

      <div class="box">
         <img src="./images/duybeo.jpg" alt="">
         <p>trải nghiệm mua hàng quá tốt, tôi sẽ tiếp tục tin tưởng Dat fresh food trong tương lai</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Duc Dz</h3>
      </div>

      <div class="box">
         <img src="./images/duybeo.jpg" alt="">
         <p>ờ mây zing, gút chóp. Tôi đã ăn hết cả 1 thùng cà chua vì quá ngon.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Duy Hai Neo</h3>
      </div>

      <div class="box">
         <img src="./images/duybeo.jpg" alt="">
         <p>Messi es el mejor jugador del mundo. Bay-co no hay edad.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Messi's fan</h3>
      </div>

   </div>

</section>









<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>