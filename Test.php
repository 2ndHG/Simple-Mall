<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>PHP與MySQL建立網頁資料庫</title>
</head>
<body>
<?php
// 建立MySQL的資料庫連接 
$link = @mysqli_connect( 
            'localhost',  // MySQL主機名稱 
            'root',       // 使用者名稱 
            'root',  // 密碼 
            '測試資料庫');  // 預設使用的資料庫名稱 
if ( !$link ) {
    echo "MySQL資料庫連接錯誤!<br/>";
    exit();
}
else {
    
    echo "MySQL	資料庫test連接成功!<br/>";
}
echo "錯誤訊息：". $php_errormsg;

mysqli_close($link);  // 關閉資料庫連接
?>

</body>
</html>