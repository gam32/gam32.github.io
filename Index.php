<?php
session_start();
 
include("DB_login.php");


if(!isset($_SESSION['Medlem_ID']) || empty($_SESSION['Medlem_ID'])){
	$login = "login";
	header('location=../login/login.php');
	
}
else {
	$login = "logout";
	
	$medlem = $_SESSION["Medlem_ID"];

	$admin_res = mysqli_query($kobling, "SELECT admin FROM medlem WHERE Medlem_ID=$medlem");
	$rad = mysqli_fetch_row($admin_res);
	$admin = $rad[0];
}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Skytebane</title>
<link rel="stylesheet" href="index.css">
<link rel="icon" href="Bilder/logoen.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">

</head>
	

<body>
	<div class="header">
	<ul class="meny">
		<li class="meny"><a class="img" href="Index.php"><img src="Bilder/logoen.png" alt="Logo"></a></li>
		<li class="meny"><a class="meny_a" href="info/terminliste.php">Terminliste</a></li>
		<li class="meny"><a class="meny_a" href="info/ungdom.php">Ungdommer</a></li>
		<li class="meny"><a class="meny_a" href="Skytterdata/Skytedata.php">Resultater</a></li>
		<li class="meny">
			<div class="drop">
				<?php
				if($login == "logout"){
				echo('<a class="meny_a" href="Min_side/Min_side.php" class="dropbtn">Min Side</a>
				<div class="dropdown-content">
					<a class="drop_link" href="Min_side/Data/data.php">Dine resultater</a>
					<a class="drop_link" href="Min_side/Vaapen/addvaapen.php">Legg til våpen</a>');
					if($admin == "TRUE"){ echo('<a class="drop_link" href="admin/admin.php">Adminmeny</a>');}
					echo('<a class="drop_link" href="Login/logout.php">Logg ut</a>');
					echo('</div>');}
				elseif($login == "login"){
					echo('<a class="meny_a" href="Login/login.php">Logg inn</a>');
				}?></div></li>
	</ul>
	</div>

	<div class="inf">
		<h1 class="overskrift">Trondheim skyteklubb</h1>
		<div class="row">
			<div class="column_3">
				<h2 class="overskrift">Om oss:</h2>
				<p class="inf_p">Trondheim skyteklubb ble dannet i 1943 og startet som en motstandsgruppe under krigen, etter krigen var over ble den gitt en veldedig gave for arbeidet. Vi har skytebaner for skyting med rifle, hagle og pistol, og alle er like velkomende. På nettsiden vår kan man legge inn skuddseriene sine for å kunne se på fremgangen din gjennom skytingen.</p>
			</div>
			<div class="column_3">
				<h2 class="overskrift">Regler:</h2>
				<p class="inf_p">Vi har felles baneregler med nidaros skyteklubb, disse kan dere finne <a href="https://www.dfs.no/globalassets/associationfiles/nidaros/lover-og-statutter/lover_nidaros_oppdatert-2015.pdf">her</a></p>
			</div>
			<div class="column_3">
				<h2 class="overskrift">Kontakt oss:</h2>
				<p class="inf_p">Det er bare å kontakte oss med alle spørsmål du kan ha, vi svarer iløpet av kort tid og prøver å gi så kvalikative svar som mulig. Ved søknad om jobb send epost med CV og søknad til jobb.Trondheimskyteklubb@gmail.com.</p>
				<p class="inf_p">Magne Moe: magne.moe1@gmail.com</p>
				<p class="inf_p">Jens Karlsen: jens.k@gmail.com</p>
			</div>
		</div>
	</div>
</body>
</html>