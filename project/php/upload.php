
<?php

// 上传头像
header("Content-Type: text/html; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
 
// 获取上传文件data
$fileData = $_FILES['fileData'];
// 文件名
$fileName = $fileData['name'];
// 用户编号
$dir = $_POST['dir'];
 
// 服务器临时文件
$tmp_name = $fileData['tmp_name'];
 
// 转码为GB2312（防止文件夹名称为中文时乱码）
$fileName = iconv('UTF-8', 'GB2312', $fileName);
 
// 接收到的文件要保存的文件夹名称
$dirName = '../img/'.$dir;
// 检查服务器当前地址有无名称为用户编号的
if (!file_exists($dirName)) {
    // 如果该文件夹不存在，新建该文件夹
    $cc = mkdir($dirName, 0777);
    if ($cc === true) {
        $msg = '创建'.$dirName.'文件夹成功！';
    } else {
        $msg = '创建'.$dirName.'文件夹失败！';
        echo json_encode($msg);
        return;
    }
} else {
    // 如果该文件夹已存在
    $msg = '文件夹'.$dirName.'在当前文件夹里已存在！';
}
 
// 目标地址
$desUrl = $dirName."/".$fileName;
// 将服务器上的临时文件移动至指定的目录 (move_uploaded_file函数)
$status = move_uploaded_file($tmp_name, $desUrl);
if ($status === true) {
    // 转码为UTF-8
    $fileName = iconv('GB2312', 'UTF-8', $fileName);
    // 输出语句
    echo json_encode(array('status' => 'success', 'msg' => '上传成功！', 'fileName' => $fileName));
} else {
    // 输出语句
    echo json_encode(array('status' => 'error', 'msg' => '上传失败！', 'fileName' => ''));
}