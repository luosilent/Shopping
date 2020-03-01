<?php
	require"../php/conn.php";
	error_reporting(0); 
$username=$_POST["username"];
$password=$_POST["password"];
$usertel=$_POST["usertel"];
if(strlen($username)== 0 || strlen($password)==0||strlen($usertel)==0){
	require"fail2.html";
	exit();//强制结束php的程序处理
}

//在mysql中处理的值是数字，或者null的话不需要写''，否则都要求用''包含
$sql_chk = "select * from `uses` where username='{$username}';";
//查询结果集
$re_chk = $conn->query($sql_chk);
//返回数据查询的记录行数
if ($re_chk->num_rows == 0) {
    $sql_add = "insert into `uses` (username ,password ,usertel) ";
    $sql_add .= "values ('{$username}' ,'{$password}','{$usertel}' )";
    //在写入数据之前，要检测当前注册用户是否有数据，用户名是否可被注册！
    $re = $conn->query($sql_add);
    if ($re) {
    	
        require"success.html";
        
    }
} else {
    require "fail1.html";
}
$conn->close();
?>