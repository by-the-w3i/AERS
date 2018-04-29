<?php
require_once "System.php";
session_start();
set_time_limit(90);

if (isset($_POST["userID"]) && isset($_POST["passWD"]) && strip_tags($_POST["passWD"])==="surprise") {
    $sys = new System();
    if ($sys->initSys(strip_tags($_POST["userID"]))){
        $_SESSION["SYSTEM_SESSION"] = $sys;
//        var_dump($sys->getReviews());
        header("location: index.php");
        exit;
    }
}

$_SESSION["LOGIN_ERROR"] = "Invalid user ID or password.";
header("location: login.php");