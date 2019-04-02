var app = require('express')();
var http = require('http').Server(app);
var mysql = require('mysql');

function sqldb(){
    var con = mysql.createConnection({
    host    : '34.76.79.252',
    user    : 'eriklaforce',
    password: 'ol012345'
    });
    return con;
}

function db(){
    var con = mysql.createConnection({
    host    : '34.76.79.252',
    user    : 'eriklaforce',
    password: 'ol012345',
    database: 'ChromeChat'
    });
    return con;
}


//create database
app.get('/createdb', (req,res) =>{
    createDatabase();
    createChatTable();
    createUserTable();
    createMemberTable();
    createMessageTable();
});

//create tables
function createDatabase(){
    let sql = 'CREATE DATABASE ChromeChat';
    sqldb().query(sql, (err,result) => {
        if(err) throw err;
        console.log(result);
        console.log('database created...');
    });
}

function createChatTable(){
    let sql = `CREATE TABLE ChromeChat.CHAT (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        navn VARCHAR(30) NOT NULL, 
        user_id INT(6) UNSIGNED)
    `;
    db().query(sql, (err,result) => {
        if(err) throw err;
        console.log(result);
        console.log('chat created...');
    });
}

function createUserTable(){
    let sql = `CREATE TABLE ChromeChat.USER (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        navn VARCHAR(30) NOT NULL, 
        password VARCHAR(512) NOT NULL)
    `;
    db().query(sql, (err,result) => {
        if(err) throw err;
        console.log(result);
        console.log('user created...');
    });
}

function createMemberTable(){
    let sql = `CREATE TABLE ChromeChat.MEMBER (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        user_id INT(6) UNSIGNED, 
        chat_id INT(6) UNSIGNED, 
        FOREIGN KEY (user_id) REFERENCES ChromeChat.USER(id), 
        FOREIGN KEY (chat_id) REFERENCES ChromeChat.CHAT(id))
    `;
    db().query(sql, (err,result) => {
        if(err) throw err;
        console.log(result);
        console.log('MEMBER created...');
    });
}

function createMessageTable(){
    let sql = `CREATE TABLE ChromeChat.MESSAGE (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT(6) UNSIGNED, 
        chat_id INT(6) UNSIGNED, 
        message varchar(255), 
        FOREIGN KEY (user_id) REFERENCES ChromeChat.USER(id), 
        FOREIGN KEY (chat_id) REFERENCES ChromeChat.CHAT(id))
    `;
    db().query(sql, (err,result) => {
        if(err) throw err;
        console.log(result);
        console.log('MEssage created...');
    });
}