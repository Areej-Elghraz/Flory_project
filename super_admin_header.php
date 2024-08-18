<?php
require 'config.php';
session_start();
?>

<!DOCTYPE html>
<!-- Coding by CodingLab | www.codinglabweb.com  -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="pro">Product</title>

    <!-- Swiper JS CSS-->
    <link rel="stylesheet" href="css/swiper-bundle.min.css">

    <!-- Scroll Reveal -->
    <link rel="stylesheet" href="css/scrollreveal.min.js">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <!-- CSS -->
    <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
<!-- Header -->
    <header class="header">
        <nav class="nav container flex">
                <a href="#" class="logo-content flex">
                <i class='bx bxs-florist logo-icon'></i>
                <span class="logo-text">Flory.</span>
                </a>

        <div class="menu-content">
                <ul class="menu-list flex">
                <li><a href="super_admin_home.php" class="nav-link">Home</a></li>
                <li><a href="super_admin_users.php" class="nav-link">Users</a></li>
                <li><a href="super_admin_admins.php" class="nav-link">Admins</a></li>
                <li><a href="super_admin_contacts.php" class="nav-link">Messages</a></li>
                <li><a href="super_admin_product.php" class="nav-link">Products</a></li>
                <li><a href="super_admin_orders.php" class="nav-link">Orders</a></li>
                <li><a href="super_admin_accounts.php" class="nav-link">Accounts</a></li>
                </ul>
                        
                        <i class='bx bx-x navClose-btn'></i>
                </div>
                
                <div class="contact-content flex">
                        
                        <i class='bx bx-user-circle login-icon' id="login-icon"></i>
                        <i class='bx bx-menu navOpen-btn'></i>
                </div>
                <div class="user-box">
                        <div class="user-img-container">
                                <img src="img/<?php echo $_SESSION['super_admin_img'];?>" alt="<?php echo $_SESSION['super_admin_img'];?>" class="user-img">
                        </div>
                        <p>username : <span><?php echo $_SESSION['super_admin_name']; ?></span></p>
                        <p>email : <span><?php echo $_SESSION['super_admin_email']; ?></span></p>
                        <a href="logout.php" class="delete-btn">Logout</a>
                        <a href="index.php">
                                <span class="login-text"> Login | SignUp</span>
                        </a>
                </div>  
        </nav>
    </header>

<!-- Home Section -->
<main>
        
    