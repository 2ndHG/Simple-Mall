<!DOCTYPE html>
<html>
<head>
<style>
p {text-align: center;}
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}
</style>
<meta charset="utf-8" />
<title>login.php</title>
</head>

<body>
<?php
	session_start();  // 啟用交談期
	$address = "";  $password = "";
	// 取得表單欄位值
	if ( isset($_POST["address"]) )
	   $address = $_POST["address"];
	if ( isset($_POST["password"]) )
	   $password = $_POST["password"];
	//預設不是攤商
	$isMerchant = false;
	//若有打勾則isMerchant == true
	if ( isset($_POST["isMerchant"]) )
		$isMerchant = $_POST["isMerchant"];
	
	
// 檢查是否輸入使用者名稱和密碼
if ($address != "" && $password != "") {
   // 建立MySQL的資料庫連接 
   if(!$isMerchant)
   {
	   $link = mysqli_connect("localhost","root",
							  "","test")
			or die("無法開啟MySQL資料庫連接!<br/>");
	   //送出UTF8編碼的MySQL指令
	   mysqli_query($link, 'SET NAMES utf8'); 
	   // 建立SQL指令字串
	   $sql = "SELECT * FROM 使用者資訊 WHERE password='";
	   $sql.= $password."' AND address='".$address."'";
	   echo $address;
	   echo $password;
   }
   else
   {
	   $link = mysqli_connect("localhost","root",
							  "","test")
			or die("無法開啟MySQL資料庫連接!<br/>");
	   //送出UTF8編碼的MySQL指令
	   mysqli_query($link, 'SET NAMES utf8'); 
	   // 建立SQL指令字串
	   $sql = "SELECT * FROM merchant WHERE m_password='";
	   $sql.= $password."' AND m_address='".$address."'";
	   echo $address;
	   echo $password;
	   
   }
	if($isMerchant == true)
		echo "我是攤商";
	else
		echo "我是用戶";

   // 執行SQL查詢
   $result = mysqli_query($link, $sql);
   $total_records = mysqli_num_rows($result);
   // 是否有查詢到使用者記錄
   if ( $total_records > 0 ) {
		// 成功登入, 指定Session變數
		$_SESSION["login_session"] = true;
		$_SESSION["isMerchant"] = $isMerchant;
		$_SESSION["address"] = $address;
		header("Location: index.php");
   } else {  // 登入失敗
		echo "<center><font color='red'>";
		echo "使用者名稱或密碼錯誤!<br/>";
		echo "</font>";
		$_SESSION["login_session"] = false;
   }
   mysqli_close($link);  // 關閉資料庫連接  
}
?>
<form action="login.php" method="post" >
  <div align="center" style="background-color:#82FF82;padding:10px;margin-bottom:5px;">
    <br>
    <label for="address">電子郵件:</label>
    <input type="text" name="address" id="address" required autofocus/>
    <br>  
    <br> 
    <label for="password">密碼:</label>
    <input type="password" name="password" id="password" required/>
    <br>
	<br>
	<input type="checkbox" id="isMerchant" name="isMerchant" value=true>
	<label for="isMerchant"> 我是攤商</label>
	<br>
    <br>
    <input type="submit" value="登入"/>
  </div>
</form>
<br>
<div align="center" style="background-color:#77E9FF;padding:10px;margin-bottom:5px;">
    
    <p> 沒有帳號嗎?請註冊</p>
	<br>
	<button type="button" onclick="location.href='register.html'"><center>註冊</button>
</div>
<div align="center" style="background-color:#75845b;padding:10px;margin-bottom:5px;">
    
    <p>商家註冊</p>
	<br>
	<button type="button" onclick="location.href='mRegister.html'"><center>註冊</button>
</div>

<!-- 好吃的炸雞腿又來了-->
<div align="center" style="background-color:#985142;padding:10px;margin-bottom:5px;">
<img id="fried" src="">
<br>
<form action='http://localhost:3100/' target="_blank">
<input type="submit" name="submit" >前往IPFS</input>
</form>
<!--button onclick="chicken()">點我吃炸雞</button-->
</div>
<script>
function chicken()
{
	document.getElementById('fried').src='img/一口炸雞一口可樂.png';
}
</script>
</body>
</html>