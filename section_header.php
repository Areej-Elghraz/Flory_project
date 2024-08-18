<?php

require 'config.php';
session_start();

// chick login account
$user_id = $_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
   header('location: index.php');
}

// check cart
if(isset($_POST['add_to_cart'])){
     $quantity = $_POST['quantity'];
     $product_id = $_POST['image'];
     $user_id = $_SESSION['user_id'];

$select = mysqli_query($conn, "SELECT * FROM `carts` WHERE user_id = '$user_id' AND product_id = '$product_id'");

if(mysqli_num_rows($select) > 0){
     $_message[] = 'this product aleady in the cart!';
} else {
     mysqli_query($conn, "INSERT INTO `carts`(user_id, product_id, quantity)
               VALUES('$user_id', '$product_id', '$quantity')");
     $_message[] = 'added in the cart successfully!';
}
$_SESSION['mesg'] = $_message;
}

// show more in shopping
if(isset($_GET['more_products'])){
     $_SESSION['department_type'] = $_GET['more_products'];
     header("location: section.php");
}

// delet from carts
if(isset($_GET['delete'])){
     $user_id = $_SESSION['user_id'];
     $product_id = $_GET['delete'];
     mysqli_query($conn, "DELETE FROM `carts` WHERE product_id = '$product_id' AND user_id = '$user_id'") 
     or die('query failed');
header("location: cart.php");
}

// delete all carts
if(isset($_GET['delete_all_from_cart'])){
     $user_id = $_SESSION['user_id'];
     mysqli_query($conn, "DELETE FROM `carts` WHERE user_id = '$user_id'") 
       or die('query failed');
     header("location: cart.php");
}

// update carts
if(isset($_POST['update'])){
     $user_id = $_SESSION['user_id'];
     $product_id = $_POST['id'];
     $quantity = $_POST['quantity'];

mysqli_query($conn, "UPDATE `carts` SET quantity = '$quantity' WHERE product_id = '$product_id' AND user_id = '$user_id'") 
     or die('query failed');
}

if(! isset($_SESSION['department_type'])){
     header("shopping.php");
} else {
     header("section.php");
}

// input order information
if(isset($_POST['orders'])){
     $_SESSION['total_price'] = $_POST['total_price'];
     header("location: order in.php");
}

// order informatoin insertion
if($_SERVER["REQUEST_METHOD"] === 'POST'){
     if(isset($_POST['order'])){
          $name = mysqli_real_escape_string($conn, $_POST['name']);
          $email = mysqli_real_escape_string($conn, $_POST['email']);
          $number = $_POST['number'];
          $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
          $address = mysqli_real_escape_string($conn, $_POST['address']);
          $city = mysqli_real_escape_string($conn, $_POST['city']);
          $country = mysqli_real_escape_string($conn, $_POST['country']);
          $pin_code = $_POST['pin_code'];
          $user_id = $_SESSION['user_id'];
          
          $total_price = $_POST['total_price'];
          
     if($total_price > 0){
          // echo "right";
          // $select = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'");
          
          // $order_num = mysqli_num_rows($select);
          
          mysqli_query($conn, "INSERT INTO `orders`(name, email, tel_number, total_price, payment_method, address, city, country, pin_code, user_id)
                         VALUES('$name', '$email', '$number', '$total_price', '$payment_method', '$address', '$city', '$country', '$pin_code', '$user_id')") or die("failt query!");
          
          $select_orders = mysqli_query($conn, "SELECT id FROM `orders` WHERE user_id = '$user_id'");
          while ($fetch_order = mysqli_fetch_assoc($select_orders)){
               $order_id = $fetch_order['id'];
          }
          $select_orders = mysqli_query($conn, "SELECT product_id FROM `carts`");
          while ($fetch_order = mysqli_fetch_assoc($select_orders)){
               $product_id = $fetch_order['product_id'];
               mysqli_query($conn, "INSERT INTO `orders_products`(order_id, product_id, user_id) VALUES('$order_id', '$product_id','$user_id')")
                    or die("failt query!");
          }


          mysqli_query($conn, "DELETE FROM `carts` WHERE user_id = '$user_id'");

          // $_SESSION['orders'] = $order_num;

          $messeges[] = "Ordered successfully!";
          $_SESSION['mmsg1'] = $messeges;
          header("location: orders.php");
     } else {
          // echo "left";
          $messeges[] = "Sorry cart is empty!";
          $_SESSION['mmsg1'] = $messeges;
          // header("location: orders.php");
     }
     }
 }
 
?>

<!DOCTYPE html>
<!-- Coding by CodingLab | www.codinglabweb.com  -->
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Department</title>

     <!-- Swiper JS CSS-->
     <link rel="stylesheet" href="css/swiper-bundle.min.css">

     <!-- Scroll Reveal -->
     <link rel="stylesheet" href="css/scrollreveal.min.js">

     <!-- Boxicons -->
     <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
          
     <!-- CSS -->
     <link rel="stylesheet" href="css/shopping_style.css">

</head>
<body>
<!-- Header -->
<header class="header" id="header">
     <nav class="nav container flex">
               <a href="#" class="logo-content flex">
               <i class='bx bxs-florist logo-icon'></i>
               <span class="logo-text" id="logo">Flory.</span>
               </a>

               <div class="menu-content">
                    <ul class="menu-list flex">                         

                         <li><a href="home.php" class="nav-link active-navlink" id="hom">home</a></li>
                         <li><a href="home.php#about" class="nav-link" id="abou">about</a></li>
                         <li><a href="home.php#review" class="nav-link" id="rev">reviews</a></li>
                         <li><a href="#departments" class="nav-link depart" id="depart">departments</a> <span id="span">^</span> </li>
                         <li><a href="shopping.php" class="nav-link" id="shop">shopping</a></li>
                         <li><a href="contact.php" class="nav-link" id="contact">contact</a></li>

                         
                    </ul>
                    <ul class="subnav" id="subnav">

                         <?php
                              $select_groups = mysqli_query($conn, "SELECT department_type FROM `products` GROUP BY department_type;")
                                   or die('query failed');
                              if(mysqli_num_rows($select_groups) > 0){
                              while($fetch_group = mysqli_fetch_assoc($select_groups)){
                                   $department = $fetch_group['department_type'];

                         ?>
                         
                              <li><a href="shopping.php#<?php echo $department;?>" class="nav-link" id="ov"><?php echo $department;?></a></li>
                         <?php
                              } 
                         } else {
                         ?> 
                              <li><a href="shopping.php" class="nav-link" id="ov">Nothing</a></li>
                         <?php
                          }
                         ?>
                    </ul>
                    
                    <div class="media-icons flex">
                              <a href="https://www.facebook.com"><i class='bx bxl-facebook'></i></a>
                              <a href="https://twitter.com/i/flow/login"><i class='bx bxl-twitter' ></i></a>
                              <a href="https://www.instagram.com/accounts/login"><i class='bx bxl-instagram-alt' ></i></a>
                              <a href="https://github.com/login"><i class='bx bxl-github'></i></a>
                              <a href="https://www.youtube.com/login"><i class='bx bxl-youtube'></i></a>
                    </div>
                    
                    <i class='bx bx-x navClose-btn'></i>
               </div>
               <div class="login-content flex">
                    
                    <a href="shopping.php#search" id="search-icon">
                              <i class='bx bx-search-alt'></i>    
                    </a>
                    
                    <a href="cart.php">
                              <?php
                              $user_id = $_SESSION["user_id"];
                              $select_cart = mysqli_query($conn, "SELECT * FROM `carts` WHERE user_id = '$user_id'")
                                   or die("select failed!");
                              ?>
                              <span class="login-text"> <i class='bx bx-cart-alt'></i> [ <?php echo mysqli_num_rows($select_cart);?> ] </span>
                    </a>
                    
                    <i class='bx bx-user-circle login-icon' id="login-icon"></i>
                    <i class='bx bx-menu navOpen-btn'></i>
               </div>
               <div class="user-box">
                    <div class="user-img-container">
                              <img src="img/<?php echo isset($user_id)? $_SESSION['user_img'] : 'constant/unknown_man.php';?>" alt="<?php echo $_SESSION['user_img'];?>" class="user-img">
                    </div>
                    <p id="user">username : <span><?php echo $_SESSION['user_name']; ?></span></p>
                    <p id="email">email : <span><?php echo $_SESSION['user_email']; ?></span></p>
                    <a href="logout.php" class="delete-btn" id="out">Logout</a>
                    <a href="index.php">
                              <span class="login-text"> Login | SignUp</span>
                    </a>
               </div>
     </nav>
               
     </header>
<main>

