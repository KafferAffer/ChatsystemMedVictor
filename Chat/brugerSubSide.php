<html>
<body>
<?php
    echo"<form action='CreateChat.php' method='post'>
         <button type='submit'>Create Chat</button>
      </form>";
    $MemberId = getMemberId($_SESSION['user_id']);
    echo "<br>Chats:<br><table border='1'>";
    foreach($MemberId as $row){
        echo "<tr>";
        $ChatId = getChatIdFromMemberId($row);
        $Chat = getChat($ChatId);
        echo"<td>
        <form method='post'>
            <input type='hidden' name='ChatId' value=".$ChatId.">
            <button onclick='myAjax()' type='submit' >'".$Chat['navn']."'</button>
        </form>
        </td>";
        echo "</tr>";
    }
    echo "</table>";
    if(isset($_POST['ChatId'])){
        $_SESSION['ChatId'] = $ChatId;
        header("Location: Chat.php");
    }
?>
</body>
</html>