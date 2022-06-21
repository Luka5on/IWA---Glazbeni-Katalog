<?php
session_start();
include_once("baza.php");
$veza = spojiSeNaBazu();
$upit = "SELECT m.naziv,SUM(p.broj_svidanja) as ukupan_broj_svidanja FROM pjesma p, medijska_kuca m WHERE p.medijska_kuca_id=m.medijska_kuca_id AND p.datum_vrijeme_kupnje IS NOT NULL GROUP BY p.medijska_kuca_id ORDER BY ukupan_broj_svidanja DESC";
$rezultat = izvrsiUpit($veza, $upit);
zatvoriVezuNaBazu($veza);
?>


<!DOCTYPE html>
<html lang="hr">

<head>
    <title>Broj sviđanja - statistika</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>


    <?php include_once("header.php"); ?>


    <div class="kontenjer">
    <table class='tablica_dt'>
        <thead>
            <th>Naziv medijske kuće</th>
            <th>Ukupan broj sviđanja</th>
        </thead>
        <tbody>

            <?php
            while ($red = mysqli_fetch_array($rezultat)) {
                echo "<tr>    
                                <td>{$red['naziv']}</td>
                                <td>{$red['ukupan_broj_svidanja']}</td>
                             </tr>";
            }
            ?>
        </tbody>
    </table>
    </div>


    <?php include_once("footer.php"); ?>

    
</body>

</html>