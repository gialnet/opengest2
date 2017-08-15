<?php require('Redmoon_php/controlSesiones.inc.php');  ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Expedientes Colaborador</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

<script type="text/javascript"> 

var StringSerializado="";
var Gurl_parametros="";
var xPag=1;

function HacerBusqueda()
{
	
	LeeConsulta('Todo');
}

//
// Sin implementar
//
function ExpedienteRevisado()
{
	return;
}
//
// sin implementar
//
function sendMail()
{
	return;
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
function LeeConsulta()
{
	
	var url_valor = <?php
	if(isset($_SESSION["idRol"])) 
		echo $_SESSION['idRol'];
	else 
		echo "''"; 
	?>;
	var url_parametros = "xColabora="+url_valor;
	
	url_parametros+='&xPag='+xPag;

	VerGifEspera();
	//alert(url_parametros);
	// si hay valor de parametro mide mas de diez caracteres
	if (url_parametros.length>10)
		PutDataAsuntos('Redmoon_php/serializado_ColaboradorExpediente.php',url_parametros);
	else
		PutDataAsuntos('Redmoon_php/serializado_ColaboradorExpediente.php');
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
			OcultarGifEspera();
			//alert(pageRequest.responseText);
			
			if (pageRequest.responseText=='Error')
			    alert(pageRequest.responseText);
			else
			{
			    StringSerializado=pageRequest.responseText;
			    if (url=='Redmoon_php/serializado_ColaboradorExpediente.php')
			    {
			    	deleteLastRow('oTabla');
			    	AddRowTable();
			    }
			    else
			    {
				    if (pageRequest.responseText=='Ok')
				    	QuitGasto();
				    else
				    	QuitGasto();
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

  			// DAR EL VISTO BUENO
  			cellText =  row.insertCell(4);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/ok.png" alt="Expediente Enviado" title="Expediente Enviado"  onclick="ExpedienteEnviado('+j+')" id="oFase'+j+'">';

  			// Aadir Autorizacin de Cargo Adicional
  			cellText =  row.insertCell(5);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/mas.png" alt="A&ntilde;adir Coste Adicional" title="A&ntilde;adir Coste Adicional" onclick="PutGasto('+j+')" id="oFase'+j+'">';

  			// ENVIAR CORREO
  			cellText =  row.insertCell(6);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/mail.png" alt="Enviar un eMail a la Gestor&iacute;a" title="Enviar un eMail a la Gestor&iacute;a" onclick="sendMail('+j+')" id="oFase'+j+'">';
  			
  						
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

//El colaborador marca cuando ha enviado el
//expediente a lgs
function ExpedienteEnviado(xID)
{
	var idFila="ofila"+xID;
	var oCelda=document.getElementById(idFila).cells[0];
	var url_parametros="xIDExpe="+oCelda.innerHTML;
	
	VerGifEspera();
	
	alert("Expediente Enviado");
	
	PutDataAsuntos('Redmoon_php/ORAColaboraEnviaExpe.php', url_parametros);

}


function PutGasto(xID)
{
	var idFila="ofila"+xID;
	var oCelda=document.getElementById(idFila).cells[0];

	// variable de ambito global
	Gurl_parametros="xIDExpe="+oCelda.innerHTML;
	
	AreaDiv = document.getElementById("ServicioAdd");
	AreaDiv.style.visibility='visible';
	AreaDiv.style.top='150px';

}

function QuitGasto()
{
	AreaDiv = document.getElementById("ServicioAdd");
	AreaDiv.style.visibility='hidden';

}

//
// Pedir Autorizacin de un gasto adicional por parte del colaborador
//
function AddCargo()
{
	var comentario = document.getElementById("Servicio").value;
	var importe = 	document.getElementById("ImporteServicio").value;

	var url_parametros=Gurl_parametros+'&xComent='+comentario+'&xImporte='+importe;

	url_parametros+='&xColabora=<?php echo $_SESSION['idRol']; ?>';

	//alert(url_parametros);
	
	VerGifEspera();
	
	PutDataAsuntos('Redmoon_php/ORAColaboraPideAutoCargo.php', url_parametros);
}

</script>


<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />
<link href="Redmoon_ccs/cargando.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cargando.js" type="text/javascript"></script>
<script src="Redmoon_js/pagina.js" type="text/javascript"></script>
<style type="text/css">
#imagen_logo{
position: absolute;
top:7px;
left:790px;
}


#ServicioAdd
{
	position:absolute;
	top:937px;
	left:144px;
	height: 240px;
	width: 588px;
	border:solid 8px;
	border-color:#ebebeb;
	
	margin:15px 15px;
	padding:20px 40px;
	background-color: #FFFFCC;
	visibility:hidden;
}

 .Estilo1 {color: #3c4963}
 .Estilo5 {color: #36679f; font-weight: bold; }
</style>
</head>

<body  onload="HacerBusqueda();">
<?php require('cabecera.php'); ?>
<div id="documento">
    <div id="rastro"><a href="MenuColaboraGestores.php">Inicio</a>
        > Expedientes Realizados
    </div>

<div id="btnPagina">
<div id="btnNavegaAtras" onclick="GotoBack()" title="Atr·s"><span>Atr·s</span></div>
<div id="btnNavegaSig" onclick="GotoNext()" title="Atr·s"><span>Siguiente</span></div>
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

</div>

<div id="ServicioAdd">
  <p><img src="Redmoon_img/borrar1.png" alt="salir"  align="texttop" longdesc="salir" onclick="QuitGasto()" />
  <div align="center" id="Titulo" class="Estilo1">Servicio adicional, no incluido en el presupuesto inicial</div>
    </p>
    <p class="Estilo5">
    <label style="position: absolute; left:100px;">
      Descripci√≥n
        <input name="Servicio" type="text" id="Servicio" size="50" maxlength="50" /></label>
        <br />
         <br />
        <label style="position: absolute; left:100px;">
      Importe
      <input name="ImporteServicio" type="text" id="ImporteServicio" size="10" maxlength="10" style="position: absolute; left:80px;"/></label>
       <br />
       <br />
  <label style="position: absolute; left:46%;">
      <img src="Redmoon_img/aceptar2.png" alt="aceptar"  longdesc="aceptar" onclick="AddCargo()" /></label>
    </p>
    <?php require('Redmoon_php/cargando.inc'); ?>
</div>

</body>
</html>