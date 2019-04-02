var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var mysql = require('mysql');

//bruger index.html
app.get('/inchat', function(req, res){
  res.sendFile(__dirname + '/index.html');
});

//database og connection

function db(){
    var con = mysql.createConnection({
    host    : '34.76.79.252',
    user    : 'eriklaforce',
    password: 'ol012345',
    });
    return con;
}

db().connect((err) => {
    if(err){
        throw err;
    }
    console.log('connected to db');
});

//create database
app.get('/createdb', (req,res) =>{
    let sql = 'CREATE DATABASE IF NOT EXISTS ChromeChat';
    db().query(sql, (err,result) => {
        if(err) throw err;
        console.log(result);
        res.send('database created...');
    });
    createChatTable();
});

//create tables
function createChatTable(){
    let sql = `CREATE TABLE IF NOT EXISTS ChromeChat.CHAT (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        navn VARCHAR(30) NOT NULL, 
        user_id INT(6) UNSIGNED)
    `;
    db().query(sql, (err,result) => {
        if(err) throw err;
        console.log('chat created...');
        createUserTable();
    });
}

function createUserTable(){
    let sql = `CREATE TABLE IF NOT EXISTS ChromeChat.USER (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        navn VARCHAR(30) NOT NULL, 
        password VARCHAR(512) NOT NULL)
    `;
    db().query(sql, (err,result) => {
        if(err) throw err;
        console.log('user created...');
        createMemberTable();
    });
}

function createMemberTable(){
    let sql = `CREATE TABLE IF NOT EXISTS ChromeChat.MEMBER (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        user_id INT(6) UNSIGNED, 
        chat_id INT(6) UNSIGNED, 
        FOREIGN KEY (user_id) REFERENCES ChromeChat.USER(id), 
        FOREIGN KEY (chat_id) REFERENCES ChromeChat.CHAT(id))
    `;
    db().query(sql, (err,result) => {
        if(err) throw err;
        console.log('MEMBER created...');
        createMessageTable();
    });
}

function createMessageTable(){
    let sql = `CREATE TABLE IF NOT EXISTS ChromeChat.MESSAGE (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT(6) UNSIGNED, 
        chat_id INT(6) UNSIGNED, 
        message varchar(255), 
        FOREIGN KEY (user_id) REFERENCES ChromeChat.USER(id), 
        FOREIGN KEY (chat_id) REFERENCES ChromeChat.CHAT(id))
    `;
    db().query(sql, (err,result) => {
        if(err) throw err;
        console.log('MEssage created...');
    });
}

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


