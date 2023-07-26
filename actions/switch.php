<?php
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = '';
}

switch ($page) {
    case 'Message':
        include 'actions/messages.php';
        break;

    default:
        include 'actions/login-and-register-action.php';
        break;
}
?>