<!DOCTYPE html>

<?php session_start(); ?>
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
<title>merchantIndex.php</title>
</head>

<body>
	
	<div align="center" style="background-color:#96EE7E;padding:10px;margin-bottom:5px;">
		<p>
		 <?php 
			$welcome = '你好! ';
			echo $welcome.$_SESSION["address"]; ?>
		</p>
		
		
		
		<button type="button" onclick="location.href='upload.html'"><center>上傳商品</button>
		<br>
		<button type="button" onclick="location.href='myShop.php'"><center>我的商店</button>
		<br>
		<button type="button" onclick="location.href='merchantOrder.php'"><center>訂單紀錄</button>
	</div>
</body>