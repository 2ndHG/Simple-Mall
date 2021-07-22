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
	// 如果點選刪除購物車
	if ( isset($_POST["delete_stock"]) )
	{
		$id = $_POST["stock_id"];
		$sql = "DELETE FROM stock WHERE id='$id'";
		$delete_result = mysqli_query($con, $sql);
		if(!$delete_result)
			echo "刪除失敗";
	}
	
	
	$sql = "SELECT id, name, img, intro, price, amount FROM stock WHERE address='$address'";

	$result = mysqli_query($con, $sql);
?>
<html>
<head>
	<title>myShop.php</title>
</head>
<body>
	<div class="w3-container" style="text-align:center">
	
	<h2>我的商店</h2>
	<button type="button" onclick="location.href='upload.html'"><center>上傳商品</button>
	<br><br>
	<?php
		while($row = $result->fetch_assoc())
		{//左括號
			$r = $g = $b = 180;//淡麗清新彩色的根基
			$r += rand(0, 70); //加點隨機
			$g += rand(0, 70);
			$b += rand(0, 70);
			$color=dechex($r*256*256 + $g*256 + $b);
	?>
		<div style="background-color:#<?php echo $color; ?>;padding:10px;margin-bottom:5px;">
			<?php 
				echo "<h2>".$row["name"]."</h2>"; 
				echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['img'] ).'"/>';
				echo "<h4>描述:</h4>";
				echo "<p>".$row["intro"]."</p>"; 
				echo "<h4>價格:</h4>";
				echo "<p>".$row["price"]."</p>";
				echo "<h4>剩餘數量:</h4>";
				echo "<p>".$row["amount"]."</p>";
			?>
			<form action="mySHop.php" target="_blank" method="post" >
			<!--這裡藏了一個表單，可以用來傳遞商品id-->
			<input hidden name="stock_id" value=<?php echo $row['id'];?>>
			<input type="submit" name="delete_stock" style="width:100px" value="下架"/>
			</form>
			<br>
		</div>
	<?php
		}//右括號
	?>
	</div>
</body>
<?php 	mysqli_close($con);//關閉資料庫 ?>
</html>