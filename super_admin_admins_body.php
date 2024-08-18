<?php

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_users = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$delete_id'") 
        or die('query failed');
    $fetch_delete_users = mysqli_fetch_assoc($delete_users); 
    @unlink('img/'.$fetch_delete_users['img']);
    
    mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
    header('location: super_admin_admins.php');
}


if(isset($_GET['delete_all_admins'])){
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") 
    or die('query failed');
    while($fetch_user = mysqli_fetch_assoc($select_users)){
        $id = $fetch_user['id'];
        $img = $fetch_user['img'];
        @unlink('img/'.$img);
        
        mysqli_query($conn, "DELETE FROM `users` WHERE id = '$id'") or die('query failed');
        header('location: super_admin_admins.php');
    }
}
?>

<!-- admins -->
<section class="section brand first" id="admins">
    <div class="brand-container container">
        <h4 class="section-subtitle"><i>admin accounts</i></h4>

        <div class="brand-images">
            <?php
                $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
                if(mysqli_num_rows($select_users)){
                    while($fetch_users = mysqli_fetch_assoc($select_users)){
            ?>
            <div class="brand-image">
                <p> user id : <span><?php echo $fetch_users['id']; ?></span> </p>
                <p> username : <span><?php echo $fetch_users['name']; ?></span> </p>
                <p> email : <span><?php echo $fetch_users['email']; ?></span> </p>
                <p> user type : <span style="color:red;"><?php echo $fetch_users['user_type']; ?></span> </p>
                <a class="btn" href="super_admin_admins.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="btn">delete user</a>
            </div>
            <?php
                    };
                } else {
                    echo '<h1 class="section-title">no admins here!</h1>';
                }
            ?>
        </div>

    </div>
    
</section>

<section class="section">
    <div class="container">
        <!-- <h4 class="section-subtitle">.. CLick here to delete all product in the cart ..</h4> -->
        <a class="btn delete-all-btn" href="super_admin_admins.php?delete_all_admins" onclick="return confirm('delete all admins?');" >Delete All</a>
    </div>
</section>

<!-- Scroll Up -->
<a href="#add_user" class="scrollUp-btn flex">
    <i class='bx bx-up-arrow-alt scrollUp-icon'></i>
</a>