
<?php
//
// Maria del Mar PÈrez Fajardo
// Agosto 2009
//

require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');

	$xOficina = $_GET["xOficina"];


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gestor Habitual</title>
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
// 
//

function GetFila(xID)
{	
	var Oficina=document.getElementById('Oficina').value;
	
	//alert(Oficina);
	
	if(Oficina){
		var oCelda=document.getElementById(xID).cells[0];
	
		var Oficina=document.getElementById('Oficina').value;
	
		var url_parametros="xOficina="+Oficina+"&xGestor="+oCelda.innerHTML;
	
		//alert(url_parametros);
		if('<?php echo $_GET['xGestor'];?>'=='H')
			location="Redmoon_php/ORAModGestorHabitual.php?"+url_parametros;
		else
			location="Redmoon_php/ORAAddGestoriaOficinas.php?"+url_parametros;
		
	//PutDataAsuntos('Redmoon_php/ORAModNotarioHabitual.php', url_parametros);
	}
}
//
//Ir al formulario consulta del expediente
//
function VerExpe(xFila){
	
	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var url_parametros="xIDNotario="+oCelda.innerHTML;
	
	location="Notarios.php?"+url_parametros;
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
	//location="correoPHP/CorreoColaboraPedirFechaPoliza.php";
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

	if (Opcion=='NOMBRE')
	{
		url_parametros+='&xNOMBRE='+document.getElementById('NOMBRE').value;
		//alert(url_parametros);
	}
	//alert(url_parametros);
	PutDataAsuntos('Redmoon_php/serializado_Gestores.php', url_parametros);
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
	for(x=0; x<=ArrayColumnas.length-2; x+=5)
	    {
		j++;
				row = tbl.insertRow(tbl.rows.length);
				row.setAttribute('id', 'ofila'+j);
				row.setAttribute('onclick', 'GetFila(this.id);');
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
  			cellText.innerHTML=ArrayColumnas[2+x];
  			
  			cellText =  row.insertCell(3);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.innerHTML=ArrayColumnas[3+x];

  			cellText =  row.insertCell(4);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
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
// pulsaciÛn de las teclas, cuando se pulsa return se graba el valor
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
	xPag+=14;
	LeeConsulta('Todo');
}

function GotoBack()
{
	xPag-=9;
	if (xPag <=1 )
		xPag=1;
	
	LeeConsulta('Todo');
}


</script>


<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />

<style type="text/css">
#imagen_logo{
position: absolute;
top:25px;
left:790px;
}

#pagina_adelante{
position: absolute;
top:130px;
left:30px;
cursor:pointer;


}

#pagina_boton{
position: absolute;
top:700px;
left:30px;
cursor:pointer;

}

.Estilo1 {
	color: #3c4963;
	font-weight: bold;
}
.Estilo2 {

	color: #36679f;
	margin: 4px 15px;
	cursor: pointer;
	font-weight: bold;
}
 #busqueda{
 position:absolute;
 top:10px;
 left:480px;
 }
.Estilo5 {color: #36679f; font-weight: bold; }
</style>
</head>

<body  onload="HacerBusqueda();">
<?php require('cabecera.php'); ?>

<div id="documento">
<div id="btnPagina">
<div id="btnNavegaAtras" onclick="GotoBack()" title="Atr·s"><span>Atr·s</span></div>
<div id="btnNavegaSig" onclick="GotoNext()" title="Atr·s"><span>Siguiente</span></div>
</div>

<div id="busqueda">
    <form name="form1" method="post" action="">
	<span class="Estilo5">Nombre</span>
    <input style="text-transform:uppercase;" name="NOMBRE" type="text" id="NOMBRE" onkeypress="detectar_tecla(event,'NOMBRE')" size="25" maxlength="25" />
    <img src="Redmoon_img/buscar48x48.png" align="bottom" alt="buscar" align="bottom" longdesc="buscar datos"  onclick="LeeConsulta('TODO')" />
    </form>
</div>
<br/>
<br/>
<h4 align="center" class="Estilo1">Selecci&oacute;n de Gestor Habitual</h4>
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
<table width="750" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
    <td width="7%"><strong>ID</strong></td>
    <td width="5%"><strong>NIF</strong></td>
    <td width="31%"><strong>Nombre</strong></td>
    <td width="30%"><strong>Direcci√≥n</strong></td>
    <td width="27%"><strong>Poblaci√≥n</strong></td>
  </tr>
</table>
<input  type="hidden" name="Oficina" id="Oficina" value="<?php echo  $_GET["xOficina"];?>"/>
<input type="hidden" name="xPag" id="xPag" value="1" />
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
</body>
</html>
