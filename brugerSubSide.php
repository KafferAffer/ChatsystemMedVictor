<html>
<body>
<?php

    echo"<form action='CreateChat.php' method='post'>
         <button type='submit'>Create Chat</button>
      </form>";
    $MemberId = getMemberId($_SESSION['connection'], $_SESSION['user_id']);
    
    echo "<br>Chats:<br><table border='1'>";
    foreach($MemberId as $row){
        echo "<tr>";
        $ChatId = getChatIdFromMemberId($connection,$row);
        $Chat = getChat($_SESSION['connection'],$ChatId);
        echo"<td>
        <form action='Chat.php' method='post'>
            <input type='hidden' name='ChatId' value=".$ChatId.">
            <button type='submit'>'".$Chat['navn']."'</button>
        </form>
        </td>";
        echo "</tr>";
    }
    echo "</table>";
?>

</body>
</html>