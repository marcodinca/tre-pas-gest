<?php
require 'config.php';


$pettorale=$_GET["pettorale"];
$tempo9=$_GET["tempo9"];
$tempo4=$_GET["tempo4"];
$position9=1;
$position4=1;
$errore=0;


$connect = mysql_connect("localhost:3306" ,$user, $pass) or
die('Could not connect to MySQL database. ' . mysql_error());

mysql_select_db ("trepas");


if($pettorale!="")
{
	$km=0;
	$sql_get_km="SELECT km FROM iscrizioni WHERE pettorale=".mysql_real_escape_string($pettorale);

	$result = mysql_query($sql_get_km);
	echo mysql_error();

	while($row = mysql_fetch_array($result))
	{
		$km=$row['km'];
	}

	if($km==9)
	{
		$tempo=$tempo9;
	}
	else if($km==4)
	{
		$tempo=$tempo4;
	}
	else
	{
		$tempo=0;
		//exit;
	}

	$sql_check="SELECT * FROM iscrizioni WHERE tempo IS NOT NULL AND
			pettorale=".mysql_real_escape_string($pettorale);

	$resultCheck = mysql_query($sql_check);
	$rowNum=mysql_num_rows($resultCheck);
	if($rowNum >= 1)
	{
		echo "<input type=hidden name='errore' id='errore' value='ERRORE:
				PETTORALE DOPPIO ".mysql_real_escape_string($pettorale)."'><br>";
		$errore = 1;
	}

	if($errore==0)
	{
		$sql="UPDATE iscrizioni SET tempo='".mysql_real_escape_string($tempo)."' ".
		"WHERE pettorale=".mysql_real_escape_string($pettorale);

		$result = mysql_query($sql);
		$numAffRow = mysql_affected_rows();
		if($numAffRow == 0)
		{
			echo "<input type=hidden name='errore' id='errore' value='ERRORE:
					PETTORALE NON ESISTENTE ".mysql_real_escape_string($pettorale)."'><br>";
		}
		else
		{
			echo "<input type=hidden name='errore' id='errore' value='0'><br>";
		}
	}

	$sql="SELECT count(nome) as nIscritti9 from iscrizioni where km=9;";
	$result2=mysql_query($sql);
	while ( $row = mysql_fetch_array ( $result2 ) )
	{
		$nIscritti9=$row['nIscritti9'];
	}
	$sql="SELECT count(nome) as nIscritti4 from iscrizioni where km=4;";
	$result2=mysql_query($sql);
	while ( $row = mysql_fetch_array ( $result2 ) )
	{
		$nIscritti4=$row['nIscritti4'];
	}


	$sql="SELECT * from iscrizioni where tempo is not null order by tempo desc;";
	$result2=mysql_query($sql);
	echo mysql_error();
	header('Content-Type: text/html; charset=utf-8');


	$corridori9=array(array());
	$corridori4=array(array());
	$i9=0;
	$i4=0;
	while ( $row = mysql_fetch_array ( $result2 ) )
	{
		if ($row ['km'] == 9)
		{
			$corridori9[$i9]=$row;
			$i9++;
		}
		if ($row ['km'] == 4)
		{
			$corridori4[$i4]=$row;
			$i4++;
		}
	}


	$imax=$i9;
	if ($i4>$i9)
	{
		$imax=$i4;
	}
	echo "<table border='1'>
	<tr>
	<th>Pos. 9km</th>
	<th>9 km: arrivati $i9/$nIscritti9</th>
	<th>Pos. 4km</th>
	<th>4 km: arrivati $i4/$nIscritti4</th>
	</tr>";

	for ($i = 0; $i < $imax; $i++)
	{
		echo "<tr>";
		echo "<td>";
		if ($i9-$i>0)
			echo $i9-$i;
		else
			echo "";
		echo "</td>";
		$riga="";
		if(array_key_exists($i, $corridori9))
		{
			if($i9)
			{
				$row=$corridori9[$i];
				$riga=$row ['pettorale']." ".$row ['nome']." ".$row ['cognome']." ".$row ['tempo'];
			}
		}
		echo "<td>";
		echo $riga;
		echo "</td>";
		echo "<td>";
		if ($i4-$i>0)
			echo $i4-$i;
		else
			echo "";
		echo "</td>";
		$riga="";
		if(array_key_exists($i, $corridori4))
		{
			if($i4)
			{
				$row=$corridori4[$i];
				$riga=$row ['pettorale']." ".$row ['nome']." ".$row ['cognome']." ".$row ['tempo'];
			}
		}
		echo "<td>";
		echo $riga;
		echo "</td>";
		echo "</tr>";
	}
	echo "</table>";
}

?>