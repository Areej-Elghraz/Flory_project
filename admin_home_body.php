
<!-- admins -->
<section class="section brand first" id="dashboard">
    <div class="brand-container container">
        <h4 class="section-subtitle"><i>DashBoard</i></h4>

        <div class="brand-images">
            <?php
                if(isset($_SESSION["super_admin_id"])){
                    $select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
                    $admins = mysqli_num_rows($select_admins);
            ?>
            <div class="brand-image carts">
                <p> Admins_numbers : <span><?php echo $admins; ?></span> </p>
                    <a href="super_admin_admins.php" class="btn">Admins</a>
                    <!-- <a href="admin_users.php" class="btn">Admins</a> -->
            </div>
            <?php
                }
                $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
                $users = mysqli_num_rows($select_users);
            ?>
            <div class="brand-image carts">
                <p> users_numbers : <span><?php echo $users; ?></span> </p>
                <a href="admin_users.php" class="btn">Users</a>
            </div>
            <?php
            $select_accounts = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
            $accounts = mysqli_num_rows($select_accounts);
            if(isset($_SESSION["super_admin_id"])){
            ?>
            <div class="brand-image carts">
                <p> accounts_numbers : <span><?php echo $accounts; ?></span> </p>
                <a href="super_admin_accounts.php" class="btn">Accounts</a>
            </div>
            <?php
                } else {
            ?>
            <div class="brand-image carts">
                <p> accounts_numbers : <span><?php echo $accounts; ?></span> </p>
                <a href="admin_users.php" class="btn">Accounts</a>
            </div>
            <?php
                }
                $select_messages = mysqli_query($conn, "SELECT * FROM `contact_`") or die('query failed');
                $messages = mysqli_num_rows($select_messages);
            ?>
            <div class="brand-image messages">
                <p> messages_numbers : <span><?php echo $messages; ?></span> </p>
                <a href="admin_contacts.php" class="btn">messages</a>
            </div>
            <?php
                $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                $products = mysqli_num_rows($select_products);
            ?>
            <div class="brand-image carts">
                <p> products_numbers : <span><?php echo $products; ?></span> </p>
                <a href="admin_product.php" class="btn">Products</a>
            </div>
            <?php
                $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
                $orders = mysqli_num_rows($select_orders);
            ?>
            <div class="brand-image carts">
                <p> orders_numbers : <span><?php echo $orders; ?></span> </p>
                <a href="admin_orders.php" class="btn">orders</a>
            </div>
        </div>

    </div>
</section>

<!-- Scroll Up -->
<a href="#dashboard" class="scrollUp-btn flex">
    <i class='bx bx-up-arrow-alt scrollUp-icon'></i>
</a>