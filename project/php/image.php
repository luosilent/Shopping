<?php
header("Access-Control-Allow-Origin: *");
require "conn.php";

$id = $_GET["id"];
$image = $_GET["image"];

// 存入数据库
$sql = "UPDATE `users` SET head_img='$image' WHERE id='$id'";
$re = $conn->query($sql);

if ($re) {
    session_start();
    $_SESSION["head_img"] = $image;
    echo $image;
} else {
    echo "";
}