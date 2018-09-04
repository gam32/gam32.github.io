<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Hendelser</title>
<link rel="stylesheet" href="../index.css">
</head>
<body>
	
	<h1 class="overskrift">Legg til arrangement</h1>
	
	<ul class="meny">
		<li class="meny"><a href="../Index.php">Vanlig side</a></li>
		<li class="meny_admin"><a href="edit_termin.php">Legg til arrangement</a></li>
		<li class="meny_admin"><a href="edit_medlem.php">Administrer medlemmer</a></li>
		<li class="meny">
			<div class="drop">
				<?php
				if($login == "logout"){
				echo('<a href="Min_side/Min_side.php" class="dropbtn">Min Side</a>
				<div class="dropdown-content">
					<a href="Min_side/Data/data.php">Dine resultater</a>
					<a href="Min_side/Vaapen/addvaapen.php">Legg til våpen</a>');
					if($admin == "TRUE"){ echo('<a href="admin/admin.php">Adminmeny</a>');}
					echo('<a href="Login/logout.php">Logg ut</a>');
					echo('</div>');}
				elseif($login == "login"){
					echo('<a href="Login/login.php">Logg inn</a>');
				}?></div></li>
	</ul>
</body>
</html>