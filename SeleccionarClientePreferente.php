<?php require('Redmoon_php/controlSesiones.inc.php');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Buscar Clientes</title>

<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cargando.js" type="text/javascript"></script>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

<script> 

var StringSerializado="";
var xPag=1;
var xFormaBuscar='';

function GotoNext(){
	xPag+=9;
	LeeConsulta(xFormaBuscar);
}

function GotoBack()
{
	xPag-=9;
	if (xPag <=1 )
		xPag=1;
	
	LeeConsulta(xFormaBuscar);
}
function HacerBusqueda()
{
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
//
function GetFila(xID)
{
	var oCelda=document.getElementById(xID).cells[0];
	//var fila=document.getElementById(xID).rowIndex;

	//location="ORA_AniadirClientePreferente.php?xID="+oCelda.innerHTML;
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
	
	
	if(Opcion=='NIF')
	{
		var xNIF=document.getElementById('NIF').value;
	   var url_parametros='xNIF='+xNIF.toUpperCase();
	   url_parametros+='&xPag='+xPag;
	   xFormaBuscar='NIF';
	}
	   
	if(Opcion=='Nombre')
	{
	   var xNombre=document.getElementById('Nombre').value;
	   var url_parametros='xNombre='+xNombre.toUpperCase();
	   url_parametros+='&xPag='+xPag;
	   xFormaBuscar='Nombre';
	}

	if(Opcion=='Expediente')
	{
	   var xExpe=document.getElementById('Expediente').value;
	   var url_parametros='xExpe='+xExpe;
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

	VerGifEspera();
	//alert(url_parametros);
	PutDataAsuntos('Redmoon_php/serializado_Clientes.php', url_parametros);
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
		
	LeeConsulta(opcion);
}
//alert(tecla);
}

function apagaPaneles(){
document.getElementById('BuscaNIF').style.visibility='hidden';
document.getElementById('BuscaNombre').style.visibility='hidden';
document.getElementById('BuscaExpe').style.visibility='hidden';
document.getElementById('BuscaFecha').style.visibility='hidden';
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
</script>

<style type="text/css">
#imagen_logo{
position: absolute;
top:5px;
left:790px;
}

#VentanaTabla{ 
position:absolute;
	top:220px;
	left:50px;
	width:882px;
	height:600px;
	overflow:auto;
	cursor:pointer;
	border-color:#ECF3F5;
}
.etiqueta {
 border:solid 2px;
 border-color: #0099FF;
 background-color: #0099FF;
 color:#FFFFFF;
 margin: 4px 15px;
 cursor:pointer;
}

.VentanaBuscar{
	position:absolute;
	top:30px;
	left:34px;
	height: 100px;
	width: 640px;
	
	border:thin;
	
	padding:5px 25px;

	background-color: #FFFFCC;
	visibility:hidden;
}
#pagina_adelante{
position: absolute;
top:145px;
left:60px;
cursor:pointer;


}

#pagina_boton{
position: absolute;
top:680px;
left:44px;
cursor:pointer;

}
 #busqueda{
 position:absolute;
 left:20px;
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
<div id="busqueda">
  <span class="Estilo1">Buscar Clientes por:</span> 
   <label class="Estilo2" id="lbnif" onclick="lbusca(this.id)">NIF</label>
<label class="Estilo2" id="lbnombre" onclick="lbusca(this.id)">Nombre</label>

</div>
<p>&nbsp;</p>
<div class="VentanaBuscar" id="BuscaNIF">
<form name="form1" method="post" action="">
<p class="Estilo1">NIF
<input style="text-transform:uppercase;" name="NIF" type="text" id="NIF" onkeypress="detectar_tecla(event,'NIF')" size="14" maxlength="14" />
<img src="img/buscar48x48.png" alt="buscar" longdesc="buscar datos"  onclick="LeeConsulta('NIF');" />
<p>
</form>
</div>
<div class="VentanaBuscar" id="BuscaNombre">
<form name="form2" method="post" action="#">
<p class="Estilo1">Nombre
<input name="Nombre" style="text-transform:uppercase;" type="text" id="Nombre" size="40" maxlength="40" onkeypress="detectar_tecla(event,'Nombre')" />
<img src="img/buscar48x48.png" alt="buscar" longdesc="buscar datos"  onclick="LeeConsulta('Nombre');" />
</p>
</form>
</div>
<div class="VentanaBuscar" id="BuscaExpe">
<form name="form3" method="post" action="">
<p class="Estilo1">Número de Expediente
<input name="Expediente" type="text" id="Expediente" size="20" maxlength="20" onkeypress="detectar_tecla(event,'Expediente')" />
<img src="img/buscar48x48.png" alt="buscar" longdesc="buscar datos"  onclick="LeeConsulta('Expediente')" />
</p>
</form>
</div>

<div class="VentanaBuscar" id="BuscaFecha">
<form id="form4" name="form4" method="post" action="">
<p class="Estilo1">Fecha desde
<input name="FechaDe" type="text" id="FechaDe" size="10" maxlength="10" onkeypress="detectar_tecla(event)" />
hasta
<input name="FechaHa" type="text" id="FechaHa" size="10" maxlength="10" onkeypress="detectar_tecla(event,'Fecha')" />
<img src="img/buscar48x48.png" alt="buscar" longdesc="buscar datos"  onclick="LeeConsulta('Fecha')" />
</p>                
</form>
</div>

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
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<table id="list" class="scroll"></table> 
<div id="pager" class="scroll" style="text-align:center;"></div> 
<div id="VentanaTabla">
<table width="750" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
    <td width="10%"><strong>ID</strong></td>
    <td width="10%"><strong>NIF</strong></td>
    <td width="35%"><strong>Nombre</strong></td>
    <td width="35%"><strong>Domicilio</strong></td>
    <td width="10%"><strong>CC</strong></td>
    
  </tr>
</table>
</div>

<?php require('Redmoon_php/cargando.inc'); ?>
</div>
</body>
</html>
