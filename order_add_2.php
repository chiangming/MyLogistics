<!DOCTYPE HTML>
<html>
<head>
<title>Logistics|我要下单</title>

<link href='./css/order/order_add.css' rel='stylesheet' type='text/css' media="all">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="register"/>

<style type="text/css">
	#allmap {
		width: 95%;
		height:300px;
		overflow: hidden;
		margin:0 auto 20px;
		font-family:"微软雅黑";}
</style>
<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=9GLFPkT67SumdaSeXiu53GZblxBPX7mu"></script>
</head>
<body>
<?php
//导入mysql_connect.php模块
require 'mysql_connect.php';

//定义变量并默认设置为空值
$obegin=""; $obll=""; $obname=""; $obphone="";
$obeginErr=""; $obllErr=""; $obnameErr=""; $obphoneErr="";

//开启全局变量session
session_start();
$_SESSION['cid']="";

if(empty($_SESSION['uname'])){
	header("location:signon.php");
}
if(empty($_SESSION['oname']||$_SESSION['odes']||$_SESSION['ocid'])){
	header("location:order_add_1.php");
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
		if (empty($_POST["obname"])){	$obnameErr = "发货用户名称不能为空!";}
		else{$obname = test_input($_POST["obname"]);}
		
		if (empty($_POST["obphone"])){	$obphoneErr = "发货用户联系电话不能为空!";}
		else{$obphone = test_input($_POST["obphone"]);}
		
		if (empty($_POST["obegin"])){	$obeginErr = "发货地址不能为空!";}
		else{$obegin = test_input($_POST["obegin"]);}
		
		if (empty($_POST["obll"])){    $obllErr= "请于地图上点击选取发货坐标";}
		else{$obll= test_input($_POST["obll"]);}
		
		$_SESSION['obegin']="";
		$_SESSION['obll']="";
	}   

	if($obegin!=""&&$obll!=""&&$obname!=""&&$obphone!=""&&$obnameErr==""&&$obphoneErr==""&&$obeginErr==""&&$obllErr=="")
	{		
			$_SESSION['obname']=$obname;
			$_SESSION['obphone']=$obphone;
			$_SESSION['obegin']=$obegin;
			$_SESSION['obll']=$obll;
			header("location:order_add_3.php");
	}
	
//	echo $_SESSION['uid'];//uid →→ ouid
//	echo $_SESSION['oname'];
//	echo $_SESSION['odes'];
//	echo $_SESSION['ocid'];

//	echo $_SESSION['obegin'];
//	echo $_SESSION['obll'];
	
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
				
				<h1>第二步</h1>
				
				 <form id="form4" name="form4" method="post" action="order_add_2.php">
					
					<span class="hint">发货用户：</span> <span id="obnameHint" class="error">*<?php echo $obnameErr;?></span><div class="clear"> </div>
					<div class="register-ic" style="display:flex;">
						<input id="obname" name="obname" type="text" />
						<div class="clear"> </div>
					</div>
					
					<span class="hint">发货用户联系电话：</span> <span id="obphoneHint" class="error">*<?php echo $obphoneErr;?></span><div class="clear"> </div>
					<div class="register-ic" style="display:flex;">
						<input  id="obphone" name="obphone" type="number" />
						<div class="clear"> </div>
					</div>
					
					
					<span class="hint">发货地址：</span> <span id="obeginHint" class="error">*<?php echo $obeginErr;?></span><div class="clear"> </div>
					<div class="register-ic" style="display:flex;">
						<input placeholder="发货地址" style="flex:3;" id="obegin" name="obegin" type="text" /><input id="getPoint" style="flex:1;" type="button" value="获取坐标" />
						<div class="clear"> </div>
					</div>
					
					
					<span class="hint">发货坐标：</span> <span class="error">*<?php echo $obllErr;?></span><div class="clear"> </div>
					<div class="register-ic hidden">
						<input placeholder="发货坐标" id="obll" name="obll" type="text" readonly="true" required="required"/>
						<div class="clear"> </div>
					</div>
					
					<!--地图容器-->
					<div id="allmap"></div>
					
					
					
					<div class="flex log-bwn">
						<div class="fl">
							<a href="./order_add_1.php">上一步</a>
						</div>
						<div class="fr">
							<input type="submit"  value="下一步" />
						</div>
						<div class="clear"> </div>
					</div>	
					
				</form>

				
				
			</div>
			</div>
			
			
</div>		
</body>
</html>
<script type="text/javascript">
	
	var map = new BMap.Map("allmap");
	map.setMapStyle({style:'grayscale'}); 
	var point = new BMap.Point(117.28269909,31.86694226);
	map.centerAndZoom(point,12);
	
	var geolocation = new BMap.Geolocation();
	geolocation.getCurrentPosition(function(r){
	if(this.getStatus() == BMAP_STATUS_SUCCESS){
		map.centerAndZoom(r.point,12);
		map.panTo(r.point);
	}
	else {
			map.centerAndZoom(point,12);
		}        
	},{enableHighAccuracy: true})
	var obll;
	
	$(function(){
   
    $('#getPoint').click(function(){
        if($('#obegin').val() == ''){
			document.getElementById("obeginHint").innerHTML="*发货地址不能为空!";
        }else{document.getElementById("obeginHint").innerHTML="*";}
        var adds = $('#obegin').val();
        getPoint(adds);
    })
})

	
	map.addEventListener("click",function(e){
		point=e.point;
		map.clearOverlays(); 
		map.addOverlay(new BMap.Marker(point));
		obll=point.lng+","+point.lat;
		$('#obll').val(obll);
	});
	
function getPoint(adds){  
	
	// 创建地址解析器实例
	var myGeo = new BMap.Geocoder();
	// 将地址解析结果显示在地图上,并调整地图视野
	myGeo.getPoint(adds, function(point){
		if (point) 
		{
			map.centerAndZoom(point, 16);
			map.clearOverlays(); 
			map.addOverlay(new BMap.Marker(point));
			obll=point.lng+","+point.lat;
			$('#obll').val(obll);
		}
		else
		{
			document.getElementById("obeginHint").innerHTML="*请填写详细的发货地址!";
			map.clearOverlays(); 
			$('#obll').val("");
		}
		
	}, "北京市");
}
	</script>
