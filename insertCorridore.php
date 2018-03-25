<?php

require 'config.php';
header('Content-Type: text/html; charset=utf-8');


$nome=$_GET["nome"];
$cognome=$_GET["cognome"];
$nascita=$_GET["nascita"];
$sesso=$_GET["sesso"];
$pettorale=$_GET["pettorale"];
$certMed=$_GET["certMed"];
$abvs=$_GET["abvs"];
$sezione=$_GET["sezione"];
$gruppo=$_GET["gruppo"];
$km=$_GET["km"];


//echo "certMed=$certMed";

 $connect = mysql_connect("localhost:3306" ,$user, $pass) or
  die('Could not connect to MySQL database. ' . mysql_error());

  mysql_select_db ("trepas");


if($pettorale!="")
{

  $sql="INSERT INTO iscrizioni
       (nome,cognome,nascita,sesso,pettorale,certMed,donatore,sezione,gruppo,km)
       VALUES('".mysql_real_escape_string($nome).
        "','".mysql_real_escape_string($cognome)."',STR_TO_DATE('".
  mysql_real_escape_string($nascita)."','%d/%m/%Y'),'".
  mysql_real_escape_string($sesso)."','".
  mysql_real_escape_string($pettorale)."','".
  mysql_real_escape_string($certMed)."','".
  mysql_real_escape_string($abvs)."','".
  mysql_real_escape_string($sezione)."','".
  mysql_real_escape_string($gruppo)."','".
  mysql_real_escape_string($km)."')";

  $result = mysql_query($sql);
  //echo mysql_error();
  //echo "result=".$result;


  if($result!=1)
  {
	echo "<input type=hidden name='errore' id='errore' value='ERRORE: PETTORALE DOPPIO'><br>";
  }
  else
  {
    echo "<input type=hidden name='errore' id='errore' value='0'><br>";
  }
}


$sql="SELECT * FROM iscrizioni WHERE km=$km ORDER BY idcorridore DESC";
$sql_kmTotal="SELECT COUNT(idcorridore) as totalkm FROM iscrizioni WHERE km=$km";
$sql_total="SELECT COUNT(idcorridore)as total FROM iscrizioni";

$result = mysql_query($sql);
$result_kmTotal = mysql_query($sql_kmTotal);
$row_kmTotal = mysql_fetch_array($result_kmTotal);
$result_total = mysql_query($sql_total);
$row_total = mysql_fetch_array($result_total);
header('Content-Type: text/html; charset=utf-8');
echo "<table border='1'>
<tr>
	<th colspan='3'>Iscritti tot $km Km: $row_kmTotal[0]</th>
	<th colspan='2'>Iscritti tot: $row_total[0]</th>
</tr>
<tr>
<th>id</th>
<th>pettorale</th>
<th>cognome</th>
<th>nome</th>
<th>nascita</th>
</tr>";

while($row = mysql_fetch_array($result))
{
  	echo "<tr>";
  	echo "<td>" . $row['idcorridore'] . "</td>";
  	echo "<td>" . $row['pettorale'] . "</td>";
  	echo "<td>" . $row['cognome'] . "</td>";
  	echo "<td>" . $row['nome'] . "</td>";

  	$sql2="select DATE_FORMAT('".$row['nascita']."','%d/%m/%Y') as 'dataNascita'";
  	$result2 = mysql_query($sql2);
  	echo mysql_error();

  	while($row2 = mysql_fetch_array($result2))
  	{
  		echo "<td>" . $row2['dataNascita'] . "</td>";
  	}
  	echo "</tr>";
}
echo "</table><br>";

mysql_close($connect);


?>