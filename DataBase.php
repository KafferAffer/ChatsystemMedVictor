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