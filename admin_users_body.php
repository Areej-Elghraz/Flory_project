<?php

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $user_select = mysqli_query($conn, "SELECT * FROM `users` where id = '$delete_id'") 
    or die('query failed!');
    $fetch_user_img = mysqli_fetch_assoc($user_select);
    @unlink('img/'.$fetch_user_img['img']);
    
    mysqli_query($conn, "DELETE FROM `carts` WHERE user_id = '$delete_id'") or die('query failed');
    mysqli_query($conn, "DELETE FROM `orders_products` WHERE user_id = '$delete_id'") or die('query failed');
    mysqli_query($conn, "DELETE FROM `orders` WHERE user_id = '$delete_id'") or die('query failed');
    mysqli_query($conn, "DELETE FROM `contact_` WHERE user_id = '$delete_id'") or die('query failed');
    mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
    header('location: admin_users.php');
}


if(isset($_GET['delete_all_users'])){
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") 
    or die('query failed');
    while($fetch_user = mysqli_fetch_assoc($select_users)){
        $id = $fetch_user['id'];
        $img = $fetch_user['img'];
        
        @unlink('img/'.$img);
        mysqli_query($conn, "DELETE FROM `carts` WHERE user_id = '$id'") or die('query failed');
        mysqli_query($conn, "DELETE FROM `orders_products` WHERE user_id = '$delete_id'") or die('query failed');
        mysqli_query($conn, "DELETE FROM `orders` WHERE user_id = '$id'") or die('query failed');
        mysqli_query($conn, "DELETE FROM `contact_` WHERE user_id = '$id'") or die('query failed');
        mysqli_query($conn, "DELETE FROM `users` WHERE id = '$id'") or die('query failed');
        header("location: admin_users.php");
    }
}

?>
<!-- users -->
<section class="section brand first" id="users">
    <div class="brand-container container">
        <h4 class="section-subtitle"><i>user accounts</i></h4>

        <div class="brand-images">
            <?php
                $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
                if(mysqli_num_rows($select_users)){
                    while($fetch_users = mysqli_fetch_assoc($select_users)){
            ?>
            <div class="brand-image">
                <p> user id : <span><?php echo $fetch_users['id']; ?></span> </p>
                <p> username : <span><?php echo $fetch_users['name']; ?></span> </p>
                <p> email : <span><?php echo $fetch_users['email']; ?></span> </p>
                <p> user type : <span style="color:orange;"><?php echo $fetch_users['user_type']; ?></span> </p>
                <a class="btn" href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="btn">delete user</a>
            </div>
            <?php
                    };
                } else {
                    echo '<h1 class="section-title">no users here!</h1>';
                }
            ?>
        </div>

    </div>

    
</section>

<section class="section">
    <div class="container">
        <a class="btn delete-all-btn" href="admin_users.php?delete_all_users" onclick="return confirm('delete all users?');" >Delete All</a>
    </div>
</section>

<!-- Scroll Up -->
<a href="#users" class="scrollUp-btn flex">
    <i class='bx bx-up-arrow-alt scrollUp-icon'></i>
</a>