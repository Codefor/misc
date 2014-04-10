<?php
session_start();

include('common.php');
if(!(isset($_SESSION['login']) && $_SESSION['login'])){
    header("Location: login.php?r=admin.php");
    exit();
}

if($_SESSION['username'] != "wangdongwei"){
    header("Location: login.php");
    exit();
}

if(isset($_GET['a']) && isset($_GET['d'])){
    $a = trim($_GET['a']);
    $d = (int)$_GET['d'];
    delete_account($d);
    header("Location: admin.php");
    exit();
}elseif(isset($_POST['username']) && isset($_POST['password'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    new_account($username,$password);
}

$info = list_account();
$mysqli->close();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="content-type" />
    <title>管理 STC 宣传页 在线模板生成</title>
    
    <!-- Jquery Framework -->
    <script language="javascript" type="text/javascript" src="/jquery/jquery-1.8.2.min.js"></script>
    
    <!-- Bootstrap Library -->
    <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" type="text/css" href="/bootstrap/css/dataTables.bootstrap.css" />
    <script language="javascript" type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>

</head>
<body>
<div class="table-responsive">
<table class="table table-striped table-bordered dataTable DTTT_selectable">  
  <caption>账户管理</caption>  

  <thead>  
    <tr>  
      <th>#</th>  
      <th>用户名</th>  
      <th>密码</th>  
      <th>操作</th>  
    </tr>  
  </thead>  
  <tbody>  
  <?$index=0;foreach($info as $item){$index++;?>
    <tr class="success">  
      <th><?=$index?></th>  
      <td><?=$item["username"]?></td>  
      <td><?=$item["password"]?></td>  
      <th><a class="btn btn-default" href="/admin.php?a=d&d=<?=$item["id"]?>">delete</a></th>  
    </tr> 
    <?}?>
    <form method="post">
    <tr class="warning">  
      <th>#</th>  
      <td><input type="text" name="username"/></td>  
      <td><input type="text" name="password"/></td>  
      <th><input type="submit" class="btn btn-default" value="Add"/></th>  
    </tr> 
    </form>

  </tbody>  
</table>  

</div>
</body>
</html>

