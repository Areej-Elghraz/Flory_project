<?php
    require "section_header.php";
?>

<!-- Brand Section -->
<section class="section brand" id="order">
    <div class="brand-container container">
        
        <h4 class="section-subtitle cart"><i>Your Orders</i></h4>
        <div class="brand-images">
            <?php
                $user_id = $_SESSION['user_id'];
                $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") 
                or die('query failed');
                if(mysqli_num_rows($select_orders) > 0){
                    while($fetch = mysqli_fetch_assoc($select_orders)){
                        $order_id = $fetch['id'];
                        $user_id = $fetch['user_id'];
                        $select_order_products = mysqli_query($conn, "SELECT * FROM `orders_products` WHERE order_id = '$order_id' AND user_id = '$user_id'") 
                            or die('query failed');
                        $product_number = mysqli_num_rows($select_order_products);
            ?>
            <div class="brand-image carts">
                <p class="price">name : <?php echo $fetch['name'];?></p>
                <p class="price">email : <?php echo $fetch['email'];?></p>
                <p class="price">tel number : <?php echo $fetch['tel_number'];?></p>
                <p class="price">nof product : <?php echo $product_number;?></p>
                <p class="price">total price : <?php echo $fetch['total_price'];?> $</p>
                <p class="price">payment method : <?php echo $fetch['payment_method'];?></p>
                <p class="price">address : <?php echo $fetch['address'];?></p>
                <p class="price">city : <?php echo $fetch['city'];?></p>
                <p class="price">country : <?php echo $fetch['country'];?></p>
                <p class="price">pin code : <?php echo $fetch['pin_code'];?></p>
                <p class="price">order statue : <?php echo $fetch['order_statue'];?></p>
            </div>
            <?php
                    };
                }else{
                    echo '<h1 class="section-subtitle">you have no orders!</h1>';
                }
            ?>
        </div>
    </div>
</section>

<!-- Scroll Up -->
<a href="#order" class="scrollUp-btn flex">
    <i class='bx bx-up-arrow-alt scrollUp-icon'></i>
</a>

<!-- Footer Section -->
    <?php include "section_footer.php";?>
