<?php
	/*
	 * php连接数据库有两种方法
	 * mysqli(ishi improved),从mysql改进为mysqli
	 * pdo.支持12种数据库处理
	 * 如果你用pdo则只需要修改php的数据库链接方式即可，而用myaqli的话，只支持mysql（MariaDB）处理
	 */
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "project";
 /*
  * mysqli方式
  */
// 创建连接
//@符号能屏蔽报错信息！
$conn = @new mysqli($servername, $username, $password, $dbname);
//设置编码为utf8，防止中文乱码
mysqli_query($conn, "SET NAMES UTF8");
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
  //echo"连接成功";
?>