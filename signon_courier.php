<!DOCTYPE HTML>
<html>
<head>
<title>MyLogistics|派送员登陆</title>
<link href='./css/signon_courier/style.css' rel='stylesheet' type='text/css' media="all">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="keywords" content="Logistics" />
</head>
<body>


<div class="login-form">
			<div class="login-top">
				<h1>MyLogistics</h1>
				<h2>派送员登录</h2>
				
				<form id="form2" name="form2" method='post' action="signon_courier.php">
					<div class="login-ic">
						<i ></i>
						<input type="text" name="username" value="用户名" onFocus="this.value = '';" "/>
						<div class="clear"> </div>
					</div>
					<div class="login-ic">
						<i class="icon"></i>
						<input type="password"  name="password" value="" onFocus="this.value = '';" />
						<div class="clear"> </div>
					</div>
					<div class="log-bwn">
						<input type="submit"  value="登录" />
					</div>
				</form>
				
				
				<div class="mart log-bwn">
					<a href="./signon.php">我是用户</a>
				</div>
				
				<div class="mart log-bwn wrong">
				 <?php
//导入mysql_connect.php模块
require 'mysql_connect.php';

//定义变量并默认设置为空值
$username="";  
$password="";  
$loginsql="";
$result="";

//开启全局变量session
session_start();

function test_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
 
//变量赋值
if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if (!empty($_POST["username"])){	$username= test_input($_POST["username"]);}
		if (!empty($_POST["password"])){	$password = test_input($_POST["password"]);}
		
		$loginsql="SELECT * FROM `courier` WHERE cpsw = '".$password."' AND cname = '".$username."'";
	    $result = mysql_query($loginsql);
		while($row=mysql_fetch_array($result))
		{
			$_SESSION['cname']=$row['cname'];
			$_SESSION['cpsw']=$row['cpsw'];
			$_SESSION['cid']=$row['cid'];
			$_SESSION['cstate']=$row['cstate'];
			
			//开启全局变量session
			//session_start();
			header("location:courier_order.php");
		}
		if(!$row){echo "<h3>用户名或密码错误</h3>";}
	}
?>
				</div>
				
				
				<div class="message">
						<ul>
						<li>&copy; MyLogistics</li>
						<li>|</li>
						<li><a href=" https://www.baidu.com/"> 使用条款</a></li>
						<li>|</li>
						<li><a href="./signon.php"> 用户登录</a></li>
						</ul>
				</div>
			
			</div>
			
				
			
</div>	

	
</body>
</html>