<?php
session_start();

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("location: index.php");
    exit;
} else if (isset($_SESSION['user']) != "") {
    header("location: home.php");
} else if (isset($_SESSION['adm']) != "") {
    header("location: dashboard.php");
}

if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    unset($_SESSION['adm']);
    session_unset();
    session_destroy();
    header("location: index.php");
    exit;
}
