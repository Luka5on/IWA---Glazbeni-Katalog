<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
</head>
<body>   
<header>
    <nav>
        <ul>
            <li><a href="index.php">Početna</a></li>


            <?php
            if (isset($_SESSION["korisnik_id"])) {
                echo "<li><a href='dodaj_pjesmu.php'>Dodaj novu pjesmu</a></li> ";
                echo "<li><a href='popis_pjesama_korisnika.php'>Popis pjesama korisnika</a></li> ";
                if ($_SESSION["tip"] <= 1) {
                    echo "<li><a href='popis_zatrazenih_pjesama.php'>Popis zatraženih pjesmi</a></li> ";
                }
                if ($_SESSION["tip"] == 0) {
                    echo "<li><a href='popis_korisnika.php'>Popis korisnika</a> </li>";
                    echo "<li><a href='popis_medijskih_kuca.php'>Popis medijskih kuća</a> </li>";
                    echo "<li><a href='statistika_broj_svidanja.php'>Ukupan broj sviđanja</a> </li>";
                }
                echo "<li><a href='o_autoru.html'>O autoru</a></li><li><a href='prijava.php?odjava'>Odjava</a> </li> ";
            } else echo "<li><a href='o_autoru.html'>O autoru</a></li><li><a href='prijava.php'>Prijava</a> </li>";
            ?>


        </ul>
    </nav>
</header>
<body>
</body>
</html>

<?php
if (isset($_SESSION["korisnik_id"])) {
    echo "<p style='text-align: right'>Korisnik: {$_SESSION['ime']} <br> Vrsta korisnika: {$_SESSION['tip_opis']}</p>";
}
?>