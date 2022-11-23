<?php
    session_start();
    session_destroy();
    header('location:/memory/index.php');
    echo $_SESSION['user_id'];
    exit;
?>