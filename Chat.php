<?php
    session_start();
    include "database.php";
    $ChatId = $_POST['ChatId'];
    echo "
        <form action='AddMember.php' method='post'>
            <td><input type='text' name='navn' value='Username'></td>
            <input type='hidden' name='ChatId' value=".$ChatId.">
            <td><input type='submit' value='Tilføj Bruger'></td>
        </form>
    ";
?>