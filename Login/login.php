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
	
		require_once("DB_login.php");
		
		$epost = $passord = "";
		$epost_err = $pass_err = "";
		
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			
			//se om epostfeltet er tomt
			if(empty(trim($_POST["epost"]))){
				$epost_err = 'Vennligst skriv inn epost.';
			}
			
			else{
				$epost = trim($_POST["epost"]);
			}
			
			//se om passordfeltet er tomt
			if(empty(trim($_POST['Passord']))){
        		$pass_err = 'Vennligst skriv inn ditt passord.';
    		}
			else{
        		$passord = trim($_POST['Passord']);
    		}
			
			//se om informasjonen stemmer:
			
			if(empty($epost_err) && empty($pass_err)){
				$sql = "SELECT Medlem_ID, Epost, Passord FROM medlem WHERE epost = ?";
				
				if($stmt = mysqli_prepare($link, $sql)){
					mysqli_stmt_bind_param($stmt, "s", $param_epost);
					
					$param_epost = $epost;
					
					if(mysqli_stmt_execute($stmt)){
						mysqli_stmt_store_result($stmt);
						
						if(mysqli_stmt_num_rows($stmt) == 1){
							mysqli_stmt_bind_result($stmt, $medlem, $epost, $hashed_passord);
							if(mysqli_stmt_fetch($stmt)){
								if(password_verify($_POST['Passord'], $hashed_passord)){
									session_start();
									$_SESSION['epost'] = $epost;
									$_SESSION['Medlem_ID'] = $medlem;
									$header = $_SESSION['header'];
									header("location:../index.php");	
		
								}
								else{
									$pass_err = "Feil passord.";
								}
							}
						}
						else{
							$epost_err = "Denne brukeren eksisterer ikke.";
						}
					}
					else{
						echo("Noe gikk galt, vennligst prøv igjen senere.");
					}
				}
				
				mysqli_stmt_close($stmt);
			}
			mysqli_close($link);
		}
		?>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<link rel="stylesheet" href="../index.css">
<link rel="icon" href="../Bilder/logoen.png"
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
	
	<h1 class="overskrift">Logg inn</h1>
	
	<fieldset>
    <div class="wrapper">
        <h2>Log in</h2>
        <p>Vennligst fyll inn epost og passord for å logge inn</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($epost_err)) ? 'has-error' : ''; ?>">
                <label>Epost</label>
                <input type="email" name="epost"class="form-control" value="<?php echo $epost; ?>">
                <span class="help-block"><?php echo $epost_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($pass_err)) ? 'has-error' : ''; ?>">
                <label>Passord</label>
                <input type="password" name="Passord" class="form-control">
                <span class="help-block"><?php echo $pass_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Har du ikke bruker? <a href="registrere.php">Registrer deg nå</a>.</p>
        </form>
		
    </div>
	</fieldset>
</div>
</body>
</html>