<?php
include "section_header.php";

if(isset($_POST['send_message'])){
        
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $msg = mysqli_real_escape_string($conn, $_POST['message']);
        $user_id = $_SESSION['user_id'];
    
        mysqli_query($conn, "INSERT INTO `contact_`(user_id, name, email, msg) VALUES('$user_id', '$name', '$email', '$msg')") or die('query failed');
        
        $message_2_[] = 'sent successfully!';
}


?>
<!-- Brand Section -->
<section class="section brand product" id="contact">
    <?php
        if(isset($message_2_)){
            foreach($message_2_ as $msg){
                echo '
                <div class="message section-subtitle" style="color:orange;">
                    <span>'.$msg.'</span>
                    <i class="bx bx-x" onclick="this.parentElement.remove();"></i>
                </div>
                ';
            }
        }
    ?>
    <h4 class="section-title"><i>Contact Us</i></h4>
    <form action="" method="post" class="pro-form" enctype="multipart/form-data">
            <div class="sec">
                <input type="text" name="name" id="name" class="prod-input name left" required placeholder="Enter your name">
                <input type="email" name="email" id="email" class="prod-input email right" required placeholder="Enter your email">
            </div>
            <div class="single-sec">
                <textarea name="message" class="prod-input" id="message" cols="30" rows="10">Enter Your Message</textarea>
            </div>
            <div class="sec">
                <button type="submit" name="send_message" class="prod-button submit left" id="order">
                    Send
                </button>
                <button type="reset" class="prod-button reset right" id="reset">
                    Reset
                </button>
            </div>
    </form>
</section>

<!-- Scroll Up -->
<a href="#contact" class="scrollUp-btn flex">
    <i class='bx bx-up-arrow-alt scrollUp-icon'></i>
</a>

<!-- Footer Section -->
    <?php include "section_footer.php";?>
