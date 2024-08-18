<?php

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `contact_` WHERE id = '$delete_id'") or die('query failed');
   header('location: admin_contacts.php');
}

if(isset($_GET['delete_all_messages'])){
    mysqli_query($conn, "DELETE FROM `contact_`") or die('query failed');
    header("location: admin_contacts.php");
}
?>
<section class="section brand first" id="contacts">
    <div class="brand-container container">
        <h4 class="section-subtitle"><i>messages</i></h4>

        <div class="brand-images">
            <?php
                $select_message = mysqli_query($conn, "SELECT * FROM `contact_`") or die('query failed');
                if(mysqli_num_rows($select_message) > 0){
                    while($fetch_message = mysqli_fetch_assoc($select_message)){
            ?>
            <div class="brand-image">
                <p> user id : <span><?php echo $fetch_message['user_id']; ?></span> </p>
                <p> name : <span><?php echo $fetch_message['name']; ?></span> </p>
                <p> email : <span><?php echo $fetch_message['email']; ?></span> </p>
                <p> message : <span><?php echo $fetch_message['msg']; ?></span> </p>
                <a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="btn">delete message</a>
            </div>
            <?php
                    };
                }else{
                    echo '<h1 class="section-title">you have no messages!</h1>';
                }
            ?>
        </div>

    </div>
</section>

<section class="section">
    <div class="container">
        <a class="btn delete-all-btn" href="admin_contacts.php?delete_all_messages" onclick="return confirm('delete all messages?');" >Delete All</a>
    </div>
</section>

<!-- Scroll Up -->
<a href="#contacts" class="scrollUp-btn flex">
    <i class='bx bx-up-arrow-alt scrollUp-icon'></i>
</a>