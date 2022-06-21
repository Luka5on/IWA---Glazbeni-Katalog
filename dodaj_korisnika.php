<?php
include_once("baza.php");
session_start();




if (isset($_POST['unos-korisnika-submit'])) {
    $tip_korisnika_unos = $_POST["korisnik-tip"];
    $kor_ime_unos = $_POST["korime"];
    $lozinka_unos = $_POST["lozinka"];
    $ime_unos = $_POST["ime"];
    $prezime_unos = $_POST["prezime"];
    $email_unos = $_POST["email"];

    $veza = spojiSeNaBazu();
    $upit = "INSERT INTO `korisnik`(`tip_korisnika_id`, `medijska_kuca_id`, `korime`, `ime`, `prezime`, `email`, `lozinka`) 
             VALUES ({$tip_korisnika_unos}, NULL, '{$kor_ime_unos}', '{$ime_unos}', '{$prezime_unos}', '{$email_unos}', '{$lozinka_unos}')";   
    
    $rezultat_unos = izvrsiUpit($veza, $upit);
    $korisnik_id_unos = mysqli_insert_id($veza);
} 


$veza = spojiSeNaBazu();
$upit_tip_korisnika = "SELECT * FROM `tip_korisnika`";
$tipovi_korisnika = izvrsiUpit($veza, $upit_tip_korisnika);
zatvoriVezuNaBazu($veza);

?>

<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Dodaj korisnika</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>


        <?php include_once("header.php");?>


            <div class="kontenjer">
            <table class="tablica_dt">
            <tbody>
            <form id=dodaj-korisnika name=dodaj-korisnika method="POST" action="<?= $_SERVER['PHP_SELF'];?>">
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
                    <td><input type="text" name="korime" required></td>
                </tr>
                <tr>
                    <td><label for="ime">Ime:</label></td>
                    <td><input type="text" name="ime" value="" required></td>
                </tr>
                <tr>
                    <td><label for="prezime">Prezime:</label></td>
                    <td><input type="text" name="prezime" required></td>
                </tr>
                <tr>
                    <td><label for="email">e-mail:</label></td>
                    <td><input type="text" name="email" required></td>
                </tr>
                <tr>
                    <td><label for="lozinka">Lozinka:</label></td>
                    <td><input type="password" name="lozinka" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="unos-korisnika-submit" id="unos-korisnika-submit" value="Unesi korisnika"></td>
                </tr>
            </form>
            </tbody>
            </table>
            </div>


        <?php include_once("footer.php");?>

        
    </body>
</html>