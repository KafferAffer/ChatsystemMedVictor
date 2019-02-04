<html>
<body>
<?php
                            //DENNE SIDE ER LAVET TIL AT VISE EN BRUGER SINE TRANSAKTIONER FRA START-SIDEN.
//included i brugerSide...
//behøver ikke session_start();
//behøver ikke database.php

$transaktions   = getUserAktieOversigt($_SESSION['connection'], $_SESSION['user_id']);
$formue         = getFormue($_SESSION['connection'],$_SESSION['navn'],$_SESSION['password']);

echo "<br>------------------------------";

echo "<br><br><table border='1'>";
echo "<tr><th>Navn</th><th>Antal</th><th>Aktiepris</th><th>Købt for:</th></tr>";
foreach($transaktions as $row){
    echo "<tr>";
    if($row['antal']>=0){
        
        echo "  <td>".$row['aktie_navn']."</td>
                <td>".$row['antal']."</td>
                <td>".$row['aktie_pris']."</td>
                <td>".$row['omkostning']."</td>
                <!--Dette laver knappen for at gå til køb siden-->
                <form action='kobFortaget.php' method='post'>
                        <td><input type='number' name='antal' value='Antal'></td>
                        <input type='hidden' name='pris' value=".$row['aktie_pris'].">
                        <input type='hidden' name='aktie_id' value=".$row['aktie_id'].">
                        <td><input type='submit' value='Køb'></td>
                </form>
                ";
            if($row['antal']>0){
                //Dette laver knappen til sælg siden hvis derr er noget at sælge. Den bruger hidden inputs til at man kan få informationen på næste side.
                echo "  <form action='salgFortaget.php' method='post'>
                                <td><input type='number' name='antal' value='Antal'></td>
                                <input type='hidden' name='pris' value=".$row['aktie_pris'].">  
                                <input type='hidden' name='aktie_id' value=".$row['aktie_id'].">
                                <td><input type='submit' value='Sælg'></td>
                        </form>";
            }
    }
    //Vores samlede omkostning bliver taget fra vores start kapital.
    echo "</tr>";
}
echo "</table>";

echo "<br>------------------------------";

echo "<br>Formue: ".$formue;
      
echo "<br>------------------------------";


?>

</body>
</html>