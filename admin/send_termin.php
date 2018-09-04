<?php

include("../DB_login.php");

$navn = $_POST["navn"];
$dato = $_POST["dato"];
$tid = $_POST["tid"];
$info = $_POST["beskrivelse"];



$sql = "INSERT INTO termin (Navn, Dato, Tidspunkt, Beskrivelse) VALUES ('$navn', '$dato', '$tid', '$info')";

if ($kobling->query($sql)) {
		header("location: admin.php");
	} else {
		echo "Error: " . $sql . "<br>" . $kobling->error;
	}


?>