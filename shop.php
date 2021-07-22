<!DOCTYPE html>
<?php 
	session_start();
	
	$owner = $_SESSION["owner"];
	//連接資料庫
	include('userConnect.php');
	mysqli_select_db($con,'test');
	mysqli_set_charset($con,'utf8');
	
	$sql = "SELECT id, name, img, intro, price, amount FROM stock WHERE address='$owner'";
	$result = mysqli_query($con, $sql);
?>
<html>
<head>
	<title>shop.php</title>
</head>
<body>
	<div class="w3-container" style="text-align:center">
	
	<?php
		echo "<h1>歡迎來到".$_SESSION["owner"]."的商店</h1>";
	?>
	<button onclick="location.href='myCart.php'">檢視我的購物車</button>
	<br>
	<br>
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
				echo "<p>".$row["intro"]."</p>"; 
				echo "<h4>價格:</h4>";
				echo "<p>".$row["price"]."</p>";
				echo "<h4>剩餘數量:</h4>";
				echo "<p>".$row["amount"]."</p>";
			?>
			<form action="addToCart.php" target="_blank" method="post" >
			<!--這裡藏了一個表單，可以用來傳遞商品id-->
			<input hidden name="stock_id" value=<?php echo $row['id'];?>>
			<label for="amount">數量:</label>
			<input type="number" name="amount" value=1 />
			<input type="submit" name="submit" style="width:100px" value="加入購物車!"/>
			</form>
			<br><br>
		</div>
	<?php
		}//右括號
	?>
	</div>
</body>
<?php 	mysqli_close($con);//關閉資料庫 ?>
</html>