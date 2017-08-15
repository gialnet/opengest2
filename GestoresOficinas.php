<?php require('Redmoon_php/controlSesiones.inc.php');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Oficinas:Ver Gestores</title>
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

function chgProvision(xFila,xIDObjeto)
{
	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var oValor;
	var campo;
	document.getElementById("xGestor").value=oCelda.innerHTML;
	
	//alert(document.getElementById("xGestor").value);
	if (xIDObjeto.substring(0,5)=='oChgP')
	{
		//alert('pasa pos');
	oValor=document.getElementById(idFila).cells[5];
	campo='<input name="posicion" type="text" id="posicion" size="10" maxlength="10" onkeypress="detectar_tecla(event, this.id)" />';
	oValor.innerHTML=campo;
	//alert(oValor.innerHTML);
	document.getElementById('posicion').focus();
	}

//alert('fin');
	
	
	
}


function BorrarGestor(xFila){
	//alert("borrar");
	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];

	var url_parametros="xID="+oCelda.innerHTML+"&xOficina="+document.getElementById("inOficina").value;
	//alert(url_parametros);
 	//PutDataAsuntos('ORADelGestorOficina.php', url_parametros);
	location="Redmoon_php/ORADelGestorOficina.php?"+url_parametros;
}
//
// llamar a quien graba el importe de otras provisiones cuando se pulsa return
//
function CallChgProvision(xIDObjeto)
{

	var xPos=document.getElementById(xIDObjeto).value;
	var url_parametros="xGestor="+document.getElementById("xGestor").value+
	"&xPos="+xPos;
	
	//alert(url_parametros);
   	PutDataAsuntos('Redmoon_php/ORAPosicionGestor.php', url_parametros);
   //location='Redmoon_php/ORAPosicionGestor.php'+url_parametros;
   
}

//
//pulsación de las teclas
//
function detectar_tecla(e, opcion){
	//alert('detectar_tecla');
	if (window.event)
		tecla=e.keyCode;
	else
		tecla=e.which;

	//escape
	if(tecla==27){
		
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
		// refrescar la pantalla
		//LeeConsulta();
		
	}

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

		// Grabar el importe introducido al pulsar return
		//alert('pasa leer tecla');
		CallChgProvision(opcion);
		
			
	}
	
	//alert(tecla);
	}


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
	//var oCelda=document.getElementById(idFila).cells[0];
	//var url_parametros="xOficina="+oCelda.innerHTML;
	
	//location="OficinasGestores.php?"+url_parametros;
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
	//var oCelda=document.getElementById(idFila).cells[0];
	var Oficina='<?php echo $_GET['xOficinas'];?>';
	//alert(Oficina);
	var url_parametros='xPag='+xPag+'&xOficina='+Oficina;
	
	//alert(url_parametros);
	PutDataAsuntos('Redmoon_php/serializado_OficinaVerGestores.php', url_parametros);
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
			//alert(pageRequest.status);
			// despues de grabar dejar las cosas como estaban		
			//DesctivaInterfazGrabando();		
			
			
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
			    if(url=='Redmoon_php/ORAPosicionGestor.php' ) {
					  LeeConsulta();
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
  	j=1;
	for(x=0; x<=ArrayColumnas.length-2; x+=6)
	    {
		
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

  			cellText =  row.insertCell(4);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.innerHTML=ArrayColumnas[4+x];
  			
  			cellText =  row.insertCell(5);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.setAttribute('align', 'right');
  			cellText.innerHTML=ArrayColumnas[5+x]+
			'<img src="Redmoon_img/lapiz.png" onclick="chgProvision('+j+',this.id)" id="oChgPosicion'+j+'">';


  			// Borrar un gestor de una oficina
  			cellText =  row.insertCell(6);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="Redmoon_img/borrar1.png" onclick="BorrarGestor('+j+')" id="oFase'+j+'">';
  			
  			j++;
  			


  			
  		
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
	//alert('detectar_tecla');
	if (window.event)
		tecla=e.keyCode;
	else
		tecla=e.which;

	//escape
	if(tecla==27){
		
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
		// refrescar la pantalla
		//LeeConsulta();
		
	}

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

		// Grabar el importe introducido al pulsar return
		CallChgProvision(opcion);
		
			
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

function AniadirOficina(){
	location="AniadirOficina.php"
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
top:120px;
left:30px;
cursor:pointer;


}

#pagina_boton{
position: absolute;
top:840px;
left:30px;
cursor:pointer;

}
#VentanaTabla{ 
	position:absolute;
	top:200px;
	left:20px;
	width:750px;
	height:650px;
	overflow:auto;
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
.Estilo5 {color: #36679f; font-weight: bold; }
 
</style>
</head>

<body  onload="HacerBusqueda();">
<?php require('cabecera.php'); ?>

<div id="documento">

<div id="btnPagina">
<div id="btnNavegaAtras" onclick="GotoBack()" title="Atrás"><span>Atrás</span></div>
<div id="btnNavegaSig" onclick="GotoNext()" title="Atrás"><span>Siguiente</span></div>
</div>


<br/>
<br/>

<h4 align="center" class="Estilo1">Gestores de la Oficina:<?php echo $_GET['xOficina'];?></h4>
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
    <td width="7%"><strong>ID</strong></td>
    <td width="7%"><strong>NIF</strong></td>
    <td width="30%"><strong>Nombre</strong></td>    
     <td width="30%"><strong></strong>Direcci&oacute;n</td>
    <td width="16%"><strong></strong>Poblaci&oacute;n</td>
     <td width="10%"><strong></strong>Posici&oacute;n</td>
 
    
  </tr>
</table>
 <input type="hidden" name="xGestor" id="xGestor" />
  <input type="hidden" name="inOficina" id="inOficina"  value="<?php echo $_GET['xOficinas'];?>" />
<input type="hidden" name="xIDExpe" id="inIDExpe" />
<input type="hidden" name="xPag" id="xPag" value="1" />
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>

</div>
</body>
</html>