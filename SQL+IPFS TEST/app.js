const express = require('express');
const mysql = require('mysql');

// Create connection with IPFS
const IPFS = require('ipfs-mini');
const ipfs = new IPFS({ host: 'ipfs.infura.io', port: 5001, protocol: 'https' });
const app = express();

//路由
var login = require('./login.js');
app.use('/login', login);
var merchantIndex = require('./merchantIndex.js');
app.use('/merchantIndex', merchantIndex);
var upload = require('./upload.js');
app.use('/upload', upload);
var myShop = require('./myShop.js');
app.use('/myShop', myShop);


//表單解碼
var bodyParser = require('body-parser');
var urlencodedParser = bodyParser.urlencoded({ extended: false });

// Create connection with mySQL
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'test'
});

// Connect with mySQL
db.connect((err) => {
    if (err) {
        throw err;
    }
    console.log('Mysql Connected...')
});


app.get('/', (req, res) => {
    //res.sendFile(__dirname + '/public/index.html')
    res.sendFile(__dirname + '/public/login.html')
})
/*
app.get('/upload', (req, res) => {
    res.sendFile(__dirname + '/public/upload.html');
});
*/

// Insert post 1
app.get('/addpost1', (req, res) => {
    let post = { title: 'Post One', body: 'This is post number one' };
    let sql = 'INSERT INTO posts SET ?';
    let query = db.query(sql, post, (err, result) => {
        if (err) throw err;
        console.log(result);
        res.send("Post 1 added...")
    })
});

// Insert post 2
app.get('/addpost2', (req, res) => {
    let post = { title: 'Post Two', body: 'This is post number two' };
    let sql = 'INSERT INTO posts SET ?';
    let query = db.query(sql, post, (err, result) => {
        if (err) throw err;
        console.log(result);
        res.send("Post 2 added...")
    })
});

// Insert post 3
app.get('/addpost3', (req, res) => {
    let post = { title: 'Post Three', body: 'This is post number three' };
    let sql = 'INSERT INTO posts SET ?';
    let query = db.query(sql, post, (err, result) => {
        if (err) throw err;
        console.log(result);
        res.send(result);
    })
});

var dataToSend;
var RESULTS;
// Select posts get按鈕
app.get('/getposts', (req, res) => {
    let sql = 'SELECT transaction_hash FROM record WHERE id=1';
    let query = db.query(sql, (err, results) => {
        if (err) throw err;
        console.log(results);
        //res.send(results);
        dataTOSend = results;
        RESULTS = results;
    });
    res.sendFile(__dirname + '/public/index.html');
});

var ipfsHash = '';

// add data in ipfs sendToIpfs按鈕
app.get('/addipfs', (req, res, next) => {
    var data = dataToSend;
    ipfs.add(data, (err, results) => {
        if (err) console.log(err);
        console.log(results);
        res.send(results)
            // ipfsHash = results;
    });
    // res.send(ipfsHash);
    ipfs.cat('QmYRzJFB1JwQEA4nau8eyDJFSgrRN9pjvGeB1hkVdvaveP', (err, ressult) => {
        if (err) console.log(err);
        console.log(ressult);
    });
});


app.listen('3100', () => {
    console.log('Serve started on port 3100')
});