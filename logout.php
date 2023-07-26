<?php
session_start();
session_destroy();

header("Location: login_and_register.php", true, 301);
exit();
?>