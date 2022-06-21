<?php
include_once("baza.php");
session_start();
$veza = spojiSeNaBazu();

$ime_admin = $_SESSION["ime"];
$id_admina = $_SESSION["korisnik_id"];

$upit = "SELECT korisnik.*, tip_korisnika.naziv FROM korisnik INNER JOIN tip_korisnika ON tip_korisnika.tip_korisnika_id = korisnik.tip_korisnika_id";
$rezultat = izvrsiUpit($veza, $upit);
zatvoriVezuNaBazu($veza);
?>


<!DOCTYPE html>
<html lang="hr">

<head>
    <title>Popis korisnika</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>


    <?php include_once("header.php") ?>


    <a href="dodaj_korisnika.php"><button class="button2">Dodaj novog korisnika</button></a>
    <div class="kontenjer">
    <table class="tablica_dt">
        <thead>
            <th>Korisničko ime</th>
            <th>Ime</th>
            <th>Prezime</th>
            <th>e-mail</th>
            <th>Tip korisnika</th>
        </thead>
        <tbody>
            <?php
            while ($red = mysqli_fetch_array($rezultat)) {
                $id_korisnik = $red['korisnik_id'];
                $kor_ime = $red['korime'];
                $ime = $red['ime'];
                $prezime = $red['prezime'];
                $email = $red['email'];
                $tip_korisnika = $red['tip_korisnika_id'];
                $naziv_tipa = $red['naziv'];

                echo "<tr>\n";
                echo "<td>{$kor_ime}</td>\n";
                echo "<td>{$ime}</td>\n";
                echo "<td>{$prezime}</td>\n";
                echo "<td>{$email}</td>\n";
                echo "<td>{$naziv_tipa}</td>\n";
                echo "<td><a href='azuriraj_korisnika.php?id={$id_korisnik}'><button class='button'>Ažuriraj</button></a>";
                echo "</tr>\n";
            }
            ?>
        </tbody>
    </table>
    </div>


    <?php include_once("footer.php"); ?>

    
</body>

</html>