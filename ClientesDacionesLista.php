<?php require('Redmoon_php/controlSesiones.inc.php');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Clientes Daciones</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

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
	
		elemento.style.backgroundColor="#ECF3F5";
}

//
//Ir al formulario consulta del expediente
//
function VerExpe(xFila){
	
	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var url_parametros="xIDExpe="+oCelda.innerHTML;
	
	//location="DacionesVerExpedientes.php?"+url_parametros;
	location="DacionesVerExpedientes.php"
}

//
// Aadir un expediente a un cliente preferencial
//
function ExpedienteDacion(xFila){

	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var url_parametros="xNIF="+oCelda.innerHTML;

	if (confirm('Confirma crear un nuevo Expediente?'))
	{
		//alert(url_parametros);
	   PutDataAsuntos('Redmoon_php/AltaExpeDacion.php', url_parametros);
	}
}

//
//
//
function sendMail(){
	alert('Se ha enviado un email al director de la sucursal');
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
// Llamar a la consulta adecuada
//
function LeeConsulta(Opcion)
{
	
	var url_parametros='';

	
	//alert(url_parametros);
	PutDataAsuntos('Redmoon_php/serializado_ClientesPreferentes.php', url_parametros);
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
	
	pageRequest.onreadystatechange=function() {	ProcRespAsuntos(pageRequest, url);};
	
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
function ProcRespAsuntos(pageRequest, url){

	
	if (pageRequest.readyState == 4)	
	{
		if (pageRequest.status==200)
		{
			
			//alert(pageRequest.responseText);
			if (pageRequest.responseText=='Ok')
				return;
			
			if (pageRequest.responseText=='Error')
			    alert(pageRequest.responseText);
			else
			{
				// mostar la lista de clientes preferenciales
				if (url=='Redmoon_php/serializado_ClientesPreferentes.php')
				{
			    	StringSerializado=pageRequest.responseText;
			    	deleteLastRow('oTabla');
			    	AddRowTable();
				}

				// aadir expediente
				if (url=='Redmoon_php/AltaExpeDacion.php')
				{
					//alert(pageRequest.responseText);
					location='ActosExpedienteDacion.php?xIDExpe='+pageRequest.responseText;
				}
			
				
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
  	j=0;
	for(x=0; x<=ArrayColumnas.length-2; x+=4)
	    {
		j++;
				row = tbl.insertRow(tbl.rows.length);
				row.setAttribute('id', 'ofila'+j);
				//row.setAttribute('onclick', 'GetFila(this.id);');
				row.setAttribute('onMouseOver', 'FilaActiva(this.id);');
				row.setAttribute('onMouseOut', 'FilaDesactivar(this.id);');
				
				
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
 			
  			// DAR EL VISTO BUENO
  			cellText =  row.insertCell(4);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/ok.png" onclick="ExpedienteDacion('+j+')" id="oFase'+j+'">';  			

  			// VER EXPEDIENTE Y PODER CORREJIR LOS IMPORTES PRESUPUESTADOS POR EL CALCULO AUTOMTICO
  			cellText =  row.insertCell(5);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/ver.png" onclick="VerExpe('+j+')" id="oFase'+j+'">';

  			// ENVIAR CORREO
  			cellText =  row.insertCell(6);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/mail.png" onclick="sendMail('+j+')" id="oFase'+j+'">';
  						
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
// pulsacin de las teclas, cuando se pulsa return se graba el valor
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
	
	CallOtrasProvisiones();
	LeeConsulta(opcion);
		
}

//alert(tecla);
}

//
//Volver a la vista anterior
//
function GotoHome()
{
	location="MenuPrincipalHipotecas.html";
}

</script>


<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />

<style type="text/css">
#imagen_logo{
position: absolute;
top:25px;
left:790px;
}

#VentanaTabla{ position:absolute;
	top:170px;
	left:20px;
	width:750px;
	height:250px;
	overflow:auto;
	cursor:pointer;
}

 
.Estilo1 {
	color: #3c4963;
	font-weight: bold;
}
</style>
</head>

<body  onload="HacerBusqueda();">
	<?php require('cabecera.php'); ?>

<div id="documento">
<br />
<br/>
<h4 align="center" class="Estilo1">Listado de clientes Daciones</h4>
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
<table width="750" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
    <td width="10%"><strong>NIF</td>
    <td width="40%"><strong>Razon Social</td>
    <td width="40%"><strong>Direccion</td>
    <td width="10%"><strong>Cuenta</td>
  </tr>
</table>
<input type="hidden" name="xIDExpe" id="inIDExpe" />
</div>

</div>
</body>
</html>