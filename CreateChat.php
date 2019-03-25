<?php
    session_start();
    include "database.php";
    echo "
        <form method='post'>
            <td><input type='text' name='navn' value='Chatnavn'></td>
            <td><input type='submit' value='Lav'></td>
        </form>
    ";
    if(isset($_POST['navn'])){
        $chatNavn = $_POST['navn'];
        $brugerId = $_SESSION['user_id'];
        if(createChat($chatNavn,$brugerId)){
            header("location: brugerside.php");
        }
        echo "Chat blev ikke lavet";
        echo "<a href='brugerSide.php'><button>Gå tilbage til brugerside</button></a>";
    }
?>