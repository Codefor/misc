<?php
session_start();
include('common.php');
$r = isset($_GET['r']) ? $_GET['r']:"";
if(isset($_POST['username']) && isset($_POST['password'])){
    if(check_user($_POST['username'],$_POST['password'])){
            $_SESSION['login'] = True;
            $_SESSION['username'] = $_POST['username'];

            if(!empty($r)){
                header("Location: $r");
            }else{
                header("Location:index.php");
            }
            exit();
    }
}

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="content-type" />
    <title>登录 STC 宣传页 在线模板生成</title>
    
    <!-- Jquery Framework -->
    <script language="javascript" type="text/javascript" src="/jquery/jquery-1.7.1.min.js"></script>
    
    <!-- Bootstrap Library -->
    <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap-responsive.min.css" />
    <script language="javascript" type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/style/login.css" />
</head>
<body>
	<div class="offset2 span4 login-div">
		<h1>NOWSTC</h1>
        <form class="form" method="POST" action="<?=$_SERVER['REQUEST_URI']?>">
            <input type="text" name="username" id="username" class="span3 opacity05" placeholder="用户名"/>
            <input type="password" name="password" id="password" class="span3 opacity05" placeholder="密码"/>
			<input type="submit" value="登陆" class="btn btn-large btn-primary" />
        </form>
	</div>
</body>
</html>

