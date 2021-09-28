const { debug } = require('console');
var express = require('express');
var router = express.Router();
var fs = require('fs');

function render(filename, params, callback) {
    fs.readFile(filename, 'utf8', function (err, data) {
      if (err) return cabllack(err);
      for (var key in params) {
        data = data.replace('{' + key + '}', params[key]);
      }
      callback(null, data); // 用 callback 傳回結果
    });
}
  
function SendErrorMeg()
{
    console.log(err);
}

router.get('/', (req, res) => {
    data = [
        {
            "id": 1,
            "name": "Jhon"
        },
        {
            "id": 2,
            "name": "Mike"
        }
    ];
    res.sendFile(__dirname + './public/myShop.html');
    //res.json(data);
    
});

router.get('/:okok', function (req, res) {
    render(__dirname + './public/myShop.html', {
      name: req.params.name
    }, function ( data) {
      res.send(data); // 這邊要寫一個 function 才能接收到資料
    });
  })
module.exports = router;