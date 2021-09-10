const express = require('express')
const app = express()

const fs = require('fs');

const multer  = require('multer')
const upload = multer({ dest: 'uploads/' })

// const IPFS = require('ipfs-core')

// const ipfs =  IPFS.create()
// const { cid } =  ipfs.add('Hello world')
// console.info(cid)


//引用ipfs API
const IPFS = require('ipfs-mini');
const ipfs = new IPFS({ host: 'ipfs.infura.io', port: 5001, protocol: 'https' });
 


app.get('/', function (req, res) {
//  res.send('Hello World')
    res.sendFile(__dirname+'/public/index.html')
})


app.post('/profile', upload.single('avatar'), function (req, res, next) {
    // req.file is the `avatar` file
    // req.body will hold the text fields, if there were any
    console.log(req.file);
     var data = fs.readFileSync(req.file.path);
     ipfs.add(data,  function(err,file){
         if(err){
            console.log(err);
        }
        console.log(file);
        res.send(file);
    })
    var nData = "西瓜";
    //取IPFS HASH內的值
    ipfs.cat('QmcAmANWyX5GQzFaxsDNcjFcSJVHFwGueDDTB6LEjDCcGb', function(err, result){
        if(err){
            console.log(err);
        }
        //印出hash 的內容
        console.log(result);

        nData = result + nData;
        console.log(nData);
        //再上傳一次
        ipfs.add(nData,function(err,res){
            if(err){
                console.log(err);
            }   
                console.log(res);
        });
    });
    

})


app.listen(3100);