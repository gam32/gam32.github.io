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
<?php

require_once('DB_login.php');

$fornavn = $etternavn = $epost = $passord = $telefon = $dato = "";
$epost_err = $pass_err = $fornavn_err = $etternavn_err = $telf_err = $dato_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	if(empty(trim($_POST["Epost"]))){
		$epost_err = "Dette feltet er tomt.";
	}
	else{
		$sql = "SELECT Medlem_ID FROM medlem WHERE epost = ?";
		
		if($stmt = mysqli_prepare($link, $sql)){
			mysqli_stmt_bind_param($stmt, "s", $param_epost);
			
			$param_epost = trim($_POST["Epost"]);
			
			if(mysqli_stmt_execute($stmt)){
				mysqli_stmt_store_result($stmt);
				
				if(mysqli_stmt_num_rows($stmt) == 1){
					$epost_err = "Det finnes allerede en bruker knyttet til denne eposten.";
				}
				else{
					$epost = trim($_POST["Epost"]);
				}
			}
			else{
				echo "Noe gikk galt, prøv igjen senere.";
			}			
			
		}
		
		mysqli_stmt_close($stmt);
		
	}
	
	//valider passord
	if(empty(trim($_POST["Passord"]))){
        $pass_err = "Dette feltet er tomt.";     
    } 
	elseif(strlen(trim($_POST['Passord'])) < 6){
        $pass_err = "Passordet må være minst 6 tegn.";
    } 
	else{
        $passord = trim($_POST['Passord']);
    }
	
	//valider annen info
	
	if(empty(trim($_POST['Fornavn']))){
		$fornavn_err = "Dette feltet er tomt.";
	}
	else{
		$fornavn = trim($_POST['Fornavn']);
	}
	
	if(empty(trim($_POST['Fornavn']))){
		$fornavn_err = "Dette feltet er tomt.";
	}
	else{
		$fornavn = trim($_POST['Fornavn']);
	}
	
	if(empty(trim($_POST['Etternavn']))){
		$etternavn_err = "Dette feltet er tomt.";
	}
	else{
		$etternavn = trim($_POST['Etternavn']);
	}
	
	if(empty(trim($_POST['Telefon']))){
		$telf_err = "Dette feltet er tomt.";
	}
	else{
		$telefon = trim($_POST['Telefon']);
	}
	
	if(empty(trim($_POST['dato']))){
		$dato_err = "Dette feltet er tomt.";
	}
	else{
		$dato = trim($_POST['dato']);
	}
	
	
	if(empty($username_err) && empty($etternavn_err) && empty($epost_err) && empty($pass_err) && empty($telf_err) && empty($dato_err)){
		
		$sql = "INSERT INTO medlem (Fornavn, Etternavn, Epost, Passord, telefon, fodselsdato) VALUES (?, ?, ?, ?, ?, ?)";
		
		if($stmt = mysqli_prepare($link, $sql)){
			mysqli_stmt_bind_param($stmt, "ssssss", $param_fornavn, $param_etternavn, $param_epost, $param_passord, $param_telf, $param_dato);
			
			$param_fornavn = $fornavn;
			$param_etternavn = $etternavn;
			$param_epost = $epost;
			$param_telf = $telefon;
			$param_dato = $dato;
			$param_passord = password_hash($passord, PASSWORD_DEFAULT);
			
			if(mysqli_stmt_execute($stmt)){
				header("location: login.php");
			}
			else{
				echo "Noe gikk galt, prøv igjen senere.";
			}
		}
		
		mysqli_stmt_close($stmt);
	}
	
	mysqli_close($link);
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrering</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="../index.css">
	<link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
	<link rel="icon" href="../Bilder/logoen.png">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
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
		<h1 class="overskrift">Registering</h1>
    <div class="wrapper">
        <h2>Registrering</h2>
        <p>Fyll ut feltene for å lage en bruker.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($fornavn_err)) ? 'has-error' : ''; ?>">
                <label>Fornavn</label>
                <input type="text" name="Fornavn"class="form-control" value="<?php echo $fornavn; ?>">
                <span class="help-block"><?php echo $fornavn_err; ?></span>
            </div>
			<div class="form-group <?php echo (!empty($etternavn_err)) ? 'has-error' : ''; ?>">
                <label>Etternavn</label>
                <input type="text" name="Etternavn"class="form-control" value="<?php echo $etternavn; ?>">
                <span class="help-block"><?php echo $etternavn_err; ?></span>
            </div>
			<div class="form-group <?php echo (!empty($epost_err)) ? 'has-error' : ''; ?>">
                <label>Epost</label>
                <input type="email" name="Epost"class="form-control" value="<?php echo $epost; ?>">
                <span class="help-block"><?php echo $epost_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($pass_err)) ? 'has-error' : ''; ?>">
                <label>Passord</label>
                <input type="password" name="Passord" class="form-control" value="<?php echo $passord; ?>">
                <span class="help-block"><?php echo $pass_err; ?></span>
            </div>
			<div class="form-group <?php echo (!empty($telf_err)) ? 'has-error' : ''; ?>">
                <label>Telefon</label>
                <input type="text" name="Telefon"class="form-control" value="<?php echo $telefon; ?>">
                <span class="help-block"><?php echo $telf_err; ?></span>
            </div>
			<div class="form-group <?php echo (!empty($dato_err)) ? 'has-error' : ''; ?>">
                <label>Fødselsdato</label>
                <input type="date" name="dato"class="form-control" value="<?php echo $dato; ?>">
                <span class="help-block"><?php echo $dato_err; ?></span>
            </div> 
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Har du allerede en bruker? <a href="login.php">Logg inn her</a>.</p>
        </form>
    </div>
	</div>
</body>
</html>