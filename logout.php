<?php
    session_start();
    unset($_SESSION['UserName']);
    header('location:./login.php');
?>