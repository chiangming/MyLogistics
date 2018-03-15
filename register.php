<!DOCTYPE HTML>
<html>
<head>
<title>Logistics|创建账户</title>

<link href='./css/register/style.css' rel='stylesheet' type='text/css' media="all">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="register"/>
</head>
<body>
<?php
//导入mysql_connect.php模块
require 'mysql_connect.php';

//定义变量并默认设置为空值
$uname="";  $upsw=""; $upsw2=""; $uphone=""; $umail="";
$unameErr="";  $upswErr=""; $upsw2Err=""; $uphoneErr="";$umailErr="";
$regMessage="";

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
		if (empty($_POST["uname"])){	$unameErr = "用户名不能为空！";}
		else
		{
			$uname = test_input($_POST["uname"]);
			if (!preg_match("/^[a-zA-Z0-9]*$/",$uname)){$unameErr = "只允许字母和数字"; }
		}
		
		if (empty($_POST["upsw"])){    $upswErr = "密码不能为空";}
		else{$upsw = test_input($_POST["upsw"]);}
		
		if (!empty($_POST["upsw2"])){	$upsw2 = test_input($_POST["upsw2"]);}
		if($upsw!=$upsw2){ $upsw2Err = "两次密码输入不一致";}

		if (empty($_POST["uphone"])){    $uphoneErr= "联系电话不能为空";}
		else{$uphone= test_input($_POST["uphone"]);}
		
		if (empty($_POST["umail"])){    $umailErr= "联系邮箱不能为空";}
		else{$umail= test_input($_POST["umail"]);}
		
	}   



	if($unameErr==""&&$upswErr==""&&$upsw2Err==""&&$uphoneErr==""&&$umailErr==""&&$uname!=""&&$upsw!=""&&$upsw2!=""&&$uphone!=""&&$umail!="")
	{
		$sql ="INSERT INTO `user` (`uid`, `uname`, `upsw`, `uphone`, `umail`) VALUES (NULL, '".$uname."', '".$upsw."', '".$uphone."', '".$umail."');";
		
		//$sql="INSERT INTO `user` (`uid`, `uname`, `upsw`, `uphone`, `umail`) VALUES (NULL, 'john123', '123456', '18207148997', '1245333655@qq.com');";
		$res=mysql_query($sql);
		
			if(!$res)
			{
			$regMessage="该用户名已被占用";
			
			}
			else
			{
			$regMessage="注册成功";	
			header("location:signon.php");
			}
			

	}

?>


<div class="register-form">
			
			<div class="register-top">
				<h1>创建自己的LOGISTICS账户</h1>
				<h2>已有LOGISTICS账户？<a href="./signon.php">登陆</a></h2>
				 <form id="form2" name="form2" method="post" action="register.php">
					<span class="hint">用户名：</span> <span class="error">*<?php echo $unameErr;?><?php echo $regMessage;?></span><div class="clear"> </div>
					<div class="register-ic">
						<input name="uname" value="" type="text"  />
						<div class="clear"> </div>
					</div>
					
					<span class="hint">密码：</span> <span class="error">*<?php echo $upswErr;?></span><div class="clear"> </div>
					<div class="register-ic">
						<input name="upsw" value="" type="password" />
						<div class="clear"> </div>
					</div>
				
					<span class="hint">确认密码：</span> <span class="error">*<?php echo $upsw2Err;?></span><div class="clear"> </div>
					<div class="register-ic">
						<input name="upsw2" value="" type="password" />
						<div class="clear"> </div>
					</div>
					
					<span class="hint">联系电话：</span> <span class="error">*<?php echo $uphoneErr;?></span><div class="clear"> </div>
					<div class="register-ic">
						<input name="uphone" value="" type="number"/>
						<div class="clear"> </div>
					</div>
					
					<span class="hint">联系邮箱：</span> <span class="error">*<?php echo $umailErr;?></span><div class="clear"> </div>
					<div class="register-ic">
						<input name="umail" value="" type="email" />
						<div class="clear"> </div>
					</div>
					
					
					
					<div class="log-bwn">
						<input type="submit"  value="注册" />
					</div>
				</form>

				<div class="mart log-bwn">
					<a href="./signon.php">登陆账户</a>
				</div>
				
			</div>
			
			<div class="message">
						<ul>
						<li>&copy; MyLogistics</li>
						<li>|</li>
						<li><a href=" https://www.baidu.com/
						"> 使用条款</a></li>
						<li>|</li>
						<li><a href="./signon_courier.php">
						派送员登陆
						</a></li>
						</ul>
				</div>	
			
</div>	

	
</body>
</html>