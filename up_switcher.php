<?php
session_start();
switch ($_POST['target']) {
    case 'chat':
        $_SESSION['up_status'] = 'chat';
        require "user-chat.php";
        break;
    case 'view':
        $_SESSION['up_status'] = 'view';
        require "user-info.php";
        break;
}
?>