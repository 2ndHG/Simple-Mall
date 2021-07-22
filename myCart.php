<!DOCTYPE html>
<?php 
	session_start();
	
	$address = $_SESSION["address"];
	//連接資料庫
	include('userConnect.php');
	mysqli_select_db($con,'test');
	mysqli_set_charset($con,'utf8');
	// 如果點選刪除購物車
	if ( isset($_POST["delete_cart"]) )
	{
		$id = $_POST["cart_id"];
		$sql = "DELETE FROM cart WHERE id='$id'";
		$delete_result = mysqli_query($con, $sql);
		if(!$delete_result)
			echo "刪除失敗";
	}
	
	
	$sql = "SELECT id, stock_id, amount FROM cart WHERE address='$address'";
	$result = mysqli_query($con, $sql);
?>
<html>
<head>
	<title>myCart.php</title>
</head>
<body>
	<div class="w3-container" style="text-align:center">
		<h1>我的購物車</h1>
		<input type="button" onclick="location.href='pay.php'" value="結帳">
	<?php
		while($row = $result->fetch_assoc())
		{//左括號
			$r = $g = $b = 180;//淡麗清新彩色的根基
			$r += rand(0, 70); //加點隨機
			$g += rand(0, 70);
			$b += rand(0, 70);
			$color=dechex($r*256*256 + $g*256 + $b);
			//商品id
			$stock_id = $row["stock_id"];
			//取得商品資訊
			$sql2 = "SELECT name, price FROM stock WHERE id='$stock_id'";
			$result2 = mysqli_query($con, $sql2);
			$row2 = $result2->fetch_assoc();
	?>
		<div style="background-color:#<?php echo $color; ?>;padding:10px;margin-bottom:5px;">
			<?php 
				echo "<h2>".$row2["name"]."</h2>";
				echo "<h4>金額:</h4>";
				echo "<p>".$row2["price"]."</p>";				
				echo "<h4>數量:</h4>";
				echo "<p>".$row["amount"]."</p>";
			?>
			<form action="myCart.php" method="post" >
			<!--這裡藏了一個表單，可以用來傳遞購物車id-->
			<input hidden name="cart_id" value=<?php echo $row['id'];?>>
			<input type="submit" name="delete_cart" style="width:100px" value="移除"/>
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