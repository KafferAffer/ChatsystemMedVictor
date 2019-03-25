<?php

function getConnectionAndCreateAll(){
    //her bliver Connection oprettet
    /*Nedenstående udkommenteret - kan bruges til debugging!!
    if ($connect->connect_error) {
        die("<br>Connection failed: " . $conn->connect_error);
    } 
    echo "Connected successfully";*/
    createDatabase();
    createChatTable();
    createUserTable();
    createMemberTable();
    createMessageTable();
}

function connect(){
    $connect = new mysqli("localhost", "root","");
    return $connect;
}

function createChatsTable(){
    $sql = "CREATE TABLE ChromeChat.CHATS (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, navn VARCHAR(300) NOT NULL)";
    $tbCreated = connect()->query($sql);
}

function createDatabase(){
    $sql = "CREATE DATABASE ChromeChat";
    $dbCreated = connect()->query($sql);
}

function createChatTable(){
    $sql = "CREATE TABLE ChromeChat.CHAT (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, navn VARCHAR(30) NOT NULL, user_id INT(6) UNSIGNED)";
    $tbCreated = connect()->query($sql);
}

function createUserTable(){
    $sql = "CREATE TABLE ChromeChat.USER (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, navn VARCHAR(30) NOT NULL, password VARCHAR(512) NOT NULL)";
    $tbCreated = connect()->query($sql);
}

function createMemberTable(){
    $sql = "CREATE TABLE ChromeChat.MEMBER (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, user_id INT(6) UNSIGNED, chat_id INT(6) UNSIGNED, FOREIGN KEY (user_id) REFERENCES ChromeChat.USER(id), FOREIGN KEY (chat_id) REFERENCES ChromeChat.CHAT(id))";
    $tbCreated = connect()->query($sql);
}

function createMessageTable(){
    $sql = "CREATE TABLE ChromeChat.MESSAGE (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        user_id INT(6) UNSIGNED, 
        chat_id INT(6) UNSIGNED, message varchar(255), 
        FOREIGN KEY (user_id) REFERENCES ChromeChat.USER(id), 
        FOREIGN KEY (chat_id) REFERENCES ChromeChat.CHAT(id))";
    $tbCreated = connect()->query($sql);
}

function doesPasswordExists($navn, $password){
    $sql = "SELECT USER.password FROM ChromeChat.USER WHERE navn='".$navn."' LIMIT 1";
    $result = connect()->query($sql)->fetch_assoc();
    return password_verify($password,$result['password']);
}

function doesUserNameExists($navn){
    $sql = "SELECT * FROM ChromeChat.USER WHERE navn='".$navn."' LIMIT 1";
    $result = connect()->query($sql);
    $row = $result->fetch_assoc();
    return $row!=null;
}

function createUser($navn, $password){
    $secretpassword = password_hash ( $password , PASSWORD_DEFAULT );
    $sql =  "INSERT INTO ChromeChat.USER (navn, password) VALUES ('".$navn."','".$secretpassword."')";
    $userCreated = connect()->query($sql);
    return $userCreated;
}

function createChat($Chatnavn, $Brugerid){
    $connection = connect();
    $sqlChat =  "INSERT INTO ChromeChat.CHAT (navn,user_id) VALUES ('".$Chatnavn."','".$Brugerid."')";
    $chatCreated = $connection->query($sqlChat);
    $sql = "SELECT CHAT.id FROM ChromeChat.CHAT WHERE navn='".$Chatnavn."' AND user_id='".$Brugerid."' LIMIT 1";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();
    addMember($row['id'], $Brugerid);
    return TRUE;
}

function getUserId($navn){
    $sql = "SELECT USER.id FROM ChromeChat.USER WHERE navn='".$navn."' LIMIT 1";
    $result = connect()->query($sql);
    $row = $result->fetch_assoc();
    return $row['id'];
}

function getChatId($navn){
    $sql = "SELECT CHAT.id FROM ChromeChat.CHAT WHERE navn='".$navn."' LIMIT 1";
    $result = connect()->query($sql);
    $row = $result->fetch_assoc();
    return $row['id'];
}

function getMemberId($UserId){
    $sql = "SELECT MEMBER.id FROM ChromeChat.MEMBER WHERE user_id='".$UserId."'";
    $result = connect()->query($sql);
    $MemberId = array();
    
    $i = 0;
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $MemberId[$i] = $row['id'];
            $i++;
        }
    }
    return $MemberId;
}

function getChatIdFromMemberId($MemberId){
    $sql = "SELECT MEMBER.chat_id FROM ChromeChat.MEMBER WHERE id='".$MemberId."'LIMIT 1";
    $result = connect()->query($sql);
    $row = $result->fetch_assoc();
    return $row['chat_id'];
}

function getChat($ChatId){
    $sql = "SELECT * FROM ChromeChat.CHAT WHERE id='".$ChatId."' LIMIT 1";
    $result = connect()->query($sql);
    $row = $result->fetch_assoc();
    return $row;
}

function addMember($Chatid, $Brugerid){
    if(!doesMemberExist($Chatid, $Brugerid)) {
        $sqlMember ="INSERT INTO ChromeChat.MEMBER (`user_id`, `chat_id`) VALUES ('".$Brugerid."','".$Chatid."')";
        $MemberAdded = connect()->query($sqlMember);
    }
}

function doesMemberExist($chatId, $UserId){
    $sql = "SELECT * FROM chromechat.member WHERE user_id='$UserId' AND chat_id='$chatId'";
    
    $result = connect()->query($sql);
    $row = $result->fetch_assoc();
    return $row != null;
}

function addMessage($Chatid, $Brugerid, $Besked){
    $sqlMessage ="INSERT INTO ChromeChat.MESSAGE (`user_id`, `chat_id`, `message`) VALUES ('".$Brugerid."','".$Chatid."','".$Besked."')";
    $MessageAdded = connect()->query($sqlMessage);
}

function getMessage($ChatId){
    $sql = "SELECT * FROM chromechat.message WHERE chat_id='".$ChatId."' ORDER BY id DESC LIMIT 5";
    $result = connect()->query($sql);
    return$result;
}

function getMember($ChatId){
    $sql = "SELECT * FROM chromechat.member WHERE chat_id='".$ChatId."' ORDER BY id";
    $result = connect()->query($sql);
    return$result;
}

function getUsername($id){
    $sql = "SELECT USER.navn FROM ChromeChat.USER WHERE id='".$id."' LIMIT 1";
    $result = connect()->query($sql);
    $row = $result->fetch_assoc();
    return $row['navn'];
}

?>