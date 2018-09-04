<?php
session_start();
 
if(!isset($_SESSION['Medlem_ID']) || empty($_SESSION['Medlem_ID'])){
  header("location: ../login/login.php");
  exit;
}
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Skudd</title>
<link rel="stylesheet" href="../index.css">
<link rel="stylesheet" href="skytterdata.css">
</head>

<body>
	<div class="skuddserie_svar">
	<?php
		include "../DB_login.php";
		
		$vaapen=$_POST["vaapen"];
		$dato=$_POST["dato"];
		$medlem=$_SESSION["Medlem_ID"];
		$poeng=$_POST["poeng"];
		$skudd=$_POST["skudd"];
		$info=$_POST["info"];
		
			
		$sql = "INSERT INTO skuddserie (Medlem_ID, Vaapen, Dato, Skudd, Poeng, Info) VALUES ('$medlem', '$vaapen', '$dato', '$skudd', '$poeng', '$info')";
		
	
		if ($kobling->query($sql)) {
		echo "Ny skuddserie lagret";
			header("location: ../min_side/data/data.php");
	} else {
		echo "Error: " . $sql . "<br>" . $kobling->error;
	}
		



//close() the connection
$kobling->close();
	?>
</div>


	
	

</body>
</html>