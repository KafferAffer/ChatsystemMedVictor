<?php
    session_start();
    include "database.php";
    $connect = getConnectionAndCreateAll();
    $chatNavn = $_POST['navn'];
    $brugerId = $_SESSION['user_id'];
    if(createChat($connect,$chatNavn,$brugerId)){
        header("location: http://localhost/ChatsystemMedVictor/brugerside.php");
    }
    echo "Chat blev ikke lavet";
    echo "<a href='brugerSide.php'><button>Gå tilbage til brugerside</button></a>";
?>