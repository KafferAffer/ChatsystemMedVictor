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
    createDatabase($connect);
    createChatTable($connect);
    createUserTable($connect);
    createMemberTable($connect);
    createMessageTable($connect);
    

    return $connect;
}
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
    $sql = "CREATE TABLE ChromeChat.CHAT (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, navn VARCHAR(30) NOT NULL, user_id INT(6) UNSIGNED)";
    $tbCreated = $connection->query($sql);
    
    if($GLOBALS['debug']){
        if ($tbCreated) {
            echo "<br>DEBUG:Table chat created successfully";
        } else {
            echo "<br>DEBUG:Error creating chat: " . $connection->error;
        }
    }
}

function createUserTable($connection){
    $sql = "CREATE TABLE ChromeChat.USER (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, navn VARCHAR(30) NOT NULL, password VARCHAR(512) NOT NULL)";
    $tbCreated = $connection->query($sql);
    
    if($GLOBALS['debug']){
        if ($tbCreated) {
            echo "<br>DEBUG:able User created successfully";
        } else {
            echo "<br>DEBUG:Error creating User: " . $connection->error;
        }
    }
}

function createMemberTable($connection){
    $sql = "CREATE TABLE ChromeChat.MEMBER (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, user_id INT(6) UNSIGNED, chat_id INT(6) UNSIGNED, FOREIGN KEY (user_id) REFERENCES ChromeChat.USER(id), FOREIGN KEY (chat_id) REFERENCES ChromeChat.CHAT(id))";
    $tbCreated = $connection->query($sql);
    
    if($GLOBALS['debug']){
        if ($tbCreated) {
            echo "<br>DEBUG:Table Member created successfully";
        } else {
            echo "<br>DEBUG:Error creating Member: " . $connection->error;
        }
    }
}

function createMessageTable($connection){
    $sql = "CREATE TABLE ChromeChat.MESSAGE (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        user_id INT(6) UNSIGNED, 
        chat_id INT(6) UNSIGNED, antal INT(6), 
        FOREIGN KEY (user_id) REFERENCES ChromeChat.USER(id), 
        FOREIGN KEY (chat_id) REFERENCES ChromeChat.CHAT(id))";
    $tbCreated = $connection->query($sql);
    
    if($GLOBALS['debug']){
        if ($tbCreated) {
            echo "<br>DEBUG:Table Message created successfully";
        } else {
            echo "<br>DEBUG:Error creating Message: " . $connection->error;
        }
    }
}

function doesPasswordExists($connection, $navn, $password){
    $sql = "SELECT USER.password FROM ChromeChat.USER WHERE navn='".$navn."' LIMIT 1";
    $result = $connection->query($sql)->fetch_assoc();
    return password_verify($password,$result['password']);
}

function doesUserNameExists($connection, $navn){
    $sql = "SELECT * FROM ChromeChat.USER WHERE navn='".$navn."' LIMIT 1";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    //debug beskeder
    if($GLOBALS['debug']){
        echo "<br>DEBUG: Check if  user  with PASSWORD exists" . $sql . " status(error):" . $connection->error;
    }
    return $row!=null;
}


function createUser($connection, $navn, $password){
    $secretpassword = password_hash ( $password , PASSWORD_DEFAULT );
    $sql =  "INSERT INTO ChromeChat.USER (navn, password) VALUES ('".$navn."','".$secretpassword."')";
    $userCreated = $connection->query($sql);

    //debug beskeder
    if($GLOBALS['debug']){
        if ($userCreated) {
            echo "<br>DEBUG:New record created successfully";
        } else {
            echo "<br>DEBUG: Error: " . $sql . "<br>" . $connection->error;
        } 
    }
    return $userCreated;
}

function createChat($connection, $Chatnavn, $Brugerid){
    $sqlChat =  "INSERT INTO ChromeChat.CHAT (navn,user_id) VALUES ('".$Chatnavn."','".$Brugerid."')";
    $chatCreated = $connection->query($sqlChat);
    
    $sql = "SELECT CHAT.id FROM ChromeChat.CHAT WHERE navn='".$Chatnavn."' AND user_id='".$Brugerid."' LIMIT 1";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();
    
    $MemberAdded = addMember($connection, $row['id'], $Brugerid);
    
    //debug beskeder
    if($GLOBALS['debug']){
        if ($userCreated) {
            echo "<br>DEBUG:New record created successfully";
        } else {
            echo "<br>DEBUG: Error: " . $sql . "<br>" . $connection->error;
        } 
    }
    return $MemberAdded;
}

function getUserId($connection,$navn){
    $sql = "SELECT USER.id FROM ChromeChat.USER WHERE navn='".$navn."' LIMIT 1";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();
    return $row['id'];
}

function getChatId($connection,$navn){
    $sql = "SELECT CHAT.id FROM ChromeChat.CHAT WHERE navn='".$navn."' LIMIT 1";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();
    return $row['id'];
}

function getMemberId($connection,$UserId){
    $sql = "SELECT MEMBER.id FROM ChromeChat.MEMBER WHERE user_id='".$UserId."'";
    $result = $connection->query($sql);
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

function getChatIdFromMemberId($connection,$MemberId){
    $sql = "SELECT MEMBER.chat_id FROM ChromeChat.MEMBER WHERE id='".$MemberId."'LIMIT 1";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();
    return $row['chat_id'];
}

function getChat($connection,$ChatId){
    $sql = "SELECT * FROM ChromeChat.CHAT WHERE id='".$ChatId."' LIMIT 1";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();
    return $row;
}

function addMember($connection, $Chatid, $Brugerid){
    $sqlMember ="INSERT INTO ChromeChat.MEMBER (`user_id`, `chat_id`) VALUES ('".$Brugerid."','".$Chatid."')";
    $MemberAdded = $connection->query($sqlMember);
    return $MemberAdded;
}

?>
