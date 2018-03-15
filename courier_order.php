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

$_SESSION['uname']="";
$_SESSION['upsw']="";
$_SESSION['uid']="";

$_SESSION['thiscod']="";



if(empty($_SESSION['cid'])){
	header("location:signon_courier.php");
}

function test_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
}


	
?>


<div class="order_add">
			
			<div class="order_add_container">
			
			<div class="border" style="border-top:1px solid rgba(255,255,255,0.55);">
				
				<h1>我的订单</h1>
				
				 <form id="form6" name="form6" method="" action="courier_order.php">
					
					<span class="hint">配送员：</span> <div class="clear"> </div>
					<div class="register-ic">
						<input name="uname" value="<?php if(empty($_SESSION['cid'])){echo "不合法的登陆";}else{echo $_SESSION['cname'];}?>" type="text" readonly="readonly"  />
						<div class="clear"> </div>
					</div>
					
					<span class="hint">配送员状态：</span> <div class="clear"> </div>
					<div class="register-ic" style="display:flex;">
						<select name="cstate" style="flex:3;">
							<option value="0">空闲（用户派单界面将显示接收指派）</option>
							<option value="1">忙碌（用户派单界面不显示接收指派）</option>
						</select>
						<input type="submit" style="flex:1;"  value="确认修改" />
						<div class="clear"> </div>
					</div>
					
					<span class="hint">指定配送以下订单：</span> <div class="clear"> </div>
					
					<?php
							$sql="SELECT * FROM `goods` WHERE ocid ='".$_SESSION['cid']."'";
							$result = mysql_query($sql);
							if(!$result){echo "<div class='register-ic'><input value='网络连接异常' type='text' readonly='readonly'><div class='clear'> </div></div>";}
							while($row=mysql_fetch_array($result))
							{
								$sql2="SELECT uname FROM `user` WHERE uid='".$row['ouid']."'";
								$result2=mysql_query($sql2);
								while($row2=mysql_fetch_array($result2))
								{
									$uname=$row2['uname'];
								}
	
								echo "<div class='register-ic' style='margin-bottom:1px'>
						<input name='oname' value='".$row['oname']."' type='text' readonly='readonly'/>
						<div class='clear'> </div>
						<div style='display:flex;'>
						<input style='flex:11;' name='oname' value='".$uname."' type='text' readonly='readonly'/>|
						<input style='flex:8;' name='oname' value='".$row['otime']."' type='text' readonly='readonly'/>|&nbsp 
						<input class='getDetail' style='flex:4;font-size: 0.5em;' type='button' value='详情' onclick='location.href=\"courier_order_detail.php?oid=".$row['oid']."\"'/>
						</div>
						<div class='clear'> </div>
					</div>";
							}
							
					?>
					
					
					
				</form>
				<div style="margin-bottom:10px;"> </div>
				
				
			</div>
			</div>
			
			
</div>	

	
</body>
</html>