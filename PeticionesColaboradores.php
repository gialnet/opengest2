<?php require_once('Redmoon_php/controlSesiones.inc.php');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Peticiones de Servicios Adicionales</title>

<link href="Redmoon_ccs/cargando.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cargando.js" type="text/javascript"></script>
<script src="Redmoon_js/pagina.js" type="text/javascript"></script>

<script> 

var StringSerializado="";

function HacerBusqueda()
{
	LeeConsulta('Todo');
}

//
//
//
function FilaActiva(xID)
{
	var elemento=document.getElementById(xID);
	
		elemento.style.backgroundColor="#33FFFF";
}
//
// Cojer el valor de la fila
///----------------------------------------->>Cambiar según en que fase esté se irá a una pantalla
function GetFila(xID)
{
	var oCelda=document.getElementById(xID).cells[0];
	var url_parametros="?xIDExpe="+oCelda.innerHTML;
	
	var oFASE=document.getElementById(xID).cells[3];
	var vFASE=oFASE.innerHTML;
	//alert(vFASE);
	
	if (vFASE=='INFORME COSTE NOTARIA')//40
	{
		document.location='IntroduccionCosteNotaria.php'+url_parametros; 
	}
	
	if(vFASE=='PAGO NOTARIA'){//42
		document.location='JustificanteNotaria.php'+url_parametros;
	}   

	if(vFASE=='INFORME COSTE IMPUESTOS'){//50
		document.location='IntroduccionCosteImpuesto.php'+url_parametros;
	} 

	if(vFASE=='PAGO IMPUESTOS'){//52
		document.location='JustificanteImpuesto.php'+url_parametros;
	}


	if(vFASE=='PRESENTACION ESCRITURAS'){// 60
		document.location='PresentacionRegistroEscritura.php'+url_parametros;
	}
	
	if(vFASE=='INFORME COSTE REGISTRO'){//61
		document.location='IntroduccionCosteRegistro.php'+url_parametros;
	}

	if(vFASE=='PAGO REGISTRO'){//63
		document.location='JustificanteRegistro.php'+url_parametros;
	}
	//alert(oCelda.innerHTML);
	

}


function LeeConsulta()
{
	
	var url_valor = <?php
	if(isset($_GET["xColabora"])) 
		echo $_GET['xColabora'];
	else 
		echo "''"; 
	?>;
	var url_parametros = "xColabora="+url_valor;

	VerGifEspera();
	//alert(url_parametros);
	// si hay valor de parametro mide mas de diez caracteres
	if (url_parametros.length>10)
		PutDataAsuntos('Redmoon_php/serializado_PeticionesColaborador.php',url_parametros);
	else
		PutDataAsuntos('Redmoon_php/serializado_PeticionesColaborador.php');
}
//
//
//
function FilaDesactivar(xID)
{
	var elemento=document.getElementById(xID);
	
		elemento.style.backgroundColor ="#FFFFFF";
}


//
//Leer datos de Oracle via Ajax y PHP
//
function PutDataAsuntos(url,dataToSend){
	
	var pageRequest = false;
	
	if (window.XMLHttpRequest) {
		pageRequest = new XMLHttpRequest();
	}
	else if (window.ActiveXObject){ 
		try {
			pageRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} 
		catch (e) {
			try{
				pageRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e){}
		}
	}
	else return false;
	
	pageRequest.onreadystatechange=function() {	ProcRespAsuntos(pageRequest);};
	
	if (dataToSend) {		
		pageRequest.open('POST',url,true);
 	pageRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		pageRequest.send(dataToSend);
	}
	else {
		pageRequest.open('GET',url,true);
		pageRequest.send(null);
	}
}


//
//Recibe la respuesta del servidor
//
function ProcRespAsuntos(pageRequest){

	
	if (pageRequest.readyState == 4)	
	{
		if (pageRequest.status==200)
		{
			// despues de grabar dejar las cosas como estaban		
			OcultarGifEspera();		
			
			//alert(pageRequest.responseText);
			if (pageRequest.responseText=='Ok')
				return;
			
			if (pageRequest.responseText=='Error')
			    alert(pageRequest.responseText);
			else
			{
			    StringSerializado=pageRequest.responseText;
			    deleteLastRow('oTabla');
			    AddRowTable();
		    }
		    	
			// Activo el Menu de Titulares
			//ActivaMenuTitulares();

		}
		else if (pageRequest.status == 404) 
			object.innerHTML = 'Disculpas, la informacion no esta disponible en estos momentos.';
		else 
			object.innerHTML = 'Ha ocurrido un problema.';
	}
	else return;
}
//
//
//
function AddRowTable()
{
	var ArrayColumnas=StringSerializado.split('|');
	var tbl = document.getElementById('oTabla');
  	//var row = tbl.insertRow(tbl.rows.length);
  
  	//alert(StringSerializado);
  	//alert(ArrayColumnas.length);
  	j=1;
	for(x=0; x<=ArrayColumnas.length-2; x+=5)
	    {
				row = tbl.insertRow(tbl.rows.length);
				row.setAttribute('id', 'ofila'+j);
				row.setAttribute('onclick', 'GetFila(this.id);');
				row.setAttribute('onMouseOver', 'FilaActiva(this.id);');
				row.setAttribute('onMouseOut', 'FilaDesactivar(this.id);');
				j++;
				
			cellText =  row.insertCell(0);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML=ArrayColumnas[0+x];
  			
  			cellText =  row.insertCell(1);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML=ArrayColumnas[1+x];
  			
  			cellText =  row.insertCell(2);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML=ArrayColumnas[2+x];
  			
  			cellText =  row.insertCell(3);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML=ArrayColumnas[3+x];

  			cellText =  row.insertCell(4);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML=ArrayColumnas[4+x];			
		}

}
//
// tblName
//
function deleteLastRow(tblName)
{
  var tbl = document.getElementById(tblName);
  //if (tbl.rows.length > 1) tbl.deleteRow(tbl.rows.length - 1);
  for(x=(tbl.rows.length-1); x>0; x--)
      tbl.deleteRow(x);
}
//
// pulsación de las teclas
//
function detectar_tecla(e, opcion){

if (window.event)
	tecla=e.keyCode;
else
	tecla=e.which;

if(tecla==13)
{
	if (window.event)
	{
		e.returnValue=false;
		window.event.cancelBubble = true;
	}
	else
	{
		e.preventDefault();
		e.stopPropagation();
	}
		
}

//alert(tecla);
}


</script>


<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />

<style type="text/css">
#imagen_logo{
position: absolute;
top:5px;
left:790px;
}

#VentanaTabla{ position:absolute;
	top:170px;
	left:50px;
	width:842px;
	height:850px;
	overflow:auto;
	cursor:pointer;
}

 
</style>
</head>

<body id="cuerpo" onload="HacerBusqueda();">
<div id="imagen_logo">
<img src="redmoon_img/search.png">
</div>
<div align="center">&copy 2008 Redmoon Consultores</div>
<div id="pagina">

<h3 align="center">Peticiones de Servicios Adicionales</h3>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<div id="VentanaTabla">
<table width="841" border="0" id="oTabla">
  <tr bgcolor="#0066FF" id="oFila0" style="color:#FFFFFF; cursor:default">
    <td width="10%">Expediente</td>
    <td width="10%">NIF</td>
    <td width="50%">Nombre</td>
    <td width="30%">Fase</td>
    <td width="30%">Estado</td>
  </tr>
</table>
</div>

</div>
<?php require('Redmoon_php/cargando.inc'); ?>
</body>
</html>
