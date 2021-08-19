<?php
if(!isset($_SESSION["user_id"])){
    echo '<script type="text/javascript">window.location = "/chamu/views/login.php?sessionExpired=true";</script>';
}
?>