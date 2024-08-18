<?php

include "admin_header.php";

if(isset($_SESSION['super_admin_id'])){
  header('location: super_admin_users.php');
}

include "admin_users_body.php";

include "section_footer.php";

?>