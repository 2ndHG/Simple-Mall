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
<title>userIndex.php</title>
</head>

<body>
	
	<div align="center" style="background-color:#96EE7E;padding:10px;margin-bottom:5px;">
		<p>
		 <?php 
			$welcome = '你好! ';
			$r = rand(0, 3);
			switch($r)
			{
				case 1:
				$welcome = '歡迎! ';
				break;
				case 2:
				$welcome = '祝你有個美好的一天! ';
				break;
				case 3:
				$welcome = 'WOW 你來了! ';
				break;
			}
			echo $welcome.$_SESSION["address"]; 
		?>
		</p>
		
		
		
		<button type="button" onclick="location.href='merchantList.php'"><center>瀏覽攤商列表</button>
		<br>
		<br>
		<button type="button" onclick="location.href='userRecord.php'"><center>查看交易紀錄</button>
	</div>
</body>
</html>