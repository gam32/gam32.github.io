<?php
session_start();
 
include("../../DB_login.php");


if(!isset($_SESSION['Medlem_ID']) || empty($_SESSION['Medlem_ID'])){
	$login = "login";
	header("location: ../../login/login.php");
	
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
<title>Våpen</title>
<link rel="stylesheet" href="../../index.css">
<link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
<link rel="icon" href="../../Bilder/logoen.png">
</head>
	
	<?php
	include("../../DB_login.php");
	$medlem = $_SESSION['Medlem_ID'];
	
	$sql = "SELECT * FROM vaapen_type";
	$result = $kobling->query($sql);
	?>
	
	
	
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
		<h1 class="overskrift">Her kan du legge til våpen i våpenskapet ditt</h1><br>
		<div class="row">
			<div class="column_2">
				<form action="send_data_vaapen.php" method="post">
					<fieldset style="width: 40%; margin: auto">
						<table>
							<tr>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Våpentype:</td>
						<td><select name="vaapentype">
							<?php
							if ($result->num_rows > 0){
								while($rad = $result->fetch_assoc()){
									echo("<option value=" . $rad["Vaapentype_ID"]. ">" . $rad["Vaapentype"] . "</option>");
								}
							}
							else{
								echo("");
							}
							?>
						</select></td></tr>
							<tr>
								<td><p>Merke:</p></td> 
								<td><input type="text" name="merke"></td>
							</tr>
							<tr>
								<td><p>Modell:</p></td>
								<td><input type="text" name="modell"></td>
							</tr></table>
						<input type="submit" value="Legg til våpen">
					</fieldset>
				</form>
			</div>
			<div class="column_2"><img src="../../Bilder/vaapen.jpg" alt="Hagle"></div>
		</div>
	</div>
<body>
</body>
</html>