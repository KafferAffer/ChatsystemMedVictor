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