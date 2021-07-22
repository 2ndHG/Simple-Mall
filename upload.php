<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php
	session_start();  // 啟用交談期
	// 取得表單圖片
	if (isset($_POST['submit']))
	{
		/*
		if( isset($_FILES['image']['name']))
			echo $_FILES['image']['name'];
		else
			echo "沒有圖片";
		*/
		if(isset($_POST['name']) && isset($_POST['intro']) && isset($_POST['price'])
		&& isset($_POST['amount']) && isset($_FILES['image']['name']))
		{
			$address = $_SESSION["address"];
			$name = $_POST['name'];
			$intro = $_POST['intro'];
			$price  = $_POST['price'];
			$amount = $_POST['amount'];
			$date = date("Y/m/d");
			//圖片
			$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
			
			//連接資料庫
			include('userConnect.php');
			mysqli_select_db($con,'test');
			mysqli_set_charset($con,'utf8');
			
			//讀取現有貨品id最大值
			$sql = "SELECT MAX(id) AS max_id FROM stock";
			$result = mysqli_query($con, $sql);
			if (!$result)
			{
				die('錯誤!Error: ' . mysqli_error($con));//如果sql執行失敗輸出錯誤
			}
			//將編號+1當作此商品ID
			$row = $result->fetch_assoc();
			$id =  $row["max_id"]+1;
			
			//進行寫入
			$sql = "INSERT INTO stock (id, address, name, intro, img, price, amount, date) VALUES ('$id', '$address', '$name','$intro','$image','$price','$amount', '$date')";
			$result = mysqli_query($con, $sql);
			
			if (!$result)
			{
				die('錯誤!Error: ' . mysqli_error($con));//如果sql執行失敗輸出錯誤
			}
			else
			{
				echo "上傳成功";//成功上傳商品
			}
			mysqli_close($con);//關閉資料庫
		}
		else
			echo "資料不完全!";
		
	}
	else
	{
		echo "沒有經由提交表單來到此頁面";
	}
?>
</body>
</html>