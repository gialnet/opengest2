<?php require('Redmoon_php/controlSesiones.inc.php');  ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tareas Pendientes Colaborador</title>

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
///----------------------------------------->>Cambiar segn en que fase est se ir a una pantalla
function GetFila(xID)
{
	var oCelda=document.getElementById(xID).cells[0];
	var url_parametros="?xIDExpe="+oCelda.innerHTML;
	
	var oFASE=document.getElementById(xID).cells[3];
	var vFASE=oFASE.innerHTML;
	//alert(vFASE);
	
	if (vFASE=='INFORME COSTE NOTARIA')//40
	{
		document.location='IntroduccionCosteNotaria.php'+url_parametros; 
	}
	
	if(vFASE=='PAGO NOTARIA'){//42
		document.location='JustificanteNotaria.php'+url_parametros;
	}   

	if(vFASE=='INFORME COSTE IMPUESTOS'){//50
		document.location='IntroduccionCosteImpuesto.php'+url_parametros;
	} 

	if(vFASE=='PAGO IMPUESTOS'){//52
		document.location='JustificanteImpuesto.php'+url_parametros;
	}


	if(vFASE=='PRESENTACION ESCRITURAS'){// 60
		document.location='PresentacionRegistroEscritura.php'+url_parametros;
	}
	
	if(vFASE=='INFORME COSTE REGISTRO'){//61
		document.location='IntroduccionCosteRegistro.php'+url_parametros;
	}

	if(vFASE=='PAGO REGISTRO'){//63
		document.location='JustificanteRegistro.php'+url_parametros;
	}
	//alert(oCelda.innerHTML);
	

}


function LeeConsulta()
{
	var url_parametros='xPag='+xPag;
	var url_valor = <?php
	if(isset($_SESSION["idRol"])) 
		echo $_SESSION["idRol"];
	else 
		echo "''"; 
	?>;
	//alert(url_valor);
	url_parametros =url_parametros+ "&xColabora="+url_valor;

	VerGifEspera();
	//alert(url_parametros);

		PutDataAsuntos('Redmoon_php/serializado_TareasColaborador.php',url_parametros);
	
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
			OcultarGifEspera();		
			
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
	for(x=0; x<=ArrayColumnas.length-2; x+=4)
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
</script>


<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />

<style type="text/css">

#pagina_adelante{
position: absolute;
top:140px;
left:40px;
cursor:pointer;


}

#pagina_boton{
position: absolute;
top:780px;
left:40px;
cursor:pointer;

}
#imagen_logo{
position: absolute;
top:5px;
left:790px;
}


 
.Estilo1 {color: #3c4963}
</style>
</head>

<body  onload="HacerBusqueda();">
<?php require('cabecera.php'); ?>
<div id="documento">

<div id="rastro"><a href="MenuColaboraGestores.php">Inicio</a>
        > Tareas y Encargos
    </div>
<div id="btnPagina">
<div id="btnNavegaAtras" onclick="GotoBack()" title="Atr�s"><span>Atr�s</span></div>
<div id="btnNavegaSig" onclick="GotoNext()" title="Atr�s"><span>Siguiente</span></div>
</div>


<br/>
<br/>
<h4 align="center" class="Estilo1">Tareas Pendientes Colaborador</h4>
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
    <td width="10%"><strong>Expediente</strong></td>
    <td width="10%"><strong>NIF</strong></td>
    <td width="50%"><strong>Nombre</strong></td>
    <td width="30%"><strong>Fase</strong></td>
  </tr>
</table>
</div>
<?php require('Redmoon_php/cargando.inc'); ?>
</div>

</body>
</html>
