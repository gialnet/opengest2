<?php require('Redmoon_php/controlSesiones.inc.php');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ingresos de Hoy</title>

<link href="Redmoon_ccs/cargando.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cargando.js" type="text/javascript"></script>
<script src="Redmoon_js/pagina.js" type="text/javascript"></script>
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
// Cojer el valor de la fila
//
function GetFila(xID)
{
	var oCelda=document.getElementById(xID).cells[0];
	var url_parametros="xIDSegui="+oCelda.innerHTML;

	if (confirm('Confirma BORRAR el Ingreso?'))
	{
		VerGifEspera();
	   PutDataAsuntos('Redmoon_php/ORADelIngresosHoy.php', url_parametros);
	   LeeConsulta('Todo');
	}
	   
	//alert(oCelda.innerHTML);
	

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
	if(Opcion=='POBLACION')
	{
		var xPOBLA=document.getElementById('POBLACION').value
	   	url_parametros=url_parametros+'?xPOBLACION='+xPOBLA.toUpperCase();
	}   
	if(Opcion=='Nombre')
	{
	   var xNombre=document.getElementById('Nombre').value;
	   var url_parametros=url_parametros+'?xNombre='+xNombre.toUpperCase();
	}

	VerGifEspera();
	//alert(url_parametros);
	PutDataAsuntos('Redmoon_php/serializado_IngresosHoy.php', url_parametros);
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
			OcultarGifEspera();		
			if(url=='Redmoon_php/ORADelIngresosHoy.php')
				LeeConsulta('Todo');
			
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
  			cellText.setAttribute('align', 'right');
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
// pulsacin de las teclas
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
LeeConsulta(opcion);
//alert(tecla);
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

function CrearPDF(){
	//var xID=<?php echo  $_GET["xIDExpe"]; ?>;
	//alert(xID);
	location='pdf_ingresoshoy.php';
}
</script>


<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />

<style type="text/css">

#imagen_logo{
position: absolute;
top:5px;
left:790px;
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
</style>
</head>

<body  onload="HacerBusqueda();">
<?php require('cabecera.php'); ?>

<div id="documento">
     <div id="rastro"><a href="MenuLGS.php">Inicio</a>
        > Ingresos de Hoy
    </div>
    <div id="ayuda_btn">
		<!--<img src="Redmoon_img/imgDoc/ayuda.png" alt="Ayuda" title="Ayuda" onclick="AbrirAyuda('Gestoria_documentacion/ingresos_hoy.html')" />-->
	</div>
<div id="pdf"  onclick="CrearPDF()"><img alt="Exportar a PDF" title="Exportar a PDF" src="redmoon_img/imgDoc/PDF.png" /><span class="Estilo1"> </span></div>



<div id="btnPagina">
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
<div id="VentanaTabla">
<table width="750" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
    <td width="10%"><strong>ID</strong></td>
    <td width="10%"><strong>Expediente</strong></td>
    <td width="50%"><strong>Descripci&oacute;n</strong></td>
    <td width="10%"><strong>Fecha</strong></td>
    <td width="20%" align="center"><strong>Importe</strong></td>
  </tr>
</table>
</div>
<?php require('Redmoon_php/cargando.inc'); ?>
</div>

</body>
</html>
