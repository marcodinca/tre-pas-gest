var dtCh= "/";

var minYear=1900;

var d = new Date();
var maxYear = d.getFullYear();

function isInteger(s){
	var i;
    for (i = 0; i < s.length; i++)
    {
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9")))
        {
        	return false;
        }
    }
    // All characters are numbers.
    return true;
}

function stripCharsInBag(s, bag){
	var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++){
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function daysInFebruary (year){
	// February has 29 days in any year evenly divisible by four,
    // EXCEPT for centurial years which are not also divisible by 400.
    return (((year % 4 == 0) && ( (!(year % 100 == 0)) ||
    		(year % 400 == 0))) ? 29 : 28 );
}
function DaysArray(n)
{
	for (var i = 1; i <= n; i++)
	{
		this[i] = 31;
		if (i==4 || i==6 || i==9 || i==11)
			{
				this[i] = 30;
			}
		if (i==2)
		{
			this[i] = 29;
		}
   }
   return this;
}

function isDate(dtStr)
{
	var daysInMonth = DaysArray(12);
	var pos1=dtStr.indexOf(dtCh);
	var pos2=dtStr.indexOf(dtCh,pos1+1);
	var strDay=dtStr.substring(0,pos1);
	var strMonth=dtStr.substring(pos1+1,pos2);
	var strYear=dtStr.substring(pos2+1);
	strYr=strYear;
	if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1);
	if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1);
	for (var i = 1; i <= 3; i++)
	{
		if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1);
	}
	month=parseInt(strMonth);
	day=parseInt(strDay);
	year=parseInt(strYr);
	if (pos1==-1 || pos2==-1)
	{
		alert("Il fomato data corretto è : dd/mm/yyyy");
		return false;
	}
	if (strMonth.length<1 || month<1 || month>12)
	{
		alert("Inserire un mese valido");
		return false;
	}
	if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month])
    {
		alert("Inserire un giorno valido");
		return false;
	}
	if (strYear.length != 4 || year==0 || year<minYear || year>maxYear)
	{
		alert("Inserire l'anno a 4 cifre compreso tra "+minYear+" e "+maxYear);
		return false;
	}
	if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false)
	{
		alert("Inserire una data validia");
		return false;
	}
return true;
}


function ValidateDate(txtDate)
{
	if (isDate(txtDate)==false)
	{
		return false;
	}
    return true;
 }




function insertUser(form,runType)
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
			document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			errore = document.getElementById('errore');
			if(errore.value!="0")
			{
				alert(errore.value);
			}
			else
			{
				form.nome.value="";
				form.cognome.value="";
				form.nascita.value="";
				form.sesso[0].checked="checked";
				form.pettorale.value="";
				form.certMed[0].checked="checked"
				form.abvs[0].checked="checked";
				form.sezione.value="";
				form.gruppo.value="";
			}
		}
	};


	if(isNaN(form.pettorale.value))
	{
		alert("Inserisci un pettorale valido");
		return;
	}
	if(form.pettorale.value=="")
	{
		alert("Inserisci un pettorale valido");
		return;
	}
	if(form.nome.value=="")
	{
		return;
	}
	if(form.cognome.value=="")
	{
		return;
	}
	if(form.nascita.value=="")
	{
		return;
	}

	if(isDate(form.nascita.value)==false)
	{
		return;
	}

	if(form.sesso[0].checked==true)
	{
		sesso="M";
	}
	else
	{
		sesso="F";
	}

	if(form.certMed[0].checked==true)
	{
		certMed=0;
	}
	else
	{
		certMed=1;
	}

	if(form.abvs[0].checked==true)
	{
		abvs="NO";
		form.sezione.value="";
	}
	else
	{
		abvs="SI";
	}

	var str="?";
	str = str + form.nome.name;
	str = str + "=" + form.nome.value;
	str = str + "&" + form.cognome.name + "=" + form.cognome.value;
	str = str + "&" + form.nascita.name + "=" + form.nascita.value;
	str = str + "&" + form.sesso[0].name + "=" + sesso;
	str = str + "&" + form.pettorale.name + "=" + form.pettorale.value;
	str = str + "&" + form.certMed[0].name + "=" + certMed;
	str = str + "&" + form.abvs[0].name + "=" + abvs;
	str = str + "&" + form.sezione.name + "=" + form.sezione.value;
	str = str + "&" + form.gruppo.name + "=" + form.gruppo.value;
	str = str + "&km=" + runType;

	xmlhttp.open("GET","insertCorridore.php"+str,true);
	xmlhttp.send();
}









function loadUser(runType)
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
			document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			errore = document.getElementById('errore');
			if(errore.value!="0")
			{
				alert(errore.value);
			}
			else
			{
			}
		}
	};




	var str="?";
	str = str + "&km=" + runType;

	xmlhttp.open("GET","loadCorridore.php"+str,true);
	xmlhttp.send();
}






function dateSeparator(form,event)
{
	var key = event.keyCode || event.which;
    //alert ("The Unicode character code is: " + key);

if(key==8)
	return

		if(form.nascita.value.length==2)
			form.nascita.value+="/";

		else if(form.nascita.value.length==5)
			form.nascita.value+="/";

}

function checkSesso(form)
{
	var nome=form.nome.value.toLowerCase();
	var len=form.nome.value.length;
	var lastChar = nome.charAt(len-1);


	if(lastChar == 'y' &&
	  (nome!="rudy") )
	{
		form.sesso[1].checked=true;
	}
	else if(lastChar == 'a' &&
	       (nome!="luca") && (nome!="andrea") && (nome!="mattia") &&
	       (nome!="nicola") && (nome!="elia") && (nome!="barnaba") &&
	       (nome!="isaia") && (nome!="geremia") && (nome!="gianluca") &&
	       (nome!="tobia") && (nome!="zaccaria") )
	{
		form.sesso[1].checked=true;
	}
	else if( (lastChar == 'e') && (
		   (nome=="irene") || (nome=="alice") || (nome=="beatrice") ||
		   (nome=="adele") || (nome=="agnese") || (nome=="adele") ||
		   (nome=="Rachele") || (nome=="matilde") || (nome=="ezzechiele")) )
	{
		form.sesso[1].checked=true;
	}
	else if( (lastChar == 's') && (
			   (nome=="ines") ) )
		{
			form.sesso[1].checked=true;
		}
	else
	{
		form.sesso[0].checked=true;
	}
}