<?php
require"conn.php";

$username =isset($_POST["username"]) ? $_POST["username"] : ""; 
$password =isset($_POST["password"]) ? $_POST["password"] : ""; 
$user_tel =isset($_POST["user_tel"]) ? $_POST["user_tel"] : ""; 

if ($username && $password  && $user_tel ) {

	$sql = "update `users` set password='{$password}' WHERE username ='{$username}' and user_tel='{$user_tel}'; ";
	$re_chk=$conn->query($sql);
	if($re_chk){
		$message = urlencode("修改密码成功，请记住好密码！");
		header("refresh:1;url= ../html/login.html?message=$message");
		$conn->close();
		exit;
	}
}

$message = urlencode("修改密码失败!");
header("refresh:1;url= ../html/forgetPwd.html.html?message=$message");


?>
