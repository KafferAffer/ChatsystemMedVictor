<?php
    session_start();
    include "database.php";
    $id = $_POST['aktie_id']
    echo "
        <form action='CreatingChat.php' method='post'>
            <td><input type='text' name='navn' value='Username'></td>
            <td><input type='submit' value='Lav'></td>
        </form>
    ";
?>