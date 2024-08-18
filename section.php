<?php

include "section_header.php";

if(! isset($_SESSION['department_type'])){
  
    echo '<br> <br> <br><h1 class="section-subtitle">you have no products here!</h1> <br> <br>';

} else {

  $department = $_SESSION['department_type'];
  // $department = basename(__FILE__, '.php');

  $select_groups = mysqli_query($conn, "SELECT department_type , section FROM `products` WHERE department_type = '$department' GROUP BY section;")
  or die('query failed');
  if(mysqli_num_rows($select_groups) > 0){
  while($fetch_group = mysqli_fetch_assoc($select_groups)){
    // $department = $fetch_group['department_type'];
    $section = $fetch_group['section'];

?>

<section class="section brand" id="<?php if($counter == 0){ echo $id_section = $section;}?>">
<div class="brand-container container">
<h1 class="section-title"><i id="wes"><?php echo $department;?></i></h1>
<h4 class="section-subtitle packets"><i><?php echo $section;?></i></h4>

<div class="brand-images">
    <?php
      $select = mysqli_query($conn, "SELECT * FROM `products` WHERE department_type = '$department' AND section = '$section'") or die('query failed');
      if(mysqli_num_rows($select) > 0){
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
          <span class="price">Department : <span name="new_babby"><?php echo $fetch['department_type'];?></span></span>
          <span class="price">Section : <?php echo $fetch['section'];?></span>
          <input type="number" class="info_input" value="1" name="quantity" min="1">
          <input type="hidden" name="price" value="<?php echo $fetch['price'];?>">
          <input type="hidden" name="image" value="<?php echo $fetch['img'];?>">
          <input type="hidden" name="department" value="<?php echo $fetch['department_type'];?>">
          <input type="hidden" name="section" value="<?php echo $fetch['section'];?>">
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
  </div>
</section>
<?php
        }
    } else{
      echo '<br> <br> <br> <h1 class="section-subtitle">you have no products here! <br> <br> </h1>';
  }
}
?>

<!-- Scroll Up -->
<a href="#<? if(isset($id_section)){echo $id_sesstion;}?>" class="scrollUp-btn flex">
    <i class='bx bx-up-arrow-alt scrollUp-icon'></i>
</a>

<?php require "section_footer.php";?>