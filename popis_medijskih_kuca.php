<?php
include_once("baza.php");
session_start();
$veza = spojiSeNaBazu();
$upit = "SELECT * FROM medijska_kuca";
$rezultat = izvrsiUpit($veza, $upit);
zatvoriVezuNaBazu($veza);
?>


<!DOCTYPE html>
<html lang="hr">

<head>
    <title>Popis medijskih kuća</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>


    <?php include_once("header.php") ?>


    <a href="dodaj_medijsku.php"><button class="button2">Dodaj novu medijsku kuću</button></a>
    <div class="kontenjer">
    <table class="tablica_dt">
        <thead>
            <th>Naziv medijske kuće</th>
            <th>Opis</th>
        </thead>
        <tbody>
            <?php
            while ($red = mysqli_fetch_array($rezultat)) {
                echo "<tr>
                            <td>{$red['naziv']}</td>
                            <td>{$red['opis']}</td>
                            <td><a href='azuriraj_medijsku.php?id={$red['medijska_kuca_id']}'><button class='button'>Ažuriraj</button</a></td>
                          </tr>";
            }
            ?>
        </tbody>
    </table>
        </div>


    <?php include_once("footer.php"); ?>

    
</body>

</html>