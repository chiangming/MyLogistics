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

//定义变量并默认设置为空值
$oname=""; $odes=""; $ocid=""; $ocname="";
$onameErr=""; $odesErr=""; $ocidErr="";

//开启全局变量session
session_start();

$_SESSION['cid']="";

if(empty($_SESSION['uname'])){
	header("location:signon.php");
}

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
		if (empty($_POST["oname"])){	$onameErr = "订单名不能为空！";}
		else{$oname = test_input($_POST["oname"]);}
		
		if (empty($_POST["odes"])){    $odesErr= "订单描述不能为空";}
		else{$odes= test_input($_POST["odes"]);}
		
		if (empty($_POST["ocid"])){	$onameErr = "请指派配送员";}
		else{$ocid = test_input($_POST["ocid"]);}
		$_SESSION['oname']="";
		$_SESSION['odes']="";
	}   

	if($oname!=""&&$odes!=""&&$ocid!=""&&$onameErr==""&&$odesErr==""&&$ocidErr=="")
	{
			$_SESSION['oname']=$oname;
			$_SESSION['odes']=$odes;
			$_SESSION['ocid']=$ocid;
			header("location:order_add_2.php");
	}
	
//	echo $_SESSION['uid'];//uid →→ ouid
//	echo $_SESSION['oname'];
//	echo $_SESSION['odes'];
//	echo $_SESSION['ocid'];
	
?>


<div class="order_add">
			
			<div class="order_add_container">
			<div class="flex">
				<div class="fl flb">
					<p>新增订单</p>
				</div>
				<div class="fr frb">
					<a href="./order_query.php">我的订单</a>
				</div>
				<div class="clear"> </div>
			</div>	
			<div class="border">
				
				<h1>第一步</h1>
				
				 <form id="form3" name="form3" method="post" action="order_add_1.php">
					
					<span class="hint">用户名：</span> <div class="clear"> </div>
					<div class="register-ic">
						<input name="uname" value="<?php if(empty($_SESSION['uname'])){echo "不合法的登陆";}else{echo $_SESSION['uname'];}?>" type="text" readonly="readonly"  />
						<div class="clear"> </div>
					</div>
					
					<span class="hint">订单名：</span> <span class="error">*<?php echo $onameErr;?></span><div class="clear"> </div>
					<div class="register-ic">
						<input name="oname" value="" type="text"  />
						<div class="clear"> </div>
					</div>
					
				
					<span class="hint">订单描述：</span> <span class="error">*<?php echo $odesErr;?></span><div class="clear"> </div>
					<div class="register-ic">
						<textarea name="odes" row="2" placeholder="" type="text"></textarea>
						<div class="clear"> </div>
					</div>
					
					<span class="hint">指定派送员：</span> <span class="error">*<?php echo $ocidErr;?></span><div class="clear"> </div>
					<div class="register-ic">
						<select name="ocid">
						
						<?php
							$sql="SELECT * FROM `courier` WHERE cstate ='0'";
							$result = mysql_query($sql);
							if(!$result){echo "<option value='0'>'网络连接异常'</option>";}
							while($row=mysql_fetch_array($result))
							{
								echo "<option value=".$row['cid'].">".$row['cname']."</option>";	
							}
							
							?>
							
						</select>
						<div class="clear"> </div>
					</div>
					
					
					
					<div class="log-bwn">
						<input type="submit"  value="下一步" />
					</div>
				</form>

				
				
			</div>
			</div>
			
			
</div>	

	
</body>
</html>