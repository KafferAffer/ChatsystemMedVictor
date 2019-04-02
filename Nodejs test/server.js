var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var mysql = require('mysql');

//bruger index.html
app.get('/', function(req, res){
  res.sendFile(__dirname + '/index.html');
});

//database og connection
const db = mysql.createConnection({
    host    : '34.76.79.252',
    user    : 'eriklaforce',
    password: 'ol012345'
});

db.connect((err) => {
    if(err){
        throw err;
    }
    console.log('connected to db');
});

//create database
app.get('/createdb', (req,res) =>{
    let sql = 'CREATE DATABASE chat';
    db.query(sql, (err,result) => {
        if(err) throw err;
        console.log(result);
        res.send('database created...');
    });
});


//modtager og sender beskeder
io.on('connection', function(socket){
    socket.broadcast.emit('welcome');
    console.log('a user connected');
    socket.on('chat message', function(msg){
        console.log('message: ' + msg);
        io.emit('chat message', msg);
    });
    socket.on('disconnect', function(){
        console.log('user disconnected');
    });
});

http.listen(3000, function(){
  console.log('listening on *:3000');
});



