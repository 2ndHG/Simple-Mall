<!DOCTYPE html>
<html lang="en">
<?php 
	session_start();
	
	$address = $_SESSION["address"];
	if ( !isset($_POST["saveHash"]) )
	    die("從錯誤的方法來到此頁面");
	
	if (!isset($_POST["hashToSave"]) )
		die("先前沒有產生hash值");
	else
		$hashToSave = $_POST["hashToSave"];
	
	//連接資料庫
	
	include('userConnect.php');
	mysqli_select_db($con,'test');
	mysqli_set_charset($con,'utf8');
	
	$sql = "SELECT MAX(id) AS max_id FROM record";
	$result = mysqli_query($con, $sql);
	if (!$result)
	{
		die('錯誤!Error: ' . mysqli_error($con));//如果sql執行失敗輸出錯誤
	}
	//將編號+1當作此hashID
	$row = $result->fetch_assoc();
	$id =  $row["max_id"]+1;
	
	
	$q="insert into record(id, address, transaction_hash) values ('$id', '$address', '$hashToSave')";//向資料庫插入表單傳來的值的sql
	$reslut=mysqli_query($con,$q);//執行sql
	if (!$result)
	{
		die('錯誤!Error: ' . mysqli_error($con));//如果sql執行失敗輸出錯誤
	}
	else
	{
		echo "成功";
	}
	
	mysqli_close($con);//關閉資料庫
?>
<html>

<head>


</head>

<body>


</body>

<script>

</script>
</html>