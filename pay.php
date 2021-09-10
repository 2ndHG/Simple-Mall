<!DOCTYPE html>
<html lang="en">
<?php
	session_start();
	
	$address = $_SESSION["address"];
	//連接資料庫
	include('userConnect.php');
	mysqli_select_db($con,'test');
	mysqli_set_charset($con,'utf8');
	
	$data = "";
	
	$sql = "SELECT id, stock_id, amount FROM cart WHERE address='$address'";
	$result = mysqli_query($con, $sql);
	if(!$result)
	{
		die("尋找購物車時出現錯誤");
	}
	
	while($row = $result->fetch_assoc())
	{
		//商品id
		$stock_id = $row["stock_id"];

		//取得商品資訊
		$sql2 = "SELECT name, price, address FROM stock WHERE id='$stock_id'";
		$result2 = mysqli_query($con, $sql2);
		if(!$result2)
		{
			die("尋找商品資訊時出現錯誤");
		}
		$row2 = $result2->fetch_assoc();
		//金額數量相乘結果
		$m = $row['amount'] * $row2['price'];
		
		$data = $data.$address." 用 $".(string)($m)." 向 ".$row2['address']." 買了 ".$row['amount']." 個 ".$row2['name']."\n";
	}
?>


<head>
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
		<button id="btn" class="enableEthereumButton">連接</button>
		<h2>Account: <span class="showAccount"></span></h2>
		<input type="button" id="btn" onclick=getMsg() value="取值">
		<input type="button" id="btn" onclick=setMsg() value="寫入">
		<input type="button" id="btn" onclick=sendTransaction() value="送錢給紹哥">
		
		<h3>欲傳送的資料:</h3>
		<p id="dataToSend"><?php echo $data?></p>
		<!--h2><span class="getStaus"></span></h2--> 
		<form name="form" id="form">
			請輸入文字:
			<input type="text" name="data" id="data">
		</form>
		
		<h2>乙太幣的 Transaction Hash: <span id="ethTransactionHash"></span></h2>
		<h2>訊息的 Transaction Hash: <span class="transactionHash1"></span></h2>
		<br>
		<br>
		<h2>將hash寫入資料庫<h2/>
		<div style="background-color:#FBF396">
			<form name="form" id="form" action="saveTransactionHash.php" method="post" >
				<p>交易對象:</p>
				<input type="text" name="m_address" value='<?php echo $row2['address'] ?>'>
				<p>交易Hash值:</p>
				<input type="text" id="hashToSave" name="hashToSave" value=''>
				<br>
				<input type="submit" name='saveHash' onclick='' value='將hash寫入資料庫'>
			</form>
		</div>
	</div>
</body>
<script type="text/javascript">
	
		var account = null;
		var accounts = null;
		const getStaus = document.querySelector('.getStaus');
		const ethereumButton = document.querySelector('.enableEthereumButton');
        const showAccount = document.querySelector('.showAccount');
        const transactionHash1 = document.querySelector('.transactionHash1');
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
		//}
		
		/*window.addEventListener('load',async function(){
			start();
            getAccount();

        });*/
		

	

          
        //寫入訊息       
        function setMsg(moneyHash){
        	const form = document.forms["form"];
        	const dae = form.elements.data.value;
			var dataToSend = document.getElementById('dataToSend').innerHTML;
			
			
        	ContractTeat.methods.setMSG1(dataToSend).send({ from: account },function(error,transactionHash){
                if(error){
                    console.log(error)
                }else{
                    console.log(transactionHash)
                    transactionHash1.innerHTML = transactionHash;
					hashToSave.value = transactionHash;
                }
            })
        };
        

        //取得訊息
        function getMsg(){
        	ContractTeat.methods.get().call(function(error, result){
        		if(error){
        			getStaus.innerHTML = "NOT found"
                return;
            	}else{
        			getStaus.innerHTML = ("found: "+result);
        		}
        	});
        }
		
		//傳錢
		function sendTransaction()
		{
			//紹哥的帳號
//			var receiver = "0xbf64038974D1f84CC25067724B549AB70329b656";  
//			var sender = web3.eth.accounts[0];
//			web3.eth.sendTransaction({to:receiver,
//                        from:sender, 
//                       value:web3.toWei("0.01", "ether")}
//                        ,function (err, res){});
//			console.log(err, res);
			web3.eth.sendTransaction({
			from:account,	//如果from為空，預設取this.web3.eth.defaultAccount
			to:'0x96B4250b8F769Ed413BFB1bb38c5d28C54f81618',
			value:10000000000000000, //傳送的金額，這裡是0.01 ether
			gas: 21000 //一個固定值，可選
			}).on('transactionHash', function(hash){
					console.log(hash);
					document.getElementById('ethTransactionHash').innerHTML = hash;
					document.getElementById('dataToSend').innerHTML = hash +" " + document.getElementById('dataToSend').innerHTML;	
					setMsg();
				})
				
			
			
		}

</script>

</html>
