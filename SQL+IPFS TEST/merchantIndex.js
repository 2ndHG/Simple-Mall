var express = require('express');
var router = express.Router();

router.get('/merchantIndex/upload', (req, res) => {
    res.sendFile(__dirname + '/public/upload.html');
});

module.exports = router;