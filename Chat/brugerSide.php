<?php
    //DETTE ER SIDEN DU FØRST KOMMER IND PÅ EFTER LOGIND
    //starter session
    session_start();
    //includer 
    include "database.php"; //inkludere database.php

    //Dette stykke tjekker om den forrige side har givet os et password og navn ved hjælp af POST. Hvis dette ikke er sandt så bruger vi session
    $navn       = isset($_POST['navn'])     ?   $_POST['navn']      :   $_SESSION['navn'];
    $password   = isset($_POST['password']) ?   $_POST['password']  :   $_SESSION['password'];

    getConnectionAndCreateAll();  //vi opretter alle tabeller og databaser og får at vide hvad vores Connection er. Dette gøres igennem database.php
    $brugerEksisterer       = false;    //sætter den som falsk fordi det er bedre at sige det er forkert end bare at lade hvem som helst ind.
  
    if (doesUserNameExists($navn)){   //tjekker om kun navnet eksistere
        if(doesPasswordExists($navn,$password)){ //tjekker om navnet og passwordet eksistere.
            echo "<br>Velkommen ".$navn;    //siger velkommen
            $brugerEksisterer   = true;     //siger at vores bruger eksistere
        }else{
            echo "<br>Der eksisterer allerede en bruger med dette navn - men password er forkert!";
            $brugerEksisterer   = false;
        }
    }else{  //køre hvis hverken navn eller password er rigtigt.
        echo "<br>Bruger oprettet";
        $brugerEksisterer   = createUser($navn,$password);
    }

    //denne sætter alt klar til sessionen.
    //Den køre også bruger subside.
    if($brugerEksisterer){
        $_SESSION['navn']       = $navn;
        $_SESSION['password']   = $password;
        $_SESSION['user_id']    = getUserId($navn);
        //Viser brugerens data - aktier osv.
        include "brugerSubSide.php";
    }

?>