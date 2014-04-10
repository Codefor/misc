<?php
//http://blog.csdn.net/ppiao1970hank/article/details/6301812

$mysqli = new mysqli('localhost', 'stcuser', 'stcpass', 'stc');

if ($mysqli->connect_error) {
    die('数据库连接失败(' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}



$mysqli->close();
?>
