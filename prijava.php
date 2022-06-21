<?php
session_start();
include_once("baza.php");
$veza = spojiSeNaBazu();

if (isset($_POST["prijava"])) {
    $korime = $_POST["korime"];
    $lozinka = $_POST["lozinka"];

    if (!empty($korime) && (!empty($lozinka))) {
        $upit = "SELECT * FROM korisnik WHERE korime = '{$korime}' AND lozinka = '{$lozinka}'";
        $rezultat = izvrsiUpit($veza, $upit);
        while ($red = mysqli_fetch_array($rezultat)) {
            $_SESSION["korisnik_id"] = $red["korisnik_id"];
            $_SESSION["korime"] = $red["korime"];
            $_SESSION["tip"] = $red["tip_korisnika_id"];
            $_SESSION["ime"] = $red["ime"] . " " . $red["prezime"];

            $upit_tip_korisnika = "SELECT naziv FROM tip_korisnika WHERE tip_korisnika_id = {$red['tip_korisnika_id']}";
            $rezultat_tip_korisnika = izvrsiUpit($veza, $upit_tip_korisnika);
            $red_tip = mysqli_fetch_array($rezultat_tip_korisnika);
            $_SESSION["tip_opis"] = $red_tip["naziv"];

            header("Location: index.php");
            exit();
        }
    }
}

if (isset($_GET["odjava"])) {
    unset($_SESSION);
    session_destroy();
}
zatvoriVezuNaBazu($veza);
?>

<!DOCTYPE html>
<html lang="hr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Prijava</title>
</head>

<body>


    <?php include_once("header.php") ?>


    <div class="kontenjer">
    <table class="tablica_dt">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <tr>
                <td><label for="korime">Korisničko ime:</label></td>
                <td><input type="text" name="korime" required><br></td>
            </tr>
            <tr>
                <td><label for="lozinka">Lozinka:</label></td>
                <td><input type="password" name="lozinka" required><br></td>
            </tr>
                <td><input type="submit" name="prijava" value="Prijavi se"></td>
        </form>
    </table>
    </div>


    <?php include_once("footer.php") ?>

    
</body>

</html>