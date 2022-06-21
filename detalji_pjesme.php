<?php
session_start();
include("baza.php");
$veza = spojiSeNaBazu();



if (isset($_GET["svida"])) {
    $sql = "UPDATE pjesma
            SET broj_svidanja = IFNULL(broj_svidanja, 0) + 1
            WHERE pjesma_id = {$_GET['id']}";

    $rez_svida = izvrsiUpit($veza, $sql);
}



if (isset($_GET["id"])) {
    $id_pjesme = $_GET["id"];
    $upit = "SELECT pjesma.*, korisnik.ime, korisnik.prezime
            FROM pjesma 
            INNER JOIN korisnik ON pjesma.korisnik_id = korisnik.korisnik_id 
            WHERE pjesma.pjesma_id = {$_GET['id']}";
    $rezultat = izvrsiUpit($veza, $upit);
    $red = mysqli_fetch_array($rezultat);


    if ($red["medijska_kuca_id"] !== NULL) {
        $upit_naziv_medijske_k = "SELECT DISTINCT naziv FROM medijska_kuca WHERE medijska_kuca_id = {$red['medijska_kuca_id']}";
        $rez_medijska = izvrsiUpit($veza, $upit_naziv_medijske_k);
        $red_medijska = mysqli_fetch_array($rez_medijska);
        $naziv_medijske_k = $red_medijska["naziv"];
    }
}
zatvoriVezuNaBazu($veza);
?>


<!DOCTYPE html>
<html lang="hr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Detalji pjesme</title>
</head>

<body>


    <?php include_once("header.php") ?>


    <div class="kontenjer">
    <table class="tablica_dt">
        <tbody>
            <tr>
                <td>Naziv pjesme</td>
                <td><?php echo $red["naziv"] ?></td>
            </tr>
            <tr>
                <td>Datum i vrijeme kreiranja</td>
                <td><?php echo $red["datum_vrijeme_kreiranja"] ?></td>
            </tr>
            <tr>
                <td>Broj sviđanja</td>
                <td><?php echo $red["broj_svidanja"] ?></td>
            </tr>
            <tr>
                <td>Opis</td>
                <td><?php echo $red["opis"] ?></td>
            </tr>
            <tr>
                <td>Sviđa mi se</td>
                <td><a href="<?php echo $_SERVER['PHP_SELF'] ?>?svida=1&id=<?php echo $id_pjesme ?>"><button>Sviđa mi se</button></a></td>
            </tr>
            <tr>
                <td>Ime i prezime korisnika</td>
                <td><?php echo $red['ime'] . " " . $red['prezime'] ?></td>
            </tr>
            <tr>
                <td>Naziv medijske kuće</td>
                <td><?php if (isset($naziv_medijske_k)) echo $naziv_medijske_k ?></td>
            </tr>
        </tbody>
    </table>
    </div>


    <?php include_once("footer.php") ?>

    
</body>

</html>