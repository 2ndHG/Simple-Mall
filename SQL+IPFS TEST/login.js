var express = require('express');
var router = express.Router();

const mysql = require('mysql');

//表單解碼
var bodyParser = require('body-parser');
var urlencodedParser = bodyParser.urlencoded({ extended: false });

router.post('/', urlencodedParser, function(req, res) {
    //連線資料
    const db = mysql.createConnection({
        host: 'localhost',
        user: 'root',
        password: '',
        database: 'test'
    });
     //與資料庫建立連線
    db.connect((err) => {
        if (err) {
            throw err;
        }
        console.log('Mysql Connected...')
    });
    //做SQL查詢
    if(req.body.isMerchant == 'true')
    {
        //商家
        let sql = "SELECT * FROM merchant WHERE m_password='"+req.body.password+"' AND m_address='"+req.body.address +"'";
        let query = db.query(sql, (err, result) => {
            if (err)
            {
                console.log(err)
                throw err;
            }
            console.log(result);
            if(result.length == 0)
            {
                console.log("帳號或密碼錯誤");
                res.sendFile(__dirname + '/public/login.html');
            }
            else
            {
                res.sendFile(__dirname + '/public/merchantIndex.html');
                return;
            }
        })
    }
    else
    {
        //消費者
        let sql = "SELECT * FROM 使用者資訊 WHERE password='"+req.body.password+"' AND address='"+req.body.address +"'";
        let query = db.query(sql, (err, result) => {
            if (err)
            {
                console.log(err)
                throw err;
            }
            console.log(result);
            if(result.length == 0)
            {
                console.log("帳號或密碼錯誤");
                res.sendFile(__dirname + '/public/login.html');
            }
            else
            {
                res.sendFile(__dirname + '/public/userIndex.html');
                return;
            }
            
        })
    }
    

})
module.exports = router;