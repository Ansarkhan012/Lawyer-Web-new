<?php
session_start();
session_unset();
session_destroy();


header("Location: ../user/lawyer_login.php"); 
exit();
?>
