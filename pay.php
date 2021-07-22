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
    <script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js/dist/web3.min.js"></script>
    <script src="https://unpkg.com/@metamask/detect-provider/dist/detect-provider.min.js"></script>
	<script language="javascript" type="text/javascript" src="abi.js"></script>

</head>
<body>
	<h2><span class="getStaus"></span></h2> 
	<form name="form" id="form">
		請輸入文字:
		<input type="text" name="data" id="data">
	</form>
	<button id="btn" class="enableEthereumButton">連接</button>
    <h2>Account: <span class="showAccount"></span></h2>
    <h2>Transaction Hash:  <span class="transactionHash1"></span></h2>
	<input type="button" id="btn" onclick=getMsg() value="註冊">
	<input type="button" id="btn" onclick=setMsg() value="寫入">
	
	<p id="dataToSend"><?php echo $data?></p>
	
	<p>WEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE</p>
		
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
        function setMsg(){
        	const form = document.forms["form"];
        	const dae = form.elements.data.value;
			var dataToSend = document.getElementById('dataToSend').innerHTML;
        	ContractTeat.methods.setMSG1(dataToSend).send({ from: account },function(error,transactionHash){
                if(error){
                    console.log(error)
                }else{
                    console.log(transactionHash)
                    transactionHash1.innerHTML = transactionHash;
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

</script>

</html>
