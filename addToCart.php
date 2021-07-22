<?php
	session_start();
	header("Content-Type: text/html; charset=utf8");
	if(!isset($_POST['submit']))
	{
		exit("錯誤執行，需要透過商品頁面前往此頁面");
	}	
	$stock_id = $_POST["stock_id"];
	$amount = $_POST["amount"];
	$address = $_SESSION["address"];
	
	include('userConnect.php');
	mysqli_select_db($con,'test');
	mysqli_set_charset($con,'utf8');
	
	//讀取現有購物車id最大值
	$sql = "SELECT MAX(id) AS max_id FROM cart";
	$result = mysqli_query($con, $sql);
	if (!$result)
	{
		die('錯誤!Error: ' . mysqli_error($con));//如果sql執行失敗輸出錯誤
	}
	//將編號+1當作此商品ID
	$row = $result->fetch_assoc();
	$id =  $row["max_id"]+1;
	
	
	$q="insert into cart(id, stock_id, address, amount) values ('$id', '$stock_id', '$address', '$amount')";//向資料庫插入表單傳來的值的sql
	$reslut=mysqli_query($con,$q);//執行sql

	
	if (!$reslut)
	{
        die('Error: ' . mysqli_error($con));//如果sql執行失敗輸出錯誤
	}
	else
	{
        echo "新增成功";//成功輸出註冊成功
    }
    mysqli_close($con);//關閉資料庫
?>