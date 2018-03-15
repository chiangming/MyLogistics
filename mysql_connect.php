<?php
//连接数据库
$conn =mysql_connect("localhost","root","");

	//设置字符集为utf_8 //解决中文乱码问题
	mysql_query("SET NAMES 'utf8'");
	mysql_query("SET CHARACTER SET utf8");
	mysql_query("SET CHARACTER_SET_RESULT=utf8");
	
	if(!$conn){
		echo "数据库访问出现异常！";
		die(mysql_error());
	}
	
	mysql_select_db("mylogistics",$conn);
?>