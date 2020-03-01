<?php
require"conn.php";
session_start();
if(isset($_GET["oper"]) && $_GET["oper"] == "get"){
	if(!isset($_SESSION["username"])){
		echo "";
		exit;
	}
	$res['user']=$_SESSION;

	echo(json_encode($res));
}else{
	$username =isset($_POST["username"]) ? $_POST["username"] : ""; 
	$password =isset($_POST["password"]) ? $_POST["password"] : ""; 
	$sql_chk="select * from `users` where username ='{$username}' and password='{$password}';";
	$re_chk=$conn->query($sql_chk);
	$row=$re_chk->fetch_assoc();
	if($re_chk->num_rows==0){
		$message = urlencode("用户名或密码输入错误，请重新输入。");
		header("refresh:1;url= ../html/login.html?message=$message");
		$conn->close();
		exit;
	}else{
		$_SESSION["user_id"] = $row['id'];
		$_SESSION["username"] = $row['username'];
		$_SESSION["user_tel"] = $row['user_tel'];
		$_SESSION["head_img"] = $row['head_img'] ? $row['head_img'] : "";
		$_SESSION["is_seller"] = $row['is_seller'] ? $row['is_seller'] : 0;

		$message = urlencode("登录成功！");
		header("refresh:1;url= ../index.html?message=$message");
	}
}
?>
