<?php
require "conn.php";
$id=Request("id");
$sql="delect form `shopping` where id=". $id;
$flag=$conn->query($sql);
?>