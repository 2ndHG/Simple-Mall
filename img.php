<?php
	
	function uploadimg($imgnewname){
		// 	允許上傳的圖片字尾
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["file"]["name"]);

	$extension = end($temp);     // 獲取檔案字尾名
	
	if ((($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/jpg")
		|| ($_FILES["file"]["type"] == "image/pjpeg")
		|| ($_FILES["file"]["type"] == "image/x-png")
		|| ($_FILES["file"]["type"] == "image/png"))
		&& ($_FILES["file"]["size"] < 204800)   // 小於 200 kb
		&& in_array($extension, $allowedExts)){
    		if ($_FILES["file"]["error"] > 0){
        		echo "錯誤：: " . $_FILES["file"]["error"] . "<br>";
    		}else{
			//	上傳圖片的路徑
					$path = "../imgs";
        	//	獲取圖片真實名稱
					$imgname = $_FILES["file"]["name"];
			
			//	圖片新名字，使用者名稱.png/.jpg等
					$imgnew = $imgnewname . "." . $extension;
			//	使用者需要儲存的路徑+圖片名
					$userimg = $path."/".$imgnew;
					echo $userimg;
//					重新命名，此處報錯，需要修改
					rename(iconv('UTF-8', 'GBK',$imgname), iconv('UTF-8','GBK',$imgnew));
            // 如果 upload 目錄不存在該檔案則將檔案上傳到 imgs 目錄下
           			move_uploaded_file($_FILES["file"]["tmp_name"], $userimg);
            		
//          		傳遞給呼叫者儲存位置內容
            		return $userimg;
  			}
		}else{
    		echo "非法的檔案格式";
		}
	}
	

?>