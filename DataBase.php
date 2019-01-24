<?php
function getConnectionAndCreateAll(){
    //her bliver Connection oprettet
    $connect = new mysqli("localhost", "root","");
    /*Nedenstående udkommenteret - kan bruges til debugging!!
    if ($connect->connect_error) {
        die("<br>Connection failed: " . $conn->connect_error);
    } 
    echo "Connected successfully";*/
    createDatabase($connect);           //Laver Database
    createUserTable($connect);          //laver En tabel for brugere
    createMessageTable($connect);         //laver en tabel for aktier
    createChatsTable($connect);  //laver en tabel for transaktioner
    createMembersTable//Indsætter nogen aktier designet på forhånd.
    return $connect;
}

function createDatabase($connection){
    $sql = "CREATE DATABASE ChromeChat";
    $dbCreated = $connection->query($sql);

    //Igen kun for debug mode
    if($GLOBALS['debug']){
        if ($dbCreated) {
            echo "<br>DEBUG:Database created successfully";
        } else {
            echo "<br>DEBUG:Error creating database: " . $connection->error;
        }
    }
}

function createChatTable($connection){
    $sql = "CREATE TABLE ChromeChat.CHAT (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, navn VARCHAR(30) NOT NULL)";
    $tbCreated = $connection->query($sql);
    
    if($GLOBALS['debug']){
        if ($tbCreated) {
            echo "<br>DEBUG:able aktier created successfully";
        } else {
            echo "<br>DEBUG:Error creating aktier: " . $connection->error;
        }
    }
}

function createUserTable($connection){
    $sql = "CREATE TABLE myDB.USERS (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, navn VARCHAR(30) NOT NULL, password VARCHAR(30) NOT NULL,";
    $tbCreated = $connection->query($sql);
    
    if($GLOBALS['debug']){
        if ($tbCreated) {
            echo "<br>DEBUG:able aktier created successfully";
        } else {
            echo "<br>DEBUG:Error creating aktier: " . $connection->error;
        }
    }
}

function createMemberTable($connection){
    $sql = "CREATE TABLE ChromeChat.MEMBER (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, user_id INT(6) UNSIGNED, chat_id INT(6) UNSIGNED, antal INT(6), FOREIGN KEY (user_id) REFERENCES ChromeChat.USERS(id), FOREIGN KEY (chat_id) REFERENCES ChromeChat.CHAT(id))";
    $tbCreated = $connection->query($sql);
    
    if($GLOBALS['debug']){
        if ($tbCreated) {
            echo "<br>DEBUG:Table transaktioner created successfully";
        } else {
            echo "<br>DEBUG:Error creating transaktioner: " . $connection->error;
        }
    }
}

function createMessageTable($connection){
    $sql = "CREATE TABLE ChromeChat.MESSAGE (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        user_id INT(6) UNSIGNED, 
        chat_id INT(6) UNSIGNED, antal INT(6), 
        FOREIGN KEY (user_id) REFERENCES ChromeChat.USERS(id), 
        FOREIGN KEY (chat_id) REFERENCES ChromeChat.CHAT(id)),
        text VARCHAR(30) NOT NULL";
    $tbCreated = $connection->query($sql);
    
    if($GLOBALS['debug']){
        if ($tbCreated) {
            echo "<br>DEBUG:Table transaktioner created successfully";
        } else {
            echo "<br>DEBUG:Error creating transaktioner: " . $connection->error;
        }
    }
}