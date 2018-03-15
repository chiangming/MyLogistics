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
	//$ocll=$row['ocll'];	
	//$ostate=$row['ostate'];
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