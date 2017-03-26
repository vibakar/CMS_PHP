<?php include 'db.php'; ?>
<?php session_start(); ?>
<?php include '../admin/functions.php'; ?>
<?php

if (isset($_POST['login'])) {
    loginUser($_POST["username"], $_POST["password"]);
}
?>
