<?php

	$link = mysqli_connect("localhost","root",
                          "root","test")
       or die("無法開啟MySQL資料庫連接!<br/>");
	$link -> set_charset("UTF8"); // 設定語系避免亂碼
		
	if ( isset($_POST["name"]) )
	    $name = $_POST["name"];
	if ( isset($_POST["password"]) )
	    $password = $_POST["password"];
	if ( isset($_POST["tel"]) )
	    $tel = $_POST["tel"];
	if ( isset($_POST["birthday"]) )
	    $birthday = $_POST["birthday"];
	if ( isset($_POST["email"]) )
	    $email = $_POST["email"];
	if ( isset($_POST["address"]) )
	    $address = $_POST["address"];
	if(($name != "" && $password != "" && $tel != "" && $birthday != "" && $email != "" 
	    && $address != ""))
		echo "好耶好耶太好了";
?>