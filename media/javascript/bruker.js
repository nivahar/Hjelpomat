var xmlhttp

function showPassword(str)
{
if (str.length==0)
  {
  document.getElementById("brukerInfo").innerHTML="";
  return;
  }
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Din nettleser støtter ikke XMLHTTP!");
  return;
  }
var url="/media/javascript/brukersjekk.php";
url=url+"?q="+str;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function stateChanged()
{
if (xmlhttp.readyState==4)
  {
  document.getElementById("passField").innerHTML=xmlhttp.responseText;
  }
}

function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}