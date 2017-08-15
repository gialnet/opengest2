<?php require('Redmoon_php/controlSesiones.inc.php');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Autorizar Pagos Colaboradores</title>

<link href="Redmoon_ccs/cargando.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cargando.js" type="text/javascript"></script>
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
function PeticionAceptada(xFila){
	
	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var url_parametros="xIDSegui="+oCelda.innerHTML;
	
	 PutDataAsuntos('Redmoon_php/ORA_PeticionAceptada.php', url_parametros);
}

//
// Cambiar de fase el expediente
//
function PeticionDenegada(xFila){

	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var url_parametros="xIDSegui="+oCelda.innerHTML;

	   PutDataAsuntos('Redmoon_php/ORA_PeticionDenegada.php', url_parametros);
	   
	
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

	VerGifEspera();
	
	//alert(url_parametros);
	PutDataAsuntos('Redmoon_php/serializado_AutorizarPagoColaboradores.php', url_parametros);
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
			
			//alert(pageRequest.responseText);
			//if (pageRequest.responseText=='Ok')
			//	return;
			
			if (pageRequest.responseText=='Error')
			    alert(pageRequest.responseText);
			else
			{
				//alert(pageRequest.responseText);
			    StringSerializado=pageRequest.responseText;
			    if (url!='Redmoon_php/serializado_AutorizarPagoColaboradores.php')
			    {
			    	LeeConsulta('Todo');
			    }
			    else{
			    deleteLastRow('oTabla');
			    AddRowTable();
			    }
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
  			cellText.innerHTML=ArrayColumnas[0+x];
  			
  			cellText =  row.insertCell(1);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML=ArrayColumnas[1+x];
  			
  			cellText =  row.insertCell(2);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML=ArrayColumnas[2+x];
  			
  			cellText =  row.insertCell(3);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('align', 'center');
  			cellText.innerHTML=ArrayColumnas[3+x];

  			cellText =  row.insertCell(4);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('align', 'center');
  			cellText.innerHTML=ArrayColumnas[4+x];

  			
  			// DAR EL VISTO BUENO
  			cellText =  row.insertCell(5);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/cruz.png"  onclick="PeticionDenegada('+j+')" id="oFase'+j+'">';  			

  			// VER EXPEDIENTE Y PODER CORREJIR LOS IMPORTES PRESUPUESTADOS POR EL CALCULO AUTOMTICO
  			cellText =  row.insertCell(6);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/ok.png" onclick="PeticionAceptada('+j+')" id="oFase'+j+'">';

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
// pulsacin de las teclas, cuando se pulsa return se graba el valor
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
</script>




<style type="text/css">
#imagen_logo{
position: absolute;
top:25px;
left:790px;
}

#pagina_adelante{
	position: absolute;
	top:100px;
	left:60px;
	cursor:pointer;
}
#pagina_boton{
position: absolute;
top:640px;
left:60px;
cursor:pointer;
}

.Estilo1 {color: #3c4963}
.Estilo5 {color: #36679f; font-weight: bold; }
</style>
</head>

<body  onload="HacerBusqueda();">
	<?php require('cabecera.php'); ?>

<div id="documento">
	 <div id="rastro"><a href="MenuLGS.php">Inicio</a> >
      Autorizar Pagos a Colaboradores

    </div>
<div id="ayuda_btn">
   <!-- <img src="Redmoon_img/imgDoc/ayuda.png" alt="Ayuda" title="Ayuda" onclick="AbrirAyuda('Gestoria_documentacion/pago_colaboradores_pendientes.html')" />-->
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
    <td width="10%"><strong>NE</strong></td>
    <td width="25%"><strong>Colaborador</strong></td>
    <td width="35%"><strong>Descripci&oacute;n</strong></td>
    <td width="10%"><strong>Importe</strong></td>
   
  </tr>
</table>
<input type="hidden" name="xIDExpe" id="inIDExpe" />
<input type="hidden" name="xPag" id="xPag" value="1" />
</div>
<?php require('Redmoon_php/cargando.inc'); ?>
</div>

</body>
</html>