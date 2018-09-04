<?php
include('../../DB_login.php');
session_start();
 
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

$sql_slett = "DELETE FROM skuddserie WHERE skuddserie.Skudd=0";
$kobling->query($sql_slett);


$Medlem_id = $_SESSION['Medlem_ID'];
if(empty($_POST['vaapentype'])){
	$vaapentype = 1;
}
else{
	$vaapentype = $_POST['vaapentype'];	
}
$sql = "SELECT Dato, Merke, Modell, Skudd, Poeng, Vaapentype, Info FROM skuddserie, vaapen, vaapen_type WHERE skuddserie.Vaapen=vaapen.Vaapen_id AND vaapen_type.Vaapentype_ID=vaapen.vaapentype_id AND skuddserie.Medlem_ID=$Medlem_id AND vaapen.vaapentype_id=$vaapentype ORDER BY skuddserie.Dato DESC";
$resultat = $kobling->query($sql);

$VT_res = mysqli_query($kobling,"SELECT Vaapentype FROM vaapen_type WHERE Vaapentype_ID=$vaapentype");
$rad = mysqli_fetch_row($VT_res);
$VT = $rad[0];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Dine skytedata</title>
<link rel="stylesheet" href="../../index.css">
<link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
<link rel="icon" href="../../Bilder/logoen.png">
<style>
	table, td, th {
    border: 1px solid black;
	border-collapse: collapse;
	padding: 0.5em;
	}
	table {
		width: 90%;
		margin: auto;
		float: right;
	}
	form {
		margin: 0 7em;
	}
	p {
		margin: 0 12em;
	}
</style>
</head>
<body>
	
	<ul class="meny">
		<li class="meny"><a class="img" href="../../Index.php"><img src="../../Bilder/logoen.png" alt="Logo"></a></li>
		<li class="meny"><a class="meny_a" href="../../info/terminliste.php">Terminliste</a></li>
		<li class="meny"><a class="meny_a" href="../../info/ungdom.php">Ungdommer</a></li>
		<li class="meny"><a class="meny_a" href="../../Skytterdata/Skytedata.php">Resultater</a></li>
		<li class="meny">
			<div class="drop">
				<?php
				if($login == "logout"){
				echo('<a class="meny_a" href="../../Min_side/Min_side.php" class="dropbtn">Min Side</a>
				<div class="dropdown-content">
					<a class="drop_link" href="../../Min_side/Data/data.php">Dine resultater</a>
					<a class="drop_link" href="../../Min_side/Vaapen/addvaapen.php">Legg til våpen</a>');
					if($admin == "TRUE"){ echo('<a class="drop_link" href="../../admin/admin.php">Adminmeny</a>');}
					echo('<a class="drop_link" href="../../Login/logout.php">Logg ut</a>');
					echo('</div>');}
				elseif($login == "login"){
					echo('<a class="meny_a" href="../../Login/login.php">Logg inn</a>');
				}?></div></li>
	</ul>
	
	<div class="inf">
		<div class="row">
			<div class="column_3">
				<h2 class="overskrift">Her kan du velge hvilke skuddserier du skal se</h2>
				<form action="../Data/data.php" method="post">
					<input type="radio" name="vaapentype" value="1" <?php if($vaapentype==1){echo('checked');}?>>Hagle 
					<input type="radio" name="vaapentype" value="2" <?php if($vaapentype==2){echo('checked');}?>>Rifle 
					<input type="Radio" name="vaapentype" value="3" <?php if($vaapentype==3){echo('checked');}?>>Pistol <br> 
					<input style="margin: 1.5em 5em 0" type="submit" value="Velg">
				</form>
				<br>
			</div>
			
			<div class="column_2">
				<h2 class="overskrift">Her er listen over dine skuddserier med <?php echo($VT) ?></h2>

				<?php
				if ($resultat->num_rows	 > 0) {
					echo "<table> <tr><th>Dato</th><th>Våpen</th><th>Antall skudd</th><th>Poeng</th><th>Info</th></tr>";
					while($rad=$resultat->fetch_assoc()) {
						$dato=$rad["Dato"];
						$vaapen=$rad["Merke"] . " " . $rad["Modell"];
						$skudd=$rad["Skudd"];
						$poeng=$rad["Poeng"];
						$info=$rad["Info"];


						echo "<tr><td> " . $dato . "</td><td>" . $vaapen . "</td><td>" . $skudd . "</td><td>" . $poeng . "</td><td>" . $info . "</td></tr>";
					}
					echo "</table>";
				}
				elseif ($resultat->num_rows == 0){
					
						echo("<p>Du har ingen skuddserier med " . $VT . "</p>");
				}
				?>
			</div>
		</div>
	</div>
</body>
</html>