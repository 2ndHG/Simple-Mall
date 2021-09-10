<?php
	$server="localhost";//主機
	$db_username="root";
	$db_password="root";
	//$con = mysql_connect("localhost",$db_username,$db_password);//連結資料庫
	$con = mysqli_connect("localhost","root","")
	    or die ('連接資料庫失敗: ' . mysqli_error());;
	//if(!$con){
	//die("can't connect".mysqli_error());//如果連結失敗輸出錯誤
	//}
	//mysqli_select_db('test',$con);//選擇資料庫（我的是test）
?>