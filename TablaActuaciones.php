<?php require('Redmoon_php/controlSesiones.inc.php');  ?>
<?php

require('Redmoon_php/pebi_cn.inc');
require('Redmoon_php/pebi_db.inc'); 


// Create a database connection
//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();
//, (ENTIDAD||OFICINA||DC||CUENTA) AS NCUENTA
$sql='SELECT descripcion from tipos_asuntos';
$stid = oci_parse($conn, $sql);


$r = oci_execute($stid, OCI_DEFAULT);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Actos del Expediente Hipotecario</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

<script> 

var StringSerializado="";
var xPag=1;

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
	var url_parametros="xIDActo="+oCelda.innerHTML;
	
	location="Actuacion.php?"+url_parametros;
}

//
// Cambiar de fase el expediente
//
function ExpedienteRevisado(xFila){

	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var url_parametros="xIDExpe="+oCelda.innerHTML;
/*
	if (confirm('Confirma Expediente Revisado y Aprobado?'))
	{
	   PutDataAsuntos('Redmoon_php/ORAProvisionFondos_RevisionOK.php', url_parametros);
	   
	}*/
}

//
//
//
function sendMail(){
	//alert('Se ha enviado un email al colaborador');
	location="correoPHP/CorreoColaboraPedirFechaPoliza.php";
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
	
	var url_parametros='xPag='+xPag;

	
	//alert(url_parametros);
	PutDataAsuntos('Redmoon_php/serializado_Actuaciones.php', url_parametros);
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
			//DesctivaInterfazGrabando();		
			
			//alert(pageRequest.responseText);
			if (pageRequest.responseText=='Ok')
				return;
			
			if (pageRequest.responseText=='Error')
			    alert(pageRequest.responseText);
			else
			{
				//alert(pageRequest.responseText);
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
  	j=0;
	for(x=0; x<=ArrayColumnas.length-2; x+=2)
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
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.innerHTML=ArrayColumnas[0+x];
  			
  			cellText =  row.insertCell(1);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.innerHTML=ArrayColumnas[1+x];

  			

  			// VER LOS DATOS Del Acto y poder modificarlos
  			cellText =  row.insertCell(2);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/ver.png" onclick="VerExpe('+j+')" onmouseover="AyudaVer()" onmouseout="SalirAyudaVer()" id="oFase'+j+'">';

 			
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
// pulsaci�n de las teclas, cuando se pulsa return se graba el valor
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

function GotoNext(){
	xPag+=9;
	LeeConsulta('Todo');
}

function GotoBack()
{
	xPag-=9;
	if (xPag <=1 )
		xPag=1;
	
	LeeConsulta('Todo');
}


function AddTipo(){
	location="AniadirActuacion.php";
}
function Salir(){
	document.getElementById('InputTipo').style.visibility='hidden';
	document.getElementById('ModTipo').style.visibility='hidden';
}


</script>

<style type="text/css">

#AniadirTipo{
	position: absolute;
	top:20px;
	left:600px;
}
#InputTipo{
	position:absolute;
	top:140px;
	text-align: center;
	font-weight:900;
	margin:15px 15px;
	border-bottom: solid 2px;
	border-right: solid 2px;
	border-top: solid 1px;
	border-left: solid 1px;
	padding:25px 25px;
	background-color: #FFFFCC;
	width: 30%;
	left:400px;
	visibility:hidden;

}
#ModTipo{
	position:absolute;
	top:140px;
	text-align: center;
	font-weight:900;
	margin:15px 15px;
	border-bottom: solid 2px;
	border-right: solid 2px;
	border-top: solid 1px;
	border-left: solid 1px;
	padding:25px 25px;
	background-color: #FFFFCC;
	width: 30%;
	left:400px;
	visibility:hidden;

}


</style>

</head>

<body onload="HacerBusqueda();">
<?php require('cabecera.php'); ?>
<div id="documento">

 <div id="rastro"><a href="MenuAdmin.php">Inicio</a> >
            Actos del Expediente
</div>
<div id="btnPagina">
<div id="btnNavegaAtras" onclick="GotoBack()" title="Atr�s"><span>Atr�s</span></div>
<div id="btnNavegaSig" onclick="GotoNext()" title="Atr�s"><span>Siguiente</span></div>
</div>



<div id="AniadirTipo" onclick="AddTipo()" >
<img src="redmoon_img/imgDoc/AadirActo.png" align="middle" />
</div>
<div id="VentanaTabla">
<table width="750"  border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
    <td width="10%"><strong>ID</strong></td>
    <td width="90%"><strong>Descripci&oacute;n</strong></td>


   
  </tr>

</table>
</div>
<div id="InputTipo">
<p align="left">
<img src="Redmoon_img/imgDoc/cruz.png" alt="Salir" width="24" height="24" onclick="Salir()" />
Salir
</p>
<p>Introduzca el nuevo tipo de Expediente:</p>
<form  name="form2" id="form2" method="post" action="Redmoon_php/ORAAddTipoExpe.php">
<label>Tipo:
<input id="tipo" name="tipo" type="text" maxlength="40" size="40"  /></label>
 <br />
      <input  name="Grabar" type="submit" id="Grabar" title="Grabar" value="Grabar" />

</form>
</p>
</div>

<div id="ModTipo">
<p align="left">
<img src="Redmoon_img/Delete.png" alt="Salir" width="24" height="24" onclick="Salir()" />
Salir
</p>
<p>Modifique el tipo de Expediente:</p>
<form  name="form3" id="form3" method="post" action="Redmoon_php/ORACambioTipoExpediente.php">
<label>Tipo:
<input id="modtipo" name="modtipo" type="text" maxlength="40" size="40"  /></label>
 <br />
      <input  name="Grabar" type="submit" id="Grabar" title="Grabar" value="Grabar" />
           <input type="hidden" name="xIDtipo" id="xIDtipo"  />
     

</form>
</p>
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
</div>

</body>
</html>

