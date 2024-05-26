<?php
    include 'config.php';
    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $pass = md5($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
        $cpass = md5($_POST['cpass']);
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
        $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $select->execute([$email]);
        if(!($select->rowCount() > 0)){
            $message[] = 'Email does not exist!';
        }else{
            if($pass != $cpass){
                $message[] = 'confirm password not matched!';
            }else{
                $update = $conn->prepare("UPDATE `users` SET password = ? WHERE email = ?");
                $update->execute([$pass, $email]);
                if($update){
                    $message[] = 'successfully!';
                    header('location: login.php');
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/components.css">
</head>
<body>
    <?php
        if(isset($message)){
            foreach($message as $message){
                echo '
                <div class="message">
                    <span>'.$message.'</span>
                    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                </div>
                ';
            }
        }
    ?>  
    <section class="form-container">
    <form action="" method="POST">
        <h3>forgot password</h3>
        <input type="email" name="email" class="box" placeholder="enter your email" required>
        <input type="password" name="pass" class="box" placeholder="enter your password" required>
        <input type="password" name="cpass" class="box" placeholder="confirm your password" required>
        <input type="submit" value="confirm" class="btn" name="submit">
        <p><a href="login.php">login now</a></p>
    </form>
    </section>
</body>
</html>