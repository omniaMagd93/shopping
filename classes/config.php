<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . "/constant.php";
include __DIR__ . "/openConnection.php";

session_start();
//print_r($_SESSION['cart']);