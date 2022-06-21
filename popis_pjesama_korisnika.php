<?php
session_start();
include("baza.php");
$veza = spojiSeNaBazu();

if (isset($_GET["odobri"])) {
    $dat_vrijeme = date("Y-m-d H:i:s");
    $upit_odobri = "UPDATE pjesma SET datum_vrijeme_kupnje = '{$dat_vrijeme}' WHERE pjesma_id = '{$_GET['odobri']}'";
    izvrsiUpit($veza, $upit_odobri);
}

if (isset($_GET["odbij"])) {
    $upit_odbij = "UPDATE pjesma SET medijska_kuca_id = NULL WHERE pjesma_id = '{$_GET['odbij']}'";
    izvrsiUpit($veza, $upit_odbij);
}

if (isset($_SESSION["korisnik_id"])) {
    $korisnik_id = $_SESSION["korisnik_id"];
    $upit = "SELECT pjesma.* FROM pjesma WHERE korisnik_id = {$korisnik_id}";
    $rezultat = izvrsiUpit($veza, $upit);
}
zatvoriVezuNaBazu($veza);
?>


<!DOCTYPE html>
<html lang="hr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Popis pjesama korisnika</title>
</head>

<body>


    <?php include_once("header.php") ?>


    <div class="kontenjer">
    <table class="tablica_dt">
        <thead>
            <th>Naziv</th>
            <th>Opis</th>
            <th>Datum i vrijeme kreiranja</th>
            <th>Datum i vrijeme kupnje</th>
            <th>Audio zapis</th>
            <th>Status</th>
        <tbody>
            <?php
            $skripta = $_SERVER["PHP_SELF"];
            while ($red = mysqli_fetch_array($rezultat)) {
                $datum_kreiranja = date('d.m.Y H:i:s', strtotime($red['datum_vrijeme_kreiranja']));

                if ($red['datum_vrijeme_kupnje'] == NULL) {
                    $datum_kupnje = "-";
                } else {
                    $datum_kupnje = date('d.m.Y H:i:s', strtotime($red['datum_vrijeme_kupnje']));
                }
                if ($datum_kupnje != "-") {
                    $status = "kupljena";
                } else if (($red['medijska_kuca_id'] != NULL) && ($datum_kupnje = "-")) {
                    $status = "zatražena kupnja";
                } else if (($red['medijska_kuca_id'] == NULL) && ($datum_kupnje = "-")) {
                    $status = "nije kupljena";
                }

                echo "
                        <tr>
                            <td>{$red['naziv']}</td>
                            <td>{$red['opis']}</td>
                            <td>{$datum_kreiranja}</td>
                            <td>{$datum_kupnje}</td>
                            <td><audio controls><source src='{$red['poveznica']}' type='audio/mpeg'></audio</td>
                            <td>{$status}</td>";
                if ($status !== "kupljena") echo "
                            <td><a href='azuriraj_pjesmu.php?id={$red['pjesma_id']}'><button class='button'>Ažuriraj pjesmu</button></a>";
                else echo "<td></td>";

                if ($status === "zatražena kupnja") {
                    echo "<td><a href='{$skripta}?odobri={$red['pjesma_id']}'><button class='button'>Odobri kupnju</button></td>";
                    echo "<td><a href='{$skripta}?odbij={$red['pjesma_id']}'><button class='button'>Odbij kupnju</button></td>";
                }

                echo "</tr>";
            }
            ?>
        </tbody>

        </thead>
    </table>

    </div>


    <?php include_once("footer.php") ?>

    
</body>

</html>