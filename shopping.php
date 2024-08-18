<?php
require "section_header.php";
?>

<!-- Home Section -->
<!-- Brand Section -->
<section class="section search" id="search">
        <div class="search-container containter">
        <?php
                if(isset($_SESSION['mesg'])){
                        foreach($_SESSION['mesg'] as $msg){
                                echo '
                                <div class="message section-subtitle" style="color:orange;">
                                        <span>'.$msg.'</span>
                                        <i class="bx bx-x close" onclick="this.parentElement.remove();"></i>
                                </div>
                                ';
                        }
                }
                ?>
                <h1 class="section-subtitle title search-title" id="sech">Search for Departments</h1>
                <div class="search-box">
                        <input type="search" name="search" id="search-input">
                        <div class="results">
                                <ul>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                </ul>
                        </div>
                </div>
        </div>
</section>


<?php
$select_groups = mysqli_query($conn, "SELECT department_type , section FROM `products` GROUP BY department_type , section;")
or die('query failed');
if(mysqli_num_rows($select_groups) > 0){
while($fetch_group = mysqli_fetch_assoc($select_groups)){
        $department = $fetch_group['department_type'];
        $section = $fetch_group['section'];

?>

<section class="section brand first" id="<?php echo $department;?>">
        <div class="brand-container container">
                
                <h4 class="section-title"><i id="wes"><?php echo $department;?></i></h4>
                
                <div class="brand-images">
<?php
        $select = mysqli_query($conn, "SELECT * FROM `products` WHERE department_type = '$department' AND section = '$section'") or die('query failed');
        if(mysqli_num_rows($select) > 0){
        if(mysqli_num_rows($select) > 3){
                $select = mysqli_query($conn, "SELECT * FROM `products` WHERE department_type = '$department' AND section = '$section' LIMIT 3") or die('query failed');
        }
        
        while($fetch = mysqli_fetch_assoc($select)){
?>
                <div class="brand-image shopping"> 
                        <div class="front">
                                <img src="img/<?php echo $fetch['img'];?>" alt="<?php echo $fetch['img'];?>" class="brand-img">
                        </div>
                <div class="info">
                        <p class="sub-info">information :</p>
                        <form class="info-container" method="post" enctype="multipart/form-data">
                                <span class="price">Price : <?php echo $fetch['price'];?> $</span>
                                <span class="price">Department : <span><?php echo $fetch['department_type'];?></span></span>
                                <span class="price">Section : <?php echo $fetch['section'];?></span>

                                <input type="number" class="info_input" value="1" name="quantity" min="1">
                                <input type="hidden" name="image" value="<?php echo $fetch['id'];?>">
                                <input type="submit" class="btn" value="Add To Cart" name="add_to_cart">
                                <!-- <li class="left idd">Id : <span name="prod_num">11</span> </li> -->
                        </form>
                </div>

        </div>
        <?php
                        };
                }
        ?>
        </div>
        <form action="" method="get" class="more">
                <a href="shopping.php?more_products=<?php echo $department;?>" onclick="return confirm('Show more products?');" class="section-subtitle sec-link" id="see1">
                        More <?php echo $department;?> Products...
                </a>
        </form>
</div>
</section>

<?php
        }
} else{
        echo '<h1 class="section-subtitle">No product here!</h1>';
}
?>


<!-- Scroll Up -->
<a href="#search" class="scrollUp-btn flex">
        <i class='bx bx-up-arrow-alt scrollUp-icon'></i>
</a>

<?php require "section_footer.php";?>