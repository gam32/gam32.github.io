<?php

define('DB_SERVER', 'mysql.klasserom.net');
define('DB_USERNAME', 'knet-elev19010');
define('DB_PASSWORD', 'qtc69');
define('DB_NAME', 'knet-elev19010');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: noe gikk galt. " . mysqli_connect_error());
}
?>