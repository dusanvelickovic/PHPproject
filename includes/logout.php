<?php session_start(); ?>
<?php ob_start(); ?>
<?php
    $_SESSION['id'] = null;
    $_SESSION['user'] = null;
    $_SESSION['firstName'] = null;
    $_SESSION['lastName'] = null;
    $_SESSION['role'] = null;
    $_SESSION['email'] = null;

    header("Location: ../index.php");
?>