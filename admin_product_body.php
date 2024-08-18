

<?php

if(isset($_POST['send'])){
    
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'img/'.$image;
    $depart = mysqli_real_escape_string($conn, $_POST['depart']);
    $section = mysqli_real_escape_string($conn, $_POST['section']);
    $price = $_POST['price'];

    $select_product = mysqli_query($conn, "SELECT img FROM `products` WHERE img = '$image'")  or die('query failed');

    if(mysqli_num_rows($select_product) > 0){
        $message[] = 'this product already exist!';
    } else {
        if($image_size > 2000000){
            $message[] = 'image size is too large';
        }else{
            $add_product_query = mysqli_query($conn, "INSERT INTO `products`(img, department_type, section, price) 
                                    VALUES('$image', '$depart', '$section', '$price')") or die('query failed');
            if(isset($add_product_query)){
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'product added successfully!';
            }else{
                $message[] = 'product could not be added!';
            }
        }
    }
}

if(isset(($_POST['update_product']))){
    $update_p_id = $_POST['update_id'];
    $update_department = $_POST['update_department'];
    $update_section = $_POST['update_section'];
    $update_price = $_POST['update_price'];
 
    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = 'img/'.$update_image;
    $update_old_image = $_POST['update_old_image'];
    
    
    $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_p_id'")  or die('query failed');
    
    if(mysqli_num_rows($select_product) > 0){
        mysqli_query($conn, "UPDATE `products` SET department_type = '$update_department' WHERE id = '$update_p_id'")
        or die('query failed');
        mysqli_query($conn, "UPDATE `products` SET section = '$update_section' WHERE id = '$update_p_id'")
        or die('query failed');
        mysqli_query($conn, "UPDATE `products` SET price = '$update_price' WHERE id = '$update_p_id'")
        or die('query failed');
        
        
        if(isset($update_image)){
            if(!empty($update_image)){
                if($update_image_size > 2000000){
                    $message[] = 'image file size is too large';
                }else{
                    @unlink('img/'.$update_old_image);
                    mysqli_query($conn, "UPDATE `products` SET img = '$update_image' WHERE id = '$update_p_id'")
                    or die('query failed');
                    move_uploaded_file($update_image_tmp_name, $update_folder);
                    $message[] = 'Product updated successfully!';
                }
            } else {
                $message[] = 'Product updated successfully!';

            }
        }
        // header('location:admin_product.php');
    } 
 }

if(isset($_GET['delete_product'])){
    $delete_id = $_GET['delete_product'];
    $delete_image_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$delete_id'") 
        or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
    $img = $fetch_delete_image['img'];
    @unlink('img/'.$img);
    
    mysqli_query($conn, "DELETE FROM `carts` WHERE product_id = '$delete_id'") or die('query failed');
    mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
    $message[] = 'product deleted successfully!';
    // header('location: admin_product.php');
}
?>
<!-- Brand Section -->
<section class="section brand product" id="add_products">
    <h4 class="section-subtitle"><i>add products</i></h4>
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
        <form action="" method="post" class="pro-form input-box" enctype="multipart/form-data">
                <div class="sec">
                    <input type="file" name="image" id="image" class="prod-input email left" required value="Choose Image">
                    <select name="depart" id="depart" class="prod-input name right" required>
                        <option value="" selected disabled>Select Department</option>
                        <option value="weddings">Weddings</option>
                        <option value="lovers">Lovers</option>
                        <option value="decoration">Decoration</option>
                        <option value="new_babby">New Babby</option>
                        <option value="get_well_soon">Get Well Soon</option>
                    </select>
                </div>
                <div class="sec">
                    <input type="number" name="price" id="add" class="prod-input add right" required placeholder="Price">
                    <select name="section" id="section" class="prod-input name left" required>
                        <option value="" selected disabled>Select Section</option>
                        <option value="packets">Packets</option>
                        <option value="box">Box</option>
                        <option value="boy">Boy</option>
                        <option value="girl">Girl</option>
                        <option value="decore">Decore</option>
                        <option value="vases">Vases</option>
                        <option value="toys">Toys</option>
                    </select>
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
</section>

<!-- products -->
<!-- weddings -->
<?php
    $select_groups = mysqli_query($conn, "SELECT department_type , section FROM `products` GROUP BY department_type , section;")
        or die('query failed');
    if(mysqli_num_rows($select_groups) > 0){
        while($fetch_group = mysqli_fetch_assoc($select_groups)){
            $department = $fetch_group['department_type'];
            $section = $fetch_group['section'];
?>
<section class="section brand first" id="weddings">
    <h4 class="section-subtitle"><i><?php echo $department;?></i></h4>
    <div class="brand-container container">
        <h4 class="section-title"><i><?php echo $section;?></i></h4>

        <form action="" method="post" enctype="multipart/form-data" class="brand-images">
            <?php
                $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE department_type = '$department' AND section = '$section'")
                    or die('query failed');
                if(mysqli_num_rows($select_products) > 0){
                    while($fetch_products = mysqli_fetch_assoc($select_products)){
            ?>
            <div class="brand-image products">
                <input type="hidden" name="update_id" value="<?php echo $fetch_products['id']; ?>">
                <input type="hidden" name="update_old_image" value="<?php echo $fetch_products['img']; ?>">
                <img src="img/<?php echo $fetch_products['img']; ?>" alt="">
                <select name="update_department" id="depart" class="prod-input" required>
                    <option value="<?php echo $fetch_products['department_type']; ?>" selected><?php echo $fetch_products['department_type']; ?></option>
                    <option value="weddings">Weddings</option>
                    <option value="lovers">Lovers</option>
                    <option value="decoration">Decoration</option>
                    <option value="new_babby">New Babby</option>
                    <option value="get_well_soon">Get Well Soon</option>
                </select>
                <select name="update_section" id="section" required class="prod-input">
                    <option value="<?php echo $fetch_products['section']; ?>" selected><?php echo $fetch_products['section']; ?></option>
                    <option value="packets">Packets</option>
                    <option value="box">Box</option>
                    <option value="boy">Boy</option>
                    <option value="girl">Girl</option>
                    <option value="decore">Decore</option>
                    <option value="vases">Vases</option>
                    <option value="toys">Toys</option>
                </select>
                <input type="number" name="update_price" class="prod-input" value="<?php echo $fetch_products['price']; ?>" min="0" class="box" required placeholder="enter product price">
                <input type="file" name="update_image"  class="prod-input" accept="image/jpg, image/jpeg, image/png">
                <a class="btn" href="admin_product.php?delete_product=<?php echo $fetch_products['id']; ?>" onclick="return confirm('delete this product?');" class="btn">delete product</a>
                <!-- <a class="btn" name="update_product" type="submit" href="admin_product.php?update=<?php echo $fetch_products['id']; ?>" onclick="return confirm('update this product?');" class="btn">update</a> -->
                <input type="submit" value="update product" name="update_product" class="btn">
            </div>
            <?php
                    };
                }
            ?>
        </form>

    </div>
</section>
<?php
        }
    } else{
    echo '<h1 class="section-title">you have no products!</h1>';
    }
?>
<!-- Scroll Up -->
<a href="#add_products" class="scrollUp-btn flex">
    <i class='bx bx-up-arrow-alt scrollUp-icon'></i>
</a>
