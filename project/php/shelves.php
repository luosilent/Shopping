<?php

require "conn.php";

//请求参数
$name = isset($_POST["name"]) ? $_POST["name"] : "";
$user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : "";
$price = isset($_POST["price"]) ? $_POST["price"] : "";
$type = isset($_POST["type"]) ? $_POST["type"] : "";
$content = isset($_POST["content"]) ? $_POST["content"] : "";
$image = isset($_POST["image"]) ? $_POST["image"] : "";


//服务端判断
if ($name == "") {
	$message = "商品名称不为空";

} elseif ($type == "") {
	$message = "分类不为空";
} else {
	//插入信息
	$create_time = date("Y-m-d H:i:s");
	$sql_add = "insert into `shopping` (id,user_id, name, price, type, content, image, create_time) ";
	$sql_add .= "values ('','{$user_id}','{$name}','{$price}','{$type}','{$content}','{$image}','{$create_time}')";

	$re = $conn->query($sql_add);

	if ($re) {
		$message = "上架成功";
	} else {
		$message = "上架失败";

	}
}
//返回发布成功与否的信息提示和跳转
$message = isset($message) ? urlencode($message) : "error";
header("refresh:1;url= ../html/shelves.html?message=$message");

$conn->close();