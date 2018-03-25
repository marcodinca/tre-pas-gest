<?php

require 'config.php';
header('Content-Type: text/html; charset=utf-8');


$km=$_GET["km"];




 $connect = mysql_connect("localhost:3306" ,$user, $pass) or
  die('Could not connect to MySQL database. ' . mysql_error());


 if(!$connect)
 {
 	echo "<input type=hidden name='errore' id='errore' value='ERRORE: DB'><br>" . $connect;
 	return;
 }
 else
 {
 	echo "<input type=hidden name='errore' id='errore' value='0'><br>";
 }


  mysql_select_db ("trepas");



$sql="SELECT * FROM iscrizioni WHERE km=$km ORDER BY idcorridore DESC";
$sql_kmTotal="SELECT COUNT(idcorridore) as totalkm FROM iscrizioni WHERE km=$km";
$sql_total="SELECT COUNT(idcorridore)as total FROM iscrizioni";

$result = mysql_query($sql);
$result_kmTotal = mysql_query($sql_kmTotal);
$row_kmTotal = mysql_fetch_array($result_kmTotal);
$result_total = mysql_query($sql_total);
$row_total = mysql_fetch_array($result_total);
header('Content-Type: text/html; charset=utf-8');
echo "<table border=''>
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