<?php
/**
 * Created by PhpStorm.
 * User: Jevin
 * Date: 4/27/18
 * Time: 1:32 AM
 */

require_once "System.php";
session_start();

if (!isset($_SESSION["SYSTEM_SESSION"])){
    header("location: login.php");
    exit;
}

$sys = $_SESSION["SYSTEM_SESSION"];