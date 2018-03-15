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
<?php
//导入mysql_connect.php模块
require 'mysql_connect.php';

//定义变量并默认设置为空值
$query="";$queryArray="";$oid=""; 
$oname="";$odes="";$ocid="";$ouid="";
$obll="";$oell="";$obegin="";$oend="";
$ocll="";$ostate="";$otime="";
$WRONG="";

	


//开启全局变量session
session_start();

$_SESSION['uname']="";
$_SESSION['upsw']="";
$_SESSION['uid']="";




//获取参数
$query=$_SERVER["QUERY_STRING"];

if(empty($_SESSION['cid'])){
	header("location:signon_courier.php");
}


//将字符串参数变为数组
function convertUrlQuery($query)
{
    $queryParts = explode('&', $query);
    $params = array();
    foreach ($queryParts as $param) {
        $item = explode('=', $param);
        @$params[$item[0]] = $item[1];
    }
    return $params;
}

$queryArray= convertUrlQuery($query);
@$oid=$queryArray['oid'];
if($oid){
$_SESSION['thiscod']=$oid;
}


if((!@$oid)&&(!$_SESSION['thiscod']))
{
	header("location:courier_order.php");
}
//echo $oid;
//echo $_SESSION['uid'];


$sql="SELECT * FROM `goods` WHERE oid = '".$_SESSION['thiscod']."'";
$result = mysql_query($sql);
if(!$result){echo "连接异常";}
while($row=mysql_fetch_array($result))
{
	$oname=$row['oname'];
	$odes=$row['odes'];	
	$ocid=$row['ocid'];	
	$ouid=$row['ouid'];	
	$obll=$row['obll'];	
	$oell=$row['oell'];	
	$obegin=$row['obegin'];	
	$oend=$row['oend'];
	$ocll=$row['ocll'];	
	$ostate=$row['ostate'];
	$otime=$row['otime'];
}
//防止用户误连接
//if($ocid!=$_SESSION['cid']){
	//header("location:courier_order.php");
//}

function test_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
}




	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
	if (empty($_POST["ocll"])){$ocll ="未确认";$ocllHint = "未确认";}else{$ocll = test_input($_POST["ocll"]);}
	$ostate =test_input($_POST["ostate"]);	
	
	$sqlcod ="UPDATE `goods` SET `ocll` = '".$ocll."', `ostate` = '".$ostate."' WHERE `goods`.`oid` = ".$_SESSION['thiscod'].";";
	$rescod=mysql_query($sqlcod);
	
	//echo $_SESSION['thiscod'];
	//echo '<script>location.href="test.php?"</script>';
	}


	
?>
<script type="text/javascript" src="./js/LuShu_min.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=9GLFPkT67SumdaSeXiu53GZblxBPX7mu"></script>

<script type="text/javascript" src="./js/jquery.js"></script>

</head>



<body>

	
<div class="order_add">
			
			<div class="order_add_container">
				
				 <form id="form4" name="form4" method="post" action="courier_order_detail.php">
					<h1>配送状态<?php echo $WRONG;?></h1>
					
				 
				 
				 
					<span class="hint">配送员：</span> <div class="clear"> </div>
					<div class="register-ic">
						<input name="uname" value="<?php echo $_SESSION['cname'];?>" type="text" readonly="readonly"  />
						<div class="clear"> </div>
					</div>
					
					<span class="hint">配送详情：</span> <div class="clear"> </div>
					<div class="register-ic">
						<select name="ostate">
							<option value ="0" <?php if($ostate==0){echo "selected=\"selected\"";};?>>已下单，正等待派送员接单……</option>
							<option value ="1" <?php if($ostate==1){echo "selected=\"selected\"";};?>>派送员已接单，正在派送中……</option>
							<option value ="2" <?php if($ostate==2){echo "selected=\"selected\"";};?>>订单已签收</option>
							<option value ="3" <?php if($ostate==3){echo "selected=\"selected\"";};?>>其他情况</option>
						</select>
						<div class="clear"> </div>	
					</div>
					
					<!--地图容器-->
					<span class="hint">当前配送位置：</span> <div class="clear"> </div>
					<div class="register-ic">
						<input id="ocll" name="ocll" value="<?php echo $ocll;?>" type="text" readonly="readonly"/>
						<div class="clear"> </div>
					</div>
					<div id="allmap"></div>
					
					<div id="toggle-bwn">
							<input type="button" id="tbutton" onclick="removeElement()" value="订单详情" />
						<div class="clear"> </div>
					</div>	
				<div id="togglediv">
				
					<span class="hint">发货地址：</span> <div class="clear"> </div>
					<div class="register-ic">
						<input id="obegin" name="obegin" value="<?php echo $obegin;?>" type="text" readonly="readonly"/>
						<div class="clear"> </div>
					</div>
					
					<span class="hint">收货地址：</span><div class="clear"> </div>
					<div class="register-ic" style="display:flex;">
						<input id="oend" name="oend" value="<?php echo $oend;?>" type="text" />
						<div class="clear"> </div>
					</div>
					
					<span class="hint">订单名：</span></span><div class="clear"> </div>
					<div class="register-ic">
						<input name="oname" value="<?php echo $oname;?>" type="text" readonly="readonly" />
						<div class="clear"> </div>
					</div>
					
				
					<span class="hint">订单描述：</span> <div class="clear"> </div>
					<div class="register-ic">
						<textarea name="odes" row="2" style="color:#FFF" type="text" readonly="readonly"><?php echo $odes;?></textarea>
						<div class="clear"> </div>
					</div>
					
					<span class="hint">指定派送员：</span><div class="clear"> </div>
					<div class="register-ic">			
						<input name="ocid" value="<?php
							$sql="SELECT cname FROM `courier` WHERE cid = '".$ocid."'";
							$result = mysql_query($sql);
							if(!$result){echo "网络连接异常";}
							while($row=mysql_fetch_array($result))
							{
								echo $row['cname'];	
							}
							?>" type="text" readonly="readonly" />
						<div class="clear"> </div>
					</div>
					
					<span class="hint">下单时间：</span> <div class="clear"> </div>
					<div class="register-ic">
						<input id="otime" name="otime" value="<?php echo $otime;?>" type="text" readonly="readonly"/>
						<div class="clear"> </div>
					</div>
		</div>
					
					<div class="fff-bwn">
							<input type="submit"  value="修改配送状态" />
						<div class="clear"> </div>
					</div>	
					
					
					
					
					
					
				</form>

				
				
			
			</div>
			
			
</div>	
</body>
</html>
<script type="text/javascript">
//alert(11111111);

	var ocs;
	var ocpoint;
	var ocmarker;
	var obstr="<?php echo $obll?>";
	var obs=obstr.split(","); //字符分割
	var oestr="<?php echo $oell?>";
	var oes=oestr.split(","); //字符分割*/
	
	
	var map = new BMap.Map('allmap');
	map.setMapStyle({style:'grayscale'});
	map.enableScrollWheelZoom();
	map.centerAndZoom(new BMap.Point(116.404, 39.915), 13);
	
	var obpoint=new BMap.Point(obs[0],obs[1]);
	var oepoint=new BMap.Point(oes[0],oes[1]);
	var obicon = new BMap.Icon("./image/map/obegin.png", new BMap.Size(50,50));
	var oeicon = new BMap.Icon("./image/map/oend.png", new BMap.Size(50,50));
	var ocicon=  new BMap.Icon("./image/map/Mario.png",new BMap.Size(32,70));
	var obmarker = new BMap.Marker(obpoint,{icon:obicon}); 
	var oemarker = new BMap.Marker(oepoint,{icon:oeicon});
	map.addOverlay(obmarker);
	map.addOverlay(oemarker);
	//map.addOverlay(obpoint);
	
	var ocstr="<?php echo $ocll?>";
	if(ocstr!="")
	{
		ocs=ocstr.split(","); //字符分割*/
		ocpoint=new BMap.Point(ocs[0],ocs[1]);
		ocmarker = new BMap.Marker(ocpoint,{icon:ocicon});
		map.addOverlay(ocmarker);
	};
	
	
	
	//var ocmarker;
	var arrPois =[];
	
	map.addEventListener("click",function(e){
		point=e.point;
		ocmarker=new BMap.Marker(point,{icon:ocicon});
		ocll=point.lng+","+point.lat;
		//alert(ocll);
		$('#ocll').val(ocll);
		map.clearOverlays(); 
		map.addOverlay(ocmarker);
		map.addOverlay(obmarker);
		map.addOverlay(oemarker);
		map.addOverlay(new BMap.Polyline(arrPois, {strokeColor: '#111'}));
	});
	
	var lushu;
	// 实例化一个驾车导航用来生成路线
    var drv = new BMap.DrivingRoute('北京', {
        onSearchComplete: function(res) {
            if (drv.getStatus() == BMAP_STATUS_SUCCESS) {
                var plan = res.getPlan(0);
                arrPois =[];
                for(var j=0;j<plan.getNumRoutes();j++){
                    var route = plan.getRoute(j);
                    arrPois= arrPois.concat(route.getPath());
                }
                map.addOverlay(new BMap.Polyline(arrPois, {strokeColor: '#111'}));
                map.setViewport(arrPois);
                
                lushu = new BMapLib.LuShu(map,arrPois,{
                defaultContent:"",//"从天安门到百度大厦"
                autoView:true,//是否开启自动视野调整，如果开启那么路书在运动过程中会根据视野自动调整
                icon  : new BMap.Icon("./image/map/Mario.png",new BMap.Size(32,70)),
                speed: 4500,
                enableRotation:true,//是否设置marker随着道路的走向进行旋转
                });          
            }
        }
    });
	drv.search(obpoint,oepoint);
	
	</script>



<script>

$(document).ready(function(){
	$("#togglediv").hide();
  $("#tbutton").click(function(){
    //$("#div1").fadeToggle();
    //$("#div2").fadeToggle("slow");
    $("#togglediv").fadeToggle(1000);
  });
});


</script>

