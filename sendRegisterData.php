<?php
	header("Content-Type: text/html; charset=utf8");
	/*
	$link = mysqli_connect("localhost","root",
                          "root","test")
       or die("無法開啟MySQL資料庫連接!<br/>");
	$link -> set_charset("UTF8"); // 設定語系避免亂碼
	*/
	//判斷是否有submit操作
	if(!isset($_POST['submit']))
	{
		exit("錯誤執行");
	}	
	$name = $_POST["name"];
	$password = $_POST["password"];
	$tel = $_POST["tel"];
	$birthday = $_POST["birthday"];
	$address = $_POST["address"];
	/*
	if(($name != "" && $password != "" && $tel != "" && $birthday != "" && $email != "" 
	    && $address != ""))
		echo "好耶好耶太好了";*/
	include('userConnect.php');
	mysqli_select_db($con,'test');
	mysqli_set_charset($con,'utf8');
	$q="insert into 使用者資訊(address,password,name,birthday,tel) values ('$address','$password','$name','$birthday','$tel')";//向資料庫插入表單傳來的值的sql
	$reslut=mysqli_query($con,$q);//執行sql
	
	if (!$reslut)
	{
        die('Error: ' . mysqli_error($con));//如果sql執行失敗輸出錯誤
	}
	else
	{
        echo "註冊成功";//成功輸出註冊成功
    }
    mysqli_close($con);//關閉資料庫
?>