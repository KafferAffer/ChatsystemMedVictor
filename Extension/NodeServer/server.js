
var express = require('express');
var mysql = require('mysql');
var socket = require('socket.io');

var con = mysql.createConnection({
  host: "192.158.30.151",
  user: "eriklaforce",
  password: "ol012345"
});

con.connect(function(err) {
  if (err) throw err;
  console.log("Connected!");
});

var app = express();
var server = app.listen(3000);
app.use(express.static('public'));
console.log("my server is running");
var io = socket(server);
io.sockets.on('connection', newConnection);

function newConnection(socket){
    console.log(socket);
    
}