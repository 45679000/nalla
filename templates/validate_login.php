<?php
if(!isset($_SESSION["user_id"])){
    echo '<script type="text/javascript">window.location = "/chamu/admin/login.php?sessionExpired=true";</script>';
}
?>