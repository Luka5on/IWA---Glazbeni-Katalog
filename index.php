<?php
session_start();
include("baza.php");
$veza = spojiSeNaBazu();


if (isset($_GET["zatrazi_kupnju_id"])) {
    $id_pjesme_kupnja = $_GET["zatrazi_kupnju_id"];
    $id_moderatora = $_SESSION["korisnik_id"];

    $sql = "SELECT medijska_kuca_id FROM korisnik WHERE korisnik_id = {$id_moderatora}";
    $rez = izvrsiUpit($veza, $sql);
    $red1 = mysqli_fetch_array($rez);
    $id_medijske_kuce_moderatora = $red1["medijska_kuca_id"];

    
    $sql = "UPDATE pjesma SET medijska_kuca_id = {$id_medijske_kuce_moderatora} WHERE pjesma_id = {$id_pjesme_kupnja}";
    $rez_update = izvrsiUpit($veza, $sql);
}



if (isset($_SESSION["tip"]) && $_SESSION["tip"] <= 1) {
    $moderator = true;
}

if (isset($_SESSION["korisnik_id"])) {
    $upit = "SELECT pjesma.*, korisnik.korime FROM pjesma
    INNER JOIN korisnik ON pjesma.korisnik_id = korisnik.korisnik_id
    ORDER BY broj_svidanja DESC";
} else {
    $upit = "SELECT pjesma.*, korisnik.korime FROM pjesma
    INNER JOIN korisnik ON pjesma.korisnik_id = korisnik.korisnik_id
    WHERE pjesma.medijska_kuca_id IS NOT NULL ORDER BY broj_svidanja DESC";
}



if (isset($_POST["filtracija"])) {
    $ime_medijske_k = $_POST["medijska-kuca"];
    if (empty($_POST["vrijeme_od"]) && empty($_POST["vrijeme_do"])) {
        $upit = "SELECT pjesma.*, korisnik.korime, medijska_kuca.naziv AS 'naziv_medijske' FROM pjesma 
        INNER JOIN korisnik ON pjesma.korisnik_id = korisnik.korisnik_id 
        INNER JOIN medijska_kuca ON pjesma.medijska_kuca_id = medijska_kuca.medijska_kuca_id 
        WHERE medijska_kuca.naziv LIKE '%{$ime_medijske_k}%'
        ORDER BY broj_svidanja DESC";
    } else {
        $vrijeme_od = date('Y-m-d H:i:s', strtotime($_POST['vrijeme_od']));
        $vrijeme_do = date('Y-m-d H:i:s', strtotime($_POST['vrijeme_do']));
        $upit = "SELECT pjesma.*, korisnik.korime, medijska_kuca.naziv AS 'naziv_medijske' FROM pjesma 
        INNER JOIN korisnik ON pjesma.korisnik_id = korisnik.korisnik_id 
        INNER JOIN medijska_kuca ON pjesma.medijska_kuca_id = medijska_kuca.medijska_kuca_id 
        WHERE medijska_kuca.naziv LIKE '%{$ime_medijske_k}%'
        AND pjesma.datum_vrijeme_kreiranja BETWEEN '2020-10-01 00:00:00' AND '2022-07-15 00:00:00' 
        ORDER BY broj_svidanja DESC";
    }
}


$rezultat = izvrsiUpit($veza, $upit);
zatvoriVezuNaBazu($veza);
?>


<!DOCTYPE html>
<html lang="hr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Početna - popis pjesama</title>
</head>

<body>


    <?php include_once("header.php") ?>
    <?php

    if (isset($_SESSION["korisnik_id"])) {
        echo "
        <div class='kontenjer'>
        <table class='tablica'>
        <tbody>
            <tr>
                <td><span>Filtriraj pjesme</span></td>
                <td><span>Od:</span></td>
                <td><span >Do:</span></td>
            </tr>
            <tr>
                <form  method='POST' action='{$_SERVER['PHP_SELF']}'></td>
                <td><input type='text' name='medijska-kuca' placeholder='Medijska kuća'></td>
                <td><input type='text' name='vrijeme_od' value='01.10.2020 00:00:00'></td>
                <td><input type='text' name='vrijeme_do' value='15.07.2022 00:00:00'></td>
                <td><input type='submit' name='filtracija' value='Pretraži' class='button'></td>
                </form>
            </tr>
        </tbody>
        </table>
        </div>";
    }
    ?>


    <div class="kontenjer">
    <table class="tablica_dt">
        <thead>
            <th>Naziv pjesme</th>
            <th>Postavio korisnik</th>
            <th>Broj sviđanja</th>
            <th>Audio zapis</th>
        </thead>
        <tbody>


            <?php
            while ($red = mysqli_fetch_array($rezultat)) {
                if (isset($moderator) && ($moderator === true) && ($red["medijska_kuca_id"] === NULL)) {
                    echo "<tr class='main'>";
                    $zatrazi = true;
                } else {
                    echo "<tr>";
                    $zatrazi = false;
                }
                echo "<td><a href='detalji_pjesme.php?id={$red['pjesma_id']}'>{$red['naziv']}</a></td>
                    <td>{$red['korime']}</td>
                    <td>{$red['broj_svidanja']}</td>
                    <td>
                        <audio controls>
                        <source src='{$red['poveznica']}' type='audio/mpeg'>
                        </audio>
                    </td>";
                if (($zatrazi === true)) {
                    echo "<td><a href='{$_SERVER['PHP_SELF']}?zatrazi_kupnju_id={$red['pjesma_id']}'><button class='button'>Zatraži kupnju</button></a></td>";
                }
                echo "</tr>";
            }

            ?>


        </tbody>
    </table>
    </div>


    <?php include_once("footer.php") ?>

    
</body>

</html>