/**
 *
 */
var ore = 0;
var minuti = 0;
var secondi = 0;
var decimi = 0;
var visualizzazione = "";
var contatore_intertempi = 0;
var stop = 1; //0=attivo 1=fermo

var ore2 = 0;
var minuti2 = 0;
var secondi2 = 0;
var decimi2 = 0;
var visualizzazione2 = "";
var contatore_intertempi2 = 0;
var stop2 = 1; //0=attivo 1=fermo




function insertTempo(text,pettorale,tempo9,tempo4)
{
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("txtHintTimer").innerHTML=xmlhttp.responseText;
			var errore = document.getElementById('errore');
			if(errore.value!="0")
			{
				alert(errore.value);
			}
			else
			{
				text.value="";
			}
		}
	};

	if(isNaN(pettorale))
	{
		alert("Inserisci un pettorale valido");
		return;
	}
	if(text.value=="")
	{
		alert("Inserisci un pettorale valido");
		return;
	}

	var str="?";
	str = str + "pettorale";
	str = str + "=" + pettorale + "&";

	str = str + "tempo9";
	str = str + "=" + tempo9+ "&";

	str = str + "tempo4";
	str = str + "=" + tempo4;

	xmlhttp.open("GET","inseriscitempo.php" + str, true);
	xmlhttp.send();
}


function avvia() {
	if (stop == 1) {
		stop = 0;
		var startDate = Date.now();
		cronometro(startDate,1);
	}
}

function cronometro(startDate,cronNum) {

	if(cronNum==1)
	{
		stopTmp=stop;
	}
	if(cronNum==2)
	{
		stopTmp=stop2;
	}

	if (stopTmp == 0) {
		var currentdate = Date.now();
		var differenza = currentdate-startDate;
		var secTot = differenza/1000;
		var hour=parseInt(secTot/3600, 10);
		if(hour < 10)
		{
			hour="0"+hour;
		}
		var secLeft=secTot-(hour*3600);
		var minute=parseInt(secLeft/60,10);
		if(minute < 10)
		{
			minute="0"+minute;
		}
		secLeft=secLeft-(minute*60);
		var second=parseInt(secLeft,10);
		if(second < 10)
		{
			second="0"+second;
		}


		if(cronNum==1)
		{
			visualizzazione = hour+":"+minute+":"+second;
			obj=document.getElementById("mostra_cronometro").value = visualizzazione;
		}
		else
		{
			visualizzazione2 = hour+":"+minute+":"+second;
			obj=document.getElementById("mostra_cronometro2").value = visualizzazione2;
		}
		setTimeout(function(){ cronometro(startDate,cronNum); }, 1000);
	}
}

function intertempo()
{
	if (stop == 0)
	{
		input= document.getElementById("ins_pettorale");
		insertTempo(input,input.value,visualizzazione,visualizzazione2);
		input.value="";
		document.getElementById(input.id).focus();
	}
}

function ferma() {
	stop = 1;
}

function azzera() {
	if (stop == 1) {
		ore = 0;
		minuti = 0;
		secondi = 0;
		decimi = 0;

		document.getElementById("mostra_cronometro").value = "00:00:00:0";
	}
}

function avvia2() {
	if (stop2 == 1) {
		stop2 = 0;
		var startDate = Date.now();
		cronometro(startDate,2);
	}
}


function intertempo2() {
	if (stop2 == 0) {
		contatore_intertempi2 += 1;
		document.getElementById("intertempi2").appendChild(
				document.createTextNode(contatore_intertempi2 + ". "
						+ visualizzazione2));
		document.getElementById("intertempi2").appendChild(
				document.createElement("br"));
	}
}

function ferma2() {
	stop2 = 1;
}

function azzera2() {
	if (stop2 == 1) {
		ore2 = 0;
		minuti2 = 0;
		secondi2 = 0;
		decimi2 = 0;
		document.getElementById("mostra_cronometro2").value = "00:00:00:0";
	}
}

function avvia3() {

	var startDate = new Date();
	if (stop == 1) {
		stop = 0;
		cronometro(startDate,1);
	}

	if (stop2 == 1) {
		stop2 = 0;
		cronometro(startDate,2);
	}
}
