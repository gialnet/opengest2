<?php require('Redmoon_php/controlSesiones.inc.php');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Expedientes Finalizados</title>
<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cargando.js" type="text/javascript"></script>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

<script> 

var StringSerializado="";
var xPag=1;
//variable para guardar la ultima consulta realizada
var xUltimo='';

function HacerBusqueda()
{
	//alert("busqueda");
	<?php 
			if(isset($_GET["xNIF"]))
			{
				$xNIF=$_GET["xNIF"];
				echo 'xNIF="'.$xNIF.'"'.";\n";
				echo 'document.getElementById("NIF").value="'.$xNIF.'"'.";\n";
				echo "LeeConsulta('NIF');"."\n";

			}
			
			if(isset($_GET["xNombre"]))
			{
				$xNombre=$_GET["xNombre"];
				echo 'xNombre="'.$xNombre.'"'.";\n";
				echo 'document.getElementById("Nombre").value="'.$xNombre.'"'.";\n";
				echo "LeeConsulta('Nombre');"."\n";
			}
			
			if(isset($_GET["xIDExpe"]))
			{
				$xIDExpe=$_GET["xIDExpe"];
				echo 'xIDExpe="'.xIDExpe.'"\n';
			}
			
			if(isset($_GET["xFecha"]))
			{
				$xFecha=$_GET["xFecha"];
				echo 'xFecha="'.xFecha.'"\n';
			}
			else{ 
				echo "LeeConsulta('Todo');"."\n";
			}
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
// Cojer el valor de la fila
///----------------------------------------->>Cambiar seg�n en que fase est� se ir� a una pantalla
function GetFila(xID)
{
	var oCelda=document.getElementById(xID).cells[0];
	var url_parametros="?xIDExpe="+oCelda.innerHTML;
	
	location="SeguiExpeFacturacion.php"+url_parametros;

	

}


function LeeConsulta(Opcion)
{
	var url_parametros='xPag='+xPag;
	if(Opcion=='NIF')
	{
		var xNIF=document.getElementById('NIF').value;
	   var url_parametros='xNIF='+xNIF.toUpperCase();
	   xUltimo=url_parametros;
	   url_parametros+='&xPag='+xPag;
	   xFormaBuscar='NIF';
	}
	   
	if(Opcion=='Nombre')
	{
	   var xNombre=document.getElementById('Nombre').value;
	   var url_parametros='xNombre='+xNombre.toUpperCase();
	   xUltimo=url_parametros;
	   url_parametros+='&xPag='+xPag;
	   xFormaBuscar='Nombre';
	}

	if(Opcion=='Expediente')
	{
	   var xExpe=document.getElementById('Expediente').value;
	   var url_parametros='xExpe='+xExpe;
	   xUltimo=url_parametros;
	   url_parametros+='&xPag='+xPag;
	   xFormaBuscar='Expediente';
	}
	
	if(Opcion=='Fecha')
	{
	   var xFecha1=document.getElementById('FechaDe').value;
	   var xFecha2=document.getElementById('FechaHa').value;
	   var url_parametros='xFecha1='+xFecha1+'&xFecha2='+xFecha2;
	   url_parametros+='&xPag='+xPag;
	   xFormaBuscar='Fecha';
	}

	//VerGifEspera();
	
	//alert(url_parametros);
	PutDataAsuntos('Redmoon_php/serializado_FacturacionClientes.php',url_parametros);
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
			//OcultarGifEspera();		
			//alert('pasa');
			//alert(pageRequest.responseText);
			if (pageRequest.responseText=='Error')
			    alert(pageRequest.responseText);
			else
			{
			    StringSerializado=pageRequest.responseText;
			    //alert(StringSerializado);
			    
			    if (StringSerializado!='NoDataFound')
			    {
			    	deleteLastRow('oTabla');
				    AddRowTable();				   
			    }
			    else
			    {
			    	alert('No hay datos para esta consulta');
			    }
			    
		    }
		    	
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
	for(x=0; x<=ArrayColumnas.length-2; x+=3)
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

function lbusca(opcion){
	
	//alert(opcion);

	apagaPaneles();
	
	if (opcion=='lbnif')
	{
		document.getElementById('BuscaNIF').style.visibility='visible';
		document.getElementById('NIF').focus();
	}
	
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
	
	if (opcion=='lbfecha')
	{
		document.getElementById('BuscaFecha').style.visibility='visible';
		document.getElementById('FechaDe').focus();
	}			
}

function apagaPaneles(){
	document.getElementById('BuscaNIF').style.visibility='hidden';
	document.getElementById('BuscaNombre').style.visibility='hidden';
	document.getElementById('BuscaExpe').style.visibility='hidden';
	document.getElementById('BuscaFecha').style.visibility='hidden';
	}


function CrearPDF(){
	
			
			location='pdf_expedientesFinalizados.php?'+xUltimo;
}

</script>


<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />

<style type="text/css">

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


 #busqueda{
 	position:absolute;
	top:50px;
 	left:20px;
 }
.Estil
</style>
</head>

<body  onload="LeeConsulta();">
<?php require('cabecera.php'); ?>

<div id="documento">
    <div id="rastro"><a href="MenuLGS.php">Inicio</a> >
      Expedientes Pendientes de Facturar a Clientes

    </div>
<div id="ayuda_btn">
		<!--<img src="Redmoon_img/imgDoc/ayuda.png" alt="Ayuda" title="Ayuda" onclick="AbrirAyuda('Gestoria_documentacion/expedientes_pendientes_facturacion_clientes.html')" />-->
	</div>
<div id="pdf"  onclick="CrearPDF()"><img alt="Exportar a PDF" title="Exportar a PDF" src="redmoon_img/imgDoc/PDF.png" /><span class="Estilo1"> </span></div>


<div id="busqueda">
  <span class="Estilo1">Buscar Expedientes por:</span> 
   <label class="Estilo2" id="lbnif" onclick="lbusca(this.id)">NIF</label>
<label class="Estilo2" id="lbnombre" onclick="lbusca(this.id)">Nombre</label>
<label class="Estilo2" id="lbexpediente" onclick="lbusca(this.id)">Número de Expediente</label>

</div>
<p>&nbsp;</p>
<div class="example-twitter" id="BuscaNIF">
<form name="form1" method="post" action="">
<p class="Estilo1">NIF
<input style="text-transform:uppercase;" name="NIF" type="text" id="NIF" onkeypress="detectar_tecla(event,'NIF')" size="14" maxlength="14" />
<img src="Redmoon_img/imgDoc/buscar.png" alt="Buscar" align="right" title="Buscar"  onclick="LeeConsulta('NIF');" />
</p>
</form>
</div>
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
<p class="Estilo1">Número de Expediente
<input name="Expediente" type="text" id="Expediente" size="20" maxlength="20" onkeypress="detectar_tecla(event,'Expediente')" />
<img src="Redmoon_img/imgDoc/buscar.png" alt="Buscar" align="right" title="Buscar"  onclick="LeeConsulta('Expediente')" />
</p>
</form>
</div>


<div class="example-twitter" id="BuscaFecha">
<form id="form4" name="form4" method="post" action="">
<p class="Estilo1">Fecha desde
<input name="FechaDe" type="text" id="FechaDe" size="10" maxlength="10" onkeypress="detectar_tecla(event)" />
hasta
<input name="FechaHa" type="text" id="FechaHa" size="10" maxlength="10" onkeypress="detectar_tecla(event,'Fecha')" />
<img src="Redmoon_img/imgDoc/buscar.png" alt="Buscar" align="right" title="Buscar"  onclick="LeeConsulta('Fecha')" />
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
<div id="VentanaTablaB">
<table width="750" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
    <td width="10%"><strong>Expediente</strong></td>
    <td width="13%"><strong>NIF</strong></td>
    <td width="50%"><strong>Nombre</strong></td>
  </tr>
</table>
</div>
<?php require('Redmoon_php/cargando.inc'); ?>
</div>
</body>
</html>
