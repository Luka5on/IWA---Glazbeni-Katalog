<?php
include_once("baza.php");
session_start();
$veza = spojiSeNaBazu();



if (isset($_GET['id'])) {
    $id_medijske = $_GET["id"];
} else {
    $id_medijske = $_POST['id'];
}



if (isset($_POST['azuriranje-medijska'])) {
    $upit_azuriraj = "UPDATE medijska_kuca SET `naziv` = '{$_POST['naziv']}', `opis` = '{$_POST['opis']}' WHERE medijska_kuca_id = {$id_medijske}";
    $rez = izvrsiUpit($veza, $upit_azuriraj);

    $upit_brisi_mod = "UPDATE korisnik SET medijska_kuca_id = NULL WHERE medijska_kuca_id = {$id_medijske}";
    izvrsiUpit($veza, $upit_brisi_mod);

    foreach ($_POST["moderator"] as $moderator_id) {
        $upit_azuriraj_mod = "UPDATE korisnik SET medijska_kuca_id = {$id_medijske} WHERE korisnik_id = {$moderator_id}";
        izvrsiUpit($veza, $upit_azuriraj_mod);
    }
    $skripta = $_SERVER['PHP_SELF'];
}



$upit_podaci = "SELECT * FROM medijska_kuca WHERE medijska_kuca_id = {$id_medijske}";
$rezultat_podaci = izvrsiUpit($veza, $upit_podaci);
$red_podaci = mysqli_fetch_array($rezultat_podaci);

$upit_svi_mod = "SELECT * FROM korisnik WHERE tip_korisnika_id = 1";
$svi_mod = izvrsiUpit($veza, $upit_svi_mod);
?>


<!DOCTYPE html>
<html lang="hr">

<head>
    <title>Ažuriraj medijsku kuću</title>
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
                    <td><input type="text" name="naziv" style="width: 96%" autofocus required value="<?php echo $red_podaci['naziv'] ?>"></td>
                </tr>
                <tr>
                    <td><label for="opis">Opis:</label></td>
                    <td><textarea name="opis" cols=60 rows=15><?php echo $red_podaci['opis'] ?></textarea></td>
                </tr>
                <tr>
                    <td>Moderatori:</td>
                    <td>
                        <?php
                        while ($red = mysqli_fetch_array($svi_mod)) {

                            echo "<input type='checkbox' name=moderator[] value='{$red['korisnik_id']}' ";
                            $upit_odabrani_mod = "SELECT korisnik_id FROM korisnik WHERE medijska_kuca_id = {$id_medijske}";
                            $rez_odabrani_mod = izvrsiUpit($veza, $upit_odabrani_mod);
                            while ($odabrani_mod = mysqli_fetch_array($rez_odabrani_mod)) {

                                if ($red["korisnik_id"] == $odabrani_mod["korisnik_id"]) echo " checked ";
                            }
                            echo ">{$red['ime']} {$red['prezime']}<br>";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td><input type="hidden" name="id" value="<?php echo $id_medijske ?>"></td>
                    <td><input type="submit" name="azuriranje-medijska" id="azuriranje-medijska" value="Ažuriraj medijsku kuću"></td>
                </tr>
            </form>
        </tbody>
    </table>
    </div>


    <?php include_once("footer.php");
    zatvoriVezuNaBazu($veza); ?>

    
</body>

</html>