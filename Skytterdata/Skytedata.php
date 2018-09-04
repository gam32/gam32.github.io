
<?php
session_start();
 
include("../DB_login.php");


if(!isset($_SESSION['Medlem_ID']) || empty($_SESSION['Medlem_ID'])){
	$login = "login";
	$_SESSION['header']="/Skytterdata/Skytedata.php";
	header("location: ../login/login.php");
	
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
<title>Lagre Skytedata</title>
<link rel="stylesheet" href="../index.css">
<link rel="stylesheet" href="Skytterdata.css">
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
<style>
	div.table table, th, td {
    border: 1px solid black;
	border-collapse: collapse;
	padding: 0.5em;
}

</style>
</head>

<body>
	
	
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
		
		<h1 class="overskrift">Resultater</h1>
	<?php
	
	include "../DB_login.php";
	
	$medlem = $_SESSION['Medlem_ID'];
		//Select våpen
	$sql = "SELECT vaapen_id, Merke, Modell FROM vaapen WHERE Medlem_ID=$medlem";
	$result = $kobling->query($sql);
	
	?>
		<div class="row">
			<div class="column_2">
				<p class="inf_p">Her kan du legge inn dine treff fra skytingen din, denne er åpen for at alle, slik at ikke bare betalende medlemmer kan bruke den.</p><br>
				<img src="../Bilder/data.jpg" alt="data" width="90%" style="padding-left: 1em;">
			</div>
			<div class="column_2">
				<fieldset>
				<form action="skudd.php" method="post">
					<table class="noline">
						<tr>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><p class="form">Våpen:</p></td>
							<td><select name="vaapen">
							<?php
							if ($result->num_rows > 0)
							{
								while($rad = $result->fetch_assoc()){
									echo "<option value=" . $rad["vaapen_id"]. ">" . $rad["Merke"]. " ". $rad["Modell"]. "</option>"; 
								}
							} else {
								echo "";
							}

							?>
						</select></td>
						</tr>
						<tr>
							<td><p class="form">Dato:</p></td>
							<td><input type="date" name="dato"></td>
						</tr>
						<tr>
							<td><p class="form">Antall skudd</p></td>
							<td><input type="number" name="skudd"></td>
						</tr>
						<tr>
							<td><p class="form">Poeng</p></td>
							<td><input type="text" name="poeng"><a class="info_knapp" onClick="info_open('info')"><img  src="info.png" alt="poeng" style="width:25px;height:25px;"></a></p>
							<div id="info" class="block">		
								<div class="block_cont">
									<i class="fa fa-times close" onclick="info_close('info')"></i>
									<center><h2>Poeng</h2></center>
									<br>
									<div class="table">
										<table style="margin: auto;">
										<tr>
											<td>Rifle/Pistol</td>
											<td>(yttertreff/innertreff)</td>
										</tr>
										<tr>
											<td>Hagle</td>
											<td>Anntall treff</td>
										</tr>
										</table>
									</div>
								</div>
							</div></td>
						</tr>
						<tr>
							<td>Notater:</td>
							<td><textarea name="info" cols="50" rows="10"></textarea></td>
						</tr>
					</table>
						<br><input type="submit" value="Registrer resultatet.">
					<br>
				</form>
				</fieldset>
			</div>
	</div>
	</div>
		

	

</body>
</html>