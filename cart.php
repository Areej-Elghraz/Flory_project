<?php
require "section_header.php";
?>

<!-- Home Section -->
<main>
<!-- Brand Section -->
<section class="section brand" id="cart">
    <div class="brand-container container">
        
        <h4 class="section-subtitle cart"><i>Products In Carts</i></h4>
            <div class="brand-images">
            <?php
                $user_id_ = $_SESSION['user_id'];
                $select_cart = mysqli_query($conn, "SELECT * FROM `carts` as cart inner join `products` as product on cart.`product_id`= product.`id` where user_id = '$user_id';") or die('query failed');
                $total_price = 0;
                if(mysqli_num_rows($select_cart) > 0){
                    while($fetch = mysqli_fetch_assoc($select_cart)){
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
                            <span class="price">Price : <?php echo $fetch['price'];?></span>
                            <span class="price">Department : <span name="new_babby"><?php echo $fetch['department_type'];?></span></span>
                            <span class="price">Section : <?php echo $fetch['section'];?></span>
                            <input type="number" class="info_input" value="<?php echo $fetch['quantity'];?>" name="quantity" min="1">
                            <input type="hidden" value="<?php echo $fetch['id'];?>" name="id">
                            <a href="cart.php?delete=<?php echo $fetch['id']; ?>" onclick="return confirm('Delete this product from the cart?');" class="btn">delete product</a>
                            <input type="submit" class="btn" value="Update" name="update" >
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
    <a class="btn delete-all-btn" href="cart.php?delete_all_from_cart" onclick="return confirm('delete this products form the cart?');" >Delete All</a>
</div>
</section>

<section class="section">
<div class="container">
    <h4 class="section-subtitle">.. CLick here to add orders ..</h4>
    <h4 class="section-title">Total Price : <?php echo $total_price;?> $</h4>
    <form action="" method="post">
        <input type="hidden" name="total_price" value="<?php echo $total_price;?>">
        <input type="submit" value="Order Now" name="orders" class="delete-all-btn btn">
    </form>
</div>
</section>


<!-- Scroll Up -->
<a href="#cart" class="scrollUp-btn flex">
    <i class='bx bx-up-arrow-alt scrollUp-icon'></i>
</a>

<!-- Footer Section -->
<?php include "section_footer.php";?>