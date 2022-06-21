<?php
session_start();
include("baza.php");

if (isset($_POST["dodaj-pjesmu"])) {
    $veza = spojiSeNaBazu();
    $upit = "INSERT INTO `pjesma` (`korisnik_id`, `medijska_kuca_id`, `naziv`, `poveznica`, `opis`, `datum_vrijeme_kreiranja`, `datum_vrijeme_kupnje`, `broj_svidanja`) VALUES ({$_SESSION['korisnik_id']}, NULL, '{$_POST['naziv']}', '{$_POST['url']}', '{$_POST['opis']}', '{$_POST['datum-kreiranja']}', NULL, NULL)";
    $rezultat = izvrsiUpit($veza, $upit);
    zatvoriVezuNaBazu($veza);
}
?>


<!DOCTYPE html>
<html lang="hr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Dodaj novu pjesmu</title>
</head>

<body>


    <?php include_once("header.php") ?>


    <div class="kontenjer">
    <table class="tablica_dt">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <tr>
                <td><label for="naziv">Naziv:</label></td>
                <td><input type="text" name="naziv" required></td>
            </tr>
            <tr>
                <td><label for="url">Poveznica do pjesme:</label></td>
                <td><input type="url" name="url" required><br></td>
            </tr>
            <tr>
                <td><label for="opis">Opis:</label></td>
                <td><textarea name="opis" cols="60" rows="15"></textarea><br></td>
            </tr>
            <tr>
                <td><input type="hidden" name="datum-kreiranja" value="<?php echo date("Y-m-d H:i:s") ?>"></td>
                <td><input type="submit" name="dodaj-pjesmu" class='button' value="Dodaj pjesmu"></td>
            </tr>
        </form>
    </table>
    </div>


    <?php include_once("footer.php") ?>

    
</body>

</html>