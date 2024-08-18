<?php
include "super_admin_header.php";

if(!isset($_SESSION['super_admin_id'])){
  header('location: index.php');
}

include "admin_orders_body.php";

include "section_footer.php";

?>