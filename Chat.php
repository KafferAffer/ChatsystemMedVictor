<?php
    session_start();
    include "database.php";
    echo "
        <form method='post'>
            <td><input type='text' name='navn' value='Username'></td>
            <td><input type='submit' value='Tilføj Bruger'></td>
        </form>
    ";

    $Member = getMember($_SESSION['ChatId']);
    foreach($Member as $row){
        echo GetUsername($row['user_id']);
        echo "<br>";
    }

    $ChatId = $_SESSION['ChatId'];
    $Message = getMessage($_SESSION['ChatId']);
    echo "<br>Messages:<br><table border='1'>";
    $senderArray = array();
    $messageArray = array();
    $i = -1;
    foreach($Message as $row){
        $i++;
        $sender[$i] = GetUsername($row['user_id']);
        $message[$i] = $row['message'];
    }
    for($i;$i>=0;$i=$i-1){
        echo $sender[$i];
        echo ":  ";
        echo $message[$i];
        echo "<br>";
    }

    echo "
        <form method='post'>
            <td><input type='text' name='Besked' value='Besked'></td>
            <td><input type='submit' value='Send'></td>
        </form>
    ";

    if(isset($_POST['navn'])){
        $userName = $_POST['navn'];
        $brugerId = $_SESSION['user_id'];
        $ChatId = $_SESSION['ChatId'];
        $AddedId = getUserId($userName);
        addMember($ChatId, $AddedId);
        header('Location: Chat.php');
    }
    
    if(isset($_POST['Besked'])){
        $Besked = $_POST['Besked'];
        $brugerId = $_SESSION['user_id'];
        $ChatId = $_SESSION['ChatId'];
        addMessage($ChatId, $brugerId, $Besked);
        header('Location: Chat.php');
    }
?>