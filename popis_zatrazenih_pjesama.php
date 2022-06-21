<?php
session_start();
include("baza.php");
$veza = spojiSeNaBazu();

$id_moderatora = $_SESSION["korisnik_id"];

$sql = "SELECT medijska_kuca_id FROM korisnik WHERE korisnik_id = {$id_moderatora}";
$rez = izvrsiUpit($veza, $sql);
$red1 = mysqli_fetch_array($rez);

if ($red1["medijska_kuca_id"] != NULL) {
    $id_medijske_kuce_moderatora = $red1["medijska_kuca_id"];

    $sql = "SELECT pjesma.* FROM pjesma WHERE medijska_kuca_id = {$id_medijske_kuce_moderatora}";
    $rezultat = izvrsiUpit($veza, $sql);
}
zatvoriVezuNaBazu($veza);
?>


<!DOCTYPE html>
<html lang="hr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Popis zatraženih pjesama medijske kuće</title>
</head>

<body>


    <?php include_once("header.php") ?>


    <div class="kontenjer">
    <table class='tablica_dt'>
        <thead>
            <th>Naziv pjesme</th>
            <th>Status</th>
        <tbody>
            <?php
            $skripta = $_SERVER["PHP_SELF"];
            if (isset($rezultat)) {
                while ($red = mysqli_fetch_array($rezultat)) {

                    if (($red['datum_vrijeme_kupnje'] === NULL) || ($red['datum_vrijeme_kupnje'] == '0000-00-00 00:00:00')) {
                        $status = "Čeka odobrenje";
                    } else {
                        $status = "Kupljena";
                    }
                    echo "
                <tr>
                    <td>{$red['naziv']}</td>
                    <td>{$status}</td>
                </tr>";
                }
            }
            ?>
        </tbody>
        </thead>
    </table>
    </div>


    <?php include_once("footer.php") ?>

    
</body>

</html>