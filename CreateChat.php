<?php
    session_start();
    include "database.php";
    echo "
        <form action='CreatingChat.php' method='post'>
            <td><input type='text' name='navn' value='Chatnavn'></td>
            <td><input type='submit' value='Lav'></td>
        </form>
    ";
?>