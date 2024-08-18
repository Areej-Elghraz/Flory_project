<?php

if(isset($_GET['delete_order'])){
    $order_id = $_GET['delete_order'];
    
    mysqli_query($conn, "DELETE FROM `orders_products` WHERE order_id = '$order_id'") or die('query failed');
    mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$order_id'") or die('query failed');
    
    $messages[] = "deleted successfully!";
    header("location: admin_orders.php");
}


if(isset($_GET['delete_all_orders'])){
    $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
    if(mysqli_num_rows($select_orders) > 0){
        while($fetch_order = mysqli_fetch_assoc($select_orders)){
            $order_id = $fetch_order['id'];
            
            mysqli_query($conn, "DELETE FROM `orders_products` WHERE order_id = '$order_id'") or die('query failed');
            mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$order_id'") or die('query failed');
        }
        $messages[] = "all deleted successfully!";
        // header("location: admin_orders.php");
    }
}

if(isset($_POST['update_order'])){
    $product_id = $_POST['id'];
    $order_statue = $_POST['order_statue'];
    // $prev_order_statue = $_post['prev_order_statue'];

   mysqli_query($conn, "UPDATE `orders` SET order_statue = '$order_statue' WHERE id = '$product_id'") or die('query failed');
    
//    header("location: admin_orders.php");

    $messages[] = "updated successfully!";
}


?>

<!-- Brand Section -->
<section class="section brand first" id="orders">
    <div class="brand-container container">
        <h4 class="section-subtitle"><i>Orders</i></h4>

    <?php
        if(isset($messages)){
            foreach($messages as $msg){
                echo '
                <div class="message section-title" style="color:orange;">
                    <span>'.$msg.'</span>
                    <i class="bx bx-x" onclick="this.parentElement.remove();"></i>
                </div>
                ';
            }
        }
    ?>

        <div class="brand-images">
        <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") 
            or die('query failed');
            if(mysqli_num_rows($select_orders) > 0){
                while($fetch = mysqli_fetch_assoc($select_orders)){
                    $order_id = $fetch['id'];
                    $user_id = $fetch['user_id'];
                    $select_order_products = mysqli_query($conn, "SELECT * FROM `orders_products` WHERE order_id = '$order_id' AND user_id = '$user_id'") 
                        or die('query failed');
                    $product_number = mysqli_num_rows($select_order_products);
        ?>
        
        <form class="brand-image carts" method="post">
            <p class="price">name : <?php echo $fetch['name'];?></p>
            <p class="price">email : <?php echo $fetch['email'];?></p>
            <p class="price">tel number : <?php echo $fetch['tel_number'];?></p>
            <p class="price">nof products : <?php echo $product_number;?></p>
            <p class="price">total price : <?php echo $fetch['total_price'];?> $</p>
            <p class="price">payment method : <?php echo $fetch['payment_method'];?></p>
            <p class="price">address : <?php echo $fetch['address'];?></p>
            <p class="price">city : <?php echo $fetch['city'];?></p>
            <p class="price">country : <?php echo $fetch['country'];?></p>
            <p class="price">pin code : <?php echo $fetch['pin_code'];?></p>
            <p class="price">order statue : 
                <select name="order_statue" id="">
                    <option value="<?php echo $fetch['order_statue'];?>" selected disabled><?php echo $fetch['order_statue'];?></option>
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                </select>
            </p>
            <input type="hidden" value="<?php echo $fetch['id'];?>" name="id">
            <a href="admin_orders.php?delete_order=<?php echo $fetch['id']; ?>" onclick="return confirm('Delete this order from the cart?');" class="btn">delete order</a>
            <!-- <a href="admin_orders.php?delete_orders" onclick="return confirm('deletei this orders?');"  class="btn">Delete All</a> -->
            <input type="submit" class="btn" value="Update" name="update_order" >
        </form>
        <?php
                };
            }else{
                echo '<h1 class="section-title">you have no orders!</h1>';
            }
        ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <!-- <h4 class="section-subtitle">.. CLick here to delete all product in the cart ..</h4> -->
        <a class="btn delete-all-btn" href="admin_orders.php?delete_all_orders" onclick="return confirm('delete all orders?');" >Delete All</a>
    </div>
</section>

<!-- Scroll Up -->
<a href="#orders" class="scrollUp-btn flex">
    <i class='bx bx-up-arrow-alt scrollUp-icon'></i>
</a>