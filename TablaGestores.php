<?php require('Redmoon_php/controlSesiones.inc.php');  ?>
<?php

require('Redmoon_php/pebi_cn.inc');
require('Redmoon_php/pebi_db.inc'); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gestores</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>
<?php require('editorTINY.php');  ?>

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
	var url_parametros="xIDColaborador="+oCelda.innerHTML;
	
	location="Colaboradores.php?"+url_parametros;
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
function sendMail(xFila){
	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[5];
	var mEmail=oCelda.innerHTML;
	var xDestino=document.getElementById('IDestinatario');
	
	// poner el NIF de la tupla seleccionada para su envio en form
	document.getElementById('xMail').value=mEmail;
	
	xDestino.innerHTML="Redactar correo para: "+mEmail;
	// nFila es una variable global
	nFila=xFila;
	
	document.getElementById('enviarMensaje').style.visibility='visible';
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
	for(x=0; x<=ArrayColumnas.length-2; x+=6)
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
  			
  			cellText =  row.insertCell(2);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.innerHTML=ArrayColumnas[2+x];
  			
  			cellText =  row.insertCell(3);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.setAttribute('align', 'center');
  			cellText.innerHTML=ArrayColumnas[3+x];

  			cellText =  row.insertCell(4);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.setAttribute('align', 'center');
  			cellText.innerHTML=ArrayColumnas[4+x];

  			cellText =  row.insertCell(5);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.setAttribute('align', 'center');
  			cellText.innerHTML=ArrayColumnas[5+x];
  			
  			// DAR EL VISTO BUENO
  			cellText =  row.insertCell(6);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/telefono.png"  onclick="ExpedienteRevisado('+j+')"  id="oFase'+j+'">';

  			// VER EXPEDIENTE Y PODER CORREJIR LOS IMPORTES PRESUPUESTADOS POR EL CALCULO AUTOM�TICO
  			cellText =  row.insertCell(7);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/ver.png" onclick="VerExpe('+j+')"  id="oFase'+j+'">';

  			// ENVIAR CORREO
  			cellText =  row.insertCell(8);
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
	xPag+=14;
	LeeConsulta('Todo');
}

function GotoBack()
{
	xPag-=14;
	if (xPag <=1 )
		xPag=1;
	
	LeeConsulta('Todo');
}

function AniadirColaborador(){
	location="AniadirColaborador.php";
}

///Menus de ayuda para los botones de las tabla
//
//ayuda para llamar al colaborador
function AyudaTlf(){

	AreaDiv = document.getElementById("AyudaTlf");
	AreaDiv.style.visibility='visible';
}
function SalirAyudaTlf(){
	AreaDiv = document.getElementById("AyudaTlf");
	AreaDiv.style.visibility='hidden';
}

function AyudaVer(){

	AreaDiv = document.getElementById("ayudaVer");
	AreaDiv.style.visibility='visible';
}
function SalirAyudaVer(){
	AreaDiv = document.getElementById("ayudaVer");
	AreaDiv.style.visibility='hidden';
}
function AyudaMail(){

	AreaDiv = document.getElementById("ayudaMail");
	AreaDiv.style.visibility='visible';
}
function SalirAyudaMail(){
	AreaDiv = document.getElementById("ayudaMail");
	AreaDiv.style.visibility='hidden';
}
</script>


<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />

<style type="text/css">
#ayudaVer{
position:absolute;
	top:1px;
	left:418px;
	visibility:hidden;
	z-index:1;
}
#AyudaTlf{

	position:absolute;
	top:1px;
	left:367px;
	visibility:hidden;
	z-index:1;
}
#ayudaMail{
position:absolute;
	top:1px;
	left:468px;
	visibility:hidden;
	z-index:1;
}
#TextoAyuda{
	position:absolute;
	top:35px;
	left:20px;
	margin-right:20px;

}

#AniadirColabora{
position: absolute;
top:20px;
left:600px;
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
.Estilo5 {color: #36679f; font-weight: bold; }

#buscar{
position: absolute;
top:40px;
left:10px;
}
</style>
</head>

<body  onload="HacerBusqueda();">
<?php require('cabecera.php'); ?>

<div id="documento">
  <div id="rastro"><a href="MenuAdmin.php">Inicio</a> >
            Lista de Gestores
</div>

<div id="AniadirColabora">
<img src="redmoon_img/imgDoc/AadirColaborador.png" align="middle" onclick="AniadirColaborador()"/>
</div>

<div id="btnPagina">
<div id="btnNavegaAtras" onclick="GotoBack()" title="Atr�s"><span>Atr�s</span></div>
<div id="btnNavegaSig" onclick="GotoNext()" title="Atr�s"><span>Siguiente</span></div>
</div>


<div id="buscar">
    <form name="form1" method="post" action="">
	<span class="Estilo5">Nombre</span>
    <input style="text-transform:uppercase;" name="POBLACION" type="text" id="POBLACION" onkeypress="detectar_tecla(event,'POBLACION')" size="25" maxlength="25" />
    <img src="Redmoon_img/imgDoc/buscar.png" align="right" alt="buscar" align="bottom" longdesc="buscar datos"  onclick="LeeConsulta('POBLACION');" />
    </form>
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
<table width="750" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
    <td width="10%"><strong>ID</strong></td>
    <td width="10%"><strong>NIF</strong></td>
    <td width="50%"><strong>Nombre</strong></td>
    <td width="10%" align="center" ><strong>Direcc&oacute;n</strong></td>
    <td width="10%" align="center" ><strong>Poblaci&oacute;n</strong></td>
     <td width="10%" align="center" ><strong>Email</strong></td>
   
  </tr>
</table>
<input type="hidden" name="xIDExpe" id="inIDExpe" />
<input type="hidden" name="xPag" id="xPag" value="1" />
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<div id="enviarMensaje">

<img src="<?php echo IMAGENES;?>/borrar1.png" alt="Salir" align="middle"  onclick="SalirMensaje();"  />
<label id="IDestinatario">Redactar correo</label> 
<form method="post" action="correoPHP/email_Oficinas.php">
<label class="Estilo5">Asunto<input type="text" size="45" name="IDAsunto" id="IDAsunto" /></label>
<br />
<textarea name="content" style="width:100%" rows="20" id="content">
</textarea>
<input type="hidden" name="xMail" id="xMail" />
<!-- 
<button type="submit">Enviar</button>
<img src="<?php echo IMAGENES;?>/aceptar2.png" alt="Enviar"  style="position:absolute; left:45%; top:400px;"  onclick="FEnviarMensaje();"  />
-->
</form>

</div>
</div>
</body>
</html>