<?php
session_start();
include("baza.php");
$veza = spojiSeNaBazu();



if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = $_POST['id'];
}



$upit = "SELECT * FROM pjesma WHERE pjesma_id = {$id}";
$rezultat = izvrsiUpit($veza, $upit);
$red = mysqli_fetch_array($rezultat);

if (isset($_POST["azuriraj-pjesmu"])) {
    $upit_azuriraj = "UPDATE pjesma
    SET naziv = '{$_POST['naziv']}', poveznica = '{$_POST['url']}', opis = '{$_POST['opis']}'
    WHERE pjesma_id = '{$id}';";
    $rezultat = izvrsiUpit($veza, $upit_azuriraj);
    header("Location: azuriraj_pjesmu.php?id={$id}");
}
zatvoriVezuNaBazu($veza);
?>


<!DOCTYPE html>
<html lang="hr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Ažuriraj pjesmu</title>
</head>

<body>


    <?php include_once("header.php") ?>


    <div class="kontenjer">
    <table class="tablica_dt">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <tr>
                <td><label for="naziv">Naziv:</label></td>
                <td><input type="text" name="naziv" required value="<?php echo $red["naziv"] ?>"><br></td>
            </tr>
            <tr>
                <td><label for="url">Poveznica do pjesme:</label></td>
                <td><input type="url" name="url" required value="<?php echo $red["poveznica"] ?>"><br></td>
            </tr>
            <tr>
                <td><label for="opis">Opis:</label></td>
                <td><textarea name="opis" cols="30" rows="20"><?php echo $red["opis"] ?></textarea><br></td>
            </tr>
            <tr>
                <td><input type="hidden" name="id" value="<?php echo $id ?>"></td>
                <td><input type="submit" name="azuriraj-pjesmu" value="Ažuriraj pjesmu"></td>
            </tr>
        </form>
    </table>
    </div>


    <?php include_once("footer.php") ?>

    
</body>

</html>