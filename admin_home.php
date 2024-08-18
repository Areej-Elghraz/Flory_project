<?php

include "admin_header.php";

// if(isset($_SESSION['super_admin_id']) or isset($_SESSION['admin_id'])) {
//   if(isset($_SESSION['super_admin_id'])){
//     header('location: super_admin_home.php');
//   }elseif(isset($_SESSION['admin_id'])){
//     header('location: admin_home.php');
//   }
// } else {
//   header('location: index.php');
// }

if(isset($_SESSION['super_admin_id'])){
  header('location: super_admin_home.php');
} 
// if(isset($_SESSION['admin_id'])){
//   header('location: admin_home.php');
// } else {
//   header('location: index.php');
// }

include "admin_home_body.php";

include "section_footer.php";

?>