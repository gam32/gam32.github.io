<?php
session_start();
 
include("../DB_login.php");


if(!isset($_SESSION['Medlem_ID']) || empty($_SESSION['Medlem_ID'])){
	$login = "login";
	header('location:../login/login.php');
	
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
<title>Admin</title>
<link rel="stylesheet" href="../index.css">
<link rel="stylesheet" href="admin.css">
<link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
</head>

<body>
	
	<h1 class="overskrift">Administrasjon</h1>
	<ul class="meny">
		<li class="meny"><a class="img" href="../Index.php"><img src="../Bilder/logoen.png" alt="Logo"></a></li>
		<li class="meny"><a class="meny_a" href="edit_termin.php">Legg til hendelser</a></li>
		<!--<li class="meny"><a class="meny_a" href="edit_medlem.php">Administrer medlemmer</a></li>-->
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
</body>
</html>