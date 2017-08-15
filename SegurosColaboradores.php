<?php require('Redmoon_php/controlSesiones.inc.php');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Seguros Colaboradores</title>

<link href="Redmoon_ccs/cargando.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cargando.js" type="text/javascript"></script>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

<script> 

var StringSerializado="";
var xPag=1;

function HacerBusqueda()
{
	<?php 
			$pasa=0;
	
			if(isset($_GET["xNombre"]))
			{
				$xNombre=$_GET["xNombre"];
				echo 'xNombre="'.$xNombre.'"'.";\n";
				echo 'document.getElementById("Nombre").value="'.$xNombre.'"'.";\n";
				echo "LeeConsulta('Nombre');"."\n";
				$pasa=1;
			}
			
			if(isset($_GET["xProvincia"]))
			{
				$xProvincia=$_GET["xProvincia"];
				echo 'xProv="'.$xProvincia.'"\n';
				echo 'document.getElementById("Provincia").value="'.$xProvincia.'"'.";\n";
				echo "LeeConsulta('Provincia');"."\n";
				$pasa=1;
			}
			
		
			if($pasa==0)
				echo "LeeConsulta('Todo');"."\n";
			?>
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
	alert("Sistema de telefonia desconectado");
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
	   
	if(Opcion=='Nombre')
	{
	   var xNombre=document.getElementById('Nombre').value;
	   var url_parametros='xNombre='+xNombre.toUpperCase();
	   url_parametros+='&xPag='+xPag;
	   xFormaBuscar='Nombre';
	}

	if(Opcion=='Provincia')
	{
	   var xExpe=document.getElementById('Provincia').value;
	   var url_parametros='xProv='+xExpe.toUpperCase();
	   url_parametros+='&xPag='+xPag;
	   xFormaBuscar='Provincia';
	}
	

//alert(url_parametros);
	VerGifEspera();
	
	//alert(url_parametros);
	PutDataAsuntos('Redmoon_php/serializado_SegurosColaboradores.php', url_parametros);
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
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.setAttribute('align', 'center');
  			cellText.innerHTML=ArrayColumnas[3+x];

  			cellText =  row.insertCell(4);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.setAttribute('align', 'center');
  			cellText.innerHTML=ArrayColumnas[4+x];

  			
  			// DAR EL VISTO BUENO
  			cellText =  row.insertCell(5);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/telefono.png"  onclick="ExpedienteRevisado('+j+')" id="oFase'+j+'">';

  			// VER EXPEDIENTE Y PODER CORREJIR LOS IMPORTES PRESUPUESTADOS POR EL CALCULO AUTOM�TICO
  			cellText =  row.insertCell(6);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/ver.png" onclick="VerExpe('+j+')" id="oFase'+j+'">';

  			// ENVIAR CORREO
  			cellText =  row.insertCell(7);
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


function apagaPaneles(){

	document.getElementById('BuscaNombre').style.visibility='hidden';
	document.getElementById('BuscaExpe').style.visibility='hidden';

	}

function lbusca(opcion){
	
	//alert(opcion);

	apagaPaneles();
	

	
	if (opcion=='lbnombre')
	{
		document.getElementById('BuscaNombre').style.visibility='visible';
		document.getElementById('Nombre').focus();
	}
	
	if (opcion=='lbexpediente')
	{
		document.getElementById('BuscaExpe').style.visibility='visible';
		document.getElementById('Expediente').focus();
	}
	
		
}
</script>


<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />

<style type="text/css">


.Estilo5 {color: #36679f; font-weight: bold; }
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
	top:60px;
 	left:20px;
 }
</style>
</head>

<body  onload="HacerBusqueda();">
<?php require('cabecera.php'); ?>

<div id="documento">
      <div id="rastro"><a href="MenuLGS.php">Inicio</a> >
      Seguros de los Colaboradores

    </div>
    <div id="ayuda_btn">
		<!--<img src="Redmoon_img/imgDoc/ayuda.png" alt="Ayuda" title="Ayuda" onclick="AbrirAyuda('Gestoria_documentacion/seguro_colaboradores.html')" />-->
	</div>
<div id="busqueda">
  <span class="Estilo1">Buscar Colaboradores por:</span> 
<label class="Estilo2" id="lbnombre" onclick="lbusca(this.id)">Nombre</label>
<label class="Estilo2" id="lbexpediente" onclick="lbusca(this.id)">Provincia</label>

</div>
<p>&nbsp;</p>

<div class="example-twitter" id="BuscaNombre">
<form name="form2" method="post" action="#">
<p class="Estilo1">Nombre
<input name="Nombre" style="text-transform:uppercase;" type="text" id="Nombre" size="40" maxlength="40" onkeypress="detectar_tecla(event,'Nombre')" />
<img src="Redmoon_img/imgDoc/buscar.png" alt="Buscar" align="right" title="Buscar"  onclick="LeeConsulta('Nombre');" />
</p>
</form>
</div>
<div class="example-twitter" id="BuscaExpe">
<form name="form3" method="post" action="">
<p class="Estilo1">Provincia
<input name="Provincia" type="text" id="Provincia" size="25" maxlength="25" onkeypress="detectar_tecla(event,'Provincia')" />
<img src="Redmoon_img/imgDoc/buscar.png" alt="Buscar" align="right" title="Buscar"  onclick="LeeConsulta('Provincia')" />
</p>
</form>
</div>





<div id="btnPaginaB">
<div id="btnNavegaAtras" onclick="GotoBack()" title="Atr�s"><span>Atr�s</span></div>
<div id="btnNavegaSig" onclick="GotoNext()" title="Atr�s"><span>Siguiente</span></div>
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
<div id="VentanaTablaB">
<table width="780" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
    <td width="10%">ID</td>
    <td width="15%">NIF</td>
    <td width="50%">Nombre</td>
     <td width="10%">Provincia</td>
    <td width="15%" align="center" >Fecha</td>
  </tr>
</table>
<input type="hidden" name="xIDExpe" id="inIDExpe" />
<input type="hidden" name="xPag" id="xPag" value="1" />
</div>


<?php require('Redmoon_php/cargando.inc'); ?>
</div>
</body>
</html>