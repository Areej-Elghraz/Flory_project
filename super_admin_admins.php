<?php

include "super_admin_header.php";

if(!isset($_SESSION['super_admin_id'])){
  header('location: index.php');
}

include "super_admin_admins_body.php";

include "section_footer.php";

?>