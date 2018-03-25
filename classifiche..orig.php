<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<?xml version="1.0" encoding="UTF-8" ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta content="text/html; charset=ISO-8859-1" http-equiv="Content-Type" />
	<title>TrePas Classifiche main page</title>
</head>
<body>

<?php
require 'config.php';
//header('Content-Type: text/html; charset=UTF-8');


$classifica=0;
$km=9;
$sesso="M";
$subCat=0;
$catLow=4;
$catUp=7;
$position=1;

$classifica=$_GET['classifica'];
$km=$_GET['km'];
$sesso=$_GET['sesso'];
$catLow=$_GET['catlow'];
$catUp=$_GET['catup'];
$certMed=$_GET['certMed'];

//echo "catLow=$catLow";
//echo "catUp=$catUp";



function qryGet($classifica,$catLow,$catUp,$km,$sesso,$certMed)
{
	$selFiled=" cognome,nome,pettorale,DATE_FORMAT(nascita,'%d/%m/%Y')as nascita,gruppo,donatore,sezione,tempo,km";
	switch ($classifica)
	{
		case 0:
		{
			$qry=
			"SELECT $selFiled FROM iscrizioni
			WHERE
			km=$km and sesso='$sesso' and tempo is not null ORDER BY tempo ASC ";
		}
		break;
		case 1:
		{
			$qry = "SELECT $selFiled FROM iscrizioni
					WHERE
					(
						(km=$km AND sesso='$sesso') AND
						(nascita >= (MAKEDATE(year(now()),1) - INTERVAL $catUp YEAR)) AND
						(nascita <  (MAKEDATE(year(now()),1) - INTERVAL $catLow - 1 YEAR))
					) AND tempo is not null AND certMed = $certMed
					ORDER BY tempo ASC";
		}
		break;

		case 2:
		{
			$qry =
			"SELECT $selFiled FROM iscrizioni ORDER BY iscrizioni.nascita DESC LIMIT 10";
		}
		break;

		case 3:
		{
			$qry =
			"SELECT $selFiled FROM iscrizioni
			WHERE
			sesso='$sesso' ORDER BY iscrizioni.nascita ASC LIMIT 1";
		}
		break;

		case 4:
		{
			$qry =
			"SELECT * FROM (
					SELECT UPPER(gruppo) as nome_gruppo, count(*) n FROM iscrizioni
					WHERE
					gruppo !='' GROUP BY UPPER(gruppo) ) as tab ORDER BY n desc";
		}
		break;

		case 5:
		{
			$qry =
			"SELECT $selFiled FROM iscrizioni
			WHERE
			sesso='$sesso' AND
			donatore='SI' AND km=9 and
			tempo is not null
			ORDER BY tempo ASC";
		}
		break;

		default:
			$qry="";
		break;
	};

	return $qry;
}


function titleGet($classifica,$catLow,$catUp,$km,$sesso,$certMed)
{
	if ($sesso=='M') {
		$sesso='maschile';
	}
	else //($sesso=='F')
	{
		$sesso='femminile';
	}

	if ($certMed==1) {
		$certMed='certificato medico';
	}
	else //($sesso=='F')
	{
		$certMed='ludica';
	}
	switch ($classifica)
	{
		case 0:
			{
				$title=
				"Clssifica Km $km $sesso $certMed";
			}
			break;
		case 1:
			{
				$title=
				"Clssifica Km $km $sesso categoria $catLow-$catUp anni $certMed";
			}
			break;

		case 2:
			{
				$title=
				"Classifica Iscritto pi&ugrave; giovane";
			}
			break;

		case 3:
			{
				$title=
				"Classifica $sesso Iscritto pi&ugrave; anziano";
			}
			break;

		case 4:
			{
				$title=
				"Classifica gruppo pi&ugrave; numeroso";
			}
			break;

		case 5:
			{
				$title=
				"Classifica $sesso donatori";
			}
			break;

		default:
			$title=
				"Classifica sconosciuta";
			break;
	};
	return $title;
}





$connect = mysql_connect("localhost:3306" ,$user, $pass) or
die('Could not connect to MySQL database. ' . mysql_error());

mysql_select_db ("trepas");

$clTitle=titleGet($classifica, $catLow, $catUp, $km, $sesso, $certMed);
$clQry=qryGet($classifica, $catLow, $catUp, $km, $sesso, $certMed);

if($clQry=="")
{
	echo "Inserire una categoria corretta";
	exit;
}

$result = mysql_query($clQry);
if(!$result)
{
	echo "<h1> $clTitle</h1>";
	echo "<br>";
	echo "Nessun risultato";
	exit;
}

$num_fields = mysql_num_fields($result);

$header="<tr><th>Pos</th>";
for ($i = 0; $i < $num_fields; $i++) {
	$name = mysql_field_name($result, $i);
	$header.="<th>$name</th>";
}
$header.="</tr>";


echo "<h1> $clTitle</h1>";
echo "<br>";
echo "<table>";
echo $header;

while($row = mysql_fetch_array($result))
{
  	echo "<tr>";
  	$data="<td>$position</td>";
	for ($i = 0; $i < $num_fields; $i++)
	{
		$name = mysql_field_name($result, $i);
		$data.="<td>$row[$name]</td>";
	}
	echo $data;
  //echo "$position) ".$row['cognome']." ".$row['nome']." ".$row['pettorale']." ".$row['tempo'];
  echo "</tr>";
  $position++;
}
echo "</table>";
?>

</body>
</html>
