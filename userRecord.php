<!DOCTYPE html>
<?php 
	session_start();
	
	if($_SESSION["isMerchant"])
		die("比需使用使用者帳戶");
	$address = $_SESSION["address"];
	
	//連接資料庫
	include('userConnect.php');
	mysqli_select_db($con,'test');
	mysqli_set_charset($con,'utf8');
	// 如果點選刪除購物車
	
	if ( isset($_POST["confirm_record"]) )
	{
		echo "交易id: ".$_POST["record_id"]."已確認!";
		//$id = $_POST["record_id"];
		//$sql = "DELETE FROM record WHERE id='$id'";
		//$delete_result = mysqli_query($con, $sql);
		//if(!$delete_result)
		//	echo "刪除失敗";
	}
	
	
	
	$sql = "SELECT transaction_hash, id FROM record WHERE address='$address'";

	$result = mysqli_query($con, $sql);
	if (!$result)
	{
		die('錯誤!Error: ' . mysqli_error($con));//如果sql執行失敗輸出錯誤
	}
?>
<html>
<head>
	<title>userRecord.php</title>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js/dist/web3.min.js">
	</script>
	
    <script src="https://unpkg.com/@metamask/detect-provider/dist/detect-provider.min.js">
	</script>
	
	<script language="javascript" type="text/javascript" src="abi.js">
	</script>
</head>
<body>
	<div class="w3-container" style="text-align:center">
	
	<h2>我的購買紀錄</h2>
	<button id="btn" class="enableEthereumButton">連接</button>
	<h3>MetaMask帳戶:</h3>
	<p><span class="showAccount"></span></p>
	<br><br>
	<?php
		while($row = $result->fetch_assoc())
		{//左括號
			$r = $g = $b = 180;//淡麗清新彩色的根基
			$r += rand(0, 70); //加點隨機
			$g += rand(0, 70);
			$b += rand(0, 70);
			$color=dechex($r*256*256 + $g*256 + $b);
			$id = $row["id"];
	?>
		<div style="background-color:#<?php echo $color; ?>;padding:10px;margin-bottom:5px;">
			<?php 
			
				echo "<h2>交易編號</h2>"; 
				echo "<p>".$row["id"]."</p>"; 
				echo "<h2>交易Hash:</h2>"; 
				echo "<p id=".$id.">".$row["transaction_hash"]."</p>";
				
				echo "<button onclick=getMsg('.getStaus".$id."', ".$row["transaction_hash"]."')>詳情:</button>"; 
				echo "<p class='getStaus".$id."'></p>";
			?>
			<form action="userRecord.php" target="_blank" method="post" >
			<!--這裡藏了一個表單，可以用來傳遞交易id-->
			<input hidden name="record_id" value=<?php echo $id;?>>
			<input type="submit" name="confirm_record" style="width:300px" value="商品已到我手中!"/>
			</form>
			<br>
		</div>
	<?php
		}//右括號
	?>
	</div>
</body>
<?php 	mysqli_close($con);//關閉資料庫 ?>

<script type="text/javascript">
	
		var account = null;
		var accounts = null;
		var getStaus = document.querySelector('.getStaus');
		const ethereumButton = document.querySelector('.enableEthereumButton');
        const showAccount = document.querySelector('.showAccount');
        var transactionHash1 = document.querySelector('.transactionHash1');
		var web3;

		ethereumButton.addEventListener('click', () => {
  			getAccount();
		});


		async function getAccount() {
            accounts = await ethereum.request({ method: 'eth_requestAccounts' });
            account = accounts[0];
            showAccount.innerHTML = account;
        };

        if (typeof window.ethereum !== 'undefined') {
            console.log('MetaMask is installed!');
        }else{
            console.log("uninstalled");
        };


		if (typeof window.ethereum !== 'undefined') {
            //var web3 = new Web3(web3.currentProvider);
            var web3 = new Web3(window.ethereum)
            console.log(web3);
        }else{
            // set the provider you want from Web3.providers
            
            var web3 = new Web3(new Web3.providers.HttpProvider(
                'HTTP://127.0.0.1:7545'
            ));
            console.log(web3);
        }



		//function start(){
			var ContractAddress = '0x40509BeC520bc4abBbc44B6f6067Dd5c4c721AC8';
			console.log(testabi);
				ContractTeat= new web3.eth.Contract(testabi, ContractAddress);
			console.log(ContractTeat)

        //取得訊息
        function getMsg(stausId, tHash){
			transactionHash1 = tHash;
			getStaus = document.querySelector(stausId);
			
        	ContractTeat.methods.get().call(function(error, result){
        		if(error){
        			getStaus.innerHTML = "NOT found"
                return;
            	}else{
        			getStaus.innerHTML = ("found: "+result);
        		}
        	});
        }

</script>
</html>