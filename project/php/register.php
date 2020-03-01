<?php

require "conn.php";

$username = isset($_POST["username"]) ? $_POST["username"] : "";
$password = isset($_POST["password"]) ? $_POST["password"] : "";
$userTel = isset($_POST["user_tel"]) ? $_POST["user_tel"] : "";
$headImg = isset($_POST["head_img"]) ? $_POST["head_img"] : "";
$isSeller = isset($_POST["is_seller"]) ? $_POST["is_seller"] : "";
   
if (empty($username) || empty($password) || empty($userTel)) {
    $message = urlencode("用户名、密码或手机不许为空！");
    header("refresh:1;url= ../html/reg.html?message=$message");
    exit();
}

if (strlen($userTel) != "11") {
    $message = urlencode("请输入格式正确的手机号");
    header("refresh:1;url= ../html/reg.html?message=$message");
    exit();
}

$sql_chk = "select * from `users` where username='{$username}';";
//查询结果集
$re_chk = $conn->query($sql_chk);
//返回数据查询的记录行数

if ($re_chk->num_rows == 0) {

    $createTime = date("Y-m-d H:i:s");
    $sql_add = "insert into `users` (username, password, user_tel, head_img, is_seller,create_time) ";
    $sql_add .= "values ('{$username}','{$password}','{$userTel}','{$headImg}','{$isSeller}','{$createTime}')";

    //检测用户名是否已被注册
    $re = $conn->query($sql_add);
    if ($re) {
        //提示信息并跳转
        $message = urlencode("注册成功啦！欢迎你来~");
        header("refresh:1;url= ../html/index.html?message=$message");

    }
} else {
    $message = urlencode("该用户名已被使用，请更换用户名重新注册。");
    header("refresh:1;url= ../html/reg.html?message=$message");

}
$conn->close();