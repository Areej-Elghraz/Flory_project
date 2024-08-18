<?php
require 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === 'POST'){

    // mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type, img) VALUES('reeja', 'reeja@gmail.com', 'reeja111', 'admin', 'unknown_man.jpg')") or die('query failed');

if(isset($_POST['submit'])){
    
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    $user_type = $_POST['user_type'];
    $img = $_FILES['img']['name'];
    $img_size = $_FILES['img']['size'];
    $img_tmp_name = $_FILES['img']['tmp_name'];
    $img_file = 'img/'.$img;
    
    if($pass !== $cpass){
        $message[] = 'confirm password not matched!';
    }else{
       $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');
        if(mysqli_num_rows($select_users) > 0){
            $message[] = 'user already exist!';
        }else{
        if(isset($img)){
            if(!empty($img)){
                mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type, img) VALUES('$name', '$email', '$cpass', '$user_type', '$img')")
                    or die('query failed');
                move_uploaded_file($img_tmp_name, $img_file);
            } else {
                mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type, img) VALUES('$name', '$email', '$cpass', '$user_type', 'constant/unknown_man.jpg')") or die('query failed');
            }
        $message[] = 'registered successfully!';
        // header('location: index.php');
    }
    }
}
}


if(isset($_POST['submit_login'])){
    
   $email_login = mysqli_real_escape_string($conn, $_POST['email_login']);
   $pass_login = mysqli_real_escape_string($conn, md5($_POST['password_login']));

   $admin_email = "admin@gmail.com";
   $admin_password = "admin";
   
   if($admin_email === $_POST['email_login'] and $admin_password === $_POST['password_login']){
       
       $_SESSION['super_admin_email'] = "admin@gmail.com";
       $_SESSION['super_admin_name'] = "Admin";
       $_SESSION['super_admin_img'] = "constant/unknown_man.jpg";
       $_SESSION['super_admin_id'] = 200000;
        header('location: super_admin_home.php');
    } else {
        
        $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email_login' AND password = '$pass_login'")
        or die('query failed');
        
        if(mysqli_num_rows($select_users) > 0){
            
            $row = mysqli_fetch_assoc($select_users);
            
            if($row['user_type'] === 'admin'){
                
                $_SESSION['admin_email'] = $row['email'];
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['admin_img'] = $row['img'];
                $_SESSION['admin_id'] = $row['id'];
                header('location: admin_home.php');
                
            }elseif($row['user_type'] === 'user'){
                
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_img'] = $row['img'];
                $_SESSION['user_id'] = $row['id'];
                header('location: captcha.php');
              

        }
    

    }else{
        $message_login[] = 'incorrect email or password!';
    }
  }
 }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/registeration_style.css">
    <title id="title">Modern Login Page</title>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="" method="post" enctype="multipart/form-data">
                <h1 id="h">Create Account</h1>
                <div class="social-icons">
                    <a class="icon" href="https://www.facebook.com/profile.php?id=100063497674729&mibextid=ZbWKwL"><i class='bx bxl-facebook'></i></a>
                    <a class="icon" href="https://twitter.com/ElGhraz96581?t=7ZKP1yAxJFojnMaYaRx67Q1&s=03"><i class='bx bxl-twitter' ></i></a>
                    <a class="icon" href="https://instagram.com/_esraa.elfar?igshid=NGVhN2U2NjQ0Yg=="><i class='bx bxl-instagram-alt' ></i></a>
                    <a class="icon" href="https://chat.whatsapp.com/H0K3dkjwIXIGWWoGxe44FY"><i class='bx bxl-whatsapp' ></i></a>
                </div>
                <span id="a">or use your email for registeration</span>
                <input required type="text" name="name" class="in" id="user_name" placeholder="User Name">
                <input required type="email" name="email" class="in" id="email" placeholder="Email">
                <input required type="password" name="password" class="in" id="password" placeholder="Password">
                <input required type="password" name="cpassword" class="in" id="confirm_password" placeholder="Confirm Password">
                <input type="file" name="img" class="in" id="img" placeholder="Choose Profile Photo">
                <!-- <input required type="" name="cpassword" class="in" placeholder="Confirm Password"> -->
                <select name="user_type" id="selecr" class="in" hidden>
                    <option id="user"value="user" selected >User</option>
                    <option id="admin"value="admin">Admin</option>
                </select>
                <input type="submit" name="submit" id="signup" value="Sign Up" class="btn"> 
                <!-- <button formaction="index.php">Sign Up</button> -->
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="" method="post">
                <h1 id="logn">logIn</h1>
                <div class="social-icons">
                    <a class="icon" href="https://www.facebook.com/profile.php?id=100063497674729&mibextid=ZbWKwL"><i class='bx bxl-facebook'></i></a>
                    <a class="icon" href="https://twitter.com/ElGhraz96581?t=7ZKP1yAxJFojnMaYaRx67Q&s=03"><i class='bx bxl-twitter' ></i></a>
                    <a class="icon" href="https://instagram.com/_esraa.elfar?igshid=NGVhN2U2NjQ0Yg=="><i class='bx bxl-instagram-alt' ></i></a>
                    <a class="icon" href="https://chat.whatsapp.com/H0K3dkjwIXIGWWoGxe44FY"><i class='bx bxl-whatsapp' ></i></a>
                </div>
                <span id="use">or use your email password</span>
                <?php
                    if(isset($message)){
                        foreach($message as $message){
                            echo '
                                <div class="message" style="color:orange;">
                                    <span>'.$message.'</span>
                                    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                                </div>
                            ';
                        }
                    }
                ?>
                <?php
                    if(isset($message_login)){
                        foreach($message_login as $message_login){
                            echo '
                            <div class="message" style="color:orange;">
                                <span>'.$message_login.'</span>
                                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                            </div>
                            ';
                        }
                    }
                ?>
                <input required type="email" name="email_login" class="in"id="l_email" placeholder="Email">
                <input required type="password" name="password_login" class="in" id="l_pass" placeholder="Password">
                <!-- <a href="#">Forget Your Password?</a> -->
                <input type="submit" name="submit_login" id="log" value="LogIn" class="btn"> 
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1 id="wel">Welcome Back!</h1>
                    <p id="p">Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">logIn</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1 id="hel">Hello, Friend!</h1>
                    <p id="reg">Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script src="js/registeration_script.js"></script>
</body>

</html>