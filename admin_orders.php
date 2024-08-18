<?php

include "admin_header.php";

if(isset($_SESSION['super_admin_id'])){
  header('location: super_admin_orders.php');
} 

include "admin_orders_body.php";

include "section_footer.php";

?>