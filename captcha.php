<?php
  include 'config.php';
  session_start();

  if(!$_SESSION['user_id'] ){
    header('location: index.php');
  }
?>
<!DOCTYPE html>
<!-- YouTube - CodingLab -->
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title id="t">Captcha</title>
    <link rel="stylesheet" href="css/capatcha_style.css" />

    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
  </head>
  <body style="background-image: url(img/constant/robot_2.jpg); background-repeat: no-repeat;background-size: cover;">
    <div class="container">
      <header id="header">I'm not a Robot !</header>
      <div class="input_field captch_box">
        <input type="text" value="" disabled />
        <button class="refresh_button">
          <i class="fa-solid fa-rotate-right"></i>
        </button>
      </div>
      <div class="input_field captch_input">
        <input type="text" id="enter" placeholder="Enter captcha">
      </div>
      <div class="message">Entered captcha is correct</div>
      <div class="input_field button disabled">
        <button id="sub">Submit Captcha</button>
      </div>
    </div>
    <script src="js/captcha_script.js"></script>
  </body>
</html>
