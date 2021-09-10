<?php
	header("Content-Type: text/html; charset=utf8");

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

	include('userConnect.php');
	mysqli_select_db($con,'test');
	mysqli_set_charset($con,'utf8');
	//讀取現有使用者id最大值
	$sql = "SELECT MAX(id) AS max_id FROM 使用者資訊";
	$result = mysqli_query($con, $sql);
	if (!$result)
	{
		die('錯誤!Error: ' . mysqli_error($con));//如果sql執行失敗輸出錯誤
	}
	//將編號+1當作此商品ID
	$row = $result->fetch_assoc();
	$id =  $row["max_id"]+1;
	
	
	$q="insert into 使用者資訊(id, address,password,name,birthday,tel) values ('$id', '$address','$password','$name','$birthday','$tel')";//向資料庫插入表單傳來的值的sql
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