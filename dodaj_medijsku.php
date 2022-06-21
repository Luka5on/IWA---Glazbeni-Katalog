<?php
include_once("baza.php");
session_start();
$veza = spojiSeNaBazu();

if (isset($_POST['unos-medijska'])) {
    $upit_dodaj = "INSERT INTO medijska_kuca (`naziv`, `opis`) VALUES ('{$_POST['naziv']}', '{$_POST['opis']}')";
    $rez = izvrsiUpit($veza, $upit_dodaj);
    $id_nove_kuce = mysqli_insert_id($veza);

    foreach ($_POST["moderator"] as $moderator_id) {
        $upit_dodaj_kucu = "UPDATE korisnik SET medijska_kuca_id = {$id_nove_kuce} WHERE korisnik_id = {$moderator_id}";
        izvrsiUpit($veza, $upit_dodaj_kucu);
    }
    header("Location: popis_medijskih_kuca.php");
}

$upit_svi_mod = "SELECT * FROM korisnik WHERE tip_korisnika_id = 1";
$svi_mod = izvrsiUpit($veza, $upit_svi_mod);
zatvoriVezuNaBazu($veza);
?>


<!DOCTYPE html>
<html lang="hr">

<head>
    <title>Dodaj medijsku kuću</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>


    <?php include_once("header.php"); ?>


    <div class="kontenjer">
    <table class="tablica_dt">
        <tbody>
            <form id=dodaj-medijsku name=dodaj-medijsku method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
                <tr>
                    <td><label for="naziv">Naziv medijske kuće:</label></td>
                    <td><input type="text" name="naziv" style="width:96%" autofocus required></td>
                </tr>
                <tr>
                    <td><label for="opis">Opis:</label></td>
                    <td><textarea name="opis" cols=60 rows=15></textarea></td>
                </tr>
                <tr>
                    <td>Moderatori:</td>
                    <td>
                        <?php
                        while ($red = mysqli_fetch_array($svi_mod)) {
                            echo "<input type='checkbox' name=moderator[] value='{$red['korisnik_id']}'>{$red['ime']} {$red['prezime']}<br>";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="unos-medijska" id="unos-medijska" value="Unesi medijsku kuću"></td>
                </tr>
            </form>
        </tbody>
    </table>
    </div>


    <?php include_once("footer.php"); ?>

    
</body>

</html>