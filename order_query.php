<!DOCTYPE HTML>
<html>
<head>
<title>Logistics|我要下单</title>

<link href='./css/order/order_add.css' rel='stylesheet' type='text/css' media="all">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="register"/>
</head>
<body>
<?php
//导入mysql_connect.php模块
require 'mysql_connect.php';

//开启全局变量session
session_start();

$_SESSION['cid']="";

if(empty($_SESSION['uname'])){
	header("location:signon.php");
}
	
?>


<div class="order_add">
			
			<div class="order_add_container">
			<div class="flex">
				<div class="fl frb">
					<a href="./order_add_1.php">新增订单</a>
				</div>
				<div class="fr flb">
					<p>我的订单</p>
				</div>
				<div class="clear"> </div>
			</div>	
			<div class="border">
				
				<h1>我的订单</h1>
				
				 <form id="form3" name="form3" method="post" action="order_add_1.php">
					
					<span class="hint">用户名：</span> <div class="clear"> </div>
					<div class="register-ic">
						<input name="uname" value="<?php if(empty($_SESSION['uname'])){echo "不合法的登陆";}else{echo $_SESSION['uname'];}?>" type="text" readonly="readonly"  />
						<div class="clear"> </div>
					</div>
					
					<span class="hint">订单：</span> <div class="clear"> </div>
					
					<?php
							$sql="SELECT * FROM `goods` WHERE ouid ='".$_SESSION['uid']."'";
							$result = mysql_query($sql);
							if(!$result){echo "<div class='register-ic'><input value='网络连接异常' type='text' readonly='readonly'><div class='clear'> </div></div>";}
							while($row=mysql_fetch_array($result))
							{
								echo "<div class='register-ic' style='display:flex;margin-bottom:1px'><input style='flex:2.5;' value='".$row['oname']."' type='text' readonly='readonly'/>|<input style='flex:2;' value='".$row['otime']."' type='text' readonly='readonly'/>|&nbsp <input class='getDetail' style='flex:1;' type='button' value='详情' onclick='location.href=\"order_query_detail.php?oid=".$row['oid']."\"'/><div class='clear'></div></div>";
							}
							?>
				</form>
				<div style="margin-bottom:10px;"> </div>
				
				
			</div>
			</div>
			
			
</div>	

	
</body>
</html>