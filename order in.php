<?php
    require "section_header.php";
?>
<!-- Brand Section -->
<section class="section brand" id="order">
    <div class="brand-container container">
        
        <h4 class="section-subtitle cart"><i>Products In Carts</i></h4>
        <div class="brand-images">
            <?php
                $user_id_ = $_SESSION['user_id'];
                $select = mysqli_query($conn, "SELECT * FROM `carts` as cart inner join `products` as product on cart.`product_id`= product.`id` where user_id = '$user_id';") 
                    or die('query failed');
                $total_price = 0;
                if(mysqli_num_rows($select) > 0){
                    while($fetch = mysqli_fetch_assoc($select)){
                        $total_price_prod = $fetch['price'] * $fetch['quantity'];
                        $total_price += $total_price_prod;
            ?>

            <div class="brand-image shopping"> 
                <div class="front">
                    <img src="img/<?php echo $fetch['img'];?>" alt="<?php echo $fetch['img'];?>" class="brand-img">
                </div>
                <div class="info">
                    <p class="sub-info">information :</p>
                    <form class="info-container" method="post" enctype="multipart/form-data">
                        <span class="price">P*Q => <?php echo $fetch['price'];?> $ * <?php echo $fetch['quantity'];?></span>
                        <span class="price">Total Price : <span name="new_babby"><?php echo $total_price_prod;?></span></span>
                    </form>
                </div>
            </div>

            <?php 
                    };
                } else {
                    echo '<h1 class="section-subtitle">No products here!</h1>';
                }
            ?>
        </div>
    </div>
</section>


<section class="section">
    <div class="container">
        <h4 class="section-title">Total Price : <?php echo $total_price;?> $</h4>
    </div>
</section>

<section class="section brand product" id="add_products">
    <h4 class="section-subtitle"><i>Place Your Order</i></h4>
    <?php
        if(isset($_SESSION['mmsg1'])){
            foreach($_SESSION['mmsg1'] as $msg){
                echo '
                <div class="message section-subtitle" style="color:orange;">
                    <span>'.$msg.'</span>
                    <i class="bx bx-x" onclick="this.parentElement.remove();"></i>
                </div>
                ';
            }
        }
    ?>
    <div class="pro-container">
        <form action="" method="post" class="pro-form" enctype="multipart/form-data">
            <div class="sec">
                <input type="text" name="name" id="name" class="prod-input name left" required placeholder="Enter your name">
                <input type="email" name="email" id="email" class="prod-input email left" required placeholder="Enter your email">
            </div>
            <div class="sec">
                <input type="tel" name="number" id="number" class="prod-input number left" required placeholder="Enter your number">
                <select name="payment_method" id="depart" class="prod-input payment-method right" required>
                    <option value="" selected disabled>Select your payment method</option>
                    <option value="cash_on_delivery">Cash On Delivery</option>
                    <option value="Credit_card">Credit Card</option>
                    <option value="paypal">Paypal</option>
                    <option value="Paytm">Paytm</option>
                </select>
            </div>
            <div class="sec">
                <input type="text" name="address" id="address" class="prod-input address left" required placeholder="Enter your address">
                <input type="text" name="city" id="city" class="prod-input city left" required placeholder="Enter your city">
            </div>
            <div class="sec">
                <input type="text" name="country" id="country" class="prod-input country left" required placeholder="Enter your country">
                <input type="number" name="pin_code" id="pin_code" class="prod-input pin-code left" required placeholder="Pin-Code as '123456'">
                <input type="hidden" name="total_price" id="total_price" class="prod-input total_price left" required value="<?php echo $total_price;?>">
            </div>
            <div class="sec">
                <button type="submit" name="order" class="prod-button submit left" id="order">
                    Order Now
                </button>
                <button type="reset" class="prod-button reset right" id="reset">
                    Reset
                </button>
            </div>
        </form>
    </div>
</section>

<section class="section">
    <div class="container">
        <h4 class="section-subtitle">.. CLick here to see your orders ..</h4>
        <a class="btn delete-all-btn" href="orders.php">Show all orders Orders</a>
    </div>
</section>


<!-- Scroll Up -->
<a href="#order" class="scrollUp-btn flex">
    <i class='bx bx-up-arrow-alt scrollUp-icon'></i>
</a>

<!-- Footer Section -->
    <?php include "section_footer.php";?>
