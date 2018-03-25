<?php

require 'config.php';


$instOK=0;

$connect = mysql_connect("localhost:3306" ,$user, $pass) or
die('Could not connect to MySQL database. ' . mysql_error());

echo "Connection to dB server localhost  OK <br>";

$sql = "CREATE DATABASE IF NOT EXISTS " . "trepas" . " CHARACTER SET = 'utf8mb4' COLLATE = 'utf8mb4_unicode_ci'" .";";
$res = mysql_query($sql) or
     die(mysql_error());



mysql_select_db ("trepas");


$sql1= "CREATE TABLE IF NOT EXISTS " . "iscrizioni (
  idcorridore    INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  pettorale      INTEGER UNSIGNED NOT NULL,
  cognome        VARCHAR(45) NOT NULL,
  nome           VARCHAR(45) NOT NULL,
  sesso			 VARCHAR(1) NOT NULL,
  nascita        date NOT NULL,
  certMed		 INTEGER UNSIGNED NOT NULL,
  km			 INTEGER UNSIGNED NOT NULL,
  gruppo		 VARCHAR(64),
  donatore		 VARCHAR(2),
  sezione		 VARCHAR(64),
  tempo			 TIME,
  arrivo         INTEGER UNSIGNED,
  PRIMARY KEY(pettorale),
  KEY (idcorridore)
)
";

$res = mysql_query($sql1) or
     die(mysql_error());



$sql1= "CREATE TABLE IF NOT EXISTS " . "tempoTab (
  num_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  num_pettorale  INTEGER UNSIGNED NOT NULL,
  tempo			 INTEGER UNSIGNED,
  PRIMARY KEY(num_id,num_pettorale)
)
";

$res = mysql_query($sql1) or
     die(mysql_error());

echo "<br> <br>";
echo "Installazione completata con successo <br>";
$instOK=1;

?>


<html>
<head>
<title>Documento senza titolo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>

<div>
Torna alla Schermata
<a href="index.htm" title="index" target="_self"> principale</a>

</div>

</body>
</html>
