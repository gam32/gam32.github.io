<?php
session_start();
 
if(!isset($_SESSION['Medlem_ID']) || empty($_SESSION['Medlem_ID'])){
  header("location: ../login/login.php");
  exit;
}


include("../../DB_login.php");
$vaapentype=$_POST["vaapentype"];
$merke=$_POST["merke"];
$modell=$_POST["modell"];
$medlem=$_SESSION["Medlem_ID"];


$sql="INSERT INTO vaapen (Medlem_ID, vaapentype_id, Merke, Modell) VALUES ('$medlem', '$vaapentype', '$merke', '$modell')";

	if ($kobling->query($sql)) {
		header("location: ../Min_side.php");
	} else {
		echo "Error: " . $sql . "<br>" . $kobling->error;
	}
	
?>