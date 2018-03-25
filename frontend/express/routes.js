var express = require('express');
var router = express.Router();
var templateData = require('../data.json');

/* GET home page. */
router.get('/', function(req, res, next) {
  res.render('register', templateData);
});

module.exports = router;
