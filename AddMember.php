<?php
    session_start();
    include "database.php";
    $connect = getConnectionAndCreateAll();
    $userName = $_POST['navn'];
    $brugerId = $_SESSION['user_id'];
    $ChatId = $_SESSION['ChatId'];
    $AddedId = getUserId($connect,$userName);
    if(addMember($connect, $ChatId, $AddedId)){
        header("location: http://localhost/ChatsystemMedVictor/brugerside.php");
    }
    echo "Chat blev ikke lavet";
    echo "<a href='brugerSide.php'><button>Gå tilbage til brugerside</button></a>";
?>