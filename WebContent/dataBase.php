<?php
$q=$_GET["q"];

require 'config.php';


$instOK=0;

$connect = mysql_connect("localhost:3306" ,$user, $pass) or 
die('Could not connect to MySQL database. ' . mysql_error());

echo "Connection to dB server localhost  OK <br>";

mysql_select_db ("trepas");

$sql="SELECT * FROM iscrizioni WHERE num_id = '".$q."'";

$result = mysql_query($sql);

echo "<table border='1'>
<tr>
<th>Cognome</th>
<th>Nome</th>
<th>Età</th>
<th>Num Pettorale</th>
<th>Gruppo</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['cognome'] . "</td>";
  echo "<td>" . $row['nome'] . "</td>";
  echo "<td>" . $row['dataNascita'] . "</td>";
  echo "<td>" . $row['num_pettorale'] . "</td>";
  echo "<td>" . $row['gruppo'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysql_close($connect);
?> 