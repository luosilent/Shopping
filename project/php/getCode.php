<?php

header("Access-Control-Allow-Origin: *");//这个必写，否则报错
require "conn.php";
$res = array("error" => false,  "code" => "failed");

$action = isset($_GET['action']) ? $_GET['action'] : "";
$user_tel = isset($_GET['user_tel']) ? $_GET['user_tel'] : "";


if ($action == "getCode" && strlen($user_tel) == 11) {

    $sql_chk = "select * from `users` where username='{$username}' and user_tel='{$user_tel}';";
    $re_chk=$conn->query($sql_chk);

    if($re_chk->num_rows != 0){

     $res['code'] = getCode();
 }

}

//获取4位随机验证码
function getCode(){
//设置字母和数字的构成的数组
    $arr1 = range('a','z');
    $arr2 = range('A','Z');
    $arr3 = range(0,9);

    $arr = array_merge($arr1,$arr2,$arr3);

//随机从中抽取4个元素
    $keys = array_rand($arr,4);
    $code = '';
    foreach($keys as $k ){
        $code .= $arr[$k];

    }
    return $code;
}


echo(json_encode($res));//这里用echo而不是return


