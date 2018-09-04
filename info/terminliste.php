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
<title>Terminliste</title>
<link rel="stylesheet" href="../index.css">
<link rel="stylesheet" href="info.css">
<link rel="icon" href="../Bilder/logoen.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
<script>
	function info_open(id) {
	document.getElementById(id).style.display = "block";
	}

	function info_close(id) {
	document.getElementById(id).style.display = "none";
	}
</script>
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
	
	
	<?php
	$slett = "DELETE FORM termin WHERE Dato(DATE) < DATE_SUB(NOW() , INTERVAL 1 DAY)";
	$res = $kobling->query($slett);
	$sql = "SELECT Navn, Dato, Tidspunkt, Beskrivelse FROM termin ORDER BY dato";
	$resultat = $kobling->query($sql);
	?>
	
	<div class="inf">
		
			<h1 class="overskrift">Terminliste</h1>	
		
		<div class="row">
			
			<div class="column_35">
				<p class="inf_p">Her kan dere finne de kommende arrangementene som skjer på banene våre. Ved å trykke på et arrengement vil du få opp all informasjon dere trenger for å bli med på arrangementet.</p>
				<img src="../Bilder/termin.JPG" alt="Skytestevne" width="80%" style="margin-left: 1em;">
			</div>
			
			<div class="column_2">
	
				<div class="terminliste">
						<?php
						$info = "info";
						$tall = 0;
						if ($resultat->num_rows > 0){
							echo "<table> <tr><th>Dato</th><th>Navn</th></tr>";

							while($rad=$resultat->fetch_assoc()){
								$Navn = $rad['Navn'];
								$Dato = $rad['Dato'];
								$Tid = $rad['Tidspunkt'];
								$Beskrivelse = $rad['Beskrivelse'];


								++$tall;

								$inf = "'" . $info . $tall . "'";
								$inf1 = $info . $tall;
								echo('<tr onClick="info_open(' . $inf . ')"><td> ' . $Dato . '</td><td style="width=10em;">' . $Navn . '</td>');
								echo(
								'<div id="' . $inf1 . '" class="block">		
										<div class="block_cont">
											<i class="fa fa-times close" onclick="info_close('. $inf .')"></i>
											<center><h2>' . $Navn .'</h2></center>
											<br>
											<p>Dato: '. $Dato .'</p><br>
											<p>Tidspunkt: ' . $Tid . ' </p><br>
											<p>Info: <br>');  echo nl2br($Beskrivelse . '</p>
										</div>
						</div>');
							;}}
						else {echo("<p> Det er ingen oppføringer </p>");}	?>
				</div>
					
			</div>
		</div>
	</div>
<body>
</body>
</html>