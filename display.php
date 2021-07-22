<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php
	session_start(); 
	include('userConnect.php');
	mysqli_select_db($con,'test');
	mysqli_set_charset($con,'utf8');
	$sql = "SELECT * FROM stock WHERE address = 'm1@gmail.com'";
	$sth = $con->query($sql);
	$result=mysqli_fetch_array($sth);

	echo '<img src="data:image/jpeg;base64,'.base64_encode( $result['img'] ).'"/>';
?>
</body>
</html>