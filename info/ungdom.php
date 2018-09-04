<?php
session_start();
 
include("../DB_login.php");


if(!isset($_SESSION['Medlem_ID']) || empty($_SESSION['Medlem_ID'])){
	$login = "login";
	
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
<title>Ungdommer</title>
<link rel="stylesheet" href="../index.css">
<link rel="icon" href="../Bilder/logoen.png">
<link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
</head>
	
	
	<ul class="meny">
		<li class="meny"><a class="img" href="../Index.php"><img src="../Bilder/logoen.png" alt="Logo"></a></li>
		<li class="meny"><a class="meny_a" href="../info/terminliste.php">Terminliste</a></li>
		<li class="meny"><a class="meny_a" href="../info/ungdom.php">Ungdommer</a></li>
		<li class="meny"><a class="meny_a" href="../Skytterdata/Skytedata.php">Resultater</a></li>
		<li class="meny">
			<div class="drop">
				<?php
				if($login == "logout"){
				echo('<a class="meny_a" href="../Min_side/Min_side.php" class="dropbtn">Min Side</a>
				<div class="dropdown-content">
					<a class="drop_link" href="../Min_side/Data/data.php">Dine resultater</a>
					<a class="drop_link" href="../Min_side/Vaapen/addvaapen.php">Legg til våpen</a>');
					if($admin == "TRUE"){ echo('<a class="drop_link" href="../admin/admin.php">Adminmeny</a>');}
					echo('<a class="drop_link" href="../Login/logout.php">Logg ut</a>');
					echo('</div>');}
				elseif($login == "login"){
					echo('<a class="meny_a" href="../Login/login.php">Logg inn</a>');
				}?></div></li>
	</ul>
		
	<div class="inf">
		<h1 class="overskrift">Ungdommer</h1>
		<div class="row">
			<div class="column_2">
				<p class="inf_p">
					Ungdomsavdelingen har fellestreninger mandag og tirsdag på vår skytebane på Jonsvatnet.<br><br>

					På vinteren trener vi innendørs på 15-metersbanen, i tillegg til feltskyting enkelte lørdager. På sommeren trener vi utendørs på vår 100-metersbane.<br><br>

					Alle nybegynnere skal gjennomgå grundig opplæring i sikkerhet, våpenteknisk og grunnleggende skyteteknikk før man blir med på fellestreninger. Dette gjennomføres med våre instruktører etter avtale.<br><br>

 

					Instruktører:
						<ul>
						<li>Jo Darell</li>
						<li>Robert Stornes</li>
						<li>Morten Andersen</li>
						<li>Kristian Jansen</li>
						<li>Torstein Halsli</li>
						</ul>
				</p>
			<p class="inf_p">
				
						Kontaktinfo:
						
						<ul>
						<li>jo.darell80@gmail.com</li>

						<li>nidaros@skytterlag.no</li>
						</ul>
				</p>
			</div>
		<div class="column_2"><img src="../Bilder/ungdommer.jpg" alt="Ungdommer"></div>
		</div>
	</div>	

<body>
</body>
</html>