<?php require('Redmoon_php/controlSesiones.inc');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Clientes Preferentes</title>
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
	var url_parametros="xIDColaborador="+oCelda.innerHTML;
	//alert(url_parametros);
	//location="Colaboradores.php?"+url_parametros;
	
}

//
// Cambiar de fase el expediente
//
function ExpedienteRevisado(xFila){

	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var url_parametros="xID="+oCelda.innerHTML;

	   PutDataAsuntos('Redmoon_php/ORAEliminarClientePreferente.php', url_parametros);

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

	if (Opcion=='NOMBRE')
	{
		url_parametros+='&xNOMBRE='+document.getElementById('NOMBRE').value;
		//alert(url_parametros);
	}
	
	//alert(url_parametros);
	PutDataAsuntos('Redmoon_php/serializado_ClientesPreferentes2.php', url_parametros);
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
			if(pageRequest.responseText=='ok_borrar')
				LeeConsulta();
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
  			cellText.setAttribute('align', 'center');
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.innerHTML=ArrayColumnas[3+x];

  			cellText =  row.insertCell(4);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('align', 'center');
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.innerHTML=ArrayColumnas[4+x];


  			
  			// Eliminar un cliente preferente
  			cellText =  row.insertCell(5);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/cruz.png" alt="Eliminar Cliente Preferente" title="Eliminar Cliente Preferente"  onclick="ExpedienteRevisado('+j+')"   id="oFase'+j+'">';

  			// VER EXPEDIENTE Y PODER CORREJIR LOS IMPORTES PRESUPUESTADOS POR EL CALCULO AUTOMÁTICO
  			cellText =  row.insertCell(6);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/ver.png" onclick="VerExpe('+j+')"  id="oFase'+j+'">';

  			// ENVIAR CORREO
  			//cellText =  row.insertCell(7);
  			//textNode = document.createTextNode(tbl.rows.length - 1);
  			//cellText.appendChild(textNode);
  			//cellText.innerHTML='<img src="redmoon_img/mail.png" onclick="sendMail('+j+')" onmouseover="AyudaMail(event)" onmouseout="SalirAyudaMail()" id="oFase'+j+'">';
  						
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
// pulsación de las teclas, cuando se pulsa return se graba el valor
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

function AniadirColaborador(){
	location="AniadirClientePreferente.php";
}

//-->Detectar Navegador
var isIE = document.all?true:false;


///Menus de ayuda para los botones de las tabla
//
//ayuda para llamar al colaborador

function AyudaTlf(event){


	
	var x = event.clientX+document.body.scrollLeft;
	var y = event.clientY+document.body.scrollTop;
	AreaDiv = document.getElementById("AyudaTlf");
	
	AreaDiv.style.top=y-370;
	AreaDiv.style.left=x-370;
	AreaDiv.style.visibility='visible';
}
function SalirAyudaTlf(){
	AreaDiv = document.getElementById("AyudaTlf");
	AreaDiv.style.visibility='hidden';
}

function AyudaVer(event){

	
	var x = event.clientX+document.body.scrollLeft;
	var y = event.clientY+document.body.scrollTop;
	AreaDiv = document.getElementById("ayudaVer");
	
	AreaDiv.style.top=y-370;
	AreaDiv.style.left=x-370;
	AreaDiv.style.visibility='visible';
}
function SalirAyudaVer(){
	AreaDiv = document.getElementById("ayudaVer");
	AreaDiv.style.visibility='hidden';
}
function AyudaMail(event){
	
	if (isIE) {
		var x = event.clientX+document.body.scrollLeft;
		var y = event.clientY+document.body.scrollTop;
		AreaDiv = document.getElementById("ayudaMail");
		AreaDiv.style.visibility='visible';
		AreaDiv.style.top=y-370;
		AreaDiv.style.left=x-370;
		}
	else{
		var x2 = event.pageX;
		var y2 = event.pageY;
		AreaDiv = document.getElementById("ayudaMail");
		AreaDiv.style.visibility='visible';
		AreaDiv.style.top=y2-370;
		AreaDiv.style.left=x2-370;

	}
}
function SalirAyudaMail(){
	AreaDiv = document.getElementById("ayudaMail");
	AreaDiv.style.visibility='hidden';
}
function detectar_raton(event,x,y){
	if (isIE) {
	var x = event.clientX+document.body.scrollLeft;
	var y = event.clientY+document.body.scrollTop;
	AreaDiv = document.getElementById("ayudaMail");
	AreaDiv.style.visibility='visible';
	AreaDiv.style.top=y-370;
	AreaDiv.style.left=x-370;
	}
	else{
		var x = event.pageX;
		var y = event.pageY;
		AreaDiv = document.getElementById("ayudaMail");
		AreaDiv.style.visibility='visible';
		AreaDiv.style.top=y-370;
		AreaDiv.style.left=x-370;

	}
	
}






</script>


<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />

<style type="text/css">
#ayudaVer{
position:absolute;
	top:1px;
	left:470px;
	visibility:hidden;
	z-index:1;
}
#AyudaTlf{

	position:absolute;
	top:1px;
	left:415px;
	visibility:hidden;
	z-index:1;
}
#ayudaMail{
position:absolute;
	top:1px;
	left:460px;
	visibility:hidden;
	z-index:1;
}
#TextoAyuda{
	position:absolute;
	top:35px;
	left:20px;
	margin-right:20px;

}


#pagina_adelante{
position: absolute;
top:140px;
left:40px;
cursor:pointer;


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
            Clientes Preferentes
</div>
<div id="AniadirColabora">
<img src="redmoon_img/imgDoc/AadirClientePreferente.png" align="middle" onclick="AniadirColaborador()"/>
</div>

<div id="btnPagina">
<div id="btnNavegaAtras" onclick="GotoBack()" title="Atrás"><span>Atrás</span></div>
<div id="btnNavegaSig" onclick="GotoNext()" title="Atrás"><span>Siguiente</span></div>
</div>

<div id="buscar">
    <form name="form1" method="post" action="">
	<span class="Estilo5">Nombre</span>
    <input style="text-transform:uppercase;" name="NOMBRE" type="text" id="NOMBRE" onkeypress="detectar_tecla(event,'NOMBRE')" size="25" maxlength="25" />
    <img src="Redmoon_img/imgDoc/buscar.png" align="right" alt="buscar"  longdesc="buscar datos"  onclick="LeeConsulta('TODO')" />
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

<div id="VentanaTabla">
<table width="750" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
    <td width="10%"><strong>ID</strong></td>
    <td width="10%"><strong>NIF</strong></td>
    <td width="35%"><strong>Nombre</strong></td>
     <td width="35%"><strong>Domicilio</strong></td>
    <td width="10%" align="center" ><strong>CC</strong></td>
  </tr>
</table>
<input type="hidden" name="xIDExpe" id="inIDExpe" />
<input type="hidden" name="xPag" id="xPag" value="1" />
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
</body>
</html>