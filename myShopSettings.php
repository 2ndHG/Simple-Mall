<!DOCTYPE html>
<?php 
	session_start();
	
	if(!$_SESSION["isMerchant"])
		die("...你不是商家");
	$address = $_SESSION["address"];
	
	//連接資料庫
	include('userConnect.php');
	mysqli_select_db($con,'test');
	mysqli_set_charset($con,'utf8');

	
	$sql = "SELECT id FROM merchant WHERE m_address='$address'";
	$result = mysqli_query($con, $sql);
	if(!$result)
	{
		die('錯誤!!Error: ' . mysqli_error($con));//如果sql執行失敗輸出錯誤
	}
	$row = $result->fetch_assoc();
	$id = $row['id'];
	// 如果點選傳送設定，更新資料
	if ( isset($_POST["submitSetting"]) )
	{
		$deliveryBySelf = $_POST['deliveryBySelf'];
		echo $_POST['deliveryBySelf'];
		$deliveryByOther = $_POST['deliveryByOther'];
		echo $_POST['deliveryByOther'];
		
		$updateSql = "UPDATE shop_settings SET self_delivery = '$deliveryBySelf',  other_delivery = '$deliveryByOther' WHERE merchant_id='$id'";
		
		
		$updateResult = mysqli_query($con, $updateSql);
		if(!$updateResult)
			die('更新失敗!!Error: ' . mysqli_error($con));//如果sql執行失敗輸出錯誤
	}
	//抓取當前設定檔資料
	$settingSql = "SELECT merchant_id, self_delivery, other_delivery FROM shop_settings WHERE merchant_id='$id'";
	$settingResult = mysqli_query($con, $settingSql);
	$row = $settingResult->fetch_assoc();
	if(!isset($row['merchant_id']))
		echo '找不到資料，建立新檔案';
	//若還沒進行過設定，新增一個設定檔
	if(!isset($row['merchant_id']))
	{
		$deliveryByself = false;
		$deliveryByOther = false;
		$addSql = "INSERT into shop_settings(merchant_id, self_delivery, other_delivery) values ('$id', '$deliveryByself', '$deliveryByOther')";
		$addResult = mysqli_query($con, $addSql);
		if(!$addResult)
			die('新建資料錯誤!!Error: ' . mysqli_error($con));//如果sql執行失敗輸出錯誤
		//重新抓取資料
		$settingSql = "SELECT self_delivery, other_delivery FROM shop_settings WHERE merchant_id='$id'";
		$settingResult = mysqli_query($con, $settingSql);
		if(!$settingResult)
			die('錯誤!!Error: ' . mysqli_error($con));//如果sql執行失敗輸出錯誤
		$row = $settingResult->fetch_assoc();
		
	}



	
?>
<html>
<head>
	<title>mySetting.php</title>
</head>
<body>
	<div class="w3-container" style="text-align:center">
	
	<h2>設定</h2>
		<form action="myShopSettings.php" method="post" >
			<div style="background-color:#82FF82">
			<h3>送貨方式:</h3>
			<input type="checkbox" id="deliveryBySelf" name="deliveryBySelf" value=<?php echo $row['self_delivery']? 'yes': 'no' ?>>
			<label for="deliveryBySelf">老闆親送</label>
			<br>
			<input type="checkbox" id="deliveryByOther" name="deliveryByOther" value=<?php echo $row['other_delivery']? 'yes': 'no' ?>>
			<label for="deliveryByOther">外送</label>
			<br>
			<input type="submit" name="submitSetting" style="width:100px" value="傳送設定"/>
		</form>
	<br><br>
	</div>
</body>
<?php 	mysqli_close($con);//關閉資料庫 ?>
</html>