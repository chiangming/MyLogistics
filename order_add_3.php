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
$oend=""; $oell="";$oename=""; $oephone="";
$oendErr=""; $oellErr=""; $oenameErr=""; $oephoneErr="";

//开启全局变量session
session_start();

$_SESSION['cid']="";

if(empty($_SESSION['uname'])){
	header("location:signon.php");
}
if(empty($_SESSION['oname']||$_SESSION['odes']||$_SESSION['ocid'])){
	header("location:order_add_1.php");
}
if(empty($_SESSION['obegin']||$_SESSION['obll'])){
	header("location:order_add_2.php");
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
		if (empty($_POST["oename"])){	$oenameErr = "收货用户名称不能为空!";}
		else{$oename = test_input($_POST["oename"]);}
		
		if (empty($_POST["oephone"])){	$oephoneErr = "收货用户联系电话不能为空!";}
		else{$oephone = test_input($_POST["oephone"]);}
		
		if (empty($_POST["oend"])){	$oendErr = "收货地址不能为空!";}
		else{$oend = test_input($_POST["oend"]);}
		
		if (empty($_POST["oell"])){    $oellErr= "请于地图上点击选取收货坐标";}
		else{$oell= test_input($_POST["oell"]);}
		
		$_SESSION['oend']="";
		$_SESSION['oell']="";
	}   

	if($oend!=""&&$oell!=""&&$oename!=""&&$oephone!=""&&$oenameErr==""&&$oephoneErr==""&&$oendErr==""&&$oellErr=="")
	{		$_SESSION['oename']=$oename;
			$_SESSION['oephone']=$oephone;
			$_SESSION['oend']=$oend;
			$_SESSION['oell']=$oell;
			header("location:order_add.php");
	}
	
//	echo $_SESSION['uid'];//uid →→ ouid
//	echo $_SESSION['oname'];
//	echo $_SESSION['odes'];
//	echo $_SESSION['ocid'];

//	echo $_SESSION['obegin'];
//	echo $_SESSION['obll'];
//	echo $_SESSION['oend'];
//	echo $_SESSION['oell'];
//	echo $_SESSION['obname'];
//	echo $_SESSION['obphone'];
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
				
				<h1>第三步</h1>
				
				 <form id="form4" name="form4" method="post" action="order_add_3.php">
					<span class="hint">收货用户：</span> <span id="oendHint" class="error">*<?php echo $oenameErr;?></span><div class="clear"> </div>
					<div class="register-ic" >
						<input id="oename" name="oename" type="text" />
						<div class="clear"> </div>
					</div>
					
					<span class="hint">收货用户联系电话：</span> <span id="oendHint" class="error">*<?php echo $oephoneErr;?></span><div class="clear"> </div>
					<div class="register-ic" >
						<input id="oephone" name="oephone" type="number"/>
						<div class="clear"> </div>
					</div>
					
					
					<span class="hint">收货地址：</span> <span id="oendHint" class="error">*<?php echo $oendErr;?></span><div class="clear"> </div>
					<div class="register-ic" style="display:flex;">
						<input placeholder="收货地址" style="flex:3;" id="oend" name="oend" type="text" /><input id="getPoint" style="flex:1;" type="button" value="获取坐标" />
						<div class="clear"> </div>
					</div>
					
					
					<span class="hint">收货坐标：</span> <span class="error">*<?php echo $oellErr;?></span><div class="clear"> </div>
					<div class="register-ic hidden">
						<input placeholder="收货坐标" id="oell" name="oell" type="text" readonly="true" required="required"/>
						<div class="clear"> </div>
					</div>
					
					<!--地图容器-->
					<div id="allmap"></div>
					
					
					
					<div class="flex log-bwn">
						<div class="fl">
							<a href="./order_add_2.php">上一步</a>
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
	var oell;
	
	$(function(){
   
    $('#getPoint').click(function(){
        if($('#oend').val() == ''){
			document.getElementById("oendHint").innerHTML="*收货地址不能为空!";
        }else{document.getElementById("oendHint").innerHTML="*";}
        var adds = $('#oend').val();
        getPoint(adds);
    })
})

	
	map.addEventListener("click",function(e){
		point=e.point;
		map.clearOverlays(); 
		map.addOverlay(new BMap.Marker(point));
		oell=point.lng+","+point.lat;
		$('#oell').val(oell);
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
			oell=point.lng+","+point.lat;
			$('#oell').val(oell);
		}
		else
		{
			document.getElementById("oendHint").innerHTML="*请填写详细的收货地址!";
			map.clearOverlays(); 
			$('#oell').val("");
		}
		
	}, "北京市");
}
	</script>
