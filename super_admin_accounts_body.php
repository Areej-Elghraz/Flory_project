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
    header('location: super_admin_accounts.php');
}


if(isset($_GET['delete_all_accounts'])){
    $select_users = mysqli_query($conn, "SELECT * FROM `users`") 
    or die('query failed');
    while($fetch_user = mysqli_fetch_assoc($select_users)){
        $id = $fetch_user['id'];
        $img = $fetch_user['img'];
        
        @unlink('img/'.$img);
        mysqli_query($conn, "DELETE FROM `carts` WHERE user_id = '$id'") or die('query failed');
        mysqli_query($conn, "DELETE FROM `orders_products` WHERE user_id = '$id'") or die('query failed');
        mysqli_query($conn, "DELETE FROM `orders` WHERE user_id = '$id'") or die('query failed');
        mysqli_query($conn, "DELETE FROM `contact_` WHERE user_id = '$id'") or die('query failed');
        mysqli_query($conn, "DELETE FROM `users` WHERE id = '$id'") or die('query failed');
        header("location: super_admin_accounts.php");
    }
}

if(isset($_POST['send'])){
    
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'img/'.$image;
    // $user_type = $_POST['user_type'];
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = $_POST['email'];
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['confirm_password']));
    // $admin_id = $_SESSION['admin_id'];

    
    if($pass !== $cpass){
        $message[] = 'passwords are not the same!';
    } else {
        $select_product = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'")  or die('query failed');
        if(mysqli_num_rows($select_product) > 0){
            $message[] = 'this account already exist!';
        } else {
            if(isset($image)){
                if(!empty($image)){
                    mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type, img) VALUES('$name', '$email', '$cpass', '$user_type', '$image')")
                        or die('query failed');
                    move_uploaded_file($image_tmp_name, $image_folder);
                        $message[] = 'registered with successfully!';
                } else {
                    mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type, img) VALUES('$name', '$email', '$cpass', '$user_type', 'constant/unknown_man.jpg')") or die('query failed');
                    $message[] = 'registered with out successfully!';
                }
            } else {
                mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type, img) VALUES('$name', '$email', '$cpass', '$user_type', 'constant/unknown_man.jpg')") or die('query failed');
                $message[] = 'registered without successfully!';
            }
                // header('location: index.php');
        }
    }
}
?>



<!-- add admins -->
<section class="section brand product" id="add_user">
    <h4 class="section-subtitle"><i>Add admins</i></h4>
    <?php
        if(isset($message)){
            foreach($message as $msg){
                echo '
                <div class="message section-title" style="color:orange;">
                    <span>'.$msg.'</span>
                    <i class="bx bx-x" onclick="this.parentElement.remove();"></i>
                </div>
                ';
            }
        }
    ?>
    <!-- <div class="pro-container"> -->
  <form action="" method="post" class="pro-form input-box" enctype="multipart/form-data">
    <!-- <div class="input-box"> -->
        <div class="sec">
            <input type="text" class="prod-input left" name="name" placeholder="Username" required>
            <input type="email" class="prod-input right" name="email" placeholder="Email" required>
        </div>
        <div class="sec">
            <input type="password" class="prod-input left" placeholder="Password" name="password" required>
            <input type="password" class="prod-input right" placeholder="Confirm Password" name="confirm_password" required>
        </div>
        <div class="sec">
            <input type="file" name="image" id="image" class="prod-input email left" value="Choose Image">
            <select name="user_type" id="depart" class="prod-input name right" required>
                <option selected value="admin">admin</option>
                <option value="user">user</option>
            </select>
            <!-- <input type="text" name="depart" id="depart" class="prod-input name left" required placeholder="Department"> -->
        </div>
        <div class="sec">
            <button type="submit" name="send" class="prod-button submit left" id="send">
                submit
            </button>
            <button type="reset" class="prod-button reset right" id="reset">
                reset
            </button>
        </div>
      <!-- </div> -->
    </form>
  <!-- </div> -->
</section>


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
                <a class="btn" href="super_admin_accounts.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="btn">delete user</a>
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
        <a class="btn" href="super_admin_accounts.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="btn">delete user</a>
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
        <a class="btn delete-all-btn" href="super_admin_accounts.php?delete_all_accounts" onclick="return confirm('delete all users?');" >Delete All</a>
    </div>
</section>

<!-- Scroll Up -->
<a href="#admins" class="scrollUp-btn flex">
    <i class='bx bx-up-arrow-alt scrollUp-icon'></i>
</a>