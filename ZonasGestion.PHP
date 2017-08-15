<?php require('Redmoon_php/controlSesiones.inc.php');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Zonas de Gesti&oacute;n</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

<script type="text/javascript">

var StringSerializado="";

function chgProvision(xFila,xIDObjeto)
{
	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var oValor;
	var campo;
	document.getElementById("xIDZona").value=oCelda.innerHTML;
	
	//alert(document.getElementById("xIDZona").value);
	if (xIDObjeto.substring(0,5)=='oChgC')
	{
		//alert('pasa');
	oValor=document.getElementById(idFila).cells[2];
	campo='<input name="Coste" type="text" id="Coste" size="10" maxlength="10" onkeypress="detectar_tecla(event, this.id)" />';
	oValor.innerHTML=campo;
	document.getElementById('Coste').focus();
	}

	
	
	
	
}

//
// llamar a quien graba el importe de otras provisiones cuando se pulsa return
//
function CallChgProvision(xIDObjeto)
{

	var xImporte=document.getElementById(xIDObjeto).value;
	var url_parametros="xIDZona="+document.getElementById("xIDZona").value+
	"&xImporte="+xImporte;
	
	//alert(url_parametros);
   	PutDataAsuntos('Redmoon_php/ORACambioCosteZona.php', url_parametros);
  
   
}


//
//
//
function FilaActiva(xID)
{
	var elemento=document.getElementById(xID);
	
		elemento.style.backgroundColor="#ECF3F5";
}
//

function GetFila(xID)
{
	var oCelda=document.getElementById(xID).cells[0];
	
	

}


function LeeConsulta()
{		
		PutDataAsuntos('Redmoon_php/serializado_ZonasGestion.php');
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
	
	pageRequest.onreadystatechange=function() {	ProcRespAsuntos(pageRequest,url);};
	
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
function ProcRespAsuntos(pageRequest,url){
	
	
	if (pageRequest.readyState == 4)	
	{	

		if (pageRequest.status==200)
		{
			// despues de grabar dejar las cosas como estaban		
			//DesctivaInterfazGrabando();		
			
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
			 	if(url=='Redmoon_php/ORACambioCosteZona.php' || url=='Redmoon_php/ORAInputZona.php') 
				  LeeConsulta();
		    }
		    	
		

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
	for(x=0; x<=ArrayColumnas.length-2; x+=3)
	    {
				row = tbl.insertRow(tbl.rows.length);
				row.setAttribute('id', 'ofila'+j);
				//row.setAttribute('onclick', 'GetFila(this.id);');
				row.setAttribute('onMouseOver', 'FilaActiva(this.id);');
				row.setAttribute('onMouseOut', 'FilaDesactivar(this.id);');
				



				
			cellText =  row.insertCell(0);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.innerHTML=ArrayColumnas[0+x];
  			
  			cellText =  row.insertCell(1);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.innerHTML=ArrayColumnas[1+x];
  			
  			cellText =  row.insertCell(2);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.setAttribute('align', 'right');
  			cellText.innerHTML=ArrayColumnas[2+x]+
			'<img src="Redmoon_img/lapiz3.png" onclick="chgProvision('+j+',this.id)" id="oChgCoste'+j+'">';
  			
  			j++;
  						
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
// pulsaci�n de las teclas
//
function detectar_tecla(e, opcion){
	//alert('detectar_tecla');
	if (window.event)
		tecla=e.keyCode;
	else
		tecla=e.which;

	//escape
	if(tecla==27){
		
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
		// refrescar la pantalla
		//LeeConsulta();
		
	}

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

		// Grabar el importe introducido al pulsar return
		CallChgProvision(opcion);
		
			
	}
	
	//alert(tecla);
	}

	function OtraZona(){
		document.getElementById('InputZona').style.visibility='visible';
	}
	function Salir(){
		document.getElementById('InputZona').style.visibility='hidden';
		
	}
	//envia los datos sobre la nueva zona
	function GuardarZona(){
		var Zona=document.getElementById('zona').value;
		var Coste=document.getElementById('coste').value;
		var Nombre=document.getElementById('nombre').value;
		var url_parametros="xZona="+Zona+"&xCoste="+Coste+"&xNombre="+Nombre;
		
		PutDataAsuntos('Redmoon_php/ORAInputZona.php', url_parametros);
	}
</script>

<style type="text/css">

#ImgAdd{
	position:absolute;
	top:80px;
	left:30px;
}
#TextoAniadir{
	position:absolute;
	top:90px;
	left:10px;
}
#InputZona{
	position:absolute;
	top:200px;
	
	left: 180px;
	visibility:hidden;

}
</style>

</head>

<body  onload="LeeConsulta();">
<?php require('cabecera.php'); ?>
<div id="documento">

     <div id="rastro"><a href="MenuAdmin.php">Inicio</a> >
         Zonas de Gesti&oacute;n
</div>

<div id="ImgAdd">
	<img src="Redmoon_img/imgDoc/AadirZona.png" align="middle" onclick="OtraZona()"/>
</div>

<div id="VentanaTabla">
<table width="750" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
    <td width="10%"><strong>Zona</strong></td>
    <td width="50%"><strong>Nombre</strong></td>
    <td width="30%"><strong>Coste del Colaborador</strong></td>
   
  </tr>

</table>

 <input type="hidden" name="xIDZona" id="xIDZona"  />
</div>

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


</div>
<div id="InputZona">
<div id="winPop">
<p align="left">
<img src="Redmoon_img/imgDoc/cancelar.png" alt="Salir"  onclick="Salir()" />
</p>
<p class="Estilo1">Introduzca los datos de la nueva Zona de Gesti&oacute;n:</p>
<label class="Estilo5">Zona
<input id="zona" name="zona" type="text" maxlength="2" size="3"  />
</label>
<label class="Estilo5">Nombre
<input id="nombre" name="nombre" type="text" maxlength="40" size="40"  />
</label>
<label class="Estilo5">Coste
<input id="coste" name="coste" type="text" maxlength="12" size="12"  />
</label>
<p align="right">

<img src="Redmoon_img/imgDoc/aceptar.png" alt="Aceptar"  onclick="GuardarZona()" />
</p>
</div>
</div>
</body>
</html>
