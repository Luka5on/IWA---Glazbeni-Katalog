<?php
include_once("baza.php");
session_start();
$veza = spojiSeNaBazu();



if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else if (isset($_POST["id"])) {
    $id = $_POST["id"];
}



if (isset($_POST['unos-korisnika-submit'])) {
    $tip_korisnika_unos = $_POST["korisnik-tip"];
    $kor_ime_unos = $_POST["korime"];
    $lozinka_unos = $_POST["lozinka"];
    $ime_unos = $_POST["ime"];
    $prezime_unos = $_POST["prezime"];
    $email_unos = $_POST["email"];

    $upit = "UPDATE korisnik SET `tip_korisnika_id` = {$tip_korisnika_unos}, `medijska_kuca_id` = NULL, `korime` = '{$kor_ime_unos}', `ime` = '{$ime_unos}', `prezime` = '{$prezime_unos}', `email` = '{$email_unos}', `lozinka` = '{$lozinka_unos}'
    WHERE `korisnik_id` = {$id}";
    $rezultat_unos = izvrsiUpit($veza, $upit);
}



$upit = "SELECT * FROM korisnik WHERE korisnik_id = {$id}";
$rez_korisnik = izvrsiUpit($veza, $upit);
$red_korisnik = mysqli_fetch_array($rez_korisnik);



$veza = spojiSeNaBazu();
$upit_tip_korisnika = "SELECT * FROM `tip_korisnika`";
$tipovi_korisnika = izvrsiUpit($veza, $upit_tip_korisnika);
zatvoriVezuNaBazu($veza);
?>



<!DOCTYPE html>
<html lang="hr">

<head>
    <title>Ažuriraj korisnika</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>


    <?php include_once("header.php"); ?>


    <div class="kontenjer">
    <table class="tablica_dt">
        <tbody>
            <form id=dodaj-korisnika name=dodaj-korisnika method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
                <tr>
                    <td><label for="korisnik-tip">Tip korisnika:</label></td>

                    <td><select name="korisnik-tip" autofocus required class="galerija-filtracija dodaj-azuriraj">
                            <?php
                            while ($red = mysqli_fetch_array($tipovi_korisnika)) {
                                $tip_korisnika_baza = $red['tip_korisnika_id'];
                                $naziv = $red['naziv'];
                                echo "<option value='{$tip_korisnika_baza}'";
                                if ($tip_korisnika_baza == 2) echo " selected";
                                echo ">{$naziv}</option>";
                            }
                            ?>
                        </select></td>
                </tr>
                <tr>
                    <td><label for="kor-ime">Korisničko ime:</label></td>
                    <td><input type="text" name="korime" required value="<?php echo $red_korisnik['korime'] ?>"></td>
                </tr>
                <tr>
                    <td><label for="ime">Ime:</label></td>
                    <td><input type="text" name="ime" required value="<?php echo $red_korisnik['ime'] ?>"></td>
                </tr>
                <tr>
                    <td><label for="prezime">Prezime:</label></td>
                    <td><input type="text" name="prezime" required value="<?php echo $red_korisnik['prezime'] ?>"></td>
                </tr>
                <tr>
                    <td><label for="email">e-mail:</label></td>
                    <td><input type="text" name="email" required value="<?php echo $red_korisnik['email'] ?>"></td>
                </tr>
                <tr>
                    <td><label for="lozinka">Lozinka:</label></td>
                    <td><input type="password" name="lozinka" required value="<?php echo $red_korisnik['lozinka'] ?>"></td>
                </tr>
                <tr>
                    <td><input type="hidden" name="id" value="<?php echo $red_korisnik['korisnik_id'] ?>"></td>
                    <td><input type="submit" name="unos-korisnika-submit" class='button' id="unos-korisnika-submit" value="Ažuriraj korisnika"></td>
                </tr>
            </form>
        </tbody>
    </table>
    </div>


    <?php include_once("footer.php"); ?>


</body>

</html>