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
<script type="text/javascript" src="http://api.map.baidu.com/library/LuShu/1.2/src/LuShu_min.js"></script>
</head>
<body>
<?php
//导入mysql_connect.php模块
require 'mysql_connect.php';

//定义变量并默认设置为空值
$query="";$queryArray="";$oid=""; 
$oname="";$odes="";$ocid="";$ouid="";
$obll="";$oell="";$obegin="";$oend="";
$ocll="";$ostate="";$otime="";

	


//开启全局变量session
session_start();

$_SESSION['cid']="";

if(empty($_SESSION['uname'])){
	header("location:signon.php");
}
//获取参数
$query=$_SERVER["QUERY_STRING"];

//将字符串参数变为数组
function convertUrlQuery($query)
{
    $queryParts = explode('&', $query);
    $params = array();
    foreach ($queryParts as $param) {
        $item = explode('=', $param);
        $params[$item[0]] = $item[1];
    }
    return $params;
}

$queryArray= convertUrlQuery($query);
$oid=$queryArray['oid'];
//echo $oid;
//echo $_SESSION['uid'];


$sql="SELECT * FROM `goods` WHERE oid = '".$oid."'";
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
	$obname=$row['obname'];
	$obphone=$row['obphone'];
	$oename=$row['oename'];
	$oephone=$row['oephone'];
	
}
//防止用户误连接
if($ouid!=$_SESSION['uid']){
	header("location:order_query.php");
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
				
				<h1>订单详情</h1>
				
				 <form id="form4" name="form4" method="" action="order_query_detail.php">
					<span class="hint">发货用户：</span> <div class="clear"> </div>
					<div class="register-ic" >
						<input id="obname" name="obname" value="<?php echo $obname;?>" type="text" readonly="readonly"/>
						<div class="clear"> </div>
					</div>
					
					<span class="hint">发货用户联系电话：</span><div class="clear"> </div>
					<div class="register-ic">
						<input  id="obphone" name="obphone" value="<?php echo $obphone;?>" type="text" readonly="readonly"/>
						<div class="clear"> </div>
					</div>
					
					<span class="hint">收货用户：</span><div class="clear"> </div>
					<div class="register-ic" >
						<input id="oename" name="oename" value="<?php echo $oename;?>" type="text" readonly="readonly"/>
						<div class="clear"> </div>
					</div>
					
					<span class="hint">收货用户联系电话：</span><div class="clear"> </div>
					<div class="register-ic" >
						<input id="oephone" name="oephone" value="<?php echo $oephone;?>" type="text" readonly="readonly"/>
						<div class="clear"> </div>
					</div>
					
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
					
					<span class="hint">配送状态：</span> <div class="clear"> </div>
					<div class="register-ic">
						<input id="ostate" name="ostate" value="<?php 
						if($ostate==0){echo "已下单，正等待派送员接单……";}
						if($ostate==1){echo "派送员已接单，正在派送中……";}
						if($ostate==2){echo "订单已签收";}
						if($ostate==3){echo "其他情况";}
						?>" type="text" readonly="readonly"/>
						<div class="clear"> </div>
					</div>
					
					<!--地图容器-->
					<div id="allmap"></div>
					
					<span class="hint">用户名：</span> <div class="clear"> </div>
					<div class="register-ic">
						<input name="uname" value="<?php echo $_SESSION['uname'];?>" type="text" readonly="readonly"  />
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

					
					
					
					
				</form>

				
				
			</div>
			</div>
			
			
</div>	
</body>
</html>
<script type="text/javascript">
	var ocs;
	var ocpoint;
	var ocmarker;
	
	var obstr="<?php echo $obll?>";
	var obs=obstr.split(","); //字符分割
	var oestr="<?php echo $oell?>";
	var oes=oestr.split(","); //字符分割
	
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
	
	var ocstr="<?php echo $ocll?>";
	if(ocstr!="")
	{
		ocs=ocstr.split(","); //字符分割*/
		ocpoint=new BMap.Point(ocs[0],ocs[1]);
		ocmarker = new BMap.Marker(ocpoint,{icon:ocicon});
		map.addOverlay(ocmarker);
	};
	
	var lushu;
	// 实例化一个驾车导航用来生成路线
    var drv = new BMap.DrivingRoute('北京', {
        onSearchComplete: function(res) {
            if (drv.getStatus() == BMAP_STATUS_SUCCESS) {
                var plan = res.getPlan(0);
                var arrPois =[];
                for(var j=0;j<plan.getNumRoutes();j++){
                    var route = plan.getRoute(j);
                    arrPois= arrPois.concat(route.getPath());
                }
                map.addOverlay(new BMap.Polyline(arrPois, {strokeColor: '#111'}));
                map.setViewport(arrPois);
                
                lushu = new BMapLib.LuShu(map,arrPois,{
                defaultContent:"派送员<?php $sql="SELECT cname FROM `courier` WHERE cid = '".$_SESSION['ocid']."'";
							$result = mysql_query($sql);
							if(!$result){echo "网络连接异常";}
							while($row=mysql_fetch_array($result))
							{
								echo $row['cname'];	
							} ?>",
                autoView:true,//是否开启自动视野调整，如果开启那么路书在运动过程中会根据视野自动调整
                icon  :new BMap.Icon("./image/map/Mario.png",new BMap.Size(32, 70),{imageOffset: new BMap.Size(0,0)}),
                speed: 4500,
                enableRotation:false,//是否设置marker随着道路的走向进行旋转
               });   
				//lushu.start();
            }
        }
    });
	drv.search(obpoint,oepoint);
	//绑定事件
	
	
	</script>	


