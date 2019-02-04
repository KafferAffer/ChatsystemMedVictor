<?php

$GLOBALS['debug'] = false;

//tjekker om vi er i debug mode før den sender debug beskeden
if($GLOBALS['debug']){
    echo "<br>DEBUG: database.php included";
}

function getConnectionAndCreateAll(){
    //her bliver Connection oprettet
    $connect = new mysqli("localhost", "root","");
    /*Nedenstående udkommenteret - kan bruges til debugging!!
    if ($connect->connect_error) {
        die("<br>Connection failed: " . $conn->connect_error);
    } 
    echo "Connected successfully";*/
    createDatabase($connect);           //Laver Database
    createMemberTable($connect);
    createUserTable($connect);          //laver En tabel for brugere
    createMessageTable($connect);         //laver en tabel for aktier
    createChatTable($connect);  //laver en tabel for transaktioner
    

    return $connect;
}
<<<<<<< HEAD
function createChatsTable($connection){
        $sql = "CREATE TABLE ChromeChat.CHATS (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, navn VARCHAR(300) NOT NULL)";
        $tbCreated = $connection->query($sql);

        //debug bekseder
        if($GLOBALS['debug']){
            if ($tbCreated) {
                echo "<br>DEBUG:able chat created successfully";
            } else {
                echo "<br>DEBUG:Error creating chat: " . $connection->error;
            }
        }
    }
function createChatsTable($connection){
     $sql = "CREATE TABLE ChromeChat.MEMBERS (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, user_id INT(6) UNSIGNED, aktie_id INT(6) UNSIGNED, antal INT(6), omkostning DECIMAL(8,2) NOT NULL, FOREIGN KEY (user_id) REFERENCES ChromeChat.USERS(id), FOREIGN KEY (aktie_id) REFERENCES ChromeChat.AKTIER(id))";
        $tbCreated = $connection->query($sql);

        //debug bekseder
        if($GLOBALS['debug']){
            if ($tbCreated) {
                echo "<br>DEBUG:able chat created successfully";
            } else {
                echo "<br>DEBUG:Error creating chat: " . $connection->error;
            }
        }
}
=======

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
    $sql = "CREATE TABLE ChromeChat.USERS (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, navn VARCHAR(30) NOT NULL, password VARCHAR(30) NOT NULL,";
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

function doesUserNameAndPasswordExists($connection, $navn, $password){
    $secretnavn = password_hash($navn , PASSWORD_DEFAULT );
    $secretpassword = password_hash($password , PASSWORD_DEFAULT );//krypterer vores password inden man sætter det ind i databasen
    $sql = "SELECT USERS.id FROM ChromeChat.USERS WHERE password='".$secretpassword."' AND navn='".$secretnavn."' LIMIT 1";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();
    if($GLOBALS['debug']){
        echo "<br>DEBUG: USER ID ".$row['id'];
        echo "<br>DEBUG: Check if  user  with NAME,PASSWORD exists sql:" . $sql . " " . $connection->error;
    }
    return $row != null ? $row['id']: null;
}

function doesUserNameExists($connection, $navn){
    $secretnavn = password_hash ( $navn , PASSWORD_DEFAULT );
    $sql = "SELECT * FROM ChromeChat.USERS WHERE navn='".$secretnavn."' LIMIT 1";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    //debug beskeder
    if($GLOBALS['debug']){
        echo "<br>DEBUG: Check if  user  with PASSWORD exists" . $sql . " status(error):" . $connection->error;
    }
    return $row!=null;
}

?>
>>>>>>> c283a09b7d4dc332f4c2609854a32b4abd5620ca
