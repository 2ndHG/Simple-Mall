<!DOCTYPE html>


<?php
	session_start();

	//已點擊任一商家
	if (isset($_POST["owner"]))
	{
		$_SESSION["owner"] = $_POST["owner"];
		header("Location: shop.php");
	}
	

	include('userConnect.php');
	mysqli_select_db($con,'test');
	mysqli_set_charset($con,'utf8');
	$sql = "SELECT m_name, m_address FROM merchant";
	$result = mysqli_query($con, $sql);
	if (!$result)
	{
		die('錯誤!Error: ' . mysqli_error($con));//如果sql執行失敗輸出錯誤
	}
?>
<html>
<head>
	<title>MerchantList.php</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<style>
	p {text-align: center; font-size:24px}
	.button {
		border: none;
		color: white;
		padding: 15px 32px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
	}
	</style>
</head>

<body>
	<?php
    function GoToShop(){
        echo "clicked!";
		//location.href = "http://www.google.com/";
		//header("Location: shop.php");
    }
	?>
	
	<div class="w3-container" style="text-align:center">
		<h1>攤商列表</h1>
	<?php
		
		//echo "找到".$result->num_rows."筆資料" ;
		while($row = $result->fetch_assoc())
		{//左括號
			$r = $g = $b = 180;//淡麗清新彩色的根基
			$r += rand(0, 70); //加點隨機
			$g += rand(0, 70);
			$b += rand(0, 70);
			$color=dechex($r*256*256 + $g*256 + $b);
	?>
		<div style="background-color:#<?php echo $color; ?>;padding:10px;margin-bottom:5px;">
		<p><?php echo $row["m_name"]; ?></p>
		
		<!--<button type="button" onclick='GoToShop()'>進入攤商頁面</button> -->
		<form action="merchantList.php" method="post" >
			<!--這裡藏了一個表單，方便紀錄和傳遞商家的帳號-->
			<input hidden name="owner" value="<?php echo $row['m_address'];?>">
			<input type="submit" value="進入攤商頁面"/>
		</form>
		<br>
		<br>
		</div>
	<?php
		}//右括號
	?>
	</div>
</body>
<?php mysqli_close($con);//關閉資料庫 ?>
</html>