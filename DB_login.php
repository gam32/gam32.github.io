<?php
// Innloggingsinfo til databasen
$tjener = "mysql.klasserom.net";
$brukernavn = "knet-elev19010";
$passord = "qtc69";
$database = "knet-elev19010";

// Opprett forbindelse til databasen
$kobling= new mysqli($tjener, $brukernavn, $passord, $database);
// Sjekk forbindelsen
if ($kobling->connect_error) {
    die("Noe gikk galt: " . $kobling->connect_error);
}

//Angi UTF-8 som tegnsett
$kobling->set_charset("utf-8");
?>